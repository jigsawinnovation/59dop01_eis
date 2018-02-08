        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2">ลำดับ</td>
            <td class="report-th" colspan="3">ข้อมูลผู้ขอรับบริการ</td>
            <td class="report-th" colspan="3">ข้อมูลดำเนินงาน</td>
            <td class="report-th" rowspan="2"></td>
          </tr>
          <tr>
            <td class="report-th">เลข ปปช.</td>
            <td class="report-th">ชื่อตัว - ชื่อสกุล</td>
            <td class="report-th">อายุ (ปี)</td>
            <td class="report-th">แจ้งเรื่อง</td>
            <td class="report-th">สงเคราะห์</td>
            <td class="report-th">จำนวนเงิน</td>
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
              <td class="<?php echo $class_td;?> center"><?php echo $intRow;?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['id_card'];?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['name'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['age'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['date_of_req'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['date_of_help'];?></td>
              <td class="<?php echo $class_td;?> right">
              <?php
              if($row['pay_amount'] > 0){
                  echo number_format($row['pay_amount'],2);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </td>
            </tr>
          <?php
          }
        }
        ?>
        </table>
