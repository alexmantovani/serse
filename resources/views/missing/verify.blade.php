<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center">
                <div class="pr-3 text-lg cursor-pointer text-gray-800 dark:text-gray-200">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Verifica traduzioni prima della spedizione') }}
                </h2>
            </div>

            @if ($missings->count())
                <div>
                    <form method="GET" action="{{ route('missing.send') }}">
                        <x-primary-button class="ml-3" title="Invia traduzioni mancanti">
                            <i class="fas fa-plus"></i> &nbsp;
                            {{ __('Invia a intradoc') }}
                        </x-primary-button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="flex-1">
            @if ($missings->count())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 flex-1">
                    <table class="table-auto w-full my-6">
                        @foreach ($missings as $key => $lingua)
                            <thead class="text-xs font-semibold uppercase text-gray-600 bg-gray-50 dark:bg-gray-700">
                                <tr class="">
                                    <th colspan="4" class="px-2 whitespace-nowrap text-left font-semibold text-2xl">
                                        <div class="flex items-center">
                                            {{-- https://flagcdn.com/fr.svg --}}
                                            <img src="{{ url('flags/' . $key . '.svg') }}" alt=""
                                                class="h-5 pr-2">
                                            {{ $key }}
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 pb-6">
                                @foreach ($lingua as $missing)
                                    <tr class=" h-10">
                                        <td class="w-20">
                                            <div class="text-left dark:text-gray-300">
                                                {{ $missing->serial_number }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="p-2 text-left dark:text-gray-300">
                                                {{ $missing->source }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="h-full">
                    <div class="pt-30 text-4xl text-center">
                        <br>
                        <br>
                        <br>
                        <div class=" text-gray-400">
                            Non ci sono testi da mandare a tradurre
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
