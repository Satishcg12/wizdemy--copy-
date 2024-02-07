<?php

class StudyMaterialController extends Controller
{
    public function __construct()
    {
        parent::__construct('StudyMaterial');
    }

    public function index()
    {
        $studyMaterials = $this->model->all();
        $this->view('index', ['studyMaterials' => $studyMaterials]);
    }
    public function create()
    {
        $requestDetail = null;
        if (isset($_GET['request_id'])) {
            $request = new Requests();
            $requestId = $_GET['request_id'];
            $requestDetail = $request->select(['users.full_name', 'study_material_requests.*'])
                ->join('users', 'users.id', '=', 'study_material_requests.user_id')
                ->where('study_material_requests.id', $requestId)
                ->first();
        }
        $this->view('createStudyMaterial', ['requestDetail' => $requestDetail]);
    }
    public function store()
    {

        // -- Create the study_materials table
        // CREATE TABLE study_materials (
        //     id INT PRIMARY KEY AUTO_INCREMENT,
        //     user_id INT NOT NULL,
        //     respond_to INT,
        //     title VARCHAR(255) NOT NULL,
        //     description TEXT,
        //     document_type VARCHAR(255) NOT NULL,
        //     format VARCHAR(255) NOT NULL,
        //     education_level VARCHAR(255) NOT NULL,
        //     semester VARCHAR(255),
        //     subject VARCHAR(255) NOT NULL,
        //     author VARCHAR(255) NOT NULL,
        //     file_path VARCHAR(255) NOT NULL,
        //     thumbnail_path VARCHAR(255) NOT NULL,
        //     class_faculty VARCHAR(255) NOT NULL,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        //     FOREIGN KEY (user_id) REFERENCES users(id),
        //     FOREIGN KEY (respond_to) REFERENCES study_material_requests(id)
        // );
        $user_id = $_SESSION['user_id'];
        $respondTo = null;
        $title = $_POST['title'];
        $description = $_POST['description'];
        $format = $_POST['format'];
        $author = $_POST['author'];
        if (isset($_POST['request_id'])) {
            $respondTo = $_POST['request_id'];
            $request = new Requests();
            $request = $request->find($respondTo);
            if (!$request) {
                ToastNotification::error('Invalid request');
                $this->redirect('/study-material/create');
            }
            $documentType = $request['document_type'];
            $educationLevel = $request['education_level'];
            $semester = $request['semester'];
            $subject = $request['subject'];
            $class_faculty = $request['class_faculty'];
        } else {
            $respondTo = null;
            $documentType = $_POST['document_type'];
            $educationLevel = $_POST['education_level'];
            $semester = $_POST['semester'];
            $subject = $_POST['subject'];
            $class_faculty = $_POST['class_faculty'];
            $educationLevel = $_POST['education_level'];
        }
        $thumbnail = $_FILES['file-thumbnail'];
        $document = $_FILES['file-document'];

        //validate
        $validation = Validator::validate([
            'title' => $title,
            'description' => $description,
            'format' => $format,
            'author' => $author,
            'document_type' => $documentType,
            'education_level' => $educationLevel,
            'subject' => $subject,
            'class_faculty' => $class_faculty,
            'thumbnail' => $thumbnail,
            'document' => $document
        ], [
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'format' => ['required'],
            'author' => ['required', 'min:3'],
            'document_type' => ['required'],
            'education_level' => ['required'],
            'subject' => ['required'],
            'class_faculty' => ['required'],
            'thumbnail' => ['required', 'image', 'max-size:100000'],
            'document' => ['required', 'file', 'max-size:10000000']
        ]);

        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $_SESSION['old'] = $_POST;
            $this->redirect('/studymaterial/create');
        }
        //upload files
        $thumbnailPath = File::upload($thumbnail, 'uploads/study-materials/thumbnails');
        $documentPath = File::upload($document, 'uploads/study-materials/documents');

        if (!$thumbnailPath['status'] || !$documentPath['status']) {
            ToastNotification::error("Failed to upload files. ");
            $_SESSION['old'] = $_POST;
            if ($respondTo) {
                $this->redirect('/studymaterial/create?request_id=' . $respondTo);
            } else {
                $this->redirect('/studymaterial/create');
            }
        }
        $thumbnailPath = $thumbnailPath['path'];
        $documentPath = $documentPath['path'];
        //save to database
        $result = $this->model->create([
            'user_id' => $user_id,
            'respond_to' => $respondTo,
            'title' => $title,
            'description' => $description,
            'document_type' => $documentType,
            'format' => $format,
            'education_level' => $educationLevel,
            'semester' => $semester,
            'subject' => $subject,
            'author' => $author,
            'file_path' => $documentPath,
            'thumbnail_path' => $thumbnailPath,
            'class_faculty' => $class_faculty
        ]);
        if (!$result) {
            ToastNotification::error('Failed to create study material');
            $_SESSION['old'] = $_POST;
            if ($respondTo) {
                $this->redirect('/studymaterial/create?request_id=' . $respondTo);
            } else {
                $this->redirect('/studymaterial/create');
            }
        }
        ToastNotification::success('Study material created successfully');
        $this->redirect('/studymaterial/create');
    }
}