<?php 

View::renderPartial('Header', [
  'pageTitle' => SITE_NAME . ' | Likes',
  'stylesheets' => [
    'styles',
    'statusAndZeroResult'
  ],
  'scripts' => [
    'script',
    'threeDotMenu',
    'sideInfo',
    'searchOverlay',
    'toastTimer',
    'timeAgo',
    'confirmModal',
  ]
]);

View::renderPartial('SideNav', [
  'currentPage' => 'like'
]);

View::renderPartial('MenuHeader');

?>

<section>
<?php
 if (!empty($likes)):
  View::renderPartial('StudyMaterialCard', [
    'materials' => $likes,
  ]);
else:
  View::renderPartial('ZeroResult');
endif;
?>
</section>

</main>

<?php
View::renderPartial('ThreeDotMenu');

View::renderPartial('SideInfo');

View::renderPartial('SearchOverlay');

View::renderPartial('ToastNotification');

View::renderPartial('ConfirmModal');

View::renderPartial('EndOfHTMLDocument');
