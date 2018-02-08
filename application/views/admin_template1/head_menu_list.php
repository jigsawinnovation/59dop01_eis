      <a href="<?php echo site_url('control/main_module');?>" >
      <div class="sidenav-name"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;เมนูหลัก</div>
      </a>
      <?php
      $app_id = 84;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'service_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 85;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'kpiorg_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 86;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'fnrl_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 87;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'impv_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 88;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'wisd_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 89;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'volt_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 90;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'stat_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 91;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'stat_media_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 92;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'school_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 93;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'edoe_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 94;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'stat_sysall_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 95;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'stat_dbcenter_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 96;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'stat_web_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
      <?php
      $app_id = 98;
      $tmp = $this->admin_model->getOnce_Application($app_id);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss($app_id, get_session('user_id')); //Check User Permission
      if(isset($tmp1['perm_status'])) {
        $href = site_url().report_url().'gateway_report';
      }else{
        $href = '#';
      }
      ?>
      <a href="<?php echo $href;?>">
      <div class="sidenav-name"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?></div>
      </a>
