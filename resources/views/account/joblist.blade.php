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
                                <div class="job-name fw-500">{{ $joblist->job_title }}</div>
                                <div class="info1">{{ $joblist->job_nature }} . {{ $joblist->location }}</div>
                            </td>
                            <td>{{ $joblist->created_at->format('Y-m-d') }}</td>
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
                                    <li><a class="dropdown-item" href="{{ route('jobsingle',$joblist->id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                    <li><a href="#" class="dropdown-item edit-job-link" data-joblist='@json($joblist)'><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                    <form id="delete-form-{{ $joblist->id }}" action="{{ route('joblist.delete', $joblist->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <li><a href="#0" class="dropdown-item"   onclick="confirmDeletion({{ $joblist->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>

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
            <div class="d-flex justify-content-center mt-3">
                {{ $joblists->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Edit Job Listing Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Edit Job Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editJobForm" method="POST">
                @csrf
                <div class="modal-body">

                    @if(auth()->user()->role == 'Admin')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="feature">Feature</label>
                        <select class="form-control" id="feature" name="feature">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                @endif
                    
                    @if(auth()->user()->role == 'Member')

                    <div class="form-group">
                        <label for="job_title">Job Title</label>
                        <input type="text" class="form-control" id="job_title" name="job_title">
                    </div>
                   
                    <label for="category" class="mb-2">Category<span class="req">*</span></label>
                    <select name="job_category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                           @if(!empty($categoris))
                            @foreach ($categoris as $categori)
                                <option value="{{ $categori->slug }}" 
                                        {{ isset($joblist) && $categori->slug == $joblist->job_category ? 'selected' : '' }}>
                                    {{ $categori->name }}
                                </option>
                            @endforeach
                        @endif

                    </select>

                    
                    <div class="form-group">
                        <label for="job_nature">Job Nature</label>
                        <input type="text" class="form-control" id="job_nature" name="job_nature">
                    </div>

                    <div class="form-group">
                        <label for="vacancy" class="mb-2">Vacancy</label>
                        <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="salary" class="mb-2">Salary</label>
                            <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="mb-2">Description<span class="req">*</span></label>
                        <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="benefits" class="mb-2">Benefits</label>
                        <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="responsibility" class="mb-2">Responsibility</label>
                        <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
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
                            <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
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
                 @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editLinks = document.querySelectorAll('.edit-job-link');

    editLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            const joblist = JSON.parse(this.getAttribute('data-joblist'));
            const modal = new bootstrap.Modal(document.getElementById('editJobModal'));

            const setFieldValue = (elementId, value) => {
                const element = document.getElementById(elementId);
                if (element) {
                    element.value = value !== undefined ? value.toString() : '';
                }
            };

            setFieldValue('job_title', joblist.job_title);
            setFieldValue('job_nature', joblist.job_nature);
            setFieldValue('location', joblist.location);
            setFieldValue('vacancy', joblist.vacancy);
            setFieldValue('salary', joblist.salary);
            setFieldValue('description', joblist.description);
            setFieldValue('benefits', joblist.benefits);
            setFieldValue('responsibility', joblist.responsibility);
            setFieldValue('qualifications', joblist.qualification);
            setFieldValue('keywords', joblist.keywords);
            setFieldValue('company_name', joblist.company_name);
            setFieldValue('company_location', joblist.company_location);
            setFieldValue('website', joblist.company_website);
            setFieldValue('status', joblist.status);
            setFieldValue('feature', joblist.feature);

            document.getElementById('editJobForm').action = `/joblist/update/${joblist.id}`;

            modal.show();
        });
    });
});

</script>
@endsection





