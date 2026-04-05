    </div>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">

            <div class="footer-grid">

                <div class="footer-col footer-brand">
                    <div class="footer-brand-header">
                        <div class="site-logo" aria-hidden="true">E</div>
                        <span class="site-title">ESGI</span>
                    </div>
                    <p>Votre boutique lifestyle & streetwear. Des produits soigneusement sélectionnés pour votre style de vie urbain.</p>
                </div>

                <div class="footer-col">
                    <h4>Boutique</h4>
                    <ul>
                        <?php if (function_exists('wc_get_page_id')): ?>
                        <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">Tous les produits</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('cart'))); ?>">Mon panier</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('checkout'))); ?>">Paiement</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('myaccount'))); ?>">Mon compte</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Informations</h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('blog'))); ?>">Blog</a></li>
                    </ul>
                </div>

            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo esc_html(gmdate('Y')); ?> <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-bottom-link">ESGI</a>. Tous droits réservés.</p>
                <p>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ]);
                    ?>
                </p>
            </div>

        </div>
    </footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
