<!DOCTYPE html>
<html>
<head>
	<title>Test Paper Details</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		@font-face {
			font-family: 'Open Sans', sans-serif;
			src: url({{ asset('public/assets/css/font/OpenSans-Regular.ttf') }});
	    }  
	    .budget-table{
            padding: 15px!important;
		    border-collapse: collapse;
		    width: 90%;
		    margin: 20px auto;
	    }
	    .budget-table th {
	    	background-color: #ccc;
	    }
	    .budget-table td, .budget-table th {
		    border: 1px solid #dddddd;
		    text-align: left;
		    padding: 8px;
		}
		
	</style>
	</head>
<body style="padding: 0px;margin: 0px;font-family: 'Open Sans', sans-serif;color: #7d7878">
	<div style="max-width: 800px;margin-right: auto;margin-left: auto;border: 1px solid #dddd;">
		<table align="center" border="0" cellspacing="0" cellpadding="0"  width="100%">
			<tr>
				<td bgcolor="#382e46" align="center" width="100%" style="padding-top:10px;padding-bottom:10px">
					 <img src="{{ url('public/frontassets/img/logo.png') }}" style="height:80px!important" alt="logo"> 
				</td>
			</tr>
			
			<tr>
				<td style="padding:10px 15px;font-size: 15px;">
					Hello {{$name}} ,<br><br>
					 Your test has been scheduled on this date {{$sdate}}
                     please login in to your account for more details .<br><br>
                    <span> Test Name : {{$tname}} </span><br>
                    <span> Subject   : {{$sname}} </span><br><br>
                    <a href="{{url('user-login')}}"> Click here to Login</a>
                    <br>
				</td>
			</tr>
		   	
			<tr>
				<td style="border-right: 1px solid #dedede">
					<table  cellspacing="0" cellpadding="0" width="100%" style="font-size: 15px;">
				<th bgcolor="#382e46" align="center" width="100%" style="padding-top:20px;padding-bottom:20px;color: #fff;font-size: 16px;">
				Thank You. <a href="{{ url('/')}}" style="color: #fff;font-size: 16px;text-decoration: none;" target="_blank"> Click Here To Visit Website</a>
				</th>
			</table>
		</td>
			</tr>
			
		</table>
  </div>

</body>
</html>
