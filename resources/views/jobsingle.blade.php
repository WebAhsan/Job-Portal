@extends('layout.app')

@section('main')

<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $singleListing->job_title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{ $singleListing->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>  {{ $singleListing->job_nature }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="#"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            {!! $singleListing->description !!}
                        </div>

                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            <a href="#" class="btn btn-secondary">Save</a>
                            <a href="{{ route('joblist.apply',$singleListing->id)}}" data-id="{{ $singleListing->id }}" id="applyBtn" class="btn btn-primary">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>12 Nov, 2019</span></li>
                                <li>Vacancy: <span> {{ $singleListing->vacancy }}</span></li>
                                <li>Salary: <span> {{ $singleListing->salary }}</span></li>
                                <li>Location: <span> {{ $singleListing->location }}</span></li>
                                <li>Job Nature: <span> {{ $singleListing->job_nature }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{ $singleListing->company_name }}</span></li>
                                <li>Locaion: <span>{{ $singleListing->company_location }}</span></li>
                                <li>Webite: <span>{{ $singleListing->company_website }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@section ('scripts')

<script>
//         // Ensure the script runs after the DOM is fully loaded
//   document.addEventListener('DOMContentLoaded', function() {
//             var applyBtn = document.getElementById('applyBtn');

//             applyBtn.addEventListener('click', function(event) {
//                 event.preventDefault();

//                 var listingId = this.getAttribute('data-id');
//                 var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//                 var xhr = new XMLHttpRequest();
//                 xhr.open('POST', '/joblist/apply/' + listingId, true);
//                 xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
//                 xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

//                 xhr.onreadystatechange = function() {
//                     if (xhr.readyState === XMLHttpRequest.DONE) {
//                         if (xhr.status === 200) {
//                             alert('Application successful');
//                         } else {
//                             alert('Error: ' + xhr.statusText);
//                         }
//                     }
//                 };

//                 xhr.send(JSON.stringify({ id: listingId }));
//             });
//         });
    </script>

@endsection