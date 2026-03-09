		
		
		<a href="<?php echo base_url();?>c_dts/report_pdf?rep_id=1&semestral=<?php echo $semestral;?>&rec_yr=<?php echo $rec_yr;?>" target="_blank" class="ui-button ui-corner-all ui-widget" style="float:right;font-weight:bold;margin-right:20px">Print</a>
		<br>
		<center><h2>DOCUMENT SUMMARY REPORT</center>
		<table class="report_table">
					
						<tr style="font-weight:bold">
							<td rowspan="2">Month</td>
							<td rowspan="2">No. of Documents Released</td>
							<td rowspan="2">No. of Documents Received</td>
							<td colspan="3">Level of Priority</td>
							<td colspan="<?php echo count($doc_type);?>">Document Type</td>
							<td colspan="5">Documents Preliminary Referral</td>
							<td colspan="5">Document Classification</td>
						</tr>
						<tr style="font-style:italic">
							<td>Low</td>
							<td>Normal</td>
							<td>High</td>
							<?php foreach($doc_type as $row):?>
								<td><?php echo $row['doc_description'];?></td>
							<?php endforeach;?>
							<td>MSD</td>
							<td>TSD</td>
							<td>EMB</td>
							<td>MGB</td>
							<td>PENR Officer Only</td>
							<td>Simple</td>
							<td>Complex</td>
							<td>Highly-Technical</td>
							<td>Legal Concern</td>
							<td>No Action Required</td>
						</tr>
						
						<?php 
							$subt = array();
						
							for($x=1;$x<=12;$x++):
							
							if($x<=6){$sem=1;}
							else{$sem=2;}
						?>
						<tr>
							<td style="text-align:left;width:180px"><?php echo date('F', mktime(0, 0, 0, $x, 10)); ;?></td>
							<td><?php $nod_rel = $controller->get_doc_released(date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_rel[0]['doc_count']); array_push($subt, array("sem"=>$sem,"nod_rel_".$sem=>$nod_rel[0]['doc_count']));?></td>
							<td>
							<?php 
							
								$nod_recv1 = $controller->get_doc_lop('Low',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
								$nod_recv2 = $controller->get_doc_lop('Normal',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
								$nod_recv3 = $controller->get_doc_lop('High',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); 
								
								echo number_format($nod_recv1[0]['doc_count']+$nod_recv2[0]['doc_count']+$nod_recv3[0]['doc_count']);
								
								array_push($subt, array("sem"=>$sem,"nod_recv_".$sem=>($nod_recv1[0]['doc_count']+$nod_recv2[0]['doc_count']+$nod_recv3[0]['doc_count'])));
							
							?>
							</td>
							
							<td><?php $nod_low = $controller->get_doc_lop('Low',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_low[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_low_".$sem=>$nod_low[0]['doc_count']));?></td>
							<td><?php $nod_norm = $controller->get_doc_lop('Normal',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_norm[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_norm_".$sem=>$nod_norm[0]['doc_count']));?></td>
							<td><?php $nod_high = $controller->get_doc_lop('High',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_high[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_high_".$sem=>$nod_high[0]['doc_count']));?></td>
							
							<?php foreach($doc_type as $row):?>
							<td><?php $nod_type = $controller->get_doc_types($row['dt_id'],date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_type[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_type_".$sem."_".$row['dt_id']=>$nod_type[0]['doc_count']));?></td>
							<?php endforeach;?>
							
							<td><?php $nod_msd = $controller->get_offdiv(2,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_msd[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_msd_".$sem=>$nod_msd[0]['doc_count']));?></td>
							<td><?php $nod_tsd = $controller->get_offdiv(3,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_tsd[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_tsd_".$sem=>$nod_tsd[0]['doc_count']));?></td>
							<td><?php $nod_emb = $controller->get_offdiv(5,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_emb[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_emb_".$sem=>$nod_emb[0]['doc_count']));?></td>
							<td><?php $nod_mgb = $controller->get_offdiv(4,date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_mgb[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_mgb_".$sem=>$nod_mgb[0]['doc_count']));?></td>
							<td><?php $nod_penro = $controller->get_penro_doc(date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_penro[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_penro_".$sem=>$nod_penro[0]['doc_count']));?></td>
							
							<td><?php $nod_simp = $controller->get_act_class('Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_simp[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_simp_".$sem=>$nod_simp[0]['doc_count']));?></td>
							<td><?php $nod_comp = $controller->get_act_class('Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_comp[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_comp_".$sem=>$nod_comp[0]['doc_count']));?></td>
							<td><?php $nod_hitech = $controller->get_act_class('Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_hitech[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_hitech_".$sem=>$nod_hitech[0]['doc_count']));?></td>
							<td><?php $nod_legcon = $controller->get_act_class('Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_legcon[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_legcon_".$sem=>$nod_legcon[0]['doc_count']));?></td>
							<td><?php $nod_noact = $controller->get_act_class_nar(date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec); echo number_format($nod_noact[0]['doc_count']);  array_push($subt, array("sem"=>$sem,"nod_noact_".$sem=>$nod_noact[0]['doc_count']));?></td>
							
						</tr>
						
						<?php if($x==6):?>
						<tr style="font-weight:bold;">
							<td style="text-align:left;width:180px">Sub-Total for 1st Semester</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_rel_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_recv_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_low_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_norm_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_high_1')));?></td>
							
							<?php foreach($doc_type as $row):?>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_type_1_'.$row['dt_id'])));?></td>
							<?php endforeach;?>
							
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_msd_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_tsd_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_emb_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_mgb_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_penro_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_simp_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_comp_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_hitech_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_legcon_1')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_noact_1')));?></td>
						</tr>
						<?php endif;?>
						
						<?php if($x==12):?>
						<tr style="font-weight:bold;">
							<td style="text-align:left;width:180px">Sub-Total for 2nd Semester</td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_rel_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_recv_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_low_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_norm_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_high_2')));?></td>
							
							<?php foreach($doc_type as $row):?>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_type_2_'.$row['dt_id'])));?></td>
							<?php endforeach;?>
							
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_msd_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_tsd_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_emb_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_mgb_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_penro_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_simp_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_comp_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_hitech_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_legcon_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_noact_2')));?></td>
						</tr>
						<tr style="font-weight:bold;">
							<td style="text-align:left;width:180px">Grand Total for CY <?php echo $rec_yr;?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_rel_1'))+array_sum(array_column($subt, 'nod_rel_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_recv_1'))+array_sum(array_column($subt, 'nod_recv_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_low_1'))+array_sum(array_column($subt, 'nod_low_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_norm_1'))+array_sum(array_column($subt, 'nod_norm_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_high_1'))+array_sum(array_column($subt, 'nod_high_2')));?></td>
							
							<?php foreach($doc_type as $row):?>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_type_1_'.$row['dt_id']))+array_sum(array_column($subt, 'nod_type_2_'.$row['dt_id'])));?></td>
							<?php endforeach;?>
							
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_msd_1'))+array_sum(array_column($subt, 'nod_msd_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_emb_1'))+array_sum(array_column($subt, 'nod_tsd_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_emb_1'))+array_sum(array_column($subt, 'nod_emb_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_mgb_1'))+array_sum(array_column($subt, 'nod_mgb_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_penro_1'))+array_sum(array_column($subt, 'nod_penro_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_simp_1'))+array_sum(array_column($subt, 'nod_simp_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_comp_1'))+array_sum(array_column($subt, 'nod_comp_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_hitech_1'))+array_sum(array_column($subt, 'nod_hitech_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_legcon_1'))+array_sum(array_column($subt, 'nod_legcon_2')));?></td>
							<td><?php echo number_format(array_sum(array_column($subt, 'nod_noact_1'))+array_sum(array_column($subt, 'nod_noact_2')));?></td>
						</tr>
						<?php endif;?>

						
						<?php endfor;?>
						
				</table>
				
