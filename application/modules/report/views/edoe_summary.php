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
          "country": "<?php echo $row['budget_year'];?>",
          "visits": <?php echo round($row['count_job_vacancy']);?>,
          "visits2": <?php echo round($row['count_job_reg_y']);?>,
          "visits3": <?php echo round($row['count_job_reg_n']);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวน ตำแหน่งงานว่าง/ได้งานทำแล้ว/ยังไม่มีงานทำ"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#0D8ECF",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "ตำแหน่งงานว่าง (ตำแหน่ง)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits"
          },{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#216311",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "ได้งานทำแล้ว (คน)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits2"
        },{
          "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
          "fillAlphas": 0.8,
          "lineColor": "#E5D522",
          "labelText": "[[value]]",
          "lineAlpha": 0.3,
          "title": "ยังไม่มีงานทำ (คน)",
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
              <td class="report-th" rowspan="2" >ปีงบประมาณ</td>
              <td class="report-th" rowspan="2" width="15%">ตำแหน่งงานว่าง (ตำแหน่ง)</td>
              <td class="report-th" colspan="3">ผู้สูงอายุที่ขึ้นทะเบียนจัดหางาน (คน)</td>
            </tr>
            <tr>
              <td class="report-th" width="15%">ได้ทำงานแล้ว</td>
              <td class="report-th" width="15%">ยังไม่ได้งาน</td>
              <td class="report-th" width="15%">รวม</td>
            </tr>
          <?php
          $intRow = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            $total_count_job_vacancy = 0;
            $total_count_job_reg_y = 0;
            $total_count_job_reg_n = 0;
            $total_count_job_reg_sum = 0;
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $total_count_job_vacancy += $row['count_job_vacancy'];
            $total_count_job_reg_y += $row['count_job_reg_y']; ;
            $total_count_job_reg_n += $row['count_job_reg_n']; ;
            $total_count_job_reg_sum += $row['count_job_reg_sum']; ;
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['budget_year'];?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_vacancy']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_reg_y'] > 0){
                    echo number_format($row['count_job_reg_y']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_reg_n'] > 0){
                    echo number_format($row['count_job_reg_n']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_reg_sum'] > 0){
                    echo number_format($row['count_job_reg_sum']);
                }else{
                    echo '';
                }
                ?>
                </td>
              </tr>
            <?php
            }
            ?>
            <tr >
              <td class="report-td-sum center">รวม</td>
              <td class="report-td-sum right">
              <?php
              if($total_count_job_vacancy > 0){
                  echo number_format($total_count_job_vacancy);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_count_job_reg_y > 0){
                  echo number_format($total_count_job_reg_y);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_count_job_reg_n > 0){
                  echo number_format($total_count_job_reg_n);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_count_job_reg_sum > 0){
                  echo number_format($total_count_job_reg_sum);
              }else{
                  echo '';
              }
              ?>
              </td>
            </tr>
          <?php
          }
          ?>
          </table>
      </div>
    </div>
</div>
