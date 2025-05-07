<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\BlastController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\AdmSubscriptionController;

use App\Http\Controllers\Admin\AdminServiceController;

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
Route::post('/store-subscriptions', [AdmSubscriptionController::class, 'storeOrUpdateSubscription']);
Route::get('/edit-subscription/{updId}', [AdmSubscriptionController::class, 'updateSubscription']);
Route::get('/delete-subscription/{delId}', [AdmSubscriptionController::class, 'deleteSubscription']);

/** */


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

Route::get('/forgot-password', function () {
    return view('auth.Forgot-password');
});


// Route::get('/profile', function () {
//     return view('admin.pages.profile');
// });


Route::get('/blast-dashboard', function () {
    return view('admin.pages.blast-dashboard');
});

Route::get('/admin-dashboard', function () {
    return view('admin.pages.admin-dashboard');
});

Route::get('/account', function () {
    return view('admin.pages.user-account');
});

// Route::get('/subscription', function () {
//     return view('admin.pages.subscription');
// });

// Route::get('/payment-info', function () {
//     return view('admin.pages.payment');
// });


Route::get('/payment-info', [PaymentController::class,'getPaymentDetail']);

Route::get('/update-card-info/{updId}', [PaymentController::class,'updateCardDetails']);

Route::Delete('/delete-card-info/{delId}', [PaymentController::class,'deleteCardDetails']);


Route::get('/contact', function () {
    return view('admin.pages.contact');
});

Route::get('/dashboard', function () {
    return view('admin.pages.my-dashboard');
});

Route::get('/create-blast', function () {
    return view('admin.pages.create-blast');
});


// Route::get('/contact-type', function () {
//     return view('admin.pages.contact-type');
// });


Route::get('/contact-type', [ContactController::class, 'getContactType']);

Route::DELETE('/delete-contact-type/{delId}', [ContactController::class, 'deleteContactType']);

Route::get('/update-contact-type/{updId}', [ContactController::class, 'updatePopulateContactType']);


// Route::get('/my-contacts', function () {
//     return view('admin.pages.my-contacts');
// });

Route::get('/billing-payments', function () {
    return view('admin.pages.billing-payments');
});

Route::get('/my-contacts',[ContactController::class,'myContacts']);

Route::get('/my-networks', function () {
    return view('admin.pages.my-networks');
});

// Route::get('/my-template', function () {
//     return view('admin.pages.my-templates');
// });

Route::get('/my-template', [TempelateController::class ,'getTempelate']);
// Route::post('/select-template', [TempelateController::class ,'getTempelateStructure']);
Route::match(['get', 'post'], '/select-template', [TempelateController::class, 'getTempelateStructure']);

/*admin*/
Route::get('/admin-dashoard', function () {
    return view('admin.pages.admin-dashboard');
});

Route::get('/service-payments', function () {
    return view('admin.pages.service-payments');
});

Route::get('/blast-payments', function () {
    return view('admin.pages.blast-payments');
});

Route::get('/manage-subscriptions', function () {
    return view('admin.pages.manage-sub');
});

// Route::get('/create-services', function () {
//     return view('admin.pages.create-services');
// });

Route::get('create-services',[AdminServiceController::class,'getService']);
Route::post('store-service',[ServiceController::class,'storeService']);


// Route::get('/create-subscription', function () {
//     return view('admin.pages.create-sub');
// });




Route::get('/create-discount', function () {
    return view('admin.pages.create-discount');
});

Route::get('/blast-report', function () {
    return view('admin.pages.blast-report');
});


Route::get('/test', function () {
    return view('admin.pages.test');
});

/*--------------------------------------------------------------------------------------------------------*/


Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');

//Route::get('/profile/{id}', [UserController::class, 'getUserData']);

//Route::get('/profile', [UserController::class, 'getUserDataa']);

Route::get('/account', [UserController::class, 'getUserData']);


Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);


Route::get('/register', [AuthController::class, 'register']);

//Route::put('/user_meta/{id}', [UserController::class, 'updateUserMetaData']); 

Route::post('/user_meta', [UserController::class, 'storeUserMetaData']);
//Route::get('/user_meta', [UserController::class, 'storeUserMetaData']);

Route::post('/upld-profile-image', [UserController::class, 'storeProfileImage']);

Route::get('/get_user_meta', [UserController::class, 'getUserData']);



Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');


Route::post('/forget-password', [AuthController::class, 'forgetPassword']);

// In routes/web.php
Route::post('/support-ticket', [SupportTicketController::class, 'storeSupportTicket']);


Route::get('/contact', [SupportTicketController::class, 'getSupportData']);


/*-----------------------------------------------*/
Route::post('/create-blast/{id}', [BlastController::class, 'storeBlast']);
Route::post('/store-contact-type', [ContactController::class, 'storeContactType']);


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

Route::post('/add-contact', [ContactController::class, 'storeContact']);
Route::get('/update-contact/{updId}', [ContactController::class, 'updateContact']);
Route::delete('/delete-contact/{delId}', [ContactController::class, 'deleteContact']);



Route::post('/add-template', [TempelateController::class, 'storeTempelate']);
Route::post('/update-template89', [TempelateController::class, 'updateTempelatStructure']);

// Route::get('/get-tempelate', [TempelateController::class, 'getTempelate']);
// Route::get('/get-tempelate-list', [TempelateController::class, 'getTempelateList']);


Route::post('/add-resource', [TempelateController::class, 'storeResource']);
Route::get('/get-resource', [TempelateController::class, 'getResource']);


Route::post('/add-service', [ServiceController::class, 'storeService']);
Route::get('/get-service', [ServiceController::class, 'storeService']);

Route::post('/add-system-value', [ServiceController::class, 'storeSystemValue']);
Route::post('/get-system-value', [ServiceController::class, 'getSystemValue']);

Route::post('/get-system-value', [ServiceController::class, 'getSystemValue']);

// Stripe Payment Routes
Route::post('/purchase-subscription', [PaymentController::class, 'storePayment'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');