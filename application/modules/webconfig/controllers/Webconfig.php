<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webconfig extends MX_Controller {

	function __construct() {
		parent::__construct();

		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);

	}
	function __deconstruct() {
		$this->db->close();
	}	
	function index() {
		$data = array(
			'content_view'=>'main',
			'title'=>'Welcome to administrator',
			'content'=>'ตัวอย่างการใช้งาน css template'
		);
		$this->template->load('index_page',$data);
	}

}
