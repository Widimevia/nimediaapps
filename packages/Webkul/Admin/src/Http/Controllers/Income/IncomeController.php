<?php

namespace Webkul\Admin\Http\Controllers\Income;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\Attribute\Http\Requests\AttributeForm;
use Webkul\Income\Repositories\IncomeRepository;
use Illuminate\Support\Facades\Event;


class IncomeController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $incomeRepository;
    // protected $request;

    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
        request()->request->add(['entity_type' => 'income']);
    }
    
    public function index()
    {
        if (request()->ajax()) {
            return app(\Webkul\Admin\DataGrids\Income\IncomeDataGrid::class)->toJson();
        }

        return view('admin::income.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::income.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
 
        Event::dispatch('income.create.before');

        $income = $this->incomeRepository->create(request()->all());

        Event::dispatch('income.create.after', $income);

        session()->flash('success', trans('admin::app.income.create-success'));

        return redirect()->route('admin.income.index');

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $income = $this->incomeRepository->findOrFail($id);

        return view('admin::income.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        Event::dispatch('income.update.before', $id);

        $income = $this->incomeRepository->update(request()->all(), $id);

        Event::dispatch('income.update.after', $income);

        session()->flash('success', trans('admin::app.income.update-success'));

        return redirect()->route('admin.income.index');
    }
    public function search()
    {
        $results = $this->incomeRepository->findWhere([
            ['name', 'like', '%' . urldecode(request()->input('query')) . '%']
        ]);

        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->incomeRepository->findOrFail($id);

        try {
            Event::dispatch('settings.income.delete.before', $id);

            $this->incomeRepository->delete($id);

            Event::dispatch('settings.income.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.income.title')]),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.income.title')]),
            ], 400);
        }
    }
    public function massDestroy()
    {
        foreach (request('rows') as $incomeId) {
            Event::dispatch('income.delete.before', $incomeId);

            $this->incomeRepository->delete($incomeId);

            Event::dispatch('income.delete.after', $incomeId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.income.title')]),
        ]);
    }
}
