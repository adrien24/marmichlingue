<html lang="en">
<head>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

    <?php wp_head() ?>

    <?php add_styles_and_scripts("main") ?>

</head>
<body>
<header class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggler" data-toggle="open-navbar1">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="<?php 'http://'. $_SERVER['SERVER_NAME'] ?>">
                <h4>Marmichlingue</h4>
            </a>
        </div>
        <div class="navbar-menu" style="display: flex; width: 100%" id="open-navbar1">
            <ul class="navbar-nav">
                <li><a href="/">Récents</a></li>
                <li><a href="/recettes">Recettes</a></li>
                <li><a href="/create-recipe">Créer une recette</a></li>
                <li><a href="/login">Se connecter</a></li>
                <li><a href="/register">S'inscrire</a></li>


            </ul>
            <div class="search-bar" style="margin-left: auto">
                <?php get_search_form() ?>
            </div>
        </div>


    </div>

</header>

<script>

    let dropdowns = document.querySelectorAll('.navbar .dropdown-toggler')
    let dropdownIsOpen = false


    if (dropdowns.length) {

        dropdowns.forEach((dropdown) => {
            dropdown.addEventListener('click', (event) => {
                let target = document.querySelector(`#${event.target.dataset.dropdown}`)

                if (target) {
                    if (target.classList.contains('show')) {
                        target.classList.remove('show')
                        dropdownIsOpen = false
                    } else {
                        target.classList.add('show')
                        dropdownIsOpen = true
                    }
                }
            })
        })
    }


    window.addEventListener('mouseup', (event) => {
        if (dropdownIsOpen) {
            dropdowns.forEach((dropdownButton) => {
                let dropdown = document.querySelector(`#${dropdownButton.dataset.dropdown}`)
                let targetIsDropdown = dropdown == event.target

                if (dropdownButton == event.target) {
                    return
                }

                if ((!targetIsDropdown) && (!dropdown.contains(event.target))) {
                    dropdown.classList.remove('show')
                }
            })
        }
    })


    function handleSmallScreens() {
        document.querySelector('.navbar-toggler')
            .addEventListener('click', () => {
                let navbarMenu = document.querySelector('.navbar-menu')

                if (navbarMenu.style.display === 'flex') {
                    navbarMenu.style.display = 'none'
                    return
                }

                navbarMenu.style.display = 'flex'
            })
    }

    handleSmallScreens()
</script>