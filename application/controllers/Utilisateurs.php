<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateurs extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->library(['form_validation','session']);
		$this->load->model('login/login_model');
		$this->load->helper('url');
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
		if (!$this->session->userdata('isconnected'))
		{
			$this->session->set_flashdata('login-msg', "Votre session est expirée. Veuillez-vous reconnecter");
			redirect('login/index');
			return;
		}
	}

	public function index()
	{  
        $this->testerSession();	 

        $region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();

        $data['region'] = $region;
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['utilisateur'];
        $data['title'] = 'SITENY | Liste utilisateur';

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_utilisateur');
		$this->load->view('layout/footer');
	}
	public function delegue()
	{  
        $this->testerSession();	   
        
        $region = $this->db->query("select * from faritany r ORDER BY r.LIBELLE_FARITANY")->result();

        $get['region'] = $region;

        $data['title'] = 'SITENY | Liste délégué';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_delegue', $get);
		$this->load->view('layout/footer');
	}
	public function observation()
	{  
        $this->testerSession();	   
        
        $region = $this->db->query("select * from faritany r ORDER BY r.LIBELLE_FARITANY")->result();

        $get['region'] = $region;

        $data['title'] = 'SITENY | Liste observation';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_observation', $get);
		$this->load->view('layout/footer');
	}

    public function chargeRegion()
	{

		$select = '<select   data-live-search= true id="region" title="region">';
							
		$select .= "<option value=''></option>";
        $data = $this->db->query("select * from region where CODE_FARITANY = '".$_POST["id"]."' ")->result();
        foreach ($data as $key) {
            $select .= "<option value='".$key->CODE_REGION."'>".$key->LIBELLE_REGION."</option>";
	   }
										  
		$select .= "</select>";

		
		echo $select;
	}
    public function chargeRegion5()
	{

		$select = '<select   data-live-search= true id="region" title="region">';
							
		$select .= "<option value=''></option>";
        $data = $this->db->query("select * from region where CODE_FARITANY = '".$_POST["id"]."' ")->result();
        foreach ($data as $key) {
            $select .= "<option value='".$key->CODE_REGION."'>".$key->LIBELLE_REGION."</option>";
	   }
										  
		$select .= "</select>";

		
		echo $select;
	}

    public function chargeDistrict()
	{
							
	   
	   $data = $this->db->query("select * from district where CODE_REGION = ".$_POST["id"]." ")->result();
	   $select = "<option value=''></option>";
	   foreach ($data as $key) {
		   $select .= "<option value='".$key->CODE_DISTRICT."'>".$key->LIBELLE_DISTRICT."</option>";
		}						

		echo ($select);
	}

    public function chargeDistrict5()
	{
		//var_dump($_POST["id"]);
	   $select = '<select   data-live-search= true id="district" title="District">';
							
	   
	   $data = $this->db->query("select * from district where CODE_DISTRICT = ".$_SESSION["idDistrict"]." ")->result();
	   $select .= "<option value=''></option>";
	   foreach ($data as $key) {
		$select .= "<option value='".$key->CODE_DISTRICT."'>".$key->LIBELLE_DISTRICT."</option>";
	   }
										  
		$select .= "</select>";

		echo $select;
	}

	public function listerUtilisateur()
	{
        $draw = intval($this->input->get("draw"));
		$datauser = $this->login_model->getListeUser();		
        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','',''
					   ];
		}
		else
		{
			foreach ($datauser as $value)
			{
				$region = explode('_', $value['id_region']);
				$libs = '';

				// if (count($region) > 1) {
				// 	$count = 0;
				// 	foreach ($region as $key => $val) {
				// 		$getLib = $this->db->query("SELECT * FROM region WHERE CODE_REGION = " . $val)->row();
				// 		$lib = $getLib->LIBELLE_REGION;
				// 		$libs .= $lib;
						
				// 		if ($count < count($region) - 1) {
				// 			$libs .= ', ';  // Ajoute une virgule sauf à la dernière itération
				// 		}
						
				// 		$count++;
				// 	}
				// } else {
				// 	// S'il n'y a qu'une seule région, assignez simplement le libellé à $libs
				// 	$getLib = $this->db->query("SELECT * FROM region WHERE CODE_REGION = " . $region[0])->row();
				// 	$libs = $getLib->LIBELLE_REGION;
				// }

				$data[]  = [
								$value['pseudo'],
								$value['email'],
								// $libs
						   ];
			}
		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data
              	  ];
		echo json_encode($result);
		
	}


	public function listerDeleger()
	{
		$fr = $this->input->post("fr");
		$rg = $this->input->post("rg");
		$ds = $this->input->post("ds");
	

		if ($fr == "tous" && $rg == "tous" && $ds == "tous") {

			if ($_SESSION['type'] == 'Administrateur') {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->login_model->getListeDelegue();	
				
			}else {
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where rg in (  " . implode(",",$_SESSION['tabRegion'] ) . " ) limit 10")->result_array();	
			}

		} 
		else if ($fr == "tous" && $rg != "tous" && $ds == "tous") {

				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where rg = $rg")->result_array();		
		
		}

		else if ($fr == "tous" && $rg != "tous" && $ds != "tous") {

				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where rg = $rg and ds = $ds")->result_array();		
		
		}
		else if ($fr != "tous" && $rg == "tous" && $ds == "tous") {

				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr ")->result_array();	

		} 
		else if ($fr != "tous" && $rg != "tous" && $ds == "tous") {

				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr and  rg = $rg ")->result_array();		
		
		}

		else if ($fr != "tous" && $rg != "tous" && $ds != "tous") {
			
				$draw = intval($this->input->get("draw"));
				$datauser = $this->db->query("select * from delegue where fr = $fr and  rg = $rg and ds = $ds ")->result_array();		
		
		}
		

        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','','','','','','','','','','',''
					   ];
		}
		else
		{
			foreach ($datauser as $value)
			{
				if ($value['bv']<>$value['bv_ac']) {
					$etat = '<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #0040ff; font-size: 15px;"></i>';
				} 
				else {
					if ($value['type'] == 1) {
						$etat = '<i class="fa fa-check-circle" aria-hidden="true" style="color: #2cc71b; font-size: 15px;"></i>';
					}else {
						$etat = '<i class="fa fa-times-circle" aria-hidden="true" style="color: #ff2b13; font-size: 15px;"></i>';
					}
				}

				$datas = $this->db->query("SELECT b.LIBELLE_BV ,  v.LIBELLE_CV , co.LIBELLE_COMMUNE , fk.LIBELLE_FOKONTANY , ds.CODE_DISTRICT , fr.CODE_FARITANY  FROM  bv b , cv v , fokontany fk 
										, commune co , district ds , region r ,  faritany fr
										WHERE b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE 
										AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND fr.CODE_FARITANY = r.CODE_FARITANY
										AND r.CODE_REGION= ds.CODE_REGION AND b.CODE_BV = ".$value['bv_ac']." GROUP BY b.CODE_BV")->row();
				
				/*$datasds["bv"] = $datas->CODE_BV;
					$datasds["ds"] = $datas->CODE_DISTRICT;
					$datasds["cm"] = $datas->CODE_COMMUNE;
					$datasds["cv"] = $datas->CODE_CV;
					$datasds["fk"] = $datas->CODE_FOKONTANY;*/

				
				
				$bv = $this->db->query("select * from bv where code_bv = ".$value['bv']." ")->row();
	
				if ($datas == NULL  ) {
					$data = array();
				}else {
					$data[]  = [
						$value['date_check'],
						$value['cin'],
						$value['nom'],
						$value['contact'],
						$etat,
									$datas->LIBELLE_COMMUNE,
									$datas->LIBELLE_FOKONTANY,
									$datas->LIBELLE_CV,
									$datas->LIBELLE_BV,
									$bv->LIBELLE_BV,
									$value['des'],
									$value['par']
							   ];					
				}

			}
		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data
              	  ];
		echo json_encode($result);
		
    }
	public function listerAnomalie()
	{
        $draw = intval($this->input->get("draw"));
		$datauser = $this->login_model->getListeAnomalie();		
        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','','','','','','',''
					   ];
		}
		else
		{
			foreach ($datauser as $value)
			{
				$btn = "<button title='Voir solution' onclick='valideAno(".$value['id'].")' class='btn btn-info btn-sm' style='padding: 0px;width: 20px;height: 20px'>
							<i class='fa fa-info' style='color:white'></i>
						</button>";
				if ($value['type'] == 6) {
					$raison = '<i class="fa fa-check-circle" aria-hidden="true" style="color: #2cc71b; font-size: 10px;"></i> Résolu';
					$btn = "<button title='Voir solution' onclick='voirAno(".$value['id'].")' class='btn btn-danger btn-sm' style='padding: 0px;width: 20px;height: 20px'>
							<i class='fa fa-info' style='color:white'></i>
						</button>";
				}else {
					$raison = '<i class="fa fa-times-circle" aria-hidden="true" style="color: #ff2b13; font-size: 10px;"></i> Non résolu ';
				}
				if ($value['type'] == 3) {
					$etat = '<i class="fa fa-circle" aria-hidden="true" style="color: #000aff; font-size: 10px;"></i>' ;
				}
				else if ($value['type'] == 2) {
					$etat = '<i class="fa fa-circle" aria-hidden="true" style="color: #ff9914; font-size: 10px;"></i>';
				} 
				else if ($value['type'] == 4) {
					$etat = '<i class="fa fa-circle" aria-hidden="true" style="color: #f70505; font-size: 10px;"></i>';
				} 
				else {
					$etat = '<i class="fa fa-circle" aria-hidden="true" style="color: #31bc31; font-size: 10px;"></i>';
				} 
				$bv = $this->db->query("select * from bv where code_bv = ".$value['bv']." ")->row();
				$rg = $this->db->query("SELECT libelle_region , libelle_district , libelle_bv , code_bv 
				FROM cv , bv , fokontany fk , district ds , region r , commune cm  
				WHERE cv.CODE_CV = bv.CODE_CV AND fk.CODE_FOKONTANY = cv.CODE_FOKONTANY AND fk.CODE_COMMUNE = cm.CODE_COMMUNE 
				AND cm.CODE_DISTRICT = ds.CODE_DISTRICT AND ds.CODE_REGION = r.CODE_REGION and bv.CODE_BV = ".$value['bv']."  ")->row();


				$data[]  = [
						$rg->libelle_region,		
						$rg->libelle_district,		
						$bv->LIBELLE_BV,		
						$value['nom'],
						$value['prenom'],
						$value['cin'],
						$value['contact'],
						$value['date'],
						$etat,
						$raison,
						$btn					
					];
			}
		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data
              	  ];
		echo json_encode($result);
		
	}

    public function getInfo()
	{
		$id = $this->input->post('id'); 

		$datauser = $this->login_model->getInfo($id);	

		echo json_encode($datauser);
	}

    public function insertRaison()
	{
		$id = $this->input->post('id'); 

		$raison = $this->input->post('raison'); 

		$data = array(
			    	'type'=> 6,
			    	'raison'=> $raison
			    );
		$sql = " UPDATE baseimport SET type = 6, raison = '".$raison."'  WHERE  id=".$id."";

		$this->db->query($sql);

		echo json_encode(array('status' => 'OK', 'message' => " OK !!"));
	}

    public function ajouterClientZoom()
	{

		$nom = $this->input->post('nom-user');   
		
		$pseudo = explode('_', $_SESSION['idRegion']);
		
		$selectedRegions = $this->input->post('region-user');
		$selectedRegionsString = implode('_', $selectedRegions);

		$dataClient = [
                            'pseudo'=> 'r'.$pseudo[0],
							'nom' => $this->input->post('nom-user'),
							'prenom' => $this->input->post('prenom-user'),
							'cin' => $this->input->post('cin-user'),
							'adresse' => $this->input->post('adresse-user'),
							'telephone' => $this->input->post('tel-user'),
							'email' => $this->input->post('email-user'),
							'motdepasse' => $this->input->post('pwd-user'),
							'type' => $this->input->post('type-user'),
							'id_region' => $selectedRegionsString
					  ];
		$this->login_model->insertUser($dataClient);
		echo json_encode(array('status' => 'OK', 'message' => "L'insertion a été effectuée avec succès !!"));
	}
    public function chartDelege()
	{
		$this->testerSession();	  
		$idr = $_SESSION['idRegion'];
		$user = $_SESSION['type'];
		$idDistrict = $_SESSION['idDistrict'];
		
		if ($idDistrict == 0) {			
			if ($user == 'Administrateur') {
				$region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();
			}else {
				$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
			}	
			$data['region'] = $region;
			$data['title'] = 'SITENY | Statistique délégué';
			$data['type'] = $_SESSION['type'];
			$data['prenom'] = $_SESSION['prenom'];
	
			$this->load->view('layout/header', $data);
			$this->load->view('utilisateurs/chartDelege', $data);
			$this->load->view('layout/footer');
		}else {
			$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
			//var_dump($_SESSION['type']);die;
			$district = $this->db->query("select LIBELLE_DISTRICT, CODE_DISTRICT from district  where CODE_DISTRICT = ".$idDistrict."")->result();
			$district = $this->db->query("select LIBELLE_DISTRICT, CODE_DISTRICT from district  where CODE_DISTRICT = ".$idDistrict."")->result();
			$data['district'] = $district;
			$data['region'] = $region;
			$data['title'] = 'SITENY | Statistique délégué';
			$data['type'] = $_SESSION['type'];
			$data['prenom'] = $_SESSION['prenom'];
	
			$this->load->view('layout/header', $data);
			$this->load->view('utilisateurs/district', $data);
			$this->load->view('layout/footer');
		}

	}

    public function chartDelege2()
	{
		$this->testerSession();	  
		$idr = $_SESSION['idRegion'];
		$user = $_SESSION['type'];
		if ($user == 'Administrateur') {
			$region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();
		}else {
			$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
		}	

        $data['region'] = $region;

        $data['title'] = 'SITENY | Statistique délégué';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/chartDelege2', $data);
		$this->load->view('layout/footer');
	}

	public function chartDelegue3()
	{
		$this->testerSession();	  
		$idr = $_SESSION['idRegion'];
		$user = $_SESSION['type'];
		if ($user == 'Administrateur') {
			$region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();
		}else {
			$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
		}	

        $data['region'] = $region;

        $data['title'] = 'SITENY | Statistique délégué';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/chartDelege3', $data);
		$this->load->view('layout/footer');
	}

	public function chart_data() {		
		if ($user == 'Administrateur') {			
			$sql = ("SELECT COUNT(b.CODE_BV)  nbr , r.LIBELLE_REGION  FROM bv b , cv v , fokontany fk
			, commune co , district ds , region r
			WHERE  b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT
			AND r.CODE_REGION= ds.CODE_REGION GROUP BY r.CODE_REGION");
		}else {
			$sql = ("SELECT COUNT(b.CODE_BV)  nbr , r.LIBELLE_REGION  FROM bv b , cv v , fokontany fk
			, commune co , district ds , region r
			WHERE  b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT
			AND r.CODE_REGION=  GROUP BY r.CODE_REGION");
		}
		$dataGlobal = $this->db->query($sql)->result();

		echo json_encode($dataGlobal);
	}

	public function getStatReg() {		
		$table = 'r'.$_POST['id'];	
		
		$dataTache = $this->db->query("SELECT Count(bv_ac) AS fr  FROM delegue f WHERE f.rg = ".$_POST['id']." GROUP BY bv_ac  HAVING COUNT(f.bv_ac) >= 1")->num_rows();
		
		$region = $this->db->query("select * from region where CODE_REGION= ". $_POST['id']." ORDER BY LIBELLE_REGION")->row();
		$data[] = array(
			'nbr' => $dataTache,
			'LIBELLE_REGION' => $region->LIBELLE_REGION
		);			
		$sql = "SELECT COUNT(b.CODE_BV)  nbr FROM bv b , cv v , fokontany fk , commune co , district ds , region r  WHERE  b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT
		AND r.CODE_REGION= ds.CODE_REGION AND r.CODE_REGION = ".$_POST['id']."  GROUP BY r.CODE_REGION";
		$dataReg = $this->db->query($sql)->row();
		$reste = (intval($dataReg->nbr)) - intval($dataTache);
		$data[] = array(
			'nbr' => $reste,
			'LIBELLE_REGION' => 'Reste'
		);
		$stat = array(
			'bv' => (intval($dataReg->nbr)),
			'tache' => intval($dataTache),
			'reste' => intval($reste)
		);

		echo json_encode(array( 'stat' => $stat, 'data' => $data));
		
	}

	public function getStatRecap() {		
		
		$dataTache = $this->db->query("SELECT Count(bv_ac) AS fr  FROM delegue f GROUP BY bv_ac  HAVING COUNT(f.bv_ac) >= 1")->num_rows();
		
		$data[] = array(
			'nbr' => intval($dataTache),
			'LIBELLE_REGION' => 'Tache'
		);			
		$sql = ("SELECT COUNT(CODE_BV) AS nbr FROM bv");
		$dataReg = $this->db->query($sql)->row();
		$reste = (intval($dataReg->nbr)) - intval($dataTache);
		$data[] = array(
			'nbr' => $reste,
			'LIBELLE_REGION' => 'Total'
		);
		$stat = array(
			'bv' => (intval($dataReg->nbr)),
			'tache' => intval($dataTache),
			'reste' => intval($reste)
		);

		echo json_encode(array( 'stat' => $stat, 'data' => $data));
		
	}

	// public function getStatRecap() {		
	// 	$dataTache = $this->login_model->getLisTacheRecap();

	// 	// $region = $this->db->query("select * from region where CODE_REGION= ". $_POST['id']." ORDER BY LIBELLE_REGION")->row();
	// 	$data[] = array(
	// 		'nbr' => intval($dataTache->tache),
	// 		'LIBELLE_REGION' => 'Tache'
	// 	);			
	// 	$sql = ("SELECT COUNT(b.CODE_BV)  nbr , r.LIBELLE_REGION  FROM  bv b , cv v , fokontany fk
	// 	, commune co , district ds , region r
	// 	WHERE  b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT AND r.CODE_REGION = ds.CODE_REGION
	// 	GROUP BY r.CODE_REGION");
	// 	$dataReg = $this->db->query($sql)->row();
	// 	$reste = intval($dataReg->nbr) - intval($dataTache->tache);
	// 	$data[] = array(
	// 		'nbr' => $reste,
	// 		'LIBELLE_REGION' => 'Total'
	// 	);
	// 	$stat = array(
	// 		'bv' => intval($dataReg->nbr),
	// 		'tache' => intval($dataTache->tache),
	// 		'reste' => intval($reste)
	// 	);

	// 	echo json_encode(array( 'stat' => $stat, 'data' => $data));
		
	// }

	public function listerDistrict()
	{
			
		$draw = intval($this->input->get("draw"));

		$datauser = $this->db->query("select * from delegue where rg = ".$_SESSION['idRegion']." and ds = ".$_SESSION['idDistrict']." ")->result_array();
		
		

        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','','','','','','','','','',''
					   ];
		}
		else
		{
			foreach ($datauser as $value)
			{
				if ($value['bv_ac'] <>  $value['bv_ac']) {
					$etat = '<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #0040ff; font-size: 15px;"></i>';
				} 
				if ($value['bv']<>$value['bv_ac']) {
					$etat = '<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #0040ff; font-size: 15px;"></i>';
				} 
				else {
					if ($value['type'] == 1) {
						$etat = '<i class="fa fa-check-circle" aria-hidden="true" style="color: #2cc71b; font-size: 15px;"></i>';
					}else {
						$etat = '<i class="fa fa-times-circle" aria-hidden="true" style="color: #ff2b13; font-size: 15px;"></i>';
					}
				}
				
				$fkt = $this->db->query("select * from fokontany where code_fokontany = ".$value['fk']." ")->row();
				$com = $this->db->query("select * from commune where code_commune = ".$value['cm']." ")->row();
				$cv = $this->db->query("select * from cv where code_cv = ".$value['cv']." ")->row();
				$bv = $this->db->query("select * from bv where code_bv = ".$value['bv']." ")->row();
				$bv_ac = $this->db->query("select * from bv where code_bv = ".$value['bv_ac']." ")->row();

				// if ($fkt == NULL || $com == NULL || $cv == NULL || $bv == NULL || $bv_ac == NULL  ) {
				// 	$data = array();
				// }else {
					if ($value['etat'] == 0) {
						$btn = "<button title='Voir solution' onclick='valideAno(".$value['id'].")' class='btn btn-primary btn-sm' style='color:green; color:white'>
									<i class='fa fa-check-square' style='color:white; font: size 15px;'></i> Valider
									</button>";
						$etat = 'Non validé';
					}
					else {
						$btn = '';
						$etat = 'Validé';
					}
								$data[]  = [
									$value['id'],
									$btn,
									$etat,
									$value['contact'],
									$value['nom'],
									$bv_ac->LIBELLE_BV,
									$com->LIBELLE_COMMUNE,
									$fkt->LIBELLE_FOKONTANY,
									$cv->LIBELLE_CV,
									$value['cin'],
							   ];					
				}

			}
		

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data
              	  ];
		echo json_encode($result);
		
	}

	public function updateEtat()
	{
		$id = $this->input->post('id'); 
		$nom = $this->input->post('nom'); 
		$contact = $this->input->post('contact'); 

		$sql = " UPDATE delegue SET etat = 1, nomRes = '".$nom."', contRes = '".$contact."' WHERE  id=".$id."";

		$this->db->query($sql);

		echo json_encode(array('status' => 'OK', 'message' => " OK !!"));
	}

	
	public function genererIdDistrict()
	{
		$dt = $this->db->query('select * from district ')->result();

		$count = 1;
		foreach ($dt as $key => $value) {
			$data = array(				
				'pseudo' => 'd'.$count ,
				'motdepasse' => '142536' ,
				'id_district' => $value->CODE_DISTRICT ,
				'id_region' => $value->CODE_REGION ,
				'type' => 'Personnel' 
			);
			$test = $this->db->insert('utilisateur', $data);
			$test = $this->db->affected_rows();
			var_dump($test);
			$count++;
		}
	}

	public function chargeDistrict2()
	{
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

	// public function getStatReg() {		
	// 	$table = 'r'.$_POST['id'];	
		
	// 	$dataTache = $this->db->query("SELECT Count(bv_ac) AS fr  FROM delegue f WHERE f.rg = ".$_POST['id']." GROUP BY bv_ac  HAVING COUNT(f.bv_ac) >= 1")->num_rows();
		
	// 	$region = $this->db->query("select * from region where CODE_REGION= ". $_POST['id']." ORDER BY LIBELLE_REGION")->row();
	// 	$data[] = array(
	// 		'nbr' => $dataTache,
	// 		'LIBELLE_REGION' => $region->LIBELLE_REGION
	// 	);			
	// 	$sql = "SELECT COUNT(b.CODE_BV)  nbr FROM bv b , cv v , fokontany fk , commune co , district ds , region r  WHERE  b.CODE_CV = v.CODE_CV AND v.CODE_FOKONTANY = fk.CODE_FOKONTANY AND co.CODE_COMMUNE = fk.CODE_COMMUNE AND ds.CODE_DISTRICT = co.CODE_DISTRICT
	// 	AND r.CODE_REGION= ds.CODE_REGION AND r.CODE_REGION = ".$_POST['id']."  GROUP BY r.CODE_REGION";
	// 	$dataReg = $this->db->query($sql)->row();
	// 	$reste = (intval($dataReg->nbr)) - intval($dataTache);
	// 	$data[] = array(
	// 		'nbr' => $reste,
	// 		'LIBELLE_REGION' => 'Reste'
	// 	);
	// 	$stat = array(
	// 		'bv' => (intval($dataReg->nbr)),
	// 		'tache' => intval($dataTache),
	// 		'reste' => intval($reste)
	// 	);

	// 	echo json_encode(array( 'stat' => $stat, 'data' => $data));
		
	// }

	public function getStatDis() {	
		
		$dataTache = $this->db->query("SELECT r.LIBELLE_REGION,LIBELLE_DISTRICT, COUNT( DISTINCT bv_ac) vita , (SELECT COUNT( DISTINCT b1.CODE_BV) FROM bv b1, cv v1 , fokontany fk1 , commune cm  
										WHERE b1.CODE_CV = v1.CODE_CV and v1.CODE_FOKONTANY = fk1.CODE_FOKONTANY 
										AND fk1.CODE_COMMUNE = cm.CODE_COMMUNE AND cm.CODE_DISTRICT = ds.CODE_DISTRICT
										GROUP BY cm.CODE_DISTRICT ) tous FROM delegue , bv , region r , district ds WHERE bv.CODE_BV = delegue.bv and
										ds.CODE_DISTRICT = delegue.ds AND r.CODE_REGION = delegue.rg AND ds.CODE_DISTRICT = ".$_POST['id']."  group BY ds")->row();


		$data[] = array(
			'nbr' => intval($dataTache->vita),
			'LIBELLE_REGION' => $dataTache->LIBELLE_DISTRICT
		);	

		$reste = ((($dataTache->tous))-($dataTache->vita));

		$data[] = array(
			'nbr' => $reste,
			'LIBELLE_REGION' => 'RESTE'
		);	

		$stat = array(
			'bv' => (intval($dataTache->tous)),
			'tache' => intval($dataTache->vita),
			'reste' => intval($reste)
		);

		echo json_encode(array( 'stat' => $stat, 'data' => $data));
		
	}

	public function pdfUtilisateur()
	{
		$name = "Test";
		$pdfFilePath = FCPATH . "uploads/pdf/".$name.".pdf";
		$this->load->library('M_pdf');    
		$tt = array();
		
		$data['info'] = $tt;
	
		// Charger la vue PDF
		$html = $this->load->view('fichierPDF/pdf', $data, true);
	
		// Définir l'en-tête lors de l'initialisation de mPDF
		$header = '<div style="background-color: yellow; color: black; font-weight : bold;width=100%; height=100%">PRO SITENY</div>';
		$this->m_pdf->pdf->SetHeader($header);
	
		// Ajouter une page avec l'orientation paysage (L pour Landscape)
		$this->m_pdf->pdf->AddPage('L'); 
	
		// Écrire le HTML dans le PDF
		$this->m_pdf->pdf->WriteHTML($html);
	
		// Enregistrer le PDF sur le serveur
		$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
	
		// Chemin du fichier PDF
		$file = "uploads/pdf/".$name.".pdf";
	
		echo json_encode(array("lien"=>$file,"status"=>"1"));
	}

	public function viewMandant()
	{
		$this->testerSession();	  
		$idr = $_SESSION['idRegion'];
		$user = $_SESSION['type'];
		if ($user == 'Administrateur') {
			$region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();
		}else {
			$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
		}	

        $data['region'] = $region;

        $data['title'] = 'SITENY | Statistique délégué';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/mandant', $data);
		$this->load->view('layout/footer');
	}

	public function viewMessage()
	{
		$this->testerSession();	  
		$idr = $_SESSION['idRegion'];
		$user = $_SESSION['type'];
		if ($user == 'Administrateur') {
			$region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();
		}else {
			$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
		}	

        $data['region'] = $region;

        $data['title'] = 'SITENY | BUREAU DE VOTE';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/message', $data);
		$this->load->view('layout/footer');
	}
	public function viewBureau()
	{
		$this->testerSession();	  
		$idr = $_SESSION['idRegion'];
		$user = $_SESSION['type'];
		if ($user == 'Administrateur') {
			$region = $this->db->query("select * from region r ORDER BY r.LIBELLE_REGION")->result();
		}else {
			$region = 	$this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $_SESSION['tabRegion']) . " ) group by r.CODE_REGION  ")->result();
		}	

        $data['region'] = $region;

        $data['title'] = 'SITENY | MESSAGES';
        $data['type'] = $_SESSION['type'];
        $data['prenom'] = $_SESSION['prenom'];

		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/bureau', $data);
		$this->load->view('layout/footer');
	}

	public function listerMessage()
	{
        $draw = intval($this->input->get("draw"));
		$count = 0;
		

		$datauser = $this->db->query("SELECT ba.contact, cm.LIBELLE_COMMUNE, ba.CODE_BV, ba.LIBELLE_BV
		FROM base_sms ba, cv c , fokontany fk , commune cm , district ds , region rg WHERE ba.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
		AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.etat = 1")->result();
        
		if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','','','','','','',''
					   ];
		}
		else
		{
			//$count = 1;
			foreach ($datauser as $value)
			{
				$data[]  = [	
						$value->contact,
						$value->LIBELLE_COMMUNE,
						$value->LIBELLE_BV,
						$value->CODE_BV,
					];
					$count++;
			}
		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data,
                    "count" => $count,
              	  ];
		echo json_encode($result);
		
	}

	public function listerMessageComptant()
	{
        $draw = intval($this->input->get("draw"));
		$count = 0;
		$datauser = $this->db->query("SELECT ba.contact, cm.LIBELLE_COMMUNE, ba.CODE_BV, ba.LIBELLE_BV
		FROM  base_sms ba, cv c , fokontany fk , commune cm , district ds , region rg WHERE ba.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
		AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.etat = 2")->result();
        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','','','','','','',''
					   ];
		}
		else
		{
			foreach ($datauser as $value)
			{
				$data[]  = [	
						$value->contact,
						$value->LIBELLE_COMMUNE,
						$value->LIBELLE_BV,
						$value->CODE_BV,
					];

					$count++;
			}
		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data,
                    "count" => $count,
              	  ];
		echo json_encode($result);
		
	}

	public function listerMessageNon()
	{
        $draw = intval($this->input->get("draw"));
		$count = 0;
		$datauser = $this->db->query("SELECT cm.LIBELLE_COMMUNE, ba.CODE_BV, ba.LIBELLE_BV
		FROM base_sms ba, cv c , fokontany fk , commune cm , district ds , region rg WHERE ba.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
		AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND etat = 0 GROUP BY ba.CODE_BV")->result();
        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','',''
					   ];
		}
		else
		{
			
			foreach ($datauser as $value)
			{
				$data[]  = [	
						$value->LIBELLE_COMMUNE,
						$value->CODE_BV,
						$value->LIBELLE_BV,
					];
					$count++;
			}

		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data,
                    "count" => $count,
              	  ];
		echo json_encode($result);
		
	}

	public function listerAno()
	{
        $draw = intval($this->input->get("draw"));
		$datauser = $this->db->query("SELECT a.id, a.contact, b.contentsms, a.anomalie FROM anomalie_sms a 
		JOIN basebrutesms b ON a.id_brute = b.id where a.etat = 0")->result();
        if(sizeof($datauser) == 0)
		{
			$data[]  = [
							'','','',''
					   ];
		}
		else
		{
			foreach ($datauser as $value)
			{
				$btn = "<button title='Voir solution' data-id='".$value->contentsms."' id=".$value->id."  class='btn btn-info btn-sm' style='padding: 0px;width: 20px;height: 20px'>
				<i class='fa fa-info' style='color:white'></i>
				</button>";
				$data[]  = [	
						$value->contact,
						$value->contentsms,
						$value->anomalie,
						$btn
					];
			}
		}

		$result = [
                    "draw" => $draw,
                    "recordsTotal" => "5",
                    "recordsFiltered" => "5",
                    "data" => $data
              	  ];
		echo json_encode($result);
		
	}

	
    public function updateAno()
	{
		$id = $this->input->post('id'); 

		$raison = $this->input->post('raison'); 

		$sql = " UPDATE anomalie_sms SET etat = 1  WHERE  id=".$id."";

		$this->db->query($sql);

		echo json_encode(array('status' => 'OK', 'message' => " OK !!"));
	}

	public function listerVote()
	{
		$id = $this->input->post('id'); 

		if ($id == 'tous' || $id == '') {
			$datauser = $this->db->query("SELECT * FROM base_sms_tur")->result();
		}else {
			$datauser = $this->db->query("SELECT * FROM base_sms_tur where CODE_BV = ".$id."")->result();
		}

		$draw = intval($this->input->get("draw"));
		$result = array();
		$count = 0;
		$somme = 0;
		$somme2 = 0;
		$somme3 = 0;
		$somme4 = 0;
		$somme5 = 0;
		$somme6 = 0;
		$somme7 = 0;
		$somme8 = 0;
		$somme9 = 0;
		$somme10 = 0;
		$somme11 = 0;
		$somme12 = 0;
		$somme13 = 0;
		if (!empty($datauser)) {
			foreach ($datauser as $value)
			{		
				$somme3 += 	$value->voix03;			
				$somme5 += 	$value->voix05;				
				$somme13 += $value->voix13;			
				$somme += $value->total;			
				$count ++;
			}
			$resultat = array(
				'sum3' => round((($somme3*100)/$somme), 2) . '%',
				'sum5' => round((($somme5*100)/$somme), 2) . '%',
				'sum13' => round((($somme13*100)/$somme), 2) . '%',
				'total13' => $somme13,
				'total3' => $somme3,
				'total5' => $somme5,
				'totalsum' => $somme,
				'count' => $count,
			);	
	
			
			$result = [
						"draw" => $draw,
						"resultat" => $resultat,
					];
	
			echo json_encode($result);
		}else {
			$resultat = array(
				'sum3' => 0 . '%',
				'sum5' => 0 . '%',
				'sum13' => 0 . '%',
				'total13' => $somme13,
				'total3' => $somme3,
				'total5' => $somme5,
				'totalsum' => $somme,
				'count' => $count,
			);	
			$result = [
				"draw" => $draw,
				"resultat" => $resultat,
			];

			echo json_encode($result);
		}

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

	public function chargeBVS()
	{
		$select = '';

		$data = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
		FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
		AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND 
		cm.CODE_COMMUNE = " . $_POST["id"] . "")->result();
		$i = 0;
		foreach ($data as $key) {
			$sel = ($i == 0) ? "selected" : "";
			$select .= "<option value='" . $key->CODE_BV . "' >" . $key->LIBELLE_BV . "</option>";
			$i++;
		}



		echo $select;
	}

	public function chargeBVS2()
	{
		$select = '';

		$data = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
		FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
		AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND 
		cm.CODE_COMMUNE = " . $_POST["id"] . "")->result();
		$i = 0;
		$select .= "<option value='tous' selected >tous</option>";
		foreach ($data as $key) {
			$select .= "<option value='" . $key->CODE_BV . "' >" . $key->LIBELLE_BV . "</option>";
			$i++;
		}



		echo $select;
	}

	public function resultat2()
	{
		$this->testerSession();
		$data['type'] = $_SESSION['type'];
		$data['prenom'] = $_SESSION['prenom'];
		$data['idRegion'] = $_SESSION['idRegion'];
		$data['tabRegion'] = $_SESSION['tabRegion'];
		$data['title'] = 'SITENY | RESULTAT';
		$regions = $this->db->query("select * from region")->result();
		if ($_SESSION['type'] == "Administrateur") {
			$faritra = $this->db->query("select * from faritany ")->result();
			$region = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
			FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg, base_sms_tur ba  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.CODE_BV = b.CODE_BV")->result();
		} else {
			$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
			$region = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
			FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg, base_sms_tur ba  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.CODE_BV = b.CODE_BV")->result();
		}

		//var_dump($region);die;
		$data['faritra'] = $faritra;
		$data['region'] = $region;
		$data['regions'] = $regions;
		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_resultat2', $data);
		$this->load->view('layout/footer');
	}

	public function resultat3()
	{
		$this->testerSession();
		$data['type'] = $_SESSION['type'];
		$data['prenom'] = $_SESSION['prenom'];
		$data['idRegion'] = $_SESSION['idRegion'];
		$data['tabRegion'] = $_SESSION['tabRegion'];
		$data['title'] = 'SITENY | RESULTAT';
		$regions = $this->db->query("select * from region")->result();
		if ($_SESSION['type'] == "Administrateur") {
			$faritra = $this->db->query("select * from faritany ")->result();
			$region = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
			FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg, base_resultat ba  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.CODE_BV = b.CODE_BV AND ba.etat = 3")->result();
		} else {
			$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
			$region = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
			FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg, base_resultat ba  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.CODE_BV = b.CODE_BV AND ba.etat = 3")->result();
		}

		//var_dump($region);die;
		$data['faritra'] = $faritra;
		$data['region'] = $region;
		$data['regions'] = $regions;
		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_resultat3', $data);
		$this->load->view('layout/footer');
	}

	public function resultat4()
	{
		$this->testerSession();
		$data['type'] = $_SESSION['type'];
		$data['prenom'] = $_SESSION['prenom'];
		$data['idRegion'] = $_SESSION['idRegion'];
		$data['tabRegion'] = $_SESSION['tabRegion'];
		$data['title'] = 'SITENY | RESULTAT GLOBAL';
		$regions = $this->db->query("select * from region")->result();
		if ($_SESSION['type'] == "Administrateur") {
			$faritra = $this->db->query("select * from faritany ")->result();
			$region = $this->db->query("SELECT rg.CODE_REGION, rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
			FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg, base_resultat ba  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.CODE_BV = b.CODE_BV group by rg.CODE_REGION")->result();
			
		} else {
			$faritra = $this->db->query("select r.CODE_REGION , r.LIBELLE_REGION , f.CODE_FARITANY , LIBELLE_FARITANY from faritany f  join region r on r.CODE_FARITANY = f.CODE_FARITANY WHERE r.CODE_REGION in (  " . implode(",", $data['tabRegion']) . " ) group by r.CODE_FARITANY ")->result();
			$region = $this->db->query("SELECT rg.LIBELLE_REGION , ds.LIBELLE_DISTRICT , cm.LIBELLE_COMMUNE, b.CODE_BV, b.LIBELLE_BV
			FROM bv b , cv c , fokontany fk , commune cm , district ds , region rg, base_sms_tur ba  WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND ba.CODE_BV = b.CODE_BV")->result();
		}

		//var_dump($region);die;
		$data['faritra'] = $faritra;
		$data['region'] = $region;
		$data['regions'] = $regions;
		$this->load->view('layout/header', $data);
		$this->load->view('utilisateurs/liste_resultat4', $data);
		$this->load->view('layout/footer');
	}

	public function cronSMS() {
		$data = $this->db->query("SELECT * FROM base_sms_tur WHERE etat = 0")->result();
		$this->maria = $this->load->database('maria_db', TRUE);
		
	
		foreach ($data as $key => $value) {
			// Vérifiez si le code_bv existe dans la table base_sms_mad
			$existingCodeBV = $this->maria->get_where('base_sms_mad', array('code_bv' => $value->CODE_BV))->row();
	
			if (!$existingCodeBV) {
				// Le code_bv n'existe pas, on peut insérer les données
				$dateMadagascar = new DateTime('now', new DateTimeZone('Indian/Antananarivo'));
				$dateFormatted = $dateMadagascar->format('Y-m-d H:i:s');
	
				$donnee = array(
					'code_bv' => $value->CODE_BV,
					'voix13' => $value->voix13,
					'voix03' => $value->voix03,
					'voix05' => $value->voix05,
					'PresentVote' => $value->total,
					'date' => $dateFormatted // Utilisez la date ajustée pour Madagascar
				);
	
				$this->maria->insert('base_sms_mad', $donnee);
	
				$sql = "UPDATE base_sms_tur SET etat = 1 WHERE CODE_BV=" . $value->CODE_BV;
				$this->db->query($sql);
			}
		}
	
		echo ('okok');
	}

	public function creerRepertoiresDepuisBD() {
		$Path = FCPATH . "uploads/";
	
		// Exécutez la requête SQL
		$query = $this->db->query("SELECT rg.CODE_REGION, rg.LIBELLE_REGION, ds.CODE_DISTRICT, ds.LIBELLE_DISTRICT, cm.CODE_COMMUNE, cm.LIBELLE_COMMUNE
			FROM bv b, cv c, fokontany fk, commune cm, district ds, region rg, base_sms_tur ba  
			WHERE b.CODE_CV = c.CODE_CV 
			AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE 
			AND ds.CODE_DISTRICT = cm.CODE_DISTRICT 
			AND rg.CODE_REGION = ds.CODE_REGION");
	
		$results = $query->result(); // Récupérez les résultats
	
		foreach ($results as $row) {
			$codeRegion = $row->CODE_REGION;
			$libelleRegion = $row->LIBELLE_REGION;
			$codeDistrict = $row->CODE_DISTRICT;
			$libelleDistrict = $row->LIBELLE_DISTRICT;
			$codeCommune = $row->CODE_COMMUNE;
			$libelleCommune = $row->LIBELLE_COMMUNE;
	
			// Nom du répertoire avec le code et le libellé (format : code-libelle)
			$regionDirectory = $Path . $codeRegion . '-' . strtolower(str_replace(' ', '-', $libelleRegion));
	
			// Création du répertoire pour la région
			if (!is_dir($regionDirectory)) {
				mkdir($regionDirectory, 0777, true);
			}
	
			// Nom du répertoire du district avec le code et le libellé
			$districtDirectory = $regionDirectory . '/' . $codeDistrict . '-' . strtolower(str_replace(' ', '-', $libelleDistrict));
	
			// Création du répertoire pour le district
			if (!is_dir($districtDirectory)) {
				mkdir($districtDirectory, 0777, true);
			}
	
			// Nom du répertoire de la commune avec le code et le libellé
			$communeDirectory = $districtDirectory . '/' . $codeCommune . '-' . strtolower(str_replace(' ', '-', $libelleCommune));
	
			// Création du répertoire pour la commune
			if (!is_dir($communeDirectory)) {
				mkdir($communeDirectory, 0777, true);
			}
		}
	}

	public function listerVoteGlo()
	{
		$rg = $this->input->post("region");
		$ds = $this->input->post("district");
		$cm = $this->input->post('commune'); 
		$bv = $this->input->post('bv'); 

		if ($rg == "tous" && $ds == "tous" && $cm == "tous" && $bv == "tous") {
			$datauser = $this->db->query("SELECT * FROM base_resultat where etat = 3")->result();
		}else if ( $rg <> "tous" && $ds == "tous" && $cm == "tous" && $bv == "tous") {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." and b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}else if ( $rg <> "tous" && $ds == "tous" && $cm <> "tous") {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." and b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}else if ($rg <> "tous" && $ds <> "tous" && $cm == "tous" && $bv == "tous") {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}
		else if ($rg <> "tous" && $ds <> "tous" && $cm == "") {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}
		else if ($rg <> "tous" && $ds <> "tous" && $cm == "" & $bv == "") {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}
		else if ($rg <> "tous" && $ds <> "tous" && $cm <> "tous" && $bv == "tous" ) {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND cm.CODE_COMMUNE = ".$cm." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
		// var_dump('ato');die;	
		}
		else if ($rg <> "tous" && $ds <> "tous" && $cm <> "tous" && $bv <> "tous") {
			$datauser = $this->db->query("SELECT b.*
			FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND cm.CODE_COMMUNE = ".$cm." AND b.CODE_BV = ".$bv." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}
			// else{
			// 	$datauser = $this->db->query("SELECT b.*
			// 	FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			// 	AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND cm.CODE_COMMUNE = ".$cm." AND b.CODE_CV = ".$bv." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
			// }
		


		$draw = intval($this->input->get("draw"));
		$result = array();
		$count = 0;
		$somme = 0;
		$somme1 = 0;
		$somme2 = 0;
		$somme3 = 0;
		$somme4 = 0;
		$somme5 = 0;
		$somme6 = 0;
		$somme7 = 0;
		$somme8 = 0;
		$somme9 = 0;
		$somme10 = 0;
		$somme11 = 0;
		$somme12 = 0;
		$somme13 = 0;
		$blancNul = 0;
		if (!empty($datauser)) {
			foreach ($datauser as $value)
			{		
				$somme1 += 	$value->voix01;			
				$somme2 += 	$value->voix02;			
				$somme3 += 	$value->voix03;			
				$somme4 += 	$value->voix04;			
				$somme5 += 	$value->voix05;				
				$somme6 += 	$value->voix06;				
				$somme7 += 	$value->voix07;				
				$somme8 += 	$value->voix08;				
				$somme9 += 	$value->voix09;				
				$somme10 += 	$value->voix10;				
				$somme11 += 	$value->voix11;				
				$somme12 += 	$value->voix12;				
				$somme13 += $value->voix13;			
				$somme += $value->total;			
				$blancNul += $value->fotsy;			
				$blancNul += $value->maty;			
				$count ++;
			}
			if ($somme != 0) {
				$resultat = array(
					'sum1' => round((($somme1*100)/$somme), 2) . '%',
					'sum2' => round((($somme2*100)/$somme), 2) . '%',
					'sum3' => round((($somme3*100)/$somme), 2) . '%',
					'sum4' => round((($somme4*100)/$somme), 2) . '%',
					'sum5' => round((($somme5*100)/$somme), 2) . '%',
					'sum6' => round((($somme6*100)/$somme), 2) . '%',
					'sum7' => round((($somme7*100)/$somme), 2) . '%',
					'sum8' => round((($somme8*100)/$somme), 2) . '%',
					'sum9' => round((($somme9*100)/$somme), 2) . '%',
					'sum10' => round((($somme10*100)/$somme), 2) . '%',
					'sum11' => round((($somme11*100)/$somme), 2) . '%',
					'sum12' => round((($somme12*100)/$somme), 2) . '%',
					'sum13' => round((($somme13*100)/$somme), 2) . '%',
					'total1' => $somme1,
					'total2' => $somme2,
					'total3' => $somme3,
					'total4' => $somme4,
					'total5' => $somme5,
					'total6' => $somme6,
					'total7' => $somme7,
					'total8' => $somme8,
					'total9' => $somme9,
					'total10' => $somme10,
					'total11' => $somme11,
					'total12' => $somme12,
					'total13' => $somme13,
					'totalsum' => $somme,
					'blanc' => $blancNul,
					'count' => $count,
				);	
			}else {

				$resultat = array(
					'sum1' => '0%',
					'sum2' => '0%',
					'sum3' => '0%',
					'sum4' => '0%',
					'sum5' => '0%',
					'sum6' => '0%',
					'sum7' => '0%',
					'sum8' => '0%',
					'sum9' => '0%',
					'sum10' => '0%',
					'sum11' => '0%',
					'sum12' => '0%',
					'sum13' => '0%',
					'total1' => $somme1,
					'total2' => $somme2,
					'total3' => $somme3,
					'total4' => $somme4,
					'total5' => $somme5,
					'total6' => $somme6,
					'total7' => $somme7,
					'total8' => $somme8,
					'total9' => $somme9,
					'total10' => $somme10,
					'total11' => $somme11,
					'total12' => $somme12,
					'total13' => $somme13,
					'totalsum' => $somme,
					'blanc' => $blancNul,
					'count' => $count,
				);	
			}
		
			
			$result = [
						"draw" => $draw,
						"resultat" => $resultat,
					];
	
			echo json_encode($result);
		}else {
			$resultat = array(
				'sum1' => '0%',
				'sum2' => '0%',
				'sum3' => '0%',
				'sum4' => '0%',
				'sum5' => '0%',
				'sum6' => '0%',
				'sum7' => '0%',
				'sum8' => '0%',
				'sum9' => '0%',
				'sum10' => '0%',
				'sum11' => '0%',
				'sum12' => '0%',
				'sum13' => '0%',
				'total1' => $somme1,
				'total2' => $somme2,
				'total3' => $somme3,
				'total4' => $somme4,
				'total5' => $somme5,
				'total6' => $somme6,
				'total7' => $somme7,
				'total8' => $somme8,
				'total9' => $somme9,
				'total10' => $somme10,
				'total11' => $somme11,
				'total12' => $somme12,
				'total13' => $somme13,
				'totalsum' => $somme,
				'blanc' => $blancNul,
				'count' => $count,
			);	
			$result = [
				"draw" => $draw,
				"resultat" => $resultat,
			];

			echo json_encode($result);
		}

	}

	public function listerVoteGlo1()
	{
		$rg = $this->input->post("region");
		$ds = $this->input->post("district");
		$cm = $this->input->post('commune'); 
		$bv = $this->input->post('bv'); 
		if ($bv <> "tous") {
			$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND b.CODE_BV = ".$bv." and b.etat = 3 GROUP BY b.CODE_BV ")->result();
		}else {
			if ($rg == "tous" && $ds == "tous" && $cm == "tous" && $bv == "tous") {
				$datauser = $this->db->query("SELECT * FROM base_resultat where etat = 3")->result();
			}else if ( $rg <> "tous" && $ds == "tous" && $cm == "tous" && $bv == "tous") {
				$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." and b.etat = 3 GROUP BY b.CODE_BV ")->result();
			}else if ( $rg <> "tous" && $ds == "tous" && $cm <> "tous") {
				$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." and b.etat = 3 GROUP BY b.CODE_BV ")->result();
			}else if ($rg <> "tous" && $ds <> "tous" && $cm == "tous" && $bv == "tous") {
				$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
			}
			else if ($rg <> "tous" && $ds <> "tous" && $cm == "") {
				$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
			}
			else if ($rg <> "tous" && $ds <> "tous" && $cm == "" & $bv == "") {
				$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
			}
			else if ($rg <> "tous" && $ds <> "tous" && $cm <> "tous") {
				$datauser = $this->db->query("SELECT b.*
				FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
				AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND cm.CODE_COMMUNE = ".$cm." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
			}
			// else{
			// 	$datauser = $this->db->query("SELECT b.*
			// 	FROM base_resultat b , cv c , fokontany fk , commune cm , district ds , region rg WHERE b.CODE_CV = c.CODE_CV AND c.CODE_FOKONTANY = fk.CODE_FOKONTANY
			// 	AND fk.CODE_COMMUNE = cm.CODE_COMMUNE AND ds.CODE_DISTRICT = cm.CODE_DISTRICT AND rg.CODE_REGION = ds.CODE_REGION AND rg.CODE_REGION = ".$rg." AND ds.CODE_DISTRICT = ".$ds." AND cm.CODE_COMMUNE = ".$cm." AND b.CODE_CV = ".$bv." AND b.etat = 3 GROUP BY b.CODE_BV ")->result();
			// }
		}


		$draw = intval($this->input->get("draw"));
		$result = array();
		$count = 0;
		$somme = 0;
		$somme1 = 0;
		$somme2 = 0;
		$somme3 = 0;
		$somme4 = 0;
		$somme5 = 0;
		$somme6 = 0;
		$somme7 = 0;
		$somme8 = 0;
		$somme9 = 0;
		$somme10 = 0;
		$somme11 = 0;
		$somme12 = 0;
		$somme13 = 0;
		$blancNul = 0;
		if (!empty($datauser)) {
			foreach ($datauser as $value)
			{		
				$somme1 += 	$value->voix01;			
				$somme2 += 	$value->voix02;			
				$somme3 += 	$value->voix03;			
				$somme4 += 	$value->voix04;			
				$somme5 += 	$value->voix05;				
				$somme6 += 	$value->voix06;				
				$somme7 += 	$value->voix07;				
				$somme8 += 	$value->voix08;				
				$somme9 += 	$value->voix09;				
				$somme10 += 	$value->voix10;				
				$somme11 += 	$value->voix11;				
				$somme12 += 	$value->voix12;				
				$somme13 += $value->voix13;			
				$somme += $value->total;			
				$blancNul += $value->fotsy;			
				$blancNul += $value->maty;			
				$count ++;
			}
			if ($somme != 0) {
				$resultat = array(
					'sum1' => round((($somme1*100)/$somme), 2) . '%',
					'sum2' => round((($somme2*100)/$somme), 2) . '%',
					'sum3' => round((($somme3*100)/$somme), 2) . '%',
					'sum4' => round((($somme4*100)/$somme), 2) . '%',
					'sum5' => round((($somme5*100)/$somme), 2) . '%',
					'sum6' => round((($somme6*100)/$somme), 2) . '%',
					'sum7' => round((($somme7*100)/$somme), 2) . '%',
					'sum8' => round((($somme8*100)/$somme), 2) . '%',
					'sum9' => round((($somme9*100)/$somme), 2) . '%',
					'sum10' => round((($somme10*100)/$somme), 2) . '%',
					'sum11' => round((($somme11*100)/$somme), 2) . '%',
					'sum12' => round((($somme12*100)/$somme), 2) . '%',
					'sum13' => round((($somme13*100)/$somme), 2) . '%',
					'total1' => $somme1,
					'total2' => $somme2,
					'total3' => $somme3,
					'total4' => $somme4,
					'total5' => $somme5,
					'total6' => $somme6,
					'total7' => $somme7,
					'total8' => $somme8,
					'total9' => $somme9,
					'total10' => $somme10,
					'total11' => $somme11,
					'total12' => $somme12,
					'total13' => $somme13,
					'totalsum' => $somme,
					'blanc' => $blancNul,
					'count' => $count,
				);	
			}else {

				$resultat = array(
					'sum1' => '0%',
					'sum2' => '0%',
					'sum3' => '0%',
					'sum4' => '0%',
					'sum5' => '0%',
					'sum6' => '0%',
					'sum7' => '0%',
					'sum8' => '0%',
					'sum9' => '0%',
					'sum10' => '0%',
					'sum11' => '0%',
					'sum12' => '0%',
					'sum13' => '0%',
					'total1' => $somme1,
					'total2' => $somme2,
					'total3' => $somme3,
					'total4' => $somme4,
					'total5' => $somme5,
					'total6' => $somme6,
					'total7' => $somme7,
					'total8' => $somme8,
					'total9' => $somme9,
					'total10' => $somme10,
					'total11' => $somme11,
					'total12' => $somme12,
					'total13' => $somme13,
					'totalsum' => $somme,
					'blanc' => $blancNul,
					'count' => $count,
				);	
			}
		
			
			$result = [
						"draw" => $draw,
						"resultat" => $resultat,
					];
	
			echo json_encode($result);
		}else {
			$resultat = array(
				'sum1' => '0%',
				'sum2' => '0%',
				'sum3' => '0%',
				'sum4' => '0%',
				'sum5' => '0%',
				'sum6' => '0%',
				'sum7' => '0%',
				'sum8' => '0%',
				'sum9' => '0%',
				'sum10' => '0%',
				'sum11' => '0%',
				'sum12' => '0%',
				'sum13' => '0%',
				'total1' => $somme1,
				'total2' => $somme2,
				'total3' => $somme3,
				'total4' => $somme4,
				'total5' => $somme5,
				'total6' => $somme6,
				'total7' => $somme7,
				'total8' => $somme8,
				'total9' => $somme9,
				'total10' => $somme10,
				'total11' => $somme11,
				'total12' => $somme12,
				'total13' => $somme13,
				'totalsum' => $somme,
				'blanc' => $blancNul,
				'count' => $count,
			);	
			$result = [
				"draw" => $draw,
				"resultat" => $resultat,
			];

			echo json_encode($result);
		}

	}
	
}

		
