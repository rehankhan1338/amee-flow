<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications_mdl extends CI_Model {
	
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

	public function notiRecipientsDataArr($nId){
		$this->db->where('nId', $nId);
		$this->db->where('activeSts', 0);
		$query = $this->db->get('notifications_recipients');
		return $query->result_array();
	}

	public function resOptionsArr(){
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('notifications_resoptions');
		return $query->result_array();
	}

	public function resOptionsChoiceArr(){
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('notifications_resoptions_choice');
		return $query->result_array();
	}

	public function notiDetailsArr($nId){
		$this->db->where('nId', $nId);
		$query = $this->db->get('projects_notifications');
		return $query->row_array();
	}

	public function notiRecipientsLogArr($nId){
		$this->db->where('nId', $nId);
		$this->db->where('activeSts', 0);
		$query = $this->db->get('notifications_recipients');
		return $query->result_array();
	}

	public function proSentNotificaionsDataArr($taskId,$sentById,$notiFor){
		$this->db->where('notiFor', $notiFor);
		$this->db->where('taskId', $taskId);
		$this->db->where('sentById', $sentById);
		$this->db->where('sendFrom', 0);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('onTime', 'desc');
		$query = $this->db->get('projects_notifications');
		return $query->result_array();
	}

	public function proSentUserNotificaionsDataArr($taskId,$subTaskId,$sentById,$notiFor){
		$this->db->where('notiFor', $notiFor);
		$this->db->where('taskId', $taskId);
		$this->db->where('subTaskId', $subTaskId);
		$this->db->where('sentById', $sentById);
		$this->db->where('sendFrom', 1);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('onTime', 'desc');
		$query = $this->db->get('projects_notifications');
		return $query->result_array();
	}

	public function getGuestAccessListByAE($userId){
		$this->db->select('auName, userAccessId');
		$this->db->where('auserId', $userId);
		$this->db->where('addedBy > ', 0);
		$this->db->where('auIsActive', 0);
		$this->db->where('auIsDeleted', 0);
		$this->db->order_by('auName', 'asc');
		$query = $this->db->get('users_access');
		return $query->result_array();
	}

	public function sendProNotiEntry(){
		$recipientsCnt = 0;
		$recipientsIdsArr = array();
		$recipientsIds = '';
		$userAccessCnt = 0;
		$userAccessIdsArr = array();
		$userAccessIds = '';
		if(isset($_POST['assuIds']) && $_POST['assuIds']!=''){
            if(count($_POST['assuIds'])>0){
				$recipientsCnt = count($_POST['assuIds']);

				foreach($_POST['assuIds'] as $assuIdsArr){
					$recipientsIdsChk = explode('||',$assuIdsArr);
					if(!in_array($recipientsIdsChk[0],$recipientsIdsArr)){
						$recipientsIdsArr[] = $recipientsIdsChk[0];
					}
					if(!in_array($recipientsIdsChk[1],$userAccessIdsArr)){
						if($recipientsIdsChk[1]>0){
							$userAccessIdsArr[] = $recipientsIdsChk[1];
						}
					}
				}
				
				$recipientsIds = implode(',',$recipientsIdsArr);
				
				$userAccessCnt = count($userAccessIdsArr);
				$userAccessIds = implode(',',$userAccessIdsArr);
			 

				$nIdChk = $this->input->post('ntnId');

				$sendDateArr = explode('/',$this->input->post('ntsendDate'));
				$sendDate = strtotime($sendDateArr[2].'-'.$sendDateArr[0].'-'.$sendDateArr[1]);
				
				$followupDate = 0;
				if(isset($_POST['ntfollowupDate']) && $_POST['ntfollowupDate']!=''){
					$followupDateArr = explode('/',$this->input->post('ntfollowupDate'));
					$followupDate = strtotime($followupDateArr[2].'-'.$followupDateArr[0].'-'.$followupDateArr[1]);
					if($sendDate==$followupDate){						
						return 'error||Oops, your followup date must different from send date.';
					}					
				}				
						
				$projectId = trim($this->input->post('ntProjectId'));
				$uniAdminId = trim($this->input->post('ntuniAdminId'));
				$universityId = trim($this->input->post('ntuniversityId'));
				$taskId = trim($this->input->post('ntTaskId'));
				$notiFor = $this->input->post('ntNotiFor');
				$topic = $this->input->post('ntTopicName');
				$sendMsg = $this->input->post('ntSendMsg');	
				$resOptionId = $this->input->post('ntresOptionId');			

				$onDate = strtotime(date('Y-m-d'));	
				$onTime = time();	
				$onMonth = date('m');
				$onYear = date('Y');
				
				if(isset($nIdChk) && $nIdChk!='' && $nIdChk>0){
					$nId = $nIdChk;
					$this->db->where('nId',$nId);
					$this->db->update('projects_notifications', array('topic'=>$topic, 'sendMsg'=>$sendMsg, 'recipientsCnt'=>$recipientsCnt, 'recipientsIds'=>$recipientsIds, 'userAccessCnt'=>$userAccessCnt, 'userAccessIds'=>$userAccessIds, 'sendDate'=>$sendDate, 'followupDate'=>$followupDate, 'resOptionId'=>$resOptionId));

					$this->db->where('nId',$nId);
					$this->db->update('notifications_recipients', array('activeSts'=>1));

				}else{
					$this->db->insert('projects_notifications', array('notiFor'=>$notiFor, 'universityId'=>$universityId, 'sentById'=>$uniAdminId, 'projectId'=>$projectId, 'taskId'=>$taskId, 'topic'=>$topic, 'sendMsg'=>$sendMsg, 'recipientsCnt'=>$recipientsCnt, 'recipientsIds'=>$recipientsIds, 'userAccessCnt'=>$userAccessCnt, 'userAccessIds'=>$userAccessIds, 'sendDate'=>$sendDate, 'followupDate'=>$followupDate, 'resOptionId'=>$resOptionId, 'onDate'=>$onDate, 'onTime'=>$onTime, 'onMonth'=>$onMonth, 'onYear'=>$onYear));
					$nId = $this->db->insert_id();
					$enId = generateRandomNumStringCh(4).'nt'.$nId.generateRandomNumStringCh(4);
					$this->db->where('nId',$nId); 
					$this->db->update('projects_notifications', array("enId"=>$enId));
				}				

				if($recipientsCnt>0){
					$this->db->select('userId, userName, userEmail');
					$where = ' userId in ('.$recipientsIds.')';
					$this->db->where($where);
					$query = $this->db->get('users');
					$sendToResArr = $query->result_array();
					foreach($sendToResArr as $resDetails){

						$userId = trim($resDetails['userId']);
						$recpName = trim($resDetails['userName']);
						$recpEmail = trim($resDetails['userEmail']);

						$this->db->where('nId',$nId);
						$this->db->where('userId',$userId);
						$qryRec = $this->db->get('notifications_recipients');
						$recCnt = $qryRec->num_rows();
						if($recCnt==0){
							$this->db->insert('notifications_recipients', array('nId'=>$nId, 'userId'=>$userId, 'recpName'=>$recpName, 'recpEmail'=>$recpEmail));
							$nrecpId = $this->db->insert_id();
							$enrecpId = generateRandomNumStringCh(3).'ntrcp'.$nrecpId.generateRandomNumStringCh(3);
							$this->db->where('nrecpId',$nrecpId); 
							$this->db->update('notifications_recipients', array("enrecpId"=>$enrecpId));
						}else{
							$this->db->where('nId',$nId);
							$this->db->where('userId',$userId);
							$this->db->update('notifications_recipients', array('activeSts'=>0));
						}
						
					}
				}

				
				if(count($userAccessIdsArr)>0){						

					$this->db->select('userAccessId, auserId, auName, auEmailId');
					$where = ' userAccessId in ('.$userAccessIds.')';
					$this->db->where($where);
					$query = $this->db->get('users_access');
					$sendToResArr = $query->result_array();
					foreach($sendToResArr as $resDetails){

						$userAccessId = trim($resDetails['userAccessId']);
						$userId = trim($resDetails['auserId']);
						$recpName = trim($resDetails['auName']);
						$recpEmail = trim($resDetails['auEmailId']);

						$this->db->where('nId',$nId);
						$this->db->where('userId',$userId);
						$this->db->where('userAccessId',$userAccessId);
						$qryRec = $this->db->get('notifications_recipients');
						$recCnt = $qryRec->num_rows();
						if($recCnt==0){
							$this->db->insert('notifications_recipients', array('nId'=>$nId, 'userId'=>$userId, 'userAccessId'=>$userAccessId, 'recpName'=>$recpName, 'recpEmail'=>$recpEmail));
							$nrecpId = $this->db->insert_id();
							$enrecpId = generateRandomNumStringCh(3).'ntrcp'.$nrecpId.generateRandomNumStringCh(3);
							$this->db->where('nrecpId',$nrecpId); 
							$this->db->update('notifications_recipients', array("enrecpId"=>$enrecpId));
						}else{
							$this->db->where('nId',$nId);
							$this->db->where('userId',$userId);
							$this->db->where('userAccessId',$userAccessId);
							$this->db->update('notifications_recipients', array('activeSts'=>0));
						}
						
					}
				}
				

				return 'success||'.$taskId.'||'.$uniAdminId.'||'.$notiFor;
				
			}else{
				return 'error||Oops, please select at least one recipient.';
			}

		}else{
			return 'error||Oops, please select at least one recipient.';
		}  


	}

	public function ajaxSelRolesUsersDataArr($roleIds,$universityId,$userId){
		$this->db->select('roleId, name, email, roleType');
		$where = ' roleType in ('.$roleIds.')';
		$this->db->where($where);
		$this->db->where('userId', $userId);
		$this->db->where('universityId', $universityId);
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('senior_roles');
		return $query->result_array();
	}	

	public function ajaxGenProMsgAIContent(){
		if(isset($_POST['topicName']) && $_POST['topicName']!=''){
			$topicName = $this->input->post('topicName');
			$taskId = trim($this->input->post('taskId'));
			$projectId = trim($this->input->post('projectId'));

			if(isset($_POST['promptId']) && $_POST['promptId']!='' && $_POST['promptId']>0){
				$this->db->where('promptId', $_POST['promptId']);
			}else{
				if(isset($_POST['subTaskId']) && $_POST['subTaskId']!='' && $_POST['subTaskId']>0){
					$this->db->where('promptId', 5);
				}else{
					$this->db->where('promptId', 4);
				}		
			}	
			$query = $this->db->get('prompting');
			$secContent = $query->row_array();

			$inputText = str_replace('{taskName}',$topicName,$secContent['msgUserRole']);			
			$sysInput = $secContent['msgSystemRole'];
			$maxTokens = $secContent['maxTokenCnt'];

			if(isset($inputText) && $inputText!='' && isset($sysInput) && $sysInput!='' && isset($maxTokens) && $maxTokens!=''){ 
				$resArr = customCurlAIh($sysInput,$inputText,$maxTokens);
				if($resArr[0]=='success'){
					//echo '<pre>';print_r($resArr);die;
					if(isset($resArr[1]['choices'][0]['message']['content']) && $resArr[1]['choices'][0]['message']['content']!=''){
						return convertToHtmlAvoidAh($resArr[1]['choices'][0]['message']['content']);                    
					}
				}
			}

			// return $topicName.' content';
			return '';

		}else{
			return '';
		}
	}
	
	public function sendNotiFromUsersEntry(){

		if(isset($_POST['uroleIds']) && $_POST['uroleIds']!=''){
            if(count($_POST['uroleIds'])>0){

				$nIdChk = $this->input->post('ntnId');
				$sendFrom = $this->input->post('ntsendFrom');;
				$sendDateArr = explode('/',$this->input->post('ntsendDate'));
				$sendDate = strtotime($sendDateArr[2].'-'.$sendDateArr[0].'-'.$sendDateArr[1]);
				
				$followupDate = 0;
				if(isset($_POST['ntfollowupDate']) && $_POST['ntfollowupDate']!=''){
					$followupDateArr = explode('/',$this->input->post('ntfollowupDate'));
					$followupDate = strtotime($followupDateArr[2].'-'.$followupDateArr[0].'-'.$followupDateArr[1]);
					if($sendDate==$followupDate){						
						return 'error||Oops, your followup date must different from send date.';
					}					
				}
				
				$recipientsCnt = count($_POST['uroleIds']);
				$recipientsIds = implode(',',$_POST['userRoleTypes']);	
				// $recipientsIds = '';	
				$projectId = trim($this->input->post('ntProjectId'));
				$uniAdminId = trim($this->input->post('ntuniAdminId'));
				$universityId = trim($this->input->post('ntuniversityId'));
				$taskId = trim($this->input->post('ntTaskId'));
				$subTaskId = trim($this->input->post('ntSubTaskId'));
				$notiFor = $this->input->post('ntNotiFor');
				$topic = $this->input->post('ntTopicName');
				$sendMsg = $this->input->post('ntSendMsg');	
				$resOptionId = $this->input->post('ntresOptionId');			

				$onDate = strtotime(date('Y-m-d'));	
				$onTime = time();	
				$onMonth = date('m');
				$onYear = date('Y');
				
				if(isset($nIdChk) && $nIdChk!='' && $nIdChk>0){
					$nId = $nIdChk;
					$this->db->where('nId',$nId);
					$this->db->update('projects_notifications', array('topic'=>$topic, 'sendMsg'=>$sendMsg, 'recipientsCnt'=>$recipientsCnt, 'recipientsIds'=>$recipientsIds, 'sendDate'=>$sendDate, 'followupDate'=>$followupDate, 'resOptionId'=>$resOptionId));

					$this->db->where('nId',$nId);
					$this->db->update('notifications_recipients', array('activeSts'=>1));

				}else{
					$this->db->insert('projects_notifications', array('notiFor'=>$notiFor, 'sendFrom'=>$sendFrom, 'universityId'=>$universityId, 'sentById'=>$uniAdminId, 'projectId'=>$projectId, 'taskId'=>$taskId, 'subTaskId'=>$subTaskId, 'topic'=>$topic, 'sendMsg'=>$sendMsg, 'recipientsCnt'=>$recipientsCnt, 'recipientsIds'=>$recipientsIds, 'sendDate'=>$sendDate, 'followupDate'=>$followupDate, 'resOptionId'=>$resOptionId, 'onDate'=>$onDate, 'onTime'=>$onTime, 'onMonth'=>$onMonth, 'onYear'=>$onYear));
					$nId = $this->db->insert_id();
					$enId = generateRandomNumStringCh(4).'nt'.$nId.generateRandomNumStringCh(4);
					$this->db->where('nId',$nId); 
					$this->db->update('projects_notifications', array("enId"=>$enId));
				}				

				// $this->db->select('userId, userName, userEmail');
				// $where = ' userId in ('.$recipientsIds.')';
				// $this->db->where($where);
				// $query = $this->db->get('users');
				// $sendToResArr = $query->result_array();
				foreach($_POST['uroleIds'] as $assData){

					$assDataArr = explode('||',$assData);
					$recpName = $assDataArr[0];
					$recpEmail = $assDataArr[1];

					$this->db->where('nId',$nId);
					$this->db->where('recpEmail',$recpEmail);
					$qryRec = $this->db->get('notifications_recipients');
					$recCnt = $qryRec->num_rows();
					if($recCnt==0){
						$this->db->insert('notifications_recipients', array('nId'=>$nId, 'userId'=>0, 'recpName'=>$recpName, 'recpEmail'=>$recpEmail));
						$nrecpId = $this->db->insert_id();
						$enrecpId = generateRandomNumStringCh(3).'ntrcp'.$nrecpId.generateRandomNumStringCh(3);
						$this->db->where('nrecpId',$nrecpId); 
						$this->db->update('notifications_recipients', array("enrecpId"=>$enrecpId));
					}else{
						$this->db->where('nId',$nId);
						$this->db->where('recpEmail',$recpEmail);
						$this->db->update('notifications_recipients', array('activeSts'=>0));
					}
					
				}

				return 'success||'.$taskId.'||'.$uniAdminId.'||'.$notiFor.'||'.$subTaskId;
				
			}else{
				return 'error||Oops, please select at least one recipient.';
			}

		}else{
			return 'error||Oops, please select at least one recipient.';
		}  


	}

	public function sentNotificationDetails($enrecpId){
		$this->db->select('nr.*, n.sendMsg, n.topic, n.resOptionId, n.followupDateSts');
		$this->db->from('notifications_recipients as nr');
		$this->db->where('nr.enrecpId', $enrecpId);
		$this->db->join('projects_notifications as n', 'n.nId = nr.nId', 'LEFT');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function submitNotiResEntry(){
		$dbprefix = $this->db->dbprefix;
		$enrecpId = $this->input->post('h_enrecpId');
		$resTxt = $this->input->post('h_resTxt');
		$resOptChoiceId = trim($this->input->post('h_resOptChoiceId'));
		$todayDate = strtotime(date('Y-m-d'));	
		$curTime = time();		
		$this->db->where('enrecpId',$enrecpId); 
		$this->db->update('notifications_recipients', array("resTxt"=>$resTxt,"resOptChoiceId"=>$resOptChoiceId, "resDate"=>$todayDate, "resTime"=>$curTime));				 
		return 'success||'.base_url().'share/notification/'.$enrecpId;	
	}

	public function userFacultyAccessorDataArr($userId){
		$dbprefix = $this->db->dbprefix;
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		// $this->db->select('spc.*, csc.courseTitle, csc.subject, csc.courseNBR, csc.classNBR, csc.firstName, csc.lastName, csc.enrolled');
		$this->db->select('csc.ceClassId, csc.firstName, csc.lastName, csc.facultyEmail, spc.courseSts');
		$this->db->from('sampling_plans_courses as spc');
		$this->db->where('spc.userId', $userId);
		$this->db->where('csc.facultyEmail != ', '');
		$this->db->group_by('csc.lastName,csc.firstName,');		 	
		$this->db->order_by('csc.subject, csc.courseNBR, csc.classNBR', 'asc');
		$this->db->join('course_enrollment_classes as csc', 'csc.ceClassId = spc.ceClassId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function ajaxGetRolesDataArr($roleType,$spId,$userId){
		if($roleType==4){
			$dbprefix = $this->db->dbprefix;
			$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
			$this->db->select('spc.*, csc.courseTitle, csc.subject, csc.courseNBR, csc.classNBR, csc.firstName, csc.lastName, csc.enrolled');
			$this->db->from('sampling_plans_courses as spc');
			// $this->db->where('spc.spId', $spId);
			$this->db->where('spc.userId', $userId);
			$this->db->where('csc.facultyEmail != ', '');
			$this->db->group_by('csc.lastName,csc.firstName,');		 	
			$this->db->order_by('csc.subject, csc.courseNBR, csc.classNBR', 'asc');
			$this->db->join('course_enrollment_classes as csc', 'csc.ceClassId = spc.ceClassId', 'LEFT');
			$query = $this->db->get();
			return $query->result_array();
		}else{
			$this->db->where('roleType', $roleType);
			$this->db->where('userId', $userId);
			$this->db->where('isActive', 0);
			$this->db->where('isDeleted', 0);
			$this->db->order_by('name', 'asc');
			$query = $this->db->get('senior_roles');
			return $query->result_array();
		}
	}

	public function sharedWithDetails($enwithShareId){
		$this->db->select('sw.*, s.*');
		$this->db->from('sampling_plans_share_with as sw');
		$this->db->where('sw.enwithShareId', $enwithShareId);
		$this->db->join('sampling_plans_share as s', 's.shareId = sw.shareId', 'LEFT');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function generateSPshareContent($submitFor,$reportFor,$userId){
		$share_report_for_array = $this->config->item('share_report_for_array_config')[$reportFor];
		if($submitFor==1){			
			$promptId = $share_report_for_array['reviewPromptId'];
		}else{
			$promptId = $share_report_for_array['approvalPromptId'];
		}
		$this->db->where('promptId', $promptId);
        $query = $this->db->get('prompting');
        $secContent = $query->row_array();
        // $inputText = str_replace('{allCategories}',$catNamesOnly,$secContent['msgUserRole']);
		$inputText = $secContent['msgUserRole'];			
        $sysInput = $secContent['msgSystemRole'];
        $maxTokens = $secContent['maxTokenCnt'];
        if(isset($inputText) && $inputText!='' && isset($sysInput) && $sysInput!='' && isset($maxTokens) && $maxTokens!=''){ 
            $resArr = customCurlAIh($sysInput,$inputText,$maxTokens);
            if($resArr[0]=='success'){
                //echo '<pre>';print_r($resArr);die;
                if(isset($resArr[1]['choices'][0]['message']['content']) && $resArr[1]['choices'][0]['message']['content']!=''){
                    $aiMsg = convertToHtmlAvoidAh($resArr[1]['choices'][0]['message']['content']); 
					
					$this->db->select('userName , userEmail');
					$this->db->where('userId', $userId);
					$qry = $this->db->get('users');
					$aeDetails = $qry->row_array();

					$areaExpertName = trim($aeDetails['userName']);
					$areaExpertEmail = trim($aeDetails['userEmail']);

					$lnkMsg = '<p>Please take a moment to access the report using the link below and complete any requested actions: <br /> <a href="{receiverActionLink}">{receiverActionLink}</a></p><p>If you have any questions or need additional context, feel free to reach out to <strong>'.$areaExpertName.'</strong> at <strong>'.$areaExpertEmail.'</strong></p>';
					$msg = '<p> <strong>Dear {receiverName}</strong></p>';
					return $message = $msg.$aiMsg.$lnkMsg.'<p>Warm Regards, <br />The AMEE FLOW Support Team</p>';	


                }
            }
        }	
	}

	public function shareSamplingPlan($userId,$universityId){
		
		
		$roleType = trim($this->input->post('txt_roleType'));		 

		if(isset($_POST['chRoleIds']) && $_POST['chRoleIds']!=''){
			if(count($_POST['chRoleIds'])>0){
				// echo '<pre>'; print_r($_POST);
				$shareReportFor = trim($this->input->post('h_shareReportFor'));
				$share_report_for_array = $this->config->item('share_report_for_array_config')[$shareReportFor];
				$chkId = trim($this->input->post('h_chkId'));
				$chkenId = trim($this->input->post('h_chkenId'));
				$submitFor = trim($this->input->post('txt_submitFor'));
				$sentMsg = trim($this->input->post('txt_sentMsg'));				
				$liveSts = 1;

				$roleIds = $this->input->post('chRoleIds');
				$roleIdsStr = implode(',',$roleIds);

				$todayDate = strtotime(date('Y-m-d'));	
				$curTime = time();	

				$this->db->insert('sampling_plans_share', array('reportFor'=>$shareReportFor, 'chkId'=>$chkId, 'chkenId'=>$chkenId, 'userId'=>$userId, 'universityId'=>$universityId, 'submitFor'=>$submitFor, 'sentMsg'=>$sentMsg, 'roleType'=>$roleType, 'roleIds'=>$roleIdsStr, 'sentDate'=>$todayDate, 'sentOn'=>$curTime));
				$shareId = $this->db->insert_id();
				$eshareId = generateRandomNumStringCh(3).'sr'.$shareId.generateRandomNumStringCh(3);
				$this->db->where('shareId',$shareId); 
				$this->db->update('sampling_plans_share', array("eshareId"=>$eshareId));

				
				if($roleType=='self'){
					$liveSts = 0;
					$this->db->select('userName as swName, userEmail as swEmail');
					$where = ' userId in ('.$roleIdsStr.')';
					$this->db->where($where);
					$query = $this->db->get('users');
					$sendToResArr = $query->result_array();
				}else if($roleType==4){
					// $this->db->select('firstName as swName, facultyEmail as swEmail');
					$this->db->select("CONCAT(firstName, ' ', lastName) as swName, facultyEmail as swEmail");
					$where = ' ceClassId in ('.$roleIdsStr.')';
					$this->db->where($where);
					$query = $this->db->get('course_enrollment_classes');
					$sendToResArr = $query->result_array();
				}else{
					$this->db->select('name as swName, email as swEmail');
					$where = ' roleId in ('.$roleIdsStr.')';
					$this->db->where($where);
					$query = $this->db->get('senior_roles');
					$sendToResArr = $query->result_array();
				}				

				foreach($sendToResArr as $resDetails){

					$swName = trim($resDetails['swName']);
					$swEmail = trim($resDetails['swEmail']);
					
					$this->db->insert('sampling_plans_share_with', array('shareId'=>$shareId, 'userId'=>$userId, 'swName'=>$swName, 'swEmail'=>$swEmail, 'liveSts'=>$liveSts));
					$withShareId = $this->db->insert_id();
					$enwithShareId = generateRandomNumStringCh(3).'swr'.$withShareId.generateRandomNumStringCh(3);
					$this->db->where('withShareId',$withShareId); 
					$this->db->update('sampling_plans_share_with', array("enwithShareId"=>$enwithShareId));

					$lnk = base_url().'share/report/'.$enwithShareId;
					if($submitFor==1){
						$subject = 'Review and Provide Feedback on the '.$share_report_for_array['name'];						
					}else{
						$subject = 'Action Required: Approval of '.$share_report_for_array['name'];						
					}

					// $areaExpertName = trim($this->input->post('h_chkuserName'));
					// $areaExpertEmail = trim($this->input->post('h_chkuserEmail'));

					// $lnkMsg = '<p>Please take a moment to access the report using the link below and complete any requested actions:</p> <a href="'.$lnk.'">'.$lnk.'</a></p>
					// <p>If you have any questions or need additional context, feel free to reach out to '.$areaExpertName.' at '.$areaExpertEmail.'.</p>';

					// $msg = '<p> <strong>Dear '.$swName.'</strong></p>';
					// $message = $msg.$sentMsg.$lnkMsg.'<p>Warm Regards, The AMEE FLOW Support Team</p>';
					$message = str_replace('{receiverName}',$swName,$sentMsg);
					$message = str_replace('{receiverActionLink}',$lnk,$message);
					send_mail($swEmail,$message,$swName,'info',$subject); 
					
				}
				if($shareReportFor==1){
					return 'success||'.base_url().$share_report_for_array['controllerName'].'/report/'.$chkenId;
				}else{
					return 'success||'.base_url().$share_report_for_array['controllerName'].'/view/'.$chkenId;
				}
			}else{
				return 'error||Oops, please select at least one recipient.';
			}
		}else{
			return 'error||Oops, please select at least one recipient.';
		}	

	}

	public function getApprovalDataArr($chkId,$reportFor){
		$dbprefix = $this->db->dbprefix;
		$where = ' shareId in (select shareId from '.$dbprefix.'sampling_plans_share where submitFor=2 and reportFor='.$reportFor.' and chkId='.$chkId.')';
		$this->db->where($where);
		$this->db->where('liveSts', 1);
		$qry = $this->db->get('sampling_plans_share_with');
		return $qry->result_array();
	}

	public function feedbackDataArr($chkId,$reportFor){
		$dbprefix = $this->db->dbprefix;
		$this->db->where('actionTakenSts', 1);
		$this->db->where('liveSts', 1);
		$where = ' shareId in (select shareId from '.$dbprefix.'sampling_plans_share where submitFor=1 and reportFor='.$reportFor.' and chkId='.$chkId.')';
		$this->db->where($where);
		$qry = $this->db->get('sampling_plans_share_with');
		return $qry->result_array();
	}

	public function submitSharedEntry(){
		$dbprefix = $this->db->dbprefix;
		$chkId = trim($this->input->post('h_chkId'));
		$chkenId = trim($this->input->post('h_chkenId'));
		$enwithShareId = trim($this->input->post('h_enwithShareId'));
		$submitFor = trim($this->input->post('h_submitFor'));
		$reportFor = trim($this->input->post('h_reportFor'));
		$todayDate = strtotime(date('Y-m-d'));	
		$curTime = time();	
		$responseMsg = $this->input->post('responseMsg');
		
		if($submitFor==1){
			if(isset($responseMsg) && $responseMsg!=''){	
				$this->db->where('enwithShareId',$enwithShareId); 
				$this->db->update('sampling_plans_share_with', array("actionTakenSts"=>1,"reason"=>$responseMsg, "actionTakenDate"=>$todayDate, "actionTakenOn"=>$curTime));		
							
				$this->db->where('actionTakenSts', 1);
				$this->db->where('liveSts', 1);
				$where = ' shareId in (select shareId from '.$dbprefix.'sampling_plans_share where submitFor=1 and reportFor='.$reportFor.' and chkId='.$chkId.')';
				$this->db->where($where);
				$qry = $this->db->get('sampling_plans_share_with');
				$feedbackCnt = $qry->num_rows();

				if($reportFor==1){
					$this->db->where('spId',$chkId); 
					$this->db->update('sampling_plans', array("feedbackCnt"=>$feedbackCnt));
				}else if($reportFor==2){
					$this->db->where('rId',$chkId); 
					$this->db->update('loads_report', array("feedbackCnt"=>$feedbackCnt));
				}else if($reportFor==3){
					$this->db->where('rId',$chkId); 
					$this->db->update('general_reports', array("feedbackCnt"=>$feedbackCnt));
				}
			}else{
				return 'error||Oops, please leave your feedback.';	
			}		

		}else{
			$actionTakenSts = trim($this->input->post('h_clickedBtn'));
			$this->db->where('enwithShareId',$enwithShareId); 
			$this->db->update('sampling_plans_share_with', array("actionTakenSts"=>$actionTakenSts,"reason"=>$responseMsg, "actionTakenDate"=>$todayDate, "actionTakenOn"=>$curTime));		
		}
		return 'success||'.base_url().'share/report/'.$enwithShareId;	
	}

	public function approveSharedsp(){
		if(isset($_GET['enwithShareId']) && $_GET['enwithShareId']!=''){
			$enwithShareId = $_GET['enwithShareId'];
			$todayDate = strtotime(date('Y-m-d'));	
			$curTime = time();
			$this->db->where('enwithShareId',$enwithShareId); 
			$this->db->update('sampling_plans_share_with', array("actionTakenSts"=>1,"reason"=>'', "actionTakenDate"=>$todayDate, "actionTakenOn"=>$curTime));		
			return 'success||'.base_url().'share/sampling-plan/'.$enwithShareId;
		}
	}
	
}