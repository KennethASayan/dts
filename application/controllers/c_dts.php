<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dts extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
            $this->load->model('m_dts');
			$this->load->database();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');  
			$this->load->library('dompdf_gen');
			$this->load->library('zip');
			$this->load->helper('download');
			
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
       }
	   
	

	public function index()
	{
		if($this->session->userdata('valid') == TRUE){	 
			redirect('c_dts/record_page');
		}
		else{
		
			$this->load->view('login');
		}
	}
	
	public function login()
	{
		
		$log['uname'] = $this->input->post('uname');
		$log['upwd'] = $this->input->post('upwd');
		$u_flag=$this->m_dts->login($log);
				
		if ($this->m_dts->login($log) != null && $u_flag[0]['stat_flag']!=0)
		{   
			$this->session->set_userdata('valid', TRUE);
			
			$u_log = $this->m_dts->login($log);
			foreach($u_log as $row){
				$this->session->set_userdata('u_log_id', $row['u_id']);
				$this->session->set_userdata('u_log_fname', $row['f_name']);
				$this->session->set_userdata('u_log_lname', $row['l_name']);
				$this->session->set_userdata('role_log_id', $row['role_id']);
				$this->session->set_userdata('role_log_name', $row['role_name']);
				$this->session->set_userdata('div_log_id', $row['div_id']);
				$this->session->set_userdata('div_log_alias', $row['div_alias']);
				$this->session->set_userdata('off_log_id', $row['off_id']);
				$this->session->set_userdata('off_log_pname', $row['p_name']);
				$this->session->set_userdata('off_log_penro', $row['off_name']);
				$this->session->set_userdata('off_log_address', $row['off_address']);
			}
				
				
				redirect('c_dts/record_page');
			
		}
		else
		{
				
				if($u_flag[0]['stat_flag']=='0'){$msg = "Your account is deactivated";}
				else if($log['uname']!=null){$msg = "Incorrect Username/Password";}
				$this->session->set_flashdata('msg',$msg);
				redirect('c_dts');
				
		} 
		
	}
	
	public function logout()
	{
		//$inst='Logged Out';$this->m_ecab->put_logs($inst);
		
		$this->session->sess_destroy();
		
		redirect('c_dts');
	}

	
	public function add_doc()
	{        
		
		$data['div_list'] = $this->m_dts->get_off_div();
		$data['doc_type'] = $this->m_dts->get_doc_type();
		// $data['doc_subject'] = $this->m_dts->get_autocom_records();
		$this->load->view('add_doc',$data);
		
	}
	
	public function act_up()
	{        
		
		$data['doc_no']= $_GET['doc_no'];
		$data['records'] = $this->m_dts->get_records_prev($_GET['doc_no']);
		$data['div_list'] = $this->m_dts->get_off_div();
		$data['doc_type'] = $this->m_dts->get_doc_type();
		//$data['doc_subject'] = $this->m_dts->get_autocom_records();
		//$data['rel_docs'] = $this->m_dts->get_rel_docs();
		$this->load->view('act_up',$data);
		
	}
	
	
	public function get_rel_docs_data()
	{
		
			$draw = intval($this->input->post('draw'));
            $offset = intval($this->input->post('start'));
            $limit = intval($this->input->post('length'));
            $order = $this->input->post('order');
			$search = $this->input->post('search');
			
			$col_name = $this->input->post('columns');
            $column = array($col_name[$order[0]['column']]['data']);
            $orderColumn = isset($order[0]['column']) ? $column[0] : 'doc_no';
            $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
			
            $ordrBy = $orderColumn . " " . $orderDirection;
	
			$query_search='';
			for($x=0;$x<count($col_name);$x++){
				
				$s_col=$col_name[$x]['data'];
				$s_val=$col_name[$x]['search']['value'];
				if($s_val!=''){
					$query_search.='AND '.$s_col.' LIKE "%'.$s_val.'%"';
				}
				
			}
			
			$thesql2 = 'SELECT doc_rec.doc_no, doc_rec.doc_subject, doc_rec.act_date FROM doc_rec WHERE doc_rec.ef_id= "5" AND (doc_rec.doc_no LIKE "'.date('Y').'-%") '.$query_search.' ORDER BY '.$ordrBy;
			
			$thesql = $thesql2.' limit '.$offset.','.$limit;
			
			if (isset($query_search) && !empty($query_search)) {
            
				$result = $this->db->query($thesql);
				$result2 = $this->db->query($thesql2);
				$count = $result2->num_rows();	
				
            } else {
               
				$result = $this->db->query($thesql);
				$result2 = $this->db->query($thesql2);
				$count = $result2->num_rows();			
            }
			
			
			$data=array();
			foreach($result->result_array() as $rec){
				
				
				$data[]=array(
					'doc_no'=>$rec['doc_no'],
					'doc_subject'=>$rec['doc_subject'],
					'act_date'=>$rec['act_date'],
					//'file_name'=>$rec['file_name'],
				);
			}
			
			$output=array(
				"draw" => $draw,
				"recordsTotal" => $count,
				"recordsFiltered" => $count,
				"data" => $data,
			);
			
			echo json_encode($output);
			
		
	}
	
	
	public function act_up_record()
	{       
		date_default_timezone_set('Asia/Manila');
		
		$doc_act_no = null;
		$doc_no = $_GET['doc_no'];
		$nd_act = $this->input->post('nd_act');
		
		
		if($this->input->post('act_select')==4){
			
			$doc_act_no = $this->input->post('doc_act_no');
			$doc_rec_dt = $this->input->post('doc_rec_dt');
			$doc_act_rd = $this->input->post('doc_act_rd');
			//$doc_act_file = $this->input->post('doc_act_file');
			
			
			$act_file = $this->m_dts->get_act_file($doc_act_no);
			foreach ($act_file as $af){$doc_act_file = $af['file_name'];}
			
			
			date_default_timezone_set('Asia/Manila');
			$time_dur=$this->m_dts->get_time_dur($doc_rec_dt,$doc_act_rd);
			
			$this->m_dts->act_up_update($doc_no,$doc_act_no,$time_dur);
			if($doc_act_file!=''){$this->m_dts->put_file(preg_replace('/[^a-zA-Z0-9-_.,()ñÑ]/','_', $doc_act_file),$doc_no);}
			$event='Document Acted by Document No.: '.$doc_act_no; $this->m_dts->put_logs($event,$doc_no);
		}
		else if($this->input->post('act_select')==3){
			
			$max_id = $this->m_dts->get_rec_id();
			foreach ($max_id as $row){$rec_id = sprintf('%04d', $row['max_id']+1);}
			$doc_act_no = date('Y-m').'-'.$rec_id;
			
			$this->m_dts->put_act_record($doc_act_no);
			$event='Document Released by '.$this->session->userdata('u_log_fname')." ".$this->session->userdata('u_log_lname'); $this->m_dts->put_logs($event,$doc_act_no);
			
			$this->m_dts->act_up_update($doc_no,$doc_act_no,$nd_act);
			$event='Document Acted by Document No.: '.$doc_act_no; $this->m_dts->put_logs($event,$doc_no);
		}
		else if($this->input->post('act_select')==2){
			$this->m_dts->act_up_update($doc_no,$doc_act_no,$nd_act);
			$event='Document Acted'; $this->m_dts->put_logs($event,$doc_no);
		}
		else if($this->input->post('act_select')==1){
			
			$event='Forwarded Action Document to PENRO'; $this->m_dts->put_logs($event,$doc_no);
		}
		else if($this->input->post('act_select')==5){
			$this->m_dts->act_up_noact($doc_no);
			$event='No Action Required'; $this->m_dts->put_logs_nan($event,$doc_no);
		}
		
		echo $doc_act_no;
		
	}
	
	public function add_record()
	{             
		date_default_timezone_set('Asia/Manila');
		
		$check_doc=0;
		$max_id = $this->m_dts->get_rec_id();
		// $get_doc_subject = $this->m_dts->get_doc_subject();
		$doc_subject = strtoupper(preg_replace('/[^a-zA-Z0-9-_().: ]/','', trim($this->input->post('doc_subject2'))));
		
		foreach ($max_id as $row){$rec_id = sprintf('%04d', $row['max_id']+1);}
		
		

		$doc_no = date('Y-m').'-'.$rec_id;
		/* foreach ($get_doc_subject as $rec){
			
			if($doc_subject==$rec['doc_subject']){
				$check_doc=1;
			}
		} */
	
		
		if($check_doc==0){
			
			$this->m_dts->put_record($doc_no);
			
			if($this->input->post('doc_class2')==1){$event='Created for Preliminary Routing'; $this->m_dts->put_logs($event,$doc_no);}
			elseif($this->input->post('doc_class2')==2){$event='Document Released by '.$this->session->userdata('u_log_fname')." ".$this->session->userdata('u_log_lname'); $this->m_dts->put_logs($event,$doc_no);}
			
			echo $doc_no;
		}
		
		
		
	}
	
	public function get_prev_page()
	{          
	
	if($this->session->userdata('valid') == TRUE){
		$doc_no = $_GET['doc_no'];
		$data['log_rec'] = $this->m_dts->get_logs($doc_no);
		$data['records'] = $this->m_dts->get_records_prev($doc_no);
		$data['div_list'] = $this->m_dts->get_off_div();
				
		$data['doc_no'] = $doc_no;
		$data['sec_list'] = $this->m_dts->get_off_sec();
		$data['unit_list'] = $this->m_dts->get_off_unit();
		$data['act_desc'] = $this->m_dts->get_act_desc();
		$data['doc_type'] = $this->m_dts->get_doc_type();
		$data['files'] = $this->m_dts->get_files($doc_no);
		
		$this->load->view('preview_page',$data);
	}else{redirect('c_dts');}
	}
	
	public function get_section()
	{   
		$doc_no = $_GET['doc_no'];
		$div_id = $_GET['div_id'];
		$data['records'] = $this->m_dts->get_records_prev($doc_no);
		$data['sec_list'] = $this->m_dts->get_off_sec($div_id);
		
		$this->load->view('sel_section',$data);
	}
	
	public function record_page()
	{    
	if($this->session->userdata('valid') == TRUE){
		
		$data['div_list'] = $this->m_dts->get_off_div();
		$data['doc_type'] = $this->m_dts->get_doc_type();
		
		
		$this->load->view('main',$data);
	}else{redirect('c_dts');}
	}
	
	public function report_page()
	{    
	if($this->session->userdata('valid') == TRUE){
		
		$this->load->view('report_page');
		
	}else{redirect('c_dts');}
	}
	
	public function get_doc_released($month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_released($month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_lop($lop,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_lop($lop,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_types($dt_id,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_types($dt_id,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_offdiv($div_id,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_offdiv($div_id,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_act_class($act_class,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_act_class($act_class,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_act_class_nar($month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_act_class_nar($month,$year,$start_rec,$end_rec);
	}
	
	public function get_penro_doc($month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_penro_doc($month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_recv($month,$year)
	{    
		return $this->m_dts->get_doc_recv($month,$year);
	}
	
	public function get_logs_penro($doc_no)
	{    
		return $this->m_dts->get_logs_penro($doc_no);
	}
	
	public function get_doc_div_recv($div_id,$month,$year)
	{    
		return $this->m_dts->get_doc_div_recv($div_id,$month,$year);
	}
	
	public function get_logs_div($doc_no)
	{    
		return $this->m_dts->get_logs_div($doc_no);
	}
	
	public function get_doc_sec($sec_id,$act_class,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_sec($sec_id,$act_class,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_sec_uni($sec_id,$act_class,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_sec_uni($sec_id,$act_class,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_sec_nar($sec_id,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_sec_nar($sec_id,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_sec_ut($sec_id,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_sec_ut($sec_id,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_sec_ref($sec_id,$month,$year,$start_rec,$end_rec)
	{    
		return $this->m_dts->get_doc_sec_ref($sec_id,$month,$year,$start_rec,$end_rec);
	}
	
	public function get_doc_noh($act_class,$month,$year)
	{    
		return $this->m_dts-> get_doc_noh($act_class,$month,$year);
	}
	
	public function get_docs($month,$year)
	{    
		return $this->m_dts->get_docs($month,$year);
	}
	
	
	public function get_report_page()
	{    
	if($this->session->userdata('valid') == TRUE){
		
		$report_t = $_GET['report_t'];
		$data['semestral'] = $_GET['semestral'];
		$data['rec_yr'] = $_GET['rec_yr'];
		$data['doc_type'] = $this->m_dts->get_doc_type();
		$data['off_sec'] = $this->m_dts->get_all_off_sec();
		$data['controller'] = $this;
		
		
		
		$get_rec_min_max = $this->m_dts->get_rec_min_max($_GET['rec_yr']);
		$start = reset($get_rec_min_max);
		$end = end($get_rec_min_max);
		
		$data['start_rec'] = $start['rec_id'];
		$data['end_rec'] = $end['rec_id'];
		
		
		$this->load->view($report_t,$data);
		
	}else{redirect('c_dts');}
	}
	
		
	public function get_record_data()
	{
			$trigg = $this->input->post('trigg');
			$draw = intval($this->input->post('draw'));
            $offset = intval($this->input->post('start'));
            $limit = intval($this->input->post('length'));
            $order = $this->input->post('order');
			$search = $this->input->post('search');
			
			$col_name = $this->input->post('columns');
            $column = array($col_name[$order[0]['column']]['data']);
            $orderColumn = isset($order[0]['column']) ? $column[0] : 'doc_no';
            $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
			if($orderColumn=='employee_name'){$orderColumn='lastname';}
            $ordrBy = $orderColumn . " " . $orderDirection;
			
			$query_search='';
			for($x=0;$x<count($col_name);$x++){
				
				$s_col=$col_name[$x]['data'];
				$s_val=$col_name[$x]['search']['value'];
				if($s_val!=''){
					$query_search.='AND '.$s_col.' LIKE "%'.$s_val.'%"';
				}
				
			}
			
			$div_id = $this->session->userdata('div_log_id');
			//if(isset($_GET['trigg'])){$trigg = $_GET['trigg'];}
			
			$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE 1 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;
			  if($div_id==1){
				  if($trigg==0 OR $trigg==99){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE 1 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==4){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 1 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==3){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE 1 AND (doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10 OR doc_rec.doc_no NOT LIKE "%'.date('Y').'%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==5){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 6 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==6){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.ef_id = 9 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				 }
			  else{
				  if($trigg==0 OR $trigg==99){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND doc_rec.ef_id != 6 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==1){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND doc_rec.ef_id = 2 '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==2){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND (doc_rec.ef_id != 2 AND doc_rec.ef_id != 6 AND doc_rec.ef_id != 7 AND doc_rec.ef_id != 8 AND doc_rec.ef_id != 9 AND doc_rec.ef_id != 10) '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==3){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND (doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10 OR doc_rec.doc_no NOT LIKE "%'.date('Y').'%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==6){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND doc_rec.ef_id = 9 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				}
			
			$thesql = $thesql2.' limit '.$offset.','.$limit;
			
			if (isset($query_search) && !empty($query_search)) {
            
				$result = $this->db->query($thesql);
				$result2 = $this->db->query($thesql2);
				$count = $result2->num_rows();	
				
            } else {
               
				$result = $this->db->query($thesql);
				$result2 = $this->db->query($thesql2);
				$count = $result2->num_rows();			
            }
			
			
			
			$secs = $this->db->query("SELECT * FROM off_section");
					
			$data=array();
			foreach($result->result_array() as $rec){
				
				if($rec['act_class']!='0' AND $rec['act_class']!=''){$act_class=$rec['act_class'];}else{$act_class='-';}
				if($rec['ef_description']=='Acted'){$ef_description = $rec['ef_description']." within ".$rec['nd_act'];}else{$ef_description = $rec['ef_description'];}
				
				date_default_timezone_set('Asia/Manila');
				$time_dur=$this->m_dts->get_time_dur($rec['dt_recv'],date('Y-m-d H:i:s'));
				
				$ref_sec='';
				foreach($secs->result_array() as $sec){
					//if(strpos($rec['sec_id'],$sec['sec_id'].",")!==false){
					if(preg_match("/\b".$sec['sec_id']."\b/i",$rec['sec_id'])){
						$ref_sec .= $sec['sec_alias']." ";
					}
				}
						
				$data[]=array(
					'rec_id'=>$rec['rec_id'],
					'doc_no'=>$rec['doc_no'],
					'sender'=>$rec['sender'],
					'doc_date'=>$rec['doc_date'],
					'doc_subject'=>$rec['doc_subject'],
					'rec_date'=>$rec['rec_date'],
					'act_class'=>$act_class,
					//'prior_t'=>$rec['prior_t'],
					'sec_id'=>$ref_sec,
					'ef_description'=>$ef_description,
					'dt_recv'=>$time_dur,
				);
			}
			
			$output=array(
				"draw" => $draw,
				"recordsTotal" => $count,
				"recordsFiltered" => $count,
				"data" => $data,
			);
			
			echo json_encode($output);
			
		
	}
	
	
	public function delete_record()
	{		
		sleep(2);
		$this->m_dts->delete_record();
		$this->m_dts->delete_files();
		$this->m_dts->delete_logs();
	}
	
	public function update_record()
	{		
		
		$doc_no = $_GET['doc_no'];
		$ef_id = $_GET['ef_id'];
		
		if($this->input->post('doc_class')==1){	
			if($ef_id==5){
				$ef_id = 1;
				$event='Created for Preliminary Routing'; $this->m_dts->put_logs($event,$doc_no);
			}
		}
		if($this->input->post('doc_class')==2){	
			if($ef_id!=5){
				$ef_id = 5;
				$event='Released by '.$this->session->userdata('div_log_alias'); $this->m_dts->put_logs($event,$doc_no);
			}
		}
		
		$this->m_dts->update_record($doc_no,$ef_id);
		
	}
	
	public function update_stat()
	{		
		$doc_no = $_GET['doc_no'];
		$ef_id = $_GET['ef_id'];
		
		$div_list = $this->m_dts->get_off_div();
		$sec_list = $this->m_dts->get_off_sec();
		$unit_list = $this->m_dts->get_off_unit();
		$this->m_dts->update_stat($doc_no,$ef_id);
		
		$div_sel='';
		$sec_sel='';
		$unit_sel='';
				
		if($ef_id==2){
			$x=1;
			foreach($this->input->post('div_id') as $div_select){
					foreach($div_list as $list){
						if($list['div_id']!=1){
							if($div_select==$list['div_id']){ 
								if($x<2){$div_sel .= $list['div_alias'];}
								else{$div_sel .= ", ".$list['div_alias'];}
							}
						}
					}
					$x++;
			}
			
			$event='Routed to '.$div_sel; $this->m_dts->put_logs($event,$doc_no);
			
			
		}
		elseif($ef_id==3){
			$x=1;
			foreach($this->input->post('sec_id') as $sec_select){
					foreach($sec_list as $list){
						if($sec_select==$list['sec_id']){ 
							if($x<2){$sec_sel .= $list['sec_alias'];}
							else{$sec_sel .= ", ".$list['sec_alias'];}
						}
					}
					$x++;
			}
			$x=1;
			foreach($this->input->post('unit_id') as $unit_select){
					foreach($unit_list as $list){
						if($unit_select==$list['unit_id']){ 
							if($x<2){$unit_sel .= $list['unit_alias'];}
							else{$unit_sel .= ", ".$list['unit_alias'];}
						}
					}
					$x++;
			}
			if($sec_sel!='' and $unit_sel!=''){
				$event='Routed to Section(s):'.$sec_sel."; Unit(s):".$unit_sel; $this->m_dts->put_logs($event,$doc_no);
			}
			elseif($sec_sel!='' and $unit_sel==''){
				$event='Routed to Section(s):'.$sec_sel; $this->m_dts->put_logs($event,$doc_no);
			}
			elseif($sec_sel=='' and $unit_sel!=''){
				$event='Routed to Unit(s):'.$unit_sel; $this->m_dts->put_logs($event,$doc_no);
			}
			
			//if($this->input->post('act_flag')==1){$event='Waiting for Action'; $this->m_dts->put_logs($event,$doc_no);}
		}
		elseif($ef_id==4){
			$event='Received by '.$this->session->userdata('div_log_alias'); $this->m_dts->put_logs($event,$doc_no);
		}
		elseif($ef_id==6){
			$event='Returned to PENRO Receiving/Releasing'; $this->m_dts->put_logs($event,$doc_no);
		}
		elseif($ef_id==7){
			$event='For Chief '.$this->session->userdata('div_log_alias').' File'; $this->m_dts->put_logs($event,$doc_no);
		}
		elseif($ef_id==8){
			$event='Acknowledge by Recipient'; $this->m_dts->put_logs($event,$doc_no);
		}
		
	}
	
	public function delete_file_sel()
	{	
		$file_id = $_GET['f_id'];
		$file_name = $_GET['f_name'];
			
		$this->m_dts->delete_upfile_sel($file_id,$file_name);
	}
	
	public function get_logs()
	{     
		$doc_no = $_GET['doc_no'];
		$data['log_rec'] = $this->m_dts->get_logs($doc_no);
		
		$this->load->view('log_page',$data);
		
	}
	
	function upload(){
				  sleep(2);
				  if($_FILES["files"]["name"] != '')
				  {
				   $output = '';
				   $config["upload_path"] = './uploads/';
				   $config["allowed_types"] = 'pdf';
				   $this->load->library('upload', $config);
				   $this->upload->initialize($config);
				   for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
				   {
						$doc_no = $_GET['doc_no'];
						$doc_act_no = $_GET['doc_act_no'];
						$file_name = $_FILES["files"]["name"][$count];
						$_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
						$_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
						$_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
						$_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
						$_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
						
						
							if($this->upload->do_upload('file'))
							{
								$data = $this->upload->data();	
								 
								$this->m_dts->put_file(preg_replace('/[^a-zA-Z0-9-_.,()ñÑ]/','_', $data["file_name"]),$doc_no);
								if($doc_act_no!=null){$this->m_dts->put_file(preg_replace('/[^a-zA-Z0-9-_.,()ñÑ]/','_', $data["file_name"]),$doc_act_no);}
								
								$output .= '
											 <div style="float:left">
											  <a id="att_fn" href="'.base_url().'uploads/'.$data["file_name"].'" target="_blank">'.$data["file_name"].'</a>
											 </div>
								';
						}
				   }
				   echo $output;   
				  }
	}
	
	
	public function route_slip()
	{ 
		$doc_no = $_GET['doc_no'];
		
		$data['records'] = $this->m_dts->get_records_prev($doc_no);
		$data['div_list'] = $this->m_dts->get_off_div();
		$data['sec_list'] = $this->m_dts->get_off_sec();
		$data['act_desc'] = $this->m_dts->get_act_desc();
		$data['log_route'] = $this->m_dts->get_log_route($doc_no);
		
		$this->load->view('rtslip_pdf', $data);
		$this->dompdf->set_paper("A4", "portrait");
		$html = $this->output->get_output();
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Routing_Slip.pdf",array('Attachment'=>0));
		//$this->dompdf->stream("welcome.pdf");
		
	}
	
	public function report_pdf()
	{ 
		$data['rep_id'] = $_GET['rep_id'];
		$data['semestral'] = $_GET['semestral'];
		$data['rec_yr'] = $_GET['rec_yr'];
		$data['doc_type'] = $this->m_dts->get_doc_type();
		$data['off_sec'] = $this->m_dts->get_all_off_sec();
		$data['controller'] = $this;
		
		$get_rec_min_max = $this->m_dts->get_rec_min_max($_GET['rec_yr']);
		$start = reset($get_rec_min_max);
		$end = end($get_rec_min_max);
		
		$data['start_rec'] = $start['rec_id'];
		$data['end_rec'] = $end['rec_id'];
		
		$this->load->view('report_pdf', $data);
		
		$html = $this->output->get_output();
		$this->dompdf->set_paper("legal", "landscape");
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("Report.pdf",array('Attachment'=>0));
		//$this->dompdf->stream("welcome.pdf");
		
	}
	
	public function user_page()
	{
	if($this->session->userdata('valid') == TRUE){
				
		$data['user'] = $this->m_dts->get_user();
		$data['off_div'] = $this->m_dts->get_div();
		$data['off_role'] = $this->m_dts->get_office_role();
		$data['u_off'] = $this->m_dts->get_office();
		$data['msg'] = $this->session->flashdata('msg');
		
				
		$this->load->view('ua_page',$data);
	}else{redirect('c_dts');}	
	}
	
	public function ua_ctrl()
	{
		$trig = $this->input->post('trig');
		if($trig==1){$this->m_dts->put_newu();$msg='Added';}
		else if($trig==2){$this->m_dts->update_ua();$msg='Updated';}
		else if($trig==3){$this->m_dts->delete_ua();$msg='Deleted';}
		else if($trig==4){$this->m_dts->rpwd_ua();$msg='Reset Password';}
		
		$this->session->set_flashdata('msg',$msg);
		redirect('c_dts/user_page');
		
	}
	
	public function cpwd_page()
	{      	
	if($this->session->userdata('valid') == TRUE){
	
		$this->load->view('cpwd_page');
		
	}else{redirect('c_dts');}
	}
	
	public function update_pwd()
	{      
		$o_pwd = $this->input->post('o_pwd');
		
		if($this->m_dts->get_user_indiv($o_pwd) != null){
			$this->m_dts->update_pwd();
			$this->session->sess_destroy();
			
		}
		else{
			$msg = 'Old password does not matched.';
		}
			$this->session->set_flashdata('msg',$msg);
			redirect('c_dts/cpwd_page');
		
	}
	
	public function export_page()
	{   
		if($this->session->userdata('valid') == TRUE){
	
		$data['records'] = $this->m_dts->get_exp_records();
		$data['div_list'] = $this->m_dts->get_off_div();
		
		$data['page'] = 'export_page';
		$this->load->view('export_page',$data);
		
		
		}else{redirect('c_dts');}

	}
	
	public function get_export_page_data()
	{
		
			$draw = intval($this->input->post('draw'));
            $offset = intval($this->input->post('start'));
            $limit = intval($this->input->post('length'));
            $order = $this->input->post('order');
			$search = $this->input->post('search');
			
			$col_name = $this->input->post('columns');
            $column = array($col_name[$order[0]['column']+1]['data']);
            $orderColumn = isset($order[0]['column']) ? $column[0] : 'doc_no';
            $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
			
            $ordrBy = $orderColumn . " " . $orderDirection;
	
			$query_search='';
			for($x=0;$x<count($col_name);$x++){
				
				$s_col=$col_name[$x]['data'];
				$s_val=$col_name[$x]['search']['value'];
				if($s_val!=''){
					$query_search.='AND '.$s_col.' LIKE "%'.$s_val.'%"';
				}
				
			}
			
				$div_id = $this->session->userdata('div_log_id');
				
				  if($div_id==1){
					  $thesql2 = "SELECT * FROM doc_rec 
								  INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) 
								  INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) 
								   WHERE doc_rec.doc_no LIKE '%".date('Y')."%' ".$query_search." ORDER BY ".$ordrBy;
				  }
				  else{
					$thesql2 = "SELECT * FROM doc_rec 
							  INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) 
							  INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) 
							  WHERE doc_rec.div_id LIKE '%,$div_id,%' AND doc_rec.doc_class = '1' AND doc_rec.ef_id != 6 AND doc_rec.doc_no LIKE '%".date('Y')."%'".$query_search." ORDER BY ".$ordrBy;
				  }	
				
			
			$thesql = $thesql2.' limit '.$offset.','.$limit;
			
			if (isset($query_search) && !empty($query_search)) {
            
				$result = $this->db->query($thesql);
				$result2 = $this->db->query($thesql2);
				$count = $result2->num_rows();	
				
            } else {
               
				$result = $this->db->query($thesql);
				$result2 = $this->db->query($thesql2);
				$count = $result2->num_rows();			
            }
			
			$div_list = $this->m_dts->get_off_div();
			
			$data=array();
			foreach($result->result_array() as $rec){
									
									
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
				$act_class = "";			
				 if($rec['act_class']!='0' AND $rec['act_class']!=''){$act_class = $rec['act_class'];}else{$act_class = '-';}
				
				$data[]=array(
					'sel_box'=>'',
					'doc_no'=>$rec['doc_no'],
					'doc_description'=>$rec['doc_description'],
					'sender'=>$rec['sender'],
					'doc_date'=>$rec['doc_date'],
					'doc_subject'=>$rec['doc_subject'],
					'rec_date'=>$rec['rec_date'],
					'div_sel'=>$div_sel,
					'ef_description'=>$rec['ef_description'],
					'act_date'=>$rec['act_date'],
					'act_class'=>$act_class,
					'prior_t'=>$rec['prior_t'],
					'nd_act'=>$rec['nd_act'],
					'act_cn'=>$rec['act_cn'],
				);
			}
			
			$output=array(
				"draw" => $draw,
				"recordsTotal" => $count,
				"recordsFiltered" => $count,
				"data" => $data,
			);
			
			echo json_encode($output);
			
		
	} 
	
	public function autocom_subject()
	{
			
		$query = "SELECT doc_subject FROM doc_rec";
		$result = $this->db->query($query);
		
		$data=array();
		foreach($result->result_array() as $rec){
			
			$data[]=array(
				$rec['doc_subject'],
			);
			
		}
		
		echo json_encode($data);
			
	}
	
	public function system_update()
	{   
		if($this->session->userdata('valid') == TRUE){
		
		$data['sys_up'] = $this->m_dts->get_sys_up();
		
		$this->load->view('system_update',$data);
		
		}else{redirect('c_dts');}

	}
	
	
	public function get_doc_subjects()
	{ 
		$doc_sub=$this->input->post('doc_subject');
		echo json_encode($this->m_dts->get_doc_subjects($doc_sub));
	}
	
	public function get_count_rec()
	{ 
		$doc_cat=$this->input->post('doc_cat');
		echo json_encode($this->m_dts->get_count_rec($doc_cat));
	}
	
	public function get_section_list()
	{ 
		echo json_encode($this->m_dts->get_section_list());
	}
	
	
}