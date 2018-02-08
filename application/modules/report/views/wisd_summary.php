<?php
function substr_utf8( $str, $start_p , $len_p){
      return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start_p.'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len_p.'}).*#s','$1' , $str );
}
?>
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
          if(strlen($row['wis_name'])>30){
            $wis_name = substr_utf8($row['wis_name'],0,15).'...';
          }else{
            $wis_name = $row['wis_name'];
          }
        ?>
        {
          "country": "<?php echo $wis_name;?>",
          "visits": <?php echo round($row['wis_count_info']);?>
        },
        <?php
        }
        ?>
        ],
        "valueAxes": [{
          "position": "left",
          "title": "จำนวนภูมิปัญญา"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:20px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "lineColor": "#0D8ECF",
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "สาขาภูมิปัญญา (ภูมิปัญญา)",
            "type": "column",
            "color": "#000000",
            "valueField": "visits"
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
            <tr>
              <td class="report-th" >สาขาภูมิปัญญา</td>
              <td class="report-th" width="20%">จำนวน (ภูมิปัญญา)</td>
              <td class="report-th" width="20%">ร้อยละ</td>
            </tr>
          <?php
          $intRow = 0;
          $summary_wis = 0;
          $wis_percent = 0;
          $arr_class_td = array('report-td-a','report-td-b');
          if($summary){
            foreach ($summary as $row) {
            $intRow++;
            $class_td = $arr_class_td[$intRow%2];
            $summary_wis += $row['wis_count_info'];
            $wis_percent += $row['wis_percent'];
            ?>
              <tr >
                <td class="<?php echo $class_td;?> left"><?php echo $row['wis_name'];?></td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['wis_count_info'] > 0){
                    echo number_format($row['wis_count_info']);
                }else{
                    echo '';
                }
                ?>
                </td>
                <td class="<?php echo $class_td;?> right">
                <?php
                if($row['wis_percent'] > 0){
                    echo number_format($row['wis_percent'],2);
                }else{
                    echo '';
                }
                ?>
                </td>
              </tr>
            <?php
            }
            ?>
            <tr>
              <td class="report-td-sum" >รวม</td>
              <td class="report-td-sum right"><?php echo number_format($summary_wis)?></td>
              <td class="report-td-sum right"><?php echo number_format($wis_percent,2)?></td>
            </tr>
            <?php
          }
          ?>
          </table>
      </div>
    </div>
</div>
