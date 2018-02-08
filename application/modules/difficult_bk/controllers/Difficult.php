<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Difficult extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function report($get_app_id = 84) { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = $get_app_id;
		$process_action = 'View';
		/*--END Inizial Data for Check User Permission--*/
		//content_view
		$arr_content_view = array();
		$arr_content_view[84] = 'service_report';//รายงานผลการดำเนินงานการให้บริการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		$arr_content_view[85] = 'kpiorg_report';//รายงานผลการดำเนินงานตามตัวชี้วัด ศูนย์พัฒนาการจัดสวัสดิการสังคมผู้สูงอายุ
		$arr_content_view[86] = 'fnrl_report';//รายงานผลการดำเนินงานการสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี
		$arr_content_view[87] = 'impv_report';//รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
		$arr_content_view[88] = 'wisd_report';//รายงานข้อมูลคลังปัญญาผู้สูงอายุ
		$arr_content_view[89] = 'volt_report';//รายงานข้อมูลอาสาสมัครดูแลผู้สูงอายุ (อผส.)
		$arr_content_view[90] = 'stat_report';//รายงานสถิติประชากรผู้สูงอายุไทย
		$arr_content_view[93] = 'edoe_report';//รายงานข้อมูลส่งเสริมการจ้างงานผู้สูงอายุ
		$arr_content_view[98] = 'gateway_report';//รายงานสถิติการเชื่อมโยงข้อมูลในการบูรณาการงานผู้สูงอายุ
		//echo 'app_id: '.$app_id.' user_id: '.$user_id;
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

			/*-- Load Datatables for Theme --*/
			//set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
			//set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');
			/*-- End Load Datatables for Theme --*/

			/*-- Toastr style --*/
			//set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
			//set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
			/*-- End Toastr style --*/

			/*-- datepicker --*/
			//set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
			//set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
			/*-- End datepicker --*/

			/*-- datepicker --*/
			// set_css_asset_head('../plugins/bootstrap-datepicker-thai/css/datepicker.css');
			// set_js_asset_head('../plugins/bootstrap-datepicker-thai/js/bootstrap-datepicker.js');
			// set_js_asset_head('../plugins/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js');
			// set_js_asset_head('../plugins/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js');
			/*-- End datepicker --*/

			/*-- AmCharts --*/
			set_js_asset_footer('../plugins/amcharts/amcharts.js');
			set_js_asset_footer('../plugins/amcharts/serial.js');
			set_js_asset_footer('../plugins/amcharts/plugins/export/export.min.js');
			set_css_asset_footer('../plugins/amcharts/plugins/export/export.css');
			set_js_asset_footer('../plugins/amcharts/themes/light.js');
			/*-- End AmCharts --*/

			set_js_asset_head('util.js','difficult');
			set_js_asset_head('util_control.js','difficult');

			//set_js_asset_head('highcharts.js','difficult');

			set_css_asset_head('report.css','difficult');
			set_js_asset_footer('index.js','difficult'); //Set JS Index.js


			$data['process_action'] = $process_action;
			$data['content_view'] = $arr_content_view[$app_id];

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'difficult');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
	//ข้อมูลภาพรวม
	public function service_summary() {
		$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
		$this->load->model('difficult_report_model','difficult_report_model');
		$data = array();
		for($i=1;$i<=12;$i++){
			$arr_yyyymm[] = date( "Y-m", strtotime( (date('Y')-1)."-09-01 +".$i." month" ) );
		}
		$list_count_of_req = array();
		$list_count_of_visit = array();
		$list_count_of_help = array();
		foreach ($arr_yyyymm as $yyyymm) {
			$split_yyyymm = explode("-",$yyyymm);
			$yyyy = $split_yyyymm[0];
			$mm = $split_yyyymm[1];

			$str_mmyy = $arr_month[intval($mm)].' '.substr(($yyyy+543),-2);
			$list_mmyy[] = 	$str_mmyy;
			$res_of_req = $this->difficult_report_model->get_summary($yyyy, $mm, 'date_of_req');
			$list_count_of_req[] = $res_of_req['count_diff_info'];
			$res_of_visit = $this->difficult_report_model->get_summary($yyyy, $mm, 'date_of_visit');
			$list_count_of_visit[] = $res_of_visit['count_diff_info'];
			$res_of_pay = $this->difficult_report_model->get_summary($yyyy, $mm, 'date_of_pay');
			$list_count_of_help[] = $res_of_pay['count_diff_info'];

			$data['summary'][] = array('mmyy'=>$str_mmyy,
																	'count_of_req' => $res_of_req['count_diff_info'],
																	'count_of_visit' => $res_of_visit['count_diff_info'],
																	'count_of_help'=>$res_of_pay['count_diff_info'],
																	'sum_pay_amount'=>$res_of_pay['pay_amount']);
		}

		$data['categories'] = "'".implode("','",$list_mmyy)."'";
		$data['series_data_count_of_req'] = implode(",",$list_count_of_req);
		$data['series_data_count_of_visit'] = implode(",",$list_count_of_visit);
		$data['series_data_count_of_help'] = implode(",",$list_count_of_help);

		$this->load->view('service_summary', $data);

	}
	//ข้อมูลรายการตามพื้นที่
	public function service_table_area() {
		$data = array();
		$this->load->model('difficult_report_model','difficult_report_model');
		$data['list_area'] = $this->difficult_report_model->get_service_table_area();
		$this->load->view('service_table_area', $data);
	}
	//ข้อมูลรายการ
	public function service_table($area_id='') {
		$data = array();
		$this->load->model('difficult_report_model','difficult_report_model');
		$data['list_info'] = $this->difficult_report_model->getAll_diffInfo($area_id);
		$this->load->view('service_table', $data);
	}
	//
	public function service_table_search() {
		$quick_search = $this->input->get('quick_search');
		$data_search = array();
		$data_search['quick_search'] = $quick_search;
		$data = array();
		$this->load->model('difficult_report_model','difficult_report_model');
		$data['list_info'] = $this->difficult_report_model->getAll_diffInfo($data_search);
		$this->load->view('service_table_search', $data);
	}
	//แสดง checkbox จังหวัด
	public function service_map() {
		$this->load->model('difficult_report_model','difficult_report_model');
		$data['map_area'] = $this->difficult_report_model->get_area();
		$this->load->view('service_map', $data);
	}
	//แสดงจุดแผนที่
	public function service_xml_map($area_id=''){

			header("Content-type: text/xml; charset=utf-8");
			$this->load->model('difficult_report_model','difficult_report_model');
			$data_area = $this->difficult_report_model->get_map_info($area_id);
			$obj_area = $this->difficult_report_model->get_area($area_id);
			$count_of_req = (isset($data_area['count_of_req']))?$data_area['count_of_req']:0;

			if($count_of_req > 0){
					$shape_opacity = '0.5';
			}else{
					$shape_opacity = '0.1';
			}

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
							$str .= 'icon="'.site_url().'/assets/modules/difficult/images/blank.png" ';
							$str .= 'identify="'.site_url().'/difficult/service_identify/'.$area_id.'" />';
					}
				}
			$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
			echo $str;
		}
		//รายละเอียดแผนที่
		public function service_identify($area_id=''){
			$data_area = array();
			$this->load->model('difficult_report_model','difficult_report_model');
			$data_area = $this->difficult_report_model->get_map_info($area_id);
			$arr_get_area = $this->difficult_report_model->get_area($area_id);
			$get_area = $arr_get_area[0];

			$count_of_req = (isset($data_area['count_of_req']))?$data_area['count_of_req']:0;
			$count_of_visit = (isset($data_area['count_of_visit']))?$data_area['count_of_visit']:0;
			$count_of_pay = (isset($data_area['count_of_pay']))?$data_area['count_of_pay']:0;
			$pay_amount = (isset($data_area['pay_amount']))?$data_area['pay_amount']:0;

			$data['info'] = array('area_id'=>$area_id,
														'area_name' => $get_area['area_name'],
														'count_of_req' => $count_of_req,
														'count_of_visit' => $count_of_visit,
														'count_of_help' => $count_of_pay,
														'sum_pay_amount' => $pay_amount);

			$this->load->view('service_identify', $data);
		}

		// รายงานผลการดำเนินงานการสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี
		//ข้อมูลภาพรวม
		public function fnrl_summary() {
			$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$this->load->model('difficult_report_model','difficult_report_model');
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
				$res_of_req = $this->difficult_report_model->get_fnrl_summary($yyyy, $mm, 'date_of_req');
				$list_count_of_req[] = $res_of_req['count_info'];
				$res_of_pay = $this->difficult_report_model->get_fnrl_summary($yyyy, $mm, 'date_of_pay');
				$list_count_of_help[] = $res_of_pay['count_info'];

				$data['summary'][] = array('mmyy'=>$str_mmyy,
																		'count_of_req' => $res_of_req['count_info'],
																		'count_of_help'=>$res_of_pay['count_info'],
																		'sum_pay_amount'=>$res_of_pay['pay_amount']);
			}

			$data['categories'] = "'".implode("','",$list_mmyy)."'";
			$data['series_data_count_of_req'] = implode(",",$list_count_of_req);
			$data['series_data_count_of_help'] = implode(",",$list_count_of_help);

			$this->load->view('fnrl_summary', $data);
		}
		//ข้อมูลรายการตามพื้นที่
		public function fnrl_table_area() {
			$data = array();
			$this->load->model('difficult_report_model','difficult_report_model');
			$data['list_area'] = $this->difficult_report_model->get_fnrl_table_area();
			$this->load->view('fnrl_table_area', $data);
		}
		//ข้อมูลรายการ
		public function fnrl_table($area_id='') {
			$data = array();
			$this->load->model('difficult_report_model','difficult_report_model');
			$data['list_info'] = $this->difficult_report_model->getAll_fnrlInfo($area_id);
			$this->load->view('fnrl_table', $data);
		}

		//แสดง checkbox จังหวัด
		public function fnrl_map() {
			$this->load->model('difficult_report_model','difficult_report_model');
			$data['map_area'] = $this->difficult_report_model->get_area();
			$this->load->view('fnrl_map', $data);
		}
		//แสดงจุดแผนที่
		public function fnrl_xml_map($area_id=''){
				header("Content-type: text/xml; charset=utf-8");
				$this->load->model('difficult_report_model','difficult_report_model');
				$data_area = $this->difficult_report_model->get_map_fnrl_info($area_id);
				$obj_area = $this->difficult_report_model->get_area($area_id);
				$count_of_req = (isset($data_area['count_of_req']))?$data_area['count_of_req']:0;

				if($count_of_req > 0){
						$shape_opacity = '0.5';
				}else{
						$shape_opacity = '0.1';
				}

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
								$str .= 'icon="'.site_url().'/assets/modules/difficult/images/blank.png" ';
								$str .= 'identify="'.site_url().'/difficult/fnrl_identify/'.$area_id.'" />';
						}
					}
				$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
				echo $str;
			}
			//รายละเอียดแผนที่
			public function fnrl_identify($area_id=''){
				$data_area = array();
				$this->load->model('difficult_report_model','difficult_report_model');
				$data_area = $this->difficult_report_model->get_map_fnrl_info($area_id);
				$arr_get_area = $this->difficult_report_model->get_area($area_id);
				$get_area = $arr_get_area[0];

				$count_of_req = (isset($data_area['count_of_req']))?$data_area['count_of_req']:0;
				$count_of_pay = (isset($data_area['count_of_pay']))?$data_area['count_of_pay']:0;
				$pay_amount = (isset($data_area['pay_amount']))?$data_area['pay_amount']:0;

				$data['info'] = array('area_id'=>$area_id,
															'area_name' => $get_area['area_name'],
															'count_of_req' => $count_of_req,
															'count_of_help' => $count_of_pay,
															'sum_pay_amount' => $pay_amount);

				$this->load->view('fnrl_identify', $data);
			}


			// รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
			//ข้อมูลภาพรวม
			public function impv_summary() {
				$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
				$this->load->model('difficult_report_model','difficult_report_model');
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
					$res_of_home = $this->difficult_report_model->get_impv_home_summary($yyyy, $mm);
					$list_budget_of_home[] = intval($res_of_home['pay_amount']);
					$res_of_place = $this->difficult_report_model->get_impv_place_summary($yyyy, $mm);
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
				$this->load->model('difficult_report_model','difficult_report_model');
				$data['list_info'] = $this->difficult_report_model->getAll_impvInfo($area_id);
				$this->load->view('impv_table', $data);
			}

			//ข้อมูลรายการตามพื้นที่
			public function impv_table_area() {
				$data = array();
				$this->load->model('difficult_report_model','difficult_report_model');
				$data['list_area'] = $this->difficult_report_model->get_impv_table_area();
				$this->load->view('impv_table_area', $data);
			}

			//แสดง checkbox จังหวัด
			public function impv_map() {
				$this->load->model('difficult_report_model','difficult_report_model');
				$data['map_area'] = $this->difficult_report_model->get_area('10000000');
				$this->load->view('impv_map', $data);
			}
			//แสดงจุดแผนที่
			public function impv_xml_map($area_id=''){
					header("Content-type: text/xml; charset=utf-8");
					$this->load->model('difficult_report_model','difficult_report_model');
					$data_area = $this->difficult_report_model->get_map_impv_point();

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
										$str .= 'identify="'.site_url().'/difficult/impv_home_identify/'.$area_id.'" />';
									}
								}
						}
					$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
					echo $str;
				}
				//รายละเอียดแผนที่
				public function impv_home_identify($area_id=''){
					$data_area = array();
					$this->load->model('difficult_report_model','difficult_report_model');
					$data_area = $this->difficult_report_model->get_map_impv_info($area_id);
					$data_photo = $this->difficult_report_model->get_map_impv_photo($area_id);
					/*if($data_photo['photo_file']){
						$photo = site_url().'/'.$data_photo['photo_file'];
					}else{
						$photo = '';
					}*/
					$photo = site_url().'/assets/admin/images/noimage.gif';
					//noimage.gif
					$name = $data_area['pers_firstname_th'].' '.$data_area['pers_lastname_th'];
					$data['info'] = array('area_id'=>$area_id,
																'pers_info_name' => $name,
																'area_name' => $data_area['area_name_th'],
																'photo' => $photo,
																'case_budget' => $data_area['case_budget']);

					$this->load->view('impv_home_identify', $data);
				}

				// รายงานข้อมูลคลังปัญญาผู้สูงอายุ
				//ข้อมูลภาพรวม
				public function wisd_summary() {

					$this->load->model('difficult_report_model','difficult_report_model');
					$data_branch = $this->difficult_report_model->get_wisd_summary();
					$data = array();
					$sum_wis_info = 0;
					foreach ($data_branch as $row) {
						$wis_count_info = (isset($row['count_info']))?$row['count_info']:0;
						$sum_wis_info += $wis_count_info;
					}
					foreach ($data_branch as $row) {
						$list_wis_name[] =  $row['wis_name'];
						$list_wis_count_info[] = $row['count_info'];
						$wis_count_info = (isset($row['count_info']))?$row['count_info']:0;
						$wis_percent = ($wis_count_info*100)/$sum_wis_info;
						$data['summary'][] = array('wis_name'=>$row['wis_name'],
																				'wis_count_info' => $wis_count_info,
																				'wis_percent' => $wis_percent);
					}
					$data['categories'] = "'".implode("','",$list_wis_name)."'";
					$data['series_wis_count_info'] = implode(",",$list_wis_count_info);

					$this->load->view('wisd_summary', $data);

				}
				//ข้อมูลรายการตามพื้นที่
				public function wisd_table_area() {
					$data = array();
					$this->load->model('difficult_report_model','difficult_report_model');
					$data['list_area'] = $this->difficult_report_model->get_wisd_table_area();
					$this->load->view('wisd_table_area', $data);
				}
				//ข้อมูลรายการ
				public function wisd_table($area_id='') {

					$data = array();
					$this->load->model('difficult_report_model','difficult_report_model');
					$data['list_info'] = $this->difficult_report_model->getAll_wisdInfo($area_id);
					$this->load->view('wisd_table', $data);
				}
				//
				public function wisd_table_search() {
					$quick_search = $this->input->get('quick_search');
					$data_search = array();
					$data_search['quick_search'] = $quick_search;
					$data = array();
					$this->load->model('difficult_report_model','difficult_report_model');
					$data['list_info'] = $this->difficult_report_model->getAll_diffInfo($data_search);
					$this->load->view('service_table_search', $data);
				}
				//แสดง checkbox จังหวัด
				public function wisd_map() {
					$this->load->model('difficult_report_model','difficult_report_model');
					$data['map_area'] = $this->difficult_report_model->get_area('10000000');
					$this->load->view('wisd_map', $data);
				}
				//แสดงจุดแผนที่
				public function wisd_xml_map($area_id=''){

					header("Content-type: text/xml; charset=utf-8");
					$this->load->model('difficult_report_model','difficult_report_model');
					$data_area = $this->difficult_report_model->get_map_impv_point();

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
										$str .= 'icon="'.site_url().'/assets/modules/difficult/images/mapmark.png" ';
										$str .= 'identify="'.site_url().'/difficult/wisd_identify/'.$area_id.'" />';
									}
								}
						}
					$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
					echo $str;
					}
					//รายละเอียดแผนที่
					public function wisd_identify($area_id=''){
						$data_area = array();
						$this->load->model('difficult_report_model','difficult_report_model');
						$data_area = $this->difficult_report_model->get_map_impv_info($area_id);
						$data_photo = $this->difficult_report_model->get_map_impv_photo($area_id);
						/*if($data_photo['photo_file']){
							$photo = site_url().'/'.$data_photo['photo_file'];
						}else{
							$photo = '';
						}*/
						$photo = site_url().'/assets/modules/difficult/images/no_image.png';
						//noimage.gif
						$name = $data_area['pers_firstname_th'].' '.$data_area['pers_lastname_th'];
						$data['info'] = array('area_id'=>$area_id,
																	'pers_info_name' => $name,
																	'area_name' => $data_area['area_name_th'],
																	'photo' => $photo,
																	'case_budget' => $data_area['case_budget']);

						$this->load->view('wisd_identify', $data);
					}

					// รายงานข้อมูลส่งเสริมการจ้างงานผู้สูงอายุ
					//ข้อมูลภาพรวม
					public function edoe_summary() {
						$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
						$this->load->model('difficult_report_model','difficult_report_model');
						$data = array();

						$data_summary = $this->difficult_report_model->get_edoe_summary();
						//$data
						foreach ($data_summary as $row) {
							$list_budget_year[] = $row['budget_year'];
							$list_count_job_vacancy[] = $row['count_job_vacancy'];
							$list_count_job_reg_y[] = $row['count_job_reg_y'];
							$list_ccount_job_reg_n[] = $row['count_job_reg_n'];
							$data['summary'][] = array('budget_year' => $row['budget_year'],
																					'count_job_vacancy' => $row['count_job_vacancy'],
																					'count_job_reg_y' => $row['count_job_reg_y'],
																					'count_job_reg_n' => $row['count_job_reg_n'],
																					'count_job_reg_sum' => $row['count_job_reg_y']+$row['count_job_reg_n']
																					);
						}

						$data['categories'] = "'".implode("','",$list_budget_year)."'";
						$data['series_data_count_job_vacancy'] = implode(",",$list_count_job_vacancy);
						$data['series_data_count_job_reg_y'] = implode(",",$list_count_job_reg_y);
						$data['series_data_count_job_reg_n'] = implode(",",$list_ccount_job_reg_n);

						$this->load->view('edoe_summary', $data);

					}
					//ข้อมูลรายการตามพื้นที่
					public function edoe_table_area() {
						$data = array();
						$this->load->model('difficult_report_model','difficult_report_model');
						$data['list_area'] = $this->difficult_report_model->get_edoe_table_area();
						$this->load->view('edoe_table_area', $data);
					}
					//ข้อมูลรายการ
					public function edoe_table($area_id) {

						$data = array();
						$this->load->model('difficult_report_model','difficult_report_model');
						$data['list_info'] = $this->difficult_report_model->getAll_edoeInfo($area_id);
						$this->load->view('edoe_table', $data);
					}
					//
					public function edoe_table_search() {
						$quick_search = $this->input->get('quick_search');
						$data_search = array();
						$data_search['quick_search'] = $quick_search;
						$data = array();
						$this->load->model('difficult_report_model','difficult_report_model');
						$data['list_info'] = $this->difficult_report_model->getAll_diffInfo($data_search);
						$this->load->view('service_table_search', $data);
					}
					//แสดง checkbox จังหวัด
					public function edoe_map() {
						$this->load->model('difficult_report_model','difficult_report_model');
						$data['map_area'] = $this->difficult_report_model->get_area();
						$this->load->view('edoe_map', $data);
					}
					//แสดงจุดแผนที่
					public function edoe_xml_map($area_id=''){

							header("Content-type: text/xml; charset=utf-8");
							$this->load->model('difficult_report_model','difficult_report_model');
							$data_area = $this->difficult_report_model->get_map_edoe_info($area_id);
							$obj_area = $this->difficult_report_model->get_area($area_id);
							$count_of_req = (isset($data_area['count_org']))?$data_area['count_org']:0;

							if($count_of_req > 0){
									$shape_opacity = '0.5';
							}else{
									$shape_opacity = '0.1';
							}

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
											$str .= 'icon="'.site_url().'/assets/modules/difficult/images/blank.png" ';
											$str .= 'identify="'.site_url().'/difficult/edoe_identify/'.$area_id.'" />';
									}
								}
							$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
							echo $str;
					}
					//รายละเอียดแผนที่
					public function edoe_identify($area_id=''){
							$data_area = array();
							$this->load->model('difficult_report_model','difficult_report_model');
							$data_area = $this->difficult_report_model->get_map_edoe_info($area_id);
							$arr_get_area = $this->difficult_report_model->get_area($area_id);
							$get_area = $arr_get_area[0];

							$count_org = (isset($data_area['count_org']))?$data_area['count_org']:0;
							$count_job_vacancy = (isset($data_area['count_job_vacancy']))?$data_area['count_job_vacancy']:0;
							$count_of_req = (isset($data_area['count_of_req']))?$data_area['count_of_req']:0;

							$data['info'] = array('area_id'=>$area_id,
																		'area_name' => $get_area['area_name'],
																		'count_org' => $count_org,
																		'count_job_vacancy' => $count_job_vacancy,
																		'count_of_req' => $count_of_req);

							$this->load->view('edoe_identify', $data);
					}
					// รายงานสถิติการเชื่อมโยงข้อมูลในการบูรณาการงานผู้สูงอายุ
					//ข้อมูลภาพรวม
					public function gateway_summary() {
							$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
							$this->load->model('difficult_report_model','difficult_report_model');
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
								$res_of_import = $this->difficult_report_model->get_gateway_summary($yyyy, $mm,'Import');
								$res_of_export = $this->difficult_report_model->get_gateway_summary($yyyy, $mm,'Export');

								$data['summary'][$mm] = array('mmyy'=>$str_mmyy,
																						'count_of_import' => $res_of_import['count_log'],
																						'sum_time_process_import'=>$res_of_import['time_process'],
																						'count_of_export'=>$res_of_export['count_log'],
																						'sum_time_process_export'=>$res_of_export['time_process']);
								for($d=1;$d<=$dd;$d++){
											$res_of_date_import = $this->difficult_report_model->get_gateway_date_summary($yyyy, $mm, sprintf("%'02d",$d),'Import');
											$res_of_date_export = $this->difficult_report_model->get_gateway_date_summary($yyyy, $mm, sprintf("%'02d",$d),'Export');
											$data['summary_date_import'][$mm][] =  array('count_log' => $res_of_date_import['count_log']);
											$data['summary_date_export'][$mm][] =  array('count_log' => $res_of_date_export['count_log']);
								}


							}

							$this->load->view('gateway_summary', $data);
					}
					//ข้อมูลรายการ
					public function gateway_table($area_id='') {
							$data = array();
							$this->load->model('difficult_report_model','difficult_report_model');
							$data['list_authen'] = $this->difficult_report_model->get_gateway_user_authen_table();
							$data['list_process'] = $this->difficult_report_model->get_gateway_process_table();
							$data['list_dtawh'] = $this->difficult_report_model->get_gateway_dtawh_table();
							$this->load->view('gateway_table', $data);
					}
					//แสดง checkbox จังหวัด
					public function gateway_map() {
							$this->load->model('difficult_report_model','difficult_report_model');
							$data['map_area'] = $this->difficult_report_model->get_area('10000000');
							$this->load->view('gateway_map', $data);
					}
					//แสดงจุดแผนที่
					public function gateway_xml_map($area_id=''){
								header("Content-type: text/xml; charset=utf-8");
								$this->load->model('difficult_report_model','difficult_report_model');

								$obj_area = $this->difficult_report_model->get_area($area_id);
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
												$str .= 'identify="'.site_url().'/difficult/gateway_identify/'.$area_id.'" />';
										}
									}
								$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
								echo $str;
					}
					//รายละเอียดแผนที่
					public function gateway_identify($area_id=''){
								$data_area = array();
								$this->load->model('difficult_report_model','difficult_report_model');
								$data_area = $this->difficult_report_model->get_area($area_id);
								$data_area = rowArray($data_area);
								$data['info'] = array('area_id'=>$area_id,
																			'area_name' => $data_area['area_name']);
								$this->load->view('gateway_identify', $data);
					}

					// รายงานผลการดำเนินงานตามตัวชี้วัด ศูนย์พัฒนาการจัดสวัสดิการสังคมผู้สูงอายุ
					//ข้อมูลภาพรวม
					public function kpiorg_summary() {
								$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
								$this->load->model('difficult_report_model','difficult_report_model');
								$data = array();

								$age_range[] = array('age_min'=>'60', 'age_max'=>'70', 'name'=>'60-70 ปี');
								$age_range[] = array('age_min'=>'71', 'age_max'=>'80', 'name'=>'71-80 ปี');
								$age_range[] = array('age_min'=>'81', 'age_max'=>'90', 'name'=>'81-90 ปี');
								$age_range[] = array('age_min'=>'91', 'age_max'=>'120', 'name'=>'91 ปีขึ้นไป');
								$age_range[] = array('age_min'=>'0', 'age_max'=>'0', 'name'=>'ไม่ระบุ');

								foreach ($age_range as $key => $age_row) {
										$data_summary = $this->difficult_report_model->get_edoe_summary();
										//$data
										$intRow = 0;
										foreach ($data_summary as $row) {
											$intRow++;
											$data['summary'][] = array('list_name' => $age_row['name'],
																									'count_job_vacancy' => $row['count_job_vacancy'],
																									'count_job_reg_y' => $row['count_job_reg_y']+$intRow,
																									'count_job_reg_n' => $row['count_job_reg_n']+$intRow+2,
																									'count_job_reg_sum' => $row['count_job_reg_y']+$row['count_job_reg_n']
																									);
										}
								}

								$this->load->view('kpiorg_summary', $data);
					}
					//ข้อมูลรายการตามพื้นที่
					public function kpiorg_table_area() {
								$data = array();
								$this->load->model('difficult_report_model','difficult_report_model');
								$data['list_org'] = $this->difficult_report_model->get_kpiorg_table_area();
								$this->load->view('kpiorg_table_area', $data);
					}
					//ข้อมูลรายการ
					public function kpiorg_table($org_id='') {
								$data = array();
								$this->load->model('difficult_report_model','difficult_report_model');
								$data['list_info'][] = array(
																				'id'=>'1650400018562',
																				'name'=>'นายกฤษณะ ปัญญา',
																				'gender'=>'ชาย',
																				'age'=>'80',
																				'first_score'=>'80',
																				'first_kpi'=>'1',
																				'last_score'=>'90',
																				'last_kpi'=>'1'
																				);
								$data['list_info'][] = array(
																				'id'=>'1650400018562',
																				'name'=>'นายกฤษณะ ปัญญา',
																				'gender'=>'ชาย',
																				'age'=>'80',
																				'first_score'=>'80',
																				'first_kpi'=>'1',
																				'last_score'=>'70',
																				'last_kpi'=>'1'
																				);
									$data['list_info'][] = array(
																				'id'=>'1650400018562',
																				'name'=>'นายกฤษณะ ปัญญา',
																				'gender'=>'ชาย',
																				'age'=>'80',
																				'first_score'=>'80',
																				'first_kpi'=>'1',
																				'last_score'=>'',
																				'last_kpi'=>''
																				);
								//$data['list_info'] = $this->difficult_report_model->getAll_edoeInfo($org_id);
								$this->load->view('kpiorg_table', $data);
					}
					//แสดง checkbox จังหวัด
					public function kpiorg_map() {
								$this->load->model('difficult_report_model','difficult_report_model');
								$data['map_area'] = $this->difficult_report_model->get_area('10000000');
								$this->load->view('kpiorg_map', $data);
					}
					//แสดงจุดแผนที่
					public function kpiorg_xml_map($area_id=''){
									header("Content-type: text/xml; charset=utf-8");
									$this->load->model('difficult_report_model','difficult_report_model');

									$obj_area = $this->difficult_report_model->get_area($area_id);
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
													$str .= 'icon="'.site_url().'/assets/modules/difficult/images/pin-home.png" ';
													$str .= 'identify="'.site_url().'/difficult/kpiorg_identify/'.$area_id.'" />';
											}
										}
									$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
									echo $str;
					}
					//รายละเอียดแผนที่
					public function kpiorg_identify($area_id=''){
									$data_area = array();
									$this->load->model('difficult_report_model','difficult_report_model');
									$data_area = $this->difficult_report_model->get_area($area_id);
									$data_area = rowArray($data_area);
									$photo = site_url().'/assets/admin/images/noimage.gif';
									$data['info'] = array('area_id'=>$area_id,
																				'photo' => $photo,
																				'area_name' => $data_area['area_name']);
									$this->load->view('kpiorg_identify', $data);
					}

					// รายงานข้อมูลอาสาสมัครดูแลผู้สูงอายุ (อผส.)
					//ข้อมูลภาพรวม
					public function volt_summary() {
									$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
									$this->load->model('difficult_report_model','difficult_report_model');
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
										$res_of_req = $this->difficult_report_model->get_volt_summary($yyyy, $mm);

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
						$this->load->model('difficult_report_model','difficult_report_model');
						$data['list_area'] = $this->difficult_report_model->get_fnrl_table_area();
						$this->load->view('volt_table_area', $data);
					}
					//ข้อมูลรายการ
					public function volt_table($area_id='') {
						$data = array();
						$this->load->model('difficult_report_model','difficult_report_model');
						$data['list_info'] = $this->difficult_report_model->getAll_fnrlInfo($area_id);
						$this->load->view('volt_table', $data);
					}

					// รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
					//ข้อมูลภาพรวม
					public function stat_summary() {
						$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
						$this->load->model('difficult_report_model','difficult_report_model');
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
							$res_of_home = $this->difficult_report_model->get_impv_home_summary($yyyy, $mm);
							$list_budget_of_home[] = intval($res_of_home['pay_amount']);
							$res_of_place = $this->difficult_report_model->get_impv_place_summary($yyyy, $mm);
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

						$this->load->view('stat_summary', $data);
					}

}
