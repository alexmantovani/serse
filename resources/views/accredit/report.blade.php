<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center">
                <div class="pr-3 text-lg cursor-pointer text-gray-800 dark:text-gray-200">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>

                </div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Verifica accredito') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-4 grid lg:grid-cols-2 gap-6 md:px-32 lg:px-64">

        @if (is_null($json))
            <div class="">
                <h5>
                    Il file selezionato non sembra essere un file di accredito valido.
                </h5>
            </div>
        @else
            <div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 text-center">
                    <label class="text-sm text-gray-500">{{ __('Username') }}</label>
                    <div class="pb-5">
                        <div class="text-gray-800 font-semibold text-lg">
                            {{ $json['username'] }}
                        </div>
                    </div>

                    <label class="text-sm text-gray-500">{{ __('User Id') }}</label>
                    <div class="">
                        <div class="text-gray-800 font-semibold text-lg">
                            {{ $json['userid'] }}
                        </div>
                    </div>

                    @if (isset($json['password']))
                        <label class="text-sm text-gray-500">{{ __('PIN') }}</label>
                        <div class="">
                            <div class="text-gray-800 font-semibold text-lg">
                                {{ $json['password'] }}
                            </div>
                        </div>
                    @endif

                </div>

                <div class="text-sm pt-2 px-2 text-gray-400 text-right"
                    title="{{ Carbon\Carbon::parse($json['from'])->format('d.m.Y ') }}">
                    Accredito generato {{ Carbon\Carbon::parse($json['from'])->diffForHumans() }}
                </div>

            </div>

            <div class="p-5 border-l">

                <label class="text-sm text-gray-500">{{ __('Livello') }}</label>
                <div class="pb-5">
                    <div class="text-gray-800 font-semibold text-lg">
                        @if ($json['level'] == 7 || $json['level'] == 100)
                            Super Utente
                        @endif
                        @if ($json['level'] == 6 || $json['level'] == 3)
                            Amministratore Formati
                        @endif
                    </div>
                </div>

                <label class="text-sm text-gray-500">{{ __('Pannello') }}</label>
                <div class="pb-5">
                    <div class="text-gray-800 font-semibold text-lg">
                        {{ strtoupper($json['hmi']) }}
                    </div>
                </div>


                <label class="text-sm text-gray-500">{{ __('Macchina') }}</label>
                <div class="pb-5">
                    <div class="text-gray-800 font-semibold text-lg">
                        {{ $json['machine'] }}
                    </div>
                </div>

                <label class="text-sm text-gray-500">{{ __('Formati') }}</label>
                <div class="pb-5">
                    <div class="text-gray-800 font-semibold text-lg">
                        {{ $json['format'] }}
                    </div>
                </div>

            </div>

        @endif

    </div>

    <div class="py-8 md:flex px-32 justify-center">
        <div class="px-3">
            <a onclick="window.history.back();">
                <x-outline-button class="">
                    <i class="fa-solid fa-angle-left"></i> &nbsp;
                    {{ __('Indietro') }}
                </x-outline-button>
            </a>
        </div>
    </div>

</x-app-layout>
