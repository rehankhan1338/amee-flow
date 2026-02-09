<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends CI_Controller { 

	function __construct(){
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
		$this->data['page_title']='Create Step 5 : Measurement Tools';
		$this->data['action_menu']='4';
		$this->data['activity_name']='Tests';
		$activity_name = 'test';
		time_tracking_management_ch($activity_name); 
 	} 	

	/*public function truncate_test(){
		$this->db->truncate('tests'); 
		$this->db->truncate('tests_course'); 
		$this->db->truncate('tests_email'); 
		$this->db->truncate('tests_questions'); 
		$this->db->truncate('test_answers'); 
		$this->db->truncate('test_question_answers');	
		$this->db->truncate('test_criterion_option');	
	}*/		

	public function index(){
		$this->data['tests_listing'] = $this->Tests_mdl->department_tests_listing($this->session->userdata('dept_id'));
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/tests/list',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	

	public function apply_criterion_option(){
		if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['val']) && $_GET['val']!=''){
			$this->ajax_data['val']=$_GET['val'];
			$this->ajax_data['test_id']=$_GET['test_id'];
			return $this->load->view('Frontend/create/tests/test_criterion',$this->ajax_data);
		}
	}
	
	public function update_test_status_btn(){
		$status = $_GET['status'];
		$id = $_GET['id'];
 		$this->Tests_mdl->update_test_status_btn($status,$id);	
	}	

	public function add(){
		$this->Tests_mdl->add_test($this->session->userdata('dept_id'));
	}
	
	public function edit(){
		$this->Tests_mdl->edit_test($this->session->userdata('dept_id'));
	}
	
	public function delete(){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$this->Tests_mdl->delete_test($_GET['id']);
		}
	}

	public function management(){
		//$last = $this->uri->total_segments();
		//$survey_id = $this->uri->segment($last);
		if(isset($_GET['test_id']) && $_GET['test_id']!=''){
			$test_id = $_GET['test_id'];
			$dept_id = $this->session->userdata('dept_id');
			$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($test_id);
			if(isset($this->data['test_details']->test_id) && $this->data['test_details']->test_id!=''){
			
				$this->data['tests_questions_detail'] = $this->Tests_mdl->tests_questions_detail($test_id,'0');
				$this->data['dempgraphy_questions_detail'] = $this->Tests_mdl->tests_questions_detail($test_id,'1');
				$this->data['tests_course_detail'] = $this->Tests_mdl->tests_course_detail($test_id);
				$this->data['tests_email_detail'] = $this->Tests_mdl->tests_email_detail($test_id,$dept_id);
				
				$this->data['tests_student_complete_incomplete_detail'] = $this->Tests_mdl->tests_student_complete_incomplete_detail($test_id,$dept_id);
				
				$test_type=$this->data['test_details']->test_type;
				if($test_type==1){
					$this->data['student_post_test_complete_detail'] = $this->Tests_mdl->student_post_test_complete_detail($test_id,$dept_id);
					$this->data['student_post_test_incomplete_detail'] = $this->Tests_mdl->student_post_test_incomplete_detail($test_id,$dept_id);
				}
				$this->data['student_test_complete_detail'] = $this->Tests_mdl->student_test_complete_detail($test_id,$dept_id);
				$this->data['student_test_incomplete_detail'] = $this->Tests_mdl->student_test_incomplete_detail($test_id,$dept_id);
				
				
				$this->data['learning_outcomes_listing_question_present'] = $this->Tests_mdl->learning_outcomes_listing_question_present($test_id);
				$this->data['test_id'] = $test_id;
				$this->data['drap_drop_js'] = 1;
				if(isset($_GET['auth_code']) && $_GET['auth_code']!=''){
					$this->data['test_auth_code_detail'] = $this->Tests_mdl->test_auth_code_detail($_GET['auth_code']);
				}
				
				if(isset($_GET['plos_id']) && $_GET['plos_id']!=''){
					$this->data['test_plos_questions_listing'] = $this->Tests_mdl->test_plos_questions_listing($test_id,$_GET['plos_id']);
				}
				
				$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
				$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
				$this->load->view('Frontend/includes/header',$this->data);
				$this->load->view('Frontend/create/tests/management',$this->data);
				$this->load->view('Frontend/includes/footer',$this->data);
			
			}else{
				redirect(base_url().'department/create/tests');
			}
			 	
		}else{
			redirect(base_url().'department/create/tests');
		}		
	}

	public function demography_add(){
		$last = $this->uri->total_segments();
		$test_id = $this->uri->segment($last);
		$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($test_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/tests/demography_add',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function get_default_demography_question_choice(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/tests/demography_default_choices',$this->ajax_data);
		}
	}
	
	public function get_demography_action_html_of_answer(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/tests/demography_anser_actions',$this->ajax_data);
		}
	}
	
	public function demography_question_save(){
		$test_id = $this->input->post('hidden_test_id');
		$dept_id = $this->session->userdata('dept_id');
		if(isset($test_id) && $test_id!=''){
			$this->Tests_mdl->demography_question_save($test_id,$dept_id);
		}
		redirect(base_url().'department/create/tests/management?test_id='.$test_id.'&dept_id='.$dept_id);
	}	
	
	public function add_question(){
		$last = $this->uri->total_segments();
		$test_id = $this->uri->segment($last);
		$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($test_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/tests/add_question',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	

	public function question_save(){
		$test_id = $this->input->post('hidden_test_id');
		$dept_id = $this->session->userdata('dept_id');
		if(isset($test_id) && $test_id!=''){
			$this->Tests_mdl->question_save($test_id,$dept_id);
		}
	}	

	public function save_criterion_option(){
		$this->Tests_mdl->save_criterion_option();
	}

	public function set_order_questions(){
		$this->Tests_mdl->set_order_questions();
	}

	public function question_description(){
		if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			$this->data['tests_question_details'] = $this->Tests_mdl->get_tests_question_details($_GET['test_id'],$_GET['question_id']);
			$question_type = $this->data['tests_question_details']->question_type;
		

			if(isset($question_type) && $question_type==1){
				$this->data['tests_question_ansers_details'] = $this->Master_helper_mdl->get_choics_of_multiple_type_question_tests($_GET['question_id']);
			}
 			$this->load->view('Frontend/create/tests/test_question_description',$this->data);
		}
	}


	public function edit_question(){ 
		$last = $this->uri->total_segments();
		$question_id = $this->uri->segment($last);
		$this->data['tests_questions_fulldetails'] = $this->Tests_mdl->get_tests_questions_fulldetails($question_id);		
		$test_id = $this->data['tests_questions_fulldetails']->test_id;
		$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
		$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
	
		$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($test_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/tests/edit_question',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 		
	}	
	
	
	public function edit_demography_question(){ 
		$last = $this->uri->total_segments();
		$question_id = $this->uri->segment($last);
		$this->data['tests_questions_fulldetails'] = $this->Tests_mdl->get_tests_questions_fulldetails($question_id);		
		$test_id = $this->data['tests_questions_fulldetails']->test_id;
		$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
		$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
	
		$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($test_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/tests/edit_question_dempgraphy',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 		
	}
				

	public function update_question_entry(){
		$this->Tests_mdl->update_question_entry();
	}	

	public function delete_question_choice(){
		if(isset($_GET['answer_id']) && $_GET['answer_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			
			$this->data['tests_questions_fulldetails'] = $this->Tests_mdl->get_tests_questions_fulldetails($_GET['question_id']);
			$correct_answer = $this->data['tests_questions_fulldetails']->correct_answer;
			$this->Tests_mdl->delete_question_choice($_GET['answer_id'],$_GET['question_id'],$_GET['question_type'],$correct_answer);
		}
 	} 	 	 	

 	public function delete_test_question(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['test_id']) && $_GET['test_id']!=''){
			$this->Tests_mdl->delete_test_question($_GET['question_id'],$_GET['test_id']);
		}
 	}		

	public function get_default_question_choice(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			$this->ajax_data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
			$this->ajax_data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
			return $this->load->view('Frontend/create/tests/default_choices',$this->ajax_data);
		}
	}

	public function get_action_html_of_answer(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/tests/anser_actions',$this->ajax_data);
		}
	}

	public function add_test_deadline(){
		$this->Tests_mdl->add_test_deadline();
	}	

	public function add_course(){
		$this->Tests_mdl->add_course();
	}	

	public function delete_course(){
		if(isset($_GET['id']) && $_GET['id']!='' || isset($_GET['test_id']) && $_GET['test_id']!=''){
			$this->Tests_mdl->delete_course($_GET['id'], $_GET['test_id']);
		}
	}

	public function compose_email(){
		if(isset($_GET['test_id']) && $_GET['test_id']!=''){
			$test_id = $_GET['test_id'];
			$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($test_id); 
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/create/tests/management',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 
		}else{
			redirect(base_url().'department/create/tests');	
		}
	}

	public function save_email(){
		if(isset($_POST['h_test_id']) && $_POST['h_test_id']!=''){
			$this->data['test_details'] = $this->Tests_mdl->test_details_by_id($_POST['h_test_id']);
			
			$test_link = base_url().'test/'.$this->data['test_details']->test_code;
			//echo '<pre>';print_r($this->data['test_details']);die;
			$this->Tests_mdl->save_email($test_link);
		}
	}	

}