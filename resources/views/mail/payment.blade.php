<!DOCTYPE html>
<html>
<head>
	<title>Order-Details</title>
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
					Hello {{ $user->name }} ,<br><br>
					Thanks for joining “FAST Test Series” Where you get the Fastest Test results And Interactive Discussions with our Experts which will help you Improve Your Preparation for Real ICAI Exams.<br><br>
					{{ $user->message }}<br><br>
                    Please find the below mentioned order details:-
				</td>
			</tr>
		   	<br>
			<tr>
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th style="padding: 10px 0px; color: #fff; background-color: #382e46; border: 3px solid  #fc386b; font-size: 16px;">Order Details</th>
					</tr>
					<tr >
						<table cellpadding="0" class="budget-table" style="padding: 15px!important;border-collapse: collapse;width: 90%; margin: 20px auto;">
						  <tr>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Name</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Mobile</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">City</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Course</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Group</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Subject</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Plan</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Amount</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Schedule/Unschedule</th>
						    <th style="background-color: #ccc;border: 1px solid #dddddd;text-align: center;padding: 8px;">Date</th>
						   
						  </tr>
						 

						  <tr>
						    <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"><?php echo $user->name; ?></td>
						    <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"><?php echo $user->mobile; ?></td>
						     <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"><?php echo $user->city; ?></td>
						    <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"><?php echo $user->course_name; ?></td>
						    <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;">

						    	 <?php
                                       $gAry = explode(",",$user->group_id);
                                       $gname = Helper::getTableResultArray('groups',$gAry); 
                                         if(count($gname)>0)
                                         {
                                            $i=0;
                                            foreach($gname as $s)
                                            {
                                                $i++;
                                               echo $i.'. '.$s->name.'<br>'; 
                                            }
                                         }else{
                                                echo "N/A";
                                           } 
                                   ?> 

						    	</td>
						     <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;">
						     
                                    <?php
                                       $serAry = explode(",",$user->subject_id);
                                       $sname = Helper::getTableResultArray('subjects',$serAry); 
                                         if(count($sname)>0)
                                         {
                                            $i=0;
                                            foreach($sname as $s)
                                            {
                                                $i++;
                                               echo $i.'. '.$s->sub_name.', '; 
                                            }
                                         }else{
                                                echo "N/A";
                                           } 
                                   ?> 
						     		
						     	</td>
						    <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"> 
						    	<?php
                                        $pgAry = explode(",",$user->plan_id);
                                        $pgname = Helper::getTableResultArray('plans',$pgAry); 

                                         if(count($pgname)>0)
                                         {
                                            $i=0;
                                            foreach($pgname as $sp)
                                            {
                                                $i++;
                                               echo $i.'. '.$sp->title.', '; 
                                            }
                                         }else{
                                                echo "N/A";
                                           } 
                                   ?> </td>
						     <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"><?php echo $user->amount; ?></td>
						     <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;">
						     			<?php 
						     			if($user->schedule_payment==1) 
						     			{
						     				 echo 'Schedule';
						     			}else{

						     				echo 'Unschedule';
						     			}

										?>

						     	</td>
						    <td style="border: 1px solid #dddddd;text-align: center;padding: 8px;"><?php echo date('d-m-Y',strtotime($user->created_date)); ?></td>
						  </tr>
						
						</table>
						  <p style="text-align: center;">
						  Wishing You Oceans of GOOD LUCK for your Exams. As long as you do your Best.</p>
					</tr>
				</table>
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
