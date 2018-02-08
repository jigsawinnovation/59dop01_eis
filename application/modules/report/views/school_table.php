<div id="table">

  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr>
            <td class="report-th"></td>
            <td class="report-th">ลำดับ</td>
            <td class="report-th">ชื่อโรงเรียน</td>
            <td class="report-th">ปีที่ก่อตั้ง</td>
            <td class="report-th">ที่อยู่</td>
            <td class="report-th">จำนวน (รุ่น)</td>
            <td class="report-th">ผู้เข้าร่วม (คน)</td>
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
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url().report_url(); ?>school_report/school_table_area');">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </td>
              <td class="<?php echo $class_td;?> center"><?php echo $intRow;?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['schl_name'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['year'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['area_name'];?></td>
              <td class="<?php echo $class_td;?> right"><?php echo $row['count_gen'];?></td>
              <td class="<?php echo $class_td;?> right"><?php echo $row['count_pers'];?></td>

            </tr>
          <?php
          }
        }
        ?>
        </table>
    </div>
  </div>
</div>
