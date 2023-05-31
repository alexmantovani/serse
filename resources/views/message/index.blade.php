<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Aggiornamenti sulle macchine') }}
            </h2>
            {{--
            <div class="flex">
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

                {{-- <form method="GET" action="{{ route('missing.index') }}">
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
                </form> --}}

                <table class="table-auto w-full my-6">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('message.index', ['orderBy' => 'source']) }}">
                                        Matricola
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap w-20">
                                <div class="font-semibold text-left">
                                    <a
                                        href="{{ route('message.index', ['orderBy' => 'language']) }}">
                                        File
                                    </a>
                                </div>
                            </th>
                            <th class="p-2 w-18 text-center items-center">
                                <div class="font-semibold">
                                    <a
                                        href="{{ route('message.index', ['orderBy' => 'state']) }}">
                                        Data
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($messages as $message)
                            <tr class=" h-10">
                                <td>
                                    <div class="group flex justify-between">
                                        <p>{{ $message->serial_number }}</p>

                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap dark:text-gray-300 uppercase">
                                    <p>{{ $message->file }}</p>
                                </td>

                                <td class="p-2 w-18 text-center dark:text-gray-300 items-center uppercase text-xs">
                                    {{ $message->updated_at->translatedFormat('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <div class="pt-6 mb-0 pb-0 mx-6">
                <?php echo $messages->appends(['orderBy' => $orderBy])->links(); ?>
            </div>
        </div>

    </div>
</x-app-layout>
