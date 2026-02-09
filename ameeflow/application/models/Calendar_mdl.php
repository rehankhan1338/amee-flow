<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_mdl extends CI_Model {

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

    public function uniEventDataArr($uniAdminId){
		$this->db->select('eId as id, eTitle as title, calsTime as start, backgroundColor, backgroundColor as borderColor, textColor, display, stime, etime, etimeZoneId, eneId');
		// $this->db->select('eId as id, eTitle as title, calsTime as start');
        $this->db->where('uniAdminId', $uniAdminId);
        $this->db->where('isDeleted', 0);
		$query = $this->db->get('events');
		return $query->result_array();
    }

	public function myEventDataArr($createdBy,$createdById){
		$this->db->select('eId as id, eTitle as title, calsTime as start, backgroundColor, backgroundColor as borderColor, textColor, display, stime, etime, etimeZoneId, eneId');
		// $this->db->select('eId as id, eTitle as title, calsTime as start');
        $this->db->where('createdBy', $createdBy);
		$this->db->where('createdById', $createdById);
        $this->db->where('isDeleted', 0);
		$query = $this->db->get('events');
		return $query->result_array();
    }

	public function eventDetailsArrByeneId($eneId){
		$this->db->where('eneId', $eneId);
		$query = $this->db->get('events');
		return $query->result_array();
    }

    public function eventDetailsArr($eId){
		$this->db->where('eId', $eId);
		$query = $this->db->get('events');
		return $query->row_array();
    }

	public function saveEvent(){ 
		$createdBy = $this->input->post('calcreatedBy'); // 0=User calling, 1=Admin Calling 
		$universityId = $this->input->post('caluniversityId');
		$uniAdminId = $this->input->post('caluniAdminId');
		$createdById = $this->input->post('calcreatedById');

		$eIdChk = trim($this->input->post('caleId'));
		$eTitle = trim($this->input->post('eTitle'));
		$etSlug = create_slug_ch($eTitle);
		$eDatePost = $this->input->post('txtDate');

		$etimeZoneId = $this->input->post('etimeZoneId');

		$eDateArr = explode('/',$eDatePost);
		$eDate = strtotime($eDateArr[2].'-'.$eDateArr[0].'-'.$eDateArr[1]);


		$stime = strtotime(date('Y-m-d',$eDate).', '.$this->input->post('stime'));		
		$calsTime = date('Y-m-d',$stime).'T'.date('H:i:s',$stime);
		$etime = 0;
		if(isset($_POST['etime']) && $_POST['etime']!=''){
			$etime = strtotime(date('Y-m-d',$eDate).', '.$this->input->post('etime'));
		}
		$eDesc = $this->input->post('eDesc');
		$eURL = $this->input->post('eURL');
		$onDate = strtotime(date('Y-m-d'));
		$onTime = time();
		
		
		if(isset($eIdChk) && $eIdChk!='' && $eIdChk>0){
			$this->db->where('eId',$eIdChk); 
			$this->db->update('events', array('eTitle'=>$eTitle, 'etSlug'=>$etSlug, 'etimeZoneId'=>$etimeZoneId, 'calsTime'=>$calsTime,'stime'=>$stime, 'etime'=>$etime, 'eDesc'=>$eDesc, 'eURL'=>$eURL));
			$this->session->set_flashdata('success', 'Updated successfully!');
		}else{
			$bgColor = generateLightColorHex();
        	$fontColor = getReadableFontColor($bgColor);			 
			
			$this->db->insert('events', array('createdBy'=>$createdBy, 'createdById'=>$createdById, 'universityId'=>$universityId, 'uniAdminId'=>$uniAdminId, 'eTitle'=>$eTitle, 'etSlug'=>$etSlug, 'etimeZoneId'=>$etimeZoneId, 'eDate'=>$eDate, 'calsTime'=>$calsTime,'stime'=>$stime, 'etime'=>$etime, 'eDesc'=>$eDesc, 'eURL'=>$eURL, 'onDate'=>$onDate, 'onTime'=>$onTime, 'backgroundColor'=>$bgColor, 'textColor'=>$fontColor));
			$eId = $this->db->insert_id();
			$eneId = generateRandomNumStringCh(4).'ec'.$eId.generateRandomNumStringCh(4);
			$this->db->where('eId',$eId); 
			$this->db->update('events', array("eneId"=>$eneId));
			$this->session->set_flashdata('success', 'Added successfully!');
		}
		
		if($createdBy==0){
			return 'success||'.base_url().'calendar';
		}else{
			return 'success||'.base_url().$this->config->item('system_directory_name').'calendar';
		}
	}

	public function deleteEvent($eId){
		// $this->db->delete('events', array("eId"=>$eId));
		$this->db->where('eId',$eId); 
		$this->db->update('events', array("isDeleted"=>'1'));
		
		$this->session->set_flashdata('success', 'Deleted successfully!');
		if($_GET['createdBy']==0){
			return 'success||'.base_url().'calendar';
		}else{
			return 'success||'.base_url().$this->config->item('system_directory_name').'calendar';
		}
    }

}