<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Modifica traduzione') }}
            </h2>


        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 flex-1">
                <div class="flex justify-between">
                    <div class="pb-3">
                        <x-input-label for="matricola" :value="__('Matricola')" />
                        <h2 id="matricola" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $translation->serial_number }}
                        </h2>
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Stato')" />
                        <h2 id="status"
                            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight uppercase">
                            {{ $translation->status }}
                        </h2>

                    </div>
                </div>

                @if (strlen($translation->context))
                    <div>
                        <x-input-label for="context" :value="__('Contesto')" />
                        <x-text-input id="context" class="block mt-1 w-full" type="text" name="context"
                            disabled="true" :value="$translation->context" />
                        <x-input-error :messages="$errors->get('context')" class="mt-2" />

                    </div>
                @endif

                <form method="post" action="{{ route('translation.update', $translation) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <div class="flex items-end">
                            <div class="flex-none pr-3 pb-5">
                                <img src="{{ url('flags/it.svg') }}" alt=""
                                    class="h-7 w-12 object-cover pl-2 text-center">
                            </div>

                            <div class="py-3 flex-1">
                                <x-input-label for="source" :value="__('Testo sorgente')" />
                                <x-text-input id="source" class="block mt-1 w-full" type="text" name="source"
                                    disabled="true" :value="$translation->source" required />
                                <x-input-error :messages="$errors->get('source')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-end">
                            <div class="flex-none pr-3 pb-5">
                                <img src="{{ url('flags/' . $translation->flagCode . '.svg') }}" alt=""
                                    class="h-7 w-12 object-cover pl-2 text-center">
                            </div>

                            <div class="py-3 flex-1">
                                <x-input-label for="translation" :value="__('Testo tradotto')" />
                                <x-text-input id="translation" class="block mt-1 w-full" type="text"
                                    name="translation" :value="$translation->translation" required autofocus />
                                <x-input-error :messages="$errors->get('translation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-6 justify-between">
                            <a onclick="window.history.back();">
                                <x-outline-button class="">
                                    <i class="fa-solid fa-angle-left"></i> &nbsp;
                                    {{ __('Indietro') }}
                                </x-outline-button>
                            </a>
                            <x-primary-button>{{ __('Salva') }}</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
