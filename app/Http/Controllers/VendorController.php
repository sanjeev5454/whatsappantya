<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\User;
use App\Vendor;
use Session;
use Config;


class VendorController extends Controller {

	public function vendorListing() {
		$vendor_data = Vendor::orderBy('_id', 'desc')->paginate(5);
		return view('vendor.vendor-listing',['vendor_data' => $vendor_data]);
	}
	
	public function addVendor() {
		return view('vendor.add-vendor');
	}
	
	public function vendorDataPost(Request $request) {
		$customMessages = [
			'vendor_name.*' => 'Vendor Name must be filled out.',
			'email.unique' => 'Email should be unique.',
			'whatsapp_number.*' => 'Whatsapp number must be 10 digits.',
			'mobile_number.*' => 'Mobile number must be 10 digits.',
			'contact_person.*' => 'Contact person must be filled out.',
			'address.*' => 'Address must be filled out.',
		];
		$this->validate($request, [
			'vendor_name' => 'required',
			'address' => 'required',
			'contact_person' => 'required',
			'email' => 'required|email|unique:tbl_vendor',
			'whatsapp_number' => 'required|min:10',
			'mobile_number' => 'required|min:10',	
		],$customMessages);
		
		$vendor_data_save = new Vendor;
		$vendor_data_save->vendor_name = $request->vendor_name;
		$vendor_data_save->address = addslashes($request->address);
		$vendor_data_save->email = $request->email;
		$vendor_data_save->contact_person = $request->contact_person;
		$vendor_data_save->whatsapp_number = $request->whatsapp_number;
		$vendor_data_save->mobile_number = $request->mobile_number;
		$vendor_data_save->notification = $request->notification;
		$vendor_data_save->save();
		Session::flash('success', 'Vendor added successfully!');
		return redirect()->to('/vendor-listing');
	}
	
	public function editVendor(Request $request, $id) {
		$vendor_data = Vendor::find($id);
		return view('vendor.edit-vendor',['vendor_data' => $vendor_data]);
	}
	
	public function vendorDataUpdate(Request $request, $id){
		$customMessages = [
			'vendor_name.*' => 'Vendor Name must be filled out.',
			'email.unique' => 'Email should be unique.',
			'whatsapp_number.*' => 'Whatsapp number must be 10 digits.',
			'mobile_number.*' => 'Mobile number must be 10 digits.',
			'contact_person.*' => 'Contact person must be filled out.',
			'address.*' => 'Address must be filled out.',
		];
		$this->validate($request, [
			'vendor_name' => 'required',
			'address' => 'required',
			'contact_person' => 'required',
			'email' => 'required|email|unique:tbl_vendor,email,'.$id.',_id',
			'whatsapp_number' => 'required|min:10',
			'mobile_number' => 'required|min:10',	
		],$customMessages);
	
		$vendor_data_update = Vendor::find($id);
		$vendor_data_update->vendor_name = $request->vendor_name;
		$vendor_data_update->address = addslashes($request->address);
		$vendor_data_update->email = $request->email;
		$vendor_data_update->contact_person = $request->contact_person;
		$vendor_data_update->whatsapp_number = $request->whatsapp_number;
		$vendor_data_update->mobile_number = $request->mobile_number;
		$vendor_data_update->notification = $request->notification;
		$vendor_data_update->save();
		Session::flash('success', 'Vendor updated successfully!');
		return redirect()->to('/vendor-listing');
	}
	
	public function vendorDelete(Request $request, $id) {
	    Vendor::where('_id','=',$id)->delete();
	    Session::flash('success', 'Vendor deleted successfully!');
		return redirect()->to('/vendor-listing');
	}	
}