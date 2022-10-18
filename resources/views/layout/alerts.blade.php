@if (session('success'))
    <div class="alert container alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert container alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert container alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif