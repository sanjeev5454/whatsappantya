<?php
use Illuminate\Support\Facades\DB;
use App\Vendor;
use App\User;
use App\Item;
use App\PurchaseOrder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!function_exists('pr')) {
    function pr($data)
    {
     echo '<pre>';
	 print_r($data);
    }
}

if(!function_exists('getVendorName'))
{
	function getVendorName($id){
	    if($id!=0)
		{
		$data = Vendor::where('_id',$id)->first();
        $data2 = DB::table('tbl_purchase_settings')->first();
        if(Auth::user()->user_role==1){
        $vendorName = $data->vendor_name;
        }else{
        if($data2['code_vendor']==1){
        $vendorName = $data->vendor_name;
        }else{
        $vendorName = $data->vendor_code;  
        }
        }
		
		if($vendorName!=''){
			$res = $vendorName;
		}else{
			$res = '';
		}
		return $res;
		}else{
		return $res='';
		}		
	}
}

if(!function_exists('purchaseOrderDetails'))
{
	function purchaseOrderDetails($id){
	    if($id!=0)
		{
		$data = PurchaseOrder::where('order_number',$id)->first();
		if($data!=''){
			$res = $data;
		}else{
			$res = '';
		}
		return $res;
		}else{
		return $res='';
		}		
	}
}

if(!function_exists('getUpdateQuantityRecords'))
{
	function getUpdateQuantityRecords($id){
	    if($id!=0)
		{
		$data = DB::table('tbl_purchase_order_qty_update_intake_form')->where('invoice_number',$id)->get();
		if($data!=''){
			$res = $data;
		}else{
			$res = '';
		}
		return $res;
		}else{
		return $res='';
		}		
	}
}


if(!function_exists('ItemDetails'))
{
   function ItemDetails($id){
		if($id!=0)
		{
		$data = Item::where('_id',$id)->first();
		$item_name = $data->item_name;
		if($item_name!=''){
		$res = $item_name;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}

if(!function_exists('ItemDetailsgst'))
{
   function ItemDetailsgst($id){
		if($id!=0)
		{
		$data = Item::where('_id',$id)->first();
		$item_gst = $data->gst;
		if($item_gst!=''){
		$res = $item_gst;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}


if(!function_exists('ItemSKU'))
{
   function ItemSKU($id){
		if($id!=0)
		{
		$data = Item::where('_id',$id)->first();
		$item_name = $data->item_sku;
		if($item_name!=''){
		$res = $item_name;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}



if(!function_exists('ItemDetailsUpdateQty'))
{
   function ItemDetailsUpdateQty($id){
		if($id!=0)
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->first();
		$item = $data['receive_qty'];
		if($item!=''){
		$res = $item;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}

if(!function_exists('getAllUnits'))
{
   function getAllUnits(){
		$data = DB::table('tbl_unit')->first();
		if($data['unit_name']!='')
		{
		$units = explode(',',$data['unit_name']);
		if(!empty($units)){
		$res = $units;
		}else{
		$res = '';
		}
		return $res;
		}
		}
}

if(!function_exists('getAllOtherUnits'))
{
   function getAllOtherUnits(){
		$data = DB::table('tbl_other_unit')->where('user_id', Auth::id())->first();
		if($data['other_unit']!='')
		{
		$units =  explode(',',$data['other_unit']);
		if(!empty($units)){
		$res = $units;
		}else{
		$res = '';
		}
		return $res;
		}
		}
}

if(!function_exists('ItemDetailsUpdateDate'))
{
   function ItemDetailsUpdateDate($id){
		if($id!=0)
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->first();
		$item = $data['received_date'];
		if($item!=''){
		$res = $item;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}

if(!function_exists('vendorDetails'))
{
   function vendorDetails($name){
		if($name!='')
		{
		$data = Vendor::where('vendor_code',$name)->first();
		if($data!=''){
		$res = $data;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}

if(!function_exists('userDetails'))
{
   function userDetails($id){
		if($id!='')
		{
		$data = User::where('_id',$id)->first();
		if($data!=''){
		$res = $data;
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
   }
}


if(!function_exists('purchaseOrderDetailsReciveQty'))
{
   function purchaseOrderDetailsReciveQty($id,$order_number,$order){
		if($id!='')
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('item',$id)->where('order_number',$order_number)->where('order',$order)->first();
		if($data!=''){
		$res = $data['qty_received'];
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
		
   }
}

function purchaseDataUpdateDetails($id){
        
        if($id!=''){
          $purchase_data_items_val =  DB::table('tbl_purchase_order_qty_update')->where('quantity','<>', 'qty_received')->where('order_number', $id)->orderBy('_id', 'asc')->get();
          return $purchase_data_items_val;
        }else{
            return '';
        }
    }
    
    function purchaseDataUpdateInsert($order_number,$purchase_order_id,$vendor){
        
        if($order_number!='' && $purchase_order_id!=''){
          $values = array('order_number'=>$order_number,'purchase_order_id'=>$purchase_order_id,'vendor'=>$vendor);
          DB::table('tbl_pdf_record_count')->insert(array($values));
          
        }
    }
    
    function purchaseDataUpdateInsertItem($item,$purchase_order_id,$vendor){
        
        if($item!='' && $purchase_order_id!=''){
          $values = array('item'=>$item,'purchase_order_id'=>$purchase_order_id,'vendor'=>$vendor);
          DB::table('tbl_pdf_record_count_item')->insert(array($values));
          
        }
    }
    
    function selectPDFRecord($order_number,$vendor){
        return $purchase_data_items_val =  DB::table('tbl_pdf_record_count')->where('order_number', $order_number)->where('vendor', $vendor)->orderBy('_id', 'asc')->get();
    }
    
    function selectPDFRecordItem($item,$vendor){
        return $purchase_data_items_val =  DB::table('tbl_pdf_record_count_item')->where('item', $item)->where('vendor', $vendor)->orderBy('_id', 'asc')->get();
    }
    
    function purchaseDataUpdateDelete($order_number,$vendor){
        if($order_number!='' && $vendor!=''){
          DB::table('tbl_pdf_record_count')->where(['order_number' => $order_number,'vendor' => $vendor])->delete();  
        }
    }
    
    function purchaseDataUpdateDeleteItem($item,$vendor){
        if($item!='' && $vendor!=''){
          DB::table('tbl_pdf_record_count_item')->where(['item' => $item,'vendor' => $vendor])->delete();  
        }
    }
    
    

function purchaseDataUpdateDetailsItem($id){
        
        if($id!=''){
          $purchase_data_items_val =  DB::table('tbl_purchase_order_qty_update')->where('item', $id)->orderBy('_id', 'asc')->get();
          return $purchase_data_items_val;
        }else{
            return '';
        }
    }
    
    function purchaseDataUpdateDetailsItemPr($id){
        
        if($id!=''){
          $purchase_data_items_val =  DB::table('tbl_purchase_order_qty_update')->where('item', $id)->orderBy('_id', 'asc')->first();
          return $purchase_data_items_val;
        }else{
            return '';
        }
    }


if(!function_exists('purchaseOrderDetailsReciveQtyPrice'))
{
   function purchaseOrderDetailsReciveQtyPrice($id,$order_number){
		if($id!='')
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('item',$id)->where('order_number',$order_number)->first();
		if($data!=''){
		$res = $data['received_price'];
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
		
   }
}


if(!function_exists('purchaseOrderDetailsReciveDate'))
{
   function purchaseOrderDetailsReciveDate($id,$order_number,$order){
		if($id!='')
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('item',$id)->where('order_number',$order_number)->where('order',$order)->first();
		if($data!=''){
		$res = $data['invoice_date'];
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
		
   }
}


if(!function_exists('purchaseOrderDetailsReciveInvoice'))
{
   function purchaseOrderDetailsReciveInvoice($id,$order_number,$order){
		if($id!='')
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('item',$id)->where('order_number',$order_number)->where('order',$order)->first();
		if($data!=''){
		$res = $data['invoice_number'];
		}else{
		$res = '';
		}
		return $res;
		}else{
		return $res='';
		}
		
   }
}



if(!function_exists('checkStatus'))
{
   function checkStatus($id){
		if($id!='')
		{
		$data_received = DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->where('receive_qty','!=', "")->where('status','=', 1)->count();
		$data_all = DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->where('status','=', 1)->count();
		if($data_all==$data_received)
		{
			$res = 'Received';
		}else if($data_received==0){
			$res = '';
		}else{
			$res = 'Partially Received';
		}
		return $res;
		}else{
		return $res='';
		}
		
   }
}



if(!function_exists('itemCountPO'))
{
   function itemCountPO($id){
		if($id!='')
		{
		$data_received = DB::table('tbl_purchase_order_qty_update')->where('item',$id)->count();
		return $data_received;
		}else{
		return $data_received='';
		}
		
   }
}

if(!function_exists('sendWhatsAppmsg'))
	{
	 function sendWhatsAppmsg($fname,$file_path,$receiverMobileNo,$receiverName,$message,$id)
	 {
		$target_url = "https://app.messageautosender.com/api/v1/message/create";           
		$cfile = new CURLFile($file_path,'pdf',$fname);
		
		$post = array('username' => 'chaashni couture','password' => 'chaashni@456','receiverMobileNo' => $receiverMobileNo,'receiverName' => $receiverName,'message' => $message,'uploadFile'=>$cfile);  
		//$post = array('username' => 'antya','password' => 'antya@123','receiverMobileNo' => $receiverMobileNo,'receiverName' => $receiverName,'message' => $message,'uploadFile'=>$cfile);  
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $target_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");   
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);   
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec ($ch);
		$results = json_decode($result);
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$values = array('recurring_message'=>$message,'receiver_mobile_number'=>$receiverMobileNo,'msg_id'=>$msg_id,'message_send_date'=>$message_send_date,'message_status'=>'UNPROCESSED');
        DB::table('tbl_recurring_report_po')->insert(array($values));
        $data_message2 = array("report_id" => $msg_id);
	    DB::table('tbl_purchase_order')->where('_id',$id)->update($data_message2);
		
	 }
	}
	
		if(!function_exists('messageStatusPo'))
	{
	 function messageStatusPo($msg_id)
	 {
	  $url = "https://app.messageautosender.com/api/v1/message/status?username=chaashni couture&password=chaashni@456&messageId=".$msg_id;
	   //$url = "https://app.messageautosender.com/api/v1/message/status?username=antya&password=antya@123&messageId=".$msg_id;
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);      
		curl_close($ch); 
		$results = json_decode($output);
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$recipients_status = $results->result->recipients[0]->status;
		$data_message2 = array("message_status" => $recipients_status);
	    DB::table('tbl_recurring_report_po')->where('msg_id',$msg_id)->update($data_message2);
	    return $results;
	 }
	}
	
	
	if(!function_exists('messageStatusD'))
	{
	 function messageStatusD($msg_id)
	 {
	  $url = "https://app.messageautosender.com/api/v1/message/status?username=chaashni couture&password=chaashni@456&messageId=".$msg_id;
	  //$url = "https://app.messageautosender.com/api/v1/message/status?username=antya&password=antya@123&messageId=".$msg_id;
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);      
		curl_close($ch); 
		$results = json_decode($output);
		//$status = $results->status;
		//$msg = $results->message;
		//$msg_id = (string)$results->result->id;
		//$message_send_date = $results->result->creationTime;
		//$recipients_status = $results->result->recipients[0]->status;
		//$data_message2 = array("message_status" => $recipients_status);
	    //DB::table('tbl_recurring_report_po')->where('msg_id',$msg_id)->update($data_message2);
	    return $results;
	 }
	}


	function loginCheckGoogle()
	{
    $save_google_id = @$_COOKIE['session_google_id'];
	if($save_google_id!='')
	{
	$count  = DB::table('users')->where('google_id',$save_google_id)->count();
	if($count<=0)
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://localhost/google-auth-api/api/v1/global-select-api.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	"&google_id=".$save_google_id."&login_status=1");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$results = json_decode($server_output);
	$name = $results->data->name;
	$email = $results->data->email;
	$google_id = $results->data->google_id;
	if($name!='' && $email!='' && $google_id!=''){
	$values = array('name' => $name,'email'=>$email,'google_id'=>$google_id);
    $last_id = DB::table('users')->insertGetId($values);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$user = $last_id;
    Auth::loginUsingId($user, true);
    return redirect()->intended('/dashboard');
	}
	}else{
	$last_id = DB::table('users')->where('google_id',$save_google_id)->first();
	$oid_p = (array) $last_id['_id'];
	$last_id = $oid_p['oid'];
	$user = $last_id;
    Auth::loginUsingId($user, true);
    return redirect()->intended('/dashboard');
	}
	}else{
	return true;
	}
	}
	
	
	function insertUpdateGlobaldata($name,$email,$google_id,$login_status)
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://localhost/google-auth-api/api/v1/global-api.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	"name=".$name."&email=".$email."&google_id=".$google_id."&login_status=".$login_status."");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	}
	
	function UpdateSessionData($google_id)
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://localhost/google-auth-api/api/v1/global-update-api.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	"&google_id=".$google_id."&login_status=0");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	}
	
	function LogoutSessionData($google_id)
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://localhost/document/logout");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	"&google_id=".$google_id."");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	}
	
	if(!function_exists('pan_cards'))
{
	function pan_cards($cat_id){
	    $user = Auth::user();
		$oid = (array) $cat_id;
		$c_id = $oid['oid'];
		$data = DB::table('tbl_pan_cards')->where('user_id',$user->id)->where('cat_id',$c_id)->orderBy('_id', 'ASC')->get();
		if(!empty($data)){
		    return $data;
		}else{
		    return 0;
		}
	}
}

/* Starting for Financial */

 if(!function_exists('getMonths'))
{
	function getMonths(){
		$data = array(
			'1' 	=> 'MAR\'20',
			'2'   	=> 'FEB\'20',
			'3'  	=> 'JAN\'20',
			'4'   	=> 'DEC\'19',
			'5'  	=> 'NOV\'19',
			'6'  	=> 'OCT\'19',
			'7'  	=> 'SEP\'19',
			'8'  	=> 'AUG\'19',
			'9'  	=> 'JUL\'19',
			'10'  	=> 'JUN\'19',
			'11'  	=> 'MAY\'19',
			'12'  	=> 'APR\'19'
		);
		return $data;		
	}
} 

if(!function_exists('getFullMonths'))
{
	function getFullMonths(){
		$data = array(
			'04_2019' 	=> 'April',
			'05_2019'   => 'May',
			'06_2019'  	=> 'June',
			'07_2019'   => 'July',
			'08_2019'  	=> 'August',
			'09_2019'  	=> 'September',
			'10_2019'  	=> 'October',
			'11_2019'  	=> 'November',
			'12_2019'  	=> 'December',
			'01_2020'  	=> 'January',
			'02_2020'  	=> 'February',
			'03_2020'  	=> 'March'
		);
		return $data;		
	}
} 

if(!function_exists('getMonthsData'))
{
	function getMonthsData(){
		$data = array(
			'1' 	=> '03_2020',
			'2'   	=> '02_2020',
			'3'  	=> '01_2020',
			'4'   	=> '12_2019',
			'5'  	=> '11_2019',
			'6'  	=> '10_2019',
			'7'  	=> '09_2019',
			'8'  	=> '08_2019',
			'9'  	=> '07_2019',
			'10'  	=> '06_2019',
			'11'  	=> '05_2019',
			'12'  	=> '04_2019'
		);
		return $data;		
	}
} 



if(!function_exists('amountCanculated'))
{
	function amountCanculated($name,$month_key,$table){
		if($name!='' && $month_key!='')
		{
		$expensesb = DB::table($table)->select($month_key)->where('name',$name)->first();
		$expensesx = DB::table($table.'_x')->select($month_key)->where('name',$name)->first();
		$total_value = $expensesb[$month_key]-$expensesx[$month_key];
		if($total_value==0){return '';}else{return $total_value;}
		}
	}
}


if(!function_exists('amountCanculatedClosing'))
{
	function amountCanculatedClosing($name,$month_key,$table){
		if($name!='' && $month_key!='')
		{
		$expensesb = DB::table($table)->select($month_key)->where('name',$name)->first();
		$expensesx = DB::table(getPrefix(Auth::user()->id).'_tbl_closing_stock_x')->select($month_key)->where('name',$name)->first();
		$total_value = $expensesb[$month_key]-$expensesx[$month_key];
		if($total_value==0){return '';}else{return $total_value;}
		}
	}
}



if(!function_exists('NetRevenue'))
{
	function NetRevenue($month_key,$table_id){
		if($month_key!='')
		{
		$total_sales = DB::table('_'.$table_id."_tbl_sales")->get()->sum($month_key);
		if(is_numeric($total_sales)){return $total_sales;}else{return 0;}
		}
	}
}

if(!function_exists('NetRevenueGraph'))
{
	function NetRevenueGraph($month_key,$table_id){
		if($month_key!='')
		{
		$total_sales = DB::table('_'.$table_id."_tbl_sales")->get()->sum($month_key);
		if(is_numeric($total_sales)){return moneyFormatIndia($total_sales);}else{return 0;}
		}
	}
}




if(!function_exists('getAllNetRevenue'))
{
	function getAllNetRevenue($month_key){
		if($month_key!='')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$total_sales = 0;
		foreach($company as $allcompany)
		{
		$total_sales += DB::table('_'.$allcompany['_id']."_tbl_sales")->get()->sum($month_key);
		}
		return $total_sales;
		}
	}
}


if(!function_exists('NetVariableExpenses'))
{
	function NetVariableExpenses($month_key,$table_id){
		if($month_key!='')
		{
		$expensesb = DB::table('_'.$table_id."_tbl_variable_expenses")->get()->sum($month_key);
		$expensesx = DB::table('_'.$table_id."_tbl_variable_expenses_x")->get()->sum($month_key);
		$total_value = $expensesb - $expensesx;
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
		}
	}
}


if(!function_exists('getAllNetVariableExpenses'))
{
	function getAllNetVariableExpenses($month_key){
		if($month_key!='')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$total_value = 0;
		foreach($company as $allcompany)
		{
		$expensesb = DB::table('_'.$allcompany['_id']."_tbl_variable_expenses")->get()->sum($month_key);
		$expensesx = DB::table('_'.$allcompany['_id']."_tbl_variable_expenses_x")->get()->sum($month_key);
		$total_value += $expensesb - $expensesx;
		}
		return $total_value;
		}
	}
}



if(!function_exists('NetClosingStock'))
{
	function NetClosingStock($month_key,$table_id){
		if($month_key!='')
		{
		if($month_key=='04_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_add_april_opening_stock")->get()->sum('stock_purchase_b');
		$opening_stockx = DB::table('_'.$table_id."_tbl_add_april_opening_stock_x")->get()->sum('stock_purchase_x');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		if($month_key=='05_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('04_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('04_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='06_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('05_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('05_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='07_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('06_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('06_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='08_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('07_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('07_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='09_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('08_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('08_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='10_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('09_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('09_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='11_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('10_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('10_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='12_2019')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('11_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('11_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		
		if($month_key=='01_2020')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('12_2019');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('12_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='02_2020')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('01_2020');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('01_2020');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
		if($month_key=='03_2020')
		{
		$closing_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$table_id."_tbl_opening_stock")->get()->sum('02_2020');
		$opening_stockx = DB::table('_'.$table_id."_tbl_closing_stock_x")->get()->sum('02_2020');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$table_id."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$table_id."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		return $opening_stock + $purchases_stock - $closing_stock;
		}
		
	    }
    }
}





if(!function_exists('getAllNetClosingStock'))
{
	function getAllNetClosingStock($month_key){
		if($month_key!='')
		{
		if($month_key=='04_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock1 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_add_april_opening_stock")->get()->sum('stock_purchase_b');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_add_april_opening_stock_x")->get()->sum('stock_purchase_x');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock1 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock1;
		}
		if($month_key=='05_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock2 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('04_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('04_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock2 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		
		return $stock2;
		}
		
		if($month_key=='06_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock3 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('05_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('05_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock3 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		
		return $stock3;
		}
		
		if($month_key=='07_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock4 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('06_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('06_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock4 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock4;
		}
		
		if($month_key=='08_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock5 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('07_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('07_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock5 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock5;
		}
		
		if($month_key=='09_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock6 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('08_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('08_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock6 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock6;
		}
		
		if($month_key=='10_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock7 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('09_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('09_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock7 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock7;
		}
		
		if($month_key=='11_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock8 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('10_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('10_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock8 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock8;
		}
		
		if($month_key=='12_2019')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock9 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('11_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('11_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock9 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock9; 
		}
		
		
		if($month_key=='01_2020')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock10 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('12_2019');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('12_2019');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock10 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock10;
		}
		
		if($month_key=='02_2020')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock11 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('01_2020');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('01_2020');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock11 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock11;
		}
		
		if($month_key=='03_2020')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$stock12 = 0;
		foreach($company as $allcompany)
		{
		$closing_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum($month_key);
		$closing_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum($month_key);
		$closing_stock = $closing_stockb - $closing_stockx;
		
		$opening_stockb = DB::table('_'.$allcompany['_id']."_tbl_opening_stock")->get()->sum('02_2020');
		$opening_stockx = DB::table('_'.$allcompany['_id']."_tbl_closing_stock_x")->get()->sum('02_2020');
		$opening_stock = $opening_stockb - $opening_stockx;
		
		$purchases_stockb = DB::table('_'.$allcompany['_id']."_tbl_purchases")->get()->sum($month_key);
		$purchases_stockx = DB::table('_'.$allcompany['_id']."_tbl_purchases_x")->get()->sum($month_key);
		$purchases_stock = $purchases_stockb - $purchases_stockx;
		
		$stock12 +=$opening_stock + $purchases_stock - $closing_stock;
		}
		return $stock12;
		}
		
	    }
    }
}



if(!function_exists('GrossProfit'))
{
	function GrossProfit($NetRevenue, $NetVariableExpenses, $NetClosingStock){
		$total_value = $NetRevenue - $NetVariableExpenses - $NetClosingStock;
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
	}
}

if(!function_exists('getAllGrossProfit'))
{
	function getAllGrossProfit($getAllNetRevenue, $getAllNetVariableExpenses, $getAllNetClosingStock){
		$total_value = $getAllNetRevenue - $getAllNetVariableExpenses - $getAllNetClosingStock;
		return $total_value;
	}
}

if(!function_exists('GrossProfitPercentage'))
{
	function GrossProfitPercentage($GrossProfit, $NetRevenue){
		$total_value = ($GrossProfit/$NetRevenue);
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
	}
}

if(!function_exists('getAllGrossProfitPercentage'))
{
	function getAllGrossProfitPercentage($getAllGrossProfit, $getAllNetRevenue){
		$total_value = ($getAllGrossProfit/$getAllNetRevenue);
		return $total_value;
	}
}



if(!function_exists('NetFixedCost'))
{
	function NetFixedCost($month_key,$table_id){
		if($month_key!='')
		{
		$fixed_expensesb = DB::table('_'.$table_id."_tbl_fixed_expenses")->get()->sum($month_key);
		$fixed_expensesx = DB::table('_'.$table_id."_tbl_fixed_expenses_x")->get()->sum($month_key);
		$total_value = $fixed_expensesb - $fixed_expensesx;
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
		}
	}
}

if(!function_exists('getAllNetFixedCost'))
{
	function getAllNetFixedCost($month_key){
		if($month_key!='')
		{
		$company = DB::table('tbl_add_company')->where('user_id', Auth::user()->id)->orderBy('company_name','ASC')->get();
		$total_value = 0;
		foreach($company as $allcompany)
		{
		$fixed_expensesb = DB::table('_'.$allcompany['_id']."_tbl_fixed_expenses")->get()->sum($month_key);
		$fixed_expensesx = DB::table('_'.$allcompany['_id']."_tbl_fixed_expenses_x")->get()->sum($month_key);
		$total_value += $fixed_expensesb - $fixed_expensesx;
		}
		return $total_value;
		}
	}
}
 
 
if(!function_exists('NetProfit'))
{
	function NetProfit($GrossProfit, $NetFixedCost){
		$total_value = ($GrossProfit - $NetFixedCost);
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
	}
}

if(!function_exists('getAllNetProfit'))
{
	function getAllNetProfit($getAllGrossProfit, $getAllNetFixedCost){
		$total_value = ($getAllGrossProfit - $getAllNetFixedCost);
		return $total_value;
	}
}


if(!function_exists('NetProfitMargin'))
{
	function NetProfitMargin($NetFixedCost, $NetRevenue){
		$total_value = ($NetFixedCost/$NetRevenue);
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
	}
}


if(!function_exists('getAllNetProfitMargin'))
{
	function getAllNetProfitMargin($getAllNetFixedCost, $getAllNetRevenue){
		$total_value = ($getAllNetFixedCost/$getAllNetRevenue);
		return $total_value;
	}
}


if(!function_exists('BreakEvenPoint'))
{
	function BreakEvenPoint($NetFixedCost, $GrossProfitPercentage){
		$total_value = ($NetFixedCost/$GrossProfitPercentage);
		if(is_numeric($total_value)){return $total_value;}else{return 0;}
	}
}

if(!function_exists('getAllBreakEvenPoint'))
{
	function getAllBreakEvenPoint($getAllNetFixedCost, $getAllGrossProfitPercentage){
		$total_value = ($getAllNetFixedCost/$getAllGrossProfitPercentage);
		return $total_value;
	}
}



if(!function_exists('companyTableCreate'))
{
	function companyTableCreate($company_id){
		Schema::create('_'.$company_id.'_tbl_add_april_opening_stock', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_add_april_opening_stock_x', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_average_monthly', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_average_monthly_x', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_closing_stock', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_closing_stock_x', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_fixed_expenses', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_fixed_expenses_x', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_opening_stock', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_purchases', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_purchases_x', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_sales', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_variable_expenses', function (Blueprint $table) {
            $table->timestamps();
        });
		Schema::create('_'.$company_id.'_tbl_variable_expenses_x', function (Blueprint $table) {
            $table->timestamps();
        });
	}
}


if(!function_exists('getPrefix'))
{
	function getPrefix($user_id){
	$data = DB::table('users')->select('company_session_id')->where('_id',$user_id)->first();
	   if(@$data['company_session_id']!=''){
		return '_'.$data['company_session_id'];
		}else{
		return '';
		}
	}
}


if(!function_exists('getCompanyDropdown'))
{
	function getCompanyDropdown($inputname,$user_id){
		$data = DB::table('tbl_add_company')->where('user_id',$user_id)->orderBy('company_name','ASC')
				->get()->toArray();
		//echo "<pre>"; print_r($data); die;	
		$selected = str_replace('_','',getPrefix($user_id));	
		if(!empty($data)){
				$dropdownHtml = '<select class="form-control company-dropdown" style="width:150px;" name="'.$inputname.'" >';
				foreach($data as $row)
				{
					if($selected==$row['_id']){
						$sel = ' selected';
					}else{
						$sel = '';
					}
					$dropdownHtml .= '<option '.$sel.' value="'.$row['_id'].'">'.$row['company_name'].'</option>';
				}
				 echo $dropdownHtml .= '</select>';
			}
	}
}



if(!function_exists('getProfitDropdown'))
{
	function getProfitDropdown($inputname,$user_id){
		$data = DB::table('tbl_add_company')->where('user_id',$user_id)->orderBy('company_name','ASC')
				->get()->toArray();
		$selected = str_replace('_','',getPrefix($user_id));	
		if(!empty($data)){
				$dropdownHtml = '<select class="profit-dropdown" name="'.$inputname.'" style="width:100px;"><option selected="selected" value="all">All Centres</option>';
				foreach($data as $row)
				{
					$dropdownHtml .= '<option value="'.$row['_id'].'">'.$row['company_name'].'</option>';
				}
				 echo $dropdownHtml .= '</select>';
			}
	}
}


if(!function_exists('getProfitDropdownPage'))
{
	function getProfitDropdownPage(){
		$data = DB::table('tbl_add_company')->where('user_id',Auth::user()->id)->orderBy('company_name','ASC')
				->get();
		if(!empty($data)){
		return $data;
		}else{
		return '';
		}
	}
}

if(!function_exists('getProfitDropdownPageajax'))
{
	function getProfitDropdownPageajax(){
		$data = DB::table('tbl_add_company')->where('user_id',Auth::user()->id)->orderBy('company_name','ASC')
				->first();
		if(!empty($data)){
		return $data;
		}else{
		return '';
		}
	}
}


if(!function_exists('getAllProfitLossCheck'))
{
	function getAllProfitLossCheck(){
		$data = DB::table('users')->where('_id',Auth::user()->id)->first();
		if($data['all_profit_loss']!=''){
		    return $data['all_profit_loss'];
		}else{
		    return 0;
		}
	}
}


function moneyFormatIndia($num){
        $nums = explode(".",$num);
        if(count($nums)>2){
            return "0";
        }else{
        if(count($nums)==1){
            $nums[1]="00";
        }
        $num = $nums[0];
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){

                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; 
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        echo "'Rs ".$thecash.".".$nums[1]."'"; 
        }
    }
    
     if(!function_exists('sendWhatsAppmsgWhatsAppXNew'))
	{
	 function sendWhatsAppmsgWhatsAppXNew($template_data='',$receiverMobileNo,$id,$user_id,$message_template='')
	 {
	    //pr($template_data); die;
	   $target_url = "https://app.messageautosender.com/api/v1/message/create";   
	    
		$post_data = array(
		    'username' => WhatsappSettingDetails()['username'],
		    'password' => WhatsappSettingDetails()['password'],
		    'receiverMobileNo' => preg_replace("/\s+/", "", $receiverMobileNo)
		    ); 
		    
	    if(!empty($template_data)){
	        $filePathUrl = array();
	        $caption = array();
	        foreach($template_data as $i=>$tmp_data)
	        {
	        if(!empty($tmp_data['gdrive_name'])){
	            $path = url('public/uploads/thumbnail/'.$tmp_data['gdrive_name']);
	            array_push($filePathUrl,$path);
	            array_push($caption,$tmp_data['caption']);
	        }else{
	            $path = '';
	            array_push($filePathUrl,$path);
	            $caption = '';
	            array_push($caption,$caption);
	        }  
	        }
	       $post_data['filePathUrl'] = $filePathUrl;
	       $post_data['caption'] = $caption;
	    }
		 
        if(!empty($message_template) && $message_template['message_text_single']!=''){
	        $post_data['message'] = array($message_template['message_text_single']);
	    }		    
		$post= json_encode($post_data);
		//pr($post_data); die;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $target_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");   
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Content-Type: application/json" ) ); 
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);   
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		
		
		$output = curl_exec ($ch);
		$results = json_decode($output);
		//echo '<hr/>';
		//pr($results); die; 
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$values = array('user_id' => $user_id,'recurring_message'=>$message,'receiver_mobile_number'=>$receiverMobileNo,'msg_id'=>$msg_id,'message_send_date'=>$message_send_date,'message_status'=>'UNPROCESSED');
        DB::table('tbl_recurring_report')->insert(array($values));
        $data_message2 = array("report_id" => $msg_id);
	    DB::table('tbl_whats_app_message')->where('_id',$id)->update($data_message2);
		
	 }
	}
	
	
	if(!function_exists('sendWhatsAppmsgWhatsAppX'))
	{
	 function sendWhatsAppmsgWhatsAppX($fname,$file_path,$ext,$receiverMobileNo,$receiverName,$message,$id,$user_id)
	 {
		$target_url = "https://app.messageautosender.com/api/v1/message/create";           
		$cfile = new CURLFile($file_path,$ext,$fname);
		$r_msg = str_replace('<br />',"\n",nl2br($message));
		$post = array('username' => WhatsappSettingDetails()['username'],'password' => WhatsappSettingDetails()['password'],'receiverMobileNo' => $receiverMobileNo,'receiverName' => $receiverName,'message' =>$r_msg,'uploadFile'=>$cfile); 
		//pr($post); die; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $target_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");   
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);   
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$output = curl_exec ($ch);
		$results = json_decode($output);
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$values = array('user_id' => $user_id,'recurring_message'=>$message,'receiver_mobile_number'=>$receiverMobileNo,'msg_id'=>$msg_id,'message_send_date'=>$message_send_date,'message_status'=>'UNPROCESSED');
        DB::table('tbl_recurring_report')->insert(array($values));
        $data_message2 = array("report_id" => $msg_id);
	    DB::table('tbl_whats_app_message')->where('_id',$id)->update($data_message2);
		
	 }
	}
	
	if(!function_exists('sendWhatsAppmsgWithoutFile'))
	{
	 function sendWhatsAppmsgWithoutFile($receiverMobileNo,$receiverName,$message,$id,$user_id)
	 {

		$target_url = "https://app.messageautosender.com/api/v1/message/create";
		$post = array('username'            => WhatsappSettingDetails()['username'],
		                'password'          => WhatsappSettingDetails()['password'],
		                'receiverMobileNo'  => $receiverMobileNo,
		                'receiverName'      => $receiverName,
		                'message'           => $message
		                );
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $target_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");   
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);   
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec ($ch);
		$results = json_decode($result);
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$values = array('user_id' => $user_id,'recurring_message'=>$message,'receiver_mobile_number'=>$receiverMobileNo,'msg_id'=>$msg_id,'message_send_date'=>$message_send_date,'message_status'=>'UNPROCESSED');
        DB::table('tbl_recurring_report')->insert(array($values));
        $data_message2 = array("report_id" => $msg_id);
	    DB::table('tbl_whats_app_message')->where('_id',$id)->update($data_message2);
	 }
	}
	
	if(!function_exists('WhatsappSettingDetails'))
	{
	 function WhatsappSettingDetails()
	 {
	    $data = DB::table('tbl_whatsapp_account_management')->where('make_as_default',1)->first();
	    //$data = array('username'=>'chaashni couture','password'=>'chaashni@456');
	    //$data = array('username'=>'antya','password'=>'antya@123');
	    return $data;
	 }
	}
	
	
	if(!function_exists('messageStatus'))
	{
	 function messageStatus($msg_id)
	 {
	  $url = "https://app.messageautosender.com/api/v1/message/status?username=".WhatsappSettingDetails()['username']."&password=".WhatsappSettingDetails()['password']."&messageId=".$msg_id;
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);      
		curl_close($ch); 
		$results = json_decode($output);
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$recipients_status = $results->result->recipients[0]->status;
		$data_message2 = array("message_status" => $recipients_status);
	    DB::table('tbl_recurring_report')->where('msg_id',$msg_id)->update($data_message2);
	    return $recipients_status;
	 }
	}
	
	
		if(!function_exists('messageStatusReport'))
	{
	 function messageStatusReport($msg_id)
	 {
	  $url = "https://app.messageautosender.com/api/v1/message/status?username=".WhatsappSettingDetails()['username']."&password=".WhatsappSettingDetails()['password']."&messageId=".$msg_id;
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);      
		curl_close($ch); 
		$results = json_decode($output);
		$status = $results->status;
		$msg = $results->message;
		$msg_id = (string)$results->result->id;
		$message_send_date = $results->result->creationTime;
		$recipients_status = $results->result->recipients[0]->status;
	    return date('d-m-Y H:i',strtotime($message_send_date));
	 }
	}
	
	
	if(!function_exists('nameOfContact'))
	{
	 function nameOfContact($id)
	 {
	 if($id!='')
	 {
	 $data = DB::table('tbl_whatsapp_contact')->where('_id',$id)->first();
		if($data['name_of_contact']!=''){
		    return $data['name_of_contact'];
		}else{
		    return 0;
		}
	 }
	 }
	}
	
	
	if(!function_exists('ContactList'))
	{
	 function ContactList()
	 {
	 $data = DB::table('tbl_whatsapp_contact')->where('user_id',Auth::id())->get();
		if(!empty($data)){
		    return $data;
		}else{
		    return '';
		}
	 }
	}
	
	if(!function_exists('ContactListDetails'))
	{
	 function ContactListDetails()
	 {
	 $data = DB::table('tbl_contact_details')->where('user_id',Auth::id())->get();
		if(!empty($data)){
		    return $data;
		}else{
		    return '';
		}
	 }
	}
	
	
	if(!function_exists('getContactName'))
	{
	 function getContactName($number)
	 {
	     if($number){
	 $data = DB::table('tbl_contact_details')->where('user_id',Auth::id())->where('receiver_mobile_number',$number)->first();
		if(!empty($data)){
		    return $data;
		}else{
		    return '';
		}
	     }
	 }
	}
	
	
	if(!function_exists('getContactNameData'))
	{
	 function getContactNameData($number)
	 {
	     if($number){
	 $data = DB::table('tbl_contact_details')->where('receiver_mobile_number',$number)->first();
		if(!empty($data)){
		    return $data['company_name'];
		}else{
		    return '';
		}
	     }
	 }
	}
	
	if(!function_exists('getCont'))
	{
	 function getCont($id)
	 {
	     if($id){
	 $data = DB::table('tbl_contact_details')->where('_id',$id)->first();
		if(!empty($data)){
		    return $data;
		}else{
		    return '';
		}
	     }
	 }
	}
	
	
	
    if(!function_exists('emailSend'))
    {
    function emailSend($to, $subject, $message, $senderEmail, $senderName, $files)
    {
    $from = $senderName." <".$senderEmail.">";  
    $headers = "From: $from"; 
    
    // Boundary  
    $semi_rand = md5(time());  
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
    
    // Headers for attachment  
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";  
    
    // Multipart boundary  
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";  
    
    $file_name = basename($files); 
    $file_size = filesize($files); 
    
    $message .= "--{$mime_boundary}\n"; 
    $fp =    @fopen($files, "rb"); 
    $data =  @fread($fp, $file_size); 
    @fclose($fp); 
    $data = chunk_split(base64_encode($data)); 
    $message .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\n" .  
    "Content-Description: ".$file_name."\n" . 
    "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".$file_size.";\n" .  
    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    
    
    $message .= "--{$mime_boundary}--"; 
    $returnpath = "-f" . $senderEmail; 
    
    // Send email 
    $mail = @mail($to, $subject, $message, $headers, $returnpath);  
    
    // Return true, if email sent, otherwise return false 
    if($mail){ 
    return true;
    }else{ 
    return false;
    } 
    }
    }

	
	if(!function_exists('messageTemplate'))
	{
	 function messageTemplate($id)
	 {
	 if($id!='')
	 {
	 $data = DB::table('tbl_template')->where('_id',$id)->first();
		if($data['name_of_template']!=''){
		    return $data['name_of_template'];
		}else{
		    return 0;
		}
	 }
	 }
	}
	
	if(!function_exists('menuHide'))
	{
	    function menuHide()
	    {
	        $data = DB::table('tbl_purchase_settings')->first();
	        return $data;
	    }
	}
	
	
	if(!function_exists('duplicateData'))
	{
	    function duplicateData($string)
	    {
        $array = explode(",",$string); 
        $array = array_unique($array);
        $string = implode(",",$array);
        return $string;
	    }
	}
	
	
    function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
    {
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
    $dateArr = array();
    do
    {
    if(date("w", $startDate) != $weekdayNumber)
    {
    $startDate += (24 * 3600); // add 1 day
    }
    } while(date("w", $startDate) != $weekdayNumber);
    
    
    while($startDate <= $endDate)
    {
    $dateArr[] = date('d-m-Y', $startDate);
    $startDate += (7 * 24 * 3600); // add 7 days
    }
    
    return $dateArr[0];
    }
    
    function purchase_data_items_val($id){
        
        if($id!=''){
          $purchase_data_items_val =  DB::table('tbl_purchase_order')->where('order_number', $id)->orderBy('_id', 'asc')->get();
          return $purchase_data_items_val;
        }else{
            return '';
        }
    }
    
    if(!function_exists('InstructedBy'))
    {
    function InstructedBy(){
    
    $data = User::where('user_id','5c5966020f0e7526c00021eb')->where('role_id',"1")->where('joined',"1")->get();
    return $data;
    }
    }
    
    
    if(!function_exists('getApproveData'))
    {
    function getApproveData($invoice_id){
    
    $data = DB::table('tbl_purchase_approve_update')->where('invoice_id', $invoice_id)->first();
    return $data;
    }
    }
    
    if(!function_exists('InstructedByAdmin'))
    {
    function InstructedByAdmin(){
    
    $data = User::where('_id','5c5966020f0e7526c00021eb')->first();
    return $data;
    }
    }
	
	
	 if(!function_exists('emailSendUser'))
    {
    function emailSendUser($to, $subject, $message)
    {
   
    $to = $to;
    $subject = $subject;
    $from = 'emailtoketan@gmail.com';
    
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    // Create email headers
    $headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    $mail = @mail($to, $subject, $message, $headers);
    if($mail){ 
    return true;
    }else{ 
    return false;
    } 
    }
    }
    
    
    if(!function_exists('quantityUpdateDetails'))
{
   function quantityUpdateDetails($id){
		if($id!='')
		{
		$data = DB::table('tbl_purchase_order_qty_update')->where('_id',$id)->first();
		return $data;
	
   }
   }
}
    
    
    if(!function_exists('getVendor'))
    {
    function getVendor()
    {
    $data = Vendor::orderBy('vendor_name','ASC')->get();
    return $data;  
    }
    }
    
    function generateRandomString($length = 24) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    function purchase_details($id){
        
        if($id!=''){
          $purchase_data_items_val =  DB::table('tbl_purchase_order')->where('_id', $id)->first();
          return $purchase_data_items_val['status'];
        }else{
            return '';
        }
    }
	