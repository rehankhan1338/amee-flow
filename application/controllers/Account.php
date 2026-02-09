<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	
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
	
	public function activation(){
		 
		$last = $this->uri->total_segments();
		$md5_id = $this->uri->segment($last);
		
		$this->Signup_mdl->activate_profile($md5_id);
		 
		$this->data['title'] = 'Profile Activation';  
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/activation/view');
		$this->load->view('Frontend/includes/footer'); 
	}
	  
	public function thankyou(){
	
		$this->data['title']='Signup';
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/signup/thankyou',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
	}
	
}