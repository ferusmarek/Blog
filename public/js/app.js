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
	 * discussion
	 */
	 var discussion = $('#discussion');
	 discussion.find('form').on('submit', function(event) {

		 var form = $(this);

		 var req = $.ajax({
			 url: form.attr('action'),
			 type: 'post',
			 data: form.serialize()
		 });

		 req.done(function(data) {

			 $.ajax({
				 url: 'comment/' + data.id,
				 type: 'get',
				 success: function(html) {
					 var li = $(html).hide();
					 discussion.find('.comments').append(li);
					 li.fadeIn();
				 }
			 });

		 });

		 form.find('textarea').val('').focus();

		 event.preventDefault();

	 });



	/**
	 * Hide alerts
	 */
	$('.alert').find('.close').on('click', function() {
		$(this).parent().fadeOut();
	});


}(jQuery));
