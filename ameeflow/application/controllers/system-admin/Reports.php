<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
 	 
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
        $this->data['active_class'] = 'team-reports';
        $this->data['title'] = 'Team Reports - '.$this->config->item('product_name');
        $this->load->model('Course_enrollment_mdl');
        $this->load->model('Loads_report_mdl');
        $this->load->model('General_reports_mdl');
 	}
    public function sampling_plan(){
        $this->data['shareReportFor'] = '1';
		$this->data['samplingPlanDataArr'] = $this->Course_enrollment_mdl->pmSamplingPlansDataArr($this->data['useuniAdminId']);
        $this->data['spYearArr'] = $this->Course_enrollment_mdl->pmSamplingPlansYearsDataArr($this->data['useuniAdminId']);
        if(isset($_GET['termId']) && $_GET['termId']!='' && $_GET['termId']>0){
            $this->data['termsOptions'] = $this->Course_enrollment_mdl->spTermsByYr($this->data['useuniAdminId'],$_GET['yr']);
        }else{
            $this->data['termsOptions'] = array();
        }

		$this->data['pageTitle'] = 'Sampling Plans';
        $this->data['pageSubTitle'] = ''; 
		$this->load->view('system-admin/includes/header',$this->data);
		$this->load->view('system-admin/team-reports/sampling_plan/listing',$this->data);
		$this->load->view('system-admin/includes/footer',$this->data);
	}
    public function ajaxGetSPTerms(){
		$this->data['termsOptions'] = $this->Course_enrollment_mdl->spTermsByYr($_GET['uniAdminId'],$_GET['year']);
        $this->data['selTerm'] = $_GET['selTerm'];
		$this->load->view('system-admin/team-reports/sampling_plan/ajaxTermsOptions',$this->data);
	}
    public function loads_report(){
        $this->data['shareReportFor'] = '2';
        $this->data['loadsReportDataArr'] = $this->Loads_report_mdl->pmLoadsReportDataArr($this->data['useuniAdminId']);
		$this->data['pageTitle'] = 'LOADs Report';
        $this->data['pageSubTitle'] = ''; 
		$this->load->view('system-admin/includes/header',$this->data);
		$this->load->view('system-admin/team-reports/loads_report/listing',$this->data);
		$this->load->view('system-admin/includes/footer',$this->data);
	}
    public function general_report(){
        $this->data['shareReportFor'] = '3';
        $this->data['generalReportDataArr'] = $this->General_reports_mdl->pmGeneralReportDataArr($this->data['useuniAdminId']);
		$this->data['pageTitle'] = 'General Report';
        $this->data['pageSubTitle'] = ''; 
		$this->load->view('system-admin/includes/header',$this->data);
		$this->load->view('system-admin/team-reports/general_reports/listing',$this->data);
		$this->load->view('system-admin/includes/footer',$this->data);
	}
}