  <div class="title_identify">
      <?php
        if($info['area_id'] == '10000000'){
            echo $info['area_name'];
        }else{
            echo 'จังหวัด'.$info['area_name'];
        }
      ?>
  </div>
  <table width="100%" class="report-table">
    <tr>
      <td class="report-th" width="30%">วัน เวลา</td>
      <td class="report-th" width="30%">ชื่อผู้ใช้</td>
      <td class="report-th">เซอร์วิส</td>
    </tr>
    <tr>
      <td class="report-td-a"><?php echo date("Y-m-d H:m:i")?></td>
      <td class="report-td-a">นายธนกฤต วรินทรเวช</td>
      <td class="report-td-a">การตรวจสอบรหัสการเข้าใช้งานกับ SAS และยืนยันสิทธิ์ (สำหรับตรวจสอบ และขอข้อมูล Authentication จากสำนักทะเบียนราษฎร์)</td>
    </tr>
  </table>
  <style>
  #show_info{
    width: 500px;
    height: 250px;
  }
  </style>
