@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('invoices.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.invoices.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.external_id')</h5>
                    <span>{{ $invoice->external_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.invoice_url')</h5>
                    <span>{{ $invoice->invoice_url ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.price')</h5>
                    <span>{{ $invoice->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.status')</h5>
                    <span>{{ $invoice->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.invoices.inputs.user_id')</h5>
                    <span>{{ optional($invoice->user)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('invoices.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Invoice::class)
                <a href="{{ route('invoices.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
