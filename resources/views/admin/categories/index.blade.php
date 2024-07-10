@extends('front.layouts.app')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">All Categories</h3>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div style="margin-top: -10px;" class="me-2">
                                        <a href="#" class="btn btn-primary">Add new Category</a>
                                    </div>
                                    <div style="margin-top: -10px;" class="">
                                        <a href="#" class="btn btn-primary">Add new Subcategory</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="border-0">
                                        @forelse ($categories as $category)
                                            <tr class="active">
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    @if ($category->status == 1)
                                                        <div class="job-status text-capitalize text-success">
                                                            Active</div>
                                                    @else
                                                        <div class="job-status text-capitalize text-danger">
                                                            Inactive</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-dots d-flex">
                                                        <button href="#" class="button btn btn-secondary"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            {{-- <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.jobs.edit', $job->id) }}">
                                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                                    Edit
                                                                </a>
                                                            </li> --}}
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="deleteCategory({{ $category->id }})">
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
                                                <td colspan="5" class="text-center">No jobs found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript">
        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: "{{ route('admin.categories.destroy', $category->id) }}",
                    type: "DELETE",
                    dataType: "JSON",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        window.location.href = "{{ route('admin.categories.index') }}";
                    }
                });
            }
        }
    </script>
@endsection
