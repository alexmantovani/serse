<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accrediti') }}
            </h2>
            <div>
                <form method="GET" action="{{ route('accredit.create') }}">
                    <x-primary-button class="ml-3">
                        <i class="fas fa-plus"></i> &nbsp;
                        {{ __('Nuovo accredito') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-5 flex-1">


                <form method="GET" action="{{ route('accredit.index') }}">
                    <div class="flex my-4 rounded-md border border-gray-300">
                        <!-- Email Address -->
                        <div class="flex w-full">
                            <input
                                class="mr-3 border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
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

                <div class=" text-right text-sm text-gray-400">
                    Trovati {{ $accredits->total() }} risultati
                </div>

                <table class="table-auto w-full mb-6">
                    <tbody>
                        @foreach ($accredits as $accredit)
                            <tr class="border-t border-dotted">
                                <td class="w-full pr-4 py-3">
                                    <div class="flex text-stone-500 justify-between">
                                        <div class="flex">
                                            <div class="pr-2 pt-0.5"
                                                @if (isset($accredit->downloaded_at)) title="Scaricato il {{ Carbon\Carbon::parse($accredit->downloaded_at) }}" @endif>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 211.58 240"
                                                    width="12px" height="14px"
                                                    fill="{{ isset($accredit->downloaded_at) ? '#227dc7' : '#AAAAAA' }}"
                                                    stroke="none">
                                                    <rect class="cls-1" y="182.47" width="211.58" height="19.68" />
                                                    <polygon class="cls-2"
                                                        points="155.66 78.58 155.66 30.74 55.61 30.74 55.61 78.58 20.24 78.58 105.93 165.38 191.03 78.58 155.66 78.58" />
                                                    <rect class="cls-2" x="55.61" width="100.04" height="18.4" />
                                                </svg>
                                            </div>
                                            <div class=" text-stone-500 text-xs"
                                                title="Creato il {{ Carbon\Carbon::parse($accredit->created_at) }}">
                                                {{ Carbon\Carbon::parse($accredit->created_at)->diffForHumans() }}
                                            </div>
                                        </div>

                                        <div class=" text-xs">
                                            {{ $accredit->user->name }}
                                        </div>
                                    </div>

                                    <div class=" text-xl font-semibold text-stone-700 flex justify-between">
                                        <div>
                                            {{ $accredit->customer_company }}
                                        </div>
                                        <div
                                            class="{{ $accredit->level == 7 ? 'text-red-500' : 'text-green-500' }} text-base">
                                            <strong>
                                                @if ($accredit->level == 7)
                                                    Super Utente
                                                @elseif ($accredit->level == 6)
                                                    Amministratore Formati
                                                @else
                                                    Livello {{ $accredit->level }}
                                                @endif
                                                &centerdot;
                                                {{ strtoupper($accredit->display_type) }}
                                            </strong>
                                        </div>
                                    </div>

                                    {{-- <div class="d-flex"
                                        style="color: {{ $accredit->level == 7 ? '#AA0000' : '#00AA00' }}"> --}}
                                    <div class="flex text-xs">
                                        <div class=" items-center text-stone-400 flex">
                                            <i class="far fa-envelope"></i>
                                            <div class="pl-1">
                                                {{ $accredit->customer_email }}
                                            </div>
                                        </div>

                                        <div class="ml-auto text-stone-500">
                                            Macchine:
                                            <strong class="text-stone-700">
                                                @if ($accredit->machine == 'all')
                                                    Tutte
                                                @else
                                                    {{ str_replace(':', ' - ', $accredit->machine) }}
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-right w-min">
                                    <a href="{{ route('accredit.show', $accredit->token) }}">
                                        <x-outline-button class="">
                                            Dettagli
                                        </x-outline-button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="pt-6 mb-0 pb-0 mx-6">
                <?php echo $accredits->appends(['search' => $search])->links(); ?>
            </div>
        </div>
        <div class="flex-0 w-80 ml-6">
            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-1 mb-5">
                <div class="p-5">
                    <div class="text-lg font-semibold">
                        {{ __('Verifica accredito') }}
                    </div>

                    <form method="post" action="{{ route('accredit.upload') }}" enctype="multipart/form-data"
                        class="dropzone cursor-pointer border border-gray-500 rounded-md border-dashed bg-indigo-50 text-gray-500 p-4 my-3"
                        id="dropzone">
                        @csrf
                        <div class="dz-message text-center">Clicca o trascina qui il file accredito che vuoi verificare</div>
                    </form>
                    <script type="text/javascript">
                        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                        Dropzone.options.dropzone = {
                            paramName: "file",
                            maxFilesize: 30, // MB
                            // acceptedFiles: ".accr",
                            queuecomplete: function(file, response) {
                                console.log(file + ' ' + response);
                                window.location.href = '{{ route('accredit.report') }}';
                            }
                        };
                    </script>

                </div>
            </div>


            <div class=" bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-1 mb-5">
                <div class="p-5">
                    <div class="text-lg font-semibold">
                        Negli ultimi 30 giorni
                    </div>
                    <div class="py-3 text-gray-500">
                        La Top Ten degli utenti che hanno creato più accrediti
                    </div>

                    <div class="px-3">
                        @foreach ($topten->get() as $item)
                            <div class="flex justify-between py-1">
                                <div>
                                    {{ $loop->index + 1 }} &middot;
                                    <strong>
                                        {{ $item->user->name }}
                                    </strong>
                                </div>
                                <div class=" text-right">
                                    {{ $item->created }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
