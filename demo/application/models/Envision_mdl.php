<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envision_mdl extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}
	
	public function import_data_proposed_soc(){
	
		$dept_id = $this->session->userdata('dept_id');	
 		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('temp_import_table');
		$result = $query->result();
		foreach($result as $temp_import_table){
			
			$undergraduate_pslos = trim($temp_import_table->col_1);
			$undergraduate_pslos_title = trim($temp_import_table->col_2);
			$this->db->where('pslos_status', '0');
			$this->db->where('department_id', $dept_id);
			$this->db->where('plso_title', $undergraduate_pslos);
			$query_department_pslos = $this->db->get('department_pslos');
			$num_undergraduate_pslos = $query_department_pslos->num_rows();
			if($num_undergraduate_pslos == 0 && isset($undergraduate_pslos) && $undergraduate_pslos!=''){				
				$uinsert_data=array('department_id'=>$dept_id, 'pslos_status'=>'0', 'plso_prefix'=>$undergraduate_pslos, 'plso_title'=>$undergraduate_pslos_title, 'add_date'=>time());
				$this->db->insert('department_pslos',$uinsert_data);				
			}
			
			$graduate_pslos = trim($temp_import_table->col_3);
			$graduate_pslos_title = trim($temp_import_table->col_4);
			$this->db->where('pslos_status', '1');
			$this->db->where('department_id', $dept_id);
			$this->db->where('plso_title', $graduate_pslos);
			$query_gdepartment_pslos = $this->db->get('department_pslos');
			$num_graduate_pslos = $query_gdepartment_pslos->num_rows();
			if($num_graduate_pslos == 0 && isset($graduate_pslos) && $graduate_pslos!=''){				
				$ginsert_data=array('department_id'=>$dept_id, 'pslos_status'=>'1', 'plso_prefix'=>$graduate_pslos, 'plso_title'=>$graduate_pslos_title, 'add_date'=>time());
				$this->db->insert('department_pslos',$ginsert_data);				
			}		
		}
		
	}
	
	public function department_checklist_detail_row(){
 		//$this->db->order_by('id', 'desc');
 		$dept_id = $this->session->userdata('dept_id');	
 		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('department_checklist_detail');
		return $query->row();
	}

	
	public function envision_save_action1(){
		$dept_id = $this->session->userdata('dept_id');		
	 	$mission = $this->input->post('mission');
	 	$vision = $this->input->post('vision');
	 	$program_goals = $this->input->post('program_goals');
 		$envision_step1_overview = $this->input->post('envision_step1_overview');
	 	
	 	if(isset($mission)&& $mission!=''){
	 		$mission_statement = $mission;
	 	}else{
			$mission_statement = '';
		}	 	
		
		if(isset($vision)&& $vision!=''){
	 		$vision_statement = $vision;
	 	}else{
			$vision_statement = '';
		}		
		
		if(isset($program_goals)&& $program_goals!=''){
	 		$program_goals_statement = $program_goals;
	 	}else{
			$program_goals_statement = '';
		}
		
		if(isset($envision_step1_overview)&& $envision_step1_overview!=''){
	 		$envision_step1_overview = $envision_step1_overview;
	 	}else{
			$envision_step1_overview = '';
		}
	 	
	 	$this->db->where('department_id', $dept_id);
	 	$query = $this->db->get('department_checklist_detail');
		$num = $query->num_rows();
		if($num == 0){
			
			$insert_data=array('department_id'=>$dept_id, 'mission_statement'=>$mission, 
				'vision_statement'=>$vision, 'program_goals'=>$program_goals, 'envision_action1_overview'=>$envision_step1_overview, 'add_date'=>time());
			$this->db->insert('department_checklist_detail',$insert_data);
		}else{ 
						
			$insert_data=array('mission_statement'=>$mission, 
				'vision_statement'=>$vision, 'program_goals'=>$program_goals, 'envision_action1_overview'=>$envision_step1_overview);
			$this->db->where('department_id', $dept_id);
			$this->db->update('department_checklist_detail',$insert_data); 		
		}
	}
	
	
	public function envision_save_action2(){
		$dept_id = $this->session->userdata('dept_id');		
	 	$envision_action2_overview = $this->input->post('envision_action2_overview');
	 	
	 	if(isset($envision_action2_overview)&& $envision_action2_overview!=''){
	 		$envision_action2_overview = $envision_action2_overview;
	 	}else{
			$envision_action2_overview = '';
		} 	
	 	
	 	$this->db->where('department_id', $dept_id);
	 	$query = $this->db->get('department_checklist_detail');
		$num = $query->num_rows();
		if($num == 0){
			
			$insert_data=array('department_id'=>$dept_id, 'envision_action2_overview'=>$envision_action2_overview, 'add_date'=>time());
			$this->db->insert('department_checklist_detail',$insert_data);
		}else{ 
						
			$insert_data=array('envision_action2_overview'=>$envision_action2_overview);
			$this->db->where('department_id', $dept_id);
			$this->db->update('department_checklist_detail',$insert_data); 		
		}
	}


// =====----- Department_course -----=====//


	public function department_pslos_by_id($id){
		$this->db->where('id', $id);
		$query = $this->db->get('department_pslos');
		$row = $query->row();
		return $row->course_title;
	}	
	
	public function department_pslos_undergraduate(){
		$dept_id = $this->session->userdata('dept_id');	
		$this->db->where('department_id', $dept_id);
		$this->db->where('pslos_status', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('department_pslos');
		return $query->result();
	}	
	
	public function department_pslos_graduate(){
		$dept_id = $this->session->userdata('dept_id');	
		$this->db->where('department_id', $dept_id);
		$this->db->where('pslos_status', '1');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('department_pslos');
		return $query->result();
	}
	
	public function program_learning_outcomes(){
		$dept_id = $this->session->userdata('dept_id');	
		$this->db->where('department_id', $dept_id);
		$this->db->where('pslos_status', '2');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('department_pslos');
		return $query->result();
	}
	
	public function save_department_pslos(){
	
		$dept_id = $this->session->userdata('dept_id');
		$plso_prefix = $this->input->post('txt_add_plso_prefix');		
		$plso_title = $this->input->post('txt_add_plso_title');
	 	$pslos_status = $this->input->post('hadd_pslos_status');	 	 	

		$insert_data=array('department_id'=>$dept_id, 'pslos_status'=>$pslos_status, 'plso_prefix'=>$plso_prefix,  'plso_title'=>$plso_title, 'add_date'=>time());
		$this->db->insert('department_pslos',$insert_data);
		$this->session->set_flashdata('success', 'Added Successfully!');
		if($pslos_status==0){	
			redirect('department/envision/action2?tab_id=3');
		}else if($pslos_status==2){
			redirect('department/envision/action2?tab_id=5');
		}else{
			redirect('department/envision/action2?tab_id=4');
		}
	}	
	
	
	public function edit_ugrad_grad_plso_entry(){	
		
		$pslos_status = $this->input->post('hedit_pslos_status');
		$plso_prefix = trim($this->input->post('txt_edit_plso_prefix'));
	 	$plso_title = trim($this->input->post('txt_edit_plso_title'));
		
		$id = $this->input->post('hupdate_id');

		$arr = array('plso_title'=>$plso_title,'plso_prefix'=>$plso_prefix);
		$this->db->where('id', $id);
		$this->db->update('department_pslos',$arr);
		$this->session->set_flashdata('success', 'Updated Successfully!');
		if($pslos_status==0){	
			redirect('department/envision/action2?tab_id=3');
		}else if($pslos_status==2){
			redirect('department/envision/action2?tab_id=5');
		}else{
			redirect('department/envision/action2?tab_id=4');
		}	
	}
	
	
	public function department_pslos_delete($id){
		$this->db->delete('department_pslos',array('id'=>$id));
		$this->session->set_flashdata('success', 'Deleted Successfully!');	
		if(isset($_GET['status']) && $_GET['status']==0){	
			redirect('department/envision/action2?tab_id=3');			
		}else if(isset($_GET['status']) && $_GET['status']==2){
			redirect('department/envision/action2?tab_id=5');
		}else{
			redirect('department/envision/action2?tab_id=4');
		} 
	}	
	
	
	public function assign_core_competency(){
		$dept_id = $this->session->userdata('dept_id');	
		$course_status = $this->input->post('course_status');
		$department_pslos_id = $this->input->post('department_pslos_id');
		$core_competency_id = $this->input->post('core_competency_id');
		//print_r($core_competency_id);die;
		$commaSeparated_id = implode(',' , $core_competency_id);
		$add_date = time();

			$this->db->where('department_id', $dept_id);
			$this->db->where('department_pslos_id', $department_pslos_id);
			$query = $this->db->get('department_assign_core_competency');
			$num_row = $query->num_rows();
			
		if($num_row==0){
			$arr = array('department_id'=>$dept_id, 'department_pslos_id'=>$department_pslos_id, 
				'core_competency_id'=>$commaSeparated_id, 'add_date'=>$add_date);
			$this->db->insert('department_assign_core_competency', $arr); 
		}else{
			$arr = array('core_competency_id'=>$commaSeparated_id);
			$this->db->where('department_id', $dept_id);
			$this->db->where('department_pslos_id', $department_pslos_id);
			$this->db->update('department_assign_core_competency', $arr); 
		}	
		
		$this->session->set_flashdata('success', 'Save Successfully!');	
		if($course_status==0){	
			redirect('department/envision/action3');
		}else if($course_status==1){	
			redirect('department/envision/action3?tab_id=2');
		}else{
			redirect('department/envision/action3?tab_id=3');
		}
	}


	
		
}