<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Census_data_mdl extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}
	
	public function getCensusYearData($year){
		$this->db->where('year', $year);
		$qry = $this->db->get('census_data');
		return $qry->row();
	}
	
	public function getCensusYearDataById($censusId){
		$this->db->where('censusId', $censusId);
		$qry = $this->db->get('census_data');
		return $qry->row();
	}
	
	public function getCensusOptionsData($censusId,$catId=0){
		$this->db->where('censusId', $censusId);
		if(isset($catId) && $catId!='' && $catId>0){
			$this->db->where('catId', $catId);
		}
		$qry = $this->db->get('census_options_data');
		return $qry->result_array();
	}
	
	public function masterCensusFormData(){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->select('indicatorId, indicatorTitle, catId, parentId');
		$amee_web->where('status', '0');
		$amee_web->where('isDeleted', '0');
		$amee_web->order_by('parentId,priority', 'asc');
		$query = $amee_web->get('census_data');
		return $query->result_array();
	}
	
	public function masterCensusDataByCatId($catId){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->select('indicatorId, indicatorTitle, indLegend, catId, parentId');
		if(isset($catId) && $catId!=''){
			$amee_web->where('catId', $catId);
		}
		$amee_web->where('status', '0');
		$amee_web->where('isDeleted', '0');
		$amee_web->order_by('parentId,priority', 'asc');
		$query = $amee_web->get('census_data');
		return $query->result_array();
	}
	
	public function getCensusData($catId,$year){
		$this->db->where('catId', $catId);
		$this->db->where('year', $year);
		$qry = $this->db->get('census_data');
		return $qry->result();
	}
	
	public function updateEntry(){
		$censusId = $this->input->post('h_censusId');
		$censusYear = $this->input->post('censusYear');
		$totalPart = $this->input->post('totalPart');
 		$indicatorIdsArr = $this->input->post('indicatorIds');
		$time = time();
		if(count($indicatorIdsArr)>0){
			$this->db->where('censusId != ', $censusId);
			$this->db->where('year', $censusYear);
			$qry = $this->db->get('census_data');
			$num = $qry->num_rows(); 
			if($num==0){
			
				$this->db->where('censusId', $censusId);
				$this->db->update('census_data', array("year"=>$censusYear, "totalPart"=>$totalPart, "lastModiDataTime"=>$time));
				
				foreach($indicatorIdsArr as $data){
					
					$dataArr = explode('|',$data);
					$indicatorId = $dataArr[0];
					$catId = $dataArr[1];
					
					$indicatorAns = $this->input->post('indicator_'.$indicatorId);
					$this->db->where('censusId', $censusId);
					$this->db->where('indicatorId', $indicatorId);
					$this->db->where('catId', $catId);	
					$this->db->update('census_options_data', array("indicatorAns"=>$indicatorAns));					
				}
				$this->session->set_flashdata('success', $censusYear.' data has been updated successfully!');
				return 'success||'.base_url().'admin/census_data/';
			}else{
				return 'error||'.$censusYear.' data already added.';
			}
		}else{
			return 'error||no questions found.';
		}
	}
	
	public function createEntry(){
		$censusYear = $this->input->post('censusYear');
		$totalPart = $this->input->post('totalPart');
 		$indicatorIdsArr = $this->input->post('indicatorIds');
		$time = time();
		if(count($indicatorIdsArr)>0){
			$this->db->where('year', $censusYear);
			$qry = $this->db->get('census_data');
			$num = $qry->num_rows(); 
			if($num==0){
			
				$this->db->insert('census_data', array("year"=>$censusYear, "totalPart"=>$totalPart, "createDateTime"=>$time, "lastModiDataTime"=>$time));	
				$censusId = $this->db->insert_id();
				
				foreach($indicatorIdsArr as $data){
					
					$dataArr = explode('|',$data);
					$indicatorId = $dataArr[0];
					$catId = $dataArr[1];
					
					$indicatorAns = $this->input->post('indicator_'.$indicatorId);	
					$this->db->insert('census_options_data', array("censusId"=>$censusId, "indicatorId"=>$indicatorId, "indicatorAns"=>$indicatorAns, "catId"=>$catId));				
					/*$this->db->where('year', $censusYear);
					$this->db->where('indicatorId', $indicatorId);
					$query = $this->db->get('census_data');
					$num_rows = $query->num_rows(); 
					if($num_rows==0){		
							
					}*/					
				}
				$this->session->set_flashdata('success', $censusYear.' data has been added successfully!');
				return 'success||'.base_url().'admin/census_data/';
			}else{
				return 'error||'.$censusYear.' data already added.';
			}
		}else{
			return 'error||no questions found.';
		}
	}
	
	public function deleteCensusData($censusId){
		$this->db->delete('census_data', array("censusId"=>$censusId));	
		$this->db->delete('census_options_data', array("censusId"=>$censusId));	
		$this->session->set_flashdata('success', 'Data has been deleted successfully!');
	}
	
}