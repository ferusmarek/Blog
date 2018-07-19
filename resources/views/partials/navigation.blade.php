@if (Auth::check())
    <nav class="navigation">
        <div class="btn-group btn-group-sm pull-left">
            <a href="{{ url('/')}}" class="btn btn-default">all post</a>
            <a href="{{ url('user/'. Auth::user()->name) }}" class="btn btn-default">my post</a>
            <a href="{{ url('post/create')}}" class="btn btn-default">add new</a>
        </div>
        <div class="btn-group btn-group-sm pull-right">
            <a href="{{ route('user.edit', Auth::user()->name)}}"  class="btn btn-default">
                {{ Auth::user()->email }}
            </a>
            <a href="{{ route('logout')}}"  class="btn btn-default logout" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
                {{ csrf_field() }}
            </form>
        </div>
    </nav>

@endif
