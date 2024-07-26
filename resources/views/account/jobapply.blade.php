@extends('layout.account-layout.app')

@section('accountmain')
 

<div class="col-lg-9">
    <div class="card border-0 shadow mb-4 p-3">
        <div class="card-body card-form">
            <h3 class="fs-4 mb-1">Jobs Applied</h3>
            <div class="table-responsive">
                <table class="table ">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Applicants</th>
                            <th scope="col">Application's Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">


                @foreach ($appliedListings as $listing)

                        <tr class="active">
                            <td>
                                <div class="job-name fw-500">{{ $listing->job_title }}</div>
                                <div class="info1">{{ $listing->job_nature }} . {{ $listing->location }}</div>
                            </td>
                             @foreach ($listing->jobApplies as $application)

                            <td>{{ $listing->jobApplies->count() }} Applications</td>
                             <td>
                                <div class="job-status text-capitalize">{{ $application->user->email }}</div>
                            </td>
                           
                            @endforeach
                            <td>
                                <div class="action-dots float-end">
                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('jobsingle',$listing->id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>


                                         <form id="delete-form-{{ $application->id }}" action="{{ route('account.appliedDelete', $application->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <li><a href="#0" class="dropdown-item"   onclick="confirmDeletion({{ $application->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>

                                    <script>
                                        function confirmDeletion(id) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('delete-form-' + id).submit();
                                                }
                                            });
                                        }
                                    </script>















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

    {{-- @if ($appliedListings->isEmpty())
    <p>No listings have applications.</p>
@else
    @foreach ($appliedListings as $listing)
        <div class="listing">
            <h2>{{ $listing->job_title }}</h2>
            <p>{{ $listing->description }}</p>
            <!-- Display other listing details as needed -->

            <h3>Applications</h3>
            @foreach ($listing->jobApplies as $application)
                <div class="application">
                    <p>Applicant ID: {{ $application->user->id }}</p>
                    <p>Applicant Name: {{ $application->user->name }}</p>
                    <p>Applicant Email: {{ $application->user->email }}</p>
                    <!-- Display other user details as needed -->
                </div>
            @endforeach
        </div>
    @endforeach
@endif --}}


            </div>



@endsection
