<?php
	class Ordering_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }
        public function getMaxOrder($table,$field,$where=''){
	        $row=rowArray($this->common_model->custom_query("select max(".$field.") from ".$table." where ".$where));
	        return (int)$row["max(".$field.")"];
	    }

	    public function getMaxOrder_and_Add($table,$field,$where=''){
	        $row=rowArray($this->common_model->custom_query("select max(".$field.") from ".$table." where ".$where));
	        settype($row["max(".$field.")"],'integer');
	        return ++$row["max(".$field.")"];
	    }

	    public function afterDeleteOrder($table,$field,$pk_name,$where=''){
			//$rows=$this->common_model->get_where_custom_and_order($table,array("CN_Allow!="=>'3'),$field,'ASC');
			//$rows = $this->common_model->custom_query("select ".$field." from ".$table." where ".$where order by );
			$rows = $this->common_model->custom_query("SELECT * FROM {$table} WHERE {$where} ORDER BY {$field} ASC");
			//dieArray($rows);
			$i=1;
			foreach($rows as $row){
				$this->common_model->update($table,array($field => $i),array($pk_name => $row[$pk_name]));
				$i++; 
			}
		}

	  //   public function orderUp(){
	  //   	$temp=0;
			// $row=rowArray($this->common_model->get_where_custom_field('image_slider','IS_ID',$id,'IS_Order'));
			// $IS_Order=(int)$row['IS_Order'];
			// if(($IS_Order-1)==0){
			// 	$IS_OrderMax=$this->webinfo_model->getMaxOrder('image_slider','IS_Order',"IS_Allow!='3' AND WD_ID = {$WD_ID}");	
			// 	$IS_Order=$IS_OrderMax;
			// 	$temp=$IS_Order;
			// }else
			// 	$IS_Order=$IS_Order-1;

			// $row=rowArray($this->common_model->get_where_custom_and('image_slider',array('IS_Order'=>$IS_Order,"IS_Allow!="=>'3','WD_ID'=>$WD_ID)));
			// $id1=$row['IS_ID'];
			// $IS_Order1=1;
			// if($temp==0)
			// 	$IS_Order1=$IS_Order+1;

			// $this->common_model->update('image_slider',array('IS_Order' => $IS_Order,'IS_UserUpdate'=>get_session('M_ID'),'IS_DateTimeUpdate'=>date("Y-m-d H:i:s")),array('IS_ID' => $id)); 
			// $this->common_model->update('image_slider',array('IS_Order' => $IS_Order1,'IS_UserUpdate'=>get_session('M_ID'),'IS_DateTimeUpdate'=>date("Y-m-d H:i:s")),array('IS_ID' => $id1));

	  //   }

	  //   public function orderDown(){
	  		// $temp=0;
			// $row=rowArray($this->common_model->get_where_custom_field('image_slider','IS_ID',$id,'IS_Order'));
			// $IS_Order=(int)$row['IS_Order'];
			// $IS_OrderMax=$this->webinfo_model->getMaxOrder('image_slider','IS_Order',"IS_Allow!='3' AND WD_ID = {$WD_ID}");	
			// if(($IS_Order+1)>$IS_OrderMax){
			// 	$IS_Order=1;
			// 	$temp=$IS_OrderMax;
			// }else
			// 	$IS_Order=$IS_Order+1;
				
			// $row=rowArray($this->common_model->get_where_custom_and('image_slider',array('IS_Order'=>$IS_Order,"IS_Allow!="=>'3','WD_ID'=>$WD_ID)));
			// $id1=$row['IS_ID'];
			// $IS_Order1=$temp;
			// if($temp==0)
			// 	$IS_Order1=$IS_Order-1;

			// $this->common_model->update('image_slider',array('IS_Order' => $IS_Order1,'IS_UserUpdate'=>get_session('M_ID'),'IS_DateTimeUpdate'=>date("Y-m-d H:i:s")),array('IS_ID' => $id1));
			// $this->common_model->update('image_slider',array('IS_Order' => $IS_Order,'IS_UserUpdate'=>get_session('M_ID'),'IS_DateTimeUpdate'=>date("Y-m-d H:i:s")),array('IS_ID' => $id)); 
	  
	  //   }
	}
?>