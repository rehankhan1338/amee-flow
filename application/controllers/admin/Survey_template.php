<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Survey_template extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Survey Templates | Administrator Panel';
		$this->data['active_class']='survey_template_menu';   
 	}
	
	
	public function template(){		
		$this->data['page_title']='Survey Templates';
		$this->data['default_survey_templates_detail'] = $this->Survey_template_mdl->default_survey_templates_detail();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/survey_template/template_list',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
	
	public function index(){			
 		$this->data['default_survey_templates_fulldetail'] = $this->Survey_template_mdl->default_survey_templates_fulldetail($_GET['stid']);
		$this->data['page_title']=$this->data['default_survey_templates_fulldetail']->name.' Template';
		$this->data['default_survey_questions_details']=$this->Survey_template_mdl->default_surveys_questions_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/survey_template/questions_listing',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
	
	
	public function add_template(){
		$this->form_validation->set_rules('txt_template_name','Template Name','required'); 
 		if ($this->form_validation->run() == FALSE){			
			$this->data['title']='Survery Template - Administrator Panel';
			$this->data['active_class']='';
			$this->data['page_title']='Survery Template : : Create';
 			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/survey_template/add_template',$this->data);
			$this->load->view('Backend/includes/footer');				
		}else{			
			$this->Survey_template_mdl->add_template_entry();
			redirect(base_url()."admin/survey/template");
		}		
	}	
	
	public function edit_template(){
		if(isset($_GET['id'])&&$_GET['id']!=''){
			$id = $_GET['id'];
			$this->form_validation->set_rules('txt_template_name','Template Name','required'); 
			if ($this->form_validation->run() == FALSE){			
				$this->data['title']='Survery Template - Administrator Panel';
				$this->data['active_class']='';
				$this->data['page_title']='Survery Template : : Edit';
				$this->data['default_survey_templates_fulldetail'] = $this->Survey_template_mdl->default_survey_templates_fulldetail($id);
				$this->load->view('Backend/includes/header',$this->data);
				$this->load->view('Backend/survey_template/edit_template',$this->data);
				$this->load->view('Backend/includes/footer');				
			}else{			
				$this->Survey_template_mdl->edit_template_entry($id);
			}	
		}else{
			redirect('admin/survey/template'); 	
		}	
	}
	
	
	public function add(){
		if(isset($_GET['stid'])&&$_GET['stid']!=''){
			$this->data['default_survey_templates_fulldetail'] = $this->Survey_template_mdl->default_survey_templates_fulldetail($_GET['stid']);
			$this->data['page_title']=$this->data['default_survey_templates_fulldetail']->name.' Template : : Question : : Add';
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/survey_template/add_question',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			redirect('admin/survey/template'); 	
		}		
	}	
	
	
	public function get_default_question_choice(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Backend/survey_template/default_choices',$this->ajax_data);
		}
	}
	
	public function get_action_html_of_answer(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Backend/survey_template/anser_actions',$this->ajax_data);
		}
	}
	
	public function get_multiple_choice_rating_ajax(){
		if(isset($_GET['scale_id']) && $_GET['scale_id']!=''){
			$this->data['multiple_choice_rating_list'] = $this->Survey_template_mdl->get_multiple_choice_rating_ajax($_GET['scale_id']);
			return $this->load->view('Backend/survey_template/get_multiple_choice_rating_ajax',$this->data);
		}
	}	
	
	public function get_matrix_scale_point_rating_ajax(){
		if(isset($_GET['scale_id']) && $_GET['scale_id']!=''){
			$this->data['multiple_choice_rating_list'] = $this->Survey_template_mdl->get_multiple_choice_rating_ajax($_GET['scale_id']);
			$this->load->view('Backend/survey_template/get_matrix_scale_point_rating_ajax',$this->data);
		}
	}
	
	public function question_save(){
		$this->Survey_template_mdl->question_save();
	}	


	public function edit(){ 
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$this->data['question_id'] = $_GET['question_id'];
			$this->data['survey_template_id'] = $_GET['survey_id'];
			$this->data['default_survey_templates_fulldetail'] = $this->Survey_template_mdl->default_survey_templates_fulldetail($_GET['survey_id']);
			$this->data['page_title']=$this->data['default_survey_templates_fulldetail']->name.' Template : : Question : : Edit';		
			$this->data['default_survey_templates_detail'] = $this->Survey_template_mdl->default_survey_templates_detail();
			$this->data['default_surveys_questions_rowdetails'] = $this->Survey_template_mdl->default_surveys_questions_rowdetails($_GET['question_id']); 		
	 		$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/survey_template/edit_survey_questions/edit_question',$this->data);
			$this->load->view('Backend/includes/footer');
		}
	}
	
		
	public function get_edit_default_question_choice(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];	
			$this->ajax_data['question_id']=$_GET['question_id'];	
			$this->ajax_data['edit_question_fulldetails'] = $this->Survey_template_mdl->default_surveys_questions_rowdetails($_GET['question_id']);	 			
			return $this->load->view('Backend/survey_template/edit_survey_questions/default_choices',$this->ajax_data);
		}
	}
	
	public function get_edit_action_html_of_answer(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			$this->ajax_data['question_id']=$_GET['question_id'];				
			$this->ajax_data['edit_question_fulldetails'] = $this->Survey_template_mdl->default_surveys_questions_rowdetails($_GET['question_id']);	 			
			return $this->load->view('Backend/survey_template/edit_survey_questions/anser_actions',$this->ajax_data);
		}
	}	
	
	public function update_question_entry(){
		$this->Survey_template_mdl->update_question_entry();
	}
	

 	public function delete_question_choice(){
		if(isset($_GET['answer_id']) && $_GET['answer_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			$this->Survey_template_mdl->delete_question_choice($_GET['answer_id'],$_GET['question_id'],$_GET['question_type']);
		}
 	}	
 	
 	public function delete_default_survey_question(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$this->Survey_template_mdl->delete_default_survey_question($_GET['question_id'],$_GET['survey_id']);
		}
 	}
 	
 	
} 