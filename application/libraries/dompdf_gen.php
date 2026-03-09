<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  DOMPDF
* 
* Author: Jd Fiscus
* 	 	  jdfiscus@gmail.com
*         @iamfiscus
*          
*
* Origin API Class: http://code.google.com/p/dompdf/
* 
* Location: http://github.com/iamfiscus/Codeigniter-DOMPDF/
*          
* Created:  06.22.2010 
* 
* Description:  This is a Codeigniter library which allows you to convert HTML to PDF with the DOMPDF library
* 
*/

class Dompdf_gen {
		
	public function __construct() {
		
		$dompdf_path = APPPATH.'third_party/dompdf/autoload.inc.php';
		
		// Check if DOMPDF autoloader exists
		if (!file_exists($dompdf_path)) {
			log_message('error', 'DOMPDF autoloader not found at: ' . $dompdf_path);
			return;
		}
		
		try {
			require_once $dompdf_path;
			
			// Check if Dompdf class exists
			if (class_exists('Dompdf\DOMPDF')) {
				$pdf = new Dompdf\DOMPDF();
				$CI =& get_instance();
				$CI->dompdf = $pdf;
			} else {
				log_message('error', 'Dompdf\DOMPDF class not found. DOMPDF library files may be incomplete.');
			}
		} catch (Exception $e) {
			log_message('error', 'Failed to load DOMPDF: ' . $e->getMessage());
		}
		
	}
	
}