<?php if ( has_nav_menu( 'primary-menu' ) ) : ?>
    
    <div class="main-header__btn">

        <div class="container-menu ms-h_w">
            <div class="action-menu">
                <div class="menu-text">
                    <span class="menu-text_open"><?php esc_html_e('Menu', 'osty'); ?></span>
                </div>
                <div class="menu-lines">
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                </div>
            </div>
        </div>

        <div class="ms-menu-wrapper">
            <div class="ms-menu">
                <div class="ms-menu-container">
                    <?php if ( has_nav_menu( 'primary-menu' ) ) {  osty_render_menu('button'); } ?>
                </div>
            </div>
        </div>

        <div class="ms-ma-bg"></div>

        <div class="close-menu-bg"></div>

    </div>

<?php endif; ?>