<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aml
 */

?>
<link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<?php 
if(is_page('int-forms') ||  is_front_page() || is_page('local-forms') || is_page('form') || is_page('int-form')){	
?>
<!-- received modal-->
<div class="modal fade" id="receivedModal" tabindex="-1" role="dialog" aria-labelledby="receivedModalLabel" aria-hidden="true" data-backdrop="static" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="text-center" style="width:100%;">קבלת/מסירת שליחות</h3>
      </div>
      <div class="text-center">
        <h5 id="form_details"></h5>
      </div>

      <div class="modal-body">
          <div class="form-group row">
          	
            <div class="col-lg-8 col-sm-8">
                <input class="form-control" id="received_time" required="">

            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="received_time">שעת קבלת/מסירת משלוח *</label>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-sm-8">
                <input class="text-right form-control" name="received_sender_name" type="text" id="received_sender_name" value=""  required="" />
            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="received_sender_name">שם השליח *</label>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-sm-8">
                <input class="text-right form-control" name="received_receiver_name" type="text" id="received_receiver_name" value=""  required="" />
            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="received_receiver_name">שם מקבל  / מוסר *</label>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-sm-8">
                <input class="text-right form-control" name="received_comments" type="text" id="received_comments" value="" />
            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="received_comments">הערות</label>
        </div>
      </div>
      <div class="modal-footer">
        <button id="received_create" type="button" class="btn btn-default">התקבל</button>
        <button id="received_cancel" type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">ביטול</button>
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 


<!-- cancelled modal-->
<div class="modal fade" id="cancelledModal" tabindex="-1" role="dialog" aria-labelledby="cancelledModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="text-center text-danger" style="width:100%;">ביטול משלוח</h3>
      </div>
      <div class="text-center">
        <h5 id="form_details_cancelled"></h5>
      </div>

      <div class="modal-body">
          <div class="form-group row">
          	
            <div class="col-lg-8 col-sm-8">
                <input class="form-control" id="cancelled_time" required="">

            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="cancelled_time">שעה*</label>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-sm-8">
                <input class="text-right form-control" name="cancelled_name" type="text" id="cancelled_name" value=""  required="" />
            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="cancelled_name">שם המבטל*</label>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-sm-8">
                <input class="text-right form-control" name="cancelled_reason" type="text" id="cancelled_reason" value=""  required="" />
            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="cancelled_reason">סיבת הביטול*</label>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-sm-8">
                <input class="text-right form-control" name="cancelled_comments" type="text" id="cancelled_comments" value="" />
            </div>
            <label class="text-right col-lg-4 col-sm-4 col-form-label" for="cancelled_comments">הערות</label>
        </div>
      </div>
      <div class="modal-footer">
        <button id="cancelled_create" type="button" class="btn btn-default">שמור פרטי ביטול</button>
        <button id="cancelled_cancel" type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">ביטול</button>


      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->  


s
<?php } ?>

<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>	
  <script>
	    var resizefunc = [];
	</script>
<?php 
if(is_page('int-forms') ||  is_front_page() || is_page('local-forms')){
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<?php }else{?>
<script src="<?php bloginfo('template_directory'); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<?php } ?>
	

	<script src="<?php bloginfo('template_directory'); ?>/assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/detect.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/fastclick.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.slimscroll.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.blockUI.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/waves.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/wow.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.nicescroll.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.scrollTo.min.js"></script>

	<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.core.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.app.js"></script>

	<script src="<?php bloginfo('template_directory'); ?>/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/plugins/select2/js/select2.min.js"></script>

	
	<script src="<?php bloginfo('template_directory'); ?>/plugins/timepicker/bootstrap-timepicker.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>		

	<?php if(is_front_page() || is_page('int-forms') || is_page('local-forms') || is_page('aml-log')){?>
	<!-- Required datatable js -->
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/plugins/xeditable/bootstrap-editable.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/plugins/xeditable/jquery.xeditable.js"></script>

    <!-- Buttons examples -->
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/jszip.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/pdfmake.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/vfs_fonts.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/buttons.html5.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/buttons.print.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/plugins/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?php bloginfo('template_directory'); ?>/js/jquery.dataTables.yadcf.js"></script>

    <script src="//cdn.datatables.net/plug-ins/1.10.16/sorting/date-eu.js"></script>

    
    
    
    

	<?php } ?>

	<script>

		$(document).ready(function() {
			var cur_last_id;

		    $('.select2').select2();
		    <?php if(is_front_page() || is_page('local-forms')){?>
		    load_forms_table();

		    <?php } ?>
		    <?php if(is_page('int-forms')){?>
		    load_int_forms_table();
		    <?php } ?> 

		    $('#cancel-form').click(function() {
		        if (confirm('Are you sure?')) {
		          window.location.href = "<?php echo bloginfo('url');?>";
		        }
		    });

		    <?php if(is_front_page() || is_page('local-forms') || is_page('int-forms')){
		    if(current_user_can('subscriber')){ ?>
		    	setTimeout(function(){ 
		    		$(".select_status_col").prop('disabled', 'disabled');
		    		
	        		
		    	}, 800);
	        	
	        <?php 
	    	} } ?>
		    
		});

		<?php if(is_front_page() || is_page('local-forms')){?>

		String.prototype.replaceAll = function(search, replacement) {
    		var target = this;
    		return target.split(search).join(replacement);
		};

		function load_forms_table() {

	        var forms_table = $('#forms_table').DataTable({
	        	
		        "bSortCellsTop": true,
	            "ajax": {
	                "dataType": 'json',
	                "crossDomain": true,
	                "xhrFields": {
	                    withCredentials: true
	                },
	                
	                "url": "<?php echo bloginfo('url');?>/fetch/aml_fetch_forms.php",
	                "dataSrc": function(json) {
	                	
	                    var return_data = new Array();
	                    for (var i = 0; i < json.length; i++) {

	                        return_data.push({
	                            'date': json[i]["date"],
								'id': json[i]["id"],
								'ctcodes': json[i]["ctcodes"],
								'visits': json[i]["visits"],
								'sites': json[i]["sites"],
								'targets': json[i]["targets"],
	                            'couriers': json[i]["couriers"],
	                            'pickup': json[i]["pickup"],
	                            'pickup_date': json[i]["pickup_date"],
	                            'pickup_time': json[i]["pickup_time"],
	                            'status': json[i]["status"],


	                        })
	                    }
	                    if(json && json[0]){
	                    	cur_last_id = json[0]["id"];
	                	}
	                    return return_data;
	                }
	            },

	            "sDom": 'Bf<t>lpi',
	            
	            "buttons": [

		            {
		                "extend": 'excelHtml5',
		                "exportOptions": { "orthogonal": 'export' }
		            }
		        ],



	            "destroy": true,
				"responsive": true,
		        
		        
	            "fixedHeader": {
	                header: true
	            },

	            "columns": [

	                { "data": "date", "className": 'details-control date-filter0' },
					{ "data": "id", "className": 'details-control' },
					{ "data": "ctcodes", "className": 'details-control' },
					{ "targets": 3,
                    	"data": "visits",
						"className": 'details-control',
						"render": function ( data, type, full, meta ) {

							var cur_data = '';
							if(data){
									cur_data = data.replaceAll("~","<img src='<?php echo bloginfo('template_directory'); ?>/assets/images/overseas.png' />");
							}

							
							return cur_data;

						}

					},
					{ "data": "sites", "className": 'details-control' },
	                { "data": "targets", "className": 'details-control' },
	                { "data": "couriers", "className": 'details-control' },
	                { "data": "pickup", "className": 'details-control' },
	                { "data": "pickup_date", "className": 'details-control date-filter1'},
	                { "data": "pickup_time", "className": 'details-control' },
	                { "targets": 10,
                    	"data": "status",
                    	"sorting": false,
						"className": 'details-control',
						"render": function ( data, type, full, meta ) {
							 var data_string;
							 var status1 = '';
							 var status2 = '';
							 var status3 = '';
							 var select_class = 'success';



							 if(data == 2){
							 	status2 = ' selected';
							 	select_class = 'error';
							 }else if(data == 1){
							 	status1 = ' selected';
							 	select_class = 'success';
							 }else if(data == 3){
							 	status3 = ' selected';
							 	select_class = 'label-primary';
							 }

							if(type === 'filter'){

				                return $('#forms_table').DataTable().cell(meta.row, meta.col).nodes().to$().find('select').val();
				            	} else {
				                //return data;
				            }

							
							if(type === 'export'){
							 	if(data == 2){
							 		data_string = 'בוטל';
							 	}else if(data == 1){
							 		data_string = 'נשלח';
							 	}else if(data == 3){
							 		data_string = 'התקבל';
							 	}
							 	return data_string;
							 }

		                     return '<select class="select_status_col '+select_class+'" id="select_status_col'+full.id+'" onchange="change_status(this,'+full.id+',this.value)"><option value=1 class=success '+status1+'>נשלח</option><option value=2 class=error '+status2+'>בוטל</option><option value=3 class=label-primary '+status3+'>התקבל</option></select>';


		                 }
					 },
	                { "targets": 11,
                    	"data": null,
                    	"sorting": false,
						"className": 'details-control',
						"render": function ( data, type, full, meta ) {
		                     var FormID = full.id;
		                     return '<a href=<?php echo bloginfo('url')?>/form?formid='+FormID+' title="ערוך"><i class="ti-pencil"></i></a>';
		                 }
					 },

	                
	                
	            ],

	            "pageLength": 100,

	            "columnDefs": [
	                { "width": "8%", "targets": 0 },
	                { "width": "8%", "targets": 1 },
	                { "width": "8%", "targets": 2 },
	                { "width": "8%", "targets": 3 },
	                { "width": "8%", "targets": 4 },
	                { "width": "8%", "targets": 5 },
	                { "width": "8%", "targets": 6 },
	                { "width": "8%", "targets": 7 },
	                { "width": "10%", "targets": 8, "type": 'date-eu' },
	                { "width": "8%", "targets": 9 },           	                	                
	                { "width": "8%", "targets": 10},
	                { "width": "6%", "targets": 11 },
	              ],
	            "order": [
	                [8, 'desc']
	            ],
	            fnInitComplete: function () {

		            this.api().columns([1,2,3,4,5,6,7,9]).every( function () {
		                var column = this;
		                var select = $('<select><option value=""></option></select>')
		                    .appendTo( $(column.footer()).empty() )
		                    .on( 'change', function () {
		                        var val = $.fn.dataTable.util.escapeRegex(
		                            $(this).val()
		                        );
		 
		                        column
		                            .search( val ? '^'+val+'$' : '', true, false )
		                            .draw();
		                    } );
		 
		                column.data().unique().sort().each( function ( d, j ) {
		                	
		                	
						    if(column.search() === '^'+d+'$'){
						        select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
						    } else {

						        select.append( '<option value="'+d+'">'+d+'</option>' )
						    }
						} );
		            } );


		            this.api().columns([10]).every( function () {
		                var column = this;
		                var select = $('<select id="select_status"><option value=""></option></select>')
		                    .appendTo( $(column.footer()).empty() )
		                    .on( 'change', function () {
		                        var val = $.fn.dataTable.util.escapeRegex(
		                            $(this).val()
		                        );
		 
		                        column
		                            .search( val ? '^'+val+'$' : '', true, false )
		                            .draw();
		                    } );
		 
		 				var cur_d = '';
		                column.data().unique().sort().each( function ( d, j ) {
		                	if(d==1){
		                		cur_d = 'נשלח';
		                	}else if(d==2){
		                		cur_d = 'בוטל';
		                	}else if(d==3){
		                		cur_d = 'התקבל';
		                	}
						    if(column.search() === '^'+d+'$'){
						        select.append( '<option value="'+d+'" selected="selected">'+cur_d+'</option>' )
						    } else {
						        select.append( '<option value="'+d+'">'+cur_d+'</option>' )
						    }
						} );


		                $('thead tr').after($('tfoot tr'));

		                yadcf.init(forms_table, [
		                {
			  				column_number: 0,
							filter_type: "date",
							date_format: "dd-mm-yyyy",
							filter_default_label:'בחר תאריך'
			  			},
		                {
			  				column_number: 8,
							filter_type: "date",
							date_format: "dd/mm/yyyy",
							filter_default_label:'בחר תאריך'
			  			}
			  			]);

		                $('#yadcf-filter-wrapper--forms_table-0').prependTo("td.date-filter0:first");
			        	$('#yadcf-filter-wrapper--forms_table-8').prependTo("td.date-filter1:first");


		            } );
		        },
	        });

	        setInterval(check_new_form, 300000);

	        

	       
	    }



		


	    function check_new_form(){

	    	var new_last_id;
	    	$.ajax({
			     type: 'post',
			     url: '<?php echo bloginfo('url');?>/fetch/aml_fetch_forms.php',
			     dataType :'json',
			})
			.done(function(data){
				new_last_id = data[0]["id"];

				if(new_last_id != cur_last_id){
					load_forms_table();
					play_sound();
					
				}
			})
	    }


	    function play_sound(){
	    	var audio_el = document.createElement('audio');
			audio_el.setAttribute('src', '<?php echo bloginfo('template_directory');?>/assets/hide-and-seek.mp3');
			audio_el.load();

			audio_el.addEventListener("canplay", function() { 
			  audio_el.play(); 
			}, true);
	    }

	    <?php } ?>

	    <?php if(is_page('int-forms')){?>
		function load_int_forms_table() {
        
	        var forms_table = $('#int_forms_table').DataTable({
	        	"fnInitComplete": function () {
		            	
		            //this.api().columns().every( function () {
		            this.api().columns([0,1,2,3,4,5,6,7,8,9,10,11]).every( function () {
		                var column = this;
		                var select = $('<select><option value=""></option></select>')
		                    .appendTo( $(column.footer()).empty() )
		                    .on( 'change', function () {
		                        var val = $.fn.dataTable.util.escapeRegex(
		                            $(this).val()
		                        );
		 
		                        column
		                            .search( val ? '^'+val+'$' : '', true, false )
		                            .draw();
		                    } );
		 
		                column.data().unique().sort().each( function ( d, j ) {
						    if(column.search() === '^'+d+'$'){
						        select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
						    } else {
						        select.append( '<option value="'+d+'">'+d+'</option>' )
						    }
						} );
		            } );



		            this.api().columns([12]).every( function () {
		                var column = this;
		                var select = $('<select id="select_status"><option value=""></option></select>')
		                    .appendTo( $(column.footer()).empty() )
		                    .on( 'change', function () {
		                        var val = $.fn.dataTable.util.escapeRegex(
		                            $(this).val()
		                        );
		 
		                        column
		                            .search( val ? '^'+val+'$' : '', true, false )
		                            .draw();
		                    } );
		 
		 				var cur_d = '';
		                column.data().unique().sort().each( function ( d, j ) {
		                	if(d==1){
		                		cur_d = 'נשלח';
		                	}else if(d==2){
		                		cur_d = 'בוטל';
		                	}
						    if(column.search() === '^'+d+'$'){
						        select.append( '<option value="'+d+'" selected="selected">'+cur_d+'</option>' )
						    } else {
						        select.append( '<option value="'+d+'">'+cur_d+'</option>' )
						    }
						} );
		            } );

		            yadcf.init(forms_table, [
		                {
			  				column_number: 0,
							filter_type: "date",
							date_format: "dd-mm-yyyy",
							filter_default_label:'בחר תאריך'
			  			},
		                {
			  				column_number: 6,
							filter_type: "date",
							date_format: "dd/mm/yyyy",
							filter_default_label:'בחר תאריך'
			  			}
			  		]);

		            $('#yadcf-filter-wrapper--forms_table-0').prependTo("td.date-filter0:first");
			       	$('#yadcf-filter-wrapper--forms_table-6').prependTo("td.date-filter1:first");

			       	$.fn.editable.defaults.mode = 'inline';
		    		
				    $('.table_notes').editable({
					    type: 'text',
					    emptytext: '...',
					    url: '<?php echo bloginfo('url');?>/fetch/aml_update_table_notes.php',
					    title: 'הוסף הערה'
					});


		        },
	            "ajax": {
	                "dataType": 'json',
	                "crossDomain": true,
	                "xhrFields": {
	                    withCredentials: true
	                },

	                "url": "<?php echo bloginfo('url');?>/fetch/aml_fetch_int_forms.php",
	                "dataSrc": function(json) {
	                	
	                    var return_data = new Array();
	                    for (var i = 0; i < json.length; i++) {

	                        return_data.push({
	                            'date': json[i]["date"],
								'id': json[i]["id"],
								'int_ctcodes': json[i]["int_ctcodes"],
								'int_targets': json[i]["int_targets"],
								'awb': json[i]["awb"],
								'shipment_number': json[i]["shipment_number"],
	                            'outbound_shipment_date': json[i]["outbound_shipment_date"],
	                            'world_courier': json[i]["world_courier"],
	                            'shipping_type': json[i]["shipping_type"],
	                            'manifest_name': json[i]["manifest_name"],
	                            'is_pdf': json[i]["is_pdf"],
	                            'pdf_file_name': json[i]["pdf_file_name"],
	                            'table_notes': json[i]["table_notes"],
	                            'int_status': json[i]["int_status"],


	                        })

	                        var pdf_file_name = return_data.pdf_file_name;
	                    }

	                    return return_data;
	                }
	            },

	            "sDom": 'Bf<t>lpi',
	            
	            "buttons": [

		            {
		                "extend": 'excelHtml5',
		                "exportOptions": { "orthogonal": 'export' }
		            }
		        ],

	            "destroy": true,
				"responsive": true,
		        
		        
	            "fixedHeader": {
	                header: true
	            },

	            "columns": [

	                { "data": "date", "className": 'details-control date-filter0' },
					{ "data": "id", "className": 'details-control' },
					{ "data": "int_ctcodes", "className": 'details-control' },
					{ "data": "int_targets", "className": 'details-control' },
					{ "data": "awb", "className": 'details-control' },
	                { "data": "shipment_number", "className": 'details-control' },
	                { "data": "outbound_shipment_date", "className": 'details-control date-filter1' },
	                { "data": "world_courier", "className": 'details-control' },
	                { "data": "shipping_type", "className": 'details-control' },

	                { "data": "manifest_name", "className": 'details-control' },
	                { "targets":10,
	                	"data": "is_pdf", 
	                	"className": 'details-control',
						"render": function ( data, type, full, meta ) {
		                     var FormID = full.id;
		                     var pdf_file_name = full.pdf_file_name;
		                     
		                     if(data=='yes'){
		                     	if(!pdf_file_name){
		                     		pdf_file_name = FormID;
		                     }

		                     return '<a href="<?php echo bloginfo('url')?>/pdf/'+pdf_file_name+'.pdf" title="הורד" target="_blank"><img src="<?php echo bloginfo('template_directory')?>/assets/images/pdf.png" width="24px" /></a>';
		                 }else{
		                 	return '';
		                 }
		                 }

							 },


					{ "targets": 11,
                    	"data": "table_notes",
                    	"sorting": false,
						"className": 'table_notes details-control',
						'createdCell':  function (td, cellData, rowData, row, col) {
				           $(td).attr('data-pk', rowData.id); 
				           //console.log();
				        }
                    },							 

	                { "targets": 12,
                    	"data": "int_status",
                    	"sorting": false,
						"className": 'details-control',
						"render": function ( data, type, full, meta ) {
							 var data_string;
							 var status1 = '';
							 var status2 = '';
							 var status3 = '';
							 var select_class = 'success';


							 if(data == 2){
							 	status2 = ' selected';
							 	select_class = 'error';
							 }else if(data == 1){
							 	status1 = ' selected';
							 	select_class = 'success';
							 }else if(data == 3){
							 	status3 = ' selected';
							 	select_class = 'label-primary';
							 }

							 //console.log(select_class);



							 if(type === 'filter'){

				                return $('#int_forms_table').DataTable().cell(meta.row, meta.col).nodes().to$().find('select').val();
				            	} else {
				                //return data;
				            }


							 if(type === 'export'){
							 	if(data == 2){
							 		data_string = 'בוטל';
							 	}else if(data == 1){
							 		data_string = 'נשלח';
							 	}else if(data == 3){
							 		data_string = 'התקבל';
							 	}
							 	return data_string;
							 }


		                      return '<select class="select_status_col '+select_class+'" id="select_status_col'+full.id+'" onchange="change_status(this,'+full.id+',this.value)"><option value=1 class=success '+status1+'>נשלח</option><option value=2 class=error '+status2+'>בוטל</option><option value=3 class=label-primary '+status3+'>התקבל</option></select>';

		                    

		                 }
					 },
	                { "targets": 13,
                    	"data": null,
                    	"sorting": false,
						"className": 'details-control',
						"render": function ( data, type, full, meta ) {
		                     var FormID = full.id;
		                     return '<a href="<?php echo bloginfo('url')?>/int-form?formid='+FormID+'" title="ערוך"><i class="ti-pencil"></i></a>';
		                 }
					 },

	                
	                
	            ],

	            "pageLength": 100,
	            "columnDefs": [
	                { "width": "7%", "targets": 0 },
	                { "width": "7%", "targets": 1 },
	                { "width": "7%", "targets": 2 },
	                { "width": "7%", "targets": 3 },
	                { "width": "4%", "targets": 4 },
	                { "width": "7%", "targets": 5 },
	                { "width": "13%", "targets": 6 , "type": 'date-eu' },
	                { "width": "7%", "targets": 7 },
	                { "width": "7%", "targets": 8 },
	                { "width": "7%", "targets": 9 },           	                	                
	                { "width": "7%", "targets": 10 },
	                { "width": "7%", "targets": 11 },
	                { "width": "4%", "targets": 12 },
	                { "width": "4%", "targets": 13 },
	              ],
	            "order": [
	                [1, 'desc']
	            ],
	            fnDrawCallback: function () {
		        	$.fn.editable.defaults.mode = 'inline';
		        	$('.table_notes').editable({
					    type: 'text',
					    emptytext: '...',
					    url: '<?php echo bloginfo('url');?>/fetch/aml_update_table_notes.php',
					    title: 'הוסף הערה'
					});
		        },
	        });
	        

	    }
	    <?php } ?>


	    function change_status(select,id,val){
	    	//1 - נשלח
	    	//2 - בוטל
	    	//3 - התקבל
	    	var formType;
	    	<?php if(is_page('int-forms') || is_page('int-form')){ ?>
	    		formType = 2;
	    	<?php } ?>
	    	<?php if(is_front_page() || is_page('local-forms') || is_page('form')){?>
	    		formType = 1;
	    	<?php } ?>

	    	 

			if(val == 1){
				$(select).addClass('success');
				$(select).removeClass('error');
				$(select).removeClass('label-primary');
			}else if(val == 2){
				$(select).addClass('error');
				$(select).removeClass('success');
				$(select).removeClass('label-primary');
				cancelledBox(id,formType);


			}else if(val == 3){
				$(select).addClass('label-primary');
				$(select).removeClass('success');
				$(select).removeClass('error');
				receivedBox(id,formType);
			}
			
	    	$.ajax({
			     type: 'post',
			     url: '<?php echo bloginfo('url');?>/fetch/aml_update_status.php',
			     dataType :'json',
			     data: {
			      form_id:id,status_val:val
			     },
			     success: function () {}
			}); 


	    }

	    
	    <?php 
		if(is_page('int-forms') ||  is_front_page() || is_page('local-forms') || is_page('form') || is_page('int-form')){
		?>
		//receivedBox

	    function receivedBox(formId,formType){
	    	//reset fields


		    $.ajax({
            type: 'post',
		     url: '<?php echo bloginfo('url');?>/fetch/aml_fetch_form.php',
		     dataType :'json',
		     data: {
		      formid:formId
		     }
	        })
	        .done(function(data) {

	        	var form_title = '';
	        	 if(formType == 1){
	        	  	form_title = data.cur_ctcodes +' - '+ data.cur_sites;
	        	}else{
	        		form_title = data.int_ctcodes  +' - '+ data.int_targets;
	        	}


	        	$('#form_details').text(form_title)
	        });
			

	    	$('#receivedModal').modal('show');
	    	$('#received_create').attr('data-formId', formId);

	    	$("#received_time").timepicker({
		        useCurrent: true,
		        template: 'dropdown',
		        showInputs: false,
		        minuteStep: 1,
		        showMeridian: false,

		        icons: {
			        
			        up: 'ti-angle-up',
			        down: 'ti-angle-down',
			        
			    },

		    });



		    
		    

	    	$.ajax({
		     type: 'post',
		     url: '<?php echo bloginfo('url');?>/fetch/aml_received_check.php',
		     dataType : 'json',
		     data: {
		      formid:formId
		     },
		     success: function (response) {
		     	if(response[0]['received_time']){
		     		$("#received_time").val(response[0]['received_time']);
		     		$("#received_sender_name").val(response[1]['received_sender_name']);
		     		$("#received_receiver_name").val(response[2]['received_receiver_name']);
		     		$("#received_comments").val(response[3]['received_comments']);
		     	}else{
		     		
					var currentTime = moment().format("HH:mm");
		     		$("#received_time").val(currentTime);
		     		$("#received_sender_name").val('');
					$("#received_receiver_name").val('');
					$("#received_comments").val('');
		     	}
		     }

		    });
	    }



	    function cancelledBox(formId,formType){
	    	//reset fields


		    $.ajax({
            type: 'post',
		     url: '<?php echo bloginfo('url');?>/fetch/aml_fetch_form.php',
		     dataType :'json',
		     data: {
		      formid:formId
		     }
	        })
	        .done(function(data) {

	        	var form_title = '';
	        	 if(formType == 1){
	        	  	form_title = data.cur_ctcodes +' - '+ data.cur_sites;
	        	}else{
	        		form_title = data.int_ctcodes  +' - '+ data.int_targets;
	        	}


	        	$('#form_details_cancelled').text(form_title)
	        });
			

	    	$('#cancelledModal').modal('show');
	    	$('#cancelled_create').attr('data-formId', formId);

	    	$("#cancelled_time").timepicker({
		        useCurrent: true,
		        template: 'dropdown',
		        showInputs: false,
		        minuteStep: 1,
		        showMeridian: false,

		        icons: {
			        
			        up: 'ti-angle-up',
			        down: 'ti-angle-down',
			        
			    },

		    });



	    	$.ajax({
		     type: 'post',
		     url: '<?php echo bloginfo('url');?>/fetch/aml_cancelled_check.php',
		     dataType : 'json',
		     data: {
		      formid:formId
		     },
		     success: function (response) {
		     	if(response[0]['cancelled_time']){
		     		$("#cancelled_time").val(response[0]['cancelled_time']);
		     		$("#cancelled_name").val(response[1]['cancelled_name']);
		     		$("#cancelled_reason").val(response[2]['cancelled_reason']);
		     		$("#cancelled_comments").val(response[3]['cancelled_comments']);
		     	}else{
		     		
					var currentTime = moment().format("HH:mm");
		     		$("#cancelled_time").val(currentTime);
		     		$("#cancelled_name").val('');
					$("#cancelled_reason").val('');
					$("#cancelled_comments").val('');
		     	}
		     }

		    });



	    	


	    }




	    //create Recieved
		$("#received_create").click(function(){
		var formId = $(this).attr("data-formid");
		var received_time = $("#received_time").val();
		var received_sender_name = $("#received_sender_name").val();
		var received_receiver_name = $("#received_receiver_name").val();
		var received_comments = $("#received_comments").val();
		var LogType;

		if(received_time && received_sender_name && received_receiver_name){
		    $('#received_create').prop("disabled",true);
		    $('#received_create').text("Loading...");

		    <?php if(is_front_page() || is_page('local-forms')){?>
		    	LogType = '1';
		    <?php }elseif(is_page('int-forms')){?>
		    	LogType = '2';
		    <?php } ?>


		    $.ajax({
		     type: 'post',
		     url: '<?php echo bloginfo('url');?>/fetch/aml_received_create.php',
		     
		     data: {
		      formid:formId,
		      received_time:received_time,
		      received_sender_name:received_sender_name,
		      received_receiver_name:received_receiver_name,
		      received_comments:received_comments,
		      LogType:LogType

		     },
		     success: function (response) {
		     	//send cancellation email


		        $('#received_create').prop("disabled",false);
		        $('#received_create').text("התקבל");
		        $('#receivedModal').modal('hide');


		     }

		    });
		}else{
		    
		    alert("נא להזין את כל שדות החובה");
		}


		});



		//create Cancel
		$("#cancelled_create").click(function(){
		var formId = $(this).attr("data-formid");
		var formLang;

		var cancelled_time = $("#cancelled_time").val();
		var cancelled_name = $("#cancelled_name").val();
		var cancelled_reason = $("#cancelled_reason").val();
		var cancelled_comments = $("#cancelled_comments").val();
		var LogType;

		if(cancelled_time && cancelled_name && cancelled_reason){
		    $('#cancelled_create').prop("disabled",true);
		    $('#cancelled_create').text("Loading...");
		    
		    <?php if(is_front_page() || is_page('local-forms') || is_page('form')){?>
		    	LogType = '1';
		    	formLang = '1';
		    <?php }elseif(is_page('int-forms') || is_page('int-form')){?>
		    	LogType = '2';
		    	formLang = '2';
		    <?php } ?>
		

		    $.ajax({
		     type: 'post',
		     url: '<?php echo bloginfo('url');?>/fetch/aml_cancelled_create.php',
		     
		     data: {
		      formid:formId,
		      cancelled_time:cancelled_time,
		      cancelled_name:cancelled_name,
		      cancelled_reason:cancelled_reason,
		      cancelled_comments:cancelled_comments,
		      LogType:LogType

		     },
		     success: function (response) {
		        $('#cancelled_create').prop("disabled",false);
		        $('#cancelled_create').text("שמור פרטי ביטול");
		        $('#cancelledModal').modal('hide');

		        $.ajax({
			     type: 'post',
			     url: '<?php echo bloginfo('url');?>/fetch/aml_send_cancel.php',
			     dataType : 'json',
			     data: {
			      formID:formId,
			      formLang:formLang
			     },
			     success: function (response) {
			     	
			     }

			    });


		     }

		    });
		}else{
		    
		    alert("נא להזין את כל שדות החובה");
		}


		});


		

		<?php } ?>




		

		<?php 
		if(is_page('aml-log')){
		?>

		var log_table = $('#log_table').DataTable({
	        	
		        "bSortCellsTop": true,
	            "ajax": {
	                "dataType": 'json',
	                "crossDomain": true,
	                "xhrFields": {
	                    withCredentials: true
	                },
	                
	                "url": "<?php echo bloginfo('url');?>/fetch/aml_fetch_log.php",
	                "dataSrc": function(json) {
	                    var return_data = new Array();
	                    for (var i = 0; i < json.length; i++) {
	                        return_data.push({
	                        	'ID': json[i]["ID"],
	                        	'LogDate': json[i]["LogDate"],
	                            'Log': json[i]["Log"],
	                            'LogType': json[i]["LogType"],
	                        })
	                    }
	                    return return_data;
	                }
	            },

	            "sDom": 'Bf<t><"#table_footer"lp>i',

	            
	            "buttons": [

		            {
		                "extend": 'excelHtml5',
		                "exportOptions": { "orthogonal": 'export' }
		            }
		        ],



	            "destroy": true,
				"responsive": true,
		        
		        
	            "fixedHeader": {
	                header: true
	            },


	            "columns": [
	            	{ "data": "ID", "className": 'details-control' },
	                { "data": "LogDate", "className": 'details-control' },
	                { "data": "Log", "className": 'details-control' },
	                

	                { "targets": 3,
                    	"data": null,
						"className": 'details-control',
						"render": function ( data, type, full, meta ) {
		                     var LogType;
		                     if(data.LogType==1){
		                     	return 'מקומי';
		                     }else{
		                     	return 'חול';
		                     }
		                     
		                 }
					 },
	                
	            ],

	            "columnDefs": [{
	                "targets": [0],
	                "visible": false,
	                "searchable": false
		            }
		        ],
		        "order": [
	                [0, 'desc']
	            ]
	            
	        });


	    <?php } ?>
	    

	</script>
<?php wp_footer(); ?>

        

    </body>
</html>