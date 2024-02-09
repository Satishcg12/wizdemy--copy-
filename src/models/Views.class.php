<?php

class Views extends Model
{
    public function __construct()
    {
        parent::__construct('views');
        $this->fillable = ['user_id', 'study_material_id','ip_address','device'];
    }

    public function getViews()
    {
        $sql = "SELECT * FROM views";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}