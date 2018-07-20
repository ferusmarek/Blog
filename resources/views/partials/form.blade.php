<header class="post-header">
    <h1 class="box-heading">{{$title}}</h1>
    @if(isset($post))
        @if($post->cover != 'NULL')
            <div class="coverimg" style="background-image:url({{asset('coverimg/posts/'.$post->id.'/'.$post->cover)}})">
        @endif
    @endif
</header>
    {{-- Add New Cover Field --}}
    <div class="form-group add-files">
    <h4 id='covertop' class="box-heading">
        @if(isset($post))
            @if($post->cover != 'NULL')
                <label for="cover"><a id="addcover" class="btn btn-deafult btn-xs">change cover</a></label>
                <small>/</small><a href="{!! action('FileController@removeCover',['id' => $post->id, $post->cover]) !!}"><small class="text-muted">remove Cover</small></a>
            @else
                <label for="cover"><a id="addcover" class="btn btn-deafult btn-xs">add cover</a></label>
            @endif
        @else
            <label for="cover"><a id="addcover" class="btn btn-deafult btn-xs">add cover</a></label>
        @endif

        {!! Form::file('cover', [ 'multiple' => 'multiple', 'class' => 'form-control', 'id' => 'coverImg']) !!}
        <a href="#" id="resetCover" class="delete-link glyphicon glyphicon-remove"></a>
    </h4>
    </div>

{{-- Title Field --}}
<div class="form-group">
    {!! Form::text('title', null, [
        'class' => 'form-control',
        'placeholder' => 'title your shit'
    ]) !!}
</div>

{{-- Text Field --}}
<div class="form-group">
    {!! Form::textarea('text', null, [
        'class' => 'form-control',
        'placeholder' => 'write your thing',
        'rows'  => 16
    ]) !!}
</div>

{{-- Files Field --}}
@if(isset($post) && $post->files)
	<ul class="list-group">
		@foreach( $post->files as $file )
		    <li class="list-group-item">
			    <span class="current-attachment"> {{$file->name}}</span>
			    {{Form::input('text','edit-file-name', $file->name, [ 'id' => $file->id, 'class' => 'attachment-replace', 'style' => 'display:none;'])}}
			    {{Form::input('hidden','file-id', $file->id)}}
			    <div class="controls pull-right">
					<a href="#" class="edit-link current-attachment">edit</a>
				    <a href="#" class="edit-cancel-link" style="display:none;">cancel</a>
				    <a href="{!! action('FileController@removeFile',['id' => $post->id, 'name' => $file->filename, 'fileid' => $file->id ]) !!}" class="delete-link glyphicon glyphicon-remove"></a>
			    </div>
		    </li>
		@endforeach
	</ul>
@endif

{{-- Add New File Field --}}
<div class="form-group add-files">
	<div id="dropzone" class="dropzone form-control"></div>
	{!! Form::file('items[]', [ 'multiple' => 'multiple', 'class' => 'form-control', 'id' => 'fallback']) !!}
	<a id="OneMore" class="btn btn-deafult btn-xs pull-right">one more</a>
</div>




{{-- Tags Field --}}
<div class="form-group">
    @foreach($tags as $tag)
        <label class="checkbox">
            {!! Form::checkbox('tags[]', $tag->id) !!}
            {{ $tag->tag }}
        </label>
    @endforeach
</div>

{{-- Add post Button --}}
<div class="form-group">
    {!! Form::button($title, [
        'type' => 'submit',
        'class' => 'btn btn-primary'
    ]) !!}

    <span class="or">
        or {!! link_back('cancel') !!}
    </span>
</div>
