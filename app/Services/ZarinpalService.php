<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZarinpalService
{
    private string $merchantId;
    private bool $isSandbox;
    private string $requestUrl;
    private string $startPayUrl;
    private string $verifyUrl;

    public function __construct()
    {
        $this->merchantId = config('services.zarinpal.merchant_id');
        $this->isSandbox  = config('services.zarinpal.mode') === 'sandbox';

        if ($this->isSandbox) {
            $this->requestUrl  = 'https://sandbox.zarinpal.com/pg/v4/payment/request.json';
            $this->startPayUrl = 'https://sandbox.zarinpal.com/pg/StartPay/';
            $this->verifyUrl   = 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json';
        } else {
            $this->requestUrl  = 'https://payment.zarinpal.com/pg/v4/payment/request.json';
            $this->startPayUrl = 'https://payment.zarinpal.com/pg/StartPay/';
            $this->verifyUrl   = 'https://payment.zarinpal.com/pg/v4/payment/verify.json';
        }
    }

    /**
     * Request payment from Zarinpal
     */
    public function request(string $amount, string $description, string $callbackUrl, $mobile = null, $email = null)
    {
        $data = [
            'merchant_id'  => $this->merchantId,
            'amount'       => $amount,
            'description'  => $description,
            'callback_url' => $callbackUrl,
            'currency'     => 'IRT',
        ];

        if ($mobile) {
            $data['mobile'] = $mobile;
        }

        if ($email) {
            $data['email'] = $email;
        }

        $response = Http::post($this->requestUrl, $data);
        $result = $response->json();

        if (isset($result['data']['message']) && $result['data']['message'] === 'Success') {
            return [
                'success'     => true,
                'authority'   => $result['data']['authority'],
                'payment_url' => $this->startPayUrl . $result['data']['authority'],
            ];
        }

        return [
            'success' => false,
            'error'   => $result['errors']['code'] ?? 'Unknown error',
            'message' => $this->getErrorMessage($result['errors']['code'] ?? 0),
        ];
    }

    /**
     * Verify payment
     */
    public function verify(string $authority, string $amount)
    {
        $data = [
            'merchant_id' => $this->merchantId,
            'authority'   => $authority,
            'amount'      => $amount,
        ];

        $response = Http::post($this->verifyUrl, $data);
        $result   = $response->json();
        if (isset($result['data']['code']) && ($result['data']['code'] == 100 || $result['data']['code'] == 101)) {
            return [
                'success' => true,
                'ref_id'  => $result['data']['ref_id'] ?? null,
                'message' => $result['data']['message'],
                "code"    => $result['data']['code'],
            ];
        }

        return [
            'success' => false,
            'error'   => $result['errors']['code'] ?? 'Unknown error',
            'message' => $this->getErrorMessage($result['errors']['code'] ?? 0),
        ];
    }

    /**
     * Get error message by status code
     */
    private function getErrorMessage($status)
    {
        $errors = [
            -1  => 'اطلاعات ارسال شده ناقص است.',
            -2  => 'IP یا مرچنت کد پذیرنده صحیح نیست.',
            -3  => 'با توجه به محدودیت‌های شاپرک امکان پرداخت با رقم درخواست شده میسر نمی‌باشد.',
            -4  => 'سطح تایید پذیرنده پایین‌تر از سطح نقره‌ای است.',
            -11 => 'درخواست مورد نظر یافت نشد.',
            -12 => 'امکان ویرایش درخواست میسر نمی‌باشد.',
            -21 => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد.',
            -22 => 'تراکنش نا موفق می‌باشد.',
            -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد.',
            -34 => 'سقف تقسیم تراکنش از لحاظ تعداد یا رقم عبور نموده است.',
            -40 => 'اجازه دسترسی به متد مربوطه وجود ندارد.',
            -41 => 'اطلاعات ارسال شده مربوط به AdditionalData غیرمعتبر می‌باشد.',
            -42 => 'مدت زمان معتبر طول عمر شناسه پرداخت باید بین 30 دقیقه تا 45 روز می‌باشد.',
            -54 => 'درخواست مورد نظر آرشیو شده است.',
            100 => 'عملیات با موفقیت انجام شد.',
            101 => 'عملیات پرداخت موفق بوده و قبلا تایید شده است.',
        ];

        return $errors[$status] ?? 'خطای نامشخص رخ داده است.';
    }
}
