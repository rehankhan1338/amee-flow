<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq_mdl extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */ 
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
	
	public function delete_faq($id){
	    
		$query = $this->db->delete('faq', array('id' => $id));
  		$this->session->set_flashdata('success', 'Deleted successfully!'); 
		
	}
	
	public function faq_details(){
	
 		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('faq');
		return $query->result();
		
	}
	
	public function faq_fulldetails($id){
	
 		$this->db->where('id', $id);
		$query = $this->db->get('faq');
		return $query->row();
		
	}
	
	public function add_faq(){
	 
	 	$question = trim($this->input->post('question'));
		$description = trim($this->input->post('description'));  
		
		$insert_data=array(
			"question"=>$question,
			"description"=>$description,
			"add_date"=>time());
			
		$this->db->insert('faq',$insert_data);
		
	}
	
	public function edit_faq($id){
	 
	 	$question = trim($this->input->post('question'));
		$description = trim($this->input->post('description'));  
		
		$update_data=array("question"=>$question,"description"=>$description);
			
		$this->db->where('id',$id); 
 		$this->db->update('faq',$update_data);
		
	}	
}