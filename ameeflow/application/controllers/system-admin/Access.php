<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Access extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 
        $this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));	
        // echo '<pre>';print_r($this->data['sessionDetailsArr']);die;	
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Access_mdl'); 		  
        $this->data['active_class'] = 'access-menu';
        $this->data['title'] = 'Access - '.$this->config->item('product_name');
 	} 
    public function index(){ 
        $createdBy = $this->data['sessionDetailsArr']['uniAdminId']; 
        $this->data['pageTitle'] = 'Access';
        $this->data['pageSubTitle'] = '';
        $this->data['guestAccessDataArr'] = $this->Access_mdl->guestAccessDataArr($createdBy);
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/guest-access/list',$this->data);
        $this->load->view('system-admin/includes/footer',$this->data);
	}
    public function ajaxFormFields(){        
        if(isset($_GET['gaId']) && $_GET['gaId']!='' && $_GET['gaId']>0){
            $this->data['gaDetailsArr'] = $this->Access_mdl->accessDetailsArr($_GET['gaId']);
        }else{
            $this->data['gaDetailsArr'] = array();
        }

        
        $this->data['menuDataArr'] = $this->Access_mdl->gaccessMenuDataArr($this->data['sessionDetailsArr']['menu_ids']);
        $this->data['subMenuDataArr'] = $this->Access_mdl->subMenuDataArr($this->data['sessionDetailsArr']['submenu_ids']);
        $this->data['moreSubMenuDataArr'] = $this->Access_mdl->moreSubMenuDataArr($this->data['sessionDetailsArr']['submenu_subcat_ids']);
        $this->load->view('system-admin/guest-access/ajax-fields',$this->data);
    }
    public function manageAccessEntry(){
        echo $this->Access_mdl->manageAccessEntry();
    }
    public function deleteAccess(){
        if(isset($_GET['uniAdminIds']) && $_GET['uniAdminIds']!='' && $_GET['uniAdminIds']>0){
            echo $this->Access_mdl->deleteAccess($_GET['uniAdminIds']);
        }
    }
    public function updateAccessStatus(){
        if(isset($_GET['uniAdminId']) && $_GET['uniAdminId']!=''){
            $uniAdminId=$_GET['uniAdminId'];
            $column_name=$_GET['column_name'];
            $status=$_GET['status'];
            echo $this->Access_mdl->updateAccessStatus($uniAdminId,$column_name,$status);
        }
    }
}