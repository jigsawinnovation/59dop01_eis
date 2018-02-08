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
          "visits2": <?php echo round($row['count_of_visit']);?>,
          "visits3": <?php echo round($row['count_of_help']);?>
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
            "fillAlphas": 0.8,
            "lineColor": "#0D8ECF",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "แจ้งเรื่อง (ราย)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits"
          },{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#E5D522",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "ได้รับการตรวจเยียม (ราย)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits2"
        },{
          "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
          "fillAlphas": 0.8,
          "lineColor": "#65C01B",
          "labelText": "[[value]]",
          "lineAlpha": 0.3,
          "title": "ได้รับการสังเคราห์ (ราย)",
          "type": "column",
          "color": "#000000",
          "valueField": "visits3"
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
              <td class="report-th" colspan="3">ข้อมูลดำเนินงาน (ราย)</td>
              <td class="report-th" rowspan="2"  width="20%">งบประมาณที่ใช้ไป (บาท)</td>
            </tr>
            <tr>
              <td class="report-th" width="20%">แจ้งเรื่อง</td>
              <td class="report-th" width="20%">ได้รับการตรวจเยียม</td>
              <td class="report-th" width="20%">ได้รับการสังเคราห์</td>
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
                if($row['count_of_req'] > 0){
                    echo number_format($row['count_of_req']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> center">
                <?php
                if($row['count_of_visit'] > 0){
                    echo number_format($row['count_of_visit']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> center">
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
          </table>
      </div>
    </div>
</div>
