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
	
	
	<?php if($this->session->userdata('valid') == true):?>	
	<div id="menu_pane">
				<?php date_default_timezone_set('Asia/Manila');?>
				<script>
				var d = new Date(<?php echo time() * 1000 ?>);
				function digitalClock() {
				  d.setTime(d.getTime() + 1000);
				  var hrs = d.getHours();
				  var mins = d.getMinutes();
				  var secs = d.getSeconds();
				  mins = (mins < 10 ? "0" : "") + mins;
				  secs = (secs < 10 ? "0" : "") + secs;
				  var apm = (hrs < 12) ? "AM" : "PM";
				  hrs = (hrs > 12) ? hrs - 12 : hrs;
				  hrs = (hrs == 0) ? 12 : hrs;
				  var ctime = hrs + ":" + mins + ":" + secs + " " + apm;
				  document.getElementById("clock").firstChild.nodeValue = ctime;
				}
				window.onload = function() {
				  digitalClock();
				  setInterval('digitalClock()', 1000);
				}
				</script>
				
					<div id="dt_cont">
						<div><?php echo date('M d, Y');?></div>
						<div id="clock"> </div>
					</div>
					
				<ul style="list-style:none;margin:0;padding:0;">

<?php if($this->session->userdata('role_log_id')!=6):?>
<li style="position:relative;">
    <a id="arec_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/record.png" alt="" title="Document Records"/>Document Records
    </a>
</li>
<?php endif;?>

<?php if($this->session->userdata('div_log_id')==1 OR $this->session->userdata('div_log_id')==26 OR strpos($this->session->userdata('div_log_alias'),'C-')!==false):?>
<li style="position:relative;">
    <a id="rt_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/route.png" alt="" title="For Routing"/>For Routing
    </a>
    <div id="4" class="doc_count"
         style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                background:red;color:white;font-size:12px;padding:2px 6px;
                border-radius:4px;border:1px solid white;min-width:18px;text-align:center;">
    </div>
</li>
<?php endif;?>

<?php if($this->session->userdata('div_log_id')==1):?>
<li style="position:relative;">
    <a id="return_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/return.png" alt="" title="Rerouted"/>Returned
    </a>
    <div id="5" class="doc_count"
         style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                background:red;color:white;font-size:12px;padding:2px 6px;
                border-radius:4px;border:1px solid white;min-width:18px;text-align:center;">
    </div>
</li>
<?php endif;?>

<?php if($this->session->userdata('div_log_id')!=1 AND $this->session->userdata('div_log_id')!=26 AND strpos($this->session->userdata('div_log_alias'),'C-')===false AND $this->session->userdata('role_log_id')!=6):?>
<li style="position:relative;">
    <a id="int_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/transit.png" alt="" title="In Transit"/>In Transit
    </a>
    <div id="1" class="doc_count"
         style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                background:red;color:white;font-size:12px;padding:2px 6px;
                border-radius:4px;border:1px solid white;min-width:18px;text-align:center;">
    </div>
</li>
<?php endif;?>

<?php if($this->session->userdata('div_log_id')!=1):?>
<li style="position:relative;">
    <a id="inp_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/progress.png" alt="" title="In Progess"/>In Progess
    </a>
    <div id="2" class="doc_count"
         style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                background:red;color:white;font-size:12px;padding:2px 6px;
                border-radius:4px;border:1px solid white;min-width:18px;text-align:center;">
    </div>
</li>
<?php endif;?>

<li style="position:relative;">
    <a id="actk_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/action.png" alt="" title="For Action"/>For Action
    </a>
    <div id="6" class="doc_count"
         style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                background:red;color:white;font-size:12px;padding:2px 6px;
                border-radius:4px;border:1px solid white;min-width:18px;text-align:center;">
    </div>
</li>

<?php if($this->session->userdata('role_log_id')!=6):?>
<li style="position:relative;">
    <a id="rcv_reg_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/record.png" alt="" title="RO In-transit Documents"/>RO In-transit Documents
    </a>
    <div id="7" class="doc_count"
         style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                background:red;color:white;font-size:12px;padding:2px 6px;
                border-radius:4px;border:1px solid white;min-width:18px;text-align:center;">
    </div>
</li>
<?php endif;?>

<?php if($this->session->userdata('role_log_id')!=6):?>
<li style="position:relative;">
    <a id="arc_btn" class="doc_cat" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/archive.png" alt="" title="Archived"/>Archived
    </a>
</li>

<li style="position:relative;">
    <a id="rep_btn" href="#">
        <img src="<?php echo base_url();?>ext_lib/images/icon/transit.png" alt="" title="Reports"/>Reports
    </a>
</li>
<?php endif;?>

</ul>

	</div>
	<?php endif;?>
	<div id="main_content">
				
				<input type="hidden" id="trigg" />
				
				
				<?php if($this->session->userdata('div_log_id')==1 OR $this->session->userdata('div_log_id')==26):?>	
					<input type="button" value="Add Document" id="add_btn" />
				<?php endif;?>
				
				
				<div id="add_record_modal"></div>
				<div id="modal_content"></div>
				
				<h1 id="title_tbl" style="color:#CA5F5F;font-family:arial;margin:20px 0px 10px 0px;text-align:center">Document Records</h1>
				
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
	
	
	
		
				<div id="notify_act">
				<center>
					<?php 
							echo '<h1>You have </h1>';
							echo '<h1 id="actdoc" style="margin:0px;color:red;font-size:70px"></h1>';
							echo '<h1><span style="color:red">"Waiting for Action"</span><br>Document(s)</h1>';
							?>
				</center>
				</div>
	
	
	
	</div>



	<script type="text/javascript">
	
	function get_count_rec(doc_cat){
		
		return	$.ajax({
				url:"<?php echo base_url(); ?>c_dts/get_count_rec",
				method:"POST",
				dataType: 'json',
				data:{'doc_cat': doc_cat},
				success: function(data) {
					
					//return data[0]['cnt'];
					
				}
			});
		
	}
	
	$(document).ready(function(){	
			
			var mc_height= $('#main_content').height();
			$('#menu_pane').css({'height':mc_height});
			$('.uploading_img, #notify_act').hide();
			$('#arec_btn').addClass("active");
			$('#trigg').val(0);
			
			$('.doc_count').each(function(){
				var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
				get_count_rec(ids).done(function(response){
					$('#'+ids).text(response[0]['cnt']);
				});
			});
			
			
			var act_doc_cnt=0;
			get_count_rec(6).done(function(response){
				act_doc_cnt = response[0]['cnt'];
				$('#actdoc').text(response[0]['cnt']);
				
				if(act_doc_cnt>0 && $(location).attr('href').indexOf("record_page#") < 0){
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
				}
				
			});
			
			
			
			
			
			
			
			
			var record_tbl = $('#record_tbl').DataTable({
				
					"bSortClasses": false,
					"processing":true,
					"serverSide":true,
					"ajax": {
						"url": "<?php echo base_url();?>c_dts/get_record_data",
						"type": "POST",
						"data": function (d) {
							return $.extend({},d,{
								"trigg":$('#trigg').val(),
							});
						}
					},
					
					'columns': [
						 { data: 'rec_id' },
						 { data: 'doc_no' },
						 { data: 'sender' },
						 { data: 'doc_date' },
						 { data: 'doc_subject' },
						 { data: 'rec_date' },
						 { data: 'act_class' },
						 //{ data: 'prior_t' },
						 { data: 'sec_id' },
						 { data: 'ef_description' },
						 { data: 'dt_recv' },
					 ],
					
					//"bLengthChange": true,
					"dom": '<"toolbar">rtip',
					//"dom": 'Bfrtip',
					//"lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
					"language": {
					"processing": '<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" id="load_img" style="height:70px;margin:0;mix-blend-mode:multiply" />',
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
			
			
			$('#record_tbl tbody').on('click', 'tr', function() {
				var idx = record_tbl.row(this).data();
									
					$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+idx['doc_no']+"").dialog({
							title: 'Record Preview',
							resizable: false,
							width: '90%',
							show: 'fade',
							hide: 'fade',
							modal: true,
							closeOnEscape: false,
							close: function() {
								
								$("#modal_content").empty();
								record_tbl.draw();
								//window.location.reload();
								
							},
							position: {
								my: 'center',
								at: 'top',
							},
										
					});
					
										
			});
			
			//$('#t_foot').hide();
			$('#record_tbl tfoot th').each( function (i) {
					var title = $(this).text();

					if(title!=''){
						if(title=='Referred_to'){
							
							var select = $("<select style='height:30px' id='sec_filter' name='sec_filter' placeholder='"+title+"' data-index='"+i+"'><option value=''>-select-</option></select>").appendTo( $(this).empty() )
								
								/*.on( 'change', function () {
									
									record_tbl
									.column( $(this).data('index')+1 )
									.search( this.value )
									.draw();
								}); */
									
					 
									$.ajax({
										url:"<?php echo base_url(); ?>c_dts/get_section_list",
										method:"POST",
										dataType: 'json',
										success: function(data) {
											
											
											
											for(var x=0;x<data.length;x++){
												select.append( "<option value='"+data[x]['sec_id']+"'>"+data[x]['sec_alias']+"</option>" );
											}
											
										}
									});
					 
								
							}
							else{
								$(this).html( '<input type="text" id="'+title+'" placeholder="'+title+'" data-index="'+i+'" />' );
								}
						}
					else{$(this).html( '<span></span>' );}
					
				
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
			
			$( record_tbl.table().container() ).on( 'keyup change', 'tfoot input, select', function () {
				
				record_tbl
					.column( $(this).data('index')+1 )
					.search( this.value )
					.draw();
			} );
			
			
			
			
			
			
			
			

			$("#frm_dia").dialog({
				autoOpen: false,
				title: 'Add Document',
				resizable: false,
				width: '45%',
				minHeight: 550,
				show: 'fade',
				hide: 'fade',
				modal: true,
				closeOnEscape: false,
				close: function() {
					record_tbl.draw();
				},
				position: {
					my: 'center',
					at: 'top',
				},
				open: function(event, ui) {
					//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
				}
			
			});
			
			
			$('#add_btn').button().on('click', function(e){
				$('.uploading_img').hide();
				$('#sub_btn').val('Upload');
				$('#doc_frm2').trigger('reset');
				
				
				$('#add_record_modal').load("<?php echo base_url();?>c_dts/add_doc").dialog({
							title: 'Add Document',
							resizable: false,
							minWidth: 600,
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
				
				
				//$('#frm_dia').dialog('open');
					
			}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
			
			
			$(document).on("click", ".doc_cat" , function(){
				
				var doc_btn = $('#'+$(this).attr('id'))['selector'].replace('#', '');
				var trigg=99;
				
				if(doc_btn=='arec_btn'){
					$('#trigg').val(0);
					$('#title_tbl').text("Document Records");
					$('.doc_cat').removeClass("active");
					$('#arec_btn').addClass("active");
				}else if(doc_btn=='int_btn'){
					$('#trigg').val(1);
					$('#title_tbl').text("In Transit Records");
					$('.doc_cat').removeClass("active");
					$('#int_btn').addClass("active");
				}else if(doc_btn=='inp_btn'){
					$('#trigg').val(2);
					$('#title_tbl').text("In Progress Records");
					$('.doc_cat').removeClass("active");
					$('#inp_btn').addClass("active");
				}else if(doc_btn=='arc_btn'){
					$('#trigg').val(3);
					$('#title_tbl').text("Archived Records");
					$('.doc_cat').removeClass("active");
					$('#arc_btn').addClass("active");
				}else if(doc_btn=='rt_btn'){
					$('#trigg').val(4);
					$('#title_tbl').text("For Routing Records");
					$('.doc_cat').removeClass("active");
					$('#rt_btn').addClass("active");
				}else if(doc_btn=='return_btn'){
					$('#trigg').val(5);
					$('#title_tbl').text("Returned Records");
					$('.doc_cat').removeClass("active");
					$('#return_btn').addClass("active");
				}else if(doc_btn=='actk_btn'){
					$('#trigg').val(6);
					$('#title_tbl').text("For Action Records");
					$('.doc_cat').removeClass("active");
					$('#actk_btn').addClass("active");
				}else if(doc_btn=='rcv_reg_btn'){
					$('#trigg').val(7);
					$('#title_tbl').text("RO In-transit Documents");
					$('.doc_cat').removeClass("active");
					$('#rcv_reg_btn').addClass("active");
				}
				
				
				
				record_tbl.draw();
				
				
			});
			
			
			
			
	
			$(document).on("click", "#rep_btn" , function(){
				$(location).attr('href',"<?php echo base_url();?>c_dts/report_page");
			});
		/*				
			var uri = window.location.toString();
			if (uri.indexOf("?") > 0) {
					var clean_uri = uri.substring(0, uri.indexOf("?"));
					window.history.replaceState({}, document.title, clean_uri);
			}	
		*/			
		
		
		
		
		
		
		
		
			
	});
	</script>
	<style>
		div.dataTables_wrapper div.dataTables_processing {
		   top: 5%;
		}
	</style>

		
			
</body>
</html>