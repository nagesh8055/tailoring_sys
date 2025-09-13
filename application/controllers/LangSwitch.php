<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LangSwitch extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // 🔸 Load the session library
    }

    public function switchLanguage($language = "english") {
        $this->session->set_userdata('site_lang', $language);
        redirect($_SERVER['HTTP_REFERER']);
    }
}