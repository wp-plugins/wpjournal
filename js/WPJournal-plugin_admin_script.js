jQuery(document).ready(function(jQuery) {
    jQuery("body").delegate("#nuova_WPJournal", "click", function(e) {
        e.preventDefault();
        jQuery(".WPJournal-step").removeClass("active");
		jQuery(".WPJournal-step").removeClass("custom_selected");
        jQuery("#uno").addClass("done");
        jQuery("#due").addClass("active custom_selected");
        if (jQuery("#nome_WPJournal_nuova_WPJournal").val().length ===0) {
            jQuery("#area_alert").fadeIn().html(
                "Insert a name for the Journal");
        } else {
            jQuery("#area_cancel").fadeIn('fast');
            jQuery("#area_alert").fadeOut();
            jQuery("#base-settings").slideUp("fast", function() {});
            jQuery("#nuovo_layout").slideDown("slow", function() {});
        }
    });
    jQuery("body").delegate(".block_layout", "click", function(e) {
        e.preventDefault();
        jQuery(".WPJournal-step").removeClass("active");
		jQuery(".WPJournal-step").removeClass("custom_selected");
        jQuery("#due").addClass("done");
        jQuery("#tre").addClass("active custom_selected");
 
        jQuery("#nuovo_layout").slideUp("fast", function() {});
        jQuery("#base-settings").slideUp("fast", function() {});
        jQuery("#layout_scelto").slideDown("slow", function() {});
    });
    jQuery("body").delegate(".edit-menabo", "click", function(e) {
        var getpostid = jQuery(this).parent().attr('id');
        getpostid = getpostid.replace("postJournal", "");
        jQuery("#refresh-id-" + getpostid).html(
            '<a class="WPJournal-button this-title-refresh"><span class="dashicons dashicons-update"></span> Refresh</a>'
        );
    });
    jQuery("body").delegate(".this-title-refresh", "click", function(e) {
        e.preventDefault();
        var getpostid = jQuery(this).parent().attr('id');
        getpostid = getpostid.replace("refresh-id-", "");
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'wpjournal_this_title_refresh',
                'getpostid': getpostid
            },
            success: function(risultato) {
                jQuery("#postJournal" + getpostid +
                        ">.article-title").fadeIn()
                    .html(risultato);
                jQuery("#refresh-id-" + getpostid +
                    ">.this-title-refresh").fadeOut();
                jQuery("#id_article_selected" +
                    getpostid +
                    ">.article-title").html(
                    risultato);
                jQuery("#selected-postJournal" +
                    getpostid +
                    ">.article-title").html(
                    risultato);
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    });
    jQuery("body").delegate(".inside-articles", "click", function(e) {
        e.preventDefault();
        jQuery(".WPJournal-step").removeClass("active");
		jQuery(".WPJournal-step").removeClass("custom_selected");
        jQuery("#tre").addClass("done");
        jQuery("#quattro").addClass("custom_selected active");
        jQuery('html,body').animate({
            scrollTop: 0
        }, 'slow');
        jQuery("#layout_scelto").slideUp("fast", function() {});
        jQuery("#inside-pages").slideDown("slow", function() {});
        
			// FOR EDIT
			if 	(jQuery ("#status_WPjournal").val() == 'publish'){
				if(!jQuery ("#status_WPjournal").is(':visible')) {
						jQuery ("#final-update").fadeIn();
				}
				jQuery ("#update_WPJournal").removeAttr('disabled');
			}else{
				jQuery("#final-save").fadeIn("slow");
				jQuery('#salva_WPJournal_nuova_WPJournal').removeAttr('disabled');
			}
    });
	
 
 
 
 
 
    jQuery("body").delegate(".salva_WPJournal", "click", function(e) {
	 
		
        e.preventDefault();
        jQuery("#cover").css("z-index", "5000").fadeIn("fast"); // per il loading
        var Journalname = jQuery(
            "#nome_WPJournal_nuova_WPJournal").val();
        var issue = jQuery("#numero_WPJournal_nuova_WPJournal")
            .val();
        var year = jQuery("#anno_WPJournal_nuova_WPJournal").val();
        var info = jQuery("#voci_WPJournal_nuova_WPJournal").val();
		 
        var headerimage = jQuery("#upload_image_1").val();
        var chosenlayout = jQuery("#chosenlayout").val();
        var frontpageorder = jQuery("#frontpage-order").val();
        var postArray = [];
        jQuery('#published-area > .correct').each(function() {
            var id_posts = jQuery(this).prop('id');
            postArray.push(id_posts.replace(
                "id_article_selected", ""));
        });
		if (jQuery("#hidden_id_WPjournal").val() != ""){
			var	post_id = jQuery("#hidden_id_WPjournal").val();	
		}else{
			var	post_id = "";	
		}
		
	 
		
		
		
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'WPJournal_save_data',
				'post_id': post_id, 
                'chosenlayout': chosenlayout,
                'Journalname': Journalname,
                'issue': issue,
                'year': year,
                'info': info,
				'status': 'publish',
                'headerimage': headerimage,
                'frontpageorder': JSON.parse(
                    frontpageorder),
                'postArray': postArray
            },
            success: function(risultato) {
				
				   if(risultato.success) {
        				// loop the array, and do whatever you want to do
        			jQuery.each(risultato.result, function(key, value){
            		 		/* silence is golden */
       					 });
    				} else {
        			// alert(data.message); // or whatever...
    				}
				 
				if (risultato == "draft"){
				/* silence is golden */
				}else{
                	location.reload();
				}
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    });
});
jQuery(document).ready(function() {
    var custom_uploader;
    jQuery("body").delegate('.WPJournal_upload', "click", function(e) {
        e.preventDefault();
        identificativo_destinazione_immagini = jQuery(this).attr(
            "id");
        if (identificativo_destinazione_immagini !=
            'nuova_WPJournal') {
            identificativo_destinazione_immagini =
                identificativo_destinazione_immagini.replace(
                    "nuova_", "");
        }
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Seleziona immagine',
            button: {
                text: 'Seleziona immagine'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var selection = custom_uploader.state().get(
                'selection');
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                var num = 1;
                jQuery("#dest_" +
                    identificativo_destinazione_immagini
                ).append(" <div id=\"entry" +
                    num +
                    "\" class=\"clonedInput unit whole \"><div class=\"blocco-elemento\"><fieldset><label for=\"upload_image\"><div id=\"preview_immagine_" +
                    num +
                    "\" class=\"preview_immagine ui-draggable\" style=\"background-image: url(" +
                    attachment.url +
                    ");\"></div><input id=\"upload_image_" +
                    num +
                    "\" class=\"input_image_field\" type=\"hidden\" name=\"identificativo_image\" value=\"" +
                    attachment.id +
                    "\"></label></fieldset><div id=\"btnDel" +
                    num +
                    "\" class=\"btnDel\" ><div class=\"dashicons dashicons-no remove\"></div>Cancel</div></div></div> "
                );
                jQuery(".WPJournal_upload").fadeOut();
				
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
				
				
            });
        });
        custom_uploader.open();
    });
    jQuery("body").delegate('.btnDel', "click", function(e) {
        if (confirm("Remove the image. Confirm?")) {
            identificativo_WPJournal = jQuery(this).parent().parent()
                .attr("id");
            jQuery("#" + identificativo_WPJournal).fadeOut(
                'fast', function() {
                    jQuery(this).remove();
                    jQuery(".WPJournal_upload").fadeIn();
					
					
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
                });
        }
        return false;
    });
});
jQuery(document).ready(function(jQuery) {
    jQuery(".nessuna_WPJournal_aggiungi").on("click", function(e) {
        jQuery('#contenuti_pg_1 ').hide();
        jQuery('#contenuti_pg_2 ').show();
        jQuery('.neoaccordion__title').addClass('active');
        jQuery('.neoaccordion__title:first-child').removeClass(
            'active');
    });
    jQuery(window).load(function() {
        jQuery('#loading-elenco').fadeOut(500, function() {
            jQuery("#tab-elenco").fadeIn("fast");
        });
    });
    if (jQuery(window).width() > 768) {
        jQuery('.neoaccordion__content:not(:first)').hide();
        jQuery('.neoaccordion__title:first-child').addClass('active');
    } else {
        jQuery('.neoaccordion__content').hide();
    };
    jQuery(".neoaccordion__content").wrapInner(
        "<div class='overflow-scrolling'></div>");
    jQuery('.neoaccordion__title').on('click', function() {
        jQuery('.neoaccordion__content').hide();
        jQuery(this).next().show().prev().addClass('active').siblings()
            .removeClass('active');
    });
    jQuery(window).load(function() {
        jQuery('#loading-elenco').fadeOut(500, function() {
            jQuery("#tab-elenco").fadeIn("fast");
        });
    });
});
jQuery(document).ready(function(jQuery) {
    /* avoids problems with Firefox */
    jQuery("body").delegate("input", "click", function() {
        jQuery(this).focus();
    });
    jQuery.fn.extend({
        preventDisableSelection: function() {
            return this.each(function(i) {
                jQuery(this).bind(
                    'mousedown.ui-disableSelection selectstart.ui-disableSelection',
                    function(e) {
                        e.stopImmediatePropagation();
                    });
            });
        }
    });
    jQuery("body").find("input").preventDisableSelection();
});
jQuery(".show-published-articles").on("click", function(e) {
    e.preventDefault();
    var id_parent = jQuery(this).parent().attr("id");
    jQuery("#" + id_parent).find(".hide:not(.chosen-post)").fadeIn(
        'slow');
    jQuery(this).slideUp('fast');
});
jQuery("#add-menabo-article").on("click", function() {
    jQuery("#new-article-area").html(
        '<div class="update-articles"><span class="dashicons dashicons-update"></span> Refresh</div> '
    );
});

jQuery(".WPJournal_edit").on("click", function(e) {
	
	if (jQuery("#nome_WPJournal_nuova_WPJournal").val().length ===0) {
	aTag = jQuery(".WPJournal_logo_WPJournal");
	jQuery('html,body').animate({
						scrollTop: aTag.offset().top,
						 
					}, 'slow');
    e.preventDefault();
	var id_WPJournal = jQuery(this).attr("id");
	id_WPJournal = id_WPJournal.replace("post_", "");
  	jQuery("#cover").css("z-index", "5000").fadeIn("fast");
	
	
	
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'WPJournal_edit',
				'post_id_edit' : id_WPJournal
                 
            },
            success: function(risultato) {
                 var obj = jQuery.parseJSON( risultato );	 
                	 
					// first
					
					jQuery ("#nome_WPJournal_nuova_WPJournal").val(obj.newstitle);
					jQuery ("#numero_WPJournal_nuova_WPJournal").val(obj.numero);
					jQuery ("#anno_WPJournal_nuova_WPJournal").val(obj.anno);
					jQuery ("#voci_WPJournal_nuova_WPJournal").val(obj.info);
					 
					var completepostArray =  obj.postArray;
					var status_journal = obj.status ;
					 
					jQuery ("#status_WPjournal").val(obj.status);
					if (obj.status == 'publish') {
						
							jQuery ("#final-update").fadeIn();
						}
					
					
					if (obj.image_attributes != null){
						jQuery ("#dest_new").html('<div id="entry1" class="clonedInput unit whole "><div class="blocco-elemento"><fieldset><label for="upload_image"><div id="preview_immagine_1" class="preview_immagine ui-draggable" style="background-image: url('+obj.image_attributes+');"></div><input id="upload_image_1" class="input_image_field" type="hidden" name="identificativo_image" value="'+obj.headerimage+'"></label></fieldset><div id="btnDel1" class="btnDel"><div class="dashicons dashicons-no remove"></div>Cancel</div></div></div>');
						jQuery ("#nuova_new").fadeOut();
					}
					jQuery ("#bottom_step_uno").fadeOut();
					
					// second
					
					jQuery("#chosenlayout").val(obj.chosenlayout);
					jQuery(".block_layout").removeClass("layoutchosen");
					jQuery("#"+obj.chosenlayout).addClass("layoutchosen");
					
					// third
					 
				 
					 
				 
					 var postArray = []; // recreating the post array
					jQuery.each(obj.chosenpostsArray, function(index, value) {
					 
						var id_post = value;
						 jQuery("#no-published-posts #id_article_selected"+id_post+".ui-draggable").remove();
						 jQuery("#no-published-articles #id_article_selected"+id_post+".ui-draggable").remove();
						
					});
					jQuery.each(obj.displacement_array, function(index, value) {
						 		 
								var posizione_layout = index;
    						 
								var id_post = value;
								
								/* postArray.push({
									id_post: id_post,
									area: index
								}); */
								
								// get the title for summary
								var title = jQuery("#postJournal"+id_post+" .article-title").text();
								
								jQuery("#postJournal"+id_post).remove();
								 
								// fourth 
								// Recreate summary
								jQuery("#published-area").append("<div class='correct sortable-article-block no-removable' id='id_article_selected" + id_post + "'>" + title +"</div>");
								
								 jQuery("#no-published-posts #id_article_selected" + id_post).fadeOut().addClass('chosen-post');
								 jQuery("#no-published-articles #id_article_selected" + id_post).fadeOut().addClass('chosen-post');
							   
								
								// end fourth
					}); 
				 
				jQuery("#published-area").append(obj.recreate_summary);
					jQuery.each(obj.recreate_layout, function(index, value) {
						 	 
								var posizione_layout = index;
							 
								var html_layout = value;
 
								jQuery("#"+posizione_layout).droppable( 'disable' );
								jQuery("#"+posizione_layout).append(html_layout);
								
								
					
								
					}); 
					
				 
		 
					// general
				 
					 // publish or draft??? 
					  
				//	jQuery('input#frontpage-order').val(JSON.stringify(postArray));  /// FRONTPAGE ORDER
					jQuery('input#frontpage-order').val(JSON.stringify(obj.frontpageorder));  /// FRONTPAGE ORDER
					jQuery('#hidden_id_WPjournal').val(id_WPJournal);
					jQuery(".WPJournal-step").removeClass("active");
					jQuery("#area_cancel").fadeIn();
					jQuery(".WPJournal-step#uno").addClass("done");
					jQuery(".WPJournal-step#due").addClass("done");
					// Recreating the aspect, with all the fields filled up, we show the tab3 in case of draft, the fourth in case of edit
					if (status_journal == "draft") {
						 
						jQuery(".WPJournal-step#tre").addClass("done").addClass("active").addClass("custom_selected");
						jQuery(".uno").fadeOut();
						jQuery(".tre").fadeIn();
						 
						jQuery("#next-inside-pages").fadeIn();
						jQuery("#area_check").addClass("area_check_active").slideDown('slow');
					}else if (status_journal == "publish") {
						 
						jQuery(".WPJournal-step").removeClass("custom_selected");
						jQuery(".WPJournal-step#tre").addClass("done");
						 
				 
						 jQuery("#area_check").fadeOut().removeClass("area_check_active");
						jQuery(".WPJournal-step#quattro").addClass("done").addClass("custom_selected").addClass("active");
						 
						jQuery(".uno").fadeOut();
						jQuery(".quattro").fadeIn();
					}
					
					
					
					
					 jQuery("#cover").css("z-index", "5000").fadeOut("fast");
					 
            },
            error: function(errorThrown) {
						 jQuery("#cover").css("z-index", "5000").fadeOut("fast");
						console.log(errorThrown);
            }
		});
	
	
	
	
	
		jQuery('#contenuti_pg_1 ').hide();
        jQuery('#contenuti_pg_2 ').show();
        jQuery('.neoaccordion__title').addClass('active');
        jQuery('.neoaccordion__title:first-child').removeClass('active');
		
		
	  }else{
		  
		alert ("First save or cancel the Journal you are working on!");  
	  }
	
});



jQuery(".WPJournal_delete").on("click", function(e) {
    e.preventDefault();
    if (confirm("Are you sure?")) {
        var id_WPJournal = jQuery(this).attr("id");
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'WPJournal_delete',
                'id_to_be_deleted': id_WPJournal
            },
            success: function(risultato) {
              
                jQuery("#" + id_WPJournal).fadeOut();
                jQuery("#cover").css("z-index", "5000").fadeIn(
                    "fast");
                location.reload();
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    }
});


jQuery(".WPJournal_delete_drafts").on("click", function(e) {
    e.preventDefault();
    if (confirm("Are you sure?")) {
		 jQuery("#cover").css("z-index", "5000").fadeIn("fast");
      
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'WPJournal_delete_drafts' 
                 
            },
            success: function(risultato) {
                 
                
               
                location.reload();
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    }
});
jQuery("body").delegate('.cancel-new-Journal', "click", function(e) {
    if (confirm("Delete all data. Are you sure?")) {
        jQuery("#cover").css("z-index", "5000").fadeIn("fast");
		/// DELETE ALSO THE DRAFT
		if (jQuery("#hidden_id_WPjournal").val() != ""){
		var id_WPJournal = jQuery("#hidden_id_WPjournal").val();
		  jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'WPJournal_delete',
                'id_to_be_deleted': id_WPJournal
            },
            success: function(risultato) {
               
                jQuery("#" + id_WPJournal).fadeOut();
                jQuery("#cover").css("z-index", "5000").fadeIn(
                    "fast");
                location.reload();
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
		 
        
		});
       
		}
		 location.reload();
    } 
});
jQuery("body").delegate('#new-article-area', "click", function(e) {
    e.preventDefault();
    jQuery(".update-articles").fadeOut('fast');
    var refresh_postArray = [];
    jQuery('.area-drop > .block-menabo').each(function() {
        var id_posts = jQuery(this).prop('id');
        refresh_postArray.push(id_posts.replace("postJournal",
            ""));
    });
    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': 'WPJournal_refresh_article_area',
            'refresh_postArray': refresh_postArray
        },
        success: function(risultato) {
            jQuery("#article-area").fadeIn('fast').html(
                risultato);
            jQuery(".show-published-articles").fadeIn(
                'fast');
            jQuery(".ui-draggable-handle").draggable({
                containment: '#content',
                stack: '.postJournalPile div',
                cursor: 'move',
                revert: true
            });
            jQuery(".ui-droppable").droppable({
                accept: '.postJournalPile div',
                hoverClass: 'hovered',
                drop: handlepostJournalDrop
            });
            jQuery(".ui-draggable-order-article").draggable({
                containment: '#content',
                stack: '#published-area div',
                cursor: 'move',

                revert: true
            });
            jQuery(".ui-droppable-order-article").droppable({
                accept: '#no-published-posts div , #no-published-articles div',
                hoverClass: 'hovered',
                drop: handlepostfrontpageorderDrop // funzione che viene chiamata al drop
            });
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
});

jQuery("body").delegate(".WPJournal-step.done, .WPJournal-step.active", "click", function(e) {
		
        e.preventDefault();
        var elemento_cliccato = jQuery(this).attr('id');
	 
		
		if (!jQuery("#"+elemento_cliccato).hasClass("custom_selected")) {
				jQuery(".WPJournal-step").removeClass("custom_selected");
				jQuery(".WPJournal-step#"+elemento_cliccato).addClass("custom_selected");
				jQuery('.wizard_WPjournal').slideUp("fast");
				jQuery('.wizard_WPjournal').removeClass("active_wizard_WPJournal"); 	
				jQuery("."+elemento_cliccato ).slideDown("fast").addClass("active_wizard_WPJournal"); 	
		}
		 
    });
	
	
jQuery("body").delegate("#container_wizard", "click", function() {
	
	
	
	var elemento_attivo = jQuery('.WPJournal-step.active').attr('id');
	if (elemento_attivo !='uno'){
		 
		 
		if (!jQuery("."+elemento_attivo).hasClass("active_wizard_WPJournal")) {
			jQuery('.wizard_WPjournal').slideUp("fast");
			jQuery('.wizard_WPjournal').removeClass("active_wizard_WPJournal"); 
			jQuery("."+elemento_attivo ).fadeIn("fast").addClass("active_wizard_WPJournal"); 
			jQuery('.WPJournal-step').removeClass('custom_selected');
			jQuery('#'+elemento_attivo+'.WPJournal-step').addClass('custom_selected');
			
		}
	}
	if (jQuery("#area_check").hasClass("area_check_active")){
		 /* silence is golden */
		}
  });
  

// edit mode: check if an input field is modified

 

jQuery(".wpjournal_margin").on("input", function() {
// FOR EDIT	

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
 
	
});