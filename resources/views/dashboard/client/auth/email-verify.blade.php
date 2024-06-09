@extends('layouts.simple')
@section('content')
    <div class="mx-auto px-6 py-5 p-2 lg:py-20 max-w-6xl h-screen ">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2 bg-cover bg-center bg-no-repeat hidden sm:block bg-color "
                @if (isset($data['page_content']['thumbnail'])) style="background-image: url('{{ asset('/uploads/'. $data['page_content']['thumbnail']) }}');" @endif >
                <div class="flex flex-col items-center justify-center h-full">
                    <div class="mt-auto text-center mb-20">
                        @if (isset($data['page_content']['title']))
                        <h3 class="text-xl font-semibold text-white font-pop">{{ $data['page_content']['title'] }}
                        </h3>
                        @endif
                        @if (isset($data['page_content']['subtitle']))
                        <p class=" text-white text-sm font-pop mt-4">{{ $data['page_content']['subtitle'] }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 bg-white lg:p-4 register-column p-4">
                <livewire:client.forms.verify-form />
            </div>
        </div>
    </div>
@stop
