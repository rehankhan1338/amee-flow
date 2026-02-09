<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_commons_mdl extends CI_Model {
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
	
	function master_survey_types(){
		$this->db->where('status', '0');
		//$this->db->order_by('survey_id', 'desc');
		$query = $this->db->get('master_survey_types');
		return $query->result();
	}
	
	function data_commons_details(){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('status', '0');
		$this->db->where('department_id', $dept_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('data_commons');
		return $query->result();
	}		
	
	function data_commons_details_not_dept_id(){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('status', '0');
		$this->db->where('department_id!=', $dept_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('data_commons');
		return $query->result();
	}		
	
	function data_commons_details_row($id){
		//$dept_id = $this->session->userdata('dept_id');
		$this->db->where('status', '0');
		//$this->db->where('department_id', $dept_id);
		$this->db->where('id', $id);
		$query = $this->db->get('data_commons');
		return $query->row();
	}
		
	public function add_data_commons($dept_id){	
		$txt_title = $this->input->post('txt_title');
		$data_type = $this->input->post('data_type');
		
		if(isset($data_type)&&$data_type=='1'){
			$type_id = $this->input->post('survey_type');
		}else if(isset($data_type)&&$data_type=='2'){
			$type_id = $this->input->post('assignment_type');
		}else if(isset($data_type)&&$data_type=='3'){
			$type_id = $this->input->post('test_type');
		}
				
		$core_competency = $this->input->post('core_competency');
		$descriptive_text = $this->input->post('descriptive_text');
		$add_date = time();
		
		$arr = array('department_id'=>$dept_id, 'title'=>$txt_title, 'data_type'=>$data_type, 'type_id'=>$type_id, 'descriptive_text'=>$descriptive_text, 'core_competency'=>$core_competency, 'add_date'=>$add_date);
		$query = $this->db->insert('data_commons', $arr);
		$insert_id = $this->db->insert_id();				
				
		if(isset($_FILES['photo']) && $_FILES['photo']!=''){
			$config['upload_path'] = './assets/frontend/upload/Data_commons/upload_images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			//$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			$fileName = time().'_'.str_replace(' ','_',trim($_FILES['photo']['name']));
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/frontend/upload/Data_commons/upload_images/'.$fileName,
					'new_image'         => './assets/frontend/upload/Data_commons/upload_images/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 320,
					'height'            => 250
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 
					
					/*$imgquery = $this->db->get_where('surveys',array('survey_id'=>$h_survey_id));
					$imgrow = $imgquery->row();
					$imgname = $imgrow->survey_sponsor_logo;
					
					//UNLINK
					$file_upload_directory = './assets/frontend/upload/surveys/';
					$file_upload_directory1 = './assets/frontend/upload/surveys/thumbnails/';
					$unlink = unlink($file_upload_directory.$imgname);
					$unlink1 = unlink($file_upload_directory1.$imgname);*/
					
				$data=array("upload_image"=>$fileName);
				$this->db->where('id',$insert_id); 
				$query = $this->db->update('data_commons', $data);
			} 
		}	
		
		if(isset($_FILES['photo1']) && $_FILES['photo1']!=''){
			$config['upload_path'] = './assets/frontend/upload/Data_commons/add_thumbnail/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			//$count = count($_FILES['photo1']['name']);
			$_FILES['photo1']['name'] = $files['photo1']['name'];
			$_FILES['photo1']['type'] = $files['photo1']['type'];
			$_FILES['photo1']['tmp_name'] = $files['photo1']['tmp_name'];
			$_FILES['photo1']['error'] = $files['photo1']['error'];
			$_FILES['photo1']['size'] = $files['photo1']['size'];
			$fileName1 = time().'_'.str_replace(' ','_',trim($_FILES['photo1']['name']));
			$images[] = $fileName1;
			$config['file_name'] = $fileName1;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo1')) {
				$config1 = array(
					'source_image'      => './assets/frontend/upload/Data_commons/add_thumbnail/'.$fileName1,
					'new_image'         => './assets/frontend/upload/Data_commons/add_thumbnail/thumbnails/'.$fileName1,
					'maintain_ratio'    => true,
					'width'             => 320,
					'height'            => 250
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 	
								
				$data=array("add_thumbnail"=>$fileName1);
				$this->db->where('id',$insert_id); 
				$query = $this->db->update('data_commons', $data);
			} 
		}	
  		$this->session->set_flashdata('success', 'Save successfully!');
	}
	
	
	
	function edit_data_commons($id){
			$imgquery = $this->db->get_where('data_commons',array('id'=>$id));
			$imgrow = $imgquery->row();
			$imgname_upload = $imgrow->upload_image;
			$imgname_thumbnail = $imgrow->add_thumbnail;
		
		$txt_title = $this->input->post('txt_title');
		$data_type = $this->input->post('data_type');
		
		if(isset($data_type)&&$data_type=='1'){
			$type_id = $this->input->post('survey_type');
		}else if(isset($data_type)&&$data_type=='2'){
			$type_id = $this->input->post('assignment_type');
		}else if(isset($data_type)&&$data_type=='3'){
			$type_id = $this->input->post('test_type');
		}
				
		$core_competency = $this->input->post('core_competency');
		$descriptive_text = $this->input->post('descriptive_text');
		
		$arr = array('title'=>$txt_title, 'data_type'=>$data_type, 'type_id'=>$type_id,'descriptive_text'=>$descriptive_text, 'core_competency'=>$core_competency);
		$this->db->where('id',$id); 
		$query = $this->db->update('data_commons', $arr);
		
		
		if(isset($_FILES['photo']) && $_FILES['photo']!=''){
			$config['upload_path'] = './assets/frontend/upload/Data_commons/upload_images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			//$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			$fileName = time().'_'.str_replace(' ','_',trim($_FILES['photo']['name']));
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/frontend/upload/Data_commons/upload_images/'.$fileName,
					'new_image'         => './assets/frontend/upload/Data_commons/upload_images/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 320,
					'height'            => 250
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 

				//UNLINK
				if(isset($imgname_upload) && $imgname_upload!=''){
					$file_upload_directory = './assets/frontend/upload/Data_commons/upload_images/';
					$file_upload_directory1 = './assets/frontend/upload/Data_commons/upload_images/thumbnails/';
					$unlink = unlink($file_upload_directory.$imgname_upload);
					$unlink1 = unlink($file_upload_directory1.$imgname_upload);
				}
					
				$data=array("upload_image"=>$fileName);
				$this->db->where('id',$id); 
				$this->db->update('data_commons', $data);
			} 
		}	
				
		if(isset($_FILES['photo1']) && $_FILES['photo1']!=''){
			$config['upload_path'] = './assets/frontend/upload/Data_commons/add_thumbnail/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			//$count = count($_FILES['photo1']['name']);
			$_FILES['photo1']['name'] = $files['photo1']['name'];
			$_FILES['photo1']['type'] = $files['photo1']['type'];
			$_FILES['photo1']['tmp_name'] = $files['photo1']['tmp_name'];
			$_FILES['photo1']['error'] = $files['photo1']['error'];
			$_FILES['photo1']['size'] = $files['photo1']['size'];
			$fileName1 = time().'_'.str_replace(' ','_',trim($_FILES['photo1']['name']));
			$images[] = $fileName1;
			$config['file_name'] = $fileName1;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo1')) {
				$config1 = array(
					'source_image'      => './assets/frontend/upload/Data_commons/add_thumbnail/'.$fileName1,
					'new_image'         => './assets/frontend/upload/Data_commons/add_thumbnail/thumbnails/'.$fileName1,
					'maintain_ratio'    => true,
					'width'             => 320,
					'height'            => 250
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 	
				
				//UNLINK
				if(isset($imgname_thumbnail) && $imgname_thumbnail!=''){
					$file_upload_directory = './assets/frontend/upload/Data_commons/add_thumbnail/';
					$file_upload_directory1 = './assets/frontend/upload/Data_commons/add_thumbnail/thumbnails/';
					$unlink = unlink($file_upload_directory.$imgname_thumbnail);
					$unlink1 = unlink($file_upload_directory1.$imgname_thumbnail);
				}	
								
				$data=array("add_thumbnail"=>$fileName1);
				$this->db->where('id',$id); 
				$this->db->update('data_commons', $data);
			} 
		}	
		$this->session->set_flashdata('success', 'Update successfully!');
	}
		
	function delete($id){
		$this->db->where('id', $id);
		$query = $this->db->delete('data_commons');
	}
	
	function suites_user_detail_row($id,$uni_id,$dept_id){
		$this->db->set_dbprefix($this->config->item('superadmin_table_prefix'));
		$this->db->dbprefix('suites_user'); // outputs newprefix_tablename
		
		$this->db->where('department_id', $dept_id);
		$this->db->where('university_id', $uni_id);
		$this->db->where('suites_id', $id);
		$query = $this->db->get('suites_user');
		return $query->row();
	}
	
}
?>