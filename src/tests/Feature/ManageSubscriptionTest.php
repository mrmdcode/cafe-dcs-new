<?php
namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyPayment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ManageSubscriptionTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $company    = Company::factory()->create(['fee_received' => 150000]);
        $this->user = User::factory()->create(['company_id' => $company->id]);
    }

    public function test_it_redirects_to_zarinpal_on_payment_request()
    {
        # fake the http call to company manager (main payment service)
        Http::fake([
            '*/api/payments/initiate' => Http::response([
                'success'     => true,
                'token'       => 'test-token-abc',
                'payment_url' => 'https://sandbox.zarinpal.com/pg/StartPay/A000...',
            ], 200),
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('subscription.pay'));

        $response->assertRedirect('https://sandbox.zarinpal.com/pg/StartPay/A000...');
        # token should be stored in session
        $response->assertSessionHas('pending_payment.token', 'test-token-abc');
    }

    public function test_it_activates_subscription_on_successful_callback()
    {
        Http::fake([
            '*/api/payments/status/*' => Http::response([
                'status' => 'paid',
                'ref_id' => 'REF123456',
                'amount' => 150000,
            ], 200),
        ]);

        session(['pending_payment' => [
            'token'      => 'test-token-abc',
            'amount'     => 150000,
            'company_id' => $this->user->company_id,
        ]]);

        $response = $this->actingAs($this->user)
            ->get(route('subscription.callback') . '?' . http_build_query([
                'success' => 'true',
                'token'   => 'test-token-abc',
                'ref_id'  => 'REF123456',
            ]));

        $response->assertRedirect()->assertSessionHas('success');

        // Check payment saved in Cafe DCS
        $this->assertDatabaseHas('company_payments', [
            'company_id'   => $this->user->company_id,
            'amount'       => 150000,
            'reference_id' => 'REF123456',
            'status'       => 'paid',
        ]);

        // Check subscription created and linked to payment
        $payment = CompanyPayment::where('reference_id', 'REF123456')->first();

        $this->assertDatabaseHas('company_subscriptions', [
            'company_id' => $this->user->company_id,
            'payment_id' => $payment->id,
            'status'     => 'active',
        ]);
    }

    public function test_it_does_not_activate_subscription_when_cancelled()
    {
        session(['pending_payment' => [
            'token'      => 'test-token-abc',
            'amount'     => 150000,
            'company_id' => $this->user->company_id,
        ]]);

        $response = $this->actingAs($this->user)
            ->get(route('subscription.callback', [
                'success' => 'false',
            ]));

        $response->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseMissing('company_subscriptions', [
            'company_id' => $this->user->company_id,
            'status'     => 'active',
        ]);
    }

    public function test_it_activates_subscription_via_webhook()
    {
        $response = $this->postJson(route('subscription.webhook'), [
            'event'              => 'paid',
            'external_reference' => $this->user->company_id,
            'ref_id'             => 'REF123456',
            'amount'             => 150000,
        ]);

        $response->assertJson(['received' => true]);

        $this->assertDatabaseHas('company_payments', [
            'company_id'   => $this->user->company_id,
            'amount'       => 150000,
            'reference_id' => 'REF123456',
            'status'       => 'paid',
        ]);

        // Check subscription created and linked to payment
        $payment = CompanyPayment::where('reference_id', 'REF123456')->first();

        $this->assertDatabaseHas('company_subscriptions', [
            'company_id' => $this->user->company_id,
            'payment_id' => $payment->id,
            'status'     => 'active',
        ]);
    }

}
