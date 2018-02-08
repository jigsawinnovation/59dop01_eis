<?php
	class Difficult_mobile_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

				#แสดงข้อมูลผูใช้งาน
				public function getUsrmUser($pid='') {
						$tmp = array();
						$sql = "SELECT
										db_center_dev.usrm_grp.grp_title,
										usrm_application.app_id,
										usrm_application.app_name,
										db_center_dev.usrm_user.pid,
										db_center_dev.usrm_user.passcode,
										db_center_dev.usrm_user.user_firstname,
										db_center_dev.usrm_user.user_lastname
										FROM db_center_dev.usrm_grp
										JOIN db_center_dev.usrm_grp_permission
										ON db_center_dev.usrm_grp.grp_id = db_center_dev.usrm_grp_permission.grp_id
										JOIN usrm_application
										ON usrm_application.app_id = db_center_dev.usrm_grp_permission.app_id
										JOIN db_center_dev.usrm_user
										ON db_center_dev.usrm_user.org_id = db_center_dev.usrm_grp_permission.grp_id
										WHERE usrm_application.app_id='80'
 										AND db_center_dev.usrm_user.pid='".$pid."' ";
						$tmp = $this->common_model->custom_query($sql);
						return rowArray($tmp);
				}

				#Begin ข้อมูลพื้นฐาน
				#สภาพปัญหา
				public function getStdTrouble(){
						return $this->common_model->custom_query("SELECT trb_code AS id, trb_title AS name  FROM `std_trouble` ORDER BY trb_code ASC");
				}
				#ผลให้ความช่วยเหลือ
				public function getStdHelp(){
						return $this->common_model->custom_query("SELECT help_code AS id, help_title AS name  FROM `std_help` ORDER BY help_code ASC");
				}
				#แนวทางให้ความช่วยเหลือ
				public function getStdHelpGuide(){
						return $this->common_model->custom_query("SELECT help_guide_code AS id, help_guide_title AS name  FROM `std_help_guide` ORDER BY help_guide_code ASC");
				}
				#End ข้อมูลพื้นฐาน

				#แสดงข้อมูลสภาพปัญหาผู้ยากลำบาก
				public function getDiffTrouble($diff_id='') {
						$tmp = array();
						$tmp = $this->common_model->get_where_custom('diff_trouble', 'diff_id', $diff_id);
						return $tmp;
				}

				#แสดงข้อมูลผลให้ความช่วยเหลือผู้ยากลำบาก
				public function getDiffHelp($diff_id='') {
						$tmp = array();
						$tmp = $this->common_model->get_where_custom('diff_help', 'diff_id', $diff_id);
						return $tmp;
				}

				#แสดงข้อมูลแนวทางให้ความช่วยเหลือู้ยากลำบาก
				public function getDiffHelpGuide($diff_id='') {
						$tmp = array();
						$tmp = $this->common_model->get_where_custom('diff_help_guide', 'diff_id', $diff_id);
						return $tmp;
				}

				#บันทึกข้อมูลตรวจเยี่บม
				public function updateDiffInfo($id='', $data = array()){
						$sql = "UPDATE `diff_info` SET date_of_visit='".$data['date_of_visit']."',
										visit_place='".$data['visit_place']."',
										visit_place_identify='".$data['visit_place_identify']."'
										WHERE diff_id='".$id."' ";
						$this->common_model->query($sql);
				}

				#บันทึกข้อมูลสภาพปัญหา
				public function updateDiffTrouble($id='', $data = array()){
						$sql_del = "DELETE FROM diff_trouble WHERE diff_id='".$id."' ";
						$this->common_model->query($sql_del);
						foreach ($data as $row) {
								$sql_add = "INSERT INTO diff_trouble SET diff_id='".$id."', trb_code='".$row['trouble_code']."', trb_remark='".$row['trouble_remark']."' ";
								$this->common_model->query($sql_add);
						}
				}

				#บันทึกข้อมูลความช่วยเหลือ
				public function updateDiffdHelp($id='', $data = array()){
						$sql_del = "DELETE FROM diff_help WHERE diff_id='".$id."' ";
						$this->common_model->query($sql_del);
						foreach ($data as $row) {
								$sql_add = "INSERT INTO diff_help SET diff_id='".$id."', help_code='".$row['help_code']."', help_remark='".$row['help_remark']."' ";
								$this->common_model->query($sql_add);
						}
				}

				#บันทึกข้อมูลแนวทางให้ความช่วยเหลือ
				public function updateDiffdHelpGuide($id='', $data = array()){
						$sql_del = "DELETE FROM diff_help_guide WHERE diff_id='".$id."' ";
						$this->common_model->query($sql_del);
						foreach ($data as $row) {
								$sql_add = "INSERT INTO diff_help_guide SET diff_id='".$id."', help_guide_code='".$row['help_guide_code']."', help_guide_remark='".$row['help_guide_remark']."' ";
								$this->common_model->query($sql_add);
						}
				}

				#แสดงของข้อมูลภาพ
				public function getPhoto($id=''){
						$file_path = 'https://center.dop.go.th/assets/modules/difficult/uploads/';
						if($id!=''){
								$sql_where = "WHERE diff_id='".$id."' ";
						}else{
								$sql_where = "";
						}
						$sql = "SELECT diff_photo_id AS id, diff_photo_file AS src, diff_photo_label AS sub
										FROM `diff_info_photo`
										".$sql_where."
										ORDER BY diff_photo_id ASC";
						$diffPhoto = array();
						$res = array();
						$res = $this->common_model->custom_query($sql);
						foreach ($res as $row) {
							$diffPhoto[] = array(
																	'id'=>$row['id'],
																	'src'=>$file_path.$row['src'],
																	'sub'=>$row['sub']);
						}
						return $diffPhoto;
				}
				#แสดงข้อมูลภาพที่ต้องการลบ
				public function getDeletePhoto($id=''){
						if($id!=''){
								$sql_where = "WHERE diff_photo_id='".$id."' ";
						}else{
								$sql_where = "";
						}
						$sql = "SELECT diff_photo_id AS id, diff_photo_file AS src, diff_photo_label AS sub, diff_id
										FROM `diff_info_photo`
										".$sql_where."
										ORDER BY diff_photo_id ASC";
						$diffPhoto = $this->common_model->custom_query($sql);
						return rowArray($diffPhoto);
				}
				#ลบข้อมูลภาพ
				public function deletePhoto($id=''){
						$sql = "DELETE FROM `diff_info_photo` WHERE diff_photo_id='".$id."' ";
						$this->common_model->query($sql);
				}

				#บันทึกข้อมูลภาพภ่าย
				public function savePhoto($diff_id=0,$photo_file='',$photo_label='',$photo_size='') {
						$sql = "INSERT INTO diff_info_photo SET diff_id='".$diff_id."', diff_photo_file='".$photo_file."', diff_photo_label='".$photo_label."', diff_photo_size='".$photo_size."' ";
						$this->common_model->query($sql);
				}

				#แสดงข้อมูลพิกัด
				public function getAddrGPS($diff_id=0){
						$sql = "SELECT A.diff_id, B.pre_addr_id, pers_addr.addr_gps
										FROM diff_info AS A
										LEFT JOIN pers_info AS B ON A.pers_id = B.pers_id
										JOIN db_center_dev.pers_addr ON B.pre_addr_id = db_center_dev.pers_addr.addr_id
										WHERE A.diff_id = '20' ";
						$diffInfo = $this->common_model->custom_query($sql);
						return rowArray($diffInfo);
				}

				#บันทึกข้อมูลพิกัด
				public function updateAddrGPS($diff_id='', $data_gps=''){
						$sql_diff = "	SELECT A.diff_id,B.pre_addr_id
												FROM diff_info A LEFT OUTER JOIN pers_info B ON A.pers_id = B.pers_id
												LEFT OUTER JOIN std_prename C ON B.pren_code = C.pren_code
												WHERE A.diff_id = '".$diff_id."' ";
						$diffInfo = $this->common_model->custom_query($sql_diff);
						$row = rowArray($diffInfo);
						$sql_gps = "UPDATE `pers_addr` SET addr_gps='".$data_gps."' WHERE addr_id='".$row['pre_addr_id']."' ";
						$this->common_model->query($sql_gps);
				}

				#รายการผู้สูงอายุที่อยู่ในภาวะยากลำบาก
        public function getAll_diffInfo($diff_id='') {
						if($diff_id != ''){
							$sql_where_diff = " AND A.diff_id='".$diff_id."' ";
						}else{
							$sql_where_diff = '';
						}
						$sql_diff = "SELECT A.diff_id,B.pid,
																											B.pren_code AS prename,
																											B.pers_firstname_th AS firstname,
																											B.pers_lastname_th AS lastname,
																											TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) AS age,
																											B.pre_addr_id,
																											A.visit_place,
																											A.visit_place_identify,
																										A.date_of_req,
																										A.date_of_visit,
																										A.date_of_pay AS date_of_help
																										FROM diff_info A LEFT OUTER JOIN pers_info B ON A.pers_id = B.pers_id
																											 LEFT OUTER JOIN std_prename C ON B.pren_code = C.pren_code
																										WHERE (A.delete_user_id IS NULL && A.delete_datetime IS NULL)
																										".$sql_where_diff."
																										AND (B.delete_user_id IS NULL && B.delete_datetime IS NULL)
																										ORDER BY A.insert_datetime DESC, A.update_datetime DESC";
            $res_diff = $this->common_model->custom_query($sql_diff);

						foreach ($res_diff as $row_diff) {
									$name = $row_diff['prename'].$row_diff['firstname'].' '.$row_diff['lastname'].' (อายุ '.$row_diff['age'].' ปี)';
									if($row_diff['date_of_req'] != ''){
										$arr_date_of_req = explode('-',$row_diff['date_of_req']);
										$date_of_req = $arr_date_of_req[2].'/'.$arr_date_of_req[1].'/'.($arr_date_of_req[0]);
									}else{
										$date_of_req = '';
									}
									if($row_diff['date_of_visit'] != ''){
										$arr_date_of_visit = explode('-',$row_diff['date_of_visit']);
										$date_of_visit = $arr_date_of_visit[2].'/'.$arr_date_of_visit[1].'/'.($arr_date_of_visit[0]);
									}else{
										$date_of_visit = '';
									}
									if($row_diff['date_of_help'] != ''){
										$arr_date_of_help = explode('-',$row_diff['date_of_help']);
										$date_of_help = $arr_date_of_help[2].'/'.$arr_date_of_help[1].'/'.($arr_date_of_help[0]);
									}else{
										$date_of_help = '';
									}

									$diffInfo[] = array(
																			'id'=>$row_diff['diff_id'],
																			'id_card'=>$row_diff['pid'],
																			'name'=>$name,
																			'address1'=>$this->getAddress1($row_diff['pre_addr_id']),
																			'address2'=>$this->getAddress2($row_diff['pre_addr_id']),
																			'date_of_req'=>$date_of_req,
																			'date_of_visit'=>$date_of_visit,
																			'date_of_help'=>$date_of_help,
																			'visit_place'=>$row_diff['visit_place'],
																			'visit_place_identify'=>$row_diff['visit_place_identify'],
																			'logo'=>'img/no-image-person.png'
																		);

						}
						if($diff_id != ''){
							return rowArray($diffInfo);
						}else{
							return $diffInfo;
						}
        }

				#ข้อมูลที่อยู่ 1
				public function getAddress1($addr_id=''){
						$sql = "SELECT * FROM pers_addr WHERE addr_id='".$addr_id."' ";
						$res = $this->common_model->custom_query($sql);
						$row = rowArray($res);
						$str_addr = '';
						if($row){
							$str_addr .= $row['addr_home_no'];
							if($row['addr_moo']){
								$str_addr .= ' ม.'.$row['addr_moo'];
							}
							if($row['addr_alley']){
								//$str_addr .= ' ต.'.$this->getStdAlley($row['addr_alley']);
							}
							if($row['addr_lane']){
								$str_addr .= ' ซ.'.$row['addr_lane'];
							}
							if($row['addr_sub_district']){
								$str_addr .= ' ต.'.$this->getStdArea($row['addr_sub_district']);
							}
						}
						return $str_addr;
				}

				#ข้อมูลที่อยู่ 2
				public function getAddress2($addr_id=''){
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

				#ข้อมูลที่อยู่ ซอย
				public function getStdAlley($id=''){
						$sql = "SELECT alley_name FROM std_alley WHERE alley_code='".$id."' ";
						$res = $this->common_model->custom_query($sql);
						$row = rowArray($res);
						return $row['alley_name'];
				}

				#ข้อมูลที่อยู่
				public function getStdArea($id=''){
						$sql = "SELECT area_name_th FROM std_area WHERE area_code='".$id."' ";
						$res = $this->common_model->custom_query($sql);
						$row = rowArray($res);
						return $row['area_name_th'];
				}

        public function getOnce_diffInfo($diff_id=0) {
            return rowArray($this->common_model->custom_query("select A.*,B.*,C.*,D.*,E.*,F.*,G.*,CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name
                from diff_info as A
                                    left join pers_info as B       on A.pers_id=B.pers_id
                                    left join std_prename as C     on B.pren_code=C.pren_code
                                    left join std_gender as D      on B.gender_code=D.gender_code
                                    left join std_nationality as E on B.nation_code=E.nation_code
                                    left join std_religion as F    on B.relg_code=F.relg_code
                                    left join std_edu_level as G    on B.edu_code=G.edu_code

                where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and
                      (B.delete_user_id IS NULL && B.delete_datetime IS NULL)
                      and diff_id={$diff_id}
                "));

        }

        public function getAll_reqChanel() {
            return $this->common_model->getTableOrder('std_req_channel', 'chn_id', 'ASC');
        }

        public function getOnce_reqChanel($chn_code='') {
            return rowArray($this->common_model->get_where_custom('std_edu_level', 'chn_code', $chn_code));
        }

    }
?>
