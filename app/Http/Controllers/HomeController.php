<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Home Page 

        $jobLists = Listing::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $featureJobs = Listing::where('feature', 1)
            ->where('status', 1)
            ->get();


        $categories = Categories::withCount('listings')->get();
        return view('welcome', compact('categories', 'featureJobs', 'jobLists'));
    }


    public function jobs(Request $request)
    {

        $jobs =  listing::all();
        $categoris =  categories::all();
        return view('jobs', compact('jobs', 'categoris'));
    }

    public function jobsfilter(Request $request)
    {

        $query = listing::query();
        if ($request->filled('keywords')) {
            $query->where('job_title', 'like', '%' . $request->keywords . '%')
                ->orWhere('description', 'like', '%' . $request->keywords . '%');
        }
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('job_category')) {
            $query->where('job_category', $request->job_category);
        }

        if ($request->filled('job_nature')) {
            $query->where('job_nature', $request->job_nature);
        }

        // Handle sorting
        if ($request->input('sort') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // default to latest
        }


        $jobs = $query->get();
        $categoris =  categories::all();
        return view('jobs', [
            'jobs' => $jobs,
            'categoris' => $categoris,
            'keywords' => $request->keywords,
            'location' => $request->location,
            'job_category' => $request->job_category,
            'job_nature' => $request->job_nature,

        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function filterjob(Request $request)
    {
        $query = Listing::query();

        if ($request->filled('keywords')) {
            $query->where('job_title', 'like', '%' . $request->keywords . '%')
                ->orWhere('description', 'like', '%' . $request->keywords . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('job_type')) {
            $query->where('job_nature', $request->job_type);
        }

        if ($request->filled('experience')) {
            $query->where('experience', '>=', $request->experience);
        }

        $listings = $query->get();

        $categories = Categories::with('listings')->get();
        return view('jobs', compact('categories', 'listings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
