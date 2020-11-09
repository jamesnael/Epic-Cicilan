<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PAYMENT RECEIPT</title>
        
        <style type="text/css">
            @page { 
                margin: 0 !important; 
                padding: 0 !important;
            }
            html, body, p { 
                margin: 0 !important; 
                padding: 0 !important;
            }
            body {
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                font-size: 0.875rem;
                line-height: 1.5;
            }
            .wrapper {
                margin: 30px 10px 0 10px;
                /*height: 800px;*/
            }
            .content {
                margin: 0 !important;
                min-height: 250px;
                border: 1px double #000000;
            }
            .cut-line{
                clear: both;
                margin: 25px 0;
            }
            hr {
                border: 1px dashed #000000;
            }
            .clearfix{
                clear: both;
            }
            .page-break {
                page-break-after: always;
            }
            .text-right {
                text-align: right !important;
            }
            .tx-inverse {
                color: #343a40 !important; 
            }
            .tx-16 {
                font-size: 16pt !important;
            }
            .tx-bold {
                font-weight: 600;
            }
            .wd-100-force {
                width: 100px !important; 
            }
            .tx-underline {
                text-decoration: underline;
            }
            .border {
                border: 1px solid #000000 !important; 
            }
            .border-bottom {
                border-bottom: 1px solid #000000 !important; 
            }
            .border-top {
                border-top: 1px solid #000000 !important; 
            }
            .mg-l-10 {
                margin-left: 10px;
            }
            .logo {
                font-size: 18pt;
                font-weight: 700;
                color: #000000;
            }
            .padding-b-0 {
                /*padding-top: 0 !important;*/
                padding-bottom: 0 !important;
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="content">
                <table width="100%" cellpadding="10" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td width="50%">
                                        <div class="logo">
                                            <img class="wd-100-force" src="{{ base_path('logo/neocasa.png') }}">
                                        </div>
                                    </td>
                                    <td width="50%" align="right">
                                        <h2>
                                            Tanda Terima Pembayaran
                                        </h2>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-b-0">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="7%" class="mg-l-10">
                                        Tanggal
                                    </td>
                                    <td width="3%" align="center">:</td>
                                    <td width="25%" class="border-bottom">
                                        <span>{{reformatDate(\Carbon\Carbon::now()->format('d F Y'))}}</span>
                                    </td>
                                    <td width="10%"></td>
                                    <td width="22%" align="right">
                                        Nomor
                                    </td>
                                    <td width="3%" align="center">:</td>
                                    <td width="25%" class="border-bottom">
                                        <span>RCPT-{{$data->booking->client->client_number}}</span>
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-b-0">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="17%" class="mg-l-10">
                                        Telah diterima dari
                                    </td>
                                    <td width="3%" align="center">:</td>
                                    <td width="45%" class="border-bottom">
                                        <span>{{$data->booking->client->client_name}}</span>
                                    </td>
                                    <td width="5%"></td>
                                    <td width="25%" class="border" align="left">
                                        <span class="mg-l-10">IDR</span>
                                        <span class="text-right">
                                            {{ format_money($data->total_paid) }}
                                        </span>
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-b-0">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="7%" class="mg-l-10">
                                        Sejumlah
                                    </td>
                                    <td width="3%" align="center">:</td>
                                    <td width="85%" class="border-bottom">
                                        @php
                                            $paid = ucfirst(numFormatToWords($data->total_paid));
                                            $total_paid = str_replace('juts', 'juta', $paid);
                                        @endphp
                                        <span>{{ $paid }} rupiah</span>
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-b-0">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="17%" class="mg-l-10">
                                        Untuk pembayaran
                                    </td>
                                    <td width="3%" align="center">:</td>
                                    <td width="75%" class="border-bottom">
                                        <span>{{ $data->payment }} Bulan {{ \Carbon\Carbon::parse($data->due_date)->locale('id')->translatedFormat('F') }}</span>
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-b-0">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="17%" class="mg-l-10">
                                        Jenis pembayaran
                                    </td>
                                    <td width="3%" align="center">:</td>
                                    <td width="75%" class="border-bottom">
                                        <span>{{$data->booking->payment_method_utj}}</span>
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-b-0"></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="5%"></td>
                                    <td width="30%" class="border-top" align="center">
                                        ( Finance )
                                    </td>
                                    <td width="30%"></td>
                                    <td width="30%" class="border-top" align="center">
                                        ( {{$data->booking->client->client_name}} )
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            {{-- <div class="cut-line">
                <hr>
            </div> --}}
        </div>
    </body>
</html>
