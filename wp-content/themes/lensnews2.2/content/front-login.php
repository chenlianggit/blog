<!--前台登录-->
<?php global $salong; ?>
<?php if ( class_exists( 'XH_Social' ) && !is_user_logged_in() ){ ?>
<a id="login" class="overlay" href="#ln"></a>
<section class="front_login popup">
    <section class="login_main">
        <?php echo do_shortcode($salong['login_shortcode']); ?>
        <section class="login_reg">
            <a href="<?php echo wp_registration_url(); ?>" title="<?php _e('注册一个新的帐户','salong'); ?>">
                <?php _e('注册','salong'); ?>
            </a>｜
            <a href="<?php echo wp_lostpassword_url(); ?>" title="<?php _e('忘记密码','salong'); ?>">
                <?php _e('忘记密码','salong'); ?>
            </a>
        </section>
    </section>
</section>
<?php } ?>
