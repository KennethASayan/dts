			
				
				
						
				<?php if($this->session->userdata('div_log_id')==1 OR $this->session->userdata('div_log_id')==26):?>	
					<input type="button" value="Add Document" id="add_btn" />
				<?php endif;?>
				
				<?php if($trigg==99 AND $act_doc_cnt[0]['cnt']!=0):?>
				<div id="notify_act">
				<center>
					<?php 
							echo '<h1>You have </h1>';
							echo '<h1 style="margin:0px;color:red;font-size:70px">'.$actdocs[0]['cnt'].'</h1>';
							echo '<h1><span style="color:red">"Waiting for Action"</span><br>Document(s)</h1>';
							?>
				</center>
				</div>
				<?php endif;?>
				
				<div id="modal_content"></div>
				
				<h1 id="title_tbl" style="color:#CA5F5F;font-family:arial;margin:20px 0px 10px 0px;text-align:center">
					<?php 
							if($trigg==0 OR $trigg==99){echo "Document Records";}
							elseif($trigg==1){echo "In Transit Documents";}
							elseif($trigg==2){echo "In Progress Documents";}
							elseif($trigg==3){echo "Archived Documents";}
							elseif($trigg==4){echo "For Routing Documents";}
							elseif($trigg==5){echo "Re-routed Documents";}
							elseif($trigg==6){echo "For Action Documents";}
					
					?>
				</h1>
				<table id="record_tbl" class="display" cellspacing="0" data-page-length='20'>
				
					<thead style="text-align:center">
						<tr>
								<th>rec_id</th>
								<th>Document_No.</th>
								<th>Sender/Recipient</th>
								<th>Document_Date</th>
								<th>Subject</th>
								<th>Date_Received</th>
								<th>Class</th>
								<!--<th>Priority</th>-->
							
								<th>Referred_to</th>
								<th>Status</th>
								<th>Time in Progress</th>
								<!--<th>Date</th>-->
						</tr>
					</thead>
					<tfoot id="t_foot" style="text-align:left;">
						<tr>
								<th>rec_id</th>
								<th>Document_No.</th>
								<th>Sender/Recipient</th>
								<th>Document_Date</th>
								<th>Subject</th>
								<th>Date_Received</th>
								<th>Class</th>
								<!--<th>Priority</th>-->
								
								<th>Referred_to</th>
								<th>Status</th>
								<th>Time in Progress</th>
								<!--<th>Date</th>-->
						</tr>
					</tfoot>
				
				</table>
				
				
								
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#home_btn').button().css({'background-color':'#CA5F5F', 'color':'#ffffff'});
			
			<?php if($trigg==99 AND $act_doc_cnt[0]['cnt']!=0):?>
			 $('#notify_act').dialog({
					title: 'Notification',
					resizable: false,
					width: '30%',
					show: 'fade',
					hide: 'fade',
					modal: true,
					closeOnEscape: false,
					//close: function() {window.location.reload();},
					position: {
						my: 'center',
						at: 'center',
					},
					open: function(event, ui) {
						//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
					}
			});
			<?php endif;?>
			
			<?php if($trigg==0):?>$('#arec_btn').addClass("active");
			<?php elseif($trigg==1):?>$('#int_btn').addClass("active");
			<?php elseif($trigg==2):?>$('#inp_btn').addClass("active");
			<?php elseif($trigg==3):?>$('#arc_btn').addClass("active");
			<?php elseif($trigg==4):?>$('#rt_btn').addClass("active");
			<?php elseif($trigg==5):?>$('#return_btn').addClass("active");
			<?php elseif($trigg==6):?>$('#actk_btn').addClass("active");
			<?php endif;?>
			
			$('#add_btn').button().on('click', function(e){
					
					$('#modal_content').load("<?php echo base_url();?>c_dts/add_doc").dialog({
							title: 'Add Document',
							resizable: false,
							width: '45%',
							minHeight: 550,
							show: 'fade',
							hide: 'fade',
							modal: true,
							closeOnEscape: false,
							//close: function() {window.location.reload();},
							position: {
								my: 'center',
								at: 'top',
							},
							open: function(event, ui) {
								//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
							}
					});
			}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
			
			
			
			var record_tbl = $('#record_tbl').DataTable({
				
					"processing":true,
					"serverSide":true,
					'serverMethod': 'post',
					"ajax":"<?php echo base_url();?>c_dts/get_record_data?trigg=<?php echo $trigg;?>",
					
					'columns': [
						 { data: 'rec_id' },
						 { data: 'doc_no' },
						 { data: 'sender' },
						 { data: 'doc_date' },
						 { data: 'doc_subject' },
						 { data: 'rec_date' },
						 { data: 'act_class' },
						 //{ data: 'prior_t' },
						 { data: 'section' },
						 { data: 'ef_description' },
						 { data: 'dt_recv' },
					 ],
					
					//"bLengthChange": true,
					"dom": '<"toolbar">rtip',
					//"dom": 'Bfrtip',
					//"lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
					"language": {
					"processing": "Loading Data...",
					"sSearch": "Search Keywords:",
					"loadingRecords": "Please wait - loading...",
					"lengthMenu": "Display _MENU_ Records",
					"zeroRecords": "No records found",
					"infoEmpty": "No records available",
					"infoFiltered": "(filtered from _MAX_ total records)"
				},
				"columnDefs": [
					
					{ "width": "40%", "targets": 4 },
					{
						"targets": [0],
						"visible": false,
						"searchable": false
					},
					
				],
				/* buttons: [
					'excel', 'pdf', 'print'
				] */
				
			}).order( [ 0, 'desc' ] ).draw();
			//$('div.toolbar').html('Note: <i>**<span style="color:red;font-weight:bold;">"Click"</span> table row to view record information**</i>');
			
			var table = $('#record_tbl').DataTable();
			$('#record_tbl tbody').on('click', 'tr', function() {
				var idx = table.row(this).data();
									
					$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+idx['doc_no']+"").dialog({
										title: 'Record Preview',
										resizable: false,
										width: '90%',
										show: 'fade',
										hide: 'fade',
										modal: true,
										closeOnEscape: false,
										//close: function() {window.location.reload();},
										position: {
											my: 'center',
											at: 'top',
										},
										
										
					});
					
										
			});
			
			//$('#t_foot').hide();
			$('#record_tbl tfoot th').each( function (i) {
					var title = $(this).text();

					/* if(title!=''){
						if(title=='Type' || title=='Priority' || title=='Status'){
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
							else{ */
								$(this).html( '<input type="text" id="'+title+'" placeholder="'+title+'" data-index="'+i+'" />' );
							/* 	}
						}
					else{$(this).html( '<span></span>' );} */
					
				
					$('#Document_Date').datepicker({dateFormat: "M-dd-yy"});
					$('#Date_Received').datepicker({dateFormat: "M-dd-yy"});
					$('#Date').datepicker({dateFormat: "M-dd-yy"});
	
			});
			$('#col_srch').button().on('click', function(){
						
				if($('#t_foot').is(':hidden')){
					$('#t_foot').show('medium');
					$('#col_srch').text('Hide Column Search');
				}
				else{
					$('#t_foot').hide('medium');
					$('#col_srch').text('Show Column Search');
				}
				
			});
			
			$( table.table().container() ).on( 'keyup change', 'tfoot input', function () {
				table
					.column( $(this).data('index')+1 )
					.search( this.value )
					.draw();
			} );
			
			
		});
	</script>