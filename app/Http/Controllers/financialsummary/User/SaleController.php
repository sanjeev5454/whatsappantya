<?php

namespace App\Http\Controllers\financialsummary\User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

class SaleController extends Controller
{
    public function index()
    {
	    $user = Auth::user();
		$sales = DB::table(getPrefix($user->id).'_tbl_sales')->orderBy('_id', 'ASC')->get();
        return view('financialsummary.user.sale',['sales'=>$sales]);
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
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	$last_id = DB::table(getPrefix($user->id).'_tbl_sales')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('sales_id' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_sales')->where('_id',$request->id_db)->update($data);
	$arr = array('sales_id' => $request->id_db);
    return json_encode($arr);
	}
	
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
	
	public function dataSubmitSalesAttribute(Request $request)
	{
	$user = Auth::user();
	foreach($request->row as $val){
	if($val['id']==''){
	$last_id = DB::table(getPrefix($user->id).'_tbl_sales')->insertGetId($val);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('sales_id' => $last_id);
    return json_encode($arr);
	}else{
	DB::table(getPrefix($user->id).'_tbl_sales')->where('_id',$val['id'])->update($val);
	DB::table(getPrefix($user->id).'_tbl_sales')->where('_id',$val['id'])->update(array('name'=>$val['name']));
	}
	}
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
		DB::table(getPrefix($user->id).'_tbl_sales')->where('_id',$id)->delete();
        echo $id;
    }
	
	
	
}
