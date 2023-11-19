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

	.text-muted {
		color: #000000 !important;
	}

</style>
<label style="margin: 20px;font-size:28px""><strong>RESULTAT PAR BV DE L'ELECTION PRESIDENTIELLE</strong></label>
<br>
<div class="row" style="margin:10px">
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="card">
		<h5 class="card-header"></h5>
			<ul class="list-unstyled card-body mb-0 pb-0">
				<li><strong>TOTAL BV : <span class="totalBV"></span></strong></li>
				<li><strong>Votants : <span class="totalsum"></span></strong></li>
				<li><strong>Blancs et Nuls : <span class="blanc"></span></strong></li>
			</ul>
		</div>
	</div>	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="card">
		<h5 class="card-header"></h5>
			<ul class="list-unstyled card-body mb-0 pb-0">
				<li><strong>Suffrages exprimés: : <span class=""></span></strong></li>
				<li><strong>Taux de participation : <span class=""></span></strong></li>
				<li><strong>Voix 01 : <span class="total1"></span></strong></li>
			</ul>
		</div>
	</div>	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="card">
			<h5 class="card-header"></h5>
			<ul class="list-unstyled card-body mb-0 pb-0">
				<li><strong>Voix 02 : <span class="total2"></span></strong></li>
				<li><strong>Voix 03 : <span class="total3"></span></strong></li>
				<li><strong>Voix 04 : <span class="total4"></span></strong></li>
			</ul>
		</div>
	</div>	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="card">
			<h5 class="card-header"></h5>
			<ul class="list-unstyled card-body mb-0 pb-0">
				<li><strong>Voix 05 : <span class="total5"></span></strong></li>
				<li><strong>Voix 06 : <span class="total6"></span></strong></li>
				<li><strong>Voix 07 : <span class="total7"></span></strong></li>
			</ul>
		</div>
	</div>	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="card">
			<h5 class="card-header"></h5>
			<ul class="list-unstyled card-body mb-0 pb-0">
				<li><strong>Voix 08 : <span class="total8"></span></strong></li>
				<li><strong>Voix 09 : <span class="total9"></span></strong></li>
				<li><strong>Voix 10 : <span class="total10"></span></strong></li>
			</ul>
		</div>
	</div>	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="card">
			<h5 class="card-header"></h5>
			<ul class="list-unstyled card-body mb-0 pb-0">
				<li><strong>Voix 11 : <span class="total11"></span></strong></li>
				<li><strong>Voix 12 : <span class="total12"></span></strong></li>
				<li><strong>Voix 13 : <span class="total13"></span></strong></li>
			</ul>
		</div>
	</div>	
</div>
<br>
<div class="row" style="margin:10px">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">		
		<label><strong>Bureau de vote :</strong></label>
		<select data-live-search=true id="bvFiltrevote" title="District" required name="ds">
				<option value=""></option>
			<?php foreach ($region as $key => $value) { ?>
				<option value="<?php echo $value->CODE_BV ?>"><?php echo $value->LIBELLE_DISTRICT. ' - ' .$value->LIBELLE_COMMUNE. ' - ' .$value->LIBELLE_BV ?></option>
			<?php } ?>
		</select>&emsp;
	</div>
	
</div>

<div class="row" style="margin:10px">
<!-- <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
	<div class="card">
	<h5 class="card-header"></h5>
	<ul class="list-unstyled card-body mb-0 pb-0">
		<li><strong>Total BV : <span class="totalBV"></span></strong></li>
		<li><strong>Total : <span class="totalsum"></span></strong></li>
		<li><strong>Voix 13 : <span class="total13"></span></strong></li>
		<li><strong>Voix 12 : <span class="total12"></span></strong></li>
		<li><strong>Voix 11 : <span class="total11"></span></strong></li>
		<li><strong>Voix 10 : <span class="total10"></span></strong></li>
		<li><strong>Voix 09 : <span class="total9"></span></strong></li>
		<li><strong>Voix 08 : <span class="total8"></span></strong></li>
		<li><strong>Voix 07 : <span class="total7"></span></strong></li>
		<li><strong>Voix 06 : <span class="total6"></span></strong></li>
		<li><strong>Voix 05 : <span class="total5"></span></strong></li>
		<li><strong>Voix 04 : <span class="total4"></span></strong></li>
		<li><strong>Voix 03 : <span class="total3"></span></strong></li>
		<li><strong>Voix 02 : <span class="total2"></span></strong></li>
		<li><strong>Voix 01 : <span class="total1"></span></strong></li>		
	</ul>
	</div>
</div> -->
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<div class="card">
	<h5 class="card-header"></h5>
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
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/10.jpg" />
		  <div class="media-body align-self-center">
			<strong>10 - Hery Martial Rajaonarimampianina Rakotoarimanana</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum5"></span> Voting : <span class="total10"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum10" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>
		
	  </ul>
	</div>
</div>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<div class="card">
	<h5 class="card-header"></h5>
	<ul class="list-unstyled card-body mb-0 pb-0">
		<li class="media mb-3">
		<img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/1.jpg" />
		<div class="media-body align-self-center">
			<strong>1 - Tahina Razafinjoelina</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum1"></span> Voting : <span class="total1"> </span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			<div class="progress-bar" id="sum1" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
		</li>
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/2.jpg" />
		  <div class="media-body align-self-center">
			<strong>2 - Hajo Herivelona Andrianainarivelo</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum2"></span> Voting : <span class="total2"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum2" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>		
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/4.jpg" />
		  <div class="media-body align-self-center">
			<strong>4 - Roland Ratsirakaa</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum4"></span> Voting : <span class="total4"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum4" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>		
		
	  </ul>
	</div>
</div>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<div class="card">
	<h5 class="card-header"></h5>
	<ul class="list-unstyled card-body mb-0 pb-0">
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/6.jpg" />
		  <div class="media-body align-self-center">
			<strong>6 - Auguste Richard Paraina</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum6"></span> Voting : <span class="total6"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum6" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>
		<li class="media mb-3">
		<img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/7.jpg" />
		<div class="media-body align-self-center">
			<strong>7 - Andry Tsiverizo Raobelina Andriamalala</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum7"></span> Voting : <span class="total7"> </span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			<div class="progress-bar" id="sum17" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
		</li>
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/8.jpg" />
		  <div class="media-body align-self-center">
			<strong>8 - Jean Brunelle Razafintsiandraofa</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum3"></span> Voting : <span class="total8"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum8" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>		
		
		
		
	  </ul>
	</div>
</div>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<div class="card">
	<h5 class="card-header"></h5>
	<ul class="list-unstyled card-body mb-0 pb-0">
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/9.jpg" />
		  <div class="media-body align-self-center">
			<strong>9 - Lalaina Harilanto Ratsirahonana</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum9"></span> Voting : <span class="total9"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum9" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>
		<li class="media mb-3">
		<img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/11.jpg" />
		<div class="media-body align-self-center">
			<strong>11 - Sendrison Daniela Raderanirina</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum13"></span> Voting : <span class="total11"> </span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			<div class="progress-bar" id="sum11" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
		</li>
		<li class="media mb-3">
		  <img class="rounded mr-3 align-self-center image-icon" src="<?php echo base_url() ?>assets/candidat/12.jpg" />
		  <div class="media-body align-self-center">
			<strong>12 - Jean-Jacques Jedidia Ratsietison</strong>
			<div class="small text-muted mb-1">Taux : <span id="textsum3"></span> Voting : <span class="total12"></span> / <span class="totalsum"></span></div>
			<div class="progress mb-1" style="height: 10px;">
			  <div class="progress-bar" id="sum12" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		  </div>
		</li>		
				
	  </ul>
	</div>
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
		var bv = $("#bvFiltrevote").val();
		$.ajax({
			url: '<?php echo site_url('Utilisateurs/listerVoteGlo1'); ?>',
			type: "POST",
			data: {
				bv: bv
            },
			dataType : "JSON",
			success: function (data) {
				console.log(data);
				$('.totalsum').text(data.resultat.totalsum);
				$('.totalBV').text(data.resultat.count);
				$('.blanc').text(data.resultat.blanc);
				for (let i = 1; i < 14; i++) {							
					var propertyName = 'sum' + i;
					var Name = 'total' + i;
					$('.total' + i).text(data.resultat[Name]);
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

	jQuery(document).ready(function ($) {

		// listeContratvote();

	});
</script>
