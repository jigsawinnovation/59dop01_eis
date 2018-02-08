  <div class="title_identify">
      <?php
        if($info['area_id'] == '10000000'){
            echo $info['area_name'];
        }else{
            echo 'จังหวัด'.$info['area_name'];
        }
      ?>
  </div>
  <div class="text_identify">แจ้งเรื่อง <b><?php echo number_format($info['count_of_req']);?></b> ราย</div>
  <div class="text_identify">ได้รับการตรวจเยี่ยม <b><?php echo number_format($info['count_of_visit']);?></b> ราย</div>
  <div class="text_identify">ได้รับการสังเคราห์ <b><?php echo number_format($info['count_of_help']);?></b> ราย</div>
  <div class="text_identify">งบประมาณที่ใช้ไป <b><?php echo number_format($info['sum_pay_amount'],2);?></b> บาท</div>
