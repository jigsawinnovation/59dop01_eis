<div id="table">
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="3">พื้นที่</td>
            <td class="report-th" colspan="6">ข้อมูลดำเนินงาน</td>
            <td class="report-th" rowspan="3" width="5%"></td>
          </tr>
          <tr >
            <td class="report-th" colspan="2">โรงเรียนที่ก่อตั้ง</td>
            <td class="report-th" colspan="2">รุ่น</td>
            <td class="report-th" colspan="2">ผู้เข้าร่วม</td>
          </tr>
          <tr>
            <td class="report-th" width="12%">จำนวน (โรง)</td>
            <td class="report-th" width="12%">จำนวน (ร้อยละ)</td>
            <td class="report-th" width="12%">จำนวน (รุ่น)</td>
            <td class="report-th" width="12%">จำนวน (ร้อยละ)</td>
            <td class="report-th" width="12%">จำนวน (คน)</td>
            <td class="report-th" width="12%">จำนวน (ร้อยละ)</td>
          </tr>
        <?php
        $intRow = 0;
        $count_sum = 0;
        $arr_class_td = array('report-td-a','report-td-b');
        if($list_area){
          $total_count_school = 0;
          $total_count_gen = 0;
          $total_count_pers = 0;
          $total_school_percent = 0;
          $total_gen_percent = 0;
          $total_pers_percent = 0;

					foreach ($list_area as $row_sum) {
								$total_count_school += $row_sum['count_school'];
								$total_count_gen += $row_sum['count_gen'];
                $total_count_pers += $row_sum['count_pers'];
					}
          foreach ($list_area as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            if(isset($row['count_school']) && $row['count_school'] > 0){
                $school_percent = ($row['count_school']*100)/$total_count_school;
            }else{
                $school_percent = 0;
            }
            if(isset($row['count_gen']) && $row['count_gen'] > 0){
                $gen_percent = ($row['count_gen']*100)/$total_count_gen;
            }else{
                $gen_percent = 0;
            }
            if(isset($row['count_pers']) && $row['count_pers'] > 0){
                $pers_percent = ($row['count_pers']*100)/$total_count_pers;
            }else{
                $pers_percent = 0;
            }

            $total_school_percent += $school_percent;
            $total_gen_percent += $gen_percent;
            $total_pers_percent += $pers_percent;

          ?>
            <tr >
              <td class="<?php echo $class_td;?> left"><?php echo $row['area_name'];?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_school']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($school_percent,2);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_gen']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($gen_percent,2);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($row['count_pers']);?></td>
              <td class="<?php echo $class_td;?> right"><?php echo number_format($pers_percent,2);?></td>
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url().report_url(); ?>school_report/school_table/<?php echo $row['area_id'];?>');">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </td>
            </tr>
          <?php
          }
          ?>
          <tr >
            <td class="report-td-sum left">รวม</td>
            <td class="report-td-sum right"><?php echo number_format($total_count_school);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_school_percent,2);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_gen);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_gen_percent,2);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_count_pers);?></td>
            <td class="report-td-sum right"><?php echo number_format($total_pers_percent,2);?></td>
            <td class="report-td-sum center"></td>
          </tr>
        <?php
        }
        ?>
        </table>
    </div>
  </div>
</div>
