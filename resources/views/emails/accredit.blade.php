<head>
    <title>Superuser Accredit</title>

    <style>
        {
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Roboto", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        }

        img {
            max-width: 100%;
        }

        .collapse {
            margin: 0;
            padding: 0;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            font-size: 18px;
            line-height: 1.6;
            color: #33373A;
        }


        a {
            color: #29B2E6;
        }

        .btn {
            text-decoration: none;
            color: #FFF;
            background-color: #c2d2ea;
            padding: 10px 16px;
            font-weight: bold;
            margin-right: 10px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
        }

        p.callout {
            padding: 15px;
            background-color: #DEDFE1;
            margin-bottom: 25px;
            color: #8C8D8F;
            text-align: center;
        }

        p.caption {
            color: #979797;
            font-size: 13px;
            margin-top: 10px;
        }

        p.footer {
            color: #979797;
            font-size: 13px;
            text-align: left;
        }

        hr.footer {
            border: 0;
            color: #D1D1D1;
            background-color: #D1D1D1;
            height: 3px;
            margin-bottom: 10px;
        }

        .button {
            background: #29B2E6;
            padding-top: 6px;
            padding-right: 40px;
            padding-bottom: 6px;
            padding-left: 40px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            font-family: Helvetica, Arial, sans-serif;
            display: inline-block;
            margin-right: 10px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Roboto", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, sans-serif;
            line-height: 1.5;
            margin-bottom: 25px;
            color: #30373D;
        }

        h1 small,
        h2 small,
        h3 small,
        h4 small,
        h5 small,
        h6 small {
            font-size: 60%;
            color: #6f6f6f;
            line-height: 1.1;
            text-transform: none;
        }

        h1 {
            font-weight: 500;
            font-size: 44px;
        }

        h2 {
            font-weight: 500;
            font-size: 36px;
            margin-top: -10px;
        }

        h3 {
            font-weight: 500;
            font-size: 27px;
        }

        h4 {
            font-weight: 500;
            font-size: 23px;
        }

        h5 {
            font-weight: 900;
            font-size: 17px;
        }

        h6 {
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
            color: #444;
        }

        .collapse {
            margin: 0 !important;
        }

        p,
        ul,
        ol {
            margin-bottom: 30px;
            font-weight: normal;
            color: #30373D;
            font-size: 18px;
            line-height: 1.6;
        }

        p.lead {
            font-size: 22px;
        }

        p.last {
            margin-bottom: 0px;
        }

        ul li {
            margin-left: 24px;
            list-style-position: inside;
            margin-bottom: 14px;
        }

        ol li {
            margin-left: 32px;
            list-style-position: outside;
            margin-bottom: 14px;
        }

        .small {
            font-size: 12px;
        }

        .grey {
            color: #224a85;
        }


        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            /* makes it centered */
            clear: both !important;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }

        .content table {
            width: 100%;
        }

        .clear {
            display: block;
            clear: both;
        }

        }

    </style>
</head>


<body>
    <div class="grey pt-2">
        <center>
            <img src="{{ env('APP_URL') . '/images/logo_mg.png' }}" alt="Marchesini Group" height=170>
        </center>
        <p>
        <div>
            Ciao <strong>{{ $accredit->customer_name }}</strong>
        </div>
        <div>
            Al seguente link <br>
            <a href="{{ route('accredit.download', $accredit->token) }}">
                {{ route('accredit.download', $accredit->token) }}
            </a><br>
            potrai scaricare il file contenente l'accredito da

            @if ($accredit->level == 7)
                super utente
            @endif
            @if ($accredit->level == 6)
                amministratore formati
            @endif

            della durata di {{ $accredit->durationString() }}.
            <p>

            @if ($accredit->level == '7' || $accredit->display_type == 'ed1')
                <div>
                    Queste sono le credenziali per l'accesso:<br>
                    Username: <strong> {{ $accredit->customer_id }}</strong><br>
                    PIN: <strong>{{ $accredit->pin }}</strong><br>
                    <p>
                </div>
            @endif

        </div>
        <div>
            Al seguente <a href="{{ route('accredit.tutorial', $accredit->display_type) }}">link</a> potrai guardare
            un tutorial su come copiare l'accredito su un pendrive.
            <p>
        </div>
        <div>
            Enjoy.<br>
        </div>
    </div>
</body>
