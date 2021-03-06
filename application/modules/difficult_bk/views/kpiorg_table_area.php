<div id="table">
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2" width="5%">#</td>
            <td class="report-th" rowspan="2">หน่วยงาน</td>
            <td class="report-th" colspan="3">ปริมาณผู้รับบริการ(ราย)</td>
            <td class="report-th" rowspan="2" width="5%"></td>
          </tr>
          <tr>
            <td class="report-th" width="15%">รับเข้า</td>
            <td class="report-th" width="15%">จำหน่วย</td>
            <td class="report-th" width="15%">คงเหลือ</td>
          </tr>
        <?php
        $intRow = 0;
        $count_sum = 0;
        $arr_class_td = array('report-td-a','report-td-b');
        if($list_org){

          $total_count_org = 0;
          $total_count_job_vacancy = 0;

          foreach ($list_org as $row) {
          $intRow++;
          $class_td = $arr_class_td[$intRow%2];
          $total_count_org += $row['count_org'];
          $total_count_job_vacancy += $row['count_job_vacancy'];
          ?>
            <tr >
              <td class="<?php echo $class_td;?> center"><?php echo $intRow;?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['org_title'];?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_org']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_job_vacancy']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_org']-$row['count_job_vacancy']);?></td>
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url(); ?>/difficult/kpiorg_table/<?php echo $row['org_id'];?>');">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </td>
            </tr>
          <?php
          }
          ?>
          <tr >
            <td colspan="2" class="report-td-sum left">รวม</td>
            <td class="report-td-sum right"><?php echo number_format($total_count_org);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_job_vacancy);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_org-$total_count_job_vacancy);?></td>
            <td class="report-td-sum center"></td>
          </tr>
        <?php
        }
        ?>
        </table>
    </div>
  </div>
</div>

<script>
$( "#quick_search" ).keyup(function() {
    var quick_search = $( "#quick_search" ).val();
    var url_search = '<?php echo site_url(); ?>/difficult/service_table_search';
    $.ajax({
      method: "GET",
      url: url_search,
      data: {quick_search:quick_search}
    }).done(function( data ) {
        $('#display_info').html(data);
    });
});
</script>
