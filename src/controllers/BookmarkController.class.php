<?php
class BookmarkController extends Controller
{
    public function __construct()
    {
        parent::__construct('Bookmarks');
    }
    public function bookmark()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->json(['status' => 'error', 'msg' => 'You need to login to bookmark']);
        }
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        $bookmark = new Bookmarks();

        $bookmark = $bookmark->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->first();
        if ($bookmark) {
            $bookmark = new Bookmarks();
            $bookmark->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->delete();
        } else {
            $bookmark = new Bookmarks();
            $bookmark->create([
                'user_id' => $_SESSION['user_id'],
                'study_material_id' => $id
            ]);
        }
        $this->json(['status' => 'success']);
    }
}