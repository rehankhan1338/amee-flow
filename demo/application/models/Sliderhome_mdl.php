<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sliderhome_mdl extends CI_Model {
	
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
	
	public function delete_slider($id){
		// Unlink
		$this->db->where('id', $id);
		$query = $this->db->get('slider');
		$result= $query->row();
		$slider_img = $result->image;
		
		$query = $this->db->delete('slider', array('id' => $id));
			
			// Unlink
 			$path = './assets/homeslider/';
			unlink( $path . $slider_img ); 	
  		$this->session->set_flashdata('success', 'Deleted successfully!'); 
	}
	
	
	public function slider_details(){
 		$this->db->order_by('id', 'desc');
		$query = $this->db->get('slider');
		return $query->result();
	}
	
	
	public function slider_fulldetails($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('slider');
		return $query->row();
	}
	
	
	public function add_slider(){
	 	$txt_title = trim($this->input->post('txt_title'));
		$txt_subtitle = trim($this->input->post('txt_subtitle'));
		
		$insert_data=array("title"=>$txt_title,
			"sub_title"=>$txt_subtitle,
			"add_date"=>time());
		$this->db->insert('slider',$insert_data);
		$slider_id = $this->db->insert_id(); 
		
		if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
			if($_FILES['photo']['error']==0){
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
				$photo=time().'.'.$ext;
				
				$config['file_name'] =$photo;
				$config['upload_path'] = './assets/homeslider/';
				$config['allowed_types'] = '*';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('photo');
			}
			$slider_data=array("image"=>$photo);
			$this->db->where('id',$slider_id); 
 			$this->db->update('slider',$slider_data);
		}
	}
	

	public function edit_slider($id){
	 	$txt_title = trim($this->input->post('txt_title'));
		$txt_subtitle = trim($this->input->post('txt_subtitle'));		
			
			// Unlink
			$this->db->where('id', $id);
			$query = $this->db->get('slider');
			$result= $query->row();
			$slider_img = $result->image;
		
		$update_data=array("title"=>$txt_title,"sub_title"=>$txt_subtitle);
		$this->db->where('id',$id); 
 		$this->db->update('slider',$update_data);
 		
 		if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
			if($_FILES['photo']['error']==0){
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
				$photo=time().'.'.$ext;
				
				$config['file_name'] =$photo;
				$config['upload_path'] = './assets/homeslider/';
				$config['allowed_types'] = '*';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('photo');
			}
			$slider_data=array("image"=>$photo);
			$this->db->where('id',$id); 
 			$this->db->update('slider',$slider_data);
 			
 			// Unlink
 			$path = './assets/homeslider/';
			unlink( $path . $slider_img ); 			
		}
		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/slider');
	}
	
		
}