 <section class="footer">
  	<div class="container">
    	<div class="col-sm-7 col-xs-6">
        	<ul class="foot_links">
            	<li><a href="<?php echo base_url();?>tips">Tips</a></li>
                <li><a href="<?php echo base_url();?>prices">Prices</a></li>
                <li><a href="<?php echo base_url();?>about_us">About Us</a></li>
                <li><a href="<?php echo base_url();?>contact_us">Contact Us</a></li>
            </ul>
        </div>
        <div class="col-sm-5 col-xs-6">
        	<div class="address">
            North Little Rock, AR<br/>
            support@socbuilder.com <br/> 818-403-7558
            </div>
        </div>
    </div>
  </section> 
  
  <section class="copy">
  	<div class="container">
    	<div class="col-sm-6">
        	&copy; SOC Builders &ndash; All Right Reserved
        </div>
        <div class="col-sm-6">
        	<ul class="social_links">
            	<li><a class="fb" href="#"><i class="fa fa-facebook-f"></i></a></li>
                <li><a class="twtr" href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                <li><a class="vi" href="#"><i class="fa fa-vimeo"></i></a></li>
                <li><a class="gp" href="#"><i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div>
    </div>
  </section> 
    


</body>

<script src="<?php echo base_url();?>assets/frontend/js/owl.carousel.js"></script>
<script src="<?php echo base_url();?>assets/frontend/js/bootstrap-select.js"></script>
<script>
$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
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
