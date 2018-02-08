<?php
class my_general{
	public $ci;
	public function __construct(){
		$this->ci=&get_instance();
	}
	public function get_ci(){
		return $this->ci;
	}
}

function setMsg($msg_code='',$msg_title='') {
	$obj=new my_general();
	$tmp = @rowArray($obj->get_ci()->common_model->get_where_custom('std_msg','msg_code',$msg_code));
	if(isset($tmp['msg_title'])) {
		$msg_title = $msg_title==''?$tmp['msg_title']:$msg_title;
		$obj->get_ci()->session->set_flashdata('msg_type',$tmp['msg_title']);
		$obj->get_ci()->session->set_flashdata('msg_form',$msg_title);
		return array('msg_code'=>$msg_code,'msg_type'=>$tmp['msg_type'],'msg_title'=>$msg_title);
	}else {
		return;
	}
}
function getMsg($msg_code='') {
	$obj=new my_general();
	$tmp = @rowArray($obj->get_ci()->common_model->get_where_custom('std_msg','msg_code',$msg_code));
	if(isset($tmp['msg_title'])) {
		return $tmp['msg_title'];
	}else {
		return;
	}
}

function getUser(){
	$obj=new my_general();
	return $obj->get_ci()->session->userdata('user_id');
}

function chkUserLogin() {
	$obj=new my_general();
	if(!$obj->get_ci()->session->userdata('pid'))redirect('member/admin_access','refresh');
	else return true;
}

function page404($data=array('head_title'=>'Home','title'=>'404 Error Page','content_view'=>'page404')){
	$obj=new my_general();
	$obj->get_ci()->load->library('template',
		array('name'=>'admin_template1',
			'setting'=>array('data_output'=>''))
	);
	return $obj->get_ci()->template->load('index_page', $data); 
}
function page500($data=array('head_title'=>'Home','title'=>'500 Error Page','content_view'=>'page500')){
	$obj=new my_general();
	$obj->get_ci()->load->library('template',
		array('name'=>'admin_template1',
			'setting'=>array('data_output'=>''))
	);
	return $obj->get_ci()->template->load('index_page', $data); 
}

function wbGetuser(){
	$obj=new my_general();
	$wb_sess = $obj->get_ci()->session->userdata('wb_sess');
	return $wb_sess['M_ID'];

}
function getDatetime(){
	return date("Y-m-d H:i:s");
}
function sort_array_with($arr,$key){
	$temp=array();
	foreach($arr as $data){
		$temp[$data[$key]]=$data;
	}
	return $temp;
}

function sort_array_key($arr){
	$temp=array();
	foreach($arr as $key=>$data){
		$temp[]=$data;
	}
	return $temp;
}
function sort_array_key_old($arr){
	$temp=array();
	$data_return=array();
	if(count($arr)<=1)return $arr; 
	$min='';
	foreach($arr as $key=>$data){
		$temp[]=$key;
	}
	for($i=0;$i<count($arr);$i++){
		$min=$temp[$i];
		$key='';
		for($j=$i;$j<count($arr);$j++){
			if($temp[$j]<$min){
				$min=$temp[$j];
				$key=$j;
			}
		}
		if($key!=''){
			$datatmp=$temp[$i];
			$temp[$i]=$temp[$key];
			$temp[$key]=$datatmp;
		}
	}
	for($i=0;$i<count($temp);$i++){
		$data_return[$temp[$i]]=$arr[$temp[$i]];
	}
	return $data_return;
}
function nameTitle($str='',$length=80){
	if(strlen($str) > $length)
		return mb_substr($str,0,$length,'UTF-8')." ...";
	else
		return $str;
}
function downloadName($str='',$length=35){
	return mb_substr(str_replace(array("+","(",")","'", "\"", "&quot;"), "", $str),0,$length,'UTF-8');
}

function urlName($str='',$length=70){
	return mb_substr(str_replace(array("+","(",")","'", "\"", "&quot;"," "), "-", $str),0,$length,'UTF-8');
}
function RandomNameFile(){
	$result='';
	for($a=1;$a<10;$a++){ // จำนวนรอบที่ต้องการทดสอบ หรือ สุ่ม
		$number='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; // ตัวแปร ที่จะเอาไปสุ่ม
		for($i=1;$i<10;$i++){ // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
			$random=rand(0,strlen($number)-1); //สุ่มตัวเลข
				
			$cut_txt=substr($number,$random,1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
			$result.=substr($number,$random,1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
			$number=str_replace($cut_txt,'',$number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
		}
		if($a<10)
			$result=''; // ล้างค่าตัวแปรออก เพื่อรับค่าใหม่ในรอบต่อไป
	}
	return $result;
}

function RandomNameFileEncode($data=''){
	return str_replace(".",rand(),uniqid($data.md5(strtotime(date("Y-m-d H:i:s")).rand()),true));
}

function rowArray($rows){
	if(sizeof($rows)>0)
		return $rows[0];
	else
		return array();
}
function rowArray2($rows){
	if(sizeof($rows)>0)
		return $rows[0];
	else
		return '';
}
function dieArray($arr=''){
	echo '<pre>';
	die(print_r($arr));
	echo '</pre>';
}
function dieFont($str=''){
	die('<h1>'.$str.'</h1>');
}

function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   	$randstring = '';
    for ($i = 0; $i < 10; $i++) {
       	$randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
function setZeroString($string,$num){
	if($string=='')return '';
	$str='';
	for($i=0;$i<($num-strlen($string));$i++){
		$str.='0';
	}
	return $str.$string;
}
function dateChange($date='',$method=0){
	if($date=='')
		return '';
	if($method==0){
		$arr=explode('/',$date);
		return ($arr[2]-543).'-'.$arr[1].'-'.$arr[0];
	}else if($method==2){
		$arr=explode('/',$date);
		return $arr[2].'-'.$arr[1].'-'.$arr[0];
	}elseif ($method==3) {
		$arr=explode('-',$date);
		if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
			return '';
		return $arr[2].'/'.$arr[1].'/'.($arr[0]);
	}elseif ($method==4) {
		$arr=explode('-',$date);
		if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
			return '';
		return $arr[2].'-'.$arr[1].'-'.($arr[0]);
	}else{
		$arr=explode('-',$date);
		if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
			return '';
		return $arr[2].'/'.$arr[1].'/'.($arr[0]+543);
	}
}
function dateChange2($date=''){
	if($date=='')
		return '';
	
	$arr=explode('-',$date);
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	
	return ($arr[2] * 1).'/'.($arr[1] * 1).'/'.($arr[0]);
	
}
function dateChange3($date=''){
	if($date=='')
		return '';
	
	$arr=explode('-',$date);
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	
	return ($arr[2] * 1).'/'.($arr[1] * 1).'/'.date('Y');
	
}
function formatDateThai($date){
	$arr=explode('-',$date);
	if ($date=='') {
		return '';
	}
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	$thai_month_arr=array(
	 "0"=>"",
	 "1"=>"มกราคม",
	 "2"=>"กุมภาพันธ์",
	 "3"=>"มีนาคม",
	 "4"=>"เมษายน",
	 "5"=>"พฤษภาคม",
	 "6"=>"มิถุนายน", 
	 "7"=>"กรกฎาคม",
	 "8"=>"สิงหาคม",
	 "9"=>"กันยายน",
	 "10"=>"ตุลาคม",
	 "11"=>"พฤศจิกายน",
	 "12"=>"ธันวาคม"     
	);
	$arr=explode('-',$date);
	return (int)$arr[2].' '.$thai_month_arr[(int)$arr[1]].' '.($arr[0]+543);
}

function formatDateThaiFromDatatime($datetime){
	$arr=explode(' ',$datetime);
	return formatDateThai($arr[0]).' '.$arr[1];
}

function formatDateThai1($date){
	if ($date=='') {
		return '';
	}
	$arr=explode('-',$date);
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	$thai_month_arr=array(
	 "0"=>"",
	 "1"=>"ม.ค.",
	 "2"=>"ก.พ.",
	 "3"=>"มี.ค.",
	 "4"=>"เม.ย.",
	 "5"=>"พ.ค.",
	 "6"=>"มิ.ย.", 
	 "7"=>"ก.ค.",
	 "8"=>"ส.ค.",
	 "9"=>"ก.ย.",
	 "10"=>"ต.ค.",
	 "11"=>"พ.ย.",
	 "12"=>"ธ.ค."     
	);
	$arr=explode('-',$date);
	return (int)$arr[2].' '.$thai_month_arr[(int)$arr[1]].' '.($arr[0]+543);
}
function dtParse($datetime){
	$arr=explode(' ',$datetime);
	
	$l2 = explode(':',$arr[1]);
	unset($l2[2]);
	$l2 = implode('.',$l2);

	return formatDateThai1($arr[0]).' '.$l2.' น.';
}

function formatDateUniNoM($date){
	$arr=explode('-',$date);
	if ($date=='') {
		return '';
	}
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	return $arr[2].'/'.$arr[1].'/'.$arr[0];
}
function formatDateUniNoMFromDatatime($datetime){
	$arr=explode(' ',$datetime);
	return formatDateUniNoM($arr[0]).' '.$arr[1];
}

function formatDateUni($date){
	$arr=explode('-',$date);
	if ($date=='') {
		return '';
	}
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	$ui_month_arr=array(
		"0"=>'',
		"1"=>'January',
		"2"=>'February',
		"3"=>'March',
		"4"=>'April',
		"5"=>'May',
		"6"=>'June',
		"7"=>'July',
		"8"=>'August',
		"9"=>'September',
		"10"=>'October',
		"11"=>'November',
		"12"=>'December',
	);
	$arr=explode('-',$date);
	return (int)$arr[2].' '.$ui_month_arr[(int)$arr[1]].' '.$arr[0];
}
function formatDateUniFromDatatime($datetime){
	$arr=explode(' ',$datetime);
	return formatDateThai($arr[0]).' '.$arr[1];
}

function formatDateUniMonthThai($date){
	$arr=explode('-',$date);
	if ($date=='') {
		return '';
	}
	if($arr[0]=='0000'||$arr[1]=='00'||$arr[2]=='00')
		return '';
	$ui_month_arr=array(
		"0"=>'',
		"1"=>'มกราคม',
		"2"=>'กุมภาพันธ์',
		"3"=>'มีนาคม',
		"4"=>'เมษายน',
		"5"=>'พฤษภาคม',
		"6"=>'มิถุนายน',
		"7"=>'กรกฎาคม',
		"8"=>'สิงหาคม',
		"9"=>'กันยายน',
		"10"=>'ตุลาคม',
		"11"=>'พฤศจิกายน',
		"12"=>'ธันวาคม',
	);
	$arr=explode('-',$date);
	return (int)$arr[2].' '.$ui_month_arr[(int)$arr[1]].' '.$arr[0];
}
function formatDateUniMonthThaiFromDatatime($datetime){
	$arr=explode(' ',$datetime);
	return formatDateUniMonthThai($arr[0]).' '.$arr[1];
}

function formatDateThai_WithOutDayNumber($date){
	$thai_month_arr=array(
	 "0"=>"",
	 "1"=>"มกราคม",
	 "2"=>"กุมภาพันธ์",
	 "3"=>"มีนาคม",
	 "4"=>"เมษายน",
	 "5"=>"พฤษภาคม",
	 "6"=>"มิถุนายน", 
	 "7"=>"กรกฎาคม",
	 "8"=>"สิงหาคม",
	 "9"=>"กันยายน",
	 "10"=>"ตุลาคม",
	 "11"=>"พฤศจิกายน",
	 "12"=>"ธันวาคม"     
	);
	$arr=explode('-',$date);
	return $thai_month_arr[(int)$arr[1]].' '.($arr[0]+543);
}

function formatDateThai_NextMonth($date){
	$thai_month_arr=array(
	 "0"=>"",
	 "1"=>"กุมภาพันธ์",
	 "2"=>"มีนาคม",
	 "3"=>"เมษายน",
	 "4"=>"พฤษภาคม",
	 "5"=>"มิถุนายน",
	 "6"=>"กรกฎาคม", 
	 "7"=>"สิงหาคม",
	 "8"=>"กันยายน",
	 "9"=>"ตุลาคม",
	 "10"=>"พฤศจิกายน",
	 "11"=>"ธันวาคม",
	 "12"=>"มกราคม"     
	);
	$arr=explode('-',$date);
	if($arr[1]==12)
		$arr[0] += 1;
	return $thai_month_arr[(int)$arr[1]].' '.($arr[0]+543);
}

function formatDateThai_MonthOnly($date){
	$thai_month_arr=array(
	 "0"=>"",
	 "1"=>"มกราคม",
	 "2"=>"กุมภาพันธ์",
	 "3"=>"มีนาคม",
	 "4"=>"เมษายน",
	 "5"=>"พฤษภาคม",
	 "6"=>"มิถุนายน", 
	 "7"=>"กรกฎาคม",
	 "8"=>"สิงหาคม",
	 "9"=>"กันยายน",
	 "10"=>"ตุลาคม",
	 "11"=>"พฤศจิกายน",
	 "12"=>"ธันวาคม"     
	);
	$arr=explode('-',$date);
	if($arr[1]==12)
		$arr[0] += 1;
	return $thai_month_arr[(int)$arr[1]];
}

function set_session($session_name='',$data=''){
	$obj=new my_general();
	return $obj->get_ci()->session->set_userdata($session_name,$data);
}
function get_session($session_name=''){
	$obj=new my_general();
	return $obj->get_ci()->session->userdata($session_name);
}
function get_inpost($post_name=''){
	$obj=new my_general();
	$temp = xss_clean(htmlspecialchars(($obj->get_ci()->input->post(trim($post_name)))));
	return $temp;
}
function get_inpost_arr($post_name=''){
	$obj=new my_general();
	$arr = $obj->get_ci()->input->post(trim($post_name));
	$arr_temp = array();
	foreach($arr as $key=>$value){
		$arr_temp[$key] = xss_clean(htmlspecialchars(($value)));
	}
	return $arr_temp;
}
function get_inget($get_name=''){
	$obj=new my_general();
	$temp = xss_clean(htmlspecialchars(($obj->get_ci()->input->get(trim($post_name)))));
	return $temp; 
}
function uri_seg($segment_num){
	$obj=new my_general();
	return $obj->get_ci()->uri->segment(trim($segment_num));
}
function apppath(){
	return str_replace('\\','/', APPPATH);
}

function ens($arr=array()){
	return @serialize($arr);
}
function uns($str_arr){
	return @unserialize($str_arr);
}
function label($label) {
	$obj = new my_general();
	$rs = $obj->get_ci()->lang->line($label);
	if($rs != '')
		return $rs;
	else
		return $label;
}
function labelDB($label) {
	$obj = new my_general();
	if(isset($obj->get_ci()->template->labelDB[$label]))
		return $obj->get_ci()->template->labelDB[$label][getLang()];
	else 
		return $label;
}
function getLang() {
	$obj = new my_general();
	if($obj->get_ci()->input->cookie('dopa_lang', TRUE) != '' && $obj->get_ci()->input->cookie('dopa_lang', TRUE) != 'null') {
		return $obj->get_ci()->input->cookie('dopa_lang', TRUE);
	}else return 'TH';
}

function lang($var){
	if(is_serialized($var,$unsAar)){
		if($unsAar[getLang()] != ''){
			return $unsAar[getLang()];
		}else{
			return $unsAar['TH'];
		}
	}else if(isset($var['TH'])){
		if($var[getLang()]!='') {
			return $var[getLang()];
		}else {
			return $var['TH'];
		}
	}else{
		return $var;
	}
	
}

function langDate($date=''){
	if(getLang() == 'TH'){ 
		return formatDateThai($date); 
	}else{ 
		return formatDateUni($date);
	}
}

/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details.
 */ 
/**
 * Tests if an input is valid PHP serialized string.
 *
 * Checks if a string is serialized using quick string manipulation
 * to throw out obviously incorrect strings. Unserialize is then run
 * on the string to perform the final verification.
 *
 * Valid serialized forms are the following:
 * <ul>
 * <li>boolean: <code>b:1;</code></li>
 * <li>integer: <code>i:1;</code></li>
 * <li>double: <code>d:0.2;</code></li>
 * <li>string: <code>s:4:"test";</code></li>
 * <li>array: <code>a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}</code></li>
 * <li>object: <code>O:8:"stdClass":0:{}</code></li>
 * <li>null: <code>N;</code></li>
 * </ul>
 *
 * @author		Chris Smith <code+php@chris.cs278.org>
 * @copyright	Copyright (c) 2009 Chris Smith (http://www.cs278.org/)
 * @license		http://sam.zoy.org/wtfpl/ WTFPL
 * @param		string	$value	Value to test for serialized form
 * @param		mixed	$result	Result of unserialize() of the $value
 * @return		boolean			True if $value is serialized data, otherwise false
 */
function is_serialized($value, &$result = null)
{
	// Bit of a give away this one
	if (!is_string($value))
	{
		return false;
	}
	// Serialized false, return true. unserialize() returns false on an
	// invalid string or it could return false if the string is serialized
	// false, eliminate that possibility.
	if ($value === 'b:0;')
	{
		$result = false;
		return true;
	}
	$length	= strlen($value);
	$end	= '';
	switch ($value[0])
	{
		case 's':
			if ($value[$length - 2] !== '"')
			{
				return false;
			}
		case 'b':
		case 'i':
		case 'd':
			// This looks odd but it is quicker than isset()ing
			$end .= ';';
		case 'a':
		case 'O':
			$end .= '}';
			if ($value[1] !== ':')
			{
				return false;
			}
			switch ($value[2])
			{
				case 0:
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				break;
				default:
					return false;
			}
		case 'N':
			$end .= ';';
			if ($value[$length - 1] !== $end[0])
			{
				return false;
			}
		break;
		default:
			return false;
	}
	if (($result = @unserialize($value)) === false)
	{
		$result = null;
		return false;
	}
	return true;
}
function wordCensor($text=''){
	$obj = new my_general();
	$obj->get_ci()->load->helper('text');
	$disallowed = array( 
		"kuy","k u y","KUY","k.u.y",
		"ashole","a s h o l e","a.s.h.o.l.e",
		"bitch","b i t c h","b.i.t.c.h",
		"shit","s h i t","s.h.i.t",
		"fuck","f u c k","f.u.c.k",
		"dick","d i c k","d.i.c.k",
		"มึง","มึ ง","ม ึ ง","ม ึง","มงึ","มึ.ง","มึ_ง","มึ-ง","มึ+ง",
		"กู",
		"ควย","ค ว ย","ค.ว.ย","คอ วอ ยอ","คอ-วอ-ยอ",
		"ปี้",
		"เหี้ย","ไอ้เหี้ย","เชี้ย","เฮี้ย",
		"ชาติหมา","ชาดหมา","ช า ด ห ม า","ช.า.ด.ห.ม.า","ช า ติ ห ม า","ช.า.ติ.ห.ม.า",
		"สัดหมา","สัด","เย็ด","หี","สันดาน","แม่ง","ระยำ","ส้นตีน","แตด" ) ;
	return word_censor($text,$disallowed,"***");
}

?>