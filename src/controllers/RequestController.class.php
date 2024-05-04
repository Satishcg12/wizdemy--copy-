<?php
class RequestController extends Controller
{
    public function __construct()
    {
        parent::__construct('Requests');
    }
    public function index()
    {
        $requests = $this->model->allWithUser();
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
            'semester' => [ 'max:50'],
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