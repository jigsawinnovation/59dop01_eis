<?php
	class personal_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    public function getOnce_PersonalInfo_byCode($pid=0)
    {
        $pid = str_replace("-","",$pid);
        return rowArray($this->common_model->custom_query("select A.*,B.*,C.*,D.*,E.*,F.*,CONCAT(A.pers_firstname_th, ' ', A.pers_lastname_th) as name 
            from pers_info as A 
                                left join std_prename as B     on A.pren_code=B.pren_code 
                                left join std_gender as C      on A.gender_code=C.gender_code 
                                left join std_nationality as D on A.nation_code=D.nation_code 
                                left join std_religion as E    on A.relg_code=E.relg_code 
                                left join std_edu_level as F    on A.edu_code=F.edu_code 
                                     
            where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and 
                  A.pid={$pid} 
            order by A.insert_datetime DESC,
                     A.update_datetime DESC"));
    }

    public function getOnce_PersonalInfo($pers_id=0)
    {
        return rowArray($this->common_model->custom_query("select A.*,B.*,C.*,D.*,E.*,F.*,CONCAT(A.pers_firstname_th, ' ', A.pers_lastname_th) as name 
            from pers_info as A 
                                left join std_prename as B     on A.pren_code=B.pren_code 
                                left join std_gender as C      on A.gender_code=C.gender_code 
                                left join std_nationality as D on A.nation_code=D.nation_code 
                                left join std_religion as E    on A.relg_code=E.relg_code 
                                left join std_edu_level as F    on A.edu_code=F.edu_code 
                                     
            where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and 
            	  A.pers_id={$pers_id} 
            order by A.insert_datetime DESC,
                     A.update_datetime DESC"));
    }

    //pers_addr ทะเบียนบ้าน/ที่อยู่ reg_addr_id:รหัสทะเบียนที่อยู่ (ที่อยู่ตามทะเบียนบ้าน),pre_addr_id:รหัสทะเบียนที่อยู่ (ที่อยู่ปัจจุบัน)
    public function getOnce_PersonalAddress($addr_id=0) {
        return rowArray($this->common_model->custom_query("select A.*,B.*,C.*,D.*,
            E.area_name_th as addr_sub_district,
        	E.area_code    as sub_district_code,
            F.area_name_th as addr_district,
        	F.area_code    as district_code,
            G.area_name_th as addr_province,
        	G.area_code    as province_code 
            from pers_addr as A 
                                left join std_alley as B   on A.addr_alley=B.alley_code 
                                left join std_road as C    on A.addr_road=C.road_code 
                                left join std_lane as D    on A.addr_road=D.lane_code 
                                left join std_area as E    on A.addr_sub_district=E.area_code 
                                left join std_area as F    on A.addr_district=F.area_code 
                                left join std_area as G    on A.addr_province=G.area_code 
                                     
            where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and 
            	  A.addr_id={$addr_id} 
            order by A.insert_datetime DESC,
                     A.update_datetime DESC"));
    }

    public function getPersonalInfo($pers_id = '') {
        $arr = array();
        if(chkUserLogin() && $pers_id!='') {
            $tmp = $this->getOnce_PersonalInfo($pers_id);
            if(isset($tmp['pid'])) {
                $tmp['reg_addr'] = array();
                if($tmp['reg_addr_id']!='') {
                    $tmp1 = $this->getOnce_PersonalAddress($tmp['reg_addr_id']);
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
                  $tmp['age'] = $age;
                }

            }

            $arr = $tmp;
        }
        return $arr;
    }

    public function getAll_nationality() {
        return $this->common_model->getTableOrder('std_nationality', 'nation_id', 'ASC');
    }      
    public function getOnce_nationality($nation_code='') {
        return rowArray($this->common_model->get_where_custom('std_nationality', 'nation_code', $nation_code));
    }

    public function getAll_religion() {
        return $this->common_model->getTableOrder('std_religion', 'religion_id', 'ASC');
    }      
    public function getOnce_religion($relg_code='') {
        return rowArray($this->common_model->get_where_custom('std_religion', 'religion_id', $relg_code));
    }

    public function getAll_edu_level() {
        return $this->common_model->getTableOrder('std_edu_level', 'edu_id', 'ASC');
    }      
    public function getOnce_redu_level($edu_code='') {
        return rowArray($this->common_model->get_where_custom('std_edu_level', 'edu_code', $edu_code));
    }

    public function getAll_alley() {
        return $this->common_model->getTableOrder('std_alley', 'alley_id', 'ASC');
    }
    public function getAll_lane() {
        return $this->common_model->getTableOrder('std_lane', 'lane_id', 'ASC');
    }
    public function getAll_road() {
        return $this->common_model->getTableOrder('std_road', 'road_id', 'ASC');
    }

    public function getAll_Province() {
        return $this->common_model->get_where_custom_order('std_area', 'area_type', 'Province','area_id','ASC');
    }
    public function getAll_Amphur() {
        return $this->common_model->get_where_custom_order('std_area', 'area_type', 'Amphur','area_id','ASC');
    }
    public function getAll_Tambon() {
        return $this->common_model->get_where_custom_order('std_area', 'area_type', 'Tambon','area_id','ASC');
    }
}
?>
