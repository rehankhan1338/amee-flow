<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Access_user_mdl extends CI_Model {
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
    public function guestAccessDataArr($userId){
		$this->db->where('auserId', $userId);
		$this->db->where('addedBy > ', 0);
		$this->db->where('auIsDeleted', 0);
		$query = $this->db->get('users_access');
		return $query->result_array();
    }
	public function accessDetailsArr($gaId){
		$this->db->where('userAccessId', $gaId);
		$this->db->where('auIsDeleted', 0);
		$query = $this->db->get('users_access');
		return $query->row_array();
    }
	public function manageAccessEntry(){
		$onDate = strtotime(date('Y-m-d'));	
		$onTime = time();
		
		$userId = trim($this->input->post('rauserId'));
		$universityId = trim($this->input->post('rauniversityId'));
		$shortName = strtoupper(create_slug_ch(strip_tags($this->input->post('rauniShortName'))));
		$addedBy = trim($this->input->post('racreatedBy'));
		$senderName = $this->input->post('senderName');

		$auName = trim($this->input->post('txtFullName'));
		$email = strtolower(trim($this->input->post('txtEmail')));
		
		$userAccessIdChk = trim($this->input->post('rauserAccessId'));	 		
		if(isset($userAccessIdChk) && $userAccessIdChk!='' && $userAccessIdChk>0){
			$this->db->where('userAccessId != ', $userAccessIdChk);
		}
		$this->db->where('auEmailId', $email);
		$this->db->where('auIsDeleted', 0);
		$qry = $this->db->get('users_access');
		$cnt = $qry->num_rows();
		if($cnt==0){
			if(isset($userAccessIdChk) && $userAccessIdChk!='' && $userAccessIdChk>0){				 		 
				$this->db->where('userAccessId',$userAccessIdChk); 
				$this->db->update('users_access', array('auName'=>$auName, 'auEmailId'=>$email));
				$this->session->set_flashdata('success', 'Updated successfully!');
			}else{
				$this->db->insert('users_access', array('auserId'=>$userId, 'addedBy'=>$addedBy, 'auName'=>$auName, 'auEmailId'=>$email, 'auCreatedOn'=>$onTime));
				$userAccessId = $this->db->insert_id();
				$uaeId = generateRandomNumStringCh(2).$userAccessId.generateRandomNumStringCh(2);
				$password = generateRandomNumStringCh(2).'p'.$userAccessId.generateRandomNumStringCh(2);

				$auLoginId = $shortName.$userAccessId;

				$this->db->where('userAccessId',$userAccessId); 
				$this->db->update('users_access', array("uaeId"=>$uaeId, "auLoginId"=>$auLoginId, "auPassword"=>md5($password), "auRamdomId"=>base64_encode($password)));

				$this->db->where('id', 20);
				$etQry = $this->db->get('email_templates');
				$etDetails = $etQry->row();
				$subject = str_replace('{senderName}',$senderName,$etDetails->subject);
				$loginLink = base_url().'signin';
				$message = str_replace('{senderName}',$senderName,$etDetails->message);
				$message = str_replace('{guestAccessName}',$auName,$message);
				$message = str_replace('{loginURL}',$loginLink,$message);
				$message = str_replace('{loginID}',$auLoginId,$message);
				$message = str_replace('{password}',$password,$message);
				send_mail($email,$message,$auName,'info',$subject); 
			}
			return 'success||'.base_url().'access';
		}else{
			return 'error||Oops, email already exist.';
		}
	}
	public function updateAccessStatus($userAccessId,$column_name,$status){
		$this->db->where('userAccessId', $userAccessId);
		$this->db->update('users_access', array("$column_name"=>$status));		
		return 'success';
	}
	public function deleteAccess($userAccessIds){
        $where = ' userAccessId in ('.$userAccessIds.')';
        $this->db->where($where);
		$this->db->update('users_access', array("auIsDeleted"=>1));
        $this->session->set_flashdata('success', 'Deleted successfully.');	
    }
}