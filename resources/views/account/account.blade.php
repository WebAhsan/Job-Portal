@extends('layout.account-layout.app')

@section('accountmain')

<div class="col-lg-9">
<form class="card mb-3 shadow" id="profileForm">
      @csrf
    <div class="card-body p-4">
        <h3 class="fs-4 mb-1">My Profile</h3>
        <div class="mb-4">
            <label for="name" class="mb-2">Name*</label>
            <input type="text" id="name" name="name" value="{{ $id->name }}" placeholder="Enter Name" class="form-control">
        </div>
        <div class="mb-4">
            <label for="email" class="mb-2">Email*</label>
            <input type="text" id="email" name="email" value="{{ $id->email }}" placeholder="Enter Email" class="form-control">
        </div>
        <div class="mb-4">
            <label for="designation" class="mb-2">Designation*</label>
            <input type="text" id="designation" name="designation" value="{{ $id->designation }}" placeholder="Designation" class="form-control">
        </div>
        <div class="mb-4">
            <label for="mobile" class="mb-2">Mobile*</label>
            <input type="text" id="mobile" name="mobile" value="{{ $id->mobile }}" placeholder="Mobile" class="form-control">
        </div>
    </div>
    <div class="card-footer p-4">
        <button type="submit" class="btn btn-primary" >Update</button>
    </div>
</form>


<form class="card mb-3 shadow" id="passwordForm" action="{{ route('account.passwordUpdate') }}" method="post">
    @csrf
    <div class="card border-0 shadow mb-4">
        <div class="card-body p-4">
            <h3 class="fs-4 mb-1">Change Password</h3>
            <div class="mb-4">
                <label for="oldpass" class="mb-2">Old Password*</label>
                <input type="password" name="oldpass" placeholder="Old Password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label for="newpass" class="mb-2">New Password*</label>
                <input type="password" name="newpass" placeholder="New Password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label for="newpass_confirmation" class="mb-2">Confirm New Password*</label>
                <input type="password" name="newpass_confirmation" placeholder="Confirm New Password" class="form-control" required>
            </div>                    
        </div>
        <div class="card-footer  p-4">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>  
</form>

                
            </div>

@endsection
