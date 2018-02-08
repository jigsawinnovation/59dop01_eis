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
          "visits": <?php echo round($row['count_of_req']);?>,
          "visits2": <?php echo round($row['count_of_help']);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวนคน"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#2C2C2C",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "แจ้งเรื่อง (คน)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits"
          },{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#B3B4BA",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "ได้รับการสังเคราห์ (คน)",
            "type": "column",
            "color": "#000000",
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
              <td class="report-th" rowspan="2">ช่วงเวลา<br/>เดือน ปี</td>
              <td class="report-th" colspan="2">ข้อมูลดำเนินงาน (คน)</td>
              <td class="report-th" rowspan="2"  width="25%">งบประมาณที่ใช้ไป (บาท)</td>
            </tr>
            <tr>
              <td class="report-th" width="25%">แจ้งเรื่อง</td>
              <td class="report-th" width="25%">ได้รับการสังเคราห์</td>
            </tr>
          <?php
          $intRow = 0;
          $total_count_of_req = 0;
          $total_count_of_help = 0;
          $total_sum_pay_amount = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $total_count_of_req += $row['count_of_req'];
            $total_count_of_help += $row['count_of_help'];
            $total_sum_pay_amount += $row['sum_pay_amount'];
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['mmyy'];?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_of_req'] > 0){
                    echo number_format($row['count_of_req']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_of_help'] > 0){
                    echo number_format($row['count_of_help']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['sum_pay_amount'] > 0){
                    echo number_format($row['sum_pay_amount'],2);
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
            <td class="report-td-sum right">
            <?php
            if($total_count_of_req > 0){
                echo number_format($total_count_of_req);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_of_help > 0){
                echo number_format($total_count_of_help);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_sum_pay_amount > 0){
                echo number_format($total_sum_pay_amount,2);
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
