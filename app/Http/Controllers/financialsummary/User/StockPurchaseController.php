<?php

namespace App\Http\Controllers\financialsummary\User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

class StockPurchaseController extends Controller
{
    public function index()
    {
	    $user = Auth::user();
		$opening_stock = DB::table(getPrefix($user->id).'_tbl_opening_stock')->orderBy('_id', 'ASC')->get();
		$purchases = DB::table(getPrefix($user->id).'_tbl_purchases')->orderBy('_id', 'ASC')->get();
		$closing_stock = DB::table(getPrefix($user->id).'_tbl_closing_stock')->orderBy('_id', 'ASC')->get();
		//dd($users);
        return view('financialsummary.user.stock_purchase',['opening_stock'=>$opening_stock,'purchases'=>$purchases,'closing_stock' => $closing_stock]);
    }
	
	
	public function StockPurchaseB()
    {
	    $user = Auth::user();
		$opening_stock = DB::table(getPrefix($user->id).'_tbl_opening_stock')->orderBy('_id', 'ASC')->get();
		$purchases = DB::table(getPrefix($user->id).'_tbl_purchases')->orderBy('_id', 'ASC')->get();
		$closing_stock = DB::table(getPrefix($user->id).'_tbl_closing_stock')->orderBy('_id', 'ASC')->get();
		//dd($users);
        return view('financialsummary.user.stock_purchase_b',['opening_stock'=>$opening_stock,'purchases'=>$purchases,'closing_stock' => $closing_stock]);
    }
	
	public function StockPurchaseX()
    {
	    $user = Auth::user();
		$opening_stock = DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->orderBy('_id', 'ASC')->get();
		$opening_stock_select = DB::table(getPrefix($user->id).'_tbl_opening_stock')->orderBy('_id', 'ASC')->get();
		$purchases = DB::table(getPrefix($user->id).'_tbl_purchases_x')->orderBy('_id', 'ASC')->get();
		$purchases_select = DB::table(getPrefix($user->id).'_tbl_purchases')->orderBy('_id', 'ASC')->get();
		//dd($users);
        return view('financialsummary.user.stock_purchase_x',['opening_stock'=>$opening_stock,'purchases'=>$purchases,'opening_stock_select'=>$opening_stock_select,'purchases_select'=>$purchases_select]);
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
	$last_id = DB::table(getPrefix($user->id).'_tbl_opening_stock')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$data2 = array("opening_stock_id"=>$last_id);
	$last_purchase_id = DB::table(getPrefix($user->id).'_tbl_purchases')->insertGetId($data2);
	$oid_p = (array) $last_purchase_id;
	$last_purchase_id = $oid_p['oid'];
	$last_closing_id = DB::table(getPrefix($user->id).'_tbl_closing_stock')->insertGetId($data2);
	$oid_c = (array) $last_closing_id;
	$last_closing_id = $oid_c['oid'];
	$arr = array('opening_stock' => $last_id,'purchases' => $last_purchase_id,'closing' => $last_closing_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_opening_stock')->where('_id',$request->id_db)->update($data);
	if($request->s_id!='' && $request->items_number_sl1!='' && $request->items_y!=''){
	$data_p = array($request->items_number_sl1.'_'.$request->items_y => $request->name_val);
	DB::table(getPrefix($user->id).'_tbl_opening_stock')->where('_id',$request->s_id)->update($data_p);
	}
	DB::table(getPrefix($user->id).'_tbl_purchases')->where('_id',$request->id_db)->update($data);
	DB::table(getPrefix($user->id).'_tbl_closing_stock')->where('_id',$request->id_db)->update($data);
	$purchase_details = DB::table(getPrefix($user->id).'_tbl_purchases')->where('opening_stock_id',$request->id_db)->first();
	$oid_p = (array) $purchase_details['_id'];
	$last_purchase_id = $oid_p['oid'];
	$closing_details = DB::table(getPrefix($user->id).'_tbl_closing_stock')->where('opening_stock_id',$request->id_db)->first();
	$oid_c = (array) $closing_details['_id'];
	$last_closing_id = $oid_c['oid'];
	$arr = array('opening_stock' => $request->id_db,'purchases' => $last_purchase_id,'closing' => $last_closing_id);
    return json_encode($arr);
	}
	}
	
	
	
	public function dataSubmitStockX(Request $request)
    {
	$user = Auth::user();
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$rows_count = DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('name', $request->name_val)->count();
	if($rows_count>0){
	return 1; exit;
	}
	}
	$last_id = DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$data2 = array("opening_stock_id"=>$last_id);
	$last_purchase_id = DB::table(getPrefix($user->id).'_tbl_purchases_x')->insertGetId($data2);
	$oid_p = (array) $last_purchase_id;
	$last_purchase_id = $oid_p['oid'];
	$arr = array('opening_stock' => $last_id,'purchases' => $last_purchase_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('_id',$request->id_db)->update($data);
	if($request->s_id!='' && $request->items_number_sl1!='' && $request->items_y!=''){
	$data_p = array($request->items_number_sl1.'_'.$request->items_y => $request->name_val);
	DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('_id',$request->s_id)->update($data_p);
	}
	DB::table(getPrefix($user->id).'_tbl_purchases_x')->where('_id',$request->id_db)->update($data);
	$purchase_details = DB::table(getPrefix($user->id).'_tbl_purchases_x')->where('opening_stock_id',$request->id_db)->first();
	$oid_p = (array) $purchase_details['_id'];
	$last_purchase_id = $oid_p['oid'];
	$arr = array('opening_stock' => $request->id_db,'purchases' => $last_purchase_id);
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
	
	public function dataSubmitStockAttribute(Request $request)
	{
	$user = Auth::user();
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	$last_id = DB::table(getPrefix($user->id).'_tbl_opening_stock')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$data2 = array("opening_stock_id"=>$last_id,$request->column_name=>$request->name_val);
	$arr = array('opening_stock' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_opening_stock')->where('_id',$request->id_db)->update($data);
	$arr = array('opening_stock' => $request->id_db);
    return json_encode($arr);
	}
	}
	
	
	
	public function dataSubmitStockAttributeX(Request $request)
	{
	$user = Auth::user();
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$rows_count = DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('name', $request->name_val)->count();
	if($rows_count>0){
	return 1; exit;
	}
	}
	$last_id = DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('opening_stock' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('_id',$request->id_db)->update($data);
	$arr = array('opening_stock' => $request->id_db,'purchases' => $last_purchase_id);
    return json_encode($arr);
	}
	}
	
	
	
	
	public function dataSubmitStockAttributePurchase(Request $request)
	{
	$user = Auth::user();
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	$last_id = DB::table(getPrefix($user->id).'_tbl_purchases')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('opening_stock' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_purchases')->where('_id',$request->id_db)->update($data);
	$arr = array('opening_stock' => $request->id_db);
    return json_encode($arr);
	}
	}
	
	
	public function dataSubmitStockAttributePurchaseX(Request $request)
	{
	$user = Auth::user();
	if($request->id_db=='')
	{
	$data = array($request->column_name=>$request->name_val);
	if($request->column_name=='name'){
	$rows_count = DB::table(getPrefix($user->id).'_tbl_purchases_x')->where('name', $request->name_val)->count();
	if($rows_count>0){
	return 1; exit;
	}
	}
	$last_id = DB::table(getPrefix($user->id).'_tbl_purchases_x')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('opening_stock' => $last_id);
    return json_encode($arr);
	}else{
	$data = array($request->column_name=>$request->name_val);
	DB::table(getPrefix($user->id).'_tbl_purchases_x')->where('_id',$request->id_db)->update($data);
	$arr = array('opening_stock' => $request->id_db);
    return json_encode($arr);
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
		DB::table(getPrefix($user->id).'_tbl_opening_stock')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_purchases')->where('opening_stock_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_purchases')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_closing_stock')->where('opening_stock_id',$id)->delete();
        echo $id;
    }
	
	public function dataRemoveStockX($id)
    {
	    $user = Auth::user();
		DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('_id',$id)->delete();
		DB::table(getPrefix($user->id).'_tbl_purchases_x')->where('_id',$id)->delete();
        echo $id;
    }
	
	
	public function ajaxStockAttributePurchaseX(Request $request)
	{
	    $user = Auth::user();
	    $count = ($request->rowCount)+1;
		$opening_stock_select = DB::table(getPrefix($user->id).'_tbl_opening_stock')->orderBy('_id', 'ASC')->get();
		$html = '<tr class="opening_stock" id="remove-'.$count.'"> <th class="hidden_th a-fa-click" id="a-'.$count.'"> <div class="product"><span class="sp-a-'.$count.'" style="display:none;"></span><select cus="a-'.$count.'" class="a-'.$count.' e-'.$count.' attribute" autocomplete="off" name="row['.$count.'][name]">';
		foreach($opening_stock_select as $opening_stock_dropdown){
		$row_count = DB::table(getPrefix($user->id).'_tbl_closing_stock_x')->where('name', $opening_stock_dropdown["name"])->count();
		if($row_count<=0){
		$html .='<option value="'.@$opening_stock_dropdown["name"].'">'.@$opening_stock_dropdown["name"].'</option>';
		}
		}
		$html .= '</select>&nbsp;<a style="padding:0px 0px !important;" id="a-'.$count.'" class="fa-submit-attribute fa-check-a-'.$count.'" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove exp-amt-a'.$count.'" cus="'.$count.'" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></th><input value="" type="hidden" id="h-a-'.$count.'" name="row['.$count.'][id]" /> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-03_2020" align="center"><span id="s-exp-amt-'.$count.'-03_2020" style="display:none;"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e1 number exp-amt-'.$count.'-03_2020 03_2020" value="" name="row['.$count.'][03_2020]" cus="exp-amt-'.$count.'-03_2020" id="03_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-03_2020" class="fa-submit fa-check-exp-amt-'.$count.'-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-02_2020" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-02_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e2 number exp-amt-'.$count.'-02_2020 02_2020" value="" name="row['.$count.'][02_2020]" cus="exp-amt-'.$count.'-02_2020" id="02_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-02_2020" class="fa-submit fa-check-exp-amt-'.$count.'-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-01_2020" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-01_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e3 number exp-amt-'.$count.'-01_2020 01_2020" value="" name="row['.$count.'][01_2020]" cus="exp-amt-'.$count.'-01_2020" id="01_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-01_2020" class="fa-submit fa-check-exp-amt-'.$count.'-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-12_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-12_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e4 number exp-amt-'.$count.'-12_2019 12_2019" value="" name="row['.$count.'][12_2019]" cus="exp-amt-'.$count.'-12_2019" id="12_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-12_2019" class="fa-submit fa-check-exp-amt-'.$count.'-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-11_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-11_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e5 number exp-amt-'.$count.'-11_2019 11_2019" value="" name="row['.$count.'][11_2019]" cus="exp-amt-'.$count.'-11_2019" id="11_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-11_2019" class="fa-submit fa-check-exp-amt-'.$count.'-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-10_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-10_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e6 number exp-amt-'.$count.'-10_2019 10_2019" value="" name="row['.$count.'][10_2019]" cus="exp-amt-'.$count.'-10_2019" id="10_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-10_2019" class="fa-submit fa-check-exp-amt-'.$count.'-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-09_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-09_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e7 number exp-amt-'.$count.'-09_2019 09_2019" value="" name="row['.$count.'][09_2019]" cus="exp-amt-'.$count.'-09_2019" id="09_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-09_2019" class="fa-submit fa-check-exp-amt-'.$count.'-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-08_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-08_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e8 number exp-amt-'.$count.'-08_2019 08_2019" value="" name="row['.$count.'][08_2019]" cus="exp-amt-'.$count.'-08_2019" id="08_2019"/><a style="padding:0px 0px !important;" id="exp-amt-'.$count.'-08_2019" cus="exp-amt" class="fa-submit fa-check-exp-amt-'.$count.'-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-07_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-07_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e9 number exp-amt-'.$count.'-07_2019 07_2019" value="" name="row['.$count.'][07_2019]" cus="exp-amt-'.$count.'-07_2019" id="07_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-07_2019" class="fa-submit fa-check-exp-amt-'.$count.'-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-06_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-06_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e10 number exp-amt-'.$count.'-06_2019 06_2019" value="" name="row['.$count.'][06_2019]" cus="exp-amt-'.$count.'-06_2019" id="06_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-06_2019" class="fa-submit fa-check-exp-amt-'.$count.'-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-05_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-05_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e11 number exp-amt-'.$count.'-05_2019 05_2019" value="" name="row['.$count.'][05_2019]" cus="exp-amt-'.$count.'-05_2019" id="05_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-05_2019" class="fa-submit fa-check-exp-amt-'.$count.'-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-04_2019" align="center"><span style="display:none;" id="s-exp-amt-'.$count.'-04_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="e12 number exp-amt-'.$count.'-04_2019 04_2019" value="" name="row['.$count.'][04_2019]" cus="exp-amt-'.$count.'-04_2019" id="04_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-04_2019" class="fa-submit fa-check-exp-amt-'.$count.'-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td></tr>';
		return $html;
	}
	
	
	
	
	
	public function ajaxStockAttributePurchaseAddX(Request $request)
	{
	    $user = Auth::user();
	    $count = ($request->rowCount)+1;
		$purchases_select = DB::table(getPrefix($user->id).'_tbl_purchases')->orderBy('_id', 'ASC')->get();
		$html = '<tr class="purchases" id="remove-'.$count.'"> <th class="hidden_th a-fa-click" id="a-'.$count.'"> <div class="product"><span class="sp-a-'.$count.'" style="display:none;"></span><select cus="a-'.$count.'" class="a-'.$count.' e-'.$count.' attribute-purchase" autocomplete="off" name="row['.$count.'][name]">';
		foreach($purchases_select as $purchases_select_dropdown){
		$row_count = DB::table(getPrefix($user->id).'_tbl_purchases_x')->where('name', $purchases_select_dropdown["name"])->count();
		if($row_count<=0){
		$html .='<option value="'.@$purchases_select_dropdown["name"].'">'.@$purchases_select_dropdown["name"].'</option>';
		}
		}
		$html .= '</select>&nbsp;<a style="padding:0px 0px !important;" id="a-'.$count.'" class="fa-submit-attribute-purchase fa-check-a-'.$count.'" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove exp-amt-a-'.$count.'" cus="'.$count.'" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a></div> </th><input value="" type="hidden" id="h-a-'.$count.'" name="row['.$count.'][id]" /> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-03_2020" align="center"><span id="f-exp-amt-'.$count.'-03_2020" style="display:none;"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f1 number-purchase exp-amt-'.$count.'-03_2020 f-03_2020" value="" name="row['.$count.'][03_2020]" cus="exp-amt-'.$count.'-03_2020" id="03_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-03_2020" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-02_2020" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-02_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f2 number-purchase exp-amt-'.$count.'-02_2020 f-02_2020" value="" name="row['.$count.'][02_2020]" cus="exp-amt-'.$count.'-02_2020" id="02_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-02_2020" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-01_2020" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-01_2020"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f3 number-purchase exp-amt-'.$count.'-01_2020 f-01_2020" value="" name="row['.$count.'][01_2020]" cus="exp-amt-'.$count.'-01_2020" id="01_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-01_2020" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-12_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-12_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f4 number-purchase exp-amt-'.$count.'-12_2019 f-12_2019" value="" name="row['.$count.'][12_2019]" cus="exp-amt-'.$count.'-12_2019" id="12_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-12_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-11_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-11_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f5 number-purchase exp-amt-'.$count.'-11_2019 f-11_2019" value="" name="row['.$count.'][11_2019]" cus="exp-amt-'.$count.'-11_2019" id="11_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-11_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-10_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-10_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f6 number-purchase exp-amt-'.$count.'-10_2019 f-10_2019" value="" name="row['.$count.'][10_2019]" cus="exp-amt-'.$count.'-10_2019" id="10_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-10_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-09_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-09_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f7 number-purchase exp-amt-'.$count.'-09_2019 f-09_2019" value="" name="row['.$count.'][09_2019]" cus="exp-amt-'.$count.'-09_2019" id="09_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-09_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-08_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-08_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f8 number-purchase exp-amt-'.$count.'-08_2019 f-08_2019" value="" name="row['.$count.'][08_2019]" cus="exp-amt-'.$count.'-08_2019" id="08_2019"/><a style="padding:0px 0px !important;" id="exp-amt-'.$count.'-08_2019" cus="exp-amt" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-07_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-07_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f9 number-purchase exp-amt-'.$count.'-07_2019 f-07_2019" value="" name="row['.$count.'][07_2019]" cus="exp-amt-'.$count.'-07_2019" id="07_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-07_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'.$count.'-06_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-06_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f10 number-purchase exp-amt-'.$count.'-06_2019 f-06_2019" value="" name="row['.$count.'][06_2019]" cus="exp-amt-'.$count.'-06_2019" id="06_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-06_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-05_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-05_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f11 number-purchase exp-amt-'.$count.'-05_2019 f-05_2019" value="" name="row['.$count.'][05_2019]" cus="exp-amt-'.$count.'-05_2019" id="05_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-05_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'.$count.'-04_2019" align="center"><span style="display:none;" id="f-exp-amt-'.$count.'-04_2019"></span> <input type="text" rel="a-'.$count.'" autocomplete="off" style=" text-align: center;" class="f12 number-purchase exp-amt-'.$count.'-04_2019 f-04_2019" value="" name="row['.$count.'][04_2019]" cus="exp-amt-'.$count.'-04_2019" id="04_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'.$count.'-04_2019" class="fa-submit-purchase fa-check-exp-amt-'.$count.'-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td></tr>';
		return $html;
	}
	
}
