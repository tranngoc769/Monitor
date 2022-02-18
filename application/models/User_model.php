<?php

class User_model extends CI_Model
{

    public function get_all_user()
    {
        $sql = "SELECT * 
        FROM
        user u";
        $data =  $this->db->query($sql);
        return $data->result();
    }
    public function get_all_app()
    {
        $sql = "SELECT * 
        FROM
        application where status = 0";
        $data =  $this->db->query($sql);
        return $data->result();
    }
    public function update_userdetail($mac, $data)
    {
        return $this->db->where("mac", $mac)->update("user", $data);
    }
    public function update_appdetail($name, $data)
    {
        return $this->db->where("name", $name)->update("application", $data);
    }
    public function insert_app($data)
    {
        return $this->db->insert("application", $data);
    }
    public function is_exist_app($name)
    {
        $query = $this->db
            ->limit(1)
            ->get_where("application", array("name" => $name))
            ->row();
        if ($query == null) {
            return -1;
        }
        return $query->status;
    }
    public function get_total_app()
    {
        $query = $this->db->query('SELECT count(id) as total FROM `application` WHERE status = 0')->row();
        if ($query == null) {
            return -1;
        }
        return $query->total;
    }
    public function get_total_user()
    {
        $query = $this->db->query('SELECT count(id) as total FROM `user`')->row();
        if ($query == null) {
            return -1;
        }
        return $query->total;
    }
}
