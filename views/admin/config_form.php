<div class="field">
    <div id="ehri_shortcode_config_form" class="two columns alpha">
        <label for="ehri_shortcode_uri_configuration" class="required"><?php echo __('API Base URL'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('The base URL of the EHRI Search API'); ?></p>
        <?php echo get_view()->formText('ehri_shortcode_uri_configuration',
            get_option('ehri_shortcode_uri_configuration', EhriDataPlugin::DEFAULT_API_BASE)); ?>
    </div>
</div>
