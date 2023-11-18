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
<div class="row" style="margin:10px">
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="width: 73%;">
		<label><strong>Province :</strong> </label>
		<select data-live-search=true name="faritany" id="faritanyFiltre" onchange="getFaritra(this.value)">
			<option value="tous" selected>Tous</option>
			<?php
			$i = 0;

			foreach ($faritra as $value) {
				//$sel = ($i == 0) ? "selected" : "" ;
				?>
				<option value="<?php echo $value->CODE_FARITANY ?>">
					<?php echo $value->LIBELLE_FARITANY ?>
				</option>
				<?php
				$i++;
			} ?>

		</select>&emsp;
		<label><strong>Région :</strong></label>
		<select data-live-search=true id="regionFiltre" title="region" required name="rg">
			<option value="tous" selected>Tous</option>

		</select>&emsp;
		<label><strong>District :</strong></label>
		<select data-live-search=true id="districtFiltre" title="District" required name="ds">
			<option value="tous" selected>Tous</option>
		</select>&emsp;
		<!-- <select>
						<option value="tous">Tous</option>
						<option value="">Déporté</option>
						<option value="">Inclus dans la liste</option>
						<option value="">Non inclus dans la liste</option>
				</select> -->
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right" style="width: 27%;">
	<button type="button" class="btn btn-danger" id='addEmpExcelUpdate'
			style="margin-left: 5px;color: aliceblue;">Update <i class="fa fa-file-excel"
				style="font-size:16px"></i></button>
		<button type="button" class="btn btn-info" id='addEmpExcel'
			style="margin-left: 5px;color: aliceblue;">Importer <i class="fa fa-file-excel"
				style="font-size:16px"></i></button>
		
		<button type="button" class="btn btn-info" style="margin-left: 5px;color: aliceblue;"
			onclick="exportExcel()">Exporter <i class="fa fa-file-excel" style="font-size:16px"></i></button>
			<button type="button" class="btn btn-primary" id='addEmp'
			style="margin-left: 5px;color: aliceblue;">Nouveau <i class=" fa
			fa-user-plus" style="font-size:16px"></i></button>
	</div>
</div>
<div class="row">
	<div class="row" style="margin-left: 10px;margin-top: 15px;">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #0040ff; font-size: 12px;font-family:  Arial "></i> Déporté
			&emsp;
			<i class="fa fa-check-circle" aria-hidden="true" style="color: #2cc71b; font-size: 12px;font-family:  Arial "></i> Inclus dans
			la liste &emsp;
			<i class="fa fa-times-circle" aria-hidden="true" style="color: #ff2b13; font-size: 12px;"></i> Non inclus
			dans la liste &emsp;
		</div>
	</div>
</div>
<br>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<table class="table" id="table-liste-clientZoom" style="font-size: x-small;width: 130% !important;">
		<thead>
			<tr>
				<th style="background-color:#4237b3; color:white" class="text-center">Date</th>
				<th style="background-color:#4237b3; color:white" class="text-center">CIN</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Nom et Prénoms</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Contact</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Etat</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Commune</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Quartier</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Centre de vote</th>
				<th style="background-color:#4237b3; color:white" class="text-center">BV Actuel</th>
				<th style="background-color:#4237b3; color:white" class="text-center">BV Original</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Observation</th>
				<th style="background-color:#4237b3; color:white" class="text-center">Par</th>
			</tr>
		</thead>
		<tbody>
			<!--Ajax-->
		</tbody>
	</table>
</div>


<div class="modal" id="modaladd" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:550px">
		<div class="modal-content" style='width:550px'>
			<div class="modal-header">
				<h5 class="modal-title">Ajout délégué</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style='width:550px' id="addDelegue">
				<form class="docs-search-form row gx-1 align-items-center" id="formAdd">
					<div class="col-6  mb-4">
						<label>Province</label>
						<select data-live-search=true id="faritany" name="fr">

							<?php
							$i = 0;
							foreach ($faritra as $key) {
								$sel = ($i == 0) ? "selected" : "";
								?>
								<option value="<?php echo $key->CODE_FARITANY ?>" <?php echo $sel ?>>
									<?php echo $key->LIBELLE_FARITANY ?>
								</option>
								<?php
								$i++;
							} ?>



						</select>
					</div>
					<div class="col-6  mb-4">
						<label>Région</label>


						<select data-live-search=true id="region" title="region" required name="rg">

							<?php
							$i = 0;
							foreach ($region as $key) {

								?>
								<option value="<?php echo $key->CODE_REGION ?>" selected>
									<?php echo $key->LIBELLE_REGION ?>
								</option>
								<?php
								$i++;
							}

							?>

						</select>

					</div>
					<div class="col-6 mb-4">
						<label>CIN</label>
						<input class="form-control basicAutoComplete" name="cin" type="text" maxlength="12"
							autocomplete="off">
					</div>
					<div class="col-6  mb-4">
						<label>Contact</label>
						<input type="number" id="Telephone" name="contact" style="width:100%;height:38px"
							class="form-control" placeholder="Contact">
					</div>
					<div class="col-12  mb-4">
						<label>Nom et prénoms</label>


						<div class="input-group">
							<input type="text" class="form-control" name="nom" id="nomprenom" autocomplete="off"
								placeholder="Nom et prenom" aria-describedby="inputGroupPrepend3" required>
							<div class="input-group-append">
								<span class="input-group-text btn btn-primary chearchName" id="inputGroupPrepend3"><i
										class="fa fa-search" aria-hidden="true"></i></span>
							</div>


						</div>
					</div>



					<div class="col-6  mb-4" id="">
						<label>District</label>


						<select data-live-search=true id="district" title="District" required name="ds">

						</select>

					</div>

					<div class="col-6  mb-4" id="">
						<label>Commune</label>



						<select data-live-search=true id="commune" title="Commune" required name="cm">


						</select>

					</div>
					<div class="col-6  mb-4">
						<label>Quartier</label>


						<select data-live-search=true id="fokontany" title="Quartier" required name="fk">


						</select>

					</div>
					<div class="col-6  mb-4">
						<label>Centre de vote</label>


						<select data-live-search=true id="cv" title="Centre de vote" required name="cv">


						</select>

					</div>
					<div class="col-6  mb-4">
						<label>BV Original</label>


						<select data-live-search=true id="bv" title="BV originnal" required name="bv">


						</select>

					</div>
					<div class="col-6  mb-4">
						<label>BV Actuel</label>


						<select data-live-search=true id="bva" title="Bureau de vote actuel" required name="bv_ac">


						</select>

					</div>
					<div class="col-12  mb-4">
						<label>Obervation</label>


						<textarea class="form-control" name="des" rows="2"></textarea>
					</div>



			</div>
			<div class="modal-footer" id="ioio">
				<button type="submit" class="btn btn-primary">Valider</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			</div>
		</div>
		</form>
	</div>
</div>
<div class="modal" id="modalRatach1" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style='width:1200px !important ;  margin-left: -28%;'>
			<div class="modal-header">
				<h5 class="modal-title">Liste des anomalies</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="contentRattach1">
				<div class="row">
					<div class="col-3"><i class="fa fa-circle" aria-hidden="true"
							style="color: #31bc31; font-size: 10px;"></i> Exclus de la liste electorale</div>
					<div class="col-3"><i class="fa fa-circle" aria-hidden="true"
							style="color: #ff9914; font-size: 10px;"></i> Inclus dans la liste de délégué</div>
					<div class="col-3"><i class="fa fa-circle" aria-hidden="true"
							style="color: #000aff; font-size: 10px;"></i> BV # pour ce n° CIN</div>
					<div class="col-3"><i class="fa fa-circle" aria-hidden="true"
							style="color: #f70505; font-size: 10px;"></i> BV exclus de la commune</div>
				</div>
				<table class="table table-sm" id="tbl_anomalie"
					style="font-size: x-small; margin-top: 20px;  margin-left: 10px;">
					<thead style='background-color: #333; color: #fff;'>
						<tr>
							<th style="background-color:#4237b3; color:white">BV</th>
							<th style="background-color:#4237b3; color:white">Nom</th>
							<th style="background-color:#4237b3; color:white">Prénoms</th>
							<th style="background-color:#4237b3; color:white">CIN</th>
							<th style="background-color:#4237b3; color:white">Contact</th>
							<th style="background-color:#4237b3; color:white">Date</th>
							<th style="background-color:#4237b3; color:white">Anomalie</th>

						</tr>
					</thead>
					<tbody></tbody>

				</table>
			</div>


		</div>
	</div>
</div>



<div class="modal" id="modaladdExcel" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:550px">
		<form class="docs-search-form row gx-1 align-items-center" id="formAddExcel">
			<div class="modal-content" style='width:550px'>
				<div class="modal-header">
					<h5 class="modal-title">Importation fichier Excel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style='width:550px' id="addDelegueExcel">



					<div class="col-12 mb-4">
						<label>Région</label>


						<select data-live-search=true id="regionExcel" title="region" data-size='7' name="rg">

							<?php
							$i = 0;
							foreach ($regions as $key) {

								?>
								<option value="<?php echo $key->CODE_REGION ?>" selected>
									<?php echo $key->LIBELLE_REGION ?>
								</option>
								<?php
								$i++;
							}

							?>

						</select>
						<select data-live-search=true id="type" title="region" data-size='7' name="type">

								<option value="3" selected>3</option>
								<option value="4">4</option>

						</select>
					</div>
					<div class="col-12 mb-4">
						<label>Entete : CIN , BV , Nom prenom , Telephone </label>
						<input class="form-control" name="excel" required type="file">
					</div>

				</div>
				<div class="modal-footer" id="ioioExecl">
					<button type="submit" class="btn btn-primary">Importer</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal" id="modaladdExcel" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:550px">
		<form class="docs-search-form row gx-1 align-items-center" id="formAddExcel">
			<div class="modal-content" style='width:550px'>
				<div class="modal-header">
					<h5 class="modal-title">Importation fichier Excel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style='width:550px' id="addDelegueExcel">



					<div class="col-12 mb-4">
						<label>Région</label>


						<select data-live-search=true id="regionExcel" title="region" data-size='7' name="rg">

							<?php
							$i = 0;
							foreach ($regions as $key) {

								?>
								<option value="<?php echo $key->CODE_REGION ?>" selected>
									<?php echo $key->LIBELLE_REGION ?>
								</option>
								<?php
								$i++;
							}

							?>

						</select>
						<select data-live-search=true id="type" title="region" data-size='7' name="type">

								<option value="3" selected>3</option>
								<option value="4">4</option>

						</select>
					</div>
					<div class="col-12 mb-4">
						<label>Entete : CIN , BV , Nom prenom , Telephone </label>
						<input class="form-control" name="excel" required type="file">
					</div>

				</div>
				<div class="modal-footer" id="ioioExecl">
					<button type="submit" class="btn btn-primary">Importer</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal" id="modaladdExcelupdate" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="width:550px">
		<form class="docs-search-form row gx-1 align-items-center" >
			<div class="modal-content" style='width:550px'>
				<div class="modal-header">
					<h5 class="modal-title">Importation fichier Excel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style='width:550px' id="addDelegueExcelupdate">


				<select data-live-search=true id="type" title="region" data-size='7' name="type">

<option value="3" selected>3</option>
<option value="4">4</option>

</select>
					
					<div class="col-12 mb-4">
						
						<input class="form-control" name="excel1" required type="file" id="filejsimport">
					</div>

				</div>
				<div class="modal-footer" id="ioioExeclupdate">
					<button type="submit" class="btn btn-primary">Importer</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</form>
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
					url: '<?php echo site_url('Utilisateurs/listerDeleger'); ?>',
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

	jQuery(document).ready(function ($) {

		listeContratZoom();

	});
</script>
