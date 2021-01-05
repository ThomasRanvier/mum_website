<?php include 'includes/header.php'; ?>

<div class="container content-container">
    <h2>
        Vente de Bijoux <a href="https://www.ladygum.com/" target="_blank">Ladygum</a>
    </h2>
    <h3>
        Ce sont des bijoux en gomme, légers, effet tatouage, de marque française.
    </h3>
    <p>
        Les colliers sont à 24€ seuls, promo 15€.
        <br/>
        Les bracelets à 14€, promo 7€.
        <br/>
        Les boucles d'oreilles à 12€, promo 5€.
    </p>
    <p>
        Ces bijoux ne sont pas fragiles et ne craignent pas l'eau, ils sont légers et souples et font un effet tatouage.
        Ils conviennent aussi bien pour une soirée que pour les vacances à la mer.
    </p>

    <?php
        include 'includes/gallery.php';
        $gallery_folder = 'produits/lady_gum/';
        $gallery = Gallery::getInstance($gallery_folder);
        $gallery->create_gallery();
    ?>
</div>

<?php include 'includes/footer.php'; ?>