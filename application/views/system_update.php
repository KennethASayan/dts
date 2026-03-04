<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="<?php echo base_url();?>ext_lib/images/denr.png" type="image/png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document Tracking System</title>


<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>ext_lib/main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>ext_lib/JQ/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>ext_lib/data_tables/datatables.css" />


<script type="text/javascript" src="<?php echo base_url();?>ext_lib/JQ/external/jquery/jquery.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>ext_lib/JQ/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ext_lib/FormatCurrency.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ext_lib/data_tables/datatables.js" ></script>

</head>


<body>
	<div id="menu_bar">
	
		<?php if($this->session->userdata('valid') == true):?>
		<a href="<?php echo base_url();?>c_dts/logout" id="" style="float:right;margin-right:10px"><img src="<?php echo base_url();?>ext_lib/images/icon/logout.png" alt="Logout" /></a>
		
		<div style="float:right;">	
		<?php
			echo "<div class='dropdown'>
					<a href='#'><i style='color:#ffffff;vertical-align:top;font-size:17px'>Menu</i><img src='".base_url()."ext_lib/images/icon/menu.png' alt='' title='User Group' style='margin-left:15px;' /></a>
						<div class='dropdown-content' style='margin-top:27px;'>";
						if($this->session->userdata('role_log_id')==1){
							echo "<a href='".base_url()."c_dts/user_page'><img src='".base_url()."ext_lib/images/icon/ugroup.png' alt='' /><span style='vertical-align:top'>User Account</span></a>";
						}
						if($this->session->userdata('role_log_id')!=1){
							echo "<a href='".base_url()."c_dts/cpwd_page' id=''><img src='".base_url()."ext_lib/images/icon/pwd.png' alt='' /><span style='vertical-align:top'>Change Password</span></a>";
						}
			echo "<a href='".base_url()."c_dts/export_page' id=''><img src='".base_url()."ext_lib/images/icon/report.png' alt='' /><span style='vertical-align:top'>Export Record</span></a>
				  <a href='".base_url()."c_dts/system_update' id=''><img src='".base_url()."ext_lib/images/icon/log.png' alt='' /><span style='vertical-align:top'>System Update</span></a>
				 
							
							
						</div>
					
				  </div>
			";
		?>	
		</div>
		
		<div style="float:right;margin:5px 50px;color:#ffffff;font-style:italic">	
			<?php echo "<img src='".base_url()."ext_lib/images/icon/user.png' alt='' title='User Group' style='margin-right:10px;' /><span style='vertical-align:top'>".$this->session->userdata('div_log_alias')." ".$this->session->userdata('role_log_name')."</span>";?>	
		</div>	
		<?php endif;?>
		
	</div>
	<div id="header">
			<table>
				<tr>
				<td style="padding-left:10px"><img src="<?php echo base_url();?>ext_lib/images/denr.png" alt="" /></td>
				<td>
					<ul>
						<li>Republic of the Philippines</li>
						<?php if($this->session->userdata('off_log_penro')==''):?>
						<li><h2>Department of Environment and Natural Resources</h2></li>
						<li>DENR-10 Regional Office, Cagayan de Oro City</li>
						<?php else:?>
						<li><h2><?php echo $this->session->userdata('off_log_penro');?></h2></li>
						<li><?php echo $this->session->userdata('off_log_address');?></li>
						<?php endif;?>
					</ul>
				</td>
				</tr>
			</table>
	</div>
	

	<div style="width:90%;margin-right:5%;margin-left:5%">
	
	<br>
	<br>
	<a href='<?php echo base_url();?>/c_dts' id='home_btn'><img src='<?php echo base_url();?>ext_lib/images/icon/return.png' alt='' width='15'/> Return Home</a>

	<br>
	<h1 id="title_tbl" style="color:#CA5F5F;font-family:arial;margin:20px 0px 10px 0px;text-align:center">
					<?php 
							echo "System Updates";
					?>
				</h1>	
				<center>
				<table id="sysup_tbl" class="cell-border display" cellspacing="0" data-page-length="20">
					<thead style="text-align:left">
						<tr>
								<th>id</th>
								<th>Author</th>
								<th>Type</th>
								<th>Activity</th>
								<th>Date</th>
						</tr>
					</thead>
					<?php foreach ($sys_up as $row):?>
					<tr>
						<td><?php echo $row['up_id'];?></td>
						<td><?php echo $row['res_pers'];?></td>
						<td><?php echo $row['act_type'];?></td>
						<td><?php echo $row['activity'];?></td>
						<td><?php echo date_format(date_create($row['up_date']), 'M d, Y');?></td>
					</tr>	
					<?php endforeach;?>
				</table>
				</center>
		
		</div>
				
					
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('#home_btn').button().css({'background-color':'#CA5F5F', 'color':'#ffffff'});
				
				$('#sysup_tbl').DataTable({
					"bLengthChange": true,
					
					"dom": 'rtip',
					//"lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
					"language": {
					"processing": "Loading Data...",
					"sSearch": "Search Keywords:",
					"decimal": ".",
					"thousands": ",",
					"loadingRecords": "Please wait - loading...",
					"lengthMenu": "Display _MENU_ Records",
					"zeroRecords": "No records found",
					//"info": "Page _PAGE_ of _PAGES_",
					"infoEmpty": "No records available",
					"infoFiltered": "(filtered from _MAX_ total records)"
				},
				"columnDefs": [
						
						{
							"targets": [0],
							"visible": false,
							"searchable": false
						},
					],
				
				
			}).order( [ 0, 'desc' ] ).draw();
				
				
				
			});
		</script>		