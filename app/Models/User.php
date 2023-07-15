<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @method static create(array $array)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'mobile',
        'facebook',
        'gender',
        'date_of_birth',
        'is_blocked',
        'priority',
        'sms_verification_code',
        'sms_verified_at',
    ];


    public $validation_rules = [
        'name' => ['string','min:2', 'max:255'],
        'email' => ['email', 'min:2', 'max:255'],
        'mobile' => ['string', 'size:10'],
        'facebook' => ['string'],
        'gender' => ['in:male,female'],
        'date_of_birth' => ['date:Y-m-d'],
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class,'user_notifications');
    }


}
