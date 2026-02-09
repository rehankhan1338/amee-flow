<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
        $this->load->model('Backend/Accounts_mdl');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Project Manager Accounts | Administrator Panel';
		$this->data['active_class']='accounts_menu'; 
        $this->data['page_title']='Project Manager Accounts List';
        $this->load->model('Access_mdl'); 	
 	}

    public function index(){
        $this->data['accountDataArr']=$this->Accounts_mdl->accountDataArr();
        $this->load->view('Backend/includes/header',$this->data);
        $this->load->view('Backend/accounts/view',$this->data);
        $this->load->view('Backend/includes/footer');
    }

    public function admins(){
        $uencryptId= $this->uri->segment(4);
        if(isset($uencryptId) && $uencryptId!=''){
            $this->data['accountDetailsArr']=$this->Accounts_mdl->accountsDetailsByeId($uencryptId);
            $universityId = $this->data['accountDetailsArr']['universityId'];
            $this->data['accountAdminDataArr']=$this->Accounts_mdl->accountAdminDataArr($universityId);
            $this->load->view('Backend/includes/header',$this->data);
            $this->load->view('Backend/accounts/admins/list',$this->data);
            $this->load->view('Backend/includes/footer');
        }else{
            redirect(base_url() . $this->config->item('admin_directory_name') . 'accounts');
        }
    }

    public function ajaxFormFields(){        
        if(isset($_GET['uniAdminId']) && $_GET['uniAdminId']!='' && $_GET['uniAdminId']>0){
            $this->data['uniadminDetails'] = $this->Accounts_mdl->uniadminDetailsArr($_GET['uniAdminId']);
        }else{
            $this->data['uniadminDetails'] = array();
        }
        $this->data['menuDataArr'] = $this->Access_mdl->menuDataArr();
        $this->data['subMenuDataArr'] = $this->Access_mdl->subMenuDataArr();
        $this->data['moreSubMenuDataArr'] = $this->Access_mdl->moreSubMenuDataArr();
        $this->load->view('Backend/accounts/admins/ajax-fields',$this->data);
    }

    public function manageAdminData(){
        echo $this->Accounts_mdl->manageAdminData();
    }

    public function add(){
        $this->data['headTxt']='Add New University';
        $this->data['btnTxt']='Add Now!';
        $this->data['accountDetailsArr']=array();
        $this->load->view('Backend/includes/header',$this->data);
        $this->load->view('Backend/accounts/manage',$this->data);
        $this->load->view('Backend/includes/footer');
    }

    public function edit(){
		$uencryptId= $this->uri->segment(4);
        if(isset($uencryptId) && $uencryptId!=''){
            $this->data['headTxt']='Edit University Details';
            $this->data['btnTxt']='Update';
            $this->data['accountDetailsArr']=$this->Accounts_mdl->accountsDetailsByeId($uencryptId);
            $this->load->view('Backend/includes/header',$this->data);
            $this->load->view('Backend/accounts/manage',$this->data);
            $this->load->view('Backend/includes/footer');
        }else{

        }
        
    }

    public function manageEntry(){
         echo $this->Accounts_mdl->manageEntry();
	}

    public function delete(){
        $uencryptId= $this->uri->segment(4);
        if(isset($uencryptId) && $uencryptId!=''){
            echo $this->Accounts_mdl->delete_entry($uencryptId);
        }
        redirect(base_url() . $this->config->item('admin_directory_name') . 'accounts');

    }

    public function deleteAdminAccount(){
        if(isset($_GET['uniAdminIds']) && $_GET['uniAdminIds']!='' && $_GET['uniAdminIds']>0){
            echo $this->Accounts_mdl->deleteAdminAccount($_GET['uniAdminIds'],$_GET['uId']);
        }
    }
}