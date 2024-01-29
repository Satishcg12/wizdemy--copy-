<?php
class StudyMaterial extends Model
{
    protected $table = 'study_materials';
    protected $fillable = ['title', 'description', 'file', 'user_id'];
    public function __construct()
    {
        parent::__construct();
    }
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    
}