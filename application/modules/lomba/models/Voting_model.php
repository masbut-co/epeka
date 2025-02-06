<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Voting_model extends CI_Model{
    private $_table = "voting";

    public $id_voting;
    public $id_kegiatan;
    public $id_kategori;
    public $id_balai;
    public $nilai;
    public $saran;
    public $email;
    public $no_hp;

    public function getJumlahVoterBand($unit) {
        $vote = $this->db->query('SELECT count(id_voting) as jlh_vote FROM voting WHERE id_unit = '.$unit.'.'.'and id_lomba = 1'.'');
        return $vote;
    }

    public function getJumlahVoterFashion($unit) {
        $vote = $this->db->query('SELECT count(id_voting) as jlh_vote FROM voting WHERE id_unit = '.$unit.'.'.'and id_lomba = 2'.'');
        return $vote;
    }

    public function getJumlahVoterStandup($unit) {
        $vote = $this->db->query('SELECT count(id_voting) as jlh_vote FROM voting WHERE id_unit = '.$unit.'.'.'and id_lomba = 3'.'');
        return $vote;
    }

    public function getNilaiRatingPerBintangBand($unit, $kategori, $bintang) {
        $bintang = $this->db->query('SELECT count(id_voting) as jlh_bintang FROM voting WHERE id_unit = '.$unit.' '.'and id_lomba = 1'.' '.'and id_kategori = '.$kategori.' '.'and nilai = '.$bintang.'');
        return $bintang;
    }

    public function getNilaiRatingPerBintangFashion($unit, $kategori, $bintang) {
        $bintang = $this->db->query('SELECT count(id_voting) as jlh_bintang FROM voting WHERE id_unit = '.$unit.' '.'and id_lomba = 2'.' '.'and id_kategori = '.$kategori.' '.'and nilai = '.$bintang.'');
        return $bintang;
    }

    public function getNilaiRatingPerBintangStandup($unit, $kategori, $bintang) {
        $bintang = $this->db->query('SELECT count(id_voting) as jlh_bintang FROM voting WHERE id_unit = '.$unit.' '.'and id_lomba = 3'.' '.'and id_kategori = '.$kategori.' '.'and nilai = '.$bintang.'');
        return $bintang;
    }

    public function getUnitBandAktif() {
        $band = $this->db->query('SELECT u.nama_unit, lb.id_unit, lb.id_kategori, lb.status_aktif, lb.jlh_vote, lb.waktu_aktif FROM unit u, lomba_berjalan lb where lb.status_aktif=1 and lb.id_kategori=1 and u.id_unit=lb.id_unit');
        return $band;
    }

    public function getUnitFashionAktif() {
        $fashion = $this->db->query('SELECT u.nama_unit, lb.id_unit, lb.id_kategori, lb.status_aktif, lb.jlh_vote, lb.waktu_aktif FROM unit u, lomba_berjalan lb where lb.status_aktif=1 and lb.id_kategori=2 and u.id_unit=lb.id_unit');
        return $fashion;
    }

    public function getUnitStandupAktif() {
        $standup = $this->db->query('SELECT u.nama_unit, lb.id_unit, lb.id_kategori, lb.status_aktif, lb.jlh_vote, lb.waktu_aktif FROM unit u, lomba_berjalan lb where lb.status_aktif=1 and lb.id_kategori=3 and u.id_unit=lb.id_unit');
        return $standup;
    }

    //dipake---
    public function getBandKategori($id_kegiatan) {
        // Pastikan $id_kegiatan adalah integer
        $id_kegiatan = intval($id_kegiatan);  // Force to integer

        // query binding untuk mencegah SQL injection
        $kategori_band = $this->db->query('SELECT * FROM kategori_penilaian WHERE id_kegiatan = ? GROUP BY nama_kategori ORDER BY urutan ASC', array($id_kegiatan));

        return $kategori_band;
    }//-----------

    public function getFashionKategori() {
        //$kategori_fashion = $this->db->query('SELECT * FROM kategori_penilaian WHERE id_lomba = 2');
        $kategori_fashion = null;
        return $kategori_fashion;
    }

    public function getStandupKategori() {
        //$kategori_standup = $this->db->query('SELECT * FROM kategori_penilaian WHERE id_lomba = 3');
        $kategori_fashion = null;
        return $kategori_standup;
    }

    public function addVoting($id_kegiatan, $id_kategori, $nilai, $saran, $email, $no_hp, $id_balai, $usia, $pend, $gender) {
        // $this->id_kegiatan = $id_kegiatan;
        // $this->id_kategori = $id_kategori;
        // $this->id_balai = $id_balai;
        // $this->nilai = $nilai;
        // $this->saran = $saran;
        // $this->email = $email;
        // $this->gender =$gender;
        // $this->pend =$pend;
        // $this->usia = $usia;
        // $this->no_hp = $no_hp; 

        // $this->db->insert($this->_table, $this);

        // Sanitasi dan validasi input
        $id_kegiatan = intval($id_kegiatan);
        $id_kategori = intval($id_kategori);
        $id_balai = intval($id_balai);
        $nilai = intval($nilai);
        $saran = $this->db->escape_str($saran);
        $email = $this->db->escape_str($email);
        $no_hp = $this->db->escape_str($no_hp);
        $usia = intval($usia);
        $pend = $this->db->escape_str($pend);
        $gender = $this->db->escape_str($gender);

        $data = array(
            'id_kegiatan' => $id_kegiatan,
            'id_kategori' => $id_kategori,
            'id_balai' => $id_balai,
            'nilai' => $nilai,
            'saran' => $saran,
            'email' => $email,
            'no_hp' => $no_hp,
            'usia' => $usia,
            'pend' => $pend,
            'gender' => $gender
        );

        $this->db->insert($this->_table, $data);

        return $this->db->affected_rows();
    }

    public function addKeluhan($keluhan, $file_name, $email, $nohp, $id_balai) {
        // Sanitasi input
        $keluhan = $this->db->escape_str($keluhan);
        $file_name = $this->db->escape_str($file_name);
        $email = $this->db->escape_str($email);
        $nohp = $this->db->escape_str($nohp);
        $id_balai = intval($id_balai); // Force to integer

        // Gunakan query binding atau prepared statements untuk mencegah SQL Injection
        $sql = "INSERT INTO `keluhan` (`id_balai`, `keluhan`, `file_keluhan`, `email`, `nohp`) VALUES (?, ?, ?, ?, ?)";
        $this->db->query($sql, array($id_balai, $keluhan, $file_name, $email, $nohp));

        return $this->db->affected_rows();
    }

    public function ubahJlhPeserta() {
        $post = $this->input->post();
        $id_lomba = $post["id_lomba"];
        $id_unit = $post["id_unit"];
        $count_jlh_vote = $post["jlh_vote"] + 1;
        $this->db->set('jlh_vote',$count_jlh_vote);
        $this->db->where('id_unit', $id_unit); 
        $this->db->where('id_kategori', $id_lomba);
        $this->db->update('lomba_berjalan');
    }

    public function getKegiatan($id_balai) {
        $kegiatan = $this->db->query('SELECT * FROM nama_kgt WHERE id_balai = '.$id_balai.' AND status_aktif = 1 order by nama_kegiatan');
        return $kegiatan->result();
    }


    public function getKategori() {
        $kategori_kgt = $this->db->query('SELECT * FROM kategori_nilai');
        return $kategori_kgt;
    }

    public function addRating($id_kategori, $nilai) {
        $post = $this->input->post();
        $this->id_kegiatan = $post["id_kegiatan"];
        $this->id_kategori = $id_kategori;
        $this->nilai = $nilai;
        
        $this->db->insert($this->_table, $this);
    }
}