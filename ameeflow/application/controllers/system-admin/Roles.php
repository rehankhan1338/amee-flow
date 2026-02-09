<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Roles extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 
        $this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));	
        if($this->data['sessionDetailsArr']['createdBy']>0){
            $this->data['useuniAdminId'] = $this->data['sessionDetailsArr']['createdBy'];
        }else{
            $this->data['useuniAdminId'] = $this->data['sessionDetailsArr']['uniAdminId'];
        }
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Roles_mdl'); 
        $this->load->model('Projects_mdl'); 		  
        $this->data['active_class'] = 'assignment-menu';
        $this->data['title'] = 'Role Assignments - '.$this->config->item('product_name');
 	} 
    public function index(){         
        $this->data['pageTitle'] = 'Role Assignments';
        $this->data['pageSubTitle'] = '';
        $this->data['uniUsersDataArr'] = $this->Roles_mdl->acctUsersDataArr($this->data['useuniAdminId']);
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/role-assignments/list',$this->data);
        $this->load->view('Backend/includes/footer',$this->data);
	}
    public function ajaxFormFields(){        
        if(isset($_GET['userId']) && $_GET['userId']!='' && $_GET['userId']>0){
            $this->data['userDetailsArr'] = $this->Roles_mdl->userDetailsWithAccessDetailsArr($_GET['userId']);
        }else{
            $this->data['userDetailsArr'] = array();
        }
        $this->data['menuDataArr'] = $this->Roles_mdl->menuDataArr();
        $this->data['subMenuDataArr'] = $this->Roles_mdl->subMenuDataArr();
        $this->data['moreSubMenuDataArr'] = $this->Roles_mdl->moreSubMenuDataArr();
        $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->data['useuniAdminId']); 
        $this->load->view('system-admin/role-assignments/ajax-fields',$this->data);
    }
    public function manageUser(){
        echo $this->Roles_mdl->manageUser();
    }
    public function ajaxSeniorRoles(){
        if(isset($_GET['userId']) && $_GET['userId']!='' && $_GET['userId']>0){
            $this->data['seniorData'] = $this->Roles_mdl->seniorDatabyUidArr($_GET['userId']);
            $this->load->view('system-admin/role-assignments/ajax-senior-roles',$this->data);
        }
    }
    public function resendLoginDetails(){
        if(isset($_GET['userIds']) && $_GET['userIds']!='' && $_GET['userIds']>0){
            echo $this->Roles_mdl->resendLoginDetails($_GET['userIds']);
        }
    }
    public function deleteUser(){
        if(isset($_GET['userIds']) && $_GET['userIds']!='' && $_GET['userIds']>0){
            echo $this->Roles_mdl->deleteUser($_GET['userIds']);
        }
    }
    public function updateUserStatus(){
		if(isset($_GET['userId']) && $_GET['userId']!=''){
			 $userId=$_GET['userId'];
			 $column_name=$_GET['column_name'];
			 $status=$_GET['status'];
			 echo $this->Roles_mdl->updateUserStatus($userId,$column_name,$status);
		}
	}
}