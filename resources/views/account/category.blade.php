@extends('layout.account-layout.app')

@section('accountmain')

<div class="col-lg-9">
<form class="card mb-3 shadow" action="{{ route('account.categoryadd') }}" method="post" id="categoryForm">
     @csrf
    <div class="card-body p-4">
        <h3 class="fs-4 mb-1">Category</h3>
        <div class="mb-4">
            <label for="name" class="mb-2">Category Name</label>
            <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control">
        </div>
        <div class="mb-4">
            <label for="name" class="mb-2">Category Slug</label>
            <input type="text" id="name" name="slug" placeholder="Enter Name" class="form-control">
        </div>

    </div>
    <div class="card-footer p-4">
        <button type="submit" class="btn btn-primary" >Add Category</button>
    </div>
</form>



@endsection
