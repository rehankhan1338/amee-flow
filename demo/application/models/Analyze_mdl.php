<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analyze_mdl extends CI_Model {
	
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
	
	public function ajax_submit_report($reportId){
		$time = time();
		$this->db->where('reportId',$reportId); 
		$this->db->update('department_analysis', array("submittedSts"=>'1', "firstTimeSubmittedOn"=>$time, "lastTimeSubmittedOn"=>$time));
		return 'success';
	}
	
	public function setPriority(){
		$time = time();
		$optionIds = $this->input->post('optionIds');
		if(isset($optionIds) && $optionIds!='' && count($optionIds)>0){
			foreach($optionIds as $id){
				$priority = $this->input->post('optionId_'.$id);
				$this->db->where('id',$id); 
				$this->db->update('department_analysis_reporting', array("priority"=>$priority));
			}
			$this->session->set_flashdata('success', 'Priority of Report Options has been updated successfully!');
		}		
		$encryptReportId = $this->input->post('h_encryptReportId');
		$this->db->where('encryptReportId',$encryptReportId); 
		$this->db->update('department_analysis', array("lastModiTime"=>$time));
		redirect(base_url().'analyze/view/'.$encryptReportId);
	}
	
	public function create_report($dept_id){
		$reportTitle = $this->input->post('createReportTitle');
		$reportSlug = create_slug_ch($reportTitle);
		$reportYear = $this->input->post('createReportYear');
 		$time = time();
 		$this->db->where('department_id', $dept_id);
		$this->db->where('reportSlug', $reportSlug);
		$this->db->where('reportYear', $reportYear);
		$query = $this->db->get('department_analysis');
		$num_rows = $query->num_rows();
		if($num_rows==0){				
			$this->db->insert('department_analysis', array('department_id'=>$dept_id, 'reportTitle'=>$reportTitle, 'reportSlug'=>$reportSlug, 'reportYear'=>$reportYear, 'createTime'=> $time, 'lastModiTime'=> $time));	
			$reportId = $this->db->insert_id();
			$encryptReportId = md5($reportId).$reportId;
			$this->db->where('reportId',$reportId); 
			$this->db->update('department_analysis', array("encryptReportId"=>$encryptReportId));
 			$this->session->set_flashdata('success', 'Report has been created successfully!');
			return 'success||'.$reportId;
		}else{
			return 'error||'.$reportYear.' year already exits.';
		}
	}
	
	public function edit_report($dept_id){
		$reportId = $this->input->post('h_report_id');
		$reportTitle = $this->input->post('h_report_title');
		$reportSlug = create_slug_ch($reportTitle);
		$reportYear = $this->input->post('h_report_year');
 		$time = time();
 		$this->db->where('reportId != ', $reportId);
		$this->db->where('department_id', $dept_id);
		$this->db->where('reportSlug', $reportSlug);
		$this->db->where('reportYear', $reportYear);
		$query = $this->db->get('department_analysis');
		$num_rows = $query->num_rows();
		if($num_rows==0){
			$this->db->where('reportId',$reportId); 
			$this->db->update('department_analysis', array('reportTitle'=>$reportTitle, 'reportSlug'=>$reportSlug, 'reportYear'=>$reportYear, 'lastModiTime'=>$time));
 			$this->session->set_flashdata('success', 'Report has been updated successfully!');
			return 'success||'.$reportId;
		}else{
			return 'error||'.$reportYear.' year already exits.';
		}
	}
	
	public function reportDetails($encryptReportId){
		$this->db->where('encryptReportId', $encryptReportId);
		$query = $this->db->get('department_analysis');
		return $query->row();
	}
	
	public function deleteReport($reportId){
		$this->db->delete('department_analysis', array('reportId'=>$reportId));
		$this->db->delete('department_analysis_reporting', array('reportId'=>$reportId));
		$this->session->set_flashdata('success', 'Report has been deleted successfully!');
	}
	
	public function myDeptReportListing($dept_id){
		$this->db->where('department_id', $dept_id);
		$this->db->order_by('reportYear,reportId', 'desc');
		$query = $this->db->get('department_analysis');
		return $query->result_array();
	}
	
	public function ajaxDeptReptDetails($id){
		$this->db->where('id', $id);
		$query = $this->db->get('department_analysis_reporting');
		return $query->row();
	}
	
	public function deleteReportOption($id){
		$this->db->delete('department_analysis_reporting', array('id'=>$id));
		$this->session->set_flashdata('success', 'Report option has been deleted successfully!');
	}
	
	public function save_my_reporting($dept_id){
		
		$reportId = $this->input->post('h_reportId');
		$action_sts = $this->input->post('h_action_sts');
		if($action_sts==1){
			$anlaysisType = $this->input->post('h_anlaysisType');
		}else{ 
			$anlaysisType = $this->input->post('anlaysisType');
		}
		$anlaysisDesc = $this->input->post('anlaysisDesc');
		
		$time = time();
		
		$this->db->where('reportId', $reportId);
		$this->db->where('department_id', $dept_id);
		$this->db->where('anlaysisType', $anlaysisType);
		$query = $this->db->get('department_analysis_reporting');
		$num_rows = $query->num_rows();
		if($num_rows==0){				
			$this->db->insert('department_analysis_reporting', array('department_id'=>$dept_id, 'reportId'=>$reportId, 'anlaysisType'=>$anlaysisType, 'reportDesc'=>$anlaysisDesc, 'createTime'=> $time, 'lastModiTime'=> $time));				
			$this->session->set_flashdata('success', 'Report has been saved successfully!');		
		}else{
			$this->db->where('reportId', $reportId);
			$this->db->where('department_id', $dept_id);
			$this->db->where('anlaysisType', $anlaysisType);
			$this->db->update('department_analysis_reporting', array("reportDesc"=>$anlaysisDesc, 'lastModiTime'=>$time));
			$this->session->set_flashdata('success', 'Report has been updated successfully!');	
		}
		$this->db->where('reportId',$reportId); 
		$this->db->update('department_analysis', array("lastModiTime"=>$time));
		return 'success||';
		
	}
	
	public function myDeptReportingData($dept_id,$reportId){
		$this->db->where('reportId', $reportId);
		$this->db->where('department_id', $dept_id);
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('department_analysis_reporting');
		return $query->result_array();
	}
	
	public function optionsMasterFromWebDB(){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->select('id, title, description');
		$amee_web->where('page_name', 'analyze');
		$amee_web->where('status', '0');
		$query = $amee_web->get('popup_messages');
		return $query->result_array();	
	}
	
	public function optionsDetailsFromWebDB($id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id', $id);
		$query = $amee_web->get('popup_messages');
		return $query->row();	
	}
	
	public function indicatorMasters(){
		$this->db->order_by('heading_label', 'asc');
		$query = $this->db->get('master_closing_loops');		
		return $query->result_array();	
	}	
			
	function department_reports_detail($action_status){
		$department_id = $this->session->userdata('dept_id');
 		$this->db->where('department_id', $department_id);
 		$this->db->where('action_status', $action_status);
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get('department_reports');
		return $query->result();
	}
		
	function save_upload($department_id,$action_status){
		$title = $this->input->post('title');
		
		if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!=''){		
			if($_FILES['photo']['error']==0){			
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['photo']['name']);
				$photo=time().'.'.$ext;
								
				$config['file_name'] =$photo;
				$config['upload_path'] = './assets/upload/department_reports/';
				$config['allowed_types'] = '*';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('photo');
				
				$data = array('department_id'=>$department_id, 'title'=>$title, 'file_name'=>$photo, 'action_status'=>$action_status, 'add_date'=> time());					
				$query=$this->db->insert('department_reports',$data);				
				$this->session->set_flashdata('success', 'Save successfully!');								
			}			
		}
	}
	
	public function get_loop_details($encryptLoopId){
		$this->db->where('encryptLoopId', $encryptLoopId);
		$query = $this->db->get('analyze_closing_loop_program_year');
		return $query->row();
	}
	
	public function get_closing_loop_data($loopId){
		$this->db->where('loopId', $loopId);
		$this->db->where('coding_status', '0');
		$this->db->order_by('IndicatorId', 'asc');
		$query = $this->db->get('analyze_closing_loop_year_value');
		return $query->result_array();
	}
	
	function add_program_year_entry($dept_id){
		$year = $this->input->post('add_year');		
 		$this->db->where('year', $year);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('analyze_closing_loop_program_year');
		$num_rows = $query->num_rows();
		if($num_rows==0){ 				
			$yearTitle = $this->input->post('yearTitle');
			$date = strtotime(date('Y-m-d'));
 			$time = time();
			$this->db->insert('analyze_closing_loop_program_year', array('department_id'=>$dept_id, 'yearTitle'=>$yearTitle, 'year'=>$year, 'createTime'=>$time, 'lastModiTime'=>$time));
			$loopId = $this->db->insert_id();
			$encryptLoopId = md5($loopId).$loopId;
			$this->db->where('loopId',$loopId); 
			$this->db->update('analyze_closing_loop_program_year', array("encryptLoopId"=>$encryptLoopId));
						
			$popCaseSel = $this->input->post('popCaseSel');
			if(isset($popCaseSel) && $popCaseSel!='' && count($popCaseSel)>0){				 
				foreach($popCaseSel as $indiOptId){					 
					$year_value = $this->input->post('popIndiVal'.$indiOptId);
					$IndicatorId = $this->input->post('loopId'.$indiOptId);					
					$this->db->where('loopId', $loopId);
					$this->db->where('IndicatorId', $IndicatorId);
					$this->db->where('indiOptId', $indiOptId);
					$this->db->where('department_id', $dept_id);
					$qry = $this->db->get('analyze_closing_loop_year_value');
					$num = $qry->num_rows();					
					if($num==0){ 					
						$this->db->insert('analyze_closing_loop_year_value', array('department_id'=>$dept_id, 'IndicatorId'=>$IndicatorId, 'indiOptId'=>$indiOptId, 'loopId'=>$loopId, 'year_value'=>$year_value, 'add_date'=>$date));					
					} 					 
				}				
			}		
			$this->session->set_flashdata('success', 'Successfully added!');	
			return 'success||';
		}else{
			return 'error||'.$year.' year already exits.';
		}
	}
	
	function update_program_year_entry($dept_id){
	
		$loopId = $this->input->post('h_loopId');
		$yearTitle = $this->input->post('yearTitle');
		$date = strtotime(date('Y-m-d'));
		$time = time();
		
		$this->db->where('loopId',$loopId); 
		$this->db->update('analyze_closing_loop_program_year', array("yearTitle"=>$yearTitle, 'lastModiTime'=>$time));
		
		$popCaseSel = $this->input->post('popCaseSel');
 		if(isset($popCaseSel) && $popCaseSel!='' && count($popCaseSel)>0){	
		
			$this->db->where('loopId',$loopId);
			$this->db->update('analyze_closing_loop_year_value', array('coding_status'=>'1'));
			
			foreach($popCaseSel as $indiOptId){					 
				$year_value = $this->input->post('popIndiVal'.$indiOptId);
				$IndicatorId = $this->input->post('loopId'.$indiOptId);					
				$this->db->where('loopId', $loopId);
				$this->db->where('IndicatorId', $IndicatorId);
				$this->db->where('indiOptId', $indiOptId);
				$this->db->where('department_id', $dept_id);
				$qry = $this->db->get('analyze_closing_loop_year_value');
				$num = $qry->num_rows();					
				if($num==0){ 					
					$this->db->insert('analyze_closing_loop_year_value', array('department_id'=>$dept_id, 'IndicatorId'=>$IndicatorId, 'indiOptId'=>$indiOptId, 'loopId'=>$loopId, 'year_value'=>$year_value, 'add_date'=>$date));					
				}else{
					
					$rowData = $qry->row();
					$this->db->where('id',$rowData->id); 
					$this->db->update('analyze_closing_loop_year_value', array("year_value"=>$year_value, 'coding_status'=>'0'));
				} 					 
			}
		
		}
		$this->session->set_flashdata('success', 'Successfully updated!');	
		return 'success||';
	}
	
	function closed_loop_delete($encryptLoopId){
		$this->db->where('encryptLoopId', $encryptLoopId);
		$qry = $this->db->get('analyze_closing_loop_program_year');
		$rowData = $qry->row();
 		$this->db->delete('analyze_closing_loop_program_year', array('encryptLoopId'=>$encryptLoopId));
		$this->db->delete('analyze_closing_loop_year_value', array('loopId'=>$rowData->loopId));	
		$this->session->set_flashdata('success', 'Successfully deleted!');	
	}
	
	function get_closing_loop_list($dept_id){
		$this->db->where('department_id', $dept_id);
		$this->db->order_by('year', 'desc');
		$query = $this->db->get('analyze_closing_loop_program_year');
		return $query->result();
	}
	
	function add_program_year_entry_old($dept_id){		
		$add_year = $this->input->post('add_year');
		$this->db->where('year', $add_year);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('analyze_closing_loop_program_year');
		$num_rows = $query->num_rows();
		
 		if($num_rows==0){
		
			$add_date = strtotime(date('Y-m-d'));
			
			$arr = array('department_id'=>$dept_id, 'year'=>$add_year, 'add_date'=>$add_date);
			$this->db->insert('analyze_closing_loop_program_year', $arr);
			$year_id = $this->db->insert_id();
			
		}else{
		
			$arr = array('year'=>$add_year);
			$this->db->where('year', $add_year);
			$this->db->where('department_id', $dept_id);
			$this->db->update('analyze_closing_loop_program_year',$arr);
			
		}
		$this->session->set_flashdata('success', 'Program year save and update successfully!');
		
	}
	
	function check_year_value_analyze_heading($loop_id,$analyze_label_id,$dept_id,$year_id){
		$this->db->where('year_id', $year_id);
		$this->db->where('loop_id', $loop_id);
 		//$this->db->where('coding_status', '1');
		$this->db->where('analyze_label_id', $analyze_label_id);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('analyze_closing_loop_year_value');
		return $query->row();
 	}
	
	function check_loop_status_assign($analyze_label_id,$dept_id){
		$this->db->where('analyze_label_id', $analyze_label_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('coding_status', '1');
		$query = $this->db->get('analyze_closing_loop_year_value');
		return $num_rows = $query->num_rows();
	}	
	
	function get_program_year_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get('analyze_closing_loop_program_year');
		return $query->result();
	}
	
	function save_closing_loop($dept_id){
 		
		/*$arr = array('coding_status'=>'0');
		$this->db->where('department_id', $dept_id);
		$this->db->update('analyze_closing_loop_year_value',$arr);*/
		
		for($loop=1;$loop<=3;$loop++){
			$lable_status=$loop;
		
			$loop_id = $lable_status;
			$closing_loops_detail = get_master_closing_loops_detail_by_status($lable_status);
			foreach($closing_loops_detail as $loops_detail){
				
				$analyze_label_id = $loops_detail->id;
				$this->db->where('department_id', $dept_id);
				$this->db->order_by('add_date', 'asc');
				$query = $this->db->get('analyze_closing_loop_program_year');
				$program_year_listing = $query->result();
				foreach($program_year_listing as $program_year){
					
					$year_id = $program_year->year_id;
					$year_value = $this->input->post('year_value_'.$loop_id.$analyze_label_id.$year_id);
					//if(isset($year_value) && $year_value!=''){
 							 	
								$coding_status = $this->input->post('hidden_sub_indicator_status'.$loop_id.$analyze_label_id);
  								
								$this->db->where('year_id', $year_id);
								$this->db->where('loop_id', $loop_id);
								$this->db->where('analyze_label_id', $analyze_label_id);
								$this->db->where('department_id', $dept_id);
								$query = $this->db->get('analyze_closing_loop_year_value');
								$num_rows = $query->num_rows();
								
								if($num_rows==0){
								
									$add_date = strtotime(date('Y-m-d'));
									
									$arr = array('department_id'=>$dept_id, 'loop_id'=>$loop_id, 'analyze_label_id'=>$analyze_label_id, 'year_id'=>$year_id, 'year_value'=>$year_value, 'add_date'=>$add_date, 'coding_status'=>$coding_status);
									$this->db->insert('analyze_closing_loop_year_value', $arr);
									$year_id = $this->db->insert_id();
									
								}else{
								
									$arr = array('year_value'=>$year_value, 'coding_status'=>$coding_status);
									$this->db->where('year_id', $year_id);
									$this->db->where('loop_id', $loop_id);
									$this->db->where('analyze_label_id', $analyze_label_id);
									$this->db->where('department_id', $dept_id);
									$this->db->update('analyze_closing_loop_year_value',$arr);
									
								}
						//echo '<hr>';
						
				//	}
				
				}
			
			}
		}
		
		$this->session->set_flashdata('success', 'Save and update successfully!');
	}
	
	function save_loops_description(){		
		$dept_id=$this->session->userdata('dept_id');
		$loop_status = $this->input->post('h_loop_status');
		$h_loop_id = $this->input->post('h_loop_id');
		
		foreach($h_loop_id as $loop_id){
		
			$description = trim($_POST['descreption_'.$loop_id]);
 			 	
			$this->db->where('department_id',$dept_id); 
			$this->db->where('loop_id',$loop_id); 
			$query = $this->db->get('analyze_loop_description');		
			$num_rows = $query->num_rows();
			if($num_rows==0 && isset($description) && $description!=''){
				
				$arr = array('department_id'=>$dept_id,'loop_id'=>$loop_id, 
					'content'=>$description,'loop_status'=>$loop_status,'add_date'=>time());
				$this->db->insert('analyze_loop_description',$arr);	
				
			}else{
				$arr = array('department_id'=>$dept_id,'loop_id'=>$loop_id, 
					'content'=>$description,'loop_status'=>$loop_status);
				$this->db->where('department_id', $dept_id);
				$this->db->where('loop_id', $loop_id);
				$this->db->update('analyze_loop_description',$arr);
			}
 		}
		$this->session->set_flashdata('success', 'Closing Loop save and updated successfully!');	
		redirect(base_url().'department/analyze?loop='.$loop_status);
	}	
	 
}
?>