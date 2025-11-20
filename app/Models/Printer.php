<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=['id'];
    protected $fillable = [
        'company_id',
        'name',
        'local_address',
        'cashier',
    ];

    public function MenuItem()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function Company()
    {
        return $this->belongsTo(Company::class);
    }
}
