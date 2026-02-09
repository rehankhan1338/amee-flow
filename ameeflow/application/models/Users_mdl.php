<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Users_mdl extends CI_Model {
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
	public function systemAdminDetails($uniAdminId){
		$this->db->select('sa.*, u.universityName, u.uencryptId'); 
		$this->db->from('university_admins as sa');
		$this->db->where('sa.uniAdminId', $uniAdminId);
		$this->db->join('university as u', 'u.universityId = sa.universityId', 'INNER');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function systemAdminDetailsByeid($uaencryptId){
		$this->db->select('sa.*, u.universityName, u.uencryptId'); 
		$this->db->from('university_admins as sa');
		$this->db->where('sa.uaencryptId', $uaencryptId);
		$this->db->join('university as u', 'u.universityId = sa.universityId', 'INNER');
		$query = $this->db->get();
		return $query->row_array();
	}
    public function checkLogin(){
		$email = strtolower($this->input->post('email'));
		$password = $this->input->post('password');
		$universityId = $this->input->post('universityId');
        $loginSection = $this->input->post('loginSection');
		if(isset($email) && $email!='' && isset($password) && $password!=''){
            if($loginSection==2){
			    $query = $this->db->get_where('university_admins', array('universityId'=>$universityId, 'email'=>$email, 'password'=>md5($password)));
            }else{
				$this->db->where(" (auEmailId='".$email."' || auLoginId='".$email."')");
				$this->db->where('auPassword', md5($password));
                $query = $this->db->get('users_access');
            }
			$count=$query->num_rows();
			if($count>0){
				$row = $query->row();
				if($loginSection==2){
					$chkDeleted = $row->isDeleted;
					$chkActive = $row->isActive;
				}else{
					$chkDeleted = $row->auIsDeleted;
					$chkActive = $row->auIsActive;
				}
				if($chkDeleted==1){
					return 'error||Oops, this account was permanently deleted. You will have to contact support to re-activate your account.';
				}else{
					if($chkActive==0){ 
                        if($loginSection==2){
                            $session_data = array('AFSESS_UNIADMINID'=> $row->uniAdminId,'AFSESS_UNIVERSITYID'=> $row->universityId,'AFSESS_accType'=> $row->accType,'logged_in'=>TRUE);
                            $this->db->where('uniAdminId',$row->uniAdminId);
                            $this->db->update('university_admins',array('lastLogin'=>$row->currentLogin, 'currentLogin'=>time()));
                        }else{

							$auserId = $row->auserId;

							$this->db->where('userId', $auserId);
                			$qryUser = $this->db->get('users');
							$userDetails = $qryUser->row();

							$session_data = array('AFSESS_USERID'=> $userDetails->userId,'AFSESS_USERACCESSID'=> $row->userAccessId,'AFSESS_USER_UNIVERSITYID'=> $userDetails->universityId,'AFSESS_userType'=> $userDetails->userType,'logged_in'=>TRUE);
							// print_r($session_data);die;
                            $this->db->where('auserId',$auserId);
                            $this->db->update('users_access',array('lastLogin'=>$row->currentLogin, 'currentLogin'=>time()));
                        }
						$this->session->set_userdata($session_data);
						$this->session->set_flashdata('success', str_msg1);
						if(isset($_GET['redirect_url']) && $_GET['redirect_url']!=''){
							return 'success||'.urldecode($_GET['redirect_url']);
						}else{
                            if($loginSection==2){
							    return 'success||'.base_url().$this->config->item('system_directory_name').'profile';
                            }else{
								return 'success||'.base_url().'profile';
                            }				
						}
					}else{
						return 'error||Sorry, your profile is not active.';
					}
				}
			}else{
				return 'error||Sorry, you entered the wrong Email ID and/or Password.';
			}
		}else{
			return 'error||Enter your email id and/or password.';
		}
	}
	
	public function userAccessDetailsByeId($uaeId){
		$this->db->where('uaeId', $uaeId);
		$query = $this->db->get('users_access');
		return $query->row_array();
	}

	public function chkLightAccessPermission($uaeId){
		$userAccessDetailsArr = $this->userAccessDetailsByeId($uaeId); 
		if(isset($userAccessDetailsArr['lightAccess']) && $userAccessDetailsArr['lightAccess']==1){
			if($userAccessDetailsArr['auIsDeleted']==1){
				echo 'Account deleted.';
			}else{
				if($userAccessDetailsArr['auIsActive']==1){
					echo 'Account not activated.';
				}else{

					$cookie_prefix=$this->config->item('cookie_prefix');
					$cookieTime = time()+(3600*24*7);
					setcookie($cookie_prefix."light_user_access_sts", $uaeId, $cookieTime, '/');
					// if(isset($_COOKIE[$cookie_prefix.'light_user_access_sts']) && $_COOKIE[$cookie_prefix.'light_user_access_sts']!=''){ 
					// 	echo $_COOKIE[$cookie_prefix.'light_user_access_sts']; 
					// }
					 
					$auserId = $userAccessDetailsArr['auserId'];

					$this->db->where('userId', $auserId);
					$qryUser = $this->db->get('users');
					$userDetails = $qryUser->row();

					$session_data = array('AFSESS_USERID'=>$userDetails->userId,'AFSESS_USERACCESSID'=>$userAccessDetailsArr['userAccessId'],'AFSESS_USER_UNIVERSITYID'=>$userDetails->universityId,'AFSESS_userType'=> $userDetails->userType,'logged_in'=>TRUE);
					$this->db->where('auserId',$auserId);
					$this->db->update('users_access',array('lastLogin'=>$userAccessDetailsArr['currentLogin'], 'currentLogin'=>time()));

					$this->session->set_userdata($session_data);
					$this->session->set_flashdata('success', str_msg1);
					if(isset($_GET['qs']) && $_GET['qs']!=''){
						redirect(base_url().urldecode($_GET['qs']));
					}else{
						redirect(base_url().'projects');				
					}
				}
			}
		}else{
			echo 'Do not have a access.';
		}
	}

	public function userDetails($userId){
		// $this->db->where('userId', $userId);
		// $qry = $this->db->get('users');
		// return $qry->row_array();
		$this->db->select('usr.*, u.universityName, u.shortName'); 
		$this->db->from('users as usr');
		$this->db->where('usr.userId', $userId);
		$this->db->join('university as u', 'u.universityId = usr.universityId', 'INNER');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function userAccessDetails($userAccessId){
		$this->db->select('usr.*, ac.*, u.universityName, u.shortName'); 
		$this->db->from('users_access as ac');
		$this->db->where('ac.userAccessId', $userAccessId);
		$this->db->join('users as usr', 'usr.userId = ac.auserId', 'INNER');
		$this->db->join('university as u', 'u.universityId = usr.universityId', 'INNER');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function updateSystemAdminProfile(){
		$uniAdminId = trim($this->input->post('uniAdminId'));
		$universityId = trim($this->input->post('universityId'));
		$fullName = trim($this->input->post('fullName'));
		$email = strtolower(trim($this->input->post('email')));
		$contactNo = trim($this->input->post('contactNo'));
		$unitName = trim($this->input->post('unitName'));
		if(isset($uniAdminId) && $uniAdminId!='' && $uniAdminId>0){
			$this->db->where('uniAdminId != ', $uniAdminId);
		}
		$this->db->where('universityId', $universityId);
		$this->db->where('email', $email);
		$qry = $this->db->get('university_admins');
		$cnt = $qry->num_rows();
		if($cnt==0){
			$this->db->where('uniAdminId',$uniAdminId); 
			$this->db->update('university_admins', array('fullName'=>$fullName, 'email'=>$email, 'contactNo'=>$contactNo, 'unitName'=>$unitName));
			if(isset($_POST['password']) && $_POST['password']!=''){
				$this->db->where('uniAdminId',$uniAdminId); 
				$this->db->update('university_admins', array('password'=>md5($_POST['password']), 'randomId'=>base64_encode($_POST['password'])));
			}
			$this->session->set_flashdata('success', 'Updated successfully!');
			
			return 'success||'.base_url().$this->config->item('system_directory_name').'profile';
		}else{
			return 'error||Oops, email id already exist.';
		}
	}

	 
	public function updateUserProfile(){
		$userId = trim($this->input->post('userId'));
		$addedBy = trim($this->input->post('addedBy'));
		$userAccessId = trim($this->input->post('userAccessId'));
		$universityId = trim($this->input->post('universityId'));
		$userName = trim($this->input->post('userName'));
		$email = strtolower(trim($this->input->post('userEmail')));
		

		if(isset($userAccessId) && $userAccessId!='' && $userAccessId>0){
			$this->db->where('userAccessId != ', $userAccessId);
		}
		// $this->db->where('universityId', $universityId);
		$this->db->where('auEmailId', $email);
		$this->db->where('auIsDeleted', 0);
		$qry = $this->db->get('users_access');
		$cnt = $qry->num_rows();
		if($cnt==0){

			$this->db->where('userAccessId',$userAccessId); 
			$this->db->update('users_access', array('auName'=>$userName, 'auEmailId'=>$email));
			if(isset($_POST['password']) && $_POST['password']!=''){
				$this->db->where('userAccessId',$userAccessId); 
				$this->db->update('users_access', array('auPassword'=>md5($_POST['password']), 'auRamdomId'=>base64_encode($_POST['password'])));
			}

			if($addedBy==0){
				$unitName = trim($this->input->post('unitName'));
				$unitShortName = trim($this->input->post('unitShortName'));
				$overSightName = trim($this->input->post('overSightName'));
				$this->db->where('userId',$userId); 
				$this->db->update('users', array('userName'=>$userName, 'unitName'=>$unitName, 'unitShortName'=>$unitShortName, 'overSightName'=>$overSightName, 'userEmail'=>$email));
				if(isset($_POST['password']) && $_POST['password']!=''){
					$this->db->where('userId',$userId); 
					$this->db->update('users', array('password'=>md5($_POST['password']), 'randomId'=>base64_encode($_POST['password'])));
				}
			}
			$this->session->set_flashdata('success', 'Updated successfully!');
			
			return 'success||'.base_url().'profile';
		}else{
			return 'error||Oops, email id already exist.';
		}
	}
}