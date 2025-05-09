<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserMetaData;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
class AuthController extends Controller
{/**
     * Register a new user.
     */
   
   
public function register(Request $request)
{
   
    try {
        print_r($request->country_code);
        
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'last_name' => 'string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email', // Validate unique email
            'password' => [
                'required',
                'string',
                'min:8', // Minimum 8 characters
                'confirmed',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'], // Password must match the password_confirmation field
            'mobile_number' => 'required|string', // Validate mobile number
            'country_code' => ['required', 'regex:/^\+\d{1,3}$/'],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
      
       // email sender
    //    $response = $this->post_newsletter($request->email);
    //    print_r($response);
       //die();

       
       //$store_otp = $response['otp'];
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'mobile_number' => $request->mobile_number, // Store the mobile number
            'country_code' => $request->country_code,
            'status' => 'incomplete',
            'user_role' => 'user',
            //'otp' => $response['otp'],
        ]);
       
        event(new Registered($user));
        // Log the user in immediately after registration
        Auth::login($user);

      
        // Redirect to the profile page
        return redirect('verify-email')->with('success', 'You are now logged in and ready to launch your next successful marketing campaign!');
    
    
    } catch (\Exception $e) {
        return redirect()->back()
        ->withErrors(['error' => 'User Not Registered: ' . $e->getMessage() . ' Line number: ' . $e->getLine()])
        ->withInput();
    }
}

public function showVerifyPage(){
    return view('admin.pages.verify-email');
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

    // Attempt to authenticate the user
    $user = User::where('email', $credentials['email'])->first();

    if (!$user || $user->status === 'deleted' || !Auth::attempt($credentials)) {
        return redirect()->back()->withErrors(['error' => 'Invalid credentials or account deleted.']);
    }

    $user = Auth::user();

    // // Check if user is verified
    // if (is_null($user->verified_at)) {
    //     Auth::logout(); // Logout immediately
    //     return redirect()->back()->withErrors(['error' => 'Your account is not verified.']);
    // }

    // Redirect based on user status
    if ($user->status === 'complete') {
        return redirect('dashboard')->with('success', 'You are now logged in and ready to launch your next successful marketing campaign!');
    } else {
        return redirect('account')->with('success', 'You are now logged in and ready to launch your next successful marketing campaign!');
    }
}



	public function loginPage(Request $request){
		return view('admin.pages.user-account');
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
    

    
    /*forget password old*/
    // public function forgetPassword(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'current_password' => 'required|string',
    //         'new_password' => 'required|string|min:8|confirmed',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    
    //     $user = Auth::user();
    
    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return redirect()->back()->withErrors('Current password is incorrect.')->withInput();
    //     }
    
    //     $user->password = Hash::make($request->new_password);
    //     $user->save();
    
    //     Auth::logout();
    
    //     return redirect()->route('login')->with('status', 'Password changed successfully. Please log in again.');
    // }


    public function showForgetPassPage(Request $request){
        return view('auth.Forgot-password');
    }

    //SEND OTP TO FORGET PASSWORD
    public function sendOTPForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forgot_email' => 'required|email|exists:users,email',
        ]);
        
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 200); // Use 422 for validation errors
        }

        $otp = rand(1000, 9999);
        $user = User::where('email', $request->forgot_email)->first();

        if ($user) {
            $user->otp = $otp;
            $user->save();
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Error generating otp.'
            ],200);
        }
        
    
        $sedOTP = $this->sendOTPEmail($request->forgot_email,$otp);
       
    
        if ($sedOTP) {
            return response()->json([
                'status' => true,
                'message' => 'OTP sent to your email.'
            ],200);
        } else {
            return response()->json([
                'status' =>false,
                'message' => 'Again send the OTP , something went wrong'
            ],200);
        }
    }
    

    public function sendOTPEmail($userEmail,$otp)
    {
        try {
            $mail = new PHPMailer(true);
 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nextupgradwebsolutions@gmail.com';
            $mail->Password = 'rdbq zljz cyrf dtsc'; // Use an app password from Gmail, not your regular password
            $mail->SMTPSecure = 'tls'; // Use 'ssl' if using port 465
            $mail->Port = 587;
 
            $mail->setFrom('developer11.nextupgrad@gmail.com', 'NextUpgrad Web Solutions');
            $mail->addAddress($userEmail);
            $mail->addBCC('akansha.nextupgrad@gmail.com');
 
            $mail->isHTML(true);
            $mail->Subject = 'Forget Password';
            
           

            $mail->Body = 'Your OTP is :  '.$otp;
           
            if (!$mail->send()) {
               
                return false;
            } else {
             
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

  //change user password with otp
  public function verifyOTPFromUser(Request $request)
  {
      try {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'digits:4'],
            'user_email' => [
                'required',
                'email',
                'exists:users,email' // Check if email exists in the users table
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/'
            ],
        ]);
        
  
          if ($validator->fails()) {
              return redirect()->back()
                  ->withErrors($validator)
                  ->withInput();
          }
  
          $findUser = User::where('email', $request->user_email)->first();
  
          if (!$findUser) {
              return redirect()->back()
                  ->with('error', 'User not found.')
                  ->withInput();
          }
  
          if (Carbon::now()->diffInMinutes($findUser->updated_at) > 15) {
              return redirect()->back()
                  ->with('error', 'OTP has expired.')
                  ->withInput();
          }
  
          if ((string) $findUser->otp !== (string) $request->otp) {
              return redirect()->back()
                  ->with('error', 'OTP is incorrect.')
                  ->withInput();
          }
  
          // Update password
          $findUser->password = Hash::make($request->new_password);
          $findUser->save();
  
          return redirect()->route('login')->with('success', 'Password changed successfully.');
  
      } catch (\Exception $e) {
          return redirect()->back()
              ->with('error', 'An unexpected error occurred: ' . $e->getMessage())
              ->withInput();
      }
  }
  

 
 

    public function forgetPassword(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
    }

    // Check if the new password is the same as the current password
    if (Hash::check($request->new_password, $user->password)) {
        return redirect()->back()->withErrors(['new_password' => 'New password cannot be the same as the current password.'])->withInput();
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    Auth::logout();

    return redirect()->route('login')->with('status', 'Password changed successfully. Please log in again.');
}

    

    public function accountDelete(Request $request)
    {
        $curr_userId = auth()->id();
        $user = User::find($curr_userId);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User ID not found');
        }
    
        // Deactivate the current user's account
        $user->status = 'deleted';
        $user->save();
    
        // Log the user out (optional, if you're deactivating)
        auth()->logout();
    
        return redirect('/')->with('success', 'Account deactivated successfully');
    }
    
    
}
