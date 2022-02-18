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
