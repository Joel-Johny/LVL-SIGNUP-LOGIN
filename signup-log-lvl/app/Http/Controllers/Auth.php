<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    //
    public function dashboard(Request $r){

        $userModel=new UserModel;
        $userId = Session::get("id");
        $result=$userModel->getUserDetails($userId);
        $userData=["name"=>$result["username"],"email"=>$result["email"]];
        return view('dashboard',$userData);

    }

    public function logout(){
        Session::forget('id');
        Session::flush();
        return redirect('login');
    }

    public function login(Request $r){
        if ($r->isMethod('get')) 
            return view('login');

        $form_post_data = $r->only(['email', 'username', 'password', 'confirm_password']);
        $rules=[
                'username' => 'required',
                'password' => 'required',
            ];
        $validator = Validator::make($form_post_data,$rules);
        $ajax_response=["success"=>false];
    
        
        if ($validator->fails())
            $validationResult = $validator->errors();
            
        else{
            // echo "Validation passed";
            $userModel=new UserModel;
            $result=$userModel->getUserData($form_post_data["username"]);
            if(isset($result)){// record was found
    
                // echo var_dump($result);
    
                if (Hash::check($form_post_data['password'], $result["password"])) {
    
                    $validationResult["login_status"]="Password Verified!";
                    // session(['id' => $result["id"]]);
                    Session::put("id",$result["id"]);
                    Session::save();

                    $ajax_response["success"]=true;
                    // return redirect('dashboard');
                }
                
                else
                    $validationResult["login_status"]="Invalid credentials";
            }
        
            else // record was not found
                $validationResult["login_status"]="Invalid credentials";
        }
        if($ajax_response["success"]==false)
            $ajax_response["validations"]=$validationResult;
    
        exit(json_encode($ajax_response));

        // return view('login',$validationResult);
    
        
    }

    public function register(Request $r){
       if ($r->isMethod('get')) 
        return view('register');
    
        $form_post_data = $r->only(['email', 'username', 'password', 'confirm_password']);

        $rules = [
            'email' => 'required|email',
            'username' => 'required|min:4',
            'password' => 'required|min:8', 
            'confirm_password' => 'required|same:password',
        ];
        $validator = Validator::make($form_post_data,$rules);
        $ajax_response=["success"=>false];
    
    
        if ($validator->fails())
            $validationResult = $validator->errors();
        
    
        else{
            // echo "Validation passed";
            // check for duplicate user
            $userModel=new UserModel;
            $result=$userModel->dulpicateUser($form_post_data["email"],$form_post_data["username"]);
            // echo var_dump($result);
            if(isset($result)){
    
                if($result["username"]==$form_post_data["username"])
                    $validationResult["dbValidation"]="Username already exists!";
                else
                    $validationResult["dbValidation"]="Email already exists!";
            }
        
            else {
                //NO duplicate account so save the user
                $userModel->email = $form_post_data["email"];
                $userModel->username = $form_post_data["username"];
                $userModel->password = bcrypt($form_post_data["password"]);
                $userModel->save();
                $ajax_response=["success"=>true];
            }
                   
    
        }
    if($ajax_response["success"]==false)
        $ajax_response["validations"]=$validationResult;
        
    exit(json_encode($ajax_response));
        //  return view('register',$validationResult);
    }
}
