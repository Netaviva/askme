var $Profiler = {};

$Profiler.init = function(){
	var win = $('#profiler-wrapper');
	var detail = win.find('#profiler-content');
	var minimize = $('#profiler-minimize');
	
	minimize.live('click', function(){
		var isOpen = detail.is(':visible');		
		if(isOpen){
			$(this).html('show').attr('title', 'Show Profiler Details');
			detail.slideUp();
		}
		else{
			$(this).html('hide').attr('title', 'Hide Profiler Details');
			detail.slideDown();
		}
	});
	
	$Profiler.tabilize($('#profiler-content'));
	$Profiler.tabilize($('.profiler-tabs'));
}

$Profiler.tabilize = function(wrapper){
	wrapper.each(function(){
		var panels = $(this).find('> div');
		var tabs = $(this).find('> ul a');
		
		tabs.click(function(e) {
			tabs.removeClass('profiler-tab-selected');
			$(this).addClass('profiler-tab-selected');
			panels.hide().filter(this.hash).show();
			return false;
		}).filter(':first').click();
	});
}

$App.profiler = function(){
	$Profiler.init();	
}