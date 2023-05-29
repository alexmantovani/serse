<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center">
                <div class="pr-3 text-lg cursor-pointer text-gray-800 dark:text-gray-200">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dettaglio accredito') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="grid md:grid-cols-2 w-full gap-6">
            <div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 ">
                    <div class="py-6">
                        <div class="flex justify-between items-center">
                            <div class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Informazioni principali
                            </div>

                            <div>
                                <x-outline-button id="copyBtn"
                                    data-text="Username: {{ $accredit->customer_id }} PIN: {{ $accredit->pin }}"
                                    title="Copia informazioni accredito" class="button">
                                    <i class="fa-regular fa-clipboard text-base"></i>
                                </x-outline-button>
                            </div>
                        </div>
                        <br>
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-400 py-3">{{ __('Nome utente') }}</div>
                            <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->customer_name }}</div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class=" text-sm text-gray-400 py-3">{{ __('Id utente') }}</div>
                            <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->customer_id }}</div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class=" text-sm text-gray-400 py-3">{{ __('PIN') }}</div>
                            <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->pin }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" border-l">
                <div class="text-2xl font-semibold text-gray-700 dark:text-gray-200 text-center pt-4">Altre informazioni
                </div>
                <br>

                <div class="grid grid-cols-2 gap-6 items-baseline">

                    <div class=" text-sm text-gray-400 text-right">{{ __('Tipo') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">
                        @switch($accredit->level)
                            @case(7)
                                {{ __('Super Utente') }}
                            @break

                            @case(6)
                                {{ __('Amministratore Formati') }}
                            @break

                            @default
                                {{ __('Livello') }} {{ $accredit->level }}
                        @endswitch
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Pannello') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300 uppercase">{{ $accredit->display_type }}
                    </div>
                </div>

                <br>

                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Macchina') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300 uppercase">{{ $accredit->machine }}</div>
                </div>

                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Formati') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->format }}</div>
                </div>

                <br>

                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Durata') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->durationString() }}</div>
                </div>

                <br>

                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Azienda') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->customer_company }}</div>
                </div>
                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Email') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->customer_email }}</div>
                </div>

                <br>

                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Generato da') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->user->name }}</div>
                </div>
                <div class="grid grid-cols-2 gap-6 items-baseline">
                    <div class=" text-sm text-gray-400 text-right">{{ __('Data creazione') }}</div>
                    <div class=" font-semibold text-md dark:text-gray-300">{{ $accredit->created_at->diffForHumans() }}
                    </div>
                </div>
                @if ($accredit->downloaded_at)
                    <div class="grid grid-cols-2 gap-6 items-baseline">
                        <div class=" text-sm text-gray-400 text-right">{{ __('Data download') }}</div>
                        <div class=" font-semibold text-md dark:text-gray-300">
                            {{ $accredit->downloaded_at->diffForHumans() }}
                        </div>
                    </div>
                @endif

            </div>
        </div>

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


        @if (Auth::user()->id == $accredit->user_id)
            <form action="{{ route('accredit.destroy', $accredit) }}" method="POST" class="px-3">
                @method('DELETE')
                @csrf
                <x-outline-button
                    class=" text-red-700 dark:text-red-600 border-red-200 hover:border-red-700 dark:hover:border-red-700">
                    <i class="fa-solid fa-trash-can"></i> &nbsp;
                    {{ __('Cancella accredito') }}
                </x-outline-button>
            </form>
        @endif

        <div class="px-3">
            <a href="{{ route('accredit.resend', $accredit->token) }}">
                <x-primary-button class="">
                    <i class="fa-regular fa-envelope"></i> &nbsp;
                    {{ __('Ri-invia mail') }}
                </x-primary-button>
            </a>
        </div>

        <div class="px-3">
            <a href="{{ route('accredit.get', $accredit->token) }}">
                <x-primary-button class="">
                    <i class="fa-regular fa-download"></i> &nbsp;
                    {{ __('Scarica accredito') }}
                </x-primary-button>
            </a>
        </div>
    </div>


    <script>
        const copyBtn = document.querySelector('#copyBtn');
        copyBtn.addEventListener('click', e => {
            const input = document.createElement('input');
            input.value = copyBtn.dataset.text;
            document.body.appendChild(input);
            input.select();
            if (document.execCommand('copy')) {
                alert('Text Copied');
                document.body.removeChild(input);
            }
        });
    </script>


</x-app-layout>
