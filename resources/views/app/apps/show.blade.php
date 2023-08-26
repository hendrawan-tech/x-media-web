@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('apps.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.apps.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.apps.inputs.title')</h5>
                    <span>{{ $app->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.apps.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $app->image ? \Storage::url($app->image) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.apps.inputs.description')</h5>
                    <span>{{ $app->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.apps.inputs.type')</h5>
                    <span>{{ $app->type ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('apps.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\App::class)
                <a href="{{ route('apps.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
