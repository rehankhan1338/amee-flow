<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
class Analytics extends CI_Controller {
 	 
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
        $this->load->model('Course_enrollment_mdl');	
        $this->load->model('Projects_mdl');   
        $this->data['active_class'] = 'analytics-menu';
        $this->data['title'] = 'Analytics - '.$this->config->item('product_name');
 	}
    public function index(){
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $this->data['uniProjectManagersDataArr'] = $this->Projects_mdl->uniProjectManagersDataArr($uniAdminId);
        $this->data['uniProjectDataArr'] = $this->Projects_mdl->pmProjectDataArr($uniAdminId);
        // $this->data['groupedUniAdminIdsArr'] = array_unique(array_column($this->data['uniProjectDataArr'], 'uniAdminId'));
        // echo '<pre>';print_r($this->data['uniProjectManagersDataArr']);die;
        $this->data['pageTitle'] = '';
        $this->data['pageSubTitle'] = '';
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/projects/analytics/listing',$this->data);
        $this->load->view('system-admin/includes/footer',$this->data);
    }
    public function tasks(){
        $proencryptId = $this->uri->segment(4);
		if(isset($proencryptId) && $proencryptId!=''){
			// $userId = $this->data['sessionDetailsArr']['userId'];
			$this->data['projectDetails'] = $this->Projects_mdl->projectDetailsByeIdArr($proencryptId);
			$projectId = $this->data['projectDetails']['projectId'];
			$this->data['proTaskListDataArr'] = $this->Projects_mdl->proTaskListDataArr($projectId);
            $this->data['proWiseSubTaskDataArr'] = $this->Projects_mdl->projectWiseSubTaskDataArr($projectId);
            
            $this->data['assignedProjectManagersDataArr'] = $this->Projects_mdl->assignedProjectManagersDataArr($projectId);
            $this->data['taskSubmittedDataArr'] = $this->Projects_mdl->taskSubmittedDataArr($projectId);
			// $this->data['proWiseCompletedTaskListDataArr'] = $this->Projects_mdl->proWiseCompletedTaskListDataArr($projectId,$userId);
			// echo '<pre>';print_r($this->data['proTaskListDataArr']);die;
			 $this->data['pageTitle'] = 'Project Progress';
             $this->data['pageSubTitle'] = '';
			$this->load->view('system-admin/includes/header',$this->data);	 
			$this->load->view('system-admin/projects/analytics/tasks-report',$this->data);
			$this->load->view('system-admin/includes/footer',$this->data);
		}else{
			redirect(base_url().'projects');
		}

        
        
        
        // $universityId = $this->data['sessionDetailsArr']['universityId'];
        // $uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
        // $this->data['uniProjectManagersDataArr'] = $this->Projects_mdl->uniProjectManagersDataArr($universityId);
        // $this->data['uniProjectDataArr'] = $this->Projects_mdl->uniProjectDataArr($universityId);
        // // $this->data['groupedUniAdminIdsArr'] = array_unique(array_column($this->data['uniProjectDataArr'], 'uniAdminId'));
        // // echo '<pre>';print_r($this->data['uniProjectManagersDataArr']);die;       
        
        // $this->load->view('system-admin/projects/analytics/listing',$this->data);
        // $this->load->view('system-admin/includes/footer',$this->data);
    }
    public function viewTaskDetails(){        
        $this->data['taskDetailsArr'] = $this->Projects_mdl->taskDetailsArr($_GET['tId']);
		$this->data['subTaskDataArr'] = $this->Projects_mdl->projectSubTaskDataArr($_GET['tId']);

        $this->data['assignedProTaskDataArr'] = $this->Projects_mdl->getAssignedProTaskUsersList($_GET['tId']);
        $this->data['completedTaskUserDataArr'] = $this->Projects_mdl->completedTaskUserDataArr($_GET['pId'],$_GET['tId']);
        $this->load->view('system-admin/projects/analytics/ajax-sub-task',$this->data);
    }

    public function download(){
        $proencryptId = $this->uri->segment(4);
		if(isset($proencryptId) && $proencryptId!=''){

            ini_set('memory_limit', '512M');
            set_time_limit(300);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getStyle('1')->getFont()->setBold(true);
            $sheet->getColumnDimension('A')->setWidth(50);
            $sheet->getColumnDimension('B')->setWidth(18);
            $sheet->getColumnDimension('C')->setWidth(18);
            $sheet->getColumnDimension('D')->setWidth(18);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(18);

            // $sheet->getRowDimension('1')->setRowHeight(20);

            $sheet->setCellValue('A1', 'Main Task');
            $sheet->setCellValue('B1', 'Priority');
            $sheet->setCellValue('C1', 'Due Date');
            $sheet->setCellValue('D1', 'Completed Task');
            $sheet->setCellValue('E1', 'Tasks in Progress');
            $sheet->setCellValue('F1', 'Not Started Tasks');
            $sheet->setCellValue('G1', 'Avg. Completion');

			// $userId = $this->data['sessionDetailsArr']['userId'];
			$projectDetails = $this->Projects_mdl->projectDetailsByeIdArr($proencryptId);
			$projectId = $projectDetails['projectId'];
			$proTaskListDataArr = $this->Projects_mdl->proTaskListDataArr($projectId);
            $proWiseSubTaskDataArr = $this->Projects_mdl->projectWiseSubTaskDataArr($projectId);
            
            $assignedProjectManagersDataArr = $this->Projects_mdl->assignedProjectManagersDataArr($projectId);
            $taskSubmittedDataArr = $this->Projects_mdl->taskSubmittedDataArr($projectId);

            $totalTaskIncSubTaskArr = array();
            if(count($proTaskListDataArr)>0){
                foreach($proTaskListDataArr as $task){
                    $res = filter_array($assignedProjectManagersDataArr,$task['taskId'],'taskId');
                    $mulSubTsk = 1;
                    if($task['subTskCnt']>0){
                        $mulSubTsk = $task['subTskCnt'];
                    }
                    $totalTaskIncSubTaskArr[] = count($res)*$mulSubTsk;
                    // echo '<br>';
                }
            }

            $expectedTasks = array_sum($totalTaskIncSubTaskArr);
            $tasksSubmitted = count($taskSubmittedDataArr);

            $proName = $projectDetails['projectName'].'-'.$this->config->item('terms_assessment_array_config')[$projectDetails['termId']]['name'].' '.$projectDetails['year'];
            $proSlug = create_slug_ch($proName);

            $i=2;
            foreach($proTaskListDataArr as $task){

                // $sheet->getRowDimension($i)->setRowHeight(1);
                
                // $subTskCnt = $task['subTskCnt'];                          
                    
                $tRes = filter_array($proWiseSubTaskDataArr,$task['taskId'],'taskId');
                $subTskCnt = count($tRes);

                $assignedProjectManagersDataArr = assignedProTaskDataArr($task['projectId'],$task['taskId']);
                $totalProjectManagersCnt = count($assignedProjectManagersDataArr);
                
                $avgPer = 0;
                if($subTskCnt>0){
                    $avgSubTaskActioArr = array();
                    $completedUserArr = array();
                    $inProcessUserArr = array();
                    $notStartedUserArr = array();
                    foreach($tRes as $subTask){ 
                        if($totalProjectManagersCnt>0){                                   
                            $avgSubTaskActioArr[] = avgUserTakeSubTaskActionCntCh($subTask['subTaskId'])/$totalProjectManagersCnt;
                        }else{
                            $avgSubTaskActioArr[] = 0;
                        }
                    }                    
                    if(count($avgSubTaskActioArr)>0){
                        $avgPer = round((array_sum($avgSubTaskActioArr)/count($avgSubTaskActioArr))*100,2);
                    }
                    foreach($assignedProjectManagersDataArr as $roleDetails){                                     
                        $chkStsUserRes = chkStsofUserTakeActionCh($roleDetails['userId'],$task['taskId']);
                        if($chkStsUserRes==$subTskCnt){
                            $completedUserArr[] = 1;
                        }else if($chkStsUserRes>0){
                            $inProcessUserArr[] = 1;
                        }else{
                            $notStartedUserArr[] = 1;  
                        }
                    }                                
                    $completedUserCnt = count($completedUserArr);
                    $inProcessUserCnt = count($inProcessUserArr);
                    $notStartedUserCnt = count($notStartedUserArr);
                }else{
                    $completedUserCnt = avgUserTakeTaskActionCntCh($task['taskId']);
                    $avgPer = 0;
                    if($totalProjectManagersCnt>0){
                        $avgPer = round(($completedUserCnt/$totalProjectManagersCnt)*100,2);
                    }
                    $inProcessUserCnt = 0;
                    $notStartedUserCnt = $totalProjectManagersCnt-$completedUserCnt;
                } 

                $upTaskName = $task['taskName']; 
                $sheet->setCellValue('A'.$i, $upTaskName);

                $upPriority = ''; 
                if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                    $upPriority = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['name'];
                    $bgColor = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['bgColor'];
                    $fontColor = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['fontColor'];
                    $sheet->setCellValue('B'.$i, $upPriority);
                    $sheet->getStyle('B'.$i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF'.$bgColor);
                    $sheet->getStyle('B'.$i)->getFont()->getColor()->setARGB('FF'.$fontColor);
                } 
                $updueDate = ''; 

                if(isset($task['dueDateStr']) && $task['dueDateStr']!='' && $task['dueDateStr']>0){
                    $updueDate = date('m/d/Y',$task['dueDateStr']);
                }                

                $sheet->setCellValue('C'.$i, $updueDate);
                $sheet->setCellValue('D'.$i, $completedUserCnt);
                $sheet->setCellValue('E'.$i, $inProcessUserCnt);
                $sheet->setCellValue('F'.$i, $notStartedUserCnt);
                $sheet->setCellValue('G'.$i, $avgPer.'%');

                $i++;

            }

            if (ob_get_length()) {
                ob_end_clean();
            }
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$proSlug.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

			 
		}else{
			redirect(base_url().$this->config->item('system_directory_name').'analytics');
		}
    }
}