<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lesson_plan_mdl extends CI_Model {
	
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
	
	public function make_clone($ids){
		if(isset($ids) && $ids!=''){
			$idsArr = explode(',',$ids);
			$date= strtotime(date('Y-m-d'));
			$time = time();
			foreach($idsArr as $cloneLessonId){
				$this->db->where('lessonId', $cloneLessonId);
				$query = $this->db->get('department_lesson_plans');
				$row = $query->row();
				
				$this->db->insert('department_lesson_plans', array('departmentId'=>$row->departmentId, 'programName'=>$row->programName, 'instructorName'=>$row->instructorName, 'lessonTitle'=>$row->lessonTitle, 'sessionDate'=>$row->sessionDate, 'essentialQuestions'=>$row->essentialQuestions, 'studentKnow'=>$row->studentKnow, 'studentBeAbleTo'=>$row->studentBeAbleTo, 'studentThinkAbout'=>$row->studentThinkAbout, 'focusQuestion'=>$row->focusQuestion, 'lpMaterials'=>$row->lpMaterials, 'createDate'=>$date, 'createTime'=>$time, 'lastModiTime'=>$time, 'lpDoNowMin'=>$row->lpDoNowMin, 'lpDoNowDesc'=>$row->lpDoNowDesc, 'lpMiniLessonMin'=>$row->lpMiniLessonMin, 'lpMiniLessonDesc'=>$row->lpMiniLessonDesc, 'lpActivityMin'=>$row->lpActivityMin, 'lpActivityDesc'=>$row->lpActivityDesc, 'lpSummaryMin'=>$row->lpSummaryMin, 'lpSummaryDesc'=>$row->lpSummaryDesc, 'lpHomeWork'=>$row->lpHomeWork, 'lpHomeWorkMin'=>$row->lpHomeWorkMin, 'lpAssessment'=>$row->lpAssessment, 'lpReflectionQues'=>$row->lpReflectionQues));
				$lessonId = $this->db->insert_id();			
				$encryptLessonId = md5($lessonId).$lessonId;
				$this->db->where('lessonId',$lessonId); 
				$this->db->update('department_lesson_plans', array("encryptLessonId"=>$encryptLessonId));
				
			}
			$this->session->set_flashdata('success', 'Lesson plan has been copied successfully!');
		}
	}
	
	public function admin_lesson_plans_list(){
		$this->db->select('lm.*, dept.department_name');
		$this->db->from('department_lesson_plans as lm');
		$this->db->where('lm.isDeleted', '0');
		$this->db->order_by('lm.sessionDate', 'desc');
		$this->db->join('departments as dept', 'dept.id = lm.departmentId', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function my_lesson_plan_data($departmentId){
		$this->db->where('departmentId', $departmentId);
		$this->db->where('isDeleted', '0');
		$this->db->order_by('sessionDate', 'desc');
		$query = $this->db->get('department_lesson_plans');
		return $query->result();
	}
	
	public function get_lesson_plan_details($encryptLessonId){
		$this->db->where('encryptLessonId', $encryptLessonId);
		$query = $this->db->get('department_lesson_plans');
		return $query->row();
	}	
	
	public function latest_lesson_plan_details($departmentId){
		$this->db->where('departmentId', $departmentId);
		$this->db->order_by('sessionDate', 'desc');
		$query = $this->db->get('department_lesson_plans');
		return $query->row();
	}
	
	public function count_created_lesson_plans($departmentId){
		$this->db->where('departmentId', $departmentId);
		$query = $this->db->get('department_lesson_plans');
		return $query->num_rows();
	}
	
	public function save_model_data($departmentId){	
	
		$date= strtotime(date('Y-m-d'));
		$time = time();
		$chkLessonId = $this->input->post('h_lesson_id');
		$programName = $this->input->post('programName');
		$instructorName = $this->input->post('instructorName');
		$lessonTitle = $this->input->post('lessonTitle');
		$sessionDate = strtotime($this->input->post('sessionDate'));
				
		$essentialQuestions = $this->input->post('essentialQuestions');	
		$studentKnow = $this->input->post('studentKnow');	
		$studentBeAbleTo = $this->input->post('studentBeAbleTo');	
 		$studentThinkAbout = $this->input->post('studentThinkAbout');
		
		$focusQuestion = $this->input->post('focusQuestion');
		$lpMaterials = $this->input->post('lpMaterials');
		
		$lpDoNowMin = $this->input->post('lpDoNowMin');		
		$lpDoNowDesc = $this->input->post('lpDoNowDesc');
				
		$lpMiniLessonMin = $this->input->post('lpMiniLessonMin');		
		$lpMiniLessonDesc = $this->input->post('lpMiniLessonDesc');	
			
		$lpActivityMin = $this->input->post('lpActivityMin');		
		$lpActivityDesc = $this->input->post('lpActivityDesc');	
			
		$lpSummaryMin = $this->input->post('lpSummaryMin');		
		$lpSummaryDesc = $this->input->post('lpSummaryDesc');
			
		$lpHomeWork = $this->input->post('lpHomeWork');
		$lpHomeWorkMin = $this->input->post('lpHomeWorkMin');
		
		$lpReflectionQues = $this->input->post('lpReflectionQues');
		$lpAssessment = $this->input->post('lpAssessment');
		
		if($chkLessonId>0){
			$lessonId = $chkLessonId;
			$this->db->where('lessonId',$lessonId); 
			$this->db->update('department_lesson_plans', array('programName'=>$programName, 'instructorName'=>$instructorName, 'lessonTitle'=>$lessonTitle, 'sessionDate'=>$sessionDate, 'essentialQuestions'=>$essentialQuestions, 'studentKnow'=>$studentKnow, 'studentBeAbleTo'=>$studentBeAbleTo, 'studentThinkAbout'=>$studentThinkAbout, 'focusQuestion'=>$focusQuestion, 'lpMaterials'=>$lpMaterials, 'lpDoNowMin'=>$lpDoNowMin, 'lpDoNowDesc'=>$lpDoNowDesc, 'lpMiniLessonMin'=>$lpMiniLessonMin, 'lpMiniLessonDesc'=>$lpMiniLessonDesc, 'lpActivityMin'=>$lpActivityMin, 'lpActivityDesc'=>$lpActivityDesc, 'lpSummaryMin'=>$lpSummaryMin, 'lpSummaryDesc'=>$lpSummaryDesc, 'lpHomeWork'=>$lpHomeWork, 'lpHomeWorkMin'=>$lpHomeWorkMin, 'lpReflectionQues'=>$lpReflectionQues, 'lpAssessment'=>$lpAssessment, 'lastModiTime'=>$time));
		}else{
			$this->db->insert('department_lesson_plans', array('departmentId'=>$departmentId, 'programName'=>$programName, 'instructorName'=>$instructorName, 'lessonTitle'=>$lessonTitle, 'sessionDate'=>$sessionDate, 'essentialQuestions'=>$essentialQuestions, 'studentKnow'=>$studentKnow, 'studentBeAbleTo'=>$studentBeAbleTo, 'studentThinkAbout'=>$studentThinkAbout, 'focusQuestion'=>$focusQuestion, 'lpMaterials'=>$lpMaterials, 'createDate'=>$date, 'createTime'=>$time, 'lastModiTime'=>$time, 'lpDoNowMin'=>$lpDoNowMin, 'lpDoNowDesc'=>$lpDoNowDesc, 'lpMiniLessonMin'=>$lpMiniLessonMin, 'lpMiniLessonDesc'=>$lpMiniLessonDesc, 'lpActivityMin'=>$lpActivityMin, 'lpActivityDesc'=>$lpActivityDesc, 'lpSummaryMin'=>$lpSummaryMin, 'lpSummaryDesc'=>$lpSummaryDesc, 'lpHomeWork'=>$lpHomeWork, 'lpHomeWorkMin'=>$lpHomeWorkMin, 'lpReflectionQues'=>$lpReflectionQues, 'lpAssessment'=>$lpAssessment));
			$lessonId = $this->db->insert_id();			
			$encryptLessonId = md5($lessonId).$lessonId;
			$this->db->where('lessonId',$lessonId); 
			$this->db->update('department_lesson_plans', array("encryptLessonId"=>$encryptLessonId));
		}
		$this->session->set_flashdata('success', 'Your lesson plan has been saved!');	
	}
	
	public function delete_plan($ids){	
		if(isset($ids) && $ids!=''){
			$this->db->where('lessonId in ('.$ids.')'); 
			$this->db->update('department_lesson_plans', array('isDeleted'=>'1', 'lastModiTime'=>time()));
			$this->session->set_flashdata('success', 'Your selected lesson plan has been deleted!');
		}
	}
	
}