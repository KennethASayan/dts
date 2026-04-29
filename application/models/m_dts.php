<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dts extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
			
			public function login($log)
			{
					
					$thesql = "SELECT * FROM dts_db.user_accnt
								INNER JOIN dts_db.off_role
									ON (user_accnt.role_id = off_role.role_id)
								INNER JOIN dts_db.off_division
									ON (user_accnt.div_id = off_division.div_id)
								INNER JOIN dts_db.office
									ON(user_accnt.off_id = office.off_id)
								WHERE user_accnt.u_name = '".$log['uname']."' AND user_accnt.u_pwd = MD5('".$log['upwd']."')";

					$query = $this->db->query($thesql);
					if($query->result_array()!=null){
						foreach ($query->result_array() as $row) 
						  {
							$data_return[]=$row;
						  }
						return $data_return;
					}
			}
	
			public function get_rec_id(){
				
				$data_return = array();
				$thesql = "SELECT MAX(rec_id) AS max_id FROM doc_rec";
				$query = $this->db->query($thesql);
				foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				return $data_return;
					
			}
			
			public function get_doc_subject(){
				
				$data_return = array();
				$thesql = "SELECT doc_subject FROM doc_rec";
				$query = $this->db->query($thesql);
				foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				return $data_return;
					
			}
			
			public function get_doc_type(){
				
				$data_return = array();
				$thesql = "SELECT * FROM doc_type";
				$query = $this->db->query($thesql);
				foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				return $data_return;
					
			}
				
			public function put_record($doc_no)
{
    date_default_timezone_set('Asia/Manila');

    if($this->input->post('doc_class2')==1){
        $ef_id=1;                      
    }
    elseif($this->input->post('doc_class2')==2){
        $ef_id=5;
    }

    $div_id = $this->session->userdata('div_log_id');

    $data = array(
        'doc_no' => $doc_no,
        'u_id' => $this->session->userdata('u_log_id'),
        'doc_class' => $this->input->post('doc_class2'),
        'dt_id' => $this->input->post('dt_id2'),
        'doc_subject' => strtoupper(preg_replace('/[^a-zA-Z0-9-_().: ]/','', trim($this->input->post('doc_subject2')))),
        'sender' => strtoupper($this->input->post('sender_f2')),
        'doc_date' => $this->input->post('doc_date2'),
        'rec_date' => date('M-d-Y'),
        'act_date' => date('M-d-Y'),
        'rec_time' => date('h:i A'),
        'div_id' => ','.$div_id.',',  // ✅ Store with commas so LIKE "%,X,%" works
        'ef_id' => $ef_id,
        'act_flag' => 0,
        'prior_t' => $this->input->post('prior_t2'),
        'doc_date_rr' => date_format(date_create($this->input->post('doc_date_rr2')), 'M-d-Y'),
        'doc_time_rr' =>  date_format(date_create($this->input->post('doc_time_rr2')), 'h:i A'),
    );  
    $this->db->insert('doc_rec', $data);
}
			
			public function put_act_record($doc_act_no)
			{
				date_default_timezone_set('Asia/Manila');
				
					$data = array
								(
									'doc_no' => $doc_act_no,
									'u_id' => $this->session->userdata('u_log_id'),
									'doc_class' => 2,
									'dt_id' => $this->input->post('dt_id3'),
									'doc_subject' => strtoupper(preg_replace('/[^a-zA-Z0-9-_().: ]/','', trim($this->input->post('doc_subject3')))),
									'sender' => strtoupper($this->input->post('sender_f3')),
									'doc_date' => $this->input->post('doc_date3'),
									'rec_date' => date('M-d-Y'),
									'act_date' => date('M-d-Y'),
									'rec_time' => date('h:i A'),
									//'div_id' => $this->session->userdata('div_log_id'),
									'ef_id' => 5,
									'act_flag' => 0,
									'prior_t' => 'Normal',
									'doc_date_rr' => date('M-d-Y'),
									'doc_time_rr' => date('h:i A'),
								);  
				
					$this->db->insert('doc_rec', $data);
					
			}
			
			public function put_file($file_name,$doc_no)
			{	
					$data = array
								(
									'doc_no' => $doc_no,
									'file_name' => $file_name,
								);                        
					
					$this->db->insert('uplink', $data);
			}
			
			public function get_records($trigg){
				  
				  $div_id = $this->session->userdata('div_log_id');
				  
				  $data_return = array();
				  $thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id)";
				  if($div_id==1){
					  if($trigg==0 OR $trigg==99){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id)";}
					  elseif($trigg==4){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 1 ";}
					  elseif($trigg==3){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10";}
					  elseif($trigg==5){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 6 ";}
					  elseif($trigg==6){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 9 ";}
					  
					  }
				  else{
					 
					  if($trigg==0 OR $trigg==99){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE (doc_rec.div_id LIKE '%,$div_id,%' OR doc_rec.div_id LIKE '%,1,%' OR (doc_rec.div_id IS NULL OR doc_rec.div_id = ',') OR doc_rec.doc_class = '2')";}
					  elseif($trigg==1){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 2";}
					  elseif($trigg==2){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND (doc_rec.ef_id != 2 AND doc_rec.ef_id != 6 AND doc_rec.ef_id != 7 AND doc_rec.ef_id != 8 AND doc_rec.ef_id != 9 AND doc_rec.ef_id != 10)";}
					  elseif($trigg==3){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND (doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10)";}
					  elseif($trigg==4){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 1";}
					  elseif($trigg==5){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 6";}
					  elseif($trigg==6){$thesql = "SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 9 ";}
					  
				  }
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
				}
				
			public function get_count_rec($trigg){
				  
				  $div_id = $this->session->userdata('div_log_id');
				  
				  $data_return = array();
				  $thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id)";
				  if($div_id==1){
					  if($trigg==0 OR $trigg==99){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id)";}
					  elseif($trigg==4){$thesql = "SELECT count(rec_id) as cnt FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 1 AND (doc_rec.doc_no LIKE '".date('Y')."-%' OR doc_rec.doc_no LIKE '".(date('Y')-1)."-12-%')";}
					  elseif($trigg==3){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10";}
					  elseif($trigg==5){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 6 AND (doc_rec.doc_no LIKE '".date('Y')."-%' OR doc_rec.doc_no LIKE '".(date('Y')-1)."-12-%') ";}
					  elseif($trigg==6){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 9 AND (doc_rec.doc_no LIKE '".date('Y')."-%' OR doc_rec.doc_no LIKE '".(date('Y')-1)."-12-%') ";}
					  
					  }
				  else{
					 
					  if($trigg==0 OR $trigg==99){$thesql = "SELECT count(rec_id) as cnt FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE (doc_rec.div_id LIKE '%,$div_id,%' OR doc_rec.div_id LIKE '%,1,%' OR (doc_rec.div_id IS NULL OR doc_rec.div_id = ',') OR doc_rec.doc_class = '2')";}
					  elseif($trigg==1){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 2";}
					  elseif($trigg==2){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND (doc_rec.ef_id != 2 AND doc_rec.ef_id != 6 AND doc_rec.ef_id != 7 AND doc_rec.ef_id != 8 AND doc_rec.ef_id != 9 AND doc_rec.ef_id != 10)";}
					  elseif($trigg==3){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND (doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10)";}
					  elseif($trigg==4){$thesql = "SELECT count(rec_id) as cnt FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 1";}
					  elseif($trigg==5){$thesql = "SELECT count(rec_id) as cnt FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 6";}
					  elseif($trigg==6){$thesql = "SELECT count(rec_id) as cnt  FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id = 9 AND (doc_rec.doc_no LIKE '".date('Y')."-%' OR doc_rec.doc_no LIKE '".(date('Y')-1)."-12-%') ";}
					  
				  }
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
				}
				
				
			public function get_doc_released($month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 2 AND rec_id >= $start_rec AND rec_id <= $end_rec AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
				
			public function get_doc_lop($lop,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND prior_t = '$lop' AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_types($dt_id,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND dt_id = '$dt_id' AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_offdiv($div_id,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND div_id LIKE '%,$div_id,%' AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_act_class($act_class,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND act_class LIKE '%$act_class%' AND ef_id =10 AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_act_class_nar($month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND (ef_id = 3 OR ef_id = 7 OR ef_id = 8) AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_penro_doc($month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT COUNT(doc_no) AS doc_count FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND act_id LIKE '%6,%' AND rec_date LIKE '%$month%' AND rec_date LIKE '%$year%';";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_recv($month,$year){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no FROM doc_rec WHERE doc_class = 1 AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_logs_penro($doc_no){
				
				  $data_return = array();
				  $thesql = "SELECT e_dt FROM doc_logs WHERE doc_no = '$doc_no' AND (doc_logs.event LIKE '%created%' OR doc_logs.event LIKE '%received%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_div_recv($div_id,$month,$year){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no FROM doc_rec WHERE doc_class = 1 AND div_id LIKE '%$div_id%' AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_logs_div($doc_no){
				
				  $data_return = array();
				  $thesql = "SELECT e_dt FROM doc_logs WHERE doc_no = '$doc_no' AND (doc_logs.event LIKE '%section%' OR doc_logs.event LIKE '%received%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_sec($sec_id,$act_class,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no, nd_act FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND sec_id LIKE '$sec_id,%' AND act_class LIKE '%$act_class%' AND ef_id =10 AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_sec_uni($sec_id,$act_class,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND sec_id LIKE '$sec_id,%' AND act_class LIKE '%$act_class%' AND ef_id<>8 AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_sec_nar($sec_id,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND sec_id LIKE '$sec_id,%' AND ((ef_id = 3 OR ef_id = 6 OR ef_id = 7 OR ef_id = 8) AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%'));";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_sec_ut($sec_id,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND sec_id LIKE '$sec_id,%' AND ef_id = 9 AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_doc_sec_ref($sec_id,$month,$year,$start_rec,$end_rec){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no FROM doc_rec WHERE doc_class = 1 AND rec_id >= $start_rec AND rec_id <= $end_rec AND sec_id LIKE '$sec_id,%' AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_rec_min_max($year){
				
				  $data_return = array();
				  $thesql = "SELECT rec_id FROM doc_rec WHERE doc_class = 1 AND doc_no LIKE '$year-%';";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			
			public function get_doc_noh($act_class,$month,$year){
				
				  $data_return = array();
				  $thesql = "SELECT doc_no, nd_act FROM doc_rec WHERE doc_class = 1 AND act_class LIKE '%$act_class%' AND ef_id =10 AND (rec_date LIKE '%$month%' AND rec_date LIKE '%$year%');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_docs($month,$year){
				
				  $data_return = array();
				  $thesql = "SELECT * FROM doc_rec WHERE doc_class = 1 AND rec_date LIKE '%$month%' AND rec_date LIKE '%$year%';";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			public function get_records_prev($doc_no){
				
				  $data_return = array();
				  $thesql = "SELECT * FROM doc_rec INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_no='$doc_no';";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_autocom_records(){
				
				  $data_return = array();
				  $thesql = "SELECT doc_subject FROM doc_rec ";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_rel_docs(){
				
				  $data_return = array();
				  $thesql = "SELECT doc_rec.doc_no, doc_subject, act_date, file_name FROM doc_rec
								LEFT JOIN dts_db.uplink
								ON (doc_rec.doc_no = uplink.doc_no)
								WHERE doc_rec.ef_id= '5'";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_act_desc(){
				
				  $data_return = array();
				  $thesql = "SELECT * FROM act_flags ";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_log_route($doc_no){
				
				  $data_return = array();
				  $thesql = "SELECT * 
							  FROM doc_logs 
							  INNER JOIN off_division ON (doc_logs.div_id = off_division.div_id) 
							  WHERE doc_no = '$doc_no' AND (event LIKE '%routed%' OR event LIKE '%returned%')
							  ORDER BY dl_id ASC ";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_files($doc_no){
				
				  $data_return = array();
				  $thesql = "SELECT * 
							FROM doc_rec 
							INNER JOIN dts_db.uplink
								ON(uplink.doc_no = doc_rec.doc_no)
							WHERE uplink.doc_no='$doc_no'";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
	
			public function delete_record()
			{		
					$this->db->where('doc_no', $this->input->post('doc_no'));
					$this->db->delete('doc_rec');
			}
	
			public function delete_files()
			{		
					$this->db->where('doc_no', $this->input->post('doc_no'));
					$this->db->delete('uplink');
			}
			
			public function delete_logs()
			{		
					$this->db->where('doc_no', $this->input->post('doc_no'));
					$this->db->delete('doc_logs');
			}
			
			public function update_record($doc_no,$ef_id){
				
				date_default_timezone_set('Asia/Manila');
				if($this->input->post('doc_class')==1){	
				$data = array
							(
								'u_id' => $this->session->userdata('u_log_id'),
								'doc_class' => $this->input->post('doc_class'),
								'dt_id' => $this->input->post('dt_id'),
								'doc_subject' => strtoupper(preg_replace('/[^a-zA-Z0-9-_().: ]/','', trim($this->input->post('doc_subject')))),
								'sender' => strtoupper($this->input->post('sender_f')),
								'doc_date' => $this->input->post('doc_date'),
								'prior_t' => $this->input->post('prior_t'),
								'ef_id' => $ef_id,
								'doc_date_rr' => date_format(date_create($this->input->post('doc_date_rr')), 'M-d-Y'),
								'doc_time_rr' =>  date_format(date_create($this->input->post('doc_time_rr')), 'h:i A'),
							);        
				}
				elseif($this->input->post('doc_class')==2){	
				$data = array
							(
								'u_id' => $this->session->userdata('u_log_id'),
								'doc_class' => $this->input->post('doc_class'),
								'dt_id' => $this->input->post('dt_id'),
								'doc_subject' => strtoupper(preg_replace('/[^a-zA-Z0-9-_().: ]/','', trim($this->input->post('doc_subject')))),
								'sender' => strtoupper($this->input->post('sender_f')),
								'doc_date' => $this->input->post('doc_date'),
								'prior_t' => $this->input->post('prior_t'),
								'dt_recv' => '',
								'ef_id' => $ef_id,
								'doc_date_rr' => date_format(date_create($this->input->post('doc_date_rr')), 'M-d-Y'),
								'doc_time_rr' =>  date_format(date_create($this->input->post('doc_time_rr')), 'h:i A'),
							);  
				}
					$this->db->where('doc_no',$doc_no);
					$this->db->update('doc_rec', $data);
				
			}
			
			public function update_stat($doc_no,$ef_id){
				
				date_default_timezone_set('Asia/Manila');
				
			// ✅ Only process routing data if POST data exists (for routing operations)
			$div_id = ($this->input->post('div_id')) ? implode(",",$this->input->post('div_id')) : '';
			$sec_id = ($this->input->post('sec_id')) ? implode(",",$this->input->post('sec_id')) : '';
			$unit_id = ($this->input->post('unit_id')) ? implode(",",$this->input->post('unit_id')) : '';
			$act_id = ($this->input->post('act_id')) ? implode(",",$this->input->post('act_id')) : '';
			
			if($ef_id==4){
				// ✅ FIX: Get current div_id and APPEND new divisions instead of replacing
				$current_record = $this->db->query("SELECT div_id FROM doc_rec WHERE doc_no = '$doc_no'")->result_array();
				$current_div_id = isset($current_record[0]['div_id']) ? trim($current_record[0]['div_id'], ',') : '';
				
				// Combine existing and new division IDs (avoid duplicates)
				$new_div_ids = explode(',', $div_id);
				$existing_div_ids = !empty($current_div_id) ? explode(',', $current_div_id) : array();
				$all_div_ids = array_unique(array_filter(array_merge($existing_div_ids, $new_div_ids)));
				$combined_div_id = implode(',', $all_div_ids);
				
				$data = array
						(
							'ef_id' => $ef_id,
							'div_id' => ','.$combined_div_id.',',  // ✅ APPEND new divisions to existing
							'dt_recv' => date('Y-m-d H:i:s'),
							'act_date' => date('M-d-Y'),
						);        
			}
			elseif($ef_id==6){
				$data = array
						(
							'ef_id' => $ef_id,
							'act_date' => date('M-d-Y'),
						);        
			}
			elseif($ef_id==7){
				$data = array
						(
							'ef_id' => $ef_id,
							'dt_recv' => '',
							'act_date' => date('M-d-Y'),
						);        
			}
			elseif($ef_id==8){
				$data = array
						(
							'ef_id' => $ef_id,
							'dt_recv' => '',
							'act_date' => date('M-d-Y'),
						);        
			}
			else{
				// ✅ FIX: Get current div_id and APPEND instead of replacing (for all ef_id values)
				if($this->input->post('act_flag')==1){$ef_id = 9;}
				if($div_id && (strpos($div_id,'4')!==false OR strpos($div_id,'5')!==false)){$ef_id = 7;}
				if($act_id && strpos($act_id,'6')!==false){$ef_id = 7;}
				
				// Handle div_id: Append new divisions to existing ones
				$updated_div_id = '';
				if($div_id) {
					$current_record = $this->db->query("SELECT div_id FROM doc_rec WHERE doc_no = '$doc_no'")->result_array();
					$current_div_id = isset($current_record[0]['div_id']) ? trim($current_record[0]['div_id'], ',') : '';
					
					// Combine existing and new division IDs (avoid duplicates)
					$new_div_ids = explode(',', $div_id);
					$existing_div_ids = !empty($current_div_id) ? explode(',', $current_div_id) : array();
					$all_div_ids = array_unique(array_filter(array_merge($existing_div_ids, $new_div_ids)));
					$updated_div_id = ","  .implode(',', $all_div_ids) . ",";
				}
				
				$data = array
						(
							'div_id' => ($updated_div_id ? $updated_div_id : ""),  // ✅ APPEND to existing div_id
							'sec_id' => ($sec_id ? $sec_id."," : ""),
							'unit_id' => ($unit_id ? $unit_id."," : ""),
							'ef_id' => $ef_id,
							'act_id' => ($act_id ? $act_id."," : ""),
								'act_class' => $this->input->post('doc_clsf'),
							);   
				}
					$this->db->where('doc_no',$doc_no);
					$this->db->update('doc_rec', $data);
					
			}
			
			public function delete_upfile_sel($file_id,$file_name)
			{					
					$this->db->where('file_id', $file_id);
					$this->db->delete('uplink');
					//unlink($_SERVER['DOCUMENT_ROOT'].'/dts/uploads/'.$file_name);
				
			}
			
			public function get_off_div(){
				
				  $off_id = $this->session->userdata('off_log_id');
				  
				  $data_return = array();
				  $thesql = "SELECT * 
								FROM off_division 
								INNER JOIN dts_db.office
								ON(off_division.off_id = office.off_id)
								WHERE office.off_id = '1' OR office.off_id = '$off_id'; ";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_off_sec(){	
				  
				  $off_id = $this->session->userdata('off_log_id');
				  $off_penro = $this->session->userdata('off_log_penro');
				  
				  $div_id = $this->session->userdata('div_log_id');
				  $data_return = array();
			  
		  // ✅ Routing slip sections: 
		  // PENRO (off_id < 7): Show shared sections (off_id=0) + PENRO template (off_id=1)
		  // CENRO (off_id >= 7): Show shared sections (off_id=0) + CENRO template (off_id=3)
		  // NOTE: Do NOT include office-specific sections for routing slip
		  if($off_id >= 7){
		  	// CENRO user - show shared sections (off_id=0) + CENRO template sections (off_id=3)
		  	$thesql = "SELECT * FROM off_section WHERE off_id = '0' OR off_id = '3' ORDER BY sec_alias ASC";
		  } else {
		  	// PENRO user - show shared sections (off_id=0) + PENRO template sections (off_id=1)
		  	$thesql = "SELECT * FROM off_section WHERE off_id = '0' OR off_id = '1' ORDER BY sec_alias ASC";
		  }
		  
		  $query = $this->db->query($thesql);
		  foreach ($query->result_array() as $row) 
		  {
			$data_return[]=$row;
		  }
		  return $data_return;
			}
			
			public function get_off_unit(){
				
			  $off_id = $this->session->userdata('off_log_id');
			  $div_id = $this->session->userdata('div_log_id');
			  $data_return = array();
			  if($div_id==1){
			  	$thesql = "SELECT * FROM off_unit ORDER BY unit_alias ASC";
			  }
			  else{
		  	// ✅ Show units from appropriate template sections: PENRO gets off_id=1, CENRO gets off_id=3
		  	// Do NOT include office-specific units from the office's own off_id
		  	if($off_id >= 7){
		  		// CENRO user - show units from shared (off_id=0) + CENRO template sections (off_id=3)
		  		$thesql = "SELECT DISTINCT off_unit.* FROM off_unit 
					INNER JOIN dts_db.off_section
					ON (off_unit.sec_id = off_section.sec_id)
					WHERE off_section.off_id = '0' OR off_section.off_id = '3' ORDER BY unit_alias ASC";
		  	} else {
		  		// PENRO user - show units from shared (off_id=0) + PENRO template sections (off_id=1)
		  		$thesql = "SELECT DISTINCT off_unit.* FROM off_unit 
					INNER JOIN dts_db.off_section
					ON (off_unit.sec_id = off_section.sec_id)
					WHERE off_section.off_id = '0' OR off_section.off_id = '1' ORDER BY unit_alias ASC";
		  	}
		  }
		  $query = $this->db->query($thesql);
		  foreach ($query->result_array() as $row) 
		  {
			$data_return[]=$row;
		  }
		  return $data_return;
				
		}

		public function put_logs($event,$doc_no)
			{
				date_default_timezone_set('Asia/Manila');
				
				if($this->input->post('act_id')!=''){
				$act_id=implode(",",$this->input->post('act_id'));
				if(strpos($act_id,'6')!==false){$event="Routed to PENR Officer";}
				}
				
					$data = array
								(
									'div_id' => $this->session->userdata('div_log_id'),
									'doc_no' => $doc_no,
									'event' => $event,
									'e_dt' => date('M-d-Y h:i:s A'),
									'e_act_pers' => $this->input->post('act_pers'),
									'e_remarks' => $this->input->post('doc_remarks'),
								);                        
					
					$this->db->insert('doc_logs', $data);
			}
			
			public function put_logs_nan($event,$doc_no)
			{
				date_default_timezone_set('Asia/Manila');
				
				if($this->input->post('act_id')!=''){
				$act_id=implode(",",$this->input->post('act_id'));
				if(strpos($act_id,'6')!==false){$event="Routed to PENR Officer";}
				}
				
					$data = array
								(
									'div_id' => $this->session->userdata('div_log_id'),
									'doc_no' => $doc_no,
									'event' => $event,
									'e_dt' => date('M-d-Y h:i:s A'),
									'e_act_pers' => $this->input->post('act_pers'),
									'e_remarks' => $this->input->post('doc_reason'),
								);                        
					
					$this->db->insert('doc_logs', $data);
			}
			
			public function get_logs($doc_no){
				
				  $data_return = array();
				  $thesql = "SELECT * FROM doc_logs INNER JOIN off_division ON (doc_logs.div_id=off_division.div_id) WHERE doc_logs.doc_no = '$doc_no' ";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
			public function get_user(){
				
				  $data_return = array();
				  $thesql = "SELECT * FROM
							dts_db.user_accnt
							INNER JOIN dts_db.off_division 
								ON (user_accnt.div_id = off_division.div_id)
							INNER JOIN dts_db.office
								ON (user_accnt.off_id = office.off_id)
							INNER JOIN dts_db.off_role
								ON (user_accnt.role_id = off_role.role_id);";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
			}
			
				
			public function get_office(){
			
			  $data_return = array();
			  $thesql = "SELECT * FROM office";
			  $query = $this->db->query($thesql);
			  foreach ($query->result_array() as $row) 
				  {
					$data_return[]=$row;
				  }
			  return $data_return;
				
			}
			
			public function get_div(){
			
			  $data_return = array();
			  $thesql = "SELECT * FROM off_division";
			  $query = $this->db->query($thesql);
			  foreach ($query->result_array() as $row) 
				  {
					$data_return[]=$row;
				  }
			  return $data_return;
				
			}
			
			public function get_office_role(){
			
			  $data_return = array();
			  $thesql = "SELECT * FROM off_role";
			  $query = $this->db->query($thesql);
			  foreach ($query->result_array() as $row) 
				  {
					$data_return[]=$row;
				  }
			  return $data_return;
				
			}
			
			public function put_newu()
			{
				
			$names = explode(' ',$this->input->post('fname'));
			$fnamei = '';
			   foreach($names as $name) {$fnamei .= $name[0];}			
			$m = mb_substr($this->input->post('mname'), 0, 1);
			$lname = str_replace(' ','',$this->input->post('lname'));
			
			$uname = $fnamei.$m.$lname;
			$unamelc = strtolower ($uname);
			$fname=ucwords(strtolower($this->input->post('fname')));
			$mname=ucwords(strtolower($this->input->post('mname')));
			$lname=ucwords(strtolower($this->input->post('lname')));
			
			
					$data = array
								(
									'f_name' => $fname,
									'm_name' => $mname,
									'l_name' => $lname,
									'u_name' => $unamelc,
									'u_pwd' => MD5($this->input->post('u_pwd')),
									'role_id' => $this->input->post('role_id'),
									'div_id' => $this->input->post('div_id'),
									'off_id' => $this->input->post('off_id'),
									'stat_flag' => $this->input->post('u_stat'),
								);                        
					
					$this->db->insert('user_accnt', $data);
			}
			
			public function update_ua()
			{
				
				$names = explode(' ',$this->input->post('fname'));
				$fnamei = '';
				   foreach($names as $name) {$fnamei .= $name[0];}			
				$m = mb_substr($this->input->post('mname'), 0, 1);
				$lname = str_replace(' .,','',$this->input->post('lname'));
				
				$uname = $fnamei.$m.$lname;
				$unamelc = strtolower ($uname);
				$fname=ucwords(strtolower($this->input->post('fname')));
				$mname=ucwords(strtolower($this->input->post('mname')));
				$lname=ucwords(strtolower($this->input->post('lname')));
				
					if($this->input->post('u_pwd')!=null){
						$data = array
								(
									'f_name' => $fname,
									'm_name' => $mname,
									'l_name' => $lname,
									'u_name' => $unamelc,
									'u_pwd' => MD5($this->input->post('u_pwd')),
									'role_id' => $this->input->post('role_id'),
									'div_id' => $this->input->post('div_id'),
									'off_id' => $this->input->post('off_id'),
									'stat_flag' => $this->input->post('u_stat'),
								); 
						
					}else{
						$data = array
								(
									'f_name' => $fname,
									'm_name' => $mname,
									'l_name' => $lname,
									'u_name' => $unamelc,
									'role_id' => $this->input->post('role_id'),
									'div_id' => $this->input->post('div_id'),
									'off_id' => $this->input->post('off_id'),
									'stat_flag' => $this->input->post('u_stat'),
								);  
					}
					
					$this->db->where('u_id', $this->input->post('usr_id'));
					$this->db->update('user_accnt', $data);
			}
			
			public function delete_ua()
			{		
					$this->db->where('u_id', $this->input->post('usr_id'));
					$this->db->delete('user_accnt');
			}
			
			public function rpwd_ua()
			{		
					
					$data = array
								(
									'u_pwd' => MD5('Windows7'),
								); 
					
					$this->db->where('u_id', $this->input->post('usr_id'));
					$this->db->update('user_accnt', $data);
			}
	
			public function get_user_indiv($o_pwd){
				
				$u_id = $this->session->userdata('u_log_id');
				
				  $data_return = array();
				  $thesql = "SELECT * FROM user_accnt WHERE u_id = '$u_id' AND u_pwd = MD5('$o_pwd');";
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
				}
				
			public function update_pwd()
			{
				$u_id = $this->session->userdata('u_log_id');
					$data = array
								(
									'u_pwd' => MD5($this->input->post('n_pwd')),
								);                        
					
					$this->db->where('u_id', $u_id);
					$this->db->update('user_accnt', $data);
			}
			
			public function get_exp_records(){
				  
				  $div_id = $this->session->userdata('div_log_id');
				  
				  $data_return = array();
				  if($div_id==1){
					  $thesql = "SELECT * FROM doc_rec 
								  INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) 
								  INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) 
								  WHERE doc_rec.doc_no LIKE '%".date('Y')."-%'";
				  }
				  else{
				  $thesql = "SELECT * FROM doc_rec 
							  INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) 
							  INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) 
							  WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id != 6 AND doc_rec.doc_no LIKE '%".date('Y')."-%'";
				  }		  
				  $query = $this->db->query($thesql);
				  foreach ($query->result_array() as $row) 
					  {
						$data_return[]=$row;
					  }
				  return $data_return;
					
				}
				
			public function act_up_update($doc_no,$doc_act_no,$nd_act)
			{
				date_default_timezone_set('Asia/Manila');
				
					$data = array
								(
									'ef_id' => 10,
									'act_flag' => 2,
									'act_date' => date('M-d-Y'),
									'nd_act' => $nd_act,
									'act_cn' => $doc_act_no,
									'dt_recv' => null,
								);                        
					
					$this->db->where('doc_no',$doc_no);
					$this->db->update('doc_rec', $data);
			}
			
			public function act_up_noact($doc_no)
			{
				date_default_timezone_set('Asia/Manila');
				
					$data = array
								(
									'ef_id' => 8,
									'act_flag' => 0,
									'act_date' => date('M-d-Y'),
									'dt_recv' => '',
								);                        
					
					$this->db->where('doc_no',$doc_no);
					$this->db->update('doc_rec', $data);
			}
			
			public function get_time_dur($date_starts,$date_ends)
			{    
			
				$holidays=array(
					date('Y').'-01-01', //New Year's Day
					date('Y').'-02-05', //Chinese New Year
					date('Y').'-02-25', //EDSA Revolution
					date('Y').'-04-09', //Day of Valor
					date('Y').'-04-18', //Maundy Thursday
					date('Y').'-04-19', //Good Friday
					date('Y').'-04-20', //Black Saturday
					date('Y').'-05-01', //Labor Day
					date('Y').'-06-05', //Eidul Fitr
					date('Y').'-06-12', //Independence Day
					date('Y').'-08-12', //Eidul Adha
					date('Y').'-08-21', //Ninoy Aquino Day
					date('Y').'-08-26', //National Heroes Day
					date('Y').'-11-01', //All Saint's Day
					date('Y').'-11-02', //All Soul's Day
					date('Y').'-11-30', //Bonifacio Day
					date('Y').'-12-24', //Christmas Eve
					date('Y').'-12-25', //Christmas Day
					date('Y').'-12-30', //Rizal Day
					date('Y').'-12-31', //New Year's Eve
				);
					
				date_default_timezone_set('Asia/Manila');
				$dt_recv = strtotime($date_starts);
				$dt_curr = strtotime($date_ends);
				$weekends = 0;
				$hc=0;
				/* for($i=$dt_recv; $i<=$dt_curr;$i=$i+86400){if(date("N",$i) == 6 OR date("N",$i) == 7) {$weekends++;}} */
				
				$date_end = new DateTime($date_ends);
				$date_end->add(new DateInterval('P1D'));
				$period=new DatePeriod(new DateTime($date_starts),new DateInterval('P1D'),$date_end);
				
					if($dt_recv!=''){
						foreach($period as $date){
							$date=$date->format('Y-m-d H:i:s');
							if(strtotime($date)>$dt_recv AND strtotime($date)<$dt_curr AND date("N",strtotime($date)) == 6 OR date("N",strtotime($date)) == 7){$weekends++;}
						}
					}
					
					foreach($holidays as $holiday){
						if($dt_recv!=''){
							if(strtotime($holiday)>$dt_recv AND strtotime($holiday)<$dt_curr AND date("N",strtotime($holiday)) != 6 AND date("N",strtotime($holiday)) != 7){$hc++;}
						}
					}
					
					$dt_diff = date_diff(date_create($date_starts),date_create($date_ends));
					if($dt_diff->m<=0){
						if(($dt_diff->d-$weekends)-$hc<=0){
							if($dt_diff->h<=0){
								if($dt_diff->i<=0){
									if($dt_diff->s<=0){$dt_dur = '-';
									}else{$dt_dur = $dt_diff->s.' sec(s)';}
								}else{$dt_dur = $dt_diff->i.' minute(s)';}
							}else{$dt_dur = $dt_diff->h.' hour(s)';}				
						}else{$dt_dur=($dt_diff->d-$weekends)-$hc.' day(s)';}
					}else{$dt_dur=$dt_diff->m.' month(s)';}
					
					return $dt_dur;
			}
			
		public function get_sys_up(){
				
			  $data_return = array();
			  $thesql = "SELECT * FROM sys_update";
			  $query = $this->db->query($thesql);
			  foreach ($query->result_array() as $row) 
				  {
					$data_return[]=$row;
				  }
			  return $data_return;
				
		}
		
		public function get_act_file($doc_no){
				
			  $data_return = array();
			  $thesql = "SELECT * FROM dts_db.uplink WHERE uplink.doc_no='$doc_no'";
			  $query = $this->db->query($thesql);
			  foreach ($query->result_array() as $row) 
				  {
					$data_return[]=$row;
				  }
			  return $data_return;
				
		}
		
		public function get_doc_subjects($doc_sub){
				
				$thesql = "SELECT doc_subject, doc_no FROM doc_rec WHERE doc_no LIKE '".date('Y')."-%' AND doc_subject LIKE '%$doc_sub%'";
				$query = $this->db->query($thesql);
				return $query->result();
		}
		
		public function get_section_list(){
			
			 $off_id = $this->session->userdata('off_log_id');
				  
				
				$thesql = "SELECT * FROM off_section WHERE off_id = '1' OR off_id = $off_id";
				$query = $this->db->query($thesql);
				return $query->result();
		}
	
 }
 