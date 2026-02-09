<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tutorials_mdl extends CI_Model {
	
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
	
	
	public function tutorials_details(){
 		$this->db->where('is_delete', '1');
 		$this->db->where('status', '1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('tutorials');
		return $query->result();
	}
	
	public function tutorials_detail_row($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('tutorials');
		return $query->row();
	}
	
	
	public function add_tutorials(){
		$txt_title = $this->input->post('txt_title');
		$txt_link = $this->input->post('txt_link');
		
		$insert_data=array('txt_title'=>$txt_title, 'txt_link'=>$txt_link);
		$this->db->insert('tutorials',$insert_data);
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/tutorials');
	}
	
	
	public function edit_tutorials($id){
		$txt_title = $this->input->post('txt_title');
		$txt_link = $this->input->post('txt_link');
		
		$update_data=array('txt_title'=>$txt_title, 'txt_link'=>$txt_link);
		$this->db->where('id',$id); 
		$this->db->update('tutorials',$update_data);
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/tutorials');
	}
	
	
	public function delete_tutorials($id){
		$update_data = array('is_delete'=>'0');
		$this->db->where('id',$id); 
 		$this->db->update('tutorials',$update_data);
		//$query = $this->db->delete('tutorials', array('id'=>$id));
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
		
}