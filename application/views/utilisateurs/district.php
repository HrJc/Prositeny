<style>
	#table-liste-clientZoom_paginate , #tbl_anomalie_paginate {
		font-size: 10px;
		float: left;
	}

	#table-liste-clientZoom_wrapper th , #tbl_anomalie th {
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
	
</style>
<br>
<!-- <div class="row" style="margin:10px">
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="width: 73%;">
		<label><strong>Province :</strong> </label>
		<select data-live-search=true name="faritany" id="faritanyFiltre5" onchange="getFaritra(this.value)">
			<?php
			$i = 0;

			foreach ($region as $value) {
				?>
				<option value="<?php echo $value->CODE_FARITANY ?>">
					<?php echo $value->LIBELLE_FARITANY ?>
				</option>
				<?php
				$i++;
			} ?>

		</select>&emsp;
		<label><strong>Région :</strong></label>
		<select data-live-search=true id="regionFiltre5" title="region" required name="rg">

		</select>&emsp;
		<label><strong>District :</strong></label>
		<select data-live-search=true id="districtFiltre5" title="District" required name="ds">
            <?php
                $i = 0;

                foreach ($district as $value) {
                    ?>
                    <option value="<?php echo $value->CODE_DISTRICT ?>">
                        <?php echo $value->LIBELLE_DISTRICT ?>
                    </option>
                    <?php
                    $i++;
                } ?>

		</select>&emsp;
		<!-- <select>
						<option value="tous">Tous</option>
						<option value="">Déporté</option>
						<option value="">Inclus dans la liste</option>
						<option value="">Non inclus dans la liste</option>
				</select> -
	</div> -->


<br>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<table class="table" id="table-liste-clientZoom" style="font-size: small;width: 130% !important;">
		<thead>
            <tr>
				<!-- <th style="background-color:#4237b3; color:white" class="text-center">Date</th> -->
				<th style="background-color:#4237b3; color:white" class="text-center">Id</th>
                <th style="background-color:#4237b3; color:white" class="text-center">Action</th>
                <th style="background-color:#4237b3; color:white" class="text-center">Etat</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Contact</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Nom et Prénoms</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Quartier</th>
				<!-- <th style="background-color:#4237b3; color:white" class="text-center">Etat</th> -->
				<th style="background-color:#4237b3; color:white" class="text-center">Commune</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Centre de vote</th>
				<!-- <th style="background-color:#4237b3; color:white" class="text-center">BV Original</th> -->
				<th style="background-color:#4237b3; color:white" class="text-center">BV Actuel</th>
				<th style="background-color:#4237b3; color:white" class="text-center">CIN</th>
			</tr>
		</thead>
		<tbody>
			<!--Ajax-->
		</tbody>
	</table>
</div>

<input type="hidden" name="" id="id-anomalie">

<div class="modal" id="modaladd" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document" style="width:550px">
			<div class="modal-content" style='width:550px'>
				<div class="modal-header">
					<h5 class="modal-title">Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style='width:550px' id="addDelegueExcel">			
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
							<p>Voulez-vous vraiment valider cette délégué ?</p>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom : 10px;">
							<input type="text" id="id-nom" name="contact" class="form-control" placeholder="Nom responsable">
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<input type="text" id="id-telephone" name="contact" class="form-control" placeholder="Contact">
						</div>
					</div>
					<br>
					<div style="float:right">
						<button type="button" class="btn btn-primary" onclick="voirAno()">Confirmer</button>
						<button type="button" class="btn btn-info" data-dismiss="modal">Annuler</button>
					</div>
				</div>
			</div>
		</div>
	</div>


<script>

	function getFaritra(id) {
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/chargeRegion5'); ?>',
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
			url: '<?php echo site_url('Utilisateurs/chargeDistrict5'); ?>',
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
	function listeContratZoom() {
		var table = $("#table-liste-clientZoom")
			.on('preXhr.dt', function (e, settings, data) {
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
				"info": false,
				"bPaginate": true,
				"searching": true,
				"bDestroy": true,
				"scrollX" :true,


				"preDrawCallback": function (settings) {
					$('#table-liste-clientZoom').unblock();
				},

				"ajax": {
					url: '<?php echo site_url('Utilisateurs/listerDistrict'); ?>',
					data: { fr: $("#faritanyFiltre").val(), rg: $("#regionFiltre").val(), ds: $("#districtFiltre").val() },
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

    function valideAno(idCrud) {
		$('#modaladd').modal('show');
		$('#id-anomalie').val(idCrud);
	}

	function voirAno(idCrud) {
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/updateEtat'); ?>',
			type: "POST",
			dataType : "JSON",
			data: ({
			    id: $('#id-anomalie').val(),
			    nom: $('#id-nom').val(),
			    contact: $('#id-telephone').val(),
			}),
			beforeSend: function(){
			    
			},
			success: function (data) {
                alert('Ok');
                $('#modaladd').modal('hide');
                // listeContratZoom();
				console.log();
			}
		});
	}

	jQuery(document).ready(function ($) {

		listeContratZoom();

	});
</script>