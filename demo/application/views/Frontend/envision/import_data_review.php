<?php include(APPPATH.'views/Frontend/envision/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="box">
 		  	
<div class="box-body">

<script type="text/javascript">

function swap()
{

var arr = [];
var name_array=[];
    var n = jQuery('select').length
	var name='';
	var name1='';

for(i=0;i<n;i++)
  {

  var singleValues = jQuery("#field_name_"+i).val();
  
   arr.push(singleValues);
 
  if(singleValues=="")
  {
  alert("please select all the fields bofore import");
  return false;
  }
 
  }
  var sorted_arr = arr.sort(); // You can define the comparing function here. 
                             // JS by default uses a crappy string compare.
var results = [];

jQuery.each(arr, function(i, el){
    if(jQuery(inArray(el, results) === -1) results.push(el);

	
});

if(results.length!=arr.length)
{
	alert("Sorry, there is two or more same columns are selected");
//jAlert("There is two or more same coloumns are selected",'Alert');
return false;
}
else
{
return true;
}

}

</script>
   
  <?php
		$department_id = $this->session->userdata('dept_id');	
		
		$CI = get_instance();
		$db_subdomain_name=$CI->config->item("subdomain_name").'_'; 
		//ini_set('post_max_size',200000);	
        if(isset($_POST['submit']) && $_POST['submit']=='Import')
      	{
			$date_for_file_name=strtotime(date("Y/m/d H:i:s"));
			 
			/*if(isset($_POST['with_header']) && $_POST['with_header']!=''){
				$with_header=$_POST["with_header"];
			}else{
				$with_header='';
			}*/
			$date=date('d-m-Y');
			$handle = fopen($_FILES['file']['tmp_name'],'r');
			$ext=explode(".",str_replace(' ','_',$_FILES['file']['name']));
			$extension = end($ext);
			$real_file_name_without_path=$db_subdomain_name.''.$date_for_file_name.'.'.$extension;
			
			//$real_file_name="assets/upload/import_files/" .$db_subdomain_name.$ext[0].'__'.$date_for_file_name.'.'.$extension;
			$real_file_name="assets/upload/import_files/" .$db_subdomain_name.''.$date_for_file_name.'.'.$extension;
			if($extension=="xlsx" or $extension=="xls" or $extension=="csv") 
			{			
//if file is xls or xlsx by PHPexcel
	
/*print get_include_path()."n<br>";
$path = "/public_html/one2onescheduler/WFG/admin";
set_include_path(get_include_path().PATH_SEPARATOR.$path);
print get_include_path()."n";*/
include(APPPATH.'Classes/PHPExcel/IOFactory.php');
//include 'Classes/PHPExcel/IOFactory.php';


 move_uploaded_file($_FILES['file']['tmp_name'], $real_file_name);
$inputFileName = $real_file_name;
if($extension=="xlsx")
{
$objReader = new PHPExcel_Reader_Excel2007();//this is for xlsx files
}
else if($extension=="csv")
{
 $objReader = new PHPExcel_Reader_CSV(); 
}
else
{
$objReader = new PHPExcel_Reader_Excel5();//this is for xls files
}

//	$objReader = new PHPExcel_Reader_Excel2003XML();
//	$objReader = new PHPExcel_Reader_OOCalc();
//	$objReader = new PHPExcel_Reader_SYLK();
//	$objReader = new PHPExcel_Reader_Gnumeric();

$objPHPExcel = $objReader->load($inputFileName);


$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
 $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

//echo $highestRow = $sheetData->getHighestRow(); // set fourth parameter as "true" for getting actual indexes like 'A','B' etc....
 

$count_rows=count($sheetData);

 
	          $data=$sheetData;
				$w=0;
				$_SESSION['tmp']=$data;
				///////////////loop for row
				for($h=0;$h<=$count_rows-1;$h++)
				{
					  if (!array_filter($data[$h])) 
					{
					   echo  $w++;
					}	
				
				}	
	 
 
	$data1=$data[$w];
 
    $count=count($data1);
 
		?>
        <div class="contenttitle2 nomargintop"><h3>Step 2 of 2 - Match and Import</h3></div> 
        <div class="col-md-12">
<form name="submit" id="submit" action="<?php echo base_url();?>envision/import_data_proposed_soc" method="post">

	<input type="hidden" name="count" value="<?php echo $count;?>" id="count">
	<input type="hidden" name="real_file_name_without_path" value="<?php echo $real_file_name_without_path;?>" id="real_file_name_without_path">
	<div class="table-responsive">
		<table  class="table table-hover table-bordered" >
			<tr>
				<th style="background-color:#CCCCCC" width="10%">Row Number </th>
 				<?php for($j=0;$j<=$count-1;$j++) {
				if($j==0){?>
				<th width="20%"><?php echo $data1[$j];?></th>
				<?php }else{?>
				<th width="20%"><?php echo $data1[$j];?></th>
				<?php } } ?>  
			</tr>
    <?php	
		
		$default_username = $this->db->username;
		$default_password = $this->db->password;
		$default_database = $this->db->database;
		$default_hostname = $this->db->hostname;
		
		$default_con=mysqli_connect("$default_hostname","$default_username","$default_password","$default_database");
 
  		mysqli_query($default_con,'TRUNCATE TABLE '.$db_subdomain_name.'temp_import_table');
		mysqli_query($default_con,'TRUNCATE TABLE '.$db_subdomain_name.'import_error_log');
	
				$r=1;
				/*if($with_header=="on")
				{
				$row=0;
				}
				else
				{
				$row=1;
				}*/
				$row=0;	
				for($h=$w;$h<=$count_rows-1;$h++)
				{
		 	//echo "<pre>";print_r($data[$h]);
				if($row>=1)
				{
				//print_r($data[$h]);
				echo "<tr>";
				echo '<td style="background-color:#CCCCCC"><input type="hidden" name="sheet_row_no[]" value="'.$r.'">'.$r.'</td>';
				
				for($j=0;$j<1;$j++)
				{
				?>
				
				<td> <?php 
				
				 ///////////append
			$ss=$j+1;
			//$index_value_get_semester_year = $data[$h][$index_of_semeseter_year]; 
			// $field_name="col_".$ss;
			// $field_name="course";
			// $data=$_POST["data_".$i];
			$data_count=count($data);
 			
			//$create = mysql_query("CREATE TABLE IF NOT EXISTS  ".$db_subdomain_name."temp_import_table (ID INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(ID), course VARCHAR(255), semester_data VARCHAR(255), term VARCHAR(255), year VARCHAR(255))");
			
			$col_1=mysqli_real_escape_string($default_con,$data[$h][$j]);
			$col_2=mysqli_real_escape_string($default_con,$data[$h][$j+1]);
			$col_3=mysqli_real_escape_string($default_con,$data[$h][$j+2]);
			$col_4=mysqli_real_escape_string($default_con,$data[$h][$j+3]);
			//$semester_data=mysqli_real_escape_string($index_value_get_semester_year);
			$sql_query = "INSERT INTO ".$db_subdomain_name."temp_import_table(department_id,col_1,col_2,col_3,col_4) VALUES ('$department_id','$col_1','$col_2','$col_3','$col_4')";
			mysqli_query($default_con,$sql_query); 		
			
 				////////////append
						//print_r($data);
						?><input type="hidden" value="<?php echo $row;?>" name="count_row" id="count_row"><input type="hidden" name="data_<?php echo $j;?>[]" value="<?php echo $data[$h][$j];?>"><?php echo $data[$h][$j];?></td> 
						<td><?php echo $col_2;?></td>
						<td><?php echo $col_3;?></td>
						<td><?php echo $col_4;?></td>
				<?php 
				}
				 
				}
				$row++;
				$r++;
				
				echo "</tr>";	
				
				}
				
				 
						
	}
?>
<tr><td colspan="11" align="center"><input type="submit" name="submit" id="submit" value="Ok" class="btn btn-primary" onclick="return swap()" ></td></tr>
</table>
</div>
</form></div>
<?php
 
	//$path = dirname(dirname(__DIR__)).'/assets/upload/import_files/'.$real_file_name_without_path;
	//$path=str_replace('application/views/Backend/','',$path);
	//unlink($path);
	
 }else{ redirect('department/envision/action2/upload'); ?>

<?php } ?>
</div>
</div>
<div class="clearfix"></div><br />
<div class="box-footer">
	<div class="pull-right">
		<a href="<?php echo base_url();?>department/envision/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/envision/action3" class="btn btn-info">Next Action3 >></a>
		 
	</div>
</div> 
