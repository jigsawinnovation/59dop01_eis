<?php
class Member_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function getAll_Member() {
        return $this->common_model->custom_query("select * from usrm_user");
    }
    public function getOnce_Member($user_id=0) {
        return rowArray($this->common_model->custom_query("select * from usrm_user where user_id=".$user_id));
    }

    public function getAll_Province() {
        return $this->common_model->custom_query("select * from tbl_area where area_type='Province'");
    }
    public function getOnce_Province($area_code='') {
        return $this->common_model->custom_query("select * from tbl_area where area_code='".$area_code."'AND area_type='Province'");
    }    

    public function getAll_Amphur() {
        return $this->common_model->custom_query("select * from tbl_area where area_type='Amphur'");
    }
    public function getOnce_Amphur($area_code='') {
        return $this->common_model->custom_query("select * from tbl_area where area_code='".$area_code."'AND area_type='Amphur'");
    }    

    public function getAll_Tambon() {
        return $this->common_model->custom_query("select * from tbl_area where area_type='Tambon'");
    }
    public function getOnce_Tambon($area_code='') {
        return $this->common_model->custom_query("select * from tbl_area where area_code='".$area_code."'AND area_type='Tambon'");
    }    

    /*
    public function getAll_members() {
        return $this->common_model->custom_query("select 
            A.M_ID,A.M_Img,A.M_Username,A.M_Password,A.M_TName,A.M_ThName,A.M_EnName,A.M_Sex,A.M_Birthdate,A.M_npID,A.M_Tel,A.M_Email,A.M_Address,A.GM_ID,A.M_UserAdd,A.M_DateTimeAdd,A.M_DateTimeUpdate,A.M_UserUpdate,A.M_Type,A.M_Allow, 
            B.M_ThName as M_ThNameAdd,B.M_EnName as M_EnNameAdd,C.M_ThName as M_ThNameUpdate,C.M_EnName as M_EnNameUpdate,A.M_Position,A.M_UnitName,
            D.GM_Name 
            from member as A 
            left join member as B on B.M_ID=A.M_UserAdd 
            left join member as C on C.M_ID=A.M_UserUpdate 
            left join group_members as D on D.GM_ID=A.GM_ID 
            where A.M_Type='1' AND A.M_Allow='1' AND A.GM_ID!=0 order by D.GM_ID asc,A.M_DateTimeUpdate DESC");
    }
    */
    /*
    public function getOnce_members($M_ID=0) {
        return rowArray($this->common_model->custom_query("select 
            A.M_ID,A.M_Img,A.M_Username,A.M_Password,A.M_TName,A.M_ThName,A.M_EnName,A.M_Sex,A.M_Birthdate,A.M_npID,A.M_Tel,A.M_Email,A.M_Address,A.GM_ID,A.M_UserAdd,A.M_DateTimeAdd,A.M_DateTimeUpdate,A.M_UserUpdate,A.M_Type,A.M_Allow, 
            B.M_ThName as M_ThNameAdd,B.M_EnName as M_EnNameAdd,C.M_ThName as M_ThNameUpdate,C.M_EnName as M_EnNameUpdate,A.M_Position,A.M_UnitName,
            D.GM_Name 
            from member as A 
            left join member as B on B.M_ID=A.M_UserAdd 
            left join member as C on C.M_ID=A.M_UserUpdate 
            left join group_members as D on D.GM_ID=A.GM_ID 
            where A.M_Type='1' AND A.M_Allow='1' AND A.M_ID={$M_ID}")
        );
    } 
    */
    /* 
    public function getUsername_with_MID($M_ID=0) {
        return rowArray($this->common_model->get_where_custom_field('member','M_ID',$M_ID,'M_ID'));
    } 
    */
    /*
    public function getUsername_with_npID($M_npID='') {
        return rowArray($this->common_model->get_where_custom_field('member','M_npID',$M_npID,'M_ID'));
    } 
    */
    /*
    public function getOnce_group_permissions_with_P_ID($GM_ID,$P_ID){
        return rowArray($this->common_model->custom_query("select 
            A.GP_ID,A.GP_Value,A.GM_ID,A.P_ID,A.GP_UserAdd,A.GP_DateTimeAdd,A.GP_Allow, 
            B.M_ThName as M_ThNameAdd,B.M_EnName as M_EnNameAdd 
            from group_permissions as A 
            left join member as B on B.M_ID=A.GP_UserAdd 
            where A.GM_ID=$GM_ID AND A.P_ID=$P_ID AND GP_Allow='1'")
        );
    } 
    */
    /*
    public function getPGP(&$P_ID_arr = array(),$GM_ID = 0,$Parent_ID=0) {
        $process = $this->admin_model->getAll_permissions_with_parentID($Parent_ID);
        if(count($process)>0)
        foreach ($process as $key => $value) {
            $temp = $this->getOnce_group_permissions_with_P_ID($GM_ID,$value['P_ID']);

            if(isset($temp['GP_ID'])) {
                $P_ID_arr[] = 1;
            }else {
                $P_ID_arr[] = 0;
            }
            $this->getPGP($P_ID_arr,$GM_ID,$value['P_ID']);
        }      
    }
    */
}

?>
