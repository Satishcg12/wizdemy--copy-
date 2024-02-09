<?php

class StudyMaterialController extends Controller
{
    public function __construct()
    {
        parent::__construct('StudyMaterial');
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
            'thumbnail' => ['required', 'image', 'max-size:10000000'],
            'document' => ['required', 'file', 'max-size:10000000']
        ]);

        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $_SESSION['old'] = $_POST;
            if ($respondTo) {
                $this->redirect('/studymaterial/create?request_id=' . $respondTo);
            } else {
                $this->redirect('/studymaterial/create');
            }
        }
        //upload files
        $thumbnailPath = File::upload($thumbnail, 'uploads/study-materials/thumbnails/');
        $documentPath = File::upload($document, 'uploads/study-materials/documents/');

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
    public function show()
    {
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        //get study material with user and view , like , comment count have like
        $studyMaterial = $this->model->select([
            'users.username as user_name',
            'study_materials.*',
            'COUNT(views.id) as views_count',
            'COUNT(likes.id) as likes_count',
            'COUNT(comments.id) as comments_count',
        ])
            ->join('users', 'study_materials.user_id', '=', 'users.id')
            ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
            ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
            ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
            ->where('study_materials.id', $id)
            ->groupBy('study_materials.id')
            ->first();

        $like = false;
        $bookmark = false;
        if (isset($_SESSION['user_id'])) {
            $like = (new Likes())->isLiked($_SESSION['user_id'], $id);
            $bookmark = (new Bookmarks())->isBookmarked($_SESSION['user_id'], $id);
        }
        $studyMaterial['like_status'] = $like;
        $studyMaterial['bookmark_status'] = $bookmark;

        if (empty($studyMaterial)) {
            $this->redirect('/404');
        }
        $this->view('showStudyMaterial', ['studyMaterial' => $studyMaterial]);
    }
    public function edit()
    {
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        $studyMaterial = $this->model->find($id);
        if (empty($studyMaterial)) {
            $this->redirect('/404');
        }
        $this->view('editStudyMaterial', ['studyMaterial' => $studyMaterial]);
    }
    public function like()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->json(['status' => 'error', 'msg' => 'You need to login to like']);
        }
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        $like = new Likes();

        $like = $like->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->first();
        if ($like) {
            $like = new Likes();
            $like->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->delete();
            $likecount = $like->where('study_material_id', $id)->count();
        } else {
            $like = new Likes();
            $like->create([
                'user_id' => $_SESSION['user_id'],
                'study_material_id' => $id
            ]);
            $likecount = $like->where('study_material_id', $id)->count();
        }
        $this->json(['status' => 'success', 'likeCount' => $likecount]);
    }
    public function bookmark()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->json(['status' => 'error', 'msg' => 'You need to login to bookmark']);
        }
        if (!isset($_GET['id'])) {
            $this->redirect('/404');
        }
        $id = $_GET['id'];
        $bookmark = new Bookmarks();

        $bookmark = $bookmark->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->first();
        if ($bookmark) {
            $bookmark = new Bookmarks();
            $bookmark->where('user_id', $_SESSION['user_id'])->where('study_material_id', $id)->delete();
        } else {
            $bookmark = new Bookmarks();
            $bookmark->create([
                'user_id' => $_SESSION['user_id'],
                'study_material_id' => $id
            ]);
        }
        $this->json(['status' => 'success']);
    }
}