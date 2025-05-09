
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UploadController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\BlastController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\AdmSubscriptionController;
use App\Http\Controllers\Admin\AdmCouponController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**admin routes */
Route::get('/create-subscription', [AdmSubscriptionController::class, 'createSubscription']);
Route::post('/store-subscriptions', [AdmSubscriptionController::class, 'storeOrUpdateSubscription'])->name('subscription.store');
Route::any('/edit-subscription', [AdmSubscriptionController::class, 'updateSubscription']);
Route::post('/delete-subscription', [AdmSubscriptionController::class, 'deleteSubscription']);



Route::get('/service-payments', [AdmSubscriptionController::class, 'showServicePayPage']);

// Route::get('/service-payments', function () {
//     return view('admin.pages.service-payments');
// });


/*landing page */

Route::get('/landing-page', function () {
    return view('admin.pages.landing-page');
});




// Social Login Routes
Route::get('/auth/{provider}', [UserController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [UserController::class, 'handleProviderCallback']);

Route::get('/', function () {
    return view('auth.Login');
});

Route::get('/sign-up', function () {
    return view('auth.Registration');
});
Route::post('/register', [AuthController::class, 'register']);

Route::get('/verify-email', [AuthController::class, 'showVerifyPage'])
    ->middleware('auth')
    ->name('verification.notice');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified']);

 Route::get('/dashboard', [UserController::class,'showDashboardPage']);




Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // ✅ This verifies the user's email

    return redirect('/dashboard'); // Or wherever you want to redirect after verification
})->middleware(['auth', 'signed'])->name('verification.verify');







// Route::get('/forgot-password', function () {
//     return view('auth.Forgot-password');
// });

Route::get('/forgot-password', [AuthController::class, 'showForgetPassPage']);

Route::post('/send-otp', [AuthController::class, 'sendOTPForgetPassword']);


Route::match(['get','post'],'/delete-account', [AuthController::class, 'accountDelete']);



// Route::get('/profile', function () {
//     return view('admin.pages.profile');
// });


// Route::get('/blast-dashboard', function () {
//     return view('admin.pages.blast-dashboard');
// });

// Route::get('/admin-dashboard', function () {
//     return view('admin.pages.admin-dashboard');
// });

// Route::get('/account', function () {
//     return view('admin.pages.user-account');
// })->name('account');


Route::get('/login', [AuthController::class, 'loginPage'])->name('login');

Route::get('/admin-dashboard', [AdminDashboardController::class, 'showAdminDashboard']);

// Route::get('/subscription', function () {
//     return view('admin.pages.subscription');
// });

// Route::get('/payment-info', function () {
//     return view('admin.pages.payment');
// });


Route::get('/payment-info', [PaymentController::class,'getPaymentDetail']);

Route::get('/update-card-info/{updId}', [PaymentController::class,'updateCardDetails']);

Route::Delete('/delete-card-info/{delId}', [PaymentController::class,'deleteCardDetails']);

Route::post('/toggle-default-card', [PaymentController::class, 'togglePriority']);

// Route::get('/contact', function () {
//     return view('admin.pages.contact');
// });

// Route::get('/dashboard', function () {
//     return view('admin.pages.my-dashboard');
// });

// Route::get('/create-blast', function () {
//     return view('admin.pages.create-blast');
// });


// Route::get('/contact-type', function () {
//     return view('admin.pages.contact-type');
// });

Route::post('/store-contact-type', [ContactController::class, 'storeContactType']);

Route::get('/contact-type', [ContactController::class, 'getContactType']);

Route::get('/delete-contact-type/{delId}', [ContactController::class, 'deleteContactType']);

Route::get('/update-contact-type/{updId}', [ContactController::class, 'updatePopulateContactType']);


// Route::get('/my-contacts', function () {
//     return view('admin.pages.my-contacts');
// });

Route::get('/billing-payments', function () {
    return view('admin.pages.billing-payments');
});


//Route::post('/import-contacts', [ContactController::class, 'importMultipleContacts'])->name('import-contacts');
//Route::match(['get', 'post'], '/my-contacts', [ContactController::class, 'myContacts'])->name('my-contacts');
//Route::get('/my-networks', function () {
//    return view('admin.pages.my-networks');
//});

Route::get('/my-contacts', [ContactController::class, 'myContacts'])->name('my-contacts');
Route::get('/my-networks', function () {return view('admin.pages.my-networks');});

// Route::get('/my-template', function () {
//     return view('admin.pages.my-templates');
// });

Route::get('/my-template', [TempelateController::class ,'getTempelate'])->name('my-template');
//Route::post('/select-template', [TempelateController::class ,'getTempelateStructure']);
Route::match(['get', 'post'], '/select-template', [TempelateController::class, 'getTempelateStructure']);

/*admin*/
// Route::get('/admin-dashoard', function () {
//     return view('admin.pages.admin-dashboard');
// });

// Route::get('/service-payments', function () {
//     return view('admin.pages.service-payments');
// });

//for admin
Route::get('/blast-payments', function () {
    return view('admin.pages.blast-payments');
});

Route::get('/manage-subscriptions', function () {
    return view('admin.pages.manage-sub');
});

// Route::get('/create-services', function () {
//     return view('admin.pages.create-services');
// });

Route::match(['get','post'],'create-services',[AdminServiceController::class,'getService']);
Route::post('store-service',[AdminServiceController::class,'storeService']);
// Route::post('update-service',[AdminServiceController::class,'updateService']);
Route::post('delete-service',[AdminServiceController::class,'deleteService']);
Route::post('toggle-service-status',[AdminServiceController::class,'toggleServiceStatus']);



// Route::post('store-system-value',[AdminServiceController::class,'storeSystemValue']);
// Route::post('update-system-value',[AdminServiceController::class,'updateSystemValue']);
// Route::post('update-system-value',[AdminServiceController::class,'deleteSystemValue']);

// Route::get('/create-subscription', function () {
//     return view('admin.pages.create-sub');
// });


Route::match(['get','post'],'create-discount',[AdmCouponController::class,'getCouponPage']);
Route::post('store-discount',[AdmCouponController::class,'createOrUpdateCoupon']);
Route::match(['get','post'],'update-coupon',[AdmCouponController::class,'updateCpnForm']);
Route::post('delete-coupon',[AdmCouponController::class,'deleteCpn']);
Route::post('update-status',[AdmCouponController::class,'changeStatusCpn']);
Route::post('/add-footer-message',[AdmCouponController::class,'addFooterMessage']);

// Route::get('/create-discount', function () {
//     return view('admin.pages.create-discount');
// });

// Route::get('/blast-report', function () {
//     return view('admin.pages.blast-report');
// });

Route::get('/blast-report',[AdminReportController::class,'viewReportPage']);
Route::post('/filter-report',[AdminReportController::class,'filterData']);


// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/test', function () {
//         return view('admin.pages.test');
//     });
// });

Route::get('/test', [TestController::class,'testing']);

/*--------------------------------------------------------------------------------------------------------*/


Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');

//Route::get('/profile/{id}', [UserController::class, 'getUserData']);

//Route::get('/profile', [UserController::class, 'getUserDataa']);

Route::get('/account', [UserController::class, 'getUserData']);


Route::post('/login', [AuthController::class, 'login']);

Route::any('/logout', [AuthController::class, 'logout']);


Route::get('/register', [AuthController::class, 'register']);

//Route::put('/user_meta/{id}', [UserController::class, 'updateUserMetaData']); 

Route::post('/user_meta', [UserController::class, 'storeUserMetaData']);
//Route::get('/user_meta', [UserController::class, 'storeUserMetaData']);

Route::post('/upld-profile-image', [UserController::class, 'storeProfileImage']);

Route::get('/get_user_meta', [UserController::class, 'getUserData']);



Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');


Route::post('/forget-password', [AuthController::class, 'forgetPassword']);

Route::post('/verify-OTP-From-User', [AuthController::class, 'verifyOTPFromUser']);



// In routes/web.php
Route::post('/support-ticket', [SupportTicketController::class, 'storeSupportTicket']);


Route::get('/contact', [SupportTicketController::class, 'getSupportData']);

Route::post('/store-issue-type', [SupportTicketController::class, 'addIssueType']);



/*-----------------------------------------------*/
Route::post('/store-blast', [BlastController::class, 'storeBlast']);

Route::get('/create-blast', [BlastController::class, 'createBlast']);

Route::post('/fetch-contacts-according-to-contactType', [BlastController::class, 'getContactUsingContType']);
Route::post('/save-structure-to-blast-tbl', [BlastController::class, 'storeTempStructureToBlastTbl']);

Route::post('/get-temp-structure-using-id', [BlastController::class, 'getTempStructUsingId']);

Route::post('/store-keyword-in-db', [BlastController::class, 'storeKeywordsToDB']);

Route::post('/enhance-prompt', [BlastController::class, 'enhancePrompt']);





Route::get('/subscription', [SubscriptionController::class, 'getSubscriptionData']);



Route::post('/add-to-list', [SubscriptionController::class, 'subscriptionAddToList']);

Route::get('/get-card-details', [PaymentController::class, 'storeCoupon']);
Route::post('/add-card-detail', [PaymentController::class, 'storeOrUpdateCardDetail']);
Route::post('/purchase-subscription', [PaymentController::class, 'storeOrUpdateCardDetailAndPay']);


Route::post('/add-coupon', [PaymentController::class, 'storeCoupon']);
Route::get('/add-coupon', [PaymentController::class, 'storeCoupon']);


Route::post('/add-contact-type', [ContactController::class, 'storeContactType']);

Route::get('/get-contact-type', [ContactController::class, 'getContactType']);

Route::post('/import-contact-list', [ContactController::class, 'storeMultipleContacts']);

Route::post('/add-contact', [ContactController::class, 'storeOrUpdateContact']);

Route::get('/update-contact/{updId}', [ContactController::class, 'updateContact']);
Route::match(['get','post'],'/delete-contact/{delId}', [ContactController::class, 'deleteContact']);



Route::post('/add-template', [TempelateController::class, 'storeTempelate']);
Route::post('/update-template-new', [TempelateController::class, 'updateTempelatStructure'])->name('update-template-new');
// Route::post('/update-template-new', function(){
//     return "hi";
// })->name('update-template-new');

// Route::get('/get-tempelate', [TempelateController::class, 'getTempelate']);
// Route::get('/get-tempelate-list', [TempelateController::class, 'getTempelateList']);


Route::post('/add-resource', [TempelateController::class, 'storeResource']);
Route::post('/store-link', [TempelateController::class, 'storeResourceLink']);
Route::post('/store-media', [TempelateController::class, 'storeResourceMedia']);
Route::post('/delete-resource', [TempelateController::class, 'deleteResource']);




Route::get('/get-resource', [TempelateController::class, 'getResource']);


// Route::post('/add-service', [ServiceController::class, 'storeService']);
// Route::get('/get-service', [ServiceController::class, 'storeService']);

Route::post('/add-system-value', [ServiceController::class, 'storeSystemValue']);
Route::post('/get-system-value', [ServiceController::class, 'getSystemValue']);

Route::post('/get-system-value', [ServiceController::class, 'getSystemValue']);

// Stripe Payment Routes
Route::post('/purchase-subscription', [PaymentController::class, 'storePayment'])->name('payment.process');
//test
Route::post('/save-plan-subscription', [PaymentController::class, 'savePlanSubscription']);


Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

Route::put('/delete-template/{id}', [TempelateController::class, 'deleteTempelate'])->name('delete-template');


Route::post('/send-opt-to-verify-email', [AuthController::class, 'sendOTPtoVerifyEmail']);


// linkedin message

Route::get('/make-it-blast/auth/linkedin', [UserController::class, 'redirectToLinkedIn']);
Route::get('/make-it-blast/auth/linkedin/callback', [UserController::class, 'handleLinkedInCallback']);
Route::post('/linkedin/send-message', [UserController::class, 'sendLinkedInMessage']);



Route::post('/linkedin/post', [UserController::class, 'sendLinkedInMessage'])->name('linkedin.post');
// Redirect to LinkedIn
Route::get('/linkedin/redirect', function () {
return Socialite::driver('linkedin')->scopes(['r_liteprofile', 'w_member_social'])->redirect();
});
// Callback after LinkedIn login
Route::get('/auth/linkedin/callback', [UserController::class, 'handleLinkedInCallback']);



Route::post('process-payment-and-subscription', [PaymentController::class, 'processPaymentAndSubscription'])->name('process-payment-and-subscription');

Route::get('/auth/linkedin/redirect', [UserController::class, 'redirectToLinkedIn'])->name('linkedin.redirect');
Route::get('/auth/linkedin/callback', [UserController::class, 'handleLinkedInCallback'])->name('linkedin.callback');


//send Emails

Route::post('/send-emails', [TestController::class, 'testEmail']);


//adding issue type from admin
Route::match(['get','post'],'/support-tickets', [SupportTicketController::class, 'getIssueTypes']);
Route::post('/update-status-types', [SupportTicketController::class, 'updateIssueType']);
Route::post('/delete-issue-types', [SupportTicketController::class, 'deleteIssueType']);

Route::post('/update-support-status', [SupportTicketController::class, 'updateSupportStatus']);

Route::post('/update-subscription-status', [SubscriptionController::class, 'updateSubscriptionStatus']);

Route::post('/store-or-update-card-detail', [PaymentController::class, 'storeOrUpdateCardDetail'])->name('store-or-update-card-detail');

Route::post('/store-service', [AdminServiceController::class, 'storeOrUpdateService']);


Route::get('/admin-tempelate', function () {
    return view('admin.pages.admin-tempelate');
});

Route::get('/admin-login', function () {
    return view('admin.pages.admin-login');
});


Route::post('/contacts/update-inline', [ContactController::class, 'updateInline']);

Route::get('/store-replies', [ContactController::class, 'storeRepliesPageView']);

Route::post('/store-replies-db', [ContactController::class, 'storeRepliesOfCustomers']);

Route::post('/fetch-contact-according-contactType', [ContactController::class, 'fetchContactAccordingContactType']);

Route::get('/download-replies', [BlastController::class, 'downloadReplies']);
