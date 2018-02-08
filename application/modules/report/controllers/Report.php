<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function report_url(){
	return 'report/';
}

class Report extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function template($get_app_id = 84) { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก

	}

}
