<?php

class GithubProjectModel extends Model
{

    public function __construct(string $table = 'github_projects')
    {
        parent::__construct($table);
        $this->fillable = ['user_id', 'repo_link'];
    }

    public function show()
    {
        //join user table and github_projects table to get username,user_id,project_id,repo_link
        return $this->select([
            'u.user_id',
            'u.username',
            'u.full_name',
            'p.*'
        ], 'p')
        ->leftJoin('users as u', 'u.user_id = p.user_id')
        ->where('p.status <> :status')
        ->bind(['status' => 'suspend'])
            ->orderBy('p.created_at', 'DESC')
            ->limit(10)
            ->getAll();
    }

    public function isDuplicate($userId, $repoLink)
    {
        return $this->select(['*'])
            ->where('user_id = :user_id AND repo_link = :repo_link')
            ->bind(['user_id' => $userId, 'repo_link' => $repoLink])
            ->get();
    }

    public function store($userId, $repoLink)
    {

        return $this->insert([
            'user_id' => $userId,
            'repo_link' => $repoLink,
        ])->execute();
    }

    //shows suspended projects too in owner's profile
    public function showProjectsByCurrentUser()
    {
        $user_id = Session::get('user')['user_id'] ?? null;
        return $this->select([
            'p.*',
            'u.username'
        ], 'p')
            ->leftJoin('users as u', 'u.user_id = p.user_id')
            ->where('p.user_id = :user_id')
            ->bind(['user_id' => $user_id])
            ->getAll();
    }

    public function showProjectsByUserId($user_id)
    {
        return $this->select([
            'p.*',
            'u.username'
        ], 'p')
            ->leftJoin('users as u', 'u.user_id = p.user_id')
            ->where('p.user_id = :user_id AND p.status <> :status')
            ->bind(['user_id' => $user_id, 'status' => 'suspend'])
            ->getAll();
    }
   
    public function getProjectsForAdmin()
    {
        {
            //join user table and github_projects table to get username,user_id,project_id,repo_link
            return $this->select([
                'u.user_id',
                'u.username',
                'u.full_name',
                'p.*'
            ], 'p')
            ->leftJoin('users as u', 'u.user_id = p.user_id')
                ->orderBy('p.created_at', 'DESC')
                ->limit(10)
                ->getAll();
        }
    }

    public function getProjectDetailById($project_id)
    {
        return $this->select(['*'])
            ->where('project_id = :project_id')
            ->bind(['project_id' => $project_id])
            ->get();
    }

    public function updateProject($project_id, $repo_link)
    {
        $result = $this->update([
            'repo_link' => $repo_link
        ])
            ->where('project_id = :project_id')
            ->appendBindings(['project_id' => $project_id])
            ->execute();
        if($result){
            return [
                'status' => true,
                'message' => 'Project updated successfully'
            ];
        }else{
            return [
                'status' => false,
                'message' => 'Project update failed'
            ];
        }
    }

    public function deleteProject($project_id)
    {
        $result = $this->delete()
            ->where('project_id = :project_id')
            ->bind(['project_id' => $project_id])
            ->execute();
        if($result){
            return [
                'status' => true,
                'message' => 'Project deleted successfully'
            ];
        }else{
            return [
                'status' => false,
                'message' => 'Project deletion failed'
            ];
        }
    }
    
    public function getTotalProjectsCount()
    {
        $result = $this->count()->get();
        return $result['total'];
    }
}