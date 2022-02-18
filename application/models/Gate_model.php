<?php

class Gate_model extends CI_Model {
    function ajax_gate() {
        if (!$this->input->is_ajax_request()) {
            redirect('/');
        }
    }
	public function admin_gate() {
    try {
      $level = $this->session->userdata('usertype');
      if ( $level == 3) {
        return $level;
      }
    } catch (Exception $th) {}
    redirect('/authen/admin_login');
  }
    
    public function ctvgate() {
      try {
        $level = $this->session->userdata('usertype');
        if ($level == 2) {
          return $level;
        }
      } catch (Exception $th) {}
      redirect('/Authen/index');
    }
    public function ctvuser_data() {
      try {
        $level = $this->session->userdata('usertype');
        if ($level == 1 || $level == 2) {
          return $level;
        }
      } catch (Exception $th) {}
      redirect('/Authen/index');
    }
    public function user_gate() {
      try {
        $level = $this->session->userdata('usertype');
        if ($level == 1) {
          return $level;
        }
      } catch (Exception $th) {}
      redirect('/Authen/index');
    }

}