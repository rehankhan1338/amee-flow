<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Projects extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
		$this->data['title']='Projects'; 
		$this->data['active_class']='project-menu';
		// $this->load->model('Backend/Accounts_mdl');
		$this->load->model('Projects_mdl');
		$this->load->model('Notifications_mdl');
 	}
    public function index(){
		$this->data['pageTitle'] = 'My Projects';
        $this->data['pageSubTitle'] = '';
        $this->data['assignProjectsDataArr'] = $this->Projects_mdl->userAssignProjectsDataArr($this->session->userdata('AFSESS_USERID')); 
		// echo '<pre>';print_r($this->data['assignProjectsDataArr']);die;
		$this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/projects/listing',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
	}
	public function tasks(){
		$proencryptId = $this->uri->segment(3);
		if(isset($proencryptId) && $proencryptId!=''){
			$userId = $this->data['sessionDetailsArr']['userId'];
			$this->data['projectDetails'] = $this->Projects_mdl->projectDetailsByeIdArr($proencryptId);
			$projectId = $this->data['projectDetails']['projectId'];
			$this->data['proTaskListDataArr'] = $this->Projects_mdl->userProTaskListDataArr($projectId,$userId);
			$this->data['proWiseCompletedTaskListDataArr'] = $this->Projects_mdl->proWiseCompletedTaskListDataArr($projectId,$userId);
			// echo '<pre>';print_r($this->data['proWiseCompletedTaskListDataArr']);die;
			$this->data['pageTitle'] = 'Task Completion Dashboard';
			$this->load->view('Frontend/includes/header',$this->data);		 
			$this->load->view('Frontend/projects/tasks',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data);
		}else{
			redirect(base_url().'projects');
		}
	}
	public function ajaxTakeActionOnSubTask(){
		if(isset($_GET['subtId']) && $_GET['subtId']!=''){
			$subTaskId = $_GET['subtId'];
			$taskId = $_GET['tId'];
			$projectId = $_GET['pId'];
			$colName = $_GET['colName'];
			$status = $_GET['status'];
			$userId = $this->session->userdata('AFSESS_USERID');
			echo $this->Projects_mdl->takeActionOnSubTask($subTaskId,$colName,$status,$taskId,$projectId,$userId);
		}
	}
	
	public function viewTaskDetails(){        
        $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
		$this->data['subTaskDataArr'] = $this->Projects_mdl->projectSubTaskDataArr($_GET['tId']);
        // $this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($this->session->userdata('AFSESS_UNIADMINID'));
        $this->load->view('Frontend/projects/ajax-sub-task',$this->data);
    }
	public function ajaxSendNotiticationModal(){
        if(isset($_GET['tId']) && $_GET['tId']!=''){
            $userId = $this->data['sessionDetailsArr']['userId'];
			 
            $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
			$this->data['subtaskDetails'] = $this->Projects_mdl->subtaskDetailsArr($_GET['subTaskId']);
            $projectId = $this->data['taskDetailsArr']['projectId'];
            $this->data['proDetailsArr'] = $this->Projects_mdl->proDetailsArr($projectId);
			$notiFor = 1;
            $this->data['notiFor'] = $notiFor;
			$sendFrom = 1;
            $this->data['sendFrom'] = $sendFrom;
            $this->data['assignedUserDataArr'] = array();
            $this->data['proSentNotificaionsDataArr'] = $this->Notifications_mdl->proSentUserNotificaionsDataArr($_GET['tId'],$_GET['subTaskId'],$userId,$notiFor);
			
            $this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
			$this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
            $this->load->view('Frontend/projects/notifications/ajax-sent-notification-list',$this->data);
        }
    } 
	public function ajaxAddProNotiFrm(){
        $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
		$this->data['subtaskDetails'] = $this->Projects_mdl->subtaskDetailsArr($_GET['subTaskId']);
        $projectId = $this->data['taskDetailsArr']['projectId'];
        $this->data['proDetailsArr'] = $this->Projects_mdl->proDetailsArr($projectId);
        $notiFor = $_GET['notiFor'];
        $this->data['notiFor'] = $notiFor;
		$sendFrom = 1;
		$this->data['sendFrom'] = $sendFrom;
        $this->data['assignedUserDataArr'] = array();
        if(isset($_GET['nId']) && $_GET['nId']!=''){
            $this->data['notiDetailsArr'] = $this->Notifications_mdl->notiDetailsArr($_GET['nId']);
			// $this->data['notiRecipientsDataArr'] = $this->Notifications_mdl->notiRecipientsDataArr($_GET['nId']);
        }else{
            $this->data['notiDetailsArr'] = array();
			// $this->data['notiRecipientsDataArr'] = array();
        }
        $this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
        $this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
        $this->load->view('Frontend/projects/notifications/ajax-noti-frm-fields',$this->data);
    }
	public function ajaxGenUserProMsgAIContent(){
        echo $this->Notifications_mdl->ajaxGenProMsgAIContent();
    }
	public function sendNotiFromUsersEntry(){
        echo $this->Notifications_mdl->sendNotiFromUsersEntry();
    }
	public function ajaxSelRolesUsersDataArr(){
		if(isset($_GET['roleIds']) && $_GET['roleIds']!=''){
			$universityId = $this->data['sessionDetailsArr']['universityId'];
			$userId = $this->data['sessionDetailsArr']['userId'];
			$this->data['selRolesUsersDataArr'] = $this->Notifications_mdl->ajaxSelRolesUsersDataArr($_GET['roleIds'],$universityId,$userId);
			$roleIdsArr = explode(',',$_GET['roleIds']);
			if(in_array('4',$roleIdsArr)){
				$this->data['userFacultyAccessorDataArr'] = $this->Notifications_mdl->userFacultyAccessorDataArr($userId);
			}else{
				$this->data['userFacultyAccessorDataArr'] = array();
			}	
			if(isset($_GET['nId']) && $_GET['nId']!='' && $_GET['nId']>0){
				$this->data['notiRecipientsDataArr'] = $this->Notifications_mdl->notiRecipientsDataArr($_GET['nId']);
			}else{
				$this->data['notiRecipientsDataArr'] = array();
			}
        	$this->load->view('Frontend/projects/ajax-senior-roles',$this->data);
		}
	}

	public function downloadTask(){
		$proencryptId = $this->uri->segment(3);
		if(isset($proencryptId) && $proencryptId!=''){
			$userId = $this->data['sessionDetailsArr']['userId'];
			$this->data['projectDetails'] = $this->Projects_mdl->projectDetailsByeIdArr($proencryptId);
			$projectId = $this->data['projectDetails']['projectId'];
			$proTaskListDataArr = $this->Projects_mdl->userProTaskListDataArr($projectId,$userId);
			$proWiseCompletedTaskListDataArr = $this->Projects_mdl->proWiseCompletedTaskListDataArr($projectId,$userId);

			$etimeZoneId = 4;
			$timezone_array = $this->config->item('timezone_array_config');
			$timezone = $timezone_array[$etimeZoneId]['timezone'];
			$offset = str_replace(':','',$timezone_array[$etimeZoneId]['offset']);
			$short_name = str_replace(':','',$timezone_array[$etimeZoneId]['short_name']);

			$ics = "BEGIN:VCALENDAR\r\n";
			$ics .= "PRODID:-//Assessment Made Easy Everyday//EN\r\n";
			$ics .= "VERSION:2.0\r\n";

			// echo '<pre>';print_r($eventsData);die;
			foreach($proTaskListDataArr as $task){				
				
				$ics .= "BEGIN:VTIMEZONE\r\n";
				$ics .= "TZID:".$timezone."\r\n";
				$ics .= "X-LIC-LOCATION:".$timezone."\r\n";
				$ics .= "BEGIN:STANDARD\r\n";
				$ics .= "DTSTART:19700101T000000\r\n";
				$ics .= "TZOFFSETFROM:".$offset."\r\n"; // Can be dynamic, but +0000 is safe fallback
				$ics .= "TZOFFSETTO:".$offset."\r\n";
				// $ics .= "TZNAME:" . $this->timezone_name_to_abbr($timezone) . "\r\n";
				$ics .= "TZNAME:" . $short_name. "\r\n";
				$ics .= "END:STANDARD\r\n";
				$ics .= "END:VTIMEZONE\r\n";

				$priority = '';
				if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
					$priority = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['name'].' priority';
				}
				
				$eventStart = date('Ymd\THis', $task['dueDateStr']);
   				$summary = ucfirst($task['taskName']).' - '.$priority;
				$description = 'Project Tasks of AMEE Flow';//.$event['hostBy'];
				$location = $task['taskName'];

				$status = 'CONFIRMED'; 				
				$ics .= "BEGIN:VEVENT\r\n";
				$ics .= "UID:" . $task['taskId'].$task['dueDateStr'] . "\r\n";
				$ics .= "SUMMARY:" . $summary . "\r\n";
				$ics .= "DESCRIPTION:" . $description . "\r\n";
				$ics .= "DTSTART;TZID=".$timezone.":" . $eventStart . "\r\n";
						
				$ics .= "LOCATION:" . $location . "\r\n";
				$ics .= "STATUS:" . $status . "\r\n";
				$ics .= "END:VEVENT\r\n";			
			}	
			
			
			echo $ics .= "END:VCALENDAR";

			
			header('Content-type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename=tasks.ics');
 			echo $ics;

			 
		}
	}
}