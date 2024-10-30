	<div id="search_wrapper">
	<form action="/" method="post">
	  <h3 class="media-title"><?php _e('YouTube search') ?></h3>
	  <input type="text" name="q" style="width: 450px;" id="q" />
	  <input type="submit" value="<?php _e('Search'); ?>" id="img_search" class="button-secondary" />
	  <span style="font-size: 0.8em;"><a href="#" id="options_link"><?php _e('Options'); ?></a></span>
	  <img src="<?php echo admin_url('images/loading.gif'); ?>" style="margin-left: auto; margin-right: auto; display: none;" class="loading" id="form_loading" />
	  <p id="search_options">
	    Order results by
	    <select name="orderby" id="orderby" size="1">
	      <option value="relevance"><?php _e('Relevance'); ?></option>
	      <option value="published"><?php _e('Publication date'); ?></option>
	      <option value="viewCount"><?php _e('Number of views'); ?></option>
	      <option value="rating"><?php _e('Rating'); ?></option>
	    </select>
	  </p>
	</form>


	<ul class="search-results" id="search_results">
	
	</ul>
	<p style="text-align: center; width: 650px; float: left; clear: both; margin-bottom: 0;">
	  <span id="prev_page_wrapper" style="display: none;"><img src="<?php echo admin_url('images/loading.gif'); ?>" style="margin-left: auto; margin-right: auto; display: none;" class="loading" id="prev_loading" /><a href="#" id="prev_page" class="paging"> &laquo;<?php _e('Previous page'); ?></a> |</span>
	  <span id="next_page_wrapper" style="display: none;"><a href="#" id="next_page" class="paging"><?php _e('Next  page'); ?>&raquo;</a><img src="<?php echo admin_url('images/loading.gif'); ?>" style="margin-left: auto; margin-right: auto; display: none;" class="loading" id="next_loading" /></span>
	</p>
	</div>
	
	<div id="large_image_container" style="display: none;">
	  <img id="large_image"   />
	  <p>
	    <a href="#" class="back-search">&laquo; <?php _e('Back to search'); ?></a> |
	    <a href="#" id="insert_from_image" class="insert"><?php _e('Insert'); ?></a>
	  </p>
	</div>	
	
	<div id="video_screen_container" style="display: none; padding: 15px;">
	  <div id="video_container"></div>
	  <p>
	    <a href="#" class="back-search">&laquo; <?php _e('Back to search'); ?></a> |
	    <a href="#" id="insert_from_video" class="insert"><?php _e('Insert'); ?></a>
	  </p>
	</div>
	
    
	
	<script type="text/javascript">
	    //<![CDATA[
	    var insertUrl = "<?php echo  admin_url("media-upload.php?post_id=$post_id&type=image&tab=type_url&fill_fields=true"); ?>";
	    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	    var currentPage = 1;
	    var lastQuery = "";
	    var lastOrderby = "";
	    var xhr = null;
	    var videoWidth = <?php echo get_option('ms_video_width'); ?>;
	    var videoHeight = <?php echo get_option('ms_video_height'); ?>;
	    //]]>
	</script>