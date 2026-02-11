<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title'] = $this->config->item('product_name'); 
		$this->load->model('Notifications_mdl');
		$this->load->model('Course_enrollment_mdl');  		 
 	}

	public function chkPass(){
		echo base64_decode('Mk1tMzMzMTMyIQ==');
	}

	// public function smanageAccessUserData(){
	// 	$this->db->where('spId <= ', 26);
	// 	$query = $this->db->get('sampling_plans');
	// 	$asTskRes = $query->result_array();
	// 	foreach($asTskRes as $as){		 
			 

	// 		$this->db->where('userId', $as['userId']);
	// 		$qruUni = $this->db->get('users');
	// 		$uDetails = $qruUni->row_array();	
			
	// 		$this->db->where('auEmailId', $uDetails['userEmail']);
	// 		$uUni = $this->db->get('users_access');
	// 		$uaDetails = $uUni->row_array();
			  

	// 		$this->db->where('spId',$as['spId']); 
	// 		$this->db->update('sampling_plans', array("userAccessId"=>$uaDetails['userAccessId'])); 

		 
	// 		echo '<br>';
	// 	}
	// }

	// public function manageAccessUserData(){
	// 	$this->db->where('isDeleted', 0);
	// 	$this->db->order_by('userId', 'asc');
	// 	$query = $this->db->get('users');
	// 	$asTskRes = $query->result_array();
	// 	foreach($asTskRes as $as){		 

	// 		$this->db->where('universityId', $as['universityId']);
	// 		$qruUni = $this->db->get('university');
	// 		$uniDetails = $qruUni->row_array();			
			
	// 		$this->db->insert('users_access', array('auserId'=>$as['userId'], 'addedBy'=>'0', 'auName'=>$as['userName'], 'auEmailId'=>$as['userEmail'], 'auCreatedOn'=>$as['createTime']));
	// 		$userAccessId = $this->db->insert_id();
	// 		$uaeId = generateRandomNumStringCh(2).'au'.$userAccessId.generateRandomNumStringCh(2);
	// 		$shortName = strtoupper(create_slug_ch(strip_tags($uniDetails['shortName'])));
	// 		$auLoginId = $shortName.'-'.$uaeId;

	// 		$this->db->where('userId',$as['userId']); 
	// 		$this->db->update('users', array("loginID"=>$auLoginId));                        

	// 		$this->db->where('userAccessId',$userAccessId); 
	// 		$this->db->update('users_access', array("uaeId"=>$uaeId, "auLoginId"=>$auLoginId, "auPassword"=>$as['password'], "auRamdomId"=>$as['randomId']));


	// 	}
	// }

	public function chkEmail(){

		$userEmail = 'sakile.camara@csun.edu';
		$fullName = 'Sakile';
		 
		// $userEmail = 'tns.ankit@gmail.com';
		// $fullName = 'Ankit';
 
		$subject = 'Access Your Project Dashboard';
		$message = '<p>Dear Ankit Bhogre,</p><p>AMEE Flow is designed to make project management more efficient, organized, and collaborative. As a member of the project team, you now have access to a streamlined workspace tailored to your role.</p>';
		chk_send_mail($userEmail,$message,$fullName,'info',$subject); 

	}
	
	public function ameelab(){  
		$this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));
		$this->data['pageTitle']='AMEE Lab';
		$this->data['active_class'] = 'ameelab-menu';
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/amee-lab',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
	}

	public function ajaxFormFields(){  
		if(isset($_GET['copySts']) && $_GET['copySts']!='' && $_GET['copySts']>0){
			$this->data['copySts'] = 1;
		}else{
			$this->data['copySts'] = 0;
		}
		
        if(isset($_GET['eId']) && $_GET['eId']!='' && $_GET['eId']>0){
			$this->load->model('Calendar_mdl');
            $this->data['eventDetails'] = $this->Calendar_mdl->eventDetailsArr($_GET['eId']);
        }else{
            $this->data['eventDetails'] = array();
        }
		$this->data['selDate'] = $_GET['selDate'];
        $this->load->view('Frontend/calendar/manage-frm',$this->data);
    }

	public function saveEvent(){
		$this->load->model('Calendar_mdl');
		echo $this->Calendar_mdl->saveEvent();
	}

	public function ajaxEventDetails(){        
        if(isset($_GET['eId']) && $_GET['eId']!='' && $_GET['eId']>0){
			$this->load->model('Calendar_mdl');
			$this->data['ucreatedBy'] = $_GET['createdBy'];
			$this->data['ucreatedById'] = $_GET['createdById'];
            $this->data['eventDetails'] = $this->Calendar_mdl->eventDetailsArr($_GET['eId']);
			$this->load->view('Frontend/calendar/view-event',$this->data);
        }        
    }

	public function deleteEvent(){        
        if(isset($_GET['eId']) && $_GET['eId']!='' && $_GET['eId']>0){
			$this->load->model('Calendar_mdl');
            echo $this->Calendar_mdl->deleteEvent($_GET['eId']);
        }        
    }

	public function ajaxSPreport(){
		$this->data['sessionDetailsArr'] = $this->Users_mdl->userDetails($_GET['userId']);
		$reportFor = $_GET['reportFor'];
		$this->data['reportFor'] = $_GET['reportFor'];
		if($reportFor==1){        
			$this->data['spDetails'] = $this->Course_enrollment_mdl->sampling_plans_details($_GET['chkenId']);
			$spId = $this->data['spDetails']['spId'];
			$this->data['samplingPlanCoursesDataArr'] = $this->Course_enrollment_mdl->samplingPlanCoursesDataArr($_GET['userId'],$spId);
		}else if($reportFor==2){
			$this->load->model('Loads_report_mdl');
			$this->data['reportDetails'] = $this->Loads_report_mdl->reportDetailsByeIdArr($_GET['chkenId']);
		}else{
			$this->load->model('General_reports_mdl');
			$this->data['reportDetails'] = $this->General_reports_mdl->reportDetailsByeIdArr($_GET['chkenId']);
		}
        $this->load->view('system-admin/team-reports/ajax-view-report',$this->data);
    }

	public function sentNotification(){
		$enrecpId = $this->uri->segment(3);
		if(isset($enrecpId) && $enrecpId!=''){
			$this->data['ntDetails'] = $this->Notifications_mdl->sentNotificationDetails($enrecpId);
			// $this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
        	$this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
			// echo '<pre>';print_r($this->data['ntDetails']);die;	
			$this->load->view('Frontend/notifications/recp-action',$this->data);
		}
	}

	public function submitNotiResEntry(){
		echo $this->Notifications_mdl->submitNotiResEntry();
	}
	
	public function sharedReport(){
		$enwithShareId = $this->uri->segment(3);
		if(isset($enwithShareId) && $enwithShareId!=''){
			$this->data['sharedWith'] = $this->Notifications_mdl->sharedWithDetails($enwithShareId);
			$userId = $this->data['sharedWith']['userId'];
			$reportFor = $this->data['sharedWith']['reportFor'];
			$chkenId = $this->data['sharedWith']['chkenId'];
			$share_report_for_array = $this->config->item('share_report_for_array_config')[$reportFor];
			$this->data['title'] = $share_report_for_array['name'];
			$this->data['sessionDetailsArr'] = $this->Users_mdl->userDetails($userId);
			// echo '<pre>';print_r($this->data['sharedWith']);die;			
			
			if($reportFor==1){
				$this->data['spDetails'] = $this->Course_enrollment_mdl->sampling_plans_details($chkenId);
				$spId = $this->data['spDetails']['spId'];
				$this->data['samplingPlanCoursesDataArr'] = $this->Course_enrollment_mdl->samplingPlanCoursesDataArr($userId,$spId); 
			}else if($reportFor==2){
				$this->load->model('Loads_report_mdl');
				$this->data['reportDetails'] = $this->Loads_report_mdl->reportDetailsByeIdArr($chkenId);
			}else{
				$this->load->model('General_reports_mdl');
				$this->data['reportDetails'] = $this->General_reports_mdl->reportDetailsByeIdArr($chkenId);
			}
						
			$this->load->view('Frontend/notifications/submitted-report',$this->data);
		}else{
			
		}
	}

	public function submitSharedEntry(){
		$this->load->model('Notifications_mdl');
		echo $this->Notifications_mdl->submitSharedEntry();
	}

	public function approveSharedsp(){
		$this->load->model('Notifications_mdl');
		echo $this->Notifications_mdl->approveSharedsp();
	}

	public function ajaxNotiMsgModal(){
        if(isset($_GET['nId']) && $_GET['nId']!=''){
			$this->load->model('Notifications_mdl');
            $this->data['notiDetailsArr'] = $this->Notifications_mdl->notiDetailsArr($_GET['nId']);
            $this->load->view('Frontend/ajax/notification-msg-view',$this->data);
        }
    }

	public function ajaxViewRecipientsLog(){
        if(isset($_GET['nId']) && $_GET['nId']!=''){
			$this->load->model('Notifications_mdl');
            $this->data['notiDetailsArr'] = $this->Notifications_mdl->notiDetailsArr($_GET['nId']);
			$this->data['notiRecipientsLogArr'] = $this->Notifications_mdl->notiRecipientsLogArr($_GET['nId']);
			$this->data['resOptionsArr'] = $this->Notifications_mdl->resOptionsArr();
        	$this->data['resOptionsChoiceArr'] = $this->Notifications_mdl->resOptionsChoiceArr();
            $this->load->view('Frontend/ajax/notification-recipients-log',$this->data);
        }
    }

	public function ajaxSPAIContent(){
		if(isset($_GET['submitFor']) && $_GET['submitFor']!=''){
			$this->data['aiShareContent'] = $this->Notifications_mdl->generateSPshareContent($_GET['submitFor'],$_GET['reportFor'],$_GET['userId']);
			$this->load->view('Frontend/reports/sampling_plan/ajax-share-ai-msg',$this->data);
		}
	}
	public function shareSamplingPlan(){
		if(isset($_POST['h_chkuserId']) && $_POST['h_chkuserId']!='' && isset($_POST['h_chkuniversityId']) && $_POST['h_chkuniversityId']!=''){
			$userId = $_POST['h_chkuserId'];
			$universityId = $_POST['h_chkuniversityId'];
			echo $this->Notifications_mdl->shareSamplingPlan($userId,$universityId);
		}
	}
	public function viewFeedback(){
		if(isset($_GET['chkId']) && $_GET['chkId']!=''){
			$this->data['feedbackDataArr'] = $this->Notifications_mdl->feedbackDataArr($_GET['chkId'],$_GET['shareReportFor']);
			$this->load->view('Frontend/reports/sampling_plan/ajax-feedbacks',$this->data);
		}
	}

	public function shareAlignmentMap(){
		if(isset($_POST['mamId']) && $_POST['mamId']!=''){
			$this->load->model('Master_alignment_map_mdl');
			echo $this->Master_alignment_map_mdl->shareAlignmentMap();
		}
	}

	public function ticketEntry(){			
		$this->load->model('Backend/Tickets_mdl');		
		echo $this->Tickets_mdl->generate_ticket();		
	}
	
	public function conversationEntry(){			
		$this->load->model('Backend/Tickets_mdl');		
		echo $this->Tickets_mdl->comment_entry();		
	}

	public function ticket_update_status(){
		if(isset($_GET['id']) && $_GET['id']!='' && isset($_GET['ticket_status']) && $_GET['ticket_status']!=''){
			$this->load->model('Backend/Tickets_mdl');	
			$this->Tickets_mdl->update_status_ticket($_GET['id'],$_GET['ticket_status']);
		}  			
	}	
	
	public function ticket_delete(){		
		if(isset($_GET['utId']) && $_GET['utId']!=''){
			$this->load->model('Backend/Tickets_mdl');	
			$this->Tickets_mdl->delete_ticket($_GET['utId']);
		}
		redirect($_GET['r'].'tickets');
	}

	function timezone_name_to_abbr($timezone_name) {
		$dt = new DateTime("now", new DateTimeZone($timezone_name));
		return $dt->format('T'); // e.g. "EST", "IST", "CET"
	}

	public function downloadIcs(){
		if(isset($_GET['eneId']) && $_GET['eneId']!=''){			
			$ics = "BEGIN:VCALENDAR\r\n";
			$ics .= "PRODID:-//Assessment Made Easy Everyday//EN\r\n";
			$ics .= "VERSION:2.0\r\n";
			$this->load->model('Calendar_mdl');			
			$eventsData = $this->Calendar_mdl->eventDetailsArrByeneId($_GET['eneId']); 

			// echo '<pre>';print_r($eventsData);die;
			foreach($eventsData as $event){
				
				$timezone_array = $this->config->item('timezone_array_config');
				$timezone = $timezone_array[$event['etimeZoneId']]['timezone'];
				$offset = str_replace(':','',$timezone_array[$event['etimeZoneId']]['offset']);
				$short_name = str_replace(':','',$timezone_array[$event['etimeZoneId']]['short_name']);
				
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
				
				$eventStart = date('Ymd\THis', $event['stime']);
   				$summary = ucfirst($event['eTitle']);
				// $description = 'AMEE Flow Events';//.$event['hostBy'];
				$description = strip_tags($event['eDesc']);
				$location = $event['eTitle'];

				$status = 'CONFIRMED'; 				
				$ics .= "BEGIN:VEVENT\r\n";
				$ics .= "UID:" . $event['eneId'] . "\r\n";
				$ics .= "SUMMARY:" . $summary . "\r\n";
				$ics .= "DESCRIPTION:" . $description . "\r\n";
				$ics .= "DTSTART;TZID=".$timezone.":" . $eventStart . "\r\n";
				if(isset($event['etime']) && $event['etime']!='' && $event['etime']>0){
					$eventEnd = date('Ymd\THis', $event['etime']);
					$ics .= "DTEND;TZID=".$timezone.":" . $eventEnd . "\r\n";
				}		
				$ics .= "LOCATION:" . $location . "\r\n";
				$ics .= "STATUS:" . $status . "\r\n";
				$ics .= "END:VEVENT\r\n";			
			}			
			$ics .= "END:VCALENDAR";
			header('Content-type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename=event.ics');
 			echo $ics;

			 
		}
	}

	public function emptyData(){ // check email_templates table have to remove universities emails
		// $this->db->truncate('course_enrollment');
		// $this->db->truncate('course_enrollment_classes');
		// $this->db->truncate('master_alignment_maps');
		// $this->db->truncate('master_alignment_maps_courses');
		// $this->db->truncate('master_alignment_maps_oversights');
		// $this->db->truncate('projects');
		// $this->db->truncate('projects_assign_roles');
		// $this->db->truncate('projects_subtasks');
		// $this->db->truncate('projects_tasks');
		// $this->db->truncate('projects_tasks_users_sts');
		// $this->db->truncate('university');
		// $this->db->truncate('university_admins');
		// $this->db->truncate('users');
		// $this->db->truncate('sampling_plans');
		// $this->db->truncate('sampling_plans_courses');
		// $this->db->truncate('sampling_plans_share');
		// $this->db->truncate('sampling_plans_share_with');
		// $this->db->truncate('senior_roles');

		// $this->db->truncate('projects_notifications');
		// $this->db->truncate('notifications_recipients');
	}



	public function sharedAlignmentMap(){
		$this->load->model('Master_alignment_map_mdl');
		$enwithShareId = $this->uri->segment(3);
		if(isset($enwithShareId) && $enwithShareId!=''){
			$this->data['enwithShareId'] = $enwithShareId;
			$this->data['sharedWith'] = $this->Master_alignment_map_mdl->sharedWithDetails($enwithShareId);
			$userId = $this->data['sharedWith']['userId'];			 
			$mamId = $this->data['sharedWith']['mamId'];

			$this->data['mamDetailsArr'] = $this->Master_alignment_map_mdl->mamDetailsArr($mamId);
			$universityId = $this->data['mamDetailsArr']['universityId'];
			$uniAdminId = $this->data['mamDetailsArr']['uniAdminId'];
			$this->data['oversightsDataArr'] = $this->Master_alignment_map_mdl->oversightsDataArr($universityId,$uniAdminId);
			if(isset($_GET['osd']) && $_GET['osd']!='' && $_GET['osd']>0){
				$oversigntId = $_GET['osd'];
			}else{
				$oversigntId = $this->data['oversightsDataArr'][0]['oversigntId'];            
			}
			$this->data['seloversigntId'] = $oversigntId;            
			$this->data['cousesDataArr'] = $this->Master_alignment_map_mdl->alignmentCousesDataArr($universityId,$uniAdminId,$oversigntId);
			
			$this->data['sharePermission'] = 0;
			$this->data['title'] = 'Master Alignment Map';
			$this->data['sessionDetailsArr'] = $this->Users_mdl->userDetails($userId);
			//   echo '<pre>';print_r($this->data['sharedWith']);die;			
			
			// $this->data['reportDetails'] = $this->Loads_report_mdl->reportDetailsByeIdArr($chkenId);
						
			$this->load->view('Frontend/reports/alignment_map/submitted-mam',$this->data);
		}else{
			
		}
	}

	public function submitSharedAMEntry(){
		$this->load->model('Master_alignment_map_mdl');
		echo $this->Master_alignment_map_mdl->submitSharedAMEntry();
	}

	public function helpGuide(){
		$guideFor = $this->uri->segment(3);
		if(isset($guideFor) && $guideFor!=''){
			$conDetails = $this->Settings_mdl->configuration_details();
			if($guideFor=='project-manager'){				
				$guideName = $conDetails->pmGuide;
			}else if($guideFor=='area-expert'){				
				$guideName = $conDetails->areaExpertGuide;
			}else{
				$guideName = $conDetails->userGuide;
			}
			redirect(base_url().'assets/guide/'.$guideName);
		}
	}

	
	
}