<?php
include_once("Report.php");
class Volt_report extends Report {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function index() { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 89;
		$process_action = 'View';
		/*--END Inizial Data for Check User Permission--*/
		//content_view
		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign In Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			//$data['diff_info'] = $this->difficult_model->getAll_diffInfo();

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			/*-- AmCharts --*/
			set_js_asset_footer('../plugins/amcharts/amcharts.js');
			set_js_asset_footer('../plugins/amcharts/serial.js');
			set_js_asset_footer('../plugins/amcharts/plugins/export/export.min.js');
			set_css_asset_footer('../plugins/amcharts/plugins/export/export.css');
			set_js_asset_footer('../plugins/amcharts/themes/light.js');
			/*-- End AmCharts --*/

			set_js_asset_head('util.js','report');
			set_js_asset_head('util_control.js','report');

			set_css_asset_head('report.css','report');
			set_js_asset_footer('index.js','report'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'volt_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานข้อมูลอาสาสมัครดูแลผู้สูงอายุ (อผส.)
	//ข้อมูลภาพรวม
	public function volt_summary() {
			$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$this->load->model('report_model','report_model');
			$data = array();
			for($i=1;$i<=12;$i++){
						$arr_yyyymm[] = date( "Y-m", strtotime( (date('Y')-1)."-09-01 +".$i." month" ) );
			}
			$list_count_of_req = array();
			$list_count_of_help = array();
			foreach ($arr_yyyymm as $yyyymm) {
							$split_yyyymm = explode("-",$yyyymm);
							$yyyy = $split_yyyymm[0];
							$mm = $split_yyyymm[1];

							$str_mmyy = $arr_month[intval($mm)].' '.substr(($yyyy+543),-2);
							$list_mmyy[] = 	$str_mmyy;
							$res_of_req = $this->report_model->get_volt_summary($yyyy, $mm);

							$data['summary'][] = array('mmyy'=>$str_mmyy,
																				 'count_m' => $res_of_req['count_m'],
																				 'count_f' => $res_of_req['count_f'],
																				 'count_null' => $res_of_req['count_null'],
																				 'count_care'=>0);
			}
			$this->load->view('volt_summary', $data);
	}
	//ข้อมูลรายการตามพื้นที่
	public function volt_table_area() {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_area'] = $this->report_model->get_fnrl_table_area();
			$this->load->view('volt_table_area', $data);
	}
	//ข้อมูลรายการ
	public function volt_table($area_id='') {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->getAll_fnrlInfo($area_id);
			$this->load->view('volt_table', $data);
	}

}
