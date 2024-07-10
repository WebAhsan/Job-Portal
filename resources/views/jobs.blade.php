@extends('layout.app')

@section('main')

<section class="section-3 py-5 bg-2">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10">
                <h2>Find Jobs</h2>
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
     <form action="{{ route('home.jobsfilter') }}" method="GET" id="sortForm">
                        <select name="sort" id="sort" class="form-control" onchange="document.getElementById('sortForm').submit()">
                            <option value="">Latest</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                    <form action="{{ route('home.jobsfilter') }}" method="GET">
                        <div class="mb-4">
                            <h2>Keywords</h2>
                            <input type="text" value="{{ request('keywords') }}" name="keywords"
                                placeholder="Keywords" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Location</h2>
                            <input type="text" name="location" value="{{ request('location') }}"
                                placeholder="Location" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Category</h2>
                            <select name="job_category" id="category" class="form-control">
                                <option value="">Select a Category</option>
                                @foreach($categoris as $cats)
                                <option value="{{ $cats->slug }}"
                                    {{ request('job_category') == $cats->slug ? 'selected' : '' }}>{{ $cats->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <h2>Job Type</h2>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="job_nature[]" type="checkbox" value="Full Time"
                                    {{ in_array('Full Time', (array) request('job_nature')) ? 'checked' : '' }}>
                                <label class="form-check-label">Full Time</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" name="job_nature[]" type="checkbox" value="Part Time"
                                    {{ in_array('Part Time', (array) request('job_nature')) ? 'checked' : '' }}>
                                <label class="form-check-label">Part Time</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" name="job_nature[]" type="checkbox"
                                    value="Freelance" {{ in_array('Freelance', (array) request('job_nature')) ? 'checked' : '' }}>
                                <label class="form-check-label">Freelance</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" name="job_nature[]" type="checkbox" value="Remote"
                                    {{ in_array('Remote', (array) request('job_nature')) ? 'checked' : '' }}>
                                <label class="form-check-label">Remote</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8 col-lg-9">
                <div class="job_listing_area">
                    <div class="job_lists">
                        <div class="row">
                            @if($jobs->isEmpty())
                            <div class="col-12">
                                <p class="text-center">No jobs found.</p>
                            </div>
                            @else
                            @foreach($jobs as $job)
                            <div class="col-md-4">
                                <div class="card border-0 p-3 shadow mb-4">
                                    <div class="card-body">
                                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->job_title }}</h3>
                                        <p>{{ $job->description }}</p>
                                        <div class="bg-light p-3 border">
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1">{{ $job->location }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{ $job->job_nature }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $job->salary }}</span>
                                            </p>
                                        </div>

                                        <div class="d-grid mt-3">
                                            <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
