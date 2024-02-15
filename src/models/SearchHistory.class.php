<?php
class SearchHistory extends Model
{
    public function __construct()
    {
        parent::__construct('search_history');
        $this->fillable = ['user_id', 'search_query'];
    }
    
}