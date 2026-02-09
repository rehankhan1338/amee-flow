<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logic_model_mdl extends CI_Model {
	
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
	
	public function admin_logic_models_list(){
		$this->db->select('lm.*, dept.department_name');
		$this->db->from('department_logic_models as lm');
		$this->db->where('lm.isDeleted', '0');
		$this->db->order_by('lm.lastModiTime', 'desc');
		$this->db->join('departments as dept', 'dept.id = lm.departmentId', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function my_logic_model_data($departmentId){
		$this->db->where('departmentId', $departmentId);
		$this->db->where('isDeleted', '0');
		$this->db->order_by('modelId', 'desc');
		$query = $this->db->get('department_logic_models');
		return $query->result();
	}
	
	/*public function get_logic_model_step_data($modelId){
		$this->db->where('modelId', $modelId);
		$query = $this->db->get('department_logic_models_steps');
		return $query->result_array();
	}*/	
	
	public function get_logic_model_details($encryptModelId){
		$this->db->where('encryptModelId', $encryptModelId);
		$query = $this->db->get('department_logic_models');
		return $query->row();
	}	
	
	public function latest_logic_model_details($departmentId){
		$this->db->where('departmentId', $departmentId);
		$this->db->order_by('modelId', 'desc');
		$query = $this->db->get('department_logic_models');
		return $query->row();
	}
	
	public function count_created_logic_models($departmentId){
		$this->db->where('departmentId', $departmentId);
		$query = $this->db->get('department_logic_models');
		return $query->num_rows();
	}
	
	public function save_model_data($departmentId){	
	
		$date= strtotime(date('Y-m-d'));
		$time = time();
		$chkModelId = $this->input->post('h_model_id');
		$programName = $this->input->post('programName');
		$programYear = $this->input->post('programYear');
				
		$situation = $this->input->post('situation');	
		$priority = $this->input->post('priority');	
		$inputs = $this->input->post('inputs');	
		
		$participants = $this->input->post('participants');
		$activities = $this->input->post('activities');
		$directProducts = $this->input->post('directProducts');
		
		$shortOutCome = $this->input->post('shortOutCome');		
		$intermediateOutCome = $this->input->post('intermediateOutCome');		
		$longOutCome = $this->input->post('longOutCome');
		
		if($chkModelId>0){
			$modelId = $chkModelId;
			$this->db->where('modelId',$modelId); 
			$this->db->update('department_logic_models', array('programName'=>$programName, 'programYear'=>$programYear, 'situation'=>$situation, 'priority'=>$priority, 'inputs'=>$inputs, 'participants'=>$participants, 'activities'=>$activities, 'directProducts'=>$directProducts, 'shortOutCome'=>$shortOutCome, 'intermediateOutCome'=>$intermediateOutCome, 'longOutCome'=>$longOutCome, 'lastModiTime'=>$time));
		}else{
			$this->db->insert('department_logic_models', array('departmentId'=>$departmentId, 'programName'=>$programName, 'programYear'=>$programYear, 'situation'=>$situation, 'priority'=>$priority, 'inputs'=>$inputs, 'participants'=>$participants, 'activities'=>$activities, 'directProducts'=>$directProducts, 'shortOutCome'=>$shortOutCome, 'intermediateOutCome'=>$intermediateOutCome, 'longOutCome'=>$longOutCome, 'createDate'=>$date, 'createTime'=>$time, 'lastModiTime'=>$time));
			$modelId = $this->db->insert_id();			
			$encryptModelId = md5($modelId).$modelId;
			$this->db->where('modelId',$modelId); 
			$this->db->update('department_logic_models', array("encryptModelId"=>$encryptModelId));
		}		
		
 		/*$steps = 6;
		
		for($s=1;$s<=$steps;$s++){
			$stepContent = $this->input->post('step_'.$s);
			if($chkModelId==0){
				$this->db->insert('department_logic_models_steps', array('modelId'=>$modelId, 'departmentId'=>$departmentId, 'step'=>$s, 'stepContent'=>$stepContent));				 
			}else{
				$this->db->where('modelId', $modelId);
				$this->db->where('departmentId', $departmentId);
				$this->db->where('step', $s);
				$this->db->update('department_logic_models_steps', array('stepContent'=>$stepContent)); 		
			}		
		}*/
		$this->session->set_flashdata('success', 'Your Logic Model has been saved!');	
	}
	
	public function delete_model($encryptModelId){	
		$this->db->where('encryptModelId',$encryptModelId); 
		$this->db->update('department_logic_models', array('isDeleted'=>'1', 'lastModiTime'=>time()));
		$this->session->set_flashdata('success', 'Your Logic Model has been deleted!');
	}
	
}