

jQuery(document).ready(function(jQuery) {
    jQuery('.meta-box-sortables').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.hndle'
    });
});
jQuery(document).ready(function(jQuery) {
    var correctpostJournals = 0;
    jQuery(init);

    function init() {
        jQuery(".ui-draggable-handle").draggable({
            containment: '#content',
            stack: '.postJournalPile div',
            cursor: 'move',
			
            revert: true
        });
        jQuery(".ui-droppable").droppable({
            accept: '.postJournalPile div',
            hoverClass: 'hovered',
            drop: handlepostJournalDrop // funzione che viene chiamata al drop
        });
        jQuery(".ui-draggable-order-article").draggable({
            containment: '#content',
            stack: '#published-area div',
            cursor: 'move',
			//drag: function(){alert ("check 03"); },
			// drop: function(){alert ("check 03"); },
            revert: true
        });
        jQuery(".ui-droppable-order-article").droppable({
            accept: '#no-published-posts div , #no-published-articles div',
            hoverClass: 'hovered',
            drop: handlepostfrontpageorderDrop // funzione che viene chiamata al drop
        });
    }
});

 


function handlepostfrontpageorderDrop(event, ui) {
    
    ui.draggable.addClass('correct');
    jQuery(ui.draggable).detach().css({
        top: 0,
        left: 0
    }).appendTo(this);
    ui.draggable.draggable('disable');
    ui.draggable.draggable('option', 'revert', false);
    ui.draggable.append(
        '<a class="WPJournal-button btnBack"><span class=" dashicons dashicons-redo"></span></a>'
    );
		 
		 // FOR EDIT
		 if 	(jQuery ("#status_WPjournal").val() == 'publish'){
														if(!jQuery ("#status_WPjournal").is(':visible')) {
																jQuery ("#final-update").fadeIn();
														}
								 						if(!jQuery ("WPjournal-advise-update").is(':visible')) {
																jQuery ("#WPjournal-advise-update").fadeIn();
														}
														jQuery ("#update_WPJournal").removeAttr('disabled');
														
								   }
	
};

function handlepostJournalDrop(event, ui) {
	// handles drop
    jQuery("#area_check").fadeOut().removeClass("area_check_active");
	
	jQuery("#final-save").fadeOut();
    ui.draggable.addClass('correct');
    jQuery(ui.draggable).detach().css({
        top: 0,
        left: 0
    }).appendTo(this);
    ui.draggable.draggable('disable');
    ui.draggable.draggable('option', 'revert', false);
    ui.draggable.append(
        '<a class="WPJournal-button btnDels"><span class=" dashicons dashicons-redo"></span>undo</a>'
    );
    jQuery(this).droppable('disable');
    jQuery.each(jQuery('#postJournalSlots'), function(i, menabo_art) {
        jQuery("#published-area").empty();
        jQuery('.block-menabo', menabo_art).each(function() {
            var currentId = jQuery(this).attr('id');
            var Id_selected = currentId.replace(
                'postJournal', '');
            var currentArea = jQuery(this).parent().attr(
                'id');
            var articletitle = jQuery(this).find(
                ".article-title").html();
            jQuery("#id_article_selected" + Id_selected).fadeOut()
                .addClass('chosen-post');
            jQuery("#published-area").append(
                "<div class='correct sortable-article-block no-removable' id='id_article_selected" +
                Id_selected + "'>" + articletitle +
                "</div>");
            var conta = jQuery(
                "#postJournalSlots .ui-droppable-disabled"
            ).length;
        });
    });
    if (jQuery("#postJournalSlots .ui-droppable").length == jQuery("#postJournalSlots .ui-droppable-disabled").length) {
        // All posts were placed in menabo

		

		
       
            
        var postArray = [];
        jQuery('.ui-droppable-disabled > .block-menabo').each(function() {
            var id_post = jQuery(this).prop('id');
            postArray.push({
                id_post: id_post.replace("postJournal", ""),
                area: jQuery(this).parent().prop('id')
            });
        });
        jQuery('input#frontpage-order').val(JSON.stringify(postArray));
		
        jQuery('#area_small_warning').fadeOut();
        
		
		
		
		if (jQuery("#hidden_id_WPjournal").val() != ""){
			
			var aTag = jQuery("#ancora");
					jQuery('html,body').animate({
						scrollTop: aTag.offset().top,
						// marginTop: '50px' 
					}, 'slow');
				jQuery("#area_load").css('background', '#D9D9D9').slideDown('fast');	
				jQuery("#area_load").slideUp('fast');		
				jQuery("#area_check").addClass("area_check_active").slideDown('slow');
				 	 			// Once we have completed the layout of the newspaper we check if we are in "edit" mode. 
								// If yes we activate the "Update" button
								// FOR EDIT	
								   if 	(jQuery ("#status_WPjournal").val() == 'publish'){
														if(!jQuery ("#status_WPjournal").is(':visible')) {
																jQuery ("#final-update").fadeIn();
														}
								 
														jQuery ("#update_WPJournal").removeAttr('disabled');
														
								   }
			 
				jQuery("#wpjournal-draft").attr('target', '_blank');
				jQuery("#wpjournal-draft").attr("href", jQuery("#hidden_url_draft").val());
				
				
				
				var post_id = jQuery("#hidden_id_WPjournal").val();
				
				
				var Journalname = jQuery("#nome_WPJournal_nuova_WPJournal").val();
					var issue = jQuery("#numero_WPJournal_nuova_WPJournal").val();
					var year = jQuery("#anno_WPJournal_nuova_WPJournal").val();
					var info = jQuery("#voci_WPJournal_nuova_WPJournal").val();
					var check_status = jQuery(this).prop('id');
					if (check_status == "wpjournal-draft"){ var status = "draft"; }else{ var status = "publish"; }
					var headerimage = jQuery("#upload_image_1").val();
					var chosenlayout = jQuery("#chosenlayout").val();
					var frontpageorder = jQuery("#frontpage-order").val();
					var postArray = [];
					jQuery('#published-area > .correct').each(function() {
						var id_posts = jQuery(this).prop('id');
						postArray.push(id_posts.replace( "id_article_selected", ""));
					});
				 
					jQuery.ajax({
						url: ajaxurl,
						data: {
							'action': 'WPJournal_save_data', // richiama la funzione di WP x il salvataggio
							'chosenlayout': chosenlayout,
							'Journalname': Journalname,
							'issue': issue,
							'year': year,
							'info': info,
							'status': 'draft',
							'post_id': post_id,
							'headerimage': headerimage,
							'frontpageorder': JSON.parse(frontpageorder),
							'postArray': postArray
						},
						success: function(risultato) {
					
								jQuery("#area_load").slideUp('fast');		
								
								
										 
								 
		 						
 								var obj = jQuery.parseJSON( risultato );	 
								
								jQuery("#wpjournal-draft").attr('target', '_blank');
								 
			 					jQuery("#wpjournal-draft").attr("href", obj.permalink);
								jQuery("#hidden_id_WPjournal").val(obj.post_id);
								jQuery("#hidden_url_draft").val(obj.permalink);
								
								// Once we have completed the layout of the newspaper we check if we are in "edit" mode. 
								// If yes we activate the "Update" button
								// FOR EDIT	
								   if 	(jQuery ("#status_WPjournal").val() == 'publish'){
									   					jQuery("#WPJournal-advise").remove();
														if(!jQuery ("#status_WPjournal").is(':visible')) {
																jQuery ("#final-update").fadeIn();
														}
								 
														jQuery("#update_WPJournal").removeAttr('disabled');
														jQuery("#WPJournal-edit-advise").fadeIn();
														jQuery("#area_check").addClass("area_check_active").slideDown('slow');
														jQuery("#WPjournal-advise-update").fadeOut();
														jQuery("#final-update").fadeOut();
														
								   }else{
									   jQuery("#area_check").addClass("area_check_active").slideDown('slow');
									   	jQuery('#next-inside-pages').fadeIn("fast");
								   }
 							 
            },
            error: function(errorThrown) {
			 
                console.log(errorThrown);
            }
		 });
				
				
				
			
		}else{
		
		//////////////////
		// SAVE DRAFT 
		//////////////////
		 
					var aTag = jQuery("#ancora");
								jQuery('html,body').animate({
									scrollTop: aTag.offset().top,
									// marginTop: '50px' 
								}, 'slow');
					jQuery("#area_load").css('background', '#D9D9D9').slideDown('fast');		
				 
					var Journalname = jQuery(
						"#nome_WPJournal_nuova_WPJournal").val();
					var issue = jQuery("#numero_WPJournal_nuova_WPJournal")
						.val();
					var year = jQuery("#anno_WPJournal_nuova_WPJournal").val();
					var info = jQuery("#voci_WPJournal_nuova_WPJournal").val();
					var check_status = jQuery(this).prop('id');
					if (check_status == "wpjournal-draft"){ var status = "draft"; }else{ var status = "publish"; }
					var headerimage = jQuery("#upload_image_1").val();
					var chosenlayout = jQuery("#chosenlayout").val();
					var frontpageorder = jQuery("#frontpage-order").val();
					var postArray = [];
					jQuery('#published-area > .correct').each(function() {
						var id_posts = jQuery(this).prop('id');
						postArray.push(id_posts.replace( "id_article_selected", ""));
					});
					jQuery.ajax({
						url: ajaxurl,
						data: {
							'action': 'WPJournal_save_data', // richiama la funzione di WP x il salvataggio
							'chosenlayout': chosenlayout,
							'Journalname': Journalname,
							'issue': issue,
							'year': year,
							'info': info,
							'status': 'draft',
							'post_id': '',
							'headerimage': headerimage,
							'frontpageorder': JSON.parse(frontpageorder),
							'postArray': postArray
						},
						success: function(risultato) {
					
								jQuery("#area_load").slideUp('fast');		
								
								jQuery("#area_check").addClass("area_check_active").slideDown('slow');
								//// IS IT USEFULL ?	 
								// FOR EDIT	
								if 	(jQuery ("#status_WPjournal").val() == 'publish'){
										if(!jQuery ("#status_WPjournal").is(':visible')) {
												jQuery ("#final-update").fadeIn();
										}
								
										jQuery ("#update_WPJournal").removeAttr('disabled');
										
								}
								var obj = jQuery.parseJSON( risultato );	 
								jQuery("#wpjournal-draft").attr('target', '_blank');
								 
								jQuery("#wpjournal-draft").attr("href", obj.permalink);
								jQuery("#hidden_id_WPjournal").val(obj.post_id);
								jQuery("#hidden_url_draft").val(obj.permalink);
								
								 jQuery('#next-inside-pages').fadeIn("fast");
							 
					 
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    	//////////////////
		// END SAVE DRAFT 
		//////////////////
		
		}
		
		
	 
		
		
    } else {
        
		
		 
		jQuery('#area_small_warning').html(
            '<p class="small_warning">Place a post for each area.</p>');
        jQuery('input#frontpage-order').val();
        jQuery('#next-inside-pages').fadeOut("fast");
    }
};
jQuery(document).ready(function(jQuery) {
    jQuery(function() {
		// .sortable allows the published area to be sortable
		// Article sort on summary, check if we are in "edit mode"
        jQuery("#published-area").sortable(
				{
					change: function( event, ui ) { 
						// keep event and ui for future uses
						// FOR EDIT
						 if 	(jQuery ("#status_WPjournal").val() == 'publish'){
														if(!jQuery ("#status_WPjournal").is(':visible')) {
																jQuery ("#final-update").fadeIn();
														}
								 						if(!jQuery ("WPjournal-advise-update").is(':visible')) {
																jQuery ("#WPjournal-advise-update").fadeIn();
														}
														jQuery ("#update_WPJournal").removeAttr('disabled');
														
								   }
					}
				}	
			);
        jQuery("#published-area").disableSelection();
    });
    jQuery("body").delegate('.block_layout', "click", function(e) {
        var chosenlayout = jQuery(this).attr("id");
        jQuery("#chosenlayout").val(chosenlayout);
		jQuery(".block_layout").removeClass("layoutchosen");
		jQuery("#"+chosenlayout).addClass("layoutchosen");
		// FOR EDIT	
		   if 	(jQuery ("#status_WPjournal").val() == 'publish'){
								if(!jQuery ("#status_WPjournal").is(':visible')) {
										jQuery ("#final-update").fadeIn();
								}
		 
								jQuery ("#update_WPJournal").removeAttr('disabled');
								
		   }
    });
	
	
    jQuery("body").delegate('.btnDels', "click", function(e) {
        e.preventDefault();
        var questo = jQuery(this);
        var identificativo = jQuery(this).parent().attr('id');
		
		
        var area = jQuery(this).parent().parent().attr('id');
        var origin = jQuery(this).parent().attr('data-origin');
	  
		var Id_selected = identificativo.replace('postJournal','');
	 
	   // Post in summary
	   jQuery("#no-published-posts #id_article_selected" + Id_selected).fadeIn().removeClass('chosen-post');
		 
       jQuery('#next-inside-pages').fadeOut("fast");
        if (typeof area != 'undefined') {
            jQuery(this).parent().clone().removeClass(
                "ui-draggable-dragging correct ui-draggable-disabled"
            ).fadeIn("slow").appendTo("#" + origin).draggable({
                containment: '#content',
                stack: '.postJournalPile div',
                cursor: 'move',
                revert: true
            }).find(".btnDels").remove();
			jQuery("#final-update").fadeOut();
            jQuery(this).parent().parent().droppable("option",
                "disabled", false);
            questo.parent('div').remove();
            jQuery("#postJournalSlots").remove(identificativo);
            jQuery.each(jQuery('#postJournalSlots'), function(i,
                menabo_art) {
                jQuery('.block-menabo', menabo_art).each(
                    function() {
                        var currentId = jQuery(this)
                            .attr('id');
                        var Id_selected = currentId
                            .replace('postJournal',
                                '');
                        var currentArea = jQuery(
                            this).parent().attr(
                            'id');
                        jQuery("#area_check").fadeOut().removeClass("area_check_active");
					    
                    });
            });
        }
    });
    jQuery("body").delegate('.btnBack', "click", function(e) {
        e.preventDefault();
		 
		
		// FOR EDIT
		 if 	(jQuery ("#status_WPjournal").val() == 'publish'){
														if(!jQuery ("#status_WPjournal").is(':visible')) {
																jQuery ("#final-update").fadeIn();
														}
								 						if(!jQuery ("WPjournal-advise-update").is(':visible')) {
																jQuery ("#WPjournal-advise-update").fadeIn();
														}
														jQuery ("#update_WPJournal").removeAttr('disabled');
														
								   }
		
		
        var questo = jQuery(this);
        var identificativo = jQuery(this).parent().attr('id');
        var area = jQuery(this).parent().parent().attr('id');
        var origin = jQuery(this).parent().attr('data-origin');
        if (typeof area != 'undefined') {
			 
            jQuery(this).parent().clone().removeClass(
                "ui-draggable-dragging correct ui-draggable-disabled"
            ).fadeIn("slow").appendTo("#no-published-" +
                origin).draggable({
                containment: '#content',
                stack: '.postJournalPile div',
                cursor: 'move',
                revert: true
            }).find(".btnBack").remove();
            jQuery(this).parent().parent().droppable("option",
                "disabled", false);
            questo.parent('div').remove();
            jQuery("#postJournalSlots").remove(identificativo);
        }
    });
});

