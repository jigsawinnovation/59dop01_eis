<!DOCTYPE html>
<html>
    <head>
        <?php 
            $site = $this->webinfo_model->getSiteInfo(); 
            $title = $site['site_title'].'(Login)';

            $site['site_name'] = 'Data EIS';
            $site['site_title'] = 'Executive Information System';
            $site['site_bg_file'] = 'image44.jpg';

            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
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
          echo css_asset('../admin/css/login.css');
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
            <div class="login">
                <form action="<?php echo site_url('member/admin_access/login');?>" method="post" class="form-signin" autocomplete="off">

                    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />

                    <div title="<?php echo strtoupper($site['site_name']);?>" class="row logo">
                        <div class="col-sm-12 text-center">
                            <h1 class='title'><?php echo strtoupper($site['site_name']);?></h1>
                            <h4 class="sec1_title"><?php echo $site['site_title'];?></h4>
                        </div>
                    </div>
                    <br/>

                    <div class="row clearfix">

                        <div class="col-xs-12 col-sm-12 text-right">
                            &nbsp;<span id="wrn"><?php echo $wrn;?></span>
                        </div>

                        <div class="col-xs-12 col-sm-12">
                            <input type="text" class="form-control input_idcard" value="" name="pid" placeholder="เลขประจำตัวประชาชน" required autofocus="" />
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <input type="password" class="form-control" value="" name="passcode" placeholder="รหัสผ่าน" required />
                        </div>
                        <div class="col-xs-12 col-sm-12 text-center">
                            <input type="submit" class="btn btn-default" value="เข้าสู่ระบบ" style="width: 150px" title="เข้าสู่ระบบ">
                        </div>
                    </div>

                    <!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button> -->
                    <h2 style="font-size: 18px" class="text-center">กรมกิจการผู้สูงอายุ</h2>
                    <h2 style="font-size: 18px" class="text-center">กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์</h2>
                    <input type="submit" name="bt_submit" hidden='hidden'>
                </form>
                <h2 style="font-size: 18px" class="text-center">พบปัญหาการใช้งานระบบกรุณาติดต่อผู้ดูแลระบบ</h2>
                <h3 style="font-size: 18px" class="text-center">© สงวนลิขสิทธ์โดย กรมกิจการผู้สูงอายุ พัฒนาโดย บริษัท จิ๊กซอว์ อินโนเวชั่น จำกัด เวอร์ชั่น 1.0</h3>
            </div>
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

    <!-- *************** Set Format Plugin *************** -->
    <?php echo js_asset('../plugins/setformat/jquery.number.min.js'); ?>
    <?php echo js_asset('../plugins/setformat/jquery.maskedinput.min.js'); ?>
    <?php echo js_asset('../plugins/setformat/jquery.setformat.js'); ?>
    <!-- *************** End Set Format Plugin *************** -->

    <script>

    $(document).keypress(function(e) {
        if(e.which == 13) {
            if($("input[name='pin_code']").val()=='' || $("input[name='passcode']").val()==''){
                $("#wrn").text("*กรุณากรอกข้อมูลให้ครบถ้วน");
            }else {
                //window.location.replace("<?php echo site_url('admin_access/login');?>");
                setTimeout(function(){
                    $("input[name='bt_submit']").click();
                },400);
            }
        }

    });

    $(document).bind('keyup', function(e){
        if($("input[name='pin_code']").val()!='' && $("input[name='passcode']").val()!=''){
            $("#wrn").text("");
        }
    });    

    </script>
</html>