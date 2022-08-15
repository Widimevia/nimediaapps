<?php

namespace Webkul\Income\Repositories;

use Webkul\Core\Eloquent\Repository;

class IncomeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Income\Contracts\Income';
    }
}