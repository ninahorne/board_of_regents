<div class="secondary-navigation">
    <div class="flex-center">
        <div class="contents-inline__md">
            <p class="bold">Go to: </p>
            <?php
            wp_nav_menu(array(
                'theme_location'    => 'front-page',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'inline-list__md',
                'menu_class'        => 'secondary-navigation__menu',
            ));
            ?>
        </div>

    </div>