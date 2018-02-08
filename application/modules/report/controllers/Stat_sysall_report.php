<?php
include_once("Report.php");
class Stat_sysall_report extends Report {

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
		$app_id = 94;
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
			$data['content_view'] = 'stat_sysall_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}


		//รายงานสถิติประวัติการใช้งานภาพรวมระบบ
		//ข้อมูลภาพรวม
		public function stat_sysall_summary() {
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
								$dd = date('t',strtotime($yyyymm));// date end;

								$str_mmyy = $arr_month[intval($mm)].' '.substr(($yyyy+543),-2);
								$list_mmyy[] = 	$str_mmyy;
								$res_of_import = $this->report_model->get_stat_dbcenter_summary($yyyy, $mm,'Import');
								$res_of_export = $this->report_model->get_stat_dbcenter_summary($yyyy, $mm,'Export');

								$data['summary'][$mm] = array('mmyy'=>$str_mmyy,
																						'count_of_import' => $res_of_import['count_log'],
																						'sum_time_process_import'=>$res_of_import['time_process'],
																						'count_of_export'=>$res_of_export['count_log'],
																						'sum_time_process_export'=>$res_of_export['time_process']);
								for($d=1;$d<=$dd;$d++){
											$res_of_date_import = $this->report_model->get_stat_dbcenter_date_summary($yyyy, $mm, sprintf("%'02d",$d),'Import');
											$res_of_date_export = $this->report_model->get_stat_dbcenter_date_summary($yyyy, $mm, sprintf("%'02d",$d),'Export');
											$data['summary_date_import'][$mm][] =  array('count_log' => $res_of_date_import['count_log']);
											$data['summary_date_export'][$mm][] =  array('count_log' => $res_of_date_export['count_log']);
								}
				}

				$this->load->view('stat_sysall_summary', $data);
		}
		//ข้อมูลรายการ
		public function stat_sysall_table($area_id='') {
				$data = array();
				$this->load->model('report_model','report_model');
				$data['list_authen'] = $this->report_model->get_stat_dbcenter_user_authen_table();
				$data['list_process'] = $this->report_model->get_stat_dbcenter_process_table();
				$this->load->view('stat_dbcenter_table', $data);
		}
		//แสดง checkbox จังหวัด
		public function stat_sysall_map() {
				$this->load->model('report_model','report_model');
				$data['map_area'] = $this->report_model->get_area('10000000');
				$this->load->view('stat_sysall_map', $data);
		}
		//แสดงจุดแผนที่
		public function stat_sysall_xml_map($area_id=''){
				header("Content-type: text/xml; charset=utf-8");
				$this->load->model('report_model','report_model');

				$obj_area = $this->report_model->get_area($area_id);
				$shape_opacity = '0.1';

				$str =  "<markers>";
				foreach($obj_area as $row_area){
								$shape = $row_area['g_shape'];
								$lat = $row_area['latitude'];
								$lng = $row_area['longitude'];
								if($shape != ""){
										$str .= '<marker ';
										$str .= 'name="'.$row_area['area_name'].'" ';
										$str .= 'address="" ';
										$str .= 'lat="'.$lat.'" ';
										$str .= 'lng="'.$lng.'" ';
										$str .= 'shape="'.trim($shape).'" ';
										$str .= 'shape_color="#00FF00" ';
										$str .= 'shape_opacity="'.$shape_opacity.'" ';
										$str .= 'picture="picture" ';
										$str .= 'icon="" ';
										$str .= 'identify="'.site_url().report_url().'stat_sysall_report/stat_sysall_identify/'.$area_id.'" />';
								}
				}
				$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
				echo $str;
		}
		//รายละเอียดแผนที่
		public function stat_sysall_identify($area_id=''){
				$data_area = array();
				$this->load->model('report_model','report_model');
				$data_area = $this->report_model->get_area($area_id);
				$data_area = rowArray($data_area);
				$data['info'] = array('area_id'=>$area_id,
															'area_name' => $data_area['area_name']);
				$this->load->view('stat_sysall_identify', $data);
		}

}
