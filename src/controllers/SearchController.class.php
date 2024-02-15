<?php
class SearchController extends Controller
{
    public function __construct()
    {
        parent::__construct('SearchHistory');
    }
    public function index()
    {
        $search_query = $_GET['search_query'];
        $user_id = $_SESSION['user_id'];
        $this->model->create([
            'user_id' => $user_id,
            'search_query' => $search_query
        ]);
        $this->redirect('/search/results?search_query=' . $search_query);
    }
    // json response for search suggestions
    public function suggest()
    {
        $search_query = $_GET['search_query'];
        $studyMaterial = new StudyMaterial();
        $res = $studyMaterial->select(['title as search_query'])
            ->where('title','%' . $search_query . '%', 'like ' )
            ->limit(5)
            ->get();
            

        $suggestions = [];
        foreach ($res as $row) {
            $suggestions[] = $row['search_query'];
        }
        echo json_encode($suggestions);
    }

}