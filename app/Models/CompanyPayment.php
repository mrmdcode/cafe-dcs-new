<?php
namespace App\Models;

use App\Enums\CompanySubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'payment_number',
        'transaction_id',
        'reference_id',
        'authority',
        'tracking_code',
        'amount',
        'status',
        'gateway_response',
        'gateway_status',
        'failure_reason',
        'ip_address',
        'user_agent',
        'description',
        'paid_at',
        'failed_at',
    ];

    protected $casts = [
        'amount'    => 'integer',
        'paid_at'   => 'datetime',
        'failed_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subscription()
    {
        return $this->hasOne(CompanySubscription::class);
    }

    /**
     * Helpers
     */
    public function isPaid(): bool
    {
        return $this->status === CompanySubscriptionStatus::ACTIVE;
    }

    public function isFailed(): bool
    {
        return $this->status === CompanySubscriptionStatus::EXPIRED;
    }
}
