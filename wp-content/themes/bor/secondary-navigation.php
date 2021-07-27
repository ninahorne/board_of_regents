<div class="secondary-navigation">
    <div class="flex-center">
        <div class="contents-inline__md">
            <p class="bold">Get the info you need: </p>
            <?php
            wp_nav_menu(array(
                'theme_location'    => 'extra-menu',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'inline-list__md',
                'menu_class'        => 'secondary-navigation__menu',

            ));
            ?>
        </div>

    </div>