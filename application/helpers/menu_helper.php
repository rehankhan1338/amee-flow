<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
  	function menu_list_helper($admin_type,$menu_ids){
		$CI = & get_instance();
		$CI->load->model('Master_data_mdl');
		$menu_list = $CI->Master_data_mdl->menu_list($admin_type,$menu_ids);
		return $menu_list;
	}
	
	function submenu_list_helper($menu_id,$admin_type,$submenu_ids){
		$CI = & get_instance();
		$CI->load->model('Master_data_mdl');
		$submenu_list = $CI->Master_data_mdl->submenu_list($menu_id,$admin_type,$submenu_ids);
		return $submenu_list;
	}
	
	function submenu_subcat_list_helper($submenu_id,$admin_type,$submenu_subcat_ids){
		$CI = & get_instance();
		$CI->load->model('Master_data_mdl');
		$submenu_subcat_list = $CI->Master_data_mdl->submenu_subcat_list($submenu_id,$admin_type,$submenu_subcat_ids);
		return $submenu_subcat_list;
	}