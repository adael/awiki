define(['jquery', 'jquery/plugins/cookie'], function($){

	$(function(){

		var $content = $(".content-body");
		var size = parseFloat($.cookie('font-size'));

		function changeFont(_size){
			size = _size;

			if(!size){
				size = 100;
			}

			if(size < 50 || size > 300){
				return;
			}

			$content.find('*').each(function(){
				var $this = $(this);
				var f = $this.data('font-size');
				if(!f){
					f = parseInt($this.css('font-size'));
					$this.data('font-size', f);
				}
				f = Math.round(f * size / 100);
				$(this).css('font-size', f);
			});

			$.cookie('font-size', size, {
				expires: 1,
				path: '/'
			});
		}

		$("#font-bigger").click(function(e){
			e.preventDefault();
			changeFont(size + 10);
		});

		$("#font-smaller").click(function(e){
			e.preventDefault();
			changeFont(size - 10);
		});

		$("#font-normal").click(function(e){
			e.preventDefault();
			changeFont(100);
		});

		changeFont(size);

	});
});