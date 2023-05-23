<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            @if (isset($serialNumber))
                <div class="flex items-baseline text-gray-500">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $serialNumber->name }}
                    </h2> &nbsp;
                    {{ __('Traduzioni mancanti') }}
                </div>
            @else
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Traduzioni mancanti') }}
                </h2>
            @endif
            {{-- <div class="flex">
                <a href="{{ route('missing.verify') }}">
                    <x-secondary-button class="ml-3" title="Invia manulamente le traduzioni a intradoc">
                        <i class="fas fa-check"></i> &nbsp;
                        {{ __('Verifica') }}
                    </x-secondary-button>
                </a>

                <form method="GET" action="{{ route('missing.load') }}">
                    <x-primary-button class="ml-3" title="Importa traduzioni completate">
                        <i class="fas fa-download"></i> &nbsp;
                        {{ __('Importa') }}
                    </x-primary-button>
                </form>
            </div> --}}
        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 flex-1">

                <form method="GET" action="{{ route('missing.index') }}">
                    <div class="flex mt-4 mb-1 rounded-md border border-gray-300">
                        <div class="flex w-full">
                            <input
                                class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                type="text" aria-label="Search" placeholder="Cerca..." value="{{ $search ?? '' }}"
                                name="search" autofocus>
                        </div>

                        <div class=" flex-none items-center p-1">
                            <x-primary-button class="ml-3 h-12 w-12">
                                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                            </x-primary-button>
                        </div>

                    </div>
                </form>

                <div class="flex justify-between">
                    <div class="flex pt-5 text-xl">
                        <a href="{{ route('missing.index', ['search' => $search, 'filter' => 'all', 'orderBy' => $orderBy]) }}"
                            class="{{ $filter == 'all' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            Tutti
                        </a>
                        &nbsp; &middot; &nbsp;
                        <a href="{{ route('missing.index', ['search' => $search, 'filter' => 'pending', 'orderBy' => $orderBy]) }}"
                            class="{{ $filter == 'pending' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            Nuovi
                        </a>
                        &nbsp; &middot; &nbsp;
                        <a href="{{ route('missing.index', ['search' => $search, 'filter' => 'waiting', 'orderBy' => $orderBy]) }}"
                            class="{{ $filter == 'waiting' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            In traduzione
                        </a>
                        &nbsp; &middot; &nbsp;
                        <a href="{{ route('missing.index', ['search' => $search, 'filter' => 'translated', 'orderBy' => $orderBy]) }}"
                            class="{{ $filter == 'translated' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            Tradotti
                        </a>
                    </div>
                    <div class=" text-right text-sm text-gray-400">
                        Trovati {{ $missingTranslations->total() }} risultati
                    </div>
                </div>

                <table class="table-auto w-full my-6">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('missing.index', ['search' => $search, 'filter' => $filter, 'orderBy' => 'source']) }}">
                                        Testo
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap w-20">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('missing.index', ['search' => $search, 'filter' => $filter, 'orderBy' => 'language']) }}">
                                        Lingua
                                    </a>
                                </div>
                            </th>
                            @if (!$serialNumber)
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">
                                        <a
                                            href="{{ route('missing.index', ['search' => $search, 'filter' => $filter, 'orderBy' => 'serial_number']) }}">
                                            Matricola
                                        </a>
                                    </div>
                                </th>
                            @endif
                            <th class="p-2 w-20 text-center items-center">
                                <div class="font-semibold">
                                    <a
                                        href="{{ route('missing.index', ['search' => $search, 'filter' => $filter, 'orderBy' => 'state']) }}">
                                        Stato
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($missingTranslations as $missing)
                            <tr class=" h-10">
                                <td>
                                    <a href="{{ route('missing.show', $missing) }}">
                                        <div
                                            class="p-2 text-left text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:font-bold">
                                            {{ $missing->source }}
                                        </div>
                                    </a>
                                </td>
                                <td class="p-2 whitespace-nowrap dark:text-gray-300 uppercase">
                                    <img src="{{ url('flags/' . $missing->flagCode . '.svg') }}" alt=""
                                        class="h-5 w-10 object-cover pl-2 text-center">

                                </td>
                                @if (!isset($serialNumber))
                                    <td>
                                        <a href="{{ route('dashboard', ['search' => $missing->serial_number]) }}">
                                            <div class="text-center dark:text-gray-300">
                                                {{ $missing->serial_number }}
                                            </div>
                                        </a>
                                    </td>
                                @endif
                                <td class="p-2 w-20 text-center dark:text-gray-300 items-center uppercase text-xs">
                                    <div class="text-center"
                                        @if ($missing->status == 'waiting') title="Inviato {{ Carbon\Carbon::parse($missing->sent_at)->format('d.m.Y ') }}" @endif
                                        @if ($missing->status == 'translated') title="Ricevuto {{ Carbon\Carbon::parse($missing->received_at)->format('d.m.Y ') }}" @endif>
                                        {{ $missing->status }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <div class="pt-6 mb-0 pb-0 mx-6">
                <?php echo $missingTranslations->appends(['search' => $search, 'filter' => $filter, 'orderBy' => $orderBy])->links(); ?>
            </div>
        </div>

    </div>
</x-app-layout>
