<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Install_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function last_id()
    {
        return $this->db->insert_id();
    }

    public function import_tables($file)
    {
        $this->db->trans_off();

        $this->db->trans_start(TRUE);
        $this->db->trans_begin();

        $sql = file_get_contents($file);
        $this->db->query($sql);

        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function insert_user($data)
    {
        return $this->db->insert('user', $data);
    }

    public function update_config($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('config', $data);
    }

    public function update_setting($key, $data)
    {
        $this->db->where('key', $key);
        return $this->db->update('setting_aplikasi', $data);
    }
}
