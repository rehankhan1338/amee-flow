<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Effectiveness_data_mdl extends CI_Model {
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

	function get_master_indicators(){
		$this->db->where('status', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('master_indicators');
		return $query->result();
	}
	
	function get_master_sub_indicators($indicators_id){
		$this->db->where('status', '1');
		//$this->db->where('sub_indicators', 'other');
		$this->db->where('indicators', $indicators_id);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('master_sub_indicators');
		return $query->result();
	
	}
	
	function get_program_year_listing($dept_id,$data_id){
		$this->db->where('effectiveness_id', $data_id);
 		$this->db->where('department_id', $dept_id);
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get('unit_effectiveness_data_program_year');
		return $query->result();
	}
	
	function effectiveness_data_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('unit_effectiveness_data');
		return $query->result();
	}
	
	function get_effectiveness_data_fulldetails($data_id,$dept_id){
 		$this->db->where('id', $data_id);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('unit_effectiveness_data');
		return $query->row();
	}
	
	function manage_unit_effectiveness_data($dept_id,$data_id){	
	
		$academic_unit_name = $this->input->post('academic_unit_name');
		$overview = $this->input->post('overview');
		
		if($data_id==0){
		
			$add_date = strtotime(date('Y-m-d'));
			
			$arr = array('department_id'=>$dept_id, 'academic_unit_name'=>$academic_unit_name, 'overview'=>$overview, 'add_date'=>$add_date);
			$this->db->insert('unit_effectiveness_data', $arr);
			$data_id = $this->db->insert_id();
			
		}else{
		
			$arr = array('academic_unit_name'=>$academic_unit_name, 'overview'=>$overview);
			$this->db->where('id', $data_id);
			$this->db->where('department_id', $dept_id);
			$this->db->update('unit_effectiveness_data',$arr);
			
		}
		$this->session->set_flashdata('success', 'Save and update successfully!');
		redirect(base_url().'department/create/effectiveness_data/manage?tab=2&data_id='.$data_id.'&dept_id='.$dept_id);
	}	
	
	function add_program_year_entry($dept_id,$data_id){	
	
		$add_year = $this->input->post('add_year');
		$this->db->where('effectiveness_id', $data_id);
		$this->db->where('year', $add_year);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('unit_effectiveness_data_program_year');
		$num_rows = $query->num_rows();
		
 		if($num_rows==0){
		
			$add_date = strtotime(date('Y-m-d'));
			
			$arr = array('department_id'=>$dept_id,'effectiveness_id'=>$data_id, 'year'=>$add_year, 'add_date'=>$add_date);
			$this->db->insert('unit_effectiveness_data_program_year', $arr);
			$year_id = $this->db->insert_id();
			
		}else{
		
			$arr = array('year'=>$add_year);
			$this->db->where('year', $add_year);
			$this->db->where('effectiveness_id', $data_id);
			$this->db->where('department_id', $dept_id);
			$this->db->update('unit_effectiveness_data_program_year',$arr);
			
		}
		$this->session->set_flashdata('success', 'Program year save and update successfully!');
		
	}	
	
	function check_indicator_assign($data_id,$sub_indicator_id,$dept_id){
		 
		$this->db->where('effectiveness_id', $data_id);
		$this->db->where('sub_indicator_id', $sub_indicator_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('coding_status', '1');
		$query = $this->db->get('unit_effectiveness_data_value');
		return $num_rows = $query->num_rows();
	
	}
	
	function check_year_value_assign($data_id,$indicator_id,$sub_indicator_id,$dept_id,$year_id){
		$this->db->where('year_id', $year_id);
		$this->db->where('indicator_id', $indicator_id);
		$this->db->where('effectiveness_id', $data_id);
 		//$this->db->where('coding_status', '1');
		$this->db->where('sub_indicator_id', $sub_indicator_id);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('unit_effectiveness_data_value');
		return $query->row();
 	}
	
	function save_indicators($dept_id,$data_id){
 		//echo '<pre>';print_r($_POST);die;
		/*$arr = array('coding_status'=>'0');
		$this->db->where('department_id', $dept_id);
		$this->db->update('unit_effectiveness_data_value',$arr);*/
		
		$master_indicators = get_master_indicators_h();
		foreach($master_indicators as $indicators){
		
			$indicator_id = $indicators->id;
			$master_sub_indicators = get_master_sub_indicators_h($indicator_id);
			foreach($master_sub_indicators as $sub_indicators){
				
				$sub_indicator_id = $sub_indicators->id;
				$this->db->where('effectiveness_id', $data_id);
				$this->db->where('department_id', $dept_id);
				$this->db->order_by('add_date', 'asc');
				$query = $this->db->get('unit_effectiveness_data_program_year');
				$program_year_listing = $query->result();
				foreach($program_year_listing as $program_year){
					
					$year_id = $program_year->year_id;
					$year_value = $this->input->post('year_value_'.$indicator_id.$sub_indicator_id.$year_id);
					if(isset($year_value) && $year_value!=''){
 							 	
								$coding_status = $this->input->post('hidden_sub_indicator_status'.$indicator_id.$sub_indicator_id);
  								
								$this->db->where('year_id', $year_id);
								$this->db->where('effectiveness_id', $data_id);
								$this->db->where('indicator_id', $indicator_id);
								$this->db->where('sub_indicator_id', $sub_indicator_id);
								$this->db->where('department_id', $dept_id);
								$query = $this->db->get('unit_effectiveness_data_value');
								$num_rows = $query->num_rows();
								
								if($num_rows==0){
								
									$add_date = strtotime(date('Y-m-d'));
									
									$arr = array('department_id'=>$dept_id, 'effectiveness_id'=>$data_id, 'indicator_id'=>$indicator_id, 'sub_indicator_id'=>$sub_indicator_id, 'year_id'=>$year_id, 'year_value'=>$year_value, 'add_date'=>$add_date, 'coding_status'=>$coding_status);
									$this->db->insert('unit_effectiveness_data_value', $arr);
									$year_id = $this->db->insert_id();
									
								}else{
								
									$arr = array('year_value'=>$year_value, 'coding_status'=>$coding_status);
									$this->db->where('year_id', $year_id);
									$this->db->where('effectiveness_id', $data_id);
									$this->db->where('indicator_id', $indicator_id);
									$this->db->where('sub_indicator_id', $sub_indicator_id);
									$this->db->where('department_id', $dept_id);
									$this->db->update('unit_effectiveness_data_value',$arr);
									
								}
						//echo '<hr>';
						
					}
				
				}
			
			}
		}
		
		$this->session->set_flashdata('success', 'Save and update successfully!');
	}
	 	
	/*public function delete_core_function($core_function_id){
 		$this->db->where('id',$core_function_id); 
		$query = $this->db->delete('unit_effectiveness_data_core_functions');
  		$this->session->set_flashdata('success', 'Core function has been deleted successfully!');
	}*/
	
	
	public function archive_delete_effectiveness(){
		$arr_id = $_GET['arr'];
		$status = $_GET['status'];
		
		$explode_arr = explode(',', $arr_id);
		
		for($i=0; $i<count($explode_arr); $i++){
			$delete_id = $explode_arr[$i];		
			$arr = array('status'=>$status);
			$this->db->where('id', $delete_id);
			$this->db->update('unit_effectiveness_data',$arr);
		}
		
		if($status==1){
			$this->session->set_flashdata('success', 'Archive successfully!');
		}else{
			$this->session->set_flashdata('success', 'Deleted successfully!');
		}
  	}	
	 

}
?>