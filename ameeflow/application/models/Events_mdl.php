<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_mdl extends CI_Model {
	
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

	public function getAssessmentDetails(){
		$this->db->where('id', 4);
		$qryCms = $this->db->get('cms');
		return $qryCms->row();
	}
	
	public function assessmentWeekEventsArr(){
		$cmsDetails = $this->getAssessmentDetails();		
		$startDate = $cmsDetails->image;
		$endDate = $cmsDetails->add_date;
		
		$this->db->select('e.*, org.organizationName');
		$this->db->from('events as e');
		$this->db->where('e.memberId in (select memberId from naw_organizations_members where pcMemSts=1)');		
		$this->db->where('e.eventDate >= ', $startDate);
		$this->db->where('e.eventDate <= ', $endDate);
		$this->db->where('e.isStatus', '0');
		$this->db->where('e.isDeleted', '0');
		$this->db->order_by('e.eventDate, e.eventTime', 'asc');
		$this->db->join('organizations as org', 'org.organizationId = e.organizationId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
		
	}
	
	public function events_array($pageName){
		$currentDate = strtotime(date('Y-m-d'));

		$cmsDetails = $this->getAssessmentDetails();		
		$startDate = $cmsDetails->image;
		$endDate = $cmsDetails->add_date;

		/*if($pageName=='upcoming'){
			$this->db->where('eventDate >= ', $currentDate);
		}else if($pageName=='previous'){
			$this->db->where('eventDate < ', $currentDate);
		}
		$this->db->where('isStatus', '0');
		$this->db->where('isDeleted', '0');
		if($pageName=='upcoming'){
			$this->db->order_by('eventDate, eventTime', 'asc');
		}else{
			$this->db->order_by('eventDate, eventTime', 'desc');
		}
		$query = $this->db->get('events');
		return $query->result_array();*/
		
		
		
		
		$this->db->select('e.*, org.organizationName');
		$this->db->from('events as e');
		if($pageName=='upcoming'){
			$this->db->where('e.eventDate >= ', $currentDate);
		}else if($pageName=='previous'){
			$this->db->where('e.eventDate < ', $currentDate);
		}else if($pageName=='recorded'){
			$this->db->where('e.showRecordSts', '1');
		}else if($pageName=='featured'){
			$this->db->where('e.memberId in (select memberId from naw_organizations_members where pcMemSts=1)');		
			$this->db->where('e.eventDate >= ', $startDate);
			$this->db->where('e.eventDate <= ', $endDate);
		}
		$this->db->where('e.isStatus', '0');
		$this->db->where('e.isDeleted', '0');
		if($pageName=='upcoming' || $pageName=='featured'){
			$this->db->order_by('e.eventDate, e.eventTime', 'asc');
		}else{
			$this->db->order_by('e.eventDate, e.eventTime', 'desc');
		}
		$this->db->join('organizations as org', 'org.organizationId = e.organizationId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
		
		
	}
	
	public function admin_events_array($pageName){
		$currentDate = strtotime(date('Y-m-d'));
		$this->db->select('e.*, org.organizationName');
		$this->db->from('events as e');
		if($pageName=='upcoming'){
			$this->db->where('e.eventDate >= ', $currentDate);
		}else if($pageName=='previous'){
			$this->db->where('e.eventDate < ', $currentDate);
		}
		$this->db->where('e.isDeleted', '0');
		if($pageName=='upcoming'){
			$this->db->order_by('e.eventDate, e.eventTime', 'asc');
		}else{
			$this->db->order_by('e.eventDate, e.eventTime', 'desc');
		}
		$this->db->join('organizations as org', 'org.organizationId = e.organizationId', 'LEFT');
		$query = $this->db->get();
		return $query->result();
		
		
	}
	
	public function event_delete($encryptId){
		$this->db->where('encryptId',$encryptId); 
		$this->db->update('events', array("isDeleted"=>'1'));
		$this->session->set_flashdata('success', 'Deleted successfully!'); 
	}
	
	public function my_events_array($memberId){
		$this->db->order_by('eventId', 'desc');
		$query = $this->db->get_where('events', array('memberId' =>$memberId, "isDeleted"=>'0'));
		return $query->result_array();
	}
	
	public function event_details($encryptId){
		//$query = $this->db->get_where('events', array('encryptId' =>$encryptId));
		//return $query->row();		
		$this->db->select('e.*, org.organizationName, mem.firstName, mem.lastName, mem.email');
		$this->db->from('events as e');
		$this->db->where('e.encryptId', $encryptId);
		$this->db->join('organizations as org', 'org.organizationId = e.organizationId', 'LEFT');
		$this->db->join('organizations_members as mem', 'mem.memberId = e.memberId', 'LEFT');
		$query = $this->db->get();
		return $query->row();
	}
	
	public function manage_entry($callFrom=0){ // 0=User calling, 1=Admin Calling 
		
 		$pageLstSegName = 'upcoming'; // only for admin calling 
		if(isset($_POST['h_previous_event_sts']) && $_POST['h_previous_event_sts']!='' && $_POST['h_previous_event_sts']=='yes'){
			$pageLstSegName = 'previous';
		}
		
		$memberId = trim($this->input->post('h_memberId'));
		$organizationId = trim($this->input->post('h_organizationId'));
		
		$eventId = trim($this->input->post('h_eventId'));
		$eventType = trim($this->input->post('eventType'));
		$eventTitle = trim($this->input->post('eventTitle'));
		$eventSlug = create_slug_ch($eventTitle);
		
		if(isset($eventId) && $eventId!='' && $eventId>0){
			$this->db->where('eventId != ', $eventId);
		}		
		$this->db->where('memberId', $memberId);
		$this->db->where('eventType', $eventType);
		$this->db->where('eventSlug', $eventSlug);
		$query = $this->db->get('events');
		$num = $query->num_rows();
		if($num==0){
		
			$createDate = strtotime(date('Y-m-d'));
			$createMonth = date('m');
			$createYear = date('Y');
			$createTime = time();
			$eventDate = strtotime($this->input->post('eventDate'));
			//$eventTime = strtotime($this->input->post('eventTime'));
			
			$eventTime = strtotime(date('Y-m-d',$eventDate).' '.$_POST['eventTime']);
			
			$timeZone = $this->input->post('timeZone');
			$costSts = $this->input->post('costSts');
 			$eventCost = $this->input->post('eventCost');
			$eventURL = $this->input->post('eventURL');
			$eventLocation = $this->input->post('eventLocation');
			$eventDesc = $this->input->post('eventDesc');
			$isStatus = $this->input->post('isStatus');
			$recordDocType = $this->input->post('recordDocType');	
			
			if(isset($_POST['h_previous_event_sts']) && $_POST['h_previous_event_sts']!='' && $_POST['h_previous_event_sts']=='yes'){ // only for updating the recorded events in admin
				$shortCode='';
				$recordedDocExt = '';
				$recordedDocName = '';
				$showRecordSts = $this->input->post('showRecordSts');
				if($showRecordSts==1){
									
					if($recordDocType==1){
						if(isset($_POST['videoURL']) && $_POST['videoURL']!=''){	
							$videoURL = $this->input->post('videoURL');
							if(strpos($videoURL, 'youtu') !== false){
								$shortCode = $this->get_youtube_short_code($videoURL);		
							}	
						}				
					}else if($recordDocType==2){
					
							if(isset($_FILES['upDoc']['name']) && $_FILES['upDoc']['name']!=''){
								
								$fil_exp = explode(".", trim($_FILES['upDoc']['name']));
								$ext = end($fil_exp);
								$dcoument_pdf_thumb = time();
								$dcoument_upload = trim($dcoument_pdf_thumb.'.'.$ext);
								
								$config['file_name'] = $dcoument_upload;
								$config['upload_path'] = './assets/upload/events/';
								$config['allowed_types'] = 'pdf|doc|docx|pptx|xlsx|xls|csv|txt|ppt';
								$this->load->library('upload');
								$this->upload->initialize($config);
								$this->upload->do_upload('upDoc');
								$errors = $this->upload->display_errors('<span>', '</span>');
								if(isset($errors) && $errors!=''){
									return 'error||'.$errors;
								}else{
									$recordedDocExt = $ext;
									$recordedDocName = $dcoument_upload;
 									if($ext=='pdf'){								
										$this->genPdfThumbnail('./assets/upload/events/'.$dcoument_upload, $dcoument_pdf_thumb.'.png');
									}								
								}
								
							}else{
								return 'error||Oops, document is required for recorded event.';
							}
					}
				}
				
				$this->db->where('eventId',$eventId); 
				$this->db->update('events', array('showRecordSts'=>$showRecordSts, 'recordDocType'=>$recordDocType, 'shortCode'=>$shortCode, 'recordedDocExt'=>$recordedDocExt, 'recordedDocName'=>$recordedDocName));
			
			}
			
			$eventData = array('organizationId'=>$organizationId, 'memberId'=>$memberId, 'eventType'=>$eventType, 'eventTitle'=>$eventTitle, 'eventSlug'=>$eventSlug, 'eventDate'=>$eventDate, 'eventTime'=>$eventTime,'timeZone'=>$timeZone, 'costSts'=>$costSts, 'eventCost'=>$eventCost, 'eventURL'=>$eventURL, 'eventLocation'=>$eventLocation, 'eventDesc'=>$eventDesc, 'isStatus'=>$isStatus, 'updatedOn'=>$createTime);
			
			if(isset($eventId) && $eventId!='' && $eventId>0){
				
				$updatedEventId = $eventId;
				$this->db->where('eventId',$eventId); 
				$this->db->update('events', $eventData);
				$this->session->set_flashdata('success', 'Updated successfully!'); 
				
			}else{				
				
				$this->db->insert('events',$eventData);
				$insertedId = $this->db->insert_id();
				$updatedEventId = $insertedId;
				$encryptId = md5($insertedId).$insertedId;
				$this->db->where('eventId',$insertedId); 
				$this->db->update('events', array("encryptId"=>$encryptId, 'createDate'=>$createDate, 'createMonth'=>$createMonth, 'createYear'=>$createYear, 'createTime'=>$createTime));
				$this->session->set_flashdata('success', 'Added successfully!'); 
				
			}
			
			
			
			if(isset($_FILES['eventImg']['name']) && $_FILES['eventImg']['name']!=''){
				
				$img_data_check = getimagesize($_FILES["eventImg"]['tmp_name']);
				$img_check_width = $img_data_check[0];
				$img_check_height = $img_data_check[1];
				
				$path = './assets/upload/events/';
				$fil_exp = explode(".", $_FILES['eventImg']['name']);
				$fileExt = strtolower(end($fil_exp));
				$fileName = time().".".$fileExt;
				$new_file_name = trim($fileName);
				
				$imgresize = common_ImageResize('400', '250', 'eventImg', $path, $new_file_name, $fileExt);
				if(isset($imgresize) && $imgresize=='0'){
					
					$this->db->where('eventId',$updatedEventId); 
					$this->db->update('events', array("eventImg"=>$new_file_name));
					if($callFrom==0){
						return 'success||'.base_url().'events/my';
					}else{
						return 'success||'.base_url().$this->config->item('admin_directory_name').'events/listing/'.$pageLstSegName;
					}
				
				}else if(isset($imgresize) && $imgresize=='1'){
					return 'error||Oops, unknown image extension.';
				}else if(isset($imgresize) && $imgresize=='2'){
					return 'error||You have exceeded the size limit';
				}
				
			}else{
				if($callFrom==0){
					return 'success||'.base_url().'events/my';
				}else{
					return 'success||'.base_url().$this->config->item('admin_directory_name').'events/listing/'.$pageLstSegName;
				}
			}			
		
		}else{
			return 'error||Oops, event already exist!';
		}
		
		
	}
	
	public function get_youtube_short_code($video_link_path){
	
		$shortName='';
		
		if(strpos($video_link_path, '?v=') !== false){
				
			$video_link_path_arr = explode('?v=',$video_link_path);
			if(strpos($video_link_path_arr[1], '&') !== false){
				$video_link_path_arr1 = explode('&',$video_link_path_arr[1]);
				$shortName=$video_link_path_arr1[0];
			}else{
				$shortName=$video_link_path_arr[1];
			}
			
		}else{
			
			if(strpos($video_link_path, 'embed/') !== false){
				$video_link_path_arr = explode('embed/',$video_link_path);
				if(strpos($video_link_path_arr[1], '/') !== false){
					$video_link_path_arr1 = explode('/',$video_link_path_arr[1]);
					$shortName=$video_link_path_arr1[0];
				}else{
					$shortName=$video_link_path_arr[1];
				}
			}else{
				$video_link_path_arr = explode('.be/',$video_link_path);
				$shortName=$video_link_path_arr[1];
			}
			
		}
		return $shortName;
	}
	
	public function genPdfThumbnail($source, $target){
		$im = new Imagick($source."[0]"); // 0-first page, 1-second page
		$im->setImageColorspace(255); // prevent image colors from inverting
		$im->setimageformat("png");
		$im->thumbnailimage(400, 250, true, true); // width and height
		$im->writeimage('./assets/upload/events/'.$target);
		$im->clear();
		$im->destroy();
	}
	
	public function update_event_status($eventId,$column_name,$status){	
		$data = array("$column_name"=>$status);
		$this->db->where('eventId', $eventId);
		$this->db->update('events',$data);		
		return 'success';
	}
	
 
	
}