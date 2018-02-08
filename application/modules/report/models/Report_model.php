<?php
	class Report_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

				#ข้อมูลที่อยู่
				public function getStdArea($id=''){

						if($id != ''){
							if($id!='NULL'){
								$sql = "SELECT area_name_th FROM std_area WHERE area_code='".$id."' ";
								$res = $this->common_model->custom_query($sql);
								$row = rowArray($res);
								$area_name_th = (isset($row['area_name_th']))?$row['area_name_th']:'';
								return $area_name_th;
							}else{
								return 'ไม่ระบุ';
							}
						}else{
							return 'ไม่ระบุ';
						}
				}

				public function getAddress($addr_id=''){
						$sql = "SELECT * FROM pers_addr WHERE addr_id='".$addr_id."' ";
						$res = $this->common_model->custom_query($sql);
						$row = rowArray($res);
						$str_addr = '';
						if($row){
							if($row['addr_sub_district']){
								$str_addr .= ' อ.'.$this->getStdArea($row['addr_district']);
							}
							if($row['addr_sub_district']){
								$str_addr .= ' จ.'.$this->getStdArea($row['addr_province']);
							}
							/*if($row['addr_zipcode']){
								$str_addr .= ' '.$row['addr_zipcode'];
							}*/
						}
						return $str_addr;
				}

				//ข้อมูลภาพรวม รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
				public function get_summary($yyyy='',$mm='', $type='')
		    {
					if($type == 'date_of_req'){
							$where = " WHERE diff_info.date_of_req LIKE('".$yyyy."-".$mm."%') ";
					}else if($type == 'date_of_visit'){
							$where = " WHERE diff_info.date_of_visit LIKE('".$yyyy."-".$mm."%') ";
					}else if($type == 'date_of_pay'){
							$where = " WHERE diff_info.date_of_pay LIKE('".$yyyy."-".$mm."%') ";
					}else{
							$where = '';
					}
					$sql = " SELECT COUNT(pers_info.pers_id) as count_diff_info,
										SUM(diff_info.pay_amount) AS pay_amount
									FROM diff_info
									JOIN pers_info
									ON diff_info.pers_id = pers_info.pers_id
									".$where."
								";
					//echo $sql."<br/>";
					$result = $this->common_model->custom_query($sql);
					return rowArray($result);
	      }

				#ข้อมูล รายการผู้สูงอายุที่อยู่ในภาวะยากลำบาก
				public function getAll_diffInfo($area_id='',$data_search=array()) {
						$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
						$quick_search = '';
						if(isset($data_search['diff_id'])){
							$diff_id = $data_search['diff_id'];
						}else{
							$diff_id = '';
						}
						if(isset($data_search['quick_search'])){
							$quick_search = $data_search['quick_search'];
						}else{
							$quick_search = '';
						}

						$sql_where = '';
						if($diff_id != ''){
							$sql_where .= " AND A.diff_id='".$diff_id."' ";
						}else{
							$sql_where .= '';
						}
						if($area_id == 'NULL'){
								$sql_where .= ' AND pers_addr.addr_province IS NULL ';
						}else if($area_id != ''){
								$sql_where .= " AND pers_addr.addr_province LIKE('".$area_id."%') ";
						}else{
								$sql_where .= ' AND pers_addr.addr_province IS NULL ';
						}
						if($quick_search != ''){
							$sql_where .= " AND ( B.pid LIKE('%".$quick_search."%')
																	OR B.pers_firstname_th LIKE('%".$quick_search."%')
																	OR B.pers_lastname_th LIKE('%".$quick_search."%') ) ";
						}
						$sql_diff = "SELECT A.diff_id,B.pid,
																											C.prename_th AS prename,
																											B.pers_firstname_th AS firstname,
																											B.pers_lastname_th AS lastname,
																											TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) AS age,
																											B.pre_addr_id,
																											A.visit_place,
																											A.visit_place_identify,
																										A.date_of_req,
																										A.date_of_visit,
																										A.date_of_pay AS date_of_help,
																										A.pay_amount
																										FROM diff_info A LEFT OUTER JOIN pers_info B ON A.pers_id = B.pers_id
																										LEFT JOIN std_prename C ON B.pren_code = C.pren_code
																										LEFT JOIN pers_addr ON B.pre_addr_id = pers_addr.addr_id
																										WHERE A.pers_id IS NOT NULL
																										".$sql_where."
																										GROUP BY A.diff_id
																										ORDER BY A.insert_datetime DESC, A.update_datetime DESC";
						//echo $sql_diff;
						$res_diff = $this->common_model->custom_query($sql_diff);
						$diffInfo = array();
						foreach ($res_diff as $row_diff) {
									$name = $row_diff['prename'].$row_diff['firstname'].' '.$row_diff['lastname'];
									if($row_diff['date_of_req'] != '' && $row_diff['date_of_req'] != '0000-00-00'){
										$arr_date_of_req = explode('-',$row_diff['date_of_req']);
										$year = substr(($arr_date_of_req[0]+543),-2);
										$date_of_req = $arr_date_of_req[2].' '.$arr_month[intval($arr_date_of_req[1])].' '.$year;
									}else{
										$date_of_req = '';
									}
									if($row_diff['date_of_visit'] != '' && $row_diff['date_of_visit'] != '0000-00-00'){
										$arr_date_of_visit = explode('-',$row_diff['date_of_visit']);
										$year = substr(($arr_date_of_visit[0]+543),-2);
										$date_of_visit = $arr_date_of_visit[2].' '.$arr_month[intval($arr_date_of_visit[1])].' '.$year;
									}else{
										$date_of_visit = '';
									}
									if($row_diff['date_of_help'] != '' && $row_diff['date_of_help'] != '0000-00-00'){
										$arr_date_of_help = explode('-',$row_diff['date_of_help']);
										$year = substr(($arr_date_of_help[0]+543),-2);
										$date_of_help = $arr_date_of_help[2].' '.$arr_month[intval($arr_date_of_help[1])].' '.$year;
									}else{
										$date_of_help = '';
									}
									$diffInfo[] = array(
																			'id'=>$row_diff['diff_id'],
																			'id_card'=>$row_diff['pid'],
																			'name'=>$name,
																			'age'=>$row_diff['age'],
																			'date_of_req'=>$date_of_req,
																			'date_of_visit'=>$date_of_visit,
																			'date_of_help'=>$date_of_help,
																			'visit_place'=>$row_diff['visit_place'],
																			'visit_place_identify'=>$row_diff['visit_place_identify'],
																			'pay_amount'=>$row_diff['pay_amount']
																		);
						}
						if($diff_id != ''){
							return rowArray($diffInfo);
						}else{
							return $diffInfo;
						}
			}

			#ข้อมูล
			public function get_service_table_area() {

					$sql = "SELECT
									A.pers_id AS id,
									B.pid,
									B.pre_addr_id,
									IF(pers_addr.addr_province IS NOT NULL OR pers_addr.addr_province='',pers_addr.addr_province,'NULL')  AS area_id,
									SUM(IF(B.gender_code=1,1,0)) AS count_m,
									SUM(IF(B.gender_code=2,1,0)) AS count_f,
									COUNT(A.diff_id) AS count_diff,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name
									FROM diff_info AS A
									LEFT JOIN pers_info AS B
									ON A.pers_id = B.pers_id
									LEFT JOIN std_prename AS C
									ON B.pren_code = C.pren_code
									LEFT JOIN pers_addr
									ON B.pre_addr_id = pers_addr.addr_id
									LEFT JOIN std_area
									ON std_area.area_code = pers_addr.addr_province
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC ";
					$res = $this->common_model->custom_query($sql);
					foreach ($res as $row) {
								$area_name = $this->getStdArea($row['area_id']);
								$dataArea[] = array('area_id' => $row['area_id'],
																		'area_name' => $row['area_name'],
																		'count_m' => $row['count_m'],
																		'count_f' => $row['count_f'],
																		'count_diff' => $row['count_diff']
																	);
					}
					return $dataArea;
			}

			public function get_area($area_id='')
	    {
				if($area_id != ''){
	          $where_area = " AND std_area.area_code='".$area_id."'";
	      }else{
	          $where_area = "";
	      }
	      $sql_area = " SELECT std_area.area_code AS area_id,std_area.area_name_th AS area_name,
											std_area.latitude, std_area.longitude, std_area.g_shape, std_area.area_type
	                  FROM std_area
	                  WHERE std_area.area_type='Province'
										".$where_area."
	                  ORDER BY std_area.area_code ASC ";
	      $result = $this->common_model->custom_query($sql_area);
	      return $result;
	    }

			#ข้อมูลแผนที่ รายการผู้สูงอายุที่อยู่ในภาวะยากลำบาก
			public function get_map_info($area_id = '')
	    {
				if($area_id != ''){
						$where = " WHERE pers_addr.addr_province LIKE('".$area_id."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT
									COUNT(diff_info.date_of_req) AS count_of_req,
									COUNT(diff_info.date_of_visit) AS count_of_visit,
									COUNT(diff_info.date_of_pay) AS count_of_pay,
									SUM(diff_info.pay_amount) AS pay_amount,
									pers_addr.addr_province AS area_id,
									std_area.area_name_th AS area_name
									FROM diff_info
									JOIN pers_info ON diff_info.pers_id = pers_info.pers_id
									JOIN pers_addr ON pers_info.pre_addr_id = pers_addr.addr_id
									JOIN std_area ON pers_addr.addr_province = std_area.area_code
									".$where."
									GROUP BY pers_addr.addr_province
								";
				//echo $sql."<br/>";
				$result = array();
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
      }

			//ข้อมูลภาพรวม รายงานผลการดำเนินงานการสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี
			public function get_fnrl_summary($yyyy='',$mm='', $type='')
			{
				if($type == 'date_of_req'){
						$where = " WHERE fnrl_info.date_of_req LIKE('".$yyyy."-".$mm."%') ";
				}else if($type == 'date_of_pay'){
						$where = " WHERE fnrl_info.date_of_pay LIKE('".$yyyy."-".$mm."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT COUNT(pers_info.pers_id) as count_info,
									SUM(fnrl_info.pay_amount) AS pay_amount
								FROM fnrl_info
								JOIN pers_info
								ON fnrl_info.req_pers_id = pers_info.pers_id
								".$where."
							";
				//echo $sql."<br/>";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			#ข้อมูล รายงานผลการดำเนินงานการสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี
			public function getAll_fnrlInfo($area_id='') {
					$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
					$sql_where = '';
					if($area_id == 'NULL'){
							$sql_where .= ' AND pers_addr.addr_province IS NULL ';
					}else if($area_id != ''){
							$sql_where .= " AND pers_addr.addr_province LIKE('".$area_id."%') ";
					}else{
							$sql_where .= ' AND pers_addr.addr_province IS NULL ';
					}
					$sql = "SELECT A.req_pers_id AS id,B.pid,
																										C.prename_th AS prename,
																										B.pers_firstname_th AS firstname,
																										B.pers_lastname_th AS lastname,
																										TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) AS age,
																										B.pre_addr_id,
																									A.date_of_req,
																									A.date_of_pay AS date_of_help,
																									A.pay_amount
																									FROM fnrl_info A
																									LEFT OUTER JOIN pers_info B
																									ON A.pers_id = B.pers_id
																									LEFT JOIN pers_addr
																									ON B.pre_addr_id = pers_addr.addr_id
																									LEFT OUTER JOIN std_prename C
																									ON B.pren_code = C.pren_code
																									WHERE A.req_pers_id IS NOT NULL
																									".$sql_where."
																									ORDER BY A.insert_datetime DESC, A.update_datetime DESC";
					//echo $sql;
					$res = $this->common_model->custom_query($sql);
					$dataInfo = array();
					foreach ($res as $row) {
								$name = $row['prename'].$row['firstname'].' '.$row['lastname'];
								if($row['date_of_req'] != '' && $row['date_of_req'] != '0000-00-00'){
									$arr_date_of_req = explode('-',$row['date_of_req']);
									$year = substr(($arr_date_of_req[0]+543),-2);
									$date_of_req = $arr_date_of_req[2].' '.$arr_month[intval($arr_date_of_req[1])].' '.$year;
								}else{
									$date_of_req = '';
								}

								if($row['date_of_help'] != '' && $row['date_of_help'] != '0000-00-00'){
									$arr_date_of_help = explode('-',$row['date_of_help']);
									$year = substr(($arr_date_of_help[0]+543),-2);
									$date_of_help = $arr_date_of_help[2].' '.$arr_month[intval($arr_date_of_help[1])].' '.$year;
								}else{
									$date_of_help = '';
								}
								$dataInfo[] = array(
																		'id'=>$row['id'],
																		'id_card'=>$row['pid'],
																		'name'=>$name,
																		'age'=>$row['age'],
																		'date_of_req'=>$date_of_req,
																		'date_of_help'=>$date_of_help,
																		'pay_amount'=>$row['pay_amount']
																	);
					}

					return $dataInfo;

			}

			#ข้อมูล
			public function get_fnrl_table_area() {

					$sql = "SELECT
									A.pers_id AS id,
									B.pid,
									B.pre_addr_id,
									IF(pers_addr.addr_province IS NOT NULL,pers_addr.addr_province,'NULL')  AS area_id,
									SUM(IF(B.gender_code=1,1,0)) AS count_m,
									SUM(IF(B.gender_code=2,1,0)) AS count_f,
									COUNT(A.fnrl_id) AS count_fnrl,
									A.pay_amount AS pay_amount,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name
									FROM fnrl_info AS A
									LEFT JOIN pers_info AS B
									ON A.pers_id = B.pers_id
									LEFT JOIN std_prename AS C
									ON B.pren_code = C.pren_code
									LEFT JOIN pers_addr
									ON B.pre_addr_id = pers_addr.addr_id
									LEFT JOIN std_area
									ON std_area.area_code = pers_addr.addr_province
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC ";
					$res = $this->common_model->custom_query($sql);
					foreach ($res as $row) {
								$area_name = $this->getStdArea($row['area_id']);
								$dataArea[] = array('area_id' => $row['area_id'],
																		'area_name' => $row['area_name'],
																		'count_m' => $row['count_m'],
																		'count_f' => $row['count_f'],
																		'count_fnrl' => $row['count_fnrl'],
																		'pay_amount' => $row['pay_amount']
																	);
					}
					return $dataArea;
			}

			#ข้อมูลแผนที่ รายงานผลการดำเนินงานการสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี
			public function get_map_fnrl_info($area_id = '')
			{
				if($area_id != ''){
						$where = " WHERE pers_addr.addr_province LIKE('".$area_id."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT
									COUNT(fnrl_info.date_of_req) AS count_of_req,
									COUNT(fnrl_info.date_of_pay) AS count_of_pay,
									SUM(fnrl_info.pay_amount) AS pay_amount,
									pers_addr.addr_province AS area_id,
									std_area.area_name_th AS area_name
									FROM fnrl_info
									JOIN pers_info ON fnrl_info.req_pers_id = pers_info.pers_id
									JOIN pers_addr ON pers_info.pre_addr_id = pers_addr.addr_id
									JOIN std_area ON pers_addr.addr_province = std_area.area_code
									".$where."
									GROUP BY pers_addr.addr_province
								";
				//echo $sql."<br/>";
				$result = array();
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			//ข้อมูลภาพรวม รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
			//ปรับปรุงบ้าน
			public function get_impv_home_summary($yyyy='',$mm='')
			{
				if($yyyy != '' && $mm != ''){
						$where = " WHERE impv_home_info.date_of_finish LIKE('".$yyyy."-".$mm."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT COUNT(pers_info.pers_id) as count_info,
									SUM(impv_home_info.case_budget) AS pay_amount
								FROM impv_home_info
								JOIN pers_info
								ON impv_home_info.pers_id = pers_info.pers_id
								".$where."
							";
				//echo $sql."<br/>";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}
			//ปรับปรุงสถานที่ฯ
			public function get_impv_place_summary($yyyy='',$mm='')
			{
				if($yyyy != '' && $mm != ''){
						$where = " WHERE impv_place_info.date_of_finish LIKE('".$yyyy."-".$mm."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT COUNT(pers_info.pers_id) as count_info,
									SUM(impv_place_info.case_budget) AS pay_amount
								FROM impv_place_info
								JOIN pers_info
								ON impv_place_info.pers_id = pers_info.pers_id
								".$where."
							";
				//echo $sql."<br/>";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}
			#ข้อมูล รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
			public function getAll_impvInfo($area_id='') {
					$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
					$sql_where = '';
					if($area_id == 'NULL'){
							$sql_where .= ' AND pers_addr.addr_province IS NULL ';
					}else if($area_id != ''){
							$sql_where .= " AND pers_addr.addr_province LIKE('".$area_id."%') ";
					}else{
							$sql_where .= ' AND pers_addr.addr_province IS NULL ';
					}
					$sql = "SELECT A.pers_id AS id,B.pid,
																										C.prename_th AS prename,
																										B.pers_firstname_th AS firstname,
																										B.pers_lastname_th AS lastname,
																										TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) AS age,
																										B.pre_addr_id,
																									A.date_of_finish,
																									A.consi_result,
																									A.case_budget
																									FROM impv_home_info A
																									LEFT OUTER JOIN pers_info B ON A.pers_id = B.pers_id
																									LEFT OUTER JOIN std_prename C ON B.pren_code = C.pren_code
																									LEFT JOIN pers_addr
																									ON B.pre_addr_id = pers_addr.addr_id
																									WHERE A.pers_id IS NOT NULL
																									".$sql_where."
																									ORDER BY A.insert_datetime DESC, A.update_datetime DESC";
					$res = $this->common_model->custom_query($sql);

					$sql2 = "SELECT A.pers_id AS id,B.pid,
																										C.prename_th AS prename,
																										B.pers_firstname_th AS firstname,
																										B.pers_lastname_th AS lastname,
																										TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) AS age,
																										B.pre_addr_id,
																									A.date_of_finish,
																									A.consi_result,
																									A.case_budget
																									FROM impv_place_info A
																									LEFT OUTER JOIN pers_info B ON A.pers_id = B.pers_id
																									LEFT OUTER JOIN std_prename C ON B.pren_code = C.pren_code
																									LEFT JOIN pers_addr
	 																								ON B.pre_addr_id = pers_addr.addr_id
																									WHERE A.pers_id IS NOT NULL
																									".$sql_where."
																									ORDER BY A.insert_datetime DESC, A.update_datetime DESC";
					$res2 = $this->common_model->custom_query($sql2);
					//home
					foreach ($res as $row) {
								$name = $row['prename'].$row['firstname'].' '.$row['lastname'];
								if($row['date_of_finish'] != '' && $row['date_of_finish'] != '0000-00-00'){
									$arr_date_of_finish = explode('-',$row['date_of_finish']);
									$year = substr(($arr_date_of_finish[0]+543),-2);
									$date_of_finish = $arr_date_of_finish[2].' '.$arr_month[intval($arr_date_of_finish[1])].' '.$year;
								}else{
									$date_of_finish = '';
								}
								$dataInfo[] = array('id'=>$row['id'],
																		'id_card'=>$row['pid'],
																		'name'=>$name,
																		'age'=>$row['age'],
																		'date_of_finish'=>$date_of_finish,
																		'consi_result'=>$row['consi_result'],
																		'case_budget'=>$row['case_budget']
																	);
					}
					//place
					foreach ($res2 as $row) {
								$name = $row['prename'].$row['firstname'].' '.$row['lastname'];
								if($row['date_of_finish'] != '' && $row['date_of_finish'] != '0000-00-00'){
									$arr_date_of_finish = explode('-',$row['date_of_finish']);
									$year = substr(($arr_date_of_finish[0]+543),-2);
									$date_of_finish = $arr_date_of_finish[2].' '.$arr_month[intval($arr_date_of_finish[1])].' '.$year;
								}else{
									$date_of_finish = '';
								}
								$dataInfo[] = array('id'=>$row['id'],
																		'id_card'=>$row['pid'],
																		'name'=>$name,
																		'age'=>$row['age'],
																		'date_of_finish'=>$date_of_finish,
																		'consi_result'=>$row['consi_result'],
																		'case_budget'=>$row['case_budget']
																	);
					}
					//echo $sql."<br/>";
					//echo $sql2."<br/>";
					return $dataInfo;

			}
			#ข้อมูล
			public function get_impv_table_area() {

					$sql_home = "SELECT
									A.pers_id AS id,
									B.pid,
									B.pre_addr_id,
									IF(pers_addr.addr_province IS NOT NULL,pers_addr.addr_province,'NULL')  AS area_id,
									SUM(IF(B.gender_code=1,1,0)) AS count_m,
									SUM(IF(B.gender_code=2,1,0)) AS count_f,
									COUNT(A.imp_home_id) AS count_impv,
									SUM(IF(A.consi_result='อนุมัติ',A.case_budget,0)) AS pay_amount,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name
									FROM impv_home_info AS A
									LEFT JOIN pers_info AS B
									ON A.pers_id = B.pers_id
									LEFT JOIN std_prename AS C
									ON B.pren_code = C.pren_code
									LEFT JOIN pers_addr
									ON B.pre_addr_id = pers_addr.addr_id
									LEFT JOIN std_area
									ON std_area.area_code = pers_addr.addr_province
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC ";
					$res = $this->common_model->custom_query($sql_home);
					foreach ($res as $row) {
								$area_name = $this->getStdArea($row['area_id']);
								$dataArea[$row['area_id']]['area_id'] = $row['area_id'];
								$dataArea[$row['area_id']]['area_name'] = $row['area_name'];
								@$dataArea[$row['area_id']]['count_m'] = $dataArea[$row['area_id']]['count_m']+$row['count_m'];
								@$dataArea[$row['area_id']]['count_f'] = $dataArea[$row['area_id']]['count_f']+$row['count_f'];
								@$dataArea[$row['area_id']]['count_impv'] = $dataArea[$row['area_id']]['count_impv']+$row['count_impv'];
								@$dataArea[$row['area_id']]['pay_amount'] = $dataArea[$row['area_id']]['pay_amount']+$row['pay_amount'];
					}

					$sql_place = "SELECT
									A.pers_id AS id,
									B.pid,
									B.pre_addr_id,
									IF(pers_addr.addr_province IS NOT NULL,pers_addr.addr_province,'NULL')  AS area_id,
									SUM(IF(B.gender_code=1,1,0)) AS count_m,
									SUM(IF(B.gender_code=2,1,0)) AS count_f,
									COUNT(A.impv_place_id) AS count_impv,
									SUM(IF(A.consi_result='อนุมัติ',A.case_budget,0)) AS pay_amount,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name
									FROM impv_place_info AS A
									LEFT JOIN pers_info AS B
									ON A.pers_id = B.pers_id
									LEFT JOIN std_prename AS C
									ON B.pren_code = C.pren_code
									LEFT JOIN pers_addr
									ON B.pre_addr_id = pers_addr.addr_id
									LEFT JOIN std_area
									ON std_area.area_code = pers_addr.addr_province
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC";
					$res = $this->common_model->custom_query($sql_place);
					foreach ($res as $row) {
								$area_name = $this->getStdArea($row['area_id']);
								$dataArea[$row['area_id']]['area_id'] = $row['area_id'];
								$dataArea[$row['area_id']]['area_name'] = $row['area_name'];
								@$dataArea[$row['area_id']]['count_m'] = $dataArea[$row['area_id']]['count_m']+$row['count_m'];
								@$dataArea[$row['area_id']]['count_f'] = $dataArea[$row['area_id']]['count_f']+$row['count_f'];
								@$dataArea[$row['area_id']]['count_impv'] = $dataArea[$row['area_id']]['count_impv']+$row['count_impv'];
								@$dataArea[$row['area_id']]['pay_amount'] = $dataArea[$row['area_id']]['pay_amount']+$row['pay_amount'];
					}
					/*echo "<pre>";
					print_r($dataArea);
					echo "</pre>";*/
					return $dataArea;
			}
			#ข้อมูลแผนที่ รายงานผลการดำเนินงานปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกที่เอื้อเฟื้อต่อคนทุกวัย
			public function get_map_impv_point($area_id = '')
			{
				$sql = " SELECT
									pers_addr.addr_province AS area_id,
									pers_info.pers_firstname_th AS area_name,
									pers_addr.addr_gps,
									pers_addr.addr_id,
									impv_home_info.imp_home_id
									FROM
									impv_home_info
									JOIN pers_info
									ON impv_home_info.pers_id = pers_info.pers_id
									JOIN pers_addr
									ON pers_info.pre_addr_id = pers_addr.addr_id
									JOIN std_area
									ON pers_addr.addr_province = std_area.area_code
								";
				//echo $sql."<br/>";
				$result = array();
				$result = $this->common_model->custom_query($sql);
				return $result;
			}

			public function get_map_impv_info($area_id = '')
			{
				$sql = " SELECT
									pers_addr.addr_province AS area_id,
									pers_addr.addr_gps,
									pers_addr.addr_id,
									impv_home_info.imp_home_id,
									pers_info.pren_code,
									pers_info.pers_firstname_th,
									pers_info.pers_lastname_th,
									impv_home_info.case_budget,
									std_area.area_name_th
									FROM
									impv_home_info
									JOIN pers_info
									ON impv_home_info.pers_id = pers_info.pers_id
									JOIN pers_addr
									ON pers_info.pre_addr_id = pers_addr.addr_id
									JOIN std_area
									ON pers_addr.addr_province = std_area.area_code
									WHERE impv_home_info.imp_home_id='".$area_id."'
								";
				//echo $sql."<br/>";
				$result = array();
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			public function get_map_impv_photo($imp_home_id = '')
			{
				$sql = "SELECT
								impv_home_info_photo.impv_home_id,
								impv_home_info_photo.impv_home_photo_file AS photo_file
								FROM
								impv_home_info_photo
								WHERE impv_home_info_photo.impv_home_id='".$imp_home_id."'
								LIMIT 1 ";
					$result = array();
					$result = $this->common_model->custom_query($sql);
					return rowArray($result);
			}


			//ข้อมูลภาพรวม รายงานข้อมูลคลังปัญญาผู้สูงอายุ
			public function get_wisd_summary()
			{
				$sql_branch = "SELECT
												std_wisdom.wis_id,
												std_wisdom.wis_code,
												std_wisdom.wis_name
												FROM
												std_wisdom
												ORDER BY wis_code ASC
												";
				$result_branch = $this->common_model->custom_query($sql_branch);
				$data_branch = array();
				foreach ($result_branch as $row) {
					$sql = " SELECT
									COUNT(DISTINCT(pers_info.pid) ) AS count_info, pers_info.pid
									FROM
									wisd_info
									JOIN wisd_branch
									ON wisd_info.knwl_id = wisd_branch.knwl_id
									JOIN pers_info
									ON wisd_info.pers_id = pers_info.pers_id
									LEFT JOIN std_prename
									ON pers_info.pren_code = std_prename.pren_code
									WHERE wisd_branch.wisd_code='".$row['wis_code']."'
									GROUP BY wisd_branch.wisd_code
								";
					$result = $this->common_model->custom_query($sql);
					$result_row = rowArray($result);
					$data_branch[$row['wis_id']] = array('wis_name'=>$row['wis_name'],
																								'count_info'=>((isset($result_row['count_info']))?$result_row['count_info']:0)
																							);
				}
				return $data_branch;
			}

			#ข้อมูล
			public function get_wisd_table_area() {

					$sql = "SELECT
					A.pers_id AS id,
					B.pid,
					B.pre_addr_id,
					IF(pers_addr.addr_province IS NOT NULL,pers_addr.addr_province,'NULL')  AS area_id,
					SUM(IF(B.gender_code=1,1,0)) AS count_m,
					SUM(IF(B.gender_code=2,1,0)) AS count_f,
					SUM(IF(B.gender_code=0 or B.gender_code is null,1,0)) AS count_null,
					COUNT(A.knwl_id) AS count_knwl,
					IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name
					FROM wisd_info AS A
					LEFT JOIN pers_info AS B
					ON A.pers_id = B.pers_id
					JOIN wisd_branch
					ON A.knwl_id = wisd_branch.knwl_id
					LEFT JOIN std_wisdom
					ON wisd_branch.wisd_code=std_wisdom.wis_code
					LEFT JOIN pers_addr
					ON B.pre_addr_id = pers_addr.addr_id
					LEFT JOIN std_area
					ON std_area.area_code = pers_addr.addr_province
					GROUP BY std_area.area_code
					ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
					CONVERT( std_area.area_name_th USING tis620 ) ASC ";
					$res = $this->common_model->custom_query($sql);
					foreach ($res as $row) {
								$area_name = $this->getStdArea($row['area_id']);
								$dataArea[] = array('area_id' => $row['area_id'],
																		'area_name' => $row['area_name'],
																		'count_m' => $row['count_m'],
																		'count_f' => $row['count_f'],
																		'count_knwl' => $row['count_knwl']
																	);
					}
					return $dataArea;
			}

			#ข้อมูล รายงานข้อมูลคลังปัญญาผู้สูงอายุ
			public function getAll_wisdInfo($area_id='') {
					$arr_month = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
					if($area_id != ''){
						if($area_id != 'NULL'){
								$sql_where = " AND pers_addr.addr_province='".$area_id."' ";
						}else{
								$sql_where = " AND pers_addr.addr_province IS NULL ";
						}
					}else{
						$sql_where = '';
					}
					$sql = " SELECT
									A.pers_id AS id,
									B.pid,
									C.prename_th AS prename,
									B.pers_firstname_th AS firstname,
									B.pers_lastname_th AS lastname,
									TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) AS age,
									B.pre_addr_id,
									std_wisdom.wis_name,
									B.tel_no,
									A.date_of_reg,
									pers_addr.addr_province
									FROM
									wisd_info AS A
									LEFT JOIN pers_info AS B
									ON A.pers_id = B.pers_id
									LEFT JOIN std_prename	AS C
									ON B.pren_code = C.pren_code
									JOIN wisd_branch
									ON A.knwl_id = wisd_branch.knwl_id
									LEFT JOIN std_wisdom
									ON wisd_branch.wisd_code=std_wisdom.wis_code
									LEFT JOIN pers_addr
									ON B.pre_addr_id = pers_addr.addr_id
									WHERE
									A.pers_id IS NOT NULL
									".$sql_where."
							ORDER BY A.insert_datetime DESC, A.update_datetime DESC";
					$res = $this->common_model->custom_query($sql);

					//home
					foreach ($res as $row) {
								$name = $row['prename'].$row['firstname'].' '.$row['lastname'];
								if($row['date_of_reg'] != '' && $row['date_of_reg'] != '0000-00-00'){
									$arr_date_of_reg = explode('-',$row['date_of_reg']);
									$year = substr(($arr_date_of_reg[0]+543),-2);
									$date_of_reg = $arr_date_of_reg[2].' '.$arr_month[intval($arr_date_of_reg[1])].' '.$year;
								}else{
									$date_of_reg = '';
								}

								$dataInfo[] = array('id'=>$row['id'],
																		'id_card'=>$row['pid'],
																		'name'=>$name,
																		'age'=>$row['age'],
																		'date_of_reg'=>$date_of_reg,
																		'tel_no'=>$row['tel_no'],
																		'address'=>$this->getAddress($row['pre_addr_id']),
																		'wis_name'=>$row['wis_name']
																	);
					}
					return $dataInfo;
			}

			//ข้อมูลภาพรวม รายงานข้อมูลคลังปัญญาผู้สูงอายุ
			public function get_edoe_summary()
			{
					$sql = "SELECT
									COUNT(edoe_job_vacancy.posi_id) AS count_job_vacancy,
									std_position_type.posi_type_code,
									edoe_job_vacancy.posi_id,
									edoe_job_vacancy.date_of_post,
									YEAR(edoe_job_vacancy.date_of_post)+(IF(MONTH(edoe_job_vacancy.date_of_post)>9,1,0))+(543) AS budget_year,
									edoe_job_vacancy.addr_province
									FROM
									edoe_job_vacancy
									JOIN std_position_type
									ON edoe_job_vacancy.posi_cate_code = std_position_type.posi_type_code
									GROUP BY budget_year ";
						$res = $this->common_model->custom_query($sql);
						$data = array();
						foreach ($res as $row) {
									$sql_emp_reg = "SELECT
													YEAR(edoe_older_emp_reg.date_of_reg)+(IF(MONTH(edoe_older_emp_reg.date_of_reg)>9,1,0))+(543) AS budget_year,
													SUM(IF(edoe_older_emp_reg.reg_status='ได้งานทำแล้ว',1,0)) AS reg_status_yes,
													SUM(IF(edoe_older_emp_reg.reg_status='ยังไม่ได้งาน',1,0)) AS reg_status_no
													FROM edoe_older_emp_reg
													JOIN pers_info
													ON edoe_older_emp_reg.pers_id = pers_info.pers_id
													WHERE YEAR(edoe_older_emp_reg.date_of_reg)+(IF(MONTH(edoe_older_emp_reg.date_of_reg)>9,1,0))+(543)='".$row['budget_year']."'
 													GROUP BY budget_year ";
									$res_emp_reg = $this->common_model->custom_query($sql_emp_reg);
									$res_emp_row = rowArray($res_emp_reg);
									$data[] = array('budget_year'=>$row['budget_year'],
																	'count_job_vacancy'=>$row['count_job_vacancy'],
																	'count_job_reg_y'=>$res_emp_row['reg_status_yes'],
																	'count_job_reg_n'=>$res_emp_row['reg_status_no']
														);
						}
					return $data;
			}
			#ข้อมูล
			public function get_edoe_table_area() {

					$sql = "SELECT
									IF(edoe_job_vacancy.addr_province IS NOT NULL,edoe_job_vacancy.addr_province,'NULL') AS area_id,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name,
									COUNT(DISTINCT(edoe_job_vacancy.org_code)) AS count_org,
									COUNT(edoe_job_vacancy.posi_id) AS count_job_vacancy
									FROM
									edoe_job_vacancy
									LEFT JOIN std_area
									ON edoe_job_vacancy.addr_province = std_area.area_code
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC ";
					$res = $this->common_model->custom_query($sql);
					foreach ($res as $row) {
								$area_name = $this->getStdArea($row['area_id']);
								$dataArea[] = array('area_id' => $row['area_id'],
																		'area_name' => $row['area_name'],
																		'count_org' => $row['count_org'],
																		'count_job_vacancy' => $row['count_job_vacancy']
																	);
					}
					return $dataArea;
			}
			#ข้อมูล รายงานข้อมูลคลังปัญญาผู้สูงอายุ
			public function getAll_edoeInfo($area_id='') {

					if($area_id != ''){
						if($area_id != 'NULL'){
								$sql_where = " WHERE edoe_job_vacancy.addr_province='".$area_id."' ";
						}else{
								$sql_where = " WHERE edoe_job_vacancy.addr_province IS NULL ";
						}
					}else{
						$sql_where = '';
					}
					$sql = " SELECT
										edoe_job_vacancy.*,
										std_position_type.posi_type_title
										FROM
										edoe_job_vacancy
										LEFT JOIN std_area
										ON edoe_job_vacancy.addr_province = std_area.area_code
										JOIN std_position_type
										ON edoe_job_vacancy.posi_cate_code = std_position_type.posi_type_code
									".$sql_where."
									ORDER BY date_of_post ASC,posi_title ASC";
					$res = $this->common_model->custom_query($sql);
					foreach ($res as $row) {
								if($row['date_of_post'] != '' && $row['date_of_post'] != '0000-00-00'){
									$arr_date_of_post = explode('-',$row['date_of_post']);
									$year = ($arr_date_of_post[0]+543);
									$date_of_post = $arr_date_of_post[2].'/'.$arr_date_of_post[1].'/'.$year;
								}else{
									$date_of_post = '';
								}

								$dataInfo[] = array('id'=>$row['posi_id'],
																		'date_of_post'=>$date_of_post,
																		'post_status'=>$row['post_status'],
																		'posi_title'=>$row['posi_title'],
																		'posi_type_title'=>$row['posi_type_title'],
																		'org_type'=>$row['org_type'],
																		'org_title'=>$row['org_title'],
																		'posi_workday'=>$row['posi_workday']
																	);
					}
					return $dataInfo;
			}

			#ข้อมูลแผนที่ รายงานข้อมูลส่งเสริมการจ้างงานผู้สูงอายุ
			public function get_map_edoe_info($area_id = '')
			{
				if($area_id != ''){
						$where = " WHERE edoe_job_vacancy.addr_province LIKE('".$area_id."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT
								IF(edoe_job_vacancy.addr_province IS NOT NULL,edoe_job_vacancy.addr_province,'NULL') AS area_id,
								IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name,
								COUNT(DISTINCT(edoe_job_vacancy.org_code)) AS count_org,
								COUNT(edoe_job_vacancy.posi_id) AS count_job_vacancy
								FROM
								edoe_job_vacancy
								LEFT JOIN std_area
								ON edoe_job_vacancy.addr_province = std_area.area_code
								".$where."
								GROUP BY edoe_job_vacancy.addr_province
								ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
								CONVERT( std_area.area_name_th USING tis620 ) ASC
								";
				//echo $sql."<br/>";
				$result = array();
				$result = $this->common_model->custom_query($sql);

				if($area_id != ''){
						$where_reg = " WHERE pers_addr.addr_province LIKE('".$area_id."%') ";
				}else{
						$where_reg = '';
				}
				$sql_reg = "SELECT
								COUNT(edoe_older_emp_reg.pers_id) AS count_of_req,
								pers_addr.addr_province
								FROM
								edoe_older_emp_reg
								JOIN pers_info
								ON edoe_older_emp_reg.pers_id = pers_info.pers_id
								JOIN pers_addr
								ON pers_info.pre_addr_id = pers_addr.addr_id	".$where_reg;
				$result_reg = $this->common_model->custom_query($sql_reg);
				$result = rowArray($result);
				$result_reg = rowArray($result_reg);
				$result_merge = array_merge($result, $result_reg);
				return $result_merge;
			}


			//ข้อมูลภาพรวม รายงานข้อมูลโรงเรียนผู้สูงอายุ
			public function get_school_summary()
			{
				$sql_year = "SELECT
											schl_info.year_of_established AS year,
											COUNT(schl_info.schl_id) AS count_school,
											COUNT(schl_info_generation.gen_id) AS count_gen,
											COUNT(schl_info_student.pers_id) AS count_pers
											FROM
											schl_info
											LEFT JOIN schl_info_generation
											ON schl_info.schl_id = schl_info_generation.schl_id
											LEFT JOIN schl_info_student
											ON schl_info.schl_id = schl_info_student.schl_id
											GROUP BY
											schl_info.year_of_established
											ORDER BY
											schl_info.year_of_established ASC";
				$res_year = $this->common_model->custom_query($sql_year);
				$arr_data = array();
				$count_school = 0;
				$count_gen = 0;
				$count_pers = 0;
				foreach ($res_year as $row_year) {
							if($row_year['year'] <= 2002){
								$count_school += $row_year['count_school'];
								$count_gen += $row_year['count_gen'];
								$count_pers += $row_year['count_pers'];
								$arr_data[2002] = array('year'=>'2002', 'count_school'=>$count_school, 'count_gen'=>$count_gen, 'count_pers'=>$count_pers);
							}else{
								$arr_data[$row_year['year']] = array('year'=>$row_year['year'], 'count_school'=>$row_year['count_school'], 'count_gen'=>$row_year['count_gen'],'count_pers'=>$row_year['count_pers']);
							}
				}
				return $arr_data;
			}

			public function get_school_table_area()
			{

				$sql = " 	SELECT
									IF(schl_info.addr_province IS NOT NULL,schl_info.addr_province,'NULL') AS area_id,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name,
									schl_info.year_of_established AS year,
									COUNT(schl_info.schl_id) AS count_school,
									COUNT(schl_info_generation.gen_id) AS count_gen,
									COUNT(schl_info_student.pers_id) AS count_pers
									FROM
									schl_info
									LEFT JOIN schl_info_generation
									ON schl_info.schl_id = schl_info_generation.schl_id
									LEFT JOIN schl_info_student
									ON schl_info.schl_id = schl_info_student.schl_id
									LEFT JOIN std_area
									ON schl_info.addr_province = std_area.area_code
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC ";
				$result = $this->common_model->custom_query($sql);
				return $result;
			}

			public function get_school_table($area_id='')
			{
				if($area_id != ''){
						$where = " WHERE IF(schl_info.addr_province IS NOT NULL,schl_info.addr_province,'NULL') = '".$area_id."' ";
				}else{
						$where = '';
				}
				$sql = " 	SELECT
									IF(schl_info.addr_province IS NOT NULL,schl_info.addr_province,'NULL') AS area_id,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name,
									schl_info.year_of_established AS year,
																				schl_info.schl_name AS schl_name,
																				COUNT(schl_info.schl_id) AS count_school,
																				COUNT(schl_info_generation.gen_id) AS count_gen,
																				COUNT(schl_info_student.pers_id) AS count_pers
																				FROM
																				schl_info
																				LEFT JOIN schl_info_generation
																				ON schl_info.schl_id = schl_info_generation.schl_id
																				LEFT JOIN schl_info_student
																				ON schl_info.schl_id = schl_info_student.schl_id
																				LEFT JOIN std_area
																				ON schl_info.addr_province = std_area.area_code
																				".$where."
																				GROUP BY schl_info.schl_id
																	ORDER BY CASE WHEN schl_info.schl_name IS NULL THEN 1 ELSE 0 END ASC,
																	CONVERT( schl_info.schl_name USING tis620 ) ASC ";
				$result = $this->common_model->custom_query($sql);
				return $result;
			}

			public function get_school_map_info($area_id = '')
			{
				if($area_id != ''){
						$where = " WHERE IF(schl_info.addr_province IS NOT NULL,schl_info.addr_province,'NULL') = '".$area_id."' ";
				}else{
						$where = '';
				}
				$sql = " SELECT
									IF(schl_info.addr_province IS NOT NULL,schl_info.addr_province,'NULL') AS area_id,
									IF(std_area.area_name_th IS NOT NULL,std_area.area_name_th,'ไม่ระบุ') AS area_name,
									schl_info.year_of_established AS year,
									COUNT(schl_info.schl_id) AS count_school,
									COUNT(schl_info_generation.gen_id) AS count_gen,
									COUNT(schl_info_student.pers_id) AS count_pers
									FROM
									schl_info
									LEFT JOIN schl_info_generation
									ON schl_info.schl_id = schl_info_generation.schl_id
									LEFT JOIN schl_info_student
									ON schl_info.schl_id = schl_info_student.schl_id
									LEFT JOIN std_area
									ON schl_info.addr_province = std_area.area_code
									".$where."
									GROUP BY std_area.area_code
									ORDER BY CASE WHEN std_area.area_name_th IS NULL THEN 1 ELSE 0 END ASC,
									CONVERT( std_area.area_name_th USING tis620 ) ASC
								";
				//echo $sql."<br/>";
				$result = array();
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			//รายงานสถิติประชากรผู้สูงอายุไทย
			function get_stat_summary(){
				$sql_year = " 	SELECT
									stat_thai_population.month_of_stat,
									stat_thai_population.year_of_stat
									FROM
									stat_thai_population
									GROUP BY stat_thai_population.year_of_stat ASC";
				$result_year = $this->common_model->custom_query($sql_year);
				$arr_data = array();
				foreach ($result_year as $row_year) {
						#Begin general
						$sql_field_general = "SHOW COLUMNS FROM stat_thai_population WHERE Field LIKE('male%') OR Field LIKE('female%')";
						$result_field_general = $this->common_model->custom_query($sql_field_general);
						$count_general = 0;
						$arr_field_general = array();
						foreach ($result_field_general as $field_general){
									$arr_field_general[] = "(IF(`stat_thai_population`.`".$field_general['Field']."` IS NOT NULL,`stat_thai_population`.`".$field_general['Field']."`,0))";
						}
						$str_field_general = "SUM";
						$str_field_general .= implode("+SUM",$arr_field_general);
						$sql_sum_general = "SELECT
												(".$str_field_general.") AS count_sum
												FROM
												stat_thai_population
												WHERE stat_thai_population.year_of_stat='".$row_year['year_of_stat']."' ";

						$result_sum_general = rowArray($this->common_model->custom_query($sql_sum_general));
						$count_general += isset($result_sum_general['count_sum'])?$result_sum_general['count_sum']:0;
						#End general
						#Begin over 60
						$sql_field_over60 = "	SHOW COLUMNS FROM stat_thai_population
																	WHERE (Field LIKE('male_6%') OR Field LIKE('female_6%')
																	OR Field LIKE('male_7%') OR Field LIKE('female_7%')
																	OR Field LIKE('male_8%') OR Field LIKE('female_8%')
																	OR Field LIKE('male_9%') OR Field LIKE('female_9%')
																	OR Field LIKE('male_100%') OR Field LIKE('female_100%')
																	OR Field LIKE('male_over%') OR Field LIKE('female_over%')
																	) AND Field != 'male_6' AND Field != 'female_6'
																	AND Field != 'male_7' AND Field != 'female_7'
																	AND Field != 'male_8' AND Field != 'female_8'
																	AND Field != 'male_9' AND Field != 'female_9'
																";
						$result_field_over60 = $this->common_model->custom_query($sql_field_over60);
						$count_over60 = 0;
						$arr_field_over60 = array();
						foreach ($result_field_over60 as $field_over60){
									$arr_field_over60[] = "(IF(`stat_thai_population`.`".$field_over60['Field']."` IS NOT NULL,`stat_thai_population`.`".$field_over60['Field']."`,0))";
						}
						$str_field_over60 = "SUM";
						$str_field_over60 .= implode("+SUM",$arr_field_over60);
						$sql_sum_over60 = "SELECT
												(".$str_field_over60.") AS count_sum
												FROM
												stat_thai_population
												WHERE stat_thai_population.year_of_stat='".$row_year['year_of_stat']."' ";

						$result_sum_over60 = rowArray($this->common_model->custom_query($sql_sum_over60));
						$count_over60 += isset($result_sum_over60['count_sum'])?$result_sum_over60['count_sum']:0;
						#End over 60

						$arr_data[] = array('year' => $row_year['year_of_stat'],
																'count_general' => $count_general,
																'count_pay_general' => 0,
																'count_over60' => $count_over60,
																'count_pay_over60' => 0
																);
				}
				return $arr_data;
			}

			function get_stat_table_area($year=''){
				$sql_max_year = "SELECT
													stat_thai_population.month_of_stat,
													stat_thai_population.year_of_stat
													FROM stat_thai_population
													GROUP BY stat_thai_population.year_of_stat DESC
 													LIMIT 1";
				$max_year = rowArray($this->common_model->custom_query($sql_max_year));
				if($year != ''){
						$where_year_of_stat = "WHERE stat_thai_population.year_of_stat='".$year."' ";
				}else{
						$where_year_of_stat = "WHERE stat_thai_population.year_of_stat='".$max_year['year_of_stat']."' ";
				}
				$sql_year = " 	SELECT
									stat_thai_population.month_of_stat,
									stat_thai_population.year_of_stat
									FROM
									stat_thai_population
									".$where_year_of_stat."
									GROUP BY stat_thai_population.year_of_stat ASC";
				$result_year = $this->common_model->custom_query($sql_year);
				$arr_data = array();
				foreach ($result_year as $row_year) {
						$sql_area = " SELECT area_code AS area_id, area_name_th AS area_name FROM `std_area` WHERE area_type='Province' ORDER BY area_name_th ASC ";
						$result_area = $this->common_model->custom_query($sql_area);
						foreach ($result_area as $row_area){
								#Begin male and female
								#male
								$sql_field_male = "SHOW COLUMNS FROM stat_thai_population WHERE Field LIKE('male%')";
								$result_field_male = $this->common_model->custom_query($sql_field_male);
								$count_male = 0;
								$arr_field_male = array();
								foreach ($result_field_male as $field_male){
											$arr_field_male[] = "(IF(`stat_thai_population`.`".$field_male['Field']."` IS NOT NULL,`stat_thai_population`.`".$field_male['Field']."`,0))";
								}
								$str_field_male = "SUM";
								$str_field_male .= implode("+SUM",$arr_field_male);
								#female
								$sql_field_female = "SHOW COLUMNS FROM stat_thai_population WHERE Field LIKE('female%')";
								$result_field_female = $this->common_model->custom_query($sql_field_female);
								$count_female = 0;
								$arr_field_female = array();
								foreach ($result_field_female as $field_female){
											$arr_field_female[] = "(IF(`stat_thai_population`.`".$field_female['Field']."` IS NOT NULL,`stat_thai_population`.`".$field_female['Field']."`,0))";
								}
								$str_field_female = "SUM";
								$str_field_female .= implode("+SUM",$arr_field_female);

								$sql_sum = "SELECT
														(".$str_field_male.") AS count_sum_male,
														(".$str_field_female.") AS count_sum_female
														FROM
														stat_thai_population
														WHERE stat_thai_population.year_of_stat='".$row_year['year_of_stat']."'
 														AND area_code LIKE('".substr($row_area['area_id'],0,2)."%');
														";

								$result_sum = rowArray($this->common_model->custom_query($sql_sum));
								$count_male += isset($result_sum['count_sum_male'])?$result_sum['count_sum_male']:0;
								$count_female += isset($result_sum['count_sum_female'])?$result_sum['count_sum_female']:0;
								#End male and female
								$arr_data[] = array('area_id'=>$row_area['area_id'],
																		'area_name'=>$row_area['area_name'],
																		'year' => $row_year['year_of_stat'],
																		'count_male' => $count_male,
																		'count_female' => $count_female
																		);
						}
				}
				return $arr_data;
			}

			//รายงานสถิติการเข้าชมสื่อมัลติมีเดียการเตรียมความพร้อมสู่วัยสูงอายุ
			function get_stat_media_summary($yyyy='', $mm=''){
				$sql = "SELECT
									stat_media_log.log_datetime,
									COUNT(stat_media_log.log_id) AS count_log
									FROM
									stat_media_log
									WHERE log_datetime LIKE('".$yyyy."-".$mm."%')";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			function get_stat_media_date_summary($yyyy='', $mm='', $dd=''){
				$sql = "SELECT
									stat_media_log.log_datetime,
									COUNT(stat_media_log.log_id) AS count_log
									FROM
									stat_media_log
									WHERE log_datetime LIKE('".$yyyy."-".$mm."-".$dd."%')";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			//สื่อที่ใช้งานมากที่สุด 5 อันดับ
			function get_stat_media_table(){
					$sql = "SELECT
									stat_media_log.media_id,
									COUNT(stat_media_log.log_id) AS count_log
									FROM stat_media_log
									GROUP BY
									stat_media_log.media_id
									ORDER BY
									count_log DESC
									LIMIT 10";
					$result_row = $this->common_model->custom_query($sql);
					foreach ($result_row as $row) {
							$result[] = array('media_name'=>$row['media_id'], 'count_log'=>$row['count_log']);
					}
					return $result;
			}

			//รายงานสถิติการเข้าใช้งานเว็บไซต์ศูนย์ข้อมูลผู้สูงอายุ
			function get_stat_web_summary($yyyy='', $mm=''){
				$sql = "SELECT
									stat_web_log.log_datetime,
									COUNT(stat_web_log.log_id) AS count_log
									FROM
									stat_web_log
									WHERE log_datetime LIKE('".$yyyy."-".$mm."%')";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			function get_stat_web_date_summary($yyyy='', $mm='', $dd=''){
				$sql = "SELECT
									stat_web_log.log_datetime,
									COUNT(stat_web_log.log_id) AS count_log
									FROM
									stat_web_log
									WHERE log_datetime LIKE('".$yyyy."-".$mm."-".$dd."%')";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

			//สื่อที่ใช้งานมากที่สุด 5 อันดับ
			function get_stat_web_table(){
					$sql = "SELECT
									stat_web_log.web_id,
									COUNT(stat_web_log.log_id) AS count_log
									FROM stat_web_log
									GROUP BY
									stat_web_log.web_id
									ORDER BY
									count_log DESC
									LIMIT 10";
					$result_row = $this->common_model->custom_query($sql);
					foreach ($result_row as $row) {
							$result[] = array('web_name'=>$row['web_id'], 'count_log'=>$row['count_log']);
					}
					return $result;
			}

			//รายงานประวัติการเรียกใช้ฐานข้อมูลกลางทะเบียนประวัติผู้สูงอายุ
			function get_stat_dbcenter_summary($yyyy='', $mm='', $log_type='Import'){
						$sql = "SELECT
											db_gateway.wsrv_log.req_datetime,
											COUNT(db_gateway.wsrv_log.log_id) AS count_log,
											SUM(if(end_datetime is NULL,1,TIMEDIFF(end_datetime,req_datetime))) AS time_process
											FROM
											db_gateway.wsrv_log
											JOIN db_gateway.wsrv_info
											ON db_gateway.wsrv_log.wsrv_id = db_gateway.wsrv_info.wsrv_id
											WHERE db_gateway.wsrv_log.log_type='".$log_type."'
											AND db_gateway.wsrv_log.req_datetime LIKE('".$yyyy."-".$mm."%')";
						$result = $this->common_model->custom_query($sql);
						return rowArray($result);
			}
			function get_stat_dbcenter_date_summary($yyyy='', $mm='', $dd='', $log_type='Import'){
						$sql = "SELECT
											db_gateway.wsrv_log.req_datetime,
											COUNT(db_gateway.wsrv_log.log_id) AS count_log,
											SUM(if(end_datetime is NULL,1,TIMEDIFF(end_datetime,req_datetime))) AS time_process
											FROM
											db_gateway.wsrv_log
											JOIN db_gateway.wsrv_info
											ON db_gateway.wsrv_log.wsrv_id = db_gateway.wsrv_info.wsrv_id
											WHERE db_gateway.wsrv_log.log_type='".$log_type."'
											AND db_gateway.wsrv_log.req_datetime LIKE('".$yyyy."-".$mm."-".$dd."%')";
						$result = $this->common_model->custom_query($sql);
						return rowArray($result);
			}
			//หน่วยงานที่ใช้งานมากที่สุด 5 อันดับ
			function get_stat_dbcenter_user_authen_table(){
					$sql_org = "SELECT
									wsrv_authen_key.user_org,
									COUNT(db_gateway.wsrv_log.log_id) AS count_log
									FROM db_gateway.wsrv_authen_key
									JOIN db_gateway.wsrv_log
									ON wsrv_authen_key.pid = db_gateway.wsrv_log.pid
									JOIN db_center.std_prename
									ON wsrv_authen_key.user_prename = db_center.std_prename.pren_code
									GROUP BY
									wsrv_authen_key.user_org
									ORDER BY
									count_log DESC
									LIMIT 5";
					$result_org = $this->common_model->custom_query($sql_org);
					foreach ($result_org as $row_org) {
							$sql_user = " SELECT
									wsrv_authen_key.pid,
									wsrv_authen_key.user_prename,
									db_center.std_prename.prename_th,
									wsrv_authen_key.user_firstname,
									wsrv_authen_key.user_lastname,
									wsrv_authen_key.user_org,
									COUNT(db_gateway.wsrv_log.log_id) AS count_log
									FROM db_gateway.wsrv_authen_key
									JOIN db_gateway.wsrv_log
									ON wsrv_authen_key.pid = db_gateway.wsrv_log.pid
									JOIN db_center.std_prename
									ON wsrv_authen_key.user_prename = db_center.std_prename.pren_code
									WHERE wsrv_authen_key.user_org LIKE('%".$row_org['user_org']."%')
									GROUP BY
									wsrv_authen_key.pid
									ORDER BY
									count_log DESC
									LIMIT 1 ";
							$result_user = $this->common_model->custom_query($sql_user);
							$row_user = rowArray($result_user);
							$user_name = $row_user['prename_th'].$row_user['user_firstname'].' '.$row_user['user_lastname'];
							$result[] = array('user_org'=>$row_org['user_org'], 'user_name'=>$user_name, 'count_log'=>$row_org['count_log']);
					}
					return $result;
			}
			//การประมวลที่ใช้เวลามาที่ใช้งานมากที่สุด 5 อันดับ
			function get_stat_dbcenter_process_table(){
					$sql = "SELECT
									db_gateway.wsrv_info.wsrv_definition,
									COUNT(db_gateway.wsrv_log.log_id) AS count_log,
									db_gateway.wsrv_log.req_datetime,
									db_gateway.wsrv_log.end_datetime
									FROM db_gateway.wsrv_log
									JOIN db_gateway.wsrv_info
									ON db_gateway.wsrv_log.wsrv_id = db_gateway.wsrv_info.wsrv_id
									GROUP BY db_gateway.wsrv_info.wsrv_id
									ORDER BY count_log DESC
									LIMIT 5 ";
					$result = $this->common_model->custom_query($sql);
					return $result;
			}
			//คลังพักฐานข้อมูล Data Warehouse
			function get_stat_dbcenter_dtawh_table(){
					$sql_tbl = " SHOW TABLES IN db_gateway WHERE Tables_in_db_gateway LIKE('dtawh%') ";
					$result_tbl = $this->common_model->custom_query($sql_tbl);
					foreach ($result_tbl as $tbl_value) {
							$tbl_name = $tbl_value['Tables_in_db_gateway'];
							$sql_tbl_name = "	SELECT tbl.TABLE_COMMENT AS table_name,
																round(((data_length + index_length) / 1024 / 1024), 2) `size`
																FROM  information_schema.TABLES AS tbl
																WHERE tbl.TABLE_NAME='".$tbl_name."'";
							$result_tbl_name = $this->common_model->custom_query($sql_tbl_name);
							$row_name = rowArray($result_tbl_name);

							$sql_tbl_conut = "	SELECT COUNT(*) AS count_row  FROM db_gateway.".$tbl_name." ";
							$result_tbl_count = $this->common_model->custom_query($sql_tbl_conut);
							$row_count = rowArray($result_tbl_count);

							$result[] = array('table_name'=>$row_name['table_name'],
																'count_row'=>$row_count['count_row'],
																'size'=>$row_name['size']
																);
					}

					return $result;
			}

			//รายงานสถิติการเชื่อมโยงข้อมูลในการบูรณาการงานผู้สูงอายุ
			function get_gateway_summary($yyyy='', $mm='', $log_type='Import'){
						$sql = "SELECT
											db_gateway.wsrv_log.req_datetime,
											COUNT(db_gateway.wsrv_log.log_id) AS count_log,
											SUM(if(end_datetime is NULL,1,TIMEDIFF(end_datetime,req_datetime))) AS time_process
											FROM
											db_gateway.wsrv_log
											JOIN db_gateway.wsrv_info
											ON db_gateway.wsrv_log.wsrv_id = db_gateway.wsrv_info.wsrv_id
											WHERE db_gateway.wsrv_log.log_type='".$log_type."'
											AND db_gateway.wsrv_log.req_datetime LIKE('".$yyyy."-".$mm."%')";
						$result = $this->common_model->custom_query($sql);
						return rowArray($result);
			}
			function get_gateway_date_summary($yyyy='', $mm='', $dd='', $log_type='Import'){
						$sql = "SELECT
											db_gateway.wsrv_log.req_datetime,
											COUNT(db_gateway.wsrv_log.log_id) AS count_log,
											SUM(if(end_datetime is NULL,1,TIMEDIFF(end_datetime,req_datetime))) AS time_process
											FROM
											db_gateway.wsrv_log
											JOIN db_gateway.wsrv_info
											ON db_gateway.wsrv_log.wsrv_id = db_gateway.wsrv_info.wsrv_id
											WHERE db_gateway.wsrv_log.log_type='".$log_type."'
											AND db_gateway.wsrv_log.req_datetime LIKE('".$yyyy."-".$mm."-".$dd."%')";
						$result = $this->common_model->custom_query($sql);
						return rowArray($result);
			}
			//หน่วยงานที่ใช้งานมากที่สุด 5 อันดับ
			function get_gateway_user_authen_table(){
					$sql_org = "SELECT
									wsrv_authen_key.user_org,
									COUNT(db_gateway.wsrv_log.log_id) AS count_log
									FROM db_gateway.wsrv_authen_key
									JOIN db_gateway.wsrv_log
									ON wsrv_authen_key.pid = db_gateway.wsrv_log.pid
									JOIN db_center.std_prename
									ON wsrv_authen_key.user_prename = db_center.std_prename.pren_code
									GROUP BY
									wsrv_authen_key.user_org
									ORDER BY
									count_log DESC
									LIMIT 5";
					$result_org = $this->common_model->custom_query($sql_org);
					foreach ($result_org as $row_org) {
							$sql_user = " SELECT
									wsrv_authen_key.pid,
									wsrv_authen_key.user_prename,
									db_center.std_prename.prename_th,
									wsrv_authen_key.user_firstname,
									wsrv_authen_key.user_lastname,
									wsrv_authen_key.user_org,
									COUNT(db_gateway.wsrv_log.log_id) AS count_log
									FROM db_gateway.wsrv_authen_key
									JOIN db_gateway.wsrv_log
									ON wsrv_authen_key.pid = db_gateway.wsrv_log.pid
									JOIN db_center.std_prename
									ON wsrv_authen_key.user_prename = db_center.std_prename.pren_code
									WHERE wsrv_authen_key.user_org LIKE('%".$row_org['user_org']."%')
									GROUP BY
									wsrv_authen_key.pid
									ORDER BY
									count_log DESC
									LIMIT 1 ";
							$result_user = $this->common_model->custom_query($sql_user);
							$row_user = rowArray($result_user);
							$user_name = $row_user['prename_th'].$row_user['user_firstname'].' '.$row_user['user_lastname'];
							$result[] = array('user_org'=>$row_org['user_org'], 'user_name'=>$user_name, 'count_log'=>$row_org['count_log']);
					}
					return $result;
			}
			//การประมวลที่ใช้เวลามาที่ใช้งานมากที่สุด 5 อันดับ
			function get_gateway_process_table(){
					$sql = "SELECT
									db_gateway.wsrv_info.wsrv_definition,
									COUNT(db_gateway.wsrv_log.log_id) AS count_log,
									db_gateway.wsrv_log.req_datetime,
									db_gateway.wsrv_log.end_datetime
									FROM db_gateway.wsrv_log
									JOIN db_gateway.wsrv_info
									ON db_gateway.wsrv_log.wsrv_id = db_gateway.wsrv_info.wsrv_id
									GROUP BY db_gateway.wsrv_info.wsrv_id
									ORDER BY count_log DESC
									LIMIT 5 ";
					$result = $this->common_model->custom_query($sql);
					return $result;
			}
			//คลังพักฐานข้อมูล Data Warehouse
			function get_gateway_dtawh_table(){
					$sql_tbl = " SHOW TABLES IN db_gateway WHERE Tables_in_db_gateway LIKE('dtawh%') ";
					$result_tbl = $this->common_model->custom_query($sql_tbl);
					foreach ($result_tbl as $tbl_value) {
							$tbl_name = $tbl_value['Tables_in_db_gateway'];
							$sql_tbl_name = "	SELECT tbl.TABLE_COMMENT AS table_name,
																round(((data_length + index_length) / 1024 / 1024), 2) `size`
																FROM  information_schema.TABLES AS tbl
																WHERE tbl.TABLE_NAME='".$tbl_name."'";
							$result_tbl_name = $this->common_model->custom_query($sql_tbl_name);
							$row_name = rowArray($result_tbl_name);

							$sql_tbl_conut = "	SELECT COUNT(*) AS count_row  FROM db_gateway.".$tbl_name." ";
							$result_tbl_count = $this->common_model->custom_query($sql_tbl_conut);
							$row_count = rowArray($result_tbl_count);

							$result[] = array('table_name'=>$row_name['table_name'],
																'count_row'=>$row_count['count_row'],
																'size'=>$row_name['size']
																);
					}

					return $result;
			}

			//รายงานผลการดำเนินงานตามตัวชี้วัด ศูนย์พัฒนาการจัดสวัสดิการสังคมผู้สูงอายุ
			public function getAll_admIrp($pers_id = ''){
				if($pers_id == ''){
					return array();
				}
				return rowArray($this->common_model->custom_query("
					SELECT A.* FROM adm_irp AS A
					WHERE pers_id = {$pers_id}
					ORDER BY date_of_irp DESC LIMIT 1
				"));
			}
			public function get_Percentage($irp_id='',$q_id=''){
					if($irp_id == ''){
						return array(	'ans_rate'	=> '',
													'ans_points' => 0,
													'ans_full_score' => 0,
													'ans_percent'	=> 0
						);
					}
					$question = "";
					if($q_id != ''){
						$question = "AND qstn_id = {$q_id}";
					}
					$countIrp = rowArray($this->common_model->custom_query("SELECT SUM(ans_points) AS ans_points ,SUM(ans_full_score) AS ans_full_score FROM adm_irp_result WHERE irp_id = {$irp_id} {$question}"));
					$ans_percent = @($countIrp['ans_points']/$countIrp['ans_full_score'])*100;
					if(empty($countIrp['ans_points'])){
						$ans_rate = '';
					}else if($ans_percent < 33.33){
						$ans_rate = 'A';
					}else if($ans_percent < 66.66){
						$ans_rate = 'B';
					}else{
						$ans_rate = 'C';
					}
					//echo '=======>'.$ans_rate."<br/>";
					$irp_result = array(
						'ans_rate'	=> $ans_rate,
						'ans_points' => $countIrp['ans_points'],
						'ans_full_score' => $countIrp['ans_full_score'],
						'ans_percent'	=> $ans_percent,
					);

					return $irp_result;
			}

			public function get_kpiorg_summary($age_min='', $age_max=''){
						$sql = "SELECT
										A.pers_id,
										B.gender_code
										FROM
										adm_info AS A
										JOIN pers_info AS B
										ON A.pers_id = B.pers_id
										JOIN adm_irp AS adm_irp
										ON B.pers_id = adm_irp.pers_id
										LEFT JOIN std_prename AS C
										ON B.pren_code = C.pren_code
										WHERE
										(A.delete_user_id IS NULL AND A.delete_datetime IS NULL)
										AND (B.delete_user_id IS NULL AND B.delete_datetime IS NULL)
										AND (
											IF(TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) IS NOT NULL,TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()),0 ) >= '".$age_min."'
											AND IF(TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) IS NOT NULL,TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()),0 ) <= '".$age_max."'
										)
										AND adm_irp.irp_org_id IN(102,103,104,105,106,107,108,109,110,111,112,113)
										GROUP BY A.pers_id
										ORDER BY
										A.insert_datetime DESC,
										A.update_datetime DESC";
						$result = $this->common_model->custom_query($sql);
						$pers_result = array();
						$pers_result['count_ma'] = 0;
						$pers_result['count_mb'] = 0;
						$pers_result['count_mc'] = 0;
						$pers_result['count_m_no'] = 0;
						$pers_result['count_fa'] = 0;
						$pers_result['count_fb'] = 0;
						$pers_result['count_fc'] = 0;
						$pers_result['count_f_no'] = 0;
						$pers_result['count_nulla'] = 0;
						$pers_result['count_nullb'] = 0;
						$pers_result['count_nullc'] = 0;
						$pers_result['count_null_no'] = 0;

						foreach ($result as $pers) {
								$get_admirp = $this->getAll_admIrp($pers['pers_id']);
								$irp_id = (isset($get_admirp['irp_id']))?$get_admirp['irp_id']:'';
								$irp_result = $this->get_Percentage($irp_id);
								if($pers['gender_code']=='1'){
										if($irp_result['ans_rate'] == 'A'){
											$pers_result['count_ma']++;
										}else if($irp_result['ans_rate'] == 'B'){
											$pers_result['count_mb']++;
										}else if($irp_result['ans_rate'] == 'C'){
											$pers_result['count_mc']++;
										}else{
											$pers_result['count_m_no']++;
										}
								}else if($pers['gender_code']=='2'){
										if($irp_result['ans_rate'] == 'A'){
											$pers_result['count_fa']++;
										}else if($irp_result['ans_rate'] == 'B'){
											$pers_result['count_fb']++;
										}else if($irp_result['ans_rate'] == 'C'){
											$pers_result['count_fc']++;
										}else{
											$pers_result['count_f_no']++;
										}
								}else{
										if($irp_result['ans_rate'] == 'A'){
											$pers_result['count_nulla']++;
										}else if($irp_result['ans_rate'] == 'B'){
											$pers_result['count_nullb']++;
										}else if($irp_result['ans_rate'] == 'C'){
											$pers_result['count_nullc']++;
										}else{
											$pers_result['count_null_no']++;
										}
								}
						}
					return $pers_result;
			}
			public function get_kpiorg_table_area() {

					$sql = "SELECT
									usrm_org.org_id,
									usrm_org.org_title,
									usrm_org.org_parent_id
									FROM usrm_org
									WHERE usrm_org.org_id IN(102,103,104,105,106,107,108,109,110,111,112,113)";
					//IN(102,103,104,105,106,107,108,109,110,111,112,113)
					$res = $this->common_model->custom_query($sql);
					$data = array();
					foreach ($res as $row) {
								$sql_org = "SELECT
														SUM(IF(adm_info.date_of_adm IS NOT NULL AND adm_info.date_of_adm != '0000-00-00',1,0)) AS count_of_adm,
														SUM(IF(adm_info.date_of_dis IS NOT NULL AND adm_info.date_of_dis != '0000-00-00',1,0)) AS count_of_dis,
														adm_info.pers_id,
														adm_irp.irp_org_id,
														adm_info.date_of_dis
														FROM adm_irp
														JOIN adm_info
														ON adm_irp.pers_id = adm_info.pers_id
														WHERE adm_irp.irp_org_id='".$row['org_id']."'
														GROUP BY  adm_irp.irp_org_id";
								$result_org = $this->common_model->custom_query($sql_org);
								$row_org = rowArray($result_org);
								$data[] = array('org_id' => $row['org_id'],
																		'org_title' => $row['org_title'],
																		'count_org' => (isset($row_org['count_of_adm'])?$row_org['count_of_adm']:0),
																		'count_job_vacancy' => (isset($row_org['count_of_dis'])?$row_org['count_of_dis']:0)
																	);
					}
					return $data;
			}

			public function get_kpiorg_table($org_id='') {
					$sql = "SELECT
									adm_info.pers_id,
									adm_irp.irp_id,
									adm_irp.irp_org_id,
									adm_info.date_of_dis,
									pers_info.pid,
									pers_info.gender_code,
									std_prename.prename_th,
									pers_info.pers_firstname_th,
									pers_info.pers_lastname_th,
									pers_info.date_of_birth,
									IF(TIMESTAMPDIFF(YEAR, pers_info.date_of_birth, CURDATE()) IS NOT NULL,TIMESTAMPDIFF(YEAR, pers_info.date_of_birth, CURDATE()),0 ) AS age
									FROM
									adm_irp
									JOIN adm_info
									ON adm_irp.pers_id = adm_info.pers_id
									JOIN db_center.pers_info
									ON adm_info.pers_id = pers_info.pers_id
									JOIN std_prename
									ON pers_info.pren_code = std_prename.pren_code
									WHERE adm_irp.irp_org_id='".$org_id."'
									GROUP BY adm_info.pers_id";
					$res = $this->common_model->custom_query($sql);
					$data = array();
					foreach ($res as $row) {
									$pers_id = $row['pers_id'];
									 $first_irp = rowArray($this->common_model->custom_query("
										SELECT A.* FROM adm_irp AS A
										WHERE pers_id = {$pers_id}
										ORDER BY date_of_irp ASC LIMIT 1
									"));
									$last_irp = rowArray($this->common_model->custom_query("
									 SELECT A.* FROM adm_irp AS A
									 WHERE pers_id = {$pers_id}
									 ORDER BY date_of_irp DESC LIMIT 1
								 "));
								$first_irp_id = (isset($first_irp['irp_id']))?$first_irp['irp_id']:'';
 								$first_irp_result = $this->get_Percentage($first_irp_id);
								$last_irp_id = (isset($last_irp['irp_id']))?$last_irp['irp_id']:'';
								$last_irp_result = $this->get_Percentage($last_irp_id);
								if($row['gender_code'] != ''){
										if($row['gender_code'] == 1){
											$gender = 'ชาย';
										}else if($row['gender_code'] == 2){
											$gender = 'หญิง';
										}else{
											$gender = '';
										}
								}else{
										$gender = '';
								}
								$data[] = array('id' => $row['pid'],
																'name' => $row['prename_th'].$row['pers_firstname_th'].$row['pers_lastname_th'],
																'gender'=> $gender,
																'age' => (($row['age'] > 0)?$row['age']:''),
																'first_score'=>$first_irp_result['ans_points'],
																'first_kpi'=>$first_irp_result['ans_rate'],
																'last_score'=>$last_irp_result['ans_points'],
																'last_kpi'=>$last_irp_result['ans_rate']
																);
					}
					return $data;
			}

			//ข้อมูลภาพรวม รายงานข้อมูลอาสาสมัครดูแลผู้สูงอายุ (อผส.)
			public function get_volt_summary($yyyy='',$mm='')
			{
				if($yyyy != '' && $mm != ''){
						//$where = " WHERE volt_info.date_of_reg LIKE('".$yyyy."-".$mm."%') ";
						$where = " WHERE volt_info.insert_datetime LIKE('".$yyyy."-".$mm."%') ";
				}else{
						$where = '';
				}
				$sql = " SELECT
								  SUM(IF(gender_code=1,1,0)) AS count_m,
									SUM(IF(gender_code=2,1,0)) AS count_f,
									SUM(IF(gender_code=0 OR gender_code IS NULL,1,0)) AS count_null
								FROM volt_info
								JOIN pers_info
								ON volt_info.pers_id = pers_info.pers_id
								".$where."
							";
				//echo $sql."<br/>";
				$result = $this->common_model->custom_query($sql);
				return rowArray($result);
			}

  }
?>
