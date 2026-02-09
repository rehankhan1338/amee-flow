<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_mdl extends CI_Model {
	
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
	
	public function delete_category($id){
		$query = $this->db->delete('category', array('id' => $id));
  		$this->session->set_flashdata('success', 'Deleted successfully!'); 
	}
	
	public function category_details(){
	
 		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('category');
		return $query->result();
		
	}
	
	public function category_fulldetails($id){
	
 		$this->db->where('id', $id);
		$query = $this->db->get('category');
		return $query->row();
		
	}
	
	public function add_category(){
	 
	 	$txt_name = trim($this->input->post('txt_name')); 
		
		$insert_data=array(
			"name"=>$txt_name,
			"add_date"=>time());
			
		$this->db->insert('category',$insert_data);
		
	}
	
	public function edit_category($id){
	 
	 	$txt_name = trim($this->input->post('txt_name')); 
		
		$update_data=array("name"=>$txt_name);
			
		$this->db->where('id',$id); 
 		$this->db->update('category',$update_data);
		
	}	
}