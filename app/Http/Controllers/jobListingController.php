<?php

namespace App\Http\Controllers;

use  App\Models\Listing;
use  App\Models\User;
use  App\Models\Categories;
use App\Models\JobApply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\UserApplied;
use App\Mail\AdminNotification;
use App\Mail\SendMeetLink;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class jobListingController extends Controller
{
    /**
     * Store Joblists
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
        return redirect()->route('account.joblist');
    }


    /**
     * Update Joblists
     */
    public function joblistUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_title' => 'sometimes|string',
            'job_category' => 'sometimes|string',
            'job_nature' => 'sometimes|string',
            'vacancy' => 'sometimes|integer',
            'salary' => 'sometimes|string',
            'location' => 'sometimes|string',
            'description' => 'sometimes|string',
            'benefits' => 'sometimes|string',
            'responsibility' => 'sometimes|string',
            'qualifications' => 'sometimes|string',
            'keywords' => 'sometimes|string',
            'company_name' => 'sometimes|string',
            'company_location' => 'sometimes|string',
            'company_website' => 'sometimes|url',
        ]);

        if ($validator->fails()) {
            toastr()->error('Please fill up the correctly');
            return redirect()->route('home.index');
        }

        $JobListing = Listing::find($request->id); // Assuming the ID of the job listing is passed in the request

        if (!$JobListing) {
            toastr()->error('Job listing not found');
            return redirect()->route('home.index');
        }


        // Check if the authenticated user is an admin before updating the status

        $id = Auth::id();
        $userid = User::findOrFail($id);
        if ($userid->role == 'Admin') {
            $JobListing->status = $request->status;
            $JobListing->feature = $request->feature;
        } else {
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
        }


        $JobListing->save();

        toastr()->success('Update successfully!');
        return redirect()->route('account.jobPost');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function category()
    {
        //Show Category

        $userId = Auth::id();
        $id = User::findOrFail($userId);

        return view('account.category', ['id' => $id]);
    }

    public function categoryadd(Request $request)
    {
        //Store category

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
     * Show Joblists
     */
    public function joblist(Request $request)
    {
        // JobLists
        $userid = auth::id();
        $id = user::findOrFail(($userid));

        $categoris = Categories::all();


        if ($id->role == 'Admin') {
            $joblists =
                Listing::paginate(5);
        } else {
            $joblists = Listing::where('userid', $userid)->paginate(5);
        }

        // $users = listing::with('user')->get();
        return view('account.joblist', compact('joblists', 'id', 'categoris'));
    }



    /**
     * Display the specified resource.
     */
    public function joblistdlt(string $id)
    {
        // Find the job listing by ID
        $joblist = listing::findOrFail($id);

        if ($joblist) {
            // Delete the job listing
            $joblist->delete();

            // Redirect to the job list view with a success message
            toastr()->success('Delete successfully!');
            return redirect()->back();
        } else {
            // If job listing not found, redirect with an error message
            toastr()->error('Delete no found!');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function jobsingle(string $id)
    {
        //Single Listing

        $singleListing = Listing::findOrFail($id);
        return view('jobsingle', compact('singleListing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function jobapply(string $id)
    {
        if (!Auth::check()) {
            toastr()->error('You need to be logged in to apply for a job!');
            return redirect()->back();
        }

        // Assuming this code is within a method in your controller
        $userId = Auth::id();
        $user = Auth::user(); // Get the authenticated user instance
        $listing = Listing::findOrFail($id);
        $employeeID = $listing->userid;

        // Check if $userId and $employeeID are the same
        if ($userId == $employeeID) {
            toastr()->error('You cannot apply to your own listing!');
            return redirect()->back();
        }

        // Check if the user has already applied to this listing
        $existingApplication = JobApply::where('user_id', $userId)
            ->where('job_id', $listing->id)
            ->exists();

        if ($existingApplication) {
            toastr()->error('You have already applied to this listing!');
            return redirect()->back();
        }

        // Create a new instance of JobApply model
        $apply = new JobApply();

        // Assign values to the attributes
        $apply->user_id = $userId;
        $apply->employee_id = $employeeID;
        $apply->job_id = $listing->id; // Assigning the ID of the listing, not the object itself

        // Save the model
        $apply->save();

        // Send email to the user who applied
        Mail::to($user->email)->send(new UserApplied($listing, $user));

        // Send email to the listing's admin
        $listingAdmin = User::find($employeeID); // Ensure the listing admin is correctly fetched
        Mail::to($listingAdmin->email)->send(new AdminNotification($listing, $user));

        toastr()->success('Applied successfully!');
        return redirect()->back();
    }
    /**
     * Show all application list
     */
    public function applied(Request $request)
    {
        $user = Auth::id();
        $id = User::findOrFail($user);
        $listings = Listing::where('userid', $id->id)->with('jobApplies.user')->get();

        $appliedListings = $listings->filter(function ($listing) {
            return $listing->jobApplies->isNotEmpty();
        });

        // Pass the listings with applications to the view
        return view('account.jobapply', compact('id', 'appliedListings'));
    }


    /**
     * Delete application list
     */


    public function appliedDelete($id)
    {
        $jobApplication = JobApply::findOrFail($id);
        $jobApplication->delete();

        toastr()->success('Application deleted successfully!');
        return redirect()->back();
    }
}
