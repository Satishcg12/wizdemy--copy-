<?php
class RequestController extends Controller
{
    public function __construct()
    {
        parent::__construct('Requests');
    }
    public function index()
    {
        $requests = null;
        //get all requests with user and study_material joint, arrange by latest, count study_materials
        $requests = $this->model->select(['study_material_requests.*', 'users.username as user_name', 'COUNT(study_materials.id) as study_material_count'])
            ->leftJoin('users', 'study_material_requests.user_id', '=', 'users.id')
            ->leftJoin('study_materials', 'study_material_requests.id', '=', 'study_materials.respond_to')
            ->groupBy('study_material_requests.id')
            ->orderBy('study_material_requests.created_at', 'DESC')
            ->get();
        // select study_material_requests.*, users.username as user_name, COUNT(study_materials.id) as study_material_count from study_material_requests left join users on study_material_requests.user_id = users.id left join study_materials on study_material_requests.id = study_materials.respond_to group by study_material_requests.id order by study_material_requests.created_at desc
        $this->view('requests', ['requests' => $requests]);
    }
    public function create()
    {
        $this->view('createRequest');
    }
    public function store()
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user_id = $_SESSION['user_id'];
        $document_type = $_POST['document_type'];
        $education_level = $_POST['education_level'];
        $semester = $_POST['semester'];
        $subject = $_POST['subject'];
        $class_faculty = $_POST['class_faculty'];

        $validation = Validator::validate([
            'title' => $title,
            'description' => $description,
            'document_type' => $document_type,
            'education_level' => $education_level,
            'semester' => $semester,
            'subject' => $subject,
            'class_faculty' => $class_faculty
        ], [
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:20', 'max:1000'],
            'document_type' => ['required', 'max:50'],
            'education_level' => ['required', 'max:50'],
            'semester' => ['max:50'],
            'subject' => ['required', 'max:50'],
            'class_faculty' => ['required', 'min:3', 'max:50']
        ]);
        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $_SESSION['old'] = $_POST;
            $this->redirect('/requests/create');
        }
        $data = [
            'title' => $title,
            'description' => $description,
            'user_id' => $user_id,
            'education_level' => $education_level,
            'semester' => $semester,
            'subject' => $subject,
            'class_faculty' => $class_faculty,
            'document_type' => $document_type
        ];
        $result = $this->model->create($data);
        if ($result) {
            ToastNotification::success('We have received your request');
            $this->redirect('/requests');
        } else {
            ToastNotification::error('Something went wrong');
            $this->redirect('/requests/create');
        }
    }
    public function show($id)
    {
        $studyMaterial = $this->model->find($id);
        $this->view('show', ['studyMaterial' => $studyMaterial]);
    }
    public function edit($id)
    {
        $studyMaterial = $this->model->find($id);
        $this->view('edit', ['studyMaterial' => $studyMaterial]);
    }
}