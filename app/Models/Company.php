<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, softDeletes;
    protected $guarded  = ['id'];
    protected $fillable = [
        'name',
        'username',
        'address',
        'state',
        'city',
        'phone',
        'name_boss',
        'phone_boss',
        'phone_representative',
        'capacity',
        'sm_tel',
        'sm_instagram',
        'sm_telegram',
        'sm_whatsapp',
        'sm_twitter',
        'sm_threads',
        'sm_website',
        'zip',
        'lat',
        'long',
        'plan_menu',
        'plan_order_taker',
        'plan_time_report',
        'plan_online_order',
        'plan_printer_control',
        'plan_preparation_notification',
        'active',
        'fee_received',
        'image',
    ];

    public function template_data()
    {
        return $this->hasOne(TemplateData::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function work_shifts()
    {
        return $this->hasMany(Workshift::class);
    }

    public function employers()
    {
        return $this->hasMany(User::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Menu()
    {
        return $this->hasMany(Menu::class);
    }
    public function MenuItem()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function Table()
    {
        return $this->hasMany(Table::class);
    }

    public function Printer()
    {
        return $this->hasMany(Printer::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CompanySubscription::class, 'company_id');
    }

    public function active(): void
    {
        $this->update(['active' => true]);
    }

}
