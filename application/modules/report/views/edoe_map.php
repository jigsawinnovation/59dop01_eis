<?php
foreach ($map_area as $area) {
?>
  <input name="map_province"  type="checkbox" style="display:none" checked="checked" value="<?php echo site_url().report_url(); ?>edoe_report/edoe_xml_map/<?php echo $area['area_id'];?>" id="map_province_<?php echo $area['area_id'];?>" >
<?php
}
?>
<table cellspacing="2" cellpadding="2" id="mapTitle" class="mapTitle">
    <tr>
        <td  style="background-color:#0493C6;padding:5px; color:#FFF;border-radius: 5px 5px 0px 0px;" align="center" colspan="2">
          <b>สถานประกอบการที่ต้องการผู้สูงอายุ</b>
        </td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#daf2d6;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">ไม่มีสถานประกอบการที่ต้องการผู้สูงอายุ</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#aad4a8;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 1 แห่ง</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#ede17b;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 50 แห่ง</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#ecb07b;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 250 แห่ง</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#ef817b;height:30px;width:30;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 500 แห่ง</td>
    </tr>
    <tr>
        <td   align="center" colspan="2">&nbsp;</td>
    </tr>
</table>
