<div id="table">

  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2"></td>
            <td class="report-th" rowspan="2">ลำดับ</td>
            <td class="report-th" colspan="5">ข้อมูลผู้สูงอายุที่ขึ้นทะเบียน</td>
            <td class="report-th" colspan="2">ข้อมูลด้านภูมิปัญญาที่ขึ้นทะเบียน</td>
          </tr>
          <tr>
            <td class="report-th">เลข ปปช.</td>
            <td class="report-th">ชื่อตัว - ชื่อสกุล</td>
            <td class="report-th">อายุ (ปี)</td>
            <td class="report-th">ที่อยู่</td>
            <td class="report-th">เบอร์โทรศัพย์</td>
            <td class="report-th">วันที่ลงทะเบียน</td>
            <td class="report-th">สาขาผู้ปัญญา</td>
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
              <td class="<?php echo $class_td;?> center"  onclick="getData('<?php echo site_url().report_url(); ?>wisd_report/wisd_table_area');">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </td>
              <td class="<?php echo $class_td;?> center"><?php echo $intRow;?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['id_card'];?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['name'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['age'];?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['address'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['tel_no'];?></td>
              <td class="<?php echo $class_td;?> center"><?php echo $row['date_of_reg'];?></td>
              <td class="<?php echo $class_td;?> left"><?php echo $row['wis_name'];?></td>
            </tr>
          <?php
          }
        }
        ?>
        </table>
    </div>
  </div>
</div>

<script>
$( "#quick_search" ).keyup(function() {
    var quick_search = $( "#quick_search" ).val();
    var url_search = '<?php echo site_url(); ?>report/wisd_report/service_table_search';
    $.ajax({
      method: "GET",
      url: url_search,
      data: {quick_search:quick_search}
    }).done(function( data ) {
        $('#display_info').html(data);
    });
});
</script>
