<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('url','form','general','file','html','asset','directory'));
		$this->load->library(array('session','encrypt'));
        $this->load->model(array('member/admin_model','member/member_model','common_model','useful_model','webconfig/webinfo_model'));

		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);

		chkUserLogin(); 		 //Check User Login
	}
	function __deconstruct() {
		$this->db->close();
	}	

	public function main_module($process_action='View'){

		$data = array();
		$this->template->load('menu',$data);
	}

	public function dashboard($process_action='View'){

		$data = array();
		$data['process_action'] = $process_action;		
		$data['content_view'] = 'main';
		$data['head_title'] = 'Home';
		$data['title'] = '	Dashboard';	
				
		$this->template->load('index_page',$data);
	}

/*	
	function pdf()
	{
	    require_once(APPPATH."libraries/html2pdf/setPDF.php"); // ไฟล์สำหรับกำหนดรายละเอียด pdf 
	    
	    /*
	        ---- ---- ---- ----
	        your code here
	        ---- ---- ---- ----
	    */
		// เพิ่มหน้าใน PDF 
		//$pdf->AddPage();
		 
		// กำหนด HTML code หรือรับค่าจากตัวแปรที่ส่งมา
		//  กรณีกำหนดโดยตรง
		//  ตัวอย่าง กรณีรับจากตัวแปร
		// $htmlcontent =$_POST['HTMLcode'];
		//$htmlcontent='<p>ทดสอบ</p>';
		//$htmlcontent=stripslashes($htmlcontent);
		//$htmlcontent=AdjustHTML($htmlcontent);
		 
		// สร้างเนื้อหาจาก  HTML code
		//$pdf->writeHTML($htmlcontent, true, 0, true, 0);
		 
		// เลื่อน pointer ไปหน้าสุดท้าย
		//$pdf->lastPage();
		 
		// ปิดและสร้างเอกสาร PDF
		//ob_end_clean();
		//$pdf->Output('test.pdf', 'I');	        

	    //$data = array();
	    //$this->load->view('pdfreport', $data);
	//}
	// public function template1(){

	// 	//dieFont($this->encrypt->decode("pp/rgRf0CaI4m4VLGJjo+apju72lR5f/IIwoQznamipXSlEY2jtvsn2WDFzxBV80Xz86Hq8k7xRriyldrUyjWw=="));

	// 	//$GP_Value = 7;
	// 	//$this->admin_model->get_permiss_iniz($GM_ID,$GP_Value,$P_Process,$data);
	// 	$data['head_title'] = 'การสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก';
	// 	$data['title'] = 'รายการสงเคราะห์1';
	// 	$data['content_view'] = 'content_template1';

	// 	$this->template->load('index_page',$data);
	// }
	// public function template2(){
	// 	//$GP_Value = 7;
	// 	//$this->admin_model->get_permiss_iniz($GM_ID,$GP_Value,$P_Process,$data);

	// 	$data['head_title'] = 'การสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก';
	// 	$data['title'] = 'รายการสงเคราะห์2';
	// 	$data['content_view'] = 'content_template2';

	// 	$this->template->load('index_page',$data);
	// }

/*	public function file_browser($module_name=''){
		$path = "./assets/";
		if($module_name != ''){
			$path .= "modules/{$module_name}/";
		}
		$folder = get_inpost('folder');
		if($folder == ''){
			echo "No data !!";
			die();
		}
		$fdlist = array();
		$map = directory_map($path.$folder, FALSE, TRUE);
		if(get_inpost('type') == 'images'){
			$ext_arr = array("gif","jpeg","jpg","png");
		}else{
			$ext_arr = array("gif","jpeg","jpg","png","tiff","doc","docx","txt","odt","xls","xlsx","pdf","ppt","pptx","pps","ppsx","mp3","m4a","ogg","wav","mp4","m4v","mov","wmv","flv","avi","mpg","ogv","3gp","3g2","zip","csv");
		}
		
		foreach ($map as $k => $v) {
			if(gettype($v) == 'array'){
				$fd = rtrim($k,'\\');
				$fdlist[] = $fd.".folder";
				unset($map[$k]);
			}else{
				$ext = @end(explode('.', $v));
				if(!in_array(strtolower($ext), $ext_arr)){
					unset($map[$k]);
				}
			}
		}
		$map = array_merge($fdlist,$map);
		echo json_encode(array('OK'=>TRUE,'module_name'=>$module_name,'item'=>$map));
		die();
	}
*/
	
}
