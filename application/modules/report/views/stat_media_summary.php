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
          "visits": <?php echo round($row['count_of'],2);?>

        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวนเข้าชม (ครั้ง)"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "lineColor": "#63D946",
            "bulletColor": "#FFFFFF",
            "labelText": "[[value]]",
            "title": "จำนวนเข้าชม (ครั้ง)",
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

        <?php
        foreach ($summary as $key=>$row) {
          if($row['count_of'] > 0){
        ?>
          AmCharts.makeChart( "line_import_<?php echo $key;?>", {
            "type": "serial",
          "theme": "light",
            "dataProvider": [
              <?php
              foreach ($summary_date[$key] as $date=>$row_import) {
              ?>
              {
                "day": <?php echo $date;?>,
                "value": <?php echo round($row_import['count_log']);?>
              },
              <?php
              }
              ?>
            ],
            "categoryField": "day",
            "autoMargins": false,
            "marginLeft": 0,
            "marginRight": 5,
            "marginTop": 0,
            "marginBottom": 0,
            "graphs": [ {
              "fillAlphas": 0.5,
              "valueField": "value",
              "bulletField": "bullet",
              "showBalloon": false,
              "lineColor": "#63D946"
            } ],
            "valueAxes": [ {
              "gridAlpha": 0,
              "axisAlpha": 0
            } ],
            "categoryAxis": {
              "gridAlpha": 0,
              "axisAlpha": 0,
              "startOnAxis": false
            }
          } );
        <?php
          }
        }
        ?>
        </script>
        <!-- End Chart -->
      </div>
      <div class="col-sm-12">
          <table width="100%" class="report-table">
            <tr>
              <td class="report-th" rowspan="2">ช่วงเวลา<br/>(เดือน ปี)</td>
              <td class="report-th" colspan="3">การเข้าชมสื่อมัลติมีเดีย</td>
            </tr>
            <tr>
              <td class="report-th" width="20%">สถิติ</td>
              <td class="report-th" width="20%">จำนวนเข้าชม (ครั้ง)</td>
              <td class="report-th" width="20%">จำนวนสื่อมัลติมีเดีย (สื่อ)</td>
            </tr>
          <?php
          $intRow = 0;
          $total_count_of = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            foreach ($summary as $key =>$row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $total_count_of += $row['count_of'];
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['mmyy'];?></td>
                <td class="<?php echo $class_td;?> center">
                  <?php
                    if($row['count_of'] > 0){
                  ?>
                    <div id="line_import_<?php echo $key;?>" style="vertical-align: middle; display: inline-block; width: 100px; height: 30px;"></div>
                  <?php
                    }
                  ?>

                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_of'] > 0){
                    echo number_format($row['count_of']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">

                </td>
              </tr>
            <?php
            }
          }
          ?>
          <tr >
            <td class="report-td-sum center">รวม</td>
            <td class="report-td-sum center">
              <?php
                if($row['count_of'] > 0){
              ?>
                <div id="line_import_<?php echo $key;?>" style="vertical-align: middle; display: inline-block; width: 100px; height: 30px;"></div>
              <?php
                }
              ?>

            </td>
            <td class="report-td-sum right">
            <?php
            if($total_count_of > 0){
                echo number_format($total_count_of);
            }else{
                echo '';
            }
            ?>
            </td>
            <td class="report-td-sum right">

            </td>
          </tr>
          </table>
      </div>
    </div>
</div>
