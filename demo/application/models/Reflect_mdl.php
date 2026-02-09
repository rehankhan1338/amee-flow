<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reflect_mdl extends CI_Model {
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
	public function get_master_direct_assessment_name($id){
		$this->db->where('id', $id);
		$query = $this->db->get('master_direct_assessment');
		$num = $query->num_rows();
 		if($num>0){
			$row = $query->row();
			return $row->name;
		}
 	}
	public function get_master_direct_assessment(){
		$this->db->where('status', '0');
		$query = $this->db->get('master_direct_assessment');
		return $query->result();
 	}
	
	public function get_master_indirect_assessment(){
		$this->db->where('status', '0');
		$query = $this->db->get('master_indirect_assessment');
		return $query->result();
 	}
	
	public function get_benchmark_tabuler_details($department_id,$academic_year,$tabular_status){
		
		$this->db->where('department_id', $department_id);
		$this->db->where('year_id', $academic_year);
		$this->db->where('tabular_status', $tabular_status);
		$query = $this->db->get('department_measurement_benchmark_tabular');
		return $query->row();
			
	}
	
	public function save_undergraduate_tabuler($department_id,$tabular_status,$tabular_field_name){
	
		$hyear_id = $this->input->post('hyear_id');
		//$tabular_status_dam_ids = $this->input->post($tabular_field_name.'dam');
		//$tabular_status_indam_ids= $this->input->post($tabular_field_name.'indam');
		if(isset($hyear_id) && $hyear_id!='' && count($hyear_id)>0){
		
			for($i=0;$i<count($hyear_id);$i++){
				
				$year_id = $hyear_id[$i];
				/*$DAM_ids=array();
				for($j=0;$j<count($tabular_status_dam_ids);$j++){
					$tabular_status_dam_id = $tabular_status_dam_ids[$j];
					$DAM_post_value = trim($this->input->post($tabular_field_name.'dam_'.$tabular_status_dam_id.$year_id));
					if(isset($DAM_post_value) && $DAM_post_value!=''){
						$DAM_ids[]=$DAM_post_value;
					}
				}
				
				$DAM_id_insert = implode(',',$DAM_ids);
				
				$INDAM_ids=array();
				for($j=0;$j<count($tabular_status_indam_ids);$j++){
					$tabular_status_indam_id = $tabular_status_indam_ids[$j];
					$INDAM_post_value = trim($this->input->post($tabular_field_name.'indam_'.$tabular_status_indam_id.$year_id));
					if(isset($INDAM_post_value) && $INDAM_post_value!=''){
						$INDAM_ids[]=$INDAM_post_value;
					}
				}
				
				$INDAM_id_insert = implode(',',$INDAM_ids);*/
				
				$dam = $this->input->post($tabular_field_name.'dam'.$year_id);
				if(isset($dam) && $dam!='' && count($dam)>0){
					$DAM_id_insert = implode(',',$dam);
				}else{
					$DAM_id_insert = '';
				}
				
				$indam = $this->input->post($tabular_field_name.'indam'.$year_id);
				if(isset($indam) && $indam!='' && count($indam)>0){
					$INDAM_id_insert = implode(',',$indam);
				}else{
					$INDAM_id_insert = '';
				}
				
				$criteria = $this->input->post($tabular_field_name.'criteria_'.$year_id);
				$sample_size = $this->input->post($tabular_field_name.'sample_size'.$year_id);
				
				$this->db->where('department_id', $department_id);
				$this->db->where('year_id', $year_id);
				$this->db->where('tabular_status', $tabular_status);
				$query = $this->db->get('department_measurement_benchmark_tabular');
				$num = $query->num_rows();
				if($num==0){
				
					$data_arr = array('department_id'=>$department_id, 'year_id'=>$year_id, 'criteria'=>$criteria,'dam'=>$DAM_id_insert, 'indam'=>$INDAM_id_insert, 'sample_size'=>$sample_size, 'tabular_status'=>$tabular_status);
					$this->db->insert('department_measurement_benchmark_tabular', $data_arr);
					$tabular_id = $this->db->insert_id();				
				
				}else{
				
					$row = $query->row();
					$tabular_id=$row->id;
					$update_arr = array('criteria'=>$criteria,'sample_size'=>$sample_size,'dam'=>$DAM_id_insert,'indam'=>$INDAM_id_insert,);
					$this->db->where('id', $tabular_id);
					$this->db->update('department_measurement_benchmark_tabular',$update_arr);
				}
				 
			}
		
		}
		
		$this->session->set_flashdata('success', 'Save & updated successfully!');
		if($tabular_status==0){redirect(base_url().'department/reflect/action2');
 		}else if($tabular_status==2){
		redirect(base_url().'department/reflect/action2?tab_id=4');
		}else{redirect(base_url().'department/reflect/action2?tab_id=2');}
			
	}
	
	public function update_assesment_measure_columns($dept_id,$DAM,$INDAM,$underg_grad_status){
	
		if($underg_grad_status==0){
			
			$update_data=array('undergraduate_DAM'=>$DAM,'undergraduate_INDAM'=>$INDAM);
			
		}else{
			
			$update_data=array('graduate_DAM'=>$DAM,'graduate_INDAM'=>$INDAM);
		
		}
		
		$this->db->where('department_id', $dept_id);
		$this->db->update('department_checklist_detail',$update_data); 		
		$this->session->set_flashdata('success', 'Update Successfully!');	
		
		if($underg_grad_status==0){
			redirect(base_url().'department/reflect/action2');
		}else{
			redirect(base_url().'department/reflect/action2?tab_id=2');
		}
	}
	public function reflect_save_action1(){
		$dept_id = $this->session->userdata('dept_id');		
	 	$reflect_action1_overview = $this->input->post('reflect_action1_overview');
	 	
	 	$this->db->where('department_id', $dept_id);
	 	$query = $this->db->get('department_checklist_detail');
		$num = $query->num_rows();
		if($num==0){
			$insert_data=array('department_id'=>$dept_id, 'reflect_action1_overview'=>$reflect_action1_overview, 'add_date'=>time());
			$this->db->insert('department_checklist_detail',$insert_data);
			$this->session->set_flashdata('success', 'Save Successfully!');	
		}else{
			$insert_data=array('reflect_action1_overview'=>$reflect_action1_overview);
			$this->db->where('department_id', $dept_id);
			$this->db->update('department_checklist_detail',$insert_data); 		
			$this->session->set_flashdata('success', 'Update Successfully!');	
		}
		
	}	
	
	function get_master_direct_assessment_codename($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('master_direct_assessment');
		$row = $query->row();
		return $row->da_code;
	} 
	
	function get_master_indirect_assessment_codename($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('master_indirect_assessment');
		$row = $query->row();
		return $row->da_code;
	} 
	
	function get_master_direct_assessment_title($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('master_direct_assessment');
		$row = $query->row();
		return $row->name;
	} 
	
	function get_master_indirect_assessment_title($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('master_indirect_assessment');
		$row = $query->row();
		return $row->name;
	}
	
	function team_members_detail_group_by(){
 		$dept_id = $this->session->userdata('dept_id');
 		$this->db->where('department_id', $dept_id);
 		$this->db->group_by('team_id');
		$this->db->where('status', '0');
		$query = $this->db->get('team_members');
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
				$this->db->insert('team_members', $arr);
			}
		}
		$this->session->set_flashdata('success', 'Save Successfully!');
		redirect(base_url().'department/members/action2');
	}
	
	
	public function edit_team_members(){	
	 	$name = $this->input->post('name');
		$id = $this->input->post('hupdate_id');
	
		$arr = array('name'=>$name);
		$this->db->where('id', $id);
		$this->db->update('team_members',$arr);
		$this->session->set_flashdata('success', 'Updated Successfully!');
		redirect('department/members/action2'); 
	}	
	
	
	public function delete_members($id){
 		$this->db->where('id',$id); 
		$query = $this->db->delete('team_members');
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
	
/*	function team_members_detail_by_id($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('team_members');
		return $query->row();
	} */	
}
?>