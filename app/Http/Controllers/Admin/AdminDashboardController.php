<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller
use App\Models\UserMetaData;
use App\Models\BlastInvoice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminDashboardController extends Controller
{
    public function showAdminDashboard(Request $request)
    {
        $user_data = UserMetaData::with('user')->get();
        $blastInvoiceData = BlastInvoice::with(['user','blast'])
            ->get();
          
        return view('admin.pages.admin-dashboard',compact('user_data','blastInvoiceData')); // Pass to view
    }
    
}