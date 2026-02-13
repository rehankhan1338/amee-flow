<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Master_alignment_map_mdl extends CI_Model {
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
	public function courseDetailsArr($mamCourseId){
		$this->db->where('mamCourseId', $mamCourseId);
		$query = $this->db->get('master_alignment_maps_courses');
		return $query->row_array();
	}
	
	public function mamDetailsArr($mamId){
		$this->db->where('mamId', $mamId);
		$query = $this->db->get('master_alignment_maps');
		return $query->row_array();
	}
    public function chkAlignmentMapSts($universityId,$uniAdminId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$query = $this->db->get('master_alignment_maps');
		return $query->row_array();
	}
	public function oversightsDataArr($universityId,$uniAdminId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('unitName', 'asc');
		$query = $this->db->get('master_alignment_maps_oversights');
		return $query->result_array();
	}
	public function alignmentCousesDataArr($universityId,$uniAdminId,$oversigntId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('oversigntId', $oversigntId);
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('courseSubject,courseNBR', 'asc');
		$query = $this->db->get('master_alignment_maps_courses');
		return $query->result_array();
	}
	public function manageClassEntry(){
		$mamCourseIdChk = trim($this->input->post('txtmamCourseId'));
		$oversigntId = trim($this->input->post('txtoversigntId'));
		if(isset($oversigntId) && $oversigntId!='' && $oversigntId>0){
			$mamId = trim($this->input->post('txtmamId'));
			$uniAdminId = trim($this->input->post('mauniAdminId'));
			$universityId = trim($this->input->post('mauniversityId'));
			$program = trim($this->input->post('txtProgram'));
			$courseSubject = trim($this->input->post('txtcourseSubject'));
			$courseNBR = trim($this->input->post('txtcourseNBR'));
			$courseSlug = create_slug_ch($courseSubject.'-'.$courseNBR);
			$courseISLO = '';
			if(isset($_POST['chkISLO']) && $_POST['chkISLO']!=''){
				if(count($_POST['chkISLO'])>0){
					$courseISLO = implode(',',$_POST['chkISLO']);
				}
			}
			$courseGISLO = '';
			if(isset($_POST['chkGISLO']) && $_POST['chkGISLO']!=''){
				if(count($_POST['chkGISLO'])>0){
					$courseGISLO = implode(',',$_POST['chkGISLO']);
				}
			}
			$coursePSLO = '';
			if(isset($_POST['chkPSLO']) && $_POST['chkPSLO']!=''){
				if(count($_POST['chkPSLO'])>0){
					$coursePSLO = implode(',',$_POST['chkPSLO']);
				}
			}
			$courseGPSLO = '';
			if(isset($_POST['chkGPSLO']) && $_POST['chkGPSLO']!=''){
				if(count($_POST['chkGPSLO'])>0){
					$courseGPSLO = implode(',',$_POST['chkGPSLO']);
				}
			}
			if(isset($mamCourseIdChk) && $mamCourseIdChk!='' && $mamCourseIdChk>0){
				$this->db->where('mamCourseId != ', $mamCourseIdChk);
			}
			$this->db->where('universityId', $universityId);
			$this->db->where('uniAdminId', $uniAdminId);
			$this->db->where('oversigntId', $oversigntId);
			$this->db->where('courseSubject', $courseSubject);
			$this->db->where('courseNBR', $courseNBR);
			$this->db->where('isDeleted', 0);
			$qryCourse = $this->db->get('master_alignment_maps_courses');
			$courseCnt = $qryCourse->num_rows();
			if($courseCnt==0){                        
				if(isset($mamCourseIdChk) && $mamCourseIdChk!='' && $mamCourseIdChk>0){
					$this->db->where('mamCourseId',$mamCourseIdChk); 
					$this->db->update('master_alignment_maps_courses', array('program'=>$program, 'courseSubject'=>$courseSubject, 'courseNBR'=>$courseNBR, 'courseSlug'=>$courseSlug, 'courseISLO'=>$courseISLO, 'courseGISLO'=>$courseGISLO, 'coursePSLO'=>$coursePSLO, 'courseGPSLO'=>$courseGPSLO, 'isActive'=>0));
				}else{
					$this->db->insert('master_alignment_maps_courses', array('mamId'=>$mamId, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'oversigntId'=>$oversigntId, 'courseSubject'=>$courseSubject, 'courseNBR'=>$courseNBR, 'courseSlug'=>$courseSlug, 'courseISLO'=>$courseISLO, 'courseGISLO'=>$courseGISLO, 'coursePSLO'=>$coursePSLO, 'courseGPSLO'=>$courseGPSLO, 'isActive'=>0));
				}
				return 'success||';
			}else{
				return 'error||Oops, course already exist.';
			} 
		}else{
			return 'error||Oops, please check the Oversight Units.';
		}
	}
	public function toggleCourseSLO($mamCourseId, $sloType, $sloNumber, $action){
		// Map sloType to the correct DB column
		$columnMap = array(
			'ISLO'  => 'courseISLO',
			'GISLO' => 'courseGISLO',
			'PSLO'  => 'coursePSLO',
			'GPSLO' => 'courseGPSLO'
		);
		if(!isset($columnMap[$sloType])){
			return array('status'=>'error','message'=>'Invalid SLO type');
		}
		$column = $columnMap[$sloType];

		// Fetch current record
		$this->db->where('mamCourseId', $mamCourseId);
		$query = $this->db->get('master_alignment_maps_courses');
		$row = $query->row_array();
		if(!$row){
			return array('status'=>'error','message'=>'Course not found');
		}

		// Parse current values
		$currentValues = array();
		if(isset($row[$column]) && $row[$column] != ''){
			$currentValues = explode(',', $row[$column]);
			$currentValues = array_map('trim', $currentValues);
		}

		$sloNumber = strval($sloNumber);

		if($action === 'add'){
			if(!in_array($sloNumber, $currentValues)){
				$currentValues[] = $sloNumber;
			}
			$newState = 1;
		} else {
			$currentValues = array_diff($currentValues, array($sloNumber));
			$newState = 0;
		}

		// Sort numerically and re-implode
		$currentValues = array_filter($currentValues, function($v){ return $v !== ''; });
		sort($currentValues, SORT_NUMERIC);
		$newValue = implode(',', $currentValues);

		// Update DB
		$this->db->where('mamCourseId', $mamCourseId);
		$this->db->update('master_alignment_maps_courses', array($column => $newValue));

		return array('status'=>'success','newState'=>$newState,'newValue'=>$newValue);
	}

	public function uploadMasterAlignmentMap($path){
		$uniAdminId = trim($this->input->post('mauniAdminId'));
		$universityId = trim($this->input->post('mauniversityId'));
		$createdBy = trim($this->input->post('macreatedBy'));
		$mamIdChk = trim($this->input->post('txtMamId'));
		$ctime = time();
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$query = $this->db->get('master_alignment_maps');
		$cnt = $query->num_rows();
		if($cnt==0){
			$this->db->insert('master_alignment_maps', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'createdBy'=>$createdBy, 'addedOn'=>$ctime));
			$mamId = $this->db->insert_id();
		}else{
			$row = $query->row_array();
            $mamId = $row['mamId'];
		}		
		if(isset($_FILES['curFile']['name']) && $_FILES['curFile']['name']!=''){            
			$curTime = time().'-mam-'.$uniAdminId;
			$oldCurFile = $this->input->post('txtoldCurFile');
			$fileDocument = explode(".", $_FILES['curFile']['name']);
			$fileExt = strtolower(end($fileDocument));
			$fileName = $curTime.".".$fileExt;
			$config['file_name'] = $fileName;
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'xlsx';
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->do_upload('curFile');
			$errors = $this->upload->display_errors('<span>', '</span>');
			if(isset($errors) && $errors!=''){
				return 'error||'.$errors;
			}else{
				if(isset($oldCurFile) && $oldCurFile!=''){
					unlink($path.$oldCurFile); 	
				}				
				// $this->db->where('mamId', $mamId);
				// $this->db->update('master_alignment_maps', array("curUploadedFile"=>$fileName, 'lastUpdatedOn'=>$ctime)); 
				return 'success||'.$fileName.'||'.$mamId;
			}            
		}else{
			return 'error||Please upload your file.';
		}
		// echo '<pre>';print_r($_POST);print_r($_FILES);
	}
	public function deleteCourse($courseIds){
		$where = ' mamCourseId in ('.$courseIds.')';
		$this->db->where($where);
		$this->db->delete('master_alignment_maps_courses');
		$this->session->set_flashdata('success', 'Course has been deleted successfully.'.$courseIds);	
	}

	public function sharedWithDetails($enwithShareId){
		$this->db->select('sw.*, s.*');
		$this->db->from('alignment_map_share_with as sw');
		$this->db->where('sw.enwithShareId', $enwithShareId);
		$this->db->join('alignment_map_share as s', 's.shareId = sw.shareId', 'LEFT');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function notesDataArr($mamCourseId){
		$this->db->select('n.notes, n.addedOn, ua.auName');
		$this->db->from('master_alignment_maps_notes as n');
		$this->db->where('n.mamCourseId', $mamCourseId);
		$this->db->order_by('n.mamNoteId', 'desc');
		$this->db->join('users_access as ua', 'ua.userAccessId = n.userAccessId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function shareAlignmentMap(){
		$shareFrom = trim($this->input->post('shareFrom'));
		$mamId = trim($this->input->post('mamId'));
		$userId = trim($this->input->post('userId'));
		$userAccessId = trim($this->input->post('userAccessId'));
		$universityId = trim($this->input->post('universityId'));
		$oversigntId = trim($this->input->post('seloversigntId'));

		$roleType = trim($this->input->post('txt_roleType'));		 

		if(isset($_POST['chRoleIds']) && $_POST['chRoleIds']!=''){
			if(count($_POST['chRoleIds'])>0){

				// echo '<pre>'; print_r($_POST);	
				$subject = trim($this->input->post('amSubject'));			
				$sentMsg = trim($this->input->post('amContent'));				
				$liveSts = 1;

				$roleIds = $this->input->post('chRoleIds');
				$roleIdsStr = implode(',',$roleIds);

				$todayDate = strtotime(date('Y-m-d'));	
				$curTime = time();	

				$this->db->insert('alignment_map_share', array('shareFrom'=>$shareFrom, 'mamId'=>$mamId, 'userId'=>$userId, 'universityId'=>$universityId, 'userAccessId'=>$userAccessId, 'sentMsg'=>$sentMsg, 'roleType'=>$roleType, 'roleIds'=>$roleIdsStr, 'sentDate'=>$todayDate, 'sentOn'=>$curTime));
				$shareId = $this->db->insert_id();
				$eshareId = generateRandomNumStringCh(3).'sam'.$shareId.generateRandomNumStringCh(3);
				$this->db->where('shareId',$shareId); 
				$this->db->update('alignment_map_share', array("eshareId"=>$eshareId));
				
				if($roleType=='other'){
					$sendToResArr = $this->input->post('chRoleIds');
				}else if($roleType=='self'){
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

				$oi = 0;
				foreach($sendToResArr as $resDetails){

					if($roleType=='other'){
						$swName = $this->input->post('spName')[$oi];
						$swEmail = $this->input->post('chRoleIds')[$oi];
					}else{
						$swName = trim($resDetails['swName']);
						$swEmail = trim($resDetails['swEmail']);
					}
					
					$this->db->insert('alignment_map_share_with', array('shareId'=>$shareId, 'userId'=>$userId, 'swName'=>$swName, 'swEmail'=>$swEmail, 'liveSts'=>$liveSts));
					$withShareId = $this->db->insert_id();
					$enwithShareId = generateRandomNumStringCh(3).'swr'.$withShareId.generateRandomNumStringCh(3);
					$this->db->where('withShareId',$withShareId); 
					$this->db->update('alignment_map_share_with', array("enwithShareId"=>$enwithShareId));

					$lnk = base_url().'share/alignment_map/'.$enwithShareId;					
					$message = str_replace('{receiverName}',$swName,$sentMsg);
					$message = str_replace('{receiverActionLink}',$lnk,$message);
					send_mail($swEmail,$message,$swName,'info',$subject); 
					$oi++;
				}
				return 'success||'.base_url().'sampling_plan/alignment_map?osd='.$oversigntId;
				// return 'success||'.base_url().'share/alignment_map/'.$enwithShareId.'?osd='.$oversigntId;	
			}else{
				return 'error||Oops, please select at least one recipient.';
			}
		}else{
			return 'error||Oops, please select at least one recipient.';
		}	

	}

	public function saveNotesAM(){
		$mamCourseId = $this->input->post('txt_mamCourseId');
		$oversigntId = $this->input->post('txt_oversigntId');
		$userId = $this->input->post('txt_userId');
		$userAccessId  = $this->input->post('txt_userAccessId');
		$notes = $this->input->post('txtNotes');

		$this->db->where('mamCourseId', $mamCourseId);
		$this->db->where('userId', $userId);
		$query = $this->db->get('master_alignment_maps_notes');
		$cnt = $query->num_rows();
		if($cnt==0){
			$this->db->insert('master_alignment_maps_notes', array('mamCourseId'=>$mamCourseId, 'userId'=>$userId, 'userAccessId'=>$userAccessId, 'notes'=>$notes, 'addedOn'=>time()));
		}else{
			$row = $query->row_array();
			$this->db->where('mamNoteId',$row['mamNoteId']); 
			$this->db->update('master_alignment_maps_notes', array("notes"=>$notes));		
		}	
		$this->session->set_flashdata('success', 'Note has been updated successfully.');	
		return 'success||'.base_url().'sampling_plan/alignment_map?osd='.$oversigntId;	
	}

	public function alignmentMapNotesData($mamCourseId,$userId){
		$this->db->where('mamCourseId', $mamCourseId);
		$this->db->where('userId', $userId);
		$query = $this->db->get('master_alignment_maps_notes');
		return $query->row_array();
	}	

	public function userFeedbackDataArr($mamId,$userId){
		$dbprefix = $this->db->dbprefix;
		$this->db->where('actionTakenSts', 1);
		$this->db->where('liveSts', 1);
		$this->db->where('userId', $userId);
		$where = ' shareId in (select shareId from '.$dbprefix.'alignment_map_share where submitFor=1 and mamId='.$mamId.')';
		$this->db->where($where);
		$qry = $this->db->get('alignment_map_share_with');
		return $qry->result_array();
	}

	public function submitSharedAMEntry(){
		$dbprefix = $this->db->dbprefix;
		$mamId = trim($this->input->post('h_mamId'));		
		$enwithShareId = trim($this->input->post('h_enwithShareId'));
		$oversigntId =  trim($this->input->post('h_oversigntId'));
		$submitFor = trim($this->input->post('h_submitFor'));
		$todayDate = strtotime(date('Y-m-d'));	
		$curTime = time();	
		$responseMsg = $this->input->post('responseMsg');
		
		if($submitFor==1){
			if(isset($responseMsg) && $responseMsg!=''){

				$this->db->where('enwithShareId',$enwithShareId); 
				$this->db->update('alignment_map_share_with', array("actionTakenSts"=>1,"reason"=>$responseMsg, "actionTakenDate"=>$todayDate, "actionTakenOn"=>$curTime));		
							
				$this->db->where('actionTakenSts', 1);
				$this->db->where('liveSts', 1);
				$where = ' shareId in (select shareId from '.$dbprefix.'alignment_map_share where submitFor=1 and mamId='.$mamId.')';
				$this->db->where($where);
				$qry = $this->db->get('alignment_map_share_with');
				$feedbackCnt = $qry->num_rows();

				$this->db->where('mamId',$mamId); 
				$this->db->update('master_alignment_maps', array("feedbackCnt"=>$feedbackCnt));
			}else{
				return 'error||Oops, please leave your feedback.';	
			}		

		}else{
			// $actionTakenSts = trim($this->input->post('h_clickedBtn'));
			// $this->db->where('enwithShareId',$enwithShareId); 
			// $this->db->update('sampling_plans_share_with', array("actionTakenSts"=>$actionTakenSts,"reason"=>$responseMsg, "actionTakenDate"=>$todayDate, "actionTakenOn"=>$curTime));		
		}
		return 'success||'.base_url().'share/alignment_map/'.$enwithShareId.'?osd='.$oversigntId;	
	}

}