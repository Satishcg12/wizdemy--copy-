<?php
View::renderComponent('Header', ['page_title' => SITE_NAME, 'stylesheets' => ['styles'], 'scripts' => ['script', 'toast', 'threeDotMenu', 'sideInfo', 'searchOverlay', 'parseTimeAgo']]);
View::renderComponent('SideNav', ['current_page' => 'notes']);

// get the study materials from the controller
$studyMaterials = $data['studyMaterials'];


?>

<main class="container">
    <?php View::renderComponent('MenuHeader') ?>

    <section>
        <!-- card-section  -->
        <?php if (!empty($studyMaterials)): ?>
            <div class="card-section">
                <?php foreach ($studyMaterials as $studyMaterial): ?>
                    <!-- card  -->
                    <?php View::renderComponent('StudyMaterialCard', ['studyMaterial' => $studyMaterial]) ?>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <div class="no-data">
                    <h1>No Data Found</h1>
                </div>


        <?php endif; ?>
        <?php View::renderComponent('foot') ?>
    </section>
</main>

<?php
View::renderComponent('ToastNotification');
View::renderComponent('SearchOverlay');
View::renderComponent('SideInfo');
View::renderComponent('ThreeDotMenu');
View::renderComponent('Footer');

?>