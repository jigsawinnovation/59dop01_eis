<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_access extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->database();

		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);
	}
	function __deconstruct() {
		$this->db->close();
	}
		
	public function index(){
		$this->isLogin();
	}

	public function isLogin(){
		if(get_session('pid')!=""){
			redirect('control/main_module','refresh');
		} else {
			$data = array('wrn'=>' ');
			$this->template->load('login',$data);
		}
	}

	public function login(){

		if(get_inpost('pid')!='' && get_inpost('passcode')!='') {

			/* Checking User by Web Service -----------------------------------------------------------------------------------:WS:*/
			$result = true;
			if($result) {

				$row=$this->admin_model->getLoginPinID(str_replace("-","",get_inpost('pid')),get_inpost('passcode'));

				if(isset($row['pid'])) { //Check Empty Result

					set_session('user_id',$row['user_id']);
					set_session('pid',$row['pid']);
					set_session('user_firstname',$row['user_firstname']);
					set_session('user_lastname',$row['user_lastname']);
					set_session('user_position',$row['user_position']);

					set_session('org_id',$row['org_id']);
					$tmp = rowArray($this->common_model->get_where_custom_and('usrm_org',array('org_id'=>$row['org_id'])));
					if(isset($tmp['org_title'])) {
						set_session('org_title',$tmp['org_title']);
					}else {
						set_session('org_title','Not affiliated');
					}
		
					if($row['user_photo_file']!='') {
						set_session('user_photo_file',$row['user_photo_file']);
						set_session('user_photo_label',$row['user_photo_label']);
					}
					else {
						set_session('user_photo_file','noProfilePic.jpg');
					}

					$this->common_model->insert('usrm_log',
						array(
							'app_id'=> 0,
							'process_action'=>'Authen',
							'log_action'=>'Sign In',
							'user_id'=>$row['user_id'],
							'org_id'=>$row['org_id'],
							'log_datetime'=> getDatetime(),
							'log_status'=>'Success'
						)
					);				
						
					redirect('member/admin_access','refresh');
				}

			}

		}

		$this->template->load('login',array('wrn'=>'ผู้ใช้งานนี้ไม่สามารถเข้าสู่ระบบได้, กรุณาติดต่อผู้ดูแลระบบ!'));
		//die(print_r($this->session->all_userdata()));
	}

	public function logout(){
		$this->session->sess_destroy();
					
		$this->common_model->insert('usrm_log',
			array(
				'app_id'=> 0,
				'process_action'=>'Authen',
				'log_action'=>'Sign Out',
				'user_id'=>"'".get_session('user_id')."'",
				'org_id'=>"'".get_session('org_id')."'",
				'log_datetime'=>getDatetime(),
				'log_status'=>'Success'
			)
		);	
		redirect('member/admin_access','refresh');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
