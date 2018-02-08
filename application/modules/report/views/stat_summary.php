<div id="summary" class="ui-body-d ui-content">
    <div class="row center">
      <div class="col-sm-12">
        <!-- Begin Chart -->
        <div id="chartdiv"></div>
        <script>var chart = AmCharts.makeChart("chartdiv", {
        "theme": "light",
        "type": "serial",
        "fontSize":24,
        "startDuration": 2,
        "dataProvider": [
        <?php
        foreach ($summary as $row) {
        ?>
        {
          "country": "<?php echo $row['year']+543;?>",
          "visits": <?php echo round($row['count_general'],2);?>,
          "visits2": <?php echo round($row['count_over60'],2);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวนประชากร (คน)"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "lineColor": "#63D946",
            "bulletColor": "#FFFFFF",
            "labelText": "[[value]]",
            "title": "ปริมาณประชากรทั่วประเทศ (คน)",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletSize": 8,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "useLineColorForBulletBorder": true,
            "valueField": "visits"
          },{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            //"fillAlphas": 0.8,
            "lineColor": "#216311",
            "bulletColor": "#FFFFFF",
            "labelText": "[[value]]",
            "title": "ปริมาณประชากรผู้สูงอายุ (60 ปีขึ้นไป) (คน)",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletSize": 8,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "useLineColorForBulletBorder": true,
            "valueField": "visits2"
        }],
        "depth3D": 20,
        "angle": 30,
        "chartCursor": {
          "categoryBalloonEnabled": true,
          "cursorAlpha": 0,
          "zoomable": false
        },
        "legend": {
          "useGraphSettings": true,
          "position": "bottom"
        },
        "categoryField": "country",
        "categoryAxis": {
          "gridPosition": "start",
          "labelRotation": 90
        },
        "export": {
        "enabled": false
        }

        });
        //# sourceURL=pen.js
        </script>
        <!-- End Chart -->
      </div>
      <div class="col-sm-12">
          <table width="100%" class="report-table">
            <tr >
              <td class="report-th" rowspan="3">ช่วงเวลา (ปี)</td>
              <td class="report-th" colspan="4">ปริมาณประชากรไทย (คน)</td>
            </tr>
            <tr>
              <td class="report-th" colspan="2">ทั่วประเทศ</td>
              <td class="report-th" colspan="2">ผู้สูงอายุ (60 ปีขึ้นไป)</td>
            </tr>
            <tr>
              <td class="report-th" width="20%">จำนวน (คน)</td>
              <td class="report-th" width="20%">งบประมาณที่ใช้ไป (บาท)</td>
              <td class="report-th" width="20%">จำนวน (คน)</td>
              <td class="report-th" width="20%">งบประมาณที่ใช้ไป (บาท)</td>
            </tr>
          <?php
          $intRow = 0;
          $total_count_general = 0;
          $total_count_pay_general = 0;
          $total_count_over60 = 0;
          $total_count_pay_over60 = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          /*echo "<pre>";
          print_r($summary);
          echo "</pre>";*/
          if($summary){
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $total_count_general += $row['count_general'];
            $total_count_pay_general += $row['count_pay_general'];
            $total_count_over60 += $row['count_over60'];
            $total_count_pay_over60 += $row['count_pay_over60'];
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['year']+543;?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_general'] > 0){
                    echo number_format($row['count_general']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_pay_general'] > 0){
                    echo number_format($row['count_pay_general'],2);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_over60'] > 0){
                    echo number_format($row['count_over60']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_pay_over60'] > 0){
                    echo number_format($row['count_pay_over60'],2);
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
          <tr >
            <td class="report-td-sum center">รวม</td>
            <td class="report-td-sum right"> </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_pay_general > 0){
                echo number_format($total_count_pay_general,2);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right"> </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_pay_over60 > 0){
                echo number_format($total_count_pay_over60,2);
            }else{
                echo '';
            }
            ?>
            </td>
          </tr>
          </table>
      </div>
    </div>
</div>
