<?php

namespace Webkul\Income\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Income\Contracts\Income as IncomeContract;
use Webkul\Attribute\Traits\CustomAttribute;

class Income extends Model implements IncomeContract
{
    use CustomAttribute;
    protected $fillable = [
        'subject', 'description', 'type', 'name_of_payer', 'tax_amount', 'grand_total', 'date_transac'
    ];
}