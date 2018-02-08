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
        $intRow = 0;
        foreach ($summary as $row) {
          $intRow++;
        ?>
        {
          "country": "<?php echo $row['list_name'];?>",
          "visits": <?php echo round($row['count_job_vacancy']+$intRow);?>,
          "visits2": <?php echo round($row['count_job_reg_y']+$intRow+2);?>,
          "visits3": <?php echo round($row['count_job_reg_n']+$intRow+4);?>,
          "visits4": <?php echo round($row['count_job_reg_n']);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "stackType": "regular",
          "axisAlpha": 0.3,
          "gridAlpha": 0
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#F44D4D",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "กลุ่ม A",
            "type": "column",
            "color": "#000000",
            "valueField": "visits"
          },{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#F3F025",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "กลุ่ม B",
            "type": "column",
            "color": "#000000",
            "valueField": "visits2"
        },{
          "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
          "fillAlphas": 0.8,
          "lineColor": "#338125",
          "labelText": "[[value]]",
          "lineAlpha": 0.3,
          "title": "กลุ่ม C",
          "type": "column",
          "color": "#000000",
          "valueField": "visits3"
      },{
        "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
        "fillAlphas": 0.8,
        "lineColor": "#EEEEEE",
        "labelText": "[[value]]",
        "lineAlpha": 0.3,
        "title": "ไม่ระบุ",
        "type": "column",
        "color": "#000000",
        "valueField": "visits4"
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
      </div>
      <div class="col-sm-12">
          <table width="100%" class="report-table">
            <tr>
              <td rowspan="3" class="report-th" width="10%">กลุ่มผู้รับริการ<br/>(ตามช่วงอายุ)</td>
              <td colspan="10" class="report-th" >ปริมาณผู้รับบริการ(ราย)</td>
              <td rowspan="3" class="report-th" width="10%">รวมทั้งหมด</td>
            </tr>
            <tr>
              <td colspan="5" class="report-th">เพศชาย</td>
              <td colspan="5" class="report-th">เพศหญิง</td>
            </tr>
            <tr>
              <td class="report-th" width="8%">A</td>
              <td class="report-th" width="8%">B</td>
              <td class="report-th" width="8%">C</td>
              <td class="report-th" width="8%">-</td>
              <td class="report-th" width="8%">รวม</td>
              <td class="report-th" width="8%">A</td>
              <td class="report-th" width="8%">B</td>
              <td class="report-th" width="8%">C</td>
              <td class="report-th" width="8%">-</td>
              <td class="report-th" width="8%">รวม</td>
            </tr>
          <?php
          $intRow = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            $total_ma = 0;
            $total_mb = 0;
            $total_mc = 0;
            $total_m_no = 0;
            $total_sum_m = 0;

            $total_fa = 0;
            $total_fb = 0;
            $total_fc = 0;
            $total_f_no = 0;
            $total_sum_f = 0;
            $total_sum_all = 0;

            foreach ($summary as $index => $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];

            $sum_m[$index] = 0;
            $sum_f[$index] = 0;
            $sum_fm[$index] = 0;

            $total_ma += $row['count_job_reg_n'];
            $total_mb += $row['count_job_reg_n'];
            $total_mc += $row['count_job_reg_n'];
            $total_m_no += $row['count_job_reg_n'];
            $sum_m[$index] = $row['count_job_reg_n']+$row['count_job_reg_n']+$row['count_job_reg_n']+$row['count_job_reg_n'];
            $total_sum_m += $sum_m[$index];

            $total_fa += $row['count_job_vacancy'];
            $total_fb += $row['count_job_vacancy'];
            $total_fc += $row['count_job_vacancy'];
            $total_f_no += $row['count_job_vacancy'];
            $sum_f[$index] = $row['count_job_vacancy']+$row['count_job_vacancy']+$row['count_job_vacancy']+$row['count_job_vacancy'];
            $total_sum_f += $sum_f[$index];
            $sum_fm[$index] = $sum_m[$index]+$sum_f[$index];
            $total_sum_all += $total_sum_m+$total_sum_f;
            ?>
              <tr >
                <td class="<?php echo $class_td;?> center"><?php echo $row['list_name'];?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_reg_n']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_reg_n']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_reg_n']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_reg_n']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($sum_m[$index] > 0){
                    echo number_format($sum_m[$index]);
                }else{
                    echo '';
                }
                ?>
                </td>
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
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_vacancy']);
                }else{
                    echo '';
                }
                ?>
                </td>
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
                if($row['count_job_vacancy'] > 0){
                    echo number_format($row['count_job_vacancy']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($sum_f[$index] > 0){
                    echo number_format($sum_f[$index]);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($sum_fm[$index] > 0){
                    echo number_format($sum_fm[$index]);
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
              if($total_ma > 0){
                  echo number_format($total_ma);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_mb > 0){
                  echo number_format($total_mb);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_mc > 0){
                  echo number_format($total_mc);
              }else{
                  echo '';
              }
              ?>
              <td class="report-td-sum right">
              <?php
              if($total_m_no > 0){
                  echo number_format($total_m_no);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_sum_m > 0){
                  echo number_format($total_sum_m);
              }else{
                  echo '';
              }
              ?>
              <td class="report-td-sum right">
              <?php
              if($total_fa > 0){
                  echo number_format($total_fa);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_fb > 0){
                  echo number_format($total_fb);
              }else{
                  echo '';
              }
              ?>
              <td class="report-td-sum right">
              <?php
              if($total_fc > 0){
                  echo number_format($total_fc);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_f_no > 0){
                  echo number_format($total_f_no);
              }else{
                  echo '';
              }
              ?>
              </td>
              <td class="report-td-sum right">
              <?php
              if($total_sum_f > 0){
                  echo number_format($total_sum_f);
              }else{
                  echo '';
              }
              ?>
              <td class="report-td-sum right">
              <?php
              if($total_sum_all > 0){
                  echo number_format($total_sum_all);
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
