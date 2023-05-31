<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Archivio Traduzioni') }}
            </h2>
            {{-- <div>
                <form method="GET" action="{{ route('translation.create') }}">
                    <x-primary-button class="ml-3" title="Aggiungi traduzione mancante">
                        <i class="fas fa-plus"></i> &nbsp;
                        {{ __('Aggiungi') }}
                    </x-primary-button>
                </form>
            </div> --}}
        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 flex-1">

                <form method="GET" action="{{ route('translation.index') }}">
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

                    <div class=" text-right text-sm text-gray-400">
                        Trovati {{ $translations->total() }} risultati
                    </div>
                </div>

                <table class="table-auto w-full my-6">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">
                                    <a href="{{ route('translation.index', ['orderBy' => 'source']) }}">
                                        Testo
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap w-20">
                                <div class="font-semibold text-center">
                                    <a href="{{ route('translation.index', ['orderBy' => 'language']) }}">
                                        Lingua
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap w-20">
                                <div class="font-semibold text-center">
                                    <a href="{{ route('translation.index', ['orderBy' => 'serial_number']) }}">
                                        Matricola
                                    </a>
                                </div>
                            </th>

                            {{-- <th class="p-2 w-20 text-center items-center">
                                <div class="font-semibold">
                                    <a href="{{ route('translation.index', ['orderBy' => 'state']) }}">
                                        Stato
                                    </a>
                                </div>
                            </th> --}}
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($translations as $translation)
                            <tr class=" h-10">
                                <td>
                                    <div class="group flex justify-between items-center">
                                        <div class="p-2">

                                            <div class="text-left dark:text-gray-300">
                                                {{ $translation->source }}
                                            </div>
                                            <div class="text-gray-400 text-sm">
                                                {{ $translation->translation }}
                                            </div>
                                        </div>
                                        <div class="invisible group-hover:visible flex">

                                            <a href="{{ route('translation.edit', $translation) }}" class="px-1">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </a>

                                            <form method="POST"
                                                action="{{ route('translation.destroy', $translation) }}"
                                                class="invisible group-hover:visible px-1"
                                                onclick="return confirm('Vuoi davvero eliminare questo messaggio?');">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit">
                                                    <i class="fa-solid fa-trash-can text-lg text-red-600"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap dark:text-gray-300 text-center">
                                    <img src="{{ url('flags/' . $translation->flagCode . '.svg') }}" alt=""
                                        class="h-5 w-10 object-cover pl-2 text-center">
                                </td>
                                <td>
                                    <div class="text-center dark:text-gray-300">
                                        {{ $translation->serial_number }}
                                    </div>
                                </td>
                                {{-- <td class="p-2 w-20 text-center dark:text-gray-300 items-center uppercase text-xs">
                                    <div class="text-center">{{ $translation->status }}</div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <div class="pt-6 mb-0 pb-0 mx-6">
                <?php echo $translations->appends(['search' => $search])->links(); ?>
            </div>

        </div>
    </div>

</x-app-layout>
