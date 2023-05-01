@extends('layouts.app_accredit')

@section('head')
    <script type="text/javascript">
        function startDownload() {
            window.location = "{{ route('accredit.get', $accredit->token) }}";
        }
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <div class="row">
                    <h1>
                        Accredito scaricato con successo
                    </h1>
                </div>
                <br>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{ __('User Id') }}</label>
                    <div class="col-md-6 col-form-label text-md-left">
                        <strong>
                            {{ $accredit->customer_id }}
                        </strong>
                    </div>
                    <label class="col-md-4 col-form-label text-md-right">{{ __('PIN') }}</label>
                    <div class="col-md-6 col-form-label text-md-left">
                        <strong>
                            {{ $accredit->pin }}
                        </strong>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
                    <div class="col-md-6 col-form-label text-md-left">
                        <strong>
                            @if ($accredit->level == 7)
                                Super Utente
                            @endif
                            @if ($accredit->level == 6)
                                Amministratore Formati
                            @endif
                        </strong>
                    </div>
                    <label class="col-md-4 col-form-label text-md-right">{{ __('Durata') }}</label>
                    <div class="col-md-6 col-form-label text-md-left">
                        <strong>
                            {{ $accredit->duration }} giorni
                        </strong>
                    </div>
                </div>

                <br>
                <div class="row">
                    L'accredito appena scaricato andrà copiato su un pendrive.
                </div>
                <br>

                <div class="row">
                    In caso di dubbi potrai trovare un breve tutorial al seguente&nbsp;
                    <a href="">link</a>
                </div>
                <br>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        startDownload();
    </script>
@endsection
