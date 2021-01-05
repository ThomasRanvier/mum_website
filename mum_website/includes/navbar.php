<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    $cur_file = end($uri);
?>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" href="#">Carine ongles et cils</a>
    <button class="navbar-toggler navbar-toggler-btn ml-auto" type="button"  data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item <?php echo $cur_file == 'index.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item <?php echo $cur_file == 'formations_suivies.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="formations_suivies.php">Formations suivies</a>
            </li>
            <li class="nav-item <?php echo $cur_file == 'championnats.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="championnats.php">Championnats</a>
            </li>
            <li class="nav-item <?php echo $cur_file == 'tarifs.php' ? 'active' : ''; ?>">
                <a class="nav-link <?php echo $cur_file == 'tarifs.php' ? 'active' : ''; ?>" href="tarifs.php">Tarifs</a>
            </li>
            <li class="nav-item dropdown <?php echo preg_match('/prestations_.*.php/', $cur_file) ? 'active' : ''; ?>">
                <a class="nav-link dropdown-toggle" href="#prestations" aria-haspopup="true" aria-expanded="false"
                   data-toggle="collapse" data-target="#dropdown-prestations">Prestations</a>
                <div>
                    <div id="dropdown-prestations" class="dropdown-menu collapse" >
                        <a class="dropdown-item <?php echo $cur_file == 'prestations_cils.php' ? 'active' : ''; ?>" href="prestations_cils.php">Cils</a>
                        <a class="dropdown-item <?php echo $cur_file == 'prestations_ongles.php' ? 'active' : ''; ?>" href="prestations_ongles.php">Ongles</a>
                        <a class="dropdown-item <?php echo $cur_file == 'prestations_hyaluropen.php' ? 'active' : ''; ?>" href="prestations_hyaluropen.php">Hyaluropen</a>
                        <a class="dropdown-item <?php echo $cur_file == 'prestations_rehaussement.php' ? 'active' : ''; ?>" href="prestations_rehaussement.php">Réhaussement Keratin</a>
                        <a class="dropdown-item <?php echo $cur_file == 'prestations_blanchiment.php' ? 'active' : ''; ?>" href="prestations_blanchiment.php">Blanchiment dentaire</a>
                        <a class="dropdown-item <?php echo $cur_file == 'prestations_formations.php' ? 'active' : ''; ?>" href="prestations_formations.php">Formations proposées</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown <?php echo preg_match('/galerie_.*.php/', $cur_file) ? 'active' : ''; ?>">
                <a class="nav-link dropdown-toggle" href="#galerie" aria-haspopup="true" aria-expanded="false"
                   data-toggle="collapse" data-target="#dropdown-galerie">Galerie</a>
                <div>
                    <div id="dropdown-galerie" class="dropdown-menu collapse" >
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_cils.php' ? 'active' : ''; ?>" href="galerie_cils.php">Cils</a>
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_ongles.php' ? 'active' : ''; ?>" href="galerie_ongles.php">Ongles</a>
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_hyaluropen.php' ? 'active' : ''; ?>" href="galerie_hyaluropen.php">Hyaluropen</a>
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_rehaussement.php' ? 'active' : ''; ?>" href="galerie_rehaussement.php">Réhaussement Keratin</a>
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_blanchiment.php' ? 'active' : ''; ?>" href="galerie_blanchiment.php">Blanchiment dentaire</a>
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_decos_strass.php' ? 'active' : ''; ?>" href="galerie_decos_strass.php">Déco et strass</a>
                        <a class="dropdown-item <?php echo $cur_file == 'galerie_certificats.php' ? 'active' : ''; ?>" href="galerie_certificats.php">Certificats</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown <?php echo preg_match('/produits_.*.php/', $cur_file) ? 'active' : ''; ?>">
                <a class="nav-link dropdown-toggle" href="#produits" aria-haspopup="true" aria-expanded="false"
                   data-toggle="collapse" data-target="#dropdown-produits">Produits</a>
                <div>
                    <div id="dropdown-produits" class="dropdown-menu collapse" >
                        <a class="dropdown-item <?php echo $cur_file == 'produits_presson_nails.php' ? 'active' : ''; ?>" href="produits_presson_nails.php">Press'on Nails</a>
                        <a class="dropdown-item <?php echo $cur_file == 'produits_bijoux.php' ? 'active' : ''; ?>" href="produits_bijoux.php">Bijoux en gel</a>
                        <a class="dropdown-item <?php echo $cur_file == 'produits_whitecare.php' ? 'active' : ''; ?>" href="produits_whitecare.php">Charbon Whitecare</a>
                        <a class="dropdown-item <?php echo $cur_file == 'produits_lady_gum.php' ? 'active' : ''; ?>" href="produits_lady_gum.php">Lady Gum</a>
                        <a class="dropdown-item <?php echo $cur_file == 'produits_cartes.php' ? 'active' : ''; ?>" href="produits_cartes.php">Cartes cadeaux</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
