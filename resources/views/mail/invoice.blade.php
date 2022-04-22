<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<style>
		th {
		    color: #fff;
		    padding: 6px 4px;
		    font-size: 15px;
		}
		.myfnt tr td{
			padding: 7px 4px;
		    text-align: center;
		    font-size: 14px;
		    border-left: 1px solid #483e56;
		    border-bottom: 1px solid #483e56;
		    border-top: 1px solid #483e56;
		}
		.mybtn{
			padding: 7px 14px;
		    font-size: 18px;
		    background: #179bd7;
		    border: 0;
		    color: #ffffff;
		    cursor: pointer;
		}
	</style>
</head>

<body style="margin: 0;padding: 0;width: 100%;height: 100%;font-family: 'Open Sans';">
	<div class="main-dv">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#fff" >
 			<tbody>
 				<tr>
 					<td>
 						<table width="700" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#fff"  style="    border: 1px solid #483e56;font-family: 'Open Sans';">
 							<tbody>
 								<tr>
 									<td>
 										<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
 											<tbody>
 												<tr>
 													<td height="20" width="100%"></td>
 												</tr>
 												<tr>
 													<td width="50%" valign="top" style="padding: 0 20px;">
 														<img src="{{ url('public/frontassets/img/logo.png')}}" width="200px;">
 													</td>
 													<td width="50%" valign="middle" align="right" style="padding: 0 20px;">
 														<span style="font-family: 'Open Sans'; font-size: 24px; color: #969696; font-weight: 600;">INVOICE </span>
 													</td>
 												</tr>
												<tr>
 													<td width="50%" valign="middle" align="right">
 														<span style="font-family: 'Open Sans'; font-size: 18px;  font-weight: 600;">To:  {{$customer->first_name.' '.$customer->last_name}} </span>
 													</td>
 												</tr>
 											</tbody>
 										</table>
 									</td>
 								</tr> <!-- First tr -->

 								<tr>
 									<td height="30"></td>
 								</tr>

 								<tr>
 									<td>
 										<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
 											<tbody>
 												<tr> 
 													<td width="340" valign="top" style="padding: 0 20px;">
 														<table width="340" border="0" cellpadding="0" cellspacing="0" align="left" style="font-family: 'Open Sans';">
 															<tbody>
 																<tr>
											<td style="padding-bottom: 10px;">
												<b>{{$user->business_name}}</b>
											</td>
 																</tr>
 																
 																<tr>
											<td style="font-size: 15px;line-height: 24px;">
												Address:&nbsp;{{$user->address}} {{$user->street_name}} {{$user->city_town}} 
												<br>
												Phone:&nbsp; {{$user->mobile}}
												<br>
												Email:&nbsp;{{$user->marchent_email}}
												
											</td>
 																</tr>
 															</tbody>
 														</table>
 													</td>
 													<td width="340" valign="top" style="padding: 0 20px;" align="right">
 														<table width="340" border="0" cellpadding="0" cellspacing="0" align="right" style="font-family: 'Open Sans';text-align: right;">
 															<tbody>
 																
 											<tr>
											<td style="padding-bottom: 17px;">
												<span style="background: #d1f1ff;padding: 5px 18px 7px 14px; margin-right: 8px;font-size: 15px;">
													Invoice Date
												</span>
												<span style="background: #e6e6e6; padding: 5px 18px 7px 14px; font-size: 15px;">
												{{date('d-m-Y',strtotime($invoice->invoice_date))}}
												</span>
												<br><br>
												<span style="background: #d1f1ff;padding: 5px 18px 7px 28px; margin-right: 8px;font-size: 15px; text-align: center;">
													Invoice No
												</span>
												<span style="background: #e6e6e6; padding: 5px 18px 7px 14px; font-size: 15px;">
												{{$invoice->invoice_no}}
												</span>
											</td>
											
 											</tr>
 																
 																
 															</tbody>
 														</table>
 													</td>
 												</tr>
 											</tbody>
 										</table>
 									</td>
 								</tr> <!-- Second tr -->

 								<tr>
 									<td height="10"></td>
 								</tr>

 								<tr>
 									<td>
 										<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
 											<tbody>
 												
 											</tbody>
 										</table>
 									</td>
 								</tr> <!-- 3rd tr -->

 								<tr>
 									<td height="20"></td>
 								</tr>

 								<tr>
 									<td>
 										<table width="700"  cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #483e56;">
 											<thead>
 												<tr bgcolor="#382e46">
 													<th> Service Name </th>
 													<th> Date </th>
 													<th> Tax </th>
													<th> Amount </th>
													<th> Recieved Amount </th>
 												</tr>
 											</thead>
 											<tbody class="myfnt">
											@php $RcvedtotalAmount = 0; @endphp
											@if(count($services)>0)
												
												@foreach($services as $row)
											@php $RcvedtotalAmount = $RcvedtotalAmount +  $row->amount; @endphp
 												<tr>
 													<td>{{$row->service_name}}</td>
 													<td>
													{{ date("d-M-Y",strtotime($row->invoice_date)) }}
													</td>
 													<td>5%</td>
													<td>{{$row->amount}}</td>
													<td>{{$row->amount}}</td>
 													
 												</tr>
												@endforeach
												@endif
 												<tr>
 													<td colspan="4" style="text-align: right;"> 
 														<b>Total </b></td>
 													<td> {{ $RcvedtotalAmount }} </td>
 												</tr>
 											</tbody>
 										</table>
 									</td>
 								</tr> <!-- 4th tr -->

 								<tr>
 									<td height="30"></td>
 								</tr>

 							</tbody>
 						</table>
 					</td>
 				</tr>
 			</tbody>
		</table>
	</div>
</body>
</html>