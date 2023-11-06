<?php

namespace App\Http\Controllers;
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
use Session;
use Config;
use PDF;


class PurchaseOrderController extends Controller
{
     
	 public function purchaseOrderListing()
	{
	 $purchase_data = PurchaseOrder::orderBy('_id', 'desc')->get();
	 $purchase_data_draft = PurchaseOrder::where('status', 0)->orderBy('_id', 'desc')->get();
	 $purchase_data_approved = PurchaseOrder::where('status', 1)->orderBy('_id', 'desc')->get();
	 $purchase_data_awaiting = PurchaseOrder::where('status', 2)->orderBy('_id', 'desc')->get();
	 $purchase_data_billed = PurchaseOrder::where('status', 3)->orderBy('_id', 'desc')->get();
	 $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('status', 1)->orderBy('_id', 'desc')->paginate(10);
	 

   /*  $purchase_data_items_val = array();
	 foreach($purchase_data_items as $key=>$value){ 
	 $purchase_data_items_val = array_merge($purchase_data_items_val,$value->row);
	 }*/
	 //$p = array_merge($purchase_data_items_val, $k);
     //pr($purchase_data_items_val); die;

	 return view('purchase.purchase-order-listing',['purchase_data' => $purchase_data,'purchase_data_draft' => $purchase_data_draft, 'purchase_data_approved' => $purchase_data_approved, 'purchase_data_awaiting' => $purchase_data_awaiting,'purchase_data_billed' => $purchase_data_billed,'purchase_data_items_val' => $purchase_data_items_val]);
	}
	
	public function addPurchaseOrder()
	{
	$autocomplete = $this->autocomplete();
	$items = Item::get();
	$default_address = Address::where('default_address', 1)->first();
	$all_address = Address::all();
	$p = PurchaseOrder::max('order_number');
	if($p==''){
	$po_number = 'PO-0001';
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
	return view('purchase.add-purchase-order',['autocomplete' => $autocomplete,'items' => $items,'default_address' => $default_address,'all_address' => $all_address,'po_number' => $po_number]);
	}
	
	
	public function viewPurchaseOrder(Request $request, $id)
	{
	$purchase_data = PurchaseOrder::find($id);
	return view('purchase.view-purchase-order',['purchase_data' => $purchase_data]);
	}
	
	
	public function editPurchaseOrder(Request $request, $id)
	{
	$autocomplete = $this->autocomplete();
	$purchase_data = PurchaseOrder::find($id);
	$vendor_id = Vendor::select('_id')->where('vendor_name',$purchase_data['contact'])->first();
	$items = Item::where('vendor_id',$vendor_id['_id'])->get();
	$default_address = Address::where('default_address', 1)->first();
	$all_address = Address::all();
	//pr($purchase_data); die;
	return view('purchase.edit-purchase-order',['autocomplete' => $autocomplete,'items' => $items,'default_address' => $default_address,'all_address' => $all_address, 'purchase_data' => $purchase_data]);
	}
	
	public function NewPurchaseOrderUpdate(Request $request, $id){
	$purchase_data_update = PurchaseOrder::find($id);
	$purchase_data_update->contact = $request->contact;
	$purchase_data_update->date = $request->date;
	$purchase_data_update->delivery_date = $request->delivery_date;
	$purchase_data_update->order_number = str_replace('PO-','',$request->order_number);
	$purchase_data_update->reference = $request->reference;
	$purchase_data_update->row = $request->row;
	$purchase_data_update->total = $request->total;
	$purchase_data_update->gst_total = $request->gst_total;
	$purchase_data_update->subtotal = $request->subtotal;
	$purchase_data_update->address = $request->address;
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
	
	for($i=1;$i<=count($request->row);$i++){
	$count = DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->where('order',$i)->get()->count();
	if($count<=0){
	$Insert_Users_Permission_Data = array("purchase_order_id"=>$id,"item"=>$request->row[$i]['item'],"item_sku"=>$request->row[$i]['item_sku'],"unit"=>$request->row[$i]['unit'],"quantity"=>$request->row[$i]['quantity'],"price"=>$request->row[$i]['price'],"disc"=>$request->row[$i]['disc'],"amount"=>$request->row[$i]['amount'],"gst"=>$request->row[$i]['gst'],"order_number"=>$request->row[$i]['order_number'],"order"=>$request->row[$i]['order'],"status"=>$status,"receive_qty"=>"","received_date"=>"");
	DB::table('tbl_purchase_order_qty_update')->insert(array($Insert_Users_Permission_Data));
	}else{
	$data = array("item"=>$request->row[$i]['item'],"item_sku"=>$request->row[$i]['item_sku'],"description"=>$request->row[$i]['description'],"unit"=>$request->row[$i]['unit'],"quantity"=>$request->row[$i]['quantity'],"price"=>$request->row[$i]['price'],"disc"=>$request->row[$i]['disc'],"amount"=>$request->row[$i]['amount'],"gst"=>$request->row[$i]['gst'],"order_number"=>$request->row[$i]['order_number'],"order"=>$request->row[$i]['order'],"status"=>$status);
	DB::table('tbl_purchase_order_qty_update')->where("_id",'=',$id)->update($data);
	}
	}
	
	Session::flash('success', 'Purchase Order updated successfully!');
	return redirect()->to('/purchase-order-listing');
	}
	
	
	public function purchaseDelete(Request $request, $id)
	{
	    PurchaseOrder::find($id)->delete();
		DB::table('tbl_purchase_order_qty_update')->where('purchase_order_id',$id)->delete();
	    Session::flash('success', 'Purchase Order deleted successfully!');
		return redirect()->to('/purchase-order-listing');
	}
	
	public function autocomplete()
    {
	$data = DB::table('tbl_vendor')->select('id', 'vendor_name')->orderBy('vendor_name','asc')->get();
    $results=array();
      foreach ($data as $key => $v) {
	    // $r['id'] = (string)$v['_id'];
	     $r['name'] = $v['vendor_name'];
          array_push($results,$v['vendor_name']);
      }
	 $d = implode("','",$results);
	 return $d;
      //return json_encode($results)."\n";
	  //Storage::disk('local')->put('data.json', json_encode($results));
    }
	
	
	public function NewPurchaseOrder(Request $request)
	{
	//pr($request->row); die;
	$purchase_data_save = new PurchaseOrder;
	$purchase_data_save->contact = $request->contact;
	$purchase_data_save->date = $request->date;
	$purchase_data_save->delivery_date = $request->delivery_date;
	$purchase_data_save->order_number = str_replace('PO-','',$request->order_number);
	$purchase_data_save->reference = $request->reference;
	$purchase_data_save->row = $request->row;
	$purchase_data_save->total = $request->total;
	$purchase_data_save->gst_total = $request->gst_total;
	$purchase_data_save->subtotal = $request->subtotal;
	$purchase_data_save->address = $request->address;
	$purchase_data_save->history_note = $request->history_note;
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
	$Insert_Users_Permission_Data = array("purchase_order_id"=>$insertedId,"item"=>$request->row[$i]['item'],"item_sku"=>$request->row[$i]['item_sku'],"unit"=>$request->row[$i]['unit'],"quantity"=>$request->row[$i]['quantity'],"price"=>$request->row[$i]['price'],"disc"=>$request->row[$i]['disc'],"amount"=>$request->row[$i]['amount'],"gst"=>$request->row[$i]['gst'],"order_number"=>$request->row[$i]['order_number'],"order"=>$request->row[$i]['order'],"status"=>$status,"receive_qty"=>"","received_date"=>"");
	DB::table('tbl_purchase_order_qty_update')->insert(array($Insert_Users_Permission_Data));
	}
	Session::flash('success', 'New Purchase Order added successfully!');
	return redirect()->to('/purchase-order-listing');
	}
	
	public function purchaseOrderBilled(Request $request, $id)
	{
	$purchase_data_update = PurchaseOrder::find($id);
	$purchase_data_update->status = 3;
	$purchase_data_update->save();

	Session::flash('success', 'Purchase Order PO-'.$purchase_data_update->order_number.' has been marked as billed');
	return redirect()->to('/view-purchase-order/'.$id);
	}
	
	public function purchaseOrderSend(Request $request, $id)
	{
	//echo public_path('pdf/'); die;
	$purchase_data = PurchaseOrder::find($id);
	$view = \View::make('myPDF',['purchase_data' => $purchase_data]);
	$html_content = $view->render();
	PDF::SetTitle('purchase-order-'.$purchase_data->order_number);
	PDF::SetMargins(5, 5);
	PDF::SetHeaderMargin(0);
	PDF::SetAutoPageBreak(TRUE);
	PDF::SetPrintHeader(TRUE);
	PDF::AddPage('P', 'A4');
	PDF::writeHTML($html_content, true, false, true, false, '');
	PDF::lastPage();
	$filename = 'purchase-order-'.$purchase_data->order_number.'-'.date('Y-m-d-h-i-s').'.pdf';
	PDF::Output(public_path('/pdf/').$filename, 'F');
	
	$purchase_data_update = PurchaseOrder::find($id);
	$purchase_data_update->sent = 1;
	$purchase_data_update->save();
	$datamail = array(
	'from'=> userDetails(Auth::id())->email,
	'type'=>'Sent email data',
	'subject'=>'Purchase Order # PO-'.$purchase_data_update->order_number.' from '.userDetails(Auth::id())->name.' for '.$purchase_data->contact,
	'message' => 'Hi '.$purchase_data->contact.
	',<br><br>Here\'s purchase order PO-'. $purchase_data->order_number.' for INR '.$purchase_data->total.'
	<br><br>Delivery due date, address and instructions are included in the purchase order.
	<br><br>If you have any questions, 
	<br><br>Please let us know.
	<br><br>Thanks,
	<br>'.userDetails(Auth::id())->name,
	'filename' => $filename
	);
	$whatsAppMsg = 'Hi '.$purchase_data->contact.',
Here purchase order PO-'. $purchase_data->order_number.' for INR '.$purchase_data->total.'
Thanks.';
	
	Mail::to(vendorDetails($purchase_data_update->contact)->email)->send(new SendMail($datamail));
	//Mail::to('sanjay.adhek@techvoi.com')->send(new SendMail($datamail));
	if($request->whatsappsend==1){
	sendWhatsAppmsg($filename,public_path('/pdf/').$filename,vendorDetails($purchase_data->contact)->whatsapp_number,$purchase_data->contact,$whatsAppMsg);
	}
	Session::flash('success', 'Purchase Order PO-'.$purchase_data_update->order_number.' has been marked as sent');
	return redirect()->to('/view-purchase-order/'.$id);
	}
	
	
	public function generatePDF(Request $request, $id)
    {
	
        $purchase_data = PurchaseOrder::find($id);
		$view = \View::make('myPDF',['purchase_data' => $purchase_data]);
        $html_content = $view->render();
        PDF::SetTitle('purchase-order-'.$purchase_data->order_number);
		PDF::SetMargins(5, 5);
		PDF::SetHeaderMargin(0);
		PDF::SetAutoPageBreak(TRUE);
        PDF::SetPrintHeader(TRUE);
        PDF::AddPage('P', 'A4');
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::lastPage();
		$filename = 'purchase-order-'.$purchase_data->order_number.'-'.date('Y-m-d-h-i-s').'.pdf';
        PDF::Output(public_path('/pdf/').$filename, 'F');
		$headers = array('Content-Type: application/pdf',);
        return Response::download(public_path('/pdf/').$filename, $filename,$headers);
		//PDF::Output($filename);
		//return redirect()->to('/view-purchase-order/'.$id);
    }
	
	public function ajaxItemQuantityUpdateData(Request $request, $qty_val, $order_number, $item_number,$order)
	{
	$data = array("receive_qty"=>$qty_val,"received_date"=>date('d M Y'));
	DB::table('tbl_purchase_order_qty_update')->where("_id",'=',$order)->update($data);
	echo date('d M Y');
	}
	
	public function ajaxTypeheadData($id)
	{
	$vendor_id = Vendor::select('_id')->where('vendor_name',$id)->first();
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
	
	
	
}
