var $Panel = {};

$Panel.controlGroup = function(){
	var $controlgroup = $('.control-group');

	if($controlgroup.length > 0){
		var $tab = $('<ul />', {class: 'control-group-tab'});

		$controlgroup.each(function(i, e){
			var title = $(this).find('h4').text(), id = 'control-group-' + Linko.util.slugify(title);
			$(this).attr('id', id);
			$tab.append('<li id="' + id + '"><a href="#' + id + '">' + title + '</a></li>');
		});

		$controlgroup.closest('.module-content, .module').prepend($tab);
		Linko.tabilize($('ul.control-group-tab li a'), $('.control-group'));
	}
}

$App.panelTheme = function(){
	$Panel.controlGroup();
};