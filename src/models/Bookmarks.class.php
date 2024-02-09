<?php
class Bookmarks extends Model{
    public function __construct()
    {
        parent::__construct('bookmarks');
        $this->fillable = ['user_id', 'study_material_id'];
    }
    public function bookmark($user_id, $study_material_id)
    {
        $res = $this->create([
            'user_id' => $user_id,
            'study_material_id' => $study_material_id
        ]);
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Bookmarked'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to bookmark'
            ];
        }
    }
    public function unbookmark($user_id, $study_material_id)
    {
        $res = $this->where('user_id', $user_id)->where('study_material_id', $study_material_id)->delete();
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Unbookmarked'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to unbookmark'
            ];
        }
    }
    public function isBookmarked($user_id, $study_material_id)
    {
        $res = $this->where('user_id', $user_id)->where('study_material_id', $study_material_id)->get();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function getBookmarks($user_id)
    {
        $res = $this->select(['study_materials.id', 'study_materials.title', 'study_materials.description', 'study_materials.format', 'study_materials.author', 'study_materials.thumbnail', 'study_materials.document', 'study_materials.created_at'])
            ->join('study_materials', 'study_materials.id', '=', 'bookmarks.study_material_id')
            ->where('bookmarks.user_id', $user_id)
            ->get();
        return $res;
    }
    public function getBookmarksCount($study_material_id)
    {
        $res = $this->where('study_material_id', $study_material_id)->count();
        return $res;
    }
}