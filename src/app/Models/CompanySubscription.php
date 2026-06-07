<?php
namespace App\Models;

use App\Enums\CompanySubscriptionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanySubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'payment_id',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'starts_at'     => 'datetime',
        'ends_at'       => 'datetime',
        'status'        => CompanySubscriptionStatus::class,
    ];

    // =============================================
    // Relationships
    // =============================================

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(CompanyPayment::class);
    }

    // =============================================
    // Scopes
    // =============================================
    public function scopeExpired(Builder $query)
    {
        return $query->whereNotNull('ends_at')
            ->where('ends_at', '<', now());
    }
}
