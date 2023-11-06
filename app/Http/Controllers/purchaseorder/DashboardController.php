<?php

namespace App\Http\Controllers\purchaseorder;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\User;
use Session;

class DashboardController extends Controller {
    public function index() {
		if(Auth::guard('web')->check()) {
			//return view('master');
			if(Auth::user()->role_id=="4"){
			return redirect()->to('/purchaseorder/purchase-order-listing-invoice-wise');    
			}else{
			return redirect()->to('/purchaseorder/purchase-order-listing');
			}
		}
		//return view('auth.login');
	}
}

