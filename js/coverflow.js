/** The main javascript file
 *  @package    Scripts
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */

var offset           		= 6;
var preloadOffset    		= 5;
var fanartIntervalId 		= 0;
var currentPosition  		= 0;
var autoSuggestScrollLimit 	= 100;
var imageflow;

$(document).ready(function(){
    $("a#fancyboxtrigger").fancybox({type: "iframe", minHeight: 500});

    $("div#imageflow_wrapper").css("margin-top", ($("body").height() - 450) + "px");
    $(window).resize(function(){
        $("div#imageflow_wrapper").css("margin-top", ($("body").height() - 450) + "px");
    });

    imageflow = new ImageFlow();
    imageflow.init({
        reflections:    false,
        opacity:        true,
        opacityArray:   [10,9,8,6,4],
        xStep:          100,
        imageFocusM:    1.05,
        onClick:        function() {
            $("a#fancyboxtrigger").attr("href", this.getAttribute("longdesc"));
            $("a#fancyboxtrigger").attr("title", this.getAttribute("title"));
            $("a#fancyboxtrigger").trigger("click");
        }
    });

    fanartIntervalId = window.setTimeout(function(){changeFanart(0); }, 5000);

    imageflow.glideOnEvent = function(imageID){
        currentPosition++;
        //Fanart
        $("img#fanart").fadeOut("slow", function(){
            window.clearTimeout(fanartIntervalId);
            fanartIntervalId = window.setTimeout(function(){changeFanart(imageID); }, 500);
        })

        imageflow.glideTo(imageID);
        lazyLoadImages(imageID);
    }

    $("a#toggleCompleteOutline").click(function(){
        $(this).html($(this).html() == "Show" ? "Hide" : "Show");
        $("p.hidden").slideToggle("slow");
        return false;
    });

    $("div#search input").autocomplete({serviceUrl: WWWBASE + "video/autocomplete", width: "auto", onSelect: autoCompleteSuggestionSelected});
});

function autoCompleteSuggestionSelected(){
    index = $("div#imageflow span[title='" + $(this).val() + "']");
    offset = 10;

    if(index.length == 0){
        index = $("div#imageflow img[title='" + $(this).val() + "']");
        offset = 0;
    }

    if(index.index() - currentPosition > autoSuggestScrollLimit){
        //Do post!
        $("div#search form").submit();
    }
    else {
        indexToScrollTo = index.index() + offset;
        scrollToIndexInterval = window.setInterval(scrollToIndex, 10);
    }
}

var scrollToIndexInterval = -1;
var indexToScrollTo = -1;

function scrollToIndex(){
    if(currentPosition < indexToScrollTo){
        ++currentPosition;

        var width = $("div#imageflow_images img:visible:last").width();
        var height = $("div#imageflow_images img:visible:last").height();
        var top = $("div#imageflow_images img:visible:last").css("top");
        var zIndex = $("div#imageflow_images img:visible:last").css("zIndex");

        var longdesc = $("span#span_" + (currentPosition + offset)).attr("longdesc");
        var src = $("span#span_" + (currentPosition + offset)).attr("src");
        var rel = $("span#span_" + (currentPosition + offset)).attr("rel");
        var alt = $("span#span_" + (currentPosition + offset)).attr("alt");
        var title = $("span#span_" + (currentPosition + offset)).attr("title");

        $("div#imageflow_images").append("<img style='visibility:hidden;display:none;width:" + width + "px;height:" + height + "px;top:" + top +
            ";z-index:" + zIndex + "' src='" + src + "' alt=\"" + alt + "\" longdesc='" + longdesc + "' rel='" + rel + "' title=\"" + title + "\" />");

        imageflow.refresh();
        imageflow.glideTo(currentPosition);
    }
    else if(currentPosition > indexToScrollTo){
        --currentPosition;
        imageflow.glideTo(currentPosition);
    }
    else{
        window.clearInterval(scrollToIndexInterval);
    }
}

//Creating more images on the fly
function lazyLoadImages(imageID){
    if($("div#imageflow_images img:last").css("opacity") == "0.4"){
        var width = $("div#imageflow_images img:visible:last").width();
        var height = $("div#imageflow_images img:visible:last").height();
        var top = $("div#imageflow_images img:visible:last").css("top");
        var zIndex = $("div#imageflow_images img:visible:last").css("zIndex");
        var longdesc = $("span#span_" + (imageID + offset)).attr("longdesc");
        var src = $("span#span_" + (imageID + offset)).attr("src");
        var rel = $("span#span_" + (imageID + offset)).attr("rel");
        var alt = $("span#span_" + (imageID + offset)).attr("alt");
        var title = $("span#span_" + (imageID + offset)).attr("title");

        $("div#imageflow_images").append("<img style='visibility:hidden;display:none;width:" + width + "px;height:" + height + "px;top:" + top +
            ";z-index:" + zIndex + "' src='" + src + "' alt=\"" + alt + "\" longdesc='" + longdesc + "' rel='" + rel + "' title=\"" + title + "\" />");
        imageflow.refresh();

        //Preload some more posters
        var preload = Array();
        for(i = 1; i <= preloadOffset; i++){
            preload[i] = $("span#span_" + (imageID + offset + i)).attr("src");
        }
        preloadImages(preload);
    }
}

function changeFanart(imageID){
    preloadImages(Array($("div#imageflow_images img").eq(imageID).attr("rel")), function(){
        $("img#fanart").attr("src", $("div#imageflow_images img").eq(imageID).attr("rel"));
        $("img#fanart").fadeIn("slow");
    });
}

function preloadImages(picture_urls, callback){
    var loaded  = 0;

    for(var i = 0, j = picture_urls.length; i < j; i++){
        var img = new Image();

        img.onload  = function(){
            if(++loaded == picture_urls.length && callback){
                callback();
            }
        }

        img.src = picture_urls[i];
    }
}
