<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Master_alignment_map extends CI_Controller {
 	 
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
        $this->load->model('Master_alignment_map_mdl');	  
        $this->data['active_class'] = 'planning-doc-menu';
        $this->data['title'] = 'Master Alignment Map - '.$this->config->item('product_name');
        $this->data['addBtnTxt'] = 'Upload Map';
 	}
    public function index(){
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $alignmentMapDetails = $this->Master_alignment_map_mdl->chkAlignmentMapSts($universityId,$uniAdminId);
        $this->data['pageTitle'] = 'Master Alignment Map';
        $this->data['pageSubTitle'] = '';
        $this->load->view('system-admin/includes/header',$this->data);
        if(isset($alignmentMapDetails['curUploadedFile']) && $alignmentMapDetails['curUploadedFile']!=''){
            $this->data['mamDetailsArr'] = $alignmentMapDetails;
            $this->data['oversightsDataArr'] = $this->Master_alignment_map_mdl->oversightsDataArr($universityId,$uniAdminId);
            if(isset($_GET['osd']) && $_GET['osd']!='' && $_GET['osd']>0){
                $oversigntId = $_GET['osd'];
            }else{
                $oversigntId = $this->data['oversightsDataArr'][0]['oversigntId'];            
            }
            $this->data['seloversigntId'] = $oversigntId;            
            $this->data['cousesDataArr'] = $this->Master_alignment_map_mdl->alignmentCousesDataArr($universityId,$uniAdminId,$oversigntId);
            $this->load->view('system-admin/planning-documents/master-alignment-map/list',$this->data);
        }else{
            $this->load->view('system-admin/planning-documents/master-alignment-map/create',$this->data);
        }        
        $this->load->view('system-admin/includes/footer',$this->data);
    }
    public function ajaxFields(){
        if(isset($_GET['mamId']) && $_GET['mamId']!='' && $_GET['mamId']>0){
            $this->data['mamDetailsArr'] = $this->Master_alignment_map_mdl->mamDetailsArr($_GET['mamId']);
        }else{
            $this->data['mamDetailsArr'] = array();
        }
        $this->load->view('system-admin/planning-documents/master-alignment-map/ajax-mam-fields',$this->data);
    }

    public function ajaxViewNote(){
        if(isset($_GET['mamCourseId']) && $_GET['mamCourseId']!='' && $_GET['mamCourseId']>0){
            $this->data['notesDataArr'] = $this->Master_alignment_map_mdl->notesDataArr($_GET['mamCourseId']);
        }else{
            $this->data['notesDataArr'] = array();
        }
        $this->load->view('system-admin/planning-documents/master-alignment-map/ajax-notes',$this->data);
    }

    public function deleteCourse(){
        if(isset($_GET['courseIds']) && $_GET['courseIds']!='' && $_GET['courseIds']>0){
            echo $this->Master_alignment_map_mdl->deleteCourse($_GET['courseIds']);
        }
    }
    public function ajaxCMAMFields(){
        if(isset($_GET['mamCourseId']) && $_GET['mamCourseId']!='' && $_GET['mamCourseId']>0){
            $this->data['courseDetails'] = $this->Master_alignment_map_mdl->courseDetailsArr($_GET['mamCourseId']);
        }else{
            $this->data['courseDetails'] = array();
        }
        $this->data['seloversigntId'] = $_GET['seloversigntId'];
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $this->data['mamDetails'] = $this->Master_alignment_map_mdl->chkAlignmentMapSts($universityId,$uniAdminId);
        $this->load->view('system-admin/planning-documents/master-alignment-map/ajax-course-fields',$this->data);
    }
    public function manageClassEntry(){
        echo $this->Master_alignment_map_mdl->manageClassEntry();
    }
    public function manageEntry(){
        
        $missingOversightArr = array();
        $path = './assets/upload/documents/mam/';
        $uploadRes = $this->Master_alignment_map_mdl->uploadMasterAlignmentMap($path);
        $uploadResArr = explode('||',$uploadRes);
        if($uploadResArr[0]=='error'){
            echo $uploadResArr[0].'||'.$uploadResArr[1];
        }else{
            $curUploadedFile = $uploadResArr[1];
            $mamId = $uploadResArr[2];             
        
            $uniAdminId = trim($this->input->post('mauniAdminId'));
            $universityId = trim($this->input->post('mauniversityId'));
            $createdBy = trim($this->input->post('macreatedBy'));
            $this->db->where('universityId',$universityId); 
            $this->db->where('uniAdminId',$uniAdminId); 
            $this->db->where('isDeleted', 0);
            $this->db->update('master_alignment_maps_oversights', array('isActive'=>1));
            $ctime = time();
            $this->db->where('universityId',$universityId); 
            $this->db->where('uniAdminId',$uniAdminId); 
            $this->db->where('isDeleted', 0);
            $this->db->update('master_alignment_maps_courses', array('isActive'=>1));
            // $filePath = 'sample.xlsx'; // or .csv
            $filePath = $path.$curUploadedFile;
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // echo '<pre>';
            $headerSts = 0; // 0=ok, 1=error
            $isloArr = array();
            $gisloArr = array();
            $psloArr = array();
            $gpsloArr = array();        
            for($h=0;$h<1;$h++){            
                $in=0;
                foreach($data[$h] as $key=>$header){                
                    if (substr($header, 0, 4) === 'ISLO') {
                        $isloArr[] = $key;
                    }else if (substr($header, 0, 5) === 'GISLO') {
                        $gisloArr[] = $key;
                    }else if (substr($header, 0, 4) === 'PSLO') {
                        $psloArr[] = $key;
                    }else if (substr($header, 0, 5) === 'GPSLO') {
                        $gpsloArr[] = $key;
                    }
                    $in++;
                }            
            }
            $ISLOCnt = count($isloArr);
            $GISLOCnt = count($gisloArr);
            $PSLOCnt = count($psloArr);
            $GPSLOCnt = count($gpsloArr);
            $this->db->where('mamId', $mamId);
            $this->db->update('master_alignment_maps', array("curUploadedFile"=>$curUploadedFile, 'ISLOCnt'=>$ISLOCnt, 'GISLOCnt'=>$GISLOCnt, 'PSLOCnt'=>$PSLOCnt, 'GPSLOCnt'=>$GPSLOCnt, 'lastUpdatedOn'=>$ctime));
            $oversightSlugArr = array();
            // $oversightArr = array();
            for($i=1;$i<count($data);$i++){
                
                if(isset($data[$i]) && $data[$i]!=''){
                    if(count($data[$i])>0){
                        
                        for($c=0;$c<1;$c++){ //$c=0;$c<count($data[$i]);$c++
                            if($c==0){ // only for first column oversight
                                $inOverSight = $data[$i][$c];
                                $inOverSlug = create_slug_ch($inOverSight);
                                if(isset($inOverSlug) && $inOverSlug!=''){
                                    $good = 1;
                                }else{
                                    $missingOversightArr[] = $i;
                                }
                                if(!in_array($inOverSlug, $oversightSlugArr)){
                                    $this->db->where('unitNameSlug', $inOverSlug);
                                    $this->db->where('universityId', $universityId);
                                    $this->db->where('uniAdminId', $uniAdminId);
                                    $this->db->where('isDeleted', 0);
                                    $qryOverSight = $this->db->get('master_alignment_maps_oversights');
                                    $cntOverSight = $qryOverSight->num_rows();
                                    if($cntOverSight==0){
                                        $this->db->insert('master_alignment_maps_oversights', array('mamId'=>$mamId, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'unitName'=>$inOverSight, 'unitNameSlug'=>$inOverSlug));
                                        $oversigntId = $this->db->insert_id();
                                    }else{
                                        $overSightDetails = $qryOverSight->row();
                                        $oversigntId = $overSightDetails->oversigntId;
                                        $this->db->where('oversigntId',$oversigntId); 
                                        $this->db->update('master_alignment_maps_oversights', array('unitName'=>$inOverSight, 'unitNameSlug'=>$inOverSlug, 'isActive'=>0));
                                    }                                
                                    $oversightSlugArr[] = $inOverSlug;
                                    // $oversightArr[] = $inOverSight.'||'.$oversigntId;
                                }
                            }
                            // echo $inOverSight.'||'.$oversigntId;
                            // echo $data[$i][$c];
                            
                        }
                        $program = $data[$i][1];
                        $courseSubject = '';
                        $courseNBR = '';
                        $courseSlug = '';
                        if(isset($data[$i][2]) && $data[$i][2]!='' && isset($data[$i][3]) && $data[$i][3]!=''){ // get subject and course NBR
                            $courseSubject = trim($data[$i][2]);
                            $courseNBR = trim($data[$i][3]);
                            $courseSlug = create_slug_ch($courseSubject.'-'.$courseNBR);
                        }
                        $takeIsloNos = array();
                        for($n=0;$n<count($isloArr);$n++){                         
                            if(isset($data[$i][$isloArr[$n]]) && $data[$i][$isloArr[$n]]!=''){
                                if(trim($data[$i][$isloArr[$n]])=='Yes'){
                                    $takeIsloNos[] = $n+1;
                                }
                            }
                        }
                        $courseISLO = implode(',',$takeIsloNos);
                        $takeGisloNos = array();
                        for($n=0;$n<count($gisloArr);$n++){                         
                            if(isset($data[$i][$gisloArr[$n]]) && $data[$i][$gisloArr[$n]]!=''){
                                if(trim($data[$i][$gisloArr[$n]])=='Yes'){
                                    $takeGisloNos[] = $n+1;
                                }
                            }
                        }
                        $courseGISLO = implode(',',$takeGisloNos);
                        $takePisloNos = array();
                        for($n=0;$n<count($psloArr);$n++){                         
                            if(isset($data[$i][$psloArr[$n]]) && $data[$i][$psloArr[$n]]!=''){
                                if(trim($data[$i][$psloArr[$n]])=='Yes'){
                                    $takePisloNos[] = $n+1;
                                }
                            }
                        }
                        $coursePSLO = implode(',',$takePisloNos);
                        $takeGpisloNos = array();
                        for($n=0;$n<count($gpsloArr);$n++){                         
                            if(isset($data[$i][$gpsloArr[$n]]) && $data[$i][$gpsloArr[$n]]!=''){
                                if(trim($data[$i][$gpsloArr[$n]])=='Yes'){
                                    $takeGpisloNos[] = $n+1;
                                }
                            }
                        }
                        $courseGPSLO = implode(',',$takeGpisloNos);
                        if(isset($courseSubject) && $courseSubject!='' && isset($courseNBR) && $courseNBR!=''){
                            $this->db->where('universityId', $universityId);
                            $this->db->where('uniAdminId', $uniAdminId);
                            $this->db->where('oversigntId', $oversigntId);
                            $this->db->where('courseSubject', $courseSubject);
                            $this->db->where('courseNBR', $courseNBR);
                            $this->db->where('isDeleted', 0);
                            $qryCourse = $this->db->get('master_alignment_maps_courses');
                            $courseCnt = $qryCourse->num_rows();
                            if($courseCnt==0){                        
                                $this->db->insert('master_alignment_maps_courses', array('mamId'=>$mamId, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'oversigntId'=>$oversigntId, 'program'=>$program, 'courseSubject'=>$courseSubject, 'courseNBR'=>$courseNBR, 'courseSlug'=>$courseSlug, 'courseISLO'=>$courseISLO, 'courseGISLO'=>$courseGISLO, 'coursePSLO'=>$coursePSLO, 'courseGPSLO'=>$courseGPSLO, 'isActive'=>0));
                            }else{
                                $cDetails = $qryCourse->row();
                                $this->db->where('mamCourseId',$cDetails->mamCourseId); 
                                $this->db->update('master_alignment_maps_courses', array('program'=>$program, 'courseSubject'=>$courseSubject, 'courseNBR'=>$courseNBR, 'courseSlug'=>$courseSlug, 'courseISLO'=>$courseISLO, 'courseGISLO'=>$courseGISLO, 'coursePSLO'=>$coursePSLO, 'courseGPSLO'=>$courseGPSLO, 'isActive'=>0));
                            }  
                        }      
                        // echo '<hr>';
                    }
                    
                }            
                
            }
            if(count($missingOversightArr)>0){
                echo 'error||There is a system error. You have a missing oversight unit';
            }else{
                echo 'success||';
            }
        }
        
	}
    public function toggleSLO(){
        $mamCourseId = $this->input->post('mamCourseId');
        $sloType     = $this->input->post('sloType');   // ISLO, GISLO, PSLO, GPSLO
        $sloNumber   = $this->input->post('sloNumber');  // e.g. 1,2,3...
        $action      = $this->input->post('action');     // add or remove

        if(!$mamCourseId || !$sloType || !$sloNumber || !$action){
            echo json_encode(array('status'=>'error','message'=>'Missing parameters'));
            return;
        }
        $result = $this->Master_alignment_map_mdl->toggleCourseSLO($mamCourseId, $sloType, $sloNumber, $action);
        echo json_encode($result);
    }

    public function download(){
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        
        $headerArr = array('E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
         
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['useuniAdminId'];
        $this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$query = $this->db->get('master_alignment_maps');
		$mamDetails = $query->row_array();       
        $mamId = $mamDetails['mamId'];
        $ISLOCnt = $mamDetails['ISLOCnt'];
        $GISLOCnt = $mamDetails['GISLOCnt'];
        $PSLOCnt = $mamDetails['PSLOCnt'];
        $GPSLOCnt = $mamDetails['GPSLOCnt'];
         
        $headCnt = array();
        $headNo = array();
        for($slo=1;$slo<=$ISLOCnt;$slo++){
            $headCnt[] = 'ISLO'.$slo;
            $headNo[] = $slo;
        }
        for($slo=1;$slo<=$GISLOCnt;$slo++){
            $headCnt[] = 'GISLO'.$slo;
            $headNo[] = $slo;
        }
        for($slo=1;$slo<=$PSLOCnt;$slo++){
            $headCnt[] = 'PSLO'.$slo;
            $headNo[] = $slo;
        }
        for($slo=1;$slo<=$GPSLOCnt;$slo++){
            $headCnt[] = 'GPSLO'.$slo;
            $headNo[] = $slo;
        }        
        
        $oversightsDataArr = $this->Master_alignment_map_mdl->oversightsDataArr($universityId,$uniAdminId);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(12);
        for($h=0;$h<count($headCnt);$h++){
            // echo $headCnt[$h].' ---- '.$headerArr[$h];
            $sheet->getColumnDimension($headerArr[$h])->setWidth(10);
        }        
        
        $sheet->setCellValue('A1', 'OVERSIGHT UNIT');
        $sheet->setCellValue('B1', 'PROGRAM');
        $sheet->setCellValue('C1', 'SUBJECT');
        $sheet->setCellValue('D1', 'COURSE NBR');
        for($h=0;$h<count($headCnt);$h++){
            $sheet->setCellValue($headerArr[$h].'1', $headCnt[$h]);
        }
        $i=2;
        foreach($oversightsDataArr as $os){
            
            $oversigntId = $os['oversigntId']; 
            $coursesDataArr = $this->Master_alignment_map_mdl->alignmentCousesDataArr($universityId,$uniAdminId,$oversigntId);            
            foreach($coursesDataArr as $course){
                $sheet->setCellValue('A'.$i, $os['unitName']);
                $sheet->setCellValue('B'.$i, $course['program']);
                $sheet->setCellValue('C'.$i, $course['courseSubject']);
                $sheet->setCellValue('D'.$i, $course['courseNBR']);
                if(isset($course['courseISLO']) && $course['courseISLO']!=''){
                    $courseISLOArr = explode(',',$course['courseISLO']);
                }else{
                    $courseISLOArr = array();
                }
                if(isset($course['courseGISLO']) && $course['courseGISLO']!=''){
                    $courseGISLOArr = explode(',',$course['courseGISLO']);
                }else{
                    $courseGISLOArr = array();
                }
                if(isset($course['coursePSLO']) && $course['coursePSLO']!=''){
                    $coursePSLOArr = explode(',',$course['coursePSLO']);
                }else{
                    $coursePSLOArr = array();
                }
                if(isset($course['courseGPSLO']) && $course['courseGPSLO']!=''){
                    $courseGPSLOArr = explode(',',$course['courseGPSLO']);
                }else{
                    $courseGPSLOArr = array();
                }                
                for($h=0;$h<count($headCnt);$h++){
                    $sts = '';
                    $headerChk = $headCnt[$h];
                    $headKey = $headNo[$h];
                     
                    if (substr($headerChk, 0, 4) === 'ISLO') {                         
                        if(in_array($headKey,$courseISLOArr)){
                            $sts = 'Yes';
                        }
                    }else if (substr($headerChk, 0, 5) === 'GISLO') {
                        if(in_array($headKey,$courseGISLOArr)){
                            $sts = 'Yes';
                        }
                    }else if (substr($headerChk, 0, 4) === 'PSLO') {
                        if(in_array($headKey,$coursePSLOArr)){
                            $sts = 'Yes';
                        }
                    }else if (substr($headerChk, 0, 5) === 'GPSLO') {
                        if(in_array($headKey,$courseGPSLOArr)){
                            $sts = 'Yes';
                        }
                    }
                    
                    $sheet->setCellValue($headerArr[$h].$i, $sts);
                }
                 
                $i++;
            }
            
            
        }
        if (ob_get_length()) {
            ob_end_clean();
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="master-alignment-map.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
        
    }
    
}