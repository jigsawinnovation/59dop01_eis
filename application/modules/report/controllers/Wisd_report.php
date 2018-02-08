<?php
include_once("Report.php");
class Wisd_report extends Report {

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
		$app_id = 88;
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
			$data['content_view'] = 'wisd_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานข้อมูลคลังปัญญาผู้สูงอายุ
	//ข้อมูลภาพรวม
	public function wisd_summary() {
			$this->load->model('report_model','report_model');
			$data_branch = $this->report_model->get_wisd_summary();
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
			$this->load->model('report_model','report_model');
			$data['list_area'] = $this->report_model->get_wisd_table_area();
			$this->load->view('wisd_table_area', $data);
	}
	//ข้อมูลรายการ
	public function wisd_table($area_id='') {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->getAll_wisdInfo($area_id);
			$this->load->view('wisd_table', $data);
	}
	//
	public function wisd_table_search() {
			$quick_search = $this->input->get('quick_search');
			$data_search = array();
			$data_search['quick_search'] = $quick_search;
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->getAll_diffInfo($data_search);
			$this->load->view('service_table_search', $data);
	}
	//แสดง checkbox จังหวัด
	public function wisd_map() {
			$this->load->model('report_model','report_model');
			$data['map_area'] = $this->report_model->get_area('10000000');
			$this->load->view('wisd_map', $data);
	}
	//แสดงจุดแผนที่
	public function wisd_xml_map($area_id=''){

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
								$str .= 'icon="'.site_url().'assets/modules/report/images/mapmark.png" ';
								$str .= 'identify="'.site_url().report_url().'wisd_report/wisd_identify/'.$area_id.'" />';
						}
					}
			}
			$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
			echo $str;
	}
	//รายละเอียดแผนที่
	public function wisd_identify($area_id=''){
			$data_area = array();
			$this->load->model('report_model','report_model');
			$data_area = $this->report_model->get_map_impv_info($area_id);
			$data_photo = $this->report_model->get_map_impv_photo($area_id);
			/*if($data_photo['photo_file']){
						$photo = site_url().'/'.$data_photo['photo_file'];
			}else{
						$photo = '';
			}*/
			$photo = site_url().'assets/modules/report/images/no_image.png';
			//noimage.gif
			$name = $data_area['pers_firstname_th'].' '.$data_area['pers_lastname_th'];
			$data['info'] = array('area_id'=>$area_id,
														'pers_info_name' => $name,
														'area_name' => $data_area['area_name_th'],
														'photo' => $photo,
														'case_budget' => $data_area['case_budget']);
			$this->load->view('wisd_identify', $data);
	}

}
