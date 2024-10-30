<?php

/*
Plugin Name: Media Finder
Plugin URI: http://vladimir-k.blogspot.com/2009/09/media-finder-wordpress-plugin-for.html
Description: This plugin lets you search for photos on Flickr and videos on YouTube and insert results directly to your post. 
Author: Vladimir Kadalashvili
Version: 1.0.0
Author URI: http://vladimir-k.blogspot.com
*/

function ms_root() {
	return get_bloginfo('url').'/'.PLUGINDIR.'/media-finder/media-finder';
}

function ms_add_tab($tabs) {
	if (ms_is_applicable()) {
	    $tabs['search'] = __('Search'); 
	}
	return $tabs;
}

add_filter('media_upload_tabs', 'ms_add_tab');


function ms_tab_content() {
	$type = $_GET['type'];
	switch ($type) {
		case 'image':
            wp_iframe('media_search_form');
            break;
		case 'video':
		    wp_iframe('media_search_video_form');
		    break;
	}
}

function ms_is_media_tb() {
	$filename = basename($_SERVER['SCRIPT_FILENAME']);
    return 'media-upload.php' == $filename;
}


function ms_is_video_tab() {
    return ms_is_media_tb() && isset($_GET['type']) && 'video' == $_GET['type'] && isset($_GET['tab']) && 'search' == $_GET['tab'];	
}

function ms_is_image_tab() {
    return ms_is_media_tb() && isset($_GET['type']) && 'image' == $_GET['type'] && isset($_GET['tab']) && 'search' == $_GET['tab'];		
}



function ms_print_scripts() {

	//video scripts
	

	if (ms_is_video_tab()) {
	    wp_enqueue_script('json_sans_eval', ms_root().'/json-sans-eval.js');
	    wp_enqueue_script('ms_search_video', ms_root().'/ms-search-video.js');
	}
	
	//img

	if (ms_is_image_tab()) {
	    wp_enqueue_script('ms_search_image', ms_root().'/ms-search-image.js');
	}
}

add_action('admin_print_scripts', 'ms_print_scripts');

function ms_print_styles() {

	//video
	if (ms_is_video_tab()) {
	    wp_enqueue_style('ms_search_video', ms_root().'/ms-search-video.css');
	}
	
	//img
	if (ms_is_image_tab()) {
	    wp_enqueue_style('ms_search_image', ms_root().'/ms-search-image.css');
	}
}

add_action('admin_print_styles', 'ms_print_styles');


function media_search_video_form() {
	media_upload_header();
    $post_id = $_GET['post_id'];

	include(WP_PLUGIN_DIR.'/media-finder/media-finder/search-video-form.php');
}


function media_search_form() {
	media_upload_header();
    $post_id = $_GET['post_id'];
	include(WP_PLUGIN_DIR.'/media-finder/media-finder/search-image-form.php');
}

function ms_iframe_content() {
	media_upload_type_form();
}

add_action('media_upload_search', 'ms_tab_content');

function ms_is_applicable() {
	$types = array('image', 'video');
	return in_array($_GET['type'], $types);
}

function ms_fetch_feed($uri) {
	if (function_exists('curl_init')) {
		$ch = curl_init ($uri) ;
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ;
        $res = curl_exec ($ch) ;
        curl_close ($ch) ;
	}
	else if ("1" == ini_get("allow_url_fopen")) {
	    $res =  file_get_contents($uri);	
	}
	else {
		$res = '';
	}

	return $res;
}

function ms_search_image() {

	$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
	$q = isset($_POST['q']) ? $_POST['q'] : 'wordpress';
	$sort = isset($_POST['orderby']) ? $_POST['orderby'] : 'relevance';
	
	$valid_licenses = array('1', '2', '3', '4', '5', '6');
	$license = isset($_POST['license']) && in_array($_POST['license'], $valid_licenses) ? $_POST['license'] : implode(',', $valid_licenses);
	
	$license = urlencode($license);
	$q = urlencode($q);
	$sort = urlencode($sort);
	
	$qvar = 'text';
	if ('fulltext' == $_POST['searchby']) {
		$qvar = 'text';
	}
	else if ('tags' == $_POST['searchby']) {
		$qvar = 'tags';
	}
	
	
	$uri = "http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=98dc5a1e9f1ca99e90345b02cd1d9ace&sort=$sort&$qvar=$q&per_page=20&page=$page&license=$license";

	$feed = ms_fetch_feed($uri);
	@header('Content-type: application/xml; charset=UTF-8');
	die($feed);
}

add_action('wp_ajax_search_image', 'ms_search_image');

function ms_search_video() {
	if (isset($_POST['uri'])) {
		$uri = $_POST['uri'];
	}
	else {
		$q = isset($_POST['q']) ? urlencode($_POST['q']) : 'wordpress';
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : 'relevance';
		$uri = "http://gdata.youtube.com/feeds/api/videos?q=$q&orderby=$orderby&max-results=12&v=2&alt=json";
	}
	

	
	$feed = ms_fetch_feed($uri);
	@header('Content-type: application/json; charset=UTF-8');
	die($feed);
}

add_action('wp_ajax_search_video', 'ms_search_video');

function ms_is_fill_fields() {
	return ms_is_media_tb() && isset($_GET['fill_fields']) && 'type_url' == $_GET['tab'];
}

function ms_admin_head() {
    if (ms_is_fill_fields()) {
    	wp_enqueue_script('ms_fill_fields', ms_root().'/ms-fill-fields.js');
    }
}

add_action('admin_print_scripts', 'ms_admin_head');



//settings
function ms_empty() {}

function ms_input_field($val, $name) {
	?>
	<input type="text" class="small-text" value="<?php echo $val; ?>" name="<?php echo $name ?>" id="<?php echo $name; ?>" />&nbsp;<span class="description">px</span>
	<?	
}

function ms_width_input_field() {
	ms_input_field(get_option('ms_video_width'), 'ms_video_width');
}

function ms_height_input_field() {
	ms_input_field(get_option('ms_video_height'), 'ms_video_height');
}

function ms_add_settings_sections() {
	add_settings_section('ms_settings', __('Media Finder settings'), 'ms_empty', 'misc');
	add_settings_field('ms_video_width', __('Video player width'), 'ms_width_input_field', 'misc', 'ms_settings');
	add_settings_field('ms_video_height', __('Video player height'), 'ms_height_input_field', 'misc', 'ms_settings');
	register_setting('msvideo', 'ms_video_width', 'intval');
	register_setting('msvideo', 'ms_video_height', 'intval');
}

function ms_valid_options($options) {
	$options['misc'][] = 'ms_video_width';
	$options['misc'][] = 'ms_video_height';
	return $options;
}

add_action('admin_init', 'ms_add_settings_sections');
add_filter('whitelist_options', 'ms_valid_options', 1, 1);

function ms_activate() {
    add_option('ms_video_width', '425');
    add_option('ms_video_height', '344');	
}

function ms_deactivate() {
    delete_option('ms_video_width');
    delete_option('ms_video_height');
}

register_activation_hook(__FILE__, 'ms_activate');
register_deactivation_hook(__FILE__, 'ms_deactivate');


?>
