<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Readiness_mdl extends CI_Model {
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
	
	function save_checklist_data(){
		$dept_id = $this->session->userdata('dept_id');
		$add_date = time();
		 
		if(isset($_POST['checklist_ids']) && $_POST['checklist_ids']!='' && count($_POST['checklist_ids'])>0){
		
			$this->db->where('department_id',$dept_id);
			$this->db->update('department_checklist_data', array('status'=>'1'));
			
			for($i=0;$i<count($_POST['checklist_ids']);$i++){
			
				$dArr = explode('|',$_POST['checklist_ids'][$i]);
				$checklist_id = $dArr[0];
				$checklist_short_name = $dArr[1];
				
				$this->db->where('department_id',$dept_id);
				$this->db->where('checklist_id',$checklist_id);
				$query = $this->db->get('department_checklist_data');
				$num_row = $query->num_rows();
 				if($num_row==0){
					$this->db->insert('department_checklist_data', array('department_id'=>$dept_id, 'checklist_id'=>$checklist_id, 'checklist_short_name'=>$checklist_short_name, 'status'=>'0', 'add_date'=>$add_date));				
				}else{
					$this->db->where('department_id',$dept_id);
					$this->db->where('checklist_id',$checklist_id);
					$this->db->update('department_checklist_data', array('status'=>'0'));
				}			
			}
			$this->session->set_flashdata('success', 'Updated successfully, please move to the next step.');
			return 'success||'; 
		}else{
			return 'error||Looks like you selected none of the options.  Please select at least 1 option to customize your AMEE experience.';
		}
		
	
	}
	
	function get_my_checklist_data(){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->select('id, checklist_id, checklist_short_name');
		$this->db->where('department_id',$dept_id);
		$this->db->where('status','0');
		$query = $this->db->get('department_checklist_data');
		return $query->result_array();
	}
	
	function department_checklist_add(){	
	
		$dept_id = $this->session->userdata('dept_id');
		$add_date = time();
		
		$query_department_checklist = $this->db->get('master_department_checklist');
		$fetch_department_checklist = $query_department_checklist->result();
		
		foreach($fetch_department_checklist as $department_checklist){
		
			$checklist_id = $department_checklist->checklist_id;
			$checklist_short_name = $department_checklist->short_name;
			
			$this->db->where('department_id',$dept_id);
			$this->db->where('checklist_id',$checklist_id);
			$query = $this->db->get('department_checklist_data');
			$num_row = $query->num_rows();
			
			if($num_row==0){
				
				$arr = array('department_id'=>$dept_id, 'checklist_id'=>$checklist_id, 'checklist_short_name'=>$checklist_short_name, 'status'=>'1', 'add_date'=>$add_date);
				$this->db->insert('department_checklist_data', $arr);
							
			}
		}
		
		$default_arr = array('status'=>'1');
		$this->db->where('department_id',$dept_id);
		$this->db->update('department_checklist_data', $default_arr);
 			
		if(isset($_POST['checklist_id']) && $_POST['checklist_id']!=''){
		
			for($i=0;$i<count($_POST['checklist_id']); $i++){
				
				$checklist_ids = $_POST['checklist_id'][$i];

				$arr = array('status'=>'0');
				$this->db->where('department_id',$dept_id);
				$this->db->where('checklist_id',$checklist_ids);
				$this->db->update('department_checklist_data', $arr); 
			}
				$this->session->set_flashdata('success', 'Updated successfully, please move to the next step.');		
		}else{
			$this->session->set_flashdata('error', 'Looks like you selected none of the options.  Please select at least 1 option to customize your AMEE experience.');	
		}
		
	}	
	
	function checklist_sum(){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$query = $this->db->get('department_checklist_data');
		return $query->num_rows();
	}		
	
	function popup_messages_row_by_purpose($status, $val){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where($status, $val);
		$query = $amee_web->get('popup_messages');
		$row = $query->row();
		return $row->title.'@@@@'.$row->description;		
	}


}
?>