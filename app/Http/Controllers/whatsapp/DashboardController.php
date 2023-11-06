<?php
namespace App\Http\Controllers\whatsapp;
use App\Http\Controllers\Controller;
Use Auth;
use Illuminate\Http\Request;
Use DB;
use Session;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\User;
use Image;
date_default_timezone_set("Asia/Kolkata");

error_reporting(0);
ini_set('memory_limit','10000M');
set_time_limit(200000000);

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    $user = Auth::user();
		//$data = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('_id', 'DESC')->paginate(100);
		$data = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('_id', 'DESC')->paginate(100);
		
        return view('whatsapp.admin_dashboard',['data'=>$data]);
		
	    
    }
    
   
    
     public function whatsappstatusupdatesent()
    {
        $records = DB::table('tbl_whats_app_message')->get();
        
        //pr($records);
        
        foreach($records as $records){
            if($records['report_id']!='')
            {
            $report_id = messageStatusReport($records['report_id']);
            $data = array('last_message_sent' =>$report_id);
            DB::table('tbl_whats_app_message')->where("_id",'=',$records['_id'])->update($data);
            }
        }
    }
    
    public function RecurringMessageListing()
    {
        $type = $_GET['col'];
        $user = Auth::user();
        if($type=='')
        {
		$data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->orderBy('recurring_task_name', 'ASC')->get();
        }else{
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->orderBy('recurring_task_name', $type)->get();   
        }
        $temp = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('name_of_template', 'asc')->get();
		//pr($data); die;
        return view('whatsapp.recurring-message-listing',['data'=>$data,'temp'=>$temp]);  
    }
    
    public function contactdetailslisting()
    {
      $user = Auth::user();  
      $data = DB::table('tbl_contact_details')->where('user_id',$user->id)->orderBy('_id', 'DESC')->get();
      return view('whatsapp.contact-details-listing',['data'=>$data]);
    }
    
    public function editRecurringMessage($id)
    {
      $user = Auth::user();
      $data = DB::table('tbl_whats_app_message')->where('_id',$id)->first();
      $image_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$id)->first();
      //pr($data); die;
      $message_template = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('name_of_template', 'asc')->get();
      $data2 = DB::table('tbl_template')->where('_id',$data['message_template'])->first();
        $mid = $data2['_id'];
        $oid = (array) $mid;
        $mid = $oid['oid'];
        $message_data2 = DB::table('tbl_template_data')->where('template_id',$mid)->get(); 
        //pr($message_data2); die;
      return view('whatsapp.edit-recurring-message',['data'=>$data,'message_template'=>$message_template,'msg_data'=>$image_data,'message_data'=>$message_data2]);  
    }
    
     public function copyRecurringMessage($id)
    {
      $user = Auth::user();
      $data = DB::table('tbl_whats_app_message')->where('_id',$id)->first();
      $image_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$id)->first();
      //pr($data); die;
      $message_template = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
      $data2 = DB::table('tbl_template')->where('_id',$data['message_template'])->first();
        $mid = $data2['_id'];
        $oid = (array) $mid;
        $mid = $oid['oid'];
        $message_data2 = DB::table('tbl_template_data')->where('template_id',$mid)->get(); 
        //pr($message_data2); die;
      return view('whatsapp.copy-recurring-message',['data'=>$data,'message_template'=>$message_template,'msg_data'=>$image_data,'message_data'=>$message_data2]);  
    }
    
    public function editdetailscontact($id)
    {
     $user = Auth::user();
      $data = DB::table('tbl_contact_details')->where('_id',$id)->first(); 
      return view('whatsapp.edit-details-contact',['data'=>$data]); 
    }
    
    public function updatecontactdetails(Request $request)
    {
    $user = Auth::user();  
    DB::table('tbl_contact_details')->where('_id',$request->id)->delete();
	$count = count($request->name_of_contact);
	for($i=0;$i<$count;$i++)
	{
	$data_message = array("user_id"=>$user->id,"company_name" => $request->company_name[$i],"name_of_contact" => $request->name_of_contact[$i],"receiver_mobile_number"=> $request->receiver_mobile_number[$i]);
	DB::table('tbl_contact_details')->insert(array($data_message));
	}
	Session::flash('success', 'Contact update successfully!');
	return redirect()->to('/whatsapp/contacts');   
    }
    
    
    
    public function importContactDetails(Request $request)
	{
	$user = Auth::user();
	DB::table('tbl_temp_contact_details')->where('user_id',$user->id)->delete();
	if ($request->file('import_contact') != null )
	 {
	        $file = $request->file('import_contact');
			
			$filename  = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$tempPath  = $file->getRealPath();
			$fileSize  = $file->getSize();
			$mimeType  = $file->getMimeType();
			
			$valid_extension = array("csv","xlsx","xls");
			$maxFileSize = 2097152;
			if(strtolower($extension)=='xlsx' || strtolower($extension)=='xls')
			{
			$objPHPExcel = \PHPExcel_IOFactory::load($request->file('import_contact'));
			$importData_arr = array();
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
			
			for ($row = 2; $row <= $highestRow; ++ $row) {
			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			$cell = $worksheet->getCellByColumnAndRow($col, $row);
			$val = $cell->getValue();
			$importData_arr[$row][$col] = str_replace('="','',$val);
			}
			}
			}
			
			foreach(array_filter($importData_arr) as $importData){
				// 	$insertData[] = array(
				// 	        "user_id"                           => $user->id,
				// 			"name_of_contact"  	  				=> $importData[0],
				// 			"receiver_mobile_number" 	      	=> str_replace('"','',$importData[1]),
				// 		);
				//pr($importData);
					}
			
			$insert = DB::table('tbl_contact_details')->insert($insertData);
					 //echo "<pre>"; print_r($insertData); die; 
					Session::flash('success','CSV Imported Successfully.');
			}
			if(strtolower($extension)=='csv')
			{
			if(in_array(strtolower($extension),$valid_extension)){
				if($fileSize <= $maxFileSize){
					$location = ('public/uploads/import_contact'); /* Upload file */
					$file->move($location, $filename); /* Import CSV to Database */
					$filepath = ($location."/".$filename);
					$file = fopen($filepath,"r");  /* Reading file */
					$importData_arr = array();
                    $header = fgetcsv($file);
                    while ($row = fgetcsv($file)) {
                    $importData_arr[] = array_combine($header, $row);
                    }
					fclose($file);
					//pr($importData_arr);die;
					foreach(array_filter($importData_arr) as $importData){
					    
					    if($importData['Phone 1 - Value']!='' && $importData['Name']!='' && $importData['Organization 1 - Name']!='')
					    {
				DB::table('tbl_contact_details')->where('user_id',$user->id)->where('receiver_mobile_number',str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))))->delete();
				$count = DB::table('tbl_contact_details')->where('user_id',$user->id)->where('receiver_mobile_number',str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))))->count();
				if($count<=0){
				    $insertData = array('user_id' => $user->id,'company_name'=> $importData['Organization 1 - Name'],'name_of_contact' => $importData['Name'],'receiver_mobile_number' =>str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))));
				    $insert = DB::table('tbl_contact_details')->insert(array($insertData));
				}else{
				    //$updateData = array('user_id' => $user->id,'company_name'=> $importData['Organization 1 - Name'],'name_of_contact' => $importData['Name'],'receiver_mobile_number' =>str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))));
				    //$update = DB::table('tbl_contact_details')->where('user_id',$user->id)->where('receiver_mobile_number',str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))))->update(array($updateData));
				}
					    }
					}
					Session::flash('success','CSV Imported Successfully.');
				}else{
					Session::flash('success','File too large. File must be less than 2MB.');
				}
			}else{
				Session::flash('success','Invalid File Extension.');
			}
	 }
	 }
	 $count = DB::table('tbl_temp_contact_details')->where('user_id',$user->id)->count();
	 if($count>0)
	 {
	 return redirect()->to('/whatsapp/contacts');
	 }else{
	 return redirect()->to('/whatsapp/contacts');   
	 }
	}
    
    
	
	public function importContact(Request $request)
	{
	$user = Auth::user();
	if ($request->file('import_contact') != null )
	 {
	        $file = $request->file('import_contact');
			
			$filename  = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$tempPath  = $file->getRealPath();
			$fileSize  = $file->getSize();
			$mimeType  = $file->getMimeType();
			
			$valid_extension = array("csv","xlsx","xls");
			$maxFileSize = 2097152;
			if(strtolower($extension)=='xlsx' || strtolower($extension)=='xls')
			{
			$objPHPExcel = \PHPExcel_IOFactory::load($request->file('import_contact'));
			$importData_arr = array();
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
			
			for ($row = 2; $row <= $highestRow; ++ $row) {
			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			$cell = $worksheet->getCellByColumnAndRow($col, $row);
			$val = $cell->getValue();
			$importData_arr[$row][$col] = str_replace('="','',$val);
			}
			}
			}
			
			foreach(array_filter($importData_arr) as $importData){
				// 	$insertData[] = array(
				// 	        "user_id"                           => $user->id,
				// 			"name_of_contact"  	  				=> $importData[0],
				// 			"receiver_mobile_number" 	      	=> str_replace('"','',$importData[1]),
				// 		);
				//pr($importData);
					}
			
			$insert = DB::table('tbl_whatsapp_contact')->insert($insertData);
					 //echo "<pre>"; print_r($insertData); die; 
					Session::flash('success','CSV Imported Successfully.');
			}
			if(strtolower($extension)=='csv')
			{
			if(in_array(strtolower($extension),$valid_extension)){
				if($fileSize <= $maxFileSize){
					$location = ('public/uploads/import_contact'); /* Upload file */
					$file->move($location, $filename); /* Import CSV to Database */
					$filepath = ($location."/".$filename);
					$file = fopen($filepath,"r");  /* Reading file */
					$importData_arr = array();
                    $header = fgetcsv($file);
                    while ($row = fgetcsv($file)) {
                    $importData_arr[] = array_combine($header, $row);
                    }
					fclose($file);
					foreach(array_filter($importData_arr) as $importData){
					    //pr($importData);
					    if($importData['Phone 1 - Value']!='')
					    {
				$count = DB::table('tbl_whatsapp_contact')->where('user_id',$user->id)->where('receiver_mobile_number',str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))))->count();
				if($count<=0){
				    $insertData = array('user_id' => $user->id,'name_of_contact' => $importData['Name'],'receiver_mobile_number' =>str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))));
				    $insert = DB::table('tbl_whatsapp_contact')->insert(array($insertData));
				}else{
				    $updateData = array('user_id' => $user->id,'name_of_contact' => $importData['Name'],'receiver_mobile_number' =>str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))));
				    $update = DB::table('tbl_whatsapp_contact')->where('user_id',$user->id)->where('receiver_mobile_number',str_replace('-','',str_replace(':::',',',str_replace(" ", "",$importData['Phone 1 - Value']))))->update($updateData);
				}
					    }
					}
					Session::flash('success','CSV Imported Successfully.');
				}else{
					Session::flash('success','File too large. File must be less than 2MB.');
				}
			}else{
				Session::flash('success','Invalid File Extension.');
			}
	 }
	 }
	 return redirect()->to('/whatsapp/groups');
	}
	
	public function sendmessagelisting(Request $request)
	{
	$user = Auth::user();
	$data = DB::table('tbl_message_send_multiple')->where('user_id',$user->id)->orderBy('_id', 'DESC')->get();
	//pr($data); die;
	return view('whatsapp.send-message-listing',['data'=>$data]);
	}
	
	public function addMessage()
	{
	return view('whatsapp.add-message');
	}
	
	public function addcontactdetails()
	{
	return view('whatsapp.add-contact-details');   
	}
	
	public function addRecurringMessage()
	{
	 $value = rand(111111,999999);
	 session()->put('contact_temp', $value);
	 $contact_temp = session()->get('contact_temp');
	 $user = Auth::user();
	 $message_template = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('name_of_template', 'asc')->get();
	 //pr($message_template); die;
	 return view('whatsapp.add-recurring-message',['message_template'=>$message_template,'contact_temp'=>$contact_temp]);   
	}
	
	public function ajaxContactTemp($id,$rand_id)
	{
	    $user = Auth::user();
	    $data = explode(',',$id);
	    foreach($data as $d){
	          $temp_d = getCont($d); 
	          $data_message = array("user_id"=>$user->id,"company_name" => $temp_d['company_name'],"name_of_contact"=> $temp_d['name_of_contact'],'receiver_mobile_number'=>$temp_d['receiver_mobile_number'],'rand_id'=>$rand_id);
              //pr($data_message);
              DB::table('tbl_whatsapp_contact_temp')->insert(array($data_message));
	       
	    }
        $temp_data = DB::table('tbl_whatsapp_contact_temp')->where('rand_id',$rand_id)->get(); 
        if(!empty($temp_data))
        {
        $html = '';
        foreach($temp_data as $tmp){
        $html .='<span id="san-'.$tmp["receiver_mobile_number"].'">'.$tmp["company_name"].'<span id='.$tmp["receiver_mobile_number"].'" class="remove-btn"></span></span>'; 
        }
        echo $html;
        }
	    
	}
	
	public function ajaxTempData($rand_id)
	{
	$temp_data = DB::table('tbl_whatsapp_contact_temp')->where('rand_id',$rand_id)->get(); 
	if(!empty($temp_data))
	{
	    $html = '';
	    foreach($temp_data as $tmp){
	       $html .='<span id="san-'.$tmp["receiver_mobile_number"].'">'.$tmp["company_name"].'<span id='.$tmp["receiver_mobile_number"].'" class="remove-btn"></span></span>'; 
	    }
	    echo $html;
	}
	}
	
	
	public function addContact()
	{
	return view('whatsapp.add-contact');
	}
	
	public function addSendMessage()
	{
	$user = Auth::user();
	$group_contact = DB::table('tbl_whatsapp_contact')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
	$message_template = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('name_of_template', 'asc')->get();
	return view('whatsapp.add-send-message',['group_contact' => $group_contact,"message_template"=> $message_template]);
	}
	
	public function savecontact(Request $request)
	{
	$customMessages = [
	        'name_of_contact.required' => 'Name of contact must be filled out.',
			'receiver_mobile_number.required' => 'Receiver mobile number must be filled out.'
		];
		$this->validate($request, [
			'name_of_contact' => 'required',
			'receiver_mobile_number' => 'required',		
		],$customMessages);
	$user = Auth::user();	
	$data_message = array("user_id"=>$user->id,"name_of_contact" => $request->name_of_contact,"receiver_mobile_number"=> $request->receiver_mobile_number);
	DB::table('tbl_whatsapp_contact')->insert(array($data_message));
	Session::flash('success', 'Group added successfully!');
	return redirect()->to('/whatsapp/groups');
	}
	
	public function savecontactdetails(Request $request)
	{
	$user = Auth::user();   
	$count = count($request->name_of_contact);
	for($i=0;$i<$count;$i++)
	{
	$data_message = array("user_id"=>$user->id,"company_name" => $request->company_name[$i],"name_of_contact" => $request->name_of_contact[$i],"receiver_mobile_number"=> $request->receiver_mobile_number[$i]);
	DB::table('tbl_contact_details')->insert(array($data_message));
	}
	Session::flash('success', 'Contact added successfully!');
	return redirect()->to('/whatsapp/contacts');
	}
	
	public function addAccountManagement()
	{
	$user = Auth::user();
	return view('whatsapp.add-account-management');    
	}
	
	public function saveaccountmanagement(Request $request)
	{
    $customMessages = [
    'username.required' => 'Username must be filled out.',
    'password.required' => 'Password must be filled out.',
    'mobile_number.required' => 'Mobile number must be filled out.'
    ];
    $this->validate($request, [
    'username' => 'required',
    'password' => 'required',
    'mobile_number' => 'required|numeric|min:10',		
    ],$customMessages);
	$user = Auth::user();
	$data_message = array("user_id"=>$user->id,"username" => $request->username,"password"=> $request->password,"mobile_number"=> $request->mobile_number);
	DB::table('tbl_whatsapp_account_management')->insert(array($data_message));
	Session::flash('success', 'Setting added successfully!');
	return redirect()->to('/whatsapp/settings');
	}
	
	
	public function updatesendmessagemultiple(Request $request)
    {
    
    $user = Auth::user();
    if($request->name_of_sender==1){
	$name_of_contact = '';
	}else if($request->name_of_sender==2){
	$name_of_contact = $request->name_of_contact;
	}
	
	
	if($request->name_of_sender==1){
	$receiver_mobile_number = $request->receiver_mobile_number;
	}else if($request->name_of_sender==2){
	$receiver_mobile_number = '';
	}
	
	$message_date = $request->message_date;
	$message_time = $request->message_time;
	
	$data_message = array("user_id"=>$user->id,"name_of_sender" => $request->name_of_sender,"name_of_contact"=> $name_of_contact,"receiver_mobile_number"=> duplicateData($receiver_mobile_number),"message_time"=>$message_time,"message_date"=> $message_date);
	DB::table('tbl_message_send_multiple')->where('_id',$request->id)->update($data_message);
	DB::table('tbl_template_multiple_message_data')->where('template_id',$request->id)->delete();
	
	$message_text_data = count($request->message_text);
	
	for($i=0;$i<$message_text_data;$i++)
	{
	if($request->hidden_gdrive[$i]!='' && $request->file('gdrive_name')[$i]!='')
	{
	$image = $request->file('gdrive_name')[$i];
    $destinationPath = public_path('uploads/thumbnail');
    $fileName = time().$user->id.pathinfo($request->file('gdrive_name')[$i]->getClientOriginalName(), PATHINFO_FILENAME);
    $fileName = $fileName.'.'.$request->file('gdrive_name')[$i]->getClientOriginalExtension();
    $img = Image::make($image->getRealPath());
    $img->resize(700, 700, function ($constraint) {
    $constraint->aspectRatio();
    })->save($destinationPath.'/'.$fileName);
    $destinationPath_thumb = public_path('uploads/thumb');
    $img->resize(80, 80, function ($constraint) {
    $constraint->aspectRatio();
    })->save($destinationPath_thumb.'/'.$fileName);
    $original_name = pathinfo($request->file('gdrive_name')[$i]->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')[$i]->getClientOriginalExtension();
	}else if($request->hidden_gdrive[$i]=='' && $request->file('gdrive_name')[$i]!=''){
	$image = $request->file('gdrive_name')[$i];
    $destinationPath = public_path('uploads/thumbnail');
    $fileName = time().$user->id.pathinfo($request->file('gdrive_name')[$i]->getClientOriginalName(), PATHINFO_FILENAME);
    $fileName = $fileName.'.'.$request->file('gdrive_name')[$i]->getClientOriginalExtension();
    $img = Image::make($image->getRealPath());
    $img->resize(700, 700, function ($constraint) {
    $constraint->aspectRatio();
    })->save($destinationPath.'/'.$fileName);
    $destinationPath_thumb = public_path('uploads/thumb');
    $img->resize(80, 80, function ($constraint) {
    $constraint->aspectRatio();
    })->save($destinationPath_thumb.'/'.$fileName);
    $original_name = pathinfo($request->file('gdrive_name')[$i]->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')[$i]->getClientOriginalExtension();  
	}else{
	 $fileName = $request->hidden_gdrive[$i];
	 $original_name = $request->hidden_original_name[$i];
	}
    
	$data_message = array("user_id"=>$user->id,"template_id" => $request->id,"message_text"=> $request->message_text[$i],"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name); 
	//pr($data_message);
	//die;
	DB::table('tbl_template_multiple_message_data')->insert(array($data_message));
	
	}
	Session::flash('success', 'Message Send updated successfully!');
	return redirect()->to('/whatsapp/send-message-listing');
        
    }
	
	 public function sendmessagesave(Request $request)
    {
    $user = Auth::user();
    if($request->name_of_sender==1){
	$name_of_contact = '';
	}else if($request->name_of_sender==2){
	$name_of_contact = $request->name_of_contact;
	}
	
	
	if($request->name_of_sender==1){
	$receiver_mobile_number = $request->receiver_mobile_number;
	}else if($request->name_of_sender==2){
	$receiver_mobile_number = '';
	}
	
	$message_date = $request->message_date;
	$message_time = $request->message_time;
	
	$data_message = array("user_id"=>$user->id,"name_of_sender" => $request->name_of_sender,"name_of_contact"=> $name_of_contact,"receiver_mobile_number"=> duplicateData($receiver_mobile_number),"message_time"=>$message_time,"message_date"=> $message_date);
	$last_id = DB::table('tbl_message_send_multiple')->insertGetId($data_message);
	
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$message_text_data = count($request->message_text);
	for($i=0;$i<$message_text_data;$i++)
	{
    $image = $request->file('gdrive_name')[$i];
    if($image!=''){
    $destinationPath = public_path('uploads/thumbnail');
    $fileName = time().$user->id.pathinfo($request->file('gdrive_name')[$i]->getClientOriginalName(), PATHINFO_FILENAME);
    $fileName = $fileName.'.'.$request->file('gdrive_name')[$i]->getClientOriginalExtension();
    $img = Image::make($image->getRealPath());
    $img->resize(700, 700, function ($constraint) {
    $constraint->aspectRatio();
    })->save($destinationPath.'/'.$fileName);
    $destinationPath_thumb = public_path('uploads/thumb');
    $img->resize(80, 80, function ($constraint) {
    $constraint->aspectRatio();
    })->save($destinationPath_thumb.'/'.$fileName);
    $original_name = pathinfo($request->file('gdrive_name')[$i]->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')[$i]->getClientOriginalExtension();
    }else{
    $fileName = '';
    $original_name = '';
    }
	$data_message = array("user_id"=>$user->id,"template_id" => $last_id,"message_text"=> $request->message_text[$i],"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
	DB::table('tbl_template_multiple_message_data')->insert(array($data_message));
	}
	Session::flash('success', 'Message added successfully!');
	return redirect()->to('/whatsapp/send-message-listing');
	
     
    }
    
	
	
	public function savesendmessage2(Request $request)
	{
	//pr($request->all()); die;
	$user = Auth::user();
	if($request->name_of_sender==1){
	$name_of_contact = '';
	}else if($request->name_of_sender==2){
	$name_of_contact = $request->name_of_contact;
	}else if($request->name_of_sender==3){
	$name_of_contact = '';
	}
	
	
	if($request->name_of_sender==1){
	$receiver_mobile_number = $request->receiver_mobile_number_manually;
	}else if($request->name_of_sender==2){
	$receiver_mobile_number = '';
	}else if($request->name_of_sender==3){
	$receiver_mobile_number = ltrim($request->receiver_mobile_number_contact,',');
	}
	
	if($request->is_recurring=='')
	{
	 $recurring_days='';   
	}else{
	  $recurring_days=''; 
	}
	
	if($request->recurring_type==5)
	{
	    $date_of_yearly = $request->date_of_yearly;
	    $month_of_yearly = $request->month_of_yearly;
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	     if(date('m')<=$request->month_of_yearly){
	    $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y');  
	    }else{
	    $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y', strtotime($request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y'). ' +1 year'));
	    }
	}
	
	if($request->recurring_type==4)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = $request->date_of_quaterly;
	    $month_of_quaterly = $request->month_of_quaterly;
	    $date_of_month = '';
	    $day_of_week = '';
	    $checkDateLoop = $this->checkQuaterly($request->month_of_quaterly);
	    $c_month = $checkDateLoop[array_search(date('m'),$checkDateLoop)];
	    if(date('m')<=$c_month){
	    $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y');  
	    }else{
	    $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y', strtotime($request->date_of_quaterly.'-'.$c_month.'-'.date('Y'). ' +3 months'));
	    }
	    
	}
	
	if($request->recurring_type==3)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = $request->date_of_month;
	    $day_of_week = '';
	    if(date('d')<=$request->date_of_month){
	    $message_start_date = $request->date_of_month.'-'.date('m').'-'.date('Y');
	    }else{
	    $message_start_date = $request->date_of_month.'-'.date('m-Y', strtotime($request->date_of_month.'-'.date('m').'-'.date('Y'). ' +30 days'));
	    }
	}
	
	if($request->recurring_type==2)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = $request->day_of_week;
	    //pr($day_of_week); die;
	    $startDate = date('Y-m-d');
	    $endDate = date("Y-m-d", strtotime("+ 7 days"));
	    $todays = date('l');
	    if (in_array($todays, $day_of_week)) {
	        if($request->recurring_time>date('H'))
	        {
	        $days = $todays;
	        }else{
	            $k = array_reverse($day_of_week);
	           $days = $k[0]; 
	        }
	    }else{
	        $k = array_reverse($day_of_week);
	        $days = $k[0];
	    }
	    if($days=='Sunday'){$weekdayNumber=0;}
	    if($days=='Monday'){$weekdayNumber=1;}
	    if($days=='Tuesday'){$weekdayNumber=2;}
	    if($days=='Wednesday'){$weekdayNumber=3;}
	    if($days=='Thursday'){$weekdayNumber=4;}
	    if($days=='Friday'){$weekdayNumber=5;}
	    if($days=='Saturday'){$weekdayNumber=6;}
	    $message_start_date = getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber);
	    //pr($day_of_week); die;
	}
	if($request->recurring_type==1)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	    if($request->recurring_time>date('H'))
	    {
	    $message_start_date = date('d-m-Y');
	    }else{
	    $message_start_date = date("d-m-Y", strtotime("+ 1 day"));  
	    }
	}
	
	if($request->recurring_type==0)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	    $message_start_date = $request->message_start_date;
	    
	}


	//echo $name_of_contact;
	//pr($request->all());die;
	
	$data_message = array("user_id"=>$user->id,"recurring_task_name"=>$request->recurring_task_name,"name_of_sender" => $request->name_of_sender,"name_of_contact"=> $name_of_contact,"receiver_mobile_number"=> duplicateData($receiver_mobile_number),"recurring_days"=>'',"recurring_time"=>$request->recurring_time,"message_start_date"=> $message_start_date,"message_template"=> $request->message_template,"pause_task"=>"0","is_recurring"=>$request->is_recurring,"recurring_type"=>$request->recurring_type,"date_of_yearly"=>$date_of_yearly,"month_of_yearly"=>$month_of_yearly,"date_of_quaterly"=>$date_of_quaterly,"month_of_quaterly"=>$month_of_quaterly,"date_of_month"=>$date_of_month,"day_of_week"=>implode(',',$day_of_week));
	//pr($data_message);die;
	$last_id = DB::table('tbl_whats_app_message')->insertGetId($data_message);
	if($request->message_template=='custom')
	{
	$oid = (array) $last_id;
        $last_id = $oid['oid'];
        $image = $request->file('gdrive_name');
        if($image!=''){
        $destinationPath = public_path('uploads/thumbnail');
        $fileName = time().$user->id.pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $fileName.'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(700, 700, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileName);
        $destinationPath_thumb = public_path('uploads/thumb');
        $img->resize(80, 80, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$fileName);
        $original_name = pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        }else{
        $fileName = '';
        $original_name = '';
        }
        $data_message = array("user_id"=>$user->id,"recurring_id" => $last_id,"message_text"=> $request->message_text,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
        DB::table('tbl_recurring_image_data')->insert(array($data_message));
	}
	
	if($request->send_now==1){
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('_id',$last_id)->get();
	if(!empty($mobile_number_data))
	{
	//pr($mobile_number_data); die;
	foreach($mobile_number_data as $mobile_number_data)
	{
	if($mobile_number_data['name_of_sender']==1 || $mobile_number_data['name_of_sender']==3){
	$receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
	}else{
	$name_of_contact = $mobile_number_data['name_of_contact'];
	$mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
	$receiver_mobile_number = $mobile_data['receiver_mobile_number'];
	}
	
	if($mobile_number_data['message_template']=='custom')
	{
	$rec_id = $mobile_number_data['_id'];
	$oid = (array) $rec_id;
    $rec_id = $oid['oid'];
	$template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
	}else{
	$template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
	}
	foreach($template_data as $i=>$tmp_data)
	{
	if($tmp_data['gdrive_name']!='')
	{
	$file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
	$ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
	sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}else{
	    //echo 1; die;
	    //echo $receiver_mobile_number; die;
	sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}
	sleep(6);
	}
    }
	}
	}
	
	if($request->send_now==1){
	DB::table('tbl_whats_app_message')->where('_id',$last_id)->delete();
	DB::table('tbl_recurring_image_data')->where('recurring_id',$last_id)->delete();   
	}
	//die;
	Session::flash('success', 'Message Saved.');
	return redirect()->to('/whatsapp/message-planner');
	}
	
	public function savesendmessage(Request $request)
	{
        $user = Auth::user();
        if($request->name_of_sender==1){
        $name_of_contact = '';
        }else if($request->name_of_sender==2){
        $name_of_contact = $request->name_of_contact;
        }else if($request->name_of_sender==3){
        $name_of_contact = '';
        }
        
        if($request->name_of_sender==1){
        $receiver_mobile_number = $request->receiver_mobile_number_manually;
        }else if($request->name_of_sender==2){
        $receiver_mobile_number = '';
        }else if($request->name_of_sender==3){
        $receiver_mobile_number = ltrim($request->receiver_mobile_number_contact,',');
        }
        
        if($request->is_recurring=='')
        {
        $recurring_days='';   
        }else{
        $recurring_days=''; 
        }
        
        if($request->recurring_type==5)
        {
        $date_of_yearly = $request->date_of_yearly;
        $month_of_yearly = $request->month_of_yearly;
        $date_of_quaterly = '';
        $month_of_quaterly = '';
        $date_of_month = '';
        $day_of_week = '';
        if(date('m')<=$request->month_of_yearly){
        $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y');  
        }else{
        $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y', strtotime($request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y'). ' +1 year'));
        }
        }
        
        if($request->recurring_type==4)
        {
        $date_of_yearly = '';
        $month_of_yearly = '';
        $date_of_quaterly = $request->date_of_quaterly;
        $month_of_quaterly = $request->month_of_quaterly;
        $date_of_month = '';
        $day_of_week = '';
        $checkDateLoop = $this->checkQuaterly($request->month_of_quaterly);
        $c_month = $checkDateLoop[array_search(date('m'),$checkDateLoop)];
        if(date('m')<=$c_month){
        $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y');  
        }else{
        $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y', strtotime($request->date_of_quaterly.'-'.$c_month.'-'.date('Y'). ' +3 months'));
        }
        }
        
        if($request->recurring_type==3)
        {
        $date_of_yearly = '';
        $month_of_yearly = '';
        $date_of_quaterly = '';
        $month_of_quaterly = '';
        $date_of_month = $request->date_of_month;
        $day_of_week = '';
        if(date('d')<=$request->date_of_month){
        $message_start_date = $request->date_of_month.'-'.date('m').'-'.date('Y');
        }else{
        $message_start_date = $request->date_of_month.'-'.date('m-Y', strtotime($request->date_of_month.'-'.date('m').'-'.date('Y'). ' +30 days'));
        }
        }
        
        if($request->recurring_type==2)
        {
        $date_of_yearly = '';
        $month_of_yearly = '';
        $date_of_quaterly = '';
        $month_of_quaterly = '';
        $date_of_month = '';
        $day_of_week = $request->day_of_week;
        //pr($day_of_week); die;
        $startDate = date('Y-m-d');
        $endDate = date("Y-m-d", strtotime("+ 7 days"));
        $todays = date('l');
        if (in_array($todays, $day_of_week)) {
        if($request->recurring_time>date('H'))
        {
        $days = $todays;
        }else{
        $k = array_reverse($day_of_week);
        $days = $k[0]; 
        }
        }else{
        $k = array_reverse($day_of_week);
        $days = $k[0];
        }
        if($days=='Sunday'){$weekdayNumber=0;}
        if($days=='Monday'){$weekdayNumber=1;}
        if($days=='Tuesday'){$weekdayNumber=2;}
        if($days=='Wednesday'){$weekdayNumber=3;}
        if($days=='Thursday'){$weekdayNumber=4;}
        if($days=='Friday'){$weekdayNumber=5;}
        if($days=='Saturday'){$weekdayNumber=6;}
        $message_start_date = getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber);
        //pr($day_of_week); die;
        }
        
        if($request->recurring_type==1)
        {
        $date_of_yearly = '';
        $month_of_yearly = '';
        $date_of_quaterly = '';
        $month_of_quaterly = '';
        $date_of_month = '';
        $day_of_week = '';
        if($request->recurring_time>date('H'))
        {
        $message_start_date = date('d-m-Y');
        }else{
        $message_start_date = date("d-m-Y", strtotime("+ 1 day"));  
        }
        }
        
        if($request->recurring_type==0)
        {
        $date_of_yearly = '';
        $month_of_yearly = '';
        $date_of_quaterly = '';
        $month_of_quaterly = '';
        $date_of_month = '';
        $day_of_week = '';
        $message_start_date = $request->message_start_date;
        }
        
        $data_message = array("user_id"=>$user->id,"recurring_task_name"=>$request->recurring_task_name,"name_of_sender" => $request->name_of_sender,"name_of_contact"=> $name_of_contact,"receiver_mobile_number"=> duplicateData($receiver_mobile_number),"recurring_days"=>'',"recurring_time"=>$request->recurring_time,"message_start_date"=> $message_start_date,"message_template"=> $request->message_template,"pause_task"=>"0","is_recurring"=>$request->is_recurring,"recurring_type"=>$request->recurring_type,"date_of_yearly"=>$date_of_yearly,"month_of_yearly"=>$month_of_yearly,"date_of_quaterly"=>$date_of_quaterly,"month_of_quaterly"=>$month_of_quaterly,"date_of_month"=>$date_of_month,"day_of_week"=>implode(',',$day_of_week));
        $last_id = DB::table('tbl_whats_app_message')->insertGetId($data_message);
        
        if($request->message_template=='custom')
        {
        $oid = (array) $last_id;
        $last_id = $oid['oid'];
        $image = $request->file('gdrive_name');
        if($image!=''){
        $destinationPath = public_path('uploads/thumbnail');
        $fileName = time().$user->id.pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $fileName.'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(700, 700, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileName);
        $destinationPath_thumb = public_path('uploads/thumb');
        $img->resize(80, 80, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$fileName);
        $original_name = pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        }else{
        $fileName = '';
        $original_name = '';
        }
        $data_message = array("user_id"=>$user->id,"recurring_id" => $last_id,"message_text"=> $request->message_text,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
        DB::table('tbl_recurring_image_data')->insert(array($data_message));
        }
        
        if($request->send_now==1){
        $mobile_number_data = DB::table('tbl_whats_app_message')->where('_id',$last_id)->get();
        if(!empty($mobile_number_data))
        {
        //pr($mobile_number_data); die;
        foreach($mobile_number_data as $mobile_number_data)
        {
        if($mobile_number_data['name_of_sender']==1 || $mobile_number_data['name_of_sender']==3){
        $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
        }else{
        $name_of_contact = $mobile_number_data['name_of_contact'];
        $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
        $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
        }
        
        if($mobile_number_data['message_template']=='custom')
        {
        $rec_id = $mobile_number_data['_id'];
        $oid = (array) $rec_id;
        $rec_id = $oid['oid'];
        $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
        }else{
        $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
        $message_template = DB::table('tbl_template')->where('_id',$mobile_number_data['message_template'])->first();
        }
        if($message_template['random']==1){
        sendWhatsAppmsgWhatsAppXNew('',$receiver_mobile_number,$mobile_number_data['_id'],$mobile_number_data['user_id'],$message_template);
        sendWhatsAppmsgWhatsAppXNew($template_data,$receiver_mobile_number,$mobile_number_data['_id'],$mobile_number_data['user_id'],'');
        }else{
        sendWhatsAppmsgWhatsAppXNew($template_data,$receiver_mobile_number,$mobile_number_data['_id'],$mobile_number_data['user_id'],$message_template);
        }
        sleep(2);
        }
        }
        }
        
        if($request->send_now==1){
        DB::table('tbl_whats_app_message')->where('_id',$last_id)->delete();
        DB::table('tbl_recurring_image_data')->where('recurring_id',$last_id)->delete();   
        }
        //die;
        Session::flash('success', 'Message Saved.');
        return redirect()->to('/whatsapp/message-planner');
	
	}
	
	public function whatsappMessagePlanner($id)
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('_id',$id)->get();
	//pr($mobile_number_data); die;
	if(!empty($mobile_number_data))
	{
	foreach($mobile_number_data as $mobile_number_data)
	{
	if($mobile_number_data['name_of_sender']==1){
	$receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
	}else{
	$name_of_contact = $mobile_number_data['name_of_contact'];
	$mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
	$receiver_mobile_number = $mobile_data['receiver_mobile_number'];
	}
	if($mobile_number_data['message_template']=='custom')
	{
	$rec_id = $mobile_number_data['_id'];
	$oid = (array) $rec_id;
    $rec_id = $oid['oid'];
	$template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
	}else{
	$template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
	}
	
	//pr($template_data); die;
	
	foreach($template_data as $i=>$tmp_data)
	{
	if($tmp_data['gdrive_name']!='')
	{
	$file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
	$ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
	sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}else{
	sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}
	sleep(6);
	}
    }
	}
	Session::flash('success', 'Message Send Successfully.');
	return redirect()->to('/whatsapp/message-planner');
	}
	
	public function updatesendmessage(Request $request)
	{
	$user = Auth::user();
	if($request->name_of_sender==1){
	$name_of_contact = '';
	}else if($request->name_of_sender==2){
	$name_of_contact = $request->name_of_contact;
	}else if($request->name_of_sender==3){
	$name_of_contact = '';
	}
	
	
	if($request->name_of_sender==1){
	$receiver_mobile_number = $request->receiver_mobile_number_manually;
	}else if($request->name_of_sender==2){
	$receiver_mobile_number = '';
	}else if($request->name_of_sender==3){
	$receiver_mobile_number = ltrim($request->receiver_mobile_number_contact,',');
	}
	
	if($request->is_recurring=='')
	{
	 $recurring_days='';   
	}else{
	  $recurring_days=''; 
	}
	
	if($request->recurring_type==5)
	{
	    $date_of_yearly = $request->date_of_yearly;
	    $month_of_yearly = $request->month_of_yearly;
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	     if(date('m')<=$request->month_of_yearly){
	    $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y');  
	    }else{
	    $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y', strtotime($request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y'). ' +1 year'));
	    }
	}
	
	if($request->recurring_type==4)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = $request->date_of_quaterly;
	    $month_of_quaterly = $request->month_of_quaterly;
	    $date_of_month = '';
	    $day_of_week = '';
	    $checkDateLoop = $this->checkQuaterly($request->month_of_quaterly);
	    $c_month = $checkDateLoop[array_search(date('m'),$checkDateLoop)];
	    if(date('m')<=$c_month){
	    $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y');  
	    }else{
	    $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y', strtotime($request->date_of_quaterly.'-'.$c_month.'-'.date('Y'). ' +3 months'));
	    }
	    
	}
	
	if($request->recurring_type==3)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = $request->date_of_month;
	    $day_of_week = '';
	    if(date('d')<=$request->date_of_month){
	    $message_start_date = $request->date_of_month.'-'.date('m').'-'.date('Y');
	    }else{
	    $message_start_date = $request->date_of_month.'-'.date('m-Y', strtotime($request->date_of_month.'-'.date('m').'-'.date('Y'). ' +30 days'));
	    }
	}
	
	if($request->recurring_type==2)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = $request->day_of_week;
	    $startDate = date('Y-m-d');
	    $endDate = date("Y-m-d", strtotime("+ 7 days"));
	    $todays = date('l');
	    if (in_array($todays, $day_of_week)) {
	        if($request->recurring_time>date('H'))
	        {
	        $days = $todays;
	        }else{
	            $k = array_reverse($day_of_week);
	           $days = $k[0]; 
	        }
	    }else{
	        $k = array_reverse($day_of_week);
	        $days = $k[0];
	    }
	    if($days=='Sunday'){$weekdayNumber=0;}
	    if($days=='Monday'){$weekdayNumber=1;}
	    if($days=='Tuesday'){$weekdayNumber=2;}
	    if($days=='Wednesday'){$weekdayNumber=3;}
	    if($days=='Thursday'){$weekdayNumber=4;}
	    if($days=='Friday'){$weekdayNumber=5;}
	    if($days=='Saturday'){$weekdayNumber=6;}
	    $message_start_date = getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber);
	}
	if($request->recurring_type==1)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	    if($request->recurring_time>date('H'))
	    {
	    $message_start_date = date('d-m-Y');
	    }else{
	    $message_start_date = date("d-m-Y", strtotime("+ 1 day"));  
	    }
	}
	
	if($request->recurring_type==0)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	    $message_start_date_hidden = $request->message_start_date_hidden;
	    $message_start_date = $request->message_start_date;
	    if($message_start_date!='')
	    {
	    $message_start_date = $request->message_start_date;   
	    }else{
	    $message_start_date = $message_start_date_hidden;    
	    }
	    
	    
	}

	//echo $name_of_contact;
	//pr($request->all());die;
	
	
	$data_message = array("user_id"=>$user->id,"recurring_task_name"=>$request->recurring_task_name,"name_of_sender" => $request->name_of_sender,"name_of_contact"=> $name_of_contact,"receiver_mobile_number"=> duplicateData($receiver_mobile_number),"recurring_days"=>$recurring_days,"recurring_time"=>$request->recurring_time,"message_start_date"=> $message_start_date,"message_template"=> $request->message_template,"pause_task"=>$request->pause_task,"is_recurring"=>$request->is_recurring,"recurring_type"=>$request->recurring_type,"date_of_yearly"=>$date_of_yearly,"month_of_yearly"=>$month_of_yearly,"date_of_quaterly"=>$date_of_quaterly,"month_of_quaterly"=>$month_of_quaterly,"date_of_month"=>$date_of_month,"day_of_week"=>implode(',',$day_of_week));
	//pr($data_message); die;
	DB::table('tbl_whats_app_message')->where('_id',$request->id)->update($data_message);
	DB::table('tbl_recurring_image_data')->where('recurring_id',$request->id)->delete();
	if($request->message_template=='custom')
	{
	$oid = (array) $last_id;
        $last_id = $oid['oid'];
        $image = $request->file('gdrive_name');
        if($image!=''){
        $destinationPath = public_path('uploads/thumbnail');
        $fileName = time().$user->id.pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $fileName.'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(700, 700, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileName);
        $destinationPath_thumb = public_path('uploads/thumb');
        $img->resize(80, 80, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$fileName);
        $original_name = pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        }else if($request->hidden_gdrive!=''){
        $fileName = $request->hidden_gdrive;
	    $original_name = $request->hidden_original_name;
        }else{
        $fileName = '';
        $original_name = '';
        }
        $data_message = array("user_id"=>$user->id,"recurring_id" => $request->id,"message_text"=> $request->message_text,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
        DB::table('tbl_recurring_image_data')->insert(array($data_message));
	}
	
	
	if($request->send_now==1){
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('_id',$request->id)->get();
	if(!empty($mobile_number_data))
	{
	
	foreach($mobile_number_data as $mobile_number_data)
	{
	if($mobile_number_data['name_of_sender']==1){
	$receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
	}else{
	$name_of_contact = $mobile_number_data['name_of_contact'];
	$mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
	$receiver_mobile_number = $mobile_data['receiver_mobile_number'];
	}
	
	if($mobile_number_data['message_template']=='custom')
	{
	$rec_id = $mobile_number_data['_id'];
	$oid = (array) $rec_id;
    $rec_id = $oid['oid'];
	$template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
	}else{
	$template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
	}
	foreach($template_data as $i=>$tmp_data)
	{
	if($tmp_data['gdrive_name']!='')
	{
	$file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
	$ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
	sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}else{
	sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}
	sleep(6);
	}
    }
	}
	}
	
	
	Session::flash('success', 'Message Updated.');
	return redirect()->to('/whatsapp/message-planner');
	}
	
	public function copysendmessage(Request $request)
	{
	$user = Auth::user();
	if($request->name_of_sender==1){
	$name_of_contact = '';
	}else if($request->name_of_sender==2){
	$name_of_contact = $request->name_of_contact;
	}else if($request->name_of_sender==3){
	$name_of_contact = '';
	}
	
	
	if($request->name_of_sender==1){
	$receiver_mobile_number = $request->receiver_mobile_number_manually;
	}else if($request->name_of_sender==2){
	$receiver_mobile_number = '';
	}else if($request->name_of_sender==3){
	$receiver_mobile_number = ltrim($request->receiver_mobile_number_contact,',');
	}
	
	if($request->is_recurring=='')
	{
	 $recurring_days='';   
	}else{
	  $recurring_days=''; 
	}
	
	if($request->recurring_type==5)
	{
	    $date_of_yearly = $request->date_of_yearly;
	    $month_of_yearly = $request->month_of_yearly;
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	     if(date('m')<=$request->month_of_yearly){
	    $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y');  
	    }else{
	    $message_start_date = $request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y', strtotime($request->date_of_yearly.'-'.$request->month_of_yearly.'-'.date('Y'). ' +1 year'));
	    }
	}
	
	if($request->recurring_type==4)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = $request->date_of_quaterly;
	    $month_of_quaterly = $request->month_of_quaterly;
	    $date_of_month = '';
	    $day_of_week = '';
	    $checkDateLoop = $this->checkQuaterly($request->month_of_quaterly);
	    $c_month = $checkDateLoop[array_search(date('m'),$checkDateLoop)];
	    if(date('m')<=$c_month){
	    $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y');  
	    }else{
	    $message_start_date = $request->date_of_quaterly.'-'.$c_month.'-'.date('Y', strtotime($request->date_of_quaterly.'-'.$c_month.'-'.date('Y'). ' +3 months'));
	    }
	    
	}
	
	if($request->recurring_type==3)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = $request->date_of_month;
	    $day_of_week = '';
	    if(date('d')<=$request->date_of_month){
	    $message_start_date = $request->date_of_month.'-'.date('m').'-'.date('Y');
	    }else{
	    $message_start_date = $request->date_of_month.'-'.date('m-Y', strtotime($request->date_of_month.'-'.date('m').'-'.date('Y'). ' +30 days'));
	    }
	}
	
	if($request->recurring_type==2)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = $request->day_of_week;
	    $startDate = date('Y-m-d');
	    $endDate = date("Y-m-d", strtotime("+ 7 days"));
	    if($request->day_of_week[0]=='Sunday'){$weekdayNumber=0;}
	    if($request->day_of_week[0]=='Monday'){$weekdayNumber=1;}
	    if($request->day_of_week[0]=='Tuesday'){$weekdayNumber=2;}
	    if($request->day_of_week[0]=='Wednesday'){$weekdayNumber=3;}
	    if($request->day_of_week[0]=='Thursday'){$weekdayNumber=4;}
	    if($request->day_of_week[0]=='Friday'){$weekdayNumber=5;}
	    if($request->day_of_week[0]=='Saturday'){$weekdayNumber=6;}
	    $message_start_date = getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber);
	}
	if($request->recurring_type==1)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	    if($request->recurring_time>date('H'))
	    {
	    $message_start_date = date('d-m-Y');
	    }else{
	    $message_start_date = date("d-m-Y", strtotime("+ 1 day"));  
	    }
	}
	
	if($request->recurring_type==0)
	{
	    $date_of_yearly = '';
	    $month_of_yearly = '';
	    $date_of_quaterly = '';
	    $month_of_quaterly = '';
	    $date_of_month = '';
	    $day_of_week = '';
	    $message_start_date_hidden = $request->message_start_date_hidden;
	    $message_start_date = $request->message_start_date;
	    if($message_start_date!='')
	    {
	    $message_start_date = $request->message_start_date;   
	    }else{
	    $message_start_date = $message_start_date_hidden;    
	    }
	    
	    
	}

	//echo $name_of_contact;
	//pr($request->all());die;
	
	
	$data_message = array("user_id"=>$user->id,"recurring_task_name"=>$request->recurring_task_name,"name_of_sender" => $request->name_of_sender,"name_of_contact"=> $name_of_contact,"receiver_mobile_number"=> duplicateData($receiver_mobile_number),"recurring_days"=>$recurring_days,"recurring_time"=>$request->recurring_time,"message_start_date"=> $message_start_date,"message_template"=> $request->message_template,"pause_task"=>$request->pause_task,"is_recurring"=>$request->is_recurring,"recurring_type"=>$request->recurring_type,"date_of_yearly"=>$date_of_yearly,"month_of_yearly"=>$month_of_yearly,"date_of_quaterly"=>$date_of_quaterly,"month_of_quaterly"=>$month_of_quaterly,"date_of_month"=>$date_of_month,"day_of_week"=>implode(',',$day_of_week));
	//pr($data_message); die;
	$last_id = DB::table('tbl_whats_app_message')->insertGetId($data_message);
	//DB::table('tbl_recurring_image_data')->where('recurring_id',$request->id)->delete();
	if($request->message_template=='custom')
	{
	$oid = (array) $last_id;
        $last_id = $oid['oid'];
        $image = $request->file('gdrive_name');
        if($image!=''){
        $destinationPath = public_path('uploads/thumbnail');
        $fileName = time().$user->id.pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $fileName.'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(700, 700, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileName);
        $destinationPath_thumb = public_path('uploads/thumb');
        $img->resize(80, 80, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$fileName);
        $original_name = pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        }else if($request->hidden_gdrive!=''){
        $fileName = $request->hidden_gdrive;
	    $original_name = $request->hidden_original_name;
        }else{
        $fileName = '';
        $original_name = '';
        }
        $data_message = array("user_id"=>$user->id,"recurring_id" => $last_id,"message_text"=> $request->message_text,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
        //pr($data_message); die;
        DB::table('tbl_recurring_image_data')->insert(array($data_message));
	}
	
	
	if($request->send_now==1){
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('_id',$last_id)->get();
	if(!empty($mobile_number_data))
	{
	
	foreach($mobile_number_data as $mobile_number_data)
	{
	if($mobile_number_data['name_of_sender']==1){
	$receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
	}else{
	$name_of_contact = $mobile_number_data['name_of_contact'];
	$mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
	$receiver_mobile_number = $mobile_data['receiver_mobile_number'];
	}
	
	if($mobile_number_data['message_template']=='custom')
	{
	$rec_id = $mobile_number_data['_id'];
	$oid = (array) $rec_id;
    $rec_id = $oid['oid'];
	$template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
	}else{
	$template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
	}
	foreach($template_data as $i=>$tmp_data)
	{
	if($tmp_data['gdrive_name']!='')
	{
	$file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
	$ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
	sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}else{
	sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	}
	sleep(6);
	}
    }
	}
	}
	
	if($request->send_now==1){
	DB::table('tbl_whats_app_message')->where('_id',$last_id)->delete();
	DB::table('tbl_recurring_image_data')->where('recurring_id',$last_id)->delete();   
	}
	
	Session::flash('success', 'Message Saved.');
	return redirect()->to('/whatsapp/message-planner');
	}
	
	public function contactListing()
	{
	$user = Auth::user();
	$data = DB::table('tbl_whatsapp_contact')->where('user_id',$user->id)->orderBy('_id', 'DESC')->get();
    return view('whatsapp.contact-listing',['data'=>$data]);
	}
	
	
	public function accountManagement()
	{
	$user = Auth::user();
	$data = DB::table('tbl_whatsapp_account_management')->where('user_id',$user->id)->orderBy('_id', 'DESC')->paginate(5);
    return view('whatsapp.account-management-listing',['data'=>$data]);
	}
	
	
	public function updatecontact(Request $request)
	{
	$customMessages = [
	        'name_of_contact.required' => 'Name of contact must be filled out.',
			'receiver_mobile_number.required' => 'Receiver mobile number must be filled out.'
		];
		$this->validate($request, [
			'name_of_contact' => 'required',
			'receiver_mobile_number' => 'required',		
		],$customMessages);
	$user = Auth::user();	
	$data = array("user_id"=>$user->id,"name_of_contact" => $request->name_of_contact,"receiver_mobile_number"=> $request->receiver_mobile_number);
	DB::table('tbl_whatsapp_contact')->where('_id',$request->id)->update($data);
	Session::flash('success', 'Group updated successfully!');
	return redirect()->to('/whatsapp/groups');
	}
	
	
	public function updateaccountmanagement(Request $request)
	{
	$customMessages = [
	        'username.required' => 'Username must be filled out.',
	        'password.required' => 'Password must be filled out.',
			'mobile_number.required' => 'Mobile number must be filled out.'
		];
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required',
			'mobile_number' => 'required|numeric|min:10',		
		],$customMessages);
	$user = Auth::user();	
	$data = array("user_id"=>$user->id,"username" => $request->username,"password" => $request->password,"mobile_number"=> $request->mobile_number);
	DB::table('tbl_whatsapp_contact')->where('_id',$request->id)->update($data);
	Session::flash('success', 'Setting updated successfully!');
	return redirect()->to('/whatsapp/settings');
	}
	
	
	
	public function editContact($id)
	{
	$data = DB::table('tbl_whatsapp_contact')->where('_id',$id)->first();
	return view('whatsapp.edit-contact',['data'=>$data]);
	}
	
	
	public function editAccountManagement($id)
	{
	$data = DB::table('tbl_whatsapp_account_management')->where('_id',$id)->first();
	return view('whatsapp.edit-account-management',['data'=>$data]);
	}
	
	
	
	public function editsendmessage($id)
	{
	$user = Auth::user();
	$data = DB::table('tbl_message_send_multiple')->where('_id',$id)->first();
	$group_contact = DB::table('tbl_whatsapp_contact')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
	$message_template = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('name_of_template', 'asc')->get();
	$id = $data['_id'];
	$oid = (array) $id;
	$id = $oid['oid'];
	$message_data = DB::table('tbl_template_multiple_message_data')->where('template_id',$id)->get();
	return view('whatsapp.edit-send-message',['data'=>$data,'group_contact' => $group_contact,"message_template"=> $message_template,"message_data" => $message_data]);
	}

	public function imagedatadelete_temp(Request $request)
	{
	//DB::table('tbl_template')->where('_id',$request->temp_id)->delete(); 
	DB::table('tbl_template_data')->where('_id',$request->image_id)->delete(); 
	echo 1;
	}
	
	public function editMessage($id)
	{
	$data = DB::table('tbl_template')->where('_id',$id)->first();
	$id = $data['_id'];
	$oid = (array) $id;
	$id = $oid['oid'];
	$message_data = DB::table('tbl_template_data')->where('template_id',$id)->get();
	//pr($message_data); die;
	return view('whatsapp.edit-message',['data'=>$data,'message_data'=>$message_data,'hidden_id_image'=>$id]);
	}
	
	public function viewMessage($id)
	{
	$data = DB::table('tbl_template')->where('_id',$id)->first();
	$id = $data['_id'];
	$oid = (array) $id;
	$id = $oid['oid'];
	$message_data = DB::table('tbl_template_data')->where('template_id',$id)->get();
	//pr($message_data); die;
	return view('whatsapp.view-message',['data'=>$data,'message_data'=>$message_data]);
	}
	
	public function updatemessage2(Request $request)
	{
	    //pr($request->all()); die;
	$customMessages = [
	        'name_of_template.required' => 'Name of template must be filled out.',
		];
		$this->validate($request, [
			//'receiver_mobile_no' => 'required||min:10|unique:tbl_whats_app_message,receiver_mobile_no,'.$request->id.',_id',
			'name_of_template' => 'required',		
		],$customMessages);
		
		
	$user = Auth::user();
	$data = array("user_id"=>$user->id,"name_of_template" => $request->name_of_template);
	DB::table('tbl_template')->where('_id',$request->id)->update($data);
	DB::table('tbl_template_data')->where('template_id',$request->id)->delete();
	$message_text_data = count($request->message_text);
	
	for($i=0;$i<$message_text_data;$i++)
	{
	
	 $fileName = $request->hidden_gdrive[$i];
	 $original_name = $request->hidden_original_name[$i];
	 $data_message = array("user_id"=>$user->id,"template_id" => $request->id,"message_text"=> $request->message_text[$i],"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);    
	
	//pr($data_message);
	//die;
	if($request->hidden_gdrive_id[$i]!=''){
	//DB::table('tbl_template_data')->where('_id',$request->hidden_gdrive_id[$i])->update($data_message);
	DB::table('tbl_template_data')->insert(array($data_message));   
	}else{
	DB::table('tbl_template_data')->insert(array($data_message));   
	}
	}
	Session::flash('success', 'Template updated successfully!');
	return redirect()->to('/whatsapp/templates');
	}
	
	public function updatemessage(Request $request)
	{
	    //pr($request->all()); die;
	$customMessages = [
	        'name_of_template.required' => 'Name of template must be filled out.',
		];
		$this->validate($request, [
			'name_of_template' => 'required',		
		],$customMessages);
		
		
	$user = Auth::user();
	if($request->random==1){
	    $random = 1;
	}else{
	    $random = 0;
	}
	
	$data = array("user_id"=>$user->id,"name_of_template" => $request->name_of_template,'message_text_single'=>$request->message_text_single,'random'=>$random);
	DB::table('tbl_template')->where('_id',$request->id)->update($data);
	DB::table('tbl_template_data')->where('template_id',$request->id)->delete();
	$hidden_gdrive_data = count($request->hidden_gdrive);
	
	for($i=0;$i<$hidden_gdrive_data;$i++)
	{
	 $fileName = $request->hidden_gdrive[$i];
	 $original_name = $request->hidden_original_name[$i];
	 $data_message = array("user_id"=>$user->id,"template_id" => $request->id,"message_text"=> $request->message_text_single,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name,"caption"=>$request->message_text[$i]);    
	if($request->hidden_gdrive_id[$i]!=''){
	DB::table('tbl_template_data')->insert(array($data_message));   
	}else{
	DB::table('tbl_template_data')->insert(array($data_message));   
	}
	}
	Session::flash('success', 'Template updated successfully!');
	return redirect()->to('/whatsapp/templates');
	}
	
	
	
	public function savemessage2(Request $request)
	{
	    //pr($request->all()); //die;
	$customMessages = [
	        'name_of_template.required' => 'Name of template must be filled out.'
		];
		$this->validate($request, [
			//'receiver_mobile_no' => 'required||min:10|unique:tbl_whats_app_message,receiver_mobile_no,'.$request->id.',_id',
			'name_of_template' => 'required',		
		],$customMessages);
		
    $user = Auth::user();
	$data = array("user_id"=>$user->id,"name_of_template" => $request->name_of_template);
	$last_id = DB::table('tbl_template')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$message_text_data = count($request->message_text);
	for($i=0;$i<$message_text_data;$i++)
	{
	
	 $fileName = $request->hidden_gdrive[$i];
	 $original_name = $request->hidden_original_name[$i];
	 $data_message = array("user_id"=>$user->id,"template_id" => $last_id,"message_text"=> $request->message_text[$i],"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);    
	
	//pr($data_message);
	//die;
	if($request->hidden_gdrive_id[$i]!=''){
	DB::table('tbl_template_data')->where('_id',$request->hidden_gdrive_id[$i])->update($data_message);
	}else{
	DB::table('tbl_template_data')->insert(array($data_message));   
	}
	}
	Session::flash('success', 'Template added successfully!');
	return redirect()->to('/whatsapp/templates');
	}
	
	public function savemessage(Request $request)
	{
	    $customMessages = [
	        'name_of_template.required' => 'Name of template must be filled out.'
		];
		$this->validate($request, [
			'name_of_template' => 'required',		
		],$customMessages);
		
		$user = Auth::user();
        if($request->random==1){
        $random = 1;
        }else{
        $random = 0;
        }
		$data = array("user_id"=>$user->id,"name_of_template" => $request->name_of_template,'message_text_single'=>$request->message_text_single,'random'=>$random);
		$last_id = DB::table('tbl_template')->insertGetId($data);
	    $oid = (array) $last_id;
	    $last_id = $oid['oid'];
	    $hidden_gdrive_data = count($request->hidden_gdrive);
        for($i=0;$i<$hidden_gdrive_data;$i++)
        {
        $fileName = $request->hidden_gdrive[$i];
        $original_name = $request->hidden_original_name[$i];
        $data_message = array("user_id"=>$user->id,"template_id" => $last_id,"message_text"=> $request->message_text_single,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name,"caption"=>$request->message_text[$i]); 
        if($request->hidden_gdrive_id[$i]!=''){
        DB::table('tbl_template_data')->where('_id',$request->hidden_gdrive_id[$i])->update($data_message);
        }else{
        DB::table('tbl_template_data')->insert(array($data_message));   
        }
        }
		Session::flash('success', 'Template added successfully!');
	    return redirect()->to('/whatsapp/templates');
	}
	
	public function saverecurringmessage(Request $request)
	{
	    
	    $customMessages = [
	    'recurring_task_name.required' => 'Recurring Task Name must be filled out.',
	    'receiver_mobile_number.required' => 'Mobile Number must be filled out.',
	    'recurring_days.required' => 'Recurring days must be filled out.',
	    'recurring_time.required' => 'Recurring time must be filled out.',
	    'message_start_date.required' => 'Message start date must be filled out.',
	    'message_template.required' => 'Message template must be filled out.'
		];
		$this->validate($request, [
		'recurring_task_name'       => 'required',
		'receiver_mobile_number'    => 'required',
		'recurring_days'            => 'required',
		'recurring_time'            => 'required',
		'message_start_date'        => 'required',
		'message_template'          => 'required'
		],$customMessages);
		
	    $user = Auth::user();
	    
	    
	    $data = array("user_id"=>$user->id,"recurring_task_name"=>$request->recurring_task_name,"receiver_mobile_number" => $request->receiver_mobile_number,"recurring_days" => $request->recurring_days,"recurring_time" => $request->recurring_time,"pause_task" => "0","created_date" => $request->message_start_date);
	    $last_id = DB::table('tbl_recurring_number')->insertGetId($data);
        $oid = (array) $last_id;
        $last_id = $oid['oid'];
        $image = $request->file('gdrive_name');
        if($image!=''){
        $destinationPath = public_path('uploads/thumbnail');
        $fileName = time().$user->id.pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $fileName.'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(700, 700, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileName);
        $destinationPath_thumb = public_path('uploads/thumb');
        $img->resize(80, 80, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$fileName);
        $original_name = pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        }else{
        $fileName = '';
        $original_name = '';
        }
        $data_message = array("user_id"=>$user->id,"recurring_id" => $last_id,"message_text"=> $request->message_text,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
        DB::table('tbl_recurring_image_data')->insert(array($data_message));
	
    //     $send_data = DB::table('tbl_recurring_number')->where('_id', $last_id)->first();
    //     $send_image_data = DB::table('tbl_recurring_image_data')->where('recurring_id', $last_id)->first();
    //     $receiver_mobile_number = explode(',',$send_data['receiver_mobile_number']);
    //     if(!empty($receiver_mobile_number)){
    //     foreach($receiver_mobile_number as $send_receivers)
    //     {
    //     if($send_image_data['gdrive_name']!=''){
    //      $file_path = public_path('/uploads/thumbnail/'.$send_image_data['gdrive_name']);
    //      $ext = @pathinfo($send_image_data['gdrive_name'], PATHINFO_EXTENSION);
	   //  sendWhatsAppmsgWhatsAppX($send_image_data['gdrive_name'],$file_path,$ext,$send_receivers,"WhatsappX",$send_image_data['message_text']);
    //     }else{
    //      sendWhatsAppmsgWithoutFile($send_receivers,"WhatsappX",$send_image_data['message_text']);
    //     }
    //     }
    //     }
	
	    Session::flash('success', 'Message send successfully!');
	    return redirect()->to('/whatsapp/message-planner');
	}
	
	
	public function updaterecurringmessage(Request $request)
	{
	    $customMessages = [
	    'recurring_task_name.required' => 'Recurring Task Name must be filled out.',
	    'receiver_mobile_number.required' => 'Mobile Number must be filled out.',
	    'recurring_days.required' => 'Recurring days must be filled out.',
	    'recurring_time.required' => 'Recurring time must be filled out.',
	    'message_start_date.required' => 'Message start date must be filled out.',
	    'message_text.required' => 'Message must be filled out.'
		];
		$this->validate($request, [
		'recurring_task_name'       => 'required',
		'receiver_mobile_number'    => 'required',
		'recurring_days'            => 'required',
		'recurring_time'            => 'required',
		'message_start_date'        => 'required',
		'message_text'              => 'required'
		],$customMessages);
		
	    $user = Auth::user();  
	    
	    $data = array("user_id"=>$user->id,"recurring_task_name"=>$request->recurring_task_name,"receiver_mobile_number" => $request->receiver_mobile_number,"recurring_days" => $request->recurring_days,"recurring_time" => $request->recurring_time,'created_date' => $request->message_start_date);
	   DB::table('tbl_recurring_number')->where('_id',$request->id)->update($data);
	   DB::table('tbl_recurring_image_data')->where('recurring_id',$request->id)->delete();
	   
	    $image = $request->file('gdrive_name');
        if($image!=''){
        $destinationPath = public_path('uploads/thumbnail');
        $fileName = time().$user->id.pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $fileName.'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(700, 700, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileName);
        $destinationPath_thumb = public_path('uploads/thumb');
        $img->resize(80, 80, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$fileName);
        $original_name = pathinfo($request->file('gdrive_name')->getClientOriginalName(), PATHINFO_FILENAME).'.'.$request->file('gdrive_name')->getClientOriginalExtension();
        }else if($request->hidden_gdrive!=''){
        $fileName = $request->hidden_gdrive;
        $original_name = $request->hidden_original_name;
        }else{
        $fileName = '';
        $original_name = '';
        }
        $data_message = array("user_id"=>$user->id,"recurring_id" => $request->id,"message_text"=> $request->message_text,"gdrive_name"=> $fileName,"gdrive_id"=> "","original_name" => $original_name);
        //pr($data_message); die;
        DB::table('tbl_recurring_image_data')->insert(array($data_message));
        
        Session::flash('success', 'Message update successfully!');
	    return redirect()->to('/whatsapp/message-planner');
	   
	}
	
	
	public function downloadFile($file_name, $fileId)
	{
	try {
	$path = public_path().'/google_drive_whatsapp/' . $fileId;
    File::makeDirectory($path, $mode = 0777, true, true);
	$directory = public_path('/google_drive_whatsapp/'.$fileId.'/');
    $fileName = $file_name;
	$downloads_file = [
			'fileName' => $fileName,
			'mimeType' => @pathinfo($fileName, PATHINFO_EXTENSION),
			];
	session(['downloads_file' => $downloads_file]);
	$data = @file_put_contents($directory.'/'.$fileName, fopen("https://drive.google.com/uc?id=".$fileId."&export=download", 'r'));
	//pr($data); die;
	
	} catch (\Exception $e) {
	$error = json_decode($e->getMessage(), true);
	if($error['error']['code']==404){
	//echo 2;
	}
	}
	}
	
	
	
	
    public function whatsappsend()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->get();
	if(!empty($mobile_number_data))
	{
	foreach($mobile_number_data as $mobile_number_data)
	{
    if($mobile_number_data['pause_task']=="0")
    {
    if($mobile_number_data['recurring_days']==1)
    {
    $update_date = date('d-m-Y', strtotime($mobile_number_data['message_start_date'] . ' +'.$mobile_number_data['recurring_days'].' day')); 
    }else{
    $update_date = date('d-m-Y', strtotime($mobile_number_data['message_start_date'] . ' +'.$mobile_number_data['recurring_days'].' days'));    
    }
    $send_time = $mobile_number_data['recurring_time'];
	if($mobile_number_data['name_of_sender']==1){
	$receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
	}else{
	$name_of_contact = $mobile_number_data['name_of_contact'];
	$mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
	$receiver_mobile_number = $mobile_data['receiver_mobile_number'];
	}
	
	if($mobile_number_data['message_template']=='custom')
	{
	$rec_id = $mobile_number_data['_id'];
	$oid = (array) $rec_id;
    $rec_id = $oid['oid'];
	$template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
	}else{
	$template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
	}
	foreach($template_data as $i=>$tmp_data)
	{
	if($tmp_data['gdrive_name']!='')
	{
	$file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
	if(date('d-m-Y')==$mobile_number_data['message_start_date'] && date('H')==$send_time)
	{
	$ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
	sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	$data_message2 = array("message_start_date" => $update_date);
	DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
	}
	}else{
	if(date('d-m-Y')==$mobile_number_data['message_start_date'] && date('H')==$send_time)
	{
	sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
	$data_message2 = array("message_start_date" => $update_date);
	DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
	}
	}
	sleep(6);
	}
	}
    }
	}
	}
	
	
	public function whatsappsendmultiple()
	{
	$mobile_number_data = DB::table('tbl_message_send_multiple')->get();
	if(!empty($mobile_number_data))
	{
	foreach($mobile_number_data as $mobile_number_data)
	{
	    $send_time = $mobile_number_data['message_time'];
        if($mobile_number_data['name_of_sender']==1){
        $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
        }else{
        $name_of_contact = $mobile_number_data['name_of_contact'];
        $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
        $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
        }
        
        $rec_id = $mobile_number_data['_id'];
        $oid = (array) $rec_id;
        $rec_id = $oid['oid'];
        
        $template_data = DB::table('tbl_template_multiple_message_data')->where('template_id',$rec_id)->orderBy('_id', 'ASC')->get();
        foreach($template_data as $i=>$tmp_data)
        {
            
        if($tmp_data['gdrive_name']!='')
        {
        $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
        if(date('Y-m-d')==$mobile_number_data['message_date'] && date('H')==$send_time)
        {
        $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
        sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
        }
        }else{
        if(date('Y-m-d')==$mobile_number_data['message_date'] && date('H')==$send_time)
        {
        sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
        }
        }
        sleep(6);
        
        }
	
	}
	}
	}
	
	
	public function whatsappsendOneTimeMessage()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('is_recurring','0')->get(); 
	if(!empty($mobile_number_data))
	{
	    foreach($mobile_number_data as $mobile_number_data)
	    {
	        if($mobile_number_data['pause_task']=="0")
             {
                    //$update_date = date('d-m-Y', strtotime($mobile_number_data['message_start_date'] . ' +1 day')); 
                    $send_time = $mobile_number_data['recurring_time'];
                    if($mobile_number_data['name_of_sender']=='1'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='2'){
                    $name_of_contact = $mobile_number_data['name_of_contact'];
                    $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
                    $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='3'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];   
                    }
                    
                    if($mobile_number_data['message_template']=='custom')
                    {
                    $rec_id = $mobile_number_data['_id'];
                    $oid = (array) $rec_id;
                    $rec_id = $oid['oid'];
                    $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
                    }else{
                    $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
                    }
                    
                    foreach($template_data as $i=>$tmp_data)
                    {
                    if($tmp_data['gdrive_name']!='')
                    {
                    $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
                    if(date('d-m-Y')==$mobile_number_data['message_start_date'] && date('H')==$send_time)
                    {
                    $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
                    sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    }
                    }else{
                    if(date('d-m-Y')==$mobile_number_data['message_start_date'] && date('H')==$send_time)
                    {
                    sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    }
                    }
                    sleep(6);
                    }
             }
	    }
	}
	}
	
	
	public function whatsappsendEveryday()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('recurring_type','1')->get(); 
	if(!empty($mobile_number_data))
	{
	    foreach($mobile_number_data as $mobile_number_data)
	    {
	        if($mobile_number_data['pause_task']=="0")
             {
                    $update_date = date('d-m-Y', strtotime($mobile_number_data['message_start_date'] . ' +1 day')); 
                    $send_time = $mobile_number_data['recurring_time'];
                    if($mobile_number_data['name_of_sender']=='1'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='2'){
                    $name_of_contact = $mobile_number_data['name_of_contact'];
                    $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
                    $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='3'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];   
                    }
                    
                    if($mobile_number_data['message_template']=='custom')
                    {
                    $rec_id = $mobile_number_data['_id'];
                    $oid = (array) $rec_id;
                    $rec_id = $oid['oid'];
                    $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
                    }else{
                    $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
                    }
                    
                    foreach($template_data as $i=>$tmp_data)
                    {
                    if($tmp_data['gdrive_name']!='')
                    {
                    $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
                    if(date('d-m-Y')==$mobile_number_data['message_start_date'] && date('H')==$send_time)
                    {
                    $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
                    sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }else{
                    if(date('d-m-Y')==$mobile_number_data['message_start_date'] && date('H')==$send_time)
                    {
                    sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }
                    sleep(6);
                    }
             }
	    }
	}
	}
	
	public function whatsappsendDayofWeek()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('recurring_type','2')->get(); 
	if(!empty($mobile_number_data))
	{
	    foreach($mobile_number_data as $mobile_number_data)
	    {
	        if($mobile_number_data['pause_task']=="0")
             {
                   
                    $dow = explode(',',$mobile_number_data['day_of_week']);
                    foreach($dow as $dow)
                    {
                        $startDate = date('Y-m-d');
                        $endDate = date("Y-m-d", strtotime("+ 7 days"));
                        if($dow=='Sunday'){$weekdayNumber=0;}
                        if($dow=='Monday'){$weekdayNumber=1;}
                        if($dow=='Tuesday'){$weekdayNumber=2;}
                        if($dow=='Wednesday'){$weekdayNumber=3;}
                        if($dow=='Thursday'){$weekdayNumber=4;}
                        if($dow=='Friday'){$weekdayNumber=5;}
                        if($dow=='Saturday'){$weekdayNumber=6;}
                        $message_start_date = getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber);
                        $update_date = date('d-m-Y', strtotime($message_start_date . ' +7 days'));
                        $send_time = $mobile_number_data['recurring_time'];
                    if($mobile_number_data['name_of_sender']=='1'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='2'){
                    $name_of_contact = $mobile_number_data['name_of_contact'];
                    $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
                    $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='3'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];   
                    }
                    
                    if($mobile_number_data['message_template']=='custom')
                    {
                    $rec_id = $mobile_number_data['_id'];
                    $oid = (array) $rec_id;
                    $rec_id = $oid['oid'];
                    $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
                    }else{
                    $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
                    }
                    
                    foreach($template_data as $i=>$tmp_data)
                    {
                    if($tmp_data['gdrive_name']!='')
                    {
                    $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
                    if(date('l')==$dow && date('H')==$send_time)
                    {
                    $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
                    sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }else{
                    if(date('l')==$dow && date('H')==$send_time)
                    {
                    sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }
                    sleep(6);
                    }
                        
                    }
             }
	    }
	}
	}
	
	public function whatsappsendDayofMonth()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('recurring_type','3')->get(); 
	if(!empty($mobile_number_data))
	{
	    foreach($mobile_number_data as $mobile_number_data)
	    {
	        if($mobile_number_data['pause_task']=="0")
             {
                    $date = date('d', strtotime($mobile_number_data['message_start_date']));
                    $update_date = $date.'-'.date('m-Y', strtotime($mobile_number_data['message_start_date']. ' +30 days'));
                    $send_time = $mobile_number_data['recurring_time'];
                    if($mobile_number_data['name_of_sender']=='1'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='2'){
                    $name_of_contact = $mobile_number_data['name_of_contact'];
                    $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
                    $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='3'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];   
                    }
                    
                    if($mobile_number_data['message_template']=='custom')
                    {
                    $rec_id = $mobile_number_data['_id'];
                    $oid = (array) $rec_id;
                    $rec_id = $oid['oid'];
                    $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
                    }else{
                    $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
                    }
                    
                    foreach($template_data as $i=>$tmp_data)
                    {
                    if($tmp_data['gdrive_name']!='')
                    {
                    $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
                    if(date('d')==$mobile_number_data['date_of_month'] && date('H')==$send_time)
                    {
                    $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
                    sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }else{
                    if(date('d')==$mobile_number_data['date_of_month'] && date('H')==$send_time)
                    {
                    sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }
                    sleep(6);
                    }
             }
	    }
	}
	}
	
	public function whatsappsendDayofQuarter()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('recurring_type','4')->get(); 
	if(!empty($mobile_number_data))
	{
	    foreach($mobile_number_data as $mobile_number_data)
	    {
	        if($mobile_number_data['pause_task']=="0")
             {
                    
                    $update_date = date('d-m-Y', strtotime($mobile_number_data['message_start_date'] . "+3 months") );
                    $send_time = $mobile_number_data['recurring_time'];
                    if($mobile_number_data['name_of_sender']=='1'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='2'){
                    $name_of_contact = $mobile_number_data['name_of_contact'];
                    $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
                    $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='3'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];   
                    }
                    
                    if($mobile_number_data['message_template']=='custom')
                    {
                    $rec_id = $mobile_number_data['_id'];
                    $oid = (array) $rec_id;
                    $rec_id = $oid['oid'];
                    $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
                    }else{
                    $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
                    }
                    
                    foreach($template_data as $i=>$tmp_data)
                    {
                    if($tmp_data['gdrive_name']!='')
                    {
                    $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
                    $checkDateLoop = $this->checkQuaterly($mobile_number_data['month_of_quaterly']);
	                $c_month = $checkDateLoop[array_search(date('m'),$checkDateLoop)];
                    if(date('d')==$mobile_number_data['date_of_quaterly'] && date('m')==$c_month && date('H')==$send_time)
                    {
                    $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
                    sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }else{
                    $checkDateLoop = $this->checkQuaterly($mobile_number_data['month_of_quaterly']);
	                $c_month = $checkDateLoop[array_search(date('m'),$checkDateLoop)];
                    if(date('d')==$mobile_number_data['date_of_quaterly'] && date('m')==$c_month && date('H')==$send_time)
                    {
                    sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }
                    sleep(6);
                    }
             }
	    }
	}
	}
	
	public function whatsappsendDayofYearly()
	{
	$mobile_number_data = DB::table('tbl_whats_app_message')->where('recurring_type','5')->get(); 
	if(!empty($mobile_number_data))
	{
	    foreach($mobile_number_data as $mobile_number_data)
	    {
	        if($mobile_number_data['pause_task']=="0")
             {
                    
                    $update_date = date('d-m-Y', strtotime($mobile_number_data['message_start_date'] . "+1 year") );
                    $send_time = $mobile_number_data['recurring_time'];
                    if($mobile_number_data['name_of_sender']=='1'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='2'){
                    $name_of_contact = $mobile_number_data['name_of_contact'];
                    $mobile_data = DB::table('tbl_whatsapp_contact')->where('_id',$name_of_contact)->first();
                    $receiver_mobile_number = $mobile_data['receiver_mobile_number'];
                    }else if($mobile_number_data['name_of_sender']=='3'){
                    $receiver_mobile_number = $mobile_number_data['receiver_mobile_number'];   
                    }
                    
                    if($mobile_number_data['message_template']=='custom')
                    {
                    $rec_id = $mobile_number_data['_id'];
                    $oid = (array) $rec_id;
                    $rec_id = $oid['oid'];
                    $template_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$rec_id)->get();
                    }else{
                    $template_data = DB::table('tbl_template_data')->where('template_id',$mobile_number_data['message_template'])->orderBy('_id', 'ASC')->get();
                    }
                    
                    foreach($template_data as $i=>$tmp_data)
                    {
                    if($tmp_data['gdrive_name']!='')
                    {
                    $file_path = public_path('uploads/thumbnail/'.$tmp_data['gdrive_name']);
                    if(date('d')==$mobile_number_data['date_of_yearly'] && date('m')==$mobile_number_data['month_of_yearly'] && date('H')==$send_time)
                    {
                    $ext = @pathinfo($tmp_data['gdrive_name'], PATHINFO_EXTENSION);
                    sendWhatsAppmsgWhatsAppX($tmp_data['gdrive_name'],$file_path,$ext,$receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }else{
                    if(date('d')==$mobile_number_data['date_of_yearly'] && date('m')==$mobile_number_data['month_of_yearly'] && date('H')==$send_time)
                    {
                    sendWhatsAppmsgWithoutFile($receiver_mobile_number,"WhatsappX",$tmp_data['message_text'],$mobile_number_data['_id'],$mobile_number_data['user_id']);
                    $data_message2 = array("message_start_date" => $update_date);
                    DB::table('tbl_whats_app_message')->where('_id',$mobile_number_data['_id'])->update($data_message2);
                    }
                    }
                    sleep(6);
                    }
             }
	    }
	}
	}
	
	function checkQuaterly($month_of_quaterly)
	{
	$month_of_quaterly = explode('/',$month_of_quaterly);
	$quaterly_one = array(1,4,7,10);
	$quaterly_two = array(2,5,8,11);
	$quaterly_three = array(3,6,9,12);
	
	if ($month_of_quaterly == $quaterly_one) 
	return $quaterly_one;
	else if ($month_of_quaterly == $quaterly_two) 
	return $quaterly_two;
	else if ($month_of_quaterly == $quaterly_three) 
	return $quaterly_three;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
		DB::table('tbl_template')->where('_id',$id)->delete();
		DB::table('tbl_template_data')->where('template_id',$id)->delete();
		Session::flash('success', 'Template deleted successfully!');
	    return redirect()->to('/whatsapp/templates');
        
    }
	
	public function deleteContact($id)
	{
		$user = Auth::user();
		DB::table('tbl_whatsapp_contact')->where('_id',$id)->delete();
		Session::flash('success', 'Group deleted successfully!');
		return redirect()->to('/whatsapp/groups');
	}
	
	public function deletecontactdetails($id)
	{
	 DB::table('tbl_contact_details')->where('_id',$id)->delete();
	 Session::flash('success', 'Contact deleted successfully!');
	 return redirect()->to('/whatsapp/contacts');   
	}
	
	public function deletesendmessage($id)
	{
		$user = Auth::user();
		DB::table('tbl_message_send_multiple')->where('_id',$id)->delete();
		DB::table('tbl_template_multiple_message_data')->where('template_id',$id)->delete();
		Session::flash('success', 'Send message deleted successfully!');
		return redirect()->to('/whatsapp/send-message-listing');
	}
	
	public function recurringdeletemessage($id)
	{
	   $user = Auth::user();
		DB::table('tbl_whats_app_message')->where('_id',$id)->delete();
		//DB::table('tbl_recurring_image_data')->where('recurring_id',$id)->delete();
		//Session::flash('success', 'Recurring message deleted successfully!');
		//return redirect()->to('/whatsapp/recurring-message-listing'); 
		echo 1;
	}
	
	public function deleteaccountmanagement($id)
	{
	    $user = Auth::user();
		DB::table('tbl_whatsapp_account_management')->where('_id',$id)->delete();
		Session::flash('success', 'Setting deleted successfully!');
		return redirect()->to('/whatsapp/settings');  
	}
	
	public function ajaxaccountdefault($id)
	{
	    $user = Auth::user();
	    $data_message = array("user_id"=>$user->id,"make_as_default" => 0);
	    $data_message2 = array("user_id"=>$user->id,"make_as_default" => 1);
	    DB::table('tbl_whatsapp_account_management')->update($data_message);
	    DB::table('tbl_whatsapp_account_management')->where('_id',$id)->update($data_message2);
	    echo 1;
	}
	
	public function messagerecurring()
	{
	 //$user = Auth::user();
	 $data = DB::table('tbl_recurring_number')->orderBy('_id', 'DESC')->get();  
	 foreach($data as $send)
	 {   
	     if($send['pause_task']=="0")
	     {
	     if($send['recurring_days']==1)
	     {
	     $update_date = date('Y-m-d', strtotime($send['created_date'] . ' +'.$send['recurring_days'].' day')); 
	     }else{
	     $update_date = date('Y-m-d', strtotime($send['created_date'] . ' +'.$send['recurring_days'].' days'));    
	     }
	    $send_time = $send['recurring_time'];
	    if(date('Y-m-d')==$send['created_date'] && date('H')==$send_time){
	    $id = $send['_id'];
	    $oid = (array) $id;
	    $id = $oid['oid'];
        $send_image_data = DB::table('tbl_recurring_image_data')->where('recurring_id', $id)->first();
        //pr($send_image_data); die;
        $receiver_mobile_number = explode(',',$send['receiver_mobile_number']);
        if(!empty($receiver_mobile_number)){
        foreach($receiver_mobile_number as $send_receivers)
        {
        if($send_image_data['gdrive_name']!=''){
         $file_path = public_path('/uploads/thumbnail/'.$send_image_data['gdrive_name']);
         $ext = @pathinfo($send_image_data['gdrive_name'], PATHINFO_EXTENSION);
	     sendWhatsAppmsgWhatsAppX($send_image_data['gdrive_name'],$file_path,$ext,$send_receivers,"WhatsappX",$send_image_data['message_text']);
	     $data_message2 = array("created_date" => $update_date);
	     DB::table('tbl_recurring_number')->where('_id',$id)->update($data_message2);
        }else{
         sendWhatsAppmsgWithoutFile($send_receivers,"WhatsappX",$send_image_data['message_text']);
         $data_message2 = array("created_date" => $update_date);
	     DB::table('tbl_recurring_number')->where('_id',$id)->update($data_message2);
        }
        }
        }
	    }
	    sleep(6);
	  }
	 }
	}
	
	
	public function messagerecurringupdatedate(Request $request)
	{
	 $data_message = array("pause_task"=>"0",'message_start_date'=>$request->created_date);
	 DB::table('tbl_whats_app_message')->where('_id',$request->id)->update($data_message);
     Session::flash('success', 'Message update successfully!');
	 return redirect()->to('/whatsapp/message-planner');    
	}
	
	public function recurringreport($id='')
	{
	$user = Auth::user();   
	if($id=='')
	{
	$data = DB::table('tbl_recurring_report')->where('user_id',$user->id)->orderBy('_id', 'DESC')->get();
	}else{
	$data = DB::table('tbl_recurring_report')->where('user_id',$user->id)->where('msg_id',$id)->orderBy('_id', 'DESC')->get();   
	}
	//pr($data);die;
    return view('whatsapp.recurring-report-listing',['data'=>$data]);
	}

      public function ajaxrecurringpausetask($id,$status)
      {
         if($status==0){
             $pause_task = "1";
         }else{
             $pause_task = "0"; 
         }
         
         $data_message = array("pause_task"=>$pause_task);
	     DB::table('tbl_whats_app_message')->where('_id',$id)->update($data_message);
         echo 1;
      }
      
      public function sampledownloadfile()
      {
          $fileName = 'demo-contacts.csv';
          return response()->download(public_path('uploads/import_contact/'.$fileName));
      }
      
      
      public function ajaxmessageplanner(Request $request)
      {
        $user = Auth::user();
        if($request->exampleCheck1!='' && $request->exampleCheck2!='' && $request->id!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->where('message_template','=',$request->id)->orderBy('recurring_task_name', 'ASC')->get();  
        }else if($request->exampleCheck1!='' && $request->exampleCheck2!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->orderBy('recurring_task_name', 'ASC')->get();   
        }else if($request->exampleCheck1!='' && $request->id!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->where('pause_task','=',"0")->where('message_template','=',$request->id)->orderBy('recurring_task_name', 'ASC')->get();   
        }else if($request->exampleCheck2!='' && $request->id!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->where('pause_task','=',"1")->where('message_template','=',$request->id)->orderBy('recurring_task_name', 'ASC')->get();   
        }else if($request->id!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->where('message_template','=',$request->id)->orderBy('recurring_task_name', 'ASC')->get();   
        }else if($request->exampleCheck1!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->where('pause_task','=',"0")->orderBy('recurring_task_name', 'ASC')->get();   
        }else if($request->exampleCheck2!=''){
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->where('pause_task','=',"1")->orderBy('recurring_task_name', 'ASC')->get();   
        }else{
        $data = DB::table('tbl_whats_app_message')->where('user_id',$user->id)->orderBy('recurring_task_name', 'ASC')->get();   
        }
        $temp = DB::table('tbl_template')->where('user_id',$user->id)->orderBy('_id', 'DESC')->get(); 
        //pr($_POST);
        //pr($data);
        if(!empty($data)){
            $i= 1;
            foreach($data as $all_data)
            {
            $id = $all_data['_id'];
            $oid = (array) $id;
            $id = $oid['oid'];
            $template_message_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$id)->first();
            ?>
            <tr class="center san" id="del-<?php echo $all_data['_id'];?>">
            <td class="list center" data-table="#"><?php echo $i;?></td>
            <td class="name-box" data-table="Name"><span><?php echo $all_data['recurring_task_name'];?></span></td>
            <td class="contact-no-box center" data-table="Contact #"><span><?php if($all_data['name_of_contact']==''){ echo str_replace(',',', ',$all_data['receiver_mobile_number']);}else{ echo nameOfContact($all_data['name_of_contact']); }?></span></td>
            <td class="center"  data-table="Interval"><?php if($all_data['recurring_type']=='5' && $all_data['is_recurring']==1) {echo 'Yearly';}else if($all_data['recurring_type']=='4' && $all_data['is_recurring']==1) {echo 'Quaterly';}else if($all_data['recurring_type']=='3' && $all_data['is_recurring']==1) {echo 'Monthly';}else if($all_data['recurring_type']=='2' && $all_data['is_recurring']==1) {echo 'Weekly';}else if($all_data['recurring_type']=='1' && $all_data['is_recurring']==1){echo 'Everyday';}else if($all_data['is_recurring']==0){echo 'One Time';}else if($all_data['recurring_type']==''){echo '';}?></td>
            <td class="center date_width"  data-table="Schedule Date">
            <?php if($all_data['recurring_type']=='5' && $all_data['is_recurring']==1) {?>
            <span><?php echo $all_data['date_of_yearly'].'-'.$all_data['month_of_yearly'];?></span>&nbsp;&nbsp;<span style="color:gray;"><?php echo $all_data['recurring_time'];?>:00</span>
            <?php } else if($all_data['recurring_type']=='4' && $all_data['is_recurring']==1){?> 
            <span><?php echo $all_data['date_of_quaterly'].'-'.$all_data['month_of_quaterly'];?></span>&nbsp;&nbsp;<span style="color:gray;"><?php echo $all_data['recurring_time'];?>:00</span>
            <?php }else if($all_data['recurring_type']=='3' && $all_data['is_recurring']==1){?> 
            <span><?php echo $all_data['date_of_month'];?></span>&nbsp;&nbsp;<span style="color:gray;"><?php echo $all_data['recurring_time'];?>:00</span>
            <?php } else if($all_data['recurring_type']=='1' && $all_data['is_recurring']==1){?> 
            <span style="color:gray;"><?php echo $all_data['recurring_time'];?>:00</span> 
            <?php }else if($all_data['is_recurring']==0){?>
            <span><?php echo date('d-m',strtotime($all_data['message_start_date']));?></span>&nbsp;&nbsp;<span style="color:gray;"><?php echo $all_data['recurring_time'];?>:00</span> 
            <?php } ?>
            </td>
            <?php
            $d = explode('-',$all_data['message_start_date']);
            $k = $d[2].'-'.$d[1].'-'.$d[0];
            $c = date('Y-m-d');
            if($c<=$k && $all_data['pause_task']=="0"){?>
            <td class="center date_width " data-table="Next Schedule"><?php echo $all_data['message_start_date'].' '.$all_data['recurring_time'];?>:00</td>
            <?php }else{?>
            <td class="center" data-table="Next Schedule"></td>
            <?php } ?>
            <?php if($all_data['message_template']!='custom'){?>
            <td class="template-name-box center" data-table="Template"><span><?php echo messageTemplate($all_data['message_template']);?></span></td>
            <?php }else{?>
            <td class="template-name-box center" data-table="Template"><span>Custom</span></td>
            <?php } ?>
            <td align="center" class="center date_width " data-table="Last Message Sent">
            <?php if($all_data['report_id']!='' && $all_data['last_message_sent']!='01-01-1970 05:30'){?>
            <?php echo $all_data['last_message_sent'];?>
            <?php }else{?>
            Not sent yet.
            <?php } ?>
            </td>
            <td class="actions white-space" data-table="Action">
            <?php if($all_data['pause_task']=="0"){?>
            <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('whatsapp/whatsapp-message-planner/'.$all_data['_id']) }}" title="Resend"><i class="fa fa-whatsapp <?php if($c<=$k){echo 'green';}?>" aria-hidden="true"></i></a>
           <?php } ?>
            <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="<?php echo url('whatsapp/edit-message-planner/'.$all_data['_id']);?>" title="Edit"><i class="fa fa-edit" style="font-size:16px" aria-hidden="true"></i></a>
            
            <a <?php if($all_data['pause_task']=="1") {echo 'style="display:none"';}?> href="javascript:void(0);" cus="<?php echo $all_data['pause_task'];?>" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic pause-task pau-<?php echo $all_data['_id'];?>" id="<?php echo $all_data['_id'];?>" title="Pause"><i class="fa fa-pause" aria-hidden="true"></i></a>
            <?php if($all_data['is_recurring']==0){?>
            <a href="javascript:void(0);" <?php if($all_data['pause_task']=="0") {echo 'style="display:none"';}?> data-toggle="modal" data-target="#myModal" cus="<?php echo $all_data['pause_task'];?>" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic play-task pal-<?php echo $all_data['_id'];?> hid" id="<?php echo $all_data['_id'];?>" title="Play"><i class="fa fa-play" aria-hidden="true"></i></a>
            <?php }else{?>
            <a href="javascript:void(0);" <?php if($all_data['pause_task']=="0") {echo 'style="display:none"';}?> cus="<?php echo $all_data['pause_task'] ?>" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic play-task-d pal-<?php echo $all_data['_id'];?> hid" id="<?php echo $all_data['_id'];?>" title="Play"><i class="fa fa-play" aria-hidden="true"></i></a>
            <?php } ?>
            <a class="delete-row btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic " id="<?php echo $all_data['_id'];?>" title="Delete"  href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true" style="font-size:16px; color:red;"></i></a>
            <a href="<?php echo url('whatsapp/copy-message-planner/'.$all_data['_id']);?>" title="Copy" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic"><i style="font-size:16px" class="fa fa-files-o" aria-hidden="true"></i></a>
            </td>
            </tr>
            
            <?php
            $i++; 
            }
        }
      }
      
      
      
      
      public function ajaxTemplate2($id)
      {
        $data = DB::table('tbl_template')->where('_id',$id)->first();
        $mid = $data['_id'];
        $oid = (array) $mid;
        $mid = $oid['oid'];
        $message_data = DB::table('tbl_template_data')->where('template_id',$mid)->get(); 
        $html = '<div class="add-box">';
        foreach($message_data as $key=>$msg_data)
        {
            if($msg_data['gdrive_name']!='')
            {
                $html .= '<div class="add-row">';
                $html .= '<div class="form-group row"><div class="col-lg-12 msg-tamplate">';
                $html .= '<div class="upload-button upload-box">';
                if($msg_data['gdrive_name']!='')
                {
                    $html .= '<a href="'.url('public/uploads/thumbnail/'.$msg_data['gdrive_name']).'" target="_blank"><img src="'.url('public/uploads/thumbnail/'.$msg_data['gdrive_name']).'" title="'.$msg_data['original_name'].'"></a>';
                }
                $html .= '</div>';
                $html .= '<div class="text-area-box"><div class="msg-box">'.nl2br($msg_data['message_text']).'</div></div>';
                $html .= '</div></div>';
                $html .= '</div>';
            }else{
                $html .= '<div class="add-row">';
                $html .= '<div class="form-group row"><div class="col-lg-12 msg-tamplate">';
                $html .= '<div class="text-area-box"><div class="msg-box">'.nl2br($msg_data['message_text']).'</div></div>';
                $html .= '</div></div>';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
      }
      
       public function ajaxTemplate($id)
      {
        $data = DB::table('tbl_template')->where('_id',$id)->first();
        $mid = $data['_id'];
        $oid = (array) $mid;
        $mid = $oid['oid'];
        $message_data = DB::table('tbl_template_data')->where('template_id',$mid)->get(); 
        $html = '<div class="add-box">';
        $html .= '<div class="add-row">';
        $html .= '<div class="form-group row"><div class="col-lg-12 msg-tamplate">';
        $html .= '<div class="text-area-box"><div class="msg-box">'.nl2br($data['message_text_single']).'</div></div>';
        $html .= '</div></div>';
        $html .= '</div>';
        foreach($message_data as $key=>$msg_data)
        {
            if($msg_data['gdrive_name']!='')
            {
                $html .= '<div class="add-row">';
                $html .= '<div class="form-group row"><div class="col-lg-12 msg-tamplate">';
                $html .= '<div class="upload-button upload-box">';
                if($msg_data['gdrive_name']!='')
                {
                $html .= '<a href="'.url('public/uploads/thumbnail/'.$msg_data['gdrive_name']).'" target="_blank"><img src="'.url('public/uploads/thumbnail/'.$msg_data['gdrive_name']).'" title="'.$msg_data['original_name'].'"></a>';
                }
                $html .= '</div>';
                $html .= '<div class="text-area-box"><div class="msg-box">'.nl2br($msg_data['caption']).'</div></div>';
                $html .= '</div></div>';
                $html .= '</div>';
            }else{
                $html .= '<div class="add-row">';
                $html .= '<div class="form-group row"><div class="col-lg-12 msg-tamplate">';
                $html .= '<div class="text-area-box"><div class="msg-box">'.nl2br($msg_data['caption']).'</div></div>';
                $html .= '</div></div>';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
      }
      
      
      public function ajax_image_uploads(Request $request){
          //pr($_FILES); die;
                $user = Auth::user();
                $test = explode('.', $_FILES["file"]["name"]);
                $ext = end($test);
                $name = rand(1000000, 9999999) . '.' . $ext;
                $location = public_path('uploads/thumbnail/') . $name;  
                @move_uploaded_file($_FILES["file"]["tmp_name"], $location);
                $data_message = array("user_id"=>$user->id,"message_text"=>"","template_id" => $_POST['hidden_id'],"gdrive_name"=> $name,"gdrive_id"=> "","original_name" => $_FILES["file"]["name"]);
	            //pr($data_message); die;
	            if($_POST['hidden_gdrive_id']==''){
	            $last_id = DB::table('tbl_template_data')->insertGetId($data_message);
	            $oid = (array) $last_id;
	            $last_id = $oid['oid'];
	            }else{
	            DB::table('tbl_template_data')->where('_id',$_POST['hidden_gdrive_id'])->update($data_message);  
	            $last_id = $_POST['hidden_gdrive_id'];
	            }
                $arr = array('gdrive_name' => $name, 'original_name' => $_FILES["file"]["name"],'hidden_gdrive_id'=>$last_id);
                echo json_encode($arr);
          
      }
	
	

}
