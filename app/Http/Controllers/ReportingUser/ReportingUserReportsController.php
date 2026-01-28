<?php

namespace App\Http\Controllers\ReportingUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportingUserReportsController extends Controller
{
    public function index()
    {
        return view('reporting-user.reports.index');
    }

    // Department
}
