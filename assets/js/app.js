'use strict';

$(document).ready(function() {
    $("select").selectpicker();
});

choixfaritanyFiltre();
choixRegionFiltre();
choixfaritany();
choixRegion();



function choixfaritany() {
    $.ajax({
        url: adresse + 'AdminCont/chargeRegion',
        type: "POST",
        data: {
            id: $("#faritany").val()
        },
        success: function(data) {
            $("#region").empty();
            $("#region").append(data);
            //$('#region').val(11);

            var selectpickerElement = $('#region').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);

            $('select').selectpicker('refresh');


            // if (coder != 0) {

            //     $('#region').val(coder);
            //     $('#region').selectpicker('refresh');
            //     choixCinaPRES();
            // }

            // choixRegion();
        }
    });
}

function choixfaritanyFiltre() {
    if ($("#faritanyFiltre").val() == "tous") {
        $("#regionFiltre  option[value!='tous']").remove();
        $("#districtFiltre  option[value!='tous']").remove();
        $('#regionFiltre').selectpicker('val', []);
        $("#regionFiltre").val("tous");
        $('#regionFiltre').selectpicker('refresh');
    } else {
        $.ajax({
            url: adresse + 'AdminCont/chargeRegion1',
            type: "POST",
            data: {
                id: $("#faritanyFiltre").val()
            },
            success: function(data) {
                $("#regionFiltre").empty();
                $("#regionFiltre").append(data);
                //$('#region').val(11);

                var selectpickerElement = $('#regionFiltre').eq(0);

                // Sélectionnez la première option de la liste déroulante
                var firstOption = selectpickerElement.find('option').eq(0);

                // Sélectionnez la première valeur de la liste déroulante
                var firstValue = firstOption.val();

                // Appliquez la sélection au selectpicker
                selectpickerElement.selectpicker('val', firstValue);

                $('select').selectpicker('refresh');


                // if (coder != 0) {

                //     $('#region').val(coder);
                //     $('#region').selectpicker('refresh');
                //     choixCinaPRES();
                // }

                // choixRegion();
            }
        });

    }

}

function choixRegion() {
    $.ajax({
        url: adresse + 'AdminCont/chargeDistrict',
        type: "POST",
        data: {
            id: $("#region").val()
        },
        success: function(data) {
            $("#district").empty();
            $("#district").append(data);
            var selectpickerElement = $('#district').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);
            $('select').selectpicker('refresh');
            if (coded) {
                $('#district').selectpicker('refresh');
                $('#district').selectpicker('val', coded);

            }
            // choixDistrict();
            // $("#district").on("change", function name(params) {

            //     choixDistrict();
            // });
        }
    });

}

function choixRegionFiltre() {
    $.ajax({
        url: adresse + 'AdminCont/chargeDistrict1',
        type: "POST",
        data: {
            id: $("#regionFiltre").val()
        },
        success: function(data) {
            $("#districtFiltre").empty();
            $("#districtFiltre").append(data);
            var selectpickerElement = $('#districtFiltre').eq(0);

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


function choixDistrict() {
    $.ajax({
        url: adresse + 'AdminCont/chargeCommune',
        type: "POST",
        data: {
            id: (coded) ? coded : $("#district").val()
        },
        success: function(data) {
            $("#commune").empty();
            $("#commune").append(data);

            var selectpickerElement = $('#commune').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);
            $('select').selectpicker('refresh');

            if (coded) {
                $('#commune').selectpicker('refresh');
                $('#commune').selectpicker('val', codec);


            }


        }
    });
}

function choixCommune() {

    $.ajax({
        url: adresse + 'AdminCont/chargeFoko',
        type: "POST",
        data: {
            id: (codec) ? codec : $("#commune").val()
        },
        success: function(data) {
            $("#fokontany").empty();
            $("#fokontany").append(data);

            var selectpickerElement = $('#fokontany').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);
            $('select').selectpicker('refresh');
            if (codec) {

                $('#fokontany').selectpicker('refresh');
                $('#fokontany').selectpicker('val', codef);


            }
        }
    });
}

function choixfoko() {
    $.ajax({
        url: adresse + 'AdminCont/chargeCV',
        type: "POST",
        data: {
            id: (codef) ? codef : $("#fokontany").val()
        },
        success: function(data) {
            $("#cv").empty();
            $("#cv").append(data);

            var selectpickerElement = $('#cv').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);
            $('select').selectpicker('refresh');
            if (codef) {
                $('#cv').selectpicker('refresh');
                $('#cv').selectpicker('val', codecv);


            }
        }
    });
}

function choixcv() {
    let commune = (codec) ? codec : $("#commune").val();
    $.ajax({
        url: adresse + 'AdminCont/chargeBV',
        type: "POST",
        data: {
            id: (codecv) ? codecv : $("#cv").val()
        },
        success: function(data) {
            $("#bv").empty();
            $("#bv").append(data);

            var selectpickerElement = $('#bv').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);
            $('select').selectpicker('refresh');
            if (codecv) {
                $('#bv').selectpicker('refresh');
                $('#bv').selectpicker('val', codebv);


            }

        }
    });
    $.ajax({
        url: adresse + 'AdminCont/chargeBVA',
        type: "POST",
        data: {
            id: commune
        },
        success: function(data) {
            $("#bva").empty();
            $("#bva").append(data);

            var selectpickerElement = $('#bva').eq(0);

            // Sélectionnez la première option de la liste déroulante
            var firstOption = selectpickerElement.find('option').eq(0);

            // Sélectionnez la première valeur de la liste déroulante
            var firstValue = firstOption.val();

            // Appliquez la sélection au selectpicker
            selectpickerElement.selectpicker('val', firstValue);
            $('select').selectpicker('refresh');
            if (codecv) {
                $('#bva').selectpicker('refresh');
                $('#bva').selectpicker('val', codebv);


            }

        }
    });
}


$("#faritany").on('change', function name(params) {
    choixfaritany();
});
$("#faritanyFiltre").on('change', function name(params) {
    if ($(this).val() == "tous") {
        $("#regionFiltre  option[value!='tous']").remove();
        $("#districtFiltre  option[value!='tous']").remove();
        $('#regionFiltre').selectpicker('val', []);
        $("#regionFiltre").val("tous");
        $('#regionFiltre').selectpicker('refresh');
    } else {
        choixfaritanyFiltre();
        $('#districtFiltre').selectpicker('val', []);
        $("#districtFiltre").val("tous");
        $('#districtFiltre').selectpicker('refresh');

    }

    listeContratZoom();

});

$("#regionFiltre").on('change', function name(params) {
    if ($(this).val() == "tous") {
        $("#districtFiltre  option[value!='tous']").remove();
        $("#districtFiltre").val("tous");
        $('#districtFiltre').selectpicker('refresh');
    } else {
        choixRegionFiltre();
    }
    listeContratZoom();
});

$("#districtFiltre").on('change', function name(params) {
    listeContratZoom();
});
$("#region").on('change', function name(params) {
    choixRegion();
});
$("#district").on('change', function name(params) {

    coder = null;
    coded = null;
    codec = null;
    codef = null;
    codebv = null;
    choixDistrict();
});
$("#commune").on('change', function name(params) {
    coder = null;
    coded = null;
    codec = null;
    codef = null;
    codebv = null;
    choixCommune();
});
$("#fokontany").on('change', function name(params) {
    coder = null;
    coded = null;
    codec = null;
    codef = null;
    codebv = null;
    choixfoko();
});
$("#cv").on('change', function name(params) {
    coder = null;
    coded = null;
    codec = null;
    codef = null;
    codebv = null;
    choixcv();
});




$("#addEmp").on("click", function name(params) {
    $('#addDelegue').unblock();
    $('#ioio').unblock();
    $("#modaladd").modal({ backdrop: 'static', keyboard: false }).modal('show');

});

$("#addEmpExcel").on("click", function name(params) {
    $('#addDelegueExcel').unblock();
    $('#ioioExcel').unblock();
    $("#modaladdExcel").modal({ backdrop: 'static', keyboard: false }).modal('show');

});
$("#addEmpExcelUpdate").on("click", function name(params) {
    $('#addDelegueExcelupdate').unblock();
    $('#ioioExcelupdate').unblock();
    $("#modaladdExcelupdate").modal({ backdrop: 'static', keyboard: false }).modal('show');

});



function exportExcel() {
    $.ajax({
        beforeSend: function name(params) {
            $('.main').block({
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
        },
        url: adresse + 'AdminCont/exportExcel',
        method: "POST",
        data: { fr: $("#faritanyFiltre").val(), rg: $("#regionFiltre").val(), ds: $("#districtFiltre").val() },
        dataType: "json",
        success: function(data) {
            if (data.id == 1) {
                window.open(data.lien);
                swal({
                    title: "Succès",
                    text: "Exportation effectuée avec succès",
                    icon: "success",
                    button: "Ok",
                });
            } else {

                swal({
                    title: "Erreur",
                    text: "Erreur d'exportation",
                    icon: "error",
                    button: "Ok",
                });

            }

            $('.main').unblock();


        }
    });
}


// var $options = $('select').find('option');

// // Add a click event handler to each option
// $options.on('click', function() {
//     // Get the value of the clicked option
//     var selectedValue = $(this).val();

//     // Perform an action with the selected value
//     alert('Clicked on Option ' + selectedValue);
// });

$('#formAdd').submit(function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: adresse + 'AdminCont/ajout',
        beforeSend: function(params) {
            $('#addDelegue').block({
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
            $('#ioio').block({
                message: '',
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
        },
        type: 'POST',
        dataType: "JSON",
        data: formData,
        processData: false, // N'ajoutez pas de Content-Type ni de traitement de données
        contentType: false, // N'ajoutez pas de Content-Type ni de traitement de données
        success: function(response) {
            $('#addDelegue').unblock();
            $('#ioio').unblock();
            if (response.id == 1) {
                swal({
                    title: "Succès",
                    text: "L'insertion a été effectuée avec succès",
                    icon: "success",
                    button: "Ok",
                });


                listeContratZoom();
                let id = $("#region").val();
                $('#formAdd')[0].reset();
                $('#district').selectpicker('val', []);
                $('#commune').selectpicker('val', []);
                $('#fokontany').selectpicker('val', []);
                $('#cv').selectpicker('val', []);
                $('#bv').selectpicker('val', []);
                $('#bva').selectpicker('val', []);

                $("#region").val(id);
                $('#region').selectpicker('refresh');
            } else if (response.id == 2) {

                let id = $("#region").val();

                swal({
                    title: "Erreur",
                    text: "Délégué dejà ajouté",
                    icon: "info",
                    button: "Ok",
                });
                $('#formAdd')[0].reset();
                $('#district').selectpicker('val', []);
                $('#commune').selectpicker('val', []);
                $('#fokontany').selectpicker('val', []);
                $('#cv').selectpicker('val', []);
                $('#bv').selectpicker('val', []);
                $('#bva').selectpicker('val', []);
                $("#region").val(id);
                $('#region').selectpicker('refresh');

            } else {
                swal({
                    title: "Erreur",
                    text: "Erreur d'ajout",
                    icon: "danger",
                    button: "Ok",
                });
            }


        }
    });


});
$('#updatebvsms').submit(function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: adresse + 'AdminCont/updatebvsms',
        beforeSend: function(params) {
            $('#updatebvsms').block({
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
            
        },
        type: 'POST',
        dataType: "JSON",
        data: formData,
        processData: false, // N'ajoutez pas de Content-Type ni de traitement de données
        contentType: false, // N'ajoutez pas de Content-Type ni de traitement de données
        success: function(response) {

			
            $('#updatebvsms').unblock();
            
            if (response.id == 1) {
                swal({
                    title: "Succès",
                    text: "mise a jour effectuée avec succès",
                    icon: "success",
                    button: "Ok",
                });


                listeAno();

            } else if (response.id == 2) {

				swal("Vote existant (  "+response.rep+"  ) ", {
					buttons: {
					  cancel: "Annuler",
					  catch: {
						text: "Ignorer",
						value: "catch",
					  },
					  defeat: {
						text: "Mettre a jour",
						value: "defeat",
					  },
					},
				  })
				  .then((value) => {
					switch (value) {
				   
					  case "defeat":

						$.ajax({
							
							url: adresse + 'AdminCont/miseajour',
							type: 'POST',
							dataType: "JSON",
							data: formData,
							processData: false, // N'ajoutez pas de Content-Type ni de traitement de données
							contentType: false, // N'ajoutez pas de Content-Type ni de traitement de données
							success: function(data) {
								if (data.id == 1) {
									
									swal({
										title: "Succès",
										text: "mise a effectuée avec succès",
										icon: "success",
										button: "Ok",
									});
								} else {
					
									swal({
										title: "Erreur",
										text: "Erreur de mise a jour",
										icon: "error",
										button: "Ok",
									});
					
								}
					
					
							}
						});
						
						$('#updatebvsms')[0].reset();
						break;
				   
					  case "catch":
						swal({
							title: "Succès",
							text: "mise a jour effectuée avec succès ( aucun changement )",
							icon: "success",
							button: "Ok",
						});
						$('#updatebvsms')[0].reset();
						break;
				   
					  default:
						
						//$('#modaladdExcel').modal('hide');
					}
				  });
				
               

            } else if (response.id == 3){
                swal({
                    title: "Erreur",
                    text: "Bureau de vote inexistante",
                    icon: "Error",
                    button: "Ok",
                });
				$('#updatebvsms')[0].reset();
            } else {
                swal({
                    title: "Erreur",
                    text: "Erreur d'ajout",
                    icon: "error",
                    button: "Ok",
                });
				$('#updatebvsms')[0].reset();
            }


        }
    });


});

$('#formAddExcel').submit(function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: adresse + 'AdminCont/ajoutExcel',
        beforeSend: function(params) {
            $('#addDelegueExcel').block({
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
            $('#ioioExcel').block({
                message: '',
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
        },
        type: 'POST',
        dataType: "JSON",
        data: formData,
        processData: false, // N'ajoutez pas de Content-Type ni de traitement de données
        contentType: false, // N'ajoutez pas de Content-Type ni de traitement de données
        success: function(response) {
            $('#addDelegueExcel').unblock();
            $('#ioioExecl').unblock();
            $("#modaladdExcel").modal('hide');
            if (response.id == 1) {
                swal({
                    title: "Succée",
                    text: "Ajout avec succée",
                    icon: "success",
                    button: "Ok",
                });


                listeContratZoom();
                let id = $("#regionExcel").val();
                let idt = $("#type").val();
                $('#formAddExcel')[0].reset();
                $("#regionExcel").val(id);
                $("#type").val(idt);
                $('#regionExcel').selectpicker('refresh');
                $('#type').selectpicker('refresh');

            } else {
                // swal({
                //     title: "Anomalie",
                //     text: "Erreur d'importation",
                //     icon: "danger",
                //     button: "Ok",
                // });
                $("#modalRatach1").insertAfter(".app");
                $("#modalRatach1").modal({ backdrop: 'static', keyboard: false }).modal('show');
                //$("#detR1").html(idEclat);
                $("#tbl_anomalie")
                    .on("preXhr.dt", function(e, settings, data) {
                        $("#contentRattach1").block({
                            message: "<i class='fa fa-spinner fa fa-5x fa-spin' style='color:#000;'></i></br></br><p>Veuillez patienté s'il vous plait</p>",
                            overlayCSS: {
                                backgroundColor: "#fff",
                                opacity: 0.8,
                                cursor: "wait",
                            },
                            css: {
                                border: 0,
                                padding: 0,
                                backgroundColor: "transparent",
                            },
                        });
                    })
                    .DataTable({
                        destroy: true,
                        ordering: true,
                        info: false,
                        searching: false,
                        lengthChange: false,
                        pageLength: 7,
                        preDrawCallback: function(settings) {
                            $("#contentRattach1").unblock();
                        },
                        data: response.data,
                        columns: [
                            { data: "bv" },
                            { data: "nom" },
                            { data: "prenom" },
                            { data: "cin" },
                            { data: "contact" },
                            { data: "date" },
                            { data: "type" }
                        ],
                        buttons: [{
                            extend: "excelHtml5",
                            title: "Liste Anomalie",
                            className: "btn btn-sm btn-success mr-2",
                            text: '<i class="fa fa-file-excel-o"></i>',
                        }, ],
                        dom: "Bfrtip",

                        language: {
                            //"zeroRecords": "Aucun article",

                            paginate: {
                                previous: "Précédent",
                                next: "Suivant",
                            },
                        },
                    });
            }


        }
    });


});

$('#formAddExcelUpdate').submit(function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: adresse + 'AdminCont/ajoutExcelupdate',
        beforeSend: function(params) {
            $('#addDelegueExcelupdate').block({
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
            $('#ioioExcelupdate').block({
                message: '',
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
        },
        type: 'POST',
        dataType: "JSON",
        data: formData,
        processData: false, // N'ajoutez pas de Content-Type ni de traitement de données
        contentType: false, // N'ajoutez pas de Content-Type ni de traitement de données
        success: function(response) {
            $('#addDelegueExcelupdate').unblock();
            $('#ioioExeclupdate').unblock();
            $("#modaladdExcelupdate").modal('hide');
            if (response.id == 1) {
                swal({
                    title: "Succée",
                    text: "Ajout avec succée",
                    icon: "success",
                    button: "Ok",
                });


                listeContratZoom();
              

            } else {
          
            }


        }
    });


});

let codefa;
let coder;
let coded;
let codec;
let codef;
let codecv;
let codebv;

$('.chearchName').on("click", function name(params) {
    $.ajax({
        url: adresse + 'AdminCont/chearchName',
        method: "POST",
        data: { query: $('#nomprenom').val(), fary: $("#faritany").val(), regy: $("#region").val() },
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                result(data);

            } else {

                swal({
                    title: "Erreur",
                    text: "CIN INTROUVABLE ",
                    icon: "danger",
                    button: "Ok",
                });

            }
        }
    })
});

$(".basicAutoComplete ").on('paste', function() {
    $(this).typeahead('open');
});
$('.basicAutoComplete').typeahead({
    minLength: 11,
    source: function(query, result) {

        if (query.length > 11) {
            $.ajax({
                beforeSend: function name(params) {
                    $('#addDelegue').block({
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
                    $('#ioio').block({
                        message: '',
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
                },
                url: adresse + 'AdminCont/autocomplete',
                method: "POST",
                data: { query: query, fary: $("#faritany").val(), regy: $("#region").val() },
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        result(data);

                    } else {

                        swal({

                            text: "CIN INTROUVABLE DANS LA REGION " + $("#region").text(),
                            icon: "error",
                            button: "Ok",
                        });

                    }
                    $('#addDelegue').unblock();
                    $('#ioio').unblock();

                }
            })
        }

    },
    afterSelect: function(item) {
        $('#addDelegue').block({
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
        $('#ioio').block({
            message: '',
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

        $.ajax({
            url: adresse + 'AdminCont/searchCIN',
            method: "POST",
            data: { cin: item, fary: $("#faritany").val(), regy: $("#region").val() },
            dataType: "json",
            success: function(data) {
                if (data.id == 0) {
                    swal({

                        text: "CIN INTROUVABLE DANS LA REGION " + $("#region").text(),
                        icon: "error",
                        button: "Ok",
                    });
                } else {


                    data.data.forEach(element => {
                        codefa = element.CODE_FARITANY;
                        coder = element.CODE_REGION;
                        coded = element.CODE_DISTRICT;
                        codec = element.CODE_COMMUNE;
                        codef = element.CODE_FOKONTANY;
                        codecv = element.CODE_CV;
                        codebv = element.CODE_BV;

                        $('#nomprenom').val(element.NOMELECT + " " + element.PRENOMELECT);
                        choixRegion();
                        choixDistrict();
                        choixCommune();
                        choixfoko();
                        choixcv();




                        // $('#region').trigger('change');
                        // $('select').selectpicker('refresh');

                    });
                }

                $('#addDelegue').unblock();
                $('#ioio').unblock();

            }
        })



        // $("#faritany").on("change", function name(params) {

        //     $.ajax({

        //         url: adresse + 'AdminCont/chargeRegion',
        //         type: "POST",
        //         data: {
        //             id: $(this).val()
        //         },
        //         success: function(data) {
        //             $("#region1").html(data);
        //             $('select').selectpicker('refresh');

        //             $("#region").on("change", function name(params) {

        //                 $.ajax({

        //                     url: adresse + 'AdminCont/chargeDistrict',
        //                     type: "POST",
        //                     data: {
        //                         id: $(this).val()
        //                     },
        //                     success: function(data) {
        //                         $("#district1").html(data);
        //                         $('select').selectpicker('refresh');
        //                         $("#district").on("change", function name(params) {

        //                             $.ajax({

        //                                 url: adresse + 'AdminCont/chargeCommune',
        //                                 type: "POST",
        //                                 data: {
        //                                     id: $(this).val()
        //                                 },
        //                                 success: function(data) {
        //                                     $("#commune1").html(data);
        //                                     $('select').selectpicker('refresh');
        //                                     $("#commune").on("change", function name(params) {
        //                                         let commune = $(this).val();
        //                                         $.ajax({

        //                                             url: adresse + 'AdminCont/chargeFoko',
        //                                             type: "POST",
        //                                             data: {
        //                                                 id: $(this).val()
        //                                             },
        //                                             success: function(data) {
        //                                                 $("#fokontany1").html(data);
        //                                                 $('select').selectpicker('refresh');
        //                                                 $("#fokontany").on("change", function name(params) {

        //                                                     $.ajax({

        //                                                         url: adresse + 'AdminCont/chargeCV',
        //                                                         type: "POST",
        //                                                         data: {
        //                                                             id: $(this).val()
        //                                                         },
        //                                                         success: function(data) {
        //                                                             $("#cv1").html(data);
        //                                                             $('select').selectpicker('refresh');
        //                                                             $("#cv").on("change", function name(params) {

        //                                                                 $.ajax({

        //                                                                     url: adresse + 'AdminCont/chargeBV',
        //                                                                     type: "POST",
        //                                                                     data: {
        //                                                                         id: $(this).val()
        //                                                                     },
        //                                                                     success: function(data) {
        //                                                                         $("#bvo1").html(data);
        //                                                                         $('select').selectpicker('refresh');

        //                                                                     }
        //                                                                 });
        //                                                                 $.ajax({

        //                                                                     url: adresse + 'AdminCont/chargeBVA',
        //                                                                     type: "POST",
        //                                                                     data: {
        //                                                                         id: commune
        //                                                                     },
        //                                                                     success: function(data) {
        //                                                                         $("#bva1").html(data);
        //                                                                         $('select').selectpicker('refresh');

        //                                                                     }
        //                                                                 });
        //                                                             });
        //                                                         }
        //                                                     });
        //                                                 });
        //                                             }
        //                                         });
        //                                     });
        //                                 }
        //                             });
        //                         });
        //                     }
        //                 });
        //             });
        //         }
        //     });
        // });


    }
});


// $("#faritany").on("changed.bs.select", function name(params) {

//     choixfaritany();
// });




// $("#region").on("changed.bs.select", function name(params) {
//     choixRegion();
// });




/* ===== Enable Bootstrap Popover (on element  ====== */
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

/* ==== Enable Bootstrap Alert ====== */
//var alertList = document.querySelectorAll('.alert')
//alertList.forEach(function (alert) {
//  new bootstrap.Alert(alert)
//});

const alertList = document.querySelectorAll('.alert')
const alerts = [...alertList].map(element => new bootstrap.Alert(element))


/* ===== Responsive Sidepanel ====== */
const sidePanelToggler = document.getElementById('sidepanel-toggler');
const sidePanel = document.getElementById('app-sidepanel');
const sidePanelDrop = document.getElementById('sidepanel-drop');
const sidePanelClose = document.getElementById('sidepanel-close');

window.addEventListener('load', function() {
    responsiveSidePanel();
});

window.addEventListener('resize', function() {
    responsiveSidePanel();
});
// choixRegion();
// choixDistrict();



function choixCinaPRES() {
    $.ajax({
        url: adresse + 'AdminCont/chargeDistrict',
        type: "POST",
        data: {
            id: coder
        },
        success: function(data) {
            $("#district1").html(data);
            $('select').selectpicker('refresh');


            $('#district').val(coded);
            $('select').selectpicker('refresh');

            $.ajax({
                url: adresse + 'AdminCont/chargeCommune',
                type: "POST",
                data: {
                    id: coded
                },
                success: function(data) {
                    $("#commune1").html(data);
                    $('select').selectpicker('refresh');


                    $('#commune').val(codec);
                    $('select').selectpicker('refresh');
                    $('#commune').trigger('change');

                    $.ajax({
                        url: adresse + 'AdminCont/chargeFoko',
                        type: "POST",
                        data: {
                            id: codec
                        },
                        success: function(data) {
                            $("#fokontany1").html(data);
                            $('select').selectpicker('refresh');
                            $('#fokontany').val(codef);
                            $('select').selectpicker('refresh');

                            $.ajax({
                                url: adresse + 'AdminCont/chargeCV',
                                type: "POST",
                                data: {
                                    id: codef
                                },
                                success: function(data) {
                                    $("#cv1").html(data);

                                    $('#cv').val(codecv);
                                    $('select').selectpicker('refresh');


                                    $.ajax({
                                        url: adresse + 'AdminCont/chargeBV',
                                        type: "POST",
                                        data: {
                                            id: codecv
                                        },
                                        success: function(data) {

                                            $("#bvo1").html(data);
                                            $('select').selectpicker('refresh');
                                            $('#bv').val(codebv);
                                            $('select').selectpicker('refresh');

                                        }
                                    });
                                    $.ajax({
                                        url: adresse + 'AdminCont/chargeBVA',
                                        type: "POST",
                                        data: {
                                            id: codec
                                        },
                                        success: function(data) {
                                            $("#bva1").html(data);
                                            $('select').selectpicker('refresh');

                                        }
                                    });

                                }
                            });

                        }
                    });

                }
            });



        }
    });
}





function responsiveSidePanel() {
    // let w = window.innerWidth;
    // if (w >= 1200) {
    //     // if larger 
    //     //console.log('larger');
    //     sidePanel.classList.remove('sidepanel-hidden');
    //     sidePanel.classList.add('sidepanel-visible');

    // } else {
    //     // if smaller
    //     //console.log('smaller');
    //     sidePanel.classList.remove('sidepanel-visible');
    //     sidePanel.classList.add('sidepanel-hidden');
    // }
};

// sidePanelToggler.addEventListener('click', () => {
//     if (sidePanel.classList.contains('sidepanel-visible')) {
//         console.log('visible');
//         sidePanel.classList.remove('sidepanel-visible');
//         sidePanel.classList.add('sidepanel-hidden');

//     } else {
//         console.log('hidden');
//         sidePanel.classList.remove('sidepanel-hidden');
//         sidePanel.classList.add('sidepanel-visible');
//     }
// });



// sidePanelClose.addEventListener('click', (e) => {
//     e.preventDefault();
//     sidePanelToggler.click();
// });

// sidePanelDrop.addEventListener('click', (e) => {
//     sidePanelToggler.click();
// });



/* ====== Mobile search ======= */
