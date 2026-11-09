@if(session('success'))
    <div class="flash success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="flash error">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="flash error">
        <strong>Periksa kembali ya:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif