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
          "country": "<?php echo $row['year'];?>",
          "visits": <?php echo round($row['count_school'],2);?>

        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวนโรงเรียนที่ก่อตั้ง (โรง)"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "lineColor": "#63D946",
            "bulletColor": "#FFFFFF",
            "labelText": "[[value]]",
            "title": "จำนวนโรงเรียนที่ก่อตั้ง (โรง)",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletSize": 8,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "useLineColorForBulletBorder": true,
            "valueField": "visits"
          }],
        "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":true,
        "color":"#AAAAAA"
        },
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
              <td class="report-th" rowspan="2">ช่วงเวลา ปี</td>
              <td class="report-th" colspan="3">ข้อมูลดำเนินงาน</td>
            </tr>
            <tr>
              <td class="report-th" width="25%">จำนวนโรงเรียนที่ก่อตั้ง (โรง)</td>
              <td class="report-th" width="25%">จำนวน (รุ่น)</td>
              <td class="report-th" width="25%">จำนวนผู้เข้าร่วม (คน)</td>
            </tr>
          <?php
          $intRow = 0;
          $total_count_school = 0;
          $total_count_gen = 0;
          $total_count_pers = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $total_count_school += $row['count_school'];
            $total_count_gen += $row['count_gen'];
            $total_count_pers += $row['count_pers'];
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['year'];?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_school'] > 0){
                    echo number_format($row['count_school']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_gen'] > 0){
                    echo number_format($row['count_gen']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_pers'] > 0){
                    echo number_format($row['count_pers']);
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
            if($total_count_school > 0){
                echo number_format($total_count_school);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_gen > 0){
                echo number_format($total_count_gen);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_pers > 0){
                echo number_format($total_count_pers);
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
