<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshift extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'company_id',
        'shift_name',
        'start_time',
        'end_time',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
