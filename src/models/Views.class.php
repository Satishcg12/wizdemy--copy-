<?php

class Views extends Model
{
    public function __construct()
    {
        parent::__construct('views');
        $this->fillable = ['user_id', 'study_material_id','ip_address','device'];
    }

    public function getViewCount($study_material_id)
    {
        $result = $this->select(['COUNT(id) as view_count'])
            ->where('study_material_id', $study_material_id)
            ->first();
        return $result['view_count'];
    }
    public function setView($user_id, $study_material_id, $ip_address, $device)
    {
        $sql = "INSERT INTO views (user_id, study_material_id, ip_address, device) VALUES (:user_id, :study_material_id, :ip_address, :device)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id, ':study_material_id' => $study_material_id, ':ip_address' => $ip_address, ':device' => $device]);
        return $stmt->rowCount();
    }
}