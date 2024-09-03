<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function __construct(private User $user){}

    public function show()
    {
        return $this->user->find(Auth::user()->id);
    }
}
