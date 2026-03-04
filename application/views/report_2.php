				

		<a href="<?php echo base_url();?>c_dts/report_pdf?rep_id=2&rec_yr=<?php echo $rec_yr;?>" target="_blank" class="ui-button ui-corner-all ui-widget" style="float:right;font-weight:bold;margin-right:20px">Print</a>
		<br>
		<center><h2>DOCUMENT REFERRED PER DIVISION</center>
		<table class="report_table">
					
						<tr style="font-weight:bold;">
							<td rowspan="2">Month</td>
							<td colspan="2">Preliminary Routing by PENRO</td>
							<td colspan="2">Routing by MSD</td>
							<td colspan="2">Routing by TSD</td>
						</tr>
						<tr>
							<td>No. of Documents Received</td>
							<td>Average No. of Hours</td>
							<td>No. of Documents Routed</td>
							<td>Average No. of Hours</td>
							<td>No. of Documents Routed</td>
							<td>Average No. of Hours</td>
							
						</tr>
						<?php
							$subt = array();
							
							for($x=1;$x<=12;$x++):
							
								if($x<=6){$sem=1;}
								else{$sem=2;}
						?>
						<tr>
							<td style="text-align:left;width:120px"><?php echo date('F', mktime(0, 0, 0, $x, 10)); ;?></td>
							
							
							<td><?php echo $penro_tdocs = number_format(count($controller->get_doc_recv(date('M', mktime(0, 0, 0, $x, 10)),$rec_yr))); array_push($subt, array("sem"=>$sem,"penro_tdocs_".$sem=>$penro_tdocs));?></td>
							<td>
									<?php 
											$total_no_hrs = 0;
											$doc_no_recv = $controller->get_doc_recv(date('M', mktime(0, 0, 0, $x, 10)),$rec_yr);
											foreach($doc_no_recv as $row){
												
												$doc_dt_penro = $controller->get_logs_penro($row['doc_no']);
											
												if(isset($doc_dt_penro[0]['e_dt']) AND isset($doc_dt_penro[1]['e_dt'])){
													$dur_diff = date_diff(date_create($doc_dt_penro[0]['e_dt']),date_create($doc_dt_penro[1]['e_dt']));
								
													$no_hrs = ((((int)$dur_diff->m*20)*8)+((int)$dur_diff->d*8))+(int)$dur_diff->h;
													$total_no_hrs += $no_hrs;
												}
											
												
											}
											
											if(count($doc_no_recv)!=0){
												echo $penro_tdocs_percent = number_format((int)$total_no_hrs/count($doc_no_recv),2);
												array_push($subt, array("sem"=>$sem,"penro_tdocs_percent_".$sem=>$penro_tdocs_percent));
												array_push($subt, array("sem"=>$sem,"no_rec_penro_".$sem=>1));
											}else{
												echo "0";
											}
											
									
									?>
							</td>
							
							
							<td><?php echo $msd_tdocs = number_format(count($controller->get_doc_div_recv(2,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr))); array_push($subt, array("sem"=>$sem,"msd_tdocs_".$sem=>$msd_tdocs));?></td>
							<td>
									<?php 
											$total_no_hrs = 0;
											$doc_no_div_recv = $controller->get_doc_div_recv(2,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr);
											foreach($doc_no_div_recv as $row){
												
												$doc_dt_div = $controller->get_logs_div($row['doc_no']);
											
												if(isset($doc_dt_div[0]['e_dt']) AND isset($doc_dt_div[1]['e_dt'])){
													$dur_diff = date_diff(date_create($doc_dt_div[0]['e_dt']),date_create($doc_dt_div[1]['e_dt']));
								
													$no_hrs = ((((int)$dur_diff->m*20)*8)+((int)$dur_diff->d*8))+(int)$dur_diff->h;
													$total_no_hrs += $no_hrs;
												}
											
												
											}
											
											if(count($doc_no_div_recv)!=0){
												echo $msd_tdocs_percent = number_format((int)$total_no_hrs/count($doc_no_div_recv),2);
												array_push($subt, array("sem"=>$sem,"msd_tdocs_percent_".$sem=>$msd_tdocs_percent));
												array_push($subt, array("sem"=>$sem,"no_rec_msd_".$sem=>1));
											}else{
												echo "0";
											}
											
									
									?>
							</td>
							
							
							<td><?php echo $tsd_tdocs = number_format(count($controller->get_doc_div_recv(3,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr))); array_push($subt, array("sem"=>$sem,"tsd_tdocs_".$sem=>$tsd_tdocs));?></td>
							<td>
									<?php 
											$total_no_hrs = 0;
											$doc_no_div_recv = $controller->get_doc_div_recv(3,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr);
											foreach($doc_no_div_recv as $row){
												
												$doc_dt_div = $controller->get_logs_div($row['doc_no']);
											
												if(isset($doc_dt_div[0]['e_dt']) AND isset($doc_dt_div[1]['e_dt'])){
													$dur_diff = date_diff(date_create($doc_dt_div[0]['e_dt']),date_create($doc_dt_div[1]['e_dt']));
								
													$no_hrs = ((((int)$dur_diff->m*20)*8)+((int)$dur_diff->d*8))+(int)$dur_diff->h;
													$total_no_hrs += $no_hrs;
												}
											
												
											}
											
											if(count($doc_no_div_recv)!=0){
												echo $tsd_tdocs_percent = number_format((int)$total_no_hrs/count($doc_no_div_recv),2);
												array_push($subt, array("sem"=>$sem,"tsd_tdocs_percent_".$sem=>$tsd_tdocs_percent));
												array_push($subt, array("sem"=>$sem,"no_rec_tsd_".$sem=>1));
											}else{
												echo "0";
											}
											
									
									?>
							</td>
							
						</tr>
						
						<?php 
						
							$no_rec_penro_1 = number_format(array_sum(array_column($subt, 'no_rec_penro_1')));
							$no_rec_msd_1 = number_format(array_sum(array_column($subt, 'no_rec_msd_1')));
							$no_rec_tsd_1 = number_format(array_sum(array_column($subt, 'no_rec_tsd_1')));
							
							$no_rec_penro_2 = number_format(array_sum(array_column($subt, 'no_rec_penro_2')));
							$no_rec_msd_2 = number_format(array_sum(array_column($subt, 'no_rec_msd_2')));
							$no_rec_tsd_2 = number_format(array_sum(array_column($subt, 'no_rec_tsd_2')));
							
						?>
						
						<?php if($x==6):?>
						<tr style="font-weight:bold;">
							<td style="text-align:left;">Sub-Total for 1st Semester</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'penro_tdocs_1')));?></td>
							<td><?php if($no_rec_penro_1!=0){echo number_format(array_sum(array_column($subt, 'penro_tdocs_percent_1'))/$no_rec_penro_1,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'msd_tdocs_1')));?></td>
							<td><?php if($no_rec_msd_1!=0){echo number_format(array_sum(array_column($subt, 'msd_tdocs_percent_1'))/$no_rec_msd_1,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'tsd_tdocs_1')));?></td>
							<td><?php if($no_rec_tsd_1!=0){echo number_format(array_sum(array_column($subt, 'tsd_tdocs_percent_1'))/$no_rec_tsd_1,2);}else{echo '0';}?></td>
						</tr>
						<?php endif;?>
						<?php if($x==12):?>
						<tr style="font-weight:bold;">
							<td style="text-align:left;">Sub-Total for 2nd Semester</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'penro_tdocs_2')));?></td>
							<td><?php if($no_rec_penro_2!=0){echo number_format(array_sum(array_column($subt, 'penro_tdocs_percent_2'))/$no_rec_penro_2,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'msd_tdocs_2')));?></td>
							<td><?php if($no_rec_msd_2!=0){echo number_format(array_sum(array_column($subt, 'msd_tdocs_percent_2'))/$no_rec_msd_2,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'tsd_tdocs_2')));?></td>
							<td><?php if($no_rec_tsd_2!=0){echo number_format(array_sum(array_column($subt, 'tsd_tdocs_percent_2'))/$no_rec_tsd_2,2);}else{echo '0';}?></td>
						</tr>
							<tr style="font-weight:bold;">
							<td style="text-align:left;">Grand Total for CY <?php echo $rec_yr;?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'penro_tdocs_1')));?></td>
							<td>
								<?php 
										if($no_rec_penro_1!=0){$penro_tdocs_percent_1 = array_sum(array_column($subt, 'penro_tdocs_percent_1'))/$no_rec_penro_1;}else{$penro_tdocs_percent_1 = 0;}
										if($no_rec_penro_2!=0){$penro_tdocs_percent_2 = array_sum(array_column($subt, 'penro_tdocs_percent_2'))/$no_rec_penro_2;}else{$penro_tdocs_percent_2 = 0;}
										
										echo number_format(($penro_tdocs_percent_1+$penro_tdocs_percent_2)/2,2);
								?>
							</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'msd_tdocs_1')));?></td>
							<td>
								<?php 
										if($no_rec_msd_1!=0){$msd_tdocs_percent_1 = array_sum(array_column($subt, 'msd_tdocs_percent_1'))/$no_rec_msd_1;}else{$msd_tdocs_percent_1 = 0;}
										if($no_rec_msd_2!=0){$msd_tdocs_percent_2 = array_sum(array_column($subt, 'msd_tdocs_percent_2'))/$no_rec_msd_2;}else{$msd_tdocs_percent_2 = 0;}
										
										echo number_format(($msd_tdocs_percent_1+$msd_tdocs_percent_2)/2,2);
								?>
							</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'tsd_tdocs_1')));?></td>
							<td>
								<?php 
										if($no_rec_tsd_1!=0){$tsd_tdocs_percent_1 = array_sum(array_column($subt, 'tsd_tdocs_percent_1'))/$no_rec_tsd_1;}else{$tsd_tdocs_percent_1 = 0;}
										if($no_rec_tsd_2!=0){$tsd_tdocs_percent_2 = array_sum(array_column($subt, 'tsd_tdocs_percent_2'))/$no_rec_tsd_2;}else{$tsd_tdocs_percent_2 = 0;}
										
										echo number_format(($tsd_tdocs_percent_1+$tsd_tdocs_percent_2)/2,2);
								?>
							</td>
						</tr>
						<?php endif;?>
						
						
						<?php endfor;?>
						
						
						
				</table>
				
	