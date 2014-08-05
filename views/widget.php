<div class="magellan-scrollnav show-for-large-up">
    <div data-magellan-expedition="fixed" <?php echo magellan_settings(); ?>>

        <?php magellan_before_toc_widget(); ?>

        <div class="magellan-toc">
            <span class="magellan-title"><?php echo magellan_title(); ?></span>
            <dl class="sub-nav">
                <?php magellan_scroll_nav(); ?>
            </dl>
            <?php magellan_after_toc(); ?>
        </div>

        <?php magellan_after_toc_widget(); ?>

    </div>
</div>