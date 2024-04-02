<?php 

View::renderPartial('Header', [
  'pageTitle' => SITE_NAME . ' | Admin Dashboard',
  'stylesheets' => [
    'statusAndZeroResult',
    'adminStyles',
  ],
  'scripts' => [
    'script',
    'threeDotMenu',
    'sideInfo',
    'searchOverlay',
    'toastTimer',
    'timeAgo'
  ]
]);

View::renderPartial('AdminSideNav', [
  'currentPage' => 'projectManagement'
]);

View::renderPartial('AdminMenuHeader');

?>

<section>
<?php
if (!empty($projects)) {
  View::renderPartial('AdminProjectListTable', [
    'projects' => $projects
  ]);
} else {
  View::renderPartial('ZeroResult');
}

?>
</section>

</main>

<?php

View::renderPartial('ConfirmModal');

View::renderPartial('EndOfHTMLDocument');
