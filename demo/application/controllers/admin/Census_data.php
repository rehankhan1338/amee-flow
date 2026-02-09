<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Census_data extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Census Data | Administrator Panel';
		$this->data['active_class']='census_data_menu';
		$this->load->model('Backend/Census_data_mdl');
 	}
	
	public function index(){
				 
		$this->data['census_add_icon']=1;  
		
		if(isset($_GET['yr']) && $_GET['yr']!='' && isset($_GET['cid']) && $_GET['cid']!=''){
			$year = $_GET['yr'];
			$catId = $_GET['cid'];
			$this->data['censusYearData'] = $this->Census_data_mdl->getCensusYearData($year);
			if(isset($this->data['censusYearData']->censusId) && $this->data['censusYearData']->censusId!=''){
				$censusId = $this->data['censusYearData']->censusId;
			}else{
				$censusId = 0;
			}
			$this->data['censusOptionsData']=$this->Census_data_mdl->getCensusOptionsData($censusId,$catId);
		}else{
			$year = '';
			$catId = '';
			$this->data['censusYearData'] = array();
			$this->data['censusOptionsData'] = array();
		}		
		$this->data['page_title']=$year.' Census Data';
		$this->data['masterCensusData']=$this->Census_data_mdl->masterCensusDataByCatId($catId); 
		$this->data['year'] = $year;
		$this->data['catId'] = $catId;
		 
		//echo '<pre>'; print_r($this->data['masterCensusData']);die;
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/census_data/listing',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function add(){
		
		/*$masterCensusFormOptionsData=$this->Census_data_mdl->masterCensusFormOptionsData(); 
		foreach($masterCensusFormOptionsData as $data){
			$amee_web = $this->load->database('amee_web', TRUE);
			 $amee_web->insert('census_data', array("catId"=>'1', "parentId"=>$data['indicatorId'], "indicatorTitle"=>$data['optionIndTitle'], "priority"=>$data['priority']));
		}
		
		die;*/
		
		$this->data['page_title']='Census Data : : Add';
		$this->data['masterCensusFormData']=$this->Census_data_mdl->masterCensusFormData(); 
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/census_data/add',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function createEntry(){
		echo $this->Census_data_mdl->createEntry();
	}
	
	public function edit(){
		$censusId = $this->uri->segment(4);
		if(isset($censusId) && $censusId!=''){
			$this->data['censusYearData'] = $this->Census_data_mdl->getCensusYearDataById($censusId);
			$this->data['censusOptionsData']=$this->Census_data_mdl->getCensusOptionsData($censusId,'0');
			$this->data['masterCensusFormData']=$this->Census_data_mdl->masterCensusFormData();	
			//echo '<pre>'; print_r($this->data['censusOptionsData']);die;	
			$this->data['page_title']='Census Data : : Edit';
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/census_data/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			redirect(base_url().'admin/census_data');
		}
	}
	
	public function updateEntry(){
		echo $this->Census_data_mdl->updateEntry();
	}
	
	public function delete(){
		$censusId = $this->uri->segment(4);
		if(isset($censusId) && $censusId!=''){
			$this->Census_data_mdl->deleteCensusData($censusId);
		}
		redirect(base_url().'admin/census_data');
	}
	
}