						
						
						
		<a href="<?php echo base_url();?>c_dts/report_pdf?rep_id=4&semestral=<?php echo $semestral;?>&rec_yr=<?php echo $rec_yr;?>" target="_blank" class="ui-button ui-corner-all ui-widget" style="float:right;font-weight:bold;margin-right:20px">Print</a>
		<br>
		<center><h2>DOCUMENT ACTED PER CATEGORY</center>
		<table class="report_table">
					
						<tr style="font-weight:bold">
							<td rowspan="2">Month</td>
							<td rowspan="2">No. of Documents Acted</td>
							<td colspan="2">Simple</td>
							<td colspan="2">Complex</td>
							<td colspan="2">Highly Technical</td>
							<td colspan="2">Legal Concern</td>
						</tr>
						<tr style="font-style:italic">
							<td>No. of Documents</td>
							<td>Average No. of Days</td>
							<td>No. of Documents</td>
							<td>Average No. of Days</td>
							<td>No. of Documents</td>
							<td>Average No. of Days</td>
							<td>No. of Documents</td>
							<td>Average No. of Days</td>
						</tr>
						
						<?php 
							$subt = array();
						
							for($x=1;$x<=12;$x++):
							
							if($x<=6){$sem=1;}
							else{$sem=2;}
						?>
						<tr>
							<td style="text-align:left;width:180px"><?php echo date('F', mktime(0, 0, 0, $x, 10)); ;?></td>
							<td>
							<?php  
							
								$nod_act1 = $controller->get_act_class('Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
								$nod_act2 = $controller->get_act_class('Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
								$nod_act3 = $controller->get_act_class('Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); 
								
								echo number_format($nod_act1[0]['doc_count']+$nod_act2[0]['doc_count']+$nod_act3[0]['doc_count']);
								
								array_push($subt, array("sem"=>$sem,"nod_act_".$sem=>$nod_act1[0]['doc_count']+$nod_act2[0]['doc_count']+$nod_act3[0]['doc_count']));
							
							?>
							</td>
							
							<td><?php $nod_simp = $controller->get_act_class('Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);  echo number_format($nod_simp[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_simp_".$sem=>$nod_simp[0]['doc_count']));?></td>
							<td>
								<?php 
									$doc_total_hrs = 0;
									$doc_noh = $controller->get_doc_noh('Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_noh as $dur){
										
										$exp_dur = explode(" ", $dur['nd_act']);
										if(!empty($exp_dur[1])){
											if(strpos($exp_dur[1],'month')!==false){
												$doc_no_hrs = ((int)$exp_dur[0]*20)*8;
											}
											elseif(strpos($exp_dur[1],'day')!==false){
												$doc_no_hrs = (int)$exp_dur[0]*8;
											}
											elseif(strpos($exp_dur[1],'hr')!==false){
												$doc_no_hrs = (int)$exp_dur[0];
											}
											else{
												$doc_no_hrs = 0;
											}
											
											/* if($doc_no_hrs>23){
												$deduc = $doc_no_hrs-23.7;
												$doc_no_hrs = $doc_no_hrs-$deduc;
											} */
											
											$doc_total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_noh)!=0){
										//$doc_total_hrs=$doc_total_hrs/8;
										echo number_format(($doc_total_hrs/count($doc_noh))/8,2);
										array_push($subt, array("sem"=>$sem,"ave_noh_simp_".$sem=>number_format($doc_total_hrs/count($doc_noh),2)));
										array_push($subt, array("sem"=>$sem,"no_rec_simp_".$sem=>1));
									}else{
										echo "0";
									}
									
								?>
							</td>
							<td><?php $nod_comp = $controller->get_act_class('Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);  echo number_format($nod_comp[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_comp_".$sem=>$nod_comp[0]['doc_count']));?></td>
							<td>
								<?php 
									$doc_total_hrs = 0;
									$doc_noh = $controller->get_doc_noh('Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_noh as $dur){
										
										$exp_dur = explode(" ", $dur['nd_act']);
										if(!empty($exp_dur[1])){	
											if(strpos($exp_dur[1],'month')!==false){
												$doc_no_hrs = ((int)$exp_dur[0]*20)*8;
											}
											elseif(strpos($exp_dur[1],'day')!==false){
												$doc_no_hrs = (int)$exp_dur[0]*8;
											}
											elseif(strpos($exp_dur[1],'hr')!==false){
												$doc_no_hrs = (int)$exp_dur[0];
											}
											else{
												$doc_no_hrs = 0;
											}
											
											/* if($doc_no_hrs>55){
												$deduc = $doc_no_hrs-50.5;
												$doc_no_hrs = $doc_no_hrs-$deduc;
											} */
											
											$doc_total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_noh)!=0){
										//$doc_total_hrs=$doc_total_hrs/8;
										echo number_format(($doc_total_hrs/count($doc_noh))/8,2);
										array_push($subt, array("sem"=>$sem,"ave_noh_comp_".$sem=>number_format($doc_total_hrs/count($doc_noh),2)));
										array_push($subt, array("sem"=>$sem,"no_rec_comp_".$sem=>1));
									}else{
										echo "0";
									}
									
								?>
							</td>
							<td><?php $nod_hitech = $controller->get_act_class('Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);  echo number_format($nod_hitech[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_hitech_".$sem=>$nod_hitech[0]['doc_count']));?></td>
							<td>
								<?php 
									$doc_total_hrs = 0;
									$doc_noh = $controller->get_doc_noh('Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_noh as $dur){
										
										$exp_dur = explode(" ", $dur['nd_act']);
										if(!empty($exp_dur[1])){	
											if(strpos($exp_dur[1],'month')!==false){
												$doc_no_hrs = ((int)$exp_dur[0]*20)*8;
											}
											elseif(strpos($exp_dur[1],'day')!==false){
												$doc_no_hrs = (int)$exp_dur[0]*8;
											}
											elseif(strpos($exp_dur[1],'hr')!==false){
												$doc_no_hrs = (int)$exp_dur[0];
											}
											else{
												$doc_no_hrs = 0;
											}
											$doc_total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_noh)!=0){
										//$doc_total_hrs=$doc_total_hrs/8;
										echo number_format(($doc_total_hrs/count($doc_noh))/8,2);
										array_push($subt, array("sem"=>$sem,"ave_noh_hitech_".$sem=>number_format($doc_total_hrs/count($doc_noh),2)));
										array_push($subt, array("sem"=>$sem,"no_rec_hitech_".$sem=>1));
									}else{
										echo "0";
									}
									
								?>
							</td>
							<td><?php $nod_legcon = $controller->get_act_class('Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);  echo number_format($nod_legcon[0]['doc_count']); array_push($subt, array("sem"=>$sem,"nod_legcon_".$sem=>$nod_legcon[0]['doc_count']));?></td>
							<td>
								<?php 
									$doc_total_hrs = 0;
									$doc_noh = $controller->get_doc_noh('Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_noh as $dur){
										
										$exp_dur = explode(" ", $dur['nd_act']);
										if(!empty($exp_dur[1])){	
											if(strpos($exp_dur[1],'month')!==false){
												$doc_no_hrs = ((int)$exp_dur[0]*20)*8;
											}
											elseif(strpos($exp_dur[1],'day')!==false){
												$doc_no_hrs = (int)$exp_dur[0]*8;
											}
											elseif(strpos($exp_dur[1],'hr')!==false){
												$doc_no_hrs = (int)$exp_dur[0];
											}
											else{
												$doc_no_hrs = 0;
											}
											$doc_total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_noh)!=0){
										//$doc_total_hrs=$doc_total_hrs/8;
										echo number_format(($doc_total_hrs/count($doc_noh))/8,2);
										array_push($subt, array("sem"=>$sem,"ave_noh_legcon_".$sem=>number_format($doc_total_hrs/count($doc_noh),2)));
										array_push($subt, array("sem"=>$sem,"no_rec_legcon_".$sem=>1));
									}else{
										echo "0";
									}
									
								?>
							</td>
						</tr>
						
						
						<?php 
						
							$no_rec_simp_1 = number_format(array_sum(array_column($subt, 'no_rec_simp_1')));
							$no_rec_comp_1 = number_format(array_sum(array_column($subt, 'no_rec_comp_1')));
							$no_rec_hitech_1 = number_format(array_sum(array_column($subt, 'no_rec_hitech_1')));
							$no_rec_legcon_1 = number_format(array_sum(array_column($subt, 'no_rec_legcon_1')));
							
							$no_rec_simp_2 = number_format(array_sum(array_column($subt, 'no_rec_simp_2')));
							$no_rec_comp_2 = number_format(array_sum(array_column($subt, 'no_rec_comp_2')));
							$no_rec_hitech_2 = number_format(array_sum(array_column($subt, 'no_rec_hitech_2')));
							$no_rec_legcon_2 = number_format(array_sum(array_column($subt, 'no_rec_legcon_2')));
							
						?>
						
						
						<?php if($x==6):?>
						<tr style="font-weight:bold;">
							<td style="text-align:left;width:180px">Sub-Total for 1st Semester</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_act_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_simp_1')));?></td>
							<td><?php if($no_rec_simp_1!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_simp_1'))/$no_rec_simp_1)/8,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_comp_1')));?></td>
							<td><?php if($no_rec_comp_1!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_comp_1'))/$no_rec_comp_1)/8,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_hitech_1')));?></td>
							<td><?php if($no_rec_hitech_1!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_hitech_1'))/$no_rec_hitech_1)/8,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_legcon_1')));?></td>
							<td><?php if($no_rec_legcon_1!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_legcon_1'))/$no_rec_legcon_1)/8,2);}else{echo '0';}?></td>
						</tr>
						<?php endif;?>
						
						<?php if($x==12):?>
						<tr style="font-weight:bold;">
							<td style="text-align:left;width:180px">Sub-Total for 2nd Semester</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_act_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_simp_2')));?></td>
							<td><?php if($no_rec_simp_2!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_simp_2'))/$no_rec_simp_2)/8,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_comp_2')));?></td>
							<td><?php if($no_rec_comp_2!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_comp_2'))/$no_rec_comp_2)/8,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_hitech_2')));?></td>
							<td><?php if($no_rec_hitech_2!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_hitech_2'))/$no_rec_hitech_2)/8,2);}else{echo '0';}?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_legcon_2')));?></td>
							<td><?php if($no_rec_legcon_2!=0){echo number_format((array_sum(array_column($subt, 'ave_noh_legcon_2'))/$no_rec_legcon_2)/8,2);}else{echo '0';}?></td>
						</tr>
						<tr style="font-weight:bold;">
							<td style="text-align:left;width:180px">Grand Total for CY <?php echo $rec_yr;?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_act_1'))+array_sum(array_column($subt, 'nod_act_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_simp_1'))+array_sum(array_column($subt, 'nod_simp_2')));?></td>
							<td>
								<?php 
										if($no_rec_simp_1!=0){$ave_noh_simp_1 = array_sum(array_column($subt, 'ave_noh_simp_1'))/$no_rec_simp_1;}else{$ave_noh_simp_1 = 0;}
										if($no_rec_simp_2!=0){$ave_noh_simp_2 = array_sum(array_column($subt, 'ave_noh_simp_2'))/$no_rec_simp_2;}else{$ave_noh_simp_2 = 0;}
										
										if($no_rec_simp_2!=0){echo number_format((($ave_noh_simp_1+$ave_noh_simp_2)/2)/8,2);}
										else{echo number_format($ave_noh_simp_1/8,2);}
								?>
							</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_comp_1'))+array_sum(array_column($subt, 'nod_comp_2')));?></td>
							<td>
								<?php 
										if($no_rec_comp_1!=0){$ave_noh_comp_1 = array_sum(array_column($subt, 'ave_noh_comp_1'))/$no_rec_comp_1;}else{$ave_noh_comp_1 = 0;}
										if($no_rec_comp_2!=0){$ave_noh_comp_2 = array_sum(array_column($subt, 'ave_noh_comp_2'))/$no_rec_comp_2;}else{$ave_noh_comp_2 = 0;}
										
										if($no_rec_comp_2!=0){echo number_format((($ave_noh_comp_1+$ave_noh_comp_2)/2)/8,2);}
										else{echo number_format($ave_noh_comp_1/8,2);}
								?>
							</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_hitech_1'))+array_sum(array_column($subt, 'nod_hitech_2')));?></td>
							<td>
								<?php 
										if($no_rec_hitech_1!=0){$ave_noh_hitech_1 = array_sum(array_column($subt, 'ave_noh_hitech_1'))/$no_rec_hitech_1;}else{$ave_noh_hitech_1 = 0;}
										if($no_rec_hitech_2!=0){$ave_noh_hitech_2 = array_sum(array_column($subt, 'ave_noh_hitech_2'))/$no_rec_hitech_2;}else{$ave_noh_hitech_2 = 0;}
										
										if($ave_noh_hitech_2!=0){echo number_format((($ave_noh_hitech_1+$ave_noh_hitech_2)/2)/8,2);}
										else{echo number_format($ave_noh_hitech_1/8,2);}
										
								?>
							</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_legcon_1'))+array_sum(array_column($subt, 'nod_legcon_2')));?></td>
							<td>
								<?php 
										if($no_rec_legcon_1!=0){$ave_noh_legcon_1 = array_sum(array_column($subt, 'ave_noh_legcon_1'))/$no_rec_legcon_1;}else{$ave_noh_legcon_1 = 0;}
										if($no_rec_legcon_2!=0){$ave_noh_legcon_2 = array_sum(array_column($subt, 'ave_noh_legcon_2'))/$no_rec_legcon_2;}else{$ave_noh_legcon_2 = 0;}
										
										if($ave_noh_legcon_2!=0){echo number_format((($ave_noh_legcon_1+$ave_noh_legcon_2)/2)/8,2);}
										else{echo number_format($ave_noh_legcon_1/8,2);}
										
								?>
							</td>
						</tr>
						<?php endif;?>

						
						<?php endfor;?>
						
				</table>
								
	