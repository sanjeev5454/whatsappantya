<?php
namespace App\Http\Controllers\document;
use App\Http\Controllers\Controller;
Use Auth;
use Illuminate\Http\Request;
use Socialite;
use Google_Client;
use Google_Service_Drive;
Use DB;
use Session;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\User;
error_reporting(0);
ini_set('memory_limit','2048M');

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
		$pan_cards = DB::table('tbl_pan_cards')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
		$passports = DB::table('tbl_passports')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
		$aadhar_card = DB::table('tbl_aadhar_card')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
		$driving_licence = DB::table('tbl_driving_licence')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
		$voter_id = DB::table('tbl_voter_id')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
		$category = DB::table('tbl_category')->where('user_id',$user->id)->orderBy('_id', 'ASC')->get();
		
        return view('document.admin_dashboard',['pan_cards'=>$pan_cards,'passports'=>$passports,'aadhar_card' => $aadhar_card,'driving_licence' => $driving_licence,'voter_id' => $voter_id,'user_details' => $user,'category' => $category]);
		
	    
    }
	
	public function addLabel(Request $request)
	{
	$user = Auth::user();
	$data = array('user_id' => $user->id,'label_name' => $request->label_name);
	DB::table('tbl_category')->insertGetId($data);
	return redirect(url('/document/dashboard'));
	}
	
	public function ajaxDropdownUpdate($id)
	{
	$user = Auth::user();
	DB::table('users')->where('_id',$user->id)->update(['company_session_id' => $id]);
	echo 1;
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
    $user = Auth::user();
	if($request->type=='pan_cards'){
	if($request->id_db=='')
	{
	$file_id = $request->field_id;
	if(@$file_id!=''){
	$fileId = @$file_id; 
	if($request->column_name=='link')
	{
	if($fileId!='')
	{
	$this->downloadFile($request->name_val, $fileId);
	}
	}
	}
	
	if($fileId==''){
	$source_type = 'ldrive';
	}else{
	$source_type = 'gdrive';
	}
	
	if($request->field_id!='')
	{
	$file_id = $request->field_id;
	}else{
	$file_id = $user->id;
	}
	
	$data = array('cat_id' => $request->cat_id,$request->column_name=>$request->name_val,'user_id' => $user->id,'file_id' => $file_id,'source_type' => $source_type);
	$last_id = DB::table('tbl_pan_cards')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('pan_cards_id' => $last_id,'chk_id' => $file_id);
    return json_encode($arr);
	}else{
	$file_id = $request->field_id;
	if(@$file_id!=''){
	$fileId = @$file_id; 
	if($request->column_name=='link')
	{
	if($fileId!='')
	{
	$this->downloadFile($request->name_val, $fileId);
	}
	}
	}
	if($fileId==''){
	$source_type = 'ldrive';
	}else{
	$source_type = 'gdrive';
	}
	
	if($request->field_id!='')
	{
	$file_id = $request->field_id;
	}else{
	$file_id = $user->id;
	}
	
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id,'file_id' => $file_id,'source_type' => $source_type);
	DB::table('tbl_pan_cards')->where('_id',$request->id_db)->update($data);
	$arr = array('pan_cards_id' => $request->id_db, 'chk_id' => $file_id);
    return json_encode($arr);
	}
	}
	
	
	if($request->type=='passports'){
	if($request->id_db=='')
	{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id;  
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	$last_id = DB::table('tbl_passports')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('passports_id' => $last_id, 'chk_id' => $file_id);
    return json_encode($arr);
	}else{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id; 
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	DB::table('tbl_passports')->where('_id',$request->id_db)->update($data);
	$arr = array('passports_id' => $request->id_db, 'chk_id' => $file_id);
    return json_encode($arr);
	}
	}
	
	
	if($request->type=='aadhar_card'){
	if($request->id_db=='')
	{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id;  
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	$last_id = DB::table('tbl_aadhar_card')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('aadhar_card_id' => $last_id, 'chk_id' => $file_id);
    return json_encode($arr);
	}else{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id;  
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	DB::table('tbl_aadhar_card')->where('_id',$request->id_db)->update($data);
	$arr = array('aadhar_card_id' => $request->id_db, 'chk_id' => $file_id);
    return json_encode($arr);
	}
	}
	
	
	if($request->type=='driving_licence'){
	if($request->id_db=='')
	{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id; 
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	$last_id = DB::table('tbl_driving_licence')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('driving_licence_id' => $last_id, 'chk_id' => $file_id);
    return json_encode($arr);
	}else{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id; 
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	DB::table('tbl_driving_licence')->where('_id',$request->id_db)->update($data);
	$arr = array('driving_licence_id' => $request->id_db, 'chk_id' => $file_id);
    return json_encode($arr);
	}
	}
	
	
	if($request->type=='voter_id'){
	if($request->id_db=='')
	{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id;  
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	$last_id = DB::table('tbl_voter_id')->insertGetId($data);
	$oid = (array) $last_id;
	$last_id = $oid['oid'];
	$arr = array('voter_id' => $last_id, 'chk_id' => $file_id);
    return json_encode($arr);
	}else{
	$file_id1 = explode('id=',$request->name_val);
	$file_id2 = explode('d/',$request->name_val);
	$file_id3 = explode('/',$file_id2[1]);
	if($file_id1[1]!=''){
	$file_id = $file_id1[1];
	}else{
	$file_id = $file_id3[0];
	}
	if(@$file_id!=''){
	$google_client_token  =  session('google_client_token');
	$client = new Google_Client();
	$client->setApplicationName("Laravel");
	$client->setClientSecret($user->client_secret);
	$client->setClientId($user->client_id);
	$client->setAccessToken(json_encode($google_client_token));
	$service = new Google_Service_Drive($client);
	$fileId = @$file_id; 
	$this->downloadFile($service, $fileId);
	}
	$data = array($request->column_name=>$request->name_val,'user_id' => $user->id);
	DB::table('tbl_voter_id')->where('_id',$request->id_db)->update($data);
	$arr = array('voter_id' => $request->id_db, 'chk_id' => $file_id);
    return json_encode($arr);
	}
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
		DB::table('tbl_pan_cards')->where('_id',$id)->delete();
		DB::table('tbl_passports')->where('_id',$id)->delete();
		DB::table('tbl_aadhar_card')->where('_id',$id)->delete();
		DB::table('tbl_driving_licence')->where('_id',$id)->delete();
		DB::table('tbl_voter_id')->where('_id',$id)->delete();
        echo $id;
    }
	
	public function dataLinkRemove($id)
    {
        $user = Auth::user();
		$data = array('link' => '');
	    DB::table('tbl_pan_cards')->where('_id',$id)->update($data);
        echo $id;
    }
	
	public function createCredetials()
	{
	return view('create-credetials');
	}
	
	
	public function pageRedirect(Request $request)
	{
	$u = DB::table('tbl_pan_cards')->where('_id',$request->d)->first();
	//$dir = $u['file_id'].'/'.$u['link'];
	$arr = array('file_id' => $u['file_id'], 'source_type' => $u['source_type'], 'link' => $u['link']);
    return json_encode($arr);
	//$dir = $u['file_id'];
	//return $dir;
	}
	
	public function downloadFile($file_name, $fileId)
	{
	try {
	$path = public_path().'/google_drive_file/' . $fileId;
    File::makeDirectory($path, $mode = 0777, true, true);
	$directory = public_path('/google_drive_file/'.$fileId.'/');
    $fileName = $file_name;
	$downloads_file = [
			'fileName' => $fileName,
			'mimeType' => @pathinfo($fileName, PATHINFO_EXTENSION),
			];
	session(['downloads_file' => $downloads_file]);
	$data = @file_put_contents($directory.'/'.$fileName, fopen("https://docs.google.com/uc?export=download&id=".$fileId, 'r'));

	//echo 1;
	} catch (\Exception $e) {
	$error = json_decode($e->getMessage(), true);
	if($error['error']['code']==404){
	//echo 2;
	}
	}
	}
	
	public function getDownload($id){
	    $user = Auth::user();
		$google_client_token  =  session('google_client_token');
		$client = new Google_Client();
		$client->setApplicationName("Laravel");
		$client->setClientSecret($user->client_secret);
		$client->setClientId($user->client_id);
		$client->setAccessToken(json_encode($google_client_token));
		$service = new Google_Service_Drive($client);
		$fileId = $id;
		try { 
		$file = $service->files->get($fileId);
        $file_data = public_path()."/google_drive_file/".$id."/".$file->name;
        $headers = array('Content-Type: '.$file->mimeType,);
        return response()->download($file_data, $file->name,$headers);
		}catch (\Exception $e) {
		$error = json_decode($e->getMessage(), true);
		if($error['error']['code']==404){
		return redirect(url('document/dashboard?file=error'));
		}
		}
		}
	
	function ajaxUserlogin($name, $email){
	 $finduser = User::where('email', $email)->first();
	 if($finduser){
                User::where('_id', $finduser['_id'])->update(['name' => ucwords($name),'google_id' => '']);
				//setcookie('session_google_id', $user->id, time()+31556926, "/");
                //insertUpdateGlobaldata(ucwords($user->name),$user->email,$user->id,1);
				Auth::login($finduser);
			    redirect(url('document/dashboard'));
                echo '';
   
            }else{
                $newUser = User::create([
                    'name' => ucwords($name),
                    'email' => $email,
                    'google_id'=> ''
                ]);
			//setcookie('session_google_id', $user->id, time()+31556926, "/");
			//insertUpdateGlobaldata(ucwords($user->name),$user->email,$user->id,1);
               Auth::login($newUser);
               redirect(url('document/dashboard'));
               echo '';
            }
	}
	
	public function emailSend(Request $request)
	{
	$user = Auth::user();
	$attachment_file = explode(',',trim($request->attachment_file));
	$to = $request->email; 
	$from = $user->email; 
	$fromName = $user->name; 
	
	$subject = $request->email_subject;  
	$files = array();
	foreach($attachment_file as $f){/*
	$dir = public_path('/google_drive_file/'.trim($f).'/');
		if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..')
		{
		array_push($files,$dir.$file);
		}
		}
		closedir($handle);
		}
	*/
	$u = DB::table('tbl_pan_cards')->where('_id',trim($f))->first();
	$dir = public_path('/google_drive_file/'.trim($u['file_id']).'/'.$u['link']);
	array_push($files,$dir);
	}
	
	$htmlContent = $request->message; 
	
	// Call function and pass the required arguments 
	$sendEmail = $this->multi_attach_mail($to, $subject, $htmlContent, $from, $fromName, $files); 
	
	// Email sending status 
	if($sendEmail){ 
	//echo 'The email has sent successfully.'; 
	}else{ 
	//echo 'Mail sending failed!'; 
	}
	return redirect(url('document/dashboard'));
	}
	
/** Mail with attachment */
function multi_attach_mail($to, $subject, $message, $senderEmail, $senderName, $files = array()){ 
 
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
 
    // Preparing attachment 
    if(!empty($files)){ 
        for($i=0;$i<count($files);$i++){ 
            if(is_file($files[$i])){ 
                $file_name = basename($files[$i]); 
                $file_size = filesize($files[$i]); 
                 
                $message .= "--{$mime_boundary}\n"; 
                $fp =    @fopen($files[$i], "rb"); 
                $data =  @fread($fp, $file_size); 
                @fclose($fp); 
                $data = chunk_split(base64_encode($data)); 
                $message .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\n" .  
                "Content-Description: ".$file_name."\n" . 
                "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".$file_size.";\n" .  
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
            } 
        } 
    } 
     
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


public function imageUploads(Request $request)
{
$user = Auth::user();
 $upload = 'err'; 
if(!empty($_FILES['local_upload_file'])){ 
     
    // File upload configuration 
 
	$path = public_path().'/google_drive_file/' . $user->id;
    File::makeDirectory($path, $mode = 0777, true, true);
	$targetDir = public_path('/google_drive_file/'.$user->id.'/');
    //$allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif', 'xls','csv','xlsx'); 
     
    $fileName = basename($_FILES['local_upload_file']['name']); 
    $targetFilePath = $targetDir.$fileName;
	$data = array('user_id' => $user->id,'local_file_name' => $fileName);
	DB::table('tbl_user_local_file')->insertGetId($data); 
     
    // Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
    if(!empty($fileType)){ 
        // Upload file to the server 
        if(move_uploaded_file($_FILES['local_upload_file']['tmp_name'], $targetFilePath)){ 
            $upload = 'ok'; 
        } 
    } 
} 
echo $upload; 
}

	
}
