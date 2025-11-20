<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,softDeletes;
    public $timestamps = false;
    protected $guarded=['id'];
    protected $fillable = [
        'company_id',
        'name',
        'name_en',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function MenuItem()
    {
        return $this->hasMany(MenuItem::class);
    }

}
