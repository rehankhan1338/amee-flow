<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
  	function create_slug_ch($string){
		$slug_a = url_title(convert_accented_characters($string), 'dash', true);
		//$slug_b = preg_replace ('/[0-9]+$/','', $slug_a );
		$slug_c = auto_link($slug_a, 'url');
		return reduce_multiples(trim($slug_c), "-", TRUE);
	} 
	
	function pop_messages_listing_h($page_name){
		$CI = & get_instance();
		$CI->load->model('Popup_messages_mdl');
		return $CI->Popup_messages_mdl->pop_messages_listing($page_name);
 	}
	
	function filter_array($array,$term,$field_name){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term)
				$matches[]=$a;
		}
		return $matches;
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