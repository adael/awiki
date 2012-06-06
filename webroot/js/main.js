require.config({
	urlArgs: "bust=" +  (new Date()).getTime(),
	paths: {
		tpl: 'tpl'
	}
});
require(['jquery', 'wiki/ui/confirm', 'wiki/ui/font_resize'], function($, Confirm){

	$("#flashMessage").slideDown('normal');
	setTimeout(function(){
		$("#flashMessage").slideUp('normal');
	}, 3000);

	// Confirm replacement
	$("[data-confirm]").click(function(e){
		return Confirm($(this).data('confirm'), $(this).data('confirm-caption'));
	});

});