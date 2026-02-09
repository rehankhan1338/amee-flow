<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 
        $this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Projects_mdl'); 		  
        $this->data['active_class'] = 'system_setting';
        $this->data['title'] = 'System Setting - '.$this->config->item('product_name');
 	} 
    public function emails(){   
        // echo '<pre>';print_r($_SESSION);die;      
        $this->data['pageTitle'] = 'Email Templates';
        $this->data['pageSubTitle'] = '';
        $this->data['emailsList'] = $this->Settings_mdl->universityEmailsListbyuId($this->session->userdata('AFSESS_UNIADMINID'));
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/settings/emails',$this->data);
        $this->load->view('system-admin/includes/footer',$this->data);
	}
    public function ajaxEmailFields(){        
        if(isset($_GET['eId']) && $_GET['eId']!='' && $_GET['eId']>0){
            $this->data['emailDetails'] = $this->Settings_mdl->emailDetailsArr($_GET['eId']);
        }else{
            $this->data['emailDetails'] = array();
        }
        $this->load->view('system-admin/settings/ajax-fields',$this->data);
    }
    public function updateEmailContent(){
        echo $this->Settings_mdl->updateEmailContent();
    }
}