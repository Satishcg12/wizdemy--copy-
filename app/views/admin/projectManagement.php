<?php 

View::renderPartial('Header', [
  'pageTitle' => SITE_NAME . ' | Project Management',
  'stylesheets' => [
    'statusAndZeroResult',
    'adminStyles',
  ],
  'scripts' => [
    'script',
    'jquery.min',
    'toastTimer',
    'confirmModal',
    'adminTable',
    'statusDelete',
  ]
]);

View::renderPartial('../adminPartials/sideNav', [
  'currentPage' => 'projectManagement'
]);

View::renderPartial('../adminPartials/menuHeader');

?>

<section>
<?php
 if (!empty($projects) || !empty($query)) {
  View::renderPartial('../adminPartials/projectTable', [
    'projects' => $projects,
    'totalData' => $totalData,
    'page' => $page,
    'query' => $query,
  ]);
} else {
  View::renderPartial('ZeroResult');
}

?>
</section>

</main>
<?php

View::renderPartial('ToastNotification');

View::renderPartial('ConfirmModal');

View::renderPartial('EndOfHTMLDocument');
