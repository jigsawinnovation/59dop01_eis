<!-- *************** inspinia-3 Template: CSS *************** -->
<?php echo css_asset('../plugins/Static_Full_Version/css/bootstrap.min.css'); ?>
<?php echo css_asset('../plugins/Static_Full_Version/font-awesome/css/font-awesome.css'); ?>
<?php echo css_asset('../plugins/Static_Full_Version/css/animate.css'); ?>
<?php echo css_asset('../plugins/Static_Full_Version/css/style.css'); ?>
<!-- *************** End inspinia-3 Template: CSS *************** -->

<!-- *************** inspinia-3 Template: JS *************** ----->
<?php echo js_asset('../plugins/Static_Full_Version/js/jquery-3.1.1.min.js'); ?>
<!-- *************** End inspinia-3 Template: JS *************** -->

<?php
  if(isset($this->template->js_assets_head))
    foreach ($this->template->js_assets_head as $key => $data) {
      echo $data;
    }
?>
<?php
  if(isset($this->template->css_assets_head))
    foreach ($this->template->css_assets_head as $key => $data) {
      echo $data;
    }
?>

<?php
  echo css_asset('../admin/css/fontsset.css');
  echo css_asset('../admin/css/main.css');
?>

<script>
  var base_url = "<?php echo base_url();?>"; //Set Base URL

  //Set Alert Notifications
  var toastr_type = null; //Set toast type
  var toastr_msg = null; //Set toast message
<?php

$msg = $this->session->flashdata('msg');

  if(isset($msg['msg_code'])) {
?>
  //set inizial toastr
  toastr_type = '<?php echo $msg['msg_type']?>';
  toastr_msg = '<?php echo $msg['msg_title']?>';
<?php 
  }
?>  
  //End Set Alert Notifications

  var frmKey = true;//Set Form key
</script>