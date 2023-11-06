<?php
namespace App\Http\Controllers\financialsummary\User;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Session;

class UserController extends Controller
{
    public function index()
    {//return $fmsdata = Fmstask::where('fms_id', '=', $fms_id)->count();
        //$users=User::all();
		if(!userHasRight()){
			return redirect()->route('dashboard');
		}
		
		$users=User::where('member_id', '=', getCompanyId())->get();
		//dd($users);
        return view('financialsummary.user.userlist',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('financialsummary.user.user_register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	$user = Auth::user();
	if($request->type=='variable_expenses'){
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	$last_id = DB::table(getPrefix($user->id).'_tbl_variable_expenses')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('variable_expenses_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_variable_expenses')->where('_id',$request->id_db)->update($data);
	$arr = array('variable_expenses_id' => $request->id_db);
    return json_encode($arr);
	}
	}
	
	
	if($request->type=='fixed_expenses'){
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	$last_id = DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('fixed_expenses_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->where('_id',$request->id_db)->update($data);
	$arr = array('fixed_expenses_id' => $request->id_db);
    return json_encode($arr);
	}
	}
	
	if($request->type=='average_monthly'){
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	$last_id = DB::table(getPrefix($user->id).'_tbl_average_monthly')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('average_monthly_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_average_monthly')->where('_id',$request->id_db)->update($data);
	$arr = array('average_monthly_id' => $request->id_db);
    return json_encode($arr);
	}
	}
	
    }
	
	
	
	public function dataSubmitExpensesX(Request $request)
    {
	$user = Auth::user();
	if($request->type=='variable_expenses'){
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$rows_count = DB::table(getPrefix($user->id).'_tbl_variable_expenses_x')->where('name', $request->name_val)->count();
	if($rows_count>0){
	return 1; exit;
	}
	}
	$last_id = DB::table(getPrefix($user->id).'_tbl_variable_expenses_x')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('variable_expenses_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$exp_id = DB::table(getPrefix($user->id).'_tbl_variable_expenses')->where('name',$request->name_val)->first();
	$exp_id_oid = (array) $exp_id['_id'];
	$exp_id = $exp_id_oid['oid'];
	$data['expenses_m_id'] = $exp_id;
	}
	DB::table(getPrefix($user->id).'_tbl_variable_expenses_x')->where('_id',$request->id_db)->update($data);
	$arr = array('variable_expenses_id' => $request->id_db);
    return json_encode($arr);
	}
	}
	
	
	if($request->type=='fixed_expenses'){
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$rows_count = DB::table(getPrefix($user->id).'_tbl_fixed_expenses_x')->where('name', $request->name_val)->count();
	if($rows_count>0){
	return 1; exit;
	}
	}
	$last_id = DB::table(getPrefix($user->id).'_tbl_fixed_expenses_x')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('fixed_expenses_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$exp_id = DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->where('name',$request->name_val)->first();
	$exp_id_oid = (array) $exp_id['_id'];
	$exp_id = $exp_id_oid['oid'];
	$data['fixed_expenses_m_id'] = $exp_id;
	}
	DB::table(getPrefix($user->id).'_tbl_fixed_expenses_x')->where('_id',$request->id_db)->update($data);
	$arr = array('fixed_expenses_id' => $request->id_db);
    return json_encode($arr);
	}
	}
	
	if($request->type=='average_monthly'){
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$rows_count = DB::table(getPrefix($user->id).'_tbl_average_monthly_x')->where('name', $request->name_val)->count();
	if($rows_count>0){
	return 1; exit;
	}
	}
	$last_id = DB::table(getPrefix($user->id).'_tbl_average_monthly_x')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('average_monthly_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$exp_id = DB::table(getPrefix($user->id).'_tbl_average_monthly')->where('name',$request->name_val)->first();
	$exp_id_oid = (array) $exp_id['_id'];
	$exp_id = $exp_id_oid['oid'];
	$data['average_monthly_m_id'] = $exp_id;
	}
	DB::table(getPrefix($user->id).'_tbl_average_monthly_x')->where('_id',$request->id_db)->update($data);
	$arr = array('average_monthly_id' => $request->id_db);
    return json_encode($arr);
	}
	}
	
    }
	
	
	public function AddAprilOpeningStock(Request $request)
	{
	$user = Auth::user();
	DB::table(getPrefix($user->id).'_tbl_add_april_opening_stock')->update(array('stock_purchase_b' => $request->stock_purchase_b));
	DB::table(getPrefix($user->id).'_tbl_add_april_opening_stock_x')->update(array('stock_purchase_x' => $request->stock_purchase_x));
	//return redirect()->route('financialsummary/add-april-opening-stock');
	return redirect()->to('financialsummary/add-april-opening-stock');
	}
	
	
	
	public function AddCompany(Request $request)
	{
	$last_company_id = DB::table('tbl_add_company')->insertGetId(array('company_name' => $request->company_name,'user_id' => Auth::user()->id));
	$last_company_id_oid = (array) $last_company_id;
	$last_company_id = $last_company_id_oid['oid'];
	companyTableCreate($last_company_id);
	DB::table('users')->update(array('stock_purchase_b' => $request->stock_purchase_b));
	$data = array('company_session_id'=>$last_company_id,'all_profit_loss'=>"0");
	DB::table('users')->where('_id',Auth::user()->id)->update($data);
	return redirect()->to('financialsummary/add-company');
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
		$user = User::find($id);
        return view('financialsummary.user.user_edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update1111(Request $request, $id)
    {
		$user= User::find($id);
		$user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->uname = $request->get('uname');        
        $user->email = $request->get('email'); 
		
		request()->validate([
            'email' => 'required|email',
        ]);
		
		$user->password = Hash::make($request->get('password'));
		
		if( !empty($request->get('image')))
		{
			request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
			$imageName = time().'.'.request()->image->getClientOriginalExtension();
			request()->image->move(public_path('admin/images'), $imageName);
			$user->image = $imageName;
		}
		
        
        $user->usercontent = $request->get('usercontent'); 
		
		$user->save();
        return redirect('financialsummary/admin/userlist')->with('success', 'User has been successfully update');
    }
	
	public function update(Request $request, $id)
    {
		//dd($_POST);dd($_FILES);die;
		$this->validate($request, [
			'full_name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255'],
			'user_role' => ['required'],
        ]);
		
		$user= User::find($id);
        $user->full_name = $request->get('full_name');
        //$user->username = $request->get('username');        
        $user->email = $request->get('email'); 
        $user->phone = $request->get('phone');  
		
		if(($user->member_id) == 0 && $user->_id==getCompanyId()){
			$user->member_id=0;
		}else{
			$user->member_id = getCompanyId();
		}
		
        //$user->send_email = $request->get('send_email');
		//$user->hide_client = $request->get('hide_client');
		$user->user_role = $request->get('user_role');
		$user->fms_user_right = $request->get('fms_user_right');
		$user->access_fms_id = $request->get('access_fms_id');
		$user->pm_user = $request->get('pm_user');
		$user->user_status = 1;
		
		
		$pass = $request->get('password');
		if(!empty($pass) && $pass != $user->org_password){
				
			$user->password = Hash::make($request->get('password'));
			$user->org_password = $request->get('password');
		}
		
		//$user->last_login = ''; fms_user_right
	
		if($request->get('image')){					
			$imageName = time().'.'.request()->image->getClientOriginalExtension();
			request()->image->move(public_path('admin/images'), $imageName);
			$user->image = $imageName;
		}
		//echo '<pre>';print_r($user);die;
        $user->save();
       return redirect()->route('financialsummary/usereditpost', $id)->with('success', 'User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $user = Auth::user();
        DB::table(getPrefix($user->id).'_tbl_variable_expenses')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_average_monthly')->where('_id',$id)->delete();
		//DB::table('tbl_variable_expenses_x')->where('expenses_m_id',$id)->delete();
		//DB::table('tbl_fixed_expenses_x')->where('fixed_expenses_m_id',$id)->delete();
		//DB::table('tbl_average_monthly_x')->where('average_monthly_m_id',$id)->delete();
        echo $id;
    }
	
	    public function dataRemoveExpensesX($id)
    {
	    $user = Auth::user();
		DB::table(getPrefix($user->id).'_tbl_variable_expenses_x')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_fixed_expenses_x')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_average_monthly_x')->where('_id',$id)->delete();
        echo $id;
    }
	
	
	
	 public function ajaxExpensesX(Request $request)
    {
	    $user = Auth::user();
        $count = ($request->rowCount)+1;
		$variable_expenses_select = DB::table(getPrefix($user->id).'_tbl_variable_expenses')->orderBy('_id', 'ASC')->get();
		$html = '<tr class="variable_expenses" id="remove-'.$count.'"> <th class="hidden_th a-fa-click" id="a-'.$count.'"><div class="product"><span class="sp-a-'.$count.'" style="display:none;"></span><select cus="a-'.$count.'" class="a-'.$count.' e-'.$count.' attribute" autocomplete="off" name="row['.$count.'][name]">';
		foreach($variable_expenses_select as $expenses_dropdown){
		$row_count = DB::table(getPrefix($user->id).'_tbl_variable_expenses_x')->where('name', $expenses_dropdown["name"])->count();
		if($row_count<=0){
		$html .='<option value="'.@$expenses_dropdown["name"].'">'.@$expenses_dropdown["name"].'</option>';
		}
		}
		$html .='</select>&nbsp;<a style="padding:0px 0px !important;" id="a-'.$count.'" class="fa-submit-attribute fa-check-a-'.$count.'" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove exp-amt-a-'.$count.'" cus="'.$count.'" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></th> <input id="type-a-'.$count.'" value="variable_expenses" type="hidden" name="row['.$count.'][type]" /> <input value="" type="hidden" id="h-a-'.$count.'" name="row['.$count.'][id]" /><td class="hidden_td fa-click" id="exp-amt-'.$count.'-03_2020" align="center"><span id="s-exp-amt-'.$count.'-03_2020" style="display:none;"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e1 number exp-amt-'.$count.'-03_2020 03_2020" value="" name="row['.$count.'][03_2020]" cus="exp-amt-'.$count.'-03_2020" id="03_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-03_2020" class="fa-submit fa-check-exp-amt-'.$count.'-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-02_2020" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-02_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e2 number exp-amt-'.$count.'-02_2020 02_2020" value="" name="row['.$count.'][02_2020]" cus="exp-amt-'.$count.'-02_2020" id="02_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-02_2020" class="fa-submit fa-check-exp-amt-'.$count.'-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-01_2020" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-01_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e3 number exp-amt-'.$count.'-01_2020 01_2020" value="" name="row['.$count.'][01_2020]" cus="exp-amt-'.$count.'-01_2020" id="01_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-01_2020" class="fa-submit fa-check-exp-amt-'.$count.'-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-12_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-12_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e4 number exp-amt-'.$count.'-12_2019 12_2019" value="" name="row['.$count.'][12_2019]" cus="exp-amt-'.$count.'-12_2019" id="12_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-12_2019" class="fa-submit fa-check-exp-amt-'.$count.'-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-11_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-11_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e5 number exp-amt-'.$count.'-11_2019 11_2019" value="" name="row['.$count.'][11_2019]" cus="exp-amt-'.$count.'-11_2019" id="11_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-11_2019" class="fa-submit fa-check-exp-amt-'.$count.'-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-10_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-10_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e6 number exp-amt-'.$count.'-10_2019 10_2019" value="" name="row['.$count.'][10_2019]" cus="exp-amt-'.$count.'-10_2019" id="10_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-10_2019" class="fa-submit fa-check-exp-amt-'.$count.'-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-09_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-09_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e7 number exp-amt-'.$count.'-09_2019 09_2019" value="" name="row['.$count.'][09_2019]" cus="exp-amt-'.$count.'-09_2019" id="09_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-09_2019" class="fa-submit fa-check-exp-amt-'.$count.'-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-08_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-08_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e8 number exp-amt-'.$count.'-08_2019 08_2019" value="" name="row['.$count.'][08_2019]" cus="exp-amt-'.$count.'-08_2019" id="08_2019"/><a style="padding:0px 0px !important;" id="exp-amt-'.$count.'-08_2019" cus="exp-amt" class="fa-submit fa-check-exp-amt-'.$count.'-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-07_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-07_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e9 number exp-amt-'.$count.'-07_2019 07_2019" value="" name="row['.$count.'][07_2019]" cus="exp-amt-'.$count.'-07_2019" id="07_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-07_2019" class="fa-submit fa-check-exp-amt-'.$count.'-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-06_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-06_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e10 number exp-amt-'.$count.'-06_2019 06_2019" value="" name="row['.$count.'][06_2019]" cus="exp-amt-'.$count.'-06_2019" id="06_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-06_2019" class="fa-submit fa-check-exp-amt-'.$count.'-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-05_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-05_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e11 number exp-amt-'.$count.'-05_2019 05_2019" value="" name="row['.$count.'][05_2019]" cus="exp-amt-'.$count.'-05_2019" id="05_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-05_2019" class="fa-submit fa-check-exp-amt-'.$count.'-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-04_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-04_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="e12 number exp-amt-'.$count.'-04_2019 04_2019" value="" name="row['.$count.'][04_2019]" cus="exp-amt-'.$count.'-04_2019" id="04_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-04_2019" class="fa-submit fa-check-exp-amt-'.$count.'-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td></tr>';
		return $html;
    }
	
	
	
	public function ajaxFixedExpensesX(Request $request)
    {
	    $user = Auth::user();
        $count = ($request->rowCount)+1;
		$fixed_expenses_select = DB::table(getPrefix($user->id).'_tbl_fixed_expenses')->orderBy('_id', 'ASC')->get();
		$html = '<tr class="fixed_expenses" id="remove-'.$count.'"> <th class="hidden_th a-fa-click" id="a-'.$count.'"> <div class="product"><span class="sp-a-'.$count.'" style="display:none;"></span><select cus="a-'.$count.'" class="a-'.$count.' e-'.$count.' attribute" autocomplete="off" name="row['.$count.'][name]">';
		foreach($fixed_expenses_select as $fixed_expenses_dropdown){
		$row_count = DB::table(getPrefix($user->id).'_tbl_fixed_expenses_x')->where('name', $fixed_expenses_dropdown["name"])->count();
		if($row_count<=0){
		$html .='<option value="'.@$fixed_expenses_dropdown["name"].'">'.@$fixed_expenses_dropdown["name"].'</option>';
		}
		}
		$html .='</select>&nbsp;<a style="padding:0px 0px !important;" id="a-'.$count.'" class="fa-submit-attribute fa-check-a-'.$count.'" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove exp-amt-a-'.$count.'" cus="'.$count.'" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></th> <input id="type-a-'.$count.'" value="fixed_expenses" type="hidden" name="row['.$count.'][type]" /> <input value="" type="hidden" id="h-a-'.$count.'" name="row['.$count.'][id]" /><td class="hidden_td fa-click" id="exp-amt-'.$count.'-03_2020" align="center"><span id="f-exp-amt-'.$count.'-03_2020" style="display:none;"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f1 number exp-amt-'.$count.'-03_2020 f-03_2020" value="" name="row['.$count.'][03_2020]" cus="exp-amt-'.$count.'-03_2020" id="03_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-03_2020" class="fa-submit fa-check-exp-amt-'.$count.'-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-02_2020" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-02_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f2 number exp-amt-'.$count.'-02_2020 f-02_2020" value="" name="row['.$count.'][02_2020]" cus="exp-amt-'.$count.'-02_2020" id="02_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-02_2020" class="fa-submit fa-check-exp-amt-'.$count.'-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-01_2020" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-01_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f3 number exp-amt-'.$count.'-01_2020 f-01_2020" value="" name="row['.$count.'][01_2020]" cus="exp-amt-'.$count.'-01_2020" id="01_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-01_2020" class="fa-submit fa-check-exp-amt-'.$count.'-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-12_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-12_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f4 number exp-amt-'.$count.'-12_2019 f-12_2019" value="" name="row['.$count.'][12_2019]" cus="exp-amt-'.$count.'-12_2019" id="12_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-12_2019" class="fa-submit fa-check-exp-amt-'.$count.'-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-11_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-11_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f5 number exp-amt-'.$count.'-11_2019 f-11_2019" value="" name="row['.$count.'][11_2019]" cus="exp-amt-'.$count.'-11_2019" id="11_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-11_2019" class="fa-submit fa-check-exp-amt-'.$count.'-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-10_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-10_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f6 number exp-amt-'.$count.'-10_2019 f-10_2019" value="" name="row['.$count.'][10_2019]" cus="exp-amt-'.$count.'-10_2019" id="10_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-10_2019" class="fa-submit fa-check-exp-amt-'.$count.'-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-09_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-09_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f7 number exp-amt-'.$count.'-09_2019 f-09_2019" value="" name="row['.$count.'][09_2019]" cus="exp-amt-'.$count.'-09_2019" id="09_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-09_2019" class="fa-submit fa-check-exp-amt-'.$count.'-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-08_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-08_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f8 number exp-amt-'.$count.'-08_2019 f-08_2019" value="" name="row['.$count.'][08_2019]" cus="exp-amt-'.$count.'-08_2019" id="08_2019"/><a style="padding:0px 0px !important;" id="exp-amt-'.$count.'-08_2019" cus="exp-amt" class="fa-submit fa-check-exp-amt-'.$count.'-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-07_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-07_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f9 number exp-amt-'.$count.'-07_2019 f-07_2019" value="" name="row['.$count.'][07_2019]" cus="exp-amt-'.$count.'-07_2019" id="07_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-07_2019" class="fa-submit fa-check-exp-amt-'.$count.'-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-06_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-06_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f10 number exp-amt-'.$count.'-06_2019 f-06_2019" value="" name="row['.$count.'][06_2019]" cus="exp-amt-'.$count.'-06_2019" id="06_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-06_2019" class="fa-submit fa-check-exp-amt-'.$count.'-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-05_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-05_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f11 number exp-amt-'.$count.'-05_2019 f-05_2019" value="" name="row['.$count.'][05_2019]" cus="exp-amt-'.$count.'-05_2019" id="05_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-05_2019" class="fa-submit fa-check-exp-amt-'.$count.'-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-04_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-04_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f12 number exp-amt-'.$count.'-04_2019 f-04_2019" value="" name="row['.$count.'][04_2019]" cus="exp-amt-'.$count.'-04_2019" id="04_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-04_2019" class="fa-submit fa-check-exp-amt-'.$count.'-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> </tr>';
		return $html;
    }
	
	
	
	public function ajaxAverageExpensesX(Request $request)
    {
	    $user = Auth::user();
        $count = ($request->rowCount)+1;
		$average_monthly_select = DB::table(getPrefix($user->id).'_tbl_average_monthly')->orderBy('_id', 'ASC')->get();
		$html = '<tr class="average_monthly" id="remove-'.$count.'"> <th class="hidden_th a-fa-click" id="a-'.$count.'"> <div class="product"><span class="sp-a-'.$count.'" style="display:none;"></span><select cus="a-'.$count.'" class="a-'.$count.' e-'.$count.' attribute" autocomplete="off" name="row['.$count.'][name]">';
		
		foreach($average_monthly_select as $average_monthly_dropdown){
		$row_count = DB::table(getPrefix($user->id).'_tbl_average_monthly_x')->where('name', $average_monthly_dropdown["name"])->count();
		if($row_count<=0){
		$html .='<option value="'.@$average_monthly_dropdown["name"].'">'.@$average_monthly_dropdown["name"].'</option>';
		}
		}
		$html .='</select>&nbsp;<a style="padding:0px 0px !important;" id="a-'.$count.'" class="fa-submit-attribute fa-check-a-'.$count.'" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove exp-amt-a-'.$count.'" cus="'.$count.'" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></th> <input id="type-a-'.$count.'" value="average_monthly" type="hidden" name="row['.$count.'][type]" /> <input value="" type="hidden" id="h-a-'.$count.'" name="row['.$count.'][id]" /> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-03_2020" align="center"><span id="f-exp-amt-'.$count.'-03_2020" style="display:none;"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f1 number exp-amt-'.$count.'-03_2020 f-03_2020" value="" name="row['.$count.'][03_2020]" cus="exp-amt-'.$count.'-03_2020" id="03_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-03_2020" class="fa-submit fa-check-exp-amt-'.$count.'-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-02_2020" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-02_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f2 number exp-amt-'.$count.'-02_2020 f-02_2020" value="" name="row['.$count.'][02_2020]" cus="exp-amt-'.$count.'-02_2020" id="02_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-02_2020" class="fa-submit fa-check-exp-amt-'.$count.'-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-01_2020" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-01_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f3 number exp-amt-'.$count.'-01_2020 f-01_2020" value="" name="row['.$count.'][01_2020]" cus="exp-amt-'.$count.'-01_2020" id="01_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-01_2020" class="fa-submit fa-check-exp-amt-'.$count.'-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-12_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-12_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f4 number exp-amt-'.$count.'-12_2019 f-12_2019" value="" name="row['.$count.'][12_2019]" cus="exp-amt-'.$count.'-12_2019" id="12_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-12_2019" class="fa-submit fa-check-exp-amt-'.$count.'-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-11_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-11_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f5 number exp-amt-'.$count.'-11_2019 f-11_2019" value="" name="row['.$count.'][11_2019]" cus="exp-amt-'.$count.'-11_2019" id="11_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-11_2019" class="fa-submit fa-check-exp-amt-'.$count.'-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-10_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-10_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f6 number exp-amt-'.$count.'-10_2019 f-10_2019" value="" name="row['.$count.'][10_2019]" cus="exp-amt-'.$count.'-10_2019" id="10_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-10_2019" class="fa-submit fa-check-exp-amt-'.$count.'-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-09_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-09_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f7 number exp-amt-'.$count.'-09_2019 f-09_2019" value="" name="row['.$count.'][09_2019]" cus="exp-amt-'.$count.'-09_2019" id="09_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-09_2019" class="fa-submit fa-check-exp-amt-'.$count.'-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-08_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-08_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f8 number exp-amt-'.$count.'-08_2019 f-08_2019" value="" name="row['.$count.'][08_2019]" cus="exp-amt-'.$count.'-08_2019" id="08_2019"/><a style="padding:0px 0px !important;" id="exp-amt-'.$count.'-08_2019" cus="exp-amt" class="fa-submit fa-check-exp-amt-'.$count.'-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-07_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-07_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f9 number exp-amt-'.$count.'-07_2019 f-07_2019" value="" name="row['.$count.'][07_2019]" cus="exp-amt-'.$count.'-07_2019" id="07_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-07_2019" class="fa-submit fa-check-exp-amt-'.$count.'-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-06_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-06_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f10 number exp-amt-'.$count.'-06_2019 f-06_2019" value="" name="row['.$count.'][06_2019]" cus="exp-amt-'.$count.'-06_2019" id="06_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-06_2019" class="fa-submit fa-check-exp-amt-'.$count.'-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-05_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-05_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f11 number exp-amt-'.$count.'-05_2019 f-05_2019" value="" name="row['.$count.'][05_2019]" cus="exp-amt-'.$count.'-05_2019" id="05_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-05_2019" class="fa-submit fa-check-exp-amt-'.$count.'-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-04_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-04_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style="text-align: center;" class="f12 number exp-amt-'.$count.'-04_2019 f-04_2019" value="" name="row['.$count.'][04_2019]" cus="exp-amt-'.$count.'-04_2019" id="04_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-04_2019" class="fa-submit fa-check-exp-amt-'.$count.'-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td>  </tr>';
		return $html;
    }

	
	
}
