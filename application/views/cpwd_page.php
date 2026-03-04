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
				
	<form id="up_cpwd" action="<?php echo base_url();?>c_dts/update_pwd" method="POST">
				<center>
				<div id="notify"><?php $msg=$this->session->flashdata('msg'); if($msg!=''){echo '<label style="color:red;border: 1px solid red;padding:5px;font-weight:bold">'.$msg.'</label>';}?></div>
				<table id="add_tbl">
					<h2 style="color:#009999">Change Password</h2>
					<tr>
						<td>Old Password<span>*</span></td>
						<td><input type="password" name="o_pwd" id="o_pwd" /></td>
					</tr>
					<tr>
						<td>New Password<span>*</span></td>
						<td><input type="password" name="n_pwd" id="n_pwd" /></td>
					</tr>
					<tr>
						<td>Confirm New Password<span>*</span></td>
						<td><input type="password" name="cn_pwd" id="cn_pwd" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input id="ch_btn" type="button" value="Submit" style="height:auto;width:auto;float:right"/></td>
					</tr>					
				</table>	
							
				</center>
				</form>
								
		</div>

		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('#home_btn').button().css({'background-color':'#CA5F5F', 'color':'#ffffff'});
				
				$('#n_pwd, #cn_pwd, #o_pwd').on('input',function(){
						if (!( /^([a-zA-Z0-9_!@#$%&])+$/.test( $(this).val()))){
							$(this).val('');
						}
				});
				
				$('input').on('input change',function(){
					$(this).css({
								"border": "",
								"background": ""
					});
				});
				
				$('#ch_btn').button().on('click', function(){
					var n_pwd = $('#n_pwd').val();
					var cn_pwd = $('#cn_pwd').val();
					var isValid = true;
					
					
					$('#up_cpwd input').each(function() {
							if ($.trim($(this).val()) == '') {
							isValid = false;
								$(this).css({
										"border": "1px solid red",
										"background": "#feebeb"
										});
							}
							else {
								$(this).css({
										"border": "",
										"background": ""
										});
							}
					});
					
					
					
					if (isValid == false){
											$('#notify').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>Please fill out all required (*) fields.</b></label>').show().delay(2000).fadeOut('slow');
					}
					else {
							if(n_pwd.length >= 6){
								if(n_pwd == cn_pwd){
									$('#up_cpwd').submit();
								}else{
									$('#notify').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>New password does not matched</b></label>').show().delay(2000).fadeOut('slow');
								}
							}else{
									$('#notify').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>Password must contain atleast 6 characters.</b></label>').show().delay(2000).fadeOut('slow');
								}
					}
					
				}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
				
			});
		</script>		