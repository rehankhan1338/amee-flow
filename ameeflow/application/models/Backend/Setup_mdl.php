<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup_mdl extends CI_Model {
	
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
	
	public function setupMastersData(){
		$this->db->where('is_deleted', '0');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('setup_masters');
        return $query->result_array();
	}
	
	public function get_wards_by_zoneId($zoneId){
		$this->db->where('is_deleted', '0');
		$this->db->where('parentId', $zoneId);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('setup_masters');
        return $query->result_array();
	}
	
	public function delete_setup_masters($id,$section_label){
 		$this->db->where('id',$id); 
		$this->db->update('setup_masters',array("is_deleted"=>'1'));
  		$this->session->set_flashdata('success', $section_label.' has been deleted successfully!'); 
 	}
	
	public function setup_masters_details($section_status){
  		$this->db->where('section_status',$section_status); 
		$this->db->where('is_deleted', 0);
		$this->db->order_by('priority,name', 'asc');
		$query = $this->db->get('setup_masters');
		return $query->result();
 	}
	
	public function fetchZonesArr(){
		$this->db->select('id, parentId, name, status'); 
  		$this->db->where('section_status','1'); 
		$this->db->where('is_deleted', 0);
		$this->db->order_by('priority,name', 'asc');
		$query = $this->db->get('setup_masters');
		return $query->result_array();
 	}
	
	public function setup_masters_fulldetails($id){
  		$this->db->where('id', $id);
		$query = $this->db->get('setup_masters');
		return $query->row();
 	}
	
	public function add_setup_masters($section_status,$section_label,$section_slug){
		$name = trim($this->input->post('txt_name'));
		$company_slug = create_slug_ch($name); 
 		$parentId = $this->input->post('parentId');
		
		$this->db->where('is_deleted', 0);
		$this->db->where('section_status', $section_status);
		$this->db->where('company_slug', $company_slug);
		$query = $this->db->get('setup_masters');
		$num_rows=$query->num_rows();
	 	if($num_rows==0){
			$insert_data=array("parentId"=>$parentId,"name"=>$name,"company_slug"=>$company_slug,"section_status"=>$section_status,"add_date"=>time());
			$this->db->insert('setup_masters',$insert_data);
			$this->session->set_flashdata('success', '<strong>Success : </strong>Your '.$section_label.' has been added successfully.');
		}else{
			$this->session->set_flashdata('error', 'Oops "<strong>'.ucfirst($name).'</strong>" '.$section_label.' was already exist in our database.');
			redirect(base_url().$this->config->item('admin_directory_name').'setup/add/'.$section_slug);
		}
 	}
	
	public function edit_setup_masters($id,$section_status,$section_label,$section_slug){
 	 	$name = trim($this->input->post('txt_name'));
		$company_slug = create_slug_ch($name);
		$parentId = $this->input->post('parentId'); 
		$this->db->where('id != ', $id);
		$this->db->where('is_deleted', 0);
		$this->db->where('section_status', $section_status);
		$this->db->where('company_slug', $company_slug);
		$query = $this->db->get('setup_masters');
		$num_rows=$query->num_rows();
	 	if($num_rows==0){
			$this->db->where('id',$id); 
 			$this->db->update('setup_masters',array("parentId"=>$parentId,"name"=>$name,"company_slug"=>$company_slug));
			$this->session->set_flashdata('success', '<strong>Success : </strong>Your '.$section_label.' has been updated successfully.');
		}else{
			$this->session->set_flashdata('error', 'Oops "<strong>'.ucfirst($name).'</strong>" '.$section_label.' was already exist in our database.');
			redirect(base_url().$this->config->item('admin_directory_name').'setup/edit/'.$section_slug.'/'.$id);
		}
 		
 	}	
}