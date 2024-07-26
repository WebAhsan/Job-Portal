@extends('layout.account-layout.app')

@section('accountmain')
 

<div class="col-lg-9">
             <div class="card border-0 shadow mb-4">
    <div class="card-body card-form p-4">
        <h3 class="fs-4 mb-1">Job Details</h3>
        <form id="jobListingForm" action="{{ route('joblistings.store') }}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" value="{{ $id->id }}" placeholder="Job Title" id="userid" name="user_id" class="form-control" >
                <div class="col-md-6 mb-4">
                    <label for="title" class="mb-2">Title<span class="req">*</span></label>
                    <input type="text" placeholder="Job Title" id="title" name="job_title" class="form-control" >
                </div>
                <div class="col-md-6 mb-4">
                    <label for="category" class="mb-2">Category<span class="req">*</span></label>
                    <select name="job_category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        @foreach ($categoris as $categori )
                        <option value="{{  $categori->slug }}">{{  $categori->name }}</option>
                         @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="job_nature" class="mb-2">Job Nature<span class="req">*</span></label>
                    <select name="job_nature" id="job_nature" class="form-select">
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                        <option value="Remote">Remote</option>
                        <option value="Freelance">Freelance</option>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                    <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="salary" class="mb-2">Salary</label>
                    <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="location" class="mb-2">Location<span class="req">*</span></label>
                    <input type="text" placeholder="Location" id="location" name="location" class="form-control" >
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="mb-2">Description</label>
                <textarea class="form-control" name="description" id="description1" cols="5" rows="5" placeholder="Description" ></textarea>
                    
            </div>
            <div class="mb-4">
                <label for="benefits" class="mb-2">Benefits</label>
                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
            </div>
            <div class="mb-4">
                <label for="responsibility" class="mb-2">Responsibility</label>
                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility" ></textarea>
            </div>
            <div class="mb-4">
                <label for="qualifications" class="mb-2">Qualifications</label>
                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
            </div>
            
            <div class="mb-4">
                <label for="keywords" class="mb-2">Keywords<span class="req">*</span></label>
                <input type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control">
            </div>

            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="company_name" class="mb-2">Name<span class="req">*</span></label>
                    <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control" >
                </div>
                <div class="col-md-6 mb-4">
                    <label for="company_location" class="mb-2">Location</label>
                    <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                </div>
            </div>

            <div class="mb-4">
                <label for="website" class="mb-2">Website</label>
                <input type="text" placeholder="Website" id="website" name="company_website" class="form-control">
            </div>

            <div class="card-footer p-4">
                <button type="submit" class="btn btn-primary">Save Job</button>
            </div>
        </form>
    </div>
</div>



@endsection
