<?php

class ReportController extends Controller
{

  public function __construct()
  {
    parent::__construct(new ReportModel());
  }

  public function index($targetType, $targetId)
  {

    if (!$targetType || !$targetId || !in_array($targetType, ['user', 'material', 'request', 'project'])) {
      Session::flash('errors', ['message' => 'Invalid Report Request']);
      $this->redirect('/profile/' . Session::get('user')['user_id']);
    }
    if ($targetType == 'user') {
      $reportDetails = (new UserModel())->profileData($targetId);
    } else if ($targetType == 'material') {
      $reportDetails = (new StudyMaterialModel())->getMaterialDetailById($targetId);
    } else if ($targetType == 'request') {
      $reportDetails = (new StudyMaterialRequestModel())->getRequestDetailById($targetId);
    } else if ($targetType == 'project') {
      $reportDetails = (new GithubProjectModel())->getProjectDetailById($targetId);
    }else{
      $reportDetails = 'no data found';
    }
    View::render('reportForm', [
      'reportDetails' => $reportDetails,
      'targetId' => $targetId,
      'targetType' => $targetType
    ]);

  }

  public function store($targetType, $targetId)
  {

    if (!in_array($targetType, ['user', 'material', 'request', 'project'])) {
      Session::flash('errors', ['message' => 'Invalid Report Request']);
      $this->redirect('/profile/' . Session::get('user')['user_id']);
    }

    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    //validate title
    if (!Validate::string($title, 10, 150)) {
      $this->errors['title'] = 'Title: 10-150 characters';
    }

    //validate description
    if (!Validate::string($description, 10, 550)) {
      $this->errors['description'] = 'Description: 10-550 characters';
    }

    //if errors
    if (!empty($this->errors)) {
      Session::flash('errors', $this->errors);
      Session::flash('old', ['title' => $title, 'description' => $description]);
      $this->redirectPost('/report/' . $targetType . '/' . $targetId);
    }

    $result = $this->model->store(Session::get('user')['user_id'], $targetType, $targetId, $title, $description);

    if ($result['status']) {
      Session::flash('success', ['message' => $result['message']]);
      $this->redirect('/profile/' . Session::get('user')['user_id']);
    } else {
      Session::flash('errors', ['message' => $result['message']]);
      Session::flash('old', ['title' => $title, 'description' => $description]);
      $this->redirectPost('/report/' . $targetType . '/' . $targetId);
    }

  }
}
