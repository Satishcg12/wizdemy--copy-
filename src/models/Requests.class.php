<?php
class Requests extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'study_material_requests';
        $this->fillable = ['title', 'description', 'user_id', 'education_level', 'semester', 'subject', 'class_faculty', 'document_type'];
    }
    // get all requests with user joint, arrange by latest
    public function allWithUser()
    {
        $stmt = $this->pdo->prepare('SELECT study_material_requests.*, users.username as user_name FROM study_material_requests JOIN users ON study_material_requests.user_id = users.id ORDER BY study_material_requests.created_at DESC');
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }
}