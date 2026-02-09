<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Access_mdl extends CI_Model {
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

	public function gaccessMenuDataArr($menu_ids){
		if(isset($menu_ids) && $menu_ids!=''){
			$where = ' id in ('.$menu_ids.')';
			$this->db->where($where);
		}
		$this->db->where('id != ', 9);
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('administrator_menu');
		return $query->result_array();
    }

    public function menuDataArr(){
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('administrator_menu');
		return $query->result_array();
    }
    public function subMenuDataArr($submenu_ids=''){
		if(isset($submenu_ids) && $submenu_ids!=''){
			$where = ' id in ('.$submenu_ids.')';
			$this->db->where($where);
		}
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('administrator_submenu');
		return $query->result_array();
    }
    public function moreSubMenuDataArr(){
		$this->db->where('status', 0);
        $this->db->order_by('priority', 'asc');
		$query = $this->db->get('administrator_submenu_subcat');
		return $query->result_array();
    }
    public function guestAccessDataArr($createdBy){
		$this->db->where('createdBy', $createdBy);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('university_admins');
		return $query->result_array();
    }
	public function accessDetailsArr($gaId){
		$this->db->where('uniAdminId', $gaId);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('university_admins');
		return $query->row_array();
    }
	public function manageAccessEntry(){
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
				$onDate = strtotime(date('Y-m-d'));	
				$onTime = time();
				$universityId = trim($this->input->post('rauniversityId'));
				$createdBy = trim($this->input->post('racreatedBy'));
				$fullName = trim($this->input->post('txtFullName'));
				$email = strtolower(trim($this->input->post('txtEmail')));
				$contactNo = trim($this->input->post('txtcontactNo'));
				$accType = 'guest-access';
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
						$this->db->update('university_admins', array('fullName'=>$fullName, 'email'=>$email, 'contactNo'=>$contactNo, 'menu_ids'=>$menu_ids, 'submenu_ids'=>$submenu_ids, 'submenu_subcat_ids'=>$submenu_subcat_ids));
						$this->session->set_flashdata('success', 'Updated successfully!');
					}else{
						$this->db->insert('university_admins', array('universityId'=>$universityId, 'createdBy'=>$createdBy, 'fullName'=>$fullName, 'email'=>$email, 'contactNo'=>$contactNo, 'accType'=>$accType, 'menu_ids'=>$menu_ids, 'submenu_ids'=>$submenu_ids, 'submenu_subcat_ids'=>$submenu_subcat_ids, 'onDate'=>$onDate, 'onTime'=>$onTime));
						$uniAdminId = $this->db->insert_id();
						$uaencryptId = generateRandomNumStringCh(4).'ua'.$uniAdminId.generateRandomNumStringCh(4);
						$password = generateRandomNumStringCh(5).'p'.$uniAdminId.generateRandomNumStringCh(5);
						$this->db->where('uniAdminId',$uniAdminId); 
						$this->db->update('university_admins', array("uaencryptId"=>$uaencryptId, "password"=>md5($password), "randomId"=>base64_encode($password)));
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
					}
					return 'success||'.base_url().$this->config->item('system_directory_name').'access';
				}else{
					return 'error||Oops, email already exist.';
				}
			}else{
				return 'error||Oops, please select at least one privillage.';
			}
		}else{
			return 'error||Oops, please select at least one privillage.';
		}
	}
	public function updateAccessStatus($uniAdminId,$column_name,$status){
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->update('university_admins', array("$column_name"=>$status));		
		return 'success';
	}
	public function deleteAccess($uniAdminIds){
        $where = ' uniAdminId in ('.$uniAdminIds.')';
        $this->db->where($where);
		$this->db->update('university_admins', array("isDeleted"=>1));
        $this->session->set_flashdata('success', 'Deleted successfully.');	
    }
}