

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
                        <div class="cardName">Délégué de vote</div>
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
                            <select data-live-search="true" name="region-user" id="region-user">
                                <option value=""></option>
                                <?php foreach ($region as $key => $value) { ?>
                                    <option value="<?php echo $value->CODE_REGION ?>"><?php echo $value->LIBELLE_REGION ?></option>
                                <?php } ?>
                            </select>
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

    $("#region-user").change(function() {
        getStatReg('piechart', 'pie');
    });

    function getStatReg(chartId, chartType) {
        var id = $("#region-user").val();

        $.ajax({
            url: '<?php echo base_url('Utilisateurs/getStatReg'); ?>',
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
                    title: 'Statistiques par région',
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

    
</script>