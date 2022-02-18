<?php

class History_model extends CI_Model
{

    // GET ALL BLOG
    public function get_history()
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $today = $date->format('Y-m-d');
        $data =  $this->db->select("*")
            ->order_by("date", "ASC")
            ->get("blogs");
        return $data->result();
    }
    public function get_online_today()
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $today = $date->format('Y-m-d');
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
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $today = $date->format('Y-m-d');
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
    public function get_user_data_report($id,$from,$to)
    {
        $sql = "SELECT * FROM history WHERE userid = $id and check_in BETWEEN '$from 00:00:00' and '$to 23:59:00'";
        $query = $this->db->query($sql)
        ->result();
        return $query;
    }
    public function get_user_history($id)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        $today = $date->format('Y-m-d');
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
