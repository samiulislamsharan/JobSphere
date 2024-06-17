@extends('front.layouts.app')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.shared.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.account.shared.message')
                    <form action="" method="POST" id="create-job-form" name="create-job-form">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                        <select class="form-select form-control" name="category" id="category">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="job_type" class="mb-2">Job Type<span class="req">*</span></label>
                                        <select class="form-select form-control" name="job_type" id="job_type">
                                            <option value="">Select a Job Type</option>
                                            @if ($jobTypes->isNotEmpty())
                                                @foreach ($jobTypes as $jobType)
                                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            name="vacancy" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="salary" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="Location" id="location" name="location"
                                            class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description"></textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="benefits" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="responsibility" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility"></textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="qualifications" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5"
                                        placeholder="Qualifications"></textarea>
                                    <p></p>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                    <select class="form-select form-control" name="experience" id="experience">
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Years</option>
                                        <option value="3">3 Years</option>
                                        <option value="4">4 Years</option>
                                        <option value="5">5 Years</option>
                                        <option value="6">6 Years</option>
                                        <option value="7">7 Years</option>
                                        <option value="8">8 Years</option>
                                        <option value="9">9 Years</option>
                                        <option value="10_plus">10 Years</option>
                                    </select>
                                    <p></p>
                                </div>

                                <div class="mb-4">
                                    <label for="keywords" class="mb-2">Keywords</label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        class="form-control">
                                    <p></p>
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="company_name" class="mb-2">Name<span
                                                class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            name="company_name" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="company_location" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            name="company_location" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="company_website" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="company_website"
                                        name="company_website" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="card-footer p-4">
                                <button type="submit" class="btn btn-primary">Save Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript">
        $("#create-job-form").submit(function(e) {
            e.preventDefault();

            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                type: "POST",
                url: "{{ route('account.job.store') }}",
                dataType: "JSON",
                data: $("#create-job-form").serializeArray(),
                success: function(response) {
                    if (response.status == true) {
                        $("button[type=submit]").prop('disabled', false);

                        $("#title").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#category").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#job_type").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#vacancy").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#location").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#description").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#company_name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        window.location.href = "{{ route('account.job.my') }}";

                    } else {
                        var errors = response.errors;

                        if (errors.title) {
                            $("#title")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.title);
                        } else {
                            $("#title")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.category) {
                            $("#category")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.category);
                        } else {
                            $("#category")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.job_type) {
                            $("#job_type")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.job_type);
                        } else {
                            $("#job_type")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.vacancy) {
                            $("#vacancy")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.vacancy);
                        } else {
                            $("#vacancy")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.location) {
                            $("#location")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.location);
                        } else {
                            $("#location")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.description) {
                            $("#description")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.description);
                        } else {
                            $("#description")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.company_name) {
                            $("#company_name")
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.company_name);
                        } else {
                            $("#company_name")
                                .removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection
