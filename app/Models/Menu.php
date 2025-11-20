<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,softDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
        'company_id',
        'name',
        'name_en',
        'description',
        'show_customer',
        'show_order_recipient',

    ];

    public function Company()
    {
        return $this->belongsTo(Company::class);
    }
    public function MenuItem()
    {
        return $this->hasMany(MenuItem::class);
    }
}
