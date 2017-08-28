<?php

namespace App\Http\Controllers\Backend;

use DB;
use App\Http\Controllers\CommonController as Common;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brands;
use App\Models\Models;
use App\Models\ModelDetails;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function index()
    {
    	$totalBrands 		= Brands::count();
        $totalModels         = Models::count();
    	$totalModelDetails 		= ModelDetails::count();
    	return view("admin.dashboard",compact("totalBrands","totalModels","totalModelDetails"));
    }
}
