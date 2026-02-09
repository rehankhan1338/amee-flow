<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_profile_mdl extends CI_Model {
	
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
	
		
	public function client_profile_details(){
 		$this->db->where('is_delete', '1');
 		$this->db->where('status', '1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('client_profile');
		return $query->result();
	}
	
	public function client_profile_detail_row($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('client_profile');
		return $query->row();
	}
	
	public function add_client_profile(){
	 	$first_name = ucfirst($this->input->post('first_name'));
	 	$last_name = $this->input->post('last_name');
	 	$email = $this->input->post('email');
	 	$phone = $this->input->post('phone');
	 	$address = $this->input->post('address');
	 	$state = $this->input->post('state');
	 	$city = $this->input->post('city');
	 	$zip_code = $this->input->post('zip_code');
	 	$organization_name = trim($this->input->post('organization_name')); 
	 	$organization_type = $this->input->post('organization_type'); 
		
		$insert_data=array('first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 
			'phone'=>$phone, 'address'=>$address, 'state'=>$state, 'city'=>$city, 'zip_code'=>$zip_code,
			'organization_name'=>$organization_name, 'organization_type'=>$organization_type, 
			'add_date'=>time());
			
		$this->db->insert('client_profile',$insert_data);
		/*$insert_id = $this->db->insert_id(); 
		if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
			if($_FILES['photo']['error']==0){
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
				$photo=time().'.'.$ext;
				
				$config['file_name'] =$photo;
				$config['upload_path'] = './assets/client_profile/';
				$config['allowed_types'] = '*';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('photo');
			}
			$image_data=array("image"=>$photo);
			$this->db->where('id',$insert_id); 
 			$this->db->update('client_profile',$image_data);
		}*/
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/clients');
	}
	
	public function edit_client_profile($id){
	 	$first_name = ucfirst($this->input->post('first_name'));
	 	$last_name = $this->input->post('last_name');
	 	$email = $this->input->post('email');
	 	$phone = $this->input->post('phone');
	 	$address = $this->input->post('address');
	 	$state = $this->input->post('state');
	 	$city = $this->input->post('city');
	 	$zip_code = $this->input->post('zip_code');
	 	$organization_name = trim($this->input->post('organization_name')); 
	 	$organization_type = $this->input->post('organization_type'); 
		
		$update_data = array('first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 
			'phone'=>$phone, 'address'=>$address, 'state'=>$state, 'city'=>$city, 'zip_code'=>$zip_code,
			'organization_name'=>$organization_name, 'organization_type'=>$organization_type);

		$this->db->where('id',$id); 
 		$this->db->update('client_profile',$update_data);
 		
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/clients');
	}
	
	
	public function delete_client_profile($id){
		$delete_date = strtotime(date('Y-m-d H:i:s'));
		$update_data = array('is_delete'=>'0', 'delete_date'=>$delete_date);
		
		$this->db->where('id',$id); 
 		$this->db->update('client_profile',$update_data);
		//$query = $this->db->delete('client_profile', array('id'=>$id));
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
		
}