<head>
	<link rel="icon" href="./ext_lib/images/denr.png" type="image/png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>DTS Routing Slip</title>
</head>
	<style type="text/css">
		
		#header{
			width: 100%;
			height: 50px;
			margin:0px;
		}
		
		#header img{
			height: 60px;
		}
		
		#header ul{
			list-style-type: none;
			margin-left: 10px;
			padding: 0;
		}
		#header {
			font-size:14px;
		}

		#header h2{
			font-size:22px;
			margin: 0px;
		}	
				
		
		#main_content{
			width: 100%;
			font-size: 14px;
			margin-top:0px;
		}
		
		#main_content table{
			border-collapse:collapse;
			margin: 20px 0px 0px 0px;
			width: 700px;
			border: 1px solid black;
			font-size:13px;
		}
		#main_content table td{
			border: 1px solid black;
			padding-left:3px;
		}
		#chk_box{
			border: 1px solid black;
			height: 10px;
			width: 10px;
			margin: 0px 5px 0px 0px;
		}
		#chk_box2{
			background-color:black;
			border: 1px solid black;
			height: 10px;
			width: 10px;
			margin: 0px 5px 0px 0px;
		}
		
			
	</style>

	<div id="header">
		<table style="margin-top:-20px">
				<tr>
				<td><img src="./ext_lib/images/denr.png" alt=""/></td>
				<td>
					<ul>
						<li>Republic of the Philippines</li>
						<li><span style="font-size:17px; font-weight:bold">Department of Environment and Natural Resources</span></li>
						<li><span style="font-size:15px"><?php echo $this->session->userdata('off_log_penro');?></span></li>
					</ul>
				</td>
				</tr>
			</table>
		<center>
			<h2>ROUTING SLIP</h2>
		</center>
	</div>
		
	<div id="main_content">
	
		<?php foreach ($records as $rec):?>
		<div style="font-size:13px;height:40px;width:100%;text-align:left;margin-top:0px;margin-left:530px;position:fixed">
			<div><b>Document No.:</b> <u><?php echo $rec['doc_no'];?></u></div>
			<div><b>Date Uploaded:</b> <u><?php echo $rec['rec_date'];?></u></div>
			<div><b>Level of Priority:</b> <u><?php echo $rec['prior_t'];?></u></div>
			<div><b>Type:</b> <u><?php echo $rec['doc_description'];?></u></div>
		</div>
		<table style="margin-top:90px;border:0px">
			<tr style="font-size:15px">
				<td style="vertical-align:top;font-weight:bold;width:80px;border:0px;font-size:14px">SUBJECT:</td>
				<td style="text-align:justify;width:610px;border:0px;font-size:14px"><u><?php echo $rec['doc_subject'];?></u></td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td style="width:100px;font-weight:bold" colspan="2">Addressee:</td>
				<td style="width:200px" colspan="2"> </td>
				
				<td style="vertical-align:top"  rowspan="5" colspan="5">
					<div style="margin-bottom:5px;font-weight:bold">Division/Bureau:</div>
					
					<div style="margin-left:10px;column-count:2">
						<?php foreach ($div_list as $list):?>
						<?php if ($list['div_id']!=1):?>
						<?php if(strpos($list['div_alias'],'C-')===false and strpos($list['div_alias'],'PA-')===false):?>
							<div style="margin-bottom:5px"><?php  $div_ids = explode(",", $rec['div_id']); $x=0; foreach ($div_ids as $div){ if($list['div_id']==$div){echo "<img src='./ext_lib/images/check.png' alt='' style='height:12px;'/> ";$x++;}} if($x==0){echo "<img src='./ext_lib/images/box.png' alt='' style='height:10px;'/> ";} echo strtoupper($list['div_alias']);?></div>
						
						<?php endif;?>
						<?php endif;?>
						<?php endforeach;?>
					</div>
					
				</td>
				<td style="vertical-align:top" rowspan="5" colspan="5">
					<div style="margin-bottom:5px;font-weight:bold">Action:</div>
					<div style="margin-left:10px;column-count:2">
						<?php foreach ($act_desc as $list):?>
							<div><?php  $act_ids = explode(",", $rec['act_id']); $x=0; foreach ($act_ids as $act){ if($list['act_id']==$act){echo "<img src='./ext_lib/images/check.png' alt='' style='height:12px;'/> ";$x++;}} if($x==0){echo "<img src='./ext_lib/images/box.png' alt='' style='height:10px;'/> ";} echo $list['act_description'];?></div>
						
						<?php endforeach;?>
						
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight:bold">Sender:</td>
				<td colspan="2"><?php echo $rec['sender'];?></td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight:bold">Document Date:</td>
				<td colspan="2"><?php echo $rec['doc_date'];?></td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight:bold">Date Received:</td>
				<td colspan="2"><?php echo $rec['doc_date_rr'];?></td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight:bold">Time Received:</td>
				<td colspan="2"><?php echo $rec['doc_time_rr'];?></td>
			</tr>
			<tr>
				<td style="height:30px;font-weight:bold;text-align:center" colspan="4">R O U T E D</td>
				<td colspan="10" rowspan="10" style="text-align:left;vertical-align:top;border:0px"><i>PENRO's Instruction:</i><!--<u style="text-align:justify"><?php echo $rec['doc_remarks'];?></u>--></td>
			</tr>
			
			<tr style="text-align:center">
				<td style="height:25px" colspan="2">FROM</td>
				<td>TO</td>
				<td>DATE/TIME</td>
			</tr>
			<?php $x=0; foreach ($log_route as $row):?>
					<tr>
						<td style="min-height:25px" colspan="2"><?php echo $row['div_alias'];?></td>
						<td><?php $a = array( 'Routed to', 'Returned to', 'Section(s):', 'Unit(s):', ';' );  echo str_replace($a,'', $row['event']);?></td>
						<td style="text-align:center"><?php echo $row['e_dt'];?></td>
					</tr>
			<?php $x++; endforeach;?>
			<?php $y=8; while(($y-$x)!=0):?>
					<tr>
						<td style="height:30px" colspan="2"></td>
						<td></td>
						<td></td>
					</tr>
			<?php $y--; endwhile;?>
			<tr>
				<td style="height:20px" colspan="2"></td>
				<td></td>
				<td></td>
				<td colspan="10" rowspan="1" style="border:0px">
					<div style="text-align:center">
						<div><b><?php echo strtoupper($this->session->userdata('off_log_pname'));?></b></div>
						<div><i>PENR Officer<i></div>
					</div>
				</td>
			</tr>
			<tr style="text-align:center">
				<td style="height:20px" colspan="2"></td>
				<td></td>
				<td></td>
				<td colspan="7" rowspan="5" style="vertical-align:top;text-align:left">
				<div style="margin-bottom:5px;font-weight:bold">Section/PA:</div>
					<div style="margin-left:10px;font-size:14px;">
						<?php foreach ($sec_list as $list):?>
						<?php if ($list['div_id']!=1):?>
							<div><?php  $sec_ids = explode(",", $rec['sec_id']); $x=0; foreach ($sec_ids as $sec){ if($list['sec_id']==$sec){echo "<img src='./ext_lib/images/check.png' alt='' style='height:12px;'/> ";$x++;}} if($x==0){echo "<img src='./ext_lib/images/box.png' alt='' style='height:10px;'/> ";} echo strtoupper($list['sec_alias']);?></div>
						
						<?php endif;?>
						<?php endforeach;?>
					</div>
				</td>
				<td colspan="3" rowspan="5" style="vertical-align:top;text-align:left">
				<div style="font-weight:bold">Document Classification:</div>
					<br>
					<div style="margin-left:10px;font-size:14px;">
						<img src='./ext_lib/images/box.png' alt='' style='height:10px;margin-bottom:10px'/> No Action Required
					</div>
					<br>
					<div style="margin:0px 0px 5px 10px;font-size:14px;">
						<img src='./ext_lib/images/box.png' alt='' style='height:10px;margin-bottom:10px'/> Required Action: 
					</div>
					<div style="margin-left:30px;font-size:14px;">
					<i>
						<?php if ($rec['act_class']=='Simple'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-bottom:10px'/> Simple 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px;margin-bottom:10px'/> Simple
						<?php endif;?>
						<br>
						<?php if ($rec['act_class']=='Complex'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-bottom:10px'/> Complex 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px;margin-bottom:10px'/> Complex
						<?php endif;?>
						<br>
						<?php if ($rec['act_class']=='Highly Technical'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-bottom:10px'/> Highly Technical 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px;margin-bottom:10px'/> Highly Technical
						<?php endif;?>
						<br>
						<?php if ($rec['act_class']=='Legal Concern'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-bottom:10px'/> Legal Concern 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px;margin-bottom:10px'/> Legal Concern
						<?php endif;?>
					</i>
					</div>
				</td>
			</tr>
			<?php $y=4; while(($y-$x)!=0):?>
					<tr>
						<td style="height:20px" colspan="2"></td>
						<td></td>
						<td></td>
					</tr>
			<?php $y--; endwhile;?>
			
			
			
			
		</table>
		<?php endforeach;?>
	</div>
