<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core_competency_mdl extends CI_Model {
	
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
	
	public function core_competency_details(){
 		$this->db->where('status', '0');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('master_core_competency');
		return $query->result();
	}
	
	public function core_competency_row($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('master_core_competency');
		return $query->row();
	}

	public function add_core_competency(){
	 	$name = trim($this->input->post('name')); 
			
		$arr = array('name'=>$name);
		$this->db->insert('master_core_competency',$arr);
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/core_competency');
	}
	
	public function edit_core_competency($id){
	 	$name = trim($this->input->post('name'));

		$arr = array('name'=>$name);
		$this->db->where('id',$id); 
 		$this->db->update('master_core_competency',$arr);
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/core_competency');
	}
	
	public function delete_core_competency($id){
		$query = $this->db->delete('master_core_competency', array('id'=>$id));
  		$this->session->set_flashdata('success', 'Deleted successfully!');
  		redirect('admin/core_competency');
	}
	
		
}