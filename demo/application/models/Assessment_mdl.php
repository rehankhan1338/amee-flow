<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assessment_mdl extends CI_Model {
	
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
	
	public function deptMeasurementAssessmentData($deptId){
		$this->db->where('department_id', $deptId);
		$query = $this->db->get('department_measurement_benchmark_tabular');
		return $query->result_array();
	}
	
	public function masterDirectAssessmentArr(){
		$query = $this->db->get('master_direct_assessment');
		return $query->result_array();
	}
	
	public function masterIndirectAssessmentArr(){
		$query = $this->db->get('master_indirect_assessment');
		return $query->result_array();
	}	
	
	public function deptMaunalRotationPlansData($deptId){
		$this->db->where('department_id', $deptId);
		$query = $this->db->get('department_manual_rotation_plan');
		return $query->result_array();
	}
	
	public function deptManualRotationPlanCoursesData($manualIds){
		$where = "manual_id in(".$manualIds.")";
		$query = $this->db->get('department_manual_rotation_plan_academic_courses');
		return $query->result_array();
	}
	
	public function deptRotationPlansData($deptId){
		$this->db->where('department_id', $deptId);
		$query = $this->db->get('department_automatic_rotation_plan');
		return $query->result_array();
	}
	
	public function deptRotationPlanCoursesData($automaticIds){
		$where = "manual_id in(".$automaticIds.")";
		$query = $this->db->get('department_automatic_rotation_plan_academic_courses');
		return $query->result_array();
	}
	
	public function deptTeamMembersData($deptId){
		$this->db->select('id, team_id, name');
		$this->db->where('department_id', $deptId);
		$this->db->where('status', '0');
		$query = $this->db->get('department_team_members');
		return $query->result_array();
	}
	
	public function deptAligementMatrixData($deptId){
		$this->db->select('id, pslos_id, course_id, matrix_option_id');
		$this->db->where('department_id', $deptId);
		$query = $this->db->get('department_allignment_matrix');
		return $query->result_array();
	}
	
	public function masterMatrixOptionsArr(){
		$query = $this->db->get('master_matrix_options_colorcode');
		return $query->result_array();
	}
	
	public function deptAligementCoursesData($deptId){
		$this->db->select('id, course_prefix, course_number, course_status, course_title');
		$this->db->where('department_id', $deptId);
		$this->db->order_by('course_status,course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result_array();
	}
	
	public function masterCoreCompetencyArr(){
		$this->db->select('id, name');
		$query = $this->db->get('master_core_competency');
		return $query->result_array();
	}
	
	public function deptAssignedCoreComtyData($deptId){
		$this->db->select('id, department_pslos_id, core_competency_id');
		$this->db->where('department_id', $deptId);
		$this->db->where('status', '0');
		$query = $this->db->get('department_assign_core_competency');
		return $query->result_array();
	}
	
	public function deptEnvisionGoalAndOutcomes($deptId){
 		$this->db->where('department_id', $deptId);
		$query = $this->db->get('department_checklist_detail');
		return $query->row();
	}
	
	public function deptLearningOutcomesData($deptId){
		$this->db->where('department_id', $deptId);
		$this->db->order_by('pslos_status,id', 'asc');
		$query = $this->db->get('department_pslos');
		return $query->result_array();
	}
	
	public function dept_detail($deptEncryptId){
		$this->db->where('deptEncryptId', $deptEncryptId);
		$query = $this->db->get('departments');
		return $query->row();
	}
	
	public function deptAnalysisReports($deptId, $reportIds){
		$this->db->select('reportId, reportTitle, reportYear');
		$where = "department_id='".$deptId."' and reportId in(".$reportIds.")";
		$this->db->where($where);
		$this->db->order_by('reportYear,reportId', 'desc');
		$query = $this->db->get('department_analysis');
		return $query->result_array();
	}
	
	public function deptAnalysisReportData($deptId, $reportIds){
		$this->db->select('reportId, anlaysisType, reportDesc');
		$where = "department_id='".$deptId."' and reportId in(".$reportIds.")";
		$this->db->where($where);
		$this->db->order_by('reportId,priority', 'asc');
		$query = $this->db->get('department_analysis_reporting');
		return $query->result_array();
	}
	
	public function deptClosingLoopList($deptId, $loopIds){
		$this->db->select('loopId, year, yearTitle');
		$where = "department_id='".$deptId."' and loopId in(".$loopIds.")";
		$this->db->where($where);
		$this->db->order_by('year,createTime', 'asc');
		$query = $this->db->get('analyze_closing_loop_program_year');
		return $query->result_array();
	}
	
	public function deptClosingLoopValueData($deptId, $loopIds){
		$this->db->select('loopId, IndicatorId, indiOptId, year_value');
		$where = "department_id='".$deptId."' and loopId in(".$loopIds.") and coding_status='0'";
		$this->db->where($where);
		$this->db->order_by('loopId,IndicatorId', 'asc');
		$query = $this->db->get('analyze_closing_loop_year_value');
		return $query->result_array();
	}
	
	public function deptLogicModelData($deptId, $modelIds){
		$where = "departmentId='".$deptId."' and modelId in(".$modelIds.") and status='0' and isDeleted='0'";
		$this->db->where($where);
		$this->db->order_by('lastModiTime', 'asc');
		$query = $this->db->get('department_logic_models');
		return $query->result();
	}
	
	public function rdAnalysisReports($deptId){
		$this->db->select('reportId, reportTitle, reportYear');
		$where = "department_id='".$deptId."'";
		$this->db->where($where);
		$this->db->order_by('reportYear,reportId', 'desc');
		$query = $this->db->get('department_analysis');
		return $query->result_array();
	}
	
	public function rdClosingLoopList($deptId){
		$this->db->select('loopId, year, yearTitle');
		$where = "department_id='".$deptId."'";
		$this->db->where($where);
		$this->db->order_by('year,createTime', 'asc');
		$query = $this->db->get('analyze_closing_loop_program_year');
		return $query->result_array();
	}
	
	public function rdLogicModelData($deptId){
		$this->db->select('modelId, programName, programYear');
		$where = "departmentId='".$deptId."' and status='0' and isDeleted='0'";
		$this->db->where($where);
		$this->db->order_by('lastModiTime', 'asc');
		$query = $this->db->get('department_logic_models');
		return $query->result_array();
	}
	
}