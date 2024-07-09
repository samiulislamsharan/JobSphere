<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li
                class="list-group-item d-flex justify-content-between p-3 {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li
                class="list-group-item d-flex justify-content-between p-3 {{ Route::is('admin.users.index') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">Users</a>
            </li>
            <li class="list-group-item d-flex justify-content-between p-3 {{ Route::is('admin.jobs.index') ? 'active' : '' }}">
                <a href="{{ route('admin.jobs.index') }}">Jobs</a>
            </li>
            <li
                class="list-group-item d-flex justify-content-between p-3 {{ Route::is('admin.job.applications.index') ? 'active' : '' }}">
                <a href="{{ route('admin.job.applications.index') }}">Job Applications</a>
            </li>
            <li class="list-group-item d-flex justify-content-center p-3">
                <a href="{{ route('account.logout') }}">Logout</a>
            </li>
        </ul>
    </div>
</div>
