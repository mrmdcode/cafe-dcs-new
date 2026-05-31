<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'company_id',
        'category_id',
        'menu_id',
        'printer_id',
        'name',
        'name_en',
        'price',
        'active',
        'description',
        'description_en',
        'show_customer',
        'show_order_recipient',
        'image',
        'rost_time',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function menu(){
        return $this->belongsTo(Menu::class);
    }
    public function printer(){
        return $this->belongsTo(Printer::class);
    }
}
