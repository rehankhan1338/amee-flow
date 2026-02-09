<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Other_documents_mdl extends CI_Model {
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
    public function docDetailsArr($docId){
		$this->db->where('docId', $docId);
		$query = $this->db->get('other_documents');
		return $query->row_array();
	}

    public function getOtherDocumentByTaskId($taskId){
        $whereChk = 'find_in_set("'.$taskId.'", taskIds)';
        $this->db->where($whereChk);
        $query = $this->db->get('other_documents');
		return $query->result_array();
    }
    public function usersDocumentsDataArr($uniAdminId,$projectIds){
		$this->db->where('uniAdminId', $uniAdminId);
        if(isset($projectIds) && $projectIds!=''){
            $projectIdsArr = explode(',',$projectIds);
            $whereChkArr = array();
            foreach($projectIdsArr as $p){
                $whereChkArr[] = 'find_in_set("'.$p.'", projectIds)';
            }
            $set = '('.implode(' || ',$whereChkArr).')';	
            $this->db->where($set);
        }
		$query = $this->db->get('other_documents');
		return $query->result_array();
	}
	public function documentsDataArr($uniAdminId){
		$this->db->where('uniAdminId', $uniAdminId);
		$query = $this->db->get('other_documents');
		return $query->result_array();
	}
    public function manageDocEntry(){
        $moveSts = 1;
        $docIdChk = trim($this->input->post('mdocId'));
        $uniAdminId = trim($this->input->post('mauniAdminId'));
        $createdBy = trim($this->input->post('macreatedBy'));
		$universityId = trim($this->input->post('mauniversityId'));
		$docTitle = trim($this->input->post('docTitle'));
        $docType = trim($this->input->post('docType'));
        $docLnk = '';
        $docFileName = '';
        $docFileExt = '';
        $todayDate = strtotime(date('Y-m-d'));	
        $curTime = time();
        if($docType==1){
            $docLnk = trim($this->input->post('docLnk'));
        }else if($docType==2){
             if(isset($_FILES['docUp']['name']) && $_FILES['docUp']['name']!=''){
                $path = './assets/upload/documents/other/';
                $dcurTime = $curTime.'od'.$uniAdminId;
                $fileDocument = explode(".", $_FILES['docUp']['name']);
                $fileExt = strtolower(end($fileDocument));
                $fileName = $dcurTime.".".$fileExt;
                $config['file_name'] = $fileName;
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'pdf|doc|docx|xls|csv|ppt|xlsx|pptx';
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('docUp');
                $errors = $this->upload->display_errors('<span>', '</span>');
                if(isset($errors) && $errors!=''){
                    $moveSts = 0;
                    return 'error||'.$errors;
                }else{
                    if(isset($_POST['oldDocName']) && $_POST['oldDocName']!=''){
                        unlink($path.$_POST['oldDocName']); 	
                    }				
                    $docFileName = $fileName;
                    $docFileExt = $fileExt;
                    $moveSts = 1;
                }
             }else{
                if($docIdChk==0){
                    $moveSts = 0;
                    return 'error||Oops, please upload your document.';
                }
             }
        }       
        if($moveSts==1){

            $taskIds = '';
            $projectIds = '';
            if(isset($_POST['odTaskIds']) && $_POST['odTaskIds']!=''){
                if(count($_POST['odTaskIds'])>0){
                    $taskIdsArr = array();
                    $projectIdsArr = array();
                    foreach($_POST['odTaskIds'] as $dt){
                        $dtArr = explode('||',$dt);
                        if(!in_array($dtArr[0],$projectIdsArr)){
                            $projectIdsArr[] = $dtArr[0];
                        }
                        if(!in_array($dtArr[1],$taskIdsArr)){
                            $taskIdsArr[] = $dtArr[1];
                        }
                    }
                    $taskIds = implode(',',$taskIdsArr);
                    $projectIds = implode(',',$projectIdsArr);
                }
            }

            if(isset($docIdChk) && $docIdChk!='' && $docIdChk>0){
                $this->db->where('docId',$docIdChk); 
                if(isset($_FILES['docUp']['name']) && $_FILES['docUp']['name']!=''){
                    $this->db->update('other_documents', array('projectIds'=>$projectIds, 'taskIds'=>$taskIds, 'docTitle'=>$docTitle, 'docType'=>$docType, 'docLnk'=>$docLnk, 'docFileName'=>$docFileName, 'docFileExt'=>$docFileExt));
                }else{
                    $this->db->update('other_documents', array('projectIds'=>$projectIds, 'taskIds'=>$taskIds, 'docTitle'=>$docTitle, 'docType'=>$docType, 'docLnk'=>$docLnk));
                }
            }else{
                $this->db->insert('other_documents', array('projectIds'=>$projectIds, 'taskIds'=>$taskIds, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'createdBy'=>$createdBy, 'docTitle'=>$docTitle, 'docType'=>$docType, 'docLnk'=>$docLnk, 'docFileName'=>$docFileName, 'docFileExt'=>$docFileExt, 'onDate'=>$todayDate, 'onTime'=>$curTime));
                $docId = $this->db->insert_id();
                $endocId = generateRandomNumStringCh(4).'od'.$docId.generateRandomNumStringCh(4);
                $this->db->where('docId',$docId); 
                $this->db->update('other_documents', array("endocId"=>$endocId));
            }
            $this->session->set_flashdata('success', 'Document uploaded successfully.');	
            return 'success||'.base_url().$this->config->item('system_directory_name').'other_documents';
        }else{
            return 'error||Oops, something went wrong.';
        }
    }
    public function deleteDoc($docIds){
        $where = ' docId in ('.$docIds.')';
		$this->db->where($where);
		$qryTspc = $this->db->get('other_documents');
		$cnt = $qryTspc->num_rows();
		if($cnt>0){
            $path = './assets/upload/documents/other/';
			$resArr = $qryTspc->result_array();
			foreach($resArr as $res){                     
                if($res['docType']!=1){
                    if(isset($res['docFileName']) && $res['docFileName']!=''){
                        unlink($path.$res['docFileName']); 	
                    }
                }
				$this->db->delete('other_documents', array("docId"=>$res['docId']));
			}
            $this->session->set_flashdata('success', 'Document has been deleted successfully.');	
		}        
    }
}