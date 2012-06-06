define(['jquery'], function($){
	$("[data-confirm]").click(function(e){
		$("#WikiMenuDeleteDialog [data-action='delete']").attr('href', $(this).data('url'));
		$("#WikiMenuDeleteDialog").modal();
	});
});