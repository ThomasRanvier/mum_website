<?php include 'includes/header.php'; ?>

<div class="container content-container">
    <h2>
        Bijoux en gel
    </h2>
    <p>
        Ce sont des bijoux en gel que je fais moi-même à la main en utilisant le même gel que celui utilisé pour les ongles.
    </p>

    <?php
    include 'includes/gallery.php';
    $gallery_folder = 'produits/bijoux_gel/';
    $gallery = Gallery::getInstance($gallery_folder);
    $gallery->create_gallery();
    ?>
</div>

<?php include 'includes/footer.php'; ?>