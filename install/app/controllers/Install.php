<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Install extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit', '-1'); 
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Mulai atau koneksi ke database gagal
			if ($_POST['act'] === 'ke_basisdata') {
				$data = array('judul' => 'pengaturan basisdata', 'tujuan' => 'ke_desa', 'aksi' => 'Lanjutkan');
				$this->render_view('set_database', $data);
			}

			// langkah 1 Pengaturan Database
			if ($_POST['act'] === 'ke_desa') {
				$_SESSION['db_host'] = $this->input->post('db_host');
				$_SESSION['db_name'] = $this->input->post('db_name');
				$_SESSION['db_user'] = $this->input->post('db_user');
				$_SESSION['db_pass'] = $this->input->post('db_pass');

				$dbconfig = $this->_dbconfig();
				$db_obj = $this->load->database($dbconfig, TRUE);

				if (!$db_obj->conn_id) {
					$data = array('judul' => 'gagal koneksi basisdata', 'tujuan' => 'ke_basisdata', 'aksi' => 'Coba lagi');
					$this->render_view('disconnect', $data);
				} else {
					$this->load->database();
					
					if ($this->install_model->import_tables(FCPATH . "install/sql/opensid.sql") == TRUE) {
						$this->db->close(); // close connection
						$data = array('judul' => 'pengaturan profil desa', 'tujuan' => 'ke_pengguna', 'aksi' => 'Selesai');
						$this->render_view('set_data_desa', $data);
						
					} else {
						$data = array('judul' => 'pengaturan basisdata', 'tujuan' => 'ke_desa', 'aksi' => 'hubungkan basisdata');
						$this->render_view('set_database', $data);
					}
				}				
			}
			
			// Langkah 2 Pengaturan Data Desa
			if ($_POST['act'] === 'ke_pengguna') {
				$dbconfig = $this->_dbconfig();
				$db_obj = $this->load->database($dbconfig, TRUE);

				if (!$db_obj->conn_id) {
					$data = array('judul' => 'gagal koneksi basisdata', 'tujuan' => 'ke_basisdata', 'aksi' => 'Coba lagi');
					$this->render_view('disconnect', $data);
				} else {
					$this->load->database();
					$this->db->reconnect();

					$this->db->trans_off();
					$this->db->trans_begin();

					//Config desa
					$this->install_model->update_config(1, array(
						'nama_desa'			=> $_POST['desa'],
						'nama_kecamatan'  	=> $_POST['kec'],
						'nama_kabupaten' 	=> $_POST['kab'],
						'nama_propinsi' 	=> $_POST['prov'],
						'website' 			=> base_url()
					));

					// setting aplikasi
					$key = 'timezone';
					$this->install_model->update_setting($key, array(
						'value' 	=> $_POST['timezone']
					));
					$this->db->close(); // close connection
					$data = array('judul' => 'pengaturan pengguna', 'tujuan' => 'ke_login', 'aksi' => 'Selesasi');
					$this->render_view('set_user', $data);
				}
			}

			// Langkah 3 Pengaturan Pengguna
			if ($_POST['act'] === 'ke_login') {
				$dbconfig = $this->_dbconfig();
				$db_obj = $this->load->database($dbconfig, TRUE);

				if (!$db_obj->conn_id) {
					$data = array('judul' => 'gagal koneksi basisdata', 'tujuan' => 'ke_basisdata', 'aksi' => 'Coba lagi');
					$this->render_view('disconnect', $data);
				} else {
					$this->load->database();
					$this->db->reconnect();

					$key = $this->key;
					$pwHash = $this->generatePasswordHash($_POST['pass']);

					$this->db->trans_off();
					$this->db->trans_begin();

					// tambah pengguna
					$this->install_model->insert_user(array(
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
			}
		} else {
			$data = array('judul' => 'selamat datang', 'tujuan' => 'ke_basisdata', 'aksi' => 'Mulai');
			$this->render_view('welcome', $data);
		}
	}

	protected function _dbconfig()
	{
		define('DB_HOST', $_SESSION['db_host']);
		define('DB_NAME', $_SESSION['db_name']);
		define('DB_USER', $_SESSION['db_user']);
		define('DB_PASS', $_SESSION['db_pass']);
		define('DB_PORT', 3306);

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