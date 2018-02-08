<div id="table">
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2">จังหวัด</td>
            <td class="report-th" colspan="4">ปริมาณประชากรไทย (คน)</td>
          </tr>
          <tr>
            <td class="report-th" width="15%">ชาย</td>
            <td class="report-th" width="15%">หญิง</td>
            <td class="report-th" width="15%">รวม</td>
            <td class="report-th" width="15%">ร้อยละ</td>
          </tr>
        <?php
        $arr_class_td = array('report-td-a','report-td-b');
        if($list_area){
          $intRow = 0;
          $total_count_male = 0;
          $total_count_female = 0;
          $total_count_sum = 0;

          foreach ($list_area as $row) {
          $intRow++;
          $class_td = $arr_class_td[$intRow%2];
          $total_count_male += $row['count_male'];
          $total_count_female += $row['count_female'];
          $total_count_sum += $row['count_male']+$row['count_female'];
          ?>
            <tr >
              <td class="<?php echo $class_td;?> left"><?php echo $row['area_name'];?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_male']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_female']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_male']+$row['count_female']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_male']);?></td>
            </tr>
          <?php
          }
          ?>
          <tr >
            <td class="report-td-sum left">รวม</td>
            <td class="report-td-sum right"><?php echo number_format($total_count_male);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_female);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_sum);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_male);?></td>
          </tr>
        <?php
        }
        ?>
        </table>
    </div>
  </div>
</div>
