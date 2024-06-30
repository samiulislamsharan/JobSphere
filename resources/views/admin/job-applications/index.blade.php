@extends('front.layouts.app')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Job Applications</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.shared.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <h3 class="fs-4 mb-1">All Job Applications</h3>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Employer</th>
                                            <th scope="col">Applied Date</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @forelse ($jobApplications as $jobApplication)
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $jobApplication->job->title }}</div>
                                                    <div class="info1">
                                                        {{ $jobApplication->job->jobType->name }}
                                                        . {{ $jobApplication->job->location }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="user-info">
                                                        {{ $jobApplication->user->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $jobApplication->employer->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($jobApplication->job->applied_date)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                    @if ($jobApplication->job->status == 1)
                                                        <div class="job-status text-capitalize text-success text-center">
                                                            Active
                                                        </div>
                                                    @else
                                                        <div class="job-status text-capitalize text-danger text-center">
                                                            Inactive</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-dots float-end">
                                                        <a href="#" class="" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" target="_blank"
                                                                    href="{{ route('job.detail', $jobApplication->job->id) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="deleteJobApplication({{ $jobApplication->id }})">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No job applications found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            {{ $jobApplications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript">
    </script>
@endsection
