<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgets_mdl extends CI_Model {
	
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
	
	public function widgets_list(){
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('widgets');
		return $query->result();
		
	}
	
	public function widgets_data_save(){
	
		$widget_id = $_POST['hwidget_id'];
 		$this->db->where('id', $widget_id);
		$query = $this->db->get('widgets');
		$row = $query->row();
 		$is_widgets_meta = $row->is_widgets_meta;
  		
 		if($is_widgets_meta==0){
			
			$widget_key = $row->widget_key;
 			$content = trim($this->input->post('widget_value_'.$widget_key)); 
 			$update_data=array("content"=>$content);
 			$this->db->where('id',$widget_id); 
			$this->db->update('widgets',$update_data);
		
		}else{
			
			$this->db->where('widget_id', $widget_id);
			$query_widgets_meta = $this->db->get('widgets_meta');
			$widgets_meta_data = $query_widgets_meta->result();
			
			foreach ($widgets_meta_data as $widgets_meta_details) {
  
				$field_type = trim($widgets_meta_details->field_type);
				$meta_id = $widgets_meta_details->id;
				$meta_key = $widgets_meta_details->meta_key.$widget_id;
				
 				if($field_type=='6'){
					
					if(isset($_FILES["$meta_key"]['name']) && $_FILES["$meta_key"]['name']!=''){
			
						if($_FILES["$meta_key"]['error']==0){
						
							$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES["$meta_key"]['name']);
							$photo=time().'.'.$ext;
							
							$config['file_name'] =$photo;
							$config['upload_path'] = './assets/upload/';
							$config['allowed_types'] = '*';
							$this->load->library('upload');
							$this->upload->initialize($config);
							$this->upload->do_upload("$meta_key");
							
							$update_data123=array("meta_value"=>$photo); 
							$this->db->where('id',$meta_id); 
							$this->db->update('widgets_meta',$update_data123);
							
						} 
						
					}
				
				}else{
 					
					$content = trim($this->input->post("$meta_key"));
					$update_data=array("meta_value"=>$content); 
					$this->db->where('id',$meta_id); 
					$this->db->update('widgets_meta',$update_data);
					
				}
			
			}
		
		}
 		
	}
	
	public function field_type_list(){
		$this->db->order_by('id', 'asc');
		$this->db->where('status', '0');
		$query = $this->db->get('field_type');
		return $query->result();
		
	}
	
	public function widget_add(){
	
		$widget_key = trim($this->input->post('txt_key'));
		
		$this->db->where('widget_key', $widget_key);
		$query = $this->db->get('widgets');
		$num_row = $query->num_rows();
		
		if($num_row==0){
		
			$widget_title = trim($this->input->post('txt_title'));
			$widget_type = trim($this->input->post('widget_type'));
			//$is_page = trim($this->input->post('page_status'));
			//$page_name = trim($this->input->post('page_name')); 
			
			$insert_data=array(
				//"is_page"=>$is_page,
				//"page_name"=>$page_name,
				"widget_key"=>$widget_key,
				"widget_title"=>$widget_title,
				"is_widgets_meta"=>$widget_type,
				"add_date"=>time());
				
			$this->db->insert('widgets',$insert_data);
			$this->session->set_flashdata('success', 'Widget added successfully!'); 
		
		}else{
			
			$this->session->set_flashdata('error', 'Sorry, widget key already exist!'); 
			redirect('admin/widgets/add');
		}
	}
	
	public function get_widgetsmeta_fields($widget_id){
		
		$this->db->where('widget_id', $widget_id);
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('widgets_meta');
		return $query->result();	
	
	}
	
	public function get_widgetmeta_options($widgetmeta_id){
		$this->db->where('widgetmeta_id', $widgetmeta_id);
		$query = $this->db->get('widgetmeta_options');
		return $query->result();	
	}
	
	
	
	public function addmeta($wid){	
		$fild_type = $this->input->post('fild_type');
		$meta_label = trim($this->input->post('meta_label'));
		$placeholder = trim($this->input->post('placeholder'));
		$is_required = trim($this->input->post('is_required'));
		$meta_key = trim($this->input->post('meta_key')); 
		
			// Title check
			$this->db->where('widget_id', $wid);
			$this->db->where('meta_key', $meta_key);
			$this->db->or_where('meta_label',$meta_label);
			$query = $this->db->get('widgets_meta');
			$num_row = $query->num_rows();
			if($num_row==1){
				$this->session->set_flashdata('error', 'Sorry, Please change your meta key or lable name!'); 
				redirect('admin/widgets/addmeta?wid='.$wid);
			}
		
		if($fild_type=='4' || $fild_type=='5'){
			$field_options = '1';	
			$meta_value = '';	
			$meta_arr=array('widget_id'=>$wid, 'field_type'=>$fild_type, 
				'is_field_options'=>$field_options, 'meta_label'=>$meta_label, 
				'meta_key'=>$meta_key, 'meta_value'=>$meta_value,
				'placeholder'=>$placeholder, 'is_required'=>$is_required);
			
			$this->db->insert('widgets_meta',$meta_arr);
			$insertid = $this->db->insert_id();
			
			$option_name = $this->input->post('option_name');
			foreach($option_name as $option){
				$arr = array('widgetmeta_id'=>$insertid, 'option_name'=>$option);
				$this->db->insert('widgetmeta_options',$arr);
			}
				
		}else{
			$field_options = '0';	
			$meta_value = '';	
			$meta_arr=array('widget_id'=>$wid, 'field_type'=>$fild_type, 
				'is_field_options'=>$field_options, 'meta_label'=>$meta_label, 
				'meta_key'=>$meta_key, 'meta_value'=>$meta_value,
				'placeholder'=>$placeholder, 'is_required'=>$is_required);
			
			$this->db->insert('widgets_meta',$meta_arr);
		}
		
		$this->session->set_flashdata('success', 'Added successfully!');
		redirect('admin/widgets/listing');		
	}
	
}