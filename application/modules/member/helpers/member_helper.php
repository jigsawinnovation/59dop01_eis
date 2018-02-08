<?php
/*
function tname($id=4){ //คำนำหน้าชื่อ
	$arr = array(1=>'นาง',2=>'นางสาว',3=>'นาย',4=>'ไม่ระบุ');
	return $arr[$id];
}

function sex($id='S'){ //คำนำหน้าชื่อ
	$arr = array('M'=>'ชาย','F'=>'หญิง','S'=>'ไม่ระบุ');
	return $arr[$id];
}

function allow($id=3){ //สถานะ
	$arr = array(1=>'ปกติ',2=>'ระงับ',3=>'ลบ/บล็อก');
	return $arr[$id];
}

function allow1($id=3){ //สถานะ
	$arr = array(1=>'เผยแพร่',2=>'ไม่เผยแพร่',3=>'ลบ/บล็อก');
	return $arr[$id];
}

function process_list($P_ID=0,&$i,$P_ID_arr) {
	$obj=new my_general();
	$str='';

	$process_sub = $obj->get_ci()->admin_model->getAll_permissions_with_parentID($P_ID);
	
	if(count($process_sub)>0){
		$str = '<ul class="sublist">';
		foreach ($process_sub as $key1 => $value1) {
			$name1 = uns($value1['P_Name']);
			$str.= "<li>
				<input class='child parent{$P_ID}' data-parent='{$P_ID}' type='checkbox' name='p[".$i."]' ";
			if($P_ID_arr[$i] == 1){ 
				$str.="checked"; 
			}
			$str.=" value='{$value1['P_ID']}'>
				{$name1['TH']}";
			$i++;
			$str.= process_list($value1['P_ID'],$i,$P_ID_arr);
			$str.= "</li>";
		}
		$str."</ul>";
		return $str;
	}
}

function process_edit_list($P_ID=0,$lang='TH') {
	$obj=new my_general();
	$str='';

	$process_sub = $obj->get_ci()->admin_model->getAll_permissions_with_parentID($P_ID);
	
	if(count($process_sub)>0){
		$str = '<ul class="sublist">';
		foreach ($process_sub as $key1 => $value1) {
			$name1 = uns($value1['P_Name']);
			$str.= "<li>
				 - 
				<input class='txtinput in_medium' data-parent='{$P_ID}' type='text' name='p[{$lang}][".$value1['P_ID']."]' ";

			$str.=" value='{$name1[$lang]}'>";
			$str.= process_edit_list($value1['P_ID']);
			$str.= "</li>";
		}
		$str."</ul>";
		return $str;
	}
}
*/
?>