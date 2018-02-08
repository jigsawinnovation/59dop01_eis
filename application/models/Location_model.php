<?php
class Location_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }

    function getProvice($pId="",$pname=""){

        $where=" 1";
        #$where.=($pId!="")?" AND code='{$pId}'":"";
        // $where.=($pname!="")?" AND (name_th LIKE '%{$pname}%' OR name_eng LIKE '%{$pname}%') ":"";

        $sql ="SELECT
                    area_code,
                    area_name_th AS provinceName,
                    latitude,
                    longitude
               FROM std_area
               WHERE {$where} AND area_type = 'Province' ORDER BY provinceName ASC";
        $query=$this->db->query($sql);
        return $query;
    }

    function getAmphur($pId,$aId=""){
        $where ='';
        if($pId!=''){
            $pId = substr($pId, 0, 2);
            $where.=($pId!="")?" AND area_code LIKE '{$pId}%' ":"";
            #$where.=($aId!="")?" AND code='{$aId}'":"";

            $sql ="SELECT
                    area_code,
                    area_name_th AS districtName,
                    latitude,
                    longitude
               FROM std_area
               WHERE 1 {$where} AND area_type = 'Amphur' ORDER BY area_code ASC";
            $query=$this->db->query($sql);
            return $query;
        }

    }

    function getTambol($aId="",$tId=""){
        $where='';
        if($aId!=""){
            $aId = substr($aId, 0, 4);
            $where.=($aId!="")?" AND area_code LIKE '{$aId}%' ":"";
            #$where.=($tId!="")?" AND code = '{$tId}'":"";

            $sql ="SELECT
                    area_code,
                    area_name_th AS subdistrictName,
                    latitude,
                    longitude
               FROM std_area
               WHERE 1 {$where} AND area_type = 'Tambon' ORDER BY area_code ASC";
            $query=$this->db->query($sql);
            return $query;
        }

    }

    public function getDataProvinceByID($_id){
        // write code
        $strTable=$this->table['area_province'];
        $cond="";

        $row=array();
        $data=array();
        $strSQL = "
        SELECT *,area_name_th AS STR_NAME
        FROM std_area
        WHERE $strTable.area_code =  '$_id'
        ";
        $query = $this->db->query($strSQL);
        if($query->num_rows){
            foreach($query->result() as $row){
                $data[$row->code]=$row;
            }
        }

        return $data;
    }

    public function getDataDistrictByID($_id){
        // write code
        $strTable=$this->table['area_district'];
        $cond="";

        $row=array();
        $data=array();
        $strSQL = "
        SELECT *,area_name_th AS STR_NAME
        FROM std_area
        WHERE $strTable.area_code =  '$_id'
        ";
        $query = $this->db->query($strSQL);
        if($query->num_rows){
            foreach($query->result() as $row){
                $data[$row->code]=$row;
            }
        }

        return $data;
    }

    public function getDataSubDistrictByID($_id){
        // write code
        $strTable=$this->table['area_subdistrict'];
        $cond="";

        $row=array();
        $data=array();
        $strSQL = "
        SELECT *,area_name_th AS STR_NAME
        FROM std_area
        WHERE $strTable.area_code =  '$_id'
        ";
        $query = $this->db->query($strSQL);
        if($query->num_rows){
            foreach($query->result() as $row){
                $data[$row->code]=$row;
            }
        }

        return $data;
    }

}