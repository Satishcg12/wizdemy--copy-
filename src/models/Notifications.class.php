<?php

class Notifications extends Model
{
    public function __construct()
    {
        parent::__construct('notifications');
        $this->fillable = ['user_id', 'title', 'action', 'message', 'link'];
    }
    public function createNotification($user_id, $title, $action, $message, $link)
    {
        $res = $this->create([
            'user_id' => $user_id,
            'title' => $title,
            'action' => $action,
            'message' => $message,
            'link' => $link
        ]);
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Notification created'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Failed to create notification'
            ];
        }
    }
    public function getNotifications($user_id)
    {
        $res = $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();
        return $res;
    }
    public function getNotificationsCount($user_id)
    {
        $res = $this->where('user_id', $user_id)->count();
        return $res;
    }
}