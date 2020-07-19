jQuery(document).ready(function() {
	if(jQuery('.mtm-news-listing').find('.f3-widget-paginator li.next a').length<=0){
	    jQuery('#lazy-loader').fadeOut();
	}
	jQuery("#lazy-loader").click(function() {
			var ajaxUrl = jQuery(".mtm-news-listing .f3-widget-paginator li.next a").attr("href");
	        var itemlength = jQuery('.mtm-news-listing .mtm-news-teaser .mtm-news-item').length;
	        console.log(ajaxUrl+" "+itemlength);

	        jQuery.ajax({
	                    type: "GET",
	                    url: ajaxUrl,
	                    beforeSend: function() {
	                    	jQuery("#loaderimg-mtm").show();
	                    },
	                    success: function(a) {
	                        var d = jQuery(a),
	                            e = jQuery(d).find(".mtm-news-listing .mtm-news-teaser").html();
	    	                    jQuery("#loaderimg-mtm").hide();
	    	                    // console.log(e);
	                            jQuery(e).insertAfter(".mtm-news-listing .mtm-news-teaser .mtm-news-item:nth-child(" + itemlength + ")");
	                            if(jQuery(d).find(".mtm-news-listing .f3-widget-paginator li.next a").length>0){
	                                jQuery(".mtm-news-listing .f3-widget-paginator li.next a").attr("href", jQuery(d).find(".mtm-news-listing .f3-widget-paginator li.next a").attr("href"));
	                            }
	                            else{
	                                jQuery('#lazy-loader').fadeOut();
	                            }
	                    }
	     });
	});

	jQuery(".mtm-news-list-datepicker").datepicker({
            prevText: "&#x3c;zurück",
            prevStatus: "",
            prevJumpText: "&#x3c;&#x3c;",
            prevJumpStatus: "",
            nextText: "Vor&#x3e;",
            nextStatus: "",
            nextJumpText: "&#x3e;&#x3e;",
            nextJumpStatus: "",
            currentText: "heute",
            currentStatus: "",
            todayText: "heute",
            todayStatus: "",
            clearText: "-",
            clearStatus: "",
            closeText: "schließen",
            closeStatus: "",
            monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
            monthNamesShort: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
            dayNames: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
            dayNamesShort: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
            dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
            changeMonth: 0,
            changeYear: 0,
            dateFormat: "dd.mm.yy",
            onSelect: function(dateText) {
			      //alert("Selected date: " + dateText + ", Current Selected Value= " + this.value);
			      jQuery('#mtm-search-title').val(''); 
			      jQuery('#mtm-search-date').val(dateText); 
			      jQuery(this).change();
		    }
        }).on("change", function() {
   		 	jQuery('#mtm-search-form').submit(); 
 		 });



        	
});

