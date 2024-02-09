<?php
class UserFollows extends Model
{
    public function __construct()
    {
        parent::__construct('user_follows');
        $this->fillable = ['follower_id', 'following_id'];
    }
    public function follow($user_id, $followed_id)
    {
        $res = $this->create([
            'follower_id' => $user_id,
            'following_id' => $followed_id
        ]);
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Followed'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to follow'
            ];
        }
    }
    public function unfollow($user_id, $followed_id)
    {
        $res = $this->where('follower_id', $user_id)->where('following_id', $followed_id)->delete();
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Unfollowed'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to unfollow'
            ];
        }
    }
    public function isFollowing($user_id, $followed_id)
    {
        $res = $this->where('follower_id', $user_id)->where('following_id', $followed_id)->get();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function getFollowers($user_id)
    {
        $res = $this->select(['users.id', 'users.username', 'users.full_name', 'users.bio'])
            ->join('users', 'users.id',' = ', 'user_follows.follower_id')
            ->where('following_id', $user_id)
            ->get();
        return $res;
    }
    public function getFollowing($user_id)
    {
        $res = $this->select(['users.id', 'users.username', 'users.full_name', 'users.bio'])
            ->join('users', 'users.id', '=', 'user_follows.following_id')
            ->where('follower_id', $user_id)
            ->get();
        return $res;
    }
}