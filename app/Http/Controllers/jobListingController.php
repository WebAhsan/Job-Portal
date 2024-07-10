<?php

namespace App\Http\Controllers;

use  App\Models\Listing;
use  App\Models\User;
use  App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class jobListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Validate the incoming request data

        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'job_category' => 'required',
            'job_nature' => 'required',
            'vacancy' => 'required',
            'salary' => 'required',
            'location' => 'required',
            'description' => 'required',
            'benefits' => 'required',
            'responsibility' => 'required',
            'qualifications' => 'required',
            'keywords' => 'required',
            'company_name' => 'required',
            'company_location' => 'required',
            'company_website' => 'required',
        ]);

        // Custom validation messages

        if ($validator->fails()) {
            toastr()->error('Please fill up the correctly');
            return redirect()->route('home.index');
        }



        $JobListing =  new Listing();
        $JobListing->job_title = $request->job_title;
        $JobListing->job_category = $request->job_category;
        $JobListing->job_nature = $request->job_nature;
        $JobListing->vacancy = $request->vacancy;
        $JobListing->salary = $request->salary;
        $JobListing->location = $request->location;
        $JobListing->description = $request->description;
        $JobListing->benefits = $request->benefits;
        $JobListing->responsibility = $request->responsibility;
        $JobListing->qualification = $request->qualifications;
        $JobListing->keywords = $request->keywords;
        $JobListing->company_name = $request->company_name;
        $JobListing->company_location = $request->company_location;
        $JobListing->company_website = $request->company_website;
        $JobListing->userid = $request->user_id;
        $JobListing->save();

        toastr()->success('Data has been saved successfully!');

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function category()
    {
        //

        $userId = Auth::id();
        $id = User::findOrFail($userId);

        return view('account.category', ['id' => $id]);
    }

    public function categoryadd(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categoris = new Categories();
        $categoris->name = $request->name;
        $categoris->slug = $request->slug;
        $categoris->save();

        toastr()->success('Data has been saved successfully!');

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function joblist(Request $request)
    {
        //

        // $userid = auth::id();
        // $id = user::findOrFail(($userid));

        // $users = listing::with('user')->get();

        // $joblists = Listing::where('userid', $userid)->get();
        // return view('account.joblist', compact('joblists', 'id', 'users'));

        $userid = auth::id();
        $id = user::findOrFail(($userid));


        if ($id->role == 'Admin') {
            $joblists =
                Listing::all();
        } else {
            $joblists = Listing::where('userid', $userid)->get();
        }

        // $users = listing::with('user')->get();
        return view('account.joblist', compact('joblists', 'id'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
