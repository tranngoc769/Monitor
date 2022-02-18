<?php

class History_model extends CI_Model
{

    // GET ALL BLOG
    public function get_history()
    {
        $today = date('Y-m-d');
        $data =  $this->db->select("*")
            ->order_by("date", "ASC")
            ->get("blogs");
        return $data->result();
    }
    public function get_online_today()
    {
        $today = date('Y-m-d');
        $sql = "SELECT
        h.userid,
        h.check_in,
        u.mac,
        u.`name`
        FROM
        history AS h
        JOIN `user` AS u ON u.id = h.userid
        WHERE DATE_FORMAT(h.check_in,'%Y-%m-%d') = '".$today."'";
        $data =  $this->db->query($sql);
        return $data->result();
    }
    
    public function get_all_log_today()
    {
        $today = date('Y-m-d');
        $sql = "SELECT * 
        FROM
        log l join user u on l.userid = u.id
        WHERE DATE_FORMAT(datetime,'%Y-%m-%d') = '".$today."' order by datetime limit 20";
        $data =  $this->db->query($sql);
        return $data->result();
    }
    public function get_user_data($id)
    {
        $query = $this->db
        ->limit(1)
        ->get_where("user", array("id" => $id))
        ->row();

        return $query;
    }
    public function get_user_history($id)
    {
        $today = date('Y-m-d');
        $sql = "SELECT
        h.userid,
        h.data
        FROM
        history AS h
        JOIN `user` AS u ON u.id = h.userid
        WHERE DATE_FORMAT(h.check_in,'%Y-%m-%d') = '".$today."'
        and u.id =".$id." limit 1";
        $data =  $this->db->query($sql);
        return $data->result();
    }
    
}
