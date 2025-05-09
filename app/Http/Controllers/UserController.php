<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SocialMediaLogin;
use App\Models\UserMetaData;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SubscriptionConnUser;
use App\Models\Blast;
use App\Models\BlastAnswer;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //social media login
    // Allowed providers
    protected $validProviders = ['google', 'facebook', 'apple'];

    // Redirect to Provider
    public function redirectToProvider($provider)
    {
        // Check if the provider is valid
        if (!in_array($provider, $this->validProviders)) {
            return redirect('/login')->with('error', 'Invalid provider selected!');
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to connect to ' . ucfirst($provider) . '. Please try again later.');
        }
    }

    // Handle Provider Callback
    public function handleProviderCallback($provider)
    {
        // Check if the provider is valid
        if (!in_array($provider, $this->validProviders)) {
            return redirect('/login')->with('error', 'Invalid provider.');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();

            if (!$socialUser || !$socialUser->getEmail()) {
                return redirect('/login')->with('error', 'Failed to retrieve user information.');
            }

            // Check if the user already exists
            $user = User::where('email', $socialUser->getEmail())->first();

            // If the user does not exist, create a new user
            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt('default_password'), // Default password (change later)
                    'status' => 'incomplete',
                ]);
            }

            // Check if social media login record exists
            $socialLogin = SocialMediaLogin::where([
                'user_id' => $user->id,
                'provider' => $provider,
            ])->first();

            // If social login does not exist, create one
            if (!$socialLogin) {
                SocialMediaLogin::create([
                    'user_id' => $user->id,
                    'provider' => $provider,
                    'provider_user_id' => $socialUser->getId(),
                ]);
            }

            if ($user->status !== 'deleted') {
                Auth::login($user);
            } else {
                // Handle the case where the user is deleted
                return redirect('/')->withErrors(['account' => 'This account has been deleted.']);
            }

            // Redirect to dashboard
            return redirect('/account')->with('success', 'Logged in successfully!');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /*store user meta data  */
    public function storeUserMetaData(Request $request) {
        try {
            print_r($request->all());
            
            // Validation
            $validator = Validator::make($request->all(), [
                'company_name'    => 'required|string|max:255',
                'address'         => 'required|string|max:500',
                'zipcode'         => 'required|numeric|digits_between:5,10',
                'city'            => 'required|string|max:255',
                'state'           => 'required|string|max:255',
                'country'         => 'required|string|max:255',
                'phno'            => 'required|string|max:14',
                'first_name'      => 'required|string|max:100',
                'last_name'       => 'required|string|max:100',
                'billing_email'   => 'required|email|max:255|confirmed',
                'avatar'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $curr_userId = auth()->id();
    
            // Load existing data
            $existingMeta = UserMetaData::where('user_id', $curr_userId)->first();
            $existingUser = User::find($curr_userId);
    
            // Prepare new data
            $newMetaData = [
                'company_name'   => $request->input('company_name'),
                'address'        => $request->input('address'),
                'zipcode'        => $request->input('zipcode'),
                'city'           => $request->input('city'),
                'state'          => $request->input('state'),
                'country'        => $request->input('country'),
                'billing_email'  => $request->input('billing_email'),
                'avatar'         => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : ($existingMeta->avatar ?? null),
                'user_id'        => $curr_userId,
                'status'         => 'active',
            ];
    
            $newUserData = [
                'mobile_number'  => $request->input('phno'),
                'name'           => $request->input('first_name'),
                'last_name'      => $request->input('last_name'),
                'status'         => 'complete'
            ];
    
            // Compare changes
            $metaChanged = !$existingMeta || collect($newMetaData)->except('avatar')->diffAssoc($existingMeta->toArray())->isNotEmpty();
            $userChanged = collect($newUserData)->diffAssoc($existingUser->only(array_keys($newUserData)))->isNotEmpty();
    
            if (!$metaChanged && !$userChanged) {
                return redirect()->back()->with('error', 'Nothing to update.');
            }
    
            // Update or create user meta
            UserMetaData::updateOrCreate(
                ['user_id' => $curr_userId],
                $newMetaData
            );
    
            // Update user table only if data changed
            if ($userChanged) {
                $existingUser->update($newUserData);
            }
    
            return redirect('dashboard')->with('success', 'User information updated successfully!');
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Some critical error: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
     
   
// public function storeProfileImage(Request $request)
// {
//     // Validate the uploaded file
//     $request->validate([
//         'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Only images, max 2MB
//     ]);


  
//             if ($validator->fails()) {
//                 return redirect()->back()->withErrors($validator)->withInput();
//             }
//     // Get the authenticated user
//     $user = auth()->user(); // Get the authenticated user

//     // Handle the file upload
//     if ($request->hasFile('avatar')) {
//         // Store the image in the 'avatars' directory in the storage folder
//         // 'public' disk is usually linked to storage/app/public via `php artisan storage:link`
//         $imagePath = $request->file('avatar')->store('avatars', 'public/media'); 

//         // Update the user's profile image in the UserMetaData model
//         // Assuming the user has a related UserMetaData model that holds the avatar field
//         $userMetaData = $user->userMetaData; // Get the related UserMetaData (assuming a one-to-one relation)

//         if ($userMetaData) {
//             // If UserMetaData exists, update the avatar field with the new image
//             // Optionally, delete the old image if needed
//             if ($userMetaData->avatar && Storage::disk('public')->exists($userMetaData->avatar)) {
//                 Storage::disk('public')->delete($userMetaData->avatar); // Delete the old avatar if necessary
//             }

//             // Update the avatar path
//             $userMetaData->avatar = $imagePath;
//             $userMetaData->save(); // Save the updated user meta data
//         }else{
//             return redirect()->back()->withErrors('user not found to addd the profile')->withInput();
//         } 
//     }

//     // Redirect back with a success message
//     return redirect()->back()->with('success', 'Profile image updated successfully!');
// }
    

// public function storeProfileImage(Request $request){
//     // Validate the uploaded file
  
//     $validator = Validator::make($request->all(), [
//         'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Only images, max 2MB
//     ]);
  
//             if ($validator->fails()) {
//                 return redirect()->back()->withErrors($validator)->withInput();
//             }
//     // Get the authenticated user
//     $user = auth()->user(); // Get the authenticated user

// print_r($request->avatar['originalName']);
// }

public function storeProfileImage(Request $request)
{
    try {
        // Validate the uploaded image if present
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // If validation fails, return a response with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the current user's ID
        $userId = auth()->id();

        // Check if an image is uploaded
        if ($request->hasFile('avatar')) {
            // Generate a unique name for the image
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();

            // Move the image to the public directory
            $request->avatar->move(public_path('usr_profile_images'), $imageName);
        } else {
            $imageName = null; // Store null if no image is uploaded
        }

        // Update the UserMetaData model
        $storeAvatar = UserMetaData::updateOrCreate(
            ['user_id' => $userId],
            ['avatar' => $imageName]
        );

        // Optionally, you can return a response or do something else
        if ($storeAvatar) {
            return redirect()->back()->with('success', 'Avatar updated successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Profile image not added']);
        }
    } catch (\Exception $e) {
        // If an error occurs
        return redirect()->back()
            ->withErrors(['error' => 'Some critical error: ' . $e->getMessage()])
            ->withInput();
    }
}


    

    public function getUserData(Request $request) {
      
        $user = auth()->user();
        if (!$user) {
            return redirect('/')->withErrors('user not found');
        }
        

        $pre_email = $user->email;
        $pre_phno = $user->mobile_number;
        $pre_name = $user->name;
        $pre_last = $user->last_name;
       
         $userMetaData = UserMetaData::where('user_id', $user->id)->first();
        
        $userMetaData['pre_name'] = $pre_name;
        $userMetaData['pre_last'] = $pre_last; 
        $userMetaData['pre_email'] = $pre_email;
        $userMetaData['pre_phno'] = $pre_phno;

       //print_r($userMetaData);

        return view('admin.pages.user-account', [
            'userMetaData' => $userMetaData     ])->with('success', 'Account details loaded successfully!');
        
    }
    



    //sedning data to dashboard view

    public function showDashboardPage(){

        $cid = auth()->id();

        $subscriptionData = SubscriptionConnUser::where('user_id', $cid)
            ->with(['subscription', 'payment'])
            ->get();

        $userBlastData = Blast::where('user_id', $cid)->get();

        $availableAnswere = BlastAnswer::with(['contact', 'question.blast']) // include contact and blast
        ->whereHas('contact.user', function ($query) use ($cid) {
            $query->where('id', $cid);
        })
        ->get();

      

        return view('admin.pages.my-dashboard', compact('subscriptionData','userBlastData','availableAnswere'));

    }

}
