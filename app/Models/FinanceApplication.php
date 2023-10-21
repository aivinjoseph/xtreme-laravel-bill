<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'co_applicant' => 'array',
        'trade_in' => 'array',
    ];
}
