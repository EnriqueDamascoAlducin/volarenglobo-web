/* Web Elements by TrueThemes */


(function($) {

/* ------------------------------------------------------------------------
Fire up Functions on Page Load
* ------------------------------------------------------------------------- */
jQuery(document).ready(function () {
	scrollTop();
	buttonHover();
	doTabsType1();
	doTabsType2();
	doAccordion();
	
});




/* ------------------------------------------------------------------------
Scroll to Top
* ------------------------------------------------------------------------- */
function scrollTop(){
	jQuery('a.scrollToTop').click(function(){ 
	jQuery('html, body').animate({scrollTop:0}, 'slow');
	return false; 
	});
}





/* ------------------------------------------------------------------------
Button Hover
* ------------------------------------------------------------------------- */
function buttonHover(){

jQuery(".button_style_1").hover(function () {
	jQuery(this).stop().animate({
		opacity: 0.7
	}, 250)
}, function () {
	jQuery(this).stop().animate({
		opacity: 1.0
	}, 250)
})

}





/* ------------------------------------------------------------------------
Tabs - Type 1
* ------------------------------------------------------------------------- */
function doTabsType1(){
	var tabs = jQuery('.tabs_type_1');
	if(tabs.length < 1){
		return;
	}
	
	tabs.append("<span class='tabs_type_1_arrow'></span>");
	tabs.each(function(){
		var self = jQuery(this);
		var handlers = self.children('dt');
		var tabContentBlocks = self.children('dd');
		var currentTab = tabContentBlocks.eq(0);
		var arrow = self.children('span').eq(0);
		var handlersWidth = handlers.eq(0).outerWidth();
		var firstHandlerY = handlers.eq(0).position().top + handlers.eq(0).outerHeight() - 17;
		arrow.css({'left': handlersWidth-17 + 'px', 'top': firstHandlerY + 'px'});
		handlers.click(function(){
			var self = jQuery(this);
			currentTab.prev().removeClass('current');
			currentTab.fadeOut('fast');
			currentTab = self.next();
			var minus = self.index() == 0 ? 17 : self.outerHeight()/2 + 17;
			arrowY = self.position().top + self.outerHeight() - minus;
			arrow.animate({'top':arrowY + 'px'});
			currentTab.fadeIn('slow');
			self.addClass('current');
		});
	});
}





/* ------------------------------------------------------------------------
Tabs - Type 2
* ------------------------------------------------------------------------- */
function doTabsType2(){
	var tabs = jQuery('.tabs_type_2');
	if(tabs.length <  1){
		return;
	}
	tabs.append("<span class='tabs_type_2_arrow'></span>");
	tabs.each(function(){
		var self = jQuery(this);
		var handlers = self.children('dt');
		var tabContentBlocks = self.children('dd');
		var currentTab = tabContentBlocks.eq(0);
		var arrow = self.children('span').eq(0);
		var handlersWidth = handlers.eq(0).outerWidth();
		var firstHandlerY = handlers.eq(0).position().top + handlers.eq(0).outerHeight() - 18;
		arrow.css({'left': handlersWidth/2 - 7 + 'px'});
		handlers.click(function(){
			var self = jQuery(this);
			currentTab.prev().removeClass('current');
			currentTab.fadeOut('fast');
			currentTab = self.next();
			//var minus = self.index() == 0 ? 18 : self.outerHeight()/2 + 18;
			arrowY = self.position().left + (self.outerWidth() /2) - 2;
			arrow.animate({'left':arrowY + 'px'});
			currentTab.fadeIn('slow');
			self.addClass('current');
		});
	});
}





/* ------------------------------------------------------------------------
Accordions
* ------------------------------------------------------------------------- */
function doAccordion(){
	var accordions = jQuery('.accordion');
	if(accordions.length < 1){
		return;
	}
	accordions.each(function(){
		var self = jQuery(this);
		var handlers = self.children('dt');
		handlers.click(function(){
			var self = jQuery(this);
			self.children('dt.current').removeClass('current').next().slideUp();
			self.toggleClass('current');
			self.next('dd').slideToggle();
		});
	});
}

}(jQuery));