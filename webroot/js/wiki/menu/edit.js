define(['jquery', 'jquery/jqueryui'], function($){

	$("#WikiMenuType").change(function(e){
		var type = this.value;
		$("#divPageAlias").toggle(type === 'page');
		$("#divLinkUrl").toggle(type === 'link');
		$("#divParentId").toggle(type !== 'nav');
	}).change();

	$("#WikiMenuPageAlias").autocomplete({
		source: $("#WikiMenuPageAlias").data('source')
	});

	$("#WikiMenuPageAlias").next('a').click(function(e){
		e.preventDefault();
		$("#WikiMenuPageAlias").prop('readonly', false).select().focus();
	})
	$("#WikiMenuPageAlias").blur(function(){
		$(this).prop('readonly', true);
	});

});