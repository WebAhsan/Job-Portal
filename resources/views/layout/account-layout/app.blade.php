@extends('layout.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="s-body text-center mt-3">
                        @if(!empty($id->image))
                        <img src="{{ asset('storage/assets/images/' . $id->image) }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
                        @else
                         <img src="{{ asset('assets/images/placeholder-profile.png') }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
                         @endif
                        <h5 class="mt-3 pb-0">{{ $id->name }}</h5>
                        <p class="text-muted mb-1 fs-6">{{ $id->designation }}</p>
                        <div class="d-flex justify-content-center mb-2">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
                        </div>
                    </div>
                </div>
                <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex justify-content-between p-3">
                                <a href="{{ route('account',['id' => $id]) }}">Account Settings</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="{{ route('account.jobPost'); }}">Post a Job</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="{{ route('account.joblist') }}">My Jobs</a>
                            </li>
                            @if(Auth::check() && Auth::user()->role == 'Admin')
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <a href="{{ route('account.category') }}">Jobs Category</a>
                                </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="{{ route('account.applied') }}">Jobs Applied</a>
                            </li>                                                   
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <form id="logoutForm" action="{{ route('account.logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a>

                            </li>                                                        
                          
                                                       
                        </ul>
                    </div>
                </div>
            </div>

            @yield('accountmain')


        </div>
    </div>
</section>



  <!-- Modal for changing profile picture -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="imageUploadForm">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-3">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

    <script>
       $(document).ready(function () {

         // For Profile Image Update


    $('#imageUploadForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '{{ route('account.uploadImage') }}',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    alert(response.success); // Display alert with the success message
                     location.reload();
                }
            },
            error: function (response) {
                console.log(response); // Log the full response
                alert('Image upload failed. Please try again.');
            }
        });
    });


    // For Profile Update
    $('#profileForm').on('submit', function (e) {
             e.preventDefault();
        let formData = new FormData(this);

            $.ajax({
                url: '{{ route('account.update') }}', // Ensure this route points to your controller method
                type: 'POST',
                data: formData,
                 contentType: false,
               processData: false,
                 headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
             
                success: function(response) {
                    alert('Profile updated successfully!');
                    // Optionally, update the UI or handle other logic after successful update
                },
                error: function(xhr) {
                    // Handle errors, display error messages, etc.
                    console.error(xhr.responseText);
                    alert('Error updating profile. Please try again.');
                }
            });
        });


    // For Profile Update

    CKEDITOR.replace('description');
    

});

    </script>
@endsection