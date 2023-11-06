<?php

namespace App\Http\Controllers\financialsummary;
use App\Http\Controllers\Controller;
Use Auth;
use Illuminate\Http\Request;
Use DB;
use Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	
	    $user = Auth::user();
		$company_details = DB::table('tbl_add_company')->where('user_id', $user->id)->orderBy('company_name','ASC')->first();
		$user_details = DB::table('users')->where('_id',$user->id)->first();
        if($company_details['company_name']!=''){
		if($user_details['company_session_id']==''){
		$company_details_oid = (array) $company_details['_id'];
	    $company_details = $company_details_oid['oid'];
		$first_company_id = $company_details;
		DB::table('users')->where('_id',$user->id)->update(['company_session_id' => $first_company_id]);
		}
		$variable_expenses = DB::table(getPrefix($user->id).'_tbl_variable_expenses')->orderBy('_id', 'ASC')->get();
		$fixed_expenses = DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->orderBy('_id', 'ASC')->get();
		$average_monthly = DB::table(getPrefix($user->id).'_tbl_average_monthly')->orderBy('_id', 'ASC')->get();
		
        return view('financialsummary.admin_dashboard',['variable_expenses'=>$variable_expenses,'fixed_expenses'=>$fixed_expenses,'average_monthly' => $average_monthly]);
		}else{
		//return redirect()->route('financialsummary/add-company');
		return redirect()->to('financialsummary/add-company');
		}
	    
    }
	
	public function ajaxDropdownUpdate($id)
	{
	$user = Auth::user();
	DB::table('users')->where('_id',$user->id)->update(['company_session_id' => $id]);
	echo 1;
	}
	
	 public function expensesB(Request $request)
    {
	    $user = Auth::user();
	    $variable_expenses = DB::table(getPrefix($user->id).'_tbl_variable_expenses')->orderBy('_id', 'ASC')->get();
		$fixed_expenses = DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->orderBy('_id', 'ASC')->get();
		$average_monthly = DB::table(getPrefix($user->id).'_tbl_average_monthly')->orderBy('_id', 'ASC')->get();
		
        return view('financialsummary.expensesb_dashboard',['variable_expenses'=>$variable_expenses,'fixed_expenses'=>$fixed_expenses,'average_monthly' => $average_monthly]);
    }
	
	public function expensesX(Request $request)
	{
	    $user = Auth::user();
	    $variable_expenses = DB::table(getPrefix($user->id).'_tbl_variable_expenses_x')->orderBy('_id', 'ASC')->get();
		$variable_expenses_select = DB::table(getPrefix($user->id).'_tbl_variable_expenses')->orderBy('_id', 'ASC')->get();
		$fixed_expenses = DB::table(getPrefix($user->id).'_tbl_fixed_expenses_x')->orderBy('_id', 'ASC')->get();
		$fixed_expenses_select = DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->orderBy('_id', 'ASC')->get();
		$average_monthly = DB::table(getPrefix($user->id).'_tbl_average_monthly_x')->orderBy('_id', 'ASC')->get();
		$average_monthly_select = DB::table(getPrefix($user->id).'_tbl_average_monthly')->orderBy('_id', 'ASC')->get();
		
        return view('financialsummary.expensesx_dashboard',['variable_expenses'=>$variable_expenses,'fixed_expenses'=>$fixed_expenses,'average_monthly' => $average_monthly,'variable_expenses_select' => $variable_expenses_select,"fixed_expenses_select"=>$fixed_expenses_select,"average_monthly_select"=>$average_monthly_select]);
	}
	
	
	public function AddAprilOpeningStock(Request $request)
	{
	$user = Auth::user();
	$add_april_opening_stock = DB::table(getPrefix($user->id).'_tbl_add_april_opening_stock')->first();
	$add_april_opening_stock_x = DB::table(getPrefix($user->id).'_tbl_add_april_opening_stock_x')->first();
	return view('financialsummary.add_april_opening_stock',['add_april_opening_stock'=>$add_april_opening_stock,'add_april_opening_stock_x'=>$add_april_opening_stock_x]);
	}
	
	public function AddCompany(Request $request)
	{
	return view('financialsummary.add_company');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
