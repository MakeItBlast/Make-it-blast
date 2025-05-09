<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import Base Controller
use App\Models\UserMetaData;
use App\Models\BlastInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdmDashboardController extends Controller
{
    public function showAdmDashboard(Request $request)
    {
        $user_data = UserMetaData::get(); // Fetch data

        $blastInvoiceData = BlastInvoice::with(['user', 'blast'])
        ->get();
        
        return view('admin.pages.admin-dashboard', compact('user_data','blastInvoiceData')); // Pass to view
    }
    
}