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
                    @include('shared/input', [
                        'name' => 'tawkto_chat_url',
                        'label' => __('tawkto::messages.admin.settings.chat_url'),
                        'value' => setting('tawkto_chat_url'),
                        'placeholder' => 'https://tawk.to/chat/xxxxxxxxxxxx/xxxxxxxxx',
                    ])
                    <p class="text-sm text-gray-500 mt-1">{{ __('tawkto::messages.admin.settings.chat_url_help') }}</p>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">{{ __('global.save') }}</button>
        </form>
    </div>
@endsection
