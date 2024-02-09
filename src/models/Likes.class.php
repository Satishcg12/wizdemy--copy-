<?php
class Likes extends Model
{
    public function __construct()
    {
        parent::__construct('likes');
        $this->fillable = ['user_id', 'study_material_id'];
    }
    public function like($user_id, $study_material_id)
    {
        $res = $this->create([
            'user_id' => $user_id,
            'study_material_id' => $study_material_id
        ]);
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Liked'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to like'
            ];
        }
    }
    public function unlike($user_id, $study_material_id)
    {
        $res = $this->where('user_id', $user_id)->where('study_material_id', $study_material_id)->delete();
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Unliked'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to unlike'
            ];
        }
    }
    public function isLiked($user_id, $study_material_id)
    {
        $res = $this->where('user_id', $user_id)->where('study_material_id', $study_material_id)->get();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function getLikes($study_material_id)
    {
        $res = $this->select(['users.id', 'users.username', 'users.full_name', 'users.bio'])
            ->join('users', 'users.id',' = ', 'likes.user_id')
            ->where('study_material_id', $study_material_id)
            ->get();
        return $res;
    }
    public function getLikesCount($study_material_id)
    {
        $res = $this->where('study_material_id', $study_material_id)->count();
        return $res;
    }
}