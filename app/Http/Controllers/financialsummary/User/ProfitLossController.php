<?php

namespace App\Http\Controllers\financialsummary\User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

class ProfitLossController extends Controller
{
    public function index()
    {   
	    $user = Auth::user();
	    @ini_set('max_execution_time', '3600');
		$sales = DB::table(getPrefix($user->id).'_tbl_sales')->get();
        return view('financialsummary.user.profit_loss',['sales'=>$sales]);
    }
	
	
	
	public function AllProfitLoss()
    {   
	    $user = Auth::user();
	    @ini_set('max_execution_time', '3600');
		$sales = DB::table(getPrefix($user->id).'_tbl_sales')->get();
        return view('financialsummary.user.all_profit_loss',['sales'=>$sales]);
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
	
	public function ajaxAllProfitLossUpdate($id)
	{
	$user = Auth::user();
	DB::table('users')->where('_id',$user->id)->update(['all_profit_loss' => $id]);
	echo 1;
	}
	
	public function ajaxCenterGraph($id)
	{
	if($id!=''){?>
	<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
	<script>
	var options10_<?php echo $id;?> = {
	animationEnabled: true,  
	title:{
		text: "Monthly Net Revenue - 2019",
		fontFamily: "Helvetica Neue,Helvetica,Arial,sans-serif",
		fontSize: 16,
	},
	axisX: {
		valueFormatString: "MMM",
		interval: 1,
        intervalType: "month",
	},
	axisY: {
		title: "Turnover (in cores)",
		prefix: "Rs ",
		valueFormatString: "#,##,###.00#",
		includeZero: false,
		titleFontSize: 12,
	},
	data: [{
		yValueFormatString: "Rs #,##,###.00#",
		xValueFormatString: "MMM",
		type: "spline",
		dataPoints: [
			{ x: new Date(2019, 3), y: <?php echo NetRevenue("04_2019",$id);?> },
			{ x: new Date(2019, 4), y: <?php echo NetRevenue("05_2019",$id);?> },
			{ x: new Date(2019, 5), y: <?php echo NetRevenue("06_2019",$id);?> },
			{ x: new Date(2019, 6), y: <?php echo NetRevenue("07_2019",$id);?> },
			{ x: new Date(2019, 7), y: <?php echo NetRevenue("08_2019",$id);?> },
			{ x: new Date(2019, 8), y: <?php echo NetRevenue("09_2019",$id);?> },
			{ x: new Date(2019, 9), y: <?php echo NetRevenue("10_2019",$id);?> },
			{ x: new Date(2019, 10), y: <?php echo NetRevenue("11_2019",$id);?> },
			{ x: new Date(2019, 11), y: <?php echo NetRevenue("12_2019",$id);?> },
			{ x: new Date(2020, 0), y:  <?php echo NetRevenue("01_2020",$id);?> },
			{ x: new Date(2020, 1), y:  <?php echo NetRevenue("02_2020",$id);?> },
			{ x: new Date(2020, 2), y:  <?php echo NetRevenue("03_2020",$id);?> },
		]
	}]
};
$("#chartContainer-<?php echo $id;?>").CanvasJSChart(options10_<?php echo $id;?>);



var options11_<?php echo $id;?> = {
	animationEnabled: true,  
	title:{
		text: "Monthly Net Variable Expenses - 2019",
		fontFamily: "Helvetica Neue,Helvetica,Arial,sans-serif",
		fontSize: 16,
	},
	axisX: {
		valueFormatString: "MMM",
		interval: 1,
        intervalType: "month",
	},
	axisY: {
		title: "Turnover (in cores)",
		prefix: "Rs ",
		valueFormatString: "#,##,###.00#",
		includeZero: false,
		titleFontSize: 12,
	},
	data: [{
		yValueFormatString: "Rs #,##,###.00#",
		xValueFormatString: "MMM",
		type: "spline",
		dataPoints: [
			{ x: new Date(2019, 3), y: <?php echo NetVariableExpenses('04_2019',$id);?> },
			{ x: new Date(2019, 4), y: <?php echo NetVariableExpenses('05_2019',$id);?> },
			{ x: new Date(2019, 5), y: <?php echo NetVariableExpenses('06_2019',$id);?> },
			{ x: new Date(2019, 6), y: <?php echo NetVariableExpenses('07_2019',$id);?> },
			{ x: new Date(2019, 7), y: <?php echo NetVariableExpenses('08_2019',$id);?> },
			{ x: new Date(2019, 8), y: <?php echo NetVariableExpenses('09_2019',$id);?> },
			{ x: new Date(2019, 9), y: <?php echo NetVariableExpenses('10_2019',$id);?> },
			{ x: new Date(2019, 10), y: <?php echo NetVariableExpenses('11_2019',$id);?> },
			{ x: new Date(2019, 11), y: <?php echo NetVariableExpenses('12_2019',$id);?> },
			{ x: new Date(2020, 0), y:  <?php echo NetVariableExpenses('01_2020',$id);?> },
			{ x: new Date(2020, 1), y:  <?php echo NetVariableExpenses('02_2020',$id);?> },
			{ x: new Date(2020, 2), y:  <?php echo NetVariableExpenses('03_2020',$id);?> },
		]
	}]
};
$("#chartContainer_netVariableExpenses-<?php echo $id;?>").CanvasJSChart(options11_<?php echo $id;?>);


var options12_<?php echo $id;?> = {
	animationEnabled: true,  
	title:{
		text: "Monthly Net Fixed Cost - 2019",
		fontFamily: "Helvetica Neue,Helvetica,Arial,sans-serif",
		fontSize: 16,
	},
	axisX: {
		valueFormatString: "MMM",
		interval: 1,
        intervalType: "month",
	},
	axisY: {
		title: "Turnover (in cores)",
		prefix: "Rs ",
		valueFormatString: "#,##,###.00#",
		includeZero: false,
		titleFontSize: 12,
	},
	data: [{
		yValueFormatString: "Rs #,##,###.00#",
		xValueFormatString: "MMM",
		type: "spline",
		dataPoints: [
			{ x: new Date(2019, 3), y: <?php echo NetFixedCost('04_2019',$id);?> },
			{ x: new Date(2019, 4), y: <?php echo NetFixedCost('05_2019',$id);?> },
			{ x: new Date(2019, 5), y: <?php echo NetFixedCost('06_2019',$id);?> },
			{ x: new Date(2019, 6), y: <?php echo NetFixedCost('07_2019',$id);?> },
			{ x: new Date(2019, 7), y: <?php echo NetFixedCost('08_2019',$id);?> },
			{ x: new Date(2019, 8), y: <?php echo NetFixedCost('09_2019',$id);?> },
			{ x: new Date(2019, 9), y: <?php echo NetFixedCost('10_2019',$id);?> },
			{ x: new Date(2019, 10), y: <?php echo NetFixedCost('11_2019',$id);?> },
			{ x: new Date(2019, 11), y: <?php echo NetFixedCost('12_2019',$id);?> },
			{ x: new Date(2020, 0), y:  <?php echo NetFixedCost('01_2020',$id);?> },
			{ x: new Date(2020, 1), y:  <?php echo NetFixedCost('02_2020',$id);?> },
			{ x: new Date(2020, 2), y:  <?php echo NetFixedCost('03_2020',$id);?> },
		]
	}]
};
$("#chartContainer_NetFixedCost-<?php echo $id;?>").CanvasJSChart(options12_<?php echo $id;?>);


var options13_<?php echo $id;?> = {
	animationEnabled: true,  
	title:{
		text: "Monthly Gross Profit - 2019",
		fontFamily: "Helvetica Neue,Helvetica,Arial,sans-serif",
		fontSize: 16,
	},
	axisX: {
		valueFormatString: "MMM",
		interval: 1,
        intervalType: "month",
	},
	axisY: {
		title: "Turnover (in cores)",
		prefix: "Rs ",
		valueFormatString: "#,##,###.00#",
		includeZero: false,
		titleFontSize: 12,
	},
	data: [{
		yValueFormatString: "Rs #,##,###.00#",
		xValueFormatString: "MMM",
		type: "spline",
		dataPoints: [
			{ x: new Date(2019, 3), y: <?php echo GrossProfit(NetRevenue('04_2019',$id), NetVariableExpenses('04_2019',$id), NetClosingStock('04_2019',$id));?> },
			{ x: new Date(2019, 4), y: <?php echo GrossProfit(NetRevenue('05_2019',$id), NetVariableExpenses('05_2019',$id), NetClosingStock('05_2019',$id));?> },
			{ x: new Date(2019, 5), y: <?php echo GrossProfit(NetRevenue('06_2019',$id), NetVariableExpenses('06_2019',$id), NetClosingStock('06_2019',$id));?> },
			{ x: new Date(2019, 6), y: <?php echo GrossProfit(NetRevenue('07_2019',$id), NetVariableExpenses('07_2019',$id), NetClosingStock('07_2019',$id));?> },
			{ x: new Date(2019, 7), y: <?php echo GrossProfit(NetRevenue('08_2019',$id), NetVariableExpenses('08_2019',$id), NetClosingStock('08_2019',$id)) ;?> },
			{ x: new Date(2019, 8), y: <?php echo GrossProfit(NetRevenue('09_2019',$id), NetVariableExpenses('09_2019',$id), NetClosingStock('09_2019',$id)) ;?> },
			{ x: new Date(2019, 9), y: <?php echo GrossProfit(NetRevenue('10_2019',$id), NetVariableExpenses('10_2019',$id), NetClosingStock('10_2019',$id)) ;?> },
			{ x: new Date(2019, 10), y: <?php echo GrossProfit(NetRevenue('11_2019',$id), NetVariableExpenses('11_2019',$id), NetClosingStock('11_2019',$id)) ;?> },
			{ x: new Date(2019, 11), y: <?php echo GrossProfit(NetRevenue('12_2019',$id), NetVariableExpenses('12_2019',$id), NetClosingStock('12_2019',$id)) ;?> },
			{ x: new Date(2020, 0), y:  <?php echo GrossProfit(NetRevenue('01_2020',$id), NetVariableExpenses('01_2020',$id), NetClosingStock('01_2020',$id)) ;?> },
			{ x: new Date(2020, 1), y:  <?php echo GrossProfit(NetRevenue('02_2020',$id), NetVariableExpenses('02_2020',$id), NetClosingStock('02_2020',$id)) ;?> },
			{ x: new Date(2020, 2), y:  <?php echo GrossProfit(NetRevenue('03_2020',$id), NetVariableExpenses('03_2020',$id), NetClosingStock('03_2020',$id)) ;?> },
		]
	}]
};
$("#chartContainer_Gross_Profit-<?php echo $id;?>").CanvasJSChart(options13_<?php echo $id;?>);


var options14_<?php echo $id;?> = {
	animationEnabled: true,  
	title:{
		text: "Monthly Net Profit - 2019",
		fontFamily: "Helvetica Neue,Helvetica,Arial,sans-serif",
		fontSize: 16,
	},
	axisX: {
		valueFormatString: "MMM",
		interval: 1,
        intervalType: "month",
	},
	axisY: {
		title: "Turnover (in cores)",
		prefix: "Rs ",
		valueFormatString: "#,##,###.00#",
		includeZero: false,
		titleFontSize: 12,
	},
	data: [{
		yValueFormatString: "Rs #,##,###.00#",
		xValueFormatString: "MMM",
		type: "spline",
		dataPoints: [
			{ x: new Date(2019, 3), y: <?php echo NetProfit(GrossProfit(NetRevenue('04_2019',$id), NetVariableExpenses('04_2019',$id), NetClosingStock('04_2019',$id)),NetFixedCost('04_2019',$id)) ;?> },
			{ x: new Date(2019, 4), y: <?php echo NetProfit(GrossProfit(NetRevenue('05_2019',$id), NetVariableExpenses('05_2019',$id), NetClosingStock('05_2019',$id)),NetFixedCost('05_2019',$id)) ;?> },
			{ x: new Date(2019, 5), y: <?php echo  NetProfit(GrossProfit(NetRevenue('06_2019',$id), NetVariableExpenses('06_2019',$id), NetClosingStock('06_2019',$id)),NetFixedCost('06_2019',$id)) ;?> },
			{ x: new Date(2019, 6), y: <?php echo  NetProfit(GrossProfit(NetRevenue('07_2019',$id), NetVariableExpenses('07_2019',$id), NetClosingStock('07_2019',$id)),NetFixedCost('07_2019',$id)) ;?> },
			{ x: new Date(2019, 7), y: <?php echo  NetProfit(GrossProfit(NetRevenue('08_2019',$id), NetVariableExpenses('08_2019',$id), NetClosingStock('08_2019',$id)),NetFixedCost('08_2019',$id)) ;?> },
			{ x: new Date(2019, 8), y: <?php echo  NetProfit(GrossProfit(NetRevenue('09_2019',$id), NetVariableExpenses('09_2019',$id), NetClosingStock('09_2019',$id)),NetFixedCost('09_2019',$id)) ;?> },
			{ x: new Date(2019, 9), y: <?php echo  NetProfit(GrossProfit(NetRevenue('10_2019',$id), NetVariableExpenses('10_2019',$id), NetClosingStock('10_2019',$id)),NetFixedCost('10_2019',$id)) ;?> },
			{ x: new Date(2019, 10), y: <?php echo  NetProfit(GrossProfit(NetRevenue('11_2019',$id), NetVariableExpenses('11_2019',$id), NetClosingStock('11_2019',$id)),NetFixedCost('11_2019',$id)) ;?> },
			{ x: new Date(2019, 11), y: <?php echo  NetProfit(GrossProfit(NetRevenue('12_2019',$id), NetVariableExpenses('12_2019',$id), NetClosingStock('12_2019',$id)),NetFixedCost('12_2019',$id)) ;?> },
			{ x: new Date(2020, 0), y: <?php echo  NetProfit(GrossProfit(NetRevenue('01_2020',$id), NetVariableExpenses('01_2020',$id), NetClosingStock('01_2020',$id)),NetFixedCost('01_2020',$id)) ;?> },
			{ x: new Date(2020, 1), y: <?php echo  NetProfit(GrossProfit(NetRevenue('02_2020',$id), NetVariableExpenses('02_2020',$id), NetClosingStock('02_2020',$id)),NetFixedCost('02_2020',$id)) ;?> },
			{ x: new Date(2020, 2), y: <?php echo  NetProfit(GrossProfit(NetRevenue('03_2020',$id), NetVariableExpenses('03_2020',$id), NetClosingStock('03_2020',$id)),NetFixedCost('03_2020',$id)) ;?> },
		]
	}]
};
$("#chartContainer_Net_Profit-<?php echo $id;?>").CanvasJSChart(options14_<?php echo $id;?>);

<?php }

	}
	
	
}
