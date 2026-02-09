<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
</head>
<body>


<style>

</style>

<div id="page-content">
<div style="width: 1170px;margin-right: auto;margin-left: auto;">
	<h2 style="font-size: 30px; margin: 10px; color: red;">
		Bordered Table
	</h2>
	
	<p style="margin: 0 0 10px;">
		The .table-bordered class adds borders to a table:
	</p>            
	
	<table style="width: 100%;max-width: 100%;margin-bottom: 20px;background-color: transparent;">
		<thead>
		<tr>
			<th style="padding: 8px;border: 1px solid black;">Firstname</th>
			<th style="padding: 8px;border: 1px solid black;">Lastname</th>
			<th style="padding: 8px;border: 1px solid black;">Email</th>
		</tr>
		</thead>
		
		<tbody>	            
		<tr style="border-top: 1px solid #ddd;">
			<td style="padding: 8px;line-height: 1.42857143;border: 1px solid #ddd;">
				John
			</td>
			<td style="padding: 8px;line-height: 1.42857143;border: 1px solid #ddd;">
				Doe
			</td>
			<td style="padding: 8px;line-height: 1.42857143;border: 1px solid #ddd;">
				john@example.com
			</td>
		</tr>

		<tr style="border-top: 1px solid #ddd;">
			<td style="padding: 8px;line-height: 1.42857143;border: 1px solid #ddd;">
				John
			</td>
			<td style="padding: 8px;line-height: 1.42857143;border: 1px solid #ddd;">
				Doe
			</td>
			<td style="padding: 8px;line-height: 1.42857143;border: 1px solid #ddd;">
				john@example.com
			</td>
		</tr>	      
		</tbody>
	</table>
</div>
</div>
</body>
</html>


<a class="word-export" href="javascript:void(0)"> Export as .doc </a> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script src="FileSaver.js"></script> 
<script src="jquery.wordexport.js"></script> 
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("a.word-export").click(function(event) {
            $("#page-content").wordExport();
        });
    });
</script>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>