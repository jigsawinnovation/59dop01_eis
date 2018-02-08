  <div class="title_identify">
      <?php
        if($info['area_id'] == '10000000'){
            echo $info['area_name'];
        }else{
            echo 'จังหวัด'.$info['area_name'];
        }
      ?>
  </div>
  <div class="text_identify">จำนวนโรงเรียน <b><?php echo number_format($info['count_school']);?></b> โรง</div>
  <div class="text_identify">จำนวนรุ่น <b><?php echo number_format($info['count_gen']);?></b> รุ่น</div>
  <div class="text_identify">จำนวนผู้เข้าร่วม <b><?php echo number_format($info['count_pers']);?></b> คน</div>
