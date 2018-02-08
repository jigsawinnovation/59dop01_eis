<?php
	class Difficult_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function getAll_diffInfo() {
            return $this->common_model->custom_query("select A.*,B.*,C.*,D.*,E.*,F.*,G.*,CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name 
                from diff_info as A 
                                    left join pers_info as B       on A.pers_id=B.pers_id 
                                    left join std_prename as C     on B.pren_code=C.pren_code 
                                    left join std_gender as D      on B.gender_code=D.gender_code 
                                    left join std_nationality as E on B.nation_code=E.nation_code 
                                    left join std_religion as F    on B.relg_code=F.relg_code 
                                    left join std_edu_level as G    on B.edu_code=G.edu_code 
                                     
                where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and
                      (B.delete_user_id IS NULL && B.delete_datetime IS NULL) 
                order by A.insert_datetime DESC,
                         A.update_datetime DESC");

        }

        /*
        public function getAll_diffInfo_forSumary() {
            return $this->common_model->custom_query("select diff_id,pers_id,CONCAT(elder_firstname, ' ', elder_lastname) as name, date_of_visit,visitor_name,consi_result,req_pers_id,req_trouble,CONCAT(req_firstname, ' ', elder_lastname) as req_name,date_of_req,visit_alm_trouble,visit_alm_help from diff_info where (delete_user_id IS NULL && delete_datetime IS NULL) order by insert_datetime DESC,update_datetime DESC");
        }
        */

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

        public function get_diffTrouble($diff_id='') {
            $tmp = array();
            $tmp = $this->common_model->get_where_custom('diff_trouble', 'diff_id', $diff_id);
            $tmp = sort_array_with($tmp,'trb_code');
            return $tmp;
        }
        public function get_diffHelp($diff_id='') {
            $tmp = array();
            $tmp = $this->common_model->get_where_custom('diff_help', 'diff_id', $diff_id);
            $tmp = sort_array_with($tmp,'help_code');
            return $tmp;
        }
        public function get_diffHelpGuide($diff_id='') {
            $tmp = array();
            $tmp = $this->common_model->get_where_custom('diff_help_guide', 'diff_id', $diff_id);
            $tmp = sort_array_with($tmp,'help_guide_code');
            return $tmp;
        }

/*        public function getOnce_diffInfo($diff_id=0) {
            return rowArray($this->common_model->get_where_custom('diff_info', 'diff_id', $diff_id));
        }
*/

        public function getAll_reqChanel() {
            return $this->common_model->getTableOrder('std_req_channel', 'chn_id', 'ASC');
        }        

        public function getOnce_reqChanel($chn_code='') {
            return rowArray($this->common_model->get_where_custom('std_edu_level', 'chn_code', $chn_code));
        } 

    }
?>