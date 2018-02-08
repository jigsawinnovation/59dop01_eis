<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personals extends MX_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->database();
		
		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

/*	function index() {

	}
*/

	public function getPersonalInfo() {
		$pid = get_inpost('pid');
		$arr = array();
		if(chkUserLogin() && $pid!='') {
			$this->load->model(array('personal_model'));
			$tmp = $this->personal_model->getOnce_PersonalInfo_byCode($pid);
			if(isset($tmp['pid'])) {
				$tmp['reg_addr'] = array();
				if($tmp['reg_addr_id']!='') {
					$tmp1 = $this->personal_model->getOnce_PersonalAddress($tmp['reg_addr_id']);
					if(isset($tmp1['addr_id'])) {
						$tmp['reg_addr'] = $tmp1;
					}
				}

        if($tmp['date_of_birth']!='') {
          $date = new DateTime($tmp['date_of_birth']);
          $now = new DateTime();
          $interval = $now->diff($date);
          $age = $interval->y;
          $tmp['date_of_birth'] = formatDateThai($tmp['date_of_birth']).' (อายุ '.$age.' ปี)';
        }

			}
			$arr = $tmp;
		}
		echo json_encode($arr);
	}

	public function get_Area_option(){
		$code = get_inpost('code');
		$type = get_inpost('type');
		// dieArray($_POST);
		if($type == 'Amphur'){
			$subCode = substr($code,0,2);
		}else if($type == 'Tambon'){
			$subCode = substr($code,0,4);
		}
		
		$opRows = $this->common_model->custom_query("
			SELECT area_code,area_name_th FROM std_area 
			WHERE area_type = '{$type}' 
			AND area_code LIKE '{$subCode}%'
			AND area_name_th NOT LIKE '%*'
			ORDER BY area_code ASC
		");

		echo json_encode($opRows);
		// dieArray($opRows);
	}

	public function getLane($code=''){
		$subCode = substr($code,0,2);
		$rows = $this->common_model->custom_query("SELECT lane_code AS id , lane_name AS 'text' FROM std_lane WHERE lane_code LIKE '{$subCode}%' AND lane_name LIKE '%{$_GET['q']}%' AND lane_name NOT LIKE '%*'");
		echo json_encode($rows);
	}

	public function getRoad($code=''){
		$subCode = substr($code,0,2);
		$rows = $this->common_model->custom_query("SELECT road_code AS id , road_name AS 'text' FROM std_road WHERE road_code LIKE '{$subCode}%' AND road_name LIKE '%{$_GET['q']}%' AND road_name NOT LIKE '%*'");
		echo json_encode($rows);
	}


}