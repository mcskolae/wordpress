    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">

            <div class="footer-grid">

                <!-- Brand -->
                <div class="footer-col footer-brand">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                        <div class="site-logo" aria-hidden="true">E</div>
                        <span class="site-title" style="font-size:1.1rem;">ESGI</span>
                    </div>
                    <p><?php esc_html_e( 'Votre boutique lifestyle & streetwear. Des produits soigneusement sélectionnés pour votre style de vie urbain.', 'esgi' ); ?></p>
                </div>

                <!-- Boutique -->
                <div class="footer-col">
                    <h4><?php esc_html_e( 'Boutique', 'esgi' ); ?></h4>
                    <ul>
                        <?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Tous les produits', 'esgi' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ); ?>"><?php esc_html_e( 'Mon panier', 'esgi' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ); ?>"><?php esc_html_e( 'Paiement', 'esgi' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Mon compte', 'esgi' ); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Informations -->
                <div class="footer-col">
                    <h4><?php esc_html_e( 'Informations', 'esgi' ); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Accueil', 'esgi' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'a-propos' ) ) ); ?>"><?php esc_html_e( 'À propos', 'esgi' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"><?php esc_html_e( 'Contact', 'esgi' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'blog' ) ) ); ?>"><?php esc_html_e( 'Blog', 'esgi' ); ?></a></li>
                    </ul>
                </div>

            </div><!-- .footer-grid -->

            <div class="footer-bottom">
                <p>
                    &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--color-accent);">ESGI</a>.
                    <?php esc_html_e( 'Tous droits réservés.', 'esgi' ); ?>
                </p>
                <p>
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'footer',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ] );
                    ?>
                </p>
            </div>

        </div><!-- .container -->
    </footer><!-- #colophon -->

</div><!-- #page -->

<script>
(function () {
    const toggle = document.querySelector('.menu-toggle');
    const nav    = document.querySelector('.main-navigation');
    if (!toggle || !nav) return;
    toggle.addEventListener('click', function () {
        const open = nav.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', String(open));
    });
})();
</script>

<?php wp_footer(); ?>

</body>
</html>
