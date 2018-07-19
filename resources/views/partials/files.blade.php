@if ( $post->tags )

	<p class="files">
		@foreach ( $post->files as $file )
			<a href="{{ url('download', [ $file->id, $file->name ]) }}" class="btn btn-success btn-xs">
				<img src="{{asset('img/'.$file->ext.'.png')}}" alt="{{$file->ext}}" eight="22" width="22">

				{{ $file->name  }}
			</a>
		@endforeach
	</p>

@endif
