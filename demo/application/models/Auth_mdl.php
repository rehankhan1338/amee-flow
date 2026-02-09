<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_mdl extends CI_Model {
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
	
	
 	function departlogin_details($dept_id){
 		$query = $this->db->get_where('departments', array('id' =>$dept_id));
		return $query->row();
	}
	
	function getNotificationsDetails($universityId,$callFrom,$dept_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$where = "FIND_IN_SET(".$universityId.",sendTo) and isDeleted=0";
		$amee_web->where($where);
		$amee_web->limit(5);  
		$amee_web->order_by('notificationId', 'desc');
		$query = $amee_web->get('notifications');
		$resData = $query->result_array();
		
		
		$query = $this->db->get_where('notifications_accepted', array('user_name'=>$user_name, 'password'=>md5($password)));
		$num = $query->num_rows();
		
		echo '<pre>';print_r($resData);die;
	}
	
	function department_check_login(){
		$user_name = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		
		$query = $this->db->get_where('departments', array('user_name'=>$user_name, 'password'=>md5($password)));
		$num = $query->num_rows();
		if($num > 0){
			$row = $query->row();
			if($row->status==0){
				return 'Sorry, you profile is not activated.';
			}else{
			
				$currentTime = time();
				$this->db->insert('department_time_tracker', array('department_id'=>$row->id, 'session_start_date_time'=>$currentTime, 'last_modification_time'=>$currentTime));
				
				$session_details = array('dept_id'=>$row->id, 'dept_name'=>$row->department_name,'dept_user_name'=>$row->user_name, 'session_start_date_time'=>$currentTime,'logged_in'=>TRUE);				
				$this->db->where('id',$row->id);
				$this->db->update('departments', array('last_login'=>$row->current_login,'current_login'=>$currentTime));				
				$this->session->set_userdata($session_details);
 				
				notificationsCookieUpdatech($row->id,'chk_login');
				
				return 'success';
			}
		}else{
			echo 'success, you entered the wrong username and/or password.';
		}
	}
	
	function insertNotiDismissEntry($notiIds){
		$dept_id = $this->session->userdata('dept_id');
		$notiIdsArr = explode(',',$notiIds);
		foreach($notiIdsArr as $notiId){
			$this->db->where('notificationId', $notiId);
			$this->db->where('departmentId', $dept_id);
			$query = $this->db->get('notifications_accepted');
			$num_row = $query->num_rows();
 			if($num_row==0){
				$this->db->insert('notifications_accepted', array("notificationId"=>$notiId, "departmentId"=>$dept_id, "acceptTime"=>time()));
			}
		}	
	}
	
	function update_profile() {
		$dept_id = $this->session->userdata('dept_id');
		$first_name = $this->input->post('first_name'); 
		$last_name = $this->input->post('last_name'); 
		$email = $this->input->post('email');   
		
		$data=array("first_name"=>$first_name, "last_name"=>$last_name, "email"=>$email);
		$this->db->where('id',$dept_id);
		$this->db->update('departments',$data);
			
			//UNLINK
			$imgquery = $this->db->get_where('departments',array('id'=>$dept_id));
			$imgrow = $imgquery->row();
			$imgname = $imgrow->image;

		if(isset($_FILES['photo']) && $_FILES['photo']!=''){
			$config['upload_path'] = './assets/upload/department/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			//$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
			$fileName = time().'.'.$ext;
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/upload/department/'.$fileName,
					'new_image'         => './assets/upload/department/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 100,
					'height'            => 100
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 
				$img_data = array('image'=>$fileName);
				$this->db->where('id',$dept_id);
				$this->db->update('departments',$img_data);
				if(isset($imgname) && $imgname!=''){
					//UNLINK
					$file_upload_directory = './assets/upload/department/';
					$file_upload_directory1 = './assets/upload/department/thumbnails/';
					$unlink = unlink($file_upload_directory.$imgname);
					$unlink1 = unlink($file_upload_directory1.$imgname);
				}	
			} 
		}
		$this->session->set_flashdata('success', 'Updated Successfully!');
		redirect(base_url().'profile');
	}
	
	
	function account_setting() {
		$dept_id = $this->session->userdata('dept_id');
		$user_name = $this->input->post('user_name');  
		$password = $this->input->post('password');  
		
		if(isset($password) && $password!=''){				 
			$data=array("user_name"=>$user_name, "password"=>md5($password), "password_view"=>$password);
		}else{
			$data=array("user_name"=>$user_name);
		}
 		
		$this->db->where('user_name', $user_name);
		$this->db->where('id!=', $dept_id);
		$query = $this->db->get('departments');
		$num_row = $query->num_rows();
			
		if($num_row!=0){
			$this->session->set_flashdata('error', 'sorry, User Name already exist'); 
			redirect(base_url()."home/account");
		}else{
			$this->db->where('id',$dept_id);
			$this->db->update('departments',$data);
			redirect(base_url()."home/account");
		}
	}
	 

}
?>