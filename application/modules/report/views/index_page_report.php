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
            //echo 'assets/modules/'.uri_seg(1).'/tools/tools_config.php';
            //$this->load->file('assets/modules/'.uri_seg(1).'/tools/tools_config.php');
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

    </div>
    <?php
        if($this->template->content_view_set==0){
            $this->load->view($this->template->name.'/'.$content_view);
        }else{
            //echo APPPATH.'views/'.$content_view.'.php';
            $this->load->file(APPPATH.'views/'.$content_view.'.php');
        }
    ?>

</body>

<?php $this->load->file('assets/admin/tools/tools_script.php'); ?>
<?php
    if($this->template->content_view_set==1){
        //$this->load->file('assets/modules/'.uri_seg(1).'/tools/tools_script.php');
    }
?>
</html>
