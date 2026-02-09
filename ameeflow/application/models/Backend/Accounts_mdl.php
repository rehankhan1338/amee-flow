<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_mdl extends CI_Model {
    
	public function __construct(){
		parent::__construct();
	}	

	public function universityDetailsbyShortName($shortName){
		$this->db->where('shortName', $shortName);
		$query = $this->db->get('university');
		return $query->row_array();
	}

	public function chkUniversityUrlShortNameSts($uniShortName){
		$this->db->where('isDeleted', '0');
		$this->db->where('isActive', '0');
		$this->db->where('shortName', $uniShortName);
		$query = $this->db->get('university');
		return $query->num_rows();
	}

	public function activeAccountDataArr(){
		$this->db->where('isDeleted', '0');
		$this->db->where('isActive', '0');
		$this->db->order_by('universityName', 'asc');
		$query = $this->db->get('university');
		return $query->result_array();
	}

	public function accountAdminDataArr($universityId){
		$this->db->where('isDeleted', '0');
		$this->db->where('universityId', $universityId);
		$this->db->order_by('uniAdminId', 'asc');
		$query = $this->db->get('university_admins');
		return $query->result_array();
	}

	public function uniadminDetailsArr($uniAdminId){
		$this->db->where('uniAdminId', $uniAdminId);
		$query = $this->db->get('university_admins');
		return $query->row_array();
	}
	
	public function accountDataArr(){
		$this->db->where('isDeleted', '0');
		$this->db->order_by('universityName', 'asc');
		$query = $this->db->get('university');
		return $query->result_array();
	}
	
	public function accounts_details_arr($universityId){
		$this->db->where('universityId',$universityId);
		$query=$this->db->get('university');
		return $query->row_array();      
	}

	public function accountsDetailsByeId($uencryptId){
		$this->db->where('uencryptId',$uencryptId);
		$query=$this->db->get('university');
		return $query->row_array();      
	}

	public function manageEntry(){
		$universityIdChk = trim($this->input->post('universityId'));
		$universityName = trim($this->input->post('universityName'));
		$universitySlug = create_slug_ch($universityName);

		$shortName = trim($this->input->post('shortName'));
		$address = trim($this->input->post('address'));
		$city = trim($this->input->post('city'));
		$stateId = trim($this->input->post('stateId'));
		$zipCode = trim($this->input->post('zipCode'));			
		$isActive = trim($this->input->post('isActive'));	 		
		$onDate = strtotime(date('Y-m-d'));	
		$onTime = time();

		if(isset($universityIdChk) && $universityIdChk!='' && $universityIdChk>0){
			$this->db->where('universityId != ', $universityIdChk);
		}
		$this->db->where('universitySlug', $universitySlug);
		$qry = $this->db->get('university');
		$cnt = $qry->num_rows();
		if($cnt==0){

			$data = array('universityName'=>$universityName, 'universitySlug'=>$universitySlug, 'shortName'=>$shortName, 'address'=>$address, 'city'=>$city, 'stateId'=>$stateId, 'zipCode'=>$zipCode, 'isActive'=>$isActive);
			
			if(isset($universityIdChk) && $universityIdChk!='' && $universityIdChk>0){
				$universityId = $universityIdChk;				 
				$this->db->where('universityId',$universityId); 
				$this->db->update('university', $data);
				$this->session->set_flashdata('success', 'Updated successfully!');

			}else{				

				$this->db->insert('university', $data);
				$universityId = $this->db->insert_id();
				$uencryptId = generateRandomNumStringCh(4).'u'.$universityId.generateRandomNumStringCh(4);
				$this->db->where('universityId',$universityId); 
				$this->db->update('university', array("uencryptId"=>$uencryptId));
				
				// $fullName = trim($this->input->post('fullName'));
				// $email = strtolower(trim($this->input->post('email')));
				// $contactNo = trim($this->input->post('contactNo'));

				// $this->db->insert('university_admins', array('universityId'=>$universityId, 'fullName'=>$fullName, 'email'=>$email, 'contactNo'=>$contactNo, 'isActive'=>$isActive, 'onDate'=>$onDate, 'onTime'=>$onTime));
				// $uniAdminId = $this->db->insert_id();
				// $uaencryptId = generateRandomNumStringCh(4).'ua'.$uniAdminId.generateRandomNumStringCh(4);
				// $password = generateRandomNumStringCh(5).'p'.$uniAdminId.generateRandomNumStringCh(5);
				// $this->db->where('uniAdminId',$uniAdminId); 
				// $this->db->update('university_admins', array("uaencryptId"=>$uaencryptId, "password"=>md5($password), "randomId"=>base64_encode($password)));

				// $this->db->where('defaultUniSts', 1);
				// $this->db->where('status', 1);
				// $this->db->where('universityId', 0);
				// $qryDE = $this->db->get('email_templates');
				// $cntDe = $qryDE->num_rows();
				// if($cntDe>0){
				// 	$defEmailRes = $qryDE->result();
				// 	foreach($defEmailRes as $def){
				// 		$this->db->insert('email_templates', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'purpose'=>$def->purpose, 'subject'=>$def->subject, 'message'=>$def->message, 'status'=>1));
				// 	}
				// }

				// $this->db->where('id', 1);
				// $etQry = $this->db->get('email_templates');
				// $etDetails = $etQry->row();
				// $subject = $etDetails->subject;
				// $loginLink = base_url().'signin';
				// $message = str_replace('{ProjectManagerName}',$fullName,$etDetails->message);
				// $message = str_replace('{loginLink}',$loginLink,$message);
				// $message = str_replace('{email}',$email,$message);
				// $message = str_replace('{password}',$password,$message);
				// send_mail($email,$message,$fullName,'info',$subject); 
				
				$this->session->set_flashdata('success', 'Added successfully!');
			}
			
			return 'success||'.base_url().$this->config->item('admin_directory_name').'accounts';
		}else{
			return 'error||Oops, university already exist.';
		}
				  
	} 
	
	public function manageAdminData(){
		$menu_ids = '';
		$submenu_ids = '';
		$submenu_subcat_ids = '';
		$accType = trim($this->input->post('raaccType'));
		if($accType!='system-admin'){
			if(isset($_POST['menuIds']) && $_POST['menuIds']!=''){
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
				}else{
					return 'error||Oops, please select at least one privillage.';
				}
			}else{
				return 'error||Oops, please select at least one privillage.';
			}
		}		

		$universityId = trim($this->input->post('rauniversityId'));		
		$uencryptId = trim($this->input->post('rauencryptId'));
		$fullName = trim($this->input->post('fullName'));
		$email = strtolower(trim($this->input->post('email')));
		$contactNo = trim($this->input->post('contactNo'));
		$unitName = trim($this->input->post('unitName'));
		$isActive = trim($this->input->post('isActive'));
		$onDate = strtotime(date('Y-m-d'));	
		$onTime = time();
		$uniAdminIdChk = trim($this->input->post('rauniAdminId'));	 		
		if(isset($uniAdminIdChk) && $uniAdminIdChk!='' && $uniAdminIdChk>0){
			$this->db->where('uniAdminId != ', $uniAdminIdChk);
		}
		$this->db->where('universityId', $universityId);
		$this->db->where('email', $email);
		$this->db->where('isDeleted', 0);
		$qry = $this->db->get('university_admins');
		$cnt = $qry->num_rows();
		if($cnt==0){

			if(isset($uniAdminIdChk) && $uniAdminIdChk!='' && $uniAdminIdChk>0){				 		 
				$this->db->where('uniAdminId',$uniAdminIdChk); 
				$this->db->update('university_admins', array('fullName'=>$fullName, 'email'=>$email, 'unitName'=>$unitName, 'contactNo'=>$contactNo, 'isActive'=>$isActive, 'menu_ids'=>$menu_ids, 'submenu_ids'=>$submenu_ids, 'submenu_subcat_ids'=>$submenu_subcat_ids));
				$this->session->set_flashdata('success', 'Updated successfully!');
			}else{

				$this->db->insert('university_admins', array('universityId'=>$universityId, 'fullName'=>$fullName, 'email'=>$email, 'unitName'=>$unitName, 'contactNo'=>$contactNo, 'isActive'=>$isActive, 'onDate'=>$onDate, 'onTime'=>$onTime, 'menu_ids'=>$menu_ids, 'submenu_ids'=>$submenu_ids, 'submenu_subcat_ids'=>$submenu_subcat_ids));
				$uniAdminId = $this->db->insert_id();
				$uaencryptId = generateRandomNumStringCh(4).'ua'.$uniAdminId.generateRandomNumStringCh(4);
				$password = generateRandomNumStringCh(5).'p'.$uniAdminId.generateRandomNumStringCh(5);
				$this->db->where('uniAdminId',$uniAdminId); 
				$this->db->update('university_admins', array("uaencryptId"=>$uaencryptId, "password"=>md5($password), "randomId"=>base64_encode($password)));

				$this->db->where('defaultUniSts', 1);
				$this->db->where('status', 1);
				$this->db->where('universityId', 0);
				$qryDE = $this->db->get('email_templates');
				$cntDe = $qryDE->num_rows();
				if($cntDe>0){
					$defEmailRes = $qryDE->result();
					foreach($defEmailRes as $def){
						$this->db->insert('email_templates', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'purpose'=>$def->purpose, 'subject'=>$def->subject, 'message'=>$def->message, 'status'=>1));
					}
				}

				$this->universityAdminCnt($universityId);

				$this->db->where('id', 1);
				$etQry = $this->db->get('email_templates');
				$etDetails = $etQry->row();
				$subject = $etDetails->subject;
				$loginLink = base_url().'signin';
				$message = str_replace('{ProjectManagerName}',$fullName,$etDetails->message);
				$message = str_replace('{loginLink}',$loginLink,$message);
				$message = str_replace('{email}',$email,$message);
				$message = str_replace('{password}',$password,$message);
				send_mail($email,$message,$fullName,'info',$subject); 
				
				$this->session->set_flashdata('success', 'Added successfully!');

			}
			return 'success||'.base_url().$this->config->item('admin_directory_name').'accounts/admins/'.$uencryptId;
		}else{
			return 'error||Oops, email already exist.';
		}
	}

	public function universityAdminCnt($universityId){
		$this->db->where('universityId', $universityId);
		$this->db->where('isDeleted', 0);
		$qryDE = $this->db->get('university_admins');
		$cntDe = $qryDE->num_rows();

		$this->db->where('universityId', $universityId);
		$this->db->update('university', array("sytemAdminCnt"=>$cntDe));
	}

	public function deleteAdminAccount($uniAdminIds,$universityId){
        $where = ' uniAdminId in ('.$uniAdminIds.')';
        $this->db->where($where);
        $this->db->update('university_admins',array("isDeleted"=>1));
		$this->universityAdminCnt($universityId);
        $this->session->set_flashdata('success', 'Deleted successfully.');	
    }
	
	public function delete_entry($universityId){
		$this->db->where('universityId', $universityId);
		$this->db->update('university', array("isDeleted" => '1'));	
		
		$this->db->where('universityId', $universityId);
		$this->db->update('university_admins', array("isDeleted" => '1'));
		$this->session->set_flashdata('success', 'Deleted successfully!');;
	}

}
