<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACSdMKi4OrvylAegEJXXR3--RnLUYUBtw"></script>
<div id="mySidenav" class="sidenav">
  <?php $this->load->view($this->template->name.'/head_menu_list');?>
</div>
<div id="menu-navbar" class="navbar-inner navbar-fixed-top">
  <span class="navbar-left report-home" onclick="openNav()"><i style="font-size: 20px; color: #2f4250 !important" class="fa fa-windows" aria-hidden="true"></i></span>&nbsp;
  <span class="report-name" style="max-width: 70%"><?php echo $title;?></span>
    <ul class="nav navbar-top-links navbar-right">
      <li id="summary">
        <div onclick="getData('<?php echo site_url(); ?>/difficult/volt_summary');">
        <div class="font-icon-tab"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
        </div>
      </li>
      <li id="table">
        <div onclick="getData('<?php echo site_url(); ?>/difficult/volt_table_area');">
        <div class="font-icon-tab"><i class="fa fa-table" aria-hidden="true"></i></div>
        </div>
      </li>
      <li id="map">
        <div onclick="getMap();">
        <div class="font-icon-tab"><i class="fa fa-globe" aria-hidden="true"></i></div>
        </div>
      </li>
    </ul>
</div>
<div id="page-content" onclick="closeNav()">
  <div >
    <div class="bg-report">
      <div id="report_data"></div>
    </div>
    <div id="loader_data_area"></div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#summary').addClass( "tab-active" );
    getData('<?php echo site_url(); ?>/difficult/volt_summary');
    getDataArea('<?php echo site_url(); ?>/difficult/volt_map');
});
</script>
