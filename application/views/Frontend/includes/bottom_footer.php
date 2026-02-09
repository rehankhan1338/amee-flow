<div class="footer">
	<div class="container">
    	<div class="row">
        	<div class="col-md-4 col-sm-4" style="padding-top: 15px;">Copyright &copy; 2010 &ndash; <?php echo date('Y');?> AMEE<sup>TM</sup>&copy;, All Rights Reserved.</div>
            <div class="col-md-4 col-sm-4">
            	<a class="foot_logo" href="<?php echo base_url();?>">
            		<img src="<?php echo base_url();?>assets/frontend/img/amee_white.png" alt="AMEE"/>
            	</a>
            </div>
            <div class="col-md-4 col-sm-4" style="padding-top: 15px;">
            	<ul class="foot_links">
					<li><a href="<?php echo base_url();?>terms_conditions">Terms and Conditions</a></li>
                </ul>
            </div>
        </div>
    </div>
</div> 
    


</body>

<script src="<?php echo base_url();?>assets/frontend/js/bootstrap.min.js"></script><!--Bootstrap-->
<script src="<?php echo base_url();?>assets/frontend/js/owl.carousel.js"></script>
<script type="text/javascript">
$(window).scroll(function(){
    if ($(window).scrollTop() >= 60) {
       $('#myHeader').addClass('sticky');
    }
    else {
       $('#myHeader').removeClass('sticky');
    }
});
</script>
<script>
    $(document).ready(function() {
      $("#testi").owlCarousel({

      navigation : false,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true

      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false

      });
    });
    </script>
</html>
