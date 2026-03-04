						
						
							
		<a href="<?php echo base_url();?>c_dts/report_pdf?rep_id=5&semestral=<?php echo $semestral;?>&rec_yr=<?php echo $rec_yr;?>" target="_blank" class="ui-button ui-corner-all ui-widget" style="float:right;font-weight:bold;margin-right:20px">Print</a>
		<br>
		<center><h2>CENTRALIZED UPLOADING OF INCOMING DOCUMENTS</h2></center>
		<?php echo $this->session->flashdata('start_rec_id');?>
		<table class="report_table">
					
						<tr style="font-weight:bold">
						
						<?php for($x=1;$x<=12;$x++): ?>
						
							<td><?php echo date('F', mktime(0, 0, 0, $x, 10));?><br><i style="font-weight:normal">(hrs:mins)</i></td>
							<?php if($x==6):?>
								<td>1st Semester Average</td>
							<?php endif;?>
							<?php if($x==12):?>
								<td>2nd Semester Average</td>
							<?php endif;?>
							
							
						<?php endfor;?>
						</tr>
						
						
						<tr>
						<?php 
						$subt = array();
						
						for($y=1;$y<=12;$y++):
						
							if($y<=6){$sem=1;}
							else{$sem=2;}
						?>
								<td>
									<?php 
									
										$total_mins=0;
										$ave_mins=0;
										$q1=0;$q2=0;
										
										$docs = $controller->get_docs(date('M', mktime(0, 0, 0, $y, 10)),$rec_yr); 
										
										foreach($docs as $row){
											
											
											$dt_stamp = $row['doc_date_rr']." ".$row['doc_time_rr'];
											$dt_upload = $row['rec_date']." ".$row['rec_time'];
											
											$dur_diff = date_diff(date_create($dt_stamp),date_create($dt_upload));
											$no_mins = (((((int)$dur_diff->m*20)*24)*60)+(((int)$dur_diff->d*24)*60))+((int)$dur_diff->h*60)+(int)$dur_diff->i;
											
											
											//echo $row['doc_no']." = ".$no_mins."<br>";
											
											
											$total_mins+=$no_mins;
											
											
										}										
										
										
											if(count($docs)!=0){
												$ave_mins=$total_mins/count($docs);	
												echo sprintf('%02d', $ave_mins/60).":".sprintf('%02d', $ave_mins%60);
												
												array_push($subt, array("sem"=>$sem,"total_mins_".$sem=>$ave_mins,"cnt_".$sem=>1,));
											}
										
										
									?>
								</td>
								<?php if($y==6):?>
									<td><?php if(array_sum(array_column($subt, 'cnt_1'))!=0){$q1 = array_sum(array_column($subt, 'total_mins_1'))/array_sum(array_column($subt, 'cnt_1')); echo sprintf('%02d', $q1/60).":".sprintf('%02d', $q1%60);}?></td>
								<?php endif;?>
								<?php if($y==12):?>
									<td><?php if(array_sum(array_column($subt, 'cnt_2'))!=0){$q2 = array_sum(array_column($subt, 'total_mins_2'))/array_sum(array_column($subt, 'cnt_2')); echo sprintf('%02d', $q2/60).":".sprintf('%02d', $q2%60);}?></td>
								<?php endif;?>
						<?php endfor;?>
						</tr>
				</table>
								
	