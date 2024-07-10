@extends('layout.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form id="registerForm">
                        <div class="mb-3">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                        </div> 
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                        </div> 
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                        </div> 
                        <div class="mb-3">
                            <label for="password_confirmation" class="mb-2">Confirm Password*</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter Password">
                        </div> 
                        <button type="submit" class="btn btn-primary mt-2">Register</button>
                    </form>                  
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Your registration was successful. You can now log in.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="loginButton" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('.alert-danger').forEach(el => el.remove());

            let formData = new FormData(this);

            fetch('{{ route('account.registerprocess') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response data:', data);  // Debugging

                if (data.errors) {
                    // Handle validation errors
                    let errors = data.errors;
                    Object.keys(errors).forEach(key => {
                        let input = document.querySelector(`[name="${key}"]`);
                        let errorMessage = document.createElement('div');
                        errorMessage.className = 'alert alert-danger mt-2';
                        errorMessage.innerText = errors[key][0];
                        input.parentNode.appendChild(errorMessage);
                    });
                } else {
                    // Handle success
                    let successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
                    successModal.show();

                    // Add event listener to the Login button
                    document.getElementById('loginButton').addEventListener('click', function() {
                        window.location.href = '{{ route('account.login') }}';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);  // Debugging
            });
        });
    });
</script>
@endsection
