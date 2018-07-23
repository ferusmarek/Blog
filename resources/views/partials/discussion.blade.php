
<div id="discussion">

	{{-- List of comments --}}
	@if($post->comments)
		<ol class="comments">
			@foreach($post->comments as $comment)
				@include('partials.comment')
			@endforeach
		</ol>
	@endif


	{!! Form::open(['route' => 'comment.store', 'method' => 'post', 'class' => 'post']) !!}

	{{-- Text Field --}}
	<div class="form-group">
		{!! Form::textarea('text', null, [
			'class' => 'form-control',
			'placeholder' => "comment",
			'rows' => 3,
		]) !!}
	</div>

	{{-- Add comment Button --}}
	<div class="form-group">
		{!! Form::hidden('post_id', $post->id) !!}
		{!! Form::button('Add comment', [
			'type' => 'submit',
			'class' => 'btn btn-primary'
		]) !!}
	</div>

	{!! Form::close() !!}

</div>
