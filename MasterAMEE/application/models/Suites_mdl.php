<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suites_mdl extends CI_Model {
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
	
	function suites_details(){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('status', '0');
		$query = $amee_web->get('suites');
		return $query->result();
	}		
		
	function suites_detail_row($id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id', $id);
		$query = $amee_web->get('suites');
		return $query->row();
	}
	
	function suites_precising_details($id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('suites_id', $id);
		$query = $amee_web->get('suites_precising');
		return $query->result();
	}		
		
	function add_user($dept_id){
	
		$university_id = $this->input->post('university_id');
		$suites_id = $this->input->post('suites_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$limit_precising_id = $this->input->post('limit_precising');
 		$amee_web = $this->load->database('amee_web', TRUE);
		
		if(isset($limit_precising_id) && $limit_precising_id!=''){
		
			$amee_web->where('id', $limit_precising_id);
			$query_limit_precising = $amee_web->get('suites_precising');
			$row_limit_precising = $query_limit_precising->row();
			$limit_precising = $row_limit_precising->limit.' | $'.$row_limit_precising->price;
			
		}else{
			$limit_precising = '-';
		}
		 
		$add_date = time();
		$name = $first_name.' '.$last_name;		 
 		
		$amee_web->where('id', $suites_id);
		$query_suites = $amee_web->get('suites');
		$row_suites = $query_suites->row();
		$suite_name = strtoupper($row_suites->name);
		
		$arr = array('department_id'=>$dept_id, 'university_id'=>$university_id, 'suites_id'=>$suites_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'phone'=>$phone, 'limit_precising'=>$limit_precising_id, 'add_date'=>$add_date);
		$amee_web->insert('suites_user', $arr); 
	
		$to = $this->config->item('admin_sent_email');		
		$amee_web->select('*');
		$amee_web->where('purpose', 'Suites Email Send');
		$query1 = $amee_web->get('email_templates');
		$fetch_email_templates = $query1->row();
		$subject = $fetch_email_templates->subject;
		$email_message = $fetch_email_templates->message;
		$status_email = $fetch_email_templates->status;
		
		if($status_email==1){	
			$message=str_replace('{suite_name}',$suite_name,$email_message);
			$message=str_replace('{name_of_user}',$first_name.' '.$last_name,$message);		
			$message=str_replace('{name}',$first_name.' '.$last_name,$message);
			$message=str_replace('{email}',$email,$message);
			$message=str_replace('{limit_precising}',$limit_precising,$message);
			$message=str_replace('{phone}',$phone,$message);
			send_mail($to,$message,'','info',$subject);				
		}
		
		$this->session->set_flashdata('success', 'Thankyou, your interest has been sent to admin!');
	}	
	
	
	function suites_user_detail_row($id,$uni_id,$dept_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('department_id', $dept_id);
		$amee_web->where('university_id', $uni_id);
		$amee_web->where('suites_id', $id);
		$query = $amee_web->get('suites_user');
		return $query->row();
	}
	
}
?>