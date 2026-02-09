<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_mdl extends CI_Model {
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
 
	public function cms_details($page_name,$module_name){
		$this->db->where('page_name', $page_name);
 		$this->db->where('module_name', $module_name);
		$query = $this->db->get('cms');
		return $query->row();
	}
	
	public function content_manage($page_name,$module_name){
	
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
			$this->session->set_flashdata('success', 'Save successfully!'); 
		}else{
			$row = $query->row();
			$id = $row->id;
			$data=array("title"=>$txt_title,"content"=>$txt_content);	
			$this->db->where('id', $id);
			$this->db->update('cms',$data);
			$this->session->set_flashdata('success', 'Update successfully!'); 
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
			
	}
	
	public function welcome_content_detail(){
 		$page_name = 'Home';
		$module_name = 'Welcome Content';	
 		$this->db->where('page_name', $page_name);
 		$this->db->where('module_name', $module_name);
		$query = $this->db->get('cms');
		return $query->row();
	}	
	
	public function add_welcome_content(){
		$page_name = 'Home';
		$module_name = 'Welcome Content';	
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
			$this->session->set_flashdata('success', 'Save successfully!'); 
		}else{
			$this->db->where('id', $id);
			$this->db->update('cms',$insert_data);
			$this->session->set_flashdata('success', 'Update successfully!'); 
		}
	}
	
	
	public function newsletter_subscribe($email_id){
		$insert_data=array('email_id'=>$email_id, 
			'status'=>'1', 'add_date'=>time());
			
		$this->db->where('email_id', $email_id);
		$query = $this->db->get('newsletter');
		$num = $query->num_rows(); 
		
		if($num==0){
			$this->db->insert('newsletter',$insert_data); 
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function accreditation_list(){
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('accreditation');
		return $query->result(); 
	}
	
	public function product_updates_list(){
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('amee_updates');
		return $query->result(); 
	}
	
	public function newsletters(){
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('newsletter');
		return $query->result(); 
	}
	
	public function realestate_details(){
		$this->db->order_by('id', 'desc');
		$this->db->where('is_status', '1');
		$query = $this->db->get('real_estate');
		return $query->result();
	}	
	
	public function realestate_row($reid){
		$this->db->where('id', $reid);
		$query = $this->db->get('real_estate');
		return $query->row();
	}
}