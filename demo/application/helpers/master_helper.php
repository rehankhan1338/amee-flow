<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 	
 	function get_admin_assignment_listing_h($department_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->assignment_listing($department_id);
 	}  	
 	function get_admin_test_listing_h($department_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->test_listing($department_id);
 	} 	
 	
 	function get_admin_survey_listing_h($department_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->survey_listing($department_id);
 	}
	
	function get_activities_listing_h($tracker_id){
		$CI = & get_instance();
		return $CI->Reports_mdl->get_activities_listing($tracker_id);
 	}
	
	function get_correct_answer_per_of_plso_h($question_assigned_ids,$test_id,$test_type){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_correct_answer_per_of_plso($question_assigned_ids,$test_id,$test_type);
 	}
	
	function get_questions_id_test_outcomes_h($test_id,$plso_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_questions_id_test_outcomes_h($test_id,$plso_id);
 	}
	
	function get_total_student_gave_answer_h($test_id,$test_type){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_total_student_gave_answer($test_id,$test_type);
 	}
	
	function get_all_item_test_textbox_answer_listing_h($test_id,$question_id,$auth_code,$test_type){
 		$CI = & get_instance();
		return $CI->Tests_mdl->get_all_item_test_textbox_answer_listing($test_id,$question_id,$auth_code,$test_type);
	}
	
	function get_all_test_authcode_textbox_answer_listing_h($test_id,$question_id,$auth_code){
 		$CI = & get_instance();
		return $CI->Tests_mdl->get_all_test_authcode_textbox_answer_listing($test_id,$question_id,$auth_code);
	}
	
	function get_choice_test_result_count_by_plos_answer_choice_id_h($answer_id,$question_id,$test_type){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_choice_test_result_count_by_plos_answer_choice_id($answer_id,$question_id,$test_type);
 	}
	
	function get_all_choice_test_result_count_by_pslo_question_id_h($question_id,$test_type){
		$CI = & get_instance();
 		return $CI->Tests_mdl->get_all_choice_test_result_count_by_pslo_question_id($question_id,$test_type);
 	}
	
	function get_test_learning_outcome_full_details_h($id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_test_learning_outcome_full_details($id);
	}
	
	function get_test_total_score_according_to_criteria_h($test_id,$current_test_type,$criterion_number){
		$CI = & get_instance();
		return $CI->Test_form_mdl->get_test_total_score_according_to_criteria($test_id,$current_test_type,$criterion_number);
	}
	
	/*function get_test_total_score_according_to_criteria_h($test_id,$test_type,$highest,$lowest){
		$CI = & get_instance();
		return $CI->Test_form_mdl->get_test_total_score_according_to_criteria($test_id,$test_type,$highest,$lowest);
	}*/
	
	function get_choice_test_result_count_by_choice_id_h($answer_id,$question_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_choice_test_result_count_by_choice_id($answer_id,$question_id);
 	}
	
	function get_all_choice_test_result_count_by_question_id_h($question_id){
		$CI = & get_instance();
 		return $CI->Tests_mdl->get_all_choice_test_result_count_by_question_id($question_id);
 	}
	
	function get_courses_test_answers_detail_by_course_id($test_id,$course_id,$auth_code){
		$CI = & get_instance();
		return $CI->Test_form_mdl->get_courses_test_answers_detail_by_course_id($test_id,$course_id,$auth_code);
 	}
	
	function get_assignment_raters_rating_status_h($assingment_id,$rater_auth_code,$final_answer_status){
		$CI = & get_instance();
 		return $CI->Assignment_raters_mdl->get_assignment_raters_rating_status($assingment_id,$rater_auth_code,$final_answer_status);
 	}
	
	function get_assignment_raters_listing_h($department_id,$assingment_id){
		$CI = & get_instance();
 		return $CI->Assignment_raters_mdl->get_assignment_raters_listing($department_id,$assingment_id);
 	}
	
	function get_raters_feedback_details_h($assingment_id,$auth_code,$user_auth_code){
		$CI = & get_instance();
		return $CI->Assignment_raters_mdl->get_raters_feedback_details($assingment_id,$auth_code,$user_auth_code);
 	}
	
	function get_raters_rating_score_h($category_id,$assingment_id,$auth_code,$user_auth_code){
 		$CI = & get_instance();
 		return $CI->Assignment_raters_mdl->get_raters_rating_score($category_id,$assingment_id,$auth_code,$user_auth_code);
  	}
	
	function get_test_criteion_details_h($test_id){
		$CI = & get_instance();
		return $CI->Tests_mdl->get_test_criteion_details($test_id);
 	}
	
	function get_courses_assingment_answers_detail_by_course_id($assignment_id,$course_id,$auth_code){
		$CI = & get_instance();
		return $CI->Assignment_mdl->get_courses_assingment_answers_detail_by_course_id($assignment_id,$course_id,$auth_code);
 	}
	
	function get_assingment_documents_h($assignment_id,$upload_type){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_assingment_documents($assignment_id,$upload_type);
 	}
	
	function get_all_choics_count_survey_of_matrix_question_h($question_id,$row_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_all_choics_count_survey_of_matrix_question($question_id,$row_id);
 	}
	
	function get_choics_count_survey_of_matrix_question_h($question_id,$row_id,$column_id){
		$CI = & get_instance();
 		return $CI->Master_helper_mdl->get_choics_count_survey_of_matrix_question($question_id,$row_id,$column_id);
 	}
	
	
	function get_matrix_choics_name_by_choice_id_h($row_id){
		$CI = & get_instance();
 		return $CI->Master_helper_mdl->get_matrix_choics_name_by_choice_id($row_id);
 	}
	
	function get_all_choice_survey_result_count_by_question_id_h($question_id){
		$CI = & get_instance();
 		return $CI->Master_helper_mdl->get_all_choice_survey_result_count_by_question_id($question_id);
 	}
	
	function get_choice_survey_result_count_by_choice_id_h($answer_id,$question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choice_survey_result_count_by_choice_id($answer_id,$question_id);
 	}
	
	function get_star_skip_logics_h($question_id){
 		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_star_skip_logics($question_id);
	}
	
	function get_5scale_rating_list_h(){
 		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_5scale_rating_list();
	}
	
	function get_answer_name_by_answer_id_h($answer_id,$question_type){
 		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_answer_name_by_answer_id($answer_id,$question_type);
	}
	function get_department_checklist_data_h($checklist_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_department_checklist_data_count($checklist_id);
 	}
	function get_department_course_matrix_options_h(){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_department_course_matrix_options();
 	}
	function get_master_organization_type_by_id($orgid){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_master_organization_type_by_id($orgid);
 	}  	
 	function get_master_department_type_by_id($dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_master_department_type_by_id($dept_id);
 	} 	
 	function get_member_names_result_by_id($team_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_member_names_result_by_id($team_id);
 	} 	 	
 	function get_department_names_by_id($dept_id){
		$CI = & get_instance();
		return $CI->Auth_mdl->departlogin_details($dept_id);
 	} 	
 	function get_assign_core_competency_detail_by_pslos_id($pslos_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assign_core_competency_detail_by_pslos_id($pslos_id);
 	} 		
 //==-- Survey --==//
 
 	function get_survey_result_answers_detail($question_id,$question_type,$survey_id,$auth_code){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_result_answers_detail($question_id,$question_type,$survey_id,$auth_code);
 	} 
	
	/*function get_survey_answers_detail($question_id,$survey_id,$auth_code){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_answers_detail($question_id,$survey_id,$auth_code);
 	} */ 	
 	
 	function get_assigment_choics_of_multiple_type_question($question_id){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_assigment_choics_of_multiple_type_question($question_id);
 	}
	
	function get_choice_assingment_result_count_by_choice_id_h($answer_id,$question_id){
		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_choice_assingment_result_count_by_choice_id($answer_id,$question_id);
 	}
	
	function get_all_choice_assignment_result_count_by_question_id_h($question_id){
		$CI = & get_instance();
 		return $CI->Assignments_rubrics_mdl->get_all_choice_assignment_result_count_by_question_id($question_id);
 	}
	
	function get_all_assingment_authcode_listing_h($assingment_id){
 		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_all_assingment_authcode_listing($assingment_id);
	}
	
	function get_all_assingment_authcode_textbox_answer_listing_h($assingment_id,$question_id,$auth_code){
 		$CI = & get_instance();
		return $CI->Assignments_rubrics_mdl->get_all_assingment_authcode_textbox_answer_listing($assingment_id,$question_id,$auth_code);
	}
	
		/////////////////
	
 	function get_choics_of_multiple_type_question($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_type_question($question_id);
 	} 	
 	function get_choics_of_multiple_rows($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_rows($question_id);
 	} 	
 	function get_choics_of_multiple_column($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_column($question_id);
 	} 		
	
	function get_test_answers_detail($test_id,$current_test_type, $auth_code){
		$CI = & get_instance();
		return $CI->Test_form_mdl->get_test_answers_detail($test_id,$current_test_type, $auth_code);
 	}
	
 	function get_survey_answers_detail($survey_id, $auth_code){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_answers_detail($survey_id, $auth_code);
 	}  	 	
 	function get_survey_answers_detail_by_question_id($survey_id, $auth_code, $question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_answers_detail_by_question_id($survey_id, $auth_code, $question_id);
 	}  
 	
 	function get_survey_matrix_answers_detail($survey_id, $auth_code, $question_id, $row_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_matrix_answers_detail($survey_id, $auth_code, $question_id, $row_id);
 	} 		
 	function get_survey_questions_details_for_demography($question_id,$survey_id,$dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_questions_details_for_demography($question_id,$survey_id,$dept_id);
 	}  	
/* 	function get_survey_answers_count($survey_id,$dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_survey_answers_count($survey_id,$dept_id);
 	}*/ 		
 	function get_survey_email_count($survey_id,$dept_id){
 		$CI = & get_instance();
 		return $CI->Master_helper_mdl->get_survey_email_count($survey_id,$dept_id);
  	} 
	
	function get_survey_responses_count($survey_id,$dept_id){
 		$CI = & get_instance();
 		return $CI->Master_helper_mdl->get_survey_responses_count($survey_id,$dept_id);
  	} 	
 	
 	 function get_master_survey_types_name_by_id($types_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_master_survey_types_name_by_id($types_id);
 	} 
 //==-- Tests --==//
 	function get_choics_of_multiple_type_question_tests($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_type_question_tests($question_id);
 	} 		
 	function get_choics_of_multiple_column_tests($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_column_tests($question_id);
 	} 
 	function get_choics_of_multiple_rows_tests($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_rows_tests($question_id);
 	} 
	 		
 	function get_point_value_by_test_id($test_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_point_value_by_test_id($test_id);
 	} 
	
	function get_score_of_test_answers_result($test_id,$auth_code,$test_type){
		$CI = & get_instance();
		return $CI->Test_form_mdl->test_answers_result($test_id,$auth_code,$test_type);
	}
	
	function get_test_current_answers_detail_by_question_id_h($test_id, $current_test_type, $auth_code, $question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_test_current_answers_detail_by_question_id($test_id, $current_test_type, $auth_code, $question_id);
	}
	
	function get_test_demo_answers_detail_by_question_id($test_id, $auth_code, $question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_test_demo_answers_detail_by_question_id($test_id, $auth_code, $question_id);
	}
	 	
 	function get_test_answers_detail_by_question_id($test_id,$current_test_type, $auth_code, $question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_test_answers_detail_by_question_id($test_id,$current_test_type, $auth_code, $question_id);
	} 
 	
 	function get_tests_email_count($test_id,$dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_tests_email_count($test_id,$dept_id);
 	} 	
	
	function get_tests_reponses_count($test_id,$dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_tests_reponses_count($test_id,$dept_id);
 	}
	
  	function get_test_result_answers_detail($question_id,$question_type,$test_id,$auth_code){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_test_result_answers_detail($question_id,$question_type,$test_id,$auth_code);
 	}  
 	
  	function get_test_question_answers_name_by_answer_id($test_answers,$question_type){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_test_question_answers_name_by_answer_id($test_answers,$question_type);
 	} 
//=====----- Survey Template -----=====// 	
 	 function get_choics_of_multiple_type_question_survey_templates($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_type_question_survey_templates($question_id);
 	}
 	function get_choics_of_multiple_column_survey_templates($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_column_survey_templates($question_id);
 	} 	
 	function get_choics_of_multiple_rows_survey_templates($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_rows_survey_templates($question_id);
 	} 	
 	
 	function get_count_of_default_surveys_questions($survey_templates_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_count_of_default_surveys_questions($survey_templates_id);
 	}  	 	
 	function get_surveys_questions_detail_by_question_id($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_surveys_questions_detail_by_question_id($question_id);
 	} 
 //=====----- Assignments Rubrics -----=====// 	
 	function get_assignments_rubrics_builder($assignment_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignments_rubrics_builder($assignment_id);
 	}	  	 	
 	function get_assignments_rubrics_builder_highest_rating_h($assignment_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignments_rubrics_builder_highest_rating($assignment_id);
 	}
	
	function get_assignments_rubrics_builder_heading($assignment_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignments_rubrics_builder_heading($assignment_id);
 	}  	
 	function get_assignments_rubrics_builder_option_details($column_no, $rubric_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignments_rubrics_builder_option_details($column_no, $rubric_id);
 	}  	 	
 	function check_assignments_rubrics_builder_status($assignment_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->check_assignments_rubrics_builder_status($assignment_id);
 	} 	 		
 	function get_assignments_rubrics_criterion_heading($assignment_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignments_rubrics_criterion_heading($assignment_id);
 	}  
 	function get_choics_of_multiple_type_question_rubrics($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_type_question_rubrics($question_id);
 	} 
 	
 	function get_assingment_email_count($assignments_id,$dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assingment_email_count($assignments_id,$dept_id);
 	} 
	
	function get_assingment_responses_count($assignments_id,$dept_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assingment_responses_count($assignments_id,$dept_id);
 	} 
 	
 	function get_assingment_answers_detail_by_question_id($assingment_id, $auth_code, $question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assingment_answers_detail_by_question_id($assingment_id, $auth_code, $question_id);
 	}
	
	function get_assignment_choics_of_multiple_type_question($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignment_choics_of_multiple_type_question($question_id);
 	} 	
 	
 	function get_assignments_rubrics_question_answers_name_by_answer_id($assingment_ans,$question_type){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_assignments_rubrics_question_answers_name_by_answer_id($assingment_ans,$question_type);
 	} 
 	
 	
//=====----- Analyze: "360" - Closing the Loop  -----=====// 	
 	function get_master_closing_loops_detail_by_status($lable_status){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_master_closing_loops_detail_by_status($lable_status);
 	}  
 	
 	function get_analyze_loop_description_by_loopid($loop_id,$lable_status){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_analyze_loop_description_by_loopid($loop_id,$lable_status);
 	} 
 	
 	
 //=====----- Tutorials  -----=====// 		
 	 	
 	function get_content_tutorials_sub_heading_details_by_heading_id($heading_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_content_tutorials_sub_heading_details_by_heading_id($heading_id);
 	} 
 	