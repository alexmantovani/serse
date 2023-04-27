<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accredit') }}
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                </div>

                <table class="table">
                    <tbody>
                        @foreach ($accredits as $accredit)
                            <tr>
                                <td>
                                    <div class="pb-2 d-flex" style="text-align: left; color: #AAAAAA;">
                                        <div class="d-flex">
                                            <div class="pr-2"
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
                                            <div class=""
                                                title="Creato il {{ Carbon\Carbon::parse($accredit->created_at) }}">
                                                {{ Carbon\Carbon::parse($accredit->created_at)->diffForHumans() }}
                                            </div>
                                            &nbsp;&nbsp;&centerdot;&nbsp;&nbsp;
                                            <div class="">
                                                {{ $accredit->user->name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="" style="text-align: left; color: #000;">
                                        <div class="" style="">
                                            <h5>
                                                <strong>
                                                    {{ $accredit->customer_company }} - {{ $accredit->customer_email }}
                                                </strong>
                                            </h5>
                                        </div>
                                    </div>

                                    {{-- <div class="d-flex"
                                        style="color: {{ $accredit->level == 7 ? '#AA0000' : '#00AA00' }}"> --}}
                                    <div class="d-flex {{ $accredit->level == 7 ? 'text-red' : 'text-green' }}">
                                        <div>
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

                                        <div class="ml-auto" style="color: #555555">
                                            Macchine:
                                            <strong>
                                                @if ($accredit->machine == 'all')
                                                    Tutte
                                                @else
                                                    {{ str_replace(':', ' - ', $accredit->machine) }}
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                </td>

                                <td style="width: 90px;">
                                    <a href="{{ route('accredit.show', $accredit->token) }}"
                                        class="btn btn-outline-primary mt-4">Dettagli</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</x-app-layout>
