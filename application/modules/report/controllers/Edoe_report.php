<?php
include_once("Report.php");
class Edoe_report extends Report {

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
		$app_id = 93;
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
			$data['content_view'] = 'edoe_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานข้อมูลส่งเสริมการจ้างงานผู้สูงอายุ
	//ข้อมูลภาพรวม
	public function edoe_summary() {
			$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$this->load->model('report_model','report_model');
			$data = array();

			$data_summary = $this->report_model->get_edoe_summary();
			//$data
			foreach ($data_summary as $row) {
					$list_budget_year[] = $row['budget_year'];
					$list_count_job_vacancy[] = $row['count_job_vacancy'];
					$list_count_job_reg_y[] = $row['count_job_reg_y'];
					$list_ccount_job_reg_n[] = $row['count_job_reg_n'];
					$data['summary'][] = array( 'budget_year' => $row['budget_year'],
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
			$this->load->model('report_model','report_model');
			$data['list_area'] = $this->report_model->get_edoe_table_area();
			$this->load->view('edoe_table_area', $data);
	}
	//ข้อมูลรายการ
	public function edoe_table($area_id) {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->getAll_edoeInfo($area_id);
			$this->load->view('edoe_table', $data);
	}
	//
	public function edoe_table_search() {
			$quick_search = $this->input->get('quick_search');
			$data_search = array();
			$data_search['quick_search'] = $quick_search;
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->getAll_diffInfo($data_search);
			$this->load->view('service_table_search', $data);
	}
	//แสดง checkbox จังหวัด
	public function edoe_map() {
			$this->load->model('report_model','report_model');
			$data['map_area'] = $this->report_model->get_area();
			$this->load->view('edoe_map', $data);
	}
	//แสดงจุดแผนที่
	public function edoe_xml_map($area_id=''){

			header("Content-type: text/xml; charset=utf-8");
			$this->load->model('report_model','report_model');
			$data_area = $this->report_model->get_map_edoe_info($area_id);
			$obj_area = $this->report_model->get_area($area_id);
			$count_of_req = (isset($data_area['count_org']))?$data_area['count_org']:0;

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
							$str .= 'identify="'.site_url().report_url().'edoe_report/edoe_identify/'.$area_id.'" />';
						}
			}
			$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
			echo $str;
	}
	//รายละเอียดแผนที่
	public function edoe_identify($area_id=''){
			$data_area = array();
			$this->load->model('report_model','report_model');
			$data_area = $this->report_model->get_map_edoe_info($area_id);
			$arr_get_area = $this->report_model->get_area($area_id);
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

}
