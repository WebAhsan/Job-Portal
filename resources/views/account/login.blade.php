@extends('layout.app')

@section('main')



<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <div id="errorPopup" style="display:none; margin-bottom: 20px; padding:20px; background-color:red; color:white; border-radius:10px;">
                        <p id="errorMessage" style="margin-bottom: 0"></p>
                    </div>
                    <h1 class="h3">Login</h1>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="example@example.com">
                        </div> 
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                        </div> 
                        <div class="justify-content-between d-flex">
                            <button type="submit" class="btn btn-primary mt-2">Login</button>
                            <a href="forgot-password.html" class="mt-3">Forgot Password?</a>
                        </div>
                    </form>                  
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.alert-danger').forEach(el => el.remove());

        let formData = new FormData(this);

        fetch('{{ route('account.loginprocess') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
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
            } else if (data.error) {
                // Handle authentication errors
                let errorPopup = document.getElementById('errorPopup');
                document.getElementById('errorMessage').innerText = data.error;
                errorPopup.style.display = 'block';
            } else {
                // Handle success
                window.location.href = `/account/${data.user_id}`;
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

<!-- Add this HTML for the error popup -->
<div id="errorPopup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); padding:20px; background-color:red; color:white; border-radius:10px;">
    <p id="errorMessage"></p>
    <button onclick="document.getElementById('errorPopup').style.display='none';">Close</button>
</div>

@endsection
