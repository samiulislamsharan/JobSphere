    <div class="card border-0 shadow mb-4 p-3">
        <div class="s-body text-center mt-3">
            @if (Auth::user()->image != '')
                <img src="{{ asset('profile_picture/thumbnail/' . Auth::user()->image) }}" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;height: 150px;">
            @else
                <img src="{{ asset('assets/images/avatar.png') }}" alt="avatar" class="rounded-circle img-fluid"
                    style="width: 150px;">
            @endif
            <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
            <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation ?? 'Add Designation' }} </p>
            <div class="d-flex justify-content-center mb-2">
                <button data-bs-toggle="modal" data-bs-target="#filePickerModal" type="button"
                    class="btn btn-primary">Change Profile Picture</button>
            </div>
        </div>
    </div>
    <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush ">
                <li class="list-group-item d-flex justify-content-between p-3 {{ Route::is('account.profile.show') ? 'active' : '' }}">
                    <a href="{{ route('account.profile.show') }}">Account Settings</a>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3 {{ Route::is('account.job.create') ? 'active' : '' }}">
                    <a href="{{ route('account.job.create') }}">Post a Job</a>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3 {{ Route::is('account.job.my') ? 'active' : '' }}">
                    <a href="{{ route('account.job.my') }}">My Jobs</a>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3 {{ Route::is('account.job.applied') ? 'active' : '' }}">
                    <a href="{{ route('account.job.applied') }}">Jobs Applied</a>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3 {{ Route::is('account.job.saved') ? 'active' : '' }}">
                    <a href="{{ route('account.job.saved') }}">Saved Jobs</a>
                </li>
                <li class="list-group-item d-flex justify-content-center p-3">
                    <a href="{{ route('account.logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
