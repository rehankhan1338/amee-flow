<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8" align="center">
    <img src="<?php echo base_url().'assets/frontend/images/tips-logo.png';?>" alt="" class="img-fluid mb-5 img-responsive" />
  </div>
  <div class="col-md-2"></div>
</div>
<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p class="mb-0">Copyright &copy; 2010 - <?php echo date('Y');?> Assessment Made Easy Everyday (AMEE). All rights reserved.</p>
    </div>
</footer>     

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">About AMEE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="line-height:25px;">
        <h4>Assessment is All About Student Success - Why Choose AMEE?</h4>
        <p><strong>AMEE</strong> is more than just an assessment platform-it's a <em>comprehensive, user-friendly solution</em> designed to simplify and enhance your institution's assessment process. No other platform offers such a seamless, intuitive design that guides users step by step, making assessment more <strong>efficient, accessible,</strong> and <strong>effective</strong> for your entire team.</p>
        <h4 class="mt-2">How AMEE Works:</h4>
        <p>AMEE starts by evaluating your organization's <strong>assessment readiness</strong>:</p>
            <ul>
            <li>Do you have clearly defined <strong>goals, objectives, and learning outcomes</strong>?</li>
            <li>Are your <strong>learning outcomes aligned</strong> with core competencies?</li>
            <li> Is there a structured <strong>assessment plan or rotation schedule</strong> in place?</li>
        </ul>
        <p>Once these foundations are established, AMEE provides <strong>guided navigation</strong> through every step-helping you build a robust assessment plan, streamline data collection, and generate <strong>real-time insights</strong> for continuous improvement.</p>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip({ html: true });
    feather.replace();
});	
</script>
</body>
</html>