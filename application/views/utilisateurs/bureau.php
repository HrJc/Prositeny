<style>
	#table-liste-clientZoom_paginate , #tbl_anomalie_paginate {
		font-size: 10px;
		float: left;
	}
	#table-liste-vote_paginate , #tbl_anomalie_paginate {
		font-size: 10px;
		float: left;
	}

	#table-liste-clientZoom_wrapper th , #tbl_anomalie th {
		font-size: 12px;
	}
	#table-liste-vote_wrapper th , #tbl_anomalie th {
		font-size: 12px;
	}

	.table tr:hover {
		background-color: grey;
	}
	label , .filter-option-inner-inner , .dropdown-item , .text-right button{
		font-size: 12px;
	}
	table#table-liste-clientZoom.table.dataTable.no-footer{
		width: 100%;
	}
	table#table-liste-vote.table.dataTable.no-footer{
		width: 100%;
	}
	
	.image-icon {
		width: 50px; /* ajustez la largeur selon vos besoins */
		height: 50px; /* ajustez la hauteur selon vos besoins */
	}

</style>
<!-- <label style="margin: 20px;"><strong>LISTE BUREAU DE VOTE</strong></label> -->

<div class="row" style = "margin:10px">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
	<h6>MESSAGES</h6>
	<button type="button" class="btn btn-primary" onclick='valideAno()' data-dismiss="modal">Ajouter</button>
		<table class="table" id="table-liste-ano" style="font-size: x-small;width: 100% !important;">
			<thead>
				<tr>
					<th style="background-color:#4237b3; color:white" class="text-center">Numéro</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Contenu message</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Observation</th>
					<th style="background-color:#4237b3; color:white" class="text-center"></th>
				</tr>
			</thead>
			<tbody >
				<!--Ajax-->
			</tbody>
		</table>
	</div>
	
</div>

<input type="hidden" name="" id="id-anomalie">

<div class="modal" id="modaladdExcel" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:550px">
		<div class="modal-content" style='width:550px'>
			<div class="modal-header">
				<h5 class="modal-title">Validation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body" style='width:550px' id="update">	
			
			<form method="POST" id="updatebvsms">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
					        <div class="mb-4" id='smsny'></div>
							<div class="col  mb-4">
								<label>Numero BV</label>
								<input type="number" id="Telephone" name="bv" style="width:100%;height:38px"
									class="form-control" placeholder="BV" required>
							</div>
							<div class="col  mb-4">
								<label>13 - Siteny</label>
								<input type="number" id="Telephone" name="siteny" style="width:100%;height:38px"
									class="form-control" placeholder="nbr vote" required>
							</div>
							<div class="col mb-4">
								<label>03 - Rajoelina</label>
								<input type="number" id="Telephone" name="andry" style="width:100%;height:38px"
									class="form-control" placeholder="nbr vote" required>
							</div>
							<div class="col  mb-4">
								<label>05 - Marc</label>
								<input type="number" id="Telephone" name="marc" style="width:100%;height:38px"
									class="form-control" placeholder="nbr vote" required>
							</div>
							<div class="col  mb-4">
								<label>Total</label>
								<input type="number" id="Telephone" name="total" style="width:100%;height:38px"
									class="form-control" placeholder="nbr vote" required>
							</div>
						<!-- <input class="form-control" name="raison-ano" id="raison-ano" rows="10" required></input> -->
					</div>
				</div>
				<br>
				<div style="float:right">
					<button type="submit" class="btn btn-primary" >Valider</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				</div>
			</form>		
			</div>
		</div>
	</div>
</div>



<script>


	function listeContratvote() {

		var table = $("#table-liste-valide")
			.on('preXhr.dt', function ( e, settings, data ) {
				$('#table-liste-valide').block({
				message: '<i class="fa fa-spinner fa fa-3x fa-spin" style="color:#000;"></i>',
				overlayCSS: {
					backgroundColor: '#fff',
					opacity: 0.8,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: 0,
					backgroundColor: 'transparent'
				}
			});
			})
			.DataTable({
			dom: 'Bfrtip',
			"ordering": true,
				"info": false,
				"bPaginate": true,
				"searching": true,
				"bDestroy": true,
				"scrollX" :true,
	              "preDrawCallback": function (settings) {
					
					$('#table-liste-valide').unblock();
				  
	              },
				  
	              "ajax" : {
                    url : adresse + 'Utilisateurs/listerMessage',
                    dataType : "JSON",
        			data: { fr: $("#faritanyFiltre").val(), rg: $("#regionFiltre").val(), ds: $("#districtFiltre").val() },
					
                    error: function (xhr, error, code){
                    	$('#table-liste-valide TBODY').html('');
		                console.log(xhr.responseText);
		            },
	            },
					
	    });

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		$('#table-liste-valide_wrapper').find('#table-liste-valide_filter').css('display', 'none');
	}

	function listeAno() {

		var table = $("#table-liste-ano")
			.on('preXhr.dt', function ( e, settings, data ) {
				$('#table-liste-ano').block({
				message: '<i class="fa fa-spinner fa fa-3x fa-spin" style="color:#000;"></i>',
				overlayCSS: {
					backgroundColor: '#fff',
					opacity: 0.8,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: 0,
					backgroundColor: 'transparent'
				}
			});
			})
			.DataTable({
			dom: 'Bfrtip',
			"ordering": true,
				"info": false,
				"bPaginate": true,
				"searching": true,
				"bDestroy": true,
				"scrollX" :true,
	              "preDrawCallback": function (settings) {
					
					$('#table-liste-ano').unblock();
				  
	              },
				  
	              "ajax" : {
                    url : adresse + 'Utilisateurs/listerAno',
                    dataType : "JSON",
        			data: { fr: $("#faritanyFiltre").val(), rg: $("#regionFiltre").val(), ds: $("#districtFiltre").val() },
					
                    error: function (xhr, error, code){
                    	$('#table-liste-ano TBODY').html('');
		                console.log(xhr.responseText);
		            },
	            },
					
	    });

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		$('#table-liste-comptant_wrapper').find('#table-liste-comptant_filter').css('display', 'none');
	}

	// $("form").on("submit",function(event){
	// 	event.preventDefault();
	// 	var id = $('#id-anomalie').val();
	// 	var raison = $('#raison-ano').val();
	// 	$.ajax({
	// 		url: '<?php echo site_url('Utilisateurs/updateAno'); ?>',
	// 		type: "POST",
	// 		data: ({
	// 			id: id, raison
	// 		}),
	// 		success: function (data) {
	// 			swal({
    //                 title: "Succès",
    //                 text: data.message,
    //                 icon: "success",
    //                 button: "Ok",
    //             });
	// 			$('#modaladdExcel').modal('hide');
	// 			listeAno();
	// 		}
	// 	});
	// })

	function listenon() {

		var table = $("#table-liste-non")
			.on('preXhr.dt', function ( e, settings, data ) {
				$('#table-liste-non').block({
				message: '<i class="fa fa-spinner fa fa-3x fa-spin" style="color:#000;"></i>',
				overlayCSS: {
					backgroundColor: '#fff',
					opacity: 0.8,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: 0,
					backgroundColor: 'transparent'
				}
			});
			})
			.DataTable({
			dom: 'Bfrtip',
			"ordering": true,
				"info": false,
				"bPaginate": true,
				"searching": true,
				"bDestroy": true,
				"scrollX" :true,
	              "preDrawCallback": function (settings) {
					
					$('#table-liste-non').unblock();
				  
	              },
				  
	              "ajax" : {
                    url : adresse + 'Utilisateurs/listerMessageNon',
                    dataType : "JSON",
        			data: { fr: $("#faritanyFiltre").val(), rg: $("#regionFiltre").val(), ds: $("#districtFiltre").val() },
					
                    error: function (xhr, error, code){
                    	$('#table-liste-non TBODY').html('');
		                console.log(xhr.responseText);
		            },
	            },
					
	    });

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		$('#table-liste-non_wrapper').find('#table-liste-non_filter').css('display', 'none');
	}

	function valideAno() {
		$('#modaladdExcel').modal('show');

		//var data = $("#"+idCrud).data("id");
		//$("#smsny").text(data);

		//$('#id-anomalie').val(idCrud);
	}

	jQuery(document).ready(function ($) {

		// listeContratvote();
		listeAno();
		// listeComptant();

	});
</script>
