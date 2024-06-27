@extends('front.layouts.app')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.shared.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.account.shared.message')
                    <div class="container text-center">
                        <div class="h2">Global Stats</div>

                        <div class="row align-items-center mt-4">
                            <div class="col">
                                <div class="card border-0 shadow mt-2">
                                    <div class="card-body">
                                        <h4 class="pb-0">{{ $usersCount }} Users</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow mt-2">
                                    <div class="card-body">
                                        <h4 class="pb-0">{{ $jobsCount }} Jobs</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow mt-2">
                                    <div class="card-body">
                                        <h4 class="pb-0">{{ $applicantCount }} Applicants</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mt-4">
                            <div class="col">
                                <div class="card border-0 shadow mt-2">
                                    <div class="card-body">
                                        <h4 class="pb-0">{{ $categoryCount }} Categories</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow mt-2">
                                    <div class="card-body">
                                        <h4 class="pb-0">{{ $jobTypeCount }} Job Types</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript"></script>
@endsection
