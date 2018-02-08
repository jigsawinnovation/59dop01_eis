<div id="table">
  <div class="row center">
    <div class="col-xs-6 col-sm-9">
       <div class="input-group">
         <div class="input-group-btn">
              <button class="btn btn-search" type="button">
              <span class="glyphicon glyphicon-search"></span>
              </button>
         </div>
       <input type="search" name="quick_search" value="" class="input-search" placeholder="ค้นหา" id="quick_search"/>
       </div>
    </div>
    <div class="col-sm-3">
        <button class="report-btn-search" data-toggle="modal" data-target="#mySearch">ค้นหาขั้นสูง</button>
    </div>
  </div>
  <!-- Modal -->
  <div id="mySearch" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ค้นหาขั้นสูง</h4>
        </div>
        <div class="modal-body">
          <div class="row center">
            <div class="col-sm-12">
              <div class="col-sm-4 right">
                เลข ปปช.
              </div>
              <div class="col-sm-8">
                <input type="search" name="quick_search" value="" class="input-text">
              </div>
            </div>
          </div>
          <div class="row center">
            <div class="col-sm-12">
              <div class="col-sm-4 right">
                  ชื่อตัว
              </div>
              <div class="col-sm-8">
                <input type="search" name="quick_search" value="" class="input-text">
              </div>
            </div>
          </div>
          <div class="row center">
            <div class="col-sm-12">
              <div class="col-sm-4 right">
                  ชื่อสกุล
              </div>
              <div class="col-sm-8">
                <input type="search" name="quick_search" value="" class="input-text">
              </div>
            </div>
          </div>
          <div class="row center">
            <div class="col-sm-12">
              <div class="col-sm-4 right">
                  อายุ (ปี)
              </div>
              <div class="col-sm-3">
                <input type="search" name="quick_search" value="" class="input-text">
              </div>
              <div class="col-sm-2">
                ถึง
              </div>
              <div class="col-sm-3">
                <input type="search" name="quick_search" value="" class="input-text">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ค้นหา</button>
        </div>
      </div>

    </div>
  </div>
  <div class="row center">
    <div class="col-sm-12" id="display_info">
        <table width="100%" class="report-table">
          <tr >
            <td class="report-th" rowspan="2"></td>
            <td class="report-th" rowspan="2">ลำดับ</td>
            <td class="report-th" colspan="3">ข้อมูลผู้ขอรับบริการ</td>
            <td class="report-th" colspan="3">ข้อมูลดำเนินงาน</td>
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
              <td class="<?php echo $class_td;?> center" onclick="getData('<?php echo site_url(); ?>/difficult/service_table_area');">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </td>
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
