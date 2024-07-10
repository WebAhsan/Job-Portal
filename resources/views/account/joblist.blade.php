@extends('layout.account-layout.app')

@section('accountmain')

<div class="col-lg-9">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">My Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <a href="{{ route('account.jobPost') }}" class="btn btn-primary">Post a Job</a>
                            </div>
                           
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">

                                    @foreach($joblists as $joblist)

                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{  $joblist->job_title }}</div>
                                            <div class="info1">{{  $joblist->job_nature }} . {{  $joblist->location }}</div>
                                        </td>
                                        <td>{{  $joblist->created_at->format('Y-m-d') }}</td>
                                        <td>130 Applications</td>
                                        <td>
                                            @if($joblist->status == '1')
                                            <div class="job-status text-capitalize p-1 text-center bg-success text-white">active</div>
                                            @else
                                            <div class="job-status text-capitalize p-1 text-center bg-warning text-white">Pending</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach


                                </tbody>
                                
                            </table>
                        </div>
                     
                    </div>
                </div> 
            </div>


@endsection
