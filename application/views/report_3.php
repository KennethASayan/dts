		
		<a href="<?php echo base_url();?>c_dts/report_pdf?rep_id=3&semestral=<?php echo $semestral;?>&rec_yr=<?php echo $rec_yr;?>" target="_blank" class="ui-button ui-corner-all ui-widget" style="float:right;font-weight:bold;margin-right:20px">Print</a>
		<br>
		<center><h2>DOCUMENT RECEIVED/ACTED PER SECTION</center>
		<?php
			$subt = array();
			$subt_uni = array();
			
			$mstart=0;$mend=0;
			if($semestral==1){
				$mstart=1;
				$mend=6;
			}else{
				$mstart=7;
				$mend=12;
			}
			
			for($x=$mstart;$x<=$mend;$x++):
			
			if($x<=6){$sem=1;}
			else{$sem=2;}
		?>
		<?php $subt_m_simp=0;$subt_m_simp_c=0;$subt_m_ut=0;$subt_m_nar=0;$subt_m_df=0;$subt_m_pda=0;$subt_m_pda_c=0;$subt_m_pda_simp=0;$subt_m_pda_simp_c=0;$subt_m_pda_comp=0;$subt_m_pda_comp_c=0;$subt_m_pda_hitech=0;$subt_m_pda_hitech_c=0;$subt_m_pda_legcon=0;$subt_m_pda_legcon_c=0;?>
				
				<h3><?php echo date('F', mktime(0, 0, 0, $x, 10)).' '.$rec_yr ;?></h3>
				<table class="report_table">
					<tr>
						<td><b>TYPE OF DOCUMENT</b></td>
						
						<?php foreach($off_sec as $row):?>
							<td><b><?php echo $row['sec_alias'];?></b></td>
						<?php endforeach;?>
							<td><b>TOTAL</b></td>
					</tr>
					
					
					<tr>
						<td style="text-align:left;width:180px">Total No. of Document Referral</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_sec_ref = $controller->get_doc_sec_ref($row['sec_id'],date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									if(count($doc_sec_ref)!=0){
										echo count($doc_sec_ref);
										$subt_m_df+=count($doc_sec_ref);
									}else{
										echo "-";
									}
									array_push($subt, array("sem"=>$sem,"docref_no_".$row['sec_alias'].$sem=>count($doc_sec_ref)));
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php echo $subt_m_df;?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Simple (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_total_hrs = 0;
									
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									
									if(count($doc_sec)!=0){
										
										echo count($doc_sec);
										$total_docs+=count($doc_sec);
										
									}else{
										echo "-";
									}
									array_push($subt_uni, array("sem"=>$sem,"simp_no_".$row['sec_alias'].$sem=>count($doc_sec)));
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "0";}?>
							</td>
						
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Simple Acted (No.)(Ave. Days)</td>
						
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_total_hrs = 0;
									
									$doc_sec = $controller->get_doc_sec($row['sec_id'],'Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_sec as $dur){
										
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
											$total_hrs+=$doc_no_hrs;
											
										}
									}
									
									if(count($doc_sec)!=0){
										echo "(".count($doc_sec).") (".number_format(($doc_total_hrs/count($doc_sec))/8,2).")";
										
										$total_docs+=count($doc_sec);
										//$subt_m_simp+= number_format($doc_total_hrs/count($doc_sec),2);
										//$subt_m_simp_c++;
									}else{
										echo "-";
									}
									array_push($subt, array("sem"=>$sem,"simp_no_".$row['sec_alias'].$sem=>count($doc_sec),"simp_hrs_".$row['sec_alias'].$sem=>$doc_total_hrs));
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "0";}?>
							</td>
						
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Complex (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_total_hrs = 0;
									
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									
									if(count($doc_sec)!=0){
										
										echo count($doc_sec);
										$total_docs+=count($doc_sec);
										
									}else{
										echo "-";
									}
									
									array_push($subt_uni, array("sem"=>$sem,"comp_no_".$row['sec_alias'].$sem=>count($doc_sec)));
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "0";}?>
							</td>
						
					</tr>
												
					<tr>
						<td style="text-align:left;width:180px">Complex Acted (No.)(Ave. Days)</td>
						
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_total_hrs = 0;
									$doc_sec = $controller->get_doc_sec($row['sec_id'],'Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_sec as $dur){
										
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
											$total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_sec)!=0){
										echo "(".count($doc_sec).") (".number_format(($doc_total_hrs/count($doc_sec))/8,2).")";
										
										$total_docs+=count($doc_sec);
									}else{
										echo "-";
									}
									array_push($subt, array("sem"=>$sem,"comp_no_".$row['sec_alias'].$sem=>count($doc_sec),"comp_hrs_".$row['sec_alias'].$sem=>$doc_total_hrs));
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "0";}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Highly Technical (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_total_hrs = 0;
									
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									
									if(count($doc_sec)!=0){
										
										echo count($doc_sec);
										$total_docs+=count($doc_sec);
										
									}else{
										echo "-";
									}
									
									array_push($subt_uni, array("sem"=>$sem,"hitech_no_".$row['sec_alias'].$sem=>count($doc_sec)));
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "0";}?>
							</td>
						
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Legal Concern (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_total_hrs = 0;
									
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									
									if(count($doc_sec)!=0){
										
										echo count($doc_sec);
										$total_docs+=count($doc_sec);
										
									}else{
										echo "-";
									}
									
									array_push($subt_uni, array("sem"=>$sem,"legcon_no_".$row['sec_alias'].$sem=>count($doc_sec)));
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "0";}?>
							</td>
						
					</tr>
												








						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
						
								<?php 
									$doc_total_hrs = 0;
									$doc_sec = $controller->get_doc_sec($row['sec_id'],'Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_sec as $dur){
										
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
											$total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_sec)!=0){
										//echo "(".count($doc_sec).") (".number_format(($doc_total_hrs/count($doc_sec))/8,2).")";
										
										$total_docs+=count($doc_sec);
									}else{
										//echo "-";
									}
									array_push($subt, array("sem"=>$sem,"hitech_no_".$row['sec_alias'].$sem=>count($doc_sec),"hitech_hrs_".$row['sec_alias'].$sem=>$doc_total_hrs));
								?>
						
						<?php endforeach;?>
						
							
								<?php //if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "0";}?>
					
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
						
								<?php 
									$doc_total_hrs = 0;
									$doc_sec = $controller->get_doc_sec($row['sec_id'],'Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									foreach($doc_sec as $dur){
										
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
											$total_hrs+=$doc_no_hrs;
										}
									}
									
									if(count($doc_sec)!=0){
										//echo "(".count($doc_sec).") (".number_format(($doc_total_hrs/count($doc_sec))/8,2).")";
										
										$total_docs+=count($doc_sec);
									}else{
										//echo "-";
									}
									array_push($subt, array("sem"=>$sem,"legcon_no_".$row['sec_alias'].$sem=>count($doc_sec),"legcon_hrs_".$row['sec_alias'].$sem=>$doc_total_hrs));
								?>
						
						<?php endforeach;?>
						
							
								<?php //if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "0";}?>
					
					
					
					
					
					
						
					<tr>
						<td style="text-align:left;width:180px">Unclosed Transaction (No.)</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_sec_ut = $controller->get_doc_sec_ut($row['sec_id'],date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									if(count($doc_sec_ut)!=0){
										echo count($doc_sec_ut);
										$subt_m_ut+=count($doc_sec_ut);
									}else{
										echo "-";
									}
									array_push($subt, array("sem"=>$sem,"ut_no_".$row['sec_alias'].$sem=>count($doc_sec_ut)));
								?>
							</td>
						<?php endforeach;?>
						
							<td>
								<?php echo $subt_m_ut;?>
							</td>
					
					</tr>
						
					<tr>
						<td style="text-align:left;width:180px">% Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_simple = $controller->get_doc_sec($row['sec_id'],'Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_complex = $controller->get_doc_sec($row['sec_id'],'Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_hitech= $controller->get_doc_sec($row['sec_id'],'Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_legcon= $controller->get_doc_sec($row['sec_id'],'Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_sec_nar = $controller->get_doc_sec_nar($row['sec_id'],date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									$total_acted = count($doc_simple)+count($doc_complex)+count($doc_hitech)+count($doc_legcon)+count($doc_sec_nar);
									
									$doc_sec_ref = $controller->get_doc_sec_ref($row['sec_id'],date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									if(count($doc_sec_ref)!=0){
										echo number_format(($total_acted/count($doc_sec_ref))*100,2)."%";
										$subt_m_pda+= number_format(($total_acted/count($doc_sec_ref))*100,2);
										$subt_m_pda_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_c!=0){echo number_format($subt_m_pda/$subt_m_pda_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Simple Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_simple = $controller->get_doc_sec($row['sec_id'],'Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Simple',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									if(count($doc_sec)!=0){
										echo number_format((count($doc_simple)/count($doc_sec))*100,2)."%";
										$subt_m_pda_simp+= number_format((count($doc_simple)/count($doc_sec))*100,2);
										$subt_m_pda_simp_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_simp_c!=0){echo number_format($subt_m_pda_simp/$subt_m_pda_simp_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Complex Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_complex = $controller->get_doc_sec($row['sec_id'],'Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Complex',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									if(count($doc_sec)!=0){
										echo number_format((count($doc_complex)/count($doc_sec))*100,2)."%";
										$subt_m_pda_comp+= number_format((count($doc_complex)/count($doc_sec))*100,2);
										$subt_m_pda_comp_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_comp_c!=0){echo number_format($subt_m_pda_comp/$subt_m_pda_comp_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Highly Technical Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_hitech = $controller->get_doc_sec($row['sec_id'],'Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Highly Technical',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									if(count($doc_sec)!=0){
										echo number_format((count($doc_hitech)/count($doc_sec))*100,2)."%";
										$subt_m_pda_hitech+= number_format((count($doc_hitech)/count($doc_sec))*100,2);
										$subt_m_pda_hitech_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_hitech_c!=0){echo number_format($subt_m_pda_hitech/$subt_m_pda_hitech_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Legal Concern Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_legcon = $controller->get_doc_sec($row['sec_id'],'Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									$doc_sec = $controller->get_doc_sec_uni($row['sec_id'],'Legal Concern',date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									
									if(count($doc_sec)!=0){
										echo number_format((count($doc_legcon)/count($doc_sec))*100,2)."%";
										$subt_m_pda_legcon+= number_format((count($doc_legcon)/count($doc_sec))*100,2);
										$subt_m_pda_legcon_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_legcon_c!=0){echo number_format($subt_m_pda_legcon/$subt_m_pda_legcon_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">No Action Required (No.)</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_sec_nar = $controller->get_doc_sec_nar($row['sec_id'],date('M', mktime(0, 0, 0, $x, 10)),$rec_yr,$start_rec,$end_rec);
									if(count($doc_sec_nar)!=0){
										echo count($doc_sec_nar);
										$subt_m_nar+=count($doc_sec_nar);
									}else{
										echo "-";
									}
									array_push($subt, array("sem"=>$sem,"nar_no_".$row['sec_alias'].$sem=>count($doc_sec_nar)));
								?>
							</td>
						<?php endforeach;?>
						
							<td>
								<?php echo $subt_m_nar;?>
							</td>
					</tr>
											
						
					
				</table>
				<br><br>
				<?php endfor;?>
			
				
				
				
				<br>
				<br>
				<hr>
				<br>
				
				<center><h2>SUMMARY REPORT CY-<?php echo $rec_yr?></h2></center>
				<br>
				
				<table class="report_table">
					<tr>
						<td><b>TYPE OF DOCUMENT</b></td>
						
						<?php foreach($off_sec as $row):?>
							<td><b><?php echo $row['sec_alias'];?></b></td>
						<?php endforeach;?>
							<td><b>TOTAL</b></td>
					</tr>
				
				<?php 
					for($y=$semestral;$y<=$semestral;$y++):
					
					if($y==1){$sems="1ST SEMESTER";}
					else{$sems="2ND SEMESTER";}
				?>
				
				
				<?php $subt_m_simp=0;$subt_m_simp_c=0;$subt_m_ut=0;$subt_m_nar=0;$subt_m_df=0;$subt_m_pda=0;$subt_m_pda_c=0;$subt_m_pda_simp=0;$subt_m_pda_simp_c=0;$subt_m_pda_comp=0;$subt_m_pda_comp_c=0;$subt_m_pda_hitech=0;$subt_m_pda_hitech_c=0;$subt_m_pda_legcon=0;$subt_m_pda_legcon_c=0;?>
				
				
					<tr><td colspan="<?php echo count($off_sec)+2;?>" style="text-align:left"><h3 style="margin:0px"><?php echo $sems;?></h3></td></tr>
					
					<tr>
						<td style="text-align:left;width:180px">Total No. of Document Referral</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									echo number_format(array_sum(array_column($subt, "docref_no_".$row['sec_alias'].$y)));
									$subt_m_df+=array_sum(array_column($subt, "docref_no_".$row['sec_alias'].$y));
								?>
							</td>
						<?php endforeach;?>
							<td>
								<?php echo number_format($subt_m_df);?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Simple (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt_uni, "simp_no_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo $sec_doc_no;}else{echo "-";}
											
									$total_docs+=$sec_doc_no;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "(0) (0)";}?>
							</td>
						
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Simple Acted (No.)(Ave. Days)</td>
						
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt, "simp_no_".$row['sec_alias'].$y));
									$sec_doc_hrs = array_sum(array_column($subt, "simp_hrs_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo "(".$sec_doc_no.") (".number_format(($sec_doc_hrs/$sec_doc_no)/8,2).")";}else{echo "(0) (0)";}
											
									$total_docs+=$sec_doc_no;
									$total_hrs+=$sec_doc_hrs;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "(0) (0)";}?>
							</td>
						
					</tr>
						
					<tr>
						<td style="text-align:left;width:180px">Complex (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt_uni, "comp_no_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo $sec_doc_no;}else{echo "-";}
											
									$total_docs+=$sec_doc_no;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "(0) (0)";}?>
							</td>
						
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Complex Acted (No.)(Ave. Days)</td>
						
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt, "comp_no_".$row['sec_alias'].$y));
									$sec_doc_hrs = array_sum(array_column($subt, "comp_hrs_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo "(".$sec_doc_no.") (".number_format(($sec_doc_hrs/$sec_doc_no)/8,2).")";}else{echo "(0) (0)";}
											
									$total_docs+=$sec_doc_no;
									$total_hrs+=$sec_doc_hrs;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "(0) (0)";}?>
							</td>
					</tr>
						
					<tr>
						<td style="text-align:left;width:180px">Highly Technical (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt_uni, "hitech_no_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo $sec_doc_no;}else{echo "-";}
											
									$total_docs+=$sec_doc_no;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "(0) (0)";}?>
							</td>
						
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Legal Concern (No.)</td>
						
						<?php $total_docs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt_uni, "legcon_no_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo $sec_doc_no;}else{echo "-";}
											
									$total_docs+=$sec_doc_no;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo number_format($total_docs);}else{echo "(0) (0)";}?>
							</td>
						
					</tr>
					
					<!--
					<tr>
						<td style="text-align:left;width:180px">Highly Technical (No.)(Ave. Days)</td>
						
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt, "hitech_no_".$row['sec_alias'].$y));
									$sec_doc_hrs = array_sum(array_column($subt, "hitech_hrs_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo "(".$sec_doc_no.") (".number_format(($sec_doc_hrs/$sec_doc_no)/8,2).")";}else{echo "(0) (0)";}
											
									$total_docs+=$sec_doc_no;
									$total_hrs+=$sec_doc_hrs;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "(0) (0)";}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">Legal Concern (No.)(Ave. Days)</td>
						
						<?php $total_docs = 0;$total_hrs = 0;
						foreach($off_sec as $row):?>
							<td>
								<?php 
									$sec_doc_no = array_sum(array_column($subt, "legcon_no_".$row['sec_alias'].$y));
									$sec_doc_hrs = array_sum(array_column($subt, "legcon_hrs_".$row['sec_alias'].$y));
									
									if($sec_doc_no!=0){echo "(".$sec_doc_no.") (".number_format(($sec_doc_hrs/$sec_doc_no)/8,2).")";}else{echo "(0) (0)";}
											
									$total_docs+=$sec_doc_no;
									$total_hrs+=$sec_doc_hrs;
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($total_docs!=0){echo "(".number_format($total_docs).") (".number_format(($total_hrs/$total_docs)/8,2).")";}else{echo "(0) (0)";}?>
							</td>
					</tr>
					-->

					
					<tr>
						<td style="text-align:left;width:180px">Unclosed Transaction (No.)</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									echo number_format(array_sum(array_column($subt, "ut_no_".$row['sec_alias'].$y)));
									$subt_m_ut+=array_sum(array_column($subt, "ut_no_".$row['sec_alias'].$y));
								?>
							</td>
						<?php endforeach;?>
						
							<td>
								<?php echo number_format($subt_m_ut);?>
							</td>
					
					</tr>
						
					<tr>
						<td style="text-align:left;width:180px">% Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_simple = array_sum(array_column($subt, "simp_no_".$row['sec_alias'].$y));
									$doc_complex = array_sum(array_column($subt, "comp_no_".$row['sec_alias'].$y));
									$doc_hitech = array_sum(array_column($subt, "hitech_no_".$row['sec_alias'].$y));
									$doc_legcon = array_sum(array_column($subt, "legcon_no_".$row['sec_alias'].$y));
									$doc_sec_nar = array_sum(array_column($subt, "nar_no_".$row['sec_alias'].$y));
									
									$total_acted = $doc_simple+$doc_complex+$doc_hitech+$doc_legcon+$doc_sec_nar;
									
									$doc_sec_ref = array_sum(array_column($subt, "docref_no_".$row['sec_alias'].$y));
									if($doc_sec_ref!=0){
										echo number_format(($total_acted/$doc_sec_ref)*100,2)."%";
										$subt_m_pda+=($total_acted/$doc_sec_ref)*100;
										$subt_m_pda_c++;
										
									}else{
										echo "-";
									}
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_c!=0){echo number_format($subt_m_pda/$subt_m_pda_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
						
					<tr>
						<td style="text-align:left;width:180px">% Simple Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_simple = array_sum(array_column($subt, "simp_no_".$row['sec_alias'].$y));
									$doc_sec = array_sum(array_column($subt_uni, "simp_no_".$row['sec_alias'].$y));
									
									if($doc_sec!=0){
										echo number_format(($doc_simple/$doc_sec)*100,2)."%";
										$subt_m_pda_simp+= number_format(($doc_simple/$doc_sec)*100,2);
										$subt_m_pda_simp_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_simp_c!=0){echo number_format($subt_m_pda_simp/$subt_m_pda_simp_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Complex Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_complex = array_sum(array_column($subt, "comp_no_".$row['sec_alias'].$y));
									$doc_sec = array_sum(array_column($subt_uni, "comp_no_".$row['sec_alias'].$y));
									
									if($doc_sec!=0){
										echo number_format(($doc_complex/$doc_sec)*100,2)."%";
										$subt_m_pda_comp+= number_format(($doc_complex/$doc_sec)*100,2);
										$subt_m_pda_comp_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_comp_c!=0){echo number_format($subt_m_pda_comp/$subt_m_pda_comp_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Highly Technical Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_hitech= array_sum(array_column($subt, "hitech_no_".$row['sec_alias'].$y));
									$doc_sec = array_sum(array_column($subt_uni, "hitech_no_".$row['sec_alias'].$y));
									
									if($doc_sec!=0){
										echo number_format(($doc_hitech/$doc_sec)*100,2)."%";
										$subt_m_pda_hitech+= number_format(($doc_hitech/$doc_sec)*100,2);
										$subt_m_pda_hitech_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_hitech_c!=0){echo number_format($subt_m_pda_hitech/$subt_m_pda_hitech_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">% Legal Concern Documents Acted</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									$doc_legcon= array_sum(array_column($subt, "legcon_no_".$row['sec_alias'].$y));
									$doc_sec = array_sum(array_column($subt_uni, "legcon_no_".$row['sec_alias'].$y));
									
									if($doc_sec!=0){
										echo number_format(($doc_legcon/$doc_sec)*100,2)."%";
										$subt_m_pda_legcon+= number_format(($doc_legcon/$doc_sec)*100,2);
										$subt_m_pda_legcon_c++;
									}else{
										echo "-";
									}
									
									
								?>
							</td>
						<?php endforeach;?>
							
							<td>
								<?php if($subt_m_pda_legcon_c!=0){echo number_format($subt_m_pda_legcon/$subt_m_pda_legcon_c,2)."%";}else{echo '0';}?>
							</td>
					</tr>
					
					<tr>
						<td style="text-align:left;width:180px">No Action Required (No.)</td>
						
						<?php foreach($off_sec as $row):?>
							<td>
								<?php 
									echo number_format(array_sum(array_column($subt, "nar_no_".$row['sec_alias'].$y)));
									$subt_m_nar+=array_sum(array_column($subt, "nar_no_".$row['sec_alias'].$y));
								?>
							</td>
						<?php endforeach;?>
						
							<td>
								<?php echo number_format($subt_m_nar);?>
							</td>
					</tr>
						
				<?php endfor;?>	
				</table>
				
				
				
				
				
				