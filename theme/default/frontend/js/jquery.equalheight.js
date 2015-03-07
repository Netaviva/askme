(function($){
	// add a new method to JQuery

	$.fn.equalHeight = function() {
		// find the tallest height in the collection
		// that was passed in (.column)
		tallest = 0;
		this.each(function(){
			thisHeight = $(this).height();
			if( thisHeight > tallest)
				tallest = thisHeight;
		});

		// set each items height to use the tallest value found
		this.each(function(){
			$(this).css({'min-height': tallest});
		});
	}
})(jQuery);