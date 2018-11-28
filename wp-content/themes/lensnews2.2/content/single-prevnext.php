<?php global $salong; ?>
<section class="prevnext<?php if ( 'post' == get_post_type() ){ ?> box<?php triangle();wow(); ?><?php } ?>">
    <div class="prev">
        <?php previous_post_link( '%link') ?>
    </div>
    <div class="next">
        <?php next_post_link( '%link') ?>
    </div>
</section>