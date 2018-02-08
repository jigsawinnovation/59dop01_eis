<div id="table">
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2">พื้นที่</td>
            <td class="report-th" colspan="4">ปริมาณผู้สูงอายุที่ขึ้นทะเบียน</td>
            <td class="report-th" colspan="2">ภูมิปัญญา</td>
            <td class="report-th" rowspan="2" width="5%"></td>
          </tr>
          <tr>
            <td class="report-th" width="10%">ชาย</td>
            <td class="report-th" width="10%">หญิง</td>
            <td class="report-th" width="10%">รวม</td>
            <td class="report-th" width="10%">ร้อยละ</td>
            <td class="report-th" width="10%">จำนวน</td>
            <td class="report-th" width="10%">ร้อยละ</td>
          </tr>
        <?php
        $intRow = 0;
        $count_sum = 0;
        $arr_class_td = array('report-td-a','report-td-b');
        if($list_area){
          $count_all = 0;
          $count_knwl_all = 0;

          $total_count_m = 0;
          $total_count_f = 0;
          $total_count_sum = 0;
          $total_wis_percent = 0;
          $total_count_knwl = 0;
          $total_knwl_percent = 0;

					foreach ($list_area as $row_sum) {
								$count_m = $row_sum['count_m'];
								$count_f = $row_sum['count_f'];
								$count_all += $count_m+$count_f;
                $count_knwl_all += $row_sum['count_knwl'];
					}
          foreach ($list_area as $row) {
          $intRow++;
          $class_td = $arr_class_td[$intRow%2];
          $count_sum = $row['count_m']+$row['count_f'];
          $wis_percent = ($count_sum*100)/$count_all;
          $knwl_percent = ($row['count_knwl']*100)/$count_knwl_all;
          $total_count_m += $row['count_m'];
          $total_count_f += $row['count_f'];
          $total_count_sum += $count_sum;
          $total_wis_percent += $wis_percent;
          $total_count_knwl += $row['count_knwl'];
          $total_knwl_percent += $knwl_percent;
          ?>
            <tr >
              <td class="<?php echo $class_td;?> left"><?php echo $row['area_name'];?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_m']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_f']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($count_sum);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($wis_percent,2);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_knwl']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($knwl_percent,2);?></td>
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url(); ?>/difficult/wisd_table/<?php echo $row['area_id'];?>');">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </td>
            </tr>
          <?php
          }
          ?>
          <tr >
            <td class="report-td-sum left">รวม</td>
            <td class="report-td-sum right"><?php echo number_format($total_count_m);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_f);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_sum);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_wis_percent,2);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_knwl);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_knwl_percent,2);?></td>
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
