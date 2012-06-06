require.config({
	urlArgs: "bust=" +  (new Date()).getTime()
});
require(['jquery', 'wiki/ui/font_resize'], function($){

	$("#flashMessage").slideDown('normal');
	setTimeout(function(){
		$("#flashMessage").slideUp('normal');
	}, 3000);

});