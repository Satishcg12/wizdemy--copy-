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
  'currentPage' => 'requestManagement'
]);

View::renderPartial('AdminMenuHeader');

?>

<section>
<?php
if (!empty($requests)) {
  View::renderPartial('AdminRequestListTable', [
    'requests' => $requests
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
