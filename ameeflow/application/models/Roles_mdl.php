<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Roles_mdl extends CI_Model {
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
    public function acctUsersDataArr($useuniAdminId){
        $this->db->where('uniAdminId', $useuniAdminId);
        $this->db->where('isDeleted', 0);
        // $this->db->where('isActive', 0);
        $this->db->order_by('userId', 'desc');
		$query = $this->db->get('users');
		return $query->result_array();
    }
    public function uniUsersDataArr($universityId){
        $this->db->where('universityId', $universityId);
        $this->db->where('isDeleted', 0);
        // $this->db->where('isActive', 0);
        $this->db->order_by('userId', 'desc');
		$query = $this->db->get('users');
		return $query->result_array();
    }
    public function rolesDataArr($userId){		 
		$this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->order_by('roleId', 'desc');
		$query = $this->db->get('senior_roles');
		return $query->result_array();
	}
    public function roleDetailsArr($roleId){
        $this->db->where('roleId', $roleId);
		$query = $this->db->get('senior_roles');
		return $query->row_array();
    }
    public function updateStatus($roleId,$column_name,$status){
		$this->db->where('roleId', $roleId);
		$this->db->update('senior_roles', array("$column_name"=>$status));		
		return 'success';
	}
    public function manageRole($universityId,$userId){
        $roleIdChk = trim($this->input->post('roleId'));
		$name = trim($this->input->post('txtFullName'));        
		$email = strtolower(trim($this->input->post('txtEmail'))); 
		$roleType = trim($this->input->post('txtroleType'));
        if(isset($roleIdChk) && $roleIdChk!='' && $roleIdChk>0){
            $this->db->where('roleId !=', $roleIdChk);
        }
        $this->db->where('universityId', $universityId);
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
		$qry = $this->db->get('senior_roles');
		$cnt = $qry->num_rows();
		if($cnt==0){
            $createDate = strtotime(date('Y-m-d'));
            $createMonth = date('m');
            $createYear = date('Y');
            $createTime = time();
            
            if(isset($roleIdChk) && $roleIdChk!='' && $roleIdChk>0){
                $this->db->where('roleId',$roleIdChk); 
                $this->db->update('senior_roles', array('roleType'=>$roleType, 'name'=>$name, 'email'=>$email));
            }else{
                $this->db->insert('senior_roles', array('universityId'=>$universityId, 'userId'=>$userId, 'roleType'=>$roleType, 'name'=>$name, 'email'=>$email, 'createDate'=>$createDate, 'createTime'=>$createTime, 'createMonth'=>$createMonth, 'createYear'=>$createYear));
                $roleId = $this->db->insert_id();
                $uroleId = generateRandomNumStringCh(4).'r'.$roleId.generateRandomNumStringCh(4);
                $this->db->where('roleId',$roleId); 
                $this->db->update('senior_roles', array("uroleId"=>$uroleId));
                
                $this->upSrCnt($userId); 
            }
            return 'success||'.base_url().'roles';
        }else{
            return 'error||Oops, email already exist.';
        }
    }    

    public function upSrCnt($userId){
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
		$qry = $this->db->get('senior_roles');
		$cnt = $qry->num_rows();

        $this->db->where('userId',$userId); 
        $this->db->update('users', array("srRoleCnt"=>$cnt));
    }

    public function deleteRole($roleIds,$userId){
        $where = ' roleId in ('.$roleIds.')';
        $this->db->where($where);
        $this->db->update('senior_roles',array("isDeleted"=>1));
        $this->upSrCnt($userId); 
        $this->session->set_flashdata('success', 'Role has been deleted successfully.');	
    }
    public function deleteUser($userIds){
        $where = ' userId in ('.$userIds.')';
        
        $this->db->select('userEmail');
        $this->db->where($where);
        $qryPro = $this->db->get('users');
        $proData = $qryPro->result_array();
        foreach($proData as $pro){           
            $this->db->where('auEmailId',$pro['userEmail']);
            $this->db->update('users_access',array("auIsDeleted"=>1));
        }

        $this->db->where($where);
        $this->db->update('users',array("isDeleted"=>1));
        
        $this->session->set_flashdata('success', 'Role has been deleted successfully.');	
    }

    public function seniorDatabyUidArr($userId){		 
		$this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
		$query = $this->db->get('senior_roles');
		return $query->result_array();
	}

    public function resendLoginDetails($userIds){
        
        $this->db->select('u.userName, u.userType, u.projectIds, u.userEmail, u.universityId, u.uniAdminId, u.randomId, u.loginID, ua.uaeId, ua.lightAccess');
		$this->db->from('users as u');
		$where = ' u.userId in ('.$userIds.')'; 
        $this->db->where($where);     
		$this->db->join('users_access as ua', 'ua.auEmailId = u.userEmail', 'LEFT');          
        $qry = $this->db->get();
		$tcnt = $qry->num_rows();
		if($tcnt>0){
			$res = $qry->result_array();
            
           
            if(isset($res[0]['uniAdminId']) && $res[0]['uniAdminId']!=''){
                $this->db->where('universityId', $res[0]['universityId']);
                $this->db->where('uniAdminId', $res[0]['uniAdminId']);
                $this->db->where('purpose', 'Welcome Email for Assignee Role');
                $etQry = $this->db->get('email_templates');
                $etDetails = $etQry->row();
                $subject = $etDetails->subject;                
             
                $this->db->where('id', '24');
                $laQry = $this->db->get('email_templates');
                $laDetails = $laQry->row();
                $la_subject = $laDetails->subject;

                foreach($res as $u){

                    if($u['lightAccess']==1){
                        $roleName = '';
                        if($u['userType']>0){
                            $roleName = $this->config->item('user_types_array_config')[$u['userType']]['name'];
                        }

                        
                        $proNames = '';
                        $proNameArr = array();
                        if(isset($u['projectIds']) && $u['projectIds']!=''){
                            $projectIds = $u['projectIds'];
                            $projectIdsArr = explode(',',$u['projectIds']);
                            if(count($projectIdsArr)>0){                                
                                $this->db->select('projectName');
                                $this->db->where('projectId in ('.$projectIds.')');
                                $qryPro = $this->db->get('projects');
                                $proData = $qryPro->result_array();
                                foreach($proData as $pro){
                                    $proNameArr[] = $pro['projectName'];
                                }
                                $proNames = implode(', ',$proNameArr);
                            }
                        }
                        $lightAccessUrl = base_url().'light/permission/'.$u['uaeId'];

                        $message = str_replace('{userName}',$u['userName'],$laDetails->message);
                        $message = str_replace('{roleName}',$roleName,$message);
                        $message = str_replace('{projectsName}',$proNames,$message);
                        $message = str_replace('{lightAccessUrl}',$lightAccessUrl,$message);
                        send_mail($u['userEmail'],$message,$u['userName'],'info',$la_subject);
                    }else{
                        $loginLink = base_url().'signin';
                        $password = base64_decode($u['randomId']);                                  
                        $message = str_replace('{userName}',$u['userName'],$etDetails->message);
                        $message = str_replace('{loginLink}',$loginLink,$message);
                        $message = str_replace('{loginID}',$u['loginID'],$message);
                        $message = str_replace('{password}',$password,$message);
                        send_mail($u['userEmail'],$message,$u['userName'],'info',$subject);
                    }
                    
                }                
                $this->session->set_flashdata('success', 'Resend email has been sent successfully.');	
            }
        }        
    }

    public function updateUserStatus($userId,$column_name,$status){
		$this->db->where('userId', $userId);
		$this->db->update('users', array("$column_name"=>$status));		
		return 'success';
	}
    public function assignUsersDataArrByUni($universityId,$projectId){
        
        $dbprefix = $this->db->dbprefix;
		$this->db->select('u.*, ua.fullName');
		$this->db->from('users as u');
        // $this->db->where("u.empId not in(select empId from ".$dbprefix."projects_assign_employees where projectId='".$projectId."')");
		$this->db->where('u.universityId', $universityId);
        $this->db->where('u.isDeleted', 0);
        $this->db->where('u.isActive', 0);
        $this->db->order_by('u.userId', 'desc');
		$this->db->join('university_admins as ua', 'ua.uniAdminId = u.uniAdminId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}
    public function proassignUsersDataArrByuniAdmin($uniAdminId,$pId){        
        $dbprefix = $this->db->dbprefix;
		$this->db->select('u.*, ua.fullName');
		$this->db->from('users as u');
		$this->db->where('u.uniAdminId', $uniAdminId);

        if(isset($pId) && $pId!=''){
            $whereChk = 'find_in_set("'.$pId.'", projectIds)';	
            $this->db->where($whereChk);
        }

        $this->db->where('u.isDeleted', 0);
        $this->db->where('u.isActive', 0);
        $this->db->order_by('u.userId', 'desc');
		$this->db->join('university_admins as ua', 'ua.uniAdminId = u.uniAdminId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}
    public function assignUsersDataArrByuniAdmin($uniAdminId){        
        $dbprefix = $this->db->dbprefix;
		$this->db->select('u.*, ua.fullName');
		$this->db->from('users as u');
		$this->db->where('u.uniAdminId', $uniAdminId);
        $this->db->where('u.isDeleted', 0);
        $this->db->where('u.isActive', 0);
        $this->db->order_by('u.userId', 'desc');
		$this->db->join('university_admins as ua', 'ua.uniAdminId = u.uniAdminId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}
    public function userDetailsArr($userId){
        $this->db->where('userId', $userId);
		$query = $this->db->get('users');
		return $query->row_array();
    }
    public function userDetailsWithAccessDetailsArr($userId){
        $this->db->select('u.*, ua.uaeId, ua.lightAccess');
		$this->db->from('users as u');
		$this->db->where('u.userId', $userId);
		$this->db->join('users_access as ua', 'ua.auEmailId = u.userEmail', 'LEFT');
		$query = $this->db->get();
		return $query->row_array();
    }
    public function manageUser(){       
        
        if(isset($_POST['menuIds']) && $_POST['menuIds']!='' && isset($_POST['assProIds']) && $_POST['assProIds']!=''){
            $projectIds = '';
            $proNames = '';
            $proNameArr = array();
            if(count($_POST['assProIds'])>0){
                $projectIds = implode(',',$_POST['assProIds']);
                $this->db->select('projectName');
                $this->db->where('projectId in ('.$projectIds.')');
                $qryPro = $this->db->get('projects');
                $proData = $qryPro->result_array();
                foreach($proData as $pro){
                    $proNameArr[] = $pro['projectName'];
                }
                $proNames = implode(', ',$proNameArr);
            }
            
			if(count($_POST['menuIds'])>0){
                $menuArr = array();
				$subMenuArr = array();
				foreach($_POST['menuIds'] as $ids){
					$idsArr = explode('||',$ids);
					$menuId = $idsArr[0];
					if($menuId>0){
						if(!in_array($menuId,$menuArr)){
							$menuArr[] = $menuId;
						}
					}
					$subMenuId = $idsArr[1];
					if($subMenuId>0){
						if(!in_array($subMenuId,$subMenuArr)){
							$subMenuArr[] = $subMenuId;
						}
					}
				}
				$menu_ids = implode(',',$menuArr);
				$submenu_ids = implode(',',$subMenuArr);
				$submenu_subcat_ids = '';
                $universityId = trim($this->input->post('rauniversityId'));

                $this->db->where('universityId', $universityId);
                $qruUni = $this->db->get('university');
                $uniDetails = $qruUni->row_array();
                
                $uniAdminId = trim($this->input->post('rauniAdminId'));
                $createdBy = trim($this->input->post('racreatedBy'));
                $userIdChk = trim($this->input->post('rauserId'));
                $userName = trim($this->input->post('txtFullName'));        
                $email = strtolower(trim($this->input->post('txtEmail')));
                
                $unitName = trim($this->input->post('txtUnitName'));
                $unitShortName = trim($this->input->post('txtShortName'));
                $overSightName = trim($this->input->post('txtOverSight'));
                $userType = trim($this->input->post('txtUserType'));
                $roleName = '';
                if($userType>0){
                    $roleName = $this->config->item('user_types_array_config')[$userType]['name'];
                }
                $lightAccess = $this->input->post('lightAccess');        
                if(isset($userIdChk) && $userIdChk!='' && $userIdChk>0){
                    $this->db->where('userId !=', $userIdChk);
                }
                $this->db->where('universityId', $universityId);
                $this->db->where('userEmail', $email);
                $this->db->where('isDeleted', 0);
                $qry = $this->db->get('users');
                $cnt = $qry->num_rows();
                if($cnt==0){
                    $createDate = strtotime(date('Y-m-d'));
                    $createMonth = date('m');
                    $createYear = date('Y');
                    $createTime = time();

                    $projectsName = '';
                    
                    if(isset($userIdChk) && $userIdChk!='' && $userIdChk>0){
                        $this->db->where('userId',$userIdChk); 
                        $this->db->update('users', array('userName'=>$userName, 'userEmail'=>$email, 'userType'=>$userType, 'unitName'=>$unitName, 'unitShortName'=>$unitShortName, 'overSightName'=>$overSightName, 'projectIds'=>$projectIds, 'menu_ids'=>$menu_ids, 'submenu_ids'=>$submenu_ids, 'submenu_subcat_ids'=>$submenu_subcat_ids));                      

                        $this->db->where('auserId',$userIdChk); 
                        $this->db->update('users_access', array("auEmailId"=>$email, "lightAccess"=>$lightAccess));

                        $uaeId = $_POST['rauserAccesseId'];

                        if($lightAccess==1){

                            $this->db->where('id', '24');
                            $etQry = $this->db->get('email_templates');
                            $etDetails = $etQry->row();
                            $subject = $etDetails->subject;
                            $lightAccessUrl = base_url().'light/permission/'.$uaeId;
                            $message = str_replace('{userName}',$userName,$etDetails->message);
                            $message = str_replace('{roleName}',$roleName,$message);
                            $message = str_replace('{projectsName}',$proNames,$message);
                            $message = str_replace('{lightAccessUrl}',$lightAccessUrl,$message);
                            send_mail($email,$message,$userName,'info',$subject);

                        }

                    }else{

                        $bgColor = generateDarkColorHex();
                        $fontColor = wpImgColorCh($bgColor);

                        $this->db->insert('users', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'createdBy'=>$createdBy, 'bgColor'=>$bgColor, 'fontColor'=>$fontColor, 'userName'=>$userName, 'userEmail'=>$email, 'userType'=>$userType, 'unitName'=>$unitName, 'unitShortName'=>$unitShortName, 'overSightName'=>$overSightName, 'projectIds'=>$projectIds, 'createDate'=>$createDate, 'createTime'=>$createTime, 'createMonth'=>$createMonth, 'createYear'=>$createYear, 'menu_ids'=>$menu_ids, 'submenu_ids'=>$submenu_ids, 'submenu_subcat_ids'=>$submenu_subcat_ids));
                        $userId = $this->db->insert_id();
                        $password = generateRandomNumStringCh(5).'u'.$userId.generateRandomNumStringCh(5);
                        $uencryptId = generateRandomNumStringCh(4).'u'.$userId.generateRandomNumStringCh(4);

                        $this->db->insert('users_access', array('auserId'=>$userId, "lightAccess"=>$lightAccess, 'addedBy'=>'0', 'auName'=>$userName, 'auEmailId'=>$email, 'auCreatedOn'=>$createTime));
				        $userAccessId = $this->db->insert_id();
                        $uaeId = generateRandomNumStringCh(2).'au'.$userAccessId.generateRandomNumStringCh(2);
                        $shortName = strtoupper(create_slug_ch(strip_tags($uniDetails['shortName'])));
                        $auLoginId = $shortName.'-'.$uaeId;

                        $this->db->where('userId',$userId); 
                        $this->db->update('users', array("uencryptId"=>$uencryptId, "loginID"=>$auLoginId, 'password'=>md5($password), 'randomId'=>base64_encode($password)));                        

                        $this->db->where('userAccessId',$userAccessId); 
                        $this->db->update('users_access', array("uaeId"=>$uaeId, "auLoginId"=>$auLoginId, "auPassword"=>md5($password), "auRamdomId"=>base64_encode($password)));

                        if($lightAccess==1){

                            $this->db->where('id', '24');
                            $etQry = $this->db->get('email_templates');
                            $etDetails = $etQry->row();
                            $subject = $etDetails->subject;
                            $lightAccessUrl = base_url().'light/permission/'.$uaeId;
                            $message = str_replace('{userName}',$userName,$etDetails->message);
                            $message = str_replace('{roleName}',$roleName,$message);
                            $message = str_replace('{projectsName}',$proNames,$message);
                            $message = str_replace('{lightAccessUrl}',$lightAccessUrl,$message);
                            send_mail($email,$message,$userName,'info',$subject);

                        }else{
                            $this->db->where('universityId', $universityId);
                            $this->db->where('uniAdminId', $uniAdminId);
                            $this->db->where('purpose', 'Welcome Email for Assignee Role');
                            $etQry = $this->db->get('email_templates');
                            $etDetails = $etQry->row();
                            $subject = $etDetails->subject;
                            $loginLink = base_url().'signin';
                            $message = str_replace('{userName}',$userName,$etDetails->message);
                            $message = str_replace('{loginLink}',$loginLink,$message);
                            $message = str_replace('{email}',$email,$message);
                            $message = str_replace('{password}',$password,$message);
                            send_mail($email,$message,$userName,'info',$subject); 
                            
                        }
        
                        // $this->db->where('id', 1);
                        // $etQry = $this->db->get('email_templates');Welcome Email for Area Expert
                        // $etDetails = $etQry->row();
                        // $subject = $etDetails->subject;
                        // $loginLink = base_url().'signin';
                        // $message = str_replace('{ProjectManagerName}',$fullName,$etDetails->message);
                        // $message = str_replace('{loginLink}',$loginLink,$message);
                        // $message = str_replace('{email}',$email,$message);
                        // $message = str_replace('{password}',$password,$message);
                        // send_mail($email,$message,$fullName,'info',$subject); 
                        
                        
                    }
                    return 'success||'.base_url().$this->config->item('system_directory_name').'roles';
                }else{
                    return 'error||Oops, email already exist.';
                }
            }else{
				return 'error||Oops, please select at least one privillage.';
			}
		}else{
			return 'error||Oops, please select at least one project and privillage.';
		}
    }

    public function menuDataArr(){
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('user_menu');
		return $query->result_array();
    }

    public function subMenuDataArr(){
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('user_submenu');
		return $query->result_array();
    }

    public function moreSubMenuDataArr(){
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('user_submenu_subcat');
		return $query->result_array();
    }

}