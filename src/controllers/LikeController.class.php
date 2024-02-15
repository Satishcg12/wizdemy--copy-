<?php
class LikeController extends Controller
{
    public function __construct()
    {
        parent::__construct('Likes');
    }
    public function like()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->json(['status' => 'error', 'msg' => 'You need to login to like']);
        }
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        $like = new Likes();

        $like = $like->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->first();
        if ($like) {
            $like = new Likes();
            $like->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->delete();
            $likecount = $like->where('study_material_id', $id)->count();
        } else {
            $like = new Likes();
            $like->create([
                'user_id' => $_SESSION['user_id'],
                'study_material_id' => $id
            ]);
            $likecount = $like->where('study_material_id', $id)->count();
        }
        $this->json(['status' => 'success', 'likeCount' => $likecount]);
    }
    public function like_delete()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->json(['status' => 'error', 'msg' => 'You need to login to like']);
        }
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        $like = new Likes();

        $like = $like->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->first();
        if ($like) {
            $like = new Likes();
            $like->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->delete();
            $likecount = $like->where('study_material_id', $id)->count();
        } else {
            $like = new Likes();
            $like->create([
                'user_id' => $_SESSION['user_id'],
                'study_material_id' => $id
            ]);
            $likecount = $like->where('study_material_id', $id)->count();
        }
        $this->json(['status' => 'success', 'likeCount' => $likecount]);
    }
}