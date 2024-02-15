<?php
class Comments extends Model
{
    public function __construct()
    {
        parent::__construct('comments');
        $this->fillable = ['user_id', 'study_material_id', 'comment'];
    }
    public function getComments($study_material_id)
    {
        $sql = "SELECT comments.id, comments.user_id, comments.comment, comments.created_at, users.name, users.profile_pic FROM comments JOIN users ON comments.user_id = users.id WHERE comments.study_material_id = :study_material_id ORDER BY comments.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':study_material_id' => $study_material_id]);
        return $stmt->fetchAll();
    }
    public function createComment($user_id, $study_material_id, $comment)
    {
        $res = $this->create([
            'user_id' => $user_id,
            'study_material_id' => $study_material_id,
            'comment' => $comment
        ]);
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Comment created'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to create comment'
            ];
        }
    }
}