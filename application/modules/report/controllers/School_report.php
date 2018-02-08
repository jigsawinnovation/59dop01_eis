<?php
include_once("Report.php");
class School_report extends Report {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function index() { // รายงานข้อมูลโรงเรียนผู้สูงอายุ
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 92;
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
			$data['content_view'] = 'school_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานข้อมูลโรงเรียนผู้สูงอายุ
	//ข้อมูลภาพรวม
	public function school_summary() {

		$this->load->model('report_model','report_model');
		$data = array();
		$arr_data = $this->report_model->get_school_summary();
		foreach ($arr_data as $row) {
				$data['summary'][] = array('year'=>$row['year']+543,
																	'count_school' => $row['count_school'],
																	'count_gen' => $row['count_gen'],
																	'count_pers' => $row['count_pers']);
		}
		$this->load->view('school_summary', $data);

	}
	//ข้อมูลรายการตามพื้นที่
	public function school_table_area() {
		$data = array();
		$this->load->model('report_model','report_model');
		$data['list_area'] = $this->report_model->get_school_table_area();
		$this->load->view('school_table_area', $data);
	}
	//ข้อมูลรายการ
	public function school_table($area_id='') {
		$data = array();
		$this->load->model('report_model','report_model');
		$data['list_info'] = $this->report_model->get_school_table($area_id);
		$this->load->view('school_table', $data);
	}
	//
	public function school_table_search() {
		$quick_search = $this->input->get('quick_search');
		$data_search = array();
		$data_search['quick_search'] = $quick_search;
		$data = array();
		$this->load->model('report_model','report_model');
		$data['list_info'] = $this->report_model->getAll_diffInfo($data_search);
		$this->load->view('school_table_search', $data);
	}
	//แสดง checkbox จังหวัด
	public function school_map() {
		$this->load->model('report_model','report_model');
		$data['map_area'] = $this->report_model->get_area();
		$this->load->view('school_map', $data);
	}
	//แสดงจุดแผนที่
	public function school_xml_map($area_id=''){

			header("Content-type: text/xml; charset=utf-8");
			$this->load->model('report_model','report_model');
			$data_area = $this->report_model->get_school_map_info($area_id);
			$obj_area = $this->report_model->get_area($area_id);
			$count_of_req = (isset($data_area['count_school']))?$data_area['count_school']:0;

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
							$str .= 'identify="'.site_url().report_url().'school_report/school_identify/'.$area_id.'" />';
					}
				}
			$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
			echo $str;
		}
		//รายละเอียดแผนที่
		public function school_identify($area_id=''){
			$data_area = array();
			$this->load->model('report_model','report_model');
			$data_area = $this->report_model->get_school_map_info($area_id);
			$arr_get_area = $this->report_model->get_area($area_id);
			$get_area = $arr_get_area[0];

			$count_school = (isset($data_area['count_school']))?$data_area['count_school']:0;
			$count_gen = (isset($data_area['count_gen']))?$data_area['count_gen']:0;
			$count_pers = (isset($data_area['count_pers']))?$data_area['count_pers']:0;

			$data['info'] = array('area_id'=>$area_id,
														'area_name' => $get_area['area_name'],
														'count_school' => $count_school,
														'count_gen' => $count_gen,
														'count_pers' => $count_pers);

			$this->load->view('school_identify', $data);
		}

}
