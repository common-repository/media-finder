	<div id="search_wrapper">
	<form action="/" method="post" id="search_form">
	  <h3 class="media-title" style="margin-top: 3px; margin-bottom: 12px;"><?php _e('Flickr search') ?></h3>
	  <input type="text" name="q" style="width: 450px; margin-top: 0;" id="q" />
	  <input type="submit" value="<?php _e('Search'); ?>" id="img_search" class="button-secondary" />
	  <span style="font-size: 0.8em;"><a href="#" id="options_link"><?php _e('Options'); ?></a></span>
	  <img src="<?php echo admin_url('images/loading.gif'); ?>" style="margin-left: auto; margin-right: auto; display: none;" class="loading" id="form_loading" />
	  <div id="search_options">
      <p>
        <?php _e('Order results by'); ?>
        <select name="orderby" size="1" id="orderby">
            <option value="relevance"><?php _e('Relevance'); ?></option>
            <option value="date-taken-desc"><?php _e('Date'); ?></option>
            <option value="interestingness-desc"><?php _e('Interestingness'); ?></option>
        </select>
        <?php _e('Search by'); ?>
        <select name="searchby" id="searchby">
          <option value="fulltext"><?php _e('Full text'); ?></option>
          <option value="tags"><?php _e('Tags only'); ?></option>
        </select>
      </p>
      <p style="margin-top: 0;">
        <?php _e('Choose license:'); ?>
        <select name="license" size="1" id="license">
            <option value="-1"><?php _e('Any'); ?></option>
            <option value="4"><?php _e('Attribution License'); ?></option>
            <option value="6"><?php _e('Attribution-NoDerivs License'); ?></option>
            <option value="3"><?php _e('Attribution-NonCommercial-NoDerivs License'); ?></option>
            <option value="2"><?php _e('Attribution-NonCommercial License'); ?></option>
            <option value="1"><?php _e('Attribution-NonCommercial-ShareAlike License'); ?></option>
            <option value="5"><?php _e('Attribution-ShareAlike License'); ?></option>
        </select>    
      </p>
      </div>
      
	</form>


	<ul class="search-results" id="search_results">
	
	</ul>
	<p style="text-align: center; width: 650px; float: left; clear: both; margin-bottom: 0; margin-top: 3px;">
	  <span id="prev_page_wrapper" style="display: none;"><img src="<?php echo admin_url('images/loading.gif'); ?>" style="margin-left: auto; margin-right: auto; display: none;" class="loading" id="prev_loading" /><a href="#" id="prev_page"> &laquo;<?php _e('Previous page'); ?></a> |</span>
	  <span id="next_page_wrapper" style="display: none;"><a href="#" id="next_page"><?php _e('Next  page'); ?>&raquo;</a><img src="<?php echo admin_url('images/loading.gif'); ?>" style="margin-left: auto; margin-right: auto; display: none;" class="loading" id="next_loading" /></span>
	</p>
	</div>
	
	<div id="large_image_container" style="display: none;">
	  <img id="large_image"   />
	  <p>
	    <a href="#" id="back_search">&laquo; <?php _e('Back to search'); ?></a> |
	    <a href="#" id="insert"><?php _e('Insert'); ?></a>
	  </p>
	</div>
	
	<script type="text/javascript">
	    //<![CDATA[
	    var insertUrl = "<?php echo  admin_url("media-upload.php?post_id=$post_id&type=image&tab=type_url&fill_fields=true"); ?>";
	    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	    //]]>
	</script>