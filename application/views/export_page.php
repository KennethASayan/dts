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
	<div style="margin:10px 0px 20px 0px">
					
			<a href='<?php echo base_url();?>/c_dts' id='home_btn'><img src='<?php echo base_url();?>ext_lib/images/icon/return.png' alt='' width='15'/> Return Home</a>

				<a href="#" id="col_srch" style="margin-left:20px">Advance Filtering</a>
				<a href="#" id="exp_btn" style="margin-left:20px">Export Record</a>
				<a href="#" id="gen_list" style="margin-left:20px">Print Record</a>
				</div>
				<div id="up_msg"></div>
				<table id="record_tbl" class="display" cellspacing="0" data-page-length='10'>
				
					<thead style="text-align:center">
						<tr>
								<th>Select All<br><input style="height:15px;width:15px" type="checkbox" name="selec_box" id="selec_box"/></th>
								<th>Document_No.</th>
								<th>Type</th>
								<th>Sender/Recipient</th>
								<th>Document_Date</th>
								<th>Subject</th>
								<th>Date_Received</th>
								<th>Routed_To</th>	
								<th>Status</th>
								<th>Status_Date</th>
								<th>Class</th>
								<th>Priority</th>
								<th>Duration_Acted</th>
								<th>Action_Document_No.</th>
						</tr>
					</thead>
					<tfoot id="t_foot" style="text-align:left">
						<tr>
								<th><input style="height:15px;width:15px" type="checkbox" name="selec_box" id="selec_box"/></th>
								<th>Document_No.</th>
								<th>Type</th>
								<th>Sender/Recipient</th>
								<th>Document_Date</th>
								<th>Subject</th>
								<th>Date_Received</th>
								<th>Routed_To</th>
								<th>Status</th>
								<th>Status_Date</th>
								<th>Class</th>
								<th>Priority</th>
								<th>Duration_Acted</th>
								<th>Action_Document_No.</th>
						</tr>
					</tfoot>
					
						<?php foreach ($records as $rec):?>
						<tr>
								<td></td>
								<td><?php echo $rec['doc_no'];?></td>
								<td><?php echo $rec['doc_description'];?></td>
								<td><?php echo $rec['sender'];?></td>
								<td><?php echo $rec['doc_date'];?></td>
								<td><?php echo $rec['doc_subject'];?></td>
								<td><?php echo $rec['rec_date'];?></td>
								<?php	
									$div_sel = '';
									$x=0;
									$div_id=explode(",",$rec['div_id']);
									foreach($div_id as $div_select){
										foreach($div_list as $list){
											if($list['div_id']!=1){
												if($div_select==$list['div_id']){
													if($x!=0){$div_sel .=", ";}
													$div_sel .= $list['div_alias']; 
													$x++;
												}
											}
										}
									}
								?>
								<td><?php echo $div_sel;?></td>
								<td style="font-weight:bold;text-align:left">
								<?php echo $rec['ef_description'];?>
								</td>
								<td><?php echo $rec['act_date'];?></td>
								<td><?php if($rec['act_class']!='0' AND $rec['act_class']!=''){echo $rec['act_class'];}else{echo '-';}?></td>
								<td><?php echo $rec['prior_t'];?></td>
								<td><?php echo $rec['nd_act'];?></td>
								<td><?php echo $rec['act_cn'];?></td>
								
						</tr>
						<?php endforeach;?>
					
				</table>
		
		</div>
				
		<script type="text/javascript">
		$(document).ready(function(){
			
			$('#home_btn').button().css({'background-color':'#CA5F5F', 'color':'#ffffff'});
			
			$('#record_tbl').DataTable({
				/* 	"lengthMenu": [ [10, 20, 50, 100000], [10, 20, 50, "All"] ],
					"processing":true,
					"serverSide":true,
					'serverMethod': 'post',
					"ajax":"<?php echo base_url();?>c_dts/get_export_page_data",
					
					'columns': [
						 { data: 'sel_box' },
						 { data: 'doc_no' },
						 { data: 'doc_description' },
						 { data: 'sender' },
						 { data: 'doc_date' },
						 { data: 'doc_subject' },
						 { data: 'rec_date' },
						 { data: 'div_sel' },
						 { data: 'ef_description' },
						 { data: 'act_date' },
						 { data: 'act_class' },
						 { data: 'prior_t' },
						 { data: 'nd_act' },
						 { data: 'act_cn' },
					 ], */
				
					"bLengthChange": true,
					"dom": 'rtip',
					"lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
					"language": {
					"sSearch": "Search Keywords:",
					"loadingRecords": "Please wait - loading...",
					"zeroRecords": "No records found",
					//"info": "Page _PAGE_ of _PAGES_",
					"infoEmpty": "No records available",
					"infoFiltered": "(filtered from _MAX_ total records)"
				},
				"columnDefs": [
					{
						orderable: false,
						className: 'select-checkbox',
						targets:   0
					},
					{
						"targets": [9,10,11,12,13],
						"visible": false,
						"searchable": false,
					},
					{ "width": "40%", "targets": 5 },
				],
				 select: {
					style: 'multi',
					selector: 'td:first-child'
				},
				buttons: [
					{
							extend: 'excelHtml5',
							text: 'Export Table',
							title: '',
							filename: 'Document Record',
							exportOptions: {
								modifier: {selected: true},
								columns: [1,2,3,4,5,6,7,8,9,10,11,12,13]
							},
							customize: function( xlsx ) {
								var sheet = xlsx.xl.worksheets['sheet1.xml'];
								var col = $('col', sheet);
								$(col[1]).attr('width', 20);
								$(col[7]).attr('width', 20);
								$('row c[r^="E"]', sheet).attr( 's', '55' );
								$('row:first c', sheet).attr( 's', '2' );
							}
							
					},
					{
						extend: 'print',
						orientation: 'Portrait',
						pageSize: 'A4',
						title: 'DOCUMENT LIST',
						filename: 'Document List',
						exportOptions: {
								modifier: {selected: true},
								columns: [1,2,3,4,5,6]
							},
						
					}
				]
				
			}).order( [ 2, 'asc' ] ).draw();
			
			var table = $('#record_tbl').DataTable();
			
			$("#selec_box").on( "click", function(e) {
				if ($(this).is( ":checked" )) {
					table.rows( {search: 'applied'} ).select();        
				} else {
					table.rows(  ).deselect(); 
					table.columns('').search('').draw();
				}
			});
			
			
			$('#t_foot').hide();
			$('#record_tbl tfoot th').each( function (i) {
					var title = $(this).text();

					if(title!=''){
						if(title=='Type' || title=='Status'){
							var select = $("<select style='height:30px' placeholder='"+title+"'><option value=''></option></select>")
						.appendTo( $(this).empty() )
						.on( 'change', function () {
							table.column( i )
								.search( $(this).val() )
								.draw();
						});
			 
						table.column( i ).data().unique().sort().each( function ( d, j ) {
							select.append( "<option value='"+d+"'>"+d+"</option>" )
						} );
								
							}
							else{$(this).html( '<input type="text" id="'+title+'" placeholder="'+title+'" data-index="'+i+'" />' );}
						}
					else{$(this).html( '<span></span>' );}
					
				
					$('#Document_Date').datepicker({dateFormat: "M-dd-yy"});
					$('#Date_Received').datepicker({dateFormat: "M-dd-yy"});
					$('#Status_Date').datepicker({dateFormat: "M-dd-yy"});
			});
			
			$('#col_srch').button().on('click', function(){
								
				if($('#t_foot').is(':hidden')){
					$('#t_foot').show('medium');
					$('#exp_btn, #gen_list').hide();
					$('#col_srch').text('Done Filtering');
					$('input[type="text"], select').each(function(){$(this).val('');});
					table.draw();
				}
				else{
					$('#t_foot').hide('medium');
					$('#exp_btn, #gen_list').show();
					$('#col_srch').text('Advance Filtering');
					 
					if(table.rows('.selected').data().length != 0){
						$.fn.dataTable.ext.search.push(
							function (settings, data, dataIndex){             
								return ($(table.row(dataIndex).node()).hasClass('selected')) ? true : false;
							}
						);
					}  
					table.columns('').search('').draw();
						
					$.fn.dataTable.ext.search.pop();
				}
				
					    
				
			});
			
			$('#exp_btn').button().on('click', function(){
					
				var sel_count= table.rows( '.selected' ).count()
				
					if(sel_count==0){
						$('#up_msg').html('<center><br><label style="color:#009999;"><b>No row(s) selected!</b></label></center>').dialog({
								title: 'Notification',
								resizable: false,
								width: 400,
								modal: true,
								open: function(event, ui) {
										//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
									},
						});
						//setTimeout(function() {$('#up_msg').dialog('close');}, 2000);
					}
					else{table.button( '.buttons-excel' ).trigger();}
				
			});
			
			$('#gen_list').button().on('click', function(){
					
				var sel_count= table.rows( '.selected' ).count()
				
					if(sel_count==0){
						$('#up_msg').html('<center><br><label style="color:#009999;"><b>No row(s) selected!</b></label></center>').dialog({
								title: 'Notification',
								resizable: false,
								width: 400,
								modal: true,
								open: function(event, ui) {
										//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
									},
						});
						//setTimeout(function() {$('#up_msg').dialog('close');}, 2000);
					}
					else{table.button( '.buttons-print' ).trigger();}
				
			});
			
			$( table.table().container() ).on( 'keyup change', 'tfoot input', function () {
				table
					.column( $(this).data('index') )
					.search( this.value )
					.draw();
			});
			
			
			
		});
	</script>