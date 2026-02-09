<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mylibrary
{	
	function day_array()
	{
		return array('1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10',
					 '11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19',
					 '20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28',
					 '29'=>'29','30'=>'30','31'=>'31');
	}
	function month_array()
	{
		return array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
					 '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	}
	function make_seed()
	{
		list($usec, $sec) = explode(' ', microtime());
		return (float) $sec + ((float) $usec * 100000);
	}
	function gethour()
	{
		$dt=$this->get_local_time("time");
		$str_date=strtotime($dt);	
		$hour=date("H",$str_date);
		
		return $hour;
	}
	function getyear()
	{
		$dt=$this->get_local_time("time");
		$str_date=strtotime($dt);	
		$hour=date("Y",$str_date);
		
		return $hour;
	}
	function get_gmt_info()
	{
		$data=array();
		$CI =& get_instance();
		$CI->db->select("gmt_time");		
        $query = $CI->db->get_where("time_zone_setting",array("status"=>"on"));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row_array();				
		}		
		$query->free_result();
		return $data['gmt_time'];
	}
	function get_local_time($time="none")
	{
		$gmt_info=$this->get_gmt_info();
		$gmt_time=explode(':',$gmt_info);		
		$hour_delay=$gmt_time[0];
		$minute_delay=$gmt_time[1];									 
		//$hour_delay=6; $minute_delay=00;
		
		if($time!='none')
		return date("Y-m-d H:i:s",mktime (gmdate("H")+$hour_delay,gmdate("i")+$minute_delay,gmdate("s"),
					gmdate("m"),gmdate("d"),gmdate("Y")));
		else
			return date("Y-m-d",mktime(gmdate("H")+$hour_delay,gmdate("i")+$minute_delay,gmdate("s"),gmdate("m"),
						gmdate("d"),gmdate("Y")));
	}

	function get_remaining_time($current_time,$end_date)
	{	
		$end_date_time=strtotime($end_date);
		$current_date_time=strtotime($current_time); 
		return $end_date_time - $current_date_time;		
	}

	function get_time_difference($start, $end)
	{
		if(strtotime($end) > strtotime($start)){
				$diff=strtotime($end) - strtotime($start); 
				if( $days=intval((floor($diff/86400))) )
					$diff = $diff % 86400;
				if( $hours=intval((floor($diff/3600))) )
					$diff = $diff % 3600;
				if( $minutes=intval((floor($diff/60))) )
					$diff = $diff % 60;
				$diff    =    intval( $diff );             
				return(array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff));
			}
			else
			{return false;}
	}


	function changeDateFormat($date)
	{
		$str_date=strtotime($date);
		//$dt_frmt=date("M d, h:i a",$str_date);	
		$dt_frmt=date("F j, Y, g:i a",$str_date);		
		return $dt_frmt;
	}
	function changeDate_timeFormat($date)
	{
		$str_date=strtotime($date);
		$dt_frmt=date("M d Y, h:i",$str_date);		
		return $dt_frmt;
	}
	function changeDateToEnglishFormat($date)
	{
		$str_date=strtotime($date);
		$dt_frmt=date("d F Y",$str_date);		
		return $dt_frmt;
	}
	function get_new_img_name($image_name,$length = 10)
	{
		$code = "";			
		$parts=explode(".",$image_name);
		$size=sizeof($parts);
		$ext=$parts[$size-1];
	
		$chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		srand((double)microtime() * 1000000);
		for ($i = 0; $i < $length; $i++)
		{
			$code = $code . substr($chars, rand() % strlen($chars), 1);
		 }
		 return $code.".".$ext;;
				
	}
	function upload_thumb_image($temp_name,$image_name,$width,$height,$upload_path)
	{		 
			$CI =& get_instance();
             $CI->load->library('image_lib');
           //Gen Random code for new file name
            $newimagename = $this->get_new_img_name($image_name);             
			 
            //Creat Thumbnail
            //$config['image_library'] = 'GD2';
            $config['source_image'] = $temp_name;
            //$config['create_thumb'] = TRUE;
            //$config['thumb_marker'] = '_tn';
            //$config['master_dim'] = 'width';
            $config['quality'] = 75;
            $config['maintain_ratio'] = FALSE;//FALSE for fix size of image, TRUE manage retion when resize image
            $config['width'] = $width;
            $config['height'] = $height;
            $config['new_image'] = $upload_path.$newimagename;//'/upload_images/product/'.$newimagename;			
			
			 $CI->image_lib->initialize($config);
            //$this->load->library('image_lib', $config);
            //$this->image_lib->resize();
			
            if(!$CI->image_lib->resize())
			{
				echo  $CI->image_lib->display_errors();
				 
				 exit;
			}
            $CI->image_lib->clear();
			
           return $newimagename;
            
	}
	function check_float_vlaue($str) 
	{
	  if (preg_match("/^[0-9]+(\.[0-9]{1,2})?$/",$str)) 
	  {return true;} 
	  else 
	  {return false;}	
	}
	function check_int_vlaue($str) 
	{
	  if (preg_match("/^[0-9]+$/",$str)) 
	  {return true;} 
	  else 
	  {return false;}	
	}
	
	function validate_email($email){ 
	
		$exp = "[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i]";
		
		if(!preg_match($exp,$email))
		{
				if(@checkdnsrr(array_pop(explode("@",$email)),"MX")){
					return TRUE;
                                        echo $email;
				}else{
					return FALSE;
				}
		}else{
			return FALSE;
		}   
	}
	
	function encode($str) 
	{
	  
	  return urlencode(base64_encode($str));
	}
	
	function decode($str) 
	{
	  
	  return urlencode(base64_decode($str));
	}
	
	function genRandomPassword($size)
	{
		$length = $size;
		$characters = '!$@#0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ';
		$string = '';
		
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, (strlen($characters)-1))];
		}
		return $string;
	}
	
	function numFormat($num, $sep='.', $sig=2, $ret=FALSE)
	{
		$cut = substr($num, 0, ( (strpos($num, $sep)+1)+$sig ));
		
		if($ret){ return $cut; }
		else{ echo $cut; }
	} 
	
	
	function getExtension($filename)
	{
		$ext =  @pathinfo($filename, PATHINFO_EXTENSION);  //substr(strrchr($filename,'.'),1);   
		return strtolower($ext);
	} 
	
	
	function getMean($numbers=array())
	{ 
	 if(count($numbers)!=0) { return  number_format(array_sum($numbers)/ count($numbers), 2); } else { return 0; }
	}
	
	function getMedian($numbers=array())
	{ if(count($numbers)!=0){
		if (!is_array($numbers))
			$numbers = func_get_args();
		
		rsort($numbers); 
		$mid = ceil((count($numbers) / 2));
		$total_arg = count($numbers);
		//print_r($numbers);
		//echo $numbers{$mid-1};
		//return ($total_arg % 2 != 0) ? $numbers{$mid-1} : (($numbers{$mid-1}) + $numbers{$mid}) / 2;
	} else { return 0;}
        }
	
	function getMode($numbers=array())
	{ if(count($numbers)!=0){
		if (!is_array($numbers))
			$numbers = func_get_args();
		
		//$numbers = array_replace($numbers,array_fill_keys(array_keys($numbers, null),''));
		
		$amt = array_count_values($numbers);
		arsort($amt);
	    
		$mode = "";
		foreach ($amt as $key => $val) {
			//if ($val == max($amt)) { return $key; }
			if ($val == max($amt)) { 
				/*if($val && max($amt) > 1) return $key; else return "-";*/
				if($val && max($amt) > 1) { $mode .=  $key.",";}  else { $mode = "-"; }
			}
		}
      
		
		return rtrim($mode, ",");
                  }else {
            return 0;
        }
	}
	
	function getStandardDeviation($numbers=array())
	{  if(count($numbers)!=0){
		$mean = array_sum($numbers) / sizeof($numbers);
		
		$devs = array();
		foreach($numbers as $num) {
			$devs[] = pow($num - $mean, 2);
		}
		
		$standard_deviation = @sqrt(array_sum($devs) / (sizeof($devs) -1));
		return @number_format($standard_deviation, 2);

	} else {return 0;}
        }
	
	function getVariance($numbers=array())
	{      if(count($numbers)!=0){
		$mean = array_sum($numbers) / sizeof($numbers);
		
		$devs = array();
		foreach($numbers as $num) {
			$devs[] = pow($num - $mean, 2);
		}
		
		@$standard_deviation = array_sum($devs) / (sizeof($devs) -1);
		return @number_format($standard_deviation, 2);

	} else { return 0;}
        }

	function limitWords($string, $word_limit) {
		$words = explode(' ', $string);
		return implode(' ', array_slice($words, 0, $word_limit))."...";
	}
	
	function limitChar($str, $limit)
	{
		if ( strlen( $str ) > $limit ) 
		{
			$str = substr( $str , 0 , $limit ) ."..";
		}
		return $str;
	}

	
}


?>