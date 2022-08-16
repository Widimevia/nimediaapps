@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.income.edit-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('admin.income.edit.header.before', ['income' => $income]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('income.edit', $income) }}

            <div class="page-title">
                <h1>{{ __('admin::app.income.edit-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('admin.income.edit.header.after', ['income' => $income]) !!}

        <form method="POST" action="{{ route('admin.income.update', $income->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('admin.income.edit.form_buttons.before', ['income' => $income]) !!}

                            <button type="submit" class="btn btn-md btn-primary">
                                {{ __('admin::app.income.save-btn-title') }}
                            </button>

                            <a href="{{ route('admin.income.index') }}">{{ __('admin::app.income.back') }}</a>

                            {!! view_render_event('admin.income.edit.form_buttons.after', ['income' => $income]) !!}
                        </div>
        
                        <div class="panel-body">
                            {!! view_render_event('admin.income.edit.form_controls.before', ['income' => $income]) !!}

                            @csrf()

                            <input name="_method" type="hidden" value="PUT">
                
                            @include('admin::common.custom-attributes.edit', [
                                'customAttributes' => app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'income',
                                ]),
                                'entity'           => $income,
                            ])

                            {!! view_render_event('admin.income.edit.form_controls.after', ['income' => $income]) !!}

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
@stop