<?php
include_once("Report.php");
class Fnrl_report extends Report {

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
		$app_id = 86;
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

			//set_js_asset_head('highcharts.js','difficult');

			set_css_asset_head('report.css','report');
			set_js_asset_footer('index.js','report'); //Set JS Index.js


			$data['process_action'] = $process_action;
			$data['content_view'] = 'fnrl_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

		// รายงานผลการดำเนินงานการสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี
		//ข้อมูลภาพรวม
		public function fnrl_summary() {
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
				$res_of_req = $this->report_model->get_fnrl_summary($yyyy, $mm, 'date_of_req');
				$list_count_of_req[] = $res_of_req['count_info'];
				$res_of_pay = $this->report_model->get_fnrl_summary($yyyy, $mm, 'date_of_pay');
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
			$this->load->model('report_model','report_model');
			$data['list_area'] = $this->report_model->get_fnrl_table_area();
			$this->load->view('fnrl_table_area', $data);
		}
		//ข้อมูลรายการ
		public function fnrl_table($area_id='') {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->getAll_fnrlInfo($area_id);
			$this->load->view('fnrl_table', $data);
		}

		//แสดง checkbox จังหวัด
		public function fnrl_map() {
			$this->load->model('report_model','report_model');
			$data['map_area'] = $this->report_model->get_area();
			$this->load->view('fnrl_map', $data);
		}
		//แสดงจุดแผนที่
		public function fnrl_xml_map($area_id=''){
				header("Content-type: text/xml; charset=utf-8");
				$this->load->model('report_model','report_model');
				$data_area = $this->report_model->get_map_fnrl_info($area_id);
				$obj_area = $this->report_model->get_area($area_id);
				$count_of_req = (isset($data_area['count_of_req']))?$data_area['count_of_req']:0;

				$shape_opacity = '0.5';
				if($count_of_req > 500){
						$shape_color = '#EB1108';
				}else if($count_of_req > 250){
							$shape_color = '#E56F07';
				}else if($count_of_req > 50){
							$shape_color = '#E8D208';
				}else if($count_of_req > 1){
						$shape_color = '#61B761';
				}else{
						$shape_opacity = '0.1';
						$shape_color = '#00FF00';
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
								$str .= 'shape_color="'.$shape_color.'" ';
								$str .= 'shape_opacity="'.$shape_opacity.'" ';
								$str .= 'picture="picture" ';
								$str .= 'icon="'.site_url().'assets/modules/report/images/blank.png" ';
								$str .= 'identify="'.site_url().report_url().'fnrl_report/fnrl_identify/'.$area_id.'" />';
						}
					}
				$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
				echo $str;
			}
			//รายละเอียดแผนที่
			public function fnrl_identify($area_id=''){
				$data_area = array();
				$this->load->model('report_model','report_model');
				$data_area = $this->report_model->get_map_fnrl_info($area_id);
				$arr_get_area = $this->report_model->get_area($area_id);
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

}
