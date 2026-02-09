<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	function time_tracking_management_ch($activity_name){
		
		if(isset($_SESSION['session_start_date_time']) && $_SESSION['session_start_date_time']!=''){
		
			$CI = & get_instance();
			$current_time = time();
			
			/*echo 'current_time = '.$current_time;
			echo '<br>';
			echo 'cur_time_date = '.strtotime(date('Y-m-d h:i:s'));
			echo '<br>';
			$d1 = strtotime("2021-01-18 12:20:00");
			$d2 = strtotime("2021-01-18 13:00:00");
			echo $totalSecondsDiff = abs($d1-$d2); //42600225	
			die;*/
			
			$department_id = $CI->session->userdata('dept_id');
			$session_start_date_time = $_SESSION['session_start_date_time'];
			
			$CI->db->where('status', '0');
			$CI->db->where('department_id', $department_id);
			$CI->db->where('session_start_date_time', $session_start_date_time);
			$query = $CI->db->get('department_time_tracker');
			$num_row = $query->num_rows();	
			if($num_row>0){
			
				$row = $query->row();
				$tracker_id = $row->id;
				$oldPerformedActivities = $row->activityPerformed;
				if(isset($oldPerformedActivities) && $oldPerformedActivities!=''){
					$oldPerformedActivitiesArr = explode('||',$oldPerformedActivities);
					if(!in_array("$activity_name",$oldPerformedActivitiesArr)){
						$newActivityPerform = $oldPerformedActivities.'||'.$activity_name;
					}else{
						$newActivityPerform = $oldPerformedActivities;
					}
				}else{
					$newActivityPerform = $activity_name;
				}		  
				
				$time_track_update_count = $row->time_track_update_count+1;
				$time_tracked = abs($current_time-$row->last_modification_time);
				$time_track = $row->time_track+$time_tracked;
				
				
				$CI->db->where('id', $tracker_id);
				$CI->db->update('department_time_tracker', array('time_track_update_count'=>$time_track_update_count, 'time_track'=>$time_track, 'last_modification_time'=>$current_time, 'activityPerformed'=>$newActivityPerform));	
				
				/*if(isset($activity_name) && $activity_name!=''){
				
					$this->db->where('tracker_id', $tracker_id);
					$this->db->where('activity_name', $activity_name);
					$query_activity = $this->db->get('department_time_tracker_acitivities');
					$num_row_activity = $query_activity->num_rows();	
					if($num_row_activity==0){
						$tracker_arr = array('tracker_id'=>$tracker_id, 'activity_name'=>$activity_name);
						$this->db->insert('department_time_tracker_acitivities', $tracker_arr);	
					}	
					
				}*/
			}
		}
	}
	
	function notificationsCookieUpdatech($departmentId,$callFrom){
		$CI = & get_instance();
		$qryDept = $CI->db->get_where('notifications_accepted', array('departmentId'=>$departmentId));
		$resDeptData = $qryDept->result_array();
		
		$notiArr = array();
		$university_id = $CI->config->item('cv_university_id');
		$amee_web = $CI->load->database('amee_web', TRUE);
		$where = "FIND_IN_SET(".$university_id.",sendTo) and isDeleted=0";
		$amee_web->where($where);
		$amee_web->limit(5);  
		$amee_web->order_by('notificationId', 'desc');
		$query = $amee_web->get('notifications');
		$resData = $query->result_array();
		if(count($resData)>0){					
			foreach($resData as $res){
				$chkArr = array();
				$chkArr['notificationId'] = $res['notificationId'];
				$chkArr['title'] = $res['title'];
				$chkArr['messageBody'] = $res['messageBody'];
				$chkArr['createTime'] = $res['createTime'];
				$accetedSts = filter_array_chk($resDeptData,$res['notificationId'],'notificationId');
				if(count($accetedSts)>0 || $callFrom=='dismiss_btn'){
					$aSts = 0;
				}else{
					$aSts = 1;
				}
				$chkArr['popShowSts'] = $aSts;
				$notiArr[] = $chkArr;
			}					
		}
		$jsonArr = json_encode($notiArr);
		$cookie_prefix = $CI->config->item('cookie_prefix');
		$expire = time() + (3600*24*60);
		setcookie($cookie_prefix."notification_data".$university_id, $jsonArr, $expire , '/');
	
	}
	
	function getNotificationsDetails_ch($universityId,$callFrom){
		$CI = & get_instance();
		$CI->load->model('Auth_mdl');
		return $CI->Auth_mdl->getNotificationsDetails($universityId,$callFrom);
	}
	
	function create_slug_ch($string){
		$slug_a = url_title(convert_accented_characters($string), 'dash', true);
		//$slug_b = preg_replace ('/[0-9]+$/','', $slug_a );
		$slug_c = auto_link($slug_a, 'url');
		return reduce_multiples(trim($slug_c), "-", TRUE);
	} 
	
	function get_survey_complete_sts($survey_id){
		$CI = & get_instance();
		return $CI->Survey_mdl->get_survey_complete_sts($survey_id);
 	}
	
	function filter_array($array,$term,$field_name){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] > $term)
				$matches[]=$a;
		}
		return $matches;
	}
	
	function filter_array_chk($array,$term,$field_name){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term)
				$matches[]=$a;
		}
		return $matches;
	}
 	
	function filter_array_chk_two($array,$term,$field_name,$term2,$field_name2){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term && $a["$field_name2"] == $term2)
				$matches[]=$a;
		}
		return $matches;
	}
	
	function check_skip_logic($h_question_id,$question_type,$survey_code,$auth_code,$answer){

 		//////////// skip login condition start 
 		$CI = & get_instance();
 		$query_surveys = $CI->db->get_where('surveys', array('survey_code'=>$survey_code));
		$fetch_survey_details = $query_surveys->row();
		$question_per_page = $fetch_survey_details->question_per_page;
					
 		$qry_skip_logic_condition = $CI->db->get_where('survey_answers_skip_logics', array('question_id'=>$h_question_id,'question_type'=>$question_type));
 		$num_skip_logic_condition = $qry_skip_logic_condition->num_rows();

		if($num_skip_logic_condition>0){
			
 			$skip_logic_condition = $qry_skip_logic_condition->result();
			//echo '<pre>'; print_r($skip_logic_condition);
 			foreach($skip_logic_condition as $skip_logic_details){
 				$logic = $skip_logic_details->logic;
 				if($logic==0){
 					$answer_id = $skip_logic_details->answer_id;					
 					if($answer_id==$answer){
 						$skip_to = $skip_logic_details->skip_to;
 						if($skip_to=='finish_survey'){
 							redirect(base_url()."survey/finish/".$survey_code.'/'.$auth_code);	
 						}else{
							$skip_to = $skip_logic_details->skip_to;
							$CI->db->select('priority');
							$query_pr = $CI->db->get_where('surveys_questions', array('question_id'=>$skip_to));
							$fetch_pr = $query_pr->row();
							$redirect_page = $fetch_pr->priority;							
							//echo $redirect_page = ceil($skip_to/$question_per_page);die;
							redirect(base_url()."survey/form/questions/".$survey_code.'/'.$auth_code.'/'.$redirect_page);	
						}
 					}
 				}else{

					$answer_id = $skip_logic_details->answer_id;
 					if($answer_id!=$answer){
 						$skip_to = $skip_logic_details->skip_to;
 						if($skip_to=='finish_survey'){
 							redirect(base_url()."survey/finish/".$survey_code.'/'.$auth_code);	
 						}else{
							$skip_to = $skip_logic_details->skip_to;
							$CI->db->select('priority');
							$query_pr = $CI->db->get_where('surveys_questions', array('question_id'=>$skip_to));
							$fetch_pr = $query_pr->row();
							$redirect_page = $fetch_pr->priority;	
							//$redirect_page = ceil($skip_to/$question_per_page);
							redirect(base_url()."survey/form/questions/".$survey_code.'/'.$auth_code.'/'.$redirect_page);	
						}
 					}
 				}
  			}
 		} //////////// skip login condition ends 

 	}
	
	function get_name_master_strategic_priorities_by_id_h($id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_name_master_strategic_priorities_by_id($id);
 	}
	
	function get_name_master_indirect_measures_by_id_h($id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_name_master_indirect_measures_by_id($id);
 	}
	
	function get_name_master_direct_measures_by_id_h($id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_name_master_direct_measures_by_id($id);
 	}
	
	function get_count_test_rating_h($test_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_count_test_rating($test_id);
 	}
	
	function get_assignemnt_student_raters_rating_by_rubric_creiterion_h($assignment_id,$bigger,$smaller){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_assignemnt_student_raters_rating_by_rubric_creiterion($assignment_id,$bigger,$smaller);
 	}
	
	function get_plso_selected_by_student_h($cours_id,$student_ass_id,$auth_code){
		$CI = & get_instance();
		return $CI->Reports_mdl->get_plso_selected_by_student($cours_id,$student_ass_id,$auth_code);
	}
	
	function get_authcode_of_student_email_id_h($student_email,$student_ass_id){
		$CI = & get_instance();
		return $CI->Reports_mdl->get_authcode_of_student_email_id_h($student_email,$student_ass_id);
	}
	
	function get_course_years_of_plsos_h($pslo_id){
		$CI = & get_instance();
		return $CI->Reports_mdl->get_course_years_of_plsos($pslo_id);
	}
	
	function get_amee_id_h($email){
		$CI = & get_instance();
		return $CI->Reports_mdl->get_amee_id_h($email);
 	}
	
	function get_test_self_rating_fulldetails_h($test_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_test_criteion_details($test_id);
 	}
	
	function get_self_rating_fulldetails_h($id){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_self_rating_fulldetails($id);
 	}
	
	function get_raters_users_of_assignment_h($assignment_id,$rater_auth_code){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_raters_users_of_assignment($assignment_id,$rater_auth_code);
 	}
	
	function get_total_rating_of_raters_h($category_id,$assignment_id,$rater_auth_code,$user_auth_code){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_total_rating_of_raters($category_id,$assignment_id,$rater_auth_code,$user_auth_code);
 	}
	
	function get_total_active_observation_h($assignment_id){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_total_active_observation($assignment_id);
	}
	
	function get_rater_rating_count_h($highest,$lowest,$assignment_id,$department_id){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_rater_rating_count($highest,$lowest,$assignment_id,$department_id);
	}
	
	function get_self_report_poll_count_h($criterion_id,$assignment_id,$department_id){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_self_report_poll_count($criterion_id,$assignment_id,$department_id);
	}
	
	function get_raters_fulldetails_by_rater_id_h($first_rater_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->get_raters_fulldetails_by_rater_id($first_rater_id);
	}
	
	function get_rater_reliability_listing_h($assingment_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->get_rater_reliability_listing($assingment_id);
	}
	
	function get_all_test_courses_fulldetails_by_couses_id_h($course_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->test_courses_fulldetails($course_id);
	}
	
	function get_courses_test_result_count_by_couses_id_h($course_id,$test_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_courses_test_result_count_by_couses_id($course_id,$test_id);
	}
	
	function get_all_courses_test_result_count_by_couses_id_h($test_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_all_courses_test_result_count_by_couses_id($test_id);
	}
	
	function get_courses_test_listing_h($test_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_courses_test_listing_result($test_id);
	}
	
	function update_random_sweepstakes_winners_h($survey_winners_calculate_count,$survey_id,$survey_code){
		$CI = & get_instance();
		return $CI->Survey_mdl->update_random_sweepstakes_winners($survey_winners_calculate_count,$survey_id,$survey_code);
	}
	
	function get_sweepstakes_winners_listing_h($survey_code){
		$CI = & get_instance();
		return $CI->Survey_mdl->get_sweepstakes_winners_listing($survey_code);
	}
	
	function get_assingment_rubric_criterion_listing_h($assingment_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->assingment_rubric_criterion_detail($assingment_id);
	}
	
	function get_all_assgingment_courses_fulldetails_by_couses_id_h($course_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->assgingment_courses_fulldetails($course_id);
	}
	
	function get_all_courses_assignment_result_count_by_couses_id_h($assignment_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->get_all_courses_assignment_result_count_by_couses_id($assignment_id);
	}
	
	function get_courses_assingment_result_count_by_couses_id_h($course_id,$assignment_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->get_courses_assingment_result_count_by_couses_id($course_id,$assignment_id);
	}
	
	function get_courses_assginment_listing_h($assingment_id){
		$CI = & get_instance();
		return $CI->Assignment_mdl->get_courses_assginment_listing_result($assingment_id);
	}
	
	function check_year_value_analyze_heading_h($loop_id,$analyze_label_id,$dept_id,$year_id){
		$CI = & get_instance();
		return $CI->Analyze_mdl->check_year_value_analyze_heading($loop_id,$analyze_label_id,$dept_id,$year_id);
	}
	
	function check_loop_status_assign_h($analyze_label_id,$dept_id){
		$CI = & get_instance();
		return $CI->Analyze_mdl->check_loop_status_assign($analyze_label_id,$dept_id);
 	}
	
	function get_raters_details_h($rater_auth_code){
		$CI = & get_instance();
 		return $CI->Assignment_raters_mdl->get_raters_details($rater_auth_code);
	}
	
	function get_assingment_raters_score_of_category_count_h($assingment_id, $rater_auth_code, $user_auth_code,$category_id){
		$CI = & get_instance();
 		return $CI->Assignment_raters_mdl->get_assingment_raters_score_of_category_count($assingment_id, $rater_auth_code, $user_auth_code,$category_id);
	}
	
	function get_raters_listing_with_feedback_details_h($assingment_id,$auth_code){
		$CI = & get_instance();
 		return $CI->Assignment_raters_mdl->get_raters_listing_with_feedback_details($assingment_id,$auth_code);
	}
	
	function get_unit_direct_indirect_measure_count_h($id,$field_name){
		$CI = & get_instance();
 		return $CI->Unit_reviews_mdl->get_unit_direct_indirect_measure_count($id,$field_name);
	}
	
	function get_unit_strategic_priorities_count_h($unit_id){
		$CI = & get_instance();
 		return $CI->Unit_reviews_mdl->get_unit_strategic_priorities_count($unit_id);
	}
	
	function get_core_functions_count_all_unit_h($kl){
		$CI = & get_instance();
 		return $CI->Unit_reviews_mdl->get_core_functions_count_all_unit($kl);
	}
	
	function get_core_functions_arr_h($id){
		$CI = & get_instance();
 		return $CI->Unit_reviews_mdl->get_core_functions_arr($id);
	}
	
	function get_department_fulldetails_h($dept_id){
		$CI = & get_instance();
 		return $CI->Departments_mdl->departments_detail_row($dept_id);
	}
	
	function get_unread_stauts_notification_h($department_id){
		$CI = & get_instance();
 		return $CI->Notification_mdl->get_unread_stauts_notification($department_id);
	}
	
	function get_all_notification_count_of_department_h($department_id){
		$CI = & get_instance();
 		return $CI->Notification_mdl->get_all_notification_count_of_department($department_id);
	}
	
	function get_last_notification_sent_details_h($department_id){
		$CI = & get_instance();
 		return $CI->Notification_mdl->get_last_notification_sent_details($department_id);
	}
	
	function get_cross_all_count_from_authcodes_and_choice_answer_id_h($question_id,$auth_codes){
		$CI = & get_instance();
 		return $CI->Survey_mdl->get_cross_all_count_from_authcodes_and_choice_answer_id($question_id,$auth_codes);
	}
	
	function get_cross_count_from_authcodes_and_choice_answer_id_h($answer_id,$question_id,$auth_codes){
		$CI = & get_instance();
 		return $CI->Survey_mdl->get_cross_count_from_authcodes_and_choice_answer_id($answer_id,$question_id,$auth_codes);
	}
	
	function get_authcode_from_cross_tabu_choice_id_h($answer_id,$question_id){
 		$CI = & get_instance();
 		return $CI->Survey_mdl->get_authcode_from_cross_tabu_choice_id($answer_id,$question_id);
  	} 
	
	function get_percentage_of_nps_status_h($status,$survey_id,$question_id){
 		$CI = & get_instance();
		return $CI->Survey_mdl->get_percentage_of_nps_status($status,$survey_id,$question_id);
	}
	
	function get_all_authcode_listing_h($survey_id){
 		$CI = & get_instance();
		return $CI->Survey_mdl->get_all_authcode_listing($survey_id);
	}
	
	function get_all_authcode_textbox_answer_listing_h($survey_id,$question_id,$auth_code){
 		$CI = & get_instance();
		return $CI->Survey_mdl->get_all_authcode_textbox_answer_listing($survey_id,$question_id,$auth_code);
	}
	
	function check_status_of_survey_started_h($survey_id){
 		$CI = & get_instance();
		return $CI->Survey_mdl->check_status_of_survey_started($survey_id);
	}
	
	function check_question_skip_logic_count_h($survey_id){
		$CI = & get_instance();
		return $CI->Survey_mdl->check_question_skip_logic_count($survey_id);
 	}
	
	function get_skip_to_question_list_h($survey_id,$question_priority){
		$CI = & get_instance();
		return $CI->Survey_mdl->get_skip_to_question_list($survey_id,$question_priority);
	}
	
	function get_test_question_fulldetails_h($question_id){
 		$CI = & get_instance();
		return $CI->Tests_mdl->get_test_question_fulldetails($question_id);
	}
	
	function get_assignment_question_fulldetails_h($question_id){
 		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_assignments_rubrics_questions_fulldetails($question_id);
	}
	
	function get_survey_question_fulldetails_h($question_id){
 		$CI = & get_instance();
		$CI->load->model('Survey_mdl');
		return $CI->Survey_mdl->get_survey_question_fulldetails($question_id);
	}
	
	function check_indicator_assign_h($data_id,$sub_indicator_id,$dept_id){
		$CI = & get_instance();
		$CI->load->model('Effectiveness_data_mdl');
		return $CI->Effectiveness_data_mdl->check_indicator_assign($data_id,$sub_indicator_id,$dept_id);
 	}
	
	function check_year_value_assign_h($data_id,$indicator_id,$sub_indicator_id,$dept_id,$year_id){
		$CI = & get_instance();
		$CI->load->model('Effectiveness_data_mdl');
		return $CI->Effectiveness_data_mdl->check_year_value_assign($data_id,$indicator_id,$sub_indicator_id,$dept_id,$year_id);
	}
	
	function get_master_sub_indicators_h($indicators_id){
		$CI = & get_instance();
		$CI->load->model('Effectiveness_data_mdl');
		return $CI->Effectiveness_data_mdl->get_master_sub_indicators($indicators_id);
	}
	
	function get_master_indicators_h(){
		$CI = & get_instance();
		$CI->load->model('Effectiveness_data_mdl');
		return $CI->Effectiveness_data_mdl->get_master_indicators();
	}
	
	function get_master_strategic_priorities_h(){
		$CI = & get_instance();
		$CI->load->model('Unit_reviews_mdl');
		return $CI->Unit_reviews_mdl->get_master_strategic_priorities();
	}
	
	function get_master_question_type_h(){
		$CI = & get_instance();
		$CI->load->model('Survey_mdl');
		return $CI->Survey_mdl->get_master_question_type();
	}	
	
	function get_master_question_type_test_h(){
		$CI = & get_instance();
		$CI->load->model('Tests_mdl');
		return $CI->Tests_mdl->get_master_question_type_test_h();
	}	
	
	function get_master_question_type_rubric_h(){
		$CI = & get_instance();
		$CI->load->model('Assignments_rubrics_mdl');
		return $CI->Assignments_rubrics_mdl->get_master_question_type_rubric_h();
	}
	
	function get_master_direct_assessment_codename_h($id){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_master_direct_assessment_codename($id);
	}
	
	function get_master_indirect_assessment_codename_h($id){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_master_indirect_assessment_codename($id);
	}
	
	function get_master_direct_assessment_title_h($id){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_master_direct_assessment_title($id);
	}
	
	function get_master_indirect_assessment_title_h($id){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_master_indirect_assessment_title($id);
	}
	
	function get_benchmark_tabuler_details_h($department_id,$academic_year,$tabular_status){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_benchmark_tabuler_details($department_id,$academic_year,$tabular_status);
	}
	
	function get_master_direct_assessment_name_h($id){
		$CI = & get_instance();
		return $CI->Reflect_mdl->get_master_direct_assessment_name($id);
	}
	
	function get_master_direct_assessment_h(){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_master_direct_assessment();
	}
	
	function get_master_indirect_assessment_h(){
		$CI = & get_instance();
		$CI->load->model('Reflect_mdl');
		return $CI->Reflect_mdl->get_master_indirect_assessment();
	}
	
	function get_course_name_from_course_id_h($course_id){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_course_name_from_course_id($course_id);
	}
	
	function get_plsos_name_from_plso_id_h($pslo_id){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_plsos_name_from_plso_id($pslo_id);
	}
	
	function get_plsos_details_from_year_id_h($department_id,$rotation_plan_status,$academic_year,$undergraduate_rotation_plan_status){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_plsos_details_from_year_id($department_id,$rotation_plan_status,$academic_year,$undergraduate_rotation_plan_status);
	}
	
	function get_courses_details_from_year_id_h($department_id,$rotation_plan_status,$academic_year,$undergraduate_rotation_plan_status){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_courses_details_from_year_id($department_id,$rotation_plan_status,$academic_year,$undergraduate_rotation_plan_status);
	}
	
	function get_maunal_rotation_plan_details_by_plso_id_h($undergraduate_status_value,$department_id,$pslo_id){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_maunal_rotation_plan_details_by_plso_id($undergraduate_status_value,$department_id,$pslo_id);
	}
	
	function get_maunal_rotation_plan_academic_details_h($manual_id,$academic_year){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_maunal_rotation_plan_academic_details($manual_id,$academic_year);
 	}
	
	function get_automatic_rotation_plan_details_by_plso_id_h($undergraduate_status_value,$department_id,$pslo_id){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_automatic_rotation_plan_details_by_plso_id($undergraduate_status_value,$department_id,$pslo_id);
	}
	
	function get_automatic_rotation_plan_academic_details_h($manual_id,$academic_year){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_automatic_rotation_plan_academic_details($manual_id,$academic_year);
 	}
	
	function get_rotation_plan_status_h($department_id,$underg_grad_status){
		$CI = & get_instance();
		$CI->load->model('Design_mdl');
		return $CI->Design_mdl->get_rotation_plan_status($department_id,$underg_grad_status);
 	}
	
	function get_import_error_log_h($department_id){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_import_error_log($department_id);
	}
	
	function get_allignment_matrix_courses_count_h($department_id,$matrix_options_id,$underg_grad_status){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_allignment_matrix_courses_count($department_id,$matrix_options_id,$underg_grad_status);
	}
	
	function get_core_competency_title_h($id){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_core_competency_title($id);
 	}
	
	function get_pslos_core_competency_h($department_id,$pslos_id){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_pslos_core_competency($department_id,$pslos_id);
 	}
	
	function get_count_plsos_for_underg_grad_h($department_id,$pslo_status){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_count_plsos_for_underg_grad($department_id,$pslo_status);
 	}
	
	function get_count_courses_for_underg_grad_h($department_id,$course_status){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_count_courses_for_underg_grad($department_id,$course_status);
 	}
	
	function get_count_allignment_matrix_option_h($department_id,$pslos_id,$course_id,$matrix_options_id){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_count_allignment_matrix_option($department_id,$pslos_id,$course_id,$matrix_options_id);	
	}
	
	function get_colorcode_matrix_option_h($department_id,$pslos_id,$course_id){
		$CI = & get_instance();
		$CI->load->model('Coordinate_mdl');
		return $CI->Coordinate_mdl->get_colorcode_matrix_option($department_id,$pslos_id,$course_id);	
	}
	
	
	function get_cmsmeta_fields_h($page_id){
		$CI = & get_instance();
		$CI->load->model('Master_data_mdl');
		return $CI->Master_data_mdl->get_cmsmeta_fields($page_id);
 	}
	
	function get_widgetsmeta_fields_h($widget_id){
		$CI = & get_instance();
		$CI->load->model('Widgets_mdl');
		return $CI->Widgets_mdl->get_widgetsmeta_fields($widget_id);
 	}
	
	function get_widgetmeta_options_h($widgetsmeta_id){
 		$CI = & get_instance();
		$CI->load->model('Widgets_mdl');
		return $CI->Widgets_mdl->get_widgetmeta_options($widgetsmeta_id);
	}
	
	function get_master_course_level_list_h(){
		$CI = & get_instance();
		$CI->load->model('Master_data_mdl');
		return $CI->Master_data_mdl->get_master_course_level_list();
 	}	
	
 	function faculty_dropdown_by_status_h($get_faculty_id){
	
		$CI = & get_instance();
		$db_subdomain_name=$CI->config->item("subdomain_name").'_';
		
		$query = $CI->db->get('master_faculty_status');
 		$master_faculty_status = $query->result();
		$select ='<option style="padding:3px;" value="">--Select--</option>';
		foreach($master_faculty_status as $faculty_status){
			
			$faculty_status_id = $faculty_status->id;
			$qry_faculty_directory = mysql_query("SELECT * FROM `".$db_subdomain_name."faculty_directory` WHERE `status` = '".$faculty_status_id."' order by first_name asc") or die(mysql_error());
			$faculty_directory_rows=mysql_num_rows($qry_faculty_directory);
			
			if($faculty_directory_rows>0){
			
				$select.='<option value="" disabled="disabled" style="font-size:16px; font-weight:600; border-bottom: 2px dotted #ddd; padding:3px;font-style: italic;">'.$faculty_status->name.'</option>';
				while($faculty_directory_fetch=mysql_fetch_array($qry_faculty_directory)){
					$selected_option = ($faculty_directory_fetch['faculty_id']===$get_faculty_id) ? ' selected="selected" ':'';
					$select.='<option style="padding:3px 20px;" value="'.$faculty_directory_fetch['faculty_id'].'" '. $selected_option.'>'.$faculty_directory_fetch['first_name'].' '.$faculty_directory_fetch['last_name'].'</option>';
				}
			}
		
		}
		return $select; 
	} 