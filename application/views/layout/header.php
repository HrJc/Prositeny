<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="<?php echo base_url(); ?>assets/plugins/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jc/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jc/css/style.css">
    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="<?php echo base_url() ?>assets/css/portal.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jc/css/jquery.dataTables.css" />
    <script src="<?php echo base_url() ?>assets/jc/js/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jc/css/bootstrap-select.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<style>
    ul{
		padding: 0px;
	}
</style>

<body>
        <div class="navigation">
            <ul>
                <li>
                    <h4 style="color:white; padding-top:20px; padding-bottom:10px; text-align:center; border-bottom:3px solid white">PRO SITENY</h4>
                </li>
            <?php 
            if($type == "Invite") { ?>
                <li>
                    <a href="<?php echo base_url(); ?>AdminCont/resultat">
                        <span class="icon">
                        <ion-icon name="receipt"></ion-icon>
                            <!-- <i class='fa fa-users'></i> -->
                        </span>
                        <span class="title">Résultat SMS</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Utilisateurs/resultat2">
                        <span class="icon">
                        <ion-icon name="receipt"></ion-icon>
                            <!-- <i class='fa fa-users'></i> -->
                        </span>
                        <span class="title">Résultat BV</span>
                    </a>
                </li>
            <?php  } 
            else {
                if (isset($district)) { ?>
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/chartDelege">
                            <span class="icon">
                                <ion-icon name="people"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Délégué</span>
                        </a>
                    </li>
                <?php  }else {
                 ?>
                    
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/chartDelege2">
                            <span class="icon">
                            <ion-icon name="bar-chart"></ion-icon>
                                <!-- <i class='fa fa-pie-chart'></i> -->
                            </span>
                            <span class="title">RECAP Global</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/chartDelege">
                            <span class="icon">
                            <ion-icon name="bar-chart"></ion-icon>
                                <!-- <i class='fa fa-pie-chart'></i> -->
                            </span>
                            <span class="title">RECAP Région</span>
                        </a>
                    </li>    
                   
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/chartDelegue3">
                            <span class="icon">
                            <ion-icon name="bar-chart"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">RECAP District</span>
                        </a>
                    </li>
    
               
    
                    <li>
                        <a href="<?php echo base_url(); ?>AdminCont/index">
                            <span class="icon">
                                <ion-icon name="people"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Délégué</span>
                        </a>
                    </li>
    
                    <!-- <li>
                        <a href="<?php echo base_url(); ?>AdminCont/listeAnomalie">
                            <span class="icon">
                                <ion-icon name="menu"></ion-icon>
                                <i class='fa fa-users'></i> 
                            </span>
                            <span class="title">Anomalie</span>
                        </a>
                    </li> -->
    
                    <?php if ($type == "Administrateur") { ?>
                    <!-- <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/viewMandant">
                            <span class="icon">
                            <ion-icon name="person"></ion-icon>
                                <!-- <i class='fa fa-users'></i> --
                            </span>
                            <span class="title">Mandant</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/index">
                            <span class="icon">
                            <ion-icon name="person"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Utilisateurs</span>
                        </a>
                    </li>
                    <?php } ?>
    
    
    
                    <?php if ($type == "Administrateur") { ?>
                    <li>
                        <a href="<?php echo base_url(); ?>AdminCont/resultat">
                            <span class="icon">
                            <ion-icon name="receipt"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Résultat SMS</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/resultat2">
                            <span class="icon">
                            <ion-icon name="receipt"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Résultat BV</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/viewMessage">
                            <span class="icon">
                            <ion-icon name="receipt"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Bureau de votes</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Utilisateurs/viewBureau">
                            <span class="icon">
                            <ion-icon name="receipt"></ion-icon>
                                <!-- <i class='fa fa-users'></i> -->
                            </span>
                            <span class="title">Messages</span>
                        </a>
                    </li>
                    <?php 
                    }
                    
                } 
                
            } ?>       
            
                
            </ul>
        </div>
        
        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu"></ion-icon>
                    <!-- <i class='fa fa-navicon'></i> -->
                </div>
                
                <div class="search" style="margin-top: 10px;">
                    <label>
                        <input type="text" placeholder="Recherche" id="myInputTextField">
                    </label>
                </div>

                <div style="display: inline-block">
                <?php
                    if ($type !== "Administrateur") {                        
                        if (isset($district)) {
                            $regionn = 'DISTRICT - '.$district[0]->LIBELLE_DISTRICT;
                        }else if($type == "Invite"){
                            $regionn = "INVITE";
                        }else if($type == "Administrateur"){
                            $regionn = "ADMINISTRATEUR";
                        }else {
                            $regionn = $region[0]->LIBELLE_REGION;
                        }
                    }
                    ?>
                    <strong class="title">Bonjour <?php echo $regionn ?></strong>
                    <a href="<?php echo base_url(); ?>Login/deconnecter">
                        <span class="icon" style="font-size: 20px;padding: 7px;position: relative;right: 0px;top: 3px;color: #5d6778;">
                            <ion-icon name="log-out"></ion-icon>
                            <!-- <i class='fa fa-sign-out'></i> -->
                        </span>
                    </a>
                </div>
            </div>
            
