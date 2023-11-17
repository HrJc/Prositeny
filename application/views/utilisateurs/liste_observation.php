<style>
    .btn btn-success{
        color: white;
    }
</style>
<div class="row" id="filter" style="background-color: #ffffff;/* margin: 20px; */">
	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
	</div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="input-group mb-3" style="margin: 10px; float:right">
			<input type="text" class="form-control" placeholder="Recherche" id="myInputTextField">
		</div>
	</div>
</div>
<br>

<div class="row" >
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-striped table-hover" id="table-liste-clientZoom" style="width: 100%; margin-left: 10px;margin-right: 10px;">
			<thead>
				<tr>
					<th class="text-center">Date</th>
					<th class="text-center">CIN</th>
					<th class="text-center">Nom et Prénoms</th>
					<th class="text-center">Centre de vote</th>
					<th class="text-center">BV Original</th>
					<th class="text-center">BV Actuel</th>
					<th class="text-center">Quartier</th>
					<th class="text-center">Commune</th>
					<th class="text-center">Etat</th>
					<th class="text-center">Par</th>
					<th class="text-center"></th>
				</tr>
			</thead>
			<tbody>
				<!--Ajax-->
			</tbody>
		</table>
	</div>
</div>

<div class="modal" id="modaladd" tabindex="-1" role="dialog" >
<div class="modal-dialog modal-lg" role="document" style="width:550px">
	<div class="modal-content"  style='width:550px'>
	<div class="modal-header">
		<h5 class="modal-title">Ajout délégué</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body" style='width:550px'>
		<form class="docs-search-form row gx-1 align-items-center" id="formAdd">
		<div class="col-6  mb-4">
									<label>Province</label>
									<select    data-live-search= true id="faritany" name="fr">
										
										<?php
											foreach ($faritra as $key) {
											?>
													<option value="<?php echo $key->CODE_FARITANY ?>"><?php echo $key->LIBELLE_FARITANY ?></option>
											<?php
											}

										?>
										
										
								
									</select>
								</div>
								<div class="col-6  mb-4" >
									<label>Région</label>
									<div id="region1">
									
										<select   data-live-search= true id="region">
									
										<?php
											foreach ($region as $key) {
											?>
													<option value="<?php echo $key->CODE_REGION ?>"><?php echo $key->LIBELLE_REGION ?></option>
											<?php
											}

										?>
								
										</select>
										</div>
								</div>
							<div class="col-6 mb-4">
								<label>CIN</label>
								<input class="form-control basicAutoComplete" name="cin" type="text" maxlength = "12" autocomplete="off"></div>
							<div class="col-6  mb-4">
									<label>Contact</label>
									<input type="number" id="Telephone" name="contact" style="width:100%;height:38px" class="form-control" placeholder="Contact">
									</div>
								<div class="col-12  mb-4">
								<label>Nom et prénoms</label>
								
								
								<div class="input-group">
									<input type="text" class="form-control" name="nom" id="nomprenom" autocomplete="off" placeholder="Nom et prenom" aria-describedby="inputGroupPrepend3" required>
									<div class="input-group-append">
										<span class="input-group-text btn btn-primary chearchName"  id="inputGroupPrepend3"><i class="fa fa-search" aria-hidden="true"></i></span>
									</div>
									
									
								</div>
								</div>
							
								
								
								<div class="col-6  mb-4" id="">
									<label>District</label>
										<div id="district1">
									
											<select   data-live-search= true >
									
											</select>
										</div>
								</div>

								<div class="col-6  mb-4" id="">
									<label>Commune</label>
									
									<div id="commune1">
									
									<select   data-live-search= true >
									
							
									</select>
									</div>
								</div>
								<div class="col-6  mb-4">
									<label>Quartier</label>
									<div id="fokontany1">
									
										<select   data-live-search= true >
									
								
										</select>
										</div>
								</div>
								<div class="col-6  mb-4">
									<label>Centre de vote</label>
									<div id="cv1">
									
										<select   data-live-search= true >
									
								
										</select>
										</div>
								</div>
								<div class="col-6  mb-4">
									<label>BV Original</label>
									<div id="bvo1">
									
										<select   data-live-search= true >
									
								
										</select>
										</div>
								</div>
								<div class="col-6  mb-4">
									<label>BV Actuel</label>
									<div id="bva1">
									
										<select   data-live-search= true >
									
								
										</select>
										</div>
								</div>
								<div class="col-12  mb-4">
									<label>Obervation</label>
									
									
									<textarea class="form-control" name="des" rows="2"></textarea>
								</div>
						
							
						
				</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Valider</button>
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
            success: function(data) {
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
            success: function(data) {
                $("#distrika").html(data);
                $('select').selectpicker('refresh');
            }
        });
    }

function gestionCrudClient(idCrud)
	{
		if(parseInt(idCrud) != 0)
		{
			$('#entete-modal-client').text("Modification NOUVEAU UTILISATEUR");
			modalModifClient(idCrud);
			$('#typeCrud-client').val(idCrud);
		}
		else
		{
			$('#entete-modal-client').text("Ajout NOUVEAU UTILISATEUR");
			$('#form-client-zoom')[0].reset();
			$('#modal-contrat').modal('show');
			$('#typeCrud-client').val(idCrud);
		}
	}
    function listeContratZoom()
	{
		var table = $("#table-liste-clientZoom")
	    .on('preXhr.dt', function ( e, settings, data ) {
	    	//$('#col-entete-zoom *').prop('disabled', true);
	    })
	    .DataTable({
            "sPaginationType": "bs_normal",
                "ordering": true,
                "info":     false,
                "bPaginate": false,
                "searching": true,
                "bDestroy": true,
                "autoWidth": true,
                "buttons": [
                            {
                                extend: 'excel',
                                text: 'Save current page',
                                exportOptions: {
                                    modifier: {
                                        page: 'current'
                                    }
                                }
                            }
                        ],
                "preDrawCallback": function (settings) {
                },

                "ajax" : {
                url : '<?php echo site_url('Utilisateurs/listerObservation'); ?>',
                type : 'POST',
                error: function (xhr, error, code){
                    $('#table-liste-clientZoom TBODY').html('');
                    console.log(xhr.responseText);
                }
            }
	    });

	    $('#myInputTextField').keyup(function(){
	          table.search($(this).val()).draw() ;
	    })

	    $('#table-liste-clientZoom_wrapper').find('#table-liste-clientZoom_filter').css('display', 'none');
	}

    jQuery(document).ready(function($) {

        listeContratZoom();        

    });
</script>