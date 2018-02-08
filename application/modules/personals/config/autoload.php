<?php  
    $autoload = array(
        'helper'    => array('url','form','general','file','html','asset'),
        'libraries' => array('session','encrypt'),
        'model' => array('member/admin_model','member/member_model','common_model','useful_model','files_model','webconfig/webinfo_model','personal_model'),
    );
?>