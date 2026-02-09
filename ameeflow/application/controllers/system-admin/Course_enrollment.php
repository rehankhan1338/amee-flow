<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Course_enrollment extends CI_Controller {
 	 
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
        $this->data['active_class'] = 'planning-doc-menu';
        $this->data['title'] = 'Schedule of Courses - '.$this->config->item('product_name');
        $this->data['addBtnTxt'] = 'Upload SOC';
 	}
     public function index(){
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $this->data['courseEnrollmentDataArr'] = $this->Course_enrollment_mdl->courseEnrollmentDataArr($universityId,$uniAdminId);
        $this->data['pageTitle'] = 'Schedule of Courses';
        $this->data['pageSubTitle'] = '';
        $this->load->view('system-admin/includes/header',$this->data);
        if(count($this->data['courseEnrollmentDataArr'])>0){
            
            if(isset($_GET['ced']) && $_GET['ced']!='' && $_GET['ced']>0){
                $ceId = $_GET['ced'];
            }else{
                $ceId = $this->data['courseEnrollmentDataArr'][0]['ceId'];            
            }
            $this->data['selceId'] = $ceId;
            $this->data['classesDataArr'] = $this->Course_enrollment_mdl->pmClassesDataArr($ceId);
            // echo count($this->data['classesDataArr']);die;
            // $this->data['facultyDataArr'] = $this->Course_enrollment_mdl->courseFacultyDataArr($universityId,$uniAdminId);
            $this->load->view('system-admin/planning-documents/course-enrollment/list',$this->data);
        }else{
            $this->load->view('system-admin/planning-documents/course-enrollment/create',$this->data);
        }
        
        $this->load->view('system-admin/includes/footer',$this->data);
    }

    public function addIntoRecognitionFlow(){
        if(isset($_GET['ceId']) && $_GET['ceId']!='' && $_GET['ceId']>0){
            $universityId = $this->data['sessionDetailsArr']['universityId'];
            $uniAdminId = $this->data['useuniAdminId'];
            $this->Course_enrollment_mdl->addIntoRecognitionFlow($_GET['ceId'],$_GET['classIds'],$universityId,$uniAdminId);
        }
    }

    public function recognitionFlow(){
        // echo '<pre>'; print_r($this->data['sessionDetailsArr']);die;
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $this->data['pageTitle'] = 'Faculty Recognition';
        $this->data['pageSubTitle'] = '';
        $this->data['pageCallFrom'] = 1;
        $this->load->view('system-admin/includes/header',$this->data);
        $this->data['courseEnrollmentDataArr'] = $this->Course_enrollment_mdl->courseEnrollmentWithTempDataArr($universityId,$uniAdminId);
        if(count($this->data['courseEnrollmentDataArr'])>0){
            if(isset($_GET['ced']) && $_GET['ced']!='' && $_GET['ced']>0){
                $ceId = $_GET['ced'];
            }else{
                $ceId = $this->data['courseEnrollmentDataArr'][0]['ceId'];            
            }
            $this->data['selceId'] = $ceId;
            $this->data['recognitionFlowDataArr'] = $this->Course_enrollment_mdl->recognitionFlowDataArr($universityId,$uniAdminId,$ceId);            
            $this->load->view('system-admin/planning-documents/course-enrollment/recognition-flow',$this->data);            
        }else{

        }
        $this->load->view('system-admin/includes/footer',$this->data);
    }

    public function resendCertificate(){
        if(isset($_GET['rfIds']) && $_GET['rfIds']!=''){
            $universityId = $this->data['sessionDetailsArr']['universityId'];
            $uniAdminId = $this->data['useuniAdminId'];
            $this->Course_enrollment_mdl->resendCertificate($_GET['rfIds'],$universityId,$uniAdminId);
        }
    }     

    

    public function create(){
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $this->data['pageTitle'] = 'Schedule of Courses';
        $this->data['pageSubTitle'] = '';
        $this->load->view('system-admin/includes/header',$this->data);
        $this->load->view('system-admin/planning-documents/course-enrollment/create',$this->data);
        $this->load->view('system-admin/includes/footer',$this->data);
    }
    
    public function ajaxFields(){
        if(isset($_GET['ceId']) && $_GET['ceId']!='' && $_GET['ceId']>0){
            $this->data['ceDetailsArr'] = $this->Course_enrollment_mdl->ceDetailsArr($_GET['ceId']);
        }else{
            $this->data['ceDetailsArr'] = array();
        }
        $this->load->view('system-admin/planning-documents/course-enrollment/ajax-ce-fields',$this->data);
    }
    public function ajaxCCEFields(){
        if(isset($_GET['ceClassId']) && $_GET['ceClassId']!='' && $_GET['ceClassId']>0){
            $this->data['classDetails'] = $this->Course_enrollment_mdl->classDetailsArr($_GET['ceClassId']);
        }else{
            $this->data['classDetails'] = array();
        }
        // $universityId = $this->data['sessionDetailsArr']['universityId'];
        // $uniAdminId = $this->data['useuniAdminId'];
        // $this->data['facultyDataArr'] = $this->Course_enrollment_mdl->courseFacultyDataArr($universityId,$uniAdminId);
        $this->data['selceId'] = $_GET['selceId'];
        $this->data['ceDetailsArr'] = $this->Course_enrollment_mdl->ceDetailsArr($_GET['selceId']);
        $this->load->view('system-admin/planning-documents/course-enrollment/ajax-class-fields',$this->data);
    }
    public function manageClassEntry(){
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        echo $this->Course_enrollment_mdl->manageClassEntry($universityId,$uniAdminId);
    }
    public function deleteClass(){
        if(isset($_GET['classIds']) && $_GET['classIds']!='' && $_GET['classIds']>0){
            echo $this->Course_enrollment_mdl->deleteClass($_GET['classIds']);
        }
    }
    public function manageTemporaryFaculty(){
        $path = './assets/upload/documents/ce/';
        // $curUploadedFile='1762517236-ce-1.xlsx';
        $uploadRes = $this->Course_enrollment_mdl->uploadCourseDoc($path,'1');
        $uploadResArr = explode('||',$uploadRes);
        if($uploadResArr[0]=='error'){
            echo $uploadResArr[0].'||'.$uploadResArr[1];
        }else{
            
            $curUploadedFile = $uploadResArr[1];
            $ceId = $uploadResArr[2];             
            $uniAdminId = trim($this->input->post('mauniAdminId'));
            $universityId = trim($this->input->post('mauniversityId'));
            $filePath = $path.$curUploadedFile;
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // echo '<pre>'; print_r($data);
            $addDate = strtotime(date('Y-m-d'));
            $curTime = time();

            for($i=1;$i<count($data);$i++){
                if(isset($data[$i]) && $data[$i]!=''){
                    if(count($data[$i])>0){                        
                        if(isset($data[$i][0]) && $data[$i][0]!='' && isset($data[$i][1]) && $data[$i][1]!=''){
                            $facultyName = $data[$i][0];
                            $facultyEmail =$data[$i][1];
                            if(isset($data[$i][2]) && $data[$i][2]!=''){
                                $deptName = $data[$i][2];
                            }else{
                                $deptName = '';
                            }
                            if(isset($data[$i][3]) && $data[$i][3]!=''){
                                $courseAssessed = $data[$i][3];
                            }else{
                                $courseAssessed = '';
                            }
                            if(isset($data[$i][4]) && $data[$i][4]!=''){
                                $nofSections = $data[$i][4];
                            }else{
                                $nofSections = '';
                            }
                            
                            $this->db->where('ceId', $ceId);
                            $this->db->where('facultyEmail', $facultyEmail);
                            $this->db->where('universityId', $universityId);
                            $this->db->where('uniAdminId', $uniAdminId);
                            $this->db->where('isDeleted', 0);
                            $qryCls = $this->db->get('faculty_recognition_flow');
                            $cntCls = $qryCls->num_rows();
                            if($cntCls==0){
                                $this->db->insert('faculty_recognition_flow', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'ceId'=>$ceId, 'facultyName'=>$facultyName, 'facultyEmail'=>$facultyEmail, 'deptName'=>$deptName, 'courseAssessed'=>$courseAssessed, 'nofSections'=>$nofSections, 'lastUpdatedOn'=>$curTime, 'addDate'=>$addDate));
                                $rfId = $this->db->insert_id();
                                $encryptId = generateRandomNumStringCh(4).'rf'.$rfId.generateRandomNumStringCh(4);
                                $this->db->where('rfId',$rfId); 
                                $this->db->update('faculty_recognition_flow', array("encryptId"=>$encryptId));
                            }else{
                                $row = $qryCls->row_array();
                                $this->db->where('rfId',$row['rfId']); 
                                $this->db->update('faculty_recognition_flow', array("facultyName"=>$facultyName, 'deptName'=>$deptName, 'courseAssessed'=>$courseAssessed, 'nofSections'=>$nofSections, 'lastUpdatedOn'=>$curTime));
                            }
                        }
                    }
                }
            }
            $this->session->set_flashdata('success', 'Added successfully.');	               
            echo 'success||'.$ceId;
        }
    }
    public function manageEntry(){
        $path = './assets/upload/documents/ce/';
        $uploadRes = $this->Course_enrollment_mdl->uploadCourseDoc($path);
        $uploadResArr = explode('||',$uploadRes);
        if($uploadResArr[0]=='error'){
            echo $uploadResArr[0].'||'.$uploadResArr[1];
        }else{
            
            $curUploadedFile = $uploadResArr[1];
            $ceId = $uploadResArr[2];             
            $uniAdminId = trim($this->input->post('mauniAdminId'));
            $universityId = trim($this->input->post('mauniversityId'));            
            // $filePath = 'sample-ce.xlsx'; // or .csv
            $filePath = $path.$curUploadedFile;
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // echo '<pre>';
            
            for($i=1;$i<count($data);$i++){
                if(isset($data[$i]) && $data[$i]!=''){
                    if(count($data[$i])>0){                         
                        //if(isset($data[$i][0]) && $data[$i][0]!=''){

                        if(isset($data[$i][0]) && $data[$i][0]!=''){
                             $subject = $data[$i][0];
                            $courseNBR = $data[$i][1];
                        }else{
                             $subject = $subjectOld;
                             $courseNBR = $courseNBROld;
                        }
                            // $subject = $data[$i][0];
                            // $courseNBR = $data[$i][1];
                            $scSlug = create_slug_ch($subject.'-'.$courseNBR);
                            $classNBR = $data[$i][2];
                            $sectionNo = $data[$i][3];
                            $courseTitle = $data[$i][4];
                            $enrolled = $data[$i][5];
                            
                            $facultyNameSlug = '';
                            $firstName = '';
                            $lastName = '';
                            if(isset($data[$i][6]) && $data[$i][6]!=''){
                                $facultyName = $data[$i][6];
                                $facultyNameArr = explode(',',$facultyName);
                                $facultyNameSlug = create_slug_ch($facultyName);
                                $lastName = $facultyNameArr[0];
                                if(isset($facultyNameArr[1]) && $facultyNameArr[1]!=''){
                                    $firstName = $facultyNameArr[1];
                                }
                            }
                            $email = '';
                            if(isset($data[$i][7]) && $data[$i][7]!=''){
                                $email = trim(strtolower($data[$i][7]));
                            }
                            $deptName = $data[$i][8];
                            $courseModality = $data[$i][9];
                            // $courseLevel = '';
                            // if (substr($courseNBR, 0, 1)<=2) {
                            //     $courseLevel = 'lower division';
                            // }else if (substr($courseNBR, 0, 1) == 3 || substr($courseNBR, 0, 1) == 4) {
                            //     $courseLevel = 'upper division';
                            // }else if (substr($courseNBR, 0, 1)>4) {
                            //     $courseLevel = 'graduate';
                            // }                             
                            
                            $courseLevel = '';
                            if(isset($courseNBR) && $courseNBR!=''){
                                $courseNBRChk = trim($courseNBR);
                                if (substr($courseNBRChk, 0, 1)<=2) {
                                    $courseLevel = 'lower division';
                                }else if (substr($courseNBRChk, 0, 1) == 3 || substr($courseNBRChk, 0, 1) == 4) {
                                    $courseLevel = 'upper division';
                                }else if (substr($courseNBRChk, 0, 1)>4) {
                                    $courseLevel = 'graduate';
                                } 
                            }
                            
                            
                            if(isset($data[$i][10]) && $data[$i][10]!=''){
                                $courseType = $data[$i][10];
                            }else{
                                $courseType = 'Major Course';
                            }
                            if(isset($data[$i][11]) && $data[$i][11]!=''){
                                $comment = $data[$i][11];
                            }else{
                                $comment = '';
                            }
                            
                            
                            $this->db->where('ceId', $ceId);
                            $this->db->where('subject', $subject);
                            $this->db->where('courseNBR', $courseNBR);
                            $this->db->where('classNBR', $classNBR);
                            $this->db->where('isDeleted', 0);
                            $qryCls = $this->db->get('course_enrollment_classes');
                            $cntCls = $qryCls->num_rows();
                            if($cntCls==0){
                                // echo $i.'<br>';
                                $this->db->insert('course_enrollment_classes', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'ceId'=>$ceId, 'subject'=>$subject, 'courseNBR'=>$courseNBR, 'scSlug'=>$scSlug,'classNBR'=>$classNBR, 'sectionNo'=>$sectionNo, 'courseTitle'=>$courseTitle, 'enrolled'=>$enrolled, 'firstName'=>$firstName, 'lastName'=>$lastName, 'facultyNameSlug'=>$facultyNameSlug, 'facultyEmail'=>$email, 'deptName'=>$deptName, 'courseModality'=>$courseModality, 'courseLevel'=>$courseLevel, 'courseType'=>$courseType, 'comment'=>$comment, 'isActive'=>0));
                                // $ceClassId = $this->db->insert_id();
                            }else{

                                // echo $subject.' '.$courseNBR.' --- '.$classNBR.'<br>';
                                $clsDetails = $qryCls->row();
                                // $ceClassId = $clsDetails->ceClassId;
                                $this->db->where('ceClassId',$clsDetails->ceClassId); 
                                $this->db->update('course_enrollment_classes', array('subject'=>$subject, 'courseNBR'=>$courseNBR, 'scSlug'=>$scSlug, 'classNBR'=>$classNBR, 'sectionNo'=>$sectionNo, 'courseTitle'=>$courseTitle, 'enrolled'=>$enrolled, 'firstName'=>$firstName, 'lastName'=>$lastName, 'facultyNameSlug'=>$facultyNameSlug, 'facultyEmail'=>$email, 'deptName'=>$deptName, 'courseModality'=>$courseModality, 'courseLevel'=>$courseLevel, 'courseType'=>$courseType, 'comment'=>$comment, 'isActive'=>0));
                            }

                            $subjectOld = $subject;
                            $courseNBROld = $courseNBR;
                            
                       // }                        
                        // echo '<hr>';
                    }
                }
                 
            }
           
            echo 'success||';
        }
        
        
    }

    // public function chkCourseLevel(){
    //     $this->db->where('ceId', '8');
    //     $this->db->where('isDeleted', '0');
    //     //  $this->db->limit(10);
    //     $query = $this->db->get('course_enrollment_classes');
    //     $num_rows = $query->num_rows();
    //     $res = $query->result_array();
    //     foreach($res as $row){            
    //         $courseLevel = '';
    //         if(isset($row['courseNBR']) && $row['courseNBR']!=''){
    //             $courseNBR = trim($row['courseNBR']);
    //             if (substr($courseNBR, 0, 1)<=2) {
    //                 $courseLevel = 'lower division';
    //             }else if (substr($courseNBR, 0, 1) == 3 || substr($courseNBR, 0, 1) == 4) {
    //                 $courseLevel = 'upper division';
    //             }else if (substr($courseNBR, 0, 1)>4) {
    //                 $courseLevel = 'graduate';
    //             } 
    //         }
            
    //         echo $row['courseLevel'].' ----- '.$courseNBR.' ---- '.$courseLevel.' ---- '.substr($courseNBR, 0, 1);
    //         $this->db->where('ceClassId', $row['ceClassId']);
    //         $this->db->update('course_enrollment_classes', array("courseLevel"=>$courseLevel));
    //         echo '<br>';
    //     }

    // }
    public function download(){
        if(isset($_GET['ceId']) && $_GET['ceId']!='' && $_GET['ceId']>0){
            $ceId = $_GET['ceId'];
            $universityId = $this->data['sessionDetailsArr']['universityId'];
            $uniAdminId = $this->data['useuniAdminId'];
            ini_set('memory_limit', '512M');
            set_time_limit(300);		 		
            $this->db->where('ceId', $ceId);
            $this->db->where('universityId', $universityId);
            $this->db->where('uniAdminId', $uniAdminId);
            $this->db->where('isActive', '0');
            $this->db->where('isDeleted', '0');
            $query = $this->db->get('course_enrollment_classes');
            $num_rows = $query->num_rows();
            if($num_rows>0){
                $res = $query->result_array();
                // echo '<pre>';print_r($res);	die;
                $i=2;
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->getStyle('1')->getFont()->setBold(true);
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(15);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(10);
                $sheet->getColumnDimension('E')->setWidth(30);
                $sheet->getColumnDimension('F')->setWidth(10);
                $sheet->getColumnDimension('G')->setWidth(30);
                $sheet->getColumnDimension('H')->setWidth(30);
                $sheet->getColumnDimension('I')->setWidth(30);
                $sheet->getColumnDimension('J')->setWidth(18);
                $sheet->getColumnDimension('K')->setWidth(18);
                $sheet->getColumnDimension('L')->setWidth(60);
                // $sheet->getColumnDimension('M')->setWidth(60);
                
                $sheet->setCellValue('A1', 'SUBJECT');
                $sheet->setCellValue('B1', 'CATALOG NBR');
                $sheet->setCellValue('C1', 'CLASS NBR');
                $sheet->setCellValue('D1', 'SECTION NO.');
                $sheet->setCellValue('E1', 'TITLE OF COURSE');
                $sheet->setCellValue('F1', 'ENROLLED');
                $sheet->setCellValue('G1', 'INSTRUCTOR NAME');
                $sheet->setCellValue('H1', 'INSTRUCTOR EMAIL');
                $sheet->setCellValue('I1', 'DEPARTMENT NAME');
                $sheet->setCellValue('J1', 'COURSE MODALITY');
                $sheet->setCellValue('K1', 'COURSE TYPE');
                $sheet->setCellValue('L1', 'COMMENTS');
                // $sheet->setCellValue('M1', 'COURSE LEVEL');
                foreach($res as $row){
                    $sheet->setCellValue('A'.$i, $row['subject']);
                    $sheet->setCellValue('B'.$i, $row['courseNBR']);
                    $sheet->setCellValue('C'.$i, $row['classNBR']);
                    $sheet->setCellValue('D'.$i, $row['sectionNo']);
                    $sheet->setCellValue('E'.$i, $row['courseTitle']);
                    $sheet->setCellValue('F'.$i, $row['enrolled']);
                    $sheet->setCellValue('G'.$i, $row['lastName'].', '.$row['firstName']);
                    $sheet->setCellValue('H'.$i, $row['facultyEmail']);
                    $sheet->setCellValue('I'.$i, $row['deptName']);
                    $sheet->setCellValue('J'.$i, $row['courseModality']);
                    $sheet->setCellValue('K'.$i, $row['courseType']);
                    $sheet->setCellValue('L'.$i, $row['comment']);
                    // $sheet->setCellValue('M'.$i, $row['courseLevel']);
                    $i++;
                }
                if (ob_get_length()) {
                    ob_end_clean();
                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="course-enrollment.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            }
        }
	}
}