<?php

namespace App\Models;

use App\Models\Agency\Agency;
use App\Models\Property\Property;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $array)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


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
        'name' => ['string', 'min:2', 'max:255'],
        'email' => ['email', 'min:2', 'max:255'],
        'mobile' => ['string', 'size:13'],
        'facebook' => ['string'],
        'gender' => ['in:male,female'],
        'date_of_birth' => ['date:Y-m-d'],
        'fcm_token' => ['string'],
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
        return $this->belongsToMany(UserNotification::class, 'user_notifications');
    }

    public function savedProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'saved_properties');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function agency_requests(): HasMany
    {
        return $this->hasMany(AgencyRequest::class);
    }

    public function agency(): HasOne
    {
        return $this->hasOne(Agency::class, 'created_by');
    }

    public function AgencyRequestStatus(): string
    {
        return ($this->agency_requests()->exists()) ? 'Rejected' : 'No request submitted';
    }

    public function reportedHistory(): HasMany
    {
        return $this->hasMany(ReportedClient::class, 'reported_user_id');
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }
}
