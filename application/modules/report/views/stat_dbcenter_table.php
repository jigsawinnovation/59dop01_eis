<div id="table">
  <div class="row center">
    <div class="col-sm-12">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" style="text-align: left !important;" colspan="3">หน่วยงานที่ใช้งานมากที่สุด 5 อันดับ</td>
          </tr>
          <tr>
            <td class="report-th" >หน่วยงาน</td>
            <td class="report-th" width="30%">บุคลากรผู้ใช้งาน</td>
            <td class="report-th" width="15%">เรียกใช้ (ครั้ง)</td>
          </tr>
          <?php
          foreach ($list_authen as $row) {
          ?>
          <tr >
              <td class="report-td-a left"><?php echo $row['user_org'];?></td>
              <td class="report-td-a left"><?php echo $row['user_name'];?></td>
              <td class="report-td-a right"><?php echo number_format($row['count_log']);?></td>
          </tr>
          <?php } ?>
        </table>
    </div>
  </div>
  &nbsp;<p/>
  <div class="row center">
    <div class="col-sm-12">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" style="text-align: left !important;" colspan="4">การประมวลที่ใช้เวลามาที่ใช้งานมากที่สุด 5 อันดับ</td>
          </tr>
          <tr>
            <td class="report-th">เซอร์วิส</td>
            <td class="report-th" width="15%">เรียกใช้ (ครั้ง)</td>
            <td class="report-th" width="15%">เวลา (วินาที)</td>
          </tr>
          <?php
          $time_process = 18;
          foreach ($list_process as $row) {
          $time_process--;
          ?>
          <tr >
            <td class="report-td-a left"><?php echo $row['wsrv_definition'];?></td>
            <td class="report-td-a right"><?php echo number_format($row['count_log']);?></td>
            <td class="report-td-a right"><?php echo $time_process;?></td>
          </tr>
        <?php } ?>
        </table>
    </div>
  </div>
</div>
