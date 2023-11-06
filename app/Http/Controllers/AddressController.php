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
use App\Address;
use Session;
use Config;

class AddressController extends Controller {
 
	public function deliveryAddress() {
		$address_data = Address::orderBy('_id', 'desc')->get();
		return view('address.delivery-address',['address_data' => $address_data]);
	}
	
	public function addAddress() {
		return view('address.add-address');
	}
	
	public function addressDataPost(Request $request) {
		$customMessages = [
			'label.*' => 'Label must be filled out.',
			'street_address.*' => 'Address must be filled out.',
		];
		$this->validate($request, [
			'label' => 'required',
			'street_address' => 'required',	
		],$customMessages);
		
		$address_data_save = new Address;
		$address_data_save->label = $request->label;
		$address_data_save->attention = addslashes($request->attention);
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
		Session::flash('success', 'Address added successfully!');
		return redirect()->to('/delivery-address');
	}
	
	public function editAddress(Request $request, $id) {
		$address_data = Address::find($id);
		return view('address.edit-address',['address_data' => $address_data]);
	}
	
	public function addressDataUpdate(Request $request, $id){
		$customMessages = [
			'label.*' => 'Label must be filled out.',
			'street_address.*' => 'Address must be filled out.',
		];
		$this->validate($request, [
			'label' => 'required',
			'street_address' => 'required',	
		],$customMessages);
	
		$address_data_update = Address::find($id);
		$address_data_update->label = $request->label;
		$address_data_update->attention = addslashes($request->attention);
		$address_data_update->street_address = addslashes($request->street_address);
		$address_data_update->town_city = $request->town_city;
		$address_data_update->state_region = $request->state_region;
		$address_data_update->zip_code = $request->zip_code;
		$address_data_update->country = $request->country;
		$address_data_update->tel_country = $request->tel_country;
		$address_data_update->tel_area = $request->tel_area;
		$address_data_update->tel_number = $request->tel_number;
		$address_data_update->instruction = $request->instruction;
		$address_data_update->user_id = Auth::id();
		$address_data_update->save();
		Session::flash('success', 'Address updated successfully!');
		return redirect()->to('/delivery-address');
	}
	
	public function defaultAddress(Request $request, $id) {
		$address_update = Address::find($id);
		DB::table('tbl_address')->where('user_id',Auth::id())->update(['default_address' =>0]);
		$address_data_update = Address::find($id);
		$address_data_update->default_address = 1;
		$address_data_update->save();
		return redirect()->to('/delivery-address');
	}
	
	public function addressDelete(Request $request, $id) {
	    Address::find($id)->delete();
	    Session::flash('success', 'Address deleted successfully!');
		return redirect()->to('/delivery-address');
	}	
	
	public function ajaxAddressData(Request $request, $id)
	{
	$select_data = Address::find($id);
	$arr = array('label' => $select_data['label'],'attention' => $select_data['attention'], 'street_address' => $select_data['street_address'], 'town_city' => $select_data['town_city'], 'state_region' => $select_data['state_region'], 'zip_code' => $select_data['zip_code'], 'country' => $select_data['country'], 'tel_country' => $select_data['tel_country'], 'tel_area' => $select_data['tel_area'], 'tel_number' => $select_data['tel_number'], 'instruction' => $select_data['instruction']);
	return json_encode($arr);
	}
}