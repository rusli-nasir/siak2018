<?php
/* 
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */
 
class Riwayat_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('rba',TRUE);
    }

    public function get_last_riwayat($level = null,$id_tahap = null,$status = null)
    {
        // $riwayat = $this->db->query("SELECT id_tahap,id_usulan FROM riwayat WHERE status = 2 OR status = 4 AND id_riwayat=(SELECT max('id_riwayat') FROM r iwayat WHERE id_usulan )")->result_array();
        $added_query = '';
        $added_query2 = '';
        if ($status != null){
            $added_query .= " AND riwayat.status = ".$status;
        } else {
            $added_query .= " AND (riwayat.status = 1 OR riwayat.status = 3) ";
        }
        if ($id_tahap != null){
            $added_query .= " AND riwayat.tahap = ".$id_tahap;
        }
        if ($level != null){
            $added_query2 = " AND tahap IN (SELECT id_tahap FROM tahap WHERE level = $level)";
        }
        $riwayat = $this->db->query("
            SELECT riwayat.*
            FROM riwayat
                INNER JOIN
                    (SELECT id_usulan, max(id_riwayat) AS last_riwayat
                     FROM riwayat
                     GROUP BY id_usulan) grouped_riwayat
                ON riwayat.id_usulan = grouped_riwayat.id_usulan
                AND riwayat.id_riwayat = grouped_riwayat.last_riwayat
            WHERE 1 $added_query $added_query2
        ")->result_array();
        return $riwayat;
    }


    
    /*
     * Get riwayat by id_riwayat
     */
    function get_riwayat($id_riwayat)
    {
        return $this->db->get_where('riwayat',array('id_riwayat'=>$id_riwayat))->row_array();
    }

    public function get_riwayat_usulan($id_usulan)
    {
        return $this->db->order_by('id_riwayat','DESC')->get_where('riwayat',array('id_usulan'=>$id_usulan))->row_array();   
    }

    
    /*
     * Get all riwayat
     */
    function get_all_riwayat()
    {
        return $this->db->get('riwayat')->result_array();
    }
    
    /*
     * function to add new riwayat
     */
    function add_riwayat($params)
    {
        $this->db->insert('akuntansi_riwayat',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update riwayat
     */
    function update_riwayat($id,$params)
    {
        $this->db->where('id',$id_riwayat);
        $response = $this->db->update('akuntansi_riwayat',$params);
        if($response)
        {
            return "riwayat updated successfully";
        }
        else
        {
            return "Error occuring while updating riwayat";
        }
    }
    
    /*
     * function to delete riwayat
     */
    function delete_riwayat($id_riwayat)
    {
        $response = $this->db->delete('riwayat',array('id_riwayat'=>$id_riwayat));
        if($response)
        {
            return "riwayat deleted successfully";
        }
        else
        {
            return "Error occuring while deleting riwayat";
        }
    }
}
