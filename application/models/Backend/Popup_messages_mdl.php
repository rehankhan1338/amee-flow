<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Popup_messages_mdl extends CI_Model {
	
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
	 
	public function pop_messages_listing($page_name){
	
 		$this->db->where('status', '0');
		$this->db->where('page_name', $page_name);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('popup_messages');
		return $query->result();
		
	}
	
	
	public function popup_messages_details_group_by_page($university_id){
 		$this->db->where('status', '0');
		$this->db->where('university_id', $university_id);
		$this->db->order_by('id', 'asc');
		$this->db->group_by('page_name');
		$query = $this->db->get('popup_messages');
		return $query->result();
	}
	
	public function Popup_messages_details(){
 		//$this->db->where('is_delete', '1');
 		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('popup_messages');
		return $query->result();
	}	
	
	public function university_detail_by_custom(){
 		$this->db->where('is_delete', '1');
 		$this->db->where('status', '1');
 		$this->db->where('popup_message_status', '1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('university');
		return $query->result();
	}
	
	public function Popup_messages_detail_row($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('popup_messages');
		return $query->row();
	}
	
	public function add_Popup_messages(){
		$university = $this->input->post('university'); 
		$page_name = $this->input->post('page_name'); 
		$purpose = $this->input->post('purpose'); 
		$title = ucfirst($this->input->post('title'));
		$description = $this->input->post('description');
		
		$insert_data=array('university_id'=>$university,'page_name'=>$page_name,
			'purpose'=>$purpose, 'title'=>$title, 'description'=>$description, "add_date"=>time());
			
		$this->db->insert('popup_messages',$insert_data);
		//$insert_id = $this->db->insert_id(); 
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/Popup_messages');
	}	
		
		
	public function edit_Popup_messages($id){
		$hidden_university_id = $this->input->post('hidden_university_id');
		if(isset($hidden_university_id) && $hidden_university_id==''){
			$hidden_university_id ='0';
		}
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		
		$arr = array('title'=>$title, 'description'=>$description);
		$this->db->where('id',$id); 
		$this->db->update('popup_messages',$arr);
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/Popup_messages?id='.$hidden_university_id);
	}
	
	
	
	
	
	
	public function delete_university($id){
		$delete_date = strtotime(date('Y-m-d H:i:s'));
		$update_data = array('is_delete'=>'0', 'delete_date'=>$delete_date);
		
		$this->db->where('id',$id); 
 		$this->db->update('university',$update_data);
		//$query = $this->db->delete('university', array('id'=>$id));
		
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
		
}