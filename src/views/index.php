<?php
View::renderComponent('Header', ['page_title' => SITE_NAME, 'stylesheets' => ['styles'], 'scripts' => ['script', 'toast', 'threeDotMenu', 'sideInfo', 'searchOverlay','parseTimeAgo']]);
View::renderComponent('SideNav', ['current_page' => 'index']);

?>

<main class="container">
    <?php View::renderComponent('MenuHeader') ?>

    <section>
        <!-- card-section  -->
        <div class="card-section">
            <?php if ($studyMaterials['status']): ?>
                <?php foreach ($studyMaterials['data'] as $studyMaterial): ?>
                    <!-- card  -->
                    <?php req('src/views/components/Card.php', ['studyMaterial' => $studyMaterial]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data" >
                    <h1>No Data Found</h1>
                </div>
            <?php endif; ?>


        </div>

        <!-- footer -->
        <footer>
            <!-- show more button  -->
            <div class="show-more-section">
                <button class="show-more-button">Show More</button>
            </div>

            <!-- footer content  -->
            <div class="footer-content">
                <p>© Copyright 2021. All Rights Reserved.</p>

                <div>
                    <a href="t&c.html">Tearms & Conditions</a>・
                    <a href="#">Privacy</a>・
                    <a href="#">Cookies</a>
                </div>

                <div>
                    Developers : <a href="#">Rayyan Balami</a> &amp;
                    <a href="#">Satish Chaudhary</a>
                </div>
            </div>
        </footer>
    </section>
</main>

<?php
View::renderComponent('SearchOverlay');
View::renderComponent('SideInfo');
View::renderComponent('ThreeDotMenu');
View::renderComponent('Footer');

?>