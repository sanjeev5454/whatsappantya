<?php
namespace App\Http\Controllers\purchaseorder;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail; 
use App\User;
use App\Vendor;
use Session;
use Cookie;
use Socialite;

class UserController extends Controller {
    use AuthenticatesUsers;
	
	protected $username = 'email';
	protected $redirectTo = '/dashboard';
	protected $guard = 'web'; 
	
	public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
	
	public function handleGoogleCallback()
    {
	//echo 1; die;
        try {
		    
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
			
			//pr($finduser); die;
            if($finduser){
                User::where('_id', $finduser['_id'])->update(['name' => ucwords($user->name),'google_id' => $user->id]);
				setcookie('session_google_id', $user->id, time()+31556926, "/");
                insertUpdateGlobaldata(ucwords($user->name),$user->email,$user->id,1);
				Auth::login($finduser);
			  
                return redirect('/dashboard');
   
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id
                ]);
			setcookie('session_google_id', $user->id, time()+31556926, "/");
			insertUpdateGlobaldata(ucwords($user->name),$user->email,$user->id,1);
               Auth::login($newUser);
               return redirect()->back();
            }
  
        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }
	
	public function getLogin() {
	//loginCheckGoogle();
		if(Auth::guard('web')->check()) {
			//return redirect(url('/dashboard'));
			//return redirect()->back();
			return redirect()->intended('/dashboard');
		}
		return view('auth.login');
		//return redirect('http://localhost/document/admin/login');
	}	
	
	public function postLogin(Request $request) {
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
		]);
		$auth = Auth::guard('web')->attempt(['email'=>$request->email,'password'=>$request->password]);
		//print_r($auth); die;
		if($auth) {
			if($request->remember==1){
				Cookie::queue(Cookie::make('userEmail', $request->email, time() + ( 365 * 24 * 60 * 60)));
				Cookie::queue(Cookie::make('userPassword', $request->password, time() + ( 365 * 24 * 60 * 60)));
				Cookie::queue(Cookie::make('userRemember', $request->remember, time() + ( 365 * 24 * 60 * 60)));
			}
			//return redirect(url('/dashboard'));
			//return redirect()->back();
			return redirect()->intended('/dashboard');
		}
		Session::flash('error', 'Username/Password is invalid.');
		return redirect('/login/')->withErrors('Username/Password is invalid.')->withInput();
	} 
	
	public function forgotPassword(){
		return view('auth.forgot_password');
	}	
	
	public function forgot_password(Request $request) {
		$this->validate($request, [
			'email' => 'required|email',
		]);
		$users_details = DB::table('users')->where('email',$request->email)->first();
		$hashstr = md5($request->email).sha1($request->email);
		DB::table('users')->where('email',$request->forgot_email)->update(['reset_pwd_hash' => $hashstr,'reset_pwd_status' =>'0']);
		//pr($users_details); die;
		if($users_details) {
			$emailconfirm = '<a href="'.url('/reset_password/'.$hashstr).'">Click here for reset password</a>';
			$datamail = array(
				'from'=> 'mohit.kumar@eyeforweb.com',
				'type'=>'forgot_password',
				'subject'=>'Forgot Password',
				'message' => $emailconfirm
			);
			//echo $request->email;
			//print_r($datamail);die;
			Mail::to('dhruvjha28@gmail.com')->send(new SendMail($datamail));
			return redirect('/login')->withErrors('Please check your email and reset your password.')->withInput();
		}else{
			return redirect('/login')->withErrors('Email does not exists in our database.')->withInput();
		}
		//echo $message; die;
		//@mail($subject, $message, $from);		
	
		//return redirect('/forgot_password')->withErrors('Email does not exists in our database.')->withInput();
	}

	public function reset_password(Request $request, $id) {
		$users_details = DB::table('users')->/* where('reset_pwd_hash',$id)-> */first();
		if($users_details) {
			return view('purchaseorder.reset_password',['reset_pwd_hash' => $id]);
		}else{
			return redirect('/login')->withErrors('Invalid Token')->withInput();
		}
	}
	
	public function resetPassword(Request $request) {
		$this->validate($request, [
			'new_password' => 'required|min:6',
			'confirm_password' => 'required|same:new_password',
		]);
		$users_details = DB::table('users')->where('reset_pwd_hash',$request->reset_pwd_hash)->first();
		if($users_details) {
			$oid = (array) $users_details['_id'];
			$id = $oid['oid'];
			$new_password = $request->new_password;
			$shift1 = substr($request->new_password, 0, 2);
			$fresh_new_password = crypt($request->new_password, $shift1);
			DB::table('users')->where('id',$id)->update(['password' => $fresh_new_password,'ori_password' => $new_password, 'reset_pwd_hash' => NULL]);
			Session::flash('success', 'Your password successfully changed.');
			return redirect(url('/login'));
		}else{
			return redirect('/purchaseorder/reset_password/'.$request->reset_pwd_hash)->withErrors('Invalid Token')->withInput();
		}
	}
	
	/*public function getLogout() {
		Auth::guard('web')->logout();
		Cookie::queue(Cookie::forget('session_google_id'));
		return redirect()->route('/login');
	}	
*/	
		
	public function editProfile() {
		$edit_details = User::find(Auth::id());
		return view('purchaseorder.user.edit-profile',['edit_details' => $edit_details]);
	}
	
	public function Setting()
	{
	  //$purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('item', "5fcf52abd049043e1a386ed2")->where('status',2)->get(); 
	  //$purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->get();
	  //pr($purchase_data_items_val); die;
	  $data = DB::table('tbl_purchase_settings')->first();
	  $vendors  = User::where('user_role','!=','1')->where('user_id','=','5c5966020f0e7526c00021eb')->orderBy('_id', 'desc')->get();
	  //pr($data); die;
	  return view('purchaseorder.user.setting',['data' => $data,'vendors' => $vendors]);  
	}
	
	public function settingUpdate(Request $request)
	{
	    //pr($request->all()); die;
	    
	    if($request->approval_rights!=''){
	      $approval_rights =   implode(',',$request->approval_rights);
	    }else{
	        $approval_rights = '';
	    }
	
    DB::table('tbl_purchase_settings')->where('user_id', '5c5966020f0e7526c00021eb')
       ->update(['menus' => $request->menus,'code_vendor' => $request->code_vendor,'approval_rights' => $approval_rights]);
    Session::flash('success', 'Setting updated successfully.');
    return redirect('/purchaseorder/user/setting');
	}
	
	public function profileUpdate(Request $request) {
		$this->validate($request, [
			'name' => 'required',
		]);
	
		$edit_details = User::find(Auth::id());
		$edit_details->name = $request->name;
		if($request->password==''){
			$edit_details->password = $request->hidden_password;
		}else{
			$shift = substr($request->password, 0, 2);
			$password = crypt($request->password, $shift);
			$edit_details->password = $password;
			$edit_details->ori_password = $request->password;
		}
	
		if($request->profile_image !=''){
			$image = $request->file('profile_image');
			$imageName = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/profile_images_thumbs');
			$img  = Image::make($image->getRealPath())->resize(50, 50, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save($destinationPath.'/'.$imageName);
			$destinationPath = public_path('/profile_images');
			$image->move($destinationPath, $imageName);
		}else{
			$imageName = '';
		}
		$edit_details->avatar = $imageName;
		$edit_details->save();
		Session::flash('success', 'Profile updated successfully.');
		return redirect('/purchaseorder/user/profile');
	}	
	
	
	public function staffListing()
	{
	   $staff_data = User::where('user_role','!=','1')->where('user_id','=','5c5966020f0e7526c00021eb')->orderBy('_id', 'desc')->paginate(15);
	   //pr($staff_data); die;
	   return view('purchaseorder.user.staff-listing',['staff_data' => $staff_data]); 
	}
	
	public function addStaff()
	{
	   return view('purchaseorder.user.add-staff'); 
	}
	
	public function editStaff($id)
	{
	   $staff = User::find($id);
	   return view('purchaseorder.user.edit-staff',['staff'=>$staff]); 
	}
	
	public function staffDelete($id)
	{
	  User::where('_id','=',$id)->delete();
	  Session::flash('success', 'Staff deleted successfully!');
	  return redirect()->to('/purchaseorder/staff-listing');  
	}
	
	public function staffDataPost(Request $request)
	{
	  $customMessages = [
			'name.*' => 'Name must be filled out.',
			'email.unique' => 'Email should be unique.',
			'phone.*' => 'Mobile number must be 10 digits.',
			'role.*' => 'Role must be filled out.',
		];
		$this->validate($request, [
			'name'  => 'required',
			'email' => 'required|email|unique:users',
			'phone' => 'required|min:10',
			'role'  => 'required',
		],$customMessages);  
		$Insert_Users_Data = array("name"=>$request->name,"phone"=>$request->phone,"email"=>$request->email,"role_id"=>$request->role,"user_id"=>'5c5966020f0e7526c00021eb',"create_datetime"=>date('Y-m-d h:i:s'),"modified_datetime" => date('Y-m-d h:i:s'));
	    DB::table('users')->insert(array($Insert_Users_Data));
	    $message = 'Hello '.$request->name.',<br/><br/>';
	    $message .= 'You\'ve been invited by Purchase Order team<br/><br/>';
	    $message .= 'Please <a target="_blank" href="https://themesofwp.com/wpxproduct">Click Here</a> to join in. It hardly takes a minute to do so.<br/><br/>';
	    $message .= 'Welcome aboard :)<br/><br/><br/>';
	    //echo $message; die;
	    emailSendUser($request->email,'Add User',$message);
		Session::flash('success', 'Staff added successfully.');
		return redirect('/purchaseorder/staff-listing');
	}
	
	
		public function staffDataUpdate(Request $request, $id){
		$customMessages = [
			'name.*' => 'Name must be filled out.',
			'email.unique' => 'Email should be unique.',
			'phone.*' => 'Mobile number must be 10 digits.',
			'role.*' => 'Role must be filled out.'
		];
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$id.',_id',
			'phone' => 'required|min:10',	
			'role'  => 'required'
		],$customMessages);
	
		$staff_data_update = User::find($id);
		$staff_data_update->name = $request->name;
		$staff_data_update->email = $request->email;
		$staff_data_update->phone = $request->phone;
		$staff_data_update->role_id = $request->role;
		$staff_data_update->save();
		Session::flash('success', 'Staff updated successfully!');
		return redirect()->to('/purchaseorder/staff-listing');
	}
	
}