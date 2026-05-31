<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateData extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    protected $fillable=[
        'company_id',
        "address",
        "icon",
        "title",
        "name",
        "slider_t",
        "slider_d",
        "sec_1_t",
        "sec_1_m",
        "sec_1_d",
        "sec_2_p_1_t",
        "sec_2_p_2_t",
        "sec_2_p_3_t",
        "sec_2_p_1_d",
        "sec_2_p_2_d",
        "sec_2_p_3_d",
        "sec_3_t",
        "sec_3_m",
        "sec_4_t",
        "sec_4_m",
        "sec_5_t",
        "sec_5_m",
        "sec_5_d",
        "s_1_i",
        "s_2_i",
        "s_3_i",
        "s_4_i",
        "s_5_i",
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
