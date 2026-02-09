<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Roles extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 
        $this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));
        // echo '<pre>';print_r($this->data['sessionDetailsArr']);die;	
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Roles_mdl'); 		  
        $this->data['active_class'] = 'assignment-menu';
        $this->data['title'] = 'Role Assignments - '.$this->config->item('product_name');
 	} 
    public function index(){         
        $this->data['pageTitle'] = 'Role Assignments';
        $this->data['pageSubTitle'] = '';
        $userId = $this->data['sessionDetailsArr']['userId'];
        $this->data['rolesDataArr'] = $this->Roles_mdl->rolesDataArr($userId);
        $this->load->view('Frontend/includes/header',$this->data);
        $this->load->view('Frontend/role-assignments/list',$this->data);
        $this->load->view('Backend/includes/footer',$this->data);
	}
    public function ajaxFormFields(){        
        if(isset($_GET['roleId']) && $_GET['roleId']!='' && $_GET['roleId']>0){
            $this->data['roleDetailsArr'] = $this->Roles_mdl->roleDetailsArr($_GET['roleId']);
        }else{
            $this->data['roleDetailsArr'] = array();
        }
        $this->load->view('Frontend/role-assignments/ajax-fields',$this->data);
    }
    public function manageRole(){
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $userId = $this->data['sessionDetailsArr']['userId'];
        echo $this->Roles_mdl->manageRole($universityId,$userId);
    }
    public function updateStatus(){
		if(isset($_GET['roleId']) && $_GET['roleId']!=''){
			 $roleId=$_GET['roleId'];
			 $column_name=$_GET['column_name'];
			 $status=$_GET['status'];
			 echo $this->Roles_mdl->updateStatus($roleId,$column_name,$status);
		}
	}
    public function deleteRole(){
        if(isset($_GET['roleIds']) && $_GET['roleIds']!='' && $_GET['roleIds']>0){
            $userId = $this->data['sessionDetailsArr']['userId'];
            echo $this->Roles_mdl->deleteRole($_GET['roleIds'],$userId);
        }
    }
}