<?php
foreach ($map_area as $area) {
?>
  <input name="map_province"  type="checkbox" style="display:none" checked="checked" value="<?php echo site_url(); ?>/difficult/gateway_xml_map/<?php echo $area['area_id'];?>" id="map_province_<?php echo $area['area_id'];?>" >
<?php
}
?>
