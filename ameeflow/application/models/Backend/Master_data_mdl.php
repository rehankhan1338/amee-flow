<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_data_mdl extends CI_Model {	
	
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
	
	public function get_cmsmeta_fields($page_id){
	
		$this->db->where('status', '0');
		$this->db->where('page_id', $page_id);
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('cmsmeta');
		return $query->result();
		
	}
	
	public function menu_list($admin_type,$menu_ids){ 		
		if($admin_type=='super_admin'){
			$this->db->where('status', '0');
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('superadmin_menu');
		}else{		
			$dbprefix = $this->db->dbprefix;
			$query = $this->db->query("select * from ".$dbprefix."superadmin_menu where id in($menu_ids) and status='0' order by priority asc");
		}
 		return $query->result();		
	}
	
	public function submenu_list($menu_id,$admin_type,$submenu_ids){
		if($admin_type=='super_admin'){
			$this->db->where('menu_id', $menu_id);
			$this->db->where('status', '0');
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('superadmin_submenu');
		}else{
			$dbprefix = $this->db->dbprefix;
			
			if(isset($submenu_ids) && $submenu_ids!=''){
			$query = $this->db->query("select * from ".$dbprefix."superadmin_submenu where id in($submenu_ids) and menu_id='".$menu_id."' and status='0' order by priority asc");
			}else{
			$query = $this->db->query("select * from ".$dbprefix."superadmin_submenu where  menu_id='".$menu_id."' and status='0' order by priority asc");
			}
		}
		 
		return $query->result();
	}
	
	public function submenu_subcat_list($submenu_id,$admin_type,$submenu_subcat_ids){
		if($admin_type=='super_admin'){
			$this->db->where('status', '0');
			$this->db->where('submenu_id', $submenu_id);
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('superadmin_submenu_subcat');
		}else{
			$dbprefix = $this->db->dbprefix;
			$query = $this->db->query("select * from ".$dbprefix."superadmin_submenu_subcat where id in($submenu_subcat_ids) and submenu_id='".$submenu_id."' and status='0' order by priority asc");
		}
		 
		 
		return $query->result();
	}	


	public function administrator_menu_list($admin_type,$menu_ids){ 		
		if($admin_type=='system-admin'){
			$this->db->where('status', '0');
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('administrator_menu');
		}else{		
			$dbprefix = $this->db->dbprefix;
			$query = $this->db->query("select * from ".$dbprefix."administrator_menu where id in($menu_ids) and status='0' order by priority asc");
		}
 		return $query->result();		
	}

	public function administrator_submenu_list($menu_id,$admin_type,$submenu_ids){
		if($admin_type=='system-admin'){
			$this->db->where('menu_id', $menu_id);
			$this->db->where('status', '0');
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('administrator_submenu');
		}else{
			$dbprefix = $this->db->dbprefix;			
			if(isset($submenu_ids) && $submenu_ids!=''){
				$query = $this->db->query("select * from ".$dbprefix."administrator_submenu where id in($submenu_ids) and menu_id='".$menu_id."' and status='0' order by priority asc");
			}else{
				$query = $this->db->query("select * from ".$dbprefix."administrator_submenu where menu_id='".$menu_id."' and status='0' order by priority asc");
			}
		}		 
		return $query->result();
	}

	public function administrator_submenu_subcat_list($submenu_id,$admin_type,$submenu_subcat_ids){
		if($admin_type=='system-admin'){
			$this->db->where('status', '0');
			$this->db->where('submenu_id', $submenu_id);
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('administrator_submenu_subcat');
		}else{
			$dbprefix = $this->db->dbprefix;
			$query = $this->db->query("select * from ".$dbprefix."administrator_submenu_subcat where id in($submenu_subcat_ids) and submenu_id='".$submenu_id."' and status='0' order by priority asc");
		}		 
		return $query->result();
	}

	public function user_menu_list($userType,$menu_ids){ 		
		if($userType=='root-user'){
			$this->db->where('status', '0');
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('user_menu');
		}else{		
			$dbprefix = $this->db->dbprefix;
			$query = $this->db->query("select * from ".$dbprefix."user_menu where id in($menu_ids) and status='0' order by priority asc");
		}
 		return $query->result();		
	}

	public function user_submenu_list($menu_id,$userType,$submenu_ids){
		if($userType=='root-user'){
			$this->db->where('menu_id', $menu_id);
			$this->db->where('status', '0');
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('user_submenu');
		}else{
			$dbprefix = $this->db->dbprefix;			
			if(isset($submenu_ids) && $submenu_ids!=''){
				$query = $this->db->query("select * from ".$dbprefix."user_submenu where id in($submenu_ids) and menu_id='".$menu_id."' and status='0' order by priority asc");
			}else{
				$query = $this->db->query("select * from ".$dbprefix."user_submenu where menu_id='".$menu_id."' and status='0' order by priority asc");
			}
		}		 
		return $query->result();
	}

	public function user_submenu_subcat_list($submenu_id,$userType,$submenu_subcat_ids){
		if($userType=='root-user'){
			$this->db->where('status', '0');
			$this->db->where('submenu_id', $submenu_id);
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get('user_submenu_subcat');
		}else{
			$dbprefix = $this->db->dbprefix;
			$query = $this->db->query("select * from ".$dbprefix."user_submenu_subcat where id in($submenu_subcat_ids) and submenu_id='".$submenu_id."' and status='0' order by priority asc");
		}		 
		return $query->result();
	}
	
}