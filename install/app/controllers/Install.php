<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Install extends CI_Controller
{
	public $vars;

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->CI = &get_instance();

		$this->key = md5(date('dmYhis') . random_string(16));
		$this->encryption->initialize(array(
			'key' => hex2bin($this->key)
		));
	}

	public function index()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Mulai
			if ($_POST['act'] === 'mulai') {
				$this->_view('set_database');
			}

			// langkah 1 Pengaturan Database
			if ($_POST['act'] === 'langkah_1') {
				$dbconfig = $this->_dbconfig($_POST);
				$db_obj = $this->load->database($dbconfig, TRUE);

				if (!$db_obj->conn_id) {
					$this->_view('disconnect');
				} else {
					$this->load->database();
					
					if ($this->install_model->import_tables(FCPATH . "install/assets/sql/opensid.sql") == TRUE) {
						$this->db->close(); // close connection
						$this->_view('set_data_desa');
					} else {
						$this->_view('set_database');
					}
				}				
			}
			
			// Jika Koneksi ke database gagal
			if ($_POST['act'] === 'gagal') {
				$this->_view('set_database');
			}
			
			// Langkah 2 Pengaturan Data Desa
			if ($_POST['act'] === 'langkah_2') {
				$dbconfig = $this->_dbconfig($_POST);
				$db_obj = $this->load->database($dbconfig, TRUE);

				if (!$db_obj->conn_id) {
					$this->_view('disconnect');
				} else {
					$this->load->database();
					$this->db->reconnect();
				}

				$this->db->trans_off();
				$this->db->trans_begin();

				//Config desa
				$this->install_model->update_config(1, array(
					'nama_desa' 		=> $_POST['nama'],
					'nama_kepala_desa'  => $_POST['kepala'],
					'email_desa' 		=> $_POST['email'],
					'telepon' 			=> $_POST['telepon'],
					'website' 			=> $_POST['website']
				));

				// local
				$key = 'timezone';
				$this->install_model->update_setting($key, array(
					'value' 	=> $_POST['timezone']
				));

				$this->db->close(); // close connection
				$this->_view('set_user');
			}

			// Langkah 3 Pengaturan Pengguna
			if ($_POST['act'] === 'langkah_3') {
				$dbconfig = $this->_dbconfig($_POST);
				$db_obj = $this->load->database($dbconfig, TRUE);

				if (!$db_obj->conn_id) {
					$this->_view('disconnect');
				} else {
					$this->load->database();
					$this->db->reconnect();
				}

				$key = $this->key;
				$pwHash = $this->generatePasswordHash($_POST['pass']);

				$this->db->trans_off();
				$this->db->trans_begin();

				// Insert User
				$this->install_model->insert_user(array(
					'id'        => NULL,
					'username'  => $_POST['user'],
					'password'  => $pwHash,
					'id_grup'	=> 1,
					'email'     => '',
					'last_login' => date('Y-m-d'),
					'active'    => '1',
					'nama'      => 'Administrator',
					'company'	=> '',
					'phone'		=> '',
					'foto'		=> 'favicon.png',
					'session'	=> ''
				));

				if (!$this->db->trans_status()) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					
					$this->salin_contoh();
					
					$this->_create_file_config(array(
						'key'     	=> $this->key,
						'site_url'	=> site_url(),
						'db_host'	=> DB_HOST,
						'db_name' 	=> DB_NAME,
						'db_user' 	=> DB_USER,
						'db_pass' 	=> DB_PASS
					));

					$this->_create_file_dbconfig(array(
						'db_port' 	=> DB_PORT,
						'db_host' 	=> DB_HOST,
						'db_name' 	=> DB_NAME,
						'db_user' 	=> DB_USER,
						'db_pass' 	=> DB_PASS
					));

					$this->db->close();
					@unlink(FCPATH . "index.php");
					$this->rebuild_index();
					@delete_folder(FCPATH . 'install');
					redirect(base_url('index.php/siteman'));
				}
			}
		} else {
			$this->_view('welcome');
		}
	}

	public function _view($var = '')
	{
		$this->load->view('head', $this->vars);
		$this->load->view($var, $this->vars);
		$this->load->view('footer', $this->vars);
	}

	protected function _dbconfig($data)
	{
		define('DB_HOST', $data['db_host']);
		define('DB_NAME', $data['db_name']);
		define('DB_USER', $data['db_user']);
		define('DB_PASS', $data['db_pass']);
		define('DB_PORT', $data['db_port']);

		$config = array(
			'dsn'	   => 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8;',
			'hostname' => DB_HOST,
			'username' => DB_USER,
			'password' => DB_PASS,
			'database' => DB_NAME,
			'dbdriver' => 'pdo',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'development'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt'  => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => FALSE
		);

		return $config;
	}

	protected function _create_file_config($configs)
	{
		$content = cfile($configs);
		$file = FCPATH . "desa/config/config.php";
		write_file($file, $content);
	}

	protected function _create_file_dbconfig($configs)
	{
		$content = cdb($configs);
		$file = FCPATH . "desa/config/database.php";
		write_file($file, $content);
	}

	protected function rebuild_index()
	{
		$content = cindex();
		$file = FCPATH . "index.php";
		write_file(FCPATH . "index.php", $content);
	}

	private function generatePasswordHash($string)
	{
		// Pastikan inputnya adalah string
		$string = is_string($string) ? $string : strval($string);
		// Buat hash password
		$pwHash = password_hash($string, PASSWORD_BCRYPT);
		// Cek kekuatan hash, regenerate jika masih lemah
		if (password_needs_rehash($pwHash, PASSWORD_BCRYPT)) {
			$pwHash = password_hash($string, PASSWORD_BCRYPT);
		}

		return $pwHash;
	}

	private function salin_contoh()
	{
		if (!file_exists('desa')) {
			mkdir('desa');
			xcopy('desa-contoh', 'desa');
		}
	}
}
