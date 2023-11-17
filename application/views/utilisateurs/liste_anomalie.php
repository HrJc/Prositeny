<style>
	#table-liste-clientZoom_paginate{
		font-size : 10px;
		float: left;
	}


</style>
	<br>
	<div class="row" style="margin-left:25px; color:#2a2185">
		<label><strong style="color:#5d6778;">LISTES DES ANOMALIES</strong></label><br><br>
		<div class="row">
			<!-- <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">					
					<label>Filtrage : </label>	
					<select>
						<option value=""></option>
						<option value="">Exclus</option>
						<option value="">Inclus</option>
						<option value="">BV</option>
					</select>
				</div>
				
			</div> -->
			<div class="col-9">
				<i class="fa fa-circle" aria-hidden="true" style="color: #31bc31; font-size: 10px;"></i> Exclus de la liste electorale &emsp;
				<i class="fa fa-circle" aria-hidden="true" style="color: #ff9914; font-size: 10px;"></i> Inclus dans la liste de délégué &emsp;
				<i class="fa fa-circle" aria-hidden="true" style="color: #000aff; font-size: 10px;"></i> BV # pour ce n° CIN &emsp;
				<i class="fa fa-circle" aria-hidden="true" style="color: #f70505; font-size: 10px;"></i> BV exclus de la commune &emsp;
			</div>
		</div>

	</div>

	<input type="hidden" name="" id="id-anomalie">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="details">
		<table class="table" id="table-liste-clientZoom" style = "font-size: x-small;">
			<thead style="background-color:#4237b3">
				<tr>
					<th style="background-color:#4237b3; color:white">Région</th>
					<th style="background-color:#4237b3; color:white">District</th>
					<th style="background-color:#4237b3; color:white">BV</th>
					<th style="background-color:#4237b3; color:white">Nom</th>
					<th style="background-color:#4237b3; color:white">Prénoms</th>
					<th style="background-color:#4237b3; color:white">CIN</th>
					<th style="background-color:#4237b3; color:white">Contact</th>
					<th style="background-color:#4237b3; color:white">Date</th>
					<th style="background-color:#4237b3; color:white">Anomalie</th>
					<th style="background-color:#4237b3; color:white">Etat</th>
					<th style="background-color:#4237b3; color:white">Solution</th>
					
				</tr>
			</thead>
			<tbody>
				<!--Ajax-->
			</tbody>
		</table>
	</div>
	</div>

	<div class="modal" id="modaladdExcel" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document" style="width:550px">
			<div class="modal-content" style='width:550px'>
				<div class="modal-header">
					<h5 class="modal-title">Solution</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style='width:550px' id="addDelegueExcel">	
				<form action="">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<textarea class="form-control" name="raison-ano" id="raison-ano" rows="10" required></textarea>
						</div>
					</div>
					<br>
					<div style="float:right">
						<button type="submit" class="btn btn-primary" onclick="validerRaison()">Valider</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					</div>
				</form>		
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modaladd" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document" style="width:550px">
			<div class="modal-content" style='width:550px'>
				<div class="modal-header">
					<h5 class="modal-title">Information</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style='width:550px' id="addDelegueExcel">			
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<textarea class="form-control" name="raison-info" id="raison-info" rows="10" readonly></textarea>
						</div>
					</div>
					<br>
					<div style="float:right">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>

	function getFaritra(id) {
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/chargeRegion'); ?>',
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$("#faritra").html(data);
				$('select').selectpicker('refresh');
			}
		});
	}

	function getdistrika(id) {
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/chargeDistrict'); ?>',
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$("#distrika").html(data);
				$('select').selectpicker('refresh');
			}
		});
	}

	function gestionCrudClient(idCrud) {
		if (parseInt(idCrud) != 0) {
			$('#entete-modal-client').text("Modification NOUVEAU UTILISATEUR");
			modalModifClient(idCrud);
			$('#typeCrud-client').val(idCrud);
		}
		else {
			$('#entete-modal-client').text("AJOUT NOUVEL UTILISATEUR");
			$('#form-client-zoom')[0].reset();
			$('#modal-contrat').modal('show');
			$('#typeCrud-client').val(idCrud);
		}
	}

	function valideAno(idCrud) {
		$('#modaladdExcel').modal('show');
		$('#id-anomalie').val(idCrud);
	}

	function voirAno(idCrud) {
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/getInfo'); ?>',
			type: "POST",
			dataType : "JSON",
			data: {
			id: idCrud
			},
			beforeSend: function(){
			$('#modaladd').modal('show');
			},
			success: function (data) {
				console.log();
				$('#raison-info').val(data.raison);
			}
		});
	}

	$("form").on("submit",function(event){
		event.preventDefault();
		var id = $('#id-anomalie').val();
		var raison = $('#raison-ano').val();
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/insertRaison'); ?>',
			type: "POST",
			data: ({
				id: id, raison
			}),
			success: function (data) {
				swal({
                    title: "Succès",
                    text: data.message,
                    icon: "success",
                    button: "Ok",
                });
				$('#modaladdExcel').modal('hide');
				listeContratZoom();
			}
		});
	})


	function listeContratZoom() {
		var table = $("#table-liste-clientZoom")
	    .on('preXhr.dt', function ( e, settings, data ) {
	    	$('#table-liste-clientZoom').block({
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
				"info":     false,
                "bPaginate": true,
                "searching": true,
                "bDestroy": true,
                "autoWidth": false,
               
				
                "preDrawCallback": function (settings) {
					$('#table-liste-clientZoom').unblock();
				},

				"ajax": {
					url: '<?php echo site_url('Utilisateurs/listerAnomalie'); ?>',
					type: 'POST',
					error: function (xhr, error, code) {
						$('#table-liste-clientZoom TBODY').html('');
						console.log(xhr.responseText);
					}
				}
			});

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		})

		$('#table-liste-clientZoom_wrapper').find('#table-liste-clientZoom_filter').css('display', 'none');
	}

	jQuery(document).ready(function ($) {

		listeContratZoom();

	});
</script>