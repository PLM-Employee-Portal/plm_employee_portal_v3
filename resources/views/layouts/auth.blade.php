@extends('components.layouts.base')

@section('body')
@vite(['resources/css/app.css','resources/js/app.js'])
    <div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
