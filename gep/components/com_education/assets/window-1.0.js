// JavaScript Document

// Must re-initialize window position
function cWindowShow(windowCall, winTitle, winWidth, winHeight, winType) {

	//alert('at windown');
	// if no window type defined, then we use dialog as default
	var _type = ( winType == '' || winType == null ) ? 'dialog' : winType;

	var Obj = document.getElementById('cWindow');
	if(!Obj){
		Obj    = document.createElement('div');

		var html  = '';
		html += '<div id="cWindow" class="' + _type + '" style="top: 0px; display: none;">';
		html += '	<!-- top section -->';
    	html += '	<div id="cwin_tl"></div>';
    	html += '	<div id="cwin_tm"></div>';
    	html += '	<div id="cwin_tr"></div>';
    	html += '	<div style="clear: both;"></div>';
    	html += '	<!-- middle section -->';
    	html += '	<div id="cwin_ml"></div>';
    	html += '	<div id="cWindowContentOuter">';
    	html += '		<div id="cWindowContentTop">';
		html += '			<a href="javascript:void(0);" onclick="cWindowHide();" id="cwin_close_btn">Close</a>';
		html += '			<div id="cwin_logo">'+winTitle+'</div>';
    	html += '		</div>';
    	html += '		<div id="cWindowContent">';
    	html += '		</div>';
    	html += '	</div>';
    	html += '	<div id="cwin_mr"></div>';
    	html += '	<div style="clear: both;"></div>';
    	html += '	<!-- bottom section -->';
    	html += '	<div id="cwin_bl"></div>';
    	html += '	<div id="cwin_bm"></div>';
    	html += '	<div id="cwin_br"></div>';
    	html += '	<div style="clear: both;"></div>';
		html += '</div>';

		//alert(html);

		Obj.innerHTML = html;
		document.body.appendChild(Obj);
	} else {
		jQuery('#cwin_logo').html(winTitle);
	}

	// Set cWindowWidth + 40
	jQuery('#cWindow').width(winWidth + 40);
	jQuery('#cWindowContentOuter, #cWindowContentTop, #cWindowContent').width(winWidth);
	jQuery('#cwin_bm, #cwin_tm').width(winWidth);

	//console.log(winWidth);


	var myWidth = 0, myHeight = 0;
	myWidth  = jQuery(window).width();
	myHeight = jQuery(window).height();

	var yPos;

	if( jQuery.browser.opera && jQuery.browser.version > "9.5" && jQuery.fn.jquery <= "1.2.6" )
	{
		yPos	= document.documentElement['clientHeight'] - 30;
	}
	else
	{
		yPos	= jQuery(window).height() - 30;
	}

	var leftPos = (myWidth - winWidth)/2;

	jQuery('#cWindow').css('zindex', cGetZIndexMax() + 1);
    jQuery('#cWindowContent').html('<div class="ajax-wait">&nbsp;</div>');

    jaxcontestant.loadingFunction = function(){
		jQuery('#cWindowContent').addClass('winloading');
	}

	jaxcontestant.doneLoadingFunction = function(){
		jQuery('#cWindowContent').removeClass('winloading');
	};
	//alert(windowCall);
    eval(windowCall);

	// Set editor position, center it in screen regardless of the scroll position
	jQuery("#cWindow").css('marginTop', (jQuery(document).scrollTop() + 10 +(yPos - winHeight)/2) + (20)+'px');


	// Set height and width for transparent window
	jQuery('#cWindow').css('height', winHeight)
	                  .css('left', leftPos);
	jQuery('#cWindowContent').css('height', (winHeight - 50)) // - 30px title and 20px border
	                         .css('width', (winWidth - 20));  // -20px border
	jQuery('#cWindowContentOuter').css('height', winHeight);
	jQuery('#cwin_tm, #cwin_bm').css('width', winWidth);
	jQuery('#cwin_ml, #cwin_mr').css('height', winHeight);
	if (jQuery.browser.msie6 = jQuery.browser.msie &&
    parseInt(jQuery.browser.version) == 6 &&
    !window["XMLHttpRequest"])
 {

  alert(jQuery.browser.version.substr(0,1));
  jQuery('#cwin_tm, #cwin_bm, #cwin_ml, #cwin_mr').each(function()
  {
   jQuery(this)[0].filters(0).sizingMethod="crop";
  })
 }

	jQuery('#cWindow').fadeIn();
}

function cWindowHide(){
	if(jQuery('#cWindowAction').get().length > 0)
		jQuery('#cWindowAction').animate({ bottom: "-40px"}, 200 , '', function(){
			jQuery('#cWindow').fadeOut('fast', function(){ jQuery(this).remove();});
		});
	else
		jQuery('#cWindow').fadeOut('fast', function(){ jQuery(this).remove();});
}

function cWindowActions(action){
	var html = '<div id="cWindowAction">';
	html += '<table><tr>';
	html += '<td align="left"><div id="cwin-wait">&nbsp;</div></td><td  align="right" valign="middle">';
	html += action;
	html += '</td></tr></table></div>';

	jaxcontestant.loadingFunction = function(){
		jQuery('#cwin-wait').show();
		jQuery('#cWindowContent input').attr('disabled', true);
		jQuery('#cWindowContent textarea').attr('disabled', true);
		jQuery('#cWindowContent button').attr('disabled', true);
	}

	jaxcontestant.doneLoadingFunction = function(){
		jQuery('#cwin-wait').hide();
		jQuery('#cWindowContent input').attr('disabled', false);
		jQuery('#cWindowContent textarea').attr('disabled', false);
		jQuery('#cWindowContent button').attr('disabled', false);
	};

	jQuery('#cWindowAction').remove();
	jQuery('#cWindowContentOuter').append(html);
	_height = jQuery('#cWindowContent').height();
	_height = _height - 34;
	jQuery('#cWindowContent').height( _height );

	jQuery('#addFriendContainer').css({
		paddingLeft: '5px',
		paddingRight: '0'
	});

	jQuery('#cWindowAction').animate({
        bottom: "0px"
      }, 200 );
}

function cWindowResize(newHeight){
	currentHeight = jQuery('#cwin_mr').height();
	reduceHeight = (currentHeight - newHeight) /2;

	// Lower top window
	jQuery('#cWindow').animate({
        marginTop: "+="+ reduceHeight +"px"
      }, 200 );
// 	jQuery('#cwin_tl,#cwin_tm,#cwin_tr').animate({
//         marginTop: "+="+ reduceHeight +"px"
//       }, 200 );

    // Reduce height
	jQuery('#cwin_mr,#cwin_ml,#cWindowContentOuter').animate({
        height: newHeight +"px"
      }, 200 );

    jQuery('#cWindowContent').animate({
        height: newHeight - 50 +"px"
      }, 200 );
}


function cGetZIndexMax(){
	var allElems = document.getElementsByTagName?
	document.getElementsByTagName("*"):
	document.all; // or test for that too
	var maxZIndex = 0;

	for(var i=0;i<allElems.length;i++) {
		var elem = allElems[i];
		var cStyle = null;
		if (elem.currentStyle) {cStyle = elem.currentStyle;}
		else if (document.defaultView && document.defaultView.getComputedStyle) {
			cStyle = document.defaultView.getComputedStyle(elem,"");
		}

		var sNum;
		if (cStyle) {
			sNum = Number(cStyle.zIndex);
		} else {
			sNum = Number(elem.style.zIndex);
		}
		if (!isNaN(sNum)) {
			maxZIndex = Math.max(maxZIndex,sNum);
		}
	}
	return maxZIndex;
}

