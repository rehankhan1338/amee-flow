/*
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Dynamic Drag and Drop with jQuery and PHP
*/

jQuery(function() {
    jQuery('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = jQuery(this).sortable('toArray').toString();
    		// change order in the database using Ajax
    		
    		//alert(list_sortable);
    		
            jQuery.ajax({
                url: '<?php echo base_url();?>survey/set_order_questions',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                	alert(data);
                    //finished
                }
            });
        }
    }); // fin sortable
});