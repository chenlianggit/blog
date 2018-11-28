<?php global $salong; ?>

<section class="slide-main slide-home">
    <div class="swiper-container swiper-home">
        <div class="swiper-wrapper">
            <?php if ($salong[ 'slides_home_list']): ?>
            <?php foreach ($salong[ 'slides_home_list'] as $value): ?>
            <article class="swiper-slide slide-single">
                <a href="<?php echo $value['url']; ?>" class="swiper-image" style="background-image: url(<?php echo $value['image']; ?>);">
                    <?php if ($value[ 'description']): ?>
                    <div class="swiper-post">
                        <h3><?php echo $value['title']; ?></h3>
                        <!-- 摘要 -->
                        <p class="description">
                            <?php echo $value[ 'description']; ?>
                        </p>
                        <!-- 摘要end -->
                    </div>
                    <?php endif ?>
                </a>
            </article>
            <?php endforeach ?>
            <?php endif ?>
        </div>
        <!-- 导航 -->
        <div class="swiper-pagination swiper-home-pagination"></div>
        <!-- 按钮 -->
        <div class="swiper-button swiper-home-button-next swiper-button-next icon-angle-right"></div>
        <div class="swiper-button swiper-home-button-prev swiper-button-prev icon-angle-left"></div>
    </div>
    <script type="text/javascript">
        //首页幻灯片
        var swiper = new Swiper('.swiper-home', {
            pagination: '.swiper-home-pagination',
            nextButton: '.swiper-home-button-next',
            prevButton: '.swiper-home-button-prev',
            paginationClickable: true,
            centeredSlides: true,
            autoplay: 5000,
            autoplayDisableOnInteraction: false,
            lazyLoading: true,
            keyboardControl: true,
            <?php if($salong['slides_home_effect'] == 'slide'){ ?>
            effect: 'slide',
            <?php }else{ ?>
            effect: 'fade',
            <?php } if($salong['slides_home_loop']){ ?>
            loop: true,
            <?php }else{ ?>
            loop: false
            <?php } ?>
        });
    </script>
</section>