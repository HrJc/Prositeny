

            <!-- ======================= Cards ================== -->
            <label style="margin: 20px;"><strong>DASHBOARD</strong></label>
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers" ><strong id="bv"></strong></div>
                        <div class="cardName">Bureau de vote</div>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="tache"><strong id="tache"></strong></div>
                        <div class="cardName">Tâche</div>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="reste"><strong id="reste"></strong></div>
                        <div class="cardName">Reste</div>
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
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin: 20px;">
                    <div class="form-group">                            
                            <label><strong>Région :</strong></label>
                            <select data-live-search="true" name="regionFiltre2" id="regionFiltre2">
                                <option value=""></option>
                                <?php foreach ($region as $key => $value) { ?>
                                    <option value="<?php echo $value->CODE_REGION ?>"><?php echo $value->LIBELLE_REGION ?></option>
                                <?php } ?>
                            </select>
                            <label><strong>District :</strong></label>
                            <select data-live-search=true id="districtFiltre1" title="District" required name="ds">
                                <option value=""></option>
                            </select>&emsp;
                    </div>
                    <div id="piechart" style="width: 900px; height: 600px;"></div>
                    </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    </div>
                </div>
            </div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(function() {});

    // $("#region-user").change(function() {
    //     getStatReg('piechart', 'pie');
    // });


    function getStatReg(chartId, chartType) {
        var id = $("#districtFiltre1").val();
        $.ajax({
            url: '<?php echo base_url('Utilisateurs/getStatDis'); ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(result) {
                var formattedData = [['Région', 'Nombre']];

                $('#bv').html('');
                $('#tache').html('');
                $('#reste').html('');

                $('#bv').html(result.stat.bv);
                $('#tache').html(result.stat.tache);
                $('#reste').html(result.stat.reste);

                var result = result.data;

                for (var i = 0; i < result.length; i++) {
                    formattedData.push([result[i].LIBELLE_REGION, parseInt(result[i].nbr)]);
                }

                var data = google.visualization.arrayToDataTable(formattedData);

                var options = {
                    title: 'Statistique Global',
                    pieHole: 0.4,
                };

                // Choisissez le type de graphique en fonction de chartType
                var chart;
                if (chartType === 'pie') {
                    chart = new google.visualization.PieChart(document.getElementById(chartId));
                }

                chart.draw(data, options);         


            }

        });
    }

    $("#regionFiltre2").on('change', function() {
        choixRegionFiltre1();
    });

    $("#districtFiltre1").on('change', function() {
        getStatReg('piechart', 'pie');
    });

    function choixRegionFiltre1() {
        var id = $("#regionFiltre2").val();
        $.ajax({
            url: '<?php echo base_url('Utilisateurs/chargeDistrict2'); ?>',
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $("#districtFiltre1").empty();
                $("#districtFiltre1").append(data);
                var selectpickerElement = $('#districtFiltre1').eq(0);

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

    $(document).ready(function() {
        $("select").selectpicker();
    });

</script>