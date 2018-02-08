<!DOCTYPE html>
<html>
    <head>
        <?php
            $site = $this->webinfo_model->getSiteInfo();
            $title = $title!=''?$title:$site['site_title'].'(Index Page)';

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

  <?php $this->load->file('assets/admin/tools/tools_config.php');?>

  <?php
        if($this->template->content_view_set==1){
            $this->load->file('assets/modules/'.uri_seg(1).'/tools/tools_config.php');
        }
    ?>
    <title><?php echo $title;?></title>
<style>
navbar{
  margin-bottom: 0px !important;
  margin-top: 0px !important;
}
</style>
</head>

<body class="pace-done mini-navbar">

  <div id="wrapper">
    <?php /* ?>
    <div class="row border-bottom">

        <nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0;background-color: #fff;border-bottom: 1px #60aed2 solid !important;">
            <div class="navbar-header">
                <a href="<?php echo site_url('control/main_module');?>" title="<?php echo $site['site_title'];?>">
                    <h1 class="title" style="float: left; padding-right: 10px; border-right: 2px #eee solid; margin-left: 25px; color: #2f4250; font-size: 26px;">DOP</h1>
                    <h2 class="sec1_title" style="float: left; margin-left: 13px; color: #1664fa; font-size: 26px;"><?php echo $site['site_title'];?></h2>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">

                <?php
                  //$user = get_session('user_firstname').' '.get_session('user_lastname');
                  $user = get_session('user_firstname');
                ?>
                <li title="<?php echo $user;?>" style="margin-top: -5px; margin-bottom: 0px;">
                  <a style="position: relative;" href="#profile" title="<?php echo $user;?>">
                      &nbsp;
                      <span class="m-r-sm text-muted welcome-message" style="font-size: 18px; color:#1664fa;"><?php echo $user;?></span>

                  </a>
                </li>

                <li>
                    <a title="เมนูหลัก" style="display: inline; color:#9a6a36" data-toggle="dropdown">
                        <i style="font-size: 18px; color: #2f4250 !important" class="fa fa-windows" aria-hidden="true"></i>
                    </a>
                    <?php $this->load->view($this->template->name.'/head_menu_list');?>
                </li>
                <li>
                    <a title="ออกจากระบบ" href="<?php echo site_url('manage/logout');?>" style="display: inline; color:#9a6a36">
                        <i style="font-size: 18px; color: #2f4250 !important" class="fa fa-power-off" aria-hidden="true"></i>
                    </a>
                </li>

            </ul>

        </nav>
    </div>

    <div class="row wrapper border-bottom white-bg page-heading" style="padding: 0 !important; background-color: #fff; border: 1px #60aed2 solid;">
        <div class="col-xs-12 col-sm-12 text-center" style="padding-right: 30px;">

            <h2><?php echo $title;?></h2>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div style="float: right" id="menu_topright">

            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight" style="padding: 0px !important">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content p-md" style="min-height: 400px; background-color: #ffffff">
                    <?php
                        if($this->template->content_view_set==0){
                            $this->load->view($this->template->name.'/'.$content_view);
                        }else{
                            $this->load->file(APPPATH.'modules/'.uri_seg(1).'/views/'.$content_view.'.php');
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php */ ?>
    </div>
    <?php
        if($this->template->content_view_set==0){
            $this->load->view($this->template->name.'/'.$content_view);
        }else{
            $this->load->file(APPPATH.'modules/'.uri_seg(1).'/views/'.$content_view.'.php');
        }
    ?>

</body>

<?php $this->load->file('assets/admin/tools/tools_script.php'); ?>
<?php
    if($this->template->content_view_set==1){
        $this->load->file('assets/modules/'.uri_seg(1).'/tools/tools_script.php');
    }
?>
</html>
