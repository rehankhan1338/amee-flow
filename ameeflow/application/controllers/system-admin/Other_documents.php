<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Other_documents extends CI_Controller {
 	 
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
        $this->load->model('Other_documents_mdl'); 
        $this->load->model('Projects_mdl'); 		  
        $this->data['active_class'] = 'planning-doc-menu';
        $this->data['title'] = 'Other Documents - '.$this->config->item('product_name');
 	}
    public function index(){         
        $this->data['pageTitle'] = 'Other Documents';
        $this->data['pageSubTitle'] = '';        
        $this->data['documentsDataArr'] = $this->Other_documents_mdl->documentsDataArr($this->data['useuniAdminId']); 
        $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->data['useuniAdminId']);               
        // $universityId = $this->data['sessionDetailsArr']['universityId'];
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/planning-documents/other-documents/manage',$this->data);
        $this->load->view('Backend/includes/footer',$this->data);
	}
    public function ajaxDocFields(){        
        if(isset($_GET['docId']) && $_GET['docId']!='' && $_GET['docId']>0){
            $this->data['docDetails'] = $this->Other_documents_mdl->docDetailsArr($_GET['docId']);
        }else{
            $this->data['docDetails'] = array();
        }
        $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->data['useuniAdminId']);   
        $this->load->view('system-admin/planning-documents/other-documents/ajax-doc-fields',$this->data);
    }
    public function manageDocEntry(){
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET, POST");
        // header("Access-Control-Allow-Headers: Content-Type");
        echo $this->Other_documents_mdl->manageDocEntry();
    }
    public function deleteDoc(){
        if(isset($_GET['docIds']) && $_GET['docIds']!='' && $_GET['docIds']>0){
            echo $this->Other_documents_mdl->deleteDoc($_GET['docIds']);
        }
    }
}