<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedClient extends Model
{
    use HasFactory;

    public $fillable = [
        'description',
        'reporting_user_id',
        'reported_user_id',
        'report_category_id',
    ];

    public function reportingUser()
    {
        return $this->belongsTo(User::class,'reporting_user_id');
    }

    public function reportiedUser()
    {
        return $this->belongsTo(User::class,'reported_user_id');
    }

    public function reportCategory()
    {
        return $this->belongsTo(ReportCategory::class,'report_category_id');
    }
}
