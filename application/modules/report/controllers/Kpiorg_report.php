<?php
include_once("Report.php");
class Kpiorg_report extends Report {

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
		$app_id = 85;
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
			$data['content_view'] = 'kpiorg_report';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page_report',$data,'report');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	// รายงานผลการดำเนินงานตามตัวชี้วัด ศูนย์พัฒนาการจัดสวัสดิการสังคมผู้สูงอายุ
	//ข้อมูลภาพรวม
	public function kpiorg_summary() {
			$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$this->load->model('report_model','report_model');
			$data = array();

			$age_range[] = array('age_min'=>'60', 'age_max'=>'70', 'name'=>'60-70 ปี');
			$age_range[] = array('age_min'=>'71', 'age_max'=>'80', 'name'=>'71-80 ปี');
			$age_range[] = array('age_min'=>'81', 'age_max'=>'90', 'name'=>'81-90 ปี');
			$age_range[] = array('age_min'=>'91', 'age_max'=>'120', 'name'=>'91 ปีขึ้นไป');
			$age_range[] = array('age_min'=>'0', 'age_max'=>'0', 'name'=>'ไม่ระบุ');
			foreach ($age_range as $key => $age_row) {
						$data_summary = $this->report_model->get_kpiorg_summary($age_row['age_min'], $age_row['age_max']);
						$data['summary'][] = array('list_name' => $age_row['name'],
																				'count_ma' => (isset($data_summary['count_ma']))?$data_summary['count_ma']:0,
																				'count_mb' => (isset($data_summary['count_mb']))?$data_summary['count_mb']:0,
																				'count_mc' => (isset($data_summary['count_mc']))?$data_summary['count_mc']:0,
																				'count_m_no' => (isset($data_summary['count_m_no']))?$data_summary['count_m_no']:0,
																				'count_fa' => (isset($data_summary['count_fa']))?$data_summary['count_fa']:0,
																				'count_fb' => (isset($data_summary['count_fb']))?$data_summary['count_fb']:0,
																				'count_fc' => (isset($data_summary['count_fc']))?$data_summary['count_fc']:0,
																				'count_f_no' => (isset($data_summary['count_f_no']))?$data_summary['count_f_no']:0
																				);

			}

			$this->load->view('kpiorg_summary', $data);
	}
	//ข้อมูลรายการตามพื้นที่
	public function kpiorg_table_area() {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_org'] = $this->report_model->get_kpiorg_table_area();
			$this->load->view('kpiorg_table_area', $data);
	}
	//ข้อมูลรายการ
	public function kpiorg_table($org_id='') {
			$data = array();
			$this->load->model('report_model','report_model');
			$data['list_info'] = $this->report_model->get_kpiorg_table($org_id);
			$this->load->view('kpiorg_table', $data);
	}
	//แสดง checkbox จังหวัด
	public function kpiorg_map() {
			$this->load->model('report_model','report_model');
			$data['map_area'] = $this->report_model->get_area('10000000');
			$this->load->view('kpiorg_map', $data);
	}
	//แสดงจุดแผนที่
	public function kpiorg_xml_map($area_id=''){
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
									$str .= 'icon="'.site_url().'assets/modules/report/images/pin-home.png" ';
									$str .= 'identify="'.site_url().report_url().'kpiorg_report/kpiorg_identify/'.$area_id.'" />';
							}
				}
				$str .= "</markers>";//site_url('difficult/service_identify/'.$area_id)
				echo $str;
	}
	//รายละเอียดแผนที่
	public function kpiorg_identify($area_id=''){
				$data_area = array();
				$this->load->model('report_model','report_model');
				$data_area = $this->report_model->get_area($area_id);
				$data_area = rowArray($data_area);
				$photo = site_url().'/assets/admin/images/noimage.gif';
				$data['info'] = array('area_id'=>$area_id,
															'photo' => $photo,
															'area_name' => $data_area['area_name']);
				$this->load->view('kpiorg_identify', $data);
	}

}
