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
				  <a href='".base_url()."c_dts/report_page' id=''><img src='".base_url()."ext_lib/images/icon/report.png' alt='' /><span style='vertical-align:top'>Generate Report</span></a>
					
							
							
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


	<div id="u_login">
				<form action="<?php echo base_url();?>c_dts/login" method="POST">
					<center>
					
					<img src="<?php echo base_url();?>ext_lib/images/denr_logo.png" height="100" width="100" alt="" style="margin-bottom:20px"/>
					<div id="msg"><?php $msg=$this->session->flashdata('msg'); if($msg!=''){echo '<label style="color:red;margin:5px;padding:5px;font-weight:bold">'.$msg.'</label>';}?></div>
					<img src="<?php echo base_url();?>ext_lib/images/icon/uin.png" style="height:30px;position:absolute;margin:7px 0px 0px 117px" />
					<a id="pass_peek" href="#" style="position:absolute;margin: 55px 0px 0px 120px"><img src="<?php echo base_url();?>ext_lib/images/icon/peek.png" style="height:25px" /></a>
					<table id="u_log_tbl">
						<tr><td><input type="input" id="uname" name="uname" placeholder="Username" style="min-width:300px;height:30px;font-size:15px;" required/></td></tr>
						<tr><td><input id="pwd" type="password" id="upwd" name="upwd" placeholder="Password" style="min-width:300px;height:30px;font-size:15px;" required/></td></tr>
						<tr><td><input type="submit" id="sub_btn" value="Login" style="float:right;margin:20px 0px 20px 0px;"/></td></tr>
					</table>
					</center>
				</form>
				</div>
				
				
				<script type="text/javascript">
							
					$(document).ready(function(){
								
						$("#sub_btn").button().width(50).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
						
						$("#u_login").dialog({
							
									title: "Login",
									autoOpen: "true",
									width: '30%',
									show: 'fade',
									hide: 'fade',
									modal: true,
									resizable: false,
									closeOnEscape: false,
									open: function(event, ui) {
										$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
									},
										  
						});
						
						$('#uname, #upwd').on('input',function(){
									if (!( /^([a-zA-Z0-9ñÑ_!@#$%&])+$/.test( $(this).val()))){
										$(this).val('');
									}
						});
						
						$('#pass_peek').on('mousedown',function(){$('#pwd').attr('type', 'text');});
						$('#pass_peek').on('mouseleave',function(){$('#pwd').attr('type', 'password');});
						$('#pass_peek').on('mouseup',function(){$('#pwd').attr('type', 'password');});
								
					});

				</script>	