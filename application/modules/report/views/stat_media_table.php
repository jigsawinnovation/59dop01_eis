<div id="table">
  <div class="row center">
    <div class="col-sm-12">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" style="text-align: left !important;" colspan="3">สื่อมัลติมีเดียที่สถิติการเข้าชมมากที่สุด 10 อันดับ</td>
          </tr>
          <tr>
            <td class="report-th" >สื่อมัลติมีเดีย</td>
            <td class="report-th" width="25%">เรียกใช้ (ครั้ง)</td>
          </tr>
          <?php
          foreach ($list as $row) {
          ?>
          <tr >
              <td class="report-td-a left"><?php echo (isset($row['media_name']))?$row['media_name']:'';?></td>
              <td class="report-td-a right"><?php echo number_format($row['count_log']);?></td>
          </tr>
          <?php } ?>
        </table>
    </div>
  </div>
