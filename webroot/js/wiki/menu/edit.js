define(['jquery', 'jquery/jqueryui'], function($){
	$("#WikiMenuType").change(function(e){
		$("#divPageAlias,#divLinkUrl").hide();
		switch($(this).val()){
			case 'page':
				$("#divPageAlias").show();
				break;
			case 'link':
				$("#divLinkUrl").show();
				break;
		}
	}).change();

	$("#WikiMenuPageAlias").autocomplete({
		source: $("#WikiMenuPageAlias").data('source')
	});

});