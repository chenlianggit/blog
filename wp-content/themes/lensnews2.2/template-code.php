<?php
/*
Template Name: 代码高亮
*/ 
get_header(); ?>

<!-- 主体内容 -->
<article class="crumbs-normal crumbs_shop">
    <h2>
        <?php the_title(); ?>
    </h2>
    <div class="bg"></div>
</article>
<section class="container wrapper">
    <article class="entry_code box<?php triangle();wow(); ?>">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="content-post">
            <?php the_content(); ?>
        </div>
        <!-- 文章end -->
        <?php endwhile; endif; ?>
        <div class="highlighting">
            <div class="code_li">
                <h3>
                    <?php _e('输入源代码','salong'); ?>
                </h3>
                <textarea title="<?php _e('输入源代码','salong'); ?>" class="php" id="sourceCode" style="width: 100%" name="sourceCode" rows="6"></textarea>
            </div>
            <hr>
            <div class="code_li">
                <h3>
                    <?php _e('代码转换设置','salong'); ?>
                </h3>
                <span class="options"><?php _e('选择程序语言：','salong'); ?>
                    <select onchange="document.getElementById('sourceCode').className=this.value">
                        <option value="php" selected>php</option>
                        <option value="css">css</option>
                        <option value="xml">xml</option>
                        <option value="java">java</option>
                        <option value="sql">sql</option>
                        <option value="jscript">jscript</option>
                        <option value="groovy">groovy</option>
                        <option value="cpp">cpp</option>
                        <option value="c#">c#</option>
                        <option value="python">python</option>
                        <option value="vb">vb</option>
                        <option value="perl">perl</option>
                        <option value="ruby">ruby</option>
                        <option value="delphi">delphi</option>
                    </select>
                </span>
                <span class="options"><?php _e('选项：','salong'); ?>
                    <label for="showGutter">
                        <input id="showGutter" type="checkbox" checked> <?php _e('显示行号','salong'); ?>
                    </label>
                    <label for="firstLine">
                        <input id="firstLine" type="checkbox" checked> <?php _e('起始为1','salong'); ?>
                    </label>
                    <span class="hide_options">
                        <input id=showControls type=checkbox> 工具栏
                        <input id=collapseAll type=checkbox> 折叠
                        <input id=showColumns type=checkbox> 显示列数
                    </span>
                </span>
                <span class="btn">
                    <button onclick=generateCode()><?php _e('转换','salong'); ?></button>
                    <button onclick=clearText()><?php _e('清除','salong'); ?></button>
                </span>
            </div>
            <hr>
            <div class="code_li">
                <h3>
                    <?php _e('HTML 代码生成','salong'); ?>
                </h3>
                <p>
                    <?php _e('将下面代码复制到 WordPress 编辑器中（文本模式下）','salong'); ?>
                </p>
                <textarea id="htmlCode" style="width: 100%" name="htmlCode" rows="6"></textarea>
            </div>
            <hr>
            <div class="code_li">
                <h3>
                    <?php _e('HTML 代码预览','salong'); ?>
                </h3>
                <div id="preview"></div>
            </div>
        </div>
    </article>
</section>
<!-- 主体内容end -->
<?php get_footer(); ?>
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/highlight.js"></script>
