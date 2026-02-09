<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 	

	function get_master_question_type_h(){
		$CI = & get_instance();
		$CI->load->model('Backend/Survey_template_mdl');
		return $CI->Survey_template_mdl->get_master_question_type();
	}	
	
	function get_5scale_rating_list_h(){
 		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_5scale_rating_list();
	}
	
	function get_choics_of_multiple_type_question($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_type_question($question_id);
 	} 		
 	
	function get_choics_of_multiple_column($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_column($question_id);
 	} 	
 	
 	 function get_choics_of_multiple_rows($question_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_choics_of_multiple_rows($question_id);
 	} 	 
 		
 	function get_default_surveys_questions_count_by_survey_template_id($survey_templates_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_default_surveys_questions_count_by_survey_template_id($survey_templates_id);
 	} 	
 	 		
/* 	function get_content_tutorials_sub_heading_detail_by_heading_id($heading_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_content_tutorials_sub_heading_detail_by_heading_id($heading_id);
 	} 	 	*/
 	 		
 	function get_content_tutorials_heading_name_by_heading_id($heading_id){
		$CI = & get_instance();
		return $CI->Master_helper_mdl->get_content_tutorials_heading_name_by_heading_id($heading_id);
 	} 	