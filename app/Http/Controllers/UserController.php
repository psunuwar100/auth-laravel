<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerUser(Request $req){

        $req->validate([
            'name'=> 'required',
            'email'=> 'required|unique:users',
            'password'=> 'required',

        ]);
        

        $newUser=new user();
        $newUser->name=$req->name;
        $newUser->email=$req->email;
        $newUser->password=Hash::make($req->password);

        $newUser->save();

        return redirect('/login');
    }

    public function loginUser(Request $req){
        $req->validate([
            'email'=> 'required',
            'password'=> 'required',
        ]);
        $user=user::where('email','=',$req->email)->first();
        if ($user){
            if(Hash::check($req->password,$user->password)){
                return redirect('/');
            }else{
                return back()->with('fail','Wrong Password');
            }
        }else{
            return back()->with('fail','User not found');
        }
        
    }


}
