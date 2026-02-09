<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_tutorials_mdl extends CI_Model {	
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
		
	public function content_tutorials_heading_details($action_status){
 		$this->db->where('status', '0');
 		$this->db->where('action_status', $action_status);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('content_tutorials_heading');
		return $query->result();
	}
		
	public function heading_add(){
		$action_status = trim($this->input->post('hidden_action_status')); 
		$heading = trim($this->input->post('heading')); 
		$description = trim($this->input->post('description')); 
					
		$insert_data = array('heading'=>$heading, 'description'=>$description, 'action_status'=>$action_status, 'add_date'=>time());
		$this->db->insert('content_tutorials_heading',$insert_data);
		//$insert_id = $this->db->insert_id(); ;	
						
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/content/tutorials/heading?as='.$action_status);
	}		
			
	public function content_tutorials_heading_rowdetails($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('content_tutorials_heading');
		return $query->row();
	}
		
	public function heading_edit($id){			
		$action_status = trim($this->input->post('hidden_action_status'));  
		$heading = trim($this->input->post('heading'));  
		$description = trim($this->input->post('description'));
		
		$update_data = array('heading'=>$heading,'description'=>$description);	
		$this->db->where('id',$id); 
		$this->db->update('content_tutorials_heading',$update_data);
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/content/tutorials/heading?as='.$action_status);	
	}	
	
	public function heading_delete($id,$action_status){
		$this->db->where('id',$id); 
 		$delete = $this->db->delete('content_tutorials_heading');
 		
 		if($delete){
			$this->db->where('heading_id',$id); 
 			$delete = $this->db->delete('content_tutorials_sub_heading');
		} 		
  		$this->session->set_flashdata('success', 'Deleted successfully!');
  		redirect('admin/content/tutorials/heading?as='.$action_status);	
	}	
		
	public function content_tutorials_sub_heading_details($heading_id){
 		$this->db->where('status', '0');
 		$this->db->where('heading_id', $heading_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('content_tutorials_sub_heading');
		return $query->result();
	}	
	
	public function add_sub_heading(){
		$action_status = $this->input->post('hidden_action_status');
		$heading_id = $this->input->post('hidden_heading_id');
		$sub_heading = trim($this->input->post('sub_heading')); 
		$description = trim($this->input->post('description')); 
		
		$insert = array('heading_id'=>$heading_id, 'sub_heading'=>$sub_heading, 'description'=>$description, 'add_date'=>time());
		$this->db->insert('content_tutorials_sub_heading',$insert);
		
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/content_tutorials?hid='.$heading_id.'&as='.$action_status);
	}	
		
	public function content_tutorials_sub_heading_rowdetails($sub_heading_id){
 		$this->db->where('id', $sub_heading_id);
		$query = $this->db->get('content_tutorials_sub_heading');
		return $query->row();
	}
	
	public function update_sub_heading(){
		$action_status = $this->input->post('hidden_action_status'); 
		$heading_id = $this->input->post('hidden_heading_id'); 
		$sub_heading_id = $this->input->post('hidden_sub_heading_id'); 
		$sub_heading = $this->input->post('sub_heading'); 
		$description = $this->input->post('description'); 
	
		$update_data = array('sub_heading'=>$sub_heading, 'description'=>$description);
		$this->db->where('id', $sub_heading_id);			
		$this->db->update('content_tutorials_sub_heading',$update_data);
		
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/content_tutorials?hid='.$heading_id.'&as='.$action_status);
	}	
	
	
	public function delete_sub_heading($sub_heading_id,$heading_id,$action_status){
		$this->db->where('id',$sub_heading_id); 
 		$this->db->delete('content_tutorials_sub_heading');
  		$this->session->set_flashdata('success', 'Deleted successfully!');
  		redirect('admin/content_tutorials?hid='.$heading_id.'&as='.$action_status);
	}		
		
}