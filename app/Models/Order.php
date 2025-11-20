<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'table_id',
        'company_id',
        'order_recipient_id',
        'waiter_id',
        'cashier',
        'customer_id',
        'status',
        'unique_key',
        'discount',
        'waiter_time',
        'cashier_time'  ,

    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function menu_item()
    {
        return $this->belongsToMany(MenuItem::class, 'item_order')
            ->withPivot(['qty','per','description']);
    }

    public function order_recipient()
    {
        return $this->belongsTo(User::class, 'order_recipient_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function Table()
    {
        return $this->belongsTo(Table::class);
    }
}

