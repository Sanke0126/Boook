<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class AccountController extends Controller
{
    public function register()
    {
        return view('account.register');
    }
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('account.login')->with('success', 'You have Registered Successfully');
    }
    public function login()
    {
        return view('account.login');
    }
    public function loginCheck(request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile')->with('success', 'Login Successfully');
        } else {
            return redirect()->route('account.login')->with('error', 'Email or Password is Invalid');
        }
    }
    public function profile()
    {
        $user = User::find(Auth::user()->id);
        return view('account.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
        ];
        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }
        if ($request->image != '') {
            File::delete('storage/profile/' . Auth::user()->image);
            File::delete('storage/profile/thumb/' . Auth::user()->image);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/profile', $imageName);
        } else {
            $user = User::find(Auth::user()->id);
            $imageName = $user->image ?  $user->image  : '';
        }
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->save();
        $manager = new ImageManager(Driver::class);
        $img = $manager->read('storage/profile/' . $imageName);
        $img->cover(150, 150);
        $img->save('storage/profile/thumb/' . $imageName);
        return redirect()->route('account.profile')->with('success', 'Profile Updated Successfully');
    }
    public function changePassword()
    {
        return view('account.update-password');
    }
    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.changePassword')->withInput()->withErrors($validator);
        }
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->get('current_password'), $user->password)) {
            return back()->with('error', "Current Password is Invalid");
        }
        if (strcmp($request->get('current_password'), $request->password) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }
        $user->password =  Hash::make($request->password);
        $user->save();
        return back()->with('success', "Password Changed Successfully");
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
