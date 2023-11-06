<?php

namespace App\Http\Controllers;
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
			//pr(Auth::id()); die;
			//return redirect()->to('/dashboard');
			return view('master');
		}
		return view('auth.login');
	}
}

