<?php

namespace App\Http\Controllers\purchaseorder;

use App\Http\Controllers\Controller;

use Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Response;

use App\Mail\SendMail;

use App\User;

use App\Vendor;

use App\PurchaseOrder;

use App\Item;

use App\Address;

use App\QuantityUpdate;

use App\Intake;

use Session;

use Config;

use PDF;
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);




class PurchaseOrderController extends Controller

{


    public function whatsappstatusupdatepo()
    {
        $records = DB::table('tbl_purchase_order')->where('status',1)->get();
        foreach($records as $records){
            if($records['report_id']!='')
            {
            $report_id = messageStatusPo($records['report_id']);
             if($report_id->result->recipients[0]->status=='SENT') 
             {
            $date = date('d-m-Y h:i A',strtotime($report_id->result->creationTime));
            $data = array('notification' =>$date);
            DB::table('tbl_purchase_order')->where("report_id",'=',$records['report_id'])->update($data);
             }
            }
        }
    }
     
     public function purchaseMessageReceiveData(Request $request)
     {
        //pr($request->all());
        $purchase_data_update = PurchaseOrder::find($request->id);
        $purchase_data_update->message_receive_type = $request->message_receive_type;
        if($request->message_receive_type=='Courier' || $request->message_receive_type=='Speed Post')
        {
        $purchase_data_update->message_receive = $request->message_receive_doc;  
        }else{
        $purchase_data_update->message_receive = $request->message_receive_date;
        }
        $purchase_data_update->save();
        Session::flash('success', 'Data save successfully!');
	    return redirect()->to('/purchaseorder/purchase-order-listing');
        
     }

	 public function purchaseOrderListing()

	{
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('status', 2)->groupBy('order_number')->orderBy('_id', 'desc')->get();
     $rights_check = DB::table('tbl_purchase_settings')->first();
	 $approval_rights = explode(',',$rights_check['approval_rights']);
	 return view('purchaseorder.purchase.purchase-order-listing',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val, 'approval_rights' => $approval_rights]);

	}
	
	public function purchaseOrderListingDraft()

	{
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('status', 2)->groupBy('order_number')->orderBy('_id', 'desc')->get();
     $rights_check = DB::table('tbl_purchase_settings')->first();
	 $approval_rights = explode(',',$rights_check['approval_rights']);
	 return view('purchaseorder.purchase.purchase-order-listing-draft',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val, 'approval_rights' => $approval_rights]);

	}
	
	public function purchaseOrderListingAwaitingApproval()

	{
     $autocomplete = $this->autocomplete();
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('status', 2)->groupBy('order_number')->orderBy('_id', 'desc')->get();
     $rights_check = DB::table('tbl_purchase_settings')->first();
	 $approval_rights = explode(',',$rights_check['approval_rights']);
	 return view('purchaseorder.purchase.purchase-order-listing-awaiting-approval',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val, 'approval_rights' => $approval_rights]);

	}
	
	public function purchaseOrderListingApproval()

	{
     $autocomplete = $this->autocomplete();
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('status', 2)->groupBy('order_number')->orderBy('_id', 'desc')->get();
     $rights_check = DB::table('tbl_purchase_settings')->first();
	 $approval_rights = explode(',',$rights_check['approval_rights']);
	 return view('purchaseorder.purchase.purchase-order-listing-approval',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val, 'approval_rights' => $approval_rights]);

	}
	
	public function purchaseOrderListingPoWise()

	{
     $autocomplete = $this->autocomplete();
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val =PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
     $rights_check = DB::table('tbl_purchase_settings')->first();
	 $approval_rights = explode(',',$rights_check['approval_rights']);
	 return view('purchaseorder.purchase.purchase-order-listing-po-wise',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val, 'approval_rights' => $approval_rights]);

	}
	
	public function purchaseOrderListingInvoiceWise()
	{
	 
    //$k = DB::table('tbl_purchase_order_qty_update_intake_form')
    //->leftJoin('tbl_purchase_order_qty_update','tbl_purchase_order_qty_update_intake_form.update_id','=','tbl_purchase_order_qty_update._id')
    //->where(['invoice_number' => '0016'])
    //->where('tbl_purchase_order_qty_update_intake_form.update_id','=','tbl_purchase_order_qty_update._id')
    //->get();
	 //pr($k);die;
	 //$k = DB::collection('tbl_purchase_order_qty_update_intake_form')
    //->where('invoice_number', '0016')->get();
    //pr($k); die;
	 $purchase_data_all = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val =PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data = DB::table('tbl_purchase_order_qty_update_intake_form')->select('update_id','invoice_date',[DB::raw('invoice_date')])->where('invoice_number','!=','')->where('invoice_date','!=','')->groupBy('invoice_number')->orderBy('invoice_number')->get();
	  
	//pr($purchase_data); die;
	 return view('purchaseorder.purchase.purchase-order-listing-invoice-wise',['purchase_data_all'=>$purchase_data_all,'purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val]);   
	}
	
	public function purchaseOrderListingItemWise()
	{
	 $purchase_data_all = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val =PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();  
	 $purchase_data = DB::table('tbl_purchase_order_qty_update')->select('item','invoice_date',[DB::raw('invoice_date')])->where('invoice_number','!=','')->where('invoice_date','!=','')->groupBy('item')->orderBy('item')->get();
	 //pr($purchase_data); die;
	 return view('purchaseorder.purchase.purchase-order-listing-item-wise',['purchase_data_all'=>$purchase_data_all,'purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val]);   
	}
	
	public function purchaseOrderPendingList()
	{
	 $autocomplete = $this->autocomplete();
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->orderBy('order_number', 'desc')->get();
     //pr($purchase_data_items_val); die;
     $purchase_data_items_val_item = DB::table('tbl_purchase_order_qty_update')->orderBy('item', 'asc')->get();
	 return view('purchaseorder.purchase.purchase-order-pending-list',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val,'purchase_data_items_val_item' => $purchase_data_items_val_item]);
	}
	
	public function purchaseOrderListingIntakeForm()

	{
	 session()->put('autoram', rand('9999999','1234567'));
     $autocomplete = $this->autocomplete();
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('status', 2)->groupBy('order_number')->orderBy('_id', 'desc')->get();
     $rights_check = DB::table('tbl_purchase_settings')->first();
	 $approval_rights = explode(',',$rights_check['approval_rights']);
	 return view('purchaseorder.purchase.purchase-order-listing-intake-form',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val, 'approval_rights' => $approval_rights, 'autocomplete' => $autocomplete]);

	}

	

	public function addPurchaseOrder()

	{

	$autocomplete = $this->autocomplete();

	$items = Item::get();

	$default_address = Address::where('default_address', 1)->first();

	$all_address = Address::all();

	$p = PurchaseOrder::max('order_number');

	if($p==''){

	$po_number = 'PO-0112';

	}else{

	$p1 = $p+1;

	if($p1<=9){

	$d = '000'.$p1;

	}else if($p1<=99){

	$d = '00'.$p1;

	}else if($p1<=999){

	$d = '0'.$p1;

	}else if($p1<=9999){

	$d = $p1;

	}

	$po_number = 'PO-'.$d;

	}
	$rights_check = DB::table('tbl_purchase_settings')->first();
	$approval_rights = explode(',',$rights_check['approval_rights']);
	
    $staff_data = User::where('user_role','!=','1')->where('user_id','=','5c5966020f0e7526c00021eb')->orderBy('_id', 'desc')->get();
	return view('purchaseorder.purchase.add-purchase-order',['autocomplete' => $autocomplete,'items' => $items,'default_address' => $default_address,'all_address' => $all_address,'po_number' => $po_number,'staff_data' => $staff_data,'approval_rights' => $approval_rights]);

	}

	

	

	public function viewPurchaseOrder(Request $request, $id)

	{

	$purchase_data = PurchaseOrder::find($id);

	return view('purchaseorder.purchase.view-purchase-order',['purchase_data' => $purchase_data]);

	}

	

	

	public function editPurchaseOrder(Request $request, $id)

	{

	$autocomplete = $this->autocomplete();

	$purchase_data = PurchaseOrder::find($id);

	$vendor_id = Vendor::select('_id')->where('vendor_code',$purchase_data['contact'])->first();

	$items = Item::where('vendor_id',$vendor_id['_id'])->get();

	$default_address = Address::where('default_address', 1)->first();

	$all_address = Address::all();
	$rights_check = DB::table('tbl_purchase_settings')->first();
	$approval_rights = explode(',',$rights_check['approval_rights']);

	//pr($purchase_data); die;
    $staff_data = User::where('user_role','!=','1')->where('user_id','=','5c5966020f0e7526c00021eb')->orderBy('_id', 'desc')->get();
	return view('purchaseorder.purchase.edit-purchase-order',['autocomplete' => $autocomplete,'items' => $items,'default_address' => $default_address,'all_address' => $all_address, 'purchase_data' => $purchase_data,'staff_data' => $staff_data,'approval_rights' => $approval_rights]);

	}

	

	public function purchaseorderapproved($id)

	{
	    //echo $id; die;
	  //pr($request->all()); die;

	  $purchase_data_update = PurchaseOrder::find($id);  

	  $purchase_data_update->status = 1;
	  
	  //$purchase_data_update->code_vendor = $request->code_vendor;
	  
	  //$purchase_data_update->vendor_mobile_number = $request->vendor_mobile_number;
	  
	  //$purchase_data_update->address_vendor = $request->address_vendor;

	  $status = 1;

	  $purchase_data_update->save();

	  

	$purchase_data = PurchaseOrder::find($id);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();
	
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();
	
	$vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	
	 $whatsAppMsg = 'Hello '.$vendor_name.'. Please find attached our new Purchase order #PO-'. $purchase_data->order_number.'. If you have any questions, please do not hesitate to call me back.';
	//sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg,$id);
	
	
	
	$own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);

	$html_content_owner = $view_owner->render();
	
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content_owner, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	
	PDF::reset();
	
	
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	$copy_of_staffs = explode(',',$purchase_data->copy_of_staffs);
	foreach($copy_of_staffs as $staffs){
	//sendWhatsAppmsg($filename,public_path('/pdf/owner/').$filename,userDetails($staffs)->phone,$purchase_data->contact,$whatsAppMsg_owner,$id);
	}
	
	
	
	
	
	$view_email = \View::make('purchaseorder.myPDF-email',['purchase_data' => $purchase_data]);

	$html_content_email = $view_email->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', 'A4');
    
    PDF::writeHTML($html_content_email, true, false, true, false, '');

	PDF::lastPage();

	$filename_email = 'Purchase-Order-email-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename_email, 'F');

	

	$purchase_data_update = PurchaseOrder::find($id);

	$purchase_data_update->sent = 1;

	$purchase_data_update->save();

	$datamail = array(

	'from'=> userDetails(Auth::id())->email,

	'type'=>'Sent email data',

	'subject'=>'Purchase Order # PO-'.$purchase_data_update->order_number.' from '.userDetails(Auth::id())->name.' for '.$purchase_data->contact,

	'message' => 'Dear '.$purchase_data->contact.

	',<br><br>Attached please find purchase order #PO-'. $purchase_data->order_number.' for INR '.$purchase_data->total.'.

	<br><br>If you have any questions, please do not hesitate to call me back. 

	<br><br>Thanks,

	<br><br>'.userDetails(Auth::id())->name.'<br>(Partner, ANTYA)',

	'filename' => $filename_email

	);

	



    $dir = public_path('/pdf/'.$filename_email);

	emailSend(vendorDetails($purchase_data_update->contact)->email, $datamail['subject'], $datamail['message'], $datamail['from'], 'Purchase Order', $dir);
   



	

	  Session::flash('success', 'Purchase Order approved successfully!');

	  return redirect()->to('/purchaseorder/purchase-order-listing');

	}
	
	public function purchaseorderapprovedsentAdmin(Request $request, $id)
	{
	$purchase_data = PurchaseOrder::find($id);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();
	
	$vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	
	$admin = DB::table('users')->where('user_role',1)->first();
	
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	 
	sendWhatsAppmsg($filename,public_path('/pdf/').$filename,$admin['phone'],$purchase_data->contact,$whatsAppMsg_owner,$id);
	
	Session::flash('success', 'Message sent successfully!');
	
	return redirect()->to('/purchaseorder/purchase-order-listing');
	
	}
	
	
	public function purchaseorderapprovedsentVendor(Request $request, $id)
	{
	 $purchase_data = PurchaseOrder::find($id);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();
	
	$vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	$whatsAppMsg = 'Hello '.$vendor_name.'. Please find attached our new Purchase order #PO-'. $purchase_data->order_number.'. If you have any questions, please do not hesitate to call me back.';
	sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg,$id);
	
	Session::flash('success', 'Message sent successfully!');
	return redirect()->to('/purchaseorder/purchase-order-listing');
	
	}
	
	public function purchaseorderapprovedsentStaff(Request $request, $id)
	{
	$own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);
	$html_content_owner = $view_owner->render();
	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);
	PDF::setLeftMargin(0);
	PDF::setTopMargin(2);
	PDF::setRightMargin(2);
	PDF::SetHeaderMargin(0);
	PDF::SetFooterMargin(-1);
	PDF::SetAutoPageBreak(TRUE);
    PDF::SetPrintHeader(TRUE);
    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');
    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    PDF::writeHTML($html_content_owner, true, false, true, false, '');
	PDF::lastPage();
	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';
	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	PDF::reset();
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	$copy_of_staffs = explode(',',$purchase_data->copy_of_staffs);
	foreach($copy_of_staffs as $staffs){
	sendWhatsAppmsg($filename,public_path('/pdf/owner/').$filename,userDetails($staffs)->phone,$purchase_data->contact,$whatsAppMsg_owner,$id);
	} 
	
	Session::flash('success', 'Message sent successfully!');
	return redirect()->to('/purchaseorder/purchase-order-listing');
	}
	
	public function purchaseorderapprovedsent(Request $request, $id)

	{
	    //echo $id; die;
	    //pr($request->all()); die;

	$purchase_data = PurchaseOrder::find($id);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();
	
	$vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	
	 $whatsAppMsg = 'Hello '.$vendor_name.'. Please find attached our new Purchase order #PO-'. $purchase_data->order_number.'. If you have any questions, please do not hesitate to call me back.';
	//sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg,$id);
	
	$own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);
	

	$html_content_owner = $view_owner->render();
	
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content_owner, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	
	PDF::reset();
	
	
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	$copy_of_staffs = explode(',',$purchase_data->copy_of_staffs);
	foreach($copy_of_staffs as $staffs){
	//sendWhatsAppmsg($filename,public_path('/pdf/owner/').$filename,userDetails($staffs)->phone,$purchase_data->contact,$whatsAppMsg_owner,$id);
	}
	

	  Session::flash('success', 'Message sent successfully!');

	  return redirect()->to('/purchaseorder/purchase-order-listing');

	}

	

	public function NewPurchaseOrderUpdate(Request $request, $id){
	    //pr($_POST); die;

	$purchase_data_update = PurchaseOrder::find($id);

	$purchase_data_update->contact = $request->contact;

	$purchase_data_update->date = $request->date;

	$purchase_data_update->delivery_date = $request->delivery_date;

	$purchase_data_update->order_number = str_replace('PO-','',$request->order_number);

	$purchase_data_update->row = $request->row;

	$purchase_data_update->total = $request->total;

	$purchase_data_update->gst_total = $request->gst_total;

	$purchase_data_update->subtotal = $request->subtotal;

	$purchase_data_update->address = $request->address;
	
	$purchase_data_update->copy_of_staffs = implode(',',$request->copy_of_staffs);
	
	$purchase_data_update->code_vendor = $request->code_vendor;
	
	$purchase_data_update->vendor_mobile_number = $request->vendor_mobile_number;
	
	$purchase_data_update->address_vendor = $request->address_vendor;
	$purchase_data_update->instructed_by = $request->instructed_by;
	
	//pr($request->address); die;

	$purchase_data_update->history_note = $request->history_note;

	if($request->save){

	$purchase_data_update->status = 0;

	$status = 0;

	}

	if($request->approve){

	$purchase_data_update->status = 1;

	$status = 1;

	}

	if($request->awaiting){

	$purchase_data_update->status = 2;

	$status = 2;

	}

	$purchase_data_update->save();

	
    DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->delete();
	for($i=1;$i<=count($request->row);$i++){

	$Insert_Users_Permission_Data = array("purchase_order_id"=>$id,"item"=>$request->row[$i]['item'],"item_sku"=>$request->row[$i]['item_sku'],"unit"=>$request->row[$i]['unit'],"quantity"=>$request->row[$i]['quantity'],"price"=>$request->row[$i]['price'],"disc"=>$request->row[$i]['disc'],"amount"=>$request->row[$i]['amount'],"gst"=>$request->row[$i]['gst'],"order_number"=>$request->row[$i]['order_number'],"order"=>$request->row[$i]['order'],"status"=>2,"receive_qty"=>"","received_date"=>"");

	DB::table('tbl_purchase_order_qty_update')->insert(array($Insert_Users_Permission_Data));


	}

	

	if($request->approve){

	$purchase_data = PurchaseOrder::find($id);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);

    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();

	

	$purchase_data_update = PurchaseOrder::find($id);

	$purchase_data_update->sent = 1;

	$purchase_data_update->save();



	$vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	
	$whatsAppMsg = 'Hello '.$vendor_name.'. Please find attached our new Purchase order #PO-'. $purchase_data->order_number.'. If you have any questions, please do not hesitate to call me back.';
    //sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg,$id);
    
    
    $own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);

	$html_content_owner = $view_owner->render();
	
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content_owner, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	
	PDF::reset();
	
	
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	$copy_of_staffs = explode(',',$purchase_data->copy_of_staffs);
	foreach($copy_of_staffs as $staffs){
	//sendWhatsAppmsg($filename,public_path('/pdf/owner/').$filename,userDetails($staffs)->phone,$purchase_data->contact,$whatsAppMsg_owner,$id);
	}
	
	
	
	
	$view_email = \View::make('purchaseorder.myPDF-email',['purchase_data' => $purchase_data]);

	$html_content_email = $view_email->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', 'A4');

    PDF::writeHTML($html_content_email, true, false, true, false, '');

	PDF::lastPage();

	$filename_email = 'Purchase-Order-email-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename_email, 'F');
	
	
	
	$datamail = array(

	'from'=> userDetails(Auth::id())->email,

	'type'=>'Sent email data',

	'subject'=>'Purchase Order # PO-'.$purchase_data_update->order_number.' from '.userDetails(Auth::id())->name.' for '.$purchase_data->contact,

	'message' => 'Dear '.$purchase_data->contact.

	',<br><br>Attached please find purchase order #PO-'. $purchase_data->order_number.' for INR '.$purchase_data->total.'.

	<br><br>If you have any questions, please do not hesitate to call me back. 

	<br><br>Thanks,

	<br><br>'.userDetails(Auth::id())->name.'<br>(Partner, ANTYA)',

	'filename' => $filename_email

	);

    $dir = public_path('/pdf/'.$filename_email);

	emailSend(vendorDetails($purchase_data_update->contact)->email, $datamail['subject'], $datamail['message'], $datamail['from'], 'Purchase Order', $dir);

	}

	Session::flash('success', 'Purchase Order updated successfully!');

	return redirect()->to('/purchaseorder/purchase-order-listing');

	}

	

	

	public function purchaseDelete(Request $request, $id)

	{

	    PurchaseOrder::find($id)->delete();

		DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->delete();

	    Session::flash('success', 'Purchase Order deleted successfully!');

		return redirect()->to('/purchaseorder/purchase-order-listing');

	}

	

	public function autocomplete()

    {

	$data = DB::table('tbl_vendor')->select('id', 'vendor_name','vendor_code')->where('vendor_code','!=','')->orderBy('vendor_name','asc')->get();

    $results=array();

      foreach ($data as $key => $v) {

	    // $r['id'] = (string)$v['_id'];

	     $r['code'] = $v['vendor_code'];

          array_push($results,$v['vendor_code']);

      }

	 $d = implode("','",$results);

	 return $d;

      //return json_encode($results)."\n";

	  //Storage::disk('local')->put('data.json', json_encode($results));

    }

	

	

	public function NewPurchaseOrder(Request $request)

	{
     //$k = array_filter($request->row);
	   // echo $_POST['reference']; die;

	//pr($k); die;
	
	$data_config = DB::table('tbl_config_setting')->first();
	//pr($data_config); die;
	
	$p1 = $data_config['invoice_id']+1;

	if($p1<=9){

	$d = '000'.$p1;

	}else if($p1<=99){

	$d = '00'.$p1;

	}else if($p1<=999){

	$d = '0'.$p1;

	}else if($p1<=9999){

	$d = $p1;

	}

	
	

	$purchase_data_save = new PurchaseOrder;

	$purchase_data_save->contact = $request->contact;

	$purchase_data_save->date = $request->date;

	$purchase_data_save->delivery_date = $request->delivery_date;

	$purchase_data_save->order_number = $d;

	$purchase_data_save->row = array_filter($request->row);

	$purchase_data_save->total = $request->total;

	$purchase_data_save->gst_total = $request->gst_total;

	$purchase_data_save->subtotal = $request->subtotal;

	$purchase_data_save->address = $request->address;

	$purchase_data_save->history_note = $request->history_note;
	
	$purchase_data_save->copy_of_staffs = implode(',',$request->copy_of_staffs);
	
	$purchase_data_save->code_vendor = $request->code_vendor;
	
	$purchase_data_save->vendor_mobile_number = $request->vendor_mobile_number;
	
	$purchase_data_save->address_vendor = $request->address_vendor;
	
	$purchase_data_save->instructed_by = $request->instructed_by;

	if($request->save){

	$purchase_data_save->status = 0;

	$status = 0;

	}

	if($request->approve){

	$purchase_data_save->status = 1;

	$status = 1;

	}

	if($request->awaiting){

	$purchase_data_save->status = 2;

	$status = 2;

	}

	$purchase_data_save->save();

	$insertedId = $purchase_data_save->id; 

	for($i=1;$i<=count($request->row);$i++){

	$Insert_Users_Permission_Data = array("purchase_order_id"=>$insertedId,"item"=>$request->row[$i]['item'],"item_sku"=>$request->row[$i]['item_sku'],"unit"=>$request->row[$i]['unit'],"quantity"=>$request->row[$i]['quantity'],"price"=>$request->row[$i]['price'],"disc"=>$request->row[$i]['disc'],"amount"=>$request->row[$i]['amount'],"gst"=>$request->row[$i]['gst'],"order_number"=>$request->row[$i]['order_number'],"order"=>$request->row[$i]['order'],"status"=>2,"receive_qty"=>"","received_date"=>"");

	DB::table('tbl_purchase_order_qty_update')->insert(array($Insert_Users_Permission_Data));

	}

	if($request->approve){

	$purchase_data = PurchaseOrder::find($insertedId);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(1);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);

    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();

	$vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	
	$whatsAppMsg = 'Hello '.$vendor_name.'. Please find attached our new Purchase order #PO-'. $purchase_data->order_number.'. If you have any questions, please do not hesitate to call me back.';
	//sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg,$insertedId);
	
	
	$own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);

	$html_content_owner = $view_owner->render();
	
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content_owner, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	
	PDF::reset();
	
	
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	$copy_of_staffs = explode(',',$purchase_data->copy_of_staffs);
	foreach($copy_of_staffs as $staffs){
	//sendWhatsAppmsg($filename,public_path('/pdf/owner/').$filename,userDetails($staffs)->phone,$purchase_data->contact,$whatsAppMsg_owner,$insertedId);
	}
	
	
	
	$view_email = \View::make('purchaseorder.myPDF-email',['purchase_data' => $purchase_data]);

	$html_content_email = $view_email->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(1);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', 'A4');

    PDF::writeHTML($html_content_email, true, false, true, false, '');

	PDF::lastPage();

	$filename_email = 'Purchase-Order-email-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename_email, 'F');
	

	$purchase_data_update = PurchaseOrder::find($insertedId);

	$purchase_data_update->sent = 1;

	$purchase_data_update->save();

	$datamail = array(

	'from'=> userDetails(Auth::id())->email,

	'type'=>'Sent email data',

	'subject'=>'Purchase Order # PO-'.$purchase_data_update->order_number.' from '.userDetails(Auth::id())->name.' for '.$purchase_data->contact,

	'message' => 'Dear '.$purchase_data->contact.

	',<br><br>Attached please find purchase order #PO-'. $purchase_data->order_number.' for INR '.$purchase_data->total.'.

	<br><br>If you have any questions, please do not hesitate to call me back. 

	<br><br>Thanks,

	<br><br>'.userDetails(Auth::id())->name.'<br>(Partner, ANTYA)',

	'filename' => $filename_email

	);

	
    $dir = public_path('/pdf/'.$filename_email);

	emailSend(vendorDetails($purchase_data_update->contact)->email, $datamail['subject'], $datamail['message'], $datamail['from'], 'Purchase Order', $dir);

	}
	
	DB::table('tbl_config_setting')->update(array('invoice_id' =>$d));

	Session::flash('success', 'New Purchase Order added successfully!');

	return redirect()->to('/purchaseorder/purchase-order-listing');

	}

	

	public function purchaseOrderBilled(Request $request, $id)

	{

	$purchase_data_update = PurchaseOrder::find($id);

	$purchase_data_update->status = 3;

	$purchase_data_update->save();



	Session::flash('success', 'Purchase Order PO-'.$purchase_data_update->order_number.' has been marked as billed');

	return redirect()->to('/purchaseorder/view-purchase-order/'.$id);

	}

	

	public function purchaseOrderSend(Request $request, $id)

	{

	//echo public_path('pdf/'); die;

		$purchase_data = PurchaseOrder::find($id);

	$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

	$html_content = $view->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

   PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);

    PDF::writeHTML($html_content, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	PDF::reset();

	if($request->whatsappsend==1){
    $vendor_name = vendorDetails($purchase_data->contact)['vendor_name'];
	$whatsAppMsg = 'Hello '.$vendor_name.'. Please find attached our new Purchase order #PO-'. $purchase_data->order_number.'. If you have any questions, please do not hesitate to call me back.';
	//sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg,$id);
	
	
	$own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);

	$html_content_owner = $view_owner->render();
	
	

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content_owner, true, false, true, false, '');

	PDF::lastPage();

	$filename = 'Purchase-Order-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	
	PDF::reset();
	
	
	$whatsAppMsg_owner = 'The following PO has been issued to your vendor '.$purchase_data->contact.'. Please take note.';
	$copy_of_staffs = explode(',',$purchase_data->copy_of_staffs);
	foreach($copy_of_staffs as $staffs){
	//sendWhatsAppmsg($filename,public_path('/pdf/owner/').$filename,userDetails($staffs)->phone,$purchase_data->contact,$whatsAppMsg_owner,$id);
	}
	
	

	}

	$purchase_data_update = PurchaseOrder::find($id);

	$purchase_data_update->sent = 1;

	$purchase_data_update->save();
	
	
	
	$view_email = \View::make('purchaseorder.myPDF-email',['purchase_data' => $purchase_data]);

	$html_content_email = $view_email->render();

	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', 'A4');

    PDF::writeHTML($html_content_email, true, false, true, false, '');

	PDF::lastPage();

	$filename_email = 'Purchase-Order-email-'.$purchase_data->order_number.'.pdf';

	PDF::Output(public_path('/pdf/').$filename_email, 'F');
	
	

	$datamail = array(

	'from'=> userDetails(Auth::id())->email,

	'type'=>'Sent email data',

	'subject'=>'Purchase Order # PO-'.$purchase_data_update->order_number.' from '.userDetails(Auth::id())->name.' for '.$purchase_data->contact,

	'message' => 'Dear '.$purchase_data->contact.

	',<br><br>Attached please find purchase order #PO-'. $purchase_data->order_number.' for INR '.$purchase_data->total.'.

	<br><br>If you have any questions, please do not hesitate to call me back. 

	<br><br>Thanks,

	<br><br>'.userDetails(Auth::id())->name.'<br>(Partner, ANTYA)',

	'filename' => $filename_email

	);

	

    $dir = public_path('/pdf/'.$filename_email);

	emailSend(vendorDetails($purchase_data_update->contact)->email, $datamail['subject'], $datamail['message'], $datamail['from'], 'Purchase Order', $dir);

	

	Session::flash('success', 'Purchase Order PO-'.$purchase_data_update->order_number.' has been marked as sent');

	return redirect()->to('/purchaseorder/view-purchase-order/'.$id);

	}

	

	

	

	public function generatePDF(Request $request, $id)

    {

        $purchase_data = PurchaseOrder::find($id);
        
		$view = \View::make('purchaseorder.myPDF-email',['purchase_data' => $purchase_data]);

        $html_content = $view->render();

        PDF::SetTitle('purchase-order-'.$purchase_data->order_number);

		PDF::setLeftMargin(0);

		PDF::setTopMargin(2);

		PDF::setRightMargin(2);

		PDF::SetHeaderMargin(0);

		PDF::SetFooterMargin(-1);

		PDF::SetAutoPageBreak(TRUE);

        PDF::SetPrintHeader(TRUE);

        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::lastPage();

		$filename = 'purchase-order-'.$purchase_data->order_number.'.pdf';

        PDF::Output(public_path('/pdf/').$filename, 'F');
        
        PDF::reset();

		$headers = array('Content-Type: application/pdf',);

        return Response::download(public_path('/pdf/').$filename, $filename,$headers);
        
       
    }
    
    
    public function generatePDFVendorDesktop(Request $request, $id)

    {

        $purchase_data = PurchaseOrder::find($id);
        
		$view = \View::make('purchaseorder.myPDF-email',['purchase_data' => $purchase_data]);

        $html_content = $view->render();

        PDF::SetTitle('PO-'.$purchase_data->order_number.'D');

		PDF::setLeftMargin(0);

		PDF::setTopMargin(2);

		PDF::setRightMargin(2);

		PDF::SetHeaderMargin(0);

		PDF::SetFooterMargin(-1);

		PDF::SetAutoPageBreak(TRUE);

        PDF::SetPrintHeader(TRUE);

        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::lastPage();

		$filename = 'PO-'.$purchase_data->order_number.'D.pdf';

        PDF::Output(public_path('/pdf/').$filename, 'F');
        
        PDF::reset();

		$headers = array('Content-Type: application/pdf',);

        return Response::download(public_path('/pdf/').$filename, $filename,$headers);
        
       
    }
    
    public function generatePDFVendorMobile(Request $request, $id)

    {

        $purchase_data = PurchaseOrder::find($id);
        
		$view = \View::make('purchaseorder.myPDF',['purchase_data' => $purchase_data]);

        $html_content = $view->render();

        PDF::SetTitle('PO-'.$purchase_data->order_number.'V');

		PDF::setLeftMargin(0);

		PDF::setTopMargin(2);

		PDF::setRightMargin(2);

		PDF::SetHeaderMargin(0);

		PDF::SetFooterMargin(-1);

		PDF::SetAutoPageBreak(TRUE);

        PDF::SetPrintHeader(TRUE);

        PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
        PDF::writeHTML($html_content, true, false, true, false, '');

	    PDF::lastPage();

		$filename = 'PO-'.$purchase_data->order_number.'V.pdf';

        PDF::Output(public_path('/pdf/').$filename, 'F');
        
        PDF::reset();

		$headers = array('Content-Type: application/pdf',);

        return Response::download(public_path('/pdf/').$filename, $filename,$headers);
        
       
    }
    
    public function generatePDFStaffMobile(Request $request, $id)

    {

    $purchase_data = PurchaseOrder::find($id);
    
    $own_data = DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')->first();
    
    $view_owner = \View::make('purchaseorder.myPDF-owner',['purchase_data' => $purchase_data,'own_data' => $own_data]);

	$html_content_owner = $view_owner->render();
	
	//PDF::SetTitle('staff-mobile-purchase-order-'.$purchase_data->order_number);
	PDF::SetTitle('PO-'.$purchase_data->order_number.'S');

	PDF::setLeftMargin(0);

	PDF::setTopMargin(2);

	PDF::setRightMargin(2);

	PDF::SetHeaderMargin(0);

	PDF::SetFooterMargin(-1);

	PDF::SetAutoPageBreak(TRUE);

    PDF::SetPrintHeader(TRUE);

    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');

    PDF::AddPage('P', array('170','155'), true, 'UTF-8', false);
    
    PDF::writeHTML($html_content_owner, true, false, true, false, '');

	PDF::lastPage();

	//$filename = 'staff-mobile-purchase-order-'.$purchase_data->order_number.'.pdf';
	
	$filename = 'PO-'.$purchase_data->order_number.'S.pdf';

	PDF::Output(public_path('/pdf/owner/').$filename, 'F');
	
	$headers = array('Content-Type: application/pdf',);

    return Response::download(public_path('/pdf/owner/').$filename, $filename,$headers);

    }
    
    
    public function generatePDFStaffDesktop(Request $request, $id)

    {

        $purchase_data = PurchaseOrder::find($id);
        
		$view = \View::make('purchaseorder.myPDF-owner-desktop',['purchase_data' => $purchase_data]);

        $html_content = $view->render();

        //PDF::SetTitle('staff-desktop-purchase-order-'.$purchase_data->order_number);
        
        PDF::SetTitle('PO-'.$purchase_data->order_number.'SD');

		PDF::setLeftMargin(0);

		PDF::setTopMargin(2);

		PDF::setRightMargin(2);

		PDF::SetHeaderMargin(0);

		PDF::SetFooterMargin(-1);

		PDF::SetAutoPageBreak(TRUE);

        PDF::SetPrintHeader(TRUE);

        PDF::AddPage('P', 'A4');

        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::lastPage();

		//$filename = 'staff-desktop-purchase-order-'.$purchase_data->order_number.'.pdf';
		
		$filename = 'PO-'.$purchase_data->order_number.'SD.pdf';

        PDF::Output(public_path('/pdf/owner/').$filename, 'F');
        
        PDF::reset();

		$headers = array('Content-Type: application/pdf',);

        return Response::download(public_path('/pdf/owner/').$filename, $filename,$headers);
        
       
    }

	public function ajaxItemQuantityUpdateData(Request $request, $qty_val, $order_number, $item_number,$order,$received_date,$invoice_number)

	{

	$data = array("receive_qty"=>$qty_val,"received_date"=>$received_date,"received_through_invoice_number"=>$invoice_number);

	//DB::table('tbl_purchase_order_qty_update')->where("_id",'=',$order)->update($data);

	echo date('d M Y');

	}


   
   
   public function ajaxTypeheadDatacheck($id,$ven)
	{
	$vendor_id = Vendor::select('_id')->where('vendor_code',$id)->first();
	$items = Item::where('vendor_id',$vendor_id['_id'])->get();
	if($vendor_id['_id']!='')
	{
	$html = "<option value=''>None</option>";
	foreach($items as $allitems)
	{
    if($allitems->_id==$ven){
    $sel = 'selected="selected"';
    }else{
    $sel = '';   
    }
	$html .='<option '.$sel.' value="'.$allitems->_id.'">'.$allitems->item_name.'</option>';
	}
	return $html;
	}else{
	return '';
	}
	}
	

	public function ajaxTypeheadData($id)

	{

	$vendor_id = Vendor::select('_id')->where('vendor_code',$id)->first();

	$items = Item::where('vendor_id',$vendor_id['_id'])->get();

	if($vendor_id['_id']!='')

	{

	$html = "<option value=''>None</option>";

	foreach($items as $allitems)

	{

	$html .='<option value="'.$allitems->_id.'">'.$allitems->item_name.'</option>';

	}

	return $html;

	}else{

	return '';

	}

	}
	
	public function ajaxTypeheadData2($id,$list)

	{
    $new_list = array_filter(explode(',',$list));
    //pr($new_list); die;
	$vendor_id = Vendor::select('_id')->where('vendor_code',$id)->first();

	$items = Item::where('vendor_id',$vendor_id['_id'])->get();

	if($vendor_id['_id']!='')

	{

	$html = "<option value=''>None</option>";

	foreach($items as $allitems)

	{
     if(@in_array($allitems->_id,$new_list)){
         
     }else{
	$html .='<option value="'.$allitems->_id.'">'.$allitems->item_name.'</option>';
     }

	}

	return $html;

	}else{

	return '';

	}

	}

	
    	public function ajaxaddressDataPost(Request $request) {
		
		$address_data_save = new Address;
		$address_data_save->label = $request->label;
		$address_data_save->street_address = addslashes($request->street_address);
		$address_data_save->town_city = $request->town_city;
		$address_data_save->state_region = $request->state_region;
		$address_data_save->zip_code = $request->zip_code;
		$address_data_save->country = $request->country;
		$address_data_save->tel_country = $request->tel_country;
		$address_data_save->tel_area = $request->tel_area;
		$address_data_save->tel_number = $request->tel_number;
		$address_data_save->instruction = $request->instruction;
		$address_data_save->user_id = Auth::id();
		$address_data_save->save();
		$address_data = Address::orderBy('_id', 'asc')->get();
		$html = '';
        foreach($address_data as $address)
        {
        $html .= '<li class="add" id="'.$address->_id.'"><h2>'.$address->label.'</h2><p>'.$address->street_address.$address->town_city.'<br/>'.$address->state_region.'<br/>'.$address->zip_code.'<br/>'.$address->country.'</p></li>';   
        }
        echo $html; 
		
	}
	
	public function ajaxinvoiceApprove($id)
	{
	$Insert_Users = array("invoice_id"=>$id,"user_id"=>Auth::id(),"created_time"=>time(),"status"=>"1");
	DB::table('tbl_purchase_approve_update')->insert(array($Insert_Users));
	$ajax_table =  'Approved by <br/>'.userDetails(Auth::id())->name.' <br/>on '.date('jS M Y');
	$ajax_on_table =  'Approved by '.userDetails(Auth::id())->name.' on '.date('jS M Y');
	$data = array('ajax_table'=>$ajax_table,'ajax_on_table'=>$ajax_on_table);
	echo json_encode($data);
	}
	
	
	
	public function purchaseorderIntake(Request $request)
	{
	  //pr($request->all()); die;
	  $Invoice_Number = $request->invoice_number;
	  $invoice_date = $request->invoice_date;
	  $date_receiving = $request->date_receiving;
	  $item_id = count($request->item_id);
	  $id = $request->item_id;
	  for($i=0;$i<$item_id;$i++)
	  {
	      $qty_received = $request->intake[$i];
	      $received_price = $request->intake_price[$i];
	      $item = $request->item_id[$i];
	      $qty = DB::table('tbl_purchase_order_qty_update')->where("_id",'=',$item)->first();
	      $data = array('qty_received'=>$qty['qty_received']+$qty_received,'received_price'=>$received_price,'invoice_number'=>$Invoice_Number,'invoice_date'=>$invoice_date,'date_receiving'=>$date_receiving);
	     //echo $item; die;
	      //pr($data); die;
	      DB::table('tbl_purchase_order_qty_update')->where("_id",'=',$item)->update($data);
	      
	      $data2 = array('update_id'=>$item,'qty_received'=>$qty_received,'received_price'=>$received_price,'invoice_number'=>$Invoice_Number,'invoice_date'=>$invoice_date,'date_receiving'=>$date_receiving);
	     //echo $item; die;
	      //pr($data); die;
	      DB::table('tbl_purchase_order_qty_update_intake_form')->insert($data2);
	      
	      
	  }
	  Session::flash('success', 'Intake save successfully!');
	  return redirect()->to('/purchaseorder/purchase-order-listing-intake-form');
	}
	
	public function ajaxPendingList($type, $vendor)
	{
	 $purchase_data_val = DB::table('tbl_purchase_order_qty_update')->groupBy('order_number')->orderBy('order_number', 'desc')->get();
	 $purchase_data_items_val_item = DB::table('tbl_purchase_order_qty_update')->select('item','order_number')->groupBy('item')->orderBy('item', 'asc')->get();
	 //pr($purchase_data_items_val_item); die;
	 if($type=="po" && $vendor!='' && $type!='')
	 {?>
	    <a style="float:right; margin-bottom:10px;" type="button" href="<?php echo url('purchaseorder/po-wise-pdf/'.$vendor);?>" class="btn btn-primary waves-effect waves-classic">Download</a>
        <table class="table responsive-table dataTable center-table po-view" id="editableTable1" cellspacing="0">
        <thead>
        <tr class="white-space-tr">
        <th class="po-th">PO#</th>
        <th class="Item-th">Item</th>
        <th class="Item-th">Item SKU</th>
        <th class="Item-th">Notes</th>
        <th class="pending-quantity-th">Pending Quantity</th>
        </tr>
        </thead>
        <tbody id="result-data">
        <?php
        $total = 0;
        foreach($purchase_data_val as $data){
        if($data['order_number']!='' && purchaseOrderDetails($data['order_number'])->contact==$vendor){
         purchaseDataUpdateDelete($data['order_number'],purchaseOrderDetails($data['order_number'])->contact);
         $data_update_val = purchaseDataUpdateDetails($data['order_number']);
         $w=0;
         $k=0;
         foreach($data_update_val as $key=>$data_v){
         $select_data = Item::find($data_v['item']);
         if(($data_v['quantity']-$data_v['qty_received'])>0 && purchase_details($data_v['purchase_order_id'])==1){
             purchaseDataUpdateInsert($data['order_number'],$data_v['purchase_order_id'],$vendor);
        ?>
        <tr <?php if($w==0){?> class="po-show" <?php }?>>
        <td <?php if($w==0){?> class="po-show" <?php }else{ ?> class="po-hide" <?php } ?> data-table="PO#"><?php if($w==0){?>PO-<?php echo $data['order_number'];?><?php } ?></td>
        <td data-table="Item"><?php echo ItemDetails($data_v['item']);?></td>
        <td data-table="Item SKU"><?php echo $select_data['item_sku'];?></td>
        <td data-table="Notes"><?php echo purchaseOrderDetails($data['order_number'])->address['instruction'];?></td>
        <td data-table="Pending Quantity"><?php echo $data_v['quantity']-$data_v['qty_received'];?></td>
        </tr>
        <?php $total += $data_v['quantity']-$data_v['qty_received'];$w++; $k++;}}}} ?> 
        <?php if($total>0){?>
        <tr>
        <td colspan="4" class="right">Total : </td>
        <td data-table="Total :"><strong><?php echo $total;?></strong></td>
        </tr>
        <?php }else{?>
        <tr>
        <td colspan="5" class="no-data-table" align="center">There are no purchase orders to display.</td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
	 <?php }else if($type=="item" && $vendor!='' && $type!=''){?>
	 <a style="float:right; margin-bottom:10px;" type="button" href="<?php echo url('purchaseorder/item-wise-pdf/'.$vendor);?>" class="btn btn-primary waves-effect waves-classic">Download</a>
	 <table class="table responsive-table dataTable center-table item-view" id="editableTable1" cellspacing="0">
  <thead>
    <tr class="white-space-tr">
      <th class="Item-th">Item</th>
      <th class="Item-th">Item SKU</th>
      <th class="po-th">PO#</th>
      <th class="Item-th">Notes</th>
      <th class="pending-quantity-th">Pending Quantity</th>
    </tr>
  </thead>
 <tbody id="result-data">
      <?php
      $array = array();
      foreach($purchase_data_items_val_item as $data_item){
      if($data_item['item']!='' && purchaseOrderDetails($data_item['order_number'])->contact==$vendor){
          purchaseDataUpdateDeleteItem($data_item['item'],purchaseOrderDetails($data_item['order_number'])->contact);
         $data_update_val_item = purchaseDataUpdateDetailsItem($data_item['item']);
         foreach($data_update_val_item as $i=>$data_i){
         $select_data = Item::find($data_i['item']);
         if(($data_i['quantity']-$data_i['qty_received'])>0 && purchase_details($data_i['purchase_order_id'])==1){
             $d['item'] = ItemDetails($data_item['item']);
             $d['item_id'] = $data_item['item'];
             array_push($array,$data_item['item']);
         ?>
        
      <?php }}}}
      $data_array = array_unique($array);
      if(!empty($data_array)){
          $total_item = 0;
      foreach($data_array as $array_d){?>
          <?php
          $data_val_item = purchaseDataUpdateDetailsItem($array_d);
          $t=0;
          foreach($data_val_item as $k=>$data_k){
         $select_data = Item::find($data_k['item']);
         if(($data_k['quantity']-$data_k['qty_received'])>0 && purchase_details($data_k['purchase_order_id'])==1){
             purchaseDataUpdateInsertItem($data_k['item'],$data_k['purchase_order_id'],$vendor);
         ?>
         <tr <?php if($t==0){?> class="po-show" <?php }?>>
        <td <?php if($t==0){?> class="po-show" <?php }else{ ?> class="po-hide" <?php } ?> data-table="Item"><?php if($t==0){?><?php echo ItemDetails($array_d);?><?php } ?></td>
        <td data-table="Item SKU"><?php echo $select_data['item_sku'];?></td>
        <td data-table="PO#">PO-<?php echo $data_k['order_number'];?></td>
        <td data-table="Notes"><?php echo purchaseOrderDetails($data_k['order_number'])->address['instruction'];?></td>
        <td data-table="Pending Quantity"><?php echo $data_k['quantity']-$data_k['qty_received'];?></td>
        </tr>
      <?php $t++;$total_item +=$data_k['quantity']-$data_k['qty_received'];}}}}
      ?>
      <?php if($total_item>0){?>
        <tr>
        <td colspan="4" class="right">Total : </td>
        <td data-table="Total :"><strong><?php echo $total_item;?></strong></td>
        </tr>
        <?php }else{?>
        <tr>
        <td colspan="5" class="no-data-table" align="center">There are no purchase orders to display.</td>
        </tr>
        <?php } ?>
  </tbody>
</table> 
	 <?php }
	}
	
	public function ajaxItemIntakeForm($id, $vendor_name,$row_data)
	{
	    //echo $id; die;
	    if($row_data==0){
	        $row = 1000;
	    }else{
	        $row = 1000+$row_data;
	    }
	    $sel = $this->ajaxTypeheadDatacheck($vendor_name,$id);
	    //echo $sel;die;
	    $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('item', $id)->where('status',2)->get(); 
	    //pr($purchase_data_items_val); die;
	    //array_unique($purchase_data_items_val);
	    foreach($purchase_data_items_val as $key=>$data){
	    //if(purchaseOrderDetails($data['order_number'])->date!=''){
	    ?>
        <tr id="sa-<?php echo $key;?>" class="joy-<?php echo $row;?> center">
        <?php
        if($key==0){?>
        <td data-table="Item" class="has-input item-td-intake">
        <select required class="form-control width-full item select2 item-select" cus="<?php echo $key+$row;?>" rel="item" id="tmp_id_item_<?php echo $key+$row;?>" name="item[]">
        <?php echo $sel; ?>
        </select>
        </td>
        <?php }else{?>
        <td data-table="Item" style="border-bottom: 0px solid #e0e0e0 !important;">
        &nbsp;
        </td>
        <?php }?>
        <td id="po-<?php echo $key+$row;?>" data-table="PO#">PO-<?php echo $data['order_number'];?></td>
        <input type="hidden" value="<?php echo $data['order_number'];?>" name="po_number[]" id="po-val-<?php echo $key+$row;?>">
        <input type="hidden" value="<?php echo $data['_id'];?>" name="item_id[]" id="item-id-val-<?php echo $key+$row;?>">
        <td id="podate-<?php echo $key+$row;?>" data-table="PO Date"><?php echo purchaseOrderDetails($data['order_number'])->date;?></td>
        <input type="hidden" name="po_date[]" value="<?php echo purchaseOrderDetails($data['order_number'])->date;?>" id="podate-val-<?php echo $key+$row;?>">
        <td class="center" id="qorder-<?php echo $key+$row;?>" data-table="Q. Ordered"><?php echo $data['quantity'];?></td>
        <input type="hidden" name="qty_ordered[]" value="<?php echo $data['quantity'];?>" id="qorder-val-<?php echo $key+$row;?>">
        <td id="poprice-<?php echo $key+$row;?>" data-table="Price"><?php echo $data['price'];?></td>
        <input type="hidden" name="po_price[]" value="<?php echo $data['price'];?>" id="poprice-val-<?php echo $key+$row;?>">
        <td class="center" id="qreceived-<?php echo $key+$row;?>" data-table="Q. Received"><?php if($data['qty_received']==''){echo 0;}else{echo $data['qty_received'];}?></td>
        <input type="hidden" name="qty_received[]" value="<?php if($data['qty_received']==''){echo 0;}else{echo $data['qty_received'];}?>" id="qreceived-val-<?php echo $key+$row;?>">
        <td id="rprice-<?php echo $key+$row;?>" data-table="Price"><?php if($data['received_price']==''){echo '--';}else{echo $data['received_price'];}?></td>
        <input type="hidden" name="received_price[]" value="<?php if($data['received_price']==''){echo '--';}else{echo $data['received_price'];}?>" id="rprice-val-<?php echo $key+$row;?>">
        <td id="inv-<?php echo $key+$row;?>" data-table="Invoice Date"><?php if($data['invoice_date']==''){echo '--';}else{echo $data['invoice_date'];}?></td>
        <input type="hidden" name="inv[]" value="<?php if($data['invoice_date']==''){echo '--';}else{echo $data['invoice_date'];}?>" id="inv-val-<?php echo $key+$row;?>">
        <td id="rec-<?php echo $key+$row;?>" data-table="Received On"><?php if($data['date_receiving']==''){echo '--';}else{echo $data['date_receiving'];}?></td>
        <input type="hidden" name="rec[]" value="<?php if($data['date_receiving']==''){echo '--';}else{echo $data['date_receiving'];}?>" id="rec-val-<?php echo $key+$row;?>">
        <td class="center" id="bqtn-<?php echo $key+$row;?>" data-table="Balance Q."><?php echo $data['quantity']-$data['qty_received'];?></td>
        <input type="hidden" name="balance_qty[]" value="<?php echo $data['quantity']-$data['qty_received'];?>" id="bqtn-val-<?php echo $key+$row;?>">
        <td class="has-input" data-table="Intake"><input type="text" required="required" id="intake-<?php echo $key+$row;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" name="intake[]" class="forn-input intake"></td>
        <td class="has-input" data-table="Price"><input type="text" required="required" id="intake_price-<?php echo $key+$row;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" name="intake_price[]" class="forn-input intake_price"></td>
        </tr>
	    <?php }
	    //}
	}
	
	public function poWisepdf($vendor)
	{
	$purchase_data_val = DB::table('tbl_purchase_order_qty_update')->groupBy('order_number')->orderBy('order_number', 'desc')->get();
	$view = \View::make('purchaseorder.powisePDF',['purchase_data_val' => $purchase_data_val,'vendor' => $vendor]);
	$html_content = $view->render(); 
	PDF::SetTitle('purchase-order-po-wise-pdf');
	PDF::setLeftMargin(0);
	PDF::setTopMargin(2);
	PDF::setRightMargin(2);
	PDF::SetHeaderMargin(0);
	PDF::SetFooterMargin(-1);
	PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_HEADER);
    PDF::SetPrintHeader(TRUE);
    //PDF::set_paper(array(0, 0, 595, 841), 'portrait');
    PDF::AddPage('P', 'A4', true, 'UTF-8', false);
    PDF::writeHTML($html_content, true, false, true, false, '');
	PDF::lastPage();
	$filename = $vendor.'-PO-Wise-Pending-Orders.pdf';
	PDF::Output(public_path('/pdf/pendinglist/').$filename, 'F');
	PDF::reset();
	$headers = array('Content-Type: application/pdf',);
    return Response::download(public_path('/pdf/pendinglist/').$filename, $filename,$headers);
	}
	
	public function itemWisepdf($vendor)
	{
	$purchase_data_items_val_item = DB::table('tbl_purchase_order_qty_update')->select('item','order_number')->groupBy('item')->orderBy('item', 'asc')->get();
	  $array = array();
      foreach($purchase_data_items_val_item as $data_item){
              if($data_item['item']!='' && purchaseOrderDetails($data_item['order_number'])->contact==$vendor){
                 $data_update_val_item = purchaseDataUpdateDetailsItem($data_item['item']);
                 foreach($data_update_val_item as $i=>$data_i){
                    if(($data_i['quantity']-$data_i['qty_received'])>0 && purchase_details($data_i['purchase_order_id'])==1){
                        array_push($array,$data_item['item']);
                    }
                 }
              }
        }
        
        $data_array = array_unique($array);
        $view = \View::make('purchaseorder.itemwisePDF',['data_array' => $data_array,'vendor' => $vendor]);
        $html_content = $view->render();
        PDF::SetTitle('purchase-order-item-wise-pdf');
        PDF::setLeftMargin(0);
        PDF::setTopMargin(2);
        PDF::setRightMargin(2);
        PDF::SetHeaderMargin(0);
        PDF::SetFooterMargin(-1);
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_HEADER);
        PDF::SetPrintHeader(TRUE);
        //PDF::set_paper(array(0, 0, 595, 841), 'portrait');
        PDF::AddPage('P', 'A4', true, 'UTF-8', false);
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::lastPage();
        $filename = $vendor.'-Item-Wise-Pending-Orders.pdf';
        PDF::Output(public_path('/pdf/pendinglist/').$filename, 'F');
        PDF::reset();
        $headers = array('Content-Type: application/pdf',);
        return Response::download(public_path('/pdf/pendinglist/').$filename, $filename,$headers);
	}

}

