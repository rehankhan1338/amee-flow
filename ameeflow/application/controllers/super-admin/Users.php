<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
        $this->load->model('Backend/users_mdl');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Organizations | Administrator Panel';
		$this->data['active_class']='users_menu'; 
 	}

    public function index(){
        $this->data['orgainzations_data'] = $this->Signup_mdl->admin_orgainzations_data();
        $this->data['page_title']='User Accounts';
        $this->load->view('Backend/includes/header',$this->data);
        $this->load->view('Backend/users/view',$this->data);
        $this->load->view('Backend/includes/footer');
    }
	
	public function send_notification(){
		echo $this->Signup_mdl->send_notification();
	}
	
	public function update_account_status(){
		if(isset($_GET['organizationId']) && $_GET['organizationId']!=''){
			 $organizationId=$_GET['organizationId'];
			 $column_name=$_GET['column_name'];
			 $status=$_GET['status'];
			 echo $this->Signup_mdl->update_account_status($organizationId,$column_name,$status);
		}
	}
	
	public function details(){
        $last = $this->uri->total_segments();
		$encryptId = $this->uri->segment($last);
 		$this->data['orgainzation_details']=$this->Signup_mdl->orgainzation_details_by_encryptId($encryptId);
		$organizationId = $this->data['orgainzation_details']->organizationId;
		$this->data['orgainzation_members_data']=$this->Signup_mdl->orgainzation_members_data($organizationId);
        $this->data['page_title']='Organization Details';
        $this->load->view('Backend/includes/header',$this->data);
        $this->load->view('Backend/users/details',$this->data);
        $this->load->view('Backend/includes/footer');
    }
	
	public function add_member_entry(){
		echo $this->Signup_mdl->add_member_entry();
	}
	
	public function edit_member_entry(){
		echo $this->Signup_mdl->edit_member_entry();
	}
	
	public function ajax_edit_member(){
		if(isset($_GET['organizationId']) && $_GET['organizationId']!='' && isset($_GET['memberId']) && $_GET['memberId']!=''){
 			$this->data['orgainzation_details'] = $this->Signup_mdl->orgainzation_details($_GET['organizationId']);
			$this->data['member_details'] = $this->Signup_mdl->userlogin_details($_GET['memberId']);
			$this->load->view('Backend/users/popFields',$this->data);			
		}
	}
	
	public function ajax_add_member(){
		if(isset($_GET['organizationId']) && $_GET['organizationId']!=''){
 			$this->data['orgainzation_details'] = $this->Signup_mdl->orgainzation_details($_GET['organizationId']);
			$this->load->view('Backend/users/popFields',$this->data);			
		}
	}
	
    /*public function edit(){
        $last = $this->uri->total_segments();
		$encryptId = $this->uri->segment($last);
 		$this->data['orgainzation_details']=$this->Signup_mdl->orgainzation_details_by_encryptId($encryptId);
		$organizationId = $this->data['orgainzation_details']->organizationId;
		$this->data['orgainzation_members_data']=$this->Signup_mdl->orgainzation_members_data($organizationId);
        $this->data['page_title']='Users';
        $this->load->view('Backend/includes/header',$this->data);
        $this->load->view('Backend/users/edit',$this->data);
        $this->load->view('Backend/includes/footer');
    }
    

    public function update(){
        echo $this->users_mdl->update_user_details();
    }*/

    public function delete_organization(){
		if(isset($_GET['organizationId']) && $_GET['organizationId']!=''){
			echo $this->Signup_mdl->delete_organization($_GET['organizationId']);
		}
		redirect(base_url().$this->config->item('admin_directory_name').'users');
    }
	
	public function delete_member(){
		if(isset($_GET['memberId']) && $_GET['memberId']!=''){
			echo $this->Signup_mdl->delete_member($_GET['memberId']);
		}
		redirect(base_url().$this->config->item('admin_directory_name').'users/details/'.$_GET['encryptId']);
    }

}