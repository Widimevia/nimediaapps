<?php

namespace Webkul\Income\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Income\Contracts\Income as IncomeContract;

class Income extends Model implements IncomeContract
{
    protected $fillable = [
        'subject', 'description', 'type', 'name_of_payer', 'tax_amount', 'grand_total', 'date_transac'
    ];
}