<div class="top-page container">
    <div class="row flex-row justify-content-between align-items-center">
        <div class="col-8">
            <h1>@yield('title')</h1>
        </div>
        <div class="col-2 text-right align-content-center align-items-center">
            <h5>{{ Auth::user()->firstName . '.' . strtoupper(Auth::user()->lastName)}}</h5>
        </div>
        <div class="col-2 text-right align-content-center">
            <form action="logout" method="post">
                @csrf
                <button type="submit" class="btn btn-light">Logout</button>
            </form>
        </div>
    </div>

    @if(Session::has('flashmessage'))
        <div class="alert alert-{{ session('flashmessage')["type"] }}" role="alert">
            {{ session('flashmessage')["message"] }}
        </div>
    @endif
</div>
