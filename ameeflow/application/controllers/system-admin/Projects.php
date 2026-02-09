<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Projects extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 
        $this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));
        if($this->data['sessionDetailsArr']['createdBy']>0){
            $this->data['useuniAdminId'] = $this->data['sessionDetailsArr']['createdBy'];
        }else{
            $this->data['useuniAdminId'] = $this->data['sessionDetailsArr']['uniAdminId'];
        }		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Projects_mdl'); 
        $this->load->model('Roles_mdl'); 
        $this->load->model('Notifications_mdl');		  
        $this->data['active_class'] = 'project-menu';
        $this->data['title'] = 'Projects - '.$this->config->item('product_name');
 	} 
    public function index(){         
        $this->data['pageTitle'] = 'Main Workspace';
        $this->data['pageSubTitle'] = 'This is where you create your project and organize your work by adding tasks and subtasks. Easily track progress and manage your assessment workflow in one place.';
        
        $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->data['useuniAdminId']);        
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        // $this->data['activeUsersDataArr'] = $this->Roles_mdl->activeUsersDataArrByUni($universityId);
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/projects/manage',$this->data);
        $this->load->view('Backend/includes/footer',$this->data);
	}
    public function ajaxProjectFields(){        
        if(isset($_GET['pId']) && $_GET['pId']!='' && $_GET['pId']>0){
            $this->data['proDetailsArr'] = $this->Projects_mdl->proDetailsArr($_GET['pId']);
        }else{
            $this->data['proDetailsArr'] = array();
        }
        // $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->session->userdata('AFSESS_UNIADMINID'));
        $this->load->view('system-admin/projects/ajax-pro-fields',$this->data);
    }
    public function manageProEntry(){
        echo $this->Projects_mdl->manageProEntry();
    }
    public function copyProEntry(){
        echo $this->Projects_mdl->copyProEntry();
    }
    public function tasks(){         
        $proencryptId = $this->uri->segment(4);
        $this->data['pageTitle'] = 'Main Workspace';
        // $this->data['pageSubTitle'] = 'This is where you create your project and organize your work by adding tasks and subtasks. Easily track progress and manage your assessment workflow in one place.';
        $this->data['projectDetails'] = $this->Projects_mdl->projectDetailsByeIdArr($proencryptId);
        $projectId = $this->data['projectDetails']['projectId'];
        $this->data['proTaskListDataArr'] = $this->Projects_mdl->proTaskListDataArr($projectId);
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/projects/tasks/list',$this->data);
        $this->load->view('Backend/includes/footer',$this->data);
	}
    public function ajaxTaskFields(){        
        if(isset($_GET['tId']) && $_GET['tId']!='' && $_GET['tId']>0){
            $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
            $this->data['subTaskDataArr'] = $this->Projects_mdl->projectSubTaskDataArr($_GET['tId']);
        }else{
            $this->data['taskDetailsArr'] = array();
            $this->data['subTaskDataArr'] = array();
        }
        // $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->session->userdata('AFSESS_UNIADMINID'));
        $this->load->view('system-admin/projects/tasks/ajax-fields',$this->data);
    }
    public function ajaxUpdateTaskPri(){
        echo $this->Projects_mdl->updateTaskPriority($_GET['tId'],$_GET['pId']);
    }
    public function update_reminder_status(){
		if(isset($_GET['taskId']) && $_GET['taskId']!=''){
			 $taskId=$_GET['taskId'];
			 $column_name=$_GET['column_name'];
			 $status=$_GET['status'];
			 echo $this->Projects_mdl->update_reminder_status($taskId,$column_name,$status);
		}
	}
    public function update_pro_status(){
		if(isset($_GET['projectId']) && $_GET['projectId']!=''){
			 $projectId=$_GET['projectId'];
			 $column_name=$_GET['column_name'];
			 $status=$_GET['status'];
			 echo $this->Projects_mdl->update_pro_status($projectId,$column_name,$status);
		}
	}
    public function ajaxSendNotiticationModal(){
        if(isset($_GET['tId']) && $_GET['tId']!=''){
            $universityId = $this->data['sessionDetailsArr']['universityId'];
            $uniAdminId = $this->data['sessionDetailsArr']['uniAdminId']; 
            $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
            $projectId = $this->data['taskDetailsArr']['projectId'];
            $this->data['proDetailsArr'] = $this->Projects_mdl->proDetailsArr($projectId);
            $notiFor = 1;
            $this->data['notiFor'] = $notiFor;
            $this->data['assignedUserDataArr'] = $this->Projects_mdl->getAssignedProActiveUsersList($projectId);
            $this->data['proSentNotificaionsDataArr'] = $this->Notifications_mdl->proSentNotificaionsDataArr($_GET['tId'],$uniAdminId,$notiFor);
            $this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
            $this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
            $this->load->view('system-admin/projects/tasks/ajax-sent-notification-list',$this->data);
        }
    }    
    public function ajaxProSentNotificaionsDataArr(){ // check this
        if(isset($_GET['tId']) && $_GET['tId']!=''){
            $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
            $projectId = $this->data['taskDetailsArr']['projectId'];
            $this->data['proDetailsArr'] = $this->Projects_mdl->proDetailsArr($projectId);
            $notiFor = $_GET['notiFor'];
            $this->data['notiFor'] = $notiFor;
            $this->data['proSentNotificaionsDataArr'] = $this->Notifications_mdl->proSentNotificaionsDataArr($_GET['tId'],$_GET['sentById'],$_GET['notiFor']);
            $this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
            $this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
            $this->load->view('system-admin/projects/tasks/ajax-sent-notification-list',$this->data);
        }
    }
    public function ajaxAddProNotiFrm(){
        $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
        $projectId = $this->data['taskDetailsArr']['projectId'];
        $this->data['proDetailsArr'] = $this->Projects_mdl->proDetailsArr($projectId);
        $notiFor = $_GET['notiFor'];
        $this->data['notiFor'] = $notiFor;
        $this->data['assignedUserDataArr'] = $this->Projects_mdl->getAssignedProActiveUsersList($projectId);
        if(isset($_GET['nId']) && $_GET['nId']!=''){
            $this->data['notiDetailsArr'] = $this->Notifications_mdl->notiDetailsArr($_GET['nId']);
        }else{
            $this->data['notiDetailsArr'] = array();
        }
        $this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
        $this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
        $this->load->view('system-admin/projects/tasks/ajax-noti-frm-fields',$this->data);
    }
    public function ajaxGenProMsgAIContent(){
        echo $this->Notifications_mdl->ajaxGenProMsgAIContent();
    }
    public function sendProNotiEntry(){
        echo $this->Notifications_mdl->sendProNotiEntry();
    }
    public function ajaxGetDueDateInput(){
        $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
        $this->load->view('system-admin/projects/tasks/ajax-due-date-input',$this->data);
    }
    
    public function ajaxUpdateTaskDueDate(){
        echo $this->Projects_mdl->ajaxUpdateTaskDueDate($_GET['tId'],$_GET['dd']);
    }
    public function manageTaskEntry(){
        echo $this->Projects_mdl->manageTaskEntry();
    }
    public function deleteTask(){
        if(isset($_GET['tIds']) && $_GET['tIds']!='' && $_GET['tIds']>0){
            echo $this->Projects_mdl->deleteTask($_GET['tIds'],$_GET['projectId']);
        }
        redirect(base_url().$this->config->item('system_directory_name').'projects/tasks/'.$_GET['epId']);
    }
    public function deleteSubTask(){
        if(isset($_GET['Ids']) && $_GET['Ids']!='' && $_GET['Ids']>0){
            echo $this->Projects_mdl->deleteSubTask($_GET['Ids'],$_GET['taskId']);
        }
        redirect(base_url().$this->config->item('system_directory_name').'projects/tasks/'.$_GET['epId']);
    }
    public function deleteProject(){
        if(isset($_GET['pIds']) && $_GET['pIds']!='' && $_GET['pIds']>0){
            echo $this->Projects_mdl->deleteProject($_GET['pIds']);
        }
    }
    // public function ajaxRoleFields(){        
    //     if(isset($_GET['pId']) && $_GET['pId']!='' && $_GET['pId']>0){
    //         $universityId = $this->data['sessionDetailsArr']['universityId'];
    //         $this->data['assignUsersDataArr'] = $this->Roles_mdl->assignUsersDataArrByUni($universityId,$_GET['pId']);
    //         $this->data['assignProjectId'] = $_GET['pId'];
    //     }else{
    //         $this->data['assignUsersDataArr'] = array();
    //         $this->data['assignProjectId'] = 0;
    //     }
    //     $this->load->view('system-admin/projects/role-assignment/ajax-role-fields',$this->data);
    // }
    public function ajaxRoleFields(){        
        if(isset($_GET['taskId']) && $_GET['taskId']!='' && $_GET['taskId']>0){
            $universityId = $this->data['sessionDetailsArr']['universityId'];
            $uniAdminId = $this->data['useuniAdminId'];
            $this->data['assignUsersDataArr'] = $this->Roles_mdl->proassignUsersDataArrByuniAdmin($uniAdminId,$_GET['pId']);
            $this->data['assignProjectId'] = $_GET['pId'];
            $this->data['assignTaskId'] = $_GET['taskId'];
        }else{
            $this->data['assignUsersDataArr'] = array();
            $this->data['assignProjectId'] = 0;
            $this->data['assignTaskId'] = 0;
        }
        $this->load->view('system-admin/projects/role-assignment/ajax-role-fields',$this->data);
    }
    public function updateProAssignStatus(){
		if(isset($_GET['userId']) && $_GET['userId']!='' && isset($_GET['pId']) && $_GET['pId']!=''){
            $universityId = $this->data['sessionDetailsArr']['universityId'];
            $uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];            
            $userId=$_GET['userId'];
            $projectId=$_GET['pId'];
            $taskId=$_GET['taskId'];
            $column_name=$_GET['column_name'];
            $status=$_GET['status'];
            echo $this->Projects_mdl->updateProAssignStatus($userId,$column_name,$status,$projectId,$taskId,$universityId,$uniAdminId);
		}
	}
}