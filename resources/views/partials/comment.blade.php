<li id="comment-{{ $comment->id }}">
	<img src="{{ $comment->user->avatar['tiny'] }}" alt="{{ $comment->user->name }}">

	<header>
		<a href="{{url('user', $comment->user->name)}}" >
			<strong>{{ $comment->user->name }}</strong>
		</a>
		<small>{{ $comment->created_at }}</small>
	</header>

	<p>
		{{ $comment->text }}
	</p>
</li>
