<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $uri = Auth::user()->role === 'admin' ? 'Admin/ManageProfile' : 'Teacher/ManageProfile';
         
        return inertia($uri);
    }

    public function update(ProfileRequest $request)
    { 
        User::find($request->user()->id)
            ->update($request->validated());
        
        return back()->with('success', 'Profile has been updated');
    }

    public function changePassword(ChangePasswordRequest $request)
    { 
        $new_password = $request->safe()->only('new_password');

        User::find($request->user()->id)
            ->update(['password' => $new_password['new_password']]);
        
        return back()->with('success', 'Password has been updated');
    }
}
