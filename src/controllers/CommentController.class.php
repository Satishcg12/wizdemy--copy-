<?php
class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct('Comments');
    }
    public function create()
    {

        $study_material_id = $_GET['id'];
        $comment = $_POST['comment'];
        $user_id = $_SESSION['user_id'];
        $validation = Validator::validate([
            'comment' => $comment
        ], [
            'comment' => ['required', 'min:1']
        ]);
        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $this->redirect('/studymaterial/show?id=' . $study_material_id);
        }
        $this->model->create([
            'user_id' => $user_id,
            'study_material_id' => $study_material_id,
            'comment' => $comment
        ]);
        $this->redirect('/studymaterial/show?id=' . $study_material_id);
        
    }
}
