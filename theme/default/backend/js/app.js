;
(function($, window, undefined) {
	'use strict';

	var $doc = $(document),
		Modernizr = window.Modernizr;

	$(document).ready(function() {

		$('select:not(.no-customize)').each(function(){
			$(this).addClass('chosen-select');
		});

		$('.chosen-select').chosen();
		$('.chzn-drop').css('z-index', '999999');

		$.fn.foundationAlerts ? $doc.foundationAlerts() : null;
		$.fn.foundationButtons ? $doc.foundationButtons() : null;
		$.fn.foundationAccordion ? $doc.foundationAccordion() : null;
		$.fn.foundationNavigation ? $doc.foundationNavigation() : null;
		$.fn.foundationTopBar ? $doc.foundationTopBar() : null;
		$.fn.foundationCustomForms ? $doc.foundationCustomForms() : null;
		$.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
		$.fn.foundationTabs ? $doc.foundationTabs({callback:$.foundation.customForms.appendCustomMarkup}) : null;
		$.fn.foundationTooltips ? $doc.foundationTooltips() : null;
		$.fn.foundationMagellan ? $doc.foundationMagellan() : null;
		$.fn.foundationClearing ? $doc.foundationClearing() : null;

		$.fn.placeholder ? $('input, textarea').placeholder() : null;

		function resize_sidebar(){
			$('#sidebar').height($(this).height() - $('#header').height());
		};

		$("body").css("min-height", $(window).height());

		$('#sidebar, #rightbar').height($(this).height() - $('#header').height());

		$(window).on('resize', function(){
			$("body").css("min-height", $(window).height());
			$('#sidebar, #rightbar').height($(document).height() - $('#header').height());
		});

		$(window).on('scroll', function(){
			window.setTimeout(function(){
				//$('#sidebar, #rightbar').height($(document).height() - $('#header').height());
			}, 100);
		});

		$('#sidebar li.drop-menu > a').on('click', function(){
			var $this = $(this);
			var $parent = $this.parent('li');
			$parent.addClass('visible');
			if($this.siblings('ul').is(':visible')){
				$this.siblings('ul').slideUp();
			}
			else{
				$this.siblings('ul').slideDown();
			}
			return false;
		});
	});

	// Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
	if(Modernizr.touch && !window.location.hash) {
		$(window).load(function() {
			setTimeout(function() {
				window.scrollTo(0, 1);
			}, 0);
		});
	}

})(jQuery, this);
