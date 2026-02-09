<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjobs extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title'] = $this->config->item('product_name'); 
		$this->load->model('Notifications_mdl');
		$this->load->model('Course_enrollment_mdl');  		 
 	}

    public function taskNotifications(){
		$todayDate = strtotime(date('Y-m-d'));		
		$this->projectsNotifications($todayDate);
		sleep(3);
		$this->taskDueDateNotification($todayDate);
    }

	public function taskDueDateNotification($todayDate){
		
		$subject = 'Overdue Task - Please Complete';
		$dbprefix = $this->db->dbprefix;        	
		
		$userIdsArr = array();
		$userDetailsArr = array();
		$pmIdsArr = array();	
		
		$pmProData = array();
			
		$this->db->select('tsk.userId, tsk.assignBy, tsk.arId, u.userName, u.userEmail, u.userType, pt.subTskCnt, pt.taskId, ua.uaeId, ua.lightAccess');
		$this->db->from('projects_assign_roles as tsk');

		$where = "tsk.taskId in (select taskId from ".$dbprefix."projects_tasks where dueDateStr < ".$todayDate.')';
		$this->db->where($where);

		// $this->db->where('tsk.taskId', $taskId);
		$this->db->where('tsk.assignSts', 0);
		$this->db->where('tsk.dueNotiSts', 0); // if you want to send notification only one time use one sts column in projects_assign_roles table
		$this->db->join('users as u', 'u.userId = tsk.userId', 'LEFT');
		$this->db->join('users_access as ua', 'ua.auEmailId = u.userEmail', 'LEFT');
		$this->db->join('projects_tasks as pt', 'pt.taskId = tsk.taskId', 'LEFT');
		$query = $this->db->get();
		$roleCnt = $query->num_rows();
		if($roleCnt>0){				
			$asTskRes = $query->result_array();
			foreach($asTskRes as $as){
				
				$taskId = $as['taskId'];
				if($as['subTskCnt']==0){
					$chkTskCnt = 1;
				}else{
					$chkTskCnt = $as['subTskCnt'];
				}

				$userId = $as['userId'];
				$this->db->where('taskId',$taskId);
				$this->db->where('userId',$userId);
				$this->db->where('actionSts', 1);
				$qryUsr = $this->db->get('projects_tasks_users_sts');
				$utcnt = $qryUsr->num_rows();

				if($chkTskCnt!=$utcnt){
					if(!in_array($userId,$userIdsArr)){
						$userDetailsArr[] = $as['userEmail'].'||'.$as['userName'].'||'.$as['uaeId'].'||'.$as['lightAccess'].'||'.$userId;
						$userIdsArr[] = $userId;
						$pmIdsArr[] = $as['assignBy'];
						$this->db->where('arId',$as['arId']);
						$this->db->update('projects_assign_roles', array('dueNotiSts'=>1));
						// echo 'yes';
					}						 
					// send_mail($as['userEmail'],$msg,$as['userName'],'info',$subject);
				}
				// echo '<br>';
			}  
		}
		
		if(count($userDetailsArr)>0){
			foreach($userDetailsArr as $ue){
				$uId = $ueArr[4];
				$ueArr = explode('||',$ue);
				if(isset($ueArr[3]) && $ueArr[3]==1){
					$loginLnk = base_url().'light/permission/'.$ueArr[2];
				}else{
					$loginLnk = base_url().'signin';
				}
				$msg = '<p>A task assigned to you is past due. Please log in to AMEE Flow to review the task details and submit your updates. If you have any questions or require assistance, please contact your Project Manager.</p>';
				$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
				$this->db->select('ptu.projectId, p.projectName, p.proencryptId');
				$this->db->from('projects_tasks_users_sts as ptu');
				$this->db->where('ptu.userId',$uId);
				$this->db->where('ptu.actionSts', 0);
				$this->db->group_by('ptu.projectId');			 	
				$this->db->join('projects as p', 'ptu.projectId = p.projectId', 'LEFT');
				$qryPro = $this->db->get();				 
				$proCnt = $qryPro->num_rows();
				if($proCnt>0){
					$proData = $qryPro->result_array();
					$msg = $msg.'<p>Late task in:</p>';
					foreach($proData as $pro){
						$proLnk = base_url().'projects/tasks/'.$pro['proencryptId'];
						$msg = $msg.'<p> <a href="'.$proLnk.'">'.$pro['projectName'].' </a> </p>';
						$pmProData[] = $pro['projectName'];
					}
				}
				$msg = $msg.'<p> <a href="'.$loginLnk.'"> <strong>Click here to view task</strong> </a> </p>';
				send_mail($ueArr[0],$msg,$ueArr[1],'info',$subject);
			}
		}
		if(count($pmIdsArr)>0){
			$loginLnk = base_url().'signin';
			$pmSub = 'Overdue Task Reminder - Project Oversight Needed';
			$pmPros = '';
			if(count($pmProData)>0){
				$pmPros = implode(', ',$pmProData);
			}
			$pmMsg = '<p>One or more of your project tasks are overdue. Project(s) are '.$pmPros.'. Please review your project dashboard in AMEE Flow and take the necessary steps to contact team members. Timely oversight ensures smooth progress for your project.</p> <p> <a href="'.$loginLnk.'"> <strong>Click here to login</strong> </a> </p>';
			$pmIds = implode(',',$pmIdsArr);
			
			$this->db->select('fullName, email');
			if(isset($pmIds) && $pmIds!=''){
				$where = ' uniAdminId in ('.$pmIds.')';
				$this->db->where($where);
				$pmQry = $this->db->get('university_admins');
				$pmRes = $pmQry->result_array();
				foreach($pmRes as $pmd){
					send_mail($pmd['email'],$pmMsg,$pmd['fullName'],'info',$pmSub);
				}
			}
		}

	}

	public function projectsNotifications($todayDate){
		 
		$subject = 'Reminder: Action Required';

		$where = " ((sendDate='".$todayDate."' and sendDateSts='0') || (followupDate='".$todayDate."' and followupDateSts='0'))";
		$this->db->where($where);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('projects_notifications');
		$cnt = $query->num_rows();
		if($cnt>0){
			$res = $query->result_array();
			foreach($res as $nt){
				$nId = $nt['nId'];
				$sendFrom = $nt['sendFrom'];

				$this->db->where('nId',$nId);
				$this->db->where('activeSts', 0);
				$this->db->where('sentSts', 0);
				$qry = $this->db->get('notifications_recipients');
				$nrRes = $qry->result_array();
				foreach($nrRes as $r){

					$lnkMsg = '';
					if($nt['resOptionId']>0){
						$lnk = base_url().'share/notification/'.$r['enrecpId'];
						$lnkMsg = '<p> <a href="'.$lnk.'"> <strong>Click here to respond</strong> </a> </p>';
					}	
					$loginLnk = '';
					// if($sendFrom==0){
					// 	$loginLnk = '<p> <a href="'.base_url().'signin'.'"> <strong>Click here to login into AMEE Flow</strong> </a> </p>';
					// }

					$message = '<p> <strong>Dear '.$r['recpName'].'</strong></p>'.$nt['sendMsg'].$lnkMsg.$loginLnk;
					send_mail($r['recpEmail'],$message,$r['recpName'],'info',$subject); 
					// echo '<hr>';

					$this->db->where('nrecpId',$r['nrecpId']);
					$this->db->update('notifications_recipients', array('sentSts'=>1));

				}
				 
				if($todayDate==$nt['sendDate']){
					$this->db->where('nId',$nId);
					$this->db->update('projects_notifications', array('sendDateSts'=>1));
				}else{
					$this->db->where('nId',$nId);
					$this->db->update('projects_notifications', array('followupDateSts'=>1));
				}

			}
		}
	}



	public function taskDueDateNotificationBkUpOldLogicCAn($todayDate){
		$loginLnk = base_url().'signin';
		$subject = 'Overdue Task - Please Complete';
		$msg = '<p>A task assigned to you is past due. Please log in to AMEE Flow to review the task details and submit your updates. If you have any questions or require assistance, please contact your Project Manager.</p> <p> <a href="'.$loginLnk.'"> <strong>Click here to login</strong> </a> </p>';
		
		$userIdsArr = array();
		$userDetailsArr = array();
		$pmIdsArr = array();

		$this->db->select('taskId, taskName, subTskCnt');
		$where = "dueDateStr < ".$todayDate;
		$this->db->where($where);
		// $this->db->where('projectId', 1);
		$qryTask = $this->db->get('projects_tasks');
		$tcnt = $qryTask->num_rows();
		if($tcnt>0){
			$res = $qryTask->result_array();
			foreach($res as $nt){
				// $taskName = $nt['taskName'];
				$taskId = $nt['taskId'];
				if($nt['subTskCnt']==0){
					$chkTskCnt = 1;
				}else{
					$chkTskCnt = $nt['subTskCnt'];
				}
				 
				$this->db->select('tsk.userId, tsk.assignBy, tsk.arId, u.userName, u.userEmail, u.userType');
				$this->db->from('projects_assign_roles as tsk');
				$this->db->where('tsk.taskId', $taskId);
				$this->db->where('tsk.assignSts', 0);
				$this->db->where('tsk.dueNotiSts', 0); // if you want to send notification only one time use one sts column in projects_assign_roles table
				$this->db->join('users as u', 'u.userId = tsk.userId', 'LEFT');
				$query = $this->db->get();
				$roleCnt = $query->num_rows();
				if($roleCnt>0){				
					$asTskRes = $query->result_array();
					foreach($asTskRes as $as){					 

						$userId = $as['userId'];
						$this->db->where('taskId',$taskId);
						$this->db->where('userId',$userId);
						$this->db->where('actionSts', 1);
						$qryUsr = $this->db->get('projects_tasks_users_sts');
						$utcnt = $qryUsr->num_rows();

						if($chkTskCnt!=$utcnt){
							if(!in_array($userId,$userIdsArr)){
								$userDetailsArr[] = $as['userEmail'].'||'.$as['userName'];
								$userIdsArr[] = $userId;
								$pmIdsArr[] = $as['assignBy'];
								$this->db->where('arId',$as['arId']);
								$this->db->update('projects_assign_roles', array('dueNotiSts'=>1));
							}						 
							// send_mail($as['userEmail'],$msg,$as['userName'],'info',$subject);
						}
						// echo '<br>';
					}  
				}				
				
			}

			if(count($userDetailsArr)>0){
				foreach($userDetailsArr as $ue){
					$ueArr = explode('||',$ue);
					send_mail($ueArr[0],$msg,$ueArr[1],'info',$subject);
				}
			}
			if(count($pmIdsArr)>0){
				$pmSub = 'Overdue Task Reminder - Project Oversight Needed';
				$pmMsg = '<p>One or more of your project tasks are overdue. Please review your project dashboard in AMEE Flow and take the necessary steps to contact team members. Timely oversight ensures smooth progress for your project.</p> <p> <a href="'.$loginLnk.'"> <strong>Click here to login</strong> </a> </p>';
				$pmIds = implode(',',$pmIdsArr);
				
				$this->db->select('fullName, email');
				if(isset($pmIds) && $pmIds!=''){
					$where = ' uniAdminId in ('.$pmIds.')';
					$this->db->where($where);
					$pmQry = $this->db->get('university_admins');
					$pmRes = $pmQry->result_array();
					foreach($pmRes as $pmd){
						send_mail($pmd['email'],$pmMsg,$pmd['fullName'],'info',$pmSub);
					}
				}
			}
		}

	}

}