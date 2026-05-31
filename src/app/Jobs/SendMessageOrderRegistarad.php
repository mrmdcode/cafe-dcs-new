<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar;

class SendMessageOrderRegistarad implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $name ;
    public $phone ;
    public $company_username;
    public $idAndUnique;
    /**
     * Create a new job instance.
     */
    public function __construct($name,$phone,$username, $idAndUnique)
    {
        $this->name="مجموعه";
        $this->phone=$phone;
        $this->company_username=$username;
        $this->idAndUnique = $idAndUnique;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $receptor = $this->phone;
            $token = $this->name;
            $token2 = $this->company_username;
            $token3 = $this->idAndUnique;
            $template="cafe-dcs-OrderCheck";
            //Send null for tokens not defined in the template
            //Pass token10 and token20 as parameter 6th and 7th
            $result = Kavenegar::VerifyLookup($receptor, $token, $token2, $token3, $template, $type = null);
            if($result){
                Log::alert('send message success',[$result]);
            }
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                Log::error(' message error',[$e]);
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                Log::error(' message error',[$e]);
            echo $e->errorMessage();
        }
    }
}
