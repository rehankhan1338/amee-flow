<?php 
		$sel = mysql_query('select * from hh_tbl_registration');
		while($fet = mysql_fetch_array($sel)){
	?>
    	<tr>
        	<td align="center"><?php echo $fet['first_name'].' '.$fet['last_name']; ?></td>
            <td align="center"><?php echo $fet['email']; ?></td>
            <td align="center"><?php echo $fet['city']; ?></td>
            <td align="center"><?php echo $fet['phone_number']; ?></td>
            <td align="center">
            
            <a href="index.htm" onClick="return hs.htmlExpand(this , {width:900})" >View</a>
            <div class="highslide-maincontent">
					<span style="color:5c607E;"><h3><?php echo $fet['company_name'];?> </h3> </span><br>
        		</div>
            </td>
            <td align="center">edit</td>
        </tr> 
        <?php
			}
		?>
		
        
<!--popup for view start-->
 
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
 
<!--=====popup end=====-->
