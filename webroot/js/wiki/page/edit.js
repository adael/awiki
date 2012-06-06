define(['jquery'], function($){

	// http://alexking.org/blog/2003/06/02/inserting-at-the-cursor-using-javascript#comment-3817
	function insertAtCursor(myField, myValue) {
		// IE support
		if (document.selection) {
			var temp;
			myField.focus();
			sel = document.selection.createRange();
			temp = sel.text.length;
			sel.text = myValue;
			if (myValue.length == 0) {
				sel.moveStart('character', myValue.length);
				sel.moveEnd('character', myValue.length);
			} else {
				sel.moveStart('character', -myValue.length + temp);
			}
			sel.select();
		} else if (myField.selectionStart || myField.selectionStart == '0') {
			//MOZILLA/NETSCAPE support
			var startPos = myField.selectionStart;
			var endPos = myField.selectionEnd;
			myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
			myField.selectionStart = startPos + myValue.length;
			myField.selectionEnd = startPos + myValue.length;
		} else {
			myField.value += myValue;
		}
	}

	mySettings.root = '';
	mySettings.previewParserPath = $("#txtContentEdit").data('preview-url');

	var $txt = $('#txtContentEdit');
	$txt.markItUp(mySettings).focus();
	$txt.keydown(function(e) {
		if (e.which == 9){
			e.preventDefault();
			insertAtCursor(this, "    ");
		}
	});

});