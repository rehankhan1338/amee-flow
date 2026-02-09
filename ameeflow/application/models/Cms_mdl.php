<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_mdl extends CI_Model {
	
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

	public function saveGuide(){
		$guideFor = $this->input->post('guideFor');
		$path = './assets/guide/';
		if(isset($_FILES['guideDoc']['name']) && $_FILES['guideDoc']['name']!=''){            
			$curTime = time().'-guide';
			$oldguideDoc = $this->input->post('oldguideDoc');
			$fileDocument = explode(".", $_FILES['guideDoc']['name']);
			$fileExt = strtolower(end($fileDocument));
			$fileName = $curTime.".".$fileExt;
			$config['file_name'] = $fileName;
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'pdf';
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->do_upload('guideDoc');
			$errors = $this->upload->display_errors('<span>', '</span>');
			if(isset($errors) && $errors!=''){
				return 'error||'.$errors;
			}else{
				if(isset($oldguideDoc) && $oldguideDoc!=''){
					unlink($path.$oldguideDoc); 	
				}				
				$this->db->where('id', 1);
				if($guideFor=='project-manager'){
					$this->db->update('configuration', array("pmGuide"=>$fileName)); 
				}else if($guideFor=='area-expert'){
					$this->db->update('configuration', array("areaExpertGuide"=>$fileName)); 
				}else{
					$this->db->update('configuration', array("userGuide"=>$fileName)); 
				}				
				return 'success||'.base_url().$this->config->item('admin_directory_name').'cms/guide/'.$guideFor;
			}            
		}
	}
	
	public function admin_prompts_listing(){
		$this->db->where('promptSts', 1);
		$query = $this->db->get('prompting');
		return $query->result_array();
	}	
	
	public function prompts_details($promptId){
		$this->db->where('promptId', $promptId);
		$query = $this->db->get('prompting');
		return $query->row_array();
	}
	
	public function savePromptData(){
		$promptId = $this->input->post('promptId');	
		//$promptFor = $this->input->post('promptFor');
		$msgSystemRole = $this->input->post('msgSystemRole');
		$msgUserRole = $this->input->post('msgUserRole');
		$maxTokenCnt = $this->input->post('maxTokenCnt');
		$this->db->where('promptId', $promptId);
		$this->db->update('prompting', array("msgSystemRole"=>$msgSystemRole, "msgUserRole"=>$msgUserRole, "maxTokenCnt"=>$maxTokenCnt));//"promptFor"=>$promptFor, 
		$this->session->set_flashdata('success', 'Updated successfully!'); 
		return 'success||'.base_url().$this->config->item('admin_directory_name').'cms/prompts';
	}	
	
	public function front_cms_data(){
		$this->db->where('frontSts', '1');
		$query = $this->db->get('cms');
		return $query->result_array();
	}  
	
	public function top_section_update(){
		$page_name = $this->input->post('h_page_name');
		$module_name = $this->input->post('h_module_name');
		
		$content = $this->input->post('content');
		$title_span = $this->input->post('title_span');
		$subtitle = $this->input->post('subtitle');
		$title = $this->input->post('title');

		$startDate = strtotime($this->input->post('startDate'));
		$endDate = strtotime($this->input->post('endDate'));
		
		$this->db->where('page_name', $page_name);
		$this->db->where('module_name', $module_name);
		$this->db->update('cms', array("content"=>$content, "title_span"=>$title_span, "subtitle"=>$subtitle, "title"=>$title, "image"=>$startDate, "add_date"=>$endDate));
		$this->session->set_flashdata('success', 'Updated successfully!'); 
		return 'success||';
	}
	
	public function get_configuration_details(){
		$query = $this->db->get('configuration');
		return $query->row();
	}
 
	public function cms_details($page_name,$module_name){
		$this->db->where('page_name', $page_name);
 		$this->db->where('module_name', $module_name);
		$query = $this->db->get('cms');
		return $query->row();
	}
	
	public function content_manage($page_name,$module_name){
	 
		$page_name_label = ucwords(str_replace('_',' ',$page_name));
		
		$this->db->where('page_name', $page_name);
		$this->db->where('module_name', $module_name);
		$query = $this->db->get('cms');
		$num = $query->num_rows(); 
		$txt_title = trim($this->input->post('txt_title'));
		$txt_content = $this->input->post('txt_content');
		
		if($num==0){
			$insert_data=array(
				"page_name"=>$page_name,
				"module_name"=>$module_name,
				"title"=>$txt_title, 
				"content"=>$txt_content,
				"add_date"=>time());
			
			$this->db->insert('cms',$insert_data);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('success', $page_name_label.' page content has been saved successfully!'); 
		}else{
			$row = $query->row();
			$id = $row->id;
			$data=array("title"=>$txt_title,"content"=>$txt_content);	
			$this->db->where('id', $id);
			$this->db->update('cms',$data);
			$this->session->set_flashdata('success', $page_name_label.' page content has been updated successfully!'); 
		}
		
		$custom_fields = get_cmsmeta_fields_h($id);	
		
		if(count($custom_fields)>0){
			
			foreach ($custom_fields as $field_data) {
			
				$meta_key = $field_data->meta_key;
				$meta_value = $_POST["$meta_key"];
				
				$cmsmeta_data=array("meta_value"=>$meta_value);	
				
				$this->db->where('meta_key', $meta_key);
				$this->db->where('page_id', $id);
				$this->db->update('cmsmeta',$cmsmeta_data);				
			}
		
		}
		
		
		if(isset($_FILES['upDoc']['name']) && $_FILES['upDoc']['name']!=''){
		
			$fil_exp_upDoc = explode(".", $_FILES['upDoc']['name']);
			$fileExt = strtolower(end($fil_exp_upDoc));
			$fileName = time().".".$fileExt;				
			
			$path = './assets/upload/logo/';
			$config['file_name'] = $fileName;
			$config['upload_path'] = $path;
			$config['allowed_types'] = '*';
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->do_upload('upDoc');				
			$errors = $this->upload->display_errors();
			if(isset($errors) && $errors!=''){
				 
			}else{
				
				if(isset($id) && $id!='' && $id>0){
					$old_upload_doc = trim($this->input->post('old_upload_doc'));
					if(isset($old_upload_doc) && $old_upload_doc!=''){
 						$chkFileExist = FCPATH.'assets/upload/logo/'.$old_upload_doc;
						if(file_exists($chkFileExist)){
							unlink($path.$old_upload_doc);
						}
					}
				}
				
				$this->db->where('id', $id);
				$this->db->update('cms', array("image"=>$fileName));
			}
		}
		
		
			
	}
	
	public function welcome_content_detail($page_name,$module_name){ 		
 		$this->db->where('page_name', $page_name);
 		$this->db->where('module_name', $module_name);
		$query = $this->db->get('cms');
		return $query->row();
	}	
	
	public function add_welcome_content($page_name,$module_name){
		$page_name_label = ucwords(str_replace('_',' ',$page_name));
	 	$txt_title = trim($this->input->post('txt_title'));
		$txt_title_span = trim($this->input->post('txt_title_span'));
		$txt_subtitle = trim($this->input->post('txt_subtitle'));
		$txt_content = $this->input->post('txt_content');
		
		$insert_data=array("page_name"=>$page_name,"module_name"=>$module_name,
			"title"=>$txt_title, "title_span"=>$txt_title_span,"subtitle"=>$txt_subtitle,
			"content"=>$txt_content, "add_date"=>time());
				
		$this->db->where('page_name', $page_name);
		$this->db->where('module_name', $module_name);
		$query = $this->db->get('cms');
		$num = $query->num_rows(); 
		$row = $query->row();
		$id = $row->id;
		
		if($num==0){
			$this->db->insert('cms',$insert_data);
			$this->session->set_flashdata('success', $page_name_label.' page content has been saved successfully!'); 
		}else{
			$this->db->where('id', $id);
			$this->db->update('cms',$insert_data);
			$this->session->set_flashdata('success', $page_name_label.' page content has been updated successfully!'); 
		}
	}
	
	
	  
}