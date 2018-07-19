<header class="post-header">
    <h1 class="box-heading">{{$title}}</h1>
</header>

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
	{!! Form::file('items[]', ['class' => 'form-control']) !!}
	<a class="btn btn-default btn-xs pull-right">one more</a>
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
