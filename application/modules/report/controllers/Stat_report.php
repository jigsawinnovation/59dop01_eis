<?php
include_once("Report.php");
class Stat_report extends Report {

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
		$app_id = 90;
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
			$data['content_view'] = 'stat_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานสถิติประชากรผู้สูงอายุไทย
	//ข้อมูลภาพรวม
	public function stat_summary() {
			$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$this->load->model('report_model','report_model');
			$data = array();
			$data_summary = $this->report_model->get_stat_summary();
			foreach ($data_summary as $row_sum) {
					$data['summary'][] = array('year' => $row_sum['year'],
															'count_general' => $row_sum['count_general'],
															'count_pay_general' => $row_sum['count_pay_general'],
															'count_over60' => $row_sum['count_over60'],
															'count_pay_over60' => $row_sum['count_pay_over60']
															);
			}

			$this->load->view('stat_summary', $data);

		}
		public function stat_table_area() {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_area'] = $this->report_model->get_stat_table_area();
			$this->load->view('stat_table_area', $data);
		}
}
