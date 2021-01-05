<?php include 'includes/header.php'; ?>

    <div class="container content-container">
        <h2>
            Galerie réhaussement de cils Keratin
        </h2>

        <?php
        include 'includes/gallery.php';
        $gallery_folder = 'galeries/rehaussement/';
        $gallery = Gallery::getInstance($gallery_folder);
        $gallery->create_gallery();
        ?>
    </div>

<?php include 'includes/footer.php'; ?>