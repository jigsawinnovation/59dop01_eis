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
          "country": "<?php echo $row['mmyy'];?>",
          "visits": <?php echo round($row['sum_home_pay_amount'],2);?>,
          "visits2": <?php echo round($row['sum_place_pay_amount'],2);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": ""
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "lineColor": "#63D946",
            "bulletColor": "#FFFFFF",
            "labelText": "[[value]]",
            "title": "งบประมาณที่ปรับปรุงบ้าน (บาท)",
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
            "title": "งบประมาณที่ปรับปรุงสถานที่ฯ (บาท)",
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
              <td class="report-th" rowspan="3">ช่วงเวลา<br/>(เดือน ปี)</td>
              <td class="report-th" colspan="4">ผลการดำเนินงาน (ราย)</td>
            </tr>
            <tr>
              <td class="report-th" colspan="2">ปรับปรุงบ้าน</td>
              <td class="report-th" colspan="2">ปรับปรุงสถานที่ฯ</td>
            </tr>
            <tr>
              <td class="report-th" width="20%">จำนวน (ราย)</td>
              <td class="report-th" width="20%">งบประมาณที่ใช้ไป (บาท)</td>
              <td class="report-th" width="20%">จำนวน (ราย)</td>
              <td class="report-th" width="20%">งบประมาณที่ใช้ไป (บาท)</td>
            </tr>
          <?php
          $intRow = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['mmyy'];?></td>
                <td class="<?php echo $class_td;?> center">
                <?php
                if($row['count_of_home'] > 0){
                    echo number_format($row['count_of_home']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['sum_home_pay_amount'] > 0){
                    echo number_format($row['sum_home_pay_amount'],2);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> center">
                <?php
                if($row['count_of_place'] > 0){
                    echo number_format($row['count_of_place']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['sum_place_pay_amount'] > 0){
                    echo number_format($row['sum_place_pay_amount'],2);
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
