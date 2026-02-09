<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_links extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
	 
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='faculty_links_menu';
		 
 	}
	
	
	//////////////////////////////////// faculty_hiring_history //////////////////////////////////////
	
	public function faculty_hiring_history(){
 		 
		$this->data['title']='Faculty Hiring History | Administrator Panel';
  		$this->data['page_title']='Faculty Hiring History';
 		
		$this->data['faculty_directory_list'] = $this->Faculty_links_mdl->faculty_directory_list();
		
		if(isset($_GET['id']) && $_GET['id']!=''){
		
			$faculty_id=$_GET['id'];
			$this->data['faculty_details'] = $this->Faculty_links_mdl->faculty_directory_full_details($faculty_id); 
			$this->data['faculty_hiring_history_details'] = $this->Faculty_hiring_history_mdl->faculty_hiring_history_details($faculty_id);
			$this->data['faculty_hiring_history_record'] = $this->Faculty_hiring_history_mdl->faculty_hiring_history_record($faculty_id);
			$this->data['faculty_data_status'] = 1;
			
		}else{
 			$this->data['faculty_data_status'] = 0;
		}
		$this->load->view('Backend/includes/header',$this->data); 
		$this->load->view('Backend/faculty_links/faculty_hiring_history/view',$this->data);
		$this->load->view('Backend/includes/footer');
		
	}
	
	public function edit_faculty_history_details(){
	
		$last = $this->uri->total_segments();
		$faculty_id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('FAC_ID','FAC ID','required');
		$this->form_validation->set_rules('Job_Code','Job Code','required');
 		
		if($this->form_validation->run() == FALSE){ 
		
			$this->form_validation->set_error_delimiters('<p class="error1">', '</p>'); 
			$this->data['title']='Faculty Hiring History | Administrator Panel';
			$this->data['page_title']='Faculty Hiring History :: Edit';
			$this->data['faculty_hiring_history_details'] = $this->Faculty_hiring_history_mdl->faculty_hiring_history_details($faculty_id);
			$this->data['faculty_details'] = $this->Faculty_links_mdl->faculty_directory_full_details($faculty_id); 
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_hiring_history/edit_details',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Faculty_hiring_history_mdl->edit_faculty_history_details($faculty_id);
			redirect(base_url()."faculty_links/faculty_hiring_history?id=".$faculty_id);
		}
		
	}
	
	public function add_faculty_history(){
	
		$last = $this->uri->total_segments();
		$faculty_id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('term','semester','required');
		$this->form_validation->set_rules('year','year','required');
 		
		if($this->form_validation->run() == FALSE){ 
		
			$this->form_validation->set_error_delimiters('<p class="error1">', '</p>'); 
			$this->data['title']='Faculty Hiring History | Administrator Panel';
			$this->data['page_title']='Faculty Hiring History :: Add';
			$this->data['faculty_details'] = $this->Faculty_links_mdl->faculty_directory_full_details($faculty_id); 
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_hiring_history/add',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Faculty_hiring_history_mdl->add_faculty_hiring_history($faculty_id);
			redirect(base_url()."faculty_links/faculty_hiring_history?id=".$faculty_id);
		}
		
	}
	
	
	public function edit_faculty_history_record(){
	
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		$this->data['faculty_hiring_history_record'] = $this->Faculty_hiring_history_mdl->faculty_hiring_history_record_full_details($id);
		$faculty_id=$this->data['faculty_hiring_history_record']->faculty_id;
		
		$this->form_validation->set_rules('term','semester','required');
		$this->form_validation->set_rules('year','year','required');
 		
		if($this->form_validation->run() == FALSE){ 
		
			$this->form_validation->set_error_delimiters('<p class="error1">', '</p>'); 
			$this->data['title']='Faculty Hiring History | Administrator Panel';
			$this->data['page_title']='Faculty Hiring History :: Add';
			
			$this->data['faculty_details'] = $this->Faculty_links_mdl->faculty_directory_full_details($faculty_id); 
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_hiring_history/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
			
			$this->Faculty_hiring_history_mdl->edit_faculty_history_record($id);
			redirect(base_url()."faculty_links/faculty_hiring_history?id=".$faculty_id);
		}
		
	}
	
	public function faculty_history_record_delete(){
	
		$this->Faculty_hiring_history_mdl->faculty_history_record_delete($_GET['id']);
		 
 			
	}
	
	///////////////////////// my_syllabi ////////////////////////////////////////////////////
	
	public function faculty_details(){
	
		if(isset($_GET['term']) && $_GET['term']!='' && isset($_GET['year']) && $_GET['year']!=''){
			$_SESSION['faculty_syllabi_grades_semester_sa'] = $_GET['term'];
			$_SESSION['faculty_syllabi_grades_year_sa'] = $_GET['year'];
 		}
		
		$this->data['title']='Details | Administrator Panel';
  		$this->data['page_title']='Details';
		
		if(isset($_GET['id']) && $_GET['id']!=''){
		
			if(isset($_SESSION['faculty_syllabi_grades_semester_sa']) && $_SESSION['faculty_syllabi_grades_semester_sa']!='' && isset($_SESSION['faculty_syllabi_grades_year_sa']) && $_SESSION['faculty_syllabi_grades_year_sa']!=''){
				
			$this->data['my_syllabi'] = $this->Faculty_document_mdl->my_syllabi_list($_GET['id'],$_SESSION['faculty_syllabi_grades_semester_sa'],$_SESSION['faculty_syllabi_grades_year_sa']);
			
			$this->data['my_grades'] = $this->Faculty_document_mdl->my_grades_list($_GET['id'],$_SESSION['faculty_syllabi_grades_semester_sa'],$_SESSION['faculty_syllabi_grades_year_sa']);
			
			$this->data['my_availability_1'] = $this->Faculty_links_mdl->my_availability_list($_GET['id'],$_SESSION['faculty_syllabi_grades_semester_sa'],$_SESSION['faculty_syllabi_grades_year_sa'],'1');
				
			$this->data['my_availability_2'] = $this->Faculty_links_mdl->my_availability_list($_GET['id'],$_SESSION['faculty_syllabi_grades_semester_sa'],$_SESSION['faculty_syllabi_grades_year_sa'],'2');
			
			$this->data['my_availability_3'] = $this->Faculty_links_mdl->my_availability_list($_GET['id'],$_SESSION['faculty_syllabi_grades_semester_sa'],$_SESSION['faculty_syllabi_grades_year_sa'],'3');
			
			$this->data['value_status']=1;
				
			}else{
				$this->data['value_status']=0;
			}
			
			$this->data['faculty_courses_teach'] = $this->Faculty_links_mdl->faculty_courses_teach($_GET['id']);
		
		}
		
		$this->data['faculty_directory_list'] = $this->Faculty_links_mdl->faculty_directory_list();

		$this->load->view('Backend/includes/header',$this->data); 
		$this->load->view('Backend/faculty_links/faculty_directory/details/view',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function delete_my_syllabi(){
	
		$this->Faculty_document_mdl->delete_my_syllabi($_GET['id']);
		redirect(base_url()."faculty_links/faculty_details");
			
	} 
	
	public function delete_my_grades(){
	
		$this->Faculty_document_mdl->delete_my_grades($_GET['id']);
		redirect(base_url()."faculty_links/faculty_details?tab_id=2");
			
	}
	
	public function delete_my_availability(){
	
		$this->Faculty_links_mdl->delete_my_availability($_GET['id']);
		redirect(base_url()."faculty_links/faculty_details?tab_id=3");
			
	}
	
	public function approve_faculty_coures(){
	
		$this->Faculty_links_mdl->approve_faculty_coures();
	}	
	 
	//////////////////////// Faculty Notifications //////////////////////////////////////////
	
	
	public function evaluation_notification_status(){
		
		$this->Faculty_links_mdl->evaluation_notification_status();
		redirect("faculty_links/evaluation_notification");
	}
	
	public function evaluation_notification(){
		
		$this->Faculty_links_mdl->new_faculty_evaluation_update();
		$this->data['title']='Faculty Notifications | Administrator Panel';
  		$this->data['page_title']='Evaluation Faculty Notifications';
		$this->data['sub_active_class']='faculty_links_notification_menu';
		$this->data['faculty_directory_list'] = $this->Faculty_links_mdl->evaluation_faculty_directory_list();
		$this->load->view('Backend/includes/header',$this->data); 
		$this->load->view('Backend/faculty_links/faculty_directory/evaluation_notification',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit_evaluation_faculty_directory(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('email','Email','required');
		
		$rank_validation = $this->input->post('rank');
		
		if($rank_validation==1 || $rank_validation==5 || $rank_validation==11){
			if($rank_validation==1 || $rank_validation==5){
				$this->form_validation->set_rules('number_of_years_previously_taught','Number of years previously taught','required');
			}
			$this->form_validation->set_rules('class_visit_date','Date class visit completed','required');
			 
		}  
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->form_validation->set_error_delimiters('<p class="error1">', '</p>'); 
			$this->data['title']='Faculty Directory Listing | Administrator Panel'; 
			$this->data['page_title']='Evaluation Faculty Directory :: Edit';
			$this->data['sub_active_class']='faculty_links_notification_menu';
			
			$this->data['course_list'] = $this->Curriculum_dev_mdl->course_list();
			$this->data['faculty_directory'] = $this->Faculty_links_mdl->faculty_directory_full_details($id); 
			$this->data['evaluation_faculty_directory'] = $this->Faculty_links_mdl->evaluation_faculty_directory_full_details($id); 
			
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_directory/edit_evaluation',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Faculty_links_mdl->edit_faculty_directory($id);
			$this->Faculty_links_mdl->edit_evaluation_faculty_directory($id);
			redirect('faculty_links/evaluation_notification');
		}
			
 	}
	
	
	public function etn_notification_status(){
		
		$this->Faculty_links_mdl->etn_notification_status();
		redirect("faculty_links/entitlement_notification");
	}
	
	
	public function entitlement_notification(){
		
		$this->Faculty_links_mdl->new_faculty_entitlement_update();
		$this->data['title']='Faculty Notifications | Administrator Panel';
  		$this->data['page_title']='Entitlement Faculty Notifications';
		$this->data['sub_active_class']='faculty_links_notification_menu';
		$this->data['faculty_directory_list'] = $this->Faculty_links_mdl->entitlement_faculty_directory_list();
		$this->load->view('Backend/includes/header',$this->data); 
		$this->load->view('Backend/faculty_links/faculty_directory/entitlement_notification',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit_entitlement_faculty_directory(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('email','Email','required');
		
		$entitlement_validation = $this->input->post('entitlement');
		$rank = $this->input->post('rank');
		
		if($entitlement_validation==1 || $entitlement_validation==2){
			$this->form_validation->set_rules('entitlement_number_no','entitlement year','required');
			$this->form_validation->set_rules('entitlement_year','Year','required');
			$this->form_validation->set_rules('entitlement_semester','Semester','required'); 
			$this->form_validation->set_rules('entitlement_course_accepted','Course Accepted','required'); 
		} else if(($entitlement_validation==5 && $rank==2) || ($entitlement_validation==4  && $rank==3)){
			$this->form_validation->set_rules('number_of_years_toward_next_level','Number of years toward next level','required');
			$this->form_validation->set_rules('year_previously_taught','Year previously taught','required'); 
		}   
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->form_validation->set_error_delimiters('<p class="error1">', '</p>'); 
			$this->data['title']='Faculty Directory Listing | Administrator Panel'; 
			$this->data['page_title']='Entitlement Faculty Directory :: Edit';
			$this->data['sub_active_class']='faculty_links_notification_menu';
			
			$this->data['course_list'] = $this->Curriculum_dev_mdl->course_list();
			$this->data['faculty_directory'] = $this->Faculty_links_mdl->faculty_directory_full_details($id); 
			$this->data['entitlement_faculty_directory'] = $this->Faculty_links_mdl->entitlement_faculty_directory_full_details($id); 
			
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_directory/edit_entitlement',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Faculty_links_mdl->edit_faculty_directory($id);
			$this->Faculty_links_mdl->edit_entitlement_faculty_directory($id);
			redirect('faculty_links/entitlement_notification');
		}
			
 	}
	
	
	public function send_notification_to_faculty(){
		
		$this->Faculty_links_mdl->send_notification_to_faculty();
		redirect("faculty_links/faculty_profiles");
	}
	
	//////////////////////// Faculty Directory Listing //////////////////////////////////////
	
	
	public function resend_invitation_to_faculty(){
		
		if($this->data['admin_type']=='super_admin'){
		
		  $username = $this->data['session_details']->superadmin_name;
		  $department_name = $this->data['session_details']->department_name;
		  
		}else{
		
		  $username = $this->data['session_details']->first_name.' '.$this->data['session_details']->last_name;
		  $department_name = $this->data['session_details']->department_unit;
		  
		}
		
		$this->Faculty_links_mdl->resend_invitation_to_faculty($username,$department_name);
		redirect("faculty_links/faculty_directory_listing");
	}
	
	public function send_password_link_to_faculty(){
		
		if($this->data['admin_type']=='super_admin'){
		
		  $username = $this->data['session_details']->superadmin_name;
		  $department_name = $this->data['session_details']->department_name;
		  
		}else{
		
		  $username = $this->data['session_details']->first_name.' '.$this->data['session_details']->last_name;
		  $department_name = $this->data['session_details']->department_unit;
		  
		}
		
		$this->Faculty_links_mdl->send_password_link_to_faculty($username,$department_name);
		redirect("faculty_links/faculty_directory_listing");
	}
	
	
	
	public function faculty_directory_listing(){
		
		$this->data['title']='Faculty Directory Listing | Administrator Panel';
  		$this->data['page_title']='Faculty Directory Listing';
		$this->data['faculty_directory_list'] = $this->Faculty_links_mdl->faculty_directory_list();
		$this->load->view('Backend/includes/header',$this->data); 
		$this->load->view('Backend/faculty_links/faculty_directory/list',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function download_faculty_directory(){
		
		if(isset($_GET['term']) && $_GET['term']){
			$term = $_GET['term'];
		}else{
			$term ='';
		}
		
		if(isset($_GET['year']) && $_GET['year']){
			$year = $_GET['year'];
		}else{
			$year ='';
		}
		
		$this->Download_faculty_directory_mdl->download_faculty_directory($year,$term);
		
	}
	
	public function faculty_directory_delete(){
		
		$this->Faculty_links_mdl->faculty_directory_delete($_GET['id']);
		redirect("faculty_links/faculty_directory_listing");
	}
	
	
	public function add_faculty_directory(){
		 
 		$this->form_validation->set_rules('email','Email','required');   
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['title']='Faculty Directory Listing | Administrator Panel'; 
			$this->data['page_title']='Faculty Directory Listing :: Add';
 			
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_directory/add',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Faculty_links_mdl->add_faculty_directory();
			redirect('faculty_links/faculty_directory_listing');
		}
			
 	}
	
	public function edit_faculty_directory(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('email','Email','required');   
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['title']='Faculty Directory Listing | Administrator Panel'; 
			$this->data['page_title']='Faculty Directory Listing :: Edit';
			
			$this->data['faculty_directory'] = $this->Faculty_links_mdl->faculty_directory_full_details($id); 
			
			$this->load->view('Backend/includes/header',$this->data); 
			$this->load->view('Backend/faculty_links/faculty_directory/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Faculty_links_mdl->edit_faculty_directory($id);
			redirect('faculty_links/faculty_directory_listing');
		}
			
 	}
	
	///////////////////////////////// Faculty Profile //////////////////////////////////////
	
	public function faculty_profiles(){
		
		$this->data['title']='Faculty Profile | Administrator Panel';
  		$this->data['page_title']='Faculty Profiles';
		$this->data['faculty_directory_status_list'] = $this->Faculty_links_mdl->faculty_directory_status_list();
		$this->load->view('Backend/includes/header',$this->data); 
		$this->load->view('Backend/faculty_links/faculty_directory/profiles',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
}