define(['jquery'], function($){
	$(function(){
		$("[data-editor]").each(function(){

			var _self = this;
			var form;
			var editor = $(this).data('editor');

			if(editor === 'next-form'){
				form = $(this).next('form');
			}else{
				form = $(editor);
			}

			function showForm(){
				$(this).hide();
				form.show().find(':text:first').select().focus();
			}

			function hideForm(){
				form.hide();
				$(_self).show();
			}

			form.submit(function(e){
				e.preventDefault();
				require(['ui/overlay'], function(overlay){
					console.log(overlay);
					overlay.show(form);
					var submit = $.ajax({
						url: form.attr('action'),
						type: 'POST',
						dataType: 'json',
						data: form.serialize()
					});
					submit.done(function(data){
						require(['ui/flash'], function(flash){
							if(data.success){
								flash.message(data.message, 'success');
								hideForm();
							}else{
								flash.message(data.message, 'error');
							}
						});
					});
					submit.fail(function(){

						});
					submit.always(overlay.hide);
				});
			});

			form.find('[data-action="cancel"]').click(hideForm);

			$(this).dblclick(showForm());

		});
	});
});