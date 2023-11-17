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

<label style="margin: 20px;"><strong>DASHBOARD</strong></label>
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers" ><strong id="open"></strong></div>
                        <div class="cardName">OPEN</div>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="tache"><strong id="close"></strong></div>
                        <div class="cardName">CLOSE</div>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="reste"><strong id="comptant"></strong></div>
                        <div class="cardName">COMPTANT</div>
                    </div>
                </div>
<!-- 
                <div class="card">
                    <div>
                        <div class="numbers">$7,842</div>
                        <div class="cardName">Earning</div>
                    </div>
                </div> -->
            </div>

<div class="row" style = "margin:10px">
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
	<h6>BUREAU DE VOTE FERME</h6>
		<table class="table" id="table-liste-non" style="font-size: x-small;width: 100% !important;">
			<thead>
				<tr>
					<th style="background-color:#4237b3; color:white" class="text-center">Commune</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Code BV</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Libellé BV</th>
				</tr>
			</thead>
			<tbody >
				<!--Ajax-->
			</tbody>
		</table>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
		<h6>BUREAU DE VOTE OUVERT</h6>
		<table class="table" id="table-liste-valide" style="font-size: x-small;width: 100% !important;">
			<thead>
				<tr>
					<th style="background-color:#4237b3; color:white" class="text-center">Numéro</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Commune</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Code BV</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Libellé BV</th>
				</tr>
			</thead>
			<tbody >
				<!--Ajax-->
			</tbody>
		</table>
	</div>
	
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
	<h6>BUREAU DE VOTE EN COMPTANT</h6>
		<table class="table" id="table-liste-comptant" style="font-size: x-small;width: 100% !important;">
			<thead>
				<tr>
					<th style="background-color:#4237b3; color:white" class="text-center">Numéro</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Commune</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Libellé BV</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Code BV</th>
				</tr>
			</thead>
			<tbody >
				<!--Ajax-->
			</tbody>
		</table>
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
		            },dataSrc: function (data) 
					{
						$("#open").html(data.count);
						
						return data.data;
					}
	            },
					
	    });

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		$('#table-liste-valide_wrapper').find('#table-liste-valide_filter').css('display', 'none');
	}

	function listeComptant() {

		var table = $("#table-liste-comptant")
			.on('preXhr.dt', function ( e, settings, data ) {
				$('#table-liste-comptant').block({
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
					
					$('#table-liste-comptant').unblock();
				  
	              },
				  
	              "ajax" : {
                    url : adresse + 'Utilisateurs/listerMessageComptant',
                    dataType : "JSON",
        			data: { fr: $("#faritanyFiltre").val(), rg: $("#regionFiltre").val(), ds: $("#districtFiltre").val() },
					
                    error: function (xhr, error, code){
                    	$('#table-liste-comptant TBODY').html('');
		                console.log(xhr.responseText);
		            },dataSrc: function (data) 
					{
						$("#comptant").html(data.count);
						
						return data.data;
					}
	            },
					
	    });

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		$('#table-liste-comptant_wrapper').find('#table-liste-comptant_filter').css('display', 'none');
	}

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
		            },dataSrc: function (data) 
					{
						$("#close").html(data.count);
						
						return data.data;
					}
	            },
					
	    });

		$('#myInputTextField').keyup(function () {
			table.search($(this).val()).draw();
		});

		$('#table-liste-non_wrapper').find('#table-liste-non_filter').css('display', 'none');
	}

	jQuery(document).ready(function ($) {

		listeContratvote();
		listenon();
		listeComptant();

	});
</script>
