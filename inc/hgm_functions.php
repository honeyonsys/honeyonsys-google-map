<?php
if(isset($_POST['save_hgm_map'])){
	$hgm_width = $_POST['hgm_width'];
	$hgm_height = $_POST['hgm_height'];
	$hgm_center_lat = $_POST['hgm_center_lat'];
	$hgm_center_lon = $_POST['hgm_center_lon'];
	$hgm_zoom = $_POST['hgm_zoom'];
	$total_loc = $_POST['total_loc'];
	$locations = array();
	for($a=0;$a<$total_loc;$a++){
		$locations_data = array($_POST['title'][$a],$_POST['latitude'][$a],$_POST['longitude'][$a],$_POST['address'][$a]);
		array_push($locations,$locations_data);
	}

	

	update_option('hgm_width',$hgm_width);
	update_option('hgm_height',$hgm_height);
	update_option('hgm_center_lat',$hgm_center_lat);
	update_option('hgm_center_lon',$hgm_center_lon);
	update_option('hgm_zoom',$hgm_zoom);
	update_option('hgm_location',$locations);

	header('location:'.admin_url('admin.php?page=hgm-top-level-handle&amp;action=add'));
}
function hgm_admin_form(){
?>
<Script type="text/javascript">
	
jQuery(document).ready(function(){
	
	
	
	
	jQuery('#hgm_add_loc').click(function(){
		var total_loc = jQuery('#total_loc').val();
		jQuery('.map_option').before('<tr class="location_list"><td><input type="text" name="title[]" id="title" value=""/>			<br> <span class="hgm-input-info">[Title display on marker\'s Popup ]</span></td><td colspan="2">			<textarea name="address[]" style="width:100%"></textarea><br> <span class="hgm-input-info">[Address display on marker\'s popup ] </span></td><td><input type="text" name="latitude[]" value=""/><br> <span class="hgm-input-info">[Marker\'s Latitude]</span></td><td><input type="text" class="my_input" name="longitude[]" value=""/><br> <span class="hgm-input-info">[Marker\'s Longitude]</span></td><td><div class="remove_row">Remove [X]</div></td></tr>');
		jQuery('#total_loc').val(parseInt(total_loc) + 1);
	});

	jQuery('.remove_row').click(function(){
		var total_loc = jQuery('#total_loc').val();
		jQuery(this).parents('.location_list').hide();
		jQuery('#total_loc').val(parseInt(total_loc) - 1);

	});
});



</Script>
<div class="wrap">
<h3 class="title">Honeyonsys Google Map Settings</h3>
<p>You can create one or multiple markers using the following settings. Place this shortcode <b>[show_map_locations]</b> where you want to put the map on your page/post. </p>
<p>To place the map inside a template file you can simply use <b>&lt;&#63;php echo do_shortcode('[show_map_locations]'); &#63;&gt;</b></p>
<form name="add_trainer" method="post" enctype="multipart/form-data"> 
  <table style="padding-left:55px;" class="form-table permalink-structure" cellspacing="5">
  	<tr>
  		<td colspan="4">
  			
  		</td>
  		<td>
  			<?php $loc_array = get_option('hgm_location'); ?>
  			<input type="hidden" name="total_loc" id="total_loc" value="<?php echo count($loc_array); ?> "/><input type="button" id="hgm_add_loc" value="[ Add More Location + ]" />
  		</td>
  	</tr>
  	<?php 
  	$s = 0;
		foreach($loc_array as $loc){?>
  	<tr class="location_list">
		
		<td>
			<input type="text" name="title[]" id="title" value="<?php echo $loc[0]; ?>"/>
			<br> <span class="hgm-input-info">[Title display on marker's Popup ]</span>
		</td>
		<td>
			<textarea name="address[]" style="width:100%"><?php echo $loc[3]; ?></textarea>
			
			<br> <span class="hgm-input-info">[Address display on marker's popup ] </span>
		</td>
		<td>
			<input type="text" name="latitude[]" value="<?php echo $loc[1]; ?>"/>
			<br> <span class="hgm-input-info">[Marker's Latitude]</span>
		</td>
		<td>
			<input type="text" class="my_input" name="longitude[]" value="<?php echo $loc[2]; ?>"/>
			<br> <span class="hgm-input-info">[Marker's Longitude]</span>
		</td>
		<td>
			<div class="remove_row">Remove [X]</div>
		</td>
		

	</tr>
	<?php $s++; } ?>

		
	<tr class="map_option">
		<td>
			Map's Width<br>
			<input type="text" name="hgm_width" placeholder="map width" value="<?php echo get_option('hgm_width');?>" /><br>
			<span class="hgm-input-info">[eg: 100px or 100%]</span>
		</td>
		<td>
			Map's Height<br>
			<input type="text" name="hgm_height" placeholder="map height" value="<?php echo get_option('hgm_height');?>" />
			<br><span class="hgm-input-info">[eg: 100px]</span>
		</td>
		
		<td>
			Center Latitude<br>
			<input type="text" name="hgm_center_lat" placeholder="Latitude_center" value="<?php echo get_option('hgm_center_lat');?>" />
			<br><span class="hgm-input-info">[Map center location latitude]</span>
		</td>
		<td>
			Center Longitude<br>
			<input type="text" name="hgm_center_lon" placeholder="Longitude_center" value="<?php echo get_option('hgm_center_lon');?>" />
			<br> <span class="hgm-input-info">[Map center location Longitude]</span>
		</td>
		<td>
			Zoom Level<br>
			<select name="hgm_zoom">
				<?php 
				$zoom = get_option('hgm_zoom');
				for($i=1;$i<=21;$i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($zoom==$i){?>selected="selected"<?php } ?>> <?php echo $i; ?> </option>
				<?php } ?>
				
				
			</select><br> <span class="hgm-input-info">[Zoom level 1-21]</span>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<input type="submit" name="save_hgm_map" id="save_hgm_map" value="Save" class="button button-primary" />
		</td>
	</tr>
  </table>
  </form>
  </div>
<?php } 


function map_with_locations(){

//wp_enqueue_script( 'googlemap', HGM_URL. '/js/googlemap.js', array(), '1.0.0', false );
//wp_register_script('hgm-script', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
//wp_enqueue_script('hgm-script');
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<div id="map" style="height: <?php echo get_option('hgm_height'); ?>; width: <?php echo get_option('hgm_width'); ?>;"></div>


<script type="text/javascript">
    
    var locations = <?php echo json_encode(get_option('hgm_location'));?>;
    
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: <?php echo get_option('hgm_zoom'); ?>,
      center: new google.maps.LatLng(<?php echo get_option('hgm_center_lat').','.get_option('hgm_center_lon');?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
      
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });
      
      
        
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]+'<br>'+locations[i][3]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
    

  </script>
<?php 
} // [show_map_locations]  ends
?>