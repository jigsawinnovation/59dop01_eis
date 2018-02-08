<div id="table">
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" width="5%"></td>
            <td class="report-th" >วันที่ประกาศ</td>
            <td class="report-th" width="35%">ชื่อตำแหน่งงาน/ประเภท</td>
            <td class="report-th" width="35%">สถานประกอบการ</td>
          </tr>

        <?php
        $intRow = 0;
        $arr_class_td = array('report-td-a','report-td-b');
        if($list_info){
          foreach ($list_info as $row) {
          $intRow++;
          $class_td = $arr_class_td[$intRow%2];
          ?>
            <tr >
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url().report_url(); ?>edoe_report/edoe_table_area');">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </td>
              <td class="<?php echo $class_td;?> center">
                  <div><?php echo $row['date_of_post'];?></div>
                  <div>(<?php echo $row['post_status'];?>)</div>
              </td>
              <td class="<?php echo $class_td;?> left">
                  <div><?php echo $row['posi_title'];?></div>
                  <div>(<?php echo $row['posi_type_title'].' - '.$row['org_type'];?>)</div>
              </td>
              <td class="<?php echo $class_td;?> left">
                <div><?php echo $row['org_title'];?></div>
                <div>เวลาทำงาน: <?php echo $row['posi_workday'];?></div>
              </td>
            </tr>
          <?php
          }
        }
        ?>
        </table>
    </div>
  </div>
</div>

<script>
$( "#quick_search" ).keyup(function() {
    /*var quick_search = $( "#quick_search" ).val();
    var url_search = '<?php echo site_url(); ?>/difficult/service_table_search';
    $.ajax({
      method: "GET",
      url: url_search,
      data: {quick_search:quick_search}
    }).done(function( data ) {
        $('#display_info').html(data);
    });*/
});
</script>
