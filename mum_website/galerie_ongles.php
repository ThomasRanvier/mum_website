<?php include 'includes/header.php'; ?>

<div class="container content-container">
    <h2>
        Galerie ongles
    </h2>

    <?php
    include 'includes/gallery.php';
    $gallery_folder = 'galeries/ongles/';
    $gallery = Gallery::getInstance($gallery_folder);
    $gallery->create_gallery();
    ?>
</div>

<?php include 'includes/footer.php'; ?>