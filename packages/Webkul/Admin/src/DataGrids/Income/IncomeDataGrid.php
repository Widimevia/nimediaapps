<?php

namespace Webkul\Admin\Datagrids\Income;

use Webkul\UI\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;

class IncomeDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('incomes')->addSelect('*');
        $this->addFilter('id', 'id');
        $this->addFilter('price', 'price');
        $this->addFilter('subject', 'subject');
        $this->addFilter('grand_total', 'grand_total');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'    => 'id',
            'label'    => trans('admin::app.datagrid.id'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'    => 'subject',
            'label'    => trans('admin::app.datagrid.subject'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        
        $this->addColumn([
            'index'    => 'grand_total',
            'label'    => trans('admin::app.datagrid.grand_total'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return '<b style="color:limegreen">+ '. core()->formatBasePrice($row->grand_total, 2).'</b>';
            },
        ]);
        $this->addColumn([
            'index'    => 'date_transac',
            'label'    => trans('admin::app.datagrid.date_transac'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return core()->formatDate($row->date_transac);
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('ui::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'admin.income.edit',
            'icon'   => 'pencil-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'admin.income.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'user']),
            'icon'         => 'trash-icon',
        ]);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('ui::app.datagrid.delete'),
            'action' => route('admin.income.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}