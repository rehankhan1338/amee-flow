<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Orders extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error'); 
		$this->data['title']='Login'; 
 	}
	
	public function index(){
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set some data
		$sheet->setCellValue('A1', 'Name');
		$sheet->setCellValue('B1', 'Email');
		$sheet->setCellValue('A2', 'John Doe');
		$sheet->setCellValue('B2', 'john@example.com');

		// Set headers to force download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="sample.xlsx"');
		header('Cache-Control: max-age=0');

		// Write and download
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}