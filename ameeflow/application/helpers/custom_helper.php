<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   	
	
	// function chkLightAccess($uaeId){
	// 	$CI = & get_instance();
	// 	$CI->load->model('Users_mdl');
	// 	return $CI->Users_mdl->chkLightAccessPermission($uaeId);
	// }
	
	function timeAgoCh($timestamp) {
	   
	   $strTime = array("sec", "min", "hour", "day", "month", "year");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return $diff . " " . $strTime[$i] . " ago ";
	   }
	}
	
	// function getPlanningMinLinksCh(){
	// 	$CI = & get_instance();
	// 	$CI->load->model('Cms_mdl');
	// 	return $CI->Cms_mdl->getPlanningMinLinks();
	// }	
	
	function create_slug_ch($string){
		$slug_a = url_title(convert_accented_characters($string), 'dash', true);
		//$slug_b = preg_replace ('/[0-9]+$/','', $slug_a );
		$slug_c = auto_link($slug_a, 'url');
		return reduce_multiples(trim($slug_c), "-", TRUE);
	}
	
	function filter_array($array,$term,$field_name){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term)
				$matches[]=$a;
		}
		return $matches;
	}
	
	function filter_array_three($array,$term,$field_name,$term_1,$field_name_1,$term_2,$field_name_2){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term && $a["$field_name_1"] == $term_1 && $a["$field_name_2"] == $term_2)
				$matches[]=$a;
		}
		return $matches;
	}
	
	function filter_array_two($array,$term,$field_name,$term_1,$field_name_1){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term && $a["$field_name_1"] == $term_1)
				$matches[]=$a;
		}
		return $matches;
	}
	
	function filter_array_two_or_con($array,$term,$field_name,$term_1,$field_name_1){
		$matches = array();
		foreach($array as $a){
			if($a["$field_name"] == $term || $a["$field_name_1"] == $term_1)
				$matches[]=$a;
		}
		return $matches;
	}
	
	function get_multidimension_array_key_ch($products, $field, $value){
		foreach($products as $key => $product){
			if($product[$field]===$value){
				return $key;
			}	 
		}
		return false;
	}

	function generateRandomNumStringCh($length = 5) {
		$characters = '123456789abdeghnqrABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function getApprovalDataArrCh($chkId,$reportFor){
		$CI = & get_instance();
		$CI->load->model('Notifications_mdl');
		return $CI->Notifications_mdl->getApprovalDataArr($chkId,$reportFor);
	}

	function getUserAssignProTaskCnt($projectId,$userId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->getUserAssignProTaskCnt($projectId,$userId);
	}

	function getRedFlaggedTaskCnt($projectId,$userId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->getRedFlaggedTaskCnt($projectId,$userId);
	}

	function chkStsofUserTakeActionCh($userId,$taskId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->chkStsofUserTakeAction($userId,$taskId);
	}

	function assignedProTaskDataArr($projectId,$taskId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->assignedProTaskDataArr($projectId,$taskId);
	}

	function avgUserTakeTaskActionCntCh($taskId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->avgUserTakeTaskActionCntCh($taskId);
	}

	function avgUserTakeSubTaskActionCntCh($subTaskId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->avgUserTakeSubTaskActionCnt($subTaskId);
	}

	function proTaskListDataArrCh($projectId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->proTaskListDataArr($projectId);
	}

	function projectWiseSubTaskDataArrCh($projectId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->projectWiseSubTaskDataArr($projectId);
	}

	function getAssignedProUsersListCh($projectId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->getAssignedProUsersList($projectId);
	}

	function getAssignedProTaskUsersListCh($taskId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->getAssignedProTaskUsersList($taskId);
	}

	function getAssignedProActiveUsersListCh($projectId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->getAssignedProActiveUsersList($projectId);
	}

	function chkTaskActionTakenSts($subTaskId,$taskId,$projectId,$userId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->chkTaskActionTakenSts($subTaskId,$taskId,$projectId,$userId);
	}

	function chkUserProAssignStsCh($userId,$projectId,$taskId){
		$CI = & get_instance();
		$CI->load->model('Projects_mdl');
		return $CI->Projects_mdl->chkUserProAssignSts($userId,$projectId,$taskId);
	}

	function getOtherDocumentByTaskIdCh($taskId){
		$CI = & get_instance();
		$CI->load->model('Other_documents_mdl');
		return $CI->Other_documents_mdl->getOtherDocumentByTaskId($taskId);
	}

	function getGuestAccessListByAEch($userId){
		$CI = & get_instance();
		$CI->load->model('Notifications_mdl');
		return $CI->Notifications_mdl->getGuestAccessListByAE($userId);
	}

	function getTwoCharsFromEachWord($str){
		$result = '';
		if(isset($str) && $str!=''){
			$strArr = explode(' ',$str);
			for($i=0;$i<=1;$i++){
				$result .= substr($strArr[$i], 0, 1);
			}
		}
		return $result;
	}

	function generateDarkColorHex() {
		$r = rand(0, 255);
		$g = rand(0, 255);
		$b = rand(0, 255);
		return sprintf("#%02X%02X%02X", $r, $g, $b);
	}

	function generateLightColorHex() {
		// $r = rand(100, 180);
		// $g = rand(120, 200);
		// $b = rand(120, 200);
		$r = rand(0, 255);
		$g = rand(0, 255);
		$b = rand(0, 255);
		return sprintf("#%02X%02X%02X", $r, $g, $b);
	}

	function getReadableFontColor($backgroundHex) {
		$backgroundHex = ltrim($backgroundHex, '#');
		// Convert hex to RGB
		$r = hexdec(substr($backgroundHex, 0, 2));
		$g = hexdec(substr($backgroundHex, 2, 2));
		$b = hexdec(substr($backgroundHex, 4, 2));
		// Calculate luminance (standard formula)
		$luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b);
		// If the background is light, return black text; else, white
		return ($luminance > 150) ? '#000000' : '#FFFFFF';
	}

	function rgbToHex($r, $g, $b) {
		return sprintf("#%02X%02X%02X", $r, $g, $b);
	}

	function generateMatchingButtonColor($r, $g, $b) {
		$r = max(0, $r - rand(40, 80));
		$g = max(0, $g - rand(40, 80));
		$b = max(0, $b - rand(40, 80));
		return rgbToHex($r, $g, $b);
	}

	function match_lighter_color($hexColor, $lightenPercent) { // will not return white and black color
		// Remove '#' if present
		$hexColor = str_replace('#', '', $hexColor);
	
		// Convert hex to RGB
		if (strlen($hexColor) == 6) {
			$r = hexdec(substr($hexColor, 0, 2));
			$g = hexdec(substr($hexColor, 2, 2));
			$b = hexdec(substr($hexColor, 4, 2));
		} elseif (strlen($hexColor) == 3) { // Short hex format (e.g., #FFF)
			$r = hexdec(str_repeat(substr($hexColor, 0, 1), 2));
			$g = hexdec(str_repeat(substr($hexColor, 1, 1), 2));
			$b = hexdec(str_repeat(substr($hexColor, 2, 1), 2));
		} else {
			return false; // Invalid hex color format
		}
	
		// Calculate the lighter shade while maintaining color proportion
		$r = min(255, $r + (($lightenPercent / 100) * (255 - $r)));
		$g = min(255, $g + (($lightenPercent / 100) * (255 - $g)));
		$b = min(255, $b + (($lightenPercent / 100) * (255 - $b)));
	
		// Ensure color stays away from pure black or white
		$minValue = 50;  // Avoid too dark (blackish)
		$maxValue = 245; // Avoid too light (whitish)
	
		$r = max($minValue, min($r, $maxValue));
		$g = max($minValue, min($g, $maxValue));
		$b = max($minValue, min($b, $maxValue));
	
		// Convert back to hex format
		$newColor = sprintf("#%02x%02x%02x", round($r), round($g), round($b));
	
		return $newColor;
	}

	function hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';

		if(empty($color))
			return $default; 

		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if (strlen($color) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		$rgb = array_map('hexdec', $hex);

		if($opacity !== false){
			$opacity = max(0, min(1, floatval($opacity))); // clamp between 0–1
			$output = 'rgb('.implode(",", $rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",", $rgb).')';
		}

		return $output;
	}

	function match_darker_color_by_pattern($hexColor) {
		// Remove '#' if it's there
		$hexColor = str_replace('#', '', $hexColor);

		// Convert hex to RGB
		if (strlen($hexColor) == 6) {
			$r = hexdec(substr($hexColor, 0, 2));
			$g = hexdec(substr($hexColor, 2, 2));
			$b = hexdec(substr($hexColor, 4, 2));
		} elseif (strlen($hexColor) == 3) {
			$r = hexdec(str_repeat($hexColor[0], 2));
			$g = hexdec(str_repeat($hexColor[1], 2));
			$b = hexdec(str_repeat($hexColor[2], 2));
		} else {
			return false; // Invalid hex color
		}

		// Decrease RGB values for a darker shade
		$r = max(0, $r - 25);  // Reduce red
		$g = max(0, $g - 30);  // Reduce green
		$b = max(0, $b - 35);  // Reduce blue

		// Convert back to hex
		$newColor = sprintf("#%02x%02x%02x", $r, $g, $b);

		return $newColor;
	}

	function wpImgColorCh($color) { 
		$default = 'rgb(0,0,0)';
		if(empty($color))
			  return $default; 
	 
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}	 
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}	 
			$rgb =  array_map('hexdec', $hex);
			if ((($rgb[0]*0.299) + ($rgb[1]*0.587) + ($rgb[2]*0.114))>186){
				$wpColor = '#000000';
			}else{
				$wpColor = '#ffffff';
			}
			return $wpColor;
	}