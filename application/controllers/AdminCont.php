<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminCont extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->library("excel");
		$this->load->library(['form_validation', 'session']);
		$this->load->model('login/login_model');
	}


	// 	public function resultat()
	// {
	// 	$this->testerSession();
	// 	$data['type'] = $_SESSION['type'];
	// 	$data['prenom'] = $_SESSION['prenom'];
	// 	$data['idRegion'] = $_SESSION['idRegion'];
	// 	$data['tabRegion'] = $_SESSION['tabRegion'];
	// 	$data['title'] = 'SITENY | Liste utilisateur';
	// 	$regions = $this->db->query("select * from region")->result();
	// 	if ($_SESSION['type'] == "Administrateur") {
	// 		$faritra = $this->db->query("select * from faritany ")->result();
	// 		$region = $this->db->query("select * from region where CODE_FARITANY = 1 ")->result();
	// 	} else {
	// 		$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
	// 		$region = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_REGION ")->result();

	// 	}

	// 	//var_dump($region);die;
	// 	$data['faritra'] = $faritra;
	// 	$data['region'] = $region;
	// 	$data['regions'] = $regions;
	// 	$this->load->view('layout/header', $data);
	// 	$this->load->view('utilisateurs/liste_resultat', $data);
	// 	$this->load->view('layout/footer');
	// }


public function cronereponse1()
	{
		$select = '';

		$data = $this->db->query("select * from basebrutesms where etat = 0 ")->result();
		
		$rep = "";

		
		// $pattern = '/\b\d{12}[\s_:;.,\/]{0,}(?:\d*[smr]|manisa|misokatra)\b/i';
		// $texte = '123456789012:,   ,,    4515    s;,,:;;;,;    ' ;
		// //$texte_sans_espaces_entre_mots = preg_replace('/\s+/', '', $texte);

		// if (preg_match($pattern, preg_replace('/\s+/', '', $texte) , $matches)) {
		// 	$donnees12Chiffres = $matches[0]; // Capturer les 12 premiers chiffres
		// 	//$autrePartie = $matches[1]; // Capturer l'autre partie
		
		// 	// Remplacer les espaces, tirets bas ou double espace par un tiret bas `_`
		// 	$donnees12Chiffres = preg_replace('/[\s_:;,.\/]+/', '_', strtoupper($donnees12Chiffres));
		
		// 	echo "Les données de 12 chiffres sont : $donnees12Chiffres";
		// 	echo "<br>";
		// 	echo "Autre partie : ";
		// }

		// die;
		

		foreach ($data as $key) {

				// $pattern = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{0,}(?:\d*[smat]|manisa|misokatra)\b/i';

				// // Vérification du format du texte
				// if (preg_match($pattern, preg_replace('/\s+/', '', $key->contentsms) , $matches)) {
				// 	$donnees12Chiffres = $matches[0];
				// 	$content =  preg_replace('/[\s_:\-;.,\/]+/', '_', strtoupper($donnees12Chiffres));
				// 	$bv = substr(trim($content), 0, 12);
					
					$pattern = '/\d{12}[\s_:;.\-,!^$*ù\/]{1,}(\d+S|misokatra|manisa|\d+A|\d+M|\d+T)$/i';

					// Vérification du format du texte
					if (preg_match($pattern, trim($key->contentsms) , $matches)) {
							$donnees12Chiffres = $matches[0];
							$content =  preg_replace('/[\s_:;.\-,!^$*ù\/]+/', '_', $donnees12Chiffres);
							$bv = substr(trim($content), 0, 12);

						

					//verification bv
					$datas = $this->db->query("select * from base_sms where CODE_BV = ".$bv." ")->row();

					if ($datas) {

						$pattern1 = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{1,}(misokatra)\b/i'; 
						$pattern2 = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{1,}(manisa)\b/i'; 
						$pattern3 = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{1,}(\d+M)$/i'; 
						$pattern4 = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{1,}(\d+A)\b/i'; 
						$pattern5 = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{1,}(\d+T)\b/i'; 
						$pattern6 = '/\b\d{12}[\s_:;.\-,!^$*ù\/]{1,}(\d+S)\b/i'; 

						if (preg_match($pattern1, trim($content))) {

							if ($datas->etat == 0 ) {

								$this->db->query("update base_sms set etat = 1 , contact = ".$key->telephone."  where CODE_BV = ".$bv." ");

							} 
							else if ($datas->etat == 1 ) {

								$anom = array(
									"contact"=> $key->telephone,
							                "id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code d'ouverture est renvoyé alors que le BV est dejà ouvert"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							else if ($datas->etat == 2 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,									
									"anomalie"=> "(".$bv.") Le code d'ouverture est renvoyé pendant que le BV est en cours de comptage"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							else if ($datas->etat == 3 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code d'ouverture est renvoyé pendant que le BV est en attente de resultat"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							else if ($datas->etat == 4 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code d'ouverture est renvoyé pendant que le BV est close"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							

							$rep = "misokatra";
						} 
						else if (preg_match($pattern2, trim($content))) {

							/*if ($datas->etat == 0 ) {

								$anom = array(
									"contact"=> $key->telephone,
"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code de comptage est renvoyé alors que le BV est deja fermé"
								);
								$this->db->insert("anomalie_sms", $anom);

							} */
							if ($datas->etat == 1 || $datas->etat == 0 ) {

								$this->db->query("update base_sms set etat = 2 , contact = ".$key->telephone." where CODE_BV = ".$bv." ");

							}
							else if ($datas->etat == 2 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code de comptage est renvoyé pendant que le BV est en cours de comptage"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							else if ($datas->etat == 3 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code de comptage est renvoyé pendant que le BV est en attente de resultat"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							else if ($datas->etat == 4 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Le code de comptage est renvoyé pendant que le BV est close"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							$rep = "manisa";
						}
						else if (preg_match($pattern6, trim($content))) {
							/*if ($datas->etat == 0 ) {

								$anom = array(
									"contact"=> $key->telephone,
"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbres de vote pour le CAD13 renvoyé alors que le BV est deja fermé"
								);
								$this->db->insert("anomalie_sms", $anom);

							} 
							else if ($datas->etat == 1 ) {

								$anom = array(
									"contact"=> $key->telephone,
"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbres de vote pour le CAD13 renvoyé alors que le code de comptage n'est sont pas encore renvoyer"
								);
								$this->db->insert("anomalie_sms", $anom);

								

							}*/
							if ($datas->etat == 2 || $datas->etat == 1 || $datas->etat == 0 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'S'));
							
								$upd = array(
									"etat" => 3,
									"contact" => $key->telephone ,
									"voix13" => $isaky
								);
								$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);

								//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , voix13 = ".$isaky." where CODE_BV = ".$bv." ");

							}
							if ($datas->etat == 3 ) {
							
								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'S'));

								if ($datas->voix13 == "" || $datas->voix13 == $isaky ) {
									$upd = array(
										"etat" => 3,
										"contact" => $key->telephone ,
										"voix13" => $isaky
									);
									$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);
									//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , voix13 = ".$isaky." where CODE_BV = ".$bv." ");

									if ($isaky != "" && $datas->voix03 != "" && $datas->voix05 != "" && $datas->total != "") {
										$way = array(
											"voix03"=> $datas->voix03,
											"voix13"=> $isaky,
											"voix05"=> $datas->voix05,
											"total"=> $datas->total,
											"CODE_BV"=> $datas->CODE_BV,
											"contact"=> $key->telephone
										);
										$this->db->insert("base_sms_tur", $way);
										$this->db->query("update base_sms set etat = 4 , contact = ".$key->telephone."  where CODE_BV = ".$bv." ");
									}
									

								}else{
									$anom = array(
										"contact"=> $key->telephone,
										"id_brute"=> $key->id,
										"anomalie"=> "(".$bv.") Nbr de vote pour le CAD13 renvoyé avec nombre different"
									);
									$this->db->insert("anomalie_sms", $anom);
								}

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "Le code de comptage est renvoyé pendant que le BV est en attente de resultat"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							else if ($datas->etat == 4 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "Nbr de vote pour le CAD13 renvoyé pendant que le BV est close"
								);
								$this->db->insert("anomalie_sms", $anom);

							}

							$rep = "resultat S";
						}
						else if (preg_match($pattern3, trim($content))) {

							/*if ($datas->etat == 0 ) {

								$anom = array(
									"contact"=> $key->telephone,
"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbres de vote pour le CAD05 renvoyé alors que le BV est deja fermé"
								);
								$this->db->insert("anomalie_sms", $anom);

							} 
							else if ($datas->etat == 1 ) {

								$anom = array(
									"contact"=> $key->telephone,
"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbres de vote pour le CAD05 renvoyé alors que le code de comptage n'est sont pas encore renvoyer"
								);
								$this->db->insert("anomalie_sms", $anom);

								

							}*/
							if ($datas->etat == 2 || $datas->etat == 1 || $datas->etat == 0 ) {

							//else if ($datas->etat == 2 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'M'));

								$upd = array(
									"etat" => 3,
									"contact" => $key->telephone ,
									"voix05" => $isaky
								);
								$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);
								//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , voix05 = ".$isaky." where CODE_BV = ".$bv." ");

							}
							else if ($datas->etat == 3 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'M'));

								if ($datas->voix05 == "" || $datas->voix05 == $isaky ) {
									$upd = array(
										"etat" => 3,
										"contact" => $key->telephone ,
										"voix05" => $isaky
									);
									$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);

									//query("update base_sms set etat = 3 , contact = ".$key->telephone." , voix05 = ".$isaky." where CODE_BV = ".$bv." ");
									
									if ($isaky != "" && $datas->voix03 != "" && $datas->voix13 != "" && $datas->total != "") {
										$way = array(
											"voix03"=> $datas->voix03,
											"voix05"=> $isaky,
											"voix13"=> $datas->voix13,
											"total"=> $datas->total,
											"CODE_BV"=> $datas->CODE_BV,
											"contact"=> $key->telephone
										);
										$this->db->insert("base_sms_tur", $way);
										$this->db->query("update base_sms set etat = 4  where CODE_BV = ".$bv." ");
									}
									
								}else{
									$anom = array(
										"contact"=> $key->telephone,
										"id_brute"=> $key->id,
										"anomalie"=> "(".$bv.") Nbr de vote pour le CAD05 renvoyé avec nombre different"
									);
									$this->db->insert("anomalie_sms", $anom);
								}

								

							}
							else if ($datas->etat == 4 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "Nbr de vote pour le CAD05 renvoyé pendant que le BV est close"
								);
								$this->db->insert("anomalie_sms", $anom);

							}

							$rep = "resultat M";
						}
						else if (preg_match($pattern4, trim($content))) {
							/*if ($datas->etat == 0 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbres de vote pour le CAD03 renvoyé alors que le BV est deja fermé"
								);
								$this->db->insert("anomalie_sms", $anom);

							} 
							else if ($datas->etat == 1 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbres de vote pour le CAD03 renvoyé alors que le code de comptage n'est sont pas encore renvoyer"
								);
								$this->db->insert("anomalie_sms", $anom);

							

							}*/
							if ($datas->etat == 2 || $datas->etat == 1 || $datas->etat == 0 ) {

							//else if ($datas->etat == 2 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'A'));

								$upd = array(
									"etat" => 3,
									"contact" => $key->telephone ,
									"voix03" => $isaky
								);
								$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);
								//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , voix03 = ".$isaky." where CODE_BV = ".$bv." ");

							}
							else if ($datas->etat == 3 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'A'));

								if ($datas->voix03 == "" || $datas->voix03 == $isaky ) {
									$upd = array(
										"etat" => 3,
										"contact" => $key->telephone ,
										"voix03" => $isaky
									);
									$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);
									//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , voix03 = ".$isaky." where CODE_BV = ".$bv." ");
									
										if ($isaky != "" && $datas->voix05 != "" && $datas->voix13 != "" && $datas->total != "") {
											$way = array(
												"voix03"=> $isaky,
												"voix05"=> $datas->voix05,
												"voix13"=> $datas->voix13,
												"total"=> $datas->total,
												"CODE_BV"=> $datas->CODE_BV,
												"contact"=> $key->telephone
											);
											$this->db->insert("base_sms_tur", $way);
											$this->db->query("update base_sms set etat = 4 , contact = ".$key->telephone."  where CODE_BV = ".$bv." ");
										}
									
								}else{
									$anom = array(
										"contact"=> $key->telephone,
										"id_brute"=> $key->id,
										"anomalie"=> "(".$bv.") Nbr de vote pour le CAD03 renvoyé avec nombre different"
									);
									$this->db->insert("anomalie_sms", $anom);
								}

							}
							else if ($datas->etat == 4 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "Nbr de vote pour le CAD03 renvoyé pendant que le BV est close"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							$rep = "resultat A";
						}
						else if (preg_match($pattern5, trim($content))) {
							/*if ($datas->etat == 0 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbre total de vote renvoyé alors que le BV est deja fermé"
								);
								$this->db->insert("anomalie_sms", $anom);

							} 
							else if ($datas->etat == 1 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbre total de vote renvoyé alors que le code de comptage n'est sont pas encore renvoyer"
								);
								$this->db->insert("anomalie_sms", $anom);


							}*/
							if ($datas->etat == 2 || $datas->etat == 1 || $datas->etat == 0 ) {

							//else if ($datas->etat == 2 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'T'));

								$upd = array(
									"etat" => 3,
									"contact" => $key->telephone ,
									"total" => $isaky
								);
								$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);

								//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , total = ".$isaky." where CODE_BV = ".$bv." ");

							}
							else if ($datas->etat == 3 ) {

								$parties = explode('_', trim($content));

								$isaky = substr($parties[1], 0, strpos($parties[1], 'T'));

								if ($datas->total == "" || $datas->total == $isaky ) {
									$upd = array(
										"etat" => 3,
										"contact" => $key->telephone ,
										"total" => $isaky
									);
									$this->db->where("CODE_BV",$bv)->update("base_sms", $upd);

									//$this->db->query("update base_sms set etat = 3 , contact = ".$key->telephone." , total = ".$isaky." where CODE_BV = ".$bv." ");
									if ($isaky != "" && $datas->voix05 != "" && $datas->voix13 != "" && $datas->voix03 != "") {
										$way = array(
											"voix03"=> $datas->voix03,
											"voix05"=> $datas->voix05,
											"voix13"=> $datas->voix13,
											"total"=> $isaky,
											"CODE_BV"=> $datas->CODE_BV,
											"contact"=> $key->telephone
										);
										$this->db->insert("base_sms_tur", $way);
										$this->db->query("update base_sms set etat = 4 , contact = ".$key->telephone."  where CODE_BV = ".$bv." ");
									}
								}else{
									$anom = array(
										"contact"=> $key->telephone,
										"id_brute"=> $key->id,
										"anomalie"=> "(".$bv.") Nbr de vote pour le CAD03 renvoyé avec nombre different"
									);
									$this->db->insert("anomalie_sms", $anom);
								}

							}
							else if ($datas->etat == 4 ) {

								$anom = array(
									"contact"=> $key->telephone,
									"id_brute"=> $key->id,
									"anomalie"=> "(".$bv.") Nbre total de vote renvoyé pendant que le BV est close"
								);
								$this->db->insert("anomalie_sms", $anom);

							}
							$rep = "resultat T";
						}

					}else{

						$anom = array(
							"contact"=> $key->telephone,
							"id_brute"=> $key->id,
							"anomalie"=> "Code BV inexistante"
						);
						$this->db->insert("anomalie_sms", $anom);

					}

					
					

					
				} else {
					$anom = array(
						"contact"=> $key->telephone,
						"id_brute"=> $key->id,
						"anomalie"=> "Le texte ne correspond pas au format spécifié"
					);
					$this->db->insert("anomalie_sms", $anom);
				
				}


			
			$this->db->query("update basebrutesms set etat = 1 where id = ".$key->id." ");
			
		}
		
		$data = array(
            'message' => $rep,
            'status' => 'success'
        );
		
        // Convertissez les données en format JSON et renvoyez-les
        header('Content-Type: application/json');

        echo json_encode($data);
		
	}




// public function cronereponse()
// 	{
// 		$select = '';

// 		$data = $this->db->query("select * from basebrutesms where etat = 0 ")->result();
		
// 		$rep = "";

// 		foreach ($data as $key) {

// 			$pattern = '/^\d{12}\s(\d+S|misokatra|manisa|\d+S|\d+A|\d+M|\d+T)$/i';

// 			// Vérification du format du texte
// 			if (preg_match($pattern, trim($key->contentsms),$matche)) {

// 				$pattern1 = '/^\d{12}\s(misokatra)$/i'; 
// 				$pattern2 = '/^\d{12}\s(manisa)$/i'; 
// 				$pattern3 = '/^\d{12}\s(\d+M)$/i'; 
// 				$pattern4 = '/^\d{12}\s(\d+A)$/i'; 
// 				$pattern5 = '/^\d{12}\s(\d+T)$/i'; 
// 				$pattern6 = '/^\d{12}\s(\d+S)$/i'; 

// 				if (preg_match($pattern1, trim($key->contentsms),$matches)) {

// 					$rep = "misokatra";
// 					$rep = $matches[1] ;


// 				} 
// 				elseif (preg_match($pattern2, trim($key->contentsms))) {
// 					$rep = "manisa";
// 				}
// 				elseif (preg_match($pattern6, trim($key->contentsms))) {
// 					$rep = "resultat S";
// 				}
// 				elseif (preg_match($pattern3, trim($key->contentsms))) {
// 					$rep = "resultat M";
// 				}
// 				elseif (preg_match($pattern4, trim($key->contentsms))) {
// 					$rep = "resultat A";
// 				}
// 				elseif (preg_match($pattern5, trim($key->contentsms))) {
// 					$rep = "resultat T";
// 				}
				

				
// 			} else {
// 				$rep = "Le texte ne correspond pas au format spécifié";
// 			}

			
// 		}
		
// 		$data = array(
//             'message' => $rep,
//             'status' => 'success'
//         );
		
//         // Convertissez les données en format JSON et renvoyez-les
//         header('Content-Type: application/json');

//         echo json_encode($data);
		
// 	}



public function sendsms2()
	{
		$select = '';
		//http://127.0.0.1:1401/send? -d 'username=duser&password=dPass&to=261340016398&content=Hi there!'
		
		
			  $liste = $this->db->query("SELECT * FROM cec_base")->result();
			foreach ($liste as $row) {		
				$data = $this->db->query("SELECT  b.CODE_BV, b.LIBELLE_BV 
				FROM bv b , cv c , fokontany fk , commune cm   WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND cm.LIBELLE_COMMUNE like '%".$row->commune."%' ")->result();

				$dataList = [];

				$val = "";
				foreach ($data as $key) {
					$val .= $key->CODE_BV. ":". $key->LIBELLE_BV. "; ";
				}

				foreach (explode("\n", wordwrap($val, 160, "\n", true)) as $key) {

					array_push($dataList, 
					array('username' => 'duser', 'password' => 'dPass', 'to' => $row->contact, 'content' =>  $key));
				}
			
			
			$url = 'http://127.0.0.1:1401/send';
			$numberOfRequests = count($dataList); // Le nombre de requêtes sera égal au nombre de sous-arrays dans $dataList

			for ($i = 0; $i < $numberOfRequests; $i++) {
				$ch = curl_init();

				// Sélectionner les données spécifiques pour cette itération
				$requestData = $dataList[$i];

				// Convertir le sous-array en chaîne de requête GET
				$query = http_build_query($requestData);

				// Ajouter la chaîne de requête à l'URL
				curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($ch);
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if ($response !== false && $httpCode === 200) {
					echo "Requête " . ($i + 1) . " envoyée. Réponse : " . $response . "\n";
				} else {
					echo "Erreur pour la requête " . ($i + 1) . "\n";
				}

				curl_close($ch);
			}

			
		}
		
	}




// public function sendsms1()
// 	{
// 		$select = '';
// 		//http://127.0.0.1:1401/send? -d 'username=duser&password=dPass&to=261340016398&content=Hi there!'
		
		
// 			$data = $this->db->query("SELECT  b.CODE_BV, b.LIBELLE_BV 
// 			FROM bv b , cv c , fokontany fk , commune cm   WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
// 			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND cm.LIBELLE_COMMUNE like '%betioky sud%' ")->result();

// 			$dataList = array();

// 			foreach ($data as $key) {
// 				$val = $key->CODE_BV. " ". $key->LIBELLE_BV;
// 				$dataList = [
// 					array('username' => 'duser', 'password' => 'dPass', 'to' => '261381301385', 'content' =>  $val)
// 				];
// 				$url = 'http://127.0.0.1:1401/send';
// 			$numberOfRequests = count($dataList); // Le nombre de requêtes sera égal au nombre de sous-arrays dans $dataList

// 			for ($i = 0; $i < $numberOfRequests; $i++) {
// 				$ch = curl_init();

// 				// Sélectionner les données spécifiques pour cette itération
// 				$requestData = $dataList[$i];

// 				// Convertir le sous-array en chaîne de requête GET
// 				$query = http_build_query($requestData);

// 				// Ajouter la chaîne de requête à l'URL
// 				curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
// 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 				$response = curl_exec($ch);
// 				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// 				if ($response !== false && $httpCode === 200) {
// 					echo "Requête " . ($i + 1) . " envoyée. Réponse : " . $response . "\n";
// 				} else {
// 					echo "Erreur pour la requête " . ($i + 1) . "\n";
// 				}

// 				curl_close($ch);
// 			}
// 			}

			
		
		
// 	}

// public function sendsms()
// 	{
// 		$select = '';
// 		//http://127.0.0.1:1401/send? -d 'username=duser&password=dPass&to=261340016398&content=Hi there!'
		
		
// 			$data = $this->db->query("SELECT  b.CODE_BV, b.LIBELLE_BV 
// 			FROM bv b , cv c , fokontany fk , commune cm   WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
// 			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND cm.LIBELLE_COMMUNE like '%betioky sud%' ")->result();

// 			$dataList = array();

// 			foreach ($data as $key) {
// 				$val = $key->CODE_BV. " ". $key->LIBELLE_BV;
// 				$dataList[] = [
// 					array('username' => 'duser', 'password' => 'dPass', 'to' => '261381301385', 'content' =>  'nico')
// 				];
// 			}

// 			$url = 'http://127.0.0.1:1401/send';
// 			$numberOfRequests = count($dataList); // Le nombre de requêtes sera égal au nombre de sous-arrays dans $dataList

// 			for ($i = 0; $i < $numberOfRequests; $i++) {
// 				$ch = curl_init();

// 				// Sélectionner les données spécifiques pour cette itération
// 				$requestData = $dataList[$i];

// 				// Convertir le sous-array en chaîne de requête GET
// 				$query = http_build_query($requestData);

// 				// Ajouter la chaîne de requête à l'URL
// 				curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
// 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 				$response = curl_exec($ch);
// 				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// 				var_dump($response);
// 				if ($response !== false && $httpCode === 200) {
// 					echo "Requête " . ($i + 1) . " envoyée. Réponse : " . $response . "\n";
// 				} else {
// 					echo "Erreur pour la requête " . ($i + 1) . "\n";
// 				}

// 				curl_close($ch);
// 			}
		
		
// 	}
		public function cronesaisie()
			{

				$dat = $this->db->query("select * from base_sms where etat = 3")->result();
				
				foreach ($dat as $value) {
					if($value->voix03 && $value->voix05 && $value->voix13 && $value->total){
						$data = $this->db->query("select * from base_sms_tur where CODE_BV = ".$value->CODE_BV."")->row();
						if ($data == null) {
							$way = array(
								"voix03"=> $value->voix03,
								"voix05"=> $value->voix05,
								"voix13"=> $value->voix13,
								"total"=> $value->total,
								"CODE_BV"=> $value->CODE_BV,
								"etat" => 0
								
							);
							$this->db->insert("base_sms_tur", $way);
							$this->db->query("update base_sms set etat = 4  where CODE_BV = ".$value->CODE_BV." ");
						}else{
							$way = array(
								"voix03"=> $value->voix03,
								"voix05"=> $value->voix05,
								"voix13"=> $value->voix13,
								"total"=> $value->total,
								"etat" => 0
							);
							$this->db->where("CODE_BV")->update("base_sms_tur", $way);
						}
					}
				}
				
				
				
			}


/**********************************/

public function croneetat()
	{
		$select = '';

		$data = $this->db->query("select * from basebrutesms where etat = 0 ")->result();
		
		foreach ($data as $key) {
			
			$value = [
				"phone_number"=> $key->telephone,
				"code_bv"=> $key->contentsms
			];

			$dat = $this->db->select("*")->from("autorized_phone")->where("phone_number", $key->telephone)->where("code_bv", $key->contentsms)->get()->row();

			if (!$dat) {
				$this->db->insert("autorized_phone", $value);
			}
			$this->db->query("update basebrutesms set etat = 1 where id = ".$key->id." ");
			
		}

	       $this->cronereponse();
	}



	public function deconnecter()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('login-msg', "Veuillez-vous identifier");
		redirect(base_url());
	}

	/******************************************************************************************
						   Vérifier état connexion : se déconnecter si session null
	******************************************************************************************/
	public function testerSession()
	{
		if (!$this->session->userdata('isconnected')) {
			$this->session->set_flashdata('login-msg', "Votre session est expirée. Veuillez-vous reconnecter");
			redirect('login/index');
			return;
		}
	}


	public function exportExcel()
	{
		$fr = $this->input->post("fr");
		$rg = $this->input->post("rg");
		$ds = $this->input->post("ds");

		$excel = new PHPExcel();

		$tab_columns = array("Region", "District", "Commune", "Fokontany", "Centre de vote","CODE_BV", "Bureau de vote", "Nom et prenoms", "Telephone", "CIN");

		$artall = array();
		$lien = "uploads/DELEGUES_BUREAU_DE_VOTES" . date("YmdHis") . ".xls";

		if ($fr == "tous" && $rg == "tous" && $ds == "tous") {

			if ($_SESSION['type'] == 'Administrateur') {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("SELECT * from delegue")->result();
				$data = $this->db->query("select * from delegue group by rg ")->result();
			} else {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where rg in (  " . implode(",", $_SESSION['tabRegion']) . " )")->result();
				$data = $this->db->query("select * from delegue where rg in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by rg ")->result();
			}

			if (sizeof($datauser) == 0) {
				echo json_encode(array("id" => 0)); // aucune donnée a generer
			} else {


				$index = 0;

				foreach ($data as $value) {

					if ($index > 0) {
						$excel->createSheet($index);
					}

					$excel->setActiveSheetIndex($index);

					$currentSheet = $excel->getActiveSheet();
					$currentSheet->getStyle("A1:L1")->getFont()->setBold(true);

					$fkt = $this->db->query("select * from region where code_region = " . $value->rg . " ")->row();
					$currentSheet->setTitle($fkt->LIBELLE_REGION);

					$column = 0;
					foreach ($tab_columns as $field) {
						$currentSheet->setCellValueByColumnAndRow($column, 1, $field);
						$column++;
					}


					$row = 2;
					foreach ($datauser as $val) {

						$datas = $this->db->query("SELECT b.CODE_BV ,b.LIBELLE_BV ,  v.LIBELLE_CV , co.LIBELLE_COMMUNE , fk.LIBELLE_FOKONTANY , ds.LIBELLE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = ".$val->bv_ac." GROUP BY b.CODE_BV")->row();
										$reg = $this->db->query("select * from region where code_region = " . $val->rg . " ")->row();

						$bv_ac = $this->db->query("select * from bv where code_bv = " . $val->bv_ac . " ")->row();

						$excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $reg->LIBELLE_REGION);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $datas->LIBELLE_DISTRICT);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $datas->LIBELLE_COMMUNE);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $datas->LIBELLE_FOKONTANY);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $datas->LIBELLE_CV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $datas->CODE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $datas->LIBELLE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $val->nom);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $val->contact);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $val->cin);

						$row++;

					}
					$index++;

				}


				for ($col = 'A'; $col !== 'I'; $col++) {
					$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
				}


				$object_writer = PHPExcel_IOFactory::createWriter($excel, "Excel5");
				$object_writer->save(FCPATH . $lien);


				//$etat = $this->EclatementModel->valideBon($id);

				echo json_encode(array("id" => 1, "lien" => base_url() . $lien));


			}


		} else if ($fr != "tous" && $rg == "tous" && $ds == "tous") {



			if ($_SESSION['type'] == 'Administrateur') {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr ")->result();
				$data = $this->db->query("select * from delegue where fr = $fr  group by rg ")->result();
			} else {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr and rg in (  " . implode(",", $_SESSION['tabRegion']) . " )")->result();
				$data = $this->db->query("select * from delegue where fr = $fr and rg in (  " . implode(",", $_SESSION['tabRegion']) . " )  group by rg ")->result();
			}

			if (sizeof($datauser) == 0) {
				echo json_encode(array("id" => 0)); // aucune donnée a generer
			} else {


				$index = 0;

				foreach ($data as $value) {

					if ($index > 0) {
						$excel->createSheet($index);
					}

					$excel->setActiveSheetIndex($index);

					$currentSheet = $excel->getActiveSheet();
					$currentSheet->getStyle("A1:L1")->getFont()->setBold(true);

					$fkt = $this->db->query("select * from region where code_region = " . $value->rg . " ")->row();
					$currentSheet->setTitle($fkt->LIBELLE_REGION);

					$column = 0;
					foreach ($tab_columns as $field) {
						$currentSheet->setCellValueByColumnAndRow($column, 1, $field);
						$column++;
					}


					$row = 2;
					foreach ($datauser as $val) {

						$datas = $this->db->query("SELECT b.CODE_BV ,b.LIBELLE_BV ,  v.LIBELLE_CV , co.LIBELLE_COMMUNE , fk.LIBELLE_FOKONTANY , ds.LIBELLE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = ".$val->bv_ac." GROUP BY b.CODE_BV")->row();
										$reg = $this->db->query("select * from region where code_region = " . $val->rg . " ")->row();

						$bv_ac = $this->db->query("select * from bv where code_bv = " . $val->bv_ac . " ")->row();

						
						$excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $reg->LIBELLE_REGION);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $datas->LIBELLE_DISTRICT);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $datas->LIBELLE_COMMUNE);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $datas->LIBELLE_FOKONTANY);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $datas->LIBELLE_CV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $datas->CODE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $datas->LIBELLE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $val->nom);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $val->contact);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $val->cin);

						$row++;

					}
					$index++;

				}


				for ($col = 'A'; $col !== 'I'; $col++) {
					$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
				}


				$object_writer = PHPExcel_IOFactory::createWriter($excel, "Excel5");
				$object_writer->save(FCPATH . $lien);


				//$etat = $this->EclatementModel->valideBon($id);

				echo json_encode(array("id" => 1, "lien" => base_url() . $lien));


			}

		} else if ($fr != "tous" && $rg != "tous" && $ds == "tous") {

			if ($_SESSION['type'] == 'Administrateur') {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr and  rg = $rg ")->result();
				$data = $this->db->query("select * from delegue where fr = $fr and rg = $rg  group by rg ")->result();
			} else {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr  and rg = $rg and rg in (  " . implode(",", $_SESSION['tabRegion']) . " )")->result();
				$data = $this->db->query("select * from delegue where fr = $fr and rg = $rg  and rg in (  " . implode(",", $_SESSION['tabRegion']) . " )  group by rg ")->result();
			}
			if (sizeof($datauser) == 0) {
				echo json_encode(array("id" => 0)); // aucune donnée a generer
			} else {


				$index = 0;

				foreach ($data as $value) {

					if ($index > 0) {
						$excel->createSheet($index);
					}

					$excel->setActiveSheetIndex($index);

					$currentSheet = $excel->getActiveSheet();
					$currentSheet->getStyle("A1:L1")->getFont()->setBold(true);

					$fkt = $this->db->query("select * from region where code_region = " . $value->rg . " ")->row();
					$currentSheet->setTitle($fkt->LIBELLE_REGION);

					$column = 0;
					foreach ($tab_columns as $field) {
						$currentSheet->setCellValueByColumnAndRow($column, 1, $field);
						$column++;
					}


					$row = 2;
					foreach ($datauser as $val) {

						$datas = $this->db->query("SELECT b.CODE_BV ,b.LIBELLE_BV ,  v.LIBELLE_CV , co.LIBELLE_COMMUNE , fk.LIBELLE_FOKONTANY , ds.LIBELLE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = ".$val->bv_ac." GROUP BY b.CODE_BV")->row();
										$reg = $this->db->query("select * from region where code_region = " . $val->rg . " ")->row();

						$bv_ac = $this->db->query("select * from bv where code_bv = " . $val->bv_ac . " ")->row();

						
						$excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $reg->LIBELLE_REGION);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $datas->LIBELLE_DISTRICT);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $datas->LIBELLE_COMMUNE);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $datas->LIBELLE_FOKONTANY);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $datas->LIBELLE_CV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $datas->CODE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $datas->LIBELLE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $val->nom);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $val->contact);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $val->cin);

						$row++;

					}
					$index++;

				}


				for ($col = 'A'; $col !== 'I'; $col++) {
					$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
				}


				$object_writer = PHPExcel_IOFactory::createWriter($excel, "Excel5");
				$object_writer->save(FCPATH . $lien);


				//$etat = $this->EclatementModel->valideBon($id);

				echo json_encode(array("id" => 1, "lien" => base_url() . $lien));


			}

		} else if ($fr != "tous" && $rg != "tous" && $ds != "tous") {

			if ($_SESSION['type'] == 'Administrateur') {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr and  rg = $rg and ds = $ds ")->result();
				$data = $this->db->query("select * from delegue where fr = $fr and rg = $rg and ds = $ds  group by rg ")->result();
			} else {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr  and rg = $rg and rg in (  " . implode(",", $_SESSION['tabRegion']) . " ) and ds = $ds ")->result();
				$data = $this->db->query("select * from delegue where fr = $fr and rg = $rg  and rg in (  " . implode(",", $_SESSION['tabRegion']) . " ) and ds = $ds  group by rg ")->result();
			}
			if (sizeof($datauser) == 0) {
				echo json_encode(array("id" => 0)); // aucune donnée a generer
			} else {


				$index = 0;

				foreach ($data as $value) {

					if ($index > 0) {
						$excel->createSheet($index);
					}

					$excel->setActiveSheetIndex($index);

					$currentSheet = $excel->getActiveSheet();
					$currentSheet->getStyle("A1:L1")->getFont()->setBold(true);

					$fkt = $this->db->query("select * from region where code_region = " . $value->rg . " ")->row();
					$currentSheet->setTitle($fkt->LIBELLE_REGION);

					$column = 0;
					foreach ($tab_columns as $field) {
						$currentSheet->setCellValueByColumnAndRow($column, 1, $field);
						$column++;
					}


					$row = 2;
					foreach ($datauser as $val) {

						$datas = $this->db->query("SELECT b.CODE_BV ,b.LIBELLE_BV ,  v.LIBELLE_CV , co.LIBELLE_COMMUNE , fk.LIBELLE_FOKONTANY , ds.LIBELLE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = ".$val->bv_ac." GROUP BY b.CODE_BV")->row();
										$reg = $this->db->query("select * from region where code_region = " . $val->rg . " ")->row();

						$bv_ac = $this->db->query("select * from bv where code_bv = " . $val->bv_ac . " ")->row();

						
						$excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $reg->LIBELLE_REGION);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $datas->LIBELLE_DISTRICT);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $datas->LIBELLE_COMMUNE);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $datas->LIBELLE_FOKONTANY);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $datas->LIBELLE_CV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $datas->CODE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $datas->LIBELLE_BV);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $val->nom);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $val->contact);
						$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $val->cin);

						$row++;

					}
					$index++;

				}


				for ($col = 'A'; $col !== 'I'; $col++) {
					$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
				}


				$object_writer = PHPExcel_IOFactory::createWriter($excel, "Excel5");
				$object_writer->save(FCPATH . $lien);


				//$etat = $this->EclatementModel->valideBon($id);

				echo json_encode(array("id" => 1, "lien" => base_url() . $lien));


			}



		}


		if (sizeof($datauser) == 0) {
			$data[] = [
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				''
			];
		}


		//echo json_encode();

	}


	public function index()
	{
		$this->testerSession();
		$data['type'] = $_SESSION['type'];
		$data['prenom'] = $_SESSION['prenom'];
		$data['idRegion'] = $_SESSION['idRegion'];
		$data['tabRegion'] = $_SESSION['tabRegion'];
		$data['title'] = 'SITENY | Liste utilisateur';
		$regions = $this->db->query("select * from region")->result();
		if ($_SESSION['type'] == "Administrateur") {
			$faritra = $this->db->query("select * from faritany ")->result();
			$region = $this->db->query("select * from region where CODE_FARITANY = 1 ")->result();
		} else {
			$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
			$region = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_REGION ")->result();

		}

		//var_dump($region);die;
		$data['faritra'] = $faritra;
		$data['region'] = $region;
		$data['regions'] = $regions;
		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_delegue', $data);
		$this->load->view('layout/footer');
	}
	public function resultat()
	{
		$this->testerSession();
		$data['type'] = $_SESSION['type'];
		$data['prenom'] = $_SESSION['prenom'];
		$data['idRegion'] = $_SESSION['idRegion'];
		$data['tabRegion'] = $_SESSION['tabRegion'];
		$data['title'] = 'SITENY | Liste utilisateur';
		$regions = $this->db->query("select * from region")->result();
		if ($_SESSION['type'] == "Administrateur") {
			$faritra = $this->db->query("select * from faritany ")->result();
			$region = $this->db->query("select * from region")->result();
		} else {
			$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
			$region = $this->db->query("select * from region")->result();

		}

		//var_dump($region);die;
		$data['faritra'] = $faritra;
		$data['region'] = $region;
		$data['regions'] = $regions;
		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_resultat', $data);
		$this->load->view('layout/footer');
	}

	public function listeAnomalie()
	{
		$this->testerSession();
		$data['type'] = $_SESSION['type'];
		$data['prenom'] = $_SESSION['prenom'];
		$data['idRegion'] = $_SESSION['idRegion'];
		$data['tabRegion'] = $_SESSION['tabRegion'];
		$data['title'] = 'SITENY | Liste anomalie';

		$regions = $this->db->query("select * from region")->result();
		if ($_SESSION['type'] == "Administrateur") {
			$faritra = $this->db->query("select * from faritany ")->result();
			$region = $this->db->query("select * from region where CODE_FARITANY = 1 ")->result();
		} else {
			$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
			$region = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_REGION ")->result();

		}

		//var_dump($region);die;
		$data['faritra'] = $faritra;
		$data['region'] = $region;
		$data['regions'] = $regions;


		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_anomalie');
		$this->load->view('layout/footer');
	}



	public function chargeRegion()
	{
		$select = "";

		$i = 0;
		if ($_SESSION['type'] == "Administrateur") {

			$data = $this->db->query("select * from region where CODE_FARITANY = " . $_POST["id"] . " ")->result();
		} else {
			$data = $this->db->query("select * from region where CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by CODE_REGION ")->result();
			# code...
		}

		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_REGION . "' selected >" . $key->LIBELLE_REGION . "</option>";
			$i++;
		}




		echo $select;
	}
	public function chargeRegion1()
	{
		$select = "";

		$i = 0;
		if ($_SESSION['type'] == "Administrateur") {

			$data = $this->db->query("select * from region where CODE_FARITANY = " . $_POST["id"] . " ")->result();
		} else {
			$data = $this->db->query("select * from region where CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by CODE_REGION ")->result();
			# code...
		}

		$select .= "<option value='tous' selected>Tous</option>";

		foreach ($data as $key) {

			$select .= "<option value='" . $key->CODE_REGION . "' >" . $key->LIBELLE_REGION . "</option>";
			$i++;
		}




		echo $select;
	}
	public function ajout()
	{
		$table = "r" . $_POST["rg"];

		if ($_POST["cin"] != "" ) {

			$ty = $this->db->query("select * from delegue where cin = " . $_POST["cin"] . " and rg = " . $_POST["rg"] . " ")->row();

			if ($ty != null) {
				echo json_encode(array('id' => 2));
			} else {

				$datas = $this->db->query("SELECT CINELECT FROM " . $table . " WHERE CINELECT = " . $_POST["cin"] . "  ")->row();
				if ($datas != null) {
					$_POST["date_check"] = date('Y-m-j');
					$_POST["type"] = 1;
					$_POST["par"] = $_SESSION['email'];
					$_POST["id_user"] = $_SESSION['id'];
					$this->db->insert("delegue", $_POST);


				} else {
					$_POST["date_check"] = date('Y-m-j');
					$_POST["type"] = 0;
					$_POST["par"] = $_SESSION['email'];
					$_POST["id_user"] = $_SESSION['id'];
					$this->db->insert("delegue", $_POST);

				}
				echo json_encode(array('id' => 1));


			}

		} else {
			$_POST["date_check"] = date('Y-m-j');
			$_POST["type"] = 0;
			$_POST["par"] = $_SESSION['email'];
			$_POST["id_user"] = $_SESSION['id'];
			$this->db->insert("delegue", $_POST);
			echo json_encode(array('id' => 1));
		}


	}

	public function updatebvsms()
	{

		//var_dump($_POST);die;
		       $datas = $this->db->query("select * from base_resultat where CODE_BV =" . $_POST["bv"] ." ")->row();

				if ($datas != null) {


					$ty = $this->db->query("select * from base_resultat where CODE_BV =" . $_POST["bv"] . " and voix13 = ".$_POST["siteny"]." and voix05 = ".$_POST["marc"]." and voix03 = ".$_POST["andry"]."  and total = ".$_POST["total"]."  ")->row();			
			
						if ($ty == null) {
							$data = array();
							$data["voix01"] = $_POST["tahina"];
							$data["voix02"] = $_POST["hajo"];
							$data["voix03"] = $_POST["andry"];
							$data["voix04"] = $_POST["roland"];
							$data["voix05"] = $_POST["marc"];
							$data["voix06"] = $_POST["auguste"];
							$data["voix07"] = $_POST["raobelina"];
							$data["voix08"] = $_POST["brunelle"];
							$data["voix09"] = $_POST["lalaina"];
							$data["voix10"] = $_POST["hery"];
							$data["voix11"] = $_POST["sendrison"];
							$data["voix12"] = $_POST["jean"];
							$data["voix13"] = $_POST["siteny"];
							$data["fotsy"] = $_POST["fotsy"];
							$data["maty"] = $_POST["maty"];
							$data["total"] = $_POST["total"];
							$data["etat"] = 3;
							
							$this->db
							->where("CODE_BV", $_POST["bv"])
							->update("base_resultat", $data);
							
							echo json_encode(array('id' => 1));
						} else {
							
							$datas = $this->db->query("select * from base_resultat where CODE_BV =" . $_POST["bv"] ." ")->row();

							if ( $datas->voix03 == "" && $datas->voix05 == "" && $datas->voix13 == "" && $datas->total == "" ) {

								$data = array();
								$data["voix01"] = $_POST["tahina"];
								$data["voix02"] = $_POST["hajo"];
								$data["voix03"] = $_POST["andry"];
								$data["voix04"] = $_POST["roland"];
								$data["voix05"] = $_POST["marc"];
								$data["voix06"] = $_POST["auguste"];
					 			$data["voix07"] = $_POST["raobelina"];
								$data["voix08"] = $_POST["brunelle"];
								$data["voix09"] = $_POST["lalaina"];
								$data["voix10"] = $_POST["hery"];
								$data["voix11"] = $_POST["sendrison"];
								$data["voix12"] = $_POST["jean"];
								$data["voix13"] = $_POST["siteny"];
								$data["fotsy"] = $_POST["fotsy"];
								$data["maty"] = $_POST["maty"];
								$data["total"] = $_POST["total"];
								$data["etat"] = 3;
								
								$this->db
								->where("CODE_BV", $_POST["bv"])
								->update("base_resultat", $data);
								
								echo json_encode(array('id' => 1));

							} else {
								$marc = ( $datas->voix05 == "" ) ? 0 : $datas->voix05  ; 
								$andry =  ( $datas->voix03 == "" ) ? 0 : $datas->voix03  ; 
								$siteny =  ( $datas->voix13 == "" ) ? 0 : $datas->voix13  ; 
								$total =  ( $datas->total == "" ) ? 0 : $datas->total ; 
								$text = "Siteny : ".$siteny." et Andry : ".$andry." et Marc : ". $marc." et Total : ". $total ;
								echo json_encode(array('id' => 2 , "rep"=> $text ));
								
							}


						}



				} else {


					echo json_encode(array('id' => 3 ));


				}

				// $this->cronesaisie();
	}

	public function miseajour()
	{
		        $data = [];
				$data["voix01"] = $_POST["tahina"];
				$data["voix02"] = $_POST["hajo"];
				$data["voix03"] = $_POST["andry"];
				$data["voix04"] = $_POST["roland"];
				$data["voix05"] = $_POST["marc"];
				$data["voix06"] = $_POST["auguste"];
				$data["voix07"] = $_POST["raobelina"];
				$data["voix08"] = $_POST["brunelle"];
				$data["voix09"] = $_POST["lalaina"];
				$data["voix10"] = $_POST["hery"];
				$data["voix11"] = $_POST["sendrison"];
				$data["voix12"] = $_POST["jean"];
				$data["voix13"] = $_POST["siteny"];
				$data["fotsy"] = $_POST["fotsy"];
				$data["maty"] = $_POST["maty"];
				$data["total"] = $_POST["total"];
				$data["etat"] = 3;
				
				$this->db
				->where("CODE_BV", $_POST["bv"])
				->update("base_resultat", $data);
				echo json_encode(array('id' => 1));
				// $this->cronesaisie();

	}
	
	public function ajoutExcel()
	{
		$table = "r" . $_POST["rg"];
		
		$lien = '';

		if (isset($_FILES['excel']['name']) && $_FILES['excel']['error'] == UPLOAD_ERR_OK) {
			$uploadedFile = $_FILES['excel']['tmp_name'];
			$lien = pathinfo($_FILES['excel']['name'], PATHINFO_FILENAME) ;
			// Créez un lecteur PHPExcel
			$objReader = PHPExcel_IOFactory::createReaderForFile($uploadedFile);
			$objReader->setReadDataOnly(true);

			// Chargez le fichier Excel
			$objPHPExcel = $objReader->load($uploadedFile);

			$typ = $_POST["type"] ;

			// Parcourez les feuilles du classeur
			foreach ($objPHPExcel->getAllSheets() as $sheet) {

				// Obtenez la première ligne (en-têtes)

				// Démarrez à la deuxième ligne
				$rowCount = 0;

				// Parcourez les lignes
				foreach ($sheet->getRowIterator() as $row) {
					$rowData = [];

					if ($rowCount > 0) {
						$BV = "";
						$Nom = "";
						$Prenom = "";
						$CIN = "";
						$Telephone = "";
						// Parcourez les cellules de la ligne
						$j = 0;
						
						if ( $typ == '3') {
						
							foreach ($row->getCellIterator() as $cell) {
								$cellValue = $cell->getValue();
								$cellColumn = $cell->getColumn();
	
								// Obtenez l'indice de la colonne (par exemple, 0 pour la première colonne, 1 pour la deuxième, etc.)
								$columnIndex = PHPExcel_Cell::columnIndexFromString($cellColumn) - 1;
	
								// if ($j == 7) {
								// 	$BV = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 11) {
								// 	$Nom = trim($cellValue);
								// }
								// if ($j == 12) {
								// 	$Prenom = trim($cellValue);
								// }
								// if ($j == 13) {
								// 	$CIN = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 14) {
								// 	$Telephone = str_replace(' ', '', $cellValue);
								// }
	
								if ($j == 7) {
									$BV = str_replace(' ', '', $cellValue);
								}
								if ($j == 11) {
									$Nom = trim($cellValue);
								}
								if ($j == 12) {
									$CIN = str_replace(' ', '', $cellValue);
								}
								if ($j == 13) {
									$Telephone = str_replace(' ', '', $cellValue);
								}
	
								// var_dump($j);
								// var_dump($cellValue);
	
	
								$j++;
							}
						} else {
							
							foreach ($row->getCellIterator() as $cell) {
								$cellValue = $cell->getValue();
								$cellColumn = $cell->getColumn();
	
								// Obtenez l'indice de la colonne (par exemple, 0 pour la première colonne, 1 pour la deuxième, etc.)
								$columnIndex = PHPExcel_Cell::columnIndexFromString($cellColumn) - 1;
	
								if ($j == 7) {
									$BV = str_replace(' ', '', $cellValue);
								}
								if ($j == 11) {
									$Nom = trim($cellValue);
								}
								if ($j == 12) {
									$Prenom = trim($cellValue);
								}
								if ($j == 13) {
									$CIN = str_replace(' ', '', $cellValue);
								}
								if ($j == 14) {
									$Telephone = str_replace(' ', '', $cellValue);
								}
	
								// if ($j == 7) {
								// 	$BV = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 11) {
								// 	$Nom = trim($cellValue);
								// }
								// if ($j == 12) {
								// 	$CIN = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 13) {
								// 	$Telephone = str_replace(' ', '', $cellValue);
								// }
	
								// var_dump($j);
								// var_dump($cellValue);
	
	
								$j++;
							}
						}
						
						
						
						

						if ($BV != '') {
							if ($Nom == "") {
								# code...
							} else {
	
	
								// array_push($an, $op);
								// $te = $this->db->query("select * from baseimport where cin = " . $CIN . "  && bv = " . $BV . " &&  type = 3  && rg = " . $_POST["rg"] . " limit 1 ")->row();
								// if ($te) {
								// 	# code...
								// } else {
								// 	# code...
	
								// }
	
								if ($CIN== '' || $CIN == 0) {
	
									$io = strtolower($Nom ." ". $Prenom);
									$test = $this->db->query("select * from baseimport where LOWER(REPLACE(nom, ' ', ''))  = '" .  str_replace(' ', '', $io) . "' and bv = ".$BV." and rg= " . $_POST["rg"] . " limit 1 ")->row();
									$op = array(

											"nom" => $io
											,
											"prenom" => $Prenom
											,
											"bv" => $BV
											,
											"contact" => $Telephone
											,
											"rg" => $_POST["rg"]
											,
											"date" => date('Y-m-j H:i:s')
											,
											"type" => 3
											,
											"etat" => 1 //anomalie
			
										);
									if ($test) {
										$this->db->where("bv", $BV)->update("baseimport", $op);
									} else {
										
										$this->db->insert("baseimport", $op);
										
									}

									$datas = $this->db->query("SELECT b.CODE_BV ,  v.CODE_CV , co.CODE_COMMUNE , fk.CODE_FOKONTANY , ds.CODE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = $BV GROUP BY b.CODE_BV")->row();
	
										$_POST["date_check"] = date('Y-m-j H:i:s');
										$_POST["type"] = 1;
										$_POST["cin"] = "";
										$_POST["contact"] = $Telephone;
										$_POST["nom"] = $Nom . " " . $Prenom;
										$_POST["par"] = $_SESSION['email'];
										$_POST["id_user"] = $_SESSION['id'];
										$_POST["bv"] = $datas->CODE_BV;
										$_POST["ds"] = $datas->CODE_DISTRICT;
										$_POST["cm"] = $datas->CODE_COMMUNE;
										$_POST["cv"] = $datas->CODE_CV;
										$_POST["type"] = 1;
										$_POST["fk"] = $datas->CODE_FOKONTANY;
										$_POST["fr"] = $datas->CODE_FARITANY;
										$_POST["bv_ac"] = $BV;
	
										$ty = $this->db->query("select * from delegue where bv_ac  = " . $BV . " and LOWER(REPLACE(nom, ' ', ''))   = '" .  str_replace(' ', '', $io) . "' and rg = " . $_POST["rg"] . " limit 1")->row();
	
										if ($ty != null) {
											$sql = "
											update delegue
											set date_check = '" . date('Y-m-j H:i:s') . "' ,
											type = 1,
											cin =  '" .  $CIN . "',
											contact = '" . $Telephone  . "',
											nom = '" .$io  . "',
											par = '" . $_SESSION['email']  . "',
											id_user = '" . $_SESSION['id']  . "',
											bv =  '" . $datas->CODE_BV  . "',
											ds =  '" . $datas->CODE_DISTRICT  . "',
											cm = '" . $datas->CODE_COMMUNE  . "',
											cv = '" . $datas->CODE_CV  . "',
											type = 1,
											fk = '" . $datas->CODE_FOKONTANY  . "',
											fr = '" . $datas->CODE_FARITANY  . "',
											bv_ac = '" . $BV  . "' where LOWER(REPLACE(nom, ' ', '')) = '". str_replace(' ', '', $io) ."' and bv_ac = $BV and rg = ". $_POST["rg"] ."

										";

										$this->db->query($sql);
										}
										else{
	
											$this->db->insert("delegue", $_POST);
	
											
	
									   }
									# code...
								} else {

									$io = strtolower($Nom ." ". $Prenom);
									$test = $this->db->query("select * from baseimport where  LOWER(REPLACE(nom, ' ', ''))  = '" .   str_replace(' ', '', $io) . "' and bv = ".$BV." and rg= " . $_POST["rg"] . " limit 1 ")->row();
									$op = array(

										"nom" => $io
										,
										"prenom" => $Prenom
										,
										"cin" => $CIN
										,
										"bv" => $BV
										,
										"contact" => $Telephone
										,
										"rg" => $_POST["rg"]
										,
										"date" => date('Y-m-j H:i:s')
										,
										"type" => 1 // 3 cin io double anaty region io fa bv samy hafa bv
										,
										"etat" => 1 //anomalie
		
										);

									if ($test) {
										$this->db->where("bv", $BV)->where("rg",$_POST["rg"])->update("baseimport", $op);
									} else {
										
										$this->db->insert("baseimport", $op);
										
									}
									
									$datas = $this->db->query("SELECT e.CINELECT , e.NOMELECT , COALESCE(e.PRENOMELECT, '') AS PRENOMELECT  , v.CODE_CV , b.CODE_BV , fk.CODE_FOKONTANY , co.CODE_COMMUNE , ds.CODE_DISTRICT , r.CODE_REGION , fr.CODE_FARITANY  FROM " . $table . " e , bv b , cv v , fokontany fk 
								, commune co , district ds , region r , faritany fr
								WHERE  e.CODE_BV = b.CODE_BV AND b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT 
								AND r.CODE_REGION= ds.CODE_REGION AND fr.CODE_FARITANY = r.CODE_FARITANY
								and r.CODE_REGION = " . $_POST["rg"] . " and e.CINELECT = " . $CIN . " limit 1 
								")->row();

								if ($datas) {
									$_POST["date_check"] = date('Y-m-j H:i:s');
									$_POST["type"] = 1;
									$_POST["cin"] = $CIN;
									$_POST["contact"] = $Telephone;
									$_POST["nom"] = $io ;
									$_POST["par"] = $_SESSION['email'];
									$_POST["id_user"] = $_SESSION['id'];
									$_POST["bv"] = $datas->CODE_BV;
									$_POST["ds"] = $datas->CODE_DISTRICT;
									$_POST["cm"] = $datas->CODE_COMMUNE;
									$_POST["cv"] = $datas->CODE_CV;
									$_POST["type"] = 1;
									$_POST["fk"] = $datas->CODE_FOKONTANY;
									$_POST["fr"] = $datas->CODE_FARITANY;
									$_POST["bv_ac"] = $BV;

									$ty = $this->db->query("select * from delegue where bv_ac  = " . $BV . " and LOWER(REPLACE(nom, ' ', ''))  = '" .  str_replace(' ', '', $io) . "' and rg = " . $_POST["rg"] . " limit 1")->row();

									if ($ty != null) {
										
										$sql = "
											update delegue
											set date_check = '" . date('Y-m-j H:i:s') . "' ,
											type = 1,
											cin =  '" .  $CIN . "',
											contact = '" . $Telephone  . "',
											nom = '" .$io  . "',
											par = '" . $_SESSION['email']  . "',
											id_user = '" . $_SESSION['id']  . "',
											bv =  '" . $datas->CODE_BV  . "',
											ds =  '" . $datas->CODE_DISTRICT  . "',
											cm = '" . $datas->CODE_COMMUNE  . "',
											cv = '" . $datas->CODE_CV  . "',
											type = 1,
											fk = '" . $datas->CODE_FOKONTANY  . "',
											fr = '" . $datas->CODE_FARITANY  . "',
											bv_ac = '" . $BV  . "' where LOWER(REPLACE(nom, ' ', '')) = '". str_replace(' ', '', $io) ."' and bv_ac = $BV and rg = ". $_POST["rg"] ."

										";

										$this->db->query($sql);
									}
									else{

										$this->db->insert("delegue", $_POST);
										
			
										// $op["type"] = 3;
										// $this->db->insert("baseimport", $op);
											
									}
									//var_dump($_POST);

								}else{
									$datas = $this->db->query("SELECT b.CODE_BV ,  v.CODE_CV , co.CODE_COMMUNE , fk.CODE_FOKONTANY , ds.CODE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
									, commune co , district ds , region r ,  faritany fr
									WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
									AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
									AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = $BV GROUP BY b.CODE_BV")->row();
									
									$ty = $this->db->query("select * from delegue where bv_ac  = " . $BV . " and LOWER(REPLACE(nom, ' ', ''))  = '" .  str_replace(' ', '', $io) . "' and rg = " . $_POST["rg"] . " limit 1")->row();

									$_POST["date_check"] = date('Y-m-j H:i:s');
								$_POST["type"] = 1;
								$_POST["cin"] = $CIN;
								$_POST["contact"] = $Telephone;
								$_POST["nom"] = $Nom . " " . $Prenom;
								$_POST["par"] = $_SESSION['email'];
								$_POST["id_user"] = $_SESSION['id'];
								$_POST["bv"] = $datas->CODE_BV;
								$_POST["ds"] = $datas->CODE_DISTRICT;
								$_POST["cm"] = $datas->CODE_COMMUNE;
								$_POST["cv"] = $datas->CODE_CV;
								$_POST["type"] = 0;
								$_POST["fk"] = $datas->CODE_FOKONTANY;
								$_POST["fr"] = $datas->CODE_FARITANY;
								$_POST["bv_ac"] = $BV;

									if ($ty != null) {

										$sql = "
											update delegue
											set date_check = '" . date('Y-m-j H:i:s') . "' ,
											type = 1,
											cin =  '" .  $CIN . "',
											contact = '" . $Telephone  . "',
											nom = '" .$io  . "',
											par = '" . $_SESSION['email']  . "',
											id_user = '" . $_SESSION['id']  . "',
											bv =  '" . $datas->CODE_BV  . "',
											ds =  '" . $datas->CODE_DISTRICT  . "',
											cm = '" . $datas->CODE_COMMUNE  . "',
											cv = '" . $datas->CODE_CV  . "',
											type = 1,
											fk = '" . $datas->CODE_FOKONTANY  . "',
											fr = '" . $datas->CODE_FARITANY  . "',
											bv_ac = '" . $BV  . "' where LOWER(REPLACE(nom, ' ', '')) = '". str_replace(' ', '', $io) ."' and bv_ac = $BV and rg = ". $_POST["rg"] ."

										";

										$this->db->query($sql);
									}
									else{
										$this->db->insert("delegue", $_POST);
									
									}

									
								}
							}
	
	
	
	
							}
						} 


						
					}

					$rowCount++;
				}
			}

			echo json_encode(array("id" => 1 , "lien" => $lien));
		} else {
			// Gérez les erreurs de téléchargement du fichier
			echo "Erreur lors du téléchargement du fichier Excel.";
		}




	}

	public function ajoutExcelupdate()
	{
		
		$lien = '';

		if (isset($_FILES['excel1']['name']) && $_FILES['excel1']['error'] == UPLOAD_ERR_OK) {
			$uploadedFile = $_FILES['excel1']['tmp_name'];
			$lien = pathinfo($_FILES['excel1']['name'], PATHINFO_FILENAME) ;
			// Créez un lecteur PHPExcel
			$objReader = PHPExcel_IOFactory::createReaderForFile($uploadedFile);
			$objReader->setReadDataOnly(true);

			// Chargez le fichier Excel
			$objPHPExcel = $objReader->load($uploadedFile);

			$typ = $_POST["type"] ;

			foreach ($objPHPExcel->getAllSheets() as $sheet) {

				// Obtenez la première ligne (en-têtes)

				// Démarrez à la deuxième ligne
				$rowCount = 0;

				// Parcourez les lignes
				foreach ($sheet->getRowIterator() as $row) {
					$rowData = [];

					if ($rowCount > 0) {
						$BV = "";
						$Nom = "";
						$Prenom = "";
						$CIN = "";
						$Telephone = "";
						// Parcourez les cellules de la ligne
						$j = 0;
						
						if ( $typ == '3') {
						
							foreach ($row->getCellIterator() as $cell) {
								$cellValue = $cell->getValue();
								$cellColumn = $cell->getColumn();
	
								// Obtenez l'indice de la colonne (par exemple, 0 pour la première colonne, 1 pour la deuxième, etc.)
								$columnIndex = PHPExcel_Cell::columnIndexFromString($cellColumn) - 1;
	
								// if ($j == 7) {
								// 	$BV = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 11) {
								// 	$Nom = trim($cellValue);
								// }
								// if ($j == 12) {
								// 	$Prenom = trim($cellValue);
								// }
								// if ($j == 13) {
								// 	$CIN = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 14) {
								// 	$Telephone = str_replace(' ', '', $cellValue);
								// }
	
								if ($j == 7) {
									$BV = str_replace(' ', '', $cellValue);
								}
								if ($j == 11) {
									$Nom = trim($cellValue);
								}
								if ($j == 12) {
									$CIN = str_replace(' ', '', $cellValue);
								}
								if ($j == 13) {
									$Telephone = str_replace(' ', '', $cellValue);
								}
	
								// var_dump($j);
								// var_dump($cellValue);
	
	
								$j++;
							}
						} else {
							
							foreach ($row->getCellIterator() as $cell) {
								$cellValue = $cell->getValue();
								$cellColumn = $cell->getColumn();
	
								// Obtenez l'indice de la colonne (par exemple, 0 pour la première colonne, 1 pour la deuxième, etc.)
								$columnIndex = PHPExcel_Cell::columnIndexFromString($cellColumn) - 1;
	
								if ($j == 7) {
									$BV = str_replace(' ', '', $cellValue);
								}
								if ($j == 11) {
									$Nom = trim($cellValue);
								}
								if ($j == 12) {
									$Prenom = trim($cellValue);
								}
								if ($j == 13) {
									$CIN = str_replace(' ', '', $cellValue);
								}
								if ($j == 14) {
									$Telephone = str_replace(' ', '', $cellValue);
								}
	
								// if ($j == 7) {
								// 	$BV = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 11) {
								// 	$Nom = trim($cellValue);
								// }
								// if ($j == 12) {
								// 	$CIN = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 13) {
								// 	$Telephone = str_replace(' ', '', $cellValue);
								// }
	
								// var_dump($j);
								// var_dump($cellValue);
	
	
								$j++;
							}
						}
						
						
						
						

						if ($BV != '') {

							$this->db->query("delete from delegue where bv_ac = $BV ");
							
						} 


						
					}

					$rowCount++;
				}
			}

			// Parcourez les feuilles du classeur
			foreach ($objPHPExcel->getAllSheets() as $sheet) {

				// Obtenez la première ligne (en-têtes)

				// Démarrez à la deuxième ligne
				$rowCount = 0;

				// Parcourez les lignes
				foreach ($sheet->getRowIterator() as $row) {
					$rowData = [];

					if ($rowCount > 0) {
						$BV = "";
						$Nom = "";
						$Prenom = "";
						$CIN = "";
						$Telephone = "";
						// Parcourez les cellules de la ligne
						$j = 0;
						
						if ( $typ == '3') {
						
							foreach ($row->getCellIterator() as $cell) {
								$cellValue = $cell->getValue();
								$cellColumn = $cell->getColumn();
	
								// Obtenez l'indice de la colonne (par exemple, 0 pour la première colonne, 1 pour la deuxième, etc.)
								$columnIndex = PHPExcel_Cell::columnIndexFromString($cellColumn) - 1;
	
								// if ($j == 7) {
								// 	$BV = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 11) {
								// 	$Nom = trim($cellValue);
								// }
								// if ($j == 12) {
								// 	$Prenom = trim($cellValue);
								// }
								// if ($j == 13) {
								// 	$CIN = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 14) {
								// 	$Telephone = str_replace(' ', '', $cellValue);
								// }
	
								if ($j == 7) {
									$BV = str_replace(' ', '', $cellValue);
								}
								if ($j == 11) {
									$Nom = trim($cellValue);
								}
								if ($j == 12) {
									$CIN = str_replace(' ', '', $cellValue);
								}
								if ($j == 13) {
									$Telephone = str_replace(' ', '', $cellValue);
								}
	
								// var_dump($j);
								// var_dump($cellValue);
	
	
								$j++;
							}
						} else {
							
							foreach ($row->getCellIterator() as $cell) {
								$cellValue = $cell->getValue();
								$cellColumn = $cell->getColumn();
	
								// Obtenez l'indice de la colonne (par exemple, 0 pour la première colonne, 1 pour la deuxième, etc.)
								$columnIndex = PHPExcel_Cell::columnIndexFromString($cellColumn) - 1;
	
								if ($j == 7) {
									$BV = str_replace(' ', '', $cellValue);
								}
								if ($j == 11) {
									$Nom = trim($cellValue);
								}
								if ($j == 12) {
									$Prenom = trim($cellValue);
								}
								if ($j == 13) {
									$CIN = str_replace(' ', '', $cellValue);
								}
								if ($j == 14) {
									$Telephone = str_replace(' ', '', $cellValue);
								}
	
								// if ($j == 7) {
								// 	$BV = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 11) {
								// 	$Nom = trim($cellValue);
								// }
								// if ($j == 12) {
								// 	$CIN = str_replace(' ', '', $cellValue);
								// }
								// if ($j == 13) {
								// 	$Telephone = str_replace(' ', '', $cellValue);
								// }
	
								// var_dump($j);
								// var_dump($cellValue);
	
	
								$j++;
							}
						}
						
						
						
						

						if ($BV != '') {
							if ($Nom == "") {
								# code...
							} else {
	
	
								// array_push($an, $op);
								// $te = $this->db->query("select * from baseimport where cin = " . $CIN . "  && bv = " . $BV . " &&  type = 3  && rg = " . $_POST["rg"] . " limit 1 ")->row();
								// if ($te) {
								// 	# code...
								// } else {
								// 	# code...
	
								// }


								$datas = $this->db->query("SELECT b.CODE_BV ,  v.CODE_CV , co.CODE_COMMUNE , fk.CODE_FOKONTANY , ds.CODE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = $BV GROUP BY b.CODE_BV")->row();
	


	
										$io = strtolower($Nom ." ". $Prenom);

										$datasds = array();

										$datasds["date_check"] = date('Y-m-j H:i:s');
										$datasds["cin"] = $CIN;
										$datasds["contact"] = $Telephone;
										$datasds["nom"] = $io ;
										$datasds["par"] = $_SESSION['email'];
										$datasds["id_user"] = $_SESSION['id'];
										$datasds["bv"] = $datas->CODE_BV;
										$datasds["ds"] = $datas->CODE_DISTRICT;
										$datasds["cm"] = $datas->CODE_COMMUNE;
										$datasds["cv"] = $datas->CODE_CV;
										$datasds["fk"] = $datas->CODE_FOKONTANY;
										$datasds["fr"] = $datas->CODE_FARITANY;
										$datasds["bv_ac"] = $BV;

										$this->db->insert("delegue", $datasds);

								
							}
	
	
	
	
						
						} 


						
					}

					$rowCount++;
				}
			}

			echo json_encode(array("id" => 1 , "lien" => $lien));
		} else {
			// Gérez les erreurs de téléchargement du fichier
			echo "Erreur lors du téléchargement du fichier Excel.";
		}




	}
	public function autocomplete()
	{
		$data = [];
		$fary = $this->input->post('fary');
		$reg = $this->input->post('regy');
		$table = "r" . $reg;
		$keyword = $this->input->post('query');
		$datas = $this->db->query("SELECT e.CINELECT , e.NOMELECT , COALESCE(e.PRENOMELECT, '') AS PRENOMELECT  , v.CODE_CV , b.CODE_BV , fk.CODE_FOKONTANY , co.CODE_COMMUNE , ds.CODE_DISTRICT , r.CODE_REGION , fr.CODE_FARITANY  FROM " . $table . " e , bv b , cv v , fokontany fk 
	   , commune co , district ds , region r , faritany fr
	   WHERE  e.CODE_BV = b.CODE_BV AND b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT 
	   AND r.CODE_REGION= ds.CODE_REGION AND fr.CODE_FARITANY= r.CODE_FARITANY
	   and fr.CODE_FARITANY = " . $fary . " and r.CODE_REGION = " . $reg . " and e.CINELECT like '" . $keyword . "%' limit 1 
	   ")->result();
		//$datas = $this->db->query("SELECT CINELECT FROM electeur WHERE CINELECT like '".$keyword."%' limit 1")->result();

		foreach ($datas as $key) {
			# code...
			$data[] = $key->CINELECT;
		}
		echo json_encode($data);

	}
	public function chearchName()
	{
		$data = [];
		$keyword = $this->input->post('query');
		$fary = $this->input->post('fary');
		$reg = $this->input->post('regy');
		$table = "r" . $reg;
		$datas = $this->db->query("SELECT e.CINELECT , e.NOMELECT , COALESCE(e.PRENOMELECT, '') AS PRENOMELECT  , v.CODE_CV , b.CODE_BV , fk.CODE_FOKONTANY , co.CODE_COMMUNE , ds.CODE_DISTRICT , r.CODE_REGION , fr.CODE_FARITANY  FROM " . $table . " e , bv b , cv v , fokontany fk 
	   , commune co , district ds , region r , faritany fr
	   WHERE  e.CODE_BV = b.CODE_BV AND b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT 
	   AND r.CODE_REGION= ds.CODE_REGION AND fr.CODE_FARITANY= r.CODE_FARITANY
	   and fr.CODE_FARITANY = " . $fary . " and r.CODE_REGION = " . $reg . " and ( NOMELECT like '%" . $keyword . "%' OR PRENOMELECT like '%" . $keyword . "%' ) limit 10 
	   ")->result();

		foreach ($datas as $key) {
			# code...
			$data[] = $key->CINELECT;
		}

		var_dump($data);
		die;

		echo json_encode($data);

	}
	public function searchCIN()
	{

		$keyword = $this->input->post('cin');
		$fary = $this->input->post('fary');
		$reg = $this->input->post('regy');
		$table = "r" . $reg;


		$datas = $this->db->query("SELECT e.CINELECT , e.NOMELECT , COALESCE(e.PRENOMELECT, '') AS PRENOMELECT  , v.CODE_CV , b.CODE_BV , fk.CODE_FOKONTANY , co.CODE_COMMUNE , ds.CODE_DISTRICT , r.CODE_REGION , fr.CODE_FARITANY  FROM " . $table . " e , bv b , cv v , fokontany fk 
	   , commune co , district ds , region r , faritany fr
	   WHERE  e.CODE_BV = b.CODE_BV AND b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT 
	   AND r.CODE_REGION= ds.CODE_REGION AND fr.CODE_FARITANY= r.CODE_FARITANY
	   and fr.CODE_FARITANY = " . $fary . " and r.CODE_REGION = " . $reg . " and e.CINELECT = " . $keyword . " 
	   ")->result();
		if ($datas) {
			# code...
			echo json_encode(array('id' => 1, "data" => $datas));
		} else {

			echo json_encode(array('id' => 0));
		}


	}
	public function chargeDistrict()
	{
		//var_dump($_POST["id"]);
		$select = "";
		$data = $this->db->query("select * from district where CODE_REGION = " . $_POST["id"] . " ")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";

			$select .= "<option value='" . $key->CODE_DISTRICT . "' >" . $key->LIBELLE_DISTRICT . "</option>";
			$i++;
		}


		echo $select;
	}
	public function chargeDistrict1()
	{
		//var_dump($_POST["id"]);
		$select = "";
		$data = $this->db->query("select * from district where CODE_REGION = " . $_POST["id"] . " ")->result();
		$i = 0;
		$select .= "<option value='tous' selected >tous</option>";
		foreach ($data as $key) {

			$select .= "<option value='" . $key->CODE_DISTRICT . "' >" . $key->LIBELLE_DISTRICT . "</option>";
			$i++;
		}


		echo $select;
	}
	public function chargeCommune()
	{

		$select = "";
		$data = $this->db->query("select * from commune where CODE_DISTRICT = " . $_POST["id"] . "")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_COMMUNE . "' >" . $key->LIBELLE_COMMUNE . "</option>";
			$i++;
		}



		echo $select;
	}
	public function chargeFoko()
	{
		$select = '';


		$data = $this->db->query("select * from fokontany where CODE_COMMUNE = " . $_POST["id"] . "")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_FOKONTANY . "' >" . $key->LIBELLE_FOKONTANY . "</option>";
			$i++;
		}



		echo $select;
	}

	public function chargeCV()
	{
		$select = '';


		$data = $this->db->query("select * from cv where CODE_FOKONTANY = " . $_POST["id"] . "")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_CV . "' >" . $key->LIBELLE_CV . "</option>";
			$i++;
		}


		echo $select;
	}
	public function chargeBV()
	{
		$select = '';


		$data = $this->db->query("select * from bv where CODE_CV = " . $_POST["id"] . "")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_BV . "' >" . $key->LIBELLE_BV . "</option>";
			$i++;
		}



		echo $select;
	}
	public function chargeBVA()
	{
		$select = '';


		$data = $this->db->query("select bv.* from commune , bv , cv f , fokontany h WHERE bv.CODE_CV = f.CODE_CV AND h.CODE_FOKONTANY = f.CODE_FOKONTANY AND commune.CODE_COMMUNE = h.CODE_COMMUNE and  h.CODE_COMMUNE = " . $_POST["id"] . "")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_BV . "' >" . $key->LIBELLE_BV . "</option>";
			$i++;
		}


		echo $select;
	}
}
