<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	
	public function truncate_database_current()
	{
		$this->db->truncate('departments'); 
		$this->db->truncate('department_allignment_matrix');
		$this->db->truncate('department_assign_core_competency');
		$this->db->truncate('department_checklist_data');
		$this->db->truncate('department_checklist_detail');
		$this->db->truncate('department_courses');
		$this->db->truncate('department_pslos');
		$this->db->truncate('department_team_members');
		$this->db->truncate('import_error_log');
		$this->db->truncate('temp_import_table');		
		
		/*$tables = array('table1', 'table2', 'table3');
		$this->db->where('id', '5');
		$this->db->delete($tables);*/
	}
	
	
}
