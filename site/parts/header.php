<header class="header"><a href="/">
    <picture class="header__logo">
        <img src="/image/logo-horizontal.png" alt="Logo le cuisineur">
    </picture></a>
    <nav class="header__navigation">
        <ul class="header__navlist">
            <li class="header__navelement"><a class="header__navlink" href="/recettes">Recettes</a></li>
            <li class="header__navelement"><a class="header__navlink" href="/membres">Membres</a></li>


            <? if (isset($_SESSION) && key_exists("utilisateur", $_SESSION)) :
                $u = $_SESSION["utilisateur"];
                ?>
                <li class="header__navelement"><a class="header__navlink" href="/profil">Mon profil</a></li>
            <? else : ?>
                <li class="header__navelement"><a class="header__navlink" href="/connexion">Se connecter</a></li>
                <li class="header__navelement"><a class="header__navlink" href="/inscription">S'inscrire</a></li>
            <? endif; ?>

            <?/* 
            <li class="header__navelement"><a href="/backoffice">Espace administrateur</a></li>
            admin */ ?>

        </ul>
    </nav>
</header>