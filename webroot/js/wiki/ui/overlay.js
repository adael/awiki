define(['jquery'], function($){

	var $overlay = null;

	function show(element){
		if($overlay === null){
			$overlay = $("<div class='overlay'></div>");
			$overlay.appendTo('body');
		}
		element = element || document;
		var $element = $(element);
		$overlay.css({
			'position': 'absolute',
			'background': 'rgba(0, 0, 0, 0.2)',
			'z-index': 9999,
			'top': $element.position().top,
			'left': $element.position().left,
			'width': $element.outerWidth(),
			'height': $element.outerHeight()
		}).show();
	};

	function hide(){
		if($overlay){
			$overlay.hide();
		}
	}

	return {
		show: show,
		hide: hide
	};

});