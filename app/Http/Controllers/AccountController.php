<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\alert;

class AccountController extends Controller
{
    /**
     * Display login view
     */
    public function index($id)
    {

        $user = User::findOrFail($id);
        return view('account.account', ['id' => $user]);
    }

    /**
     * Display login view
     */
    public function login()
    {

        return view('account.login');
    }

    /**
     * Display login process
     */

    public function loginprocess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response()->json(['success' => 'Logged in successfully', 'user_id' => Auth::id()]);
        }

        return response()->json(['error' => 'Invalid email or password'], 401);
    }



    /**
     * Display logout process
     */


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        return redirect()->route('account.login');
    }

    /**
     * Display register view
     */
    public function register()
    {
        return view('account.register');
    }


    /**
     * Display register process
     */
    public function registerprocess(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the email already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json(['errors' => ['email' => ['The email has already been taken.']]], 422);
        }

        // Create the new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => 'Registration successful!']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function uploadImage(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Validate request
        $request->validate([
            'image' => 'required',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Find the user by ID
        $user = User::find($userId);

        // Process image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/assets/images', $imageName);

            // Save image name in user record
            $user->image = $imageName;
            $user->save();

            return response()->json(['success' => 'Image Upload successful!']);
        }

        return alert('No image found in request');
    }


    public function passwordUpdate(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Validate request
        $request->validate([
            'oldpass' => 'required',
            'newpass' => 'required|string|min:8|confirmed',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->oldpass, $user->password)) {
            toastr()->error('The old password is incorrect');
            return redirect()->back();
        }

        // Update the user's password
        $user->password = Hash::make($request->newpass);
        $user->save();

        toastr()->success('Password change successfully!');
        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function accountUpdate(Request $request)
    {
        //  

        $userId = Auth::id();

        // Find the user by ID
        $user = User::findOrFail($userId);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->mobile = $request->mobile;
        $user->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function jobPost()
    {
        // Job Post View

        $categories = Categories::all();

        $userid = Auth::id();
        $id = User::findorFail($userid);
        return view('account.job-post', ['id' => $id, 'categoris' => $categories]);
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
