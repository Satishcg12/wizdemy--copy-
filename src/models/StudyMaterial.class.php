<?php
class StudyMaterial extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'study_materials';
        $this->fillable = ['title', 'description', 'file', 'user_id'];
    }
    
}