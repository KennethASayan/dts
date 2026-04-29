<head>
	<link rel="icon" href="./ext_lib/images/denr.png" type="image/png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	<style type="text/css">
		
		body{
			margin: 0px;
			padding: 0px;
		}
		
		#header{
			width: 100%;
		}
		
		#header .header-table{
			width: 100%;
			border-collapse: collapse;
		}
		
		#header .header-table td{
			vertical-align: top;
			border: none;
			padding: 0px;
		}
		
		#header .logo-cell{
			width: 70px;
			text-align: center;
			padding-right: 10px;
		}
		
		#header img{
			height: 55px;
			width: auto;
		}
		
		#header .text-cell{
			flex: 1;
			padding: 0px 5px;
			margin-top:5px;
		}
		
		#header ul{
			list-style-type: none;
			margin: 0px;
			padding: 0px;
		}
		
		#header li{
			margin: 1px 0px;
			line-height: 1.2;
			font-size: 13px;
		}
		
		#header .dept-name{
			font-size: 17px;
			font-weight: bold;
			margin: 2px 0px;
		}
		
		#header .metadata-cell{
			width: 200px;
			text-align: right;
			padding-right: 10px;
			font-size: 13px;
		}
		
		#header .metadata-cell div{
			margin: 1px 0px;
			line-height: 1.2;
			white-space: nowrap;
		}

		#header h2{
			font-size: 22px;
			margin: 8px 0px 0px 0px;
			text-align: center;
			clear: both;
		}
		
		#main_content{
			width: 100%;
			font-size: 14px;
			margin-top: 10px;
		}
		
		#main_content .subject-section{
			margin: 10px 0px 15px 0px;
			font-weight: bold;
			font-size: 13px;
		}
		
		#main_content .subject-section span{
			font-weight: normal;
		}
		
		#main_content table{
			border-collapse: collapse;
			width: 100%;
			border: 1px solid black;
			font-size: 13px;
		}
		
		#main_content table td{
			border: 1px solid black;
			padding: 4px 5px;
			vertical-align: top;
		}
		
		#chk_box{
			border: 1px solid black;
			height: 10px;
			width: 10px;
			margin: 0px 5px 0px 0px;
			display: inline-block;
		}
		
		#chk_box2{
			background-color: black;
			border: 1px solid black;
			height: 10px;
			width: 10px;
			margin: 0px 5px 0px 0px;
			display: inline-block;
		}
		
	</style>

	<div id="header">
		<table class="header-table">
			<tr>
				<td class="logo-cell">
					<img src="./ext_lib/images/denr.png" alt="DENR Logo"/>
				</td>
				<td class="text-cell">
					<ul>
						<li>Republic of the Philippines</li>
						<li class="dept-name">Department of Environment and Natural Resources</li>
						<li><?php echo $this->session->userdata('off_log_penro');?></li>
					</ul>
				</td>
				<td class="metadata-cell">
					<?php foreach ($records as $rec):?>
					<div><b>Document No.:</b> <u><?php echo $rec['doc_no'];?></u></div>
					<div><b>Date Uploaded:</b> <u><?php echo $rec['rec_date'];?></u></div>
					<div><b>Level of Priority:</b> <u><?php echo $rec['prior_t'];?></u></div>
					<div><b>Type:</b> <u><?php echo $rec['doc_description'];?></u></div>
					<?php endforeach;?>
				</td>
			</tr>
		</table>
		<h2>ROUTING SLIP</h2>
	</div>
	
	<div id="main_content">
	<?php foreach ($records as $rec):?>
		<div class="subject-section">SUBJECT: <span><u><?php echo $rec['doc_subject'];?></u></span></div>
		
		<table>
			<tr>
				<td style="width:100px;font-weight:bold" colspan="2">Addressee:</td>
				<td style="width:200px" colspan="2"> </td>
				
				<?php if(strpos($this->session->userdata('off_log_penro'), 'CENR') === false):?>
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
				<?php endif;?>
				<td style="vertical-align:top" rowspan="5" colspan="<?php echo (strpos($this->session->userdata('off_log_penro'), 'CENR') !== false) ? '10' : '5'; ?>">
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
				<td colspan="10" rowspan="10" style="text-align:left;vertical-align:top;border:0px"><i><?php echo (strpos($this->session->userdata('off_log_penro'), 'CENR') !== false) ? "CENRO's Instruction:" : "PENRO's Instruction:"; ?></i><!--<u style="text-align:justify"><?php echo $rec['doc_remarks'];?></u>--></td>
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
						<div><i><?php echo (strpos($this->session->userdata('off_log_penro'), 'CENR') !== false) ? "CENR Officer" : "PENR Officer"; ?><i></div>
					</div>
				</td>
			</tr>
			<tr style="text-align:center">
				<td style="height:20px" colspan="2"></td>
				<td></td>
				<td></td>
				<td colspan="7" rowspan="8" style="vertical-align:top;text-align:left">
				<div style="margin-bottom:5px;font-weight:bold">Section/PA:</div>
					<div style="margin-left:10px;font-size:12px;column-count:2;column-gap:15px;">
						<?php foreach ($sec_list as $list):?>
						<?php if ($list['div_id']!=1):?>
							<div><?php  $sec_ids = explode(",", $rec['sec_id']); $x=0; foreach ($sec_ids as $sec){ if($list['sec_id']==$sec){echo "<img src='./ext_lib/images/check.png' alt='' style='height:12px;'/> ";$x++;}} if($x==0){echo "<img src='./ext_lib/images/box.png' alt='' style='height:10px;'/> ";} echo strtoupper($list['sec_alias']);?></div>
						
						<?php endif;?>
						<?php endforeach;?>
					</div>
				</td>
				<td colspan="3" rowspan="8" style="vertical-align:top;text-align:left">
				<div style="font-weight:bold">Document Classification:</div>
					<br>
					<div style="margin-left:10px;font-size:14px;">
						<img src='./ext_lib/images/box.png' alt='' style='height:10px;'/> No Action Required
					</div>
					<br>
					<div style="margin:0px 0px 5px 5px;font-size:14px;">
						<img src='./ext_lib/images/box.png' alt='' style='height:10px;'/> Required Action: 
					</div>
					<div style="margin-left:5px;font-size:14px;">
					<i>
						<?php if ($rec['act_class']=='Simple'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-top:25px;'/> Simple 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px; margin-left:10px; margin-top:10px'/> Simple
						<?php endif;?>
						<br>
						<?php if ($rec['act_class']=='Complex'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-bottom:25px'/> Complex 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px; margin-left:10px; margin-top:10px'/> Complex
						<?php endif;?>
						<br>
						<?php if ($rec['act_class']=='Highly Technical'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-top:25px'/> Highly Technical 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px; margin-left:10px; margin-top:10px'/> Highly Technical
						<?php endif;?>
						<br>
						<?php if ($rec['act_class']=='Legal Concern'):?><img src='./ext_lib/images/check.png' alt='' style='height:10px;margin-bottom:25px'/> Legal Concern 
						<?php else:?><img src='./ext_lib/images/box.png' alt='' style='height:10px; margin-left:10px; margin-top:10px'/> Legal Concern
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
