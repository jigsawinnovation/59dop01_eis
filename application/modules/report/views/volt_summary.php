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
          "visits": <?php echo round($row['count_m']+$row['count_f']+$row['count_null']);?>,
          "visits2": <?php echo round($row['count_care']);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวนอาสาผู้ดู/ผู้สูงอายุ"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#2C2C2C",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "ปริมาณอาสาผู้ดูแลผู้สูงอายุ (อผส.)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits"
          },{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#B3B4BA",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "ปริมาณผู้สูงอายุในความดูแล ",
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
              <td class="report-th" rowspan="3">ช่วงเวลา<br/>เดือน ปี</td>
              <td class="report-th" colspan="5">ข้อมูลดำเนินงาน (คน)</td>
            </tr>
            <tr>
              <td class="report-th" colspan="4">อาสาผู้ดูแลผู้สูงอายุ (อผส.)</td>
              <td class="report-th" width="15%" rowspan="2">ผู้สูงอายุในความดูแล</td>
            </tr>
            <tr>
              <td class="report-th" width="15%">ชาย</td>
              <td class="report-th" width="15%">หญิง</td>
              <td class="report-th" width="15%">ไม่ระบุ</td>
              <td class="report-th" width="15%">รวม</td>
            </tr>
          <?php
          $intRow = 0;
          $total_count_m = 0;
          $total_count_f = 0;
          $total_count_null = 0;
          $total_sum_count = 0;
          $total_count_care = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $sum_count = ($row['count_m']+$row['count_f']+$row['count_null']);
            $total_count_m += $row['count_m'];
            $total_count_f += $row['count_f'];
            $total_count_null += $row['count_null'];
            $total_sum_count += $sum_count;
            $total_count_care += $row['count_care'];

            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['mmyy'];?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_m'] > 0){
                    echo number_format($row['count_m']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_f'] > 0){
                    echo number_format($row['count_f']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_null'] > 0){
                    echo number_format($row['count_null']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if(($sum_count) > 0){
                    echo number_format($sum_count);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_care'] > 0){
                    echo number_format($row['count_care'],2);
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
            if($total_count_m > 0){
                echo number_format($total_count_m);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_f > 0){
                echo number_format($total_count_f);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_null > 0){
                echo number_format($total_count_null);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if(($total_sum_count) > 0){
                echo number_format($total_sum_count);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_care > 0){
                echo number_format($total_count_care,2);
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
