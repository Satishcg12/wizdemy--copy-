<?php 

View::renderPartial('Header', [
  'pageTitle' => SITE_NAME . ' | Questions',
  'stylesheets' => [
    'styles'
  ],
  'scripts' => [
    'script',
    'threeDotMenu',
    'sideInfo',
    'searchOverlay',
    'notificationOverlay',
    'toastTimer'
  ]
]);

View::renderPartial('SideNav', [
  'currentPage' => 'question'
]);

View::renderPartial('MenuHeader');

?>

<section>
<?php
View::renderPartial('StudyMaterialCard');
?>
</section>

<?php
View::renderPartial('ThreeDotMenu');

View::renderPartial('SideInfo');

View::renderPartial('SearchOverlay');

View::renderPartial('NotificationOverlay');

View::renderPartial('ToastNotification');

View::renderPartial('EndOfHTMLDocument');