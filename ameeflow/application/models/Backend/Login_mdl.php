<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_mdl extends CI_Model {
	
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
	
	function edit_sub_admins($id){
		
		$category_ids = $this->input->post('category_ids');
		if(count($category_ids)>0){
			$category_id=array();
			for($i=0;$i<count($category_ids);$i++){
 				$category_id[]= $category_ids[$i]; 
 			}
			$admin_category_ids=implode(',',$category_id);
		}else{
		
			$admin_category_ids='';
		}
		
		$subcategory_ids = $this->input->post('subcategory_ids');
		if(count($subcategory_ids)>0){
			$subcategory_id=array();
			for($i=0;$i<count($subcategory_ids);$i++){
 				$subcategory_id[]= $subcategory_ids[$i]; 
 			}
			$admin_subcategory_ids=implode(',',$subcategory_id);
		}else{
		
			$admin_subcategory_ids='';
		}
		
		$subcategory_subcat_ids = $this->input->post('subcategory_subcat_ids');
		if(count($subcategory_subcat_ids)>0){
			$subcategory_subcat_id=array();
			for($i=0;$i<count($subcategory_subcat_ids);$i++){
 				$subcategory_subcat_id[]= $subcategory_subcat_ids[$i]; 
 			}
			$admin_subcategory_subcat_ids=implode(',',$subcategory_subcat_id);
		}else{
		
			$admin_subcategory_subcat_ids='';
		}
	
		//$guest_id = 'admin';    
 		$superadmin_name = $this->input->post('superadmin_name'); 
		$guest_email = $this->input->post('guest_email'); 
		
		//$contactNo = $this->input->post('contactNo'); 
		//$address = $this->input->post('address'); 
 		
		$username = $this->input->post('guest_user_name');		
		$status = $this->input->post('guest_status');
		
		$query_1 = $this->db->get_where('admin_login', array('username' =>$username, 'id != ' =>$id));
		$count_1 = $query_1->num_rows();
		if($count_1>0){
			$this->session->set_flashdata('error', 'sorry, username already exist!');
			redirect(base_url().$this->config->item('admin_directory_name').'subadmins/edit/'.$id);	
		}else{
			 
 			$this->db->where('id',$id); 
			$this->db->update('admin_login', array("name"=>$superadmin_name, "email"=>$guest_email, "username"=>$username, "menu_ids"=>$admin_category_ids, "submenu_ids"=>$admin_subcategory_ids, "submenu_subcat_ids"=>$admin_subcategory_subcat_ids, "status"=>$status));
			$this->session->set_flashdata('success', 'Updated successfully!');
		}
		
		$password = $this->input->post('guest_password');		
		if(isset($password) && $password!=''){				
			$this->db->where('id',$id); 
			$this->db->update('admin_login', array("password"=>md5($password), "password_v"=>$password));			
		}
	}
	
	public function delete_sub_admins($id){
	    
		$query = $this->db->delete('admin_login', array('id' => $id));
  		$this->session->set_flashdata('success', 'Deleted successfully!'); 
		
	}
	
	function sub_admins_details(){
	
 		$query = $this->db->get_where('admin_login', array('admin_type != ' =>'super_admin'));
		return $query->result();
		
	}
	
	function add_sub_admins(){
		
		$category_ids = $this->input->post('category_ids');
		if(count($category_ids)>0){
			$category_id=array();
			for($i=0;$i<count($category_ids);$i++){
 				$category_id[]= $category_ids[$i]; 
 			}
			$admin_category_ids=implode(',',$category_id);
		}else{
		
			$admin_category_ids='';
		}
		
		$subcategory_ids = $this->input->post('subcategory_ids');
		if(count($subcategory_ids)>0){
			$subcategory_id=array();
			for($i=0;$i<count($subcategory_ids);$i++){
 				$subcategory_id[]= $subcategory_ids[$i]; 
 			}
			$admin_subcategory_ids=implode(',',$subcategory_id);
		}else{
		
			$admin_subcategory_ids='';
		}
		
		$subcategory_subcat_ids = $this->input->post('subcategory_subcat_ids');
		if(count($subcategory_subcat_ids)>0){
			$subcategory_subcat_id=array();
			for($i=0;$i<count($subcategory_subcat_ids);$i++){
 				$subcategory_subcat_id[]= $subcategory_subcat_ids[$i]; 
 			}
			$admin_subcategory_subcat_ids=implode(',',$subcategory_subcat_id);
		}else{
		
			$admin_subcategory_subcat_ids='';
		}
	
		$guest_id = 'sub_admin';  
 		$superadmin_name = $this->input->post('superadmin_name'); 
		$guest_email = $this->input->post('guest_email');  
		
		//$contactNo = $this->input->post('contactNo'); 
		//$address = $this->input->post('address');  
 		
		$username = $this->input->post('guest_user_name'); 
		$password = $this->input->post('guest_password');
		$status = $this->input->post('guest_status');
		
		$query_1 = $this->db->get_where('admin_login', array('username' =>$username));
		$count_1=$query_1->num_rows();
		if($count_1>0){
			$this->session->set_flashdata('error', 'sorry, username already exist!');
			redirect(base_url().$this->config->item('admin_directory_name').'subadmins/add');	
		}else{
			 
			$insert_data = array("admin_type"=>$guest_id, "name"=>$superadmin_name, "email"=>$guest_email ,"username"=>$username, "password"=>md5($password), "password_v"=>$password, "menu_ids"=>$admin_category_ids, "submenu_ids"=>$admin_subcategory_ids, "submenu_subcat_ids"=>$admin_subcategory_subcat_ids, "status"=>$status, "image"=>'1546971026.png');//, "contactNo"=>$contactNo, "address"=>$address
			
			$this->db->insert('admin_login',$insert_data); 
			
			/*$query_admin_login = $this->db->get_where('admin_login', array('id' =>'1'));
			$admin_login = $query_admin_login->row();
			$department_name = $admin_login->department_name;
			$owner_name = $admin_login->name;
			
			$query_email_templates = $this->db->get_where('email_templates', array('purpose' =>'Guest access to SOCBuilder'));
			$email_templates = $query_email_templates->row();
			$email_subject = $email_templates->subject;
			$email_message = $email_templates->message;
			$email_status = $email_templates->status;
			$guest_profile_link=base_url();
			
			if($email_status==1){
		
				$to=$guest_email;
				
				$email_message1=str_replace('{guest_name}',$superadmin_name,$email_message);
				$email_message1=str_replace('{guest_profile_link}',$guest_profile_link,$email_message1);
				$email_message1=str_replace('{login_uesrname}',$username,$email_message1);
				$email_message1=str_replace('{login_password}',$password,$email_message1);
				$email_message1=str_replace('{name_of_department}',$department_name,$email_message1);
				$email_message1=str_replace('{superadmin_name}',$owner_name,$email_message1);
				
				send_mail($to,$email_message1,$superadmin_name,'info',$email_subject);
			}*/
			
			$this->session->set_flashdata('success', 'Added successfully!');
		}
		
	}
	
 	function check_admin_login() {	            
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if(isset($username) && $username!='' && isset($password) && $password!=''){
			$query = $this->db->get_where('admin_login', array('username' =>$username,'password'=>md5($password)));
			$count=$query->num_rows();
			if($count>0){
				$row = $query->row();
				if($row->status==0){
					if(isset($_POST['remember_me']) && $_POST['remember_me']=='on'){
						$cookie_prefix=$this->config->item('cookie_prefix');
						setcookie($cookie_prefix."admin_username_cookie", $username, time()+3600 , '/');
						setcookie($cookie_prefix."admin_password_cookie", $_POST['password'], time()+3600 , '/');
					}
					$session_data = array('username'=> $row->username,'userid'=> $row->id,'admin_type'=> $row->admin_type,'logged_in'=>TRUE);
					$this->db->where('id',$row->id);
					$this->db->update('admin_login',array('last_login'=>$row->current_login,'current_login'=>time()));
					$this->session->set_userdata($session_data);
					$this->session->set_flashdata('success', str_msg1);
					if(isset($_GET['redirect_url']) && $_GET['redirect_url']!=''){
						echo 'success||'.urldecode($_GET['redirect_url']);
					}else{
						echo 'success||'.base_url().$this->config->item('admin_directory_name').'profile';				
					}
				}else{
					echo 'error||'.str_msg4;
				}
			}else{
				echo 'error||'.str_msg3;
			}
		}else{
			echo 'error||Enter your username/password.';
		}
	}
	
	function adminlogin_details($admin_id){
	
 		$query = $this->db->get_where('admin_login', array('id' =>$admin_id));
		return $query->row();
		
	}
	
	function update_profile() {
		
		$CI = get_instance();
		$db_subdomain_name=$CI->config->item("subdomain_name").'_';
		$username = $this->input->post('user_name'); 
		$name = $this->input->post('name'); 
		$email = $this->input->post('email');   
 		$admin_id = $this->session->userdata('userid');
		$password = $this->input->post('password');
	
		if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){
		
			if($_FILES['photo']['error']==0){
			
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
				$photo=time().'.'.$ext;
				
				$config['file_name'] =$photo;
				$config['upload_path'] = './assets/upload/photo/';
				$config['allowed_types'] = '*';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('photo');
			}
			
			 if(isset($password) && $password!=''){
				 
				$data=array("username"=>$username,"name"=>$name, "email"=>$email, "image"=>$photo,"password"=>md5($password));
				 
			 }else{
				
				$data=array("username"=>$username,"name"=>$name, "email"=>$email, "image"=>$photo);
				
			 }
			
		}else{
		
			if(isset($password) && $password!=''){ 
				
				$data=array("username"=>$username,"name"=>$name,"email"=>$email,"password"=>md5($password));	
			
			}else{
				
				$data=array("username"=>$username,"name"=>$name,"email"=>$email);	
 				
			}
		}
		
 		$this->db->where('id',$admin_id);
		$this->db->update('admin_login',$data);
		$this->session->set_flashdata('success', 'Profile updated Successfully!');
		
	}
}