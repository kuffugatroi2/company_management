@if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $err)
            {{ $err }} <br>
        @endforeach
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@elseif(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
