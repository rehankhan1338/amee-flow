<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assignment_raters_mdl extends CI_Model {
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
	
	function assingment_rater_detail_by_code($assignment_code){
		$this->db->where('assignment_code', $assignment_code);
		$query = $this->db->get('assignments');
		$num = $query->num_rows();
		if($num==0){
			redirect(base_url().'assingment/error/notavailable');
		}else{
			$row = $query->row();
			$assingment_status = $row->status;
			if($assingment_status==0){
			
				$assingment_start_date = $row->open_rating;
				$assingment_end_date = $row->close_rating;
				$current_time=time();
				if($current_time>=$assingment_start_date && $current_time<=$assingment_end_date){
					return $row;
				}else{
					redirect(base_url().'assignment_raters/error/deadline_over');
				}	
			
			}else{
				redirect(base_url().'assingment/error/deactive');
			}		
			
		}
	}	
	
	function get_assingment_raters_score_of_category_count($assingment_id, $rater_auth_code, $user_auth_code,$category_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('user_auth_code', $user_auth_code);
		$this->db->where('category_id', $category_id);		
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_raters_ratings');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $row->rating_score;
		}else{
			return $num_rows;
		}
	}
	
	
	function get_raters_listing_with_feedback_details($assingment_id,$user_auth_code){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('user_auth_code', $user_auth_code);
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query_rating = $this->db->get('assingment_raters_feedback');
		return $query_rating->result();
	}
	
	function save_participant_feedback(){
		
		$rater_auth_code = $this->input->post('auth_code');
 		$assingment_id = $this->input->post('assingment_id');
		$assingment_code = $this->input->post('assingment_code');
		$user_auth_code = $this->input->post('user_auth_code');
		$participant_feedback = $this->input->post('participant_feedback');
		$final_answer_status1 = $this->input->post('final_answer_status');
		if(isset($final_answer_status1) && $final_answer_status1!=''){
			$final_answer_status = $final_answer_status1;
		}else{
			$final_answer_status=0;
		}
		 
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('user_auth_code', $user_auth_code);
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_raters_feedback');
		$num_rows = $query->num_rows();
		if($num_rows==0){
			$rater_feedback_arr = array('assingment_id'=>$assingment_id,'rater_auth_code'=>$rater_auth_code,'user_auth_code'=>$user_auth_code,'participant_feedback'=>$participant_feedback,'final_answer_status'=>$final_answer_status,'feedback_date'=>time());
			$this->db->insert('assingment_raters_feedback', $rater_feedback_arr);
		}else{
			$row = $query->row();
			$feedback_id = $row->id;
			$rater_feedback_arr = array('participant_feedback'=>$participant_feedback,'final_answer_status'=>$final_answer_status,'last_modifiction_date'=>time());
			$this->db->where('id', $feedback_id);
			$this->db->update('assingment_raters_feedback',$rater_feedback_arr);	
		}
		 
 		$category_ids_arr = $this->input->post('category_ids');
		for($j=0;$j<count($category_ids_arr);$j++){
		
			$category_id = $category_ids_arr[$j];
			$rating_score = $this->input->post('score_'.$category_id);
			
			$this->db->where('assingment_id', $assingment_id);
			$this->db->where('rater_auth_code', $rater_auth_code);
			$this->db->where('user_auth_code', $user_auth_code);
			$this->db->where('category_id', $category_id);
			$this->db->where('status', '0');
			$query_rating = $this->db->get('assingment_raters_ratings');
			$num_row_rating = $query_rating->num_rows();
			if($num_row_rating==0){
				$rater_score_arr = array('assingment_id'=>$assingment_id,'rater_auth_code'=>$rater_auth_code,'user_auth_code'=>$user_auth_code,'category_id'=>$category_id,'rating_score'=>$rating_score,'add_date'=>time());
				$this->db->insert('assingment_raters_ratings', $rater_score_arr);
			}else{
				$row_rating = $query_rating->row();
				$rating_id = $row_rating->id;
				$rater_score_arr = array('rating_score'=>$rating_score,'last_modifiction_date'=>time());
				$this->db->where('id', $rating_id);
				$this->db->update('assingment_raters_ratings',$rater_score_arr);	
			}
			
		}
	
	
$this->db->select('SUM(rating_score) as total_rating_score');
$this->db->where('assingment_id', $assingment_id);
$this->db->where('user_auth_code', $user_auth_code);
$this->db->where('status', '0');
$this->db->group_by('user_auth_code ');
$query_total_rating_score = $this->db->get('assingment_raters_ratings');
$row_total_rating_score = $query_total_rating_score->row();

$ratus_over_rating=round($row_total_rating_score->total_rating_score/count($category_ids_arr));
$ratus_over_rating_arr = array('ratus_over_rating'=>$ratus_over_rating);
$this->db->where('auth_code', $user_auth_code);
$this->db->update('assingment_email',$ratus_over_rating_arr);	


		if($final_answer_status==2){
			$this->session->set_flashdata('success', 'You have not rated all assessment participants. Please be sure to complete all ratings before the deadline date.');
		}else if($final_answer_status==1){
			$this->session->set_flashdata('success', 'You have successfully rated '.$user_auth_code.' participant.');
		}
		redirect(base_url().'assignment_raters/'.$assingment_code.'/'.$rater_auth_code);
	}
	
	function save_assingment_raters_name(){
		$auth_code = $this->input->post('h_auth_code');
		$assignment_code = $this->input->post('h_assignment_code');
		$rater_name = $this->input->post('rater_name');
		
		if(isset($auth_code) && $auth_code>0){
		
			$this->db->where('auth_code', $auth_code);
			$this->db->where('is_deleted', '0');
			$query = $this->db->get('assingment_raters_email');
			$num_rows = $query->num_rows();
			if($num_rows==0){
				$rater_name_arr = array('rater_name'=>$rater_name);
				$this->db->insert('assingment_raters_email', $rater_name_arr);
			}else{
				$rater_name_arr = array('rater_name'=>$rater_name);
				$this->db->where('auth_code', $auth_code);
				$this->db->update('assingment_raters_email',$rater_name_arr);	
			}
		
		}
		$this->session->set_flashdata('success', 'Name has been successfully saved, click RATE NOW to review and evaluate the assignment.');
		redirect(base_url().'assignment_raters/'.$assignment_code.'/'.$auth_code);
	}
	
	function get_assignment_raters_rating_status($assingment_id,$rater_auth_code,$final_answer_status){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('final_answer_status', $final_answer_status);
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_raters_feedback');
		return $query->num_rows();
 	}
	
	function get_assignment_raters_listing($department_id,$assingment_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('department_id', $department_id);
		$this->db->where('is_deleted', '0');
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get('assingment_raters_email');
		return $query->result();
	}
	
	function assingment_user_listing($assingment_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('department_status', '1');
		$query = $this->db->get('assingment_email');
		return $query->result();
	}
	
	function assignments_user_upload_instruction($auth_code,$assignment_id){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('assignment_id', $assignment_id);
		$query = $this->db->get('assignments_user_upload_instruction');
		return $query->result();
	}
	
	function get_raters_rating_score($category_id,$assingment_id,$rater_auth_code,$user_auth_code){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('category_id', $category_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('user_auth_code', $user_auth_code);
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_raters_ratings');
		$num_row = $query->num_rows();
		if($num_row>0){
			 $row = $query->row();
			 return $row->rating_score;
		}else{
			return $num_row;
		}
	}
	
	function get_raters_feedback_details($assingment_id,$rater_auth_code,$user_auth_code){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('user_auth_code', $user_auth_code);
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_raters_feedback');
		return $query->row();
	}
	
	function get_raters_details($auth_code){
		$this->db->where('auth_code', $auth_code);
		$query = $this->db->get('assingment_raters_email');
		return $query->row();
 	}
 	 
	function apply_raters_finish_status($status,$assingment_id,$auth_code){	
		$arr = array('finish_status'=>$status,'finish_date'=>time());
		$this->db->where('auth_code',$auth_code);
		$this->db->where('assingment_id',$assingment_id);
		$this->db->update('assingment_email',$arr);	
	}
	
}
?>