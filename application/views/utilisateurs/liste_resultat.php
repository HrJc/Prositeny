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
		width: 150px; /* ajustez la largeur selon vos besoins */
		height: 150px; /* ajustez la hauteur selon vos besoins */
	}

</style>
<label style="margin: 20px;"><strong>RESULTAT DE L'ELECTION PRESIDENTIELLE 2023</strong></label>
<br>
<div class="row" style="margin:10px">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label><strong>Région :</strong></label>
		<select data-live-search="true" name="regionFiltrevote" id="regionFiltrevote">
			<option value=""></option>
			<?php foreach ($region as $key => $value) { ?>
				<option value="<?php echo $value->CODE_REGION ?>"><?php echo  $value->LIBELLE_REGION ?></option>
			<?php } ?>
		</select>
		<label><strong>District :</strong></label>
		<select data-live-search=true id="districtFiltrevote" title="District" required name="ds">
			<option value="tous" selected>Tous</option>
		</select>&emsp;
		<label><strong>commnune :</strong></label>
		<select data-live-search=true id="communeFiltrevote" title="District" required name="ds">
			<option value="tous" selected>Tous</option>
		</select>&emsp;
		<label><strong>Bureau de vote :</strong></label>
		<select data-live-search=true id="bvFiltrevote" title="District" required name="ds">
			<option value="tous" selected>Tous</option>
		</select>&emsp;
	</div>
	
</div>

<br>

<div class="row" style="margin:10px">
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	<div class="card">
	<h5 class="card-header">SMS</h5>
	<ul class="list-unstyled card-body mb-0 pb-0">
		<li><strong>Total BV : <span class="totalBV"></span></strong></li>
		<li><strong>Total : <span class="totalsum"></span></strong></li>
		<li><strong>Voix 13 : <span class="total13"></span></strong></li>
		<li><strong>Voix 05 : <span class="total5"></span></strong></li>
		<li><strong>Voix 03 : <span class="total3"></span></strong></li>		
	</ul>
	</div>
</div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	<div class="card">
	<h5 class="card-header">RESULTAT</h5>
	<ul class="list-unstyled card-body mb-0 pb-0">
		<li class="media mb-3">
		<img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/13.jpg" />
		<div class="media-body align-self-center">
			<strong>13 - Siteny Thierry Randrianasoloniaiko</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum13"></span> Voting : <span class="total13"> </span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			<div class="progress-bar" id="sum13" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
		</li>
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/3.jpg" />
		  <div class="media-body align-self-center">
			<strong>3 - Andry Nirina Rajoelina</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum3"></span> Voting : <span class="total3"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum3" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>		
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/5.jpg" />
		  <div class="media-body align-self-center">
			<strong>5 - Marc Ravalomanana</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum5"></span> Voting : <span class="total5"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum5" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>
		
	  </ul>
	</div>
</div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

</div>
</div>

<br>




<script>

	$("#regionFiltrevote").on('change', function() {
        choixRegionFiltre1();
    });

    $("#districtFiltrevote").on('change', function() {
        choixCommunes();
    });
	
    $("#communeFiltrevote").on('change', function() {
        choixBVs();
    });

    $("#bvFiltrevote").on('change', function() {
        listeContratvote();
    });

    function choixRegionFiltre1() {
        var id = $("#regionFiltrevote").val();
        $.ajax({
            url: '<?php echo base_url('Utilisateurs/chargeDistrict2'); ?>',
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $("#districtFiltrevote").empty();
                $("#districtFiltrevote").append(data);
                var selectpickerElement = $('#districtFiltrevote').eq(0);

                // Sélectionnez la première option de la liste déroulante
                var firstOption = selectpickerElement.find('option').eq(0);

                // Sélectionnez la première valeur de la liste déroulante
                var firstValue = firstOption.val();

                // Appliquez la sélection au selectpicker
                selectpickerElement.selectpicker('val', firstValue);
                $('select').selectpicker('refresh');

                // choixDistrict();
                // $("#district").on("change", function name(params) {

                //     choixDistrict();
                // });
            }
        });

    }

    function choixCommunes() {
		alert('ok');
        var id = $("#districtFiltrevote").val();
        $.ajax({
            url: '<?php echo base_url('Utilisateurs/chargeCommune'); ?>',
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $("#communeFiltrevote").empty();
                $("#communeFiltrevote").append(data);
                var selectpickerElement = $('#communeFiltrevote').eq(0);

                // Sélectionnez la première option de la liste déroulante
                var firstOption = selectpickerElement.find('option').eq(0);

                // Sélectionnez la première valeur de la liste déroulante
                var firstValue = firstOption.val();

                // Appliquez la sélection au selectpicker
                selectpickerElement.selectpicker('val', firstValue);
                $('select').selectpicker('refresh');

                // choixDistrict();
                // $("#district").on("change", function name(params) {

                //     choixDistrict();
                // });
            }
        });

    }

    function choixCommunes() {
        var id = $("#districtFiltrevote").val();
        $.ajax({
            url: '<?php echo base_url('Utilisateurs/chargeCommune'); ?>',
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $("#communeFiltrevote").empty();
                $("#communeFiltrevote").append(data);
                var selectpickerElement = $('#communeFiltrevote').eq(0);

                // Sélectionnez la première option de la liste déroulante
                var firstOption = selectpickerElement.find('option').eq(0);

                // Sélectionnez la première valeur de la liste déroulante
                var firstValue = firstOption.val();

                // Appliquez la sélection au selectpicker
                selectpickerElement.selectpicker('val', firstValue);
                $('select').selectpicker('refresh');

                // choixDistrict();
                // $("#district").on("change", function name(params) {

                //     choixDistrict();
                // });
            }
        });

    }

	function choixBVs() {
        var id = $("#communeFiltrevote").val();
        $.ajax({
            url: '<?php echo base_url('Utilisateurs/chargeBVS'); ?>',
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $("#bvFiltrevote").empty();
                $("#bvFiltrevote").append(data);
                var selectpickerElement = $('#bvFiltrevote').eq(0);

                // Sélectionnez la première option de la liste déroulante
                var firstOption = selectpickerElement.find('option').eq(0);

                // Sélectionnez la première valeur de la liste déroulante
                var firstValue = firstOption.val();

                // Appliquez la sélection au selectpicker
                selectpickerElement.selectpicker('val', firstValue);
                $('select').selectpicker('refresh');

                // choixDistrict();
                // $("#district").on("change", function name(params) {

                //     choixDistrict();
                // });
            }
        });

    }
	

	// function gestionCrudClient(idCrud) {
	// 	if (parseInt(idCrud) != 0) {
	// 		$('#entete-modal-client').text("Modification NOUVEAU UTILISATEUR");
	// 		modalModifClient(idCrud);
	// 		$('#typeCrud-client').val(idCrud);
	// 	}
	// 	else {
	// 		$('#entete-modal-client').text("AJOUT NOUVEL UTILISATEUR");
	// 		$('#form-client-zoom')[0].reset();
	// 		$('#modal-contrat').modal('show');
	// 		$('#typeCrud-client').val(idCrud);
	// 	}
	// }
	function listeContratvote() {
		var id = $("#bvFiltrevote").val();
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/listerVote'); ?>',
			type: "POST",
			data: {
                id: id
            },
			dataType : "JSON",
			success: function (data) {
				$('.totalsum').text(data.resultat.totalsum);
				$('.total3').text(data.resultat.total3);
				$('.total5').text(data.resultat.total5);
				$('.total13').text(data.resultat.total13);
				$('.totalBV').text(data.resultat.count);
				for (let i = 1; i < 14; i++) {							
					var propertyName = 'sum' + i;
					var progress = data.resultat[propertyName];
					$('#sum' + i).css('width', progress);
					$('#textsum' + i).html(progress);
					$('#sum' + i).attr('aria-valuenow', progress);
				}
			}
		});

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		// $('#table-liste-vote_wrapper').find('#table-liste-vote_filter').css('display', 'none');
	}

	setInterval(listeContratvote, 1000);

	jQuery(document).ready(function ($) {

	

		listeContratvote();

	});
</script>
