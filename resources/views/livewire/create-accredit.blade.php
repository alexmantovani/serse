<div>
    <form method="POST" action="{{ route('accredit.store') }}">
        @csrf

        <div class="py-3">
            <x-input-label for="display_type" :value="__('Tipo di display')" />
            <select id="display_type" name="display_type" wire:model.refer="display_type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="ed1" selected>Dismac / ED1.0 / ED1.1</option>
                <option value="ed1.2">ED1.2</option>
                <option value="ed2">ED2.xx</option>
            </select>
        </div>

        <div class="py-3">
            <x-input-label for="level" :value="__('Tipo di accredito')" />
            <select id="level" name="level" wire:model.refer="accredit_type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="7" selected>Super utente</option>
                <option value="6">Amministratore formati</option>
                <option value="4">Livello 4</option>
                <option value="3">Livello 3</option>
                <option value="2">Livello 2</option>
                <option value="1">Livello 1</option>
            </select>
        </div>


        {{-- <div class="form-group row">
            <label for="display_type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo di display') }}</label>

            <div class="col-md-6">
                <select id="display_type" class="form-control" name="display_type" wire:model.refer="display_type">>
                    <option value="ed1" selected>Dismac / ED1.0 / ED1.1</option>
                    <option value="ed1.2" selected>ED1.2</option>
                    <option value="ed2">ED2.xx</option>
                </select>
            </div>
        </div> --}}

        {{-- <div class="form-group row">
            <label for="level" class="col-md-4 col-form-label text-md-right">{{ __('Tipo di accredito') }}</label>

            <div class="col-md-6">
                <select id="level" class="form-control" name="level" wire:model.refer="accredit_type">
                    <option value="7" selected>Super utente</option>
                    <option value="6">Amministratore formati</option>
                    <option value="4">Livello 4</option>
                    <option value="3">Livello 3</option>
                    <option value="2">Livello 2</option>
                    <option value="1">Livello 1</option>
                </select>
            </div>
        </div> --}}

        <div class="py-3">
            <x-input-label for="customer_email" :value="__('Email destinatario')" />
            <x-text-input id="customer_email" class="block mt-1 w-full" type="email" name="customer_email"
                :value="old('customer_email')" required autofocus />
            <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
        </div>

        {{-- <div class="form-group row">
            <label for="customer_email"
                class="col-md-4 col-form-label text-md-right">{{ __('Email destinatario') }}</label>

            <div class="col-md-6">
                <input id="customer_email" type="email"
                    class="form-control @error('customer_email') is-invalid @enderror" name="customer_email"
                    value="{{ old('customer_email') }}">

                @error('customer_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div> --}}

        <div class="py-3">
            <x-input-label for="customer_company" :value="__('Azienda')" />
            <x-text-input id="customer_company" class="block mt-1 w-full" type="text" name="customer_company"
                :value="old('customer_company')" required />
            <x-input-error :messages="$errors->get('customer_company')" class="mt-2" />
        </div>

        {{-- <div class="form-group row">
            <label for="customer_company" class="col-md-4 col-form-label text-md-right">{{ __('Azienda') }}</label>

            <div class="col-md-6">
                <input id="customer_company" type="text"
                    class="form-control @error('customer_company') is-invalid @enderror" name="customer_company"
                    value="{{ old('customer_company') }}">

                @error('customer_company')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div> --}}

        <input type="hidden" id="language" name="language" value="it">

        <div class="py-3">
            <x-input-label for="machine" :value="__('Matricola')" />
            <x-text-input id="machine" class="block mt-1 w-full" type="text" name="machine" :value="old('machine')" placeholder="all"
                />
            <x-input-error :messages="$errors->get('machine')" class="mt-2" />
            <small class=" text-gray-500">
                Per specificare una o più macchine inserisci le matricole separate dal carattere ":"
                (es.:"M3200040:N6200047")
            </small>
        </div>

        {{-- <div class="form-group row">
            <label for="machine" class="col-md-4 col-form-label text-md-right">{{ __('Matricola') }}</label>

            <div class="col-md-6">
                <input id="machine" type="text" class="form-control @error('machine') is-invalid @enderror"
                    name="machine" value="" placeholder="all">

                @error('machine')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 offset-md-4" style="color: rgb(170, 170, 170)">
                <small>
                    Per specificare una o più macchine inserisci le matricole separate dal carattere ":"
                    (es.:"M3200040:N6200047")
                </small>
            </div>
        </div> --}}


        <div class="form-group row">
            <div class=" py-5 text-center">
                <button type="button" class=" hover:underline hover:text-indigo-700 hover:font-semibold" wire:click="$toggle('showDiv')">
                    @if ($showDiv)
                        {{ __('Nascondi opzioni avanzate') }}
                    @else
                        {{ __('Mostra opzioni avanzate') }}
                    @endif
                </button>
            </div>
        </div>


        @if ($showDiv)
            @if ($accredit_type != '6' || $display_type == 'ed1')
                <div class="py-3">
                    <x-input-label for="username" :value="__('Nome utente')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                        value="Temporary Superuser" required />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                {{-- <div class="form-group row">
                    <label for="customer_name"
                        class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                    <div class="col-md-6">
                        <input id="customer_name" type="text"
                            class="form-control @error('customer_name') is-invalid @enderror" name="customer_name"
                            value="Temporary Superuser">

                        @error('customer_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}
            @else
                @if ($accredit_type == '7')
                    <input type="hidden" id="customer_name" name="customer_name" value="Temporary Superuser">
                @elseif ($accredit_type == '6')
                    <input type="hidden" id="customer_name" name="customer_name" value="Format Admin">
                {{-- @else
                    <input type="hidden" id="customer_name" name="customer_name" value="Level {{ $accredit_type }}"> --}}
                @endif
            @endif


            @if ($accredit_type != '6' || $display_type == 'ed1')
                <div class="py-3">
                    <x-input-label for="customer_id" :value="__('User id')" />
                    <x-text-input id="customer_id" class="block mt-1 w-full" type="text" name="customer_id"
                        value="superuser" required />
                    <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                </div>

                {{-- <div class="form-group row">
                    <label for="customer_id" class="col-md-4 col-form-label text-md-right">{{ __('User Id') }}</label>

                    <div class="col-md-6">
                        <input id="customer_id" type="text"
                            class="form-control @error('customer_id') is-invalid @enderror" name="customer_id"
                            value="superuser">

                        @error('customer_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}
            @else
                @if ($accredit_type == '7')
                    <input type="hidden" id="customer_id" name="customer_id" value="superuser">
                @elseif ($accredit_type == '6')
                    <input type="hidden" id="customer_id" name="customer_id" value="formadmin">
                @else
                    <input type="hidden" id="customer_id" name="customer_id" value="level{{ $accredit_type }}">
                @endif
                <input type="hidden" id="pin" name="pin" value="0000">
            @endif


            @if ($accredit_type != '6' || $display_type == 'ed1')
                <div class="py-3">
                    <x-input-label for="pin" :value="__('PIN')" />
                    <x-text-input id="pin" class="block mt-1 w-full" type="text" name="pin"
                        :value="$pin" required />
                    <x-input-error :messages="$errors->get('pin')" class="mt-2" />
                </div>
            @else
                <input type="hidden" id="pin" name="pin" value="0000">
            @endif

            <div class="py-3">
                <x-input-label for="duration" :value="__('Durata (giorni)')" />
                <x-text-input id="duration" class="block mt-1 w-full" type="text" name="duration"
                    :value="$accredit_type == '7' ? 2 : 1825" required />
                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
            </div>
        @else
            @if ($accredit_type == '7')
                <input type="hidden" id="customer_name" name="customer_name" value="Temporary Superuser">
                <input type="hidden" id="customer_id" name="customer_id" value="superuser">
            @elseif ($accredit_type == '6')
                <input type="hidden" id="customer_name" name="customer_name" value="Format Admin">
                <input type="hidden" id="customer_id" name="customer_id" value="formadmin">
            @else
                <input type="hidden" id="customer_name" name="customer_name" value="Level {{ $accredit_type }}">
                <input type="hidden" id="customer_id" name="customer_id" value="level{{ $accredit_type }}">
            @endif
            <input type="hidden" id="pin" name="pin" value="0000">
            <input type="hidden" id="duration" name="duration" value="{{ $accredit_type == '7' ? 2 : 1825 }}">
        @endif

        <div class="flex justify-between py-3">
            <x-outline-button class="">
                <a href="{{ route('accredit.index') }}">
                    <i class="fa-solid fa-angle-left"></i> &nbsp;
                    Indietro
                </a>
            </x-outline-button>

            <x-primary-button class="">
                <i class="fa-solid fa-check"></i> &nbsp;
                {{ __('Invia accredito') }}
            </x-primary-button>
        </div>
    </form>
</div>
