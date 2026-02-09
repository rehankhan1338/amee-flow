<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_mdl extends CI_Model {
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
	
	function get_plso_selected_by_student($cours_id,$student_ass_id,$auth_code){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('assignment_id', $student_ass_id);
		$this->db->where('question_status', '2');
		$this->db->where(' FIND_IN_SET('.$cours_id.', given_answer)');
		$query = $this->db->get('assingment_question_answer');
		return $num_rows = $query->num_rows();	
	}
	
	function get_authcode_of_student_email_id_h($student_email,$student_ass_id){
		$this->db->where('email_to', $student_email);
		$this->db->where('assingment_id', $student_ass_id);
		$query = $this->db->get('assingment_email');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$row = $query->row();
			return $row->auth_code;
		}
	}
	
	function get_course_years_of_plsos($pslo_id){
		$this->db->where('pslo_number', $pslo_id);
		$this->db->order_by('year');
		$query = $this->db->get('assignment_courses');
		return $query->result();	
	}
	
	function get_amee_id_h($email){
		$this->db->where('email', $email);
		$query = $this->db->get('email_ameeid');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$row = $query->row();
			return $row->amee_id;
		}
	}
	
	function department_courses_pslos($plso_status){
		$subdomain_name = $this->db->dbprefix;
		$this->db->where('status', '0');
		$where=' pslo_number in(select id from '.$subdomain_name.'department_pslos where pslos_status="'.$plso_status.'")';
		$this->db->where($where);
		$this->db->group_by('pslo_number');
		$query = $this->db->get('assignment_courses');
		return $query->result();
 	}	
	
	function get_undergraduate_student_listing(){		
		$this->db->where('finish_status', '1');
		$this->db->where('is_deleted', '0');
		$this->db->where('first_name!=', '');
		$this->db->order_by('id');
		$this->db->group_by('email_to');
		$query = $this->db->get('assingment_email');
		return $query->result();		
		
		/*$subdomain_name = $this->db->dbprefix;
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$this->db->where('question_status', '2');
		$where=' auth_code in(select auth_code from '.$subdomain_name.'assingment_email where finish_status=1 and is_deleted=0)';
		$this->db->where($where);
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_question_answer1');
		return $query->result();*/
	}
	
	function get_activities_listing($tracker_id){
		$this->db->where('tracker_id', $tracker_id);
		$query = $this->db->get('department_time_tracker_acitivities');
		return $query->result();
 	} 
	
	function department_time_tracker_details($department_id){
		$this->db->where('status', '0');
		$this->db->where('department_id', $department_id);
		$query = $this->db->get('department_time_tracker');
		return $query->result();
 	}
	
	function reset_time_tracker($department_id){
		
		$session_start_date_time = $_SESSION['session_start_date_time'];
		$status_arr = array('status'=>'1');
		$this->db->where('department_id', $department_id);
		$this->db->where('session_start_date_time!=', $session_start_date_time);
		$this->db->update('department_time_tracker', $status_arr);
		
		$time_tracker_reset_arr = array('department_id'=>$department_id, 'reset_date_time'=>time());
		$this->db->insert('department_time_tracker_reset', $time_tracker_reset_arr);
		
		$this->session->set_flashdata('success', 'Time tracker reset successfully!');
		redirect(base_url().'department/reports/time_tracker');			
			
 	} 	
 	
	function save_time_tracker_ajax($department_id, $session_start_date_time, $activity_name) {	
	
		$current_time = time();
		
		$this->db->where('status', '0');
		$this->db->where('department_id', $department_id);
		$this->db->where('session_start_date_time', $session_start_date_time);
		$query = $this->db->get('department_time_tracker');
		$num_row = $query->num_rows();	
		if($num_row==0){
			
			$arr = array('department_id'=>$department_id, 'session_start_date_time'=>$session_start_date_time, 'last_modification_time'=>$session_start_date_time);
			$this->db->insert('department_time_tracker', $arr);
			$tracker_id = $this->db->insert_id();
			
			if(isset($activity_name) && $activity_name!=''){
				$tracker_arr = array('tracker_id'=>$tracker_id, 'activity_name'=>$activity_name);
				$this->db->insert('department_time_tracker_acitivities', $tracker_arr);	
			}
						
		}else{
			
			$row = $query->row();
			$tracker_id = $row->id;
			$time_track_update_count = $row->time_track_update_count+1;
			$time_tracked = $current_time-$row->last_modification_time;
			//$time_track = $row->time_track+300;//300-sec=5-min
			$time_track = $row->time_track+$time_tracked;//300-sec=5-min
			
			$this->db->where('department_id', $department_id);
			$this->db->where('department_id', $department_id);
			$this->db->where('session_start_date_time', $session_start_date_time);
			$arr = array('time_track_update_count'=>$time_track_update_count, 'time_track'=>$time_track, 'last_modification_time'=>$current_time);
			$this->db->update('department_time_tracker', $arr);	
			
			if(isset($activity_name) && $activity_name!=''){
			
				$this->db->where('tracker_id', $tracker_id);
				$this->db->where('activity_name', $activity_name);
				$query_activity = $this->db->get('department_time_tracker_acitivities');
				$num_row_activity = $query_activity->num_rows();	
				if($num_row_activity==0){
					$tracker_arr = array('tracker_id'=>$tracker_id, 'activity_name'=>$activity_name);
					$this->db->insert('department_time_tracker_acitivities', $tracker_arr);	
				}	
				
			}			
		}
	}	
	


}
?>