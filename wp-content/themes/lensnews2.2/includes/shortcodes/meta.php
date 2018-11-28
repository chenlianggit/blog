<div class="shortcodes_control">
    <p>
        <?php _e( '如果你想要使用简码请选择简码选项：', 'salong'); ?>
    </p>
    <div>
        <label>
            <?php _e( '选择简码', 'salong'); ?><span></span></label>
        <select name="items" class="shortcode_sel" size="1" onchange="document.forms.post.items_accumulated.value = this.options[selectedIndex].value;">

            <option class="parentscat">
                <?php _e( '1.标题', 'salong'); ?>
            </option>
            <option value="<h2 class=&quot;icon-logo&quot;><?php _e('二级标题','salong'); ?></h2>">
                <?php _e( '二级标题', 'salong'); ?>
            </option>
            <option value="<h3 class=&quot;icon-coffee&quot;><?php _e('二级标题','salong'); ?></h3>">
                <?php _e( '三级标题', 'salong'); ?>
            </option>
            <option value="<h4 class=&quot;icon-ajust&quot;><?php _e('二级标题','salong'); ?></h4>">
                <?php _e( '四级标题', 'salong'); ?>
            </option>
            <option value="<h5 class=&quot;icon-cloud&quot;><?php _e('二级标题','salong'); ?></h5>">
                <?php _e( '五级标题', 'salong'); ?>
            </option>

            <option class="parentscat">
                <?php _e( '2.消息框简码', 'salong'); ?>
            </option>
            <option value="[infobox]<?php _e('远方的雪山','salong'); ?>[/infobox]">
                <?php _e( '信息框', 'salong'); ?>
            </option>
            <option value="[successbox]<?php _e('远方的雪山','salong'); ?>[/successbox]">
                <?php _e( '成功框', 'salong'); ?>
            </option>
            <option value="[warningbox]<?php _e('远方的雪山','salong'); ?>[/warningbox]">
                <?php _e( '警告框', 'salong'); ?>
            </option>
            <option value="[errorbox]<?php _e('远方的雪山','salong'); ?>[/errorbox]">
                <?php _e( '错误框', 'salong'); ?>
            </option>

            <option class="parentscat">3.按钮简码
                <?php _e( '简码', 'salong'); ?>
            </option>
            <option value="[scbutton link=&quot;#&quot; target=&quot;blank&quot; variation=&quot;red&quot;]<?php _e('远方的雪山','salong'); ?>[/scbutton]">
                <?php _e( '红色', 'salong'); ?>
            </option>
            <option value="[scbutton link=&quot;#&quot; target=&quot;blank&quot; variation=&quot;yellow&quot;]<?php _e('远方的雪山','salong'); ?>[/scbutton]">
                <?php _e( '黄色', 'salong'); ?>
            </option>
            <option value="[scbutton link=&quot;#&quot; target=&quot;blank&quot; variation=&quot;blue&quot;]<?php _e('远方的雪山','salong'); ?>[/scbutton]">
                <?php _e( '蓝色', 'salong'); ?>
            </option>
            <option value="[scbutton link=&quot;#&quot; target=&quot;blank&quot; variation=&quot;green&quot;]<?php _e('远方的雪山','salong'); ?>[/scbutton]">
                <?php _e( '绿色', 'salong'); ?>
            </option>

            <option class="parentscat">
                <?php _e( '4.列表简码', 'salong'); ?>
            </option>
            <option value="[ssredlist]<ul> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> </ul>[/ssredlist]">
                <?php _e( '小红点', 'salong'); ?>
            </option>
            <option value="[ssyellowlist]<ul> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> </ul>[/ssyellowlist]">
                <?php _e( '小黄点', 'salong'); ?>
            </option>
            <option value="[ssbluelist]<ul> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> </ul>[/ssbluelist]">
                <?php _e( '小蓝点', 'salong'); ?>
            </option>
            <option value="[ssgreenlist]<ul> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> <li><?php _e('远方的雪山','salong'); ?></li> </ul>[/ssgreenlist]">
                <?php _e( '小绿点', 'salong'); ?>
            </option>

            <option class="parentscat">
                <?php _e( '5.其它简码', 'salong'); ?>
            </option>
            <option value="[swf]<?php _e('flash地址','salong'); ?>[/swf]]">
                <?php _e( 'flash', 'salong'); ?>
            </option>
            <option value="[tabgroup][tab title=&quot;<?php _e('标题','salong'); ?> 1&quot; id=&quot;1&quot;]<?php _e('内容','salong'); ?> 1[/tab][tab title=&quot;<?php _e('标题','salong'); ?> 2&quot; id=&quot;2&quot;]<?php _e('内容','salong'); ?> 2[/tab] [tab title=&quot;<?php _e('标题','salong'); ?> 3&quot; id=&quot;3&quot;]<?php _e('内容','salong'); ?> 3[/tab] [tab title=&quot;<?php _e('标题','salong'); ?> 4&quot; id=&quot;4&quot;]<?php _e('内容','salong'); ?> 4[/tab][/tabgroup]">TABS</option>
            <option value="[toggle_box][toggle_item title=&quot;<?php _e('标题','salong'); ?> 1&quot; active=&quot;true&quot;]<?php _e('内容','salong'); ?> 1[/toggle_item][toggle_item title=&quot;<?php _e('标题','salong'); ?> 2&quot;]<?php _e('内容','salong'); ?> 2[/toggle_item][toggle_item title=&quot;<?php _e('标题','salong'); ?> 3&quot;]<?php _e('内容','salong'); ?> 3[/toggle_item][toggle_item title=&quot;<?php _e('标题','salong'); ?> 4&quot;]<?php _e('内容','salong'); ?> 4[/toggle_item][/toggle_box]">
                <?php _e( '开关菜单', 'salong'); ?>
            </option>
            <option value="[related_posts tagid=&quot;5&quot;]">
                <?php _e( '标签相关文章', 'salong'); ?>
            </option>
            <option value="[reply]评论后可见内容[/reply]">
                <?php _e( '评论后可见内容', 'salong'); ?>
            </option>
            <option value="[private]只有用户才能看到的内容[/private]">
                <?php _e( '用户查看的内容', 'salong'); ?>
            </option>
            <option value="[buy product_id=&quot;<?php _e('产品 ID','salong'); ?>&quot;]<?php _e('购买产品才能查看的内容','salong'); ?>[/buy]">
                <?php _e( '购买产品才能查看的内容', 'salong'); ?>
            </option>

        </select>
        <label>
            <?php _e( '简码预览', 'salong'); ?><span><?php _e('简(在编辑框中复制简码)码','salong'); ?></span></label>
        <p>
            <textarea name="items_accumulated" rows="4"></textarea>
        </p>
    </div>
</div>