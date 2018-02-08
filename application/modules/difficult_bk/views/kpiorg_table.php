<div id="table">
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="3" width="5%">&nbsp;</td>
            <td class="report-th" rowspan="3" width="5%">#</td>
            <td class="report-th" rowspan="3">ชื่อตัว-นามสกุล</td>
            <td class="report-th" rowspan="3">เพศ</td>
            <td class="report-th" rowspan="3">อายุ (ปี)</td>
            <td class="report-th" colspan="5">ผลการประเมิณสมรรถภาพรายบุคคล</td>
          </tr>
          <tr >
            <td class="report-th" colspan="2">ครั้งที่ 1</td>
            <td class="report-th" colspan="2">ครั้งลาสุด</td>
            <td class="report-th" rowspan="2">พัฒนาการ</td>
          </tr>
          <tr >
            <td class="report-th" width="15%">คะแนนที่ได้</td>
            <td class="report-th" width="10%">เกณฑ์</td>
            <td class="report-th" width="15%">คะแนนที่ได้</td>
            <td class="report-th" width="10%">เกณฑ์</td>
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
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url(); ?>/difficult/kpiorg_table_area');">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </td>
              <td class="<?php echo $class_td;?> center"><?php echo $intRow;?></td>
              <td class="<?php echo $class_td;?> left">
                  <div><?php echo $row['name'];?></div>
                  <div><?php echo $row['id'];?></div>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php echo $row['gender']; ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php echo $row['age']; ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php
                if($row['first_score'] > 0){
                    echo number_format($row['first_score'],2);
                }else{
                    echo '';
                }
                ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php
                if($row['first_kpi'] > 0){
                    echo number_format($row['first_kpi']);
                }else{
                    echo '';
                }
                ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php
                if($row['last_score'] > 0){
                    echo number_format($row['last_score'],2);
                }else{
                    echo '';
                }
                ?>
                <?php
                if($row['last_score'] > 0){
                    $diff_score = $row['last_score'] - $row['first_score'];
                    echo '(';
                    if($diff_score > 0){
                        echo '<span class="tbl-caret-up"><i class="fa fa-caret-up" aria-hidden="true"></i>&nbsp;+';
                    }else if($diff_score < 0){
                        echo '<span class="tbl-caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i>&nbsp;';
                    }
                    echo number_format($diff_score,2);
                    echo '</span>)';
                }else{
                    echo '';
                }
                ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php
                if($row['last_kpi'] > 0){
                    echo number_format($row['last_kpi']);
                }else{
                    echo '';
                }
                ?>
              </td>
              <td class="<?php echo $class_td;?> center">
                <?php
                if($row['last_score'] < 0 || $row['last_score'] == ''){
                    echo '<span style="font-size:34px;">=</span>&nbsp;คงที่';
                }else if($diff_score > 0){
                    echo '<span class="tbl-caret-up"><i class="fa fa-caret-up" aria-hidden="true"></i>&nbsp;สูงขึ้น</span>';
                }else if($diff_score < 0){
                    echo '<span class="tbl-caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i>&nbsp;ลดลง</span>';
                }else{
                    echo '<span style="font-size:34px;">=</span>&nbsp;คงที่';
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
<style>
.tbl-caret-up{
  color:#3E8916;
}
.tbl-caret-down{
  color:#D80B2A;
}
</style>
