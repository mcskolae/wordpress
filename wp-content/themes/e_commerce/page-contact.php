<?php
get_header();

$sent   = false;
$errors = [];

if (isset($_POST['contact_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['contact_nonce'])), 'esgi_contact')) {
    $name    = sanitize_text_field(wp_unslash($_POST['contact_name'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['contact_email'] ?? ''));
    $subject = sanitize_text_field(wp_unslash($_POST['contact_subject'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['contact_message'] ?? ''));

    if (empty($name))    { $errors[] = __('Le nom est requis.', 'esgi'); }
    if (!is_email($email)) { $errors[] = __('Email invalide.', 'esgi'); }
    if (empty($message)) { $errors[] = __('Le message est requis.', 'esgi'); }

    if (empty($errors)) {
        $to      = get_option('admin_email');
        $subject = sprintf('[ESGI] %s', $subject ?: __('Nouveau message de contact', 'esgi'));
        $body    = sprintf("Nom : %s\nEmail : %s\n\nMessage :\n%s", $name, $email, $message);
        $headers = ['Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $email];

        wp_mail($to, $subject, $body, $headers);
        $sent = true;
    }
}
?>

<main id="main" class="site-main" style="padding:0;">

    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.6);"><?php esc_html_e('Accueil', 'esgi'); ?></a>
                &rsaquo; <?php esc_html_e('Contact', 'esgi'); ?>
            </p>
            <h1><?php esc_html_e('Contactez-nous', 'esgi'); ?></h1>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="contact-grid">

                <div class="contact-info-card">
                    <h2><?php esc_html_e('On est là pour vous', 'esgi'); ?></h2>
                    <p style="opacity:.75;margin-bottom:32px;"><?php esc_html_e('Une question, une réclamation, un partenariat ? Notre équipe répond sous 24h.', 'esgi'); ?></p>

                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <h4 style="color:#fff;margin-bottom:4px;"><?php esc_html_e('Adresse', 'esgi'); ?></h4>
                            <p style="opacity:.75;margin:0;">12 Rue du Commerce<br>75015 Paris, France</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <h4 style="color:#fff;margin-bottom:4px;"><?php esc_html_e('Téléphone', 'esgi'); ?></h4>
                            <p style="opacity:.75;margin:0;">+33 1 23 45 67 89</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <h4 style="color:#fff;margin-bottom:4px;"><?php esc_html_e('Email', 'esgi'); ?></h4>
                            <p style="opacity:.75;margin:0;">contact@urbanshop.fr</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">🕒</div>
                        <div>
                            <h4 style="color:#fff;margin-bottom:4px;"><?php esc_html_e('Horaires', 'esgi'); ?></h4>
                            <p style="opacity:.75;margin:0;"><?php esc_html_e('Lun–Ven : 9h–18h', 'esgi'); ?><br><?php esc_html_e('Sam : 10h–16h', 'esgi'); ?></p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <?php if ($sent) : ?>
                        <div style="background:#f0fdf4;border:2px solid #22c55e;border-radius:var(--radius);padding:20px;margin-bottom:24px;">
                            <p style="color:#16a34a;font-weight:600;margin:0;">✅ <?php esc_html_e('Message envoyé ! Nous vous répondrons bientôt.', 'esgi'); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)) : ?>
                        <div style="background:#fef2f2;border:2px solid #ef4444;border-radius:var(--radius);padding:20px;margin-bottom:24px;">
                            <?php foreach ($errors as $err) : ?>
                                <p style="color:#dc2626;margin:4px 0;">⚠ <?php echo esc_html($err); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <h2 style="margin-bottom:24px;"><?php esc_html_e('Envoyer un message', 'esgi'); ?></h2>

                    <form method="post" novalidate>
                        <?php wp_nonce_field('esgi_contact', 'contact_nonce'); ?>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div class="form-group">
                                <label for="contact_name"><?php esc_html_e('Nom *', 'esgi'); ?></label>
                                <input type="text" id="contact_name" name="contact_name" required value="<?php echo esc_attr($_POST['contact_name'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact_email"><?php esc_html_e('Email *', 'esgi'); ?></label>
                                <input type="email" id="contact_email" name="contact_email" required value="<?php echo esc_attr($_POST['contact_email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_subject"><?php esc_html_e('Sujet', 'esgi'); ?></label>
                            <input type="text" id="contact_subject" name="contact_subject" value="<?php echo esc_attr($_POST['contact_subject'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="contact_message"><?php esc_html_e('Message *', 'esgi'); ?></label>
                            <textarea id="contact_message" name="contact_message" required><?php echo esc_textarea($_POST['contact_message'] ?? ''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                            <?php esc_html_e('Envoyer le message', 'esgi'); ?>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
