<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function userLogin($pseudo,$mdp)
	{

		$this->db->from('utilisateur');
		$this->db->where('pseudo like binary',$pseudo);
		$this->db->where('motdepasse',$mdp);
	    $query = $this->db->get();
	    //print_r($query);die;
	    return $query->row();
	}
	public function getListeUser()
	{

		$this->db->select('*');
		$this->db->from('utilisateur r');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getListeDelegue()
	{
		$this->db->select('*');
		$this->db->from('delegue r')->limit(10);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getListeAnomalie()
	{
		$this->db->select('*');
		$this->db->from('baseimport');
		$this->db->where('etat', 1);
		$this->db->where('TYPE !=', 5);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getInfo($id)
	{
		$this->db->select('*');
		$this->db->from('baseimport');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getListeDelegueSpec($id)
	{
		$this->db->select('*');
		$this->db->from('delegue');
		$this->db->where('rg', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getListeObservation()
	{
		$this->db->select('*');
		$this->db->from('delegue r');
		$this->db->where('des !=', '');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getLisTache($id)
	{
		$this->db->select('COUNT(d.rg) AS tache, COUNT(b.CODE_BV) AS bv, d.rg');
		$this->db->from('delegue d');
		$this->db->join('bv b', 'b.CODE_BV = d.bv');
		$this->db->where('d.rg', $id);
		$query = $this->db->get();
		return $query->row();
	}
	public function getLisTacheRecap()
	{
		$this->db->select('COUNT(d.rg) AS tache, COUNT(b.CODE_BV) AS bv, d.rg');
		$this->db->from('delegue d');
		$this->db->join('bv b', 'b.CODE_BV = d.bv');
		$query = $this->db->get();
		return $query->row();
	}
	public function getListeBv()
	{
		$this->db->select('COUNT(e.CODE_BV) AS count_electeur, r.CODE_REGION, r.LIBELLE_REGION');
		$this->db->from('electeur e');
		$this->db->join('bv b', 'e.CODE_BV = b.CODE_BV', 'INNER');
		$this->db->join('cv v', 'b.CODE_CV = v.CODE_CV', 'INNER');
		$this->db->join('fokontany fk', 'v.CODE_FOKONTANY = fk.CODE_FOKONTANY', 'INNER');
		$this->db->join('commune co', 'fk.CODE_COMMUNE = co.CODE_COMMUNE', 'INNER');
		$this->db->join('district ds', 'co.CODE_DISTRICT = ds.CODE_DISTRICT', 'INNER');
		$this->db->join('region r', 'ds.CODE_REGION = r.CODE_REGION', 'INNER');
		$this->db->group_by('r.CODE_REGION');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function insertUser($data)
	{

		$this->db->insert("utilisateur", $data);
		return $this->db->insert_id();
	}
	

}