@extends('front.layouts.app')

@section('content')
    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>
                </div>
                <div class="col-6 col-md-2">
                    <div class="align-end">

                    </div>
                </div>
            </div>

            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <div class="card border-0 shadow p-4">
                        <div class="mb-4">
                            <h2>Sort By</h2>
                            <select name="sort" id="sort" class="form-select form-control">
                                <option value="">Latest</option>
                                <option value="">Oldest</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <h2>Keywords</h2>
                            <input type="text" id="keywords" name="keywords" placeholder="Keywords"
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Location</h2>
                            <input type="text" id="location" name="location" placeholder="Location"
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Category</h2>
                            <select name="category" id="category" class="form-select form-control">
                                <option value="">Select a Category</option>
                                <option value="">Engineering</option>
                                <option value="">Accountant</option>
                                <option value="">Information Technology</option>
                                <option value="">Fashion designing</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <h2>Job Type</h2>
                            <div class="form-check mb-2">
                                <input class="form-check-input " name="job_type" type="checkbox" value="1"
                                    id="">
                                <label class="form-check-label " for="">Full Time</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input school-section" name="job_type" type="checkbox"
                                    value="1" id="">
                                <label class="form-check-label " for="">Part Time</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input school-section" name="job_type" type="checkbox"
                                    value="1" id="">
                                <label class="form-check-label " for="">Freelance</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input school-section" name="job_type" type="checkbox"
                                    value="1" id="">
                                <label class="form-check-label " for="">Remote</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h2>Experience</h2>
                            <select name="experience" id="experience" class="form-select form-control">
                                <option value="">Select Experience</option>
                                <option value="">1 Year</option>
                                <option value="">2 Years</option>
                                <option value="">3 Years</option>
                                <option value="">4 Years</option>
                                <option value="">5 Years</option>
                                <option value="">6 Years</option>
                                <option value="">7 Years</option>
                                <option value="">8 Years</option>
                                <option value="">9 Years</option>
                                <option value="">10 Years</option>
                                <option value="">10+ Years</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body">
                                            <h3 class="border-0 fs-5 pb-2 mb-0">Laravel Developer</h3>
                                            <p>We are in need of a Laravel Developer for our company.</p>
                                            <div class="bg-light p-3 border">
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">Gazipur Sadar</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                    <span class="ps-1">On-Site</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                    <span class="ps-1">100k</span>
                                                </p>
                                            </div>

                                            <div class="d-grid mt-3">
                                                <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                            </div>
                                        </div>
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
@endsection
