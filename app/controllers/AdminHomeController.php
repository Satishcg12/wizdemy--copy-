<?php

class AdminHomeController extends Controller
{
  public function __construct()
  {
    parent::__construct(new AdminModel());
  }

  public function index()
  {
    $adminId = Session::get('admin')['admin_id'];

    $userCounts = (new UserModel)->getCounts();
    $materialCounts = (new StudyMaterialModel)->getCounts();
    $requestCounts = (new StudyMaterialRequestModel)->getCounts();
    $projectCounts = (new GithubProjectModel)->getCounts();
    $reportCounts = (new ReportModel)->getCounts();


    View::render(
      'admin/dashboard',
      [
        'userCounts' => $userCounts,
        'materialCounts' => $materialCounts,
        'requestCounts' => $requestCounts,
        'projectCounts' => $projectCounts,
        'reportCounts' => $reportCounts,
      ]
    );
  }


  public function accountSecurity()
  {
    $adminDetails = $this->model->getAdminById(Session::get('admin')['admin_id']);
    View::render('admin/editAndSettingAdmin', [
      'adminDetails' => $adminDetails,
      'type' => 'accountSecurity'
    ]);
  }


  public function adminLog()
  {
    if (Session::get('admin')['admin_id'] != 1) {
      $this->previousUrl();
    }
    $query = $_GET['query'] ?? '';
    $page = $_GET['page'] ?? 1;
    if ($page < 1) {
      $page = 1;
    }

    $logs = (new AdminActionLogModel())->getLogs($query, $page);
    $totalData = (new AdminActionLogModel())->getLogsCount($query);

    View::render('admin/actionLog', [
      'logs' => $logs,
      'totalData' => $totalData,
      'query' => $query,
      'page' => $page,
      'currentPage' => 'adminLog'

    ]);
  }

  public function myLog()
  {
    $adminId = Session::get('admin')['admin_id'];

    $query = $_GET['query'] ?? '';
    $page = $_GET['page'] ?? 1;
    if ($page < 1) {
      $page = 1;
    }

    $logs = (new AdminActionLogModel())->getLogsByAdminId($adminId, $query, $page);
    $totalData = (new AdminActionLogModel())->getLogsCountByAdminId($adminId, $query);

    View::render('admin/actionLog', [
      'logs' => $logs,
      'totalData' => $totalData,
      'query' => $query,
      'page' => $page,
      'currentPage' => 'myLog'
    ]);
  }

  public function view($targetType, $targetId)
  {
    $page = 1;
    $totalData = 1;
    $query = '';

    switch ($targetType) {
      case 'user':
        $target = (new UserModel())->getUserById($targetId);
        View::render('admin/userManagement', [
          'users' => $target ? [$target] : [],
          //passing as array to use the same view because there is a foreach loop in the view
          'page' => $page,
          'totalData' => $totalData,
          'query' => $query,
          'currentPage' => 'userManagement'
        ]);
        break;
      case 'material':
        $target = (new StudyMaterialModel())->getMaterialDetailById($targetId);
        View::render('admin/materialManagement', [
          'materials' => $target ? [$target] : [],
          'page' => $page,
          'totalData' => $totalData,
          'query' => $query
        ]);
        break;
      case 'request':
        $target = (new StudyMaterialRequestModel())->getRequestDetailById($targetId);
        View::render('admin/requestManagement', [
          'requests' => $target ? [$target] : [],
          'page' => $page,
          'totalData' => $totalData,
          'query' => $query
        ]);
        break;
      case 'responded':

        $page = $_GET['page'] ?? 1;
        if ($page < 1) {
          $page = 1;
        }

        $target = (new StudyMaterialModel())->getMaterialDetailByRequestId($targetId, $page);
        $totalData = (new StudyMaterialModel())->getTotalRespondedMaterials($targetId);

        View::render('admin/materialManagement', [
          'materials' => $target, //because model method uses getAll() which returns array
          'page' => $page,
          'totalData' => $totalData,
          'query' => $query
        ]);

        
        break;
      case 'project':
        $target = (new GithubProjectModel())->getProjectDetailById($targetId);
        View::render('admin/projectManagement', [
          'projects' => $target ? [$target] : [],
          'page' => $page,
          'totalData' => $totalData,
          'query' => $query
        ]);
        break;
      case 'admin':
        if (Session::get('admin')['admin_id'] == 1) {
          $target = (new AdminModel())->getAdminById($targetId);
          View::render('admin/adminManagement', [
            'admins' => $target ? [$target] : [],
            'page' => $page,
            'totalData' => $totalData,
            'query' => $query,
            'currentPage' => 'adminManagement'
          ]);
        } else {
          $this->previousUrl();
        }
        break;
      default:
        $this->previousUrl();
        break;
    }
  }
  public function updateStatus($targetType, $targetId, $status)
  {

    // check if user_id and status are set
    if (!isset($targetId) || !isset($status) || !isset($targetType)) {
      $this->buildJsonResponse('Invalid request', 400);
    }
    switch ($targetType) {
      case 'user':
        $model = new UserModel();
        break;
      case 'material':
        $model = new StudyMaterialModel();
        break;
      case 'request':
        $model = new StudyMaterialRequestModel();
        break;
      case 'project':
        $model = new GithubProjectModel();
        break;
      case 'admin':
        $model = new AdminModel();
        break;
      case 'report':
        $model = new ReportModel();
        break;
      default:
        $this->buildJsonResponse('Invalid request', 400);
        break;
    }

    $result = $model->updateStatus($targetId, $status);

    if ($result['status']) {
      (new AdminActionLogModel())->log(Session::get('admin')['admin_id'], $targetId, $targetType, $status);
      $this->buildJsonResponse($result['message'], 200);
    } else {
      $this->buildJsonResponse($result['message'], 400);
    }

  }

  public function delete($targetType, $targetId)
  {
    // check if user_id and status are set
    if (!isset($targetId) || !isset($targetType)) {
      $this->buildJsonResponse('Invalid request', 400);
    }

    switch ($targetType) {
      case 'user':
        $model = new UserModel();
        break;
      case 'material':
        $model = new StudyMaterialModel();
        break;
      case 'request':
        $model = new StudyMaterialRequestModel();
        break;
      case 'project':
        $model = new GithubProjectModel();
        break;
      case 'admin':
        $model = new AdminModel();
        break;
      default:
        $this->buildJsonResponse('Invalid request', 400);
        break;
    }

    // making 1st char uppercase of target type because the model method is in camel case
    //eg: deleteUser, deleteMaterial, deleteRequest, deleteProject, deleteAdmin
    $method = 'delete' . ucfirst($targetType);



    if ($targetType == 'material') {
      $material = $model->getMaterialById($targetId);
      if ($material) {
        $filePath = $material['file_path'];
        if (!File::delete($filePath)) {
          $this->buildJsonResponse('Failed to delete file', 400);
        }
        $thumbnailPath = $material['thumbnail_path'];
        if (!File::delete($thumbnailPath)) {
          $this->buildJsonResponse('Failed to delete thumbnail', 400);
        }
      } else {
        $this->buildJsonResponse('Material not found', 400);
      }
    }

    $result = $model->$method($targetId);

    if ($result['status']) {
      (new AdminActionLogModel())->log(Session::get('admin')['admin_id'], $targetId, $targetType, 'delete');
      $this->buildJsonResponse($result['message'], 200);
    } else {
      $this->buildJsonResponse($result['message'], 400);
    }
  }

  public function restore($targetType) //view
  {

    //if target type is not set or not valid, redirect to previous page
    if (!isset($targetType) || !in_array($targetType, ['user', 'admin'])) {
      $this->previousUrl();
    }


    switch ($targetType) {
      case 'user':
        $model = new UserModel();
        break;
      case 'admin':
        if (Session::get('admin')['admin_id'] != 1) {
          $this->previousUrl();
        }
        $model = new AdminModel();
        break;
      default:
        $this->previousUrl();
        break;
    }


    $query = $_GET['query'] ?? '';
    $page = $_GET['page'] ?? 1;
    if ($page < 1) {
      $page = 1;
    }

    // $method = 'getDeleted' . ucfirst($targetType);
    $getDeletedMethod = 'getDeleted' . ucfirst($targetType);
    $getDeletedCountMethod = 'getDeleted' . ucfirst($targetType) . 'Count';

    $result = $model->$getDeletedMethod($query, $page);
    $totalData = $model->$getDeletedCountMethod($query);

    $view = $targetType .'Management';


    View::render('admin/'.$view, [
      $targetType.'s' => $result,
      'page' => $page,
      'totalData' => $totalData,
      'query' => $query,
      'currentPage' => 'restore' . ucfirst($targetType)
    ]);


  }

  public function restoreProcess($targetType, $targetId) //api
  {

    //if target type is not set or not valid, redirect to previous page
    if (!isset($targetType) || !in_array($targetType, ['user', 'admin'])) {
      $this->buildJsonResponse('Invalid request', 400);
    }

    switch ($targetType) {
      case 'user':
        $model = new UserModel();
        break;
      case 'admin':
        $model = new AdminModel();
        break;
      default:
        $this->previousUrl();
        break;
    }

    $method = 'restore' . ucfirst($targetType);

    $result = $model->$method($targetId);

    if ($result['status']) {
      (new AdminActionLogModel())->log(Session::get('admin')['admin_id'], $targetId, $targetType, 'restore');
      $this->buildJsonResponse($result['message'], 200);
    } else {
      $this->buildJsonResponse($result['message'], 400);
    }
  }
}