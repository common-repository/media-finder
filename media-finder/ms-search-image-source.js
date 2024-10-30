
(function($) {
        var xhr = null;
	    var currentPage = 1;

	    function getPhotoUrl(photo, size) {
            
	        size = size || "small";
	        var farmId = photo.getAttribute("farm");
	        var serverId = photo.getAttribute("server");
	        var id = photo.getAttribute("id");
	        var secret = photo.getAttribute("secret");
	        var sizeCode = "s";
	        if ("medium" == size) {
	        	sizeCode = "m";
	        }
	        return "http://farm" + farmId + ".static.flickr.com/" + serverId +"/" + id + "_" + secret + "_" + sizeCode + ".jpg";

	    };
	    
	    function getInsertUrl(photo) {
	        var title = photo.getAttribute("title");
	        var url = getPhotoUrl(photo, "medium");
	        var photostream = "http://www.flickr.com/photos/" + photo.getAttribute("owner");
	        return insertUrl + "&title=" + encodeURIComponent(title) + "&url=" + encodeURIComponent(url) + "&photostream_url=" + photostream;
	    };
	    
	    
        function largeViewer(e) {
            e.preventDefault();
            var $this = $(this);
            var src = $this.attr("href");
            $("#large_image").attr("src", src);
            $("#insert").attr("href", $this.parent().find(".insert").attr("href"));
            $("#search_wrapper").hide();
            $("#large_image_container").show();
        };	    
	    
	    function search() {
                if (xhr)
                    xhr.abort();
         
                var formData = {};
                formData.q = $("#q").val();
                formData.license = $("#license").val();
                formData.orderby = $("#orderby").val();
                formData.page = currentPage;
                formData.action = "search_image";
				formData.searchby = $("#searchby").val();
                xhr = $.post(ajaxurl, formData, function(data) {
                    var photos = data.getElementsByTagName("photo");

                    var html = "";
                    for (var i = 0, len = photos.length; i < len; ++i) {
                    	var url = getPhotoUrl(photos[i], "small");
                    	var title = photos[i].getAttribute("title");

                    	html += '<li class="search-result"><img class="search-result-img" src="' + url + '" alt="' + title + '" title="' + title + '" style="width: 75px; height: 75px;"><div style="text-align: center; margin-top: 0;"><a href="' + getPhotoUrl(photos[i], "medium") + '" class="view" >View</a> | <a href="' + getInsertUrl(photos[i]) + '" class="insert">Insert</a></div></li>';
                    }

                    $("#search_results").html(html);
                    $(".view").bind("click", largeViewer);
                    $(".loading").hide();
                    paging();

                }, "xml");
	    };    

	    function paging() {
	    	if (currentPage > 1) {
	    		$("#prev_page_wrapper").show();
	    	}
	    	else {
	    		$("#prev_page_wrapper").hide();
	    	}
	    	
	    	$("#next_page_wrapper").show();
	    }
	    
	    $(function() {

            $("#q").bind("keypress", function(e) {
                if (13 == e.keyCode) {
                	e.preventDefault();
                	$("#img_search").trigger("click");
                }
            });
            
            $("#options_link").bind("click", function(e) {
                e.preventDefault();
                $("#search_options").toggle();

            });
            
            $("#search_options").hide();
            
            
	    	
            $("#img_search").bind("click", function(e) {
                e.preventDefault();
                currentPage = 1;
                $("#form_loading").show();
                search();
            });
            
            
            $("#prev_page").bind("click", function() {
                --currentPage;
                $("#prev_loading").show();
                search();
            });
            
            $("#next_page").bind("click", function() {
                ++currentPage;
                $("#next_loading").show();
                search();
            });    
            
                
            $("#q").focus();
           
            $("#back_search").bind("click", function(e) {
                e.preventDefault();
                $("#search_wrapper").show();
                $("#large_image_container").hide();
                $("#large_image").attr("src", "");
            });
            
        
	    });
})(jQuery);	 

