<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_mdl extends CI_Model {
	
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
	
	public function university_details(){
 		$this->db->where('is_delete', '1');
 		$this->db->where('status', '1');
		$this->db->where('manage_sts', '1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('university');
		return $query->result();
	}
	
	public function university_detail_row($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('university');
		return $query->row();
	}
	
	public function add_university(){
		$subdomain_name = trim($this->input->post('subdomain_name')); 
		$university_name = trim($this->input->post('university_name')); 
		$first_name = ucfirst($this->input->post('first_name'));
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$state = $this->input->post('state');
		$city = $this->input->post('city');
		$zip_code = $this->input->post('zip_code');
		$popup_message = $this->input->post('popup_message');
		
		$this->db->where('subdomain_name', $subdomain_name);
		$query_university = $this->db->get('university');
		$row_count = $query_university->num_rows();
		
		if($row_count==0){ 			
			$insert_data=array('university_name'=>$university_name,'subdomain_name'=>$subdomain_name,
				'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'phone'=>$phone, 
				'address'=>$address, 'state'=>$state, 'city'=>$city, 'zip_code'=>$zip_code,
				'popup_message_status'=>$popup_message, "add_date"=>time());
				
			$this->db->insert('university',$insert_data);
			$insert_id = $this->db->insert_id(); 
			
			if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
				if($_FILES['photo']['error']==0){
					$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
					$photo=time().'.'.$ext;
					
					$config['file_name'] =$photo;
					$config['upload_path'] = './assets/university/';
					$config['allowed_types'] = '*';
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('photo');
				}
				$image_data=array("image"=>$photo);
				$this->db->where('id',$insert_id); 
				$this->db->update('university',$image_data);
			}
			
			//==--Mail--==//			
			$query = $this->db->get('configuration');
		 	$configuration_details = $query->row();			 	
		 	$logo = base_url().'assets/backend/logo/thumbnails/'.$configuration_details->logo;	 		
		 	$id = 'id';
			$password = 'Password';			
			$link = $subdomain_name.'.assessmentmadeeasy.com';	
						
			$to = $email;	
			$this->db->select('*');
			$this->db->where('purpose', 'Welcome to AMEE');
			$query1 = $this->db->get('email_templates');
			$fetch_email_templates = $query1->row();
			$subject = $fetch_email_templates->subject;
			$email_message = $fetch_email_templates->message;
			$status_email = $fetch_email_templates->status;
			
			if($status_email==1){			
   				$message=str_replace('{logo}',$logo,$email_message);
   				$message=str_replace('{university_name}',$university_name,$message);
   				$message=str_replace('{user_id}',$id,$message);
   				$message=str_replace('{password}',$password,$message);
   				$message=str_replace('{link}',$link,$message);
				$mail = send_mail($to,$message,'','info',$subject);	
			}
			$this->session->set_flashdata('success', 'Added successfully!'); 
			redirect('admin/accounts');

		}else{			 
			$session_data=array('sess_university_name'=>$university_name,'sess_subdomain_name'=>$subdomain_name,
				'sess_first_name'=>$first_name, 'sess_last_name'=>$last_name, 'sess_email'=>$email, 'sess_phone'=>$phone, 
				'sess_address'=>$address, 'sess_state'=>$state, 'sess_city'=>$city, 'sess_zip_code'=>$zip_code,
				'sess_popup_message'=>$popup_message, 'error'=>'sorry, the "<b>'.$subdomain_name.'</b>" subdomain is already exist!');
			$this->session->set_flashdata($session_data); 
			redirect('admin/accounts/add');
		}
	}
	

	public function edit_university($id){
	 	$subdomain_name = trim($this->input->post('subdomain_name')); 
		$this->db->where('id!=', $id);
		$this->db->where('subdomain_name', $subdomain_name);
		$query_university = $this->db->get('university');
		$row_count = $query_university->num_rows();
		
		if($row_count==0){
			$university_name = trim($this->input->post('university_name')); 
			$first_name = ucfirst($this->input->post('first_name'));
			$last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$address = $this->input->post('address');
			$state = $this->input->post('state');
			$city = $this->input->post('city');
			$zip_code = $this->input->post('zip_code');
			$popup_message = $this->input->post('popup_message');
			
			$update_data = array('university_name'=>$university_name,'subdomain_name'=>$subdomain_name,
				'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'phone'=>$phone, 
				'address'=>$address, 'state'=>$state, 'city'=>$city, 'zip_code'=>$zip_code, 
				'popup_message_status'=>$popup_message);
	
			$this->db->where('id',$id); 
			$this->db->update('university',$update_data);
			
			if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
				if($_FILES['photo']['error']==0){
					$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
					$photo=time().'.'.$ext;
					
					$config['file_name'] =$photo;
					$config['upload_path'] = './assets/upload/university/';
					$config['allowed_types'] = '*';
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('photo');
				}
				$image_data=array("image"=>$photo);
				$this->db->where('id',$id); 
				$this->db->update('university',$image_data);
			}
			$this->session->set_flashdata('success', 'Update successfully!'); 
			redirect('admin/accounts');
		
		}else{
			$this->session->set_flashdata('error', 'sorry, the "<b>'.$subdomain_name.'</b>" subdomain is already exist!');
			redirect('admin/accounts/edit/'.$id);
		}
	}
	
	public function delete_university($id){
		$delete_date = strtotime(date('Y-m-d H:i:s'));
		$update_data = array('is_delete'=>'0', 'delete_date'=>$delete_date);
		
		$this->db->where('id',$id); 
 		$this->db->update('university',$update_data);
		//$query = $this->db->delete('university', array('id'=>$id));
		
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}	
	
	
	public function sendmail($id){	
		$query = $this->db->get('configuration');
	 	$configuration_details = $query->row();			 	
	 	$logo = base_url().'assets/backend/logo/thumbnails/'.$configuration_details->logo;	 
		
		$this->db->where('id', $id);
		$query = $this->db->get('university');
		$university_row = $query->row();

		$email = $university_row->email;
		$university_name = $university_row->university_name;
		$link = $university_row->subdomain_name.'.assessmentmadeeasy.com';	
		$product_id= 'product_id';	
		$product_name= 'product_name';	
		$today_date= date('M-d-Y');	
		$billing_term=	'billing_term';
		$additional_suites=	'additional_suites';	
		
		//==--Mail--==//							
			$to = $email;	
			$this->db->select('*');
			$this->db->where('purpose', 'Renewal Notice');
			$query1 = $this->db->get('email_templates');
			$fetch_email_templates = $query1->row();
			$subject = $fetch_email_templates->subject;
			$email_message = $fetch_email_templates->message;
			$status_email = $fetch_email_templates->status;
			
			if($status_email==1){			
   				$message=str_replace('{logo}',$logo,$email_message);
   				$message=str_replace('{link}',$link,$message);
   				$message=str_replace('{university_name}',$university_name,$message);
   				$message=str_replace('{product_id}',$product_id,$message);
   				$message=str_replace('{product_name}',$product_name,$message);
   				$message=str_replace('{today_date}',$today_date,$message);
   				$message=str_replace('{billing_term}',$billing_term,$message);
   				$message=str_replace('{additional_suites}',$additional_suites,$message);
				$mail = send_mail($to,$message,'','info',$subject);	
			}
		
  		$this->session->set_flashdata('success', 'Check your mail, Your detail sent successfully!'); 
		redirect('admin/accounts');
	}
	

		
}