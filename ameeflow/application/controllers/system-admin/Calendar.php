<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Calendar extends CI_Controller {
 	 
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
		$this->data['title']='Calendar Schedule'; 
		$this->data['active_class']='calender-menu';
		$this->load->model('Calendar_mdl');
 	}

    public function index(){
		$this->data['manageSts'] = 1;		
		$this->data['pageTitle'] = 'Calendar Schedule';
		$this->data['createdBy'] = 1;
		$this->data['universityId'] = $this->data['sessionDetailsArr']['universityId'];
		$this->data['uniAdminId'] = $this->data['useuniAdminId'];
		$this->data['createdById'] = $this->data['sessionDetailsArr']['uniAdminId'];

		$this->data['uaDetails'] = $this->Users_mdl->systemAdminDetails($this->data['uniAdminId']);
		$this->data['shareuaencryptId'] = $this->data['uaDetails']['uaencryptId'];
		$this->data['eventDataArr'] = $this->Calendar_mdl->uniEventDataArr($this->data['uniAdminId']);

		$this->data['myEventDataArr'] = $this->Calendar_mdl->myEventDataArr('1',$this->data['createdById']);
		//   echo '<pre>';print_r($this->data['uaDetails']);die;
        $this->load->view('system-admin/includes/header',$this->data);	 
		$this->load->view('Frontend/calendar/show',$this->data);
		$this->load->view('Backend/includes/footer',$this->data);
    }
}