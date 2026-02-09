<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amee_mdl extends CI_Model {
	
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
	
	public function delete_amee_updates($id){
	    
		$query = $this->db->delete('amee_updates', array('id' => $id));
  		$this->session->set_flashdata('success', 'Deleted successfully!'); 
		
	}
	
	public function amee_updates_details(){
	
 		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('amee_updates');
		return $query->result();
		
	}
	
	public function amee_updates_fulldetails($id){
	
 		$this->db->where('id', $id);
		$query = $this->db->get('amee_updates');
		return $query->row();
		
	}
	
	public function add_amee_updates(){
	 
	 	$title = trim($this->input->post('title')); 
		$publish_date = strtotime(trim($this->input->post('publish_date')));
		$body_content = trim($this->input->post('body_content'));
		
		$insert_data=array(
			"title"=>$title,
			"publish_date"=>$publish_date,
			"body_content"=>$body_content,
			"add_date"=>time());
			
		$this->db->insert('amee_updates',$insert_data);
		
	}
	
	public function edit_amee_updates($id){
	 
	 	$title = trim($this->input->post('title')); 
		$publish_date = strtotime(trim($this->input->post('publish_date')));
		$body_content = trim($this->input->post('body_content'));
		
		$update_data=array(
			"title"=>$title,
			"publish_date"=>$publish_date,
			"body_content"=>$body_content);
			
		$this->db->where('id',$id); 
 		$this->db->update('amee_updates',$update_data);
		
	}	
}