<?php include 'includes/header.php'; ?>

<div class="container content-container">
    <h2>
        Press'on Nails
    </h2>
    <p>
        Les press'on nails qui sont des capsules d'ongles américaines qui se collent avec des autocollants gomme spéciaux pour ne pas abimer vos ongles.
        Ces capsules sont destinées aux personnes ne pouvant porter d'ongles en gel au quotidien à cause de leur activité professionnelle ou
        aux jeunes filles de moins de 16 ans qui ne peuvent pas encore porter de gel.
        Elles tiennent plusieurs jours et se décollent en trempant les doigts dans l'eau chaude pendant 10 mn.
    </p>
    <p>
        Envoi possible en lettre suivie à 2.5€.
    </p>
    <p>
        Voir le choix des couleurs et décos dans le galerie décos.
    </p>

    <?php
    include 'includes/gallery.php';
    $gallery_folder = 'produits/presson_nails/';
    $gallery = Gallery::getInstance($gallery_folder);
    $gallery->create_gallery();
    ?>
</div>

<?php include 'includes/footer.php'; ?>