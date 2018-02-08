  <div class="title_identify">
      <?php
        if($info['area_id'] == '10000000'){
            echo $info['area_name'];
        }else{
            echo 'จังหวัด'.$info['area_name'];
        }
      ?>
  </div>
  <div class="text_identify">สถานประกอบการที่ต้องการผู้สูงอายุ <b><?php echo number_format($info['count_org']);?></b> แห่ง</div>
  <div class="text_identify">ตำแหน่งงานว่าง <b><?php echo number_format($info['count_job_vacancy']);?></b> ตำแหน่ง</div>
  <div class="text_identify">ผู้สูงอายุที่ขึ้นทะเบียนจัดหางาน <b><?php echo number_format($info['count_of_req']);?></b> คน</div>
