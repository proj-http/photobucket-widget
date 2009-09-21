<?php
/*
Plugin Name: photobucket Widget
Author URI: http://xfuxing.com
Plugin URI: http://xfuxing.com/2009/plug-in-released-photobucket-widget-for-wordpress.html
Description: Making very easy for you to embed in sidebars from your photobucket account!
Author: freephp
Version: 0.9
*/
load_plugin_textdomain('photobucket-widget', 'wp-content/plugins/photobucket-widget');

function photobucket_widget_echo(){
	$options = get_option('widget_photobucket');
	$objwidth=$options['imagewidth'];
	$feedurl=$options['feedurl'];
	$limit=$options['imagenum'];
	$paddingn=$options['paddingn'];
	$bordern=$options['bordern'];
	$bordercolor=$options['bordercolor'];
	$space=$options['spacen'];
	$path=thumb_dir() . '/';
	$output = '';
	$title=$link=$filename=$thfilename=$jarray=array();
	if(file_exists(ABSPATH . WPINC . '/rss.php') )
		require_once(ABSPATH . WPINC . '/rss.php');
	else
		require_once(ABSPATH . WPINC . '/rss-functions.php');
	$rss = fetch_rss($feedurl);
	if (!empty($rss->items)) {
		$i = -1;
		foreach($rss->items as $item) {
			$i++;
			$title[$i] = $item['title'];
			$link[$i] = $item['guid'];
			$filename[$i] = substr(strrchr($link[$i],"/"),1);
			$thfilename[$i] = 'th_' . $objwidth . '_' . preg_replace( '/\\.[^\\.]+$/', '.jpg', $filename[$i]);
		}
		$begin=0;
		$end=count($rss->items)-1;
		$jarray=NoRand($begin,$end,$limit);
		$maxtime=ini_get('max_execution_time');
		ini_set('max_execution_time', '180');
		$output.='<div class="aligncenter">'. "\n";
		if ($limit>count($rss->items))
			$limit=count($rss->items);
		for ($i=0;$i < $limit; $i++) {
			$j=$jarray[$i];
			$objfilename=$path . $thfilename[$j];
			create_thumb($link[$j],$objfilename,$objwidth);
			$output.='<a href="'. $link[$j] . '"';
			if ($options['effect'])
				$output.=' class="thickbox"';
			$output.='>' . "\n";
			$output.='<img style="padding:'.$paddingn.'px;border:'.$bordern.'px solid '.$bordercolor.';" hspace='.$space.' vspace='.$space.' src="'.get_option('home').'/'.$path.$thfilename[$j].'" alt="'.$title[$j].'" /></a>'."\n"; 
		}
		ini_set('max_execution_time', $maxtime);
		$output.='</div>'."\n";
	}
	echo $output;
}
function photobucket_widget($args) {
	$options = get_option('widget_photobucket');
	$title = $options['title'];
    extract($args);
	echo $before_widget;
	echo $before_title . ($title==""?__('My photos on photobucket','photobucket-widget'):$title) . $after_title;
	photobucket_widget_echo();
	echo $after_widget; 
}
function photobucket_widget_control() {
	$options = $newoptions = get_option('widget_photobucket');
	if ( $_POST["photobucket-submit"] ) {
		$newoptions['title'] = trim(strip_tags(stripslashes($_POST["photobucket-title"])));
		$newoptions['feedurl'] = strip_tags(stripslashes($_POST["photobucket-feeds"]));
		$newoptions['imagenum'] = trim(strip_tags(stripslashes($_POST["photobucket-number"])));
		$newoptions['imagewidth'] = trim(strip_tags(stripslashes($_POST["photobucket-width"])));
		$newoptions['paddingn'] = trim(strip_tags(stripslashes($_POST["photobucket-paddingn"])));
		$newoptions['bordern'] = trim(strip_tags(stripslashes($_POST["photobucket-bordern"])));
		$newoptions['bordercolor'] = trim(strip_tags(stripslashes($_POST["photobucket-bordercolor"])));
		$newoptions['spacen'] = trim(strip_tags(stripslashes($_POST["photobucket-spacen"])));
		$newoptions['effect'] = isset($_POST["photobucket-effect"]);
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_photobucket', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
	$feedurl = htmlspecialchars($options['feedurl'], ENT_QUOTES);
	$imagenum = htmlspecialchars($options['imagenum'], ENT_QUOTES);
	$imagewidth = htmlspecialchars($options['imagewidth'], ENT_QUOTES);
	$paddingn = htmlspecialchars($options['paddingn'], ENT_QUOTES);
	$bordern = htmlspecialchars($options['bordern'], ENT_QUOTES);
	$bordercolor = htmlspecialchars($options['bordercolor'], ENT_QUOTES);
	$spacen = htmlspecialchars($options['spacen'], ENT_QUOTES);
	$effect = $options['effect'] ? 'checked="checked"' : '';
	$temp=($feedurl=="");
	?>
	<p>
		<label for="photobucket-title"><?php _e('Widget Title','photobucket-widget');?>:</label>
		<br />
		<input id="photobucket-title" name="photobucket-title" type="text" value="<?php echo ($temp?__("Photos","photobucket-widget"):$title); ?>" />
	</p>
	<p>
		<label for="photobucket-feeds"><?php _e('photobucket feeds url','photobucket-widget');?>:</label>
		<br />
		<input id="photobucket-feeds" name="photobucket-feeds" type="text" value="<?php echo ($temp?__("Your photobucket feeds url","photobucket-widget"):$feedurl); ?>" />
	</p>
	<p>
		<label for="photobucket-effect"><?php _e('Show effect with thickbox?','photobucket-widget');?> 
			<input class="checkbox" type="checkbox" <?php echo $effect; ?> id="photobucket-effect" name="photobucket-effect" />
		</label>
	</p>
	<p>
		<label for="photobucket-number"><?php _e('Number of display','photobucket-widget');?>:
			<br />
			<input id="photobucket-number" name="photobucket-number" type="text" value="<?php echo ($temp?4:$imagenum); ?>" />
			<small><?php _e('pictures','photobucket-widget');?></small>
		</label>
	</p>	
	<p>
		<label for="photobucket-width"><?php _e('Width of photo','photobucket-widget');?>:
			<br />
			<input id="photobucket-width" name="photobucket-width" type="text" value="<?php echo ($temp?125:$imagewidth); ?>" />
		</label>
	</p>
	<p>
		<label for="photobucket-paddingn"><?php _e('Padding of photo','photobucket-widget');?>:
			<br />
			<input id="photobucket-paddingn" name="photobucket-paddingn" type="text" value="<?php echo ($temp?3:$paddingn); ?>" />
			<small>px</small>
		</label>
	</p>
	<p>
		<label for="photobucket-bordern"><?php _e('Border of photo','photobucket-widget');?>:
			<br />
			<input id="photobucket-bordern" name="photobucket-bordern" type="text" value="<?php echo ($temp?1:$bordern); ?>" />
			<small>px</small>
		</label>
	</p>
	<p>
		<label for="photobucket-bordercolor"><?php _e('Color of border','photobucket-widget');?>:
			<br />
			<input id="photobucket-bordercolor" name="photobucket-bordercolor" type="text" value="<?php echo ($temp?"#d3d3d3":$bordercolor); ?>" />
			<small>eg: #d3d3d3</small>
		</label>
	</p>
	<p>
		<label for="photobucket-spacen"><?php _e('Space between photos','photobucket-widget');?>:
			<br />
			<input id="photobucket-spacen" name="photobucket-spacen" type="text" value="<?php echo ($temp?0:$spacen); ?>" />
			<small>px</small>
		</label>
	</p>
	<input type="hidden" id="photobucket-submit" name="photobucket-submit" value="1" />
	<?php
}
function NoRand($begin,$end,$limit){ 
	$rand_array=range($begin,$end); 
	shuffle($rand_array); 
	return array_slice($rand_array,0,$limit); 
}
function thumb_dir(){
	$dirname='';
	if (get_option('home')!=get_option('siteurl')) {
		$dirname.=substr(str_replace(get_option('home'),'',get_option('siteurl')),1).'/';
	}
	if (get_option('upload_path')!='') {
		$dirname.=str_replace(ABSPATH,'',trim(get_option('upload_path'))).'/thumb_SHe';
	} else {
		$dirname.='wp-content/uploads/thumb_SHe';
	}
	if (!file_exists($dirname)) {
		wp_mkdir_p($dirname);
	}
	return $dirname;
} 
function create_thumb($src_file,$dst_file,$new_width){
	if (file_exists($dst_file)) {
		return;
	}
//thanks "revelc(http://hply.info)" for this bug.
	if (!function_exists('exif_imagetype')){
		function exif_imagetype($filename){
			if((list($width, $height, $type, $attr) = getimagesize($filename)) !== false ){
				return $type;
			}
			return false;
		}
	}
	$type=exif_imagetype($src_file);
	switch($type) {
		case IMAGETYPE_JPEG:
			$src_img=imagecreatefromjpeg($src_file);
			break;
		case IMAGETYPE_PNG:
			$src_img=imagecreatefrompng($src_file);
			break;
		case IMAGETYPE_GIF:
			$src_img=imagecreatefromgif($src_file);
			break;
		default:
			return;
	}
	$w=imagesx($src_img);
	$h=imagesy($src_img);
	if ($w>$h) {
		$xroll=($w-$h)/2;
		$yroll=0;
		$inter_w=$h;
	} else {
		$xroll=0;
		$yroll=($h-$w)/2;
		$inter_w=$w;
	}
	$inter_img=imagecreatetruecolor($inter_w,$inter_w);
	imagecopyresampled($inter_img,$src_img,0,0,$xroll,$yroll,$inter_w,$inter_w,$inter_w,$inter_w);
	$new_img=imagecreatetruecolor($new_width,$new_width);
	imagecopyresampled($new_img,$inter_img,0,0,0,0,$new_width,$new_width,$inter_w,$inter_w);
	imagejpeg($new_img, $dst_file,100);
}
function init_photobucket_widget(){
	register_sidebar_widget("photobucket Widget", "photobucket_widget");
	register_widget_control("photobucket Widget", "photobucket_widget_control");

}
add_action("plugins_loaded", "init_photobucket_widget");
?>