<?php
include_once("Report.php");
class Impv_report extends Report {

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
		$app_id = 87;
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
			$data['content_view'] = 'impv_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
	//ข้อมูลภาพรวม
	public function impv_summary() {
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
					$res_of_home = $this->report_model->get_impv_home_summary($yyyy, $mm);
					$list_budget_of_home[] = intval($res_of_home['pay_amount']);
					$res_of_place = $this->report_model->get_impv_place_summary($yyyy, $mm);
					$list_budget_of_place[] = intval($res_of_place['pay_amount']);

					$data['summary'][] = array('mmyy'=>$str_mmyy,
																			'count_of_home' => $res_of_home['count_info'],
																			'sum_home_pay_amount'=>$res_of_home['pay_amount'],
																			'count_of_place'=>$res_of_place['count_info'],
																			'sum_place_pay_amount'=>$res_of_place['pay_amount']);
				}

				$data['categories'] = "'".implode("','",$list_mmyy)."'";
				$data['series_data_budget_of_home'] = implode(",",$list_budget_of_home);
				$data['series_data_budget_of_place'] = implode(",",$list_budget_of_place);

				$this->load->view('impv_summary', $data);
	}

	//ข้อมูลรายการ
	public function impv_table($area_id='') {
				$data = array();
				$this->load->model('report_model','report_model');
				$data['list_info'] = $this->report_model->getAll_impvInfo($area_id);
				$this->load->view('impv_table', $data);
	}

	//ข้อมูลรายการตามพื้นที่
	public function impv_table_area() {
				$data = array();
				$this->load->model('report_model','report_model');
				$data['list_area'] = $this->report_model->get_impv_table_area();
				$this->load->view('impv_table_area', $data);
	}

	//แสดง checkbox จังหวัด
	public function impv_map() {
				$this->load->model('report_model','report_model');
				$data['map_area'] = $this->report_model->get_area('10000000');
				$this->load->view('impv_map', $data);
	}
	//แสดงจุดแผนที่
	public function impv_xml_map($area_id=''){
				header("Content-type: text/xml; charset=utf-8");
				$this->load->model('report_model','report_model');
				$data_area = $this->report_model->get_map_impv_point();

				$str =  "<markers>";
				foreach($data_area as $row_area){
						$area_id = $row_area['imp_home_id'];
						if($row_area['addr_gps'] != ''){
								$arr_point = explode(',',$row_area['addr_gps']);
								$lat = $arr_point[0];
								$lng = $arr_point[1];
								if($lat != ""){
										$str .= '<marker ';
										$str .= 'name="'.$row_area['area_name'].'" ';
										$str .= 'address="" ';
										$str .= 'lat="'.$lat.'" ';
										$str .= 'lng="'.$lng.'" ';
										$str .= 'shape="" ';
										$str .= 'shape_color="" ';
										$str .= 'shape_opacity="" ';
										$str .= 'picture="picture" ';
										$str .= 'icon="" ';
										$str .= 'identify="'.site_url().report_url().'impv_report/impv_home_identify/'.$area_id.'" />';
								}
						}
				}
				$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
				echo $str;
	}
	//รายละเอียดแผนที่
	public function impv_home_identify($area_id=''){
				$data_area = array();
				$this->load->model('report_model','report_model');
				$data_area = $this->report_model->get_map_impv_info($area_id);
				$data_photo = $this->report_model->get_map_impv_photo($area_id);
					/*if($data_photo['photo_file']){
						$photo = site_url().'/'.$data_photo['photo_file'];
					}else{
						$photo = '';
					}*/
				$photo = site_url().'assets/admin/images/noimage.gif';
					//noimage.gif
				$name = $data_area['pers_firstname_th'].' '.$data_area['pers_lastname_th'];
				$data['info'] = array('area_id'=>$area_id,
															'pers_info_name' => $name,
															'area_name' => $data_area['area_name_th'],
															'photo' => $photo,
															'case_budget' => $data_area['case_budget']);

				$this->load->view('impv_home_identify', $data);
		}

}
