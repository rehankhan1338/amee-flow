<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Projects_mdl extends CI_Model {
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
    
    public function completedTaskUserDataArr($projectId,$taskId){
        $this->db->where('projectId', $projectId);
        $this->db->where('taskId', $taskId);
        $this->db->where('actionSts', 1);
		$qry = $this->db->get('projects_tasks_users_sts');
		return $qry->result_array();
    }
    public function avgUserTakeTaskActionCntCh($taskId){
        $this->db->where('taskId', $taskId);
        $this->db->where('subTaskId', 0);
        $this->db->where('actionSts', 1);
		$qry = $this->db->get('projects_tasks_users_sts');
		return $qry->num_rows();
    }
    public function avgUserTakeSubTaskActionCnt($subTaskId){
        $this->db->where('subTaskId', $subTaskId);
        $this->db->where('actionSts', 1);
		$qry = $this->db->get('projects_tasks_users_sts');
		return $qry->num_rows();
    }
    public function assignedProjectManagersDataArr($projectId){
        $this->db->where('projectId', $projectId);
        $this->db->where('assignSts', 0);
		$qry = $this->db->get('projects_assign_roles');
		return $qry->result_array();
    }
    public function taskSubmittedDataArr($projectId){
        $this->db->where('projectId', $projectId);
        $this->db->where('actionSts', 1);
		$qry = $this->db->get('projects_tasks_users_sts');
		return $qry->result_array();
    }
    public function assignedProTaskDataArr($projectId,$taskId){
        $this->db->where('projectId', $projectId);
         $this->db->where('taskId', $taskId);
        $this->db->where('assignSts', 0);
		$qry = $this->db->get('projects_assign_roles');
		return $qry->result_array();
    }
    public function chkStsofUserTakeAction($userId,$taskId){
        $this->db->where('userId', $userId);
        $this->db->where('taskId', $taskId);
        $this->db->where('actionSts', 1);
        $this->db->where('subTaskId !=', 0);
		$qry = $this->db->get('projects_tasks_users_sts');
		return $qry->num_rows();
    }
    public function projectWiseSubTaskDataArr($projectId){
		$this->db->where('projectId', $projectId);
        $this->db->order_by('subTaskId', 'asc');
		$query = $this->db->get('projects_subtasks');
		return $query->result_array();
	}
    public function uniProjectDataArr($universityId){
        $this->db->where('universityId', $universityId);
        $this->db->where('isActive', 0);
        $this->db->where('isDeleted', 0);
		$qry = $this->db->get('projects');
		return $qry->result_array();
    }
    public function pmProjectDataArr($uniAdminId){
        $this->db->where('uniAdminId', $uniAdminId);
        $this->db->where('isActive', 0);
        $this->db->where('isDeleted', 0);
		$qry = $this->db->get('projects');
		return $qry->result_array();
    }
    public function uniProjectManagersDataArr($uniAdminId){
        $dbprefix = $this->db->dbprefix;
        $this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $this->db->select('p.uniAdminId, ua.fullName');
		$this->db->from('projects as p');
		$this->db->where('p.uniAdminId', $uniAdminId);
        $this->db->where('p.isActive', 0);
        $this->db->where('p.isDeleted', 0);
        // $this->db->order_by('ua.fullName', 'desc');
        $this->db->group_by('p.uniAdminId');		 	
		$this->db->join('university_admins as ua', 'p.uniAdminId = ua.uniAdminId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
    }
    public function proWiseCompletedTaskListDataArr($projectId,$userId){
        $this->db->where('userId', $userId);
        $this->db->where('projectId', $projectId);
        $this->db->where('actionSts', 1); // 1 = task completed
		$qry = $this->db->get('projects_tasks_users_sts');
		return $qry->result_array();
    }
    public function takeActionOnSubTask($subTaskId,$colName,$status,$taskId,$projectId,$userId){
        $this->db->where('subTaskId', $subTaskId);
        $this->db->where('taskId', $taskId);
        $this->db->where('userId', $userId);
        $this->db->where('projectId', $projectId);
		$qry = $this->db->get('projects_tasks_users_sts');
		$cnt = $qry->num_rows();
        $todayDate = strtotime(date('Y-m-d'));
        $curTime = time();
        if($cnt==0){
            $this->db->insert('projects_tasks_users_sts', array('projectId'=>$projectId, 'userId'=>$userId, 'taskId'=>$taskId, 'subTaskId'=>$subTaskId, "actionSts"=>1, 'actionTakenDate'=>$todayDate, 'actionTakenOn'=>$curTime));
        }else{
            $row = $qry->row_array();
            $this->db->where('upTaskStsId', $row['upTaskStsId']);
            $this->db->update('projects_tasks_users_sts', array("actionSts"=>$status, 'actionTakenDate'=>$todayDate, 'actionTakenOn'=>$curTime));
        }
        
        // $this->db->select('userId, userName, userEmail, userType');
        // $this->db->where('userId', $userId);
        // $qryUser = $this->db->get('users');
        // $assUser = $qryUser->row_array();
		$this->db->where('actionSts', 0);
        $this->db->where('taskId', $taskId);
        $this->db->where('userId', $userId);
        $this->db->where('projectId', $projectId);
		$qryChk = $this->db->get('projects_tasks_users_sts');
        $chkSts = $qryChk->num_rows(); // 0 means all task completed

		return 'success||'.$chkSts;
    }
    public function chkTaskActionTakenSts($subTaskId,$taskId,$projectId,$userId){
        $this->db->where('subTaskId', $subTaskId);
        $this->db->where('taskId', $taskId);
        $this->db->where('userId', $userId);
        $this->db->where('projectId', $projectId);
		$qry = $this->db->get('projects_tasks_users_sts');
		$cnt = $qry->num_rows();
        if($cnt>0){
            $row = $qry->row_array();
            $sts = $row['actionSts'];
        }else{
            $sts = $cnt;
        }
        return $sts;
    }
    public function userAssignProjectsDataArr($userId){
        $this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $this->db->select('par.*, p.projectName, p.termId, p.year, p.proencryptId, p.taskCnt, p.bgColor, p.fontColor, p.lighterColor, p.btnColor');
		$this->db->from('projects_assign_roles as par');
		$this->db->where('par.userId', $userId);
        $this->db->where('par.assignSts', 0);
        $this->db->where('p.isActive', 0);
        $this->db->where('p.isDeleted', 0);
        $this->db->order_by('p.termId, p.year', 'asc');
        $this->db->group_by('par.projectId');
		$this->db->join('projects as p', 'p.projectId = par.projectId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
    }
    public function userProTaskListDataArr($projectId,$userId){
        $dbprefix = $this->db->dbprefix;
        $this->db->where('projectId', $projectId);
        $where = ' taskId in (select taskId from '.$dbprefix.'projects_assign_roles where assignSts="0" and userId="'.$userId.'")';
        $this->db->where($where);
        $this->db->order_by('dueDateStr', 'asc');
		$query = $this->db->get('projects_tasks');
		return $query->result_array();
    }
    public function getUserAssignProTaskCnt($projectId,$userId){
        $this->db->where('projectId', $projectId);
        $this->db->where('userId', $userId);
        $this->db->where('assignSts', 0);
		$query = $this->db->get('projects_assign_roles');
		return $query->num_rows();
    }
    public function proTaskListDataArr($projectId){
        $this->db->where('projectId', $projectId);
        $this->db->order_by('dueDateStr', 'asc');
		$query = $this->db->get('projects_tasks');
		return $query->result_array();
    }
    public function taskDetailsArr($taskId){
		$this->db->where('taskId', $taskId);
		$query = $this->db->get('projects_tasks');
		return $query->row_array();
	}
    public function updateTaskPriority($taskId, $priorityId){
        $priorityName = $this->config->item('task_priority_options_array_config')[$priorityId]['name'];
        $clsName = $this->config->item('task_priority_options_array_config')[$priorityId]['clsName'];
        $icon = $this->config->item('task_priority_options_array_config')[$priorityId]['icon'];
        $this->db->where('taskId',$taskId); 
        $this->db->update('projects_tasks', array("priorityId"=>$priorityId));
        return 'success||<span class="cp fw600" onclick="return placeEdit('.$taskId.');">'.$priorityName.' &nbsp;'.$icon.'</span>||'.$clsName;
    }
    public function ajaxUpdateTaskDueDate($taskId,$dueDate){        
        if(isset($dueDate) && $dueDate!=''){
            $dueDateArr = explode('/',$dueDate);
            $dueDateStr = strtotime($dueDateArr[2].'-'.$dueDateArr[0].'-'.$dueDateArr[1]);
            $upDueDate = date('m/d/Y',$dueDateStr);
            $this->db->where('taskId',$taskId); 
            $this->db->update('projects_tasks', array("dueDateStr"=>$dueDateStr));
            return 'success||<span class="cp fw600" onclick="return dueDateEdit('.$taskId.');">'.$upDueDate.'</span>';
        }        
        
    }
    public function subtaskDetailsArr($subTaskId){
		$this->db->where('subTaskId', $subTaskId);
		$query = $this->db->get('projects_subtasks');
		return $query->row_array();
	}
    public function projectSubTaskDataArr($taskId){
		$this->db->where('taskId', $taskId);
        $this->db->order_by('subTaskId', 'asc');
		$query = $this->db->get('projects_subtasks');
		return $query->result_array();
	}
    public function projectDetailsByeIdArr($proencryptId){
		$this->db->where('proencryptId', $proencryptId);
		$query = $this->db->get('projects');
		return $query->row_array();
	}
    public function proDetailsArr($projectId){
		$this->db->where('projectId', $projectId);
		$query = $this->db->get('projects');
		return $query->row_array();
	}
	public function projectDataArr($uniAdminId){
		$this->db->where('uniAdminId', $uniAdminId);
		$query = $this->db->get('projects');
		return $query->result_array();
	}
    public function manageProEntry(){
        $projectIdChk = trim($this->input->post('maProjectId'));
        $uniAdminId = trim($this->input->post('mauniAdminId'));
        $createdBy = trim($this->input->post('macreatedBy'));
		$universityId = trim($this->input->post('mauniversityId'));
		$projectName = trim($this->input->post('maProName'));
        $projectSlug = create_slug_ch($projectName);        
		$termId = trim($this->input->post('maTermId'));        
		$year = trim($this->input->post('maYear'));
        $bgColor = generateLightColorHex();
        $fontColor = getReadableFontColor($bgColor);
        $lighterColor = hex2rgba($bgColor);
        $btnColor = match_darker_color_by_pattern($bgColor);
        $todayDate = strtotime(date('Y-m-d'));	
        $curTime = time();
        if(isset($projectIdChk) && $projectIdChk!='' && $projectIdChk>0){
            $this->db->where('projectId !=', $projectIdChk);
        }
        $this->db->where('universityId', $universityId);
        $this->db->where('projectSlug', $projectSlug);
        $this->db->where('termId', $termId);
        $this->db->where('year', $year);
		$qry = $this->db->get('projects');
		$cnt = $qry->num_rows();
		if($cnt==0){
            if(isset($projectIdChk) && $projectIdChk!='' && $projectIdChk>0){
                $this->db->where('projectId',$projectIdChk); 
                $this->db->update('projects', array('projectName'=>$projectName, 'projectSlug'=>$projectSlug, 'termId'=>$termId, 'year'=>$year));
                return 'success||'.base_url().$this->config->item('system_directory_name').'projects';
            }else{
                $defaultTsk = 3; 

                $this->db->insert('projects', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'createdBy'=>$createdBy, 'projectName'=>$projectName, 'projectSlug'=>$projectSlug, 'termId'=>$termId, 'year'=>$year, 'onDate'=>$todayDate, 'onTime'=>$curTime, 'bgColor'=>$bgColor, 'fontColor'=>$fontColor, 'lighterColor'=>$lighterColor, 'btnColor'=>$btnColor));
                $projectId = $this->db->insert_id();
                $proencryptId = generateRandomNumStringCh(4).'p'.$projectId.generateRandomNumStringCh(4);
                $this->db->where('projectId',$projectId); 
                $this->db->update('projects', array("proencryptId"=>$proencryptId, "taskCnt"=>$defaultTsk));
                
                for($df=1;$df<=$defaultTsk;$df++){
                    $tName = 'Task '.$df;
                    $this->db->insert('projects_tasks', array('projectId'=>$projectId, 'universityId'=>$universityId, 'taskName'=>$tName));
                }
                return 'success||'.base_url().$this->config->item('system_directory_name').'projects/tasks/'.$proencryptId;
            }
        }else{
            return 'error||Oops, this project name already exist.';
        }
    }
    public function update_reminder_status($taskId,$column_name,$status){
		$this->db->where('taskId', $taskId);
		$this->db->update('projects_tasks', array("$column_name"=>$status));
        
        if($status==1){
            $append = ' &nbsp; <span id="notiLnk'.$taskId.'" onclick="return manageNotification('.$taskId.');" class="notiarCls"> <i class="icon-sm" data-feather="send"></i> </span>';		
        }else{
            $append = '';
        }
		return 'success||'.$append;
		// return 'success';
	}
    public function update_pro_status($projectId,$column_name,$status){
		$this->db->where('projectId', $projectId);
		$this->db->update('projects', array("$column_name"=>$status));		
		return 'success';
	}
    public function manageTaskEntry(){
        $uniAdminId = trim($this->input->post('mtuniAdminId'));
		$universityId = trim($this->input->post('mtuniversityId'));
		$taskIdChk = trim($this->input->post('mtTaskId'));
		$projectId = trim($this->input->post('mtProjectId'));
        $proencryptId = trim($this->input->post('mtproencryptId'));
		$taskName = trim($this->input->post('mtTastName'));
        $taskDesc = $this->input->post('mtTastDesc');
		// $priorityId = $this->input->post('mtPriorityId');
		// $dueDateStr = $this->input->post('mtDueDate');
        // $reminderSts = 0;
        // if(isset($_POST['reminderSts']) && $_POST['reminderSts']!='' && $_POST['reminderSts']=='on'){
        //     $reminderSts = 1;
        // }
        
        if(isset($taskIdChk) && $taskIdChk!='' && $taskIdChk>0){
            $taskId = $taskIdChk;
            $this->db->where('taskId', $taskId);
            $this->db->update('projects_tasks', array('taskName'=>$taskName, 'taskDesc'=>$taskDesc));
        }else{
            $this->db->insert('projects_tasks', array('universityId'=>$universityId, 'projectId'=>$projectId, 'taskName'=>$taskName, 'taskDesc'=>$taskDesc));
            $taskId = $this->db->insert_id();
        }
        if(isset($_POST['mtsubTaskIds']) && $_POST['mtsubTaskIds']!=''){
            if(count($_POST['mtsubTaskIds'])>0){
                for($oi=0;$oi<count($_POST['mtsubTaskIds']);$oi++){
                    $osubTaskId = $_POST['mtsubTaskIds'][$oi];
                    $osTaskLbl = $this->input->post('mtOldSubTaskLbl'.$osubTaskId);
                    $osTaskDesc = $this->input->post('mtOldSubTaskDesc'.$osubTaskId);
                    $this->db->where('subTaskId', $osubTaskId);
                    $this->db->update('projects_subtasks', array('staskLbl'=>$osTaskLbl, 'staskDesc'=>$osTaskDesc));
                }
            }
        }
        if(isset($_POST['h_item_cnt']) && $_POST['h_item_cnt']!='' && $_POST['h_item_cnt']>0){
            $itemCnt = $this->input->post('h_item_cnt');
            for($i=1;$i<=$itemCnt;$i++){
                $sTaskLbl = $this->input->post('mtSubTaskLbl'.$i);
                if(isset($sTaskLbl) && $sTaskLbl!=''){
                    $sTaskDesc = $this->input->post('mtSubTaskDesc'.$i);
                    $this->db->insert('projects_subtasks', array('projectId'=>$projectId, 'taskId'=>$taskId, 'staskLbl'=>$sTaskLbl, 'staskDesc'=>$sTaskDesc));
                }
            }
        }
        $this->db->where('taskId', $taskId);
		$qry = $this->db->get('projects_subtasks');
		$subTskCnt = $qry->num_rows();
        $this->db->where('taskId', $taskId);
        $this->db->update('projects_tasks', array("subTskCnt"=>$subTskCnt));

        $this->db->where('projectId', $projectId);
		$qryTsk = $this->db->get('projects_tasks');
		$tskCnt = $qryTsk->num_rows();
        $this->db->where('projectId', $projectId);
        $this->db->update('projects', array("taskCnt"=>$tskCnt));

        $this->session->set_flashdata('success', 'Task has been created successfully.');					
        return 'success||'.base_url().$this->config->item('system_directory_name').'projects/tasks/'.$proencryptId;
        
    }
    public function deleteProject($pIds){
        $where = ' projectId in ('.$pIds.')';

        $this->db->where($where);
        $this->db->delete('projects');

        $this->db->where($where);
        $this->db->delete('projects_tasks');
        
        $this->db->where($where);
        $this->db->delete('projects_subtasks');

        $this->db->where($where);
        $this->db->delete('projects_assign_roles');

        $this->db->where($where);
        $this->db->delete('projects_tasks_users_sts');

        $this->db->where($where);
        $this->db->delete('projects_notifications');

        $this->session->set_flashdata('success', 'Project has been deleted successfully.');	
    }
    public function deleteSubTask($Ids,$taskId){
        $where = ' subTaskId in ('.$Ids.')';        
        $this->db->where($where);
        $this->db->delete('projects_subtasks');

        $this->db->where($where);
        $this->db->delete('projects_tasks_users_sts');

        $this->db->where($where);
        $this->db->delete('projects_notifications');

        $this->db->where('taskId', $taskId);
		$qry = $this->db->get('projects_subtasks');
		$subTskCnt = $qry->num_rows();
        $this->db->where('taskId', $taskId);
        $this->db->update('projects_tasks', array("subTskCnt"=>$subTskCnt));
	
    }
    public function deleteTask($taskIds,$projectId){
        $where = ' taskId in ('.$taskIds.')';
        $this->db->where($where);
        $this->db->delete('projects_tasks');

        $this->db->where($where);
        $this->db->delete('projects_subtasks');

        $this->db->where($where);
        $this->db->delete('projects_assign_roles');

        $this->db->where($where);
        $this->db->delete('projects_tasks_users_sts');

        $this->db->where($where);
        $this->db->delete('projects_notifications');

        $this->db->where('projectId', $projectId);
        $qryTsk = $this->db->get('projects_tasks');
        $tskCnt = $qryTsk->num_rows();
        $this->db->where('projectId', $projectId);
        $this->db->update('projects', array("taskCnt"=>$tskCnt));

        $this->session->set_flashdata('success', 'Task has been deleted successfully.');	
    }
    public function getAssignedProUsersList($projectId){         
        $this->db->select('par.*, u.userName, u.userEmail, u.userType');
        $this->db->from('projects_assign_roles as par');
        $this->db->where('par.projectId', $projectId);
        $this->db->where('u.isDeleted', 0);
        $this->db->order_by('par.arId', 'desc');
        $this->db->join('users as u', 'u.userId = par.userId', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();         
    }
    public function getAssignedProTaskUsersList($taskId){         
        $this->db->select('par.*, u.userName, u.userEmail, u.userType, u.bgColor as usrbgColor, u.fontColor as usrfontColor');
        $this->db->from('projects_assign_roles as par');
        $this->db->where('par.taskId', $taskId);
        $this->db->where('u.isDeleted', 0);
        $this->db->order_by('par.arId', 'desc');
        $this->db->join('users as u', 'u.userId = par.userId', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();         
    }
    public function getAssignedProActiveUsersList($projectId){  
        $dbprefix = $this->db->dbprefix;
        $this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");       
        $this->db->select('par.*, u.userName, u.userEmail, u.userType');
        $this->db->from('projects_assign_roles as par');
        $this->db->where('par.projectId', $projectId);
        $this->db->where('par.assignSts', 0);
        $this->db->where('u.isDeleted', 0);
        $this->db->order_by('par.arId', 'desc');
        $this->db->group_by('par.userId');
        $this->db->join('users as u', 'u.userId = par.userId', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();         
    }
    public function chkUserProAssignSts($userId,$projectId,$taskId){
        $res = 1; // 1=Unassigned, 0=Assigned
        $this->db->where('userId', $userId);
        $this->db->where('projectId', $projectId);
        $this->db->where('taskId', $taskId);
		$qry = $this->db->get('projects_assign_roles');
		$cnt = $qry->num_rows();
        if($cnt>0){
            $row = $qry->row_array();
            $res = $row['assignSts'];
        }
        return $res;
    }
    public function updateProAssignStatus($userId,$column_name,$status,$projectId,$taskId,$universityId,$uniAdminId){
        $sendMail = 0;  
        
        $taskDetails = $this->taskDetailsArr($taskId);
        $dueDate = '';
        if(isset($taskDetails['dueDateStr']) && $taskDetails['dueDateStr']!='' && $taskDetails['dueDateStr']>0){
            $dueDate = date('m/d/Y',$taskDetails['dueDateStr']);
        }
        
        $projectDetails = $this->proDetailsArr($projectId);

        $this->db->where('userId', $userId);
        $this->db->where('projectId', $projectId);
        $this->db->where('taskId', $taskId);
		$qry = $this->db->get('projects_assign_roles');
		$cnt = $qry->num_rows();
        $createDate = strtotime(date('Y-m-d'));
        if($cnt==0){
            $bgColor = generateDarkColorHex();
            $fontColor = wpImgColorCh($bgColor);
            $this->db->insert('projects_assign_roles', array('projectId'=>$projectId, 'taskId'=>$taskId, 'bgColor'=>$bgColor, 'fontColor'=>$fontColor, 'userId'=>$userId, 'assignBy'=>$uniAdminId, 'assignDate'=>$createDate, "assignSts"=>0));
            $sendMail = 1; 
        }else{
            $row = $qry->row_array();
            $bgColor = $row['bgColor'];
            $fontColor = $row['fontColor'];
            $this->db->where('arId', $row['arId']);
            $this->db->update('projects_assign_roles', array("assignSts"=>$status));
        }        

        $tdId = $taskId.$userId;

        // $this->db->select('userId, userName, userEmail, userType, bgColor, fontColor');
        // $this->db->where('userId', $userId);
        // $qryUser = $this->db->get('users');
        // $assUser = $qryUser->row_array();

        $this->db->select('u.userId, u.userName, u.userEmail, u.userType, u.bgColor, u.fontColor, ua.uaeId, ua.lightAccess');
		$this->db->from('users as u');
		$this->db->where('u.userId', $userId);
		$this->db->join('users_access as ua', 'ua.auEmailId = u.userEmail', 'LEFT');
		$qryUser = $this->db->get();
		$assUser = $qryUser->row_array();


        $roleName = $this->config->item('user_types_array_config')[$assUser['userType']]['name']; 

        $this->db->select('uniAdminId, fullName, email');
        $this->db->where('uniAdminId', $uniAdminId);
        $qryPM = $this->db->get('university_admins');
        $pmDetails = $qryPM->row_array();

        if($sendMail==1){
            $this->db->where('universityId', $universityId);
            $this->db->where('uniAdminId', $uniAdminId);
            $this->db->where('purpose', 'Assigned a Task');
            $etQry = $this->db->get('email_templates');
            $etDetails = $etQry->row();
            $subject = $etDetails->subject;
            if($assUser['lightAccess']==1){
                $loginLink = base_url().'light/permission/'.$assUser['uaeId'];
            }else{
                $loginLink = base_url().'signin';
            }
            
            $message = str_replace('{assignerName}',$assUser['userName'],$etDetails->message);
            $message = str_replace('{taskTitle}',$taskDetails['taskName'],$message);
            $message = str_replace('{projectName}',$projectDetails['projectName'],$message);
            $message = str_replace('{dueDate}',$dueDate,$message);
            $message = str_replace('{loginURL}',$loginLink,$message);
            // $message = str_replace('{nameofRole}',$roleName,$message);
            $message = str_replace('{nameofAssignee}',$pmDetails['fullName'],$message);
            send_mail($assUser['userEmail'],$message,$assUser['userName'],'info',$subject);             
        }
		$append = '<label id="assRoleuId'.$tdId.'" style="background-color: '.$assUser['bgColor'].'; color: '.$assUser['fontColor'].';" class="arCls" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$assUser['userName'].'<br />'.$roleName.'">'.getTwoCharsFromEachWord($assUser['userName']).'</label>&nbsp;';		
		return 'success||'.$tdId.'||'.$append;
	}

    public function monthDiff($pre,$new){
        // $date1 = new DateTime($pre);
        // $date2 = new DateTime($new);
        // $diff = $date1->diff($date2);
        // $totalMonths = ($diff->y * 12) + $diff->m;
        // return $totalMonths;

        $date1 = new DateTime($pre);
        $date2 = new DateTime($new);
        $diff = $date1->diff($date2);

        $totalMonths = ($diff->y * 12) + $diff->m;
        return $totalDays = $diff->days;
    }

    public function copyProEntry(){
        
        $uniAdminId = trim($this->input->post('copyuniAdminId'));
        $createdBy = trim($this->input->post('copycreatedBy'));
		$universityId = trim($this->input->post('copyuniversityId'));        
		$copyProjectId = trim($this->input->post('copyProjectId'));
        
        $this->db->where('projectId', $copyProjectId);
        $this->db->order_by('dueDateStr', 'asc');
        $qryTsk = $this->db->get('projects_tasks');
        $tskCnt = $qryTsk->num_rows();
        if($tskCnt>0){

            $tskDetails = $qryTsk->row_array();
            $chkdueDateStr = date('Y-m-d',$tskDetails['dueDateStr']);
            $diffDay = 0;
            if(isset($_POST['copyStartDate']) && $_POST['copyStartDate']!=''){
                $newStartDateArr = explode('/',$_POST['copyStartDate']);
                $newStartDateStr = $newStartDateArr[2].'-'.$newStartDateArr[0].'-'.$newStartDateArr[1];                
                $diffDay = $this->monthDiff($chkdueDateStr,$newStartDateStr);
            }

            $projectName = trim($this->input->post('copyProName'));
            $projectSlug = create_slug_ch($projectName);        
            $termId = trim($this->input->post('copyTermId'));        
            $year = trim($this->input->post('copyYear'));

            

            // $copyMonth = $year.'-'.$this->config->item('terms_assessment_array_config')[$termId]['startMonth'].'-01';

            $bgColor = generateLightColorHex();
            $fontColor = getReadableFontColor($bgColor);
            $lighterColor = hex2rgba($bgColor);
            $btnColor = match_darker_color_by_pattern($bgColor);
            $todayDate = strtotime(date('Y-m-d'));	
            $curTime = time();
            $onMonth = date('m');
            $onYear = date('Y');

            $this->db->insert('projects', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'createdBy'=>$createdBy, 'projectName'=>$projectName, 'projectSlug'=>$projectSlug, 'termId'=>$termId, 'year'=>$year, 'onDate'=>$todayDate, 'onTime'=>$curTime, 'bgColor'=>$bgColor, 'fontColor'=>$fontColor, 'lighterColor'=>$lighterColor, 'btnColor'=>$btnColor));
            $projectId = $this->db->insert_id();
            $proencryptId = generateRandomNumStringCh(4).'p'.$projectId.generateRandomNumStringCh(4);
            $this->db->where('projectId',$projectId); 
            $this->db->update('projects', array("proencryptId"=>$proencryptId, "taskCnt"=>$tskCnt));
            
            $tskData = $qryTsk->result_array();
            $ti=1;
            foreach($tskData as $task){  
                $newDueDate = 0;
                if(isset($task['dueDateStr']) && $task['dueDateStr']!='' && $task['dueDateStr']>0){
                    $cpre = date('Y-m-d',$task['dueDateStr']);                    
                    $newDueDate = strtotime("+".$diffDay." days", strtotime($cpre));                   
                }
                
                $this->db->insert('projects_tasks', array('universityId'=>$universityId, 'projectId'=>$projectId, 'taskName'=>$task['taskName'], 'priorityId'=>$task['priorityId'], 'dueDateStr'=>$newDueDate, 'reminderSts'=>$task['reminderSts'], 'taskDesc'=>$task['taskDesc'], 'subTskCnt'=>$task['subTskCnt']));
                $taskId = $this->db->insert_id();
                if($task['subTskCnt']>0){
                    $this->db->where('projectId', $copyProjectId);
                    $this->db->where('taskId', $task['taskId']);
                    $qrysubTsk = $this->db->get('projects_subtasks');
                    $subtskData = $qrysubTsk->result_array();
                    foreach($subtskData as $st){
                        $this->db->insert('projects_subtasks', array('taskId'=>$taskId, 'projectId'=>$projectId, 'staskLbl'=>$st['staskLbl'], 'staskDesc'=>$st['staskDesc']));
                    }
                }

                $this->db->where('projectId', $copyProjectId);
                $this->db->where('taskId', $task['taskId']);
                $this->db->where('sendFrom', 0);
                $this->db->where('subTaskId', 0);
                $this->db->where('isDeleted', 0);
                $qryNoti = $this->db->get('projects_notifications');
                $ntCnt = $qryNoti->num_rows();
                if($ntCnt>0){
                    $ntData = $qryNoti->result_array();
                    foreach($ntData as $noti){

                        $newsendDate = 0;
                        if(isset($noti['sendDate']) && $noti['sendDate']!='' && $noti['sendDate']>0){                  
                            $newsendDate = strtotime("+".$diffDay." days", $noti['sendDate']);                   
                        }

                        $newfollowupDate = 0;
                        if(isset($noti['followupDate']) && $noti['followupDate']!='' && $noti['followupDate']>0){                  
                            $newfollowupDate = strtotime("+".$diffDay." days", $noti['followupDate']);                   
                        }
                        
                        $this->db->insert('projects_notifications', array('sendFrom'=>'0', 'sentById'=>$uniAdminId, 'taskId'=>$taskId, 'projectId'=>$projectId, 'universityId'=>$universityId, 'subTaskId'=>'0', 'topic'=>$noti['topic'], 'sendMsg'=>$noti['sendMsg'], 'recipientsCnt'=>0, 'recipientsIds'=>'', 'sendDate'=>$newsendDate, 'followupDate'=>$newfollowupDate, 'resOptionId'=>$noti['resOptionId'], 'onYear'=>$onYear, 'onDate'=>$todayDate, 'onTime'=>$curTime, 'onMonth'=>$onMonth));
                        $nId = $this->db->insert_id();
                        $enId = generateRandomNumStringCh(4).'nt'.$nId.generateRandomNumStringCh(4);
                        $this->db->where('nId',$nId); 
                        $this->db->update('projects_notifications', array("enId"=>$enId));
                    }
                }
            $ti++;
            }
            return 'success||'.base_url().$this->config->item('system_directory_name').'projects';
        }else{
            return 'error||Oops, no task present of this project.';
        }		

    }
}