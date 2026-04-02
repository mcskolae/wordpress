<?php
get_header();
?>

<main id="main" class="site-main" style="padding:0;">

    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.6);"><?php esc_html_e('Accueil', 'esgi'); ?></a>
                &rsaquo; <?php esc_html_e('À propos', 'esgi'); ?>
            </p>
            <h1><?php esc_html_e('Notre Histoire', 'esgi'); ?></h1>
        </div>
    </div>

    <section class="section section-alt">
        <div class="container">
            <div class="about-grid">
                <div class="about-image" aria-hidden="true">🏙️</div>
                <div>
                    <h2><?php esc_html_e('Née de la rue, cultivée avec passion', 'esgi'); ?></h2>
                    <p><?php esc_html_e('ESGI est né en 2020 de la passion de trois amis pour la mode urbaine et le streetwear authentique. Notre mission : rendre accessible un style de qualité pour tous les urbains.', 'esgi'); ?></p>
                    <p><?php esc_html_e('Chaque produit est soigneusement sélectionné ou conçu pour répondre aux exigences de style et de durabilité de notre communauté.', 'esgi'); ?></p>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary" style="margin-top:16px;">
                        <?php esc_html_e('Découvrir nos produits', 'esgi'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Nos Valeurs', 'esgi'); ?></h2>
                <p><?php esc_html_e('Ce qui nous guide au quotidien', 'esgi'); ?></p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">♻️</div>
                    <h3><?php esc_html_e('Durabilité', 'esgi'); ?></h3>
                    <p><?php esc_html_e('Nous privilégions des matériaux durables et des pratiques responsables pour réduire notre impact environnemental.', 'esgi'); ?></p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3><?php esc_html_e('Communauté', 'esgi'); ?></h3>
                    <p><?php esc_html_e('Notre communauté est au cœur de tout ce que nous faisons. Vos retours façonnent nos collections.', 'esgi'); ?></p>
                </div>
                <div class="value-card">
                    <div class="value-icon">⭐</div>
                    <h3><?php esc_html_e('Qualité', 'esgi'); ?></h3>
                    <p><?php esc_html_e('Chaque pièce passe par un contrôle qualité rigoureux avant d\'arriver chez vous.', 'esgi'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Notre Équipe', 'esgi'); ?></h2>
                <p><?php esc_html_e('Les personnes derrière ESGI', 'esgi'); ?></p>
            </div>
            <div class="products-grid" style="max-width:900px;margin:0 auto;">
                <?php
                $team = [
                    ['name' => 'Alex Martin', 'role' => 'Co-fondateur & CEO',   'emoji' => '👨‍💼'],
                    ['name' => 'Sara Nguyen',  'role' => 'Directrice Créative',  'emoji' => '👩‍🎨'],
                    ['name' => 'Tom Lefèvre',  'role' => 'Responsable Technique','emoji' => '👨‍💻'],
                ];
                foreach ($team as $member) :
                ?>
                <div class="product-card" style="text-align:center;padding:32px 24px;">
                    <div style="font-size:4rem;margin-bottom:16px;"><?php echo esc_html($member['emoji']); ?></div>
                    <h3><?php echo esc_html($member['name']); ?></h3>
                    <p style="color:var(--color-accent);font-weight:600;font-size:.9rem;margin:0;"><?php echo esc_html($member['role']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
