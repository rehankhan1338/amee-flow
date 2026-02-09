<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey_template_mdl extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */ 
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
		
		
	public function default_survey_templates_detail(){
 		//$this->db->where('status', '0');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('default_survey_templates');
		return $query->result();
	}
	
	public function edit_template_entry($id){
		$status = $this->input->post('status');
		$name = $this->input->post('txt_template_name');
		$slug = create_slug_ch($name);		
		$this->db->where('id != ', $id);
		$this->db->where('slug', $slug);
		$query = $this->db->get('default_survey_templates');
		$cnt = $query->num_rows();
		if($cnt==0){
			$this->db->where('id', $id);
			$this->db->update('default_survey_templates', array('name'=>$name, 'slug'=>$slug, 'status'=>$status));
			$this->session->set_flashdata('success', 'Default survey template updated successfully!');
			redirect(base_url()."admin/survey/template");
		}else{
			$this->session->set_flashdata('error', 'Oops, survey template already exist!');
			redirect(base_url()."admin/survey_template/edit_template?id=".$id);
		}
	}
	
	public function add_template_entry(){
		$name = $this->input->post('txt_template_name');
		$slug = create_slug_ch($name);		
		$this->db->where('slug', $slug);
		$query = $this->db->get('default_survey_templates');
		$cnt = $query->num_rows();
		if($cnt==0){
			$this->db->insert('default_survey_templates', array('name'=>$name, 'slug'=>$slug, 'status'=>'0'));
			$this->session->set_flashdata('success', 'Default survey template created successfully!');
		}else{
			$this->session->set_flashdata('error', 'Oops, survey template already exist!');
		}
	}		
		
	function get_master_question_type(){
		$this->db->where('status', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('survey_master_question_types');
		return $query->result();
	}	
	
	
	function default_surveys_questions_details(){
		$where = ' status=0';
		if(isset($_GET['stid'])&& $_GET['stid']!=''){
			$survey_templates_id = $_GET['stid'];
				$where.=" and survey_id=".$survey_templates_id;
			$this->db->where($where);
		}		
		$this->db->where('is_deleted', '0');
		//$this->db->order_by('id', 'asc');
		$query = $this->db->get('default_surveys_questions');
		return $query->result();
	}
	
	public function default_survey_templates_fulldetail($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('default_survey_templates');
		return $query->row();
	}
	
	function get_multiple_choice_rating_ajax($scale_id){
 		$this->db->where('id', $scale_id);
		$query = $this->db->get('5pt_rating_scale');
		return $query->row();
	}
	
	function question_save(){	
		$survey_template_id = $this->input->post('survey_template_id');

		$this->db->where('survey_id', $survey_template_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('question_id', 'desc');
		$query_get_priority = $this->db->get('default_surveys_questions');
		$priority_count = $query_get_priority->num_rows();
		if($priority_count==0){
			$priority_set = 1;
		}else{
 			$priority_set = $priority_count+1;
		}
		 
		$question_title = $this->input->post('survey_question_title');
		$question_type = $this->input->post('hidden_question_type');
		$creation_date = strtotime(date('Y-m-d'));
  			
		$surveys_questions_arr = array('survey_id'=>$survey_template_id, 'question_title'=>$question_title, 'question_type'=>$question_type, 'creation_date'=>$creation_date, 'priority'=>$priority_set);
		$this->db->insert('default_surveys_questions', $surveys_questions_arr);
		$question_id=$this->db->insert_id();
	 
		if(isset($question_type) && ($question_type==1 || $question_type==3 || $question_type==2 || $question_type==4)){
			$is_required = $this->input->post('validation_status');
			$required_message = $this->input->post('validation_error_message');
			$validation_arr = array('is_required'=>$is_required, 'required_message'=>$required_message);
			$this->db->where('question_id', $question_id);
			$this->db->update('default_surveys_questions',$validation_arr);
		}
		
		if(isset($question_type) && $question_type==1){
			//$is_demography = $this->input->post('is_demography');
			$is_demography = 0;
			$demography_arr = array('is_demography'=>$is_demography);
			$this->db->where('question_id', $question_id);
			$this->db->update('default_surveys_questions',$demography_arr);
			
			$hidden_choice_count = $this->input->post('hidden_choice_count');
			for($i=1;$i<=$hidden_choice_count;$i++){
				$choices = $this->input->post('choice_'.$i);
				$surveys_questions_answer_arr = array('survey_id'=>$survey_template_id, 
					'question_id'=>$question_id, 'answer_choice'=>$choices);
				$this->db->insert('default_survey_question_answers', $surveys_questions_answer_arr);
				$answer_id=$this->db->insert_id();
		  	}
		}	
			
		if(isset($question_type) && $question_type==2){
			$h_tr_row_count = $this->input->post('h_tr_row_count');
			$h_tr_colum_count = $this->input->post('h_tr_colum_count');
			
			for($i=1;$i<=$h_tr_colum_count;$i++){
				$matrix_column = $this->input->post('field_matrix_column_'.$i);
				
				$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_column, 'choices_status'=>'1');
				$this->db->insert('default_survey_question_choices', $matrix_row_arr);
				
				$matrix_row_arr132 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_column);
				$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr132);
		  	}
			
			for($i=1;$i<=$h_tr_row_count;$i++){
				$matrix_row = $this->input->post('field_matrix_row_'.$i);
				
				$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_row, 'choices_status'=>'0');
				$this->db->insert('default_survey_question_choices', $matrix_row_arr);
				
				for($j=1;$j<=$h_tr_colum_count;$j++){
					$choices_scale = $this->input->post('field_matrix_column_'.$j);
					$matrix_row_arr12 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_row, 'choices_scale'=>$choices_scale);
					$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr12);
				}
		  	}		  	
		  				
		}
				
		if(isset($question_type) && $question_type==4){
			$nps_first_field = $this->input->post('npsq_first_field');
			$nps_middle_field = $this->input->post('npsq_middle_field');
			$nps_last_field = $this->input->post('npsq_last_field');
			
			$nps_arr =array('nps_first_field'=>$nps_first_field, 
				'nps_middle_field'=>$nps_middle_field, 'nps_last_field'=>$nps_last_field);
			$this->db->where('question_id', $question_id);
			$this->db->update('default_surveys_questions',$nps_arr);
		}		
		redirect(base_url().'admin/survey_template?stid='.$survey_template_id);
	}
	
	
	public function default_surveys_questions_rowdetails($question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('default_surveys_questions');
		return $query->row();
	}

	
	function update_question_entry(){	
		$question_id = $this->input->post('hidden_question_id');
		$question_title = $this->input->post('survey_question_title');	
		$question_type_old = $this->input->post('hidden_old_question_type');
		$question_type = $this->input->post('hidden_question_type');
		$survey_template_id = $this->input->post('survey_template_id');				
  		$is_required = $this->input->post('validation_status');
		$required_message = $this->input->post('validation_error_message');
		
		$questions_arr = array('question_title'=>$question_title, 'question_type'=>$question_type, 'is_required'=>$is_required, 'required_message'=>$required_message);
		$this->db->where('question_id', $question_id);
		$this->db->update('default_surveys_questions',$questions_arr);	
		
		if($question_type_old==$question_type){
		
			if($question_type==1){ 				
				$answer_choice_arr = $this->input->post('answer_choice_id');
				if(count($answer_choice_arr)>0){
 					for($i=0;$i<count($answer_choice_arr);$i++){
						$answer_id = $answer_choice_arr[$i];
						$answer_choice = $this->input->post('old_choice_'.$answer_id);
						$arr = array('answer_choice'=>$answer_choice);
						$this->db->where('answer_id', $answer_id);
						$this->db->update('default_survey_question_answers',$arr);
					}	
 				}
				
				$new_choice_arr = $this->input->post('new_choice_arr');
				if(count($new_choice_arr)>0){
					for($j=0;$j<count($new_choice_arr);$j++){
						$new_choice_id = $new_choice_arr[$j];
						$new_choice_value = $this->input->post('choice_'.$new_choice_id);
						if(isset($new_choice_value) && $new_choice_value!=''){				
							$surveys_questions_answer_arr = array('survey_id'=>$survey_template_id, 'question_id'=>$question_id, 'answer_choice'=>$new_choice_value);
							$this->db->insert('default_survey_question_answers', $surveys_questions_answer_arr);	
						}
					}
				}			  
		 		
			} 
			
			if($question_type==4){				
				$nps_first_field = $this->input->post('npsq_first_field');		
				$nps_middle_field = $this->input->post('npsq_middle_field');
				$nps_last_field = $this->input->post('npsq_last_field');	
				
				$nps_arr = array('nps_first_field'=>$nps_first_field,'nps_middle_field'=>$nps_middle_field,'nps_last_field'=>$nps_last_field);
				$this->db->where('question_id', $question_id);
				$this->db->update('default_surveys_questions',$nps_arr);					
			}
			
			
			if($question_type==2){				
				$column_id_arr = $this->input->post('h_column_id');
				$h_column_name_arr = $this->input->post('h_column_name');
				if(count($column_id_arr)>0){
					for($i=0;$i<count($column_id_arr);$i++){
						$row_id = $column_id_arr[$i];
						$column_name = $h_column_name_arr[$i];
 						$scale_column_choice = $this->input->post('old_field_matrix_column_'.$row_id);
						$arr = array('choices'=>$scale_column_choice);
						$this->db->where('row_id', $row_id);
						$this->db->update('default_survey_question_choices',$arr);
						
						$first_arr = array('answer_choice'=>$scale_column_choice);
						$this->db->where('answer_choice', $column_name);
						$this->db->where('question_id', $question_id);
 						$this->db->update('default_survey_question_choices_conditions',$first_arr);
						
						$second_arr = array('choices_scale'=>$scale_column_choice);
						$this->db->where('choices_scale', $column_name);
						$this->db->where('question_id', $question_id);
 						$this->db->update('default_survey_question_choices_conditions',$second_arr);
					}
				}
				
				$row_id_arr = $this->input->post('h_statement_row_id');
				$h_row_name_arr = $this->input->post('h_statement_row_name');
				if(count($row_id_arr)>0){
					for($i=0;$i<count($row_id_arr);$i++){
						$row_id = $row_id_arr[$i];
						$row_name = $h_row_name_arr[$i];
 						$scale_row_choice = $this->input->post('old_field_matrix_row_'.$row_id);
						$arr = array('choices'=>$scale_row_choice);
						$this->db->where('row_id', $row_id);
						$this->db->update('default_survey_question_choices',$arr);
						
						$row_first_arr = array('answer_choice'=>$scale_row_choice);
						$this->db->where('answer_choice', $row_name);
						$this->db->where('question_id', $question_id);
 						$this->db->update('default_survey_question_choices_conditions',$row_first_arr);				
					}
				}
				 
 				$h_tr_row_count = $this->input->post('h_tr_row_count');
				$h_tr_colum_count = $this->input->post('h_tr_colum_count');
				if(count($h_tr_colum_count)>0){
					for($i=1;$i<=$h_tr_colum_count;$i++){
						$matrix_column = $this->input->post('field_matrix_column_'.$i);
						
						$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_column, 'choices_status'=>'1');
						$this->db->insert('default_survey_question_choices', $matrix_row_arr);
						
						$matrix_row_arr132 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_column);
						$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr132);
 					}
				}
				 
				if(count($h_tr_row_count)>0){
					for($i=1;$i<=$h_tr_row_count;$i++){
					
						$matrix_row = $this->input->post('field_matrix_row_'.$i);
 						$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_row, 'choices_status'=>'0');
						$this->db->insert('default_survey_question_choices', $matrix_row_arr);
						
						if(count($h_tr_colum_count)>0){
							for($j=1;$j<=$h_tr_colum_count;$j++){
								$choices_scale = $this->input->post('field_matrix_column_'.$j);
								$matrix_row_arr12 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_row, 'choices_scale'=>$choices_scale);
								$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr12);
							}
						}
					} 
				}
				
				$this->db->where('choices_status', '0');
				$this->db->where('question_id', $question_id);
				$this->db->order_by('row_id', 'asc');
				$query = $this->db->get('default_survey_question_choices');
				$result_survey_question_choices =  $query->result();
				foreach($result_survey_question_choices as $statement_choice_details){
				
					$statement_choices_label = $statement_choice_details->choices;
				
					$this->db->where('choices_status', '1');
					$this->db->where('question_id', $question_id);
					$this->db->order_by('row_id', 'asc');
					$query_columns_choices = $this->db->get('default_survey_question_choices');
					$result_columns_choices =  $query_columns_choices->result();
					foreach($result_columns_choices as $scale_choice_details){
						
						$scale_choices_label = $scale_choice_details->choices;
						
						$this->db->where('answer_choice', $statement_choices_label);
						$this->db->where('choices_scale', $scale_choices_label);
						$this->db->where('question_id', $question_id);
						$query_conditions_choices = $this->db->get('default_survey_question_choices_conditions');
						$conditions_choices_num_rows =  $query_conditions_choices->num_rows();
						if($conditions_choices_num_rows==0){
							$matrix_row_arr123 =array('question_id'=>$question_id, 'answer_choice'=>$statement_choices_label, 'choices_scale'=>$scale_choices_label);
							$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr123);
						}						
					}						 
				}				 
			}		
			
  			 
		}else{
 			
			if($question_type_old==1){
 				$this->db->delete('default_survey_question_answers', array('survey_id'=>$survey_template_id,'question_id'=>$question_id));
 			}else if($question_type_old==2){
 				$this->db->delete('default_survey_question_choices', array('question_id' => $question_id));
				$this->db->delete('default_survey_question_choices_conditions', array('question_id' => $question_id));
 			}else if($question_type_old==4){
 				$questions_arr = array('nps_first_field'=>'', 'nps_middle_field'=>'', 'nps_last_field'=>'');
				$this->db->where('question_id', $question_id);
				$this->db->update('default_surveys_questions',$questions_arr);
 			}			
			 
			if($question_type==1){			
				$new_choice_arr = $this->input->post('new_choice_arr');
				if(count($new_choice_arr)>0){
					for($j=0;$j<count($new_choice_arr);$j++){
						$new_choice_id = $new_choice_arr[$j];
						$new_choice_value = $this->input->post('choice_'.$new_choice_id);
						if(isset($new_choice_value) && $new_choice_value!=''){				
							$surveys_questions_answer_arr = array('survey_id'=>$survey_template_id, 'question_id'=>$question_id, 'answer_choice'=>$new_choice_value);
							$this->db->insert('default_survey_question_answers', $surveys_questions_answer_arr);	
						}
					}
				}
			}
			
			if($question_type==2){
				$h_tr_row_count = $this->input->post('h_tr_row_count');
				$h_tr_colum_count = $this->input->post('h_tr_colum_count');
				
				for($i=1;$i<=$h_tr_colum_count;$i++){
					$matrix_column = $this->input->post('field_matrix_column_'.$i);
					
					$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_column, 'choices_status'=>'1');
					$this->db->insert('default_survey_question_choices', $matrix_row_arr);
					
					$matrix_row_arr132 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_column);
					$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr132);
				}
				
				for($i=1;$i<=$h_tr_row_count;$i++){
					$matrix_row = $this->input->post('field_matrix_row_'.$i);
					
					$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_row, 'choices_status'=>'0');
					$this->db->insert('default_survey_question_choices', $matrix_row_arr);
					
					for($j=1;$j<=$h_tr_colum_count;$j++){
						$choices_scale = $this->input->post('field_matrix_column_'.$j);
						$matrix_row_arr12 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_row, 'choices_scale'=>$choices_scale);
						$this->db->insert('default_survey_question_choices_conditions', $matrix_row_arr12);
					}
				}		  	
							
			}
					
			if($question_type==4){			
				$nps_first_field = $this->input->post('npsq_first_field');
				$nps_middle_field = $this->input->post('npsq_middle_field');
				$nps_last_field = $this->input->post('npsq_last_field');
				
				$nps_arr =array('nps_first_field'=>$nps_first_field, 'nps_middle_field'=>$nps_middle_field, 'nps_last_field'=>$nps_last_field);
				$this->db->where('question_id', $question_id);
				$this->db->update('default_surveys_questions',$nps_arr);
			}
		}		 
		redirect(base_url().'admin/survey_template/edit?question_id='.$question_id.'&survey_id='.$survey_template_id);
	}
	
	
	function delete_question_choice($answer_id,$question_id,$question_type){
		if($question_type==1){
			$this->db->where('answer_id', $answer_id);
			$query = $this->db->delete('default_survey_question_answers');
		}			
  		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'admin/survey_template/edit?question_id='.$question_id.'&survey_id='.$_GET['question_id']);
	}
	
	
	function delete_default_survey_question($question_id,$survey_template_id){	
		$arr = array('is_deleted'=>'1','priority'=>'0');
		$this->db->where('question_id', $question_id);
		$this->db->update('default_surveys_questions',$arr);
		
		$this->db->where('survey_id', $survey_template_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query_get_priority = $this->db->get('default_surveys_questions');
		$priority_count = $query_get_priority->num_rows();
		if($priority_count>0){			 
			$get_priority = $query_get_priority->result();
			$i=1;foreach($get_priority as $get_priority_details){
			
				$p_question_id = $get_priority_details->question_id;
				$priority_set = $i;
				$arr_p = array('priority'=>$i); 
				$this->db->where('question_id', $p_question_id);
				$this->db->update('default_surveys_questions',$arr_p);
			
			$i++;}
		}		
		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'admin/survey_template?stid='.$survey_template_id);
	}
	
	
}