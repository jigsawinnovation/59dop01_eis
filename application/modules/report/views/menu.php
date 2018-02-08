<!DOCTYPE html>
<html>
    <head>
        <?php
            $site = $this->webinfo_model->getSiteInfo();
            $title = $site['site_title'].'(Menu)';

            $site['site_name'] = 'Data EIS';
            $site['site_title'] = 'Executive Information System';
            $site['site_bg_file'] = 'image44.jpg';
        ?>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="description" content="<?php echo $site['deprt_descp'];?>">
        <meta name="keywords" content="<?php echo $site['deprt_keywd'];?>">
        <meta name="author" content="Sonchai058">

        <link rel="shortcut icon" href="<?php echo path($site['site_icon_file'],'webconfig');?>" type="image/x-icon">
        <link rel="icon" href="<?php echo path($site['site_icon_file'],'webconfig');?>" type="image/x-icon">

        <!-- *************** inspinia-3 Template: CSS *************** -->
        <?php echo css_asset('../plugins/Static_Full_Version/css/bootstrap.min.css'); ?>
        <?php echo css_asset('../plugins/Static_Full_Version/font-awesome/css/font-awesome.css'); ?>
        <?php echo css_asset('../plugins/Static_Full_Version/css/animate.css'); ?>
        <?php echo css_asset('../plugins/Static_Full_Version/css/style.css'); ?>
        <!-- *************** End inspinia-3 Template: CSS *************** -->

        <?php
          echo css_asset('../admin/css/fontsset.css');
        ?>

        <?php
          echo css_asset('../admin/css/menu.css');
        ?>

        <?php //Set Background Path?>
        <style tyle="text/css">
            body {
              background: url('<?php echo path($site['site_bg_file'],'webconfig');?>');
            }
        </style>

        <title><?php echo $title; ?></title>

</head>

<body>
    <div id="wrapper">

        <div class="row" >
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0; background: transparent !important;">
                <div class="navbar-header" style="margin: 0px auto auto 50px;">
                    <a href="<?php echo site_url('control/main_module');?>" title="<?php echo $site['site_title'];?>">
                        <h1 class="title"><?php echo strtoupper($site['site_name']);?></h1>
                        <h2 class="sec1_title"><?php echo $site['site_title'];?></h2>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right" style="margin: 0px; color: #fff !important">
                    <?php
                    //$user = get_session('user_firstname').' '.get_session('user_lastname');
                    $user = get_session('user_firstname');
                    ?>
                    <li title="<?php echo $user;?>">
                        <a style="font-size: 18px;" href="#profile"> <span style="color: #fff !important" class="m-r-sm text-muted welcome-message"><?php echo $user;?></span> <img src="<?php echo 'https://center.dop.go.th/'.get_session('user_photo_file');?>" class="profile img-circle border-1" style="border: 4px #eee solid;" alt="<?php echo $user;?>" width="42" height="42">
                        </a>
                    </li>

                    <li>
                        <a title="ช่วยเหลือ" href="#help" style="display: inline;">
                            <i style="font-size: 18px; color: #fff !important" class="fa fa-question-circle" aria-hidden="true"></i>
                        </a>
                        <a title="ออกจากระบบ" href="<?php echo site_url('manage/logout');?>" style="display: inline;">
                            <i style="font-size: 18px; color: #fff !important" class="fa fa-power-off" aria-hidden="true"></i>
                        </a>

                    </li>
                </ul>

            </nav>
        </div>


        <!--<div class="animated fadeInRight">-->
        <div class="row" style="background: transparent !important;">
            <div class="container" style="min-height: 600px;">

                <div class="row permiss_head" style="" >
                    <div class="col-xs-12 col-sm-12 permiss_head-panel" style="border-right:0; font-size: 18px">
                                <table class="table table-bordered">
                                    <thead style="">
                                    <tr>
                                        <th style="background-color: #1d3886 !important;width:1% !important;text-align:center">#</th>
                                        <th style="background-color: #1d3886 !important;text-align:center">ระบบฐานข้อมูล</th>
                                        <th style="background-color: #1d3886 !important;width:10% !important; text-align:center">จำนวน (รายการ)</th>
                                        <th style="background-color: #1d3886 !important;width:30% !important; text-align:center">หมายเหตุ</th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color: rgba(33, 29, 29, 0.85)">
                                    <tr>
                                        <td>1</td>
                                        <td>ทะเบียนประวัติผู้สูงอายุ (ฐานข้อมูลกลาง)</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from pers_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from pers_info where delete_datetime IS NULL AND LENGTH(pid)=13"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                            รายการ ที่มีเลขบัตรประชาชน
                                         </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>การสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from diff_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>ศูนย์พัฒนาการจัดสวัสดิการสังคมผู้สูงอายุ</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from adm_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>การปรับสภาพแวดล้อมและสิ่งอำนวยความสะดวกฯ</td>
                                        <td class="text-right">
                                            <?php
                                            $rs = 0;
                                            $row = rowArray($this->common_model->custom_query("select count(*) from impv_home_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){$rs = $row['count(*)'];}
                                            ?>
                                            <?php
                                            $rs1 = 0;
                                            $row1 = rowArray($this->common_model->custom_query("select count(*) from impv_place_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){$rs1 = $row1['count(*)'];}
                                            echo number_format($rs+$rs1);
                                            ?>
                                        </td>
                                        <td>บ้านพักอาศัย <?php echo number_format($rs);?> + สถานที่ <?php echo number_format($rs1);?> รายการ</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>การสงเคราะห์ในการจัดการศพผู้สูงอายุตามประเพณี</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from fnrl_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>คลังปัญญาผู้สูงอายุ</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from wisd_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>อาสาสมัครดูแลผู้สูงอายุ (อผส.)</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from volt_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td>อยู่ระหว่างนำเข้าข้อมูลส่วนที่เหลือ</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>การเตรียมความพร้อมสู่วัยสูงอายุ (การให้ความรู้ก่อนวัยเกษียณ)</td>
                                        <td class="text-right">
                                            <?php
                                            $row = rowArray($this->common_model->custom_query("select count(*) from prep_dkm_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){echo number_format($row['count(*)']);}else{echo 0;};
                                            ?>
                                        </td>
                                        <td>ทะเบียนรายการองค์ความรู้ (สำหรับเผยแพร่)</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>โรงเรียนผู้สูงอายุ</td>
                                        <td class="text-right">
                                            <?php
                                            $rs = 0;
                                            $row = rowArray($this->common_model->custom_query("select count(*) from schl_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){$rs = $row['count(*)'];}
                                            ?>
                                            <?php
                                            $rs1 = 0;
                                            $row1 = rowArray($this->common_model->custom_query("select count(*) from schl_qlc_info where delete_datetime IS NULL"));
                                            if(isset($row['count(*)'])){$rs1 = $row1['count(*)'];}
                                            echo number_format($rs+$rs1);
                                            ?>
                                        </td>
                                        <td>โรงเรียน <?php echo number_format($rs);?> + ศพอส. <?php echo number_format($rs1);?> รายการ</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>ส่งเสริมการจ้างงานผู้สูงอายุ</td>
                                        <td class="text-right">
                                            <?php
                                            $rs = 0;
                                            $row = rowArray($this->common_model->custom_query("select count(*) from edoe_job_vacancy"));
                                            if(isset($row['count(*)'])){$rs = $row['count(*)'];}
                                            ?>
                                            <?php
                                            $rs1 = 0;
                                            $row1 = rowArray($this->common_model->custom_query("select count(*) from edoe_older_emp_reg"));
                                            if(isset($row['count(*)'])){$rs1 = $row1['count(*)'];}
                                            echo number_format($rs+$rs1);
                                            ?>
                                        </td>
                                        <td>ตำแหน่งว่าง <?php echo number_format($rs);?> + ขึ้นทะเบียน <?php echo number_format($rs1);?> รายการ</td>
                                    </tr>
                                    </tbody>
                                </table>
                    </div>
                </div>

               <div class="row permiss_head" style="border-top: 1px solid rgba(255,255,255,0.4);" >

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(84);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(84,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/service_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(85);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(85,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/kpiorg_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-building-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(86);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(86,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo base_url("report/fnrl_report");?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(87);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(87,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/impv_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-adjust" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(88);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(88,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/wisd_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(89);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(89,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo base_url("report/volt_report");?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(90);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(90,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/stat_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-book" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(91);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(91,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/kpiorg_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(92);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(92,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo base_url("dreport/school_report");?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-sliders" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(93);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(93,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/edoe_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(94);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(94,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/kpiorg_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(95);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(95,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo base_url("report/kpiorg_report");?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-database" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(96);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(96,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo site_url('report/kpiorg_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-area-chart" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(98);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(98,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
                                <?php }else{?>href="<?php echo base_url('report/gateway_report');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left">
                                        <i class="fa fa-exchange" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <br/>
        <!--
        <div class="footer" style="background: transparent !important;">
        <div style="background: transparent !important;">
            <div class="pull-right" style="font-size: 14px; padding: 15px; color: #858C92 !important;">
                เวอร์ชั่น 1.0
            </div>
            <div style="font-size: 14px; padding: 15px; color: #858C92 !important;">
                © สงวนลิขสิทธ์โดย<strong> กรมกิจการผู้สูงอายุ</strong> พัฒนาโดย บริษัท จิ๊กซอว์ อินโนเวชั่น จำกัด
            </div>
        </div>
        -->

    </div>
</body>
    <!-- *************** inspinia-3 Template: JS *************** ----->
        <!-- Mainly scripts -->
    <?php echo js_asset('../plugins/Static_Full_Version/js/jquery-3.1.1.min.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/bootstrap.min.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/metisMenu/jquery.metisMenu.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>
        <!-- Custom and plugin javascript -->
    <?php echo js_asset('../plugins/Static_Full_Version/js/inspinia.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/pace/pace.min.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>
    <!-- *************** End inspinia-3 Template: JS *************** -->
</html>
