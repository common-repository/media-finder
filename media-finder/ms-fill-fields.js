(function($){$(function(){var a=window.location.href.split('?')[1];var b=a.split('&');var c='';var d='';var e='';for(var i=0,len=b.length;i<len;++i){var f=b[i].split("=");if("title"==f[0]){c=decodeURIComponent(f[1])}if("url"==f[0]){d=decodeURIComponent(f[1])}if("photostream_url"==f[0]){e=decodeURIComponent(f[1])}}$("#src").val(d);$("#title").val(c);$("#url").val(e);addExtImage.getImageData()})})(jQuery);