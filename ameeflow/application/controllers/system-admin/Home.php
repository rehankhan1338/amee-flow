<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_login'] = $this->session->flashdata('error');
		$this->data['error_msg'] = $this->session->flashdata('error');
		//$this->data['configuration_details'] = $this->Settings_mdl->configuration_details();
        $this->data['title'] = 'My Profile - '.$this->config->item('product_name');  		  
 	} 

    public function ameelab(){  
		$this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));	
        $this->data['pageTitle']='AMEE Lab';
        $this->data['active_class'] = 'ameelab-menu';
		$this->load->view('system-admin/includes/header',$this->data);
		$this->load->view('Frontend/amee-lab',$this->data);
		$this->load->view('system-admin/includes/footer',$this->data);
	}

    public function profile(){        
        $this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));         
        $this->data['pageTitle']='My Profile';
        $this->data['pageSubTitle']='';
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/profile/manage',$this->data);
        $this->load->view('system-admin/includes/footer',$this->data);   		
	}
    public function updateProfile(){
		echo $this->Users_mdl->updateSystemAdminProfile();
	}
    public function logout(){
		session_destroy();
		redirect(base_url()."signin");
	}
    // public function index(){
    //     $shortName = $this->uri->segment(2);
    //     if(isset($shortName) && $shortName!=''){
    //         $uniDetails = $this->Accounts_mdl->universityDetailsbyShortName($shortName);
    //         if(count($uniDetails)==0){
    //             redirect(base_url().$this->config->item('system_directory_name').'error/unauthorised-university');
    //         }else{        
    //             $this->data['uniDetails'] = $uniDetails;
    //             $this->data['btnText'] = 'Sign in to start your session';
    //             $this->data['accTypeSts'] = 1;
    //             $this->data['accType'] = 'System Admin';
    //             $this->data['title'] = $this->data['accType'].' - '.$this->config->item('product_name'); 
    //             $this->data['frmAction'] = $this->config->item('ajax_base_url').$this->config->item('system_directory_name').'home/checkLogin';       
    //             $this->load->view('Backend/includes/login_header',$this->data);
    //             $this->load->view('Backend/login/view',$this->data);
    //             $this->load->view('Backend/includes/login_footer',$this->data);
    //         }
    //     }else{
    //         redirect(base_url().$this->config->item('system_directory_name').'error/url-not-valid');
    //     }  		
	// }   
    // public function profileOldAMeeDesign(){	
    //     $this->data['title']=''.$this->config->item('product_name');
    //     $this->data['page_title']='Admin Panel';
    //     $this->load->view('system-admin/includes/header',$this->data);
    //     $this->load->view('system-admin/profile/manage',$this->data);
    //     $this->load->view('system-admin/includes/footer',$this->data);   		
	// }
}