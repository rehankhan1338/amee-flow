<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Calendar extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();				
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
		$this->data['title']='Calendar Schedule'; 
		$this->data['active_class']='calender-menu';
		$this->load->model('Calendar_mdl');
		$this->load->model('Users_mdl');
 	}

	public function share(){
		$uaencryptId = $this->uri->segment(3);
		if(isset($uaencryptId) && $uaencryptId!=''){
			$this->data['uaDetails'] = $this->Users_mdl->systemAdminDetailsByeid($uaencryptId);
			$uniAdminId = $this->data['uaDetails']['uniAdminId'];
			$this->data['eventDataArr'] = $this->Calendar_mdl->uniEventDataArr($uniAdminId);
			$this->load->view('Frontend/calendar/share',$this->data);
		}
	}

    public function index(){
		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));
		if($this->data['sessionDetailsArr']['userType']==3){
			$this->data['manageSts'] = 0;
		}else{
			$this->data['manageSts'] = 1;
		}
		$this->data['pageTitle'] = 'Calendar Schedule';
		$this->data['createdBy'] = 0;
		$this->data['universityId'] = $this->data['sessionDetailsArr']['universityId'];
		$this->data['uniAdminId'] = $this->data['sessionDetailsArr']['uniAdminId'];
		$this->data['createdById'] = $this->data['sessionDetailsArr']['userId'];
		$this->data['uaDetails'] = $this->Users_mdl->systemAdminDetails($this->data['uniAdminId']);
		// $this->data['shareuaencryptId'] = $this->data['uaDetails']['uaencryptId'];
		$this->data['shareuaencryptId'] = 0;
		$this->data['eventDataArr'] = $this->Calendar_mdl->uniEventDataArr($this->data['uniAdminId']);

		$this->data['myEventDataArr'] = $this->Calendar_mdl->myEventDataArr('0',$this->data['createdById']);

		//  echo '<pre>';print_r($this->data['uaDetails']);die;
        $this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/calendar/show',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
    }
}