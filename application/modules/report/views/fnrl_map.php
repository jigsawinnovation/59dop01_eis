<?php
foreach ($map_area as $area) {
?>
  <input name="map_province"  type="checkbox" style="display:none" checked="checked" value="<?php echo site_url().report_url(); ?>fnrl_report/fnrl_xml_map/<?php echo $area['area_id'];?>" id="map_province_<?php echo $area['area_id'];?>" >
<?php
}
?>
<table cellspacing="2" cellpadding="2" id="mapTitle" class="mapTitle">
    <tr>
        <td  style="background-color:#0493C6;padding:5px; color:#FFF;border-radius: 5px 5px 0px 0px;" align="center" colspan="2">
          <b>การจัดการศพผู้สูงอายุตามประเพณี</b>
        </td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#daf2d6;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">ไม่มีผู้สูงอายุในภาวะยากลำบาก</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#aad4a8;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 1 คน</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#ede17b;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 50 คน</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#ecb07b;height:30px;width:30px;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 250 คน</td>
    </tr>
    <tr>
        <td width="30" align="center">
          <div style="background-color:#ef817b;height:30px;width:30;margin:5px;border:#FAB82C 1px solid;">&nbsp;</div>
        </td>
        <td align="left">จำนวนมากกว่า 500 คน</td>
    </tr>
    <tr>
        <td   align="center" colspan="2">&nbsp;</td>
    </tr>
</table>
