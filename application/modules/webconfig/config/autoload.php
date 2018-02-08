<?php  
   
    $autoload = array(
        'helper'    => array('url','form','general','file','html','asset','member/member'),
        'libraries' => array('session','encrypt'),
        'model' => array('member/admin_model','member/member_model','common_model','useful_model','webinfo_model','files_model'),
    );


?>