@extends('admin.settings.sidebar')
@section('title', __('tawkto::messages.admin.settings.title'))
@section('setting')
    <div class="card">
        <div class="flex justify-between">
            <h4 class="font-semibold uppercase text-gray-600 dark:text-gray-400">
                {{ __('tawkto::messages.admin.settings.title') }}
            </h4>
        </div>
        <form method="POST" action="{{ route('tawkto.settings') }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    @include('shared/textarea', [
                        'name' => 'tawkto_widget_code',
                        'label' => __('tawkto::messages.admin.settings.widget_code'),
                        'value' => setting('tawkto_widget_code'),
                        'rows' => 6,
                    ])
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('global.save') }}</button>
        </form>
    </div>
@endsection
