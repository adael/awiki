define(["tpl!wiki/views/dialogs/confirm.tpl"], function(tpl){

	return function(body, caption){
		var dialog = $(tpl({
			title: caption,
			body: body
		}));
		$(document).append(dialog);
		dialog.modal();
	}

});