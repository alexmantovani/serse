<div>
    <form method="POST" action="{{ route('accredit.store') }}">
        @csrf

        <div class="form-group row">
            <label for="display_type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo di display') }}</label>

            <div class="col-md-6">
                <select id="display_type" class="form-control" name="display_type" wire:model.refer="display_type">>
                    <option value="ed1" selected>Dismac / ED1.0 / ED1.1</option>
                    <option value="ed1.2" selected>ED1.2</option>
                    <option value="ed2">ED2.xx</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
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
        </div>

        <div class="form-group row">
            <label for="customer_email" class="col-md-4 col-form-label text-md-right">{{ __('Email destinatario') }}</label>

            <div class="col-md-6">
                <input id="customer_email" type="email" class="form-control @error('customer_email') is-invalid @enderror"
                    name="customer_email" value="{{ old('customer_email') }}">

                @error('customer_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>


        <div class="form-group row">
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
        </div>

        <input type="hidden" id="language" name="language" value="it">

        <div class="form-group row">
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
        </div>


        <div class="form-group row">
            <div class=" col-md-6 offset-md-4">
                <button type="button" class="btn btn-link" wire:click="$toggle('showDiv')">
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
                <div class="form-group row">
                    <label for="customer_name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

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
                </div>
            @else
                @if ($accredit_type == '7')
                    <input type="hidden" id="customer_name" name="customer_name" value="Temporary Superuser">
                    @elseif ($accredit_type == '6')
                        <input type="hidden" id="customer_name" name="customer_name" value="Format Admin">
                    @else
                        <input type="hidden" id="customer_name" name="customer_name" value="Level {{ $accredit_type }}">
                    @endif
                @endif


                @if ($accredit_type != '6' || $display_type == 'ed1')
                    <div class="form-group row">
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
                    </div>
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
                    <div class="form-group row">
                        <label for="pin" class="col-md-4 col-form-label text-md-right">{{ __('Pin') }}</label>

                        <div class="col-md-6">
                            <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror"
                                name="pin" value="0000">

                            @error('pin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @else
                    <input type="hidden" id="pin" name="pin" value="0000">
                @endif


                <div class="form-group row">
                    <label for="duration"
                        class="col-md-4 col-form-label text-md-right">{{ __('Durata (giorni)') }}</label>

                    <div class="col-md-6">
                        <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror"
                            name="duration" value="{{ $accredit_type == '7' ? 2 : 1825 }}">

                        @error('duration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
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

            <div class="flex justify-between">

                    <a href="{{ route('accredit.index') }}">
                        <div class="btn btn-outline-primary mr-4"><i class="fa-solid fa-angle-left"></i> &nbsp;
                            Indietro
                        </div>
                    </a>

                    <x-primary-button class="">
                        <i class="fa-solid fa-check"></i> &nbsp;
                        {{ __('Invia accredito') }}
                    </x-primary-button>
            </div>
    </form>
</div>
