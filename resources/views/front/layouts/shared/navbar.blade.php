<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">JobSphere</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('jobs') }}">Find Jobs</a>
                </li>
            </ul>
            @auth
                @if (Auth::user()->role == 'admin')
                    <a class="btn btn-primary me-2" href="{{ route('admin.dashboard') }}" type="submit">Admin</a>
                @endif
                <a class="btn btn-primary me-2" href="{{ route('account.profile.show') }}" type="submit">Account</a>
                <a class="btn btn-outline-primary" href="{{ route('account.job.create') }}" type="submit">Post a Job</a>
            @endauth

            @guest
                <a class="btn btn-outline-primary me-2" href="{{ route('account.login.index') }}" type="submit">Login</a>
            @endguest
        </div>
    </div>
</nav>
