<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Database Traduzioni') }}
            </h2>
            <div>
                <form method="GET" action="{{ route('translation.create') }}">
                    <x-primary-button class="ml-3" title="Aggiungi traduzione mancante">
                        <i class="fas fa-plus"></i> &nbsp;
                        {{ __('Aggiungi') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </x-slot>

    {{-- <div class="py-4 flex px-32">
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 flex-1">


                <form method="GET" action="{{ route('missing.index' ) }}">
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
                    <div class="flex uppercase pt-5 text-xl">
                        <a href="{{ route('missing.index', ['filter' => 'all', 'orderBy' => $orderBy]) }}" class="{{ $filter == 'all' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            tutti
                        </a>
                         &nbsp; &middot; &nbsp;
                         <a href="{{ route('missing.index', ['filter' => 'pending', 'orderBy' => $orderBy]) }}" class="{{ $filter == 'pending' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            nuovi
                        </a>
                         &nbsp; &middot; &nbsp;
                         <a href="{{ route('missing.index', ['filter' => 'waiting', 'orderBy' => $orderBy]) }}" class="{{ $filter == 'waiting' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            in attesa
                        </a>
                         &nbsp; &middot; &nbsp;
                         <a href="{{ route('missing.index', ['filter' => 'translated', 'orderBy' => $orderBy]) }}" class="{{ $filter == 'translated' ? 'border-b-2 border-indigo-600 text-indigo-600' : '' }}">
                            tradotti
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
                                        <a href="{{ route('missing.index', ['orderBy' => 'source']) }}">
                                            Testo
                                        </a>
                                    </div>
                                </th>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">
                                        <a href="{{ route('missing.index', ['orderBy' => 'language']) }}">
                                            Lingua
                                        </a>
                                    </div>
                                </th>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">
                                        <a href="{{ route('missing.index', ['orderBy' => 'serial_number']) }}">
                                            Matricola
                                        </a>
                                    </div>
                                </th>

                                <th class="p-2 w-20 text-center items-center">
                                    <div class="font-semibold">
                                        <a href="{{ route('missing.index', ['orderBy' => 'state']) }}">
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
                                        <div class="p-2 text-left dark:text-gray-300">
                                            {{ $missing->source }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap dark:text-gray-300 uppercase">
                                        <div class="text-center">{{ $missing->language }}</div>
                                    </td>
                                    <td>
                                        <div class="text-center dark:text-gray-300">
                                            {{ $missing->serial_number }}
                                        </div>
                                    </td>
                                    <td class="p-2 w-20 text-center dark:text-gray-300 items-center uppercase text-xs">
                                        <div class="text-center">{{ $missing->status }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


            </div>

            <div class="pt-6 mb-0 pb-0 mx-6">
                <?php echo $missingTranslations->appends(['search' => $search])->links(); ?>
            </div>
        </div>
    </div> --}}

</x-app-layout>
