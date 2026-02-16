<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Course_enrollment_mdl extends CI_Model {
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

	public function regDetails($encryptId){
		$this->db->where('encryptId', $encryptId);
		$query = $this->db->get('faculty_recognition_flow');
		return $query->row_array();
	}

	public function recognitionFlowDataArr($universityId,$uniAdminId,$ceId){
		$this->db->select("rf.*, 
			COALESCE(NULLIF(rf.deptName,''), GROUP_CONCAT(DISTINCT cec.deptName SEPARATOR ', ')) as deptName,
			COALESCE(NULLIF(rf.courseAssessed,''), GROUP_CONCAT(DISTINCT cec.courseTitle SEPARATOR ', ')) as courseAssessed,
			COALESCE(NULLIF(rf.nofSections,''), CAST(COUNT(DISTINCT cec.sectionNo) AS CHAR)) as nofSections", FALSE);
		$this->db->from('faculty_recognition_flow as rf');
		$this->db->join('course_enrollment_classes as cec', 'cec.ceId = rf.ceId AND cec.facultyEmail = rf.facultyEmail AND cec.isDeleted = 0 AND cec.isActive = 0', 'LEFT');
		$this->db->where('rf.ceId', $ceId);
		$this->db->where('rf.universityId', $universityId);
		$this->db->where('rf.uniAdminId', $uniAdminId);
		$this->db->where('rf.isDeleted', 0);
		$this->db->group_by('rf.rfId');
		$query = $this->db->get();
		return $query->result_array();	
	}

	public function resendCertificate($rfIds,$universityId,$uniAdminId){
		$this->db->select('rfId, encryptId, facultyName, facultyEmail, emailSentCnt');
		$where = ' rfId in ('.$rfIds.')';
		$this->db->where($where);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('faculty_recognition_flow');
		$cnt = $query->num_rows();
		if($cnt>0){
			$curTime = time();
			$resData = $query->result_array();
		 
            $this->db->where('id', 25);
            $etQry = $this->db->get('email_templates');
            $etDetails = $etQry->row();
            $subject = $etDetails->subject;

			$proManagerName = $_POST['proManagerName'];
			$unitName = $_POST['unitName'];
			$universityName = $_POST['universityName'];

			foreach($resData as $res){
				$facultyName = $res['facultyName'];
				$facultyEmail = $res['facultyEmail'];
				$emailSentCnt = $res['emailSentCnt']+1;

				$this->db->where('rfId',$res['rfId']); 
				$this->db->update('faculty_recognition_flow', array('emailSentCnt'=>$emailSentCnt, 'lastUpdatedOn'=>$curTime));

				$certificateLink = base_url().'recognition_flow/certificate/'.$res['encryptId'];
				$pdfLink = base_url().'recognition_flow/pdf/'.$res['encryptId'];
				$message = str_replace('{facultyName}',$facultyName,$etDetails->message);
				$message = str_replace('{pdfLink}',$pdfLink,$message);
				$message = str_replace('{certificateLink}',$certificateLink,$message);
				$message = str_replace('{projectManagerName}',$proManagerName,$message);
				$message = str_replace('{unitName}',$unitName,$message);
				$message = str_replace('{universityName}',$universityName,$message);
				// $facultyEmail = 'tns.ankit@gmail.com';
				send_mail($facultyEmail,$message,$facultyName,'info',$subject); 

			}
		}
		$this->session->set_flashdata('success', 'Sent successfully.');
	}

	public function addIntoRecognitionFlow($ceId,$classIds,$universityId,$uniAdminId){
		if(isset($classIds) && $classIds!=''){
			$this->db->select('ceClassId, facultyNameSlug, facultyEmail');
			$this->db->where('ceId', $ceId);
			$where = ' ceClassId in ('.$classIds.')';
			$this->db->where($where);
			$this->db->where('isActive', 0);
			$this->db->where('isDeleted', 0);
			$query = $this->db->get('course_enrollment_classes');
			$cnt = $query->num_rows();
			if($cnt>0){
				$addDate = strtotime(date('Y-m-d'));
				$curTime = time();
				$resData = $query->result_array();	
				
				$this->db->where('id', 25);
				$etQry = $this->db->get('email_templates');
				$etDetails = $etQry->row();
				$subject = $etDetails->subject;

				$proManagerName = $_POST['proManagerName'];
				$unitName = $_POST['unitName'];
				$universityName = $_POST['universityName'];
				
			 	foreach($resData as $res){
					$facultyEmail = $res['facultyEmail'];
					$facultyName = ucwords(str_replace('-',' ',$res['facultyNameSlug']));

					// Fetch deptName, courseAssessed, nofSections from course_enrollment_classes
					$this->db->select("GROUP_CONCAT(DISTINCT deptName SEPARATOR ', ') as deptName, GROUP_CONCAT(DISTINCT courseTitle SEPARATOR ', ') as courseAssessed, COUNT(DISTINCT sectionNo) as nofSections", FALSE);
					$this->db->where('ceId', $ceId);
					$this->db->where('facultyEmail', $facultyEmail);
					$this->db->where('isActive', 0);
					$this->db->where('isDeleted', 0);
					$cecQry = $this->db->get('course_enrollment_classes');
					$cecRow = $cecQry->row_array();
					$deptName = isset($cecRow['deptName']) ? $cecRow['deptName'] : '';
					$courseAssessed = isset($cecRow['courseAssessed']) ? $cecRow['courseAssessed'] : '';
					$nofSections = isset($cecRow['nofSections']) ? $cecRow['nofSections'] : '';

					$this->db->where('facultyEmail', $facultyEmail);
					$this->db->where('ceId', $ceId);
					$qry = $this->db->get('faculty_recognition_flow');
					$cntChk = $qry->num_rows();
					if($cntChk==0){
						$this->db->insert('faculty_recognition_flow', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'ceId'=>$ceId, 'facultyEmail'=>$facultyEmail, 'facultyName'=>$facultyName, 'deptName'=>$deptName, 'courseAssessed'=>$courseAssessed, 'nofSections'=>$nofSections, 'lastUpdatedOn'=>$curTime, 'addDate'=>$addDate, "emailSentCnt"=>1));
						$rfId = $this->db->insert_id();
						$encryptId = generateRandomNumStringCh(4).'rf'.$rfId.generateRandomNumStringCh(4);
						$this->db->where('rfId',$rfId); 
						$this->db->update('faculty_recognition_flow', array("encryptId"=>$encryptId));

						$certificateLink = base_url().'recognition-flow/certificate/'.$encryptId;
						$pdfLink = base_url().'recognition-flow/pdf/'.$encryptId;
						$message = str_replace('{facultyName}',$facultyName,$etDetails->message);
						$message = str_replace('{pdfLink}',$pdfLink,$message);
						$message = str_replace('{certificateLink}',$certificateLink,$message);
						$message = str_replace('{projectManagerName}',$proManagerName,$message);
						$message = str_replace('{unitName}',$unitName,$message);
						$message = str_replace('{universityName}',$universityName,$message);
						// $facultyEmail = 'tns.ankit@gmail.com';
						send_mail($facultyEmail,$message,$facultyName,'info',$subject); 
					}
				}
			}
			$this->session->set_flashdata('success', 'Added successfully.');	
		}

	}

	public function oversightDataArr($universityId,$uniAdminId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('master_alignment_maps_oversights');
		return $query->result_array();
	}
	public function ceDetailsByTermArr($universityId,$uniAdminId,$termId,$year){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('termId', $termId);
		$this->db->where('year', $year);
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$query = $this->db->get('course_enrollment');
		return $query->row_array();
	}
	public function ceDetailsArr($ceId){
		$this->db->where('ceId', $ceId);
		$query = $this->db->get('course_enrollment');
		return $query->row_array();
	}
	public function classDetailsArr($ceClassId){
		$this->db->where('ceClassId', $ceClassId);
		$query = $this->db->get('course_enrollment_classes');
		return $query->row_array();
	}
	public function getCourseEnrollmentClassDataArr($ceId,$alignSLO,$fieldName,$oversigntId=0){		
		$this->db->select('cec.*, mlmc.courseISLO, mlmc.courseGISLO, mlmc.coursePSLO, mlmc.courseGPSLO, mlmc.oversigntId, mlmc.program');
		$this->db->from('course_enrollment_classes as cec');
		$this->db->where('cec.ceId', $ceId);
		$this->db->where('cec.isDeleted', 0);
		$this->db->where('cec.isActive', 0);
		if(isset($oversigntId) && $oversigntId!='' && $oversigntId>0){
			$this->db->where('mlmc.oversigntId', $oversigntId);
		}
		$extraWhere = array();
		if(isset($alignSLO) && $alignSLO!=''){
			$alignSLOArr = explode(',',$alignSLO);
			foreach($alignSLOArr as $slo){				 
				$extraWhere[] = 'find_in_set("'.$slo.'", mlmc.'.$fieldName.')';				 
			}
		}
		// if(isset($alignGISLO) && $alignGISLO!=''){
		// 	$alignGISLOArr = explode(',',$alignGISLO);
		// 	foreach($alignGISLOArr as $gslo){				 
		// 		$extraWhere[] = 'find_in_set("'.$gslo.'", mlmc.courseISLO)';				 
		// 	}
		// }
		// if(isset($alignPSLO) && $alignPSLO!=''){
		// 	$alignPSLOArr = explode(',',$alignPSLO);
		// 	foreach($alignPSLOArr as $pslo){				 
		// 		$extraWhere[] = 'find_in_set("'.$pslo.'", mlmc.courseISLO)';				 
		// 	}
		// }
		if(count($extraWhere)>0){
			// echo '<pre>';// print_r($extraWhere);
			$extraWhereStr = ' ('.implode(' || ',$extraWhere).')';
			$this->db->where($extraWhereStr);
		}		
        $this->db->order_by('cec.subject, cec.courseNBR, cec.classNBR', 'asc');
		$this->db->join('master_alignment_maps_courses as mlmc', 'mlmc.courseSlug = cec.scSlug', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();		 
	}
	public function courseFacultyDataArr($universityId,$uniAdminId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('lastName', 'asc');
		$query = $this->db->get('course_enrollment_faculty');
		return $query->result_array();
	}
	public function courseEnrollmentDataArr($universityId,$uniAdminId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('temporarySts', 0);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('ceId', 'desc');
		$query = $this->db->get('course_enrollment');
		return $query->result_array();
	}
	public function courseEnrollmentWithTempDataArr($universityId,$uniAdminId){
		$this->db->where('universityId', $universityId);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->where('isDeleted', 0);
		$this->db->order_by('ceId', 'desc');
		$query = $this->db->get('course_enrollment');
		return $query->result_array();
	}
	public function pmClassesDataArr($ceId){
		$this->db->where('ceId', $ceId);
		$this->db->where('isDeleted', 0);
		$this->db->where('isActive', 0);
		// $this->db->limit(100);
		$this->db->order_by('addedBy', 'desc');
		$this->db->order_by('subject, courseNBR, classNBR', 'asc');
		$query = $this->db->get('course_enrollment_classes');
		return $query->result_array();
	}
	public function classesDataArr($ceId){
		$this->db->where('ceId', $ceId);
		$this->db->where('isDeleted', 0);
		$this->db->where('isActive', 0);
		$this->db->order_by('subject, courseNBR, classNBR', 'asc');
		$query = $this->db->get('course_enrollment_classes');
		return $query->result_array();
	}
	public function manageClassEntry($universityId,$uniAdminId){
		if(isset($_POST['addByuserAccessId']) && $_POST['addByuserAccessId']!='' && $_POST['addByuserAccessId']>0){
			$addedBy = 1;
			$userAccessId = $_POST['addByuserAccessId'];
		}else{
			$addedBy = 0;
			$userAccessId = 0; 
		}
		$ceClassIdChk = trim($this->input->post('txtceClassId'));
		$ceId = trim($this->input->post('txtceId'));
		$subject = trim($this->input->post('subject'));
		$courseNBR = trim($this->input->post('courseNBR'));
		$scSlug = create_slug_ch($subject.'-'.$courseNBR);
		$classNBR = trim($this->input->post('classNBR'));
		$sectionNo = trim($this->input->post('sectionNo'));
		$courseTitle = trim($this->input->post('courseTitle'));
		$enrolled = trim($this->input->post('enrolled'));
		$comment = trim($this->input->post('comment'));
		// $ceFacultyId = trim($this->input->post('ceFacultyId'));
		$facultyName = trim($this->input->post('facultyName'));
		$email = trim($this->input->post('facultyEmail'));
		$deptName = $this->input->post('deptName');
		$courseModality = $this->input->post('courseModality');
		$courseLevel = $this->input->post('courseLevel');
		$courseType = $this->input->post('courseType');
		$facultyNameSlug = '';
		$firstName = '';
		$lastName = '';
		if(isset($facultyName) && $facultyName!=''){
			$facultyNameArr = explode(',',$facultyName);
			$facultyNameSlug = create_slug_ch($facultyName);
			$lastName = $facultyNameArr[0];
			if(isset($facultyNameArr[1]) && $facultyNameArr[1]!=''){
				$firstName = $facultyNameArr[1];
			}
		}
		// $uniAdminId = trim($this->input->post('mauniAdminId'));
		// $universityId = trim($this->input->post('mauniversityId'));
		if(isset($ceClassIdChk) && $ceClassIdChk!='' && $ceClassIdChk>0){
			$this->db->where('ceClassId != ', $ceClassIdChk);
		}
		$this->db->where('ceId', $ceId);
		// $this->db->where('ceFacultyId', $ceFacultyId);
		$this->db->where('subject', $subject);
		$this->db->where('courseNBR', $courseNBR);
		$this->db->where('classNBR', $classNBR);
		$this->db->where('isDeleted', 0);
		$qryCls = $this->db->get('course_enrollment_classes');
		$cntCls = $qryCls->num_rows();
		if($cntCls==0){
			if(isset($ceClassIdChk) && $ceClassIdChk!='' && $ceClassIdChk>0){
				$this->db->where('ceClassId',$ceClassIdChk); 
				$this->db->update('course_enrollment_classes', array('subject'=>$subject, 'courseNBR'=>$courseNBR, 'scSlug'=>$scSlug, 'classNBR'=>$classNBR, 'sectionNo'=>$sectionNo, 'courseTitle'=>$courseTitle, 'enrolled'=>$enrolled, 'firstName'=>$firstName, 'lastName'=>$lastName, 'facultyNameSlug'=>$facultyNameSlug, 'facultyEmail'=>$email, 'deptName'=>$deptName, 'courseModality'=>$courseModality, 'courseLevel'=>$courseLevel, 'courseType'=>$courseType, 'comment'=>$comment, 'isActive'=>0));
			}else{
				$this->db->insert('course_enrollment_classes', array('addedBy'=>$addedBy, 'userAccessId'=>$userAccessId, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'ceId'=>$ceId, 'subject'=>$subject, 'courseNBR'=>$courseNBR, 'scSlug'=>$scSlug, 'classNBR'=>$classNBR, 'sectionNo'=>$sectionNo, 'courseTitle'=>$courseTitle, 'enrolled'=>$enrolled, 'firstName'=>$firstName, 'lastName'=>$lastName, 'facultyNameSlug'=>$facultyNameSlug, 'facultyEmail'=>$email, 'deptName'=>$deptName, 'courseModality'=>$courseModality, 'courseLevel'=>$courseLevel, 'courseType'=>$courseType, 'comment'=>$comment, 'isActive'=>0));
				// $ceClassId = $this->db->insert_id();
			}
			return 'success||';
		}else{
			return 'error||Oops, class already exist.';	
		}
	
	}
	public function uploadCourseDoc($path,$temporarySts=0){
		$uniAdminId = trim($this->input->post('mauniAdminId'));
		$universityId = trim($this->input->post('mauniversityId'));
		$createdBy = trim($this->input->post('macreatedBy'));
		$termId = trim($this->input->post('maTermId'));
		$year = trim($this->input->post('maYear'));
		
		$ctime = time();
		if($temporarySts==0){
			$ceIdChk = trim($this->input->post('txtceId'));
			if(isset($ceIdChk) && $ceIdChk!='' && $ceIdChk>0){
				$this->db->where('ceId != ', $ceIdChk);
			}
			$this->db->where('universityId', $universityId);
			$this->db->where('uniAdminId', $uniAdminId);
			$this->db->where('termId', $termId);
			$this->db->where('year', $year);
			$this->db->where('isDeleted', 0);
			$query = $this->db->get('course_enrollment');
			$cnt = $query->num_rows();
			if($cnt==0){
				if(isset($ceIdChk) && $ceIdChk!='' && $ceIdChk>0){
					$ceId = $ceIdChk;
				}else{
					$this->db->insert('course_enrollment', array('universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'createdBy'=>$createdBy, 'temporarySts'=>$temporarySts, 'termId'=>$termId, 'year'=>$year, 'isActive'=>0));
					$ceId = $this->db->insert_id();
				}
			}else{
				return 'error||'.$this->config->item('terms_assessment_array_config')[$termId]['name'].'-'.$year.' already exist.';
			}
		}else{
			$ceId = $this->input->post('maceId');	
		}
		if(isset($_FILES['curFile']['name']) && $_FILES['curFile']['name']!=''){            
			$curTime = time().'-ce-'.$uniAdminId;
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
				$this->db->where('ceId', $ceId);
				if($temporarySts==1){
					$this->db->update('course_enrollment', array("recognitionFile"=>$fileName, 'temporarySts'=>$temporarySts, 'lastUpdatedOn'=>$ctime)); 
				}else{
					$this->db->update('course_enrollment', array("ceFileName"=>$fileName, 'lastUpdatedOn'=>$ctime)); 
				}				
				return 'success||'.$fileName.'||'.$ceId;
			}            
		}else{
			return 'error||Please upload your file.';
		}
	}
	public function deleteClass($classIds){
		$where = ' ceClassId in ('.$classIds.')';
		$this->db->where($where);
		$this->db->delete('course_enrollment_classes');
		$this->session->set_flashdata('success', 'Course has been deleted successfully.');	
	}
	public function moveStepTwo($userId,$universityId,$uniAdminId,$userAccessId){
		$termId = trim($this->input->post('termId'));
		$year = trim($this->input->post('year'));
		$oversigntId = trim($this->input->post('oversigntId'));
		$todayDate = strtotime(date('Y-m-d'));	
		$curTime = time();
		$ceDetails = $this->ceDetailsByTermArr($universityId,$uniAdminId,$termId,$year);
		if(isset($ceDetails['ceId']) && $ceDetails['ceId']!=''){
			$ceId = $ceDetails['ceId'];
			$this->db->where('initiateSts', 0);
			$this->db->where('isDeleted', 0);
			$this->db->where('userId', $userId);
			$this->db->where('universityId', $universityId);
			$this->db->where('uniAdminId', $uniAdminId);
			$this->db->where('ceId', $ceId);
			$this->db->where('termId', $termId);
			$this->db->where('year', $year);
			$this->db->where('oversigntId', $oversigntId);
			$query = $this->db->get('sampling_plans');
			$cnt = $query->num_rows();
			if($cnt==0){
				$this->db->insert('sampling_plans', array('oversigntId'=>$oversigntId, 'userId'=>$userId, 'userAccessId'=>$userAccessId, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'ceId'=>$ceId, 'termId'=>$termId, 'year'=>$year, 'createDate'=>$todayDate, 'createTime'=>$curTime));
				$spId = $this->db->insert_id();
				$speId = generateRandomNumStringCh(4).'SP'.$spId.generateRandomNumStringCh(4);
				$this->db->where('spId',$spId); 
				$this->db->update('sampling_plans', array("speId"=>$speId));
				// $this->db->insert('temporary_sampling_plans', array('userId'=>$userId, 'termId'=>$termId, 'year'=>$year));
				// $tspId = $this->db->insert_id();
				// $tspEncryptId = generateRandomNumStringCh(4).'tsp'.$tspId.generateRandomNumStringCh(4);
				// $this->db->where('tspId',$tspId); 
				// $this->db->update('temporary_sampling_plans', array("tspEncryptId"=>$tspEncryptId));
			}else{
				$row = $query->row_array();
				$speId = $row['speId'];
			}
			return 'success||'.base_url().'sampling_plan/outcomes/'.$speId;
		}else{
			return 'error||Oops, course is not present for this term & year.';
		}
	}
	public function sampling_plans_details($speId){
		$this->db->where('speId', $speId);
		$query = $this->db->get('sampling_plans');
		return $query->row_array();
	}
	public function spUserAccessDetails($userAccessId){
		$this->db->where('userAccessId', $userAccessId);
		$query = $this->db->get('users_access');
		return $query->row_array();
	}
	public function moveStepThree($userId){
		$spId = trim($this->input->post('spId'));
		$speId = trim($this->input->post('speId'));
		$curTime = time();
		$alignISLO = '';
		if(isset($_POST['chkISLO']) && $_POST['chkISLO']!=''){
			if(count($_POST['chkISLO'])>0){
				$alignISLO = implode(',',$_POST['chkISLO']);
			}
		}
		$alignGISLO = '';
		if(isset($_POST['chkGISLO']) && $_POST['chkGISLO']!=''){
			if(count($_POST['chkGISLO'])>0){
				$alignGISLO = implode(',',$_POST['chkGISLO']);
			}
		}
		$alignPSLO = '';
		if(isset($_POST['chkPSLO']) && $_POST['chkPSLO']!=''){
			if(count($_POST['chkPSLO'])>0){
				$alignPSLO = implode(',',$_POST['chkPSLO']);
			}
		}
		$alignGPSLO = '';
		if(isset($_POST['chkGPSLO']) && $_POST['chkGPSLO']!=''){
			if(count($_POST['chkGPSLO'])>0){
				$alignGPSLO = implode(',',$_POST['chkGPSLO']);
			}
		}
		$this->db->where('spId',$spId); 
		$this->db->update('sampling_plans', array('alignISLO'=>$alignISLO, 'alignGISLO'=>$alignGISLO, 'alignPSLO'=>$alignPSLO, 'alignGPSLO'=>$alignGPSLO));
		return 'success||'.base_url().'sampling_plan/participants/'.$speId;
	}
	public function getCourseNoteDetailsArr($userId,$spId,$sloFor,$ceId,$ceClassId){
		$this->db->where('spId', $spId);
		$this->db->where('userId', $userId);
		$this->db->where('sloFor', $sloFor);
		$this->db->where('ceId', $ceId);
		$this->db->where('ceClassId', $ceClassId);
		$query = $this->db->get('sampling_plans_courses');
		return $query->row_array();
	}
	public function getCourseTakenStsDataArr($userId,$spId){
		$this->db->where('spId', $spId);
		$this->db->where('userId', $userId);
		$query = $this->db->get('sampling_plans_courses');
		return $query->result_array();
	}
	public function samplingPlanCoursesDataArr($userId,$spId){
		$this->db->select('spc.*, csc.courseTitle, csc.subject, csc.courseNBR, csc.classNBR, csc.firstName, csc.lastName, csc.enrolled, csc.courseLevel');
		$this->db->from('sampling_plans_courses as spc');
		$this->db->where('spc.spId', $spId);
		$this->db->where('spc.userId', $userId);		 	
        $this->db->order_by('csc.subject, csc.courseNBR, csc.classNBR', 'asc');
		$this->db->join('course_enrollment_classes as csc', 'csc.ceClassId = spc.ceClassId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function saveTempClassess($userId){
		$spId = $_GET['spId'];
		$sloFor = $_GET['sloFor'];
		$courseSts = $_GET['status'];
		$ceId = $_GET['ceId'];
		$ceClassId = $_GET['ceClassId'];
		$curTime = time();		
		$this->db->where('spId', $spId);
		$this->db->where('userId', $userId);
		$this->db->where('sloFor', $sloFor);
		$this->db->where('ceId', $ceId);
		$this->db->where('ceClassId', $ceClassId);
		$query = $this->db->get('sampling_plans_courses');
		$cnt = $query->num_rows();
		if($cnt==0){
			$this->db->insert('sampling_plans_courses', array('userId'=>$userId, 'spId'=>$spId, 'sloFor'=>$sloFor, 'ceId'=>$ceId, 'ceClassId'=>$ceClassId, 'courseSts'=>$courseSts, 'addedOn'=>$curTime, 'lastUpdatedOn'=>$curTime));
		}else{
			$row = $query->row_array();
			$this->db->where('spCourseId',$row['spCourseId']); 
			$this->db->update('sampling_plans_courses', array('courseSts'=>$courseSts, 'lastUpdatedOn'=>$curTime));
		}

		// $this->db->where('spId', $spId);
		// $this->db->where('courseSts', 1);
		// $this->db->where('userId', $userId);
		// $this->db->where('ceId', $ceId);
		// $qry = $this->db->get('sampling_plans_courses');
		// $selectedCnt = $qry->num_rows();

		$this->db->select("SUM(csc.enrolled) AS courses_selected_enrolled_sp, COUNT(*) AS courses_selected_sp");
		$this->db->from('sampling_plans_courses as spc');
		$this->db->where('spc.spId', $spId);
		$this->db->where('spc.courseSts', 1);
		$this->db->where('spc.userId', $userId);
		$this->db->where('spc.ceId', $ceId);
		$this->db->join('course_enrollment_classes as csc', 'csc.ceClassId = spc.ceClassId', 'LEFT');
		$qry = $this->db->get();	
		$qryCnt = $qry->num_rows();
		if($qryCnt>0){
			$srow = $qry->row_array();
			$courseSelected = $srow['courses_selected_sp'];
			$courseSelectedEnroll = $srow['courses_selected_enrolled_sp'];
		}else{
			$courseSelected = 0;
			$courseSelectedEnroll = 0;
		}

		return 'success||'.$courseSelected.'||'.$courseSelectedEnroll;
		// $tspId = trim($this->input->post('tspId'));
	}
	public function getSelectedCourseForIso($spId,$userId,$ceId){
		// $this->db->where('spId', $spId);
		// $this->db->where('courseSts', 1);
		// $this->db->where('userId', $userId);
		// $this->db->where('ceId', $ceId);
		// $qry = $this->db->get('sampling_plans_courses');

		$this->db->select("SUM(csc.enrolled) AS courses_selected_enrolled_sp, COUNT(*) AS courses_selected_sp");
		$this->db->from('sampling_plans_courses as spc');
		$this->db->where('spc.spId', $spId);
		$this->db->where('spc.courseSts', 1);
		$this->db->where('spc.userId', $userId);
		$this->db->where('spc.ceId', $ceId);
		$this->db->join('course_enrollment_classes as csc', 'csc.ceClassId = spc.ceClassId', 'LEFT');
		$qry = $this->db->get();		
		return $qry->row_array();
	}

	public function manageClassNotes($userId){
		$spId = $_POST['txtNotespId'];
		$sloFor = $_POST['txtNotesloFor'];
		$ceId = $_POST['txtNoteceId'];
		$ceClassId = $_POST['txtNoteceClassId'];
		
		$courseNotes = $_POST['txtNotes'];
		$curTime = time();		
		$this->db->where('spId', $spId);
		$this->db->where('userId', $userId);
		$this->db->where('sloFor', $sloFor);
		$this->db->where('ceId', $ceId);
		$this->db->where('ceClassId', $ceClassId);
		$query = $this->db->get('sampling_plans_courses');
		$cnt = $query->num_rows();
		if($cnt==0){
			$this->db->insert('sampling_plans_courses', array('userId'=>$userId, 'spId'=>$spId, 'sloFor'=>$sloFor, 'ceId'=>$ceId, 'ceClassId'=>$ceClassId, 'courseNotes'=>$courseNotes, 'addedOn'=>$curTime, 'lastUpdatedOn'=>$curTime));
		}else{
			$row = $query->row_array();
			$this->db->where('spCourseId',$row['spCourseId']); 
			$this->db->update('sampling_plans_courses', array('courseNotes'=>$courseNotes, 'lastUpdatedOn'=>$curTime));
		}
		return 'success||';
		// $tspId = trim($this->input->post('tspId'));
	}
	public function userSamplingPlanDataArr($userId){
		$this->db->where('isDeleted', 0);
		$this->db->where('initiateSts', 1);
		$this->db->where('userId', $userId);
		$this->db->order_by('spId', 'desc');
		$qry = $this->db->get('sampling_plans');
		return $qry->result_array();
	}
	public function groupSubjectArr($ceId){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('subject');
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->where('ceId', $ceId);
		$this->db->group_by('subject');
		$qry = $this->db->get('course_enrollment_classes');
		return $qry->result_array();
	}
	public function groupcourseModalityArr($ceId){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('courseModality');
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->where('ceId', $ceId);
		$this->db->group_by('courseModality');
		$qry = $this->db->get('course_enrollment_classes');
		return $qry->result_array();
	}
	public function groupcourseTypeArr($ceId){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('courseType');
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->where('ceId', $ceId);
		$this->db->group_by('courseType');
		$qry = $this->db->get('course_enrollment_classes');
		return $qry->result_array();
	}
	public function groupcourseLevelArr($ceId){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('courseLevel');
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->where('ceId', $ceId);
		$this->db->group_by('courseLevel');
		$qry = $this->db->get('course_enrollment_classes');
		return $qry->result_array();
	}
	public function groupdeptNameArr($ceId){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('deptName');
		$this->db->where('isActive', 0);
		$this->db->where('isDeleted', 0);
		$this->db->where('ceId', $ceId);
		$this->db->group_by('deptName');
		$qry = $this->db->get('course_enrollment_classes');
		return $qry->result_array();
	}
	public function spTermsByYr($uniAdminId,$year){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('termId');
		$this->db->where('isDeleted', 0);
		$this->db->where('initiateSts', 1);
		$this->db->where('year', $year);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->group_by('termId');
		$qry = $this->db->get('sampling_plans');
		return $qry->result_array();
	}
	public function pmSamplingPlansYearsDataArr($uniAdminId){
		$this->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('year');
		$this->db->where('isDeleted', 0);
		$this->db->where('initiateSts', 1);
		$this->db->where('uniAdminId', $uniAdminId);
		$this->db->group_by('year');
		$qry = $this->db->get('sampling_plans');
		return $qry->result_array();
	}
	
	public function pmSamplingPlansDataArr($uniAdminId){
		// $this->db->where('isDeleted', 0);
		// $this->db->where('initiateSts', 1);
		// $this->db->where('uniAdminId', $uniAdminId);
		// $qry = $this->db->get('sampling_plans');
		// return $qry->result_array();


		$this->db->select('sp.*, ua.auName');
		$this->db->from('sampling_plans as sp');
		$this->db->where('sp.isDeleted', 0);
		$this->db->where('sp.initiateSts', 1);
		if(isset($_GET['termId']) && $_GET['termId']!='' && $_GET['termId']>0){
			$this->db->where('sp.termId', $_GET['termId']);
		}
		if(isset($_GET['yr']) && $_GET['yr']!='' && $_GET['yr']>0){
			$this->db->where('sp.year', $_GET['yr']);
		}
		$this->db->where('sp.uniAdminId', $uniAdminId);
		$this->db->join('users_access as ua', 'ua.userAccessId = sp.userAccessId', 'LEFT');
		$query = $this->db->get();
		return $query->result_array();

	}
	public function saveSamplingPlan($userId,$universityId,$uniAdminId,$speId,$userAccessId){
		$ceClassIdArr = array();
		$spId = $_POST['spId'];	
		if(isset($_POST['selParts']) && $_POST['selParts']!=''){
			$this->db->where('spId',$spId); 
			$this->db->update('sampling_plans_courses', array('courseSts'=>0));
			if(count($_POST['selParts'])>0){				 
				foreach($_POST['selParts'] as $sparts){
					if(isset($sparts) && $sparts!=''){
						$spartsArr = explode('||',$sparts);
						$sloFor = $spartsArr[0];
						$ceClassId = $spartsArr[1];
						$ceClassIdArr[] = $ceClassId;
						$this->db->where('spId',$spId); 
						$this->db->where('sloFor',$sloFor); 
						$this->db->where('ceClassId',$ceClassId); 
						$this->db->update('sampling_plans_courses', array('courseSts'=>1));
					}
				}
			}
		}		

		$this->db->select('aiSummary');
		$this->db->where('spId',$spId); 
		$qrySP = $this->db->get('sampling_plans');
		$spDetail = $qrySP->row_array();
		if(isset($spDetail['aiSummary']) && $spDetail['aiSummary']!=''){
			$this->db->where('spId',$spId); 
			$this->db->update('sampling_plans', array('initiateSts'=>1));
		}else{
			if(count($ceClassIdArr)>0){
				$ceClassIds = implode(',',$ceClassIdArr);
				$this->genAIreportForSP($spId, $ceClassIds,'1');
			}
		}

		return 'success||';
	}
	public function ajaxgenspAIReport(){
		$spId = $_POST['spId'];
		$ceClassIdArr = array();
		// $this->db->select('spCourseId, ceClassId');
		// $this->db->where('spId',$spId);
		// $this->db->where('courseSts',1); 
		// $qrySP = $this->db->get('sampling_plans_courses');
		// $spDetail = $qrySP->result_array();
		// foreach($spDetail as $spc){
		// 	$ceClassIdArr[] = $spc['ceClassId'];
		// }
		$ceClassIds = implode(',',$ceClassIdArr);
		return $this->genAIreportForSP($spId, $ceClassIds,'0');		 
	}
	public function genAIreportForSP($spId, $ceClassIds,$callSts){
		$aiCourseDetailsArr = array();
		
		
		$this->db->select('spc.*, csc.courseTitle, csc.subject, csc.courseNBR, csc.classNBR, csc.firstName, csc.lastName, csc.enrolled, csc.courseLevel');
		$this->db->from('sampling_plans_courses as spc');
		$this->db->where('spc.spId', $spId);
		// $this->db->where('spc.userId', $userId);		 	
        $this->db->order_by('csc.subject, csc.courseNBR, csc.classNBR', 'asc');
		$this->db->join('course_enrollment_classes as csc', 'csc.ceClassId = spc.ceClassId', 'LEFT');
		$query = $this->db->get();
		$res = $query->result_array();
		
		// $this->db->select('subject, courseNBR, courseTitle, courseLevel, enrolled');
		// $where = ' ceClassId in ('.$ceClassIds.')';
		// $this->db->where($where);
		// $this->db->order_by('subject, courseNBR, classNBR', 'asc');
		// $query = $this->db->get('course_enrollment_classes');
		// $res = $query->result_array();
		$enrArr = array();
		foreach($res as $cec){//' - '.$cec['courseTitle'].
			// $aiCourseDetailsArr[] = $cec['subject'].' '.$cec['courseNBR'].' its level is '.$cec['courseLevel'].' its enrolled is '.$cec['enrolled'];			
			$chkCL = str_replace('division','div',$cec['courseLevel']);
			$chkCL = str_replace('graduate','grad',$chkCL);
			$aiCourseDetailsArr[] = $cec['subject'].' '.$cec['courseNBR'].' '.strtoupper($cec['sloFor']).' is '.$chkCL;//.' and stu. enrolled in '.$cec['enrolled']
			$enrArr[] = $cec['enrolled'];
		}
		$totalEnrolled = array_sum($enrArr);
		$courseDetails = implode(', ',$aiCourseDetailsArr);		

		$this->db->where('promptId', 3);
		$qryPrompt = $this->db->get('prompting');
		$secContent = $qryPrompt->row_array();

		$inputText = str_replace('{courseDetails}',$courseDetails,$secContent['msgUserRole']);			
		$inputText = str_replace('{totalEnrolled}',$totalEnrolled,$inputText);			
		$sysInput = $secContent['msgSystemRole'];
		$maxTokens = $secContent['maxTokenCnt'];

		if(isset($inputText) && $inputText!='' && isset($sysInput) && $sysInput!='' && isset($maxTokens) && $maxTokens!=''){ 
			$resArr = customCurlAIh($sysInput,$inputText,$maxTokens);
			// echo '<pre>'; print_r($resArr);die;
			if($resArr[0]=='success'){
				if(isset($resArr[1]['choices'][0]['message']['content']) && $resArr[1]['choices'][0]['message']['content']!=''){
					$aiSummary = convertToHtmlAvoidAh($resArr[1]['choices'][0]['message']['content']);
					if($callSts==1){
						$this->db->where('spId',$spId); 
						$this->db->update('sampling_plans', array('aiSummary'=>$aiSummary,'initiateSts'=>1));                    
					}else{
						return $aiSummary;
					}
				}
			}
		}
	}

	public function savespAIreport(){
		$spId = $_POST['ai_spId'];
		$speId = $_POST['ai_speId'];
		$aiSummary = $_POST['txt_aisummary'];
		$this->db->where('spId',$spId); 
		$this->db->update('sampling_plans', array('aiSummary'=>$aiSummary));
		$this->session->set_flashdata('success', 'Report Updated.');	
		return 'success||'.base_url().'sampling_plan/report/'.$speId;
	}

	public function saveSamplingPlanOld($userId,$universityId,$uniAdminId,$tspEncryptId){
		$tspDetails = $this->temporary_sampling_plans_details($tspEncryptId);
		$tspId = $tspDetails['tspId'];
		$termId = $tspDetails['termId'];
		$year = $tspDetails['year'];
		$alignISLO = $tspDetails['alignISLO'];
		$alignGISLO = $tspDetails['alignGISLO'];
		$alignPSLO = $tspDetails['alignPSLO'];
		$todayDate = strtotime(date('Y-m-d'));	
		$curTime = time();	
		$ceDetails = $this->ceDetailsByTermArr($universityId,$uniAdminId,$termId,$year);
		$ceId = $ceDetails['ceId'];
		$this->db->where('tspId', $tspId);
		$qryTsp = $this->db->get('sampling_plans');
		$cntTsp = $qryTsp->num_rows();
		if($cntTsp==0){
			$this->db->insert('sampling_plans', array('tspId'=>$tspId, 'userId'=>$userId, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'ceId'=>$ceId, 'termId'=>$termId, 'year'=>$year, 'alignISLO'=>$alignISLO, 'alignGISLO'=>$alignGISLO, 'alignPSLO'=>$alignPSLO, 'createDate'=>$todayDate, 'createTime'=>$curTime));
			$spId = $this->db->insert_id();
			$speId = generateRandomNumStringCh(4).'SP'.$spId.generateRandomNumStringCh(4);
			$this->db->where('spId',$spId); 
			$this->db->update('sampling_plans', array("speId"=>$speId));
		}else{
			$this->db->where('tspId',$tspId); 
			$this->db->update('sampling_plans', array('alignISLO'=>$alignISLO, 'alignGISLO'=>$alignGISLO, 'alignPSLO'=>$alignPSLO));
		}
		$this->db->where('tspId', $tspId);
		$this->db->where('userId', $userId);
		$qryTspc = $this->db->get('temporary_sampling_plans_courses');
		$cnt = $qryTspc->num_rows();
		if($cnt>0){
			$resArr = $qryTspc->result_array();
			foreach($resArr as $res){
				if($res['courseSts']==1 || (isset($res['courseNotes']) && $res['courseNotes']!='')){
					$this->db->insert('sampling_plans_courses', array('userId'=>$userId, 'spId'=>$spId, 'sloFor'=>$res['sloFor'], 'ceId'=>$res['ceId'], 'ceClassId'=>$res['ceClassId'], 'courseSts'=>$res['courseSts'], 'courseNotes'=>$res['courseNotes'], 'addedOn'=>$curTime, 'lastUpdatedOn'=>$curTime));
				}
			}
		}
		// $this->db->delete('temporary_sampling_plans', array("tspId"=>$tspId)); 
		// $this->db->delete('temporary_sampling_plans_courses', array("tspId"=>$tspId)); 
		return 'success||';
	}
	public function deleteSamplingPlan($spIds){
		$where = ' spId in ('.$spIds.')';
		$this->db->where($where);
		$this->db->update('sampling_plans', array("isDeleted"=>1));
		// $this->db->delete('sampling_plans');
		$this->session->set_flashdata('success', 'Deleted successfully.');	
	}
}