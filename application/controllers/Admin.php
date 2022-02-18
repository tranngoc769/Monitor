<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('product_model');
        $this->load->model('history_model');
        $this->load->model('user_model');
    }
    // Dashboard
    public function index()
    {
        // $this->gate_model->admin_gate();
        $data['title'] = "Trang chủ";
        $onlines = $this->history_model->get_online_today();
        $data['onlines'] = $onlines;
        $logs = $this->history_model->get_all_log_today();
        $total_app = $this->user_model->get_total_app();
        $data['total_app'] = $total_app;
        $total_user = $this->user_model->get_total_user();
        $data['total_user'] = $total_user;
        $data['online_users'] = count($onlines);
        $data['logs'] = $logs;
        // $head['username'] = $this->session->userdata["username"];
        $this->load->view('layout/head.php',$data);
        $this->load->view('layout/header.php');
        $this->load->view('layout/side.php');
        $this->load->view('index', $data);
        $this->load->view('layout/footer.php');
        // 
        // $this->load->view('layout/admin/admin_footer.php');
    }

    public function apps()
    {
        // $this->gate_model->admin_gate();
        $data['title'] = "Ứng dụng";
        $users = $this->user_model->get_all_app();
        $data['users'] = $users;
        // $head['username'] = $this->session->userdata["username"];
        $this->load->view('layout/head.php',$data);
        $this->load->view('layout/header.php');
        $this->load->view('layout/side.php');
        $this->load->view('apps', $data);
        $this->load->view('layout/footer.php');
        // 
        // $this->load->view('layout/admin/admin_footer.php');
    }
    public function users()
    {
        // $this->gate_model->admin_gate();
        $data['title'] = "Thiết bị";
        $users = $this->user_model->get_all_user();
        $data['users'] = $users;
        // $head['username'] = $this->session->userdata["username"];
        $this->load->view('layout/head.php',$data);
        $this->load->view('layout/header.php');
        $this->load->view('layout/side.php');
        $this->load->view('users', $data);
        $this->load->view('layout/footer.php');
        // 
        // $this->load->view('layout/admin/admin_footer.php');
    }
    public function detail()
    {
        // $this->gate_model->admin_gate();
        $data['title'] = "Chi tiết";
        $id = $_GET["id"];
        $userdata = $this->history_model->get_user_data($id);
        $data['userdata'] = $userdata;
        $logs = $this->history_model->get_all_log_today();
        $data['logs'] = $logs;
        // $head['username'] = $this->session->userdata["username"];
        $this->load->view('layout/head.php',$data);
        $this->load->view('layout/header.php');
        $this->load->view('layout/side.php');
        $this->load->view('detail', $data);
        $this->load->view('layout/userfooter.php');
        // 
        // $this->load->view('layout/admin/admin_footer.php');
    }
    public function report()
    {
        // $this->gate_model->admin_gate();
        $data['title'] = "Báo cáo";
        $id = $_GET["id"];
        $userdata = $this->history_model->get_user_data($id);
        $data['userdata'] = $userdata;
        $logs = $this->history_model->get_all_log_today();
        $data['logs'] = $logs;
        $from = "";
        $to = "";
        if (isset($_GET["from"]) && isset($_GET["to"])){
            $from = $_GET["from"];
            $to = $_GET["to"];
        }
        $date = new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh') );
        if ($from == "" && $to == ""){
            $from = $date->format('Y-m-01');
            $to = $date->format('Y-m-t');
        }
        $all_apps = array();
        $reports = $this->history_model->get_user_data_report($id,$from, $to);
        for ($i=0; $i < count($reports) ; $i++) { 
            $date_report = $reports[$i]->data;
            try {
                $date_report = json_decode($date_report);
            } catch (\Throwable $th) {
            }
            if ($date_report != null){
                foreach($date_report as $key => $value) {
                    if ($all_apps[$key] == null){
                        $all_apps[$key] = array("detail"=>$value->detail,"online"=>0);
                    }
                    try {
                        $all_apps[$key]["online"] = $all_apps[$key]["online"] + $value->time_online;
                    } catch (Exception $th) {
                        //throw $th;
                    }
                }
            }
            
        }
        $data['reports'] = $all_apps;
        $data['from'] = $from;
        $data['to'] = $to;
        // 
        // $head['username'] = $this->session->userdata["username"];
        $this->load->view('layout/head.php',$data);
        $this->load->view('layout/header.php');
        $this->load->view('layout/side.php');
        $this->load->view('report', $data);
        $this->load->view('layout/reportfooter.php');
        // 
        // $this->load->view('layout/admin/admin_footer.php');
    }
    public function get_user()
    {
        $id = $_GET["id"];
        $datas = $this->history_model->get_user_history($id);
        $array = array(
            "code" => 200,
            "msg" => $datas
        );
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($array);
        return;
    }
    public function update_user()
    {
        $mac = $this->input->post("mac");
        $name = $this->input->post("name");
        $datas = $this->user_model->update_userdetail($mac, array("name"=> $name));
        if ($datas){
            $array = array(
                "code" => 200,
                "msg" => "Thành công"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }else{
            $array = array(
                "code" => 400,
                "msg" => "Không thành công"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }
    }
    public function update_app()
    {
        $name = $this->input->post("name");
        $detail = $this->input->post("detail");
        $datas = $this->user_model->update_appdetail($name, array("detail"=> $detail));
        if ($datas){
            $array = array(
                "code" => 200,
                "msg" => "Thành công"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }else{
            $array = array(
                "code" => 400,
                "msg" => "Không thành công"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }
    }
    public function add_app()
    {
        $name = $this->input->post("name");
        $detail = $this->input->post("name");
        $status = $this->user_model->is_exist_app($name);
        if ($status == -1){
            // Khoong ton tai --. add
            $status_add = $this->user_model->insert_app(array("name"=>$name,"detail"=> $detail));
            if ($status_add){
                $array = array(
                    "code" => 200,
                    "msg" => "Thành công"
                );
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                echo json_encode($array);
                return;
            }else{
                $array = array(
                    "code" => 400,
                    "msg" => "Không thành công"
                );
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                echo json_encode($array);
                return;
            }
        };

        if ($status == 0){
            // Đang hoạt động
            $array = array(
                "code" => 400,
                "msg" => "Đã tồn tại ứng dụng"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }else{
            // Đã xóa --> reactice
            $status_add = $this->user_model->update_appdetail($name, array("status"=> 0));
            if ($status_add){
                $array = array(
                    "code" => 200,
                    "msg" => "Thành công"
                );
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                echo json_encode($array);
                return;
            }else{
                $array = array(
                    "code" => 400,
                    "msg" => "Không thành công"
                );
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                echo json_encode($array);
                return;
            }
        }
    }
    public function delete_app()
    {
        $name = $this->input->post("name");
        $datas = $this->user_model->update_appdetail($name, array("status"=> 1));
        if ($datas){
            $array = array(
                "code" => 200,
                "msg" => "Thành công"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }else{
            $array = array(
                "code" => 400,
                "msg" => "Không thành công"
            );
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($array);
            return;
        }
    }
}
