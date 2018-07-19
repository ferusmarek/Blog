(function($) {

	/**
	 * --------------------------------------
	 * Move cursor to the end of input
	 *
	 */
	$.fn.moveCursorToEnd = function() {
		var originalValue = this.val();
		this.val('');
		this.blur().focus().val(originalValue);
	};


	/**
	 * ADD FORM, EDIT FORM
	 */
	 $('#add-form, #edit-form')
 		.find('.add-files a').on('click', function() {
 			var input = $(this).prev();
 			input.clone().insertAfter(input);
 		})
 		.end()
 		.find('input[name=title]').moveCursorToEnd();




	/**
	 * DELETE FORM
	 */
	$('#delete-form').on('submit', function() {
		return confirm('for sure?');
	});


	/**
	 * Hide alerts
	 */
	$('.alert').find('.close').on('click', function() {
		$(this).parent().fadeOut();
	});


}(jQuery));
