<?php

namespace App\Http\Controllers\purchaseorder;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\User;
use App\Vendor;
use App\Item;
use Session;
use Config;


class ItemController extends Controller
{
     
	 public function itemListing()
	{
	 $item_data = Item::orderBy('_id', 'desc')->get();
	 return view('purchaseorder.item.item-listing',['item_data' => $item_data]);
	}
	
	public function addItem()
	{
	$data = DB::table('tbl_purchase_settings')->first();
	$vendors = Vendor::orderBy('vendor_name', 'asc')->get();
	$other_unit_data = DB::table('tbl_other_unit')->where('user_id', Auth::id())->first();
	if(!empty($other_unit_data))
	{
	$other_unit = explode(',',$other_unit_data['other_unit']);
	}else{
	$other_unit = '';
	}
	return view('purchaseorder.item.add-item',['vendors'=>$vendors,'other_unit' => $other_unit,'data'=>$data]);
	}
	
	public function itemDataPost(Request $request)
	{
		$customMessages = [
		'item_name.*' => 'Item Name must be filled out.',
		'item_sku.unique' => 'Item SKU should be unique.',
		'unit.*' => 'Unit must be filled out.',
		'other_unit.*' => 'Other Unit must be filled out.',
		'price.*' => 'Price must be filled out.',
		'vendor_id.*' => 'Vendor Name must be filled out.',
		'gst.*' => 'GST must be filled out.',
		];
		if($request->unit=='Other')
		{
		$this->validate($request, [
		'item_name' => 'required',
		'item_sku' => 'required|unique:tbl_items',
		'unit' => 'required',
		'other_unit' => 'required',
		'price' => 'required',
		'vendor_id' => 'required',	
		'gst' => 'required',
		],$customMessages);
		}else{
		$this->validate($request, [
		'item_name' => 'required',
		'item_sku' => 'required|unique:tbl_items',
		'unit' => 'required',
		'price' => 'required',
		'vendor_id' => 'required',	
		'gst' => 'required',
		],$customMessages);
		}
	
		$item_data_save = new Item;
		$item_data_save->item_name = $request->item_name;
		$item_data_save->item_sku = $request->item_sku;
		$item_data_save->description = stripslashes($request->description);
		$item_data_save->unit = $request->unit;
		$item_data_save->quantity = 1;
		$item_data_save->price = $request->price;
		$item_data_save->vendor_id = $request->vendor_id;
		$item_data_save->gst = $request->gst;
		$item_data_save->user_id = Auth::id();
		$item_data_save->status = 1;
		$item_data_save->save();
		$insertedId = $item_data_save->id;
		if($request->other_unit!=''){
		$count = DB::table('tbl_other_unit')->where('user_id', '=', Auth::id())->count();
		if($count<=0)
		{
		$data = array('other_unit'=>$request->other_unit,'user_id'=>Auth::id());
	    DB::table('tbl_other_unit')->insertGetId($data);
		}else{
		$data_other = DB::table('tbl_other_unit')->where('user_id', '=', Auth::id())->first();
		$other_unit = $data_other['other_unit'];
		$data = array('other_unit'=>$other_unit.','.$request->other_unit);
	    DB::table('tbl_other_unit')->where('user_id',Auth::id())->update($data);
		}
		}
		Session::flash('success', 'Item added successfully!');
		return redirect()->to('/purchaseorder/item-listing');
	}
	
	
	
	
	public function editItem(Request $request, $id)
	{
	    $data = DB::table('tbl_purchase_settings')->first();
		$vendors = Vendor::orderBy('vendor_name', 'asc')->get();
		$item_data = Item::find($id);
		$other_unit_data = DB::table('tbl_other_unit')->where('user_id', Auth::id())->first();
		if(!empty($other_unit_data))
		{
		$other_unit = explode(',',$other_unit_data['other_unit']);
		}else{
		$other_unit = '';
		}
		if(!empty($item_data)){
		return view('purchaseorder.item.edit-item',['item_data' => $item_data,'vendors'=>$vendors,'other_unit'=>$other_unit,'data'=>$data]);
		}else{
		return view('purchaseorder.errors.illustrated-layout');
		}
	
	}
	
	public function itemDataUpdate(Request $request, $id){
	$customMessages = [
		'item_name.*' => 'Item Name must be filled out.',
		'item_sku.unique' => 'Item SKU should be unique.',
		'unit.*' => 'Unit must be filled out.',
		'other_unit.*' => 'Other Unit must be filled out.',
		'price.*' => 'Price must be filled out.',
		'vendor_id.*' => 'Vendor Name must be filled out.',
		'gst.*' => 'GST must be filled out.',
		];
		if($request->unit=='Other')
		{
		$this->validate($request, [
		'item_name' => 'required',
		'item_sku' => 'required|unique:tbl_items,item_sku,'.$id.',_id',
		'unit' => 'required',
		'other_unit' => 'required',
		'price' => 'required',
		'vendor_id' => 'required',	
		'gst' => 'required',
		],$customMessages);
		}else{
		$this->validate($request, [
		'item_name' => 'required',
		'item_sku' => 'required|unique:tbl_items,item_sku,'.$id.',_id',
		'unit' => 'required',
		'price' => 'required',
		'vendor_id' => 'required',	
		'gst' => 'required',
		],$customMessages);
		}
	
	$item_data_update = Item::find($id);
	$item_data_update->item_name = $request->item_name;
	$item_data_update->item_sku = $request->item_sku;
	$item_data_update->description = stripslashes($request->description);
	$item_data_update->unit = $request->unit;
	$item_data_update->quantity = 1;
	$item_data_update->price = $request->price;
	$item_data_update->vendor_id = $request->vendor_id;
	$item_data_update->gst = $request->gst;
	$item_data_update->user_id = Auth::id();
	$item_data_update->status = 1;
	$item_data_update->save();
	if($request->other_unit!=''){
	$count = DB::table('tbl_other_unit')->where('user_id', '=', Auth::id())->count();
	if($count<=0)
	{
	$data = array('other_unit'=>$request->other_unit,'user_id'=>Auth::id());
	DB::table('tbl_other_unit')->insertGetId($data);
	}else{
	$data_other = DB::table('tbl_other_unit')->where('user_id', '=', Auth::id())->first();
	$other_unit = $data_other['other_unit'];
	$data = array('other_unit'=>$other_unit.','.$request->other_unit);
	DB::table('tbl_other_unit')->where('user_id',Auth::id())->update($data);
	}
	}
	Session::flash('success', 'Item updated successfully!');
	return redirect()->to('/purchaseorder/item-listing');
	}
	
	
	public function itemDelete(Request $request, $id)
	{
	    Item::find($id)->delete();
	    Session::flash('success', 'item deleted successfully!');
		return redirect()->to('/purchaseorder/item-listing');
	}
	
	public function ajaxItemData(Request $request, $id)
	{
	  $select_data = Item::find($id);
	  $arr = array('id' => $select_data['_id'],'item_sku' => $select_data['item_sku'], 'description' => $select_data['description'], 'unit' => $select_data['unit'], 'quantity' => $select_data['quantity'], 'price' => $select_data['price'], 'gst' => $select_data['gst']);
      return json_encode($arr);
	}
	
}
