<div class="clearfix"></div>
<style>
.amee_update .acc_title h2{color: #32415a;font-size: 20px;font-weight: 600;line-height: 22px;letter-spacing: 0.5px; font-family:'Roboto', sans-serif;}
.amee_update .acc_title span{color: #333;}
.amee_update #integration-list {font-family: 'Open Sans', sans-serif;width: 80%;margin: 0 auto;display: table;}
.amee_update #integration-list ul {padding: 0;margin: 20px 0;color: #555;}
.amee_update #integration-list ul > li {list-style: none;border: 1px solid #ddd;display: block;padding: 15px;overflow: hidden;margin:5px 0;}
.amee_update #integration-list ul > li:hover {background: #f3f3f3;}
.amee_update .expand {display: block;text-decoration: none;color: #32415a;cursor: pointer;}
.amee_update #sup{display: table-cell;vertical-align: middle;width: 80%;}
.amee_update .detail a {text-decoration: none;color: #C0392B;border: 1px solid #C0392B;padding: 6px 10px 5px;font-size: 14px;}
.amee_update .detail {margin: 10px 0 10px 0px;display: none;line-height: 22px;height: auto;}
.amee_update .detail span{margin: 0;}
.amee_update .right-arrow {margin-top: 12px;margin-left: 20px;width: 10px;height: 100%;float: right;font-weight: bold;font-size: 20px;}
.amee_update .icon {height: 75px;width: 75px;float: left;margin: 0 15px 0 0;}
.amee_update .london {background: url("http://placehold.it/50x50") top left no-repeat;background-size: cover;}
.amee_update .newyork {background: url("http://placehold.it/50x50") top left no-repeat;background-size: cover;}
.amee_update .paris {background: url("http://placehold.it/50x50") top left no-repeat;background-size: cover;}
</style>
<div id="page_wrapper">
	<div class="container">
	  <div class="row">
		<div class="col-lg-12 amee_update">
			<h1 class="title">AMEE COMMUNITY</h1>
			<div id="integration-list">
				<ul>
					<?php foreach($product_updates_list as $product_update){?>
					<li>
						<a class="expand">
							<div class="right-arrow">+</div>
							<div>
								<h2><?php echo $product_update->title;?></h2>
								<span>Published <?php echo date('M d, Y',$product_update->publish_date);?></span>
							</div>
						</a>
 						<div class="detail">
 							 <?php echo $product_update->body_content;?>
						</div>
					</li>
					<?php } ?>
				 </ul>
			</div> 		
 		</div>
	  </div>
	</div>
</div>
<script type="text/javascript">
$(function() {
  $(".expand").on( "click", function() {
    $(this).next().slideToggle(200);
    $expand = $(this).find(">:first-child");
    
    if($expand.text() == "+") {
      $expand.text("-");
    } else {
      $expand.text("+");
    }
  });
});
</script>