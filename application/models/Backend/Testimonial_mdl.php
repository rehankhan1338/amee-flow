<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonial_mdl extends CI_Model {
	
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
	
	/*	public function front_testimonial_details(){
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('testimonial');
		return $query->result();
	}*/
	
	public function testimonial_details(){
		
		$this->db->where('is_delete', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('testimonial');
		return $query->result();
		
	}
	
	public function testimonial_fulldetails($id){
	
 		$this->db->where('id', $id);
		$query = $this->db->get('testimonial');
		return $query->row();
			
	}
	
	
	public function add_testimonial(){
	 	$name = trim($this->input->post('name'));  
	 	$designation = $this->input->post('designation'); 
	 	$content = $this->input->post('content'); 
	 	$is_status = $this->input->post('is_status'); 
		
		$insert_data = array('name'=>$name, 'designation'=>$designation, 'content'=>$content, 'is_status'=>$is_status, "add_date"=>time());
		$this->db->insert('testimonial',$insert_data);
		$user_id = $this->db->insert_id();
	
		if(isset($_FILES['photo']) && $_FILES['photo']!=''){
			/*if(isset($_FILES['photo']['size']) && $_FILES['photo']['size']>='51200'){
				$this->session->set_flashdata('error', 'File size is too large(Uplode image size less than 50 kb)');
				redirect(base_url().'profile');
			}*/
			$config['upload_path'] = './assets/backend/testimonial/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			
			$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
			$fileName=time().'.'.$ext;
			/*$fileName = time().'_'.str_replace(' ','_',trim($_FILES['photo']['name']));*/
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/backend/testimonial/'.$fileName,
					'new_image'         => './assets/backend/testimonial/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 350,
					'height'            => 240
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 
				$data=array("image"=>$fileName);
				$this->db->where('id', $user_id);
				$this->db->update('testimonial',$data);
			} 
		}
		$this->session->set_flashdata('success', 'Added successfully!'); 
		redirect('admin/testimonial');
	}	
	
	
	public function edit_testimonial($id){
	 	$name = trim($this->input->post('name'));  
	 	$designation = $this->input->post('designation'); 
	 	$content = $this->input->post('content'); 
	 	$is_status = $this->input->post('is_status'); 
			
			// Unlink
			$this->db->where('id', $id);
			$query = $this->db->get('testimonial');
			$result= $query->row();
			$img_name = $result->image;
			
		$update_data = array('name'=>$name, 'designation'=>$designation, 'content'=>$content, 'is_status'=>$is_status);	
		$this->db->where('id',$id); 
 		$this->db->update('testimonial',$update_data);
 		
 		if(isset($_FILES['photo']) && $_FILES['photo']!=''){
			/*if(isset($_FILES['photo']['size']) && $_FILES['photo']['size']>='51200'){
				$this->session->set_flashdata('error', 'File size is too large(Uplode image size less than 50 kb)');
				redirect(base_url().'profile');
			}*/
			$config['upload_path'] = './assets/backend/testimonial/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			
			$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
			$fileName=time().'.'.$ext;
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/backend/testimonial/'.$fileName,
					'new_image'         => './assets/backend/testimonial/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 350,
					'height'            => 240
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 
				$data=array("image"=>$fileName);
				$this->db->where('id', $id);
				$this->db->update('testimonial',$data);
				
					// Unlink
					$path = './assets/backend/testimonial/';
					$path1 = './assets/backend/testimonial/thumbnails/';
					unlink( $path . $img_name );
					unlink( $path1 . $img_name );
			} 
		}
 		$this->session->set_flashdata('success', 'Update successfully!'); 
		redirect('admin/testimonial');
	}	
	
	
	public function delete_testimonial($id){
		$delete = array('is_delete'=>'1');
		$this->db->where('id',$id); 
 		$this->db->update('testimonial',$delete);
  		$this->session->set_flashdata('success', 'Deleted successfully!'); 
	}
	
}