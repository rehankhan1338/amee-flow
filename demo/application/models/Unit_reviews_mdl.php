<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_reviews_mdl extends CI_Model {
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
	
	function get_unit_direct_indirect_measure_count($id,$field_name){
		$subdomain_name = $this->db->dbprefix;
		$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0")';
		$this->db->where($where);
		$this->db->where(' FIND_IN_SET('.$id.', '.$field_name.')');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('unit_analysis_core_functions');
		return $num_row = $query->num_rows();
	}	
	
	function get_all_direct_indirect_measures_count(){
		$subdomain_name = $this->db->dbprefix;
		$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0")';
		$this->db->where($where);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('unit_analysis_core_functions');
		$num_row = $query->num_rows();
		if($num_row>0){
			$result = $query->result();
			foreach($result as $core_func_details){
				if(isset($core_func_details->direct_measures) && $core_func_details->direct_measures!='' && $core_func_details->direct_measures!=0){
 					$direct_indirect_measures_arr[] = $core_func_details->direct_measures;
				}
				if(isset($core_func_details->indirect_measures) && $core_func_details->indirect_measures!='' && $core_func_details->indirect_measures!=0){
 					$direct_indirect_measures_arr[] = $core_func_details->indirect_measures;
				}
			}
			$direct_indirect_measures_ids = implode(',',$direct_indirect_measures_arr);
			$res =  explode(',',$direct_indirect_measures_ids);
		}else{
			$res = array();
		}
		return $res;
 	}
	
	function get_all_strategic_priorities_count(){
		$subdomain_name = $this->db->dbprefix;
		$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0")';
		$this->db->where($where);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('unit_analysis_core_functions');
		$num_row = $query->num_rows();
		if($num_row>0){
			$result = $query->result();
			foreach($result as $core_func_details){
				if(isset($core_func_details->strategic_priorities_id) && $core_func_details->strategic_priorities_id!='' && $core_func_details->strategic_priorities_id!=0){
 					$strategic_priorities_ids[] = $core_func_details->strategic_priorities_id;
				}
			}
			$strategic_priorities_id = implode(',',$strategic_priorities_ids);
			$res = explode(',',$strategic_priorities_id);
		}else{
			$res = array();
		}
		return $res;
 	}
	
	function get_unit_strategic_priorities_count($unit_id){
		$subdomain_name = $this->db->dbprefix;
		$this->db->where('unit_id', $unit_id);
		$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0")';
		$this->db->where($where);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('unit_analysis_core_functions');
		$num_row = $query->num_rows();
		if($num_row>0){
			$result = $query->result();
			foreach($result as $core_func_details){
				if(isset($core_func_details->strategic_priorities_id) && $core_func_details->strategic_priorities_id!='' && $core_func_details->strategic_priorities_id!=0){
 					$strategic_priorities_ids[] = $core_func_details->strategic_priorities_id;
				}
			}
			$strategic_priorities_id = implode(',',$strategic_priorities_ids);
			return explode(',',$strategic_priorities_id);
		}
 	}
	
	function get_core_functions_arr($unit_id){
		$subdomain_name = $this->db->dbprefix;
		if(isset($_GET['year']) && $_GET['year']!=''){
			$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0" and academic_year="'.$_GET['year'].'")';
		}else{
			$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0")';
		}
		$this->db->where($where);
		$this->db->where('unit_id', $unit_id);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('unit_analysis_core_functions');
		$num_row = $query->num_rows();
		if($num_row>0){
			$result = $query->result();
			$i=1;
			foreach($result as $core_func_details){
 				$core_id = $core_func_details->id;
 				$arr = array('core_function_no'=>$i);
				$this->db->where('id', $core_id);
				$this->db->update('unit_analysis_core_functions',$arr);
 				$i++;
			}
			return $result;
		}
 	}
	
	function get_core_functions_count_all_unit($core_function_no){
		$subdomain_name = $this->db->dbprefix;
		if(isset($_GET['year']) && $_GET['year']!=''){
			$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0" and academic_year="'.$_GET['year'].'")';
		}else{
			$where = ' unit_id in (select id from '.$subdomain_name.'unit_analysis where status="0")';
		}
		$this->db->where($where);
		$this->db->where('core_function_no', $core_function_no);
		$query = $this->db->get('unit_analysis_core_functions');
		return $num_row = $query->num_rows();
	}

	function get_all_unit_reviews_listing(){
		if(isset($_GET['year']) && $_GET['year']!=''){
			$this->db->where('academic_year', $_GET['year']);
		}
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('unit_analysis');
		return $query->result();
	}
	
	function get_core_functions_loop(){
		$this->db->where('status', '0');
		$this->db->order_by('core_function_count', 'desc');
		$query = $this->db->get('unit_analysis');
 		$num_row = $query->num_rows();
		if($num_row>0){
			$row = $query->row();
			return $row->core_function_count;
		}
	}
	
	function get_all_core_functions_listing(){
		//$subdomain_name = $this->config->item('subdomain_name').'_';
		$prefix = $this->db->dbprefix;
		if(isset($_GET['year']) && $_GET['year']!=''){
			$where = ' unit_id in (select id from '.$prefix.'unit_analysis where status="0" and academic_year="'.$_GET['year'].'")';
		}else{
			$where = ' unit_id in (select id from '.$prefix.'unit_analysis where status="0")';
		}
		$this->db->where($where);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('unit_analysis_core_functions');
		return $query->result();
	}
	
	function get_unit_analysis_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('unit_analysis');
		return $query->result();
	}
	
	function get_master_strategic_priorities(){
		$this->db->where('status', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('master_strategic_priorities');
		return $query->result();
	}
	
	function get_unit_core_functions_details($unit_id,$dept_id){
		//$subdomain_name = $this->config->item('subdomain_name').'_';
		$prefix = $this->db->dbprefix;
		$where = ' unit_id in (select id from '.$prefix.'unit_analysis where status="0")';
		$this->db->where($where);
 		$this->db->where('unit_id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('unit_analysis_core_functions');
		return $query->result();
	}
	
	function get_admin_unit_details($dept_id){
 		$this->db->order_by('add_date', 'desc');
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('unit_analysis');
		return $query->row();
	}
	
	function get_unit_fulldetails($unit_id,$dept_id){
 		$this->db->where('id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('unit_analysis');
		return $query->row();
	}
	
	function manage_unit_details($dept_id,$unit_id){	
	
		$budget_unit_name = $this->input->post('budget_unit_name');
		$academic_year = $this->input->post('academic_year');
		
		if($unit_id==0){
		
			$add_date = strtotime(date('Y-m-d'));
			
			$arr = array('department_id'=>$dept_id, 'budget_unit_name'=>$budget_unit_name, 'academic_year'=>$academic_year, 'add_date'=>$add_date);
			$this->db->insert('unit_analysis', $arr);
			$unit_id = $this->db->insert_id();
			
		}else{
		
			$arr = array('budget_unit_name'=>$budget_unit_name, 'academic_year'=>$academic_year);
			$this->db->where('id', $unit_id);
			$this->db->where('department_id', $dept_id);
			$this->db->update('unit_analysis',$arr);
			
		}
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/unit_reviews/manage?tab=2&unit_id='.$unit_id.'&dept_id='.$dept_id);
	}	
	
	public function mission_statement_modifications($dept_id,$unit_id){	
	
	 	$mission_statement_modifications = $this->input->post('mission_statement_modifications');
		 
		$arr = array('mission_statement_modifications'=>$mission_statement_modifications);
		$this->db->where('id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('unit_analysis',$arr);
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/unit_reviews/manage?tab=3&unit_id='.$unit_id.'&dept_id='.$dept_id);
	}
	
	public function core_functions($dept_id,$unit_id){	
	
	 	$core_function_modifications = $this->input->post('core_function_modifications');		
		
		$core_function_add_first = $this->input->post('core_function_add_first');
		$strategic_priorities_add_first12 = $this->input->post('strategic_priorities_add_first');
		if(count($strategic_priorities_add_first12)>0){
			$strategic_priorities_add_first = implode(',',$strategic_priorities_add_first12);
		}else{
			$strategic_priorities_add_first = '';
		}
		$add_date = strtotime(date('Y-m-d'));
		
		$edit_core_function_count = $this->input->post('edit_core_function_count');
		if(count($edit_core_function_count)>0){
		
			for($i=0;$i<count($edit_core_function_count);$i++){
				
				$edit_core_func_id = $edit_core_function_count[$i];
				$core_function_add_edit = $this->input->post('core_function_add_edit'.$edit_core_func_id);
				$strategic_priorities_add_edit12 = $this->input->post('strategic_priorities_add_edit'.$edit_core_func_id);
				if(count($strategic_priorities_add_edit12)>0){
					$strategic_priorities_add_edit = implode(',',$strategic_priorities_add_edit12);
				}else{
					$strategic_priorities_add_edit = '';
				}
 				$arr_upate = array('core_functions'=>$core_function_add_edit, 'strategic_priorities_id'=>$strategic_priorities_add_edit);
				$this->db->where('id', $edit_core_func_id);
				$this->db->update('unit_analysis_core_functions',$arr_upate);
 			}
			
		}
		
		if(isset($core_function_add_first) && $core_function_add_first && isset($strategic_priorities_add_first) && $strategic_priorities_add_first){
		
			$arr = array('department_id'=>$dept_id, 'unit_id'=>$unit_id, 'core_functions'=>$core_function_add_first, 'strategic_priorities_id'=>$strategic_priorities_add_first, 'add_date'=>$add_date);
			$this->db->insert('unit_analysis_core_functions', $arr);
		}
		
		$add_more_count = $this->input->post('add_more_count');
		if(count($add_more_count)>0){
		
			for($i=0;$i<count($add_more_count);$i++){
				
				$add_more_id = $add_more_count[$i];
				$core_function_add_more = $this->input->post('core_function_add_more'.$add_more_id);
				$strategic_priorities_add_more12 = $this->input->post('strategic_priorities_add_more'.$add_more_id);
				if(count($strategic_priorities_add_more12)>0){
					$strategic_priorities_add_more = implode(',',$strategic_priorities_add_more12);
				}else{
					$strategic_priorities_add_more = '';
				}
				$arr = array('department_id'=>$dept_id, 'unit_id'=>$unit_id, 'core_functions'=>$core_function_add_more, 'strategic_priorities_id'=>$strategic_priorities_add_more, 'add_date'=>$add_date);
				$this->db->insert('unit_analysis_core_functions', $arr);
				
					
			}
			
		}
		
 		$this->db->where('unit_id', $unit_id);
		$query_unit_analysis_core_functions = $this->db->get('unit_analysis_core_functions');
		$core_function_count = $query_unit_analysis_core_functions->num_rows();
		
		$arr = array('core_function_modifications'=>$core_function_modifications,'core_function_count'=>$core_function_count);
		$this->db->where('id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('unit_analysis',$arr);
		
		//print_r($add_more_count);
		
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/unit_reviews/manage?tab=4&unit_id='.$unit_id.'&dept_id='.$dept_id);
	}
	
	
	public function evaluation_assessment($dept_id,$unit_id){	
	
	 	$year_to_year_comparisons = $this->input->post('year_to_year_comparisons');
		 
		$arr = array('year_to_year_comparisons'=>$year_to_year_comparisons);
		$this->db->where('id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('unit_analysis',$arr);
		
		$edit_ea_count = $this->input->post('edit_ea_count');
		if(count($edit_ea_count)>0){
		
			for($i=0;$i<count($edit_ea_count);$i++){
				
				$core_func_id = $edit_ea_count[$i];
				
				$core_function_ea = $this->input->post('core_function_ea'.$core_func_id);
				$goal_ea = $this->input->post('goal_ea'.$core_func_id);
 				$arr_upate = array('core_functions'=>$core_function_ea, 'goals'=>$goal_ea, 'direct_measures'=>'','indirect_measures'=>'');
				$this->db->where('id', $core_func_id);
				$this->db->update('unit_analysis_core_functions',$arr_upate);
				
				$direct_measures='';
				$indirect_measures='';
				
 				$direct_indirect_measures_ea = $this->input->post('direct_indirect_measures_ea'.$core_func_id);
				if(count($direct_indirect_measures_ea)>0){
					for($j=0;$j<count($direct_indirect_measures_ea);$j++){
 						$expl_arr = explode('|',$direct_indirect_measures_ea[$j]);
						$direct_indirect_status=$expl_arr[0];
 						
						if($direct_indirect_status==1){
							$direct_measures[]=$expl_arr[1];
						}else{
							$indirect_measures[]=$expl_arr[1];
						}
 					}
 					if(count($direct_measures)>0){ 
						$direct_measures_update = implode(',',$direct_measures);
						$arr_upate = array('direct_measures'=>$direct_measures_update);
						$this->db->where('id', $core_func_id);
						$this->db->update('unit_analysis_core_functions',$arr_upate);
					}
					if(count($indirect_measures)>0){ 
						$indirect_measures = implode(',',$indirect_measures);
						$arr_upate = array('indirect_measures'=>$indirect_measures);
						$this->db->where('id', $core_func_id);
						$this->db->update('unit_analysis_core_functions',$arr_upate);
					}
				}	
  				
 			}
			
		}
		
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/unit_reviews/manage?tab=5&unit_id='.$unit_id.'&dept_id='.$dept_id);
	}	
	
	
	public function discuss_of_evaluation_result($dept_id,$unit_id){	
	
	 	$discuss_of_evaluation_result = $this->input->post('discuss_of_evaluation_result');
		 
		$arr = array('discuss_of_evaluation_result'=>$discuss_of_evaluation_result);
		$this->db->where('id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('unit_analysis',$arr);
		
		$edit_er_count = $this->input->post('edit_er_count');
		if(count($edit_er_count)>0){
		
			for($i=0;$i<count($edit_er_count);$i++){
				
				$core_func_id = $edit_er_count[$i];
				
				$goal_er = $this->input->post('goal_er'.$core_func_id);
				$actions_for_improvement = $this->input->post('actions_for_improvement'.$core_func_id);
		 
				$arr_upate = array('actions_for_improvement'=>$actions_for_improvement, 'goals'=>$goal_er);
				$this->db->where('id', $core_func_id);
				$this->db->update('unit_analysis_core_functions',$arr_upate);
 			}
			
		}
		
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/unit_reviews/manage?tab=6&unit_id='.$unit_id.'&dept_id='.$dept_id);
	}	
	
	public function management_of_finance_hr($dept_id,$unit_id){	
	
	 	$management_of_finance_hr = $this->input->post('management_of_finance_hr');
		 
		$arr = array('management_of_finance_hr'=>$management_of_finance_hr);
		$this->db->where('id', $unit_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('unit_analysis',$arr);
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/unit_reviews');
	}
	
	public function delete_core_function($core_function_id){
 		$this->db->where('id',$core_function_id); 
		$query = $this->db->delete('unit_analysis_core_functions');
  		$this->session->set_flashdata('success', 'Core function has been deleted successfully!');
	}	
	
	
	public function archive_delete_unit_review(){
		$unit_id = $_GET['arr'];
		$status = $_GET['status'];
		
		$explode_arr = explode(',', $unit_id);
		
		for($i=0; $i<count($explode_arr); $i++){
			$delete_id = $explode_arr[$i];		
			$arr = array('status'=>$status);
			$this->db->where('id', $delete_id);
			$this->db->update('unit_analysis',$arr);
		}
		
		if($status==1){
			$this->session->set_flashdata('success', 'Archive successfully!');
		}else{
			$this->session->set_flashdata('success', 'Deleted successfully!');
		}
  	}




}
?>