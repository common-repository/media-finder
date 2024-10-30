(function($) {
$(function() {

	    var qstr = window.location.href.split('?')[1];

	    var vars = qstr.split('&');
	    var title = '';
	    var url = '';
	    var photostream = '';
	    for (var i = 0, len = vars.length; i < len; ++i) {
	    	var parts = vars[i].split("=");
	    	if ("title" == parts[0]) {
	    		title = decodeURIComponent(parts[1]);
	    	}
	    	
	    	if ("url" == parts[0]) {
	    		url = decodeURIComponent(parts[1]);
	    	}
	    	
	    	if ("photostream_url" == parts[0]) {
	    	    photostream = decodeURIComponent(parts[1]);	
	    	}
	    }
	    

	    
	    $("#src").val(url);
	    $("#title").val(title);
	    $("#url").val(photostream);
	    addExtImage.getImageData();
	});

})(jQuery);