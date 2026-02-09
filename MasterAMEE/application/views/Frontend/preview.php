<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?php echo base_url();?>assets/frontend/images/favicon.png" rel="shortcut icon">
    <title><?php echo $preview_title;?></title>
    <link rel="stylesheet" href="<?php echo base_url().'assets/frontend/survey/css/styleSurvey.css';?>">
</head>
<body class="">
    <div id="preview-banner">
        <div id="preview-actions">
      
           <div id="mobile-view-switch-container" class="">
              <label for="mobile-view-checkbox" ><strong>Mobile View</strong></label>
              <label class="mobile-view-switch">
                <input id="mobile-view-checkbox" checked type="checkbox" class="">
                <span class="mobile-view-slider"></span>
              </label>
          </div>
          
        </div>
      </div>
    <div id="preview-container">
        <div id="desktop-container" class="">
          <iframe id="preview-view" src="<?php echo $previewLnk;?>" scrolling="auto"></iframe>
        </div>
        
          <div id="mobile-container" class="">
            <div id="phone-overlay"></div>
            <div id="phone">
              <div id="inner-phone">
                <iframe height="100%" frameborder="0" id="mobile-preview-view" src="<?php echo $previewLnk;?>" mobile-frame=""></iframe>
              </div>
            </div>
          </div>
        
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script>
          $(document).ready(function(){
            $('#mobile-view-checkbox').change(function(){
                if($(this).is(":checked")) {
                    $('body').removeClass('mobile-inactive');
                    $('#mobile-container').removeClass('hide_mobile');
                    
                } else {
                    $('body').addClass('mobile-inactive');
                    $('#mobile-container').addClass('hide_mobile');
                }
            });
          });
          
      </script>
</body>
</html>