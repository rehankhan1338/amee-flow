<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Design_mdl extends CI_Model {
	/**
	 * Constructor
	 *
	 * @access	public
	 */  
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}
	
	public function department_aligment_matrix_courses_result_undergraduate(){	
  		$dbprefix = trim($this->db->dbprefix);		
		$dept_id = $this->session->userdata('dept_id');			
		$where = ' id in(select course_id from '.$dbprefix.'department_allignment_matrix)';		
  		$this->db->where('department_id', $dept_id);
  		$this->db->where('course_status', '0');
		$this->db->where($where);
		$this->db->order_by('course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result();
	}
	
	
	public function get_plsos_details_from_year_id($department_id,$rotation_plan_status,$academic_year,$auto_manual_rotataion_plan){ 		
		$dbprefix = trim($this->db->dbprefix);
		if($auto_manual_rotataion_plan==1){
 			$table_name_part = 'automatic';
		}else{
			$table_name_part = 'manual';
 		}
		$query = $this->db->query('select plso_id from '.$dbprefix.'department_'.$table_name_part.'_rotation_plan where department_id="'.$department_id.'" and rotation_plan_status="'.$rotation_plan_status.'" and id in (select manual_id from '.$dbprefix.'department_'.$table_name_part.'_rotation_plan_academic_courses where academic_year="'.$academic_year.'")');
		return $query->result();
	}
	
	public function get_courses_details_from_year_id($department_id,$rotation_plan_status,$academic_year,$auto_manual_rotataion_plan){
 		
		if($auto_manual_rotataion_plan==1){
 			$table_name_part = 'automatic';
		}else{
			$table_name_part = 'manual';
 		}
		
		$dbprefix = trim($this->db->dbprefix);
		
		$query = $this->db->query('select course_id from '.$dbprefix.'department_'.$table_name_part.'_rotation_plan_academic_courses where academic_year="'.$academic_year.'" and manual_id in (select id from '.$dbprefix.'department_'.$table_name_part.'_rotation_plan where department_id="'.$department_id.'" and rotation_plan_status="'.$rotation_plan_status.'")');
		return $query->result();
	}
	
	public function manage_rotation_plan_status($rotation_plan_status,$underg_grad_status){
	
		$dept_id = $this->session->userdata('dept_id');
		
		if($underg_grad_status==0){
		
			$undergraduate_status_value = $this->config->item('con_undergraduate_status_value');
 			$undergraduate_rotation_plan_status = get_rotation_plan_status_h($this->session->userdata('dept_id'),$undergraduate_status_value);
			if($rotation_plan_status==1){
				$this->Design_mdl->update_undergraduate_automatic_rotation_plan();
			}			
			
			$update_data=array('undergraduate_rotation_plan_status'=>$rotation_plan_status);
			
		}else if($underg_grad_status==1){
		
			$graduate_status_value = $this->config->item('con_graduate_status_value');
			$graduate_rotation_plan_status = get_rotation_plan_status_h($this->session->userdata('dept_id'),$graduate_status_value);
			if($rotation_plan_status==1){
				//echo 'still working on it';die;
				$this->Design_mdl->update_graduate_automatic_rotation_plan();
			}
			
			$update_data=array('graduate_rotation_plan_status'=>$rotation_plan_status);
			
		}else{
		
			$program_status_value = $this->config->item('con_program_status_value');
			$graduate_rotation_plan_status = get_rotation_plan_status_h($this->session->userdata('dept_id'),$program_status_value);
			if($rotation_plan_status==1){
				$this->Design_mdl->update_program_automatic_rotation_plan();
			}			
			$update_data=array('program_rotation_plan_status'=>$rotation_plan_status);
			
		}
		
		$this->db->where('department_id', $dept_id);
		$this->db->update('department_checklist_detail',$update_data); 		
		$this->session->set_flashdata('success', 'Update Successfully!');	
		
	}
	
	public function get_rotation_plan_year($dept_id){
	
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('department_checklist_detail');
		$row = $query->row();
		$num = $query->num_rows();
		if($num>0){
 			return $row->rotation_plan_year;	
		}
		
	}
	
	public function change_rotation_plan_year($year){
	
		$dept_id = $this->session->userdata('dept_id');
		$update_data=array('rotation_plan_year'=>$year);
		$this->db->where('department_id', $dept_id);
		$this->db->update('department_checklist_detail',$update_data); 		
		$this->session->set_flashdata('success', 'Update Successfully!');	
		
	}
	
	public function get_plsos_name_from_plso_id($plso_id){
		
		$this->db->where('id', $plso_id);
	 	$query = $this->db->get('department_pslos');
		$row = $query->row();
 		return $row->plso_prefix;
	}
	
	public function get_course_name_from_course_id($course_id){
		
		$this->db->where('id', $course_id);
	 	$query = $this->db->get('department_courses');
		$num = $query->num_rows();
		if($num>0){
			$row1 = $query->row();
			if($row1->course_number>0){
 				$course_data = $row1->course_prefix.' '.$row1->course_number;
			}else{
				$course_data = $row1->course_prefix;
			}
		}else{
			$course_data = '';
		}
		return $course_data;
	}
	
	public function get_rotation_plan_status($department_id,$underg_grad_status){
		
		$this->db->where('department_id', $department_id);
	 	$query = $this->db->get('department_checklist_detail');
		$row = $query->row();
		$num = $query->num_rows();
		if($num>0){
		if($underg_grad_status==0){
			$status_value = $row->undergraduate_rotation_plan_status;
		}else if($underg_grad_status==1){
			$status_value = $row->graduate_rotation_plan_status;
		}else{
			$status_value = $row->program_rotation_plan_status;
		}
		return $status_value;
		}
	}
	
	public function design_save_action1(){
		$dept_id = $this->session->userdata('dept_id');		
	 	$design_action1_overview = $this->input->post('design_action1_overview');
	 	
	 	$this->db->where('department_id', $dept_id);
	 	$query = $this->db->get('department_checklist_detail');
		$num = $query->num_rows();
		if($num==0){
			$insert_data=array('department_id'=>$dept_id, 'design_action1_overview'=>$design_action1_overview, 'add_date'=>time());
			$this->db->insert('department_checklist_detail',$insert_data);
			$this->session->set_flashdata('success', 'Save Successfully!');	
		}else{
			$insert_data=array('design_action1_overview'=>$design_action1_overview);
			$this->db->where('department_id', $dept_id);
			$this->db->update('department_checklist_detail',$insert_data); 		
			$this->session->set_flashdata('success', 'Update Successfully!');	
		}
		
	}	
	
	
	function team_members_detail_group_by(){
 		$dept_id = $this->session->userdata('dept_id');
 		$this->db->where('department_id', $dept_id);
 		$this->db->group_by('team_id');
		$this->db->where('status', '0');
		$query = $this->db->get('department_team_members');
		return $query->result();
	} 
	
	
	function add_team_members() {	
		$dept_id = $this->session->userdata('dept_id');
		$team_id = $this->input->post('team_id');
		$add_date = time();

		if(isset($_POST['name']) && $_POST['name']!=''){
			for($i=0;$i<count($_POST['name']); $i++){
				$names = $_POST['name'][$i];

				$arr = array('department_id'=>$dept_id, 'team_id'=>$team_id, 'name'=>$names, 'add_date'=>$add_date);
				$this->db->insert('department_team_members', $arr);
			}
		}
		$this->session->set_flashdata('success', 'Save Successfully!');
		redirect(base_url().'department/design/action2');
	}
	
	
	public function edit_team_members(){	
	 	$name = $this->input->post('name');
		$id = $this->input->post('hupdate_id');
	
		$arr = array('name'=>$name);
		$this->db->where('id', $id);
		$this->db->update('department_team_members',$arr);
		$this->session->set_flashdata('success', 'Updated Successfully!');
		redirect('department/design/action2'); 
	}	
	
	
	public function delete_members($id){
 		$this->db->where('id',$id); 
		$query = $this->db->delete('department_team_members');
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
	public function save_automatic_rotation_plan(){
 	
		$department_id = $this->session->userdata('dept_id');
		$rotation_plan_status = $this->input->post('hrotation_plan_status');
		$pslos_ids = $this->input->post('pslos_id');
		$academic_year_count = $this->config->item('rotation_year_plans');
		
		for($i=0;$i<count($pslos_ids);$i++){
			
			$pslos_id = $pslos_ids[$i];
			$team_id = $this->input->post('team_id'.$pslos_id);
			
			$this->db->where('department_id', $department_id);
			$this->db->where('plso_id', $pslos_id);
			$this->db->where('rotation_plan_status', $rotation_plan_status);
			$query = $this->db->get('department_automatic_rotation_plan');
			$num = $query->num_rows();
			if($num==0){
			
				$data_arr = array('department_id'=>$department_id, 'team_id'=>$team_id, 'plso_id'=>$pslos_id, 'rotation_plan_status'=>$rotation_plan_status);
				$this->db->insert('department_automatic_rotation_plan', $data_arr);
				$manual_id = $this->db->insert_id();				
 			
			}else{
			
				$row = $query->row();
				$manual_id=$row->id;
				$update_arr = array('team_id'=>$team_id);
				$this->db->where('id', $manual_id);
				$this->db->update('department_automatic_rotation_plan',$update_arr);
			}
			
			
		}
		
		$this->session->set_flashdata('success', 'Save & updated successfully!');
		if($rotation_plan_status==0){
			redirect(base_url().'department/design/action3'); 
		}else if($rotation_plan_status==1){
			redirect(base_url().'department/design/action3?tab_id=2');
		}else{
			redirect(base_url().'department/design/action3?tab_id=3');
		}
	}
	
	
	public function save_manual_rotation_plan(){
 	
		$department_id = $this->session->userdata('dept_id');
		$rotation_plan_status = $this->input->post('hrotation_plan_status');
		$pslos_ids = $this->input->post('pslos_id');
		$academic_year_count = $this->config->item('rotation_year_plans');
		
		for($i=0;$i<count($pslos_ids);$i++){
			
			$pslos_id = $pslos_ids[$i];
			$team_id = $this->input->post('team_id'.$pslos_id);
			
			$this->db->where('department_id', $department_id);
			$this->db->where('plso_id', $pslos_id);
			$this->db->where('rotation_plan_status', $rotation_plan_status);
			$query = $this->db->get('department_manual_rotation_plan');
			$num = $query->num_rows();
			if($num==0){
			
				$data_arr = array('department_id'=>$department_id, 'team_id'=>$team_id, 'plso_id'=>$pslos_id, 'rotation_plan_status'=>$rotation_plan_status);
				$this->db->insert('department_manual_rotation_plan', $data_arr);
				$manual_id = $this->db->insert_id();				
 			
			}else{
			
				$row = $query->row();
				$manual_id=$row->id;
				$update_arr = array('team_id'=>$team_id);
				$this->db->where('id', $manual_id);
				$this->db->update('department_manual_rotation_plan',$update_arr);
			}
			
			for($j=1;$j<=$academic_year_count;$j++){
			
				$academic_year = $j;
				$couses_ids = $this->input->post('couses_id'.$academic_year.$pslos_id);
				
				if(isset($couses_ids) && $couses_ids!='' && count($couses_ids)>0){
					$course_id = implode(',',$couses_ids);
				}else{
					$course_id = '';
				}
				
 					$this->db->where('manual_id', $manual_id);
					$this->db->where('academic_year', $academic_year);
					$query_1 = $this->db->get('department_manual_rotation_plan_academic_courses');
					$num1 = $query_1->num_rows();
					if($num1==0){
					
						if(isset($course_id) && $course_id!=''){
							$data_arr1 = array('manual_id'=>$manual_id, 'academic_year'=>$academic_year, 'course_id'=>$course_id);
							$this->db->insert('department_manual_rotation_plan_academic_courses', $data_arr1);
						}
						
					}else{
						$update_arr1 = array('course_id'=>$course_id);
						$this->db->where('manual_id', $manual_id);
						$this->db->where('academic_year', $academic_year);
						$this->db->update('department_manual_rotation_plan_academic_courses',$update_arr1);
					}
				
			}
				
			//echo '<hr>';
		}
		
		$this->session->set_flashdata('success', 'Save & updated successfully!');
		if($rotation_plan_status==0){
			redirect(base_url().'department/design/action3'); 
		}else if($rotation_plan_status==1){
			redirect(base_url().'department/design/action3?tab_id=2');
		}else{
			redirect(base_url().'department/design/action3?tab_id=3');
		}
	}
	
	public function get_maunal_rotation_plan_details_by_plso_id($undergraduate_status_value,$department_id,$plso_id){
		$this->db->where('department_id', $department_id);
		$this->db->where('rotation_plan_status', $undergraduate_status_value);
		$this->db->where('plso_id', $plso_id);
		$query = $this->db->get('department_manual_rotation_plan');
		return $query->row();	
	}
	
	public function get_maunal_rotation_plan_academic_details($manual_id,$academic_year){
		$this->db->where('manual_id', $manual_id);
		$this->db->where('academic_year', $academic_year);
		$query = $this->db->get('department_manual_rotation_plan_academic_courses');
		$num = $query->num_rows();
		if($num>0){
			$row=$query->row();
			$course_id = $row->course_id;
		}else{
			$course_id = '';
		}	
		return $course_id;		
	}
	
	public function get_automatic_rotation_plan_details_by_plso_id($undergraduate_status_value,$department_id,$plso_id){
		$this->db->where('department_id', $department_id);
		$this->db->where('rotation_plan_status', $undergraduate_status_value);
		$this->db->where('plso_id', $plso_id);
		$query = $this->db->get('department_automatic_rotation_plan');
		return $query->row();	
	}
	
	public function get_automatic_rotation_plan_academic_details($manual_id,$academic_year){
		$this->db->where('manual_id', $manual_id);
		$this->db->where('academic_year', $academic_year);
		$query = $this->db->get('department_automatic_rotation_plan_academic_courses');
		$num = $query->num_rows();
		if($num>0){
			$row=$query->row();
			$course_id = $row->course_id;
		}else{
			$course_id = '';
		}	
		return $course_id;		
	}
	
	
	public function update_undergraduate_automatic_rotation_plan(){
	
		$department_pslos_undergraduate = $this->Envision_mdl->department_pslos_undergraduate();
		//$department_pslos_graduate = $this->Envision_mdl->department_pslos_graduate(); 
		//$department_courses_result_undergraduate = $this->Coordinate_mdl->department_courses_result_undergraduate();
		//$department_courses_result_graduate = $this->Coordinate_mdl->department_courses_result_graduate();
		//$rotation_plan_start_year = $this->Design_mdl->get_rotation_plan_year($this->session->userdata('dept_id')); 
		$rotation_plan_count = $this->config->item('rotation_year_plans');
		
		$department_id = $this->session->userdata('dept_id');

		$undergraduate_status_value = $this->config->item('con_undergraduate_status_value');
		//$graduate_status_value = $this->config->item('con_graduate_status_value');
		
		//$upslo_no_count = get_count_plsos_for_underg_grad_h($department_id,$undergraduate_status_value);
		//$gpslo_no_count = get_count_plsos_for_underg_grad_h($department_id,$graduate_status_value); 
		$ucourses_count = get_count_courses_for_underg_grad_h($department_id,$undergraduate_status_value);
		//$gcourses_count = get_count_courses_for_underg_grad_h($department_id,$graduate_status_value); 
		
 		
		$dbprefix = trim($this->db->dbprefix);
	 
	$total_undergraduate_plsos = count($department_pslos_undergraduate);
	
	if($ucourses_count>=$total_undergraduate_plsos){
		$courses_appear_each_field1 = $ucourses_count/$total_undergraduate_plsos;
	}else{
		$courses_appear_each_field1 = $total_undergraduate_plsos/$ucourses_count;
	}
	
	if (strpos($courses_appear_each_field1, '.') !== false) {
		
		$first_arr = explode('.',$courses_appear_each_field1);
		$courses_appear_each_field=$first_arr[0]+1;
		
	}else{
	
		$courses_appear_each_field=$courses_appear_each_field1;
		
	}
	
	$continues_academic_year =  round($total_undergraduate_plsos/$rotation_plan_count);	
	
////////// remove old courses automatic raotaion plan table ///////////////////

$this->db->query("update ".$dbprefix."department_automatic_rotation_plan_academic_courses set course_id='' where manual_id in(select id from ".$dbprefix."department_automatic_rotation_plan where rotation_plan_status='".$undergraduate_status_value."' and department_id='".$department_id."')");


/*
$this->db->query("update ".$dbprefix."department_automatic_rotation_plan_academic_courses1 set course_id='' and manual_id in()"); 
$this->db->query("update ".$dbprefix."department_automatic_rotation_plan_academic_courses1 set course_id='' and manual_id in()");

$query_update = $this->db->query("select id from ".$dbprefix."department_automatic_rotation_plan where rotation_plan_status='".$undergraduate_status_value."' and department_id='".$department_id."'");
 $num_rows_query_update = $query_update->num_rows();
		
		if($num_rows_query_update>0){
		$fetch_result = $query_update->result();
		foreach($fetch_result as $data){
			$ma_ids[] = $data->id;
		}
		$man_id = implode(',',$ma_ids);
$this->db->query("update ".$dbprefix."department_automatic_rotation_plan_academic_courses1 set course_id='' and manual_id in($man_id)");
}*/
	$ay_loop=1;
	$academic_year = 1;
	
 	foreach($department_pslos_undergraduate as $undergraduate_pslos){
			
 		$this->db->where('department_id', $department_id);
		$this->db->where('plso_id', $undergraduate_pslos->id);
		$this->db->where('rotation_plan_status', $undergraduate_status_value);
		$query = $this->db->get('department_automatic_rotation_plan');
		$num_rows = $query->num_rows();
		
		if($num_rows==0){
			
			$insert_data=array('department_id'=>$department_id, 'plso_id'=>$undergraduate_pslos->id, 'rotation_plan_status'=>$undergraduate_status_value);
			$this->db->insert('department_automatic_rotation_plan',$insert_data);
			$manual_id = $this->db->insert_id();
			
		}else{
		
			$row = $query->row();
			$manual_id=$row->id;		
				
		}
	 	
		$undergraduate_courses_array=array();
 		$query_department_allignment_matrix = $this->db->query('SELECT * FROM '.$dbprefix.'department_allignment_matrix LEFT JOIN '.$dbprefix.'department_courses ON '.$dbprefix.'department_allignment_matrix.course_id = '.$dbprefix.'department_courses.id where '.$dbprefix.'department_allignment_matrix.pslos_id="'.$undergraduate_pslos->id.'" order by '.$dbprefix.'department_courses.course_number asc');
		$num_department_allignment_matrix = $query_department_allignment_matrix->num_rows();
		if($num_department_allignment_matrix>0){
		
			$row_department_allignment_matrix = $query_department_allignment_matrix->result();
			foreach($row_department_allignment_matrix as $row_department_allignment_matrix_data){
 	 				
				if(count($undergraduate_courses_array)<$courses_appear_each_field){
					
					$course_check_query = $this->db->query('SELECT * FROM '.$dbprefix.'department_automatic_rotation_plan_academic_courses where FIND_IN_SET("'.$row_department_allignment_matrix_data->course_id.'", course_id) and manual_id in(select id from '.$dbprefix.'department_automatic_rotation_plan where rotation_plan_status="'.$undergraduate_status_value.'")');
					$num_course = $course_check_query->num_rows();
					if($num_course==0){
						$undergraduate_courses_array[]=$row_department_allignment_matrix_data->course_id;
					}
				}else{
					break;
				}
			}
			$final_automatic_courses = implode(',',$undergraduate_courses_array);
			

				
				
			$this->db->where('manual_id', $manual_id);
			$this->db->where('academic_year', $academic_year);
			$query_1 = $this->db->get('department_automatic_rotation_plan_academic_courses');
			$num1 = $query_1->num_rows();
			if($num1==0){
			
				if(isset($final_automatic_courses) && $final_automatic_courses!=''){
					$data_arr1 = array('manual_id'=>$manual_id, 'academic_year'=>$academic_year, 'course_id'=>$final_automatic_courses);
					$this->db->insert('department_automatic_rotation_plan_academic_courses', $data_arr1);
				}
				
			}else{
				$update_arr1 = array('course_id'=>$final_automatic_courses);
				$this->db->where('manual_id', $manual_id);
				$this->db->where('academic_year', $academic_year);
				$this->db->update('department_automatic_rotation_plan_academic_courses',$update_arr1);
			}
			
			//print_r($final_automatic_courses);
			
			
			
		}
		
		if($ay_loop==$continues_academic_year){
		
			$ay_loop=1;
			
			if($academic_year>=$rotation_plan_count){
				$academic_year=1;
			}else{
				$academic_year++; 
			}
		
		}else{ $ay_loop++; }
	 //echo '<hr>';
		
		
	}
		
		
	}
	
	
	public function update_graduate_automatic_rotation_plan(){
	
		
		$department_pslos_graduate = $this->Envision_mdl->department_pslos_graduate(); 
		 
		$rotation_plan_count = $this->config->item('rotation_year_plans');
		
		$department_id = $this->session->userdata('dept_id');

		$graduate_status_value = $this->config->item('con_graduate_status_value');
		
		
		$gcourses_count = get_count_courses_for_underg_grad_h($department_id,$graduate_status_value); 
		
 		
		$dbprefix = trim($this->db->dbprefix);
	 
	$total_graduate_plsos = count($department_pslos_graduate);
	
	if($gcourses_count>=$total_graduate_plsos){
		$courses_appear_each_field1 = $gcourses_count/$total_graduate_plsos;
	}else{
		$courses_appear_each_field1 = $total_graduate_plsos/$gcourses_count;
	}
	
	if (strpos($courses_appear_each_field1, '.') !== false) {
		
		$first_arr = explode('.',$courses_appear_each_field1);
		$courses_appear_each_field=$first_arr[0]+1;
		
	}else{
	
		$courses_appear_each_field=$courses_appear_each_field1;
		
	}
	
	$continues_academic_year =  round($total_graduate_plsos/$rotation_plan_count);	
	
////////// remove old courses automatic raotaion plan table ///////////////////
 
$this->db->query("update ".$dbprefix."department_automatic_rotation_plan_academic_courses set course_id='' where manual_id in(select id from ".$dbprefix."department_automatic_rotation_plan where rotation_plan_status='".$graduate_status_value."' and department_id='".$department_id."')");


	$ay_loop=1;
	$academic_year = 1;
	
 	foreach($department_pslos_graduate as $graduate_pslos){
			
 		$this->db->where('department_id', $department_id);
		$this->db->where('plso_id', $graduate_pslos->id);
		$this->db->where('rotation_plan_status', $graduate_status_value);
		$query = $this->db->get('department_automatic_rotation_plan');
		$num_rows = $query->num_rows();
		
		if($num_rows==0){
			
			$insert_data=array('department_id'=>$department_id, 'plso_id'=>$graduate_pslos->id, 'rotation_plan_status'=>$graduate_status_value);
			$this->db->insert('department_automatic_rotation_plan',$insert_data);
			$manual_id = $this->db->insert_id();
			
		}else{
		
			$row = $query->row();
			$manual_id=$row->id;		
				
		}
	 	
		$graduate_courses_array=array();
 		$query_department_allignment_matrix = $this->db->query('SELECT * FROM '.$dbprefix.'department_allignment_matrix LEFT JOIN '.$dbprefix.'department_courses ON '.$dbprefix.'department_allignment_matrix.course_id = '.$dbprefix.'department_courses.id where '.$dbprefix.'department_allignment_matrix.pslos_id="'.$graduate_pslos->id.'" order by '.$dbprefix.'department_courses.course_number asc');
		$num_department_allignment_matrix = $query_department_allignment_matrix->num_rows();
		if($num_department_allignment_matrix>0){
		
			$row_department_allignment_matrix = $query_department_allignment_matrix->result();
			foreach($row_department_allignment_matrix as $row_department_allignment_matrix_data){
 	 				
				if(count($graduate_courses_array)<$courses_appear_each_field){
					
					$course_check_query = $this->db->query('SELECT * FROM '.$dbprefix.'department_automatic_rotation_plan_academic_courses where FIND_IN_SET("'.$row_department_allignment_matrix_data->course_id.'", course_id) and manual_id in(select id from '.$dbprefix.'department_automatic_rotation_plan where rotation_plan_status="'.$graduate_status_value.'")');
					$num_course = $course_check_query->num_rows();
					if($num_course==0){
						$graduate_courses_array[]=$row_department_allignment_matrix_data->course_id;
					}
				}else{
					break;
				}
			}
			$final_automatic_courses = implode(',',$graduate_courses_array);
			

				
				
			$this->db->where('manual_id', $manual_id);
			$this->db->where('academic_year', $academic_year);
			$query_1 = $this->db->get('department_automatic_rotation_plan_academic_courses');
			$num1 = $query_1->num_rows();
			if($num1==0){
			
				if(isset($final_automatic_courses) && $final_automatic_courses!=''){
					$data_arr1 = array('manual_id'=>$manual_id, 'academic_year'=>$academic_year, 'course_id'=>$final_automatic_courses);
					$this->db->insert('department_automatic_rotation_plan_academic_courses', $data_arr1);
				}
				
			}else{
				$update_arr1 = array('course_id'=>$final_automatic_courses);
				$this->db->where('manual_id', $manual_id);
				$this->db->where('academic_year', $academic_year);
				$this->db->update('department_automatic_rotation_plan_academic_courses',$update_arr1);
			}
			
			//print_r($final_automatic_courses);
			
			
			
		}
		
		if($ay_loop==$continues_academic_year){
		
			$ay_loop=1;
			
			if($academic_year>=$rotation_plan_count){
				$academic_year=1;
			}else{
				$academic_year++; 
			}
		
		}else{ $ay_loop++; }
	 //echo '<hr>';
		
		
	}
		
		
	}
	
	
	public function update_program_automatic_rotation_plan(){ 
		$program_learning_outcomes = $this->Envision_mdl->program_learning_outcomes(); 
		 
		$rotation_plan_count = $this->config->item('rotation_year_plans');
 		$department_id = $this->session->userdata('dept_id');
 		$program_status_value = $this->config->item('con_program_status_value');
  		$program_count = get_count_courses_for_underg_grad_h($department_id,$program_status_value); 
		
 		$dbprefix = trim($this->db->dbprefix);
	 
		$total_program_plsos = count($program_learning_outcomes);
		
		if($program_count>=$total_program_plsos){
			$courses_appear_each_field1 = $program_count/$total_program_plsos;
		}else{
			$courses_appear_each_field1 = $total_program_plsos/$program_count;
		}		
		
		if (strpos($courses_appear_each_field1, '.') !== false) {
			
			$first_arr = explode('.',$courses_appear_each_field1);
			$courses_appear_each_field=$first_arr[0]+1;
			
		}else{
		
			$courses_appear_each_field=$courses_appear_each_field1;
			
		}
		
		$continues_academic_year =  round($total_program_plsos/$rotation_plan_count);	
		
		////////// remove old courses automatic raotaion plan table ///////////////////
		 
		$this->db->query("update ".$dbprefix."department_automatic_rotation_plan_academic_courses set course_id='' where manual_id in(select id from ".$dbprefix."department_automatic_rotation_plan where rotation_plan_status='".$program_status_value."' and department_id='".$department_id."')");
	
	
		$ay_loop=1;
		$academic_year = 1;
		
		foreach($program_learning_outcomes as $ploData){
				
			$this->db->where('department_id', $department_id);
			$this->db->where('plso_id', $ploData->id);
			$this->db->where('rotation_plan_status', $program_status_value);
			$query = $this->db->get('department_automatic_rotation_plan');
			$num_rows = $query->num_rows();
			
			if($num_rows==0){
				
				$insert_data=array('department_id'=>$department_id, 'plso_id'=>$ploData->id, 'rotation_plan_status'=>$program_status_value);
				$this->db->insert('department_automatic_rotation_plan',$insert_data);
				$manual_id = $this->db->insert_id();
				
			}else{
			
				$row = $query->row();
				$manual_id=$row->id;		
					
			}
			
			$program_courses_array=array();
			$query_department_allignment_matrix = $this->db->query('SELECT * FROM '.$dbprefix.'department_allignment_matrix LEFT JOIN '.$dbprefix.'department_courses ON '.$dbprefix.'department_allignment_matrix.course_id = '.$dbprefix.'department_courses.id where '.$dbprefix.'department_allignment_matrix.pslos_id="'.$ploData->id.'" order by '.$dbprefix.'department_courses.course_number asc');
			$num_department_allignment_matrix = $query_department_allignment_matrix->num_rows();
			if($num_department_allignment_matrix>0){
			
				$row_department_allignment_matrix = $query_department_allignment_matrix->result();
				foreach($row_department_allignment_matrix as $row_department_allignment_matrix_data){
						
					if(count($program_courses_array)<$courses_appear_each_field){
						
						$course_check_query = $this->db->query('SELECT * FROM '.$dbprefix.'department_automatic_rotation_plan_academic_courses where FIND_IN_SET("'.$row_department_allignment_matrix_data->course_id.'", course_id) and manual_id in(select id from '.$dbprefix.'department_automatic_rotation_plan where rotation_plan_status="'.$program_status_value.'")');
						$num_course = $course_check_query->num_rows();
						if($num_course==0){
							$program_courses_array[]=$row_department_allignment_matrix_data->course_id;
						}
					}else{
						break;
					}
				}
				$final_automatic_courses = implode(',',$program_courses_array);
				
	
					
					
				$this->db->where('manual_id', $manual_id);
				$this->db->where('academic_year', $academic_year);
				$query_1 = $this->db->get('department_automatic_rotation_plan_academic_courses');
				$num1 = $query_1->num_rows();
				if($num1==0){
				
					if(isset($final_automatic_courses) && $final_automatic_courses!=''){
						$data_arr1 = array('manual_id'=>$manual_id, 'academic_year'=>$academic_year, 'course_id'=>$final_automatic_courses);
						$this->db->insert('department_automatic_rotation_plan_academic_courses', $data_arr1);
					}
					
				}else{
					$update_arr1 = array('course_id'=>$final_automatic_courses);
					$this->db->where('manual_id', $manual_id);
					$this->db->where('academic_year', $academic_year);
					$this->db->update('department_automatic_rotation_plan_academic_courses',$update_arr1);
				}
				
				//print_r($final_automatic_courses);
				
				
				
			}
			
			if($ay_loop==$continues_academic_year){
			
				$ay_loop=1;
				
				if($academic_year>=$rotation_plan_count){
					$academic_year=1;
				}else{
					$academic_year++; 
				}
			
			}else{ $ay_loop++; }
		 //echo '<hr>';
			
			
		}
		
		
	}
 

}
?>