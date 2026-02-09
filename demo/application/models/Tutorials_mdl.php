<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tutorials_mdl extends CI_Model {	
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
	
	public function tutorials_heading_details($action_status){
		$amee_web = $this->load->database('amee_web', TRUE); 			
		$amee_web->where('status', '0');
		$amee_web->where('action_status', $action_status);
		$query = $amee_web->get('content_tutorials_heading');
		return $query->result(); 
	}	
		
}