<?php

namespace Webkul\Income\Repositories;

use Illuminate\Container\Container;
use Webkul\Core\Eloquent\Repository;
use Webkul\Attribute\Repositories\AttributeValueRepository;
use Webkul\Income\Contracts\Income;

class IncomeRepository extends Repository
{
    /**
     * AttributeValueRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeValueRepository
     */
    protected $attributeValueRepository;

    /**
     * Create a new repository instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeValueRepository  $attributeValueRepository
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        AttributeValueRepository $attributeValueRepository,
        Container $container
    )
    {
        $this->attributeValueRepository = $attributeValueRepository;

        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Income\Contracts\Income';
    }

    /**
     * @param array $data
     * @return \Webkul\Income\Contracts\Income
     */
    public function create(array $data)
    {
        $Income = parent::create($data);

        $this->attributeValueRepository->save($data, $Income->id);

        return $Income;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \Webkul\Income\Contracts\Income
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $Income = parent::update($data, $id);

        $this->attributeValueRepository->save($data, $id);

        return $Income;
    }

    /**
     * Retreives customers count based on date
     *
     * @return number
     */
    public function getIncomeCount($startDate, $endDate)
    {
        return $this
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->count();
    }
}