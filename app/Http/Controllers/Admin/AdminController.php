<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /// direct admin Profile page
    public function profile()
    {
        $id = auth()->user()->id;
        $userData = User::where('id', $id)->first();
        return view('admin.profile.index')->with(['user' => $userData]);
    }

    // Update Admin Profile
    public function updateProfile($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $this->requestUserData($request);
        User::where('id', $id)->update($data);
        return back()->with(['updateSuccess' => 'Profile Updated!']);
    }

    // direct Change Password Page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $id = auth()->user()->id;
        $data = User::where('id', $id)->first();

        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $confirmPassword = $request->confirmPassword;
        $hashedPassword = $data['password'];

        if (Hash::check($oldPassword, $hashedPassword)) {
            if ($newPassword == $confirmPassword) {
                if (strlen($newPassword) > 6 && strlen($confirmPassword) > 6) {
                    $hash = Hash::make($newPassword);

                    User::where('id', $id)->update(['password' => $hash]);

                    return redirect()->route('admin#profile')->with(['changePwdSuccess' => 'Password Changed!', 'user' => $data]);
                } else {
                    return back()->with(['lengthError' => 'Password length must be greater than 6!']);
                }
            } else {
                return back()->with(['sameError' => 'New Password not match with Confirm Password!']);
            }
        } else {
            return back()->with(['matchError' => 'Old Password do not match... Try Again!']);
        }

    }

    // Request User Data to array
    private function requestUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
}
