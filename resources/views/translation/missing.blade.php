<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            @if (isset($serial))
                <div class="flex items-baseline text-gray-500">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $serial }}
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

                <form method="GET" action="{{ route('translation.missing', $serial) }}">
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

                <div class="flex justify-end">

                    <div class=" text-right text-sm text-gray-400">
                        Trovati {{ $translations->total() }} risultati
                    </div>
                </div>

                <table class="table-auto w-full my-6">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('translation.missing', ['search' => $search,  'orderBy' => 'context', 'serial' => $serial]) }}">
                                        Contesto
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('translation.missing', ['search' => $search,  'orderBy' => 'source', 'serial' => $serial]) }}">
                                        Testo
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap w-20">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('translation.missing', ['search' => $search,  'orderBy' => 'language', 'serial' => $serial]) }}">
                                        Lingua
                                    </a>
                                </div>
                            </th>
                            @if (!$serial)
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">
                                        <a
                                            href="{{ route('translation.missing', ['search' => $search,  'orderBy' => 'serial_number', 'serial' => $serial]) }}">
                                            Matricola
                                        </a>
                                    </div>
                                </th>
                            @endif
                            <th class="p-2 w-20 text-center items-center">
                                <div class="font-semibold">
                                    <a
                                        href="{{ route('translation.missing', ['search' => $search,  'orderBy' => 'state', 'serial' => $serial]) }}">
                                        Stato
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($translations as $translation)
                            <tr class=" h-10">
                                <td class="">
                                    <div class="p-2">
                                        {{ $translation->context }}
                                    </div>
                                </td>
                                <td>
                                    <div class="group flex justify-between items-center">
                                        <div class="p-2">
                                            <div
                                                class="
                                            @if ($translation->status == 'deleted') line-through text-gray-400 @endif
                                            ">
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

                                            <form method="POST" action="{{ route('translation.destroy', $translation) }}"
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

                                    {{-- <div class="flex justify-between">
                                        <a href="{{ route('missing.show', $translation) }}">
                                            <div
                                                class="p-2 text-left text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:font-bold">
                                                {{ $translation->source }}
                                            </div>
                                        </a>

                                        <div>
                                            aaa
                                        </div>
                                    </div> --}}
                                </td>
                                <td class="p-2 whitespace-nowrap dark:text-gray-300 ">
                                    <img src="{{ url('flags/' . $translation->flagCode . '.svg') }}" alt=""
                                        class="h-5 w-10 object-cover pl-2 text-center">

                                </td>
                                {{-- @if (!isset($serialNumber))
                                    <td>
                                        <a href="{{ route('missing.index', ['matricola' => $translation->serial_number]) }}">
                                            <div class="text-center dark:text-gray-300">
                                                {{ $translation->serial_number }}
                                            </div>
                                        </a>
                                    </td>
                                @endif --}}
                                <td class="p-2 w-20 text-center dark:text-gray-300 items-center uppercase text-xs">
                                    <div class="text-center"
                                        @if ($translation->status == 'waiting') title="Inviato {{ Carbon\Carbon::parse($translation->sent_at)->format('d.m.Y ') }}" @endif
                                        @if ($translation->status == 'translated') title="Ricevuto {{ Carbon\Carbon::parse($translation->received_at)->format('d.m.Y ') }}" @endif>
                                        {{ $translation->status }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <div class="pt-6 mb-0 pb-0 mx-6">
                <?php echo $translations->appends(['search' => $search,  'orderBy' => $orderBy])->links(); ?>
            </div>
        </div>

    </div>
</x-app-layout>
