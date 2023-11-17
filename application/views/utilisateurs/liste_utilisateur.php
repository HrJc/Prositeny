<style>

	#table-liste-clientZoom_paginate{
			font-size : 10px;
			float: left;
		}
</style>
<br>
<div class="row" id="filter" style="margin:4px">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<form class="form-inline" role="form" method="POST" id="form-fac-zoom">
			<button type="button" class="btn btn-success btn-sm" style="margin-left: 5px; color:white" onclick="gestionCrudClient(0)">
			  	<i class="fa fa-plus"></i> Nouvel/le utilisateur(e)
			</button>
			<button type="button" class="btn btn-success btn-sm" style="margin-left: 5px; color:white" onclick="pdfClient()">
			  	<i class="fa fa-plus"></i> Nouvel/le utilisateur(e)
			</button>
    </div>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	</div> 
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		
	</div> 
</div>
<br>
<div class="row" style="margin:5px">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<table class="table" id="table-liste-clientZoom" style = "overflow: scroll;position: static;zoom: 1;font-size: x-small;">
			<thead>
				<tr>
					<th style="background-color:#4237b3; color:white" class="text-center">Nom et Prénoms</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Email</th>
					<th style="background-color:#4237b3; color:white" class="text-center">Région</th>
				</tr>
			</thead>
			<tbody>
				<!--Ajax-->
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="modal-contrat">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="entete-modal-client">Nouvel/le Utilisateur(e)</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body" >
			<form method="POST" id="form-client-zoom">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Nom :</small></label>
                            <input type="text" name="nom-user" id="nom-user" class="form-control input-sm" required="required">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Prénom :</small></label>
                            <input type="text" name="prenom-user" id="prenom-user" class="form-control input-sm text-center" min="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>CIN :</small></label>
                            <input type="number" name="cin-user" id="cin-user" class="form-control input-sm" required="required">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Adresse :</small></label>
                            <input type="text" name="adresse-user" id="adresse-user" class="form-control input-sm text-center" min="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Téléphone :</small></label>
                            <input type="text" name="tel-user" id="tel-user" class="form-control input-sm" required="required">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Email :</small></label>
                            <input type="text" name="email-user" id="email-user" class="form-control input-sm text-center" min="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Région :</small></label>
                            <select   data-live-search= true name = "region-user[]" multiple>
								<?php foreach ($region as $key => $value) { ?>
                                    <option value="<?php echo $value->CODE_REGION ?>"><?php echo $value->LIBELLE_REGION ?></option>
                               <?php } ?>
										  
							</select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Type :</small></label>
                            <select   data-live-search= true name ="type-user">
                                <option value="Administrateur">Administrateur</option>    
                                <option value="Personnel">Personnel</option>    
							</select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Nouveau mot de passe :</small></label>
                            <input type="password" name="pwd-user" id="pwd-user" class="form-control input-sm" required="required">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><small>Re-taper le mot de passe :</small></label>
                            <input type="password" name="re-pwd-user" id="re-pwd-user" class="form-control input-sm" required>
                        </div>
                    </div>
                </div>
				<button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
			</form>
			</div>
			<div class="modal-footer" id="foot-modal-client">
			</div>
		</div>
	</div>
</div>
</div>

<script>

	function gestionCrudClient(idCrud)
	{
			$('#entete-modal-client').text("Ajout NOUVEAU UTILISATEUR");
			$('#modal-contrat').modal('show');
			$('#typeCrud-client').val(idCrud);
	}

	function pdfClient()
	{	
		var lien = 'test';	
		$.ajax({
			url : '<?php echo site_url('Utilisateurs/pdfUtilisateur'); ?>',
			type: "POST", 
			dataType: "JSON",
			success : function (result) {			
				window.open('<?php echo site_url('uploads/pdf/'); ?>'+result.lien+".pdf");
			},
			error: function (jqXHR, textStatus, errorThrown){
				window.open('<?php echo site_url('uploads/pdf/'); ?>'+lien+".pdf");
			}
		});		
	}
	

    function listeContratZoom1()
	{
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
	              "autoWidth": true,
	              "preDrawCallback": function (settings) {
					
					$('#table-liste-clientZoom').unblock();
				  
	              },
				  
	              "ajax" : {
                    url : '<?php echo site_url('Utilisateurs/listerUtilisateur'); ?>',
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

	$("form").on("submit",function(event){
		event.preventDefault();
		var data = $(this).serialize();
		var typeCRUD = 0;
		var urls = "<?php echo site_url('Utilisateurs/ajouterClientZoom'); ?>";
		$.ajax({
			type: "POST",
			url: urls,
			data: data,
			dataType: "JSON",
			beforeSend: function(){
				$('#foot-modal-client *').prop('disabled', true);
			},
			success: function(result){
				swal({
					text: result.message,
					icon: "Success",
					button: "Ok",
					});
				$('#form-client-zoom').trigger("reset");
				$('#foot-modal-client *').prop('disabled', false);
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseText);
				$('#foot-modal-client *').prop('disabled', false);
			}
		});

	})	


    jQuery(document).ready(function($) {     
		
		listeContratZoom1();

    });
</script>