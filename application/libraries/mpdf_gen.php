<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  mPDF Library Wrapper
* 
* Description: This is a Codeigniter library which allows you to convert HTML to PDF with mPDF
* Replaces the old DOMPDF library
* 
* @property \Mpdf\Mpdf $mpdf The mPDF instance
*/

use Mpdf\Mpdf;

class Mpdf_gen {
	
	private $mpdf_config = [];
	private $mpdf_instance;
		
	public function __construct() {
		try {
			// Load mPDF from composer vendor directory
			require_once APPPATH . '../vendor/autoload.php';
			
			// Store configuration for reuse
			$this->mpdf_config = [
				'mode' => 'c', // c = UTF-8, u = Unicode
				'format' => 'A4',
				'orientation' => 'P', // P = Portrait, L = Landscape
				'margin_left' => 15,
				'margin_right' => 15,
				'margin_top' => 15,
				'margin_bottom' => 15,
				'tempDir' => APPPATH . 'cache',
				'useAdobeCFF' => false, // Disable advanced font features that may cause issues
			];
			
			// Create initial instance
			$this->createInstance();
			
			log_message('info', 'mPDF library loaded successfully');
		} catch (Exception $e) {
			log_message('error', 'Failed to load mPDF: ' . $e->getMessage());
		}
	}
	
	/**
	 * Create or recreate mPDF instance
	 */
	public function createInstance($format = 'A4', $orientation = 'P') {
		try {
			// Update config for this instance
			$config = $this->mpdf_config;
			$config['format'] = $format;
			$config['orientation'] = $orientation;
			
			$this->mpdf_instance = new Mpdf($config);
			
			// Make it available throughout CodeIgniter
			$CI =& get_instance();
			$CI->mpdf = $this->mpdf_instance;
		} catch (Exception $e) {
			log_message('error', 'Failed to create mPDF instance: ' . $e->getMessage());
		}
	}
	
	/**
	 * Get the current mPDF instance
	 */
	public function getInstance() {
		return $this->mpdf_instance;
	}
	
}
