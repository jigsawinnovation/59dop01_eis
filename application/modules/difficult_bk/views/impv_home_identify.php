<div class="center"><img src="<?php echo $info['photo'];?>" width="100" style="border-radius: 5px;border: 1px solid #CCC;"></div>
  <div class="title_identify">
      <?php
        echo $info['pers_info_name'].' ';
        if($info['area_id'] == '10000000'){
            echo $info['area_name'];
        }else{
            echo 'จังหวัด'.$info['area_name'];
        }
      ?>
  </div>
  <div class="text_identify center">งบประมาณที่ใช้ไป <b><?php echo number_format($info['case_budget'],2);?></b> บาท</div>
