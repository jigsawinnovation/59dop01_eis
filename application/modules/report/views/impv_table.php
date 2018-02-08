<div id="table">
  <div class="row center">
    <div class="col-sm-12">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2"></td>
            <td class="report-th" rowspan="2">ลำดับ</td>
            <td class="report-th" colspan="3">ข้อมูลผู้ขอรับบริการ</td>
            <td class="report-th" colspan="3">ผลดำเนินงาน</td>
          </tr>
          <tr>
            <td class="report-th" width="15%">เลข ปปช.</td>
            <td class="report-th" width="20%">ชื่อตัว - ชื่อสกุล</td>
            <td class="report-th" width="10%">อายุ (ปี)</td>
            <td class="report-th" width="15%">พิจารณา</td>
            <td class="report-th" width="15%">เสร็จสิ้น</td>
            <td class="report-th" width="15%">จำนวนเงิน</td>
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
              <td class="<?php echo $class_td;?> center">
                <i class="fa fa-angle-left" aria-hidden="true"  onclick="getData('<?php echo site_url().report_url(); ?>impv_report/impv_table_area');"></i>
              </td>
              <td class="<?php echo $class_td;?> center"><?php echo $intRow;?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['id_card'];?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['name'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['age'];?></td>
              <td class="<?php echo $class_td;?> center">
              <?php
              if($row['consi_result'] == 'ไม่อนุมัติ'){
                $color = '#E71E14';
              }else{
                $color = '#15BF15';
              }
              ?>
              <span style="font-weight: bold;color:<?php echo $color;?>;"><?php echo $row['consi_result'];?></span>
              </td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['date_of_finish'];?></td>
              <td class="<?php echo $class_td;?> right">
              <?php
              if($row['case_budget'] > 0){
                  echo number_format($row['case_budget'],2);
              }else{
                  echo '';
              }
              ?>
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
