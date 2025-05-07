<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{/**
     * Register a new user.
     */
   
   
public function register(Request $request)
{
   
    try {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Validate unique email
            'password' => 'required|string|min:6|confirmed', // Password must match the password_confirmation field
            'mobile_number' => 'required|numeric|digits_between:9,11', // Validate mobile number
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
      
      
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'mobile_number' => $request->mobile_number, // Store the mobile number
        ]);
       
        // Log the user in immediately after registration
        Auth::login($user);

   
        // Redirect to the profile page
        return redirect('account')->with('success', 'You are now logged in and ready to launch your next successful marketing campaign!');
    
    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => 'User Not Registered: ' . $e->getMessage()])
            ->withInput();
    }
}
    
     

    /**
     * Login user and return token.
     */
    public function login(Request $request)
{
    // Validate incoming request
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Check if the email exists
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->back()->withErrors(['email' => 'No account found with this email.']);
    }

    // Check if the password is incorrect
    if (!Hash::check($request->password, $user->password)) {
        return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
    }

    // Attempt login
    if (!Auth::attempt($credentials)) {
        return redirect()->back()->withErrors(['error' => 'Login failed. Please try again.']);
    }

    // Redirect to the profile page of the logged-in user
    return redirect("account")->with('success', 'You are now logged in and ready to launch your next successful marketing campaign!');
}

    

    /**
     * Logout user (Revoke token).
     */
    public function logout(Request $request)
    {
        // Revoke the user's tokens
        $request->user()->tokens()->delete();
        
        // Logout the user and invalidate the session
        auth()->logout();
    
        // Invalidate the session data
        $request->session()->invalidate();
    
        // Regenerate the session token to prevent session fixation attacks
        $request->session()->regenerateToken();
    
        // Redirect to home or login page with a success message
        return redirect("/")->with('success', 'User logged out successfully!');
    }
    

    
    /*forget password*/
 
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // confirmed means new_password_confirmation must match new_password
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = Auth::user(); // Get the logged-in user
    
        if (!Hash::check($request->current_password, $user->password)) {
         
            return redirect()->back()->withErrors('Current password is incorrect.')->withInput();
        }
    
        $user->password = Hash::make($request->new_password); // Hash the new password
        $user->save(); // Save the new password

        return redirect()->back()->withErrors('Password has been successfully updated.')->withInput();

    }
    
}
