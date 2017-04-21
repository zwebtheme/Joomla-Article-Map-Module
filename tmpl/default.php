<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$base_latitude = $params->get('base_latitude');
$base_longitude = $params->get('base_longitude');
$base_zoom = $params->get('base_zoom');


//Map script
	 function getMap($list, $base_latitude, $base_longitude, $base_zoom){
         
         
            $map_script ='<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyAZ_gB5ISNkZ4DvI6Luar3clZ1rW70tnok"></script>';
                $map_script .='<script type="text/javascript" src="modules/mod_articles_map/js/jquery.ui.map.js"></script>';
	            $map_script .="<script type='text/javascript' > ";
				
				$map_script .="jQuery( document ).ready( function (){ ";
				$map_script .="jQuery('#map_category').gmap({'zoom': ".$base_zoom.",'center': '".$base_latitude." , ".$base_longitude."', 'disableDefaultUI':true}).bind('init', function(evt, map) { ";
				$map_script .=" var bounds = map.getBounds(); var southWest = bounds.getSouthWest(); var northEast = bounds.getNorthEast(); var lngSpan = northEast.lng() - southWest.lng(); var latSpan = northEast.lat() - southWest.lat();";
				 
				
            $df =0;
	        foreach( $list as $item ){
	        $df++;
				
				//Get Google Map Param
                $google_map = $item->params['google_map'];
                $latitude = $item->params['custom_latitude'];
                $longitude = $item->params['custom_longitude'];
                
                $item_title = $item->title;
                $item_title = preg_replace('/[^a-zA-Z0-9\']/', ' ', $item_title);
                $item_title = str_replace("'", '', $item_title);

				$contentm = '<p style="text-align: center;">'.$item_title.'</p>';
				$contentm .= '<a href="'.$item->link.'" style="text-align: center;">Details</a>';
				
				
				if(!empty($google_map)){
                  $lat = $latitude;
                  $long = $longitude;
			 
			      $map_script .="jQuery('#map_category').gmap('addMarker', { \n";
			      $map_script .="'position': new google.maps.LatLng(".$lat.", ".$long.") \n";
		          $map_script .="}).click(function() { \n";
			      $map_script .="jQuery('#map_category').gmap('openInfoWindow', { content : '".$contentm."' }, this); \n";
		          $map_script .="}); \n";
			  }
				
            }//end foreach
				
				$map_script .=" });";
				$map_script .="} );";
				$map_script .="</script>";
				
				return $map_script;
	}
	
echo getMap($list, $base_latitude, $base_longitude, $base_zoom);

?>


<div class="article_map <?php echo $moduleclass_sfx; ?>">
	<div id="map_category" style="height: 450px; width: 100%;margin-top: 20px;margin-bottom: 20px;"></div>
</div>

