<div class="bg-light priceCalSec">
  <div class="text-center">
    <h2 class="my-3"> <strong>Pricing Calculator</strong></h2>
    <h5>Calculate your estimated annual cost for AMEE Flow</h5>
  </div>
  <div class="calculator mt-4 mb-5">
    <div class="form-group">
      <label for="pm">Project Managers <span data-bs-toggle="tooltip" data-bs-placement="top" title="Create and oversee assessment projects, assign tasks, and manage timelines and reporting."><i class="icon-sm"  data-feather="info"></i></span> </label>
      <input type="number" id="pm" value="0" min="0">
    </div>
    <div class="form-group">
      <label for="ae">Area Experts <span data-bs-toggle="tooltip" data-bs-placement="top" title="Carry out assigned tasks."><i class="icon-sm"  data-feather="info"></i></span></label>
      <input type="number" id="ae" value="0" min="0">
    </div>
    <div class="form-group">
      <label for="ap">Approvers <span data-bs-toggle="tooltip" data-bs-placement="top" title="Review submitted work, provide formal approvals, and provide feedback if necessary."><i class="icon-sm"  data-feather="info"></i></span></label>
      <input type="number" id="ap" value="0" min="0">
    </div>
    <div class="total row mx-0">
      <div class="col-6" style="padding-top: 5px;">Estimated Total:</div>
      <div class="col-6 text-right">
        <label id="totalCost" style="float:right;">$0</label>
      </div>
    </div>

  <div class="row mx-0">
    <div class="col-12 fs16 lh25 mt-3">
      If you are interested in this product, please get in touch with customersupport@assessmentmadeeasy.com
    </div>
  </div>

  </div>
</div> 
  <script>
    const pmInput = document.getElementById("pm");
    const aeInput = document.getElementById("ae");
    const apInput = document.getElementById("ap");
    const totalCost = document.getElementById("totalCost");
 
    function calculateTotal() {
      const pm = parseInt(pmInput.value) || 0;
      const ae = parseInt(aeInput.value) || 0;
      const ap = parseInt(apInput.value) || 0;
 
      const total = (pm * 250) + (ae * 100) + (ap * 50);
      totalCost.textContent = `$${total.toLocaleString()}`;
    }
 
    pmInput.addEventListener("input", calculateTotal);
    aeInput.addEventListener("input", calculateTotal);
    apInput.addEventListener("input", calculateTotal);
</script>