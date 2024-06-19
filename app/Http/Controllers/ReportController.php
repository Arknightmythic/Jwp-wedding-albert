<?php

namespace App\Http\Controllers;

use App\Models\PackageBooking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $paidBookingsCount = PackageBooking::where('is_paid', true)->count();
        return view('dashboard', compact('paidBookingsCount'));
    }
}
