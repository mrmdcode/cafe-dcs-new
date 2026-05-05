<?php
namespace App\Console\Commands;

use App\Enums\CompanySubscriptionStatus;
use App\Models\CompanySubscription;
use App\Services\Sms\SmsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSubscriptionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-subscription-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS reminders for subscriptions ending soon or expired';

    /**
     * Execute the console command.
     */
    public function handle(SmsService $smsService)
    {
        $this->sendReminders($smsService);
        $this->handleExpiredSubscriptions($smsService);
    }

    private function sendReminders(SmsService $smsService): void
    {
        $targetDate = Carbon::now()->addDays(2)->toDateString();

        $subscriptions = CompanySubscription::query()
            ->where('status', CompanySubscriptionStatus::ACTIVE)
            ->whereDate('ends_at', $targetDate)
            ->whereNull('reminder_sent_at')
            ->with('company')
            ->get();

        foreach ($subscriptions as $subscription) {
            $company = $subscription->company;
            $phone   = $company->phone ?? null;

            if ($phone) {
                $message = "{$company->name} عزیز، اشتراک شما تا ۲ روز دیگر به پایان می‌رسد. لطفاً برای تمدید اقدام کنید.";
                $smsService->send($phone, $message);

                $subscription->update(['two_day_reminder_sent_at' => now()]);
            }
        }
    }

    private function handleExpiredSubscriptions(SmsService $smsService): void
    {
        $now = Carbon::now();

        $subscriptions = CompanySubscription::query()
            ->where('status', CompanySubscriptionStatus::ACTIVE)
            ->where('ends_at', '<', $now)
            ->with('company')
            ->get();

        foreach ($subscriptions as $subscription) {
            $subscription->update(['status' => CompanySubscriptionStatus::EXPIRED]);

            $company = $subscription->company;
            $phone   = $company->phone_boss ?? $company->phone;

            if ($phone) {
                $paymentLink = route('subscription.required');

                $message = "{$company->name} عزیز، اشتراک شما به پایان رسیده است. برای فعال‌سازی مجدد از لینک زیر استفاده کنید:\n{$paymentLink}";

                $smsService->send($phone, $message);
            }
        }
    }
}
