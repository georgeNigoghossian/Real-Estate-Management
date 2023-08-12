<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class Admin extends  Authenticatable
{

    public $table="admins";
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    public $fillable = [
        'name',
        'email',
        'password',
        'mobile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $validation_rules = [
        'name' => 'required',
        'email' => 'required|email',
        'mobile' => 'required',
        'password' => 'required|min:3',
    ];
}
