require.config({
	urlArgs: "bust=" +  (new Date()).getTime()
});
require(['jquery'], function($){

	$(function(){
		$("#flashMessage").slideDown('normal');
		setTimeout(function(){
			$("#flashMessage").slideUp('normal');
		}, 3000);
	});

});