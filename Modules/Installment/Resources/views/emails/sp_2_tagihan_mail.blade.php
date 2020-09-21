@extends('core::layouts.email')

@section('content')
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
	<!-- Body content -->
	<tr>
		<td class="content-cell" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100vw; padding: 32px;">
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: right;">Karawang, {{\Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y')}}</p>
			<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
				{{-- <tr>
					<td width="20%" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">Nomor</p>
					</td>
					<td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">:Nomor</p>
					</td>
				</tr> --}}
				<tr>
					<td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">Perihal</p>
					</td>
					<td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">:<strong>Surat Peringatan Ke-2 Tagihan</strong></p>
					</td>
				</tr>
			</table>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;margin: 30px auto;">
				Kepada Yth,<br>
				<strong>Bapak/Ibu {{$booking->client->client_name}}</strong><br>
				{{$booking->client->client_address}}<br>
				{{$booking->client->city}}, {{$booking->client->province}} 
			</p>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Dengan Hormat,</p>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Kami mengucapkan terima kasih atas kepercayaan Bapak/Ibu untuk pembelian Rumah di Emerald Neopolis (<strong>{{$booking->unit->unit_type}} No. {{$booking->unit->unit_number}}</strong>).</p>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Kami sampaikan bahwa menurut catatan kami per tanggal <strong>{{\Carbon\Carbon::parse($installment->due_date)->locale('id')->format('d F Y')}}</strong>, Bapak/Ibu masih memiliki kewajiban yang belum dibayarkan sebesar <strong>Rp. {{number_format($installment->installment + ($installment->fine * $installment->number_of_delays), 0, ',', '.')}}</strong> 
				@php
					$amount = new NumberFormatter("id", NumberFormatter::SPELLOUT);
					$amount->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose")
				@endphp
			(<strong>{{ucwords($amount->format($installment->installment + ($installment->fine * $installment->number_of_delays)))}} Rupiah</strong>) dengan rincian sebagai Berikut:</p>
			<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
				<tr>
					<td width="40%" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">1. Denda {{$installment->payment}}</p>
					</td>
					<td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">: Rp. <strong>{{number_format($installment->fine * $installment->number_of_delays, 0, ',', '.')}}</strong></p>
					</td>
				</tr>
				<tr>
					<td width="40%" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">2. {{$installment->payment}}</p>
					</td>
					<td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1em; margin-top: 0; text-align: left;">: Rp. <strong>{{number_format($installment->installment, 0, ',', '.')}}</strong></p>
					</td>
				</tr>
			</table>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Berdasarkan ketentuan umum <strong>SPR</strong> (<strong>Surat Pesanan Rumah</strong>) mengenai tata cara pembayaran menunjuk point <strong>1.4.a</strong> dalam hal keterlambatan pembayaran baik booking fee maupun cicilan DP/Pelunasan. Atas keterlambatan pembayaran angsuran yang telah jatuh tempo akan dikenakan denda keterlambatan "<strong>Sebesar 1&permil; (satu per-mil)/hari dari nilai kekurangan angsuran</strong>"</p>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Karena sampai saat ini kami belum juga menerima pembayaran dari Bapak/Ibu, dan sudah terhitung telah lebih dari <strong>{{option('sp2_date', 21)}}</strong> (<strong>{{ucwords($amount->format(option('sp2_date', 21)))}}</strong>) hari melewati batas waktu yang telah kita sepakati sebelumnya, untuk menghindari denda yang lebih besar, maka kami berharap Bapak/Ibu segera melunasinya sebelum <strong>{{\Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), 0))->locale('id')->translatedFormat('d F Y')}}</strong>.</p>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Untuk melakukan pembayaran dapat dilakukan dengan melalui tombol di bawah ini :</p>
			<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
				<tr>
					<td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
							<tr>
								<td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
									<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
										<tr>
											<td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
												<a href="https://laravel.com" class="button button-primary" target="_blank" rel="noopener" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">Pembayaran Cicilan</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">Demikian <strong>Surat Peringatan Ke-2 (Dua) Tagihan</strong> ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
			
			@include('core::layouts.email_footer', ['action_name' => 'Pembayaran Cicilan', 'action_url' => route('pembayaran.cicilan.index', [$booking->slug]), 'tembusan' => $booking->sales->user->full_name])
		</td>
	</tr>
</table>
@endsection