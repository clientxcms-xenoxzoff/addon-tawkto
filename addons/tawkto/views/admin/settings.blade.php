@extends('admin.settings.sidebar')
@section('title', 'Tawk.to Configuration')
@section('setting')
    <div class="card w-full">
        <div class="flex justify-between">
            <h4 class="font-semibold uppercase text-gray-600 dark:text-gray-400">
                Tawk.to Configuration
            </h4>
            <form method="POST" action="{{ route('tawkto.settings') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        @include('shared/input', [
                            'name' => 'tawkto_chat_url',
                            'label' => 'Direct Chat Link',
                            'value' => setting('tawkto_chat_url'),
                            'placeholder' => 'https://tawk.to/chat/xxxxxxxxxxxx/xxxxxxxxx',
                        ])
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('global.save') }}</button>
            </form>
        </div>
    </div>
@endsection
