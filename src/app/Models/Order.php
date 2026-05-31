<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded  = ['id'];
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
        'cashier_time',

    ];

    protected $casts = [
        'status' => \App\Enums\OrderStatus::class,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function menu_item()
    {
        return $this->belongsToMany(MenuItem::class, 'item_order')
            ->withPivot(['qty', 'per', 'description']);
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

    # Scopes

    /**
     * Search by customer name (related model).
     */
    public function scopeSearchCustomer(Builder $query, ?string $name): void
    {
        if (! empty($name)) {
            $query->whereHas('customer', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            });
        }
    }

    /**
     * Search by location (table name or location field).
     * Adjust the field if you store location elsewhere.
     */
    public function scopeSearchLocation(Builder $query, ?string $location): void
    {
        if (! empty($location)) {
            // Assuming you have a 'table' relationship with a 'name' column.
            $query->whereHas('table', function ($q) use ($location) {
                $q->where('name', 'like', "%{$location}%");
            });
        }
    }

    /**
     * Search by invoice number (order ID or unique_key).
     */
    public function scopeSearchInvoice(Builder $query, ?string $invoice): void
    {
        if (! empty($invoice)) {
            $query->where(function ($q) use ($invoice) {
                $q->where('id', $invoice)
                    ->orWhere('unique_key', 'like', "%{$invoice}%");
            });
        }
    }

    /**
     * Filter orders created after or equal to a given date.
     */
    public function scopeDateFrom(Builder $query, ?string $date): void
    {
        if (! empty($date)) {
            $query->whereDate('created_at', '>=', $date);
        }
    }

    /**
     * Filter orders created before or equal to a given date.
     */
    public function scopeDateTo(Builder $query, ?string $date): void
    {
        if (! empty($date)) {
            $query->whereDate('created_at', '<=', $date);
        }
    }

    /**
     * Filter orders that are paid/finished (i.e. not registration/cancelled/edit).
     */
    public function scopeStatusPaid(Builder $query): void
    {
        $query->whereNotIn('status', ['registration', 'cancelled', 'edit']);
    }

    public function scopeToday(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::today());
    }

    public function scopeYesterday(Builder $query)
    {
        return $query->whereBetween('created_at', [
            Carbon::yesterday()->startOfDay(),
            Carbon::today()->subSecond(), // up to 23:59:59 yesterday
        ]);
    }

    public function scopeOlder(Builder $query)
    {
        return $query->where('created_at', '<', Carbon::yesterday()->startOfDay());
    }

    # Helpers
    public static function generateUniqueKey(): string
    {
        do {
            $key = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (static::where('unique_key', $key)->exists());

        return $key;
    }
}
