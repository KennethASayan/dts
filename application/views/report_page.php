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
	
			
				<h1 id="title_tbl" style="color:#CA5F5F;font-family:arial;margin:20px 0px 10px 0px;text-align:center">Report Generation</h1>
				
				<table>
					<tr id="lev_prio">
					<td style="text-align:left;">
						<select name="report_t" id="report_t" style="padding:10px;font-size:16px">
							<option value="">-- Select Report --</option>
							<option value="report_1">Document Summary Report</option>
							<!--<option value="report_2">Document Referred per Division </option>-->
							<option value="report_3">Document Received/Acted per Section </option>
							<option value="report_4">Document Acted per Category</option>
							<option value="report_5">Centralized Uploading of Incoming Documents</option>
						</select>
					</td>
					<td style="text-align:left;">
						<select name="semestral" id="semestral" style="padding:10px;font-size:16px">
							<option value="">-- Select Semester --</option>
							<option value="1">1st Semester</option>
							<option value="2">2nd Semester</option>
						</select>
					</td>
					<td style="text-align:left;">
						<select name="rec_yr" id="rec_yr" style="padding:10px;font-size:16px">
							<?php $years = date('Y')-2020; for($x=0;$x<=$years;$x++):?>
								<option value="<?php echo date('Y')-$x ;?>"><?php echo date('Y')-$x ;?></option>
							<?php endfor;?>
						</select>
					</td>
					<td>
						<input type="button" value="Generate Report" id="gen_rep" style="margin-left:30px;height:40px" />
					</td>
				</tr>
				</table>
				<br><br>
				
				<div id="report_content"></div>
				
				<center>
				<div id="loading"><h3>Generating Report. . . <img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" alt="" style="height:30px;margin:0px 10px -8px 0px" /> </h3></div>
				</center>
				

	</div>

							
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loading").hide();
			$("#semestral").hide();
			
			$('#home_btn').button().css({'background-color':'#CA5F5F', 'color':'#ffffff'});
						
			$("#gen_rep").button();
			
			var rep_trig=0;
			$(document).on("change", "#report_t", function(e){
				
				if($(this).val()=='report_3'){
					$("#semestral").show();
					rep_trig=1;
				}else{
					$("#semestral").hide();
					rep_trig=0;
				}
				
			});
			
			
			$(document).on("click", "#gen_rep", function(e){
				var report_t = $("#report_t").val();
				var semestral = $("#semestral").val();
				var rec_yr = $("#rec_yr").val();
				
				var error_check='';
				
				if(rep_trig==1){
					if(semestral==''){
						error_check='Please select Semester.';
					}
				}
				
				if(report_t==''){
					error_check='Please select report.';
				}
				
				
				if(error_check==''){
					$("#report_content").empty();
					$("#loading").show();
					
					$("#report_content").load("<?php echo base_url();?>c_dts/get_report_page?report_t="+report_t+"&semestral="+semestral+"&rec_yr="+rec_yr+"", function(response, status, xhr){
						
						if(status == "success"){
							$("#loading").hide();
						}
					});
				}else{
					alert(error_check);
				}	
				
			});
			
			
			
		});
	</script>
	
	<style>
	
		.report_table {
			border:1px solid black;
			border-collapse: collapse;
			width:100%;
			
		}
		.report_table td{
			border:1px solid black;
			padding:5px;
			text-align:center;
			width:100px;
		}
	</style>