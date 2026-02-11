<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Access extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();         
        $this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));	
        //  echo '<pre>';print_r($this->data['sessionDetailsArr']);die;	
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Access_user_mdl'); 		  
        $this->data['active_class'] = 'access-menu';
        $this->data['title'] = 'Access - '.$this->config->item('product_name');
 	} 
    public function index(){ 
        $userId = $this->data['sessionDetailsArr']['userId']; 
        $this->data['pageTitle'] = 'Access';
        $this->data['pageSubTitle'] = '';
        $this->data['guestAccessDataArr'] = $this->Access_user_mdl->guestAccessDataArr($userId);
        // echo '<pre>';print_r($this->data['guestAccessDataArr']);die;	
        $this->load->view('Frontend/includes/header',$this->data);	
        $this->load->view('Frontend/guest-access/list',$this->data);
        $this->load->view('Frontend/includes/footer',$this->data);
	}
    public function ajaxFormFields(){        
        if(isset($_GET['gaId']) && $_GET['gaId']!='' && $_GET['gaId']>0){
            $this->data['gaDetailsArr'] = $this->Access_user_mdl->accessDetailsArr($_GET['gaId']);
        }else{
            $this->data['gaDetailsArr'] = array();
        }
        $this->load->view('Frontend/guest-access/ajax-fields',$this->data);
    }
    public function manageAccessEntry(){
        echo $this->Access_user_mdl->manageAccessEntry();
    }
    public function deleteAccess(){
        if(isset($_GET['userAccessIds']) && $_GET['userAccessIds']!='' && $_GET['userAccessIds']>0){
            echo $this->Access_user_mdl->deleteAccess($_GET['userAccessIds']);
        }
    }
    public function updateAccessStatus(){
        if(isset($_GET['userAccessId']) && $_GET['userAccessId']!=''){
            $userAccessId=$_GET['userAccessId'];
            $column_name=$_GET['column_name'];
            $status=$_GET['status'];
            echo $this->Access_user_mdl->updateAccessStatus($userAccessId,$column_name,$status);
        }
    }
}