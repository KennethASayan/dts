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
		$this->load->library('mpdf_gen');
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
		
		// Call login once and store result in array
		$u_log = $this->m_dts->login($log);
		
		// Check if user exists and account is active
		if ($u_log != null && is_array($u_log) && count($u_log) > 0 && $u_log[0]['stat_flag'] != 0)
		{   
			// Set session valid and all user data from the array at once
			$this->session->set_userdata('valid', TRUE);
			
			$user_data = array(
				'u_log_id' => $u_log[0]['u_id'],
				'u_log_fname' => $u_log[0]['f_name'],
				'u_log_lname' => $u_log[0]['l_name'],
				'role_log_id' => $u_log[0]['role_id'],
				'role_log_name' => $u_log[0]['role_name'],
				'div_log_id' => $u_log[0]['div_id'],
				'div_log_alias' => $u_log[0]['div_alias'],
				'off_log_id' => $u_log[0]['off_id'],
				'off_log_pname' => $u_log[0]['p_name'],
				'off_log_penro' => $u_log[0]['off_name'],
				'off_log_address' => $u_log[0]['off_address']
			);
			
			// Set all user data at once
			$this->session->set_userdata($user_data);
			
			redirect('c_dts/record_page');
		}
		else
		{
			// Set error message based on login result
			$msg = "Incorrect Username/Password";
			if ($u_log != null && is_array($u_log) && count($u_log) > 0 && $u_log[0]['stat_flag'] == 0) {
				$msg = "Your account is deactivated";
			}
			
			$this->session->set_flashdata('msg', $msg);
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
		
		// ✅ FIRST: Try to get RO In-Transit document data
		$api_base_url = 'https://dmsapi.denr10.com.ph';
		$user_office = $this->session->userdata('off_log_penro');
		
		$ro_intransit_result = null;
		if ($user_office) {
			$api_url = $api_base_url . '/dms/documents/ro-in-transit?per_page=100&office_name=' . urlencode($user_office);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($http_code === 200 && $response) {
				$api_response = json_decode($response, true);
				if (isset($api_response['data']) && is_array($api_response['data'])) {
					// Find the document matching this doc_no
					foreach ($api_response['data'] as $doc) {
						if (isset($doc['document_no']) && $doc['document_no'] === $doc_no) {
							$ro_intransit_result = $doc;
							break;
						}
					}
				}
			}
		}
		
		// ✅ Load legacy data for records
		$data['log_rec'] = $this->m_dts->get_logs($doc_no);
		$data['records'] = $this->m_dts->get_records_prev($doc_no);
		$data['div_list'] = $this->m_dts->get_off_div();
		$data['doc_no'] = $doc_no;
		$data['sec_list'] = $this->m_dts->get_off_sec();
		$data['unit_list'] = $this->m_dts->get_off_unit();
		$data['act_desc'] = $this->m_dts->get_act_desc();
		$data['doc_type'] = $this->m_dts->get_doc_type();
		
		// ✅ If RO In-Transit document found, set its data
		if ($ro_intransit_result) {
			$data['files'] = array();
			$data['is_ro_intransit'] = true;
			
			// Always set metadata from the list response first
			$data['ro_metadata'] = array(
				'document_no' => $ro_intransit_result['document_no'],
				'subject' => $ro_intransit_result['subject'],
				'sender' => $ro_intransit_result['sender'],
				'priority_level' => $ro_intransit_result['priority_level'] ?? 'N/A',
				'recipient' => $ro_intransit_result['recipient'] ?? 'N/A',
				'date_released' => $ro_intransit_result['date_released'] ?? 'N/A',
				'document_date' => $ro_intransit_result['document_date_formatted'] ?? 'N/A',
				'date_uploaded' => $ro_intransit_result['date_received_formatted'] ?? 'N/A'
			);
			
			// Fetch detail to get files
			$detail_url = $api_base_url . '/dms/documents/ro-in-transit/' . $ro_intransit_result['incoming_initial_id'];
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $detail_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);
			
			// Log the API response for debugging
			error_log("RO Detail API - URL: $detail_url | HTTP Code: $http_code | Curl Error: $curl_error");
			if ($response) {
				error_log("RO Detail API Response: " . substr($response, 0, 500));
			}
			
			if ($http_code === 200 && $response) {
				$detail_response = json_decode($response, true);
				error_log("RO Detail Decoded - Success: " . (isset($detail_response['success']) ? ($detail_response['success'] ? 'true' : 'false') : 'unknown'));
				
				if (isset($detail_response['data']) && isset($detail_response['data']['uploading_of_final_action'])) {
					$detail_data = $detail_response['data'];
					error_log("RO Detail - uploading_of_final_action count: " . count($detail_data['uploading_of_final_action']));
					
					// Extract files from uploading_of_final_action
					if (is_array($detail_data['uploading_of_final_action']) && count($detail_data['uploading_of_final_action']) > 0) {
						foreach ($detail_data['uploading_of_final_action'] as $upload) {
							error_log("RO Detail - Processing upload: " . json_encode($upload));
							if (isset($upload['final_action_document'])) {
								$files_to_process = [];
								if (is_array($upload['final_action_document'])) {
									$files_to_process = $upload['final_action_document'];
								} elseif (is_string($upload['final_action_document']) && !empty($upload['final_action_document'])) {
									$files_to_process = [$upload['final_action_document']];
								}
								
								error_log("RO Detail - Files to process: " . count($files_to_process));
								foreach ($files_to_process as $file) {
									if (!empty($file)) {
										$data['files'][] = array(
											'file_name' => $file,
											'office_name' => $upload['office_name'] ?? 'Unknown',
											'date_released' => $upload['date_released'] ?? null
										);
										error_log("RO Detail - File added: $file");
									}
								}
							}
						}
					} else {
						error_log("RO Detail - uploading_of_final_action is empty or not an array");
					}
				} else {
					error_log("RO Detail - Missing data or uploading_of_final_action. Keys: " . implode(', ', isset($detail_response['data']) ? array_keys($detail_response['data']) : ['none']));
				}
			} else {
				error_log("RO Detail API Failed - HTTP $http_code, Response: $response");
			}
		} else {
			// Fallback to legacy DTS system
			$data['files'] = $this->m_dts->get_files($doc_no);
			$data['is_ro_intransit'] = false;
			$data['ro_metadata'] = null;
		}
		
		$this->load->view('preview_page',$data);
	}else{redirect('c_dts');}
	}
	
	/**
	 * Fetch RO In-Transit document files and metadata from the uploading of final action
	 * Returns array with 'files' and 'metadata' if RO In-Transit document exists, false otherwise
	 */
	private function get_ro_intransit_files($doc_no)
	{
		try {
			log_message('info', 'DTS - Searching for RO In-Transit document: ' . $doc_no);
			
			// Get user's office from session for filtering
			$user_office = $this->session->userdata('off_log_penro');
			if (!$user_office) {
				log_message('warning', 'DTS - User office not found in session');
				return false;
			}
			
			log_message('info', 'DTS - User office: ' . $user_office);
			
			$api_base_url = 'https://dmsapi.denr10.com.ph';
			$api_url = $api_base_url . '/dms/documents/ro-in-transit?per_page=100&office_name=' . urlencode($user_office);
			
			log_message('info', 'DTS - API URL: ' . $api_url);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);
			
			log_message('info', 'DTS - RO In-Transit list API HTTP Code: ' . $http_code);
			
			if ($curl_error) {
				log_message('error', 'DTS - cURL Error: ' . $curl_error);
				return false;
			}
			
			if ($http_code !== 200 || !$response) {
				log_message('error', 'DTS - API Error HTTP ' . $http_code . ' Response: ' . substr($response, 0, 200));
				return false;
			}
			
			$api_response = json_decode($response, true);
			log_message('info', 'DTS - API Response: success=' . ($api_response['success'] ?? 'false') . ', data_count=' . count($api_response['data'] ?? []));
			
			if (!isset($api_response['success']) || !$api_response['success'] || !isset($api_response['data'])) {
				log_message('error', 'DTS - Invalid API response structure');
				return false;
			}
			
			// Find the document matching the doc_no
			$documents = $api_response['data'];
			$document = null;
			
			foreach ($documents as $doc) {
				if (isset($doc['document_no']) && $doc['document_no'] === $doc_no) {
					$document = $doc;
					log_message('info', 'DTS - Found RO In-Transit document: ' . $doc_no);
					break;
				}
			}
			
			if (!$document) {
				log_message('info', 'DTS - Document not found in RO In-Transit list: ' . $doc_no . '. Available docs: ' . json_encode(array_column($documents, 'document_no')));
				return false;
			}
			
			// Get the document ID and fetch uploading of final action files
			$doc_id = $document['incoming_initial_id'];
			log_message('info', 'DTS - Fetching document detail, ID: ' . $doc_id);
			
			$detail_url = $api_base_url . '/dms/documents/ro-in-transit/' . $doc_id;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $detail_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);
			
			log_message('info', 'DTS - Detail API HTTP Code: ' . $http_code);
			
			if ($curl_error) {
				log_message('error', 'DTS - Detail cURL Error: ' . $curl_error);
				return false;
			}
			
			if ($http_code !== 200 || !$response) {
				log_message('error', 'DTS - Detail API Error HTTP ' . $http_code);
				return false;
			}
			
			$detail_response = json_decode($response, true);
			log_message('info', 'DTS - Detail Response: ' . json_encode([
				'success' => $detail_response['success'] ?? false,
				'has_uploading' => isset($detail_response['data']['uploading_of_final_action']),
				'upload_count' => count($detail_response['data']['uploading_of_final_action'] ?? [])
			]));
			
			if (!isset($detail_response['success']) || !$detail_response['success'] || !isset($detail_response['data'])) {
				log_message('error', 'DTS - Invalid detail response');
				return false;
			}
			
			$document_detail = $detail_response['data'];
			$files_array = array();
			
			// ✅ Extract files from uploading of final action history
			if (isset($document_detail['uploading_of_final_action']) && is_array($document_detail['uploading_of_final_action'])) {
				log_message('info', 'DTS - Found ' . count($document_detail['uploading_of_final_action']) . ' uploading records');
				
				foreach ($document_detail['uploading_of_final_action'] as $upload) {
					// Each upload record has final_action_document files
					if (isset($upload['final_action_document'])) {
						// Handle both string and array formats
						$files_to_process = [];
						if (is_array($upload['final_action_document'])) {
							$files_to_process = $upload['final_action_document'];
						} elseif (is_string($upload['final_action_document']) && !empty($upload['final_action_document'])) {
							// Single file as string
							$files_to_process = [$upload['final_action_document']];
						}
						
						if (!empty($files_to_process)) {
							log_message('info', 'DTS - Upload from ' . ($upload['office_name'] ?? 'Unknown') . ' has ' . count($files_to_process) . ' files');
							
							foreach ($files_to_process as $file) {
								if (!empty($file)) {
									$files_array[] = array(
										'file_name' => $file,
										'office_name' => $upload['office_name'] ?? 'Unknown',
										'date_released' => $upload['date_released'] ?? null
									);
								}
							}
						}
					}
				}
			} else {
				log_message('info', 'DTS - No uploading_of_final_action data found');
			}
			
			log_message('info', 'DTS - Total files found before dedup: ' . count($files_array));
			
			// ✅ DEDUPLICATE FILES - remove exact duplicates
			$unique_files = array();
			$seen_filenames = array();
			foreach ($files_array as $file_entry) {
				$filename = $file_entry['file_name'];
				if (!in_array($filename, $seen_filenames)) {
					$unique_files[] = $file_entry;
					$seen_filenames[] = $filename;
				}
			}
			
			// ✅ Return files with document metadata
			// Always return metadata even if there are no files yet
			return array(
				'files' => $unique_files,
				'metadata' => array(
					'document_no' => $document['document_no'],
					'subject' => $document['subject'],
					'sender' => $document['sender'],
					'priority_level' => $document['priority_level'] ?? 'N/A',
					'recipient' => $document['recipient'] ?? 'N/A',
					'date_released' => $document['date_released'] ?? 'N/A',
					'document_date' => $document['document_date_formatted'] ?? 'N/A',
					'date_uploaded' => $document['date_received_formatted'] ?? 'N/A'
				)
			);
			
		} catch (Exception $e) {
			log_message('error', 'RO In-Transit file fetch error: ' . $e->getMessage());
			return false;
		}
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
			$trigg = intval($this->input->post('trigg'));
			$draw = intval($this->input->post('draw'));
            $offset = intval($this->input->post('start'));
            $limit = intval($this->input->post('length'));
            $order = $this->input->post('order');
			$search = $this->input->post('search');
			
			// ✅ Handle RO In-Transit separately
			if($trigg == 7) {
				return $this->get_ro_intransit_data_internal($draw, $offset, $limit, $search);
			}
			
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
				  // ✅ FIX: For non-PENRO offices, show documents routed to them OR routed to PENRO (parent) OR unrouted documents
				  if($trigg==0 OR $trigg==99){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE (doc_rec.div_id LIKE "%,'.$div_id.',%" OR doc_rec.div_id LIKE "%,1,%" OR (doc_rec.div_id IS NULL OR doc_rec.div_id = ",") OR doc_rec.doc_class = "2") AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==1){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND doc_rec.ef_id = 2 '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==2){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND (doc_rec.ef_id != 2 AND doc_rec.ef_id != 6 AND doc_rec.ef_id != 7 AND doc_rec.ef_id != 8 AND doc_rec.ef_id != 9 AND doc_rec.ef_id != 10) '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==3){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND (doc_rec.ef_id = 7 OR doc_rec.ef_id = 8 OR doc_rec.ef_id = 5 OR doc_rec.ef_id = 10 OR doc_rec.doc_no NOT LIKE "%'.date('Y').'%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==4){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND doc_rec.ef_id = 1 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
				  elseif($trigg==5){$thesql2 = 'SELECT * FROM doc_rec INNER JOIN event_flags ON (doc_rec.ef_id = event_flags.ef_id) INNER JOIN doc_type ON (doc_rec.dt_id = doc_type.dt_id) WHERE doc_rec.div_id LIKE "%,'.$div_id.',%" AND doc_rec.doc_class = "1" AND doc_rec.ef_id = 6 AND (doc_rec.doc_no LIKE "'.date('Y').'-%" OR doc_rec.doc_no LIKE "'.(date('Y')-1).'-12-%") '.$query_search.' ORDER BY '.$ordrBy;}
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
	
	/**
	 * ✅ Mark RO In-Transit document as received
	 * Sends update to Laravel r10api AND creates DTS record in doc_rec table
	 */
	public function receive_ro_intransit()
	{
		try {
			date_default_timezone_set('Asia/Manila');
			
			header('Content-Type: application/json');
			
			$doc_no = isset($_GET['doc_no']) ? $_GET['doc_no'] : null;
			
			if (!$doc_no) {
				http_response_code(400);
				echo json_encode(array('success' => false, 'message' => 'Missing doc_no parameter'));
				exit;
			}
			
			// Get user's office from session
			$user_office = $this->session->userdata('off_log_penro');
			$user_id = $this->session->userdata('u_log_id');
			$receiving_div_id = $this->session->userdata('div_log_id');
			$user_fname = $this->session->userdata('u_log_fname');
			$user_lname = $this->session->userdata('u_log_lname');
			
			// ✅ DEBUG: Check what we actually got from session
			$response_debug = array(
				'session_user_office' => $user_office,
				'session_user_id' => $user_id,
				'session_div_id' => $receiving_div_id,
				'session_user_name' => $user_fname . ' ' . $user_lname
			);
			
			if (!$user_office || !$user_id) {
				http_response_code(401);
				echo json_encode(array(
					'success' => false, 
					'message' => 'User session expired or not set',
					'debug' => $response_debug
				));
				exit;
			}
			
			// ✅ CRITICAL: Check if div_log_id is set, if not the session might be invalid
			if (!$receiving_div_id) {
				log_message('warning', 'DTS - div_log_id not found in session, user might need to relogin');
				http_response_code(401);
				echo json_encode(array('success' => false, 'message' => 'Division information missing - please reload page or login again'));
				exit;
			}
			
			$api_base_url = 'https://dmsapi.denr10.com.ph';
			
			// First, fetch the document to get its ID and metadata
			$list_url = $api_base_url . '/dms/documents/ro-in-transit?per_page=100&office_name=' . urlencode($user_office);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $list_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$curl_error = curl_error($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($curl_error) {
				log_message('error', 'DTS - cURL error fetching RO In-Transit list: ' . $curl_error);
				http_response_code(502);
				echo json_encode(array('success' => false, 'message' => 'Connection error: ' . $curl_error));
				exit;
			}
			
			if ($http_code !== 200 || !$response) {
				log_message('error', 'DTS - Failed to fetch RO In-Transit list. HTTP: ' . $http_code . ', Response: ' . $response);
				http_response_code(502);
				echo json_encode(array('success' => false, 'message' => 'Failed to fetch document from API (HTTP ' . $http_code . ')'));
				exit;
			}
			
			$api_response = json_decode($response, true);
			if (!isset($api_response['data']) || !is_array($api_response['data'])) {
				log_message('error', 'DTS - Invalid API response structure: ' . json_encode($api_response));
				http_response_code(502);
				echo json_encode(array('success' => false, 'message' => 'Invalid API response'));
				exit;
			}
			
			// Find the document matching doc_no
			$document = null;
			$doc_id = null;
			foreach ($api_response['data'] as $doc) {
				if (isset($doc['document_no']) && $doc['document_no'] === $doc_no) {
					$document = $doc;
					$doc_id = $doc['incoming_initial_id'];
					break;
				}
			}
			
			if (!$doc_id || !$document) {
				log_message('error', 'DTS - Document not found in API: ' . $doc_no . '. Response data: ' . json_encode($api_response['data']));
				http_response_code(404);
				echo json_encode(array('success' => false, 'message' => 'Document not found in API'));
				exit;
			}
			
			// ✅ Fetch document detail to get files
			$document_detail = null;
			$detail_url = $api_base_url . '/dms/documents/ro-in-transit/' . $doc_id;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $detail_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$detail_response = curl_exec($ch);
			$detail_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$detail_curl_error = curl_error($ch);
			curl_close($ch);
			
			if (!$detail_curl_error && $detail_http_code === 200 && $detail_response) {
				$detail_decoded = json_decode($detail_response, true);
				if (isset($detail_decoded['success']) && $detail_decoded['success'] && isset($detail_decoded['data'])) {
					$document_detail = $detail_decoded['data'];
					log_message('info', 'DTS - Successfully fetched document detail with files');
				}
			}
			
			// ✅ Create a record in doc_rec table for DTS tracking
			// Generate a new DTS document number (not using RO In-Transit doc_no)
			$max_id_query = $this->db->query("SELECT MAX(rec_id) AS max_id FROM doc_rec");
			$max_id_result = $max_id_query->result_array();
			$next_rec_id = sprintf('%04d', $max_id_result[0]['max_id'] + 1);
			$generated_doc_no = date('Y-m') . '-' . $next_rec_id;  // Generate DTS format doc_no like 2026-03-0065
			
			// Use same date format as other DTS records: M-d-Y
			$current_date = date('M-d-Y');
			$current_time = date('h:i A');
			
			// ✅ FIX: Set div_id for the receiving office so document shows in their records
			// Use the div_log_id we already validated above
			$div_id_formatted = ',' . $receiving_div_id . ',';  // Format with commas for LIKE query
			
			log_message('info', 'DTS - Setting div_id for record: ' . $div_id_formatted . ' (receiving_div_id: ' . $receiving_div_id . ')');
			
			$dts_record = array(
				'doc_no' => $generated_doc_no,  // ✅ Use generated DTS doc_no, not RO In-Transit doc_no
				'u_id' => $user_id,
				'doc_class' => 1,  // 1 = Regular document
				'dt_id' => 1,  // Default document type (adjust if needed)
				'doc_subject' => strtoupper(substr(isset($document['subject']) ? $document['subject'] : 'RO IN-TRANSIT DOC', 0, 255)),
				'sender' => strtoupper(substr(isset($document['sender']) ? $document['sender'] : 'FIELD OFFICE', 0, 100)),
				'doc_date' => $current_date,
				'rec_date' => $current_date,
				'act_date' => $current_date,
				'rec_time' => $current_time,
				'doc_date_rr' => $current_date,
				'doc_time_rr' => $current_time,
				'res_type' => 'RO In-Transit',
				'div_id' => $div_id_formatted,  // ✅ SET div_id so document is visible to receiving office
				'ef_id' => 1,  // ✅ Event flag 1 = For Routing (automatically put in routing queue)
				'act_flag' => 0,
				'prior_t' => 'Normal'
			);
			
			// Insert into doc_rec
			$this->db->insert('doc_rec', $dts_record);
			
			// Check for database errors
			if ($this->db->affected_rows() === 0) {
				$last_query = $this->db->last_query();
				log_message('error', 'DTS - Database insert failed for RO In-Transit. Last query: ' . $last_query);
				http_response_code(500);
				echo json_encode(array('success' => false, 'message' => 'Database error: Failed to insert record'));
				exit;
			}
			
			log_message('info', 'DTS - Successfully inserted doc_rec entry for RO In-Transit: ' . $doc_no . ' as DTS doc_no: ' . $generated_doc_no);
			
			// ✅ Extract and save files to uplink table from the document metadata
			if (isset($document_detail['uploading_of_final_action']) && is_array($document_detail['uploading_of_final_action'])) {
				log_message('info', 'DTS - Processing files for uplink table');
				
				foreach ($document_detail['uploading_of_final_action'] as $upload) {
					if (isset($upload['final_action_document'])) {
						// Handle both string and array formats
						$files_to_process = [];
						if (is_array($upload['final_action_document'])) {
							$files_to_process = $upload['final_action_document'];
						} elseif (is_string($upload['final_action_document']) && !empty($upload['final_action_document'])) {
							$files_to_process = [$upload['final_action_document']];
						}
						
						// Insert each file into uplink table and copy to local uploads folder
						foreach ($files_to_process as $file) {
							if (!empty($file)) {
									// ✅ Download file from Laravel storage to DTS uploads folder
$source_url = 'https://dmsapi.denr10.com.ph/dms/documents/view-final-action/' . urlencode($file);
								$uploads_dir = dirname(__FILE__) . '/../../uploads/';
								
								// Ensure uploads directory exists
								if (!is_dir($uploads_dir)) {
									mkdir($uploads_dir, 0777, true);
								}
								
								// Remove timestamp prefix (e.g., "1774257073_REQUEST..." -> "REQUEST...")
								$filename_to_save = $file;
								if (preg_match('/^\d+_(.+)$/', $file, $matches)) {
									$filename_to_save = $matches[1];  // Extract filename after timestamp_
									log_message('info', 'DTS - Removing timestamp prefix from file: ' . $file . ' -> ' . $filename_to_save);
								}
								
								// Sanitize filename for local storage
								$sanitized_filename = preg_replace('/[^a-zA-Z0-9-_.,()ñÑ]/', '_', $filename_to_save);
								$local_file_path = $uploads_dir . $sanitized_filename;
								
								// Download file from Laravel storage
								try {
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $source_url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_TIMEOUT, 30);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
									
									$file_content = curl_exec($ch);
									$curl_error = curl_error($ch);
									$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
									curl_close($ch);
									
									if ($curl_error) {
										log_message('warning', 'DTS - cURL error downloading file: ' . $curl_error . ' from ' . $source_url);
									} else if ($http_code === 200 && !empty($file_content)) {
										// Save to local uploads folder
										if (file_put_contents($local_file_path, $file_content)) {
											log_message('info', 'DTS - Successfully downloaded file to: ' . $local_file_path);
											// Save sanitized filename to uplink
											$this->m_dts->put_file($sanitized_filename, $generated_doc_no);
											log_message('info', 'DTS - Added file to uplink: ' . $sanitized_filename . ' for doc_no: ' . $generated_doc_no);
										} else {
											log_message('error', 'DTS - Failed to save file to: ' . $local_file_path);
											// Still add to uplink with original filename as fallback
											$this->m_dts->put_file($sanitized_filename, $generated_doc_no);
										}
									} else {
										log_message('warning', 'DTS - HTTP error ' . $http_code . ' downloading file from: ' . $source_url);
										// Still add to uplink with sanitized filename
										$this->m_dts->put_file($sanitized_filename, $generated_doc_no);
									}
								} catch (Exception $e) {
									log_message('error', 'DTS - Exception downloading file: ' . $e->getMessage());
									// Still add to uplink with sanitized filename
									$this->m_dts->put_file($sanitized_filename, $generated_doc_no);
								}
							}
						}
					}
				}
			}
			
			// ✅ Log the action (no need to call external API - we just need local DTS record)
			$event = 'RO In-Transit Document Received by ' . $this->session->userdata('u_log_fname') . ' ' . $this->session->userdata('u_log_lname');
			$this->m_dts->put_logs($event, $generated_doc_no);  // Use generated DTS doc_no for logs
			
			// ✅ Mark document as received in Laravel API using NEW per-field-office endpoint
			// This allows each field office to mark receipt independently
			// ✅ Normalize the office name to match the field_offices list (e.g., extract to "PENRO Bukidnon")
			$office_for_api = $user_office;
			log_message('info', 'DTS - Received receive_ro_intransit request for office: "' . $user_office . '" (length: ' . strlen($user_office) . ')');
			
			// If the office name is long, try to extract the short form
			if (strlen($user_office) > 30) {
				log_message('info', 'DTS - Office name is long, attempting normalization');
				// Pattern 1: "Provincial Environment and Natural Resources Office - PROVINCE_NAME"
				if (preg_match('/(?:Provincial\s+(?:Environment|Conservation)|PENRO)[^-]*-\s*(.+?)$/i', $user_office, $matches)) {
					$location = trim($matches[1]);
					if (!empty($location)) {
						$office_for_api = 'PENRO ' . $location;
						log_message('info', 'DTS - Normalized office name via Pattern 1: "' . $user_office . '" -> "' . $office_for_api . '"');
					}
				}
				// Pattern 2: Extract location from anywhere in the string
				elseif (preg_match('/([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*)\s*-\s*([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*)$/i', $user_office, $matches)) {
					$location = trim($matches[2]);
					if (!empty($location) && strtoupper($location) !== 'OFFICE') {
						$office_for_api = 'PENRO ' . $location;
						log_message('info', 'DTS - Normalized office name via Pattern 2: "' . $user_office . '" -> "' . $office_for_api . '"');
					}
				}
				// Pattern 3: Fallback - try to find province/region name in parentheses
				elseif (preg_match('/\(([^)]+)\)/', $user_office, $matches)) {
					$location = trim($matches[1]);
					if (!empty($location)) {
						$office_for_api = 'PENRO ' . $location;
						log_message('info', 'DTS - Normalized office name via Pattern 3: "' . $user_office . '" -> "' . $office_for_api . '"');
					}
				}
				else {
					log_message('warning', 'DTS - Office name is long but no normalization pattern matched. Using original: "' . $user_office . '"');
				}
			}
			else {
				log_message('info', 'DTS - Office name is short form, no normalization needed');
			}
			
			log_message('info', 'DTS - About to send mark-received request with office_for_api: "' . $office_for_api . '" (original: "' . $user_office . '")');
			
			$mark_received_url = $api_base_url . '/dms/documents/' . $doc_id . '/field-offices/' . urlencode($office_for_api) . '/mark-received';
			
			$user_full_name = $this->session->userdata('u_log_fname') . ' ' . $this->session->userdata('u_log_lname');
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $mark_received_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
				'received_by' => $user_full_name,
				'received_at' => date('Y-m-d H:i:s')
			]));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			
			$mark_response = curl_exec($ch);
			$mark_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$mark_curl_error = curl_error($ch);
			curl_close($ch);
			
			// Debug response object
			$debug_info = array(
				'mark_received_url' => $mark_received_url,
				'original_user_office' => $user_office,
				'normalized_office_for_api' => $office_for_api,
				'mark_http_code' => $mark_http_code,
				'mark_response' => $mark_response,
				'mark_curl_error' => $mark_curl_error,
				'doc_id' => $doc_id,
				'session_user_name' => $this->session->userdata('u_log_fname') . ' ' . $this->session->userdata('u_log_lname'),
				'session_user_id' => $this->session->userdata('u_log_id')
			);
			
			if ($mark_curl_error || $mark_http_code !== 200) {
				error_log('DTS - Could not mark field office as received. HTTP: ' . $mark_http_code . ', Error: ' . $mark_curl_error . ', Response: ' . $mark_response);
				// Don't fail - the document is already in DTS, just won't update Laravel receipt tracker
				http_response_code(200);
				echo json_encode(array(
					'success' => false,
					'message' => 'Document received but Laravel receipt marking failed',
					'doc_no' => $generated_doc_no,
					'debug' => $debug_info
				));
				exit;
			} else {
				error_log('DTS - Successfully marked ' . $user_office . ' as received in Laravel API for document: ' . $doc_no . ', Response: ' . $mark_response);
				http_response_code(200);
				echo json_encode(array(
					'success' => true,
					'message' => 'Document received and marked as received in Laravel',
					'doc_no' => $generated_doc_no,
					'debug' => $debug_info
				));
				exit;
			}
			
		} catch (Exception $e) {
			error_log('DTS - receive_ro_intransit exception: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
			http_response_code(500);
			echo json_encode(array(
				'success' => false,
				'message' => 'Server error: ' . $e->getMessage(),
				'debug' => array(
					'session_user_office' => $this->session->userdata('off_log_penro'),
					'session_user_name' => $this->session->userdata('u_log_fname') . ' ' . $this->session->userdata('u_log_lname'),
					'session_user_id' => $this->session->userdata('u_log_id')
				)
			));
			exit;
		}
	}
	
	/**
	 * ✅ Return RO In-Transit document to sender
	 * Updates status in Laravel r10api
	 */
	public function return_ro_intransit()
	{
		try {
			date_default_timezone_set('Asia/Manila');
			
			header('Content-Type: application/json');
			
			$doc_no = isset($_GET['doc_no']) ? $_GET['doc_no'] : null;
			$return_reason = isset($_POST['return_reason']) ? $_POST['return_reason'] : 'No reason provided';
			
			if (!$doc_no) {
				http_response_code(400);
				echo json_encode(array('success' => false, 'message' => 'Missing doc_no parameter'));
				exit;
			}
			
			$user_office = $this->session->userdata('off_log_penro');
			if (!$user_office) {
				http_response_code(401);
				echo json_encode(array('success' => false, 'message' => 'User office not found in session'));
				exit;
			}
			
			$api_base_url = 'https://dmsapi.denr10.com.ph';
			
			// First, find the document
			$list_url = $api_base_url . '/dms/documents/ro-in-transit?per_page=100&office_name=' . urlencode($user_office);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $list_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($http_code !== 200 || !$response) {
				http_response_code(500);
				echo json_encode(array('success' => false, 'message' => 'Failed to fetch document list from API'));
				exit;
			}
			
			$api_response = json_decode($response, true);
			if (!isset($api_response['data']) || !is_array($api_response['data'])) {
				http_response_code(500);
				echo json_encode(array('success' => false, 'message' => 'Invalid API response'));
				exit;
			}
			
			// Find the document matching doc_no
			$document = null;
			$doc_id = null;
			
			foreach ($api_response['data'] as $doc) {
				if ($doc['document_no'] === $doc_no) {
					$document = $doc;
					$doc_id = $doc['incoming_initial_id'];
					break;
				}
			}
			
			if (!$document || !$doc_id) {
				http_response_code(404);
				echo json_encode(array('success' => false, 'message' => 'Document not found'));
				exit;
			}
			
			// ✅ Call the correct API endpoint to mark as returned
			$return_url = $api_base_url . '/dms/documents/' . $doc_id . '/field-offices/' . urlencode($user_office) . '/return-received';
			
			$post_data = json_encode(array(
				'returned_at' => date('Y-m-d H:i:s'),
				'return_reason' => $return_reason,
				'returned_by' => $this->session->userdata('u_log_fname') . ' ' . $this->session->userdata('u_log_lname')
			));
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $return_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);
			
			if ($curl_error) {
				http_response_code(500);
				echo json_encode(array('success' => false, 'message' => 'cURL error: ' . $curl_error));
				exit;
			}
			
			// ✅ Accept both 200, 201, and 204 as success
			if ($http_code !== 200 && $http_code !== 201 && $http_code !== 204) {
				error_log("Document return API failed - HTTP $http_code, URL: $return_url, Response: $response");
				http_response_code(500);
				echo json_encode(array('success' => false, 'message' => 'API returned HTTP ' . $http_code . '. Response: ' . substr($response, 0, 200)));
				exit;
			}
			
			// Return success response
			http_response_code(200);
			echo json_encode(array(
				'success' => true,
				'message' => 'Document successfully returned to sender',
				'doc_no' => $doc_no,
				'return_reason' => $return_reason
			));
			exit;
			
		} catch (Exception $e) {
			http_response_code(500);
			echo json_encode(array(
				'success' => false,
				'message' => 'Error: ' . $e->getMessage()
			));
			exit;
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
								$sanitized_filename = preg_replace('/[^a-zA-Z0-9-_.,()ñÑ]/','_', $data["file_name"]);
								
								// Rename file on disk if sanitization changed the filename
								if($sanitized_filename !== $data["file_name"]) {
									$old_path = $data["full_path"];
									$new_path = './uploads/' . $sanitized_filename;
									rename($old_path, $new_path);
								}
								
								// ✅ FIXED: Store sanitized filename in database to match actual file on disk
								$this->m_dts->put_file($sanitized_filename,$doc_no);
								if($doc_act_no!=null){$this->m_dts->put_file($sanitized_filename,$doc_act_no);}
								
								$output .= '
											 <div style="float:left">
											  <a id="att_fn" href="'.base_url().'uploads/'.$sanitized_filename.'" target="_blank">'.$sanitized_filename.'</a>
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
		
		// ✅ Check if this is an RO In-Transit document
		$ro_intransit_result = $this->get_ro_intransit_files($doc_no);
		
		if($ro_intransit_result) {
			// RO In-Transit document - use API data
			$data['records'] = array(); // Empty for RO In-Transit
			$data['is_ro_intransit'] = true;
			$data['ro_metadata'] = $ro_intransit_result['metadata'];
			$data['ro_files'] = $ro_intransit_result['files'];
			$data['log_route'] = array(); // RO In-Transit doesn't have DTS routing logs
		} else {
			// Legacy DTS document
			$data['records'] = $this->m_dts->get_records_prev($doc_no);
			$data['is_ro_intransit'] = false;
			$data['log_route'] = $this->m_dts->get_log_route($doc_no);
		}
		
		$data['div_list'] = $this->m_dts->get_off_div();
		$data['sec_list'] = $this->m_dts->get_off_sec();
		$data['unit_list'] = $this->m_dts->get_off_unit();
		$data['act_desc'] = $this->m_dts->get_act_desc();
		
		$this->load->view('rtslip_pdf', $data);
		$html = $this->output->get_output();
		// Create fresh mPDF instance for this PDF
		$this->mpdf_gen->createInstance('A4', 'P');
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output("Routing_Slip.pdf", 'I');
		
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
		// Create fresh mPDF instance for this PDF
		$this->mpdf_gen->createInstance('legal', 'L');
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output("Report.pdf", 'I');
		
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
		
		// ✅ Handle RO In-Transit count separately
		if($doc_cat == 7) {
			$count = $this->get_ro_intransit_count_internal();
			echo json_encode(array(array('cnt' => $count)));
		} else {
			echo json_encode($this->m_dts->get_count_rec($doc_cat));
		}
	}
	
	public function get_section_list()
	{ 
		echo json_encode($this->m_dts->get_section_list());
	}

	/**
	 * ✅ Internal: Get RO In-Transit Documents from r10api
	 * Fetches documents assigned to user's field office
	 * Per-account basis: only shows documents where user's office is selected as a field office
	 */
	private function get_ro_intransit_data_internal($draw, $offset, $limit, $search)
	{
		try {
			// ✅ Get user's office name for filtering
			$user_office = $this->session->userdata('off_log_penro');
			
			log_message('info', 'DTS - RO In-Transit Data Request - User Office: ' . ($user_office ?? 'EMPTY'));
			
			// ✅ Updated API URL with office_name parameter for per-account filtering
			$api_base_url = 'https://dmsapi.denr10.com.ph';
			$api_url = $api_base_url . '/dms/documents/ro-in-transit?page=1&per_page=100';
			
			// ✅ Filter by user's office - per account visibility
			// If user's office is selected as a field office, data will show
			// If not selected, no data will be returned for this account
			if ($user_office) {
				$api_url .= '&office_name=' . urlencode($user_office);
				log_message('info', 'DTS - RO In-Transit API URL with office filter: ' . $api_url);
			} else {
				log_message('warning', 'DTS - User office not found in session, cannot filter RO In-Transit documents');
			}
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);

			$data = array();
			$total_count = 0;

			if ($curl_error) {
				log_message('error', 'cURL Error: ' . $curl_error);
			}

			log_message('info', 'RO In-Transit cURL Response - HTTP Code: ' . $http_code);
			log_message('info', 'RO In-Transit API Response: ' . substr($response, 0, 500));

			if ($http_code === 200 && $response) {
				$api_response = json_decode($response, true);
				
				log_message('info', 'RO In-Transit Decoded Response: ' . json_encode([
					'success' => $api_response['success'] ?? false,
					'data_count' => count($api_response['data'] ?? []),
					'total' => $api_response['total'] ?? 0,
					'filtered_by_office' => $api_response['filtered_by_office'] ?? 'N/A'
				]));
				
				if (isset($api_response['success']) && $api_response['success'] && isset($api_response['data'])) {
					$documents = $api_response['data'];
					$total_count = $api_response['total'] ?? count($documents);

					// Apply search filter
					if (!empty($search['value'])) {
						$search_term = strtoupper($search['value']);
						$documents = array_filter($documents, function($doc) use ($search_term) {
							return stripos($doc['document_no'], $search_term) !== false ||
									stripos($doc['subject'], $search_term) !== false ||
									stripos($doc['sender'], $search_term) !== false;
						});
						$total_count = count($documents);
					}

					// Apply pagination
					$documents = array_slice($documents, $offset, $limit);

					// Transform data for DataTable
					foreach ($documents as $doc) {
						$data[] = array(
							'rec_id' => $doc['incoming_initial_id'],
							'doc_no' => htmlspecialchars($doc['document_no']),
							'sender' => htmlspecialchars($doc['sender']),
							'doc_date' => $doc['document_date_formatted'] ?? date('M d, Y', strtotime($doc['date_received'])),
							'doc_subject' => htmlspecialchars($doc['subject']),
							'rec_date' => $doc['date_received_formatted'] ?? date('M d, Y', strtotime($doc['date_received'])),
							'act_class' => $doc['priority_level'] ?? '-',
							'sec_id' => '-',
							'referred_office' => $doc['recipient'] ?? '-',
							'ef_description' => htmlspecialchars(str_replace('_', ' ', $doc['status'])),
							'status' => htmlspecialchars(str_replace('_', ' ', $doc['status'])),
							'dt_recv' => $doc['date_released'] ?? '-',
							'updated_at' => date('M d, Y', strtotime($doc['date_received'])),
							'priority_level' => $doc['priority_level'] ?? '-',
							'recipient' => $doc['recipient'] ?? '-',
							'date_released' => $doc['date_released'] ?? '-',
						);
					}
				} else {
					log_message('error', 'Invalid API response: ' . $response);
				}
			} else {
				log_message('error', 'API HTTP Error: ' . $http_code . ' Response: ' . substr($response, 0, 500));
			}

			$output = array(
				"draw" => $draw,
				"recordsTotal" => $total_count,
				"recordsFiltered" => $total_count,
				"data" => $data,
			);

			echo json_encode($output);

		} catch (Exception $e) {
			log_message('error', 'RO In-Transit fetch error: ' . $e->getMessage());
			
			$output = array(
				"draw" => intval($this->input->post('draw')),
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => array(),
				"error" => $e->getMessage(),
			);
			
			echo json_encode($output);
		}
	}

	/**
	 * ✅ Get count of RO In-Transit documents for badge
	 * Filtered by user's office for all accounts
	 */
	private function get_ro_intransit_count_internal()
	{
		try {
			// ✅ Get user's office name for filtering
			$user_office = $this->session->userdata('off_log_penro');
			
			// Fetch from r10api
			$api_base_url = 'https://dmsapi.denr10.com.ph';
			$api_url = $api_base_url . '/dms/documents/ro-in-transit?page=1&per_page=1';
			
			// ✅ Always filter by user's office to ensure each office only sees their documents
			if ($user_office) {
				$api_url .= '&office_name=' . urlencode($user_office);
			}
			
			log_message('info', 'RO Count API URL: ' . $api_url);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);

			$count = 0;
			
			log_message('info', 'RO Count HTTP Code: ' . $http_code);
			log_message('info', 'RO Count Response: ' . substr($response, 0, 500));
			
			if ($http_code === 200 && $response) {
				$api_response = json_decode($response, true);
				
				log_message('info', 'RO Count Decoded: ' . json_encode($api_response));
				
				// ✅ Try multiple ways to get count from API response
				if (isset($api_response['success']) && $api_response['success']) {
					// Try 'total' first (common in API responses)
					$count = $api_response['total'] ?? 0;
					
					// Fall back to pagination.total
					if ($count === 0 && isset($api_response['pagination']['total'])) {
						$count = $api_response['pagination']['total'];
					}
					
					// Fall back to counting data array
					if ($count === 0 && isset($api_response['data']) && is_array($api_response['data'])) {
						$count = count($api_response['data']);
					}
				}
			} else {
				if ($curl_error) {
					log_message('error', 'RO Count cURL Error: ' . $curl_error);
				} else {
					log_message('error', 'RO Count HTTP Error: ' . $http_code);
				}
			}

			log_message('info', 'RO Count Result: ' . $count);
			return $count;

		} catch (Exception $e) {
			log_message('error', 'RO In-Transit count fetch error: ' . $e->getMessage());
			return 0;
		}
	}
	
}