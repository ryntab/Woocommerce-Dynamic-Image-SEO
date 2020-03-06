<?php
if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_style( 'style', '/wp-content/plugins/alt-seo' . '/css/style.css' );

if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'nonce') && current_user_can('administrator') ) {
	unset($_POST['_wpnonce']);
	unset($_POST['_wp_http_referer']);   
    update_option( 'Alt_seo', json_encode($_POST, JSON_NUMERIC_CHECK) );
}

$default_settings = '{"alt":{"enable":1,"force":0,"text":{"1":"[none]","2":"[name]","3":"[none]"}},"title":{"enable":1,"force":1,"text":{"1":"[none]","2":"[name]","3":"[none]"}}}';
if ( !get_option( 'Alt_seo' ) ) {
    update_option( 'Alt_seo', $default_settings );
}

$settings = json_decode( get_option( 'Alt_seo' ), true);

if( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
    $activeAlert = 'Yoast Seo is active. Extra feilds are avaible for use.';
} else if( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) {
    $activeAlert = 'All In One SEO Pack does not allow for product meta editing without extended plugins. For this reason custom feild types are not supported. You can however assign the default feilds.';
    $yoastStatus = 'disabled';
} else if( is_plugin_active( 'seo-by-rank-math/rank-math.php' ) ) {
    $activeAlert = 'Rank Math';
    $yoastStatus = 'disabled';
}
echo '<div class="wrap"><div class="postbox Alt-seo-positive"><strong>' . $activeAlert . "</strong>" . '</div></div>';
?>

<div class="wrap">
    <div id="post-success" class="postbox success Alt-seo-positive hidden">Settings Saved!</div>
</div>
<div class="wrap">
    <div class="postbox">
        <form action="admin.php?page=Alt_seo" method="post" id="Alt_seo_form">
            <div class="wrap">
                <fieldset>
                    <legend><strong>Image Alt attribute settings</strong></legend>
                    <input type="checkbox" class="hidden" name="alt[enable]" value="0" checked>
                    <input type="checkbox" class="hidden" name="alt[force]" value="0" checked>
                    <label>
                        <input id="alt" type="checkbox" name="alt[enable]" value="1" <?php if ($settings['alt']['enable'] === 1) echo "checked";  ?>> Enable automatic alt attributes? (Recomended)
                        <span class="checkmark"></span>
                    </label>
					<br>
                    <div id="toggleAlt" class="hidden">
                        <label>
                            <input type="checkbox" name="alt[force]" value="1" <?php if ($settings['alt']['force'] === 1) echo "checked"; ?>> Force alt attributes?
                            <span class="checkmark"></span>
                        </label>
                        <p>Disabling automatic Alt attributes will disable this plugins dynamic output of Alt tags.</p>
                        <p>Forcing Alt attributes will override any Alt attributes set manually.</p>
                        <br>
                        <label class="text-select">
                            <span>Image Alt Selector: </span>
                            <select name="alt[text][1]">
                                <optgroup label="Special Characters">
                                    <option value="[none]" <?php if ($settings['alt']['text'][1] === '[none]') echo "selected"; ?>>Empty</option>
                                </optgroup>
                                <optgroup label="Product Meta">
                                    <option value="[name]" <?php if ($settings['alt']['text'][1] === '[name]') echo "selected"; ?>>Product Name</option>
                                    <option value="[category]" <?php if ($settings['alt']['text'][1] === '[category]') echo "selected"; ?>>First Category</option>
                                    <option value="[tag]" <?php if ($settings['alt']['text'][1] === '[tag]') echo "selected"; ?>>First Tag</option>
                                    <option value="[postAuthor]" <?php if ($settings['alt']['text'][1] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="[siteUrl]" <?php if ($settings['alt']['text'][1] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                                </optgroup>
                                <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                    <option value="[yoastKeyword]" <?php if ($settings['alt']['text'][1] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                    <option value="[yoastTitle]" <?php if ($settings['alt']['text'][1] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                    <option value="[yoastDesc]" <?php if ($settings['alt']['text'][1] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                                </optgroup>
                            </select>
                            <select name="alt[text][2]">
                                <optgroup label="Special Characters">
                                    <option value="[none]" <?php if ($settings['alt']['text'][2] === '[none]') echo "selected"; ?>>Empty</option>
                                    <option value="[-]" <?php if ($settings['alt']['text'][2] === '[-]') echo "selected"; ?>>- (Hyphen)</option>
                                    <option value="[|]" <?php if ($settings['alt']['text'][2] === '[|]') echo "selected"; ?>>| (Bar)</option>
                                </optgroup>
                                <optgroup label="Product Meta">
                                    <option value="[name]" <?php if ($settings['alt']['text'][2] === '[name]') echo "selected"; ?>>Product Name</option>
                                    <option value="[category]" <?php if ($settings['alt']['text'][2] === '[category]') echo "selected"; ?>>First Category</option>
                                    <option value="[tag]" <?php if ($settings['alt']['text'][2] === '[tag]') echo "selected"; ?>>First Tag</option>
                                    <option value="[postAuthor]" <?php if ($settings['alt']['text'][2] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="[siteUrl]" <?php if ($settings['alt']['text'][2] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                                </optgroup>
                                <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                    <option value="[yoastKeyword]" <?php if ($settings['alt']['text'][2] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                    <option value="[yoastTitle]" <?php if ($settings['alt']['text'][2] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                    <option value="[yoastDesc]" <?php if ($settings['alt']['text'][2] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                                </optgroup>
                            </select>
                            <select name="alt[text][3]">
                                <optgroup label="Special Characters">
                                    <option value="[none]" <?php if ($settings['alt']['text'][3] === '[none]') echo "selected"; ?>>Empty</option>
                                    <option value="[-]" <?php if ($settings['alt']['text'][3] === '[-]') echo "selected"; ?>>- (Hyphen)</option>
                                    <option value="[|]" <?php if ($settings['alt']['text'][3] === '[|]') echo "selected"; ?>>| (Bar)</option>
                                </optgroup>
                                <optgroup label="Product Meta">
                                    <option value="[name]" <?php if ($settings['alt']['text'][3] === '[name]') echo "selected"; ?>>Product Name</option>
                                    <option value="[category]" <?php if ($settings['alt']['text'][3] === '[category]') echo "selected"; ?>>First Category</option>
                                    <option value="[tag]" <?php if ($settings['alt']['text'][3] === '[tag]') echo "selected"; ?>>First Tag</option>
                                    <option value="[postAuthor]" <?php if ($settings['alt']['text'][3] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="[siteUrl]" <?php if ($settings['alt']['text'][3] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                                </optgroup>
                                <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                    <option value="[yoastKeyword]" <?php if ($settings['alt']['text'][3] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                    <option value="[yoastTitle]" <?php if ($settings['alt']['text'][3] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                    <option value="[yoastDesc]" <?php if ($settings['alt']['text'][3] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                                </optgroup>
                            </select>
                            <select name="alt[text][4]">
                                <optgroup label="Special Characters">
                                    <option value="[none]" <?php if ($settings['alt']['text'][4] === '[none]') echo "selected"; ?>>Empty</option>
                                </optgroup>
                                <optgroup label="Product Meta">
                                    <option value="[name]" <?php if ($settings['alt']['text'][4] === '[name]') echo "selected"; ?>>Product Name</option>
                                    <option value="[category]" <?php if ($settings['alt']['text'][4] === '[category]') echo "selected"; ?>>First Category</option>
                                    <option value="[tag]" <?php if ($settings['alt']['text'][4] === '[tag]') echo "selected"; ?>>First Tag</option>
                                    <option value="[postAuthor]" <?php if ($settings['alt']['text'][4] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="[siteUrl]" <?php if ($settings['alt']['text'][4] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                                </optgroup>
                                <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                    <option value="[yoastKeyword]" <?php if ($settings['alt']['text'][4] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                    <option value="[yoastTitle]" <?php if ($settings['alt']['text'][4] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                    <option value="[yoastDesc]" <?php if ($settings['alt']['text'][4] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                                </optgroup>
                            </select>
                        </label>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><strong>Image Title attribute settings</strong></legend>
                    <input type="checkbox" class="hidden" name="title[enable]" value="0" checked>
                    <input type="checkbox" class="hidden" name="title[force]" value="0" checked>
                    <label>
                        <input id="titlecheck" type="checkbox" name="title[enable]" value="1" <?php if ($settings['title']['enable'] === 1) echo "checked"; ?>> Enable automatic title attribute? (Recomended)
                        <span class="checkmark"></span>
                    </label>
					<br>
                    <div id="toggleTitle" class="hidden">
                    <label>
                        <input type="checkbox" name="title[force]" value="1" <?php if ($settings['title']['force'] === 1) echo "checked"; ?>> Force title attribute?
                        <span class="checkmark"></span>
                    </label>
                    <p>Disabling automatic Title attributes will disable this plugins dynamic output of Title tags.</p>
                    <p>Forcing title attributes will override attributes set manually. If you do not force title attributes, any title attributes that are associated with an image in the media library will be preserved. </p>
					<br>
                    <label class="text-select">
						<span>Image Title Selector: </span>
						<select name="title[text][1]">
                            <optgroup label="Special Characters">
                                <option value="[none]" <?php if ($settings['title']['text'][1] === '[none]') echo "selected"; ?>>Empty</option>
                            </optgroup>
                            <optgroup label="Product Meta">
                                <option value="[name]" <?php if ($settings['title']['text'][1] === '[name]') echo "selected"; ?>>Product Name</option>
							    <option value="[category]" <?php if ($settings['title']['text'][1] === '[category]') echo "selected"; ?>>First Category</option>
							    <option value="[tag]" <?php if ($settings['title']['text'][1] === '[tag]') echo "selected"; ?>>First Tag</option>
                                <option value="[postAuthor]" <?php if ($settings['title']['text'][1] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                            </optgroup>
                            <optgroup label="Other">
                                <option value="[siteUrl]" <?php if ($settings['title']['text'][1] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                            </optgroup>
                            <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                <option value="[yoastKeyword]" <?php if ($settings['title']['text'][1] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                <option value="[yoastTitle]" <?php if ($settings['title']['text'][1] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                <option value="[yoastDesc]" <?php if ($settings['title']['text'][1] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                            </optgroup>
                        </select>
						<select name="title[text][2]">
                            <optgroup label="Special Characters">
                                <option value="[none]" <?php if ($settings['title']['text'][2] === '[none]') echo "selected"; ?>>Empty</option>
                                <option value="[-]" <?php if ($settings['title']['text'][2] === '[-]') echo "selected"; ?>>- (Hyphen)</option>
                                <option value="[|]" <?php if ($settings['title']['text'][2] === '[|]') echo "selected"; ?>>| (Bar)</option>
                            </optgroup>
                            <optgroup label="Product Meta">
                                <option value="[name]" <?php if ($settings['title']['text'][2] === '[name]') echo "selected"; ?>>Product Name</option>
							    <option value="[category]" <?php if ($settings['title']['text'][2] === '[category]') echo "selected"; ?>>First Category</option>
							    <option value="[tag]" <?php if ($settings['title']['text'][2] === '[tag]') echo "selected"; ?>>First Tag</option>
                                <option value="[postAuthor]" <?php if ($settings['title']['text'][2] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                            </optgroup>
                            <optgroup label="Other">
                                <option value="[siteUrl]" <?php if ($settings['title']['text'][2] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                            </optgroup>
                            <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                <option value="[yoastKeyword]" <?php if ($settings['title']['text'][2] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                <option value="[yoastTitle]" <?php if ($settings['title']['text'][2] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                <option value="[yoastDesc]" <?php if ($settings['title']['text'][2] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                            </optgroup>
                        </select>
                        <select name="title[text][3]">
                            <optgroup label="Special Characters">
                                <option value="[none]" <?php if ($settings['title']['text'][3] === '[none]') echo "selected"; ?>>Empty</option>
                                <option value="[-]" <?php if ($settings['title']['text'][3] === '[-]') echo "selected"; ?>>- (Hyphen)</option>
                                <option value="[|]" <?php if ($settings['title']['text'][3] === '[|]') echo "selected"; ?>>| (Bar)</option>
                            </optgroup>
                            <optgroup label="Product Meta">
                                <option value="[name]" <?php if ($settings['title']['text'][3] === '[name]') echo "selected"; ?>>Product Name</option>
							    <option value="[category]" <?php if ($settings['title']['text'][3] === '[category]') echo "selected"; ?>>First Category</option>
							    <option value="[tag]" <?php if ($settings['title']['text'][3] === '[tag]') echo "selected"; ?>>First Tag</option>
                                <option value="[postAuthor]" <?php if ($settings['title']['text'][3] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                            </optgroup>
                            <optgroup label="Other">
                                <option value="[siteUrl]" <?php if ($settings['title']['text'][3] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                            </optgroup>
                            <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                <option value="[yoastKeyword]" <?php if ($settings['title']['text'][3] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                <option value="[yoastTitle]" <?php if ($settings['title']['text'][3] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                <option value="[yoastDesc]" <?php if ($settings['title']['text'][3] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                            </optgroup>
                        </select>
                        <select name="title[text][4]">
                            <optgroup label="Special Characters">
                                <option value="[none]" <?php if ($settings['title']['text'][4] === '[none]') echo "selected"; ?>>Empty</option>
                            </optgroup>
                            <optgroup label="Product Meta">
                                <option value="[name]" <?php if ($settings['title']['text'][4] === '[name]') echo "selected"; ?>>Product Name</option>
							    <option value="[category]" <?php if ($settings['title']['text'][4] === '[category]') echo "selected"; ?>>First Category</option>
							    <option value="[tag]" <?php if ($settings['title']['text'][4] === '[tag]') echo "selected"; ?>>First Tag</option>
                                <option value="[postAuthor]" <?php if ($settings['title']['text'][4] === '[postAuthor]') echo "selected"; ?>>Post Author</option>
                            </optgroup>
                            <optgroup label="Other">
                                <option value="[siteUrl]" <?php if ($settings['title']['text'][4] === '[siteUrl]') echo "selected"; ?>>Site Title</option>
                            </optgroup>
                            <optgroup label="Yoast Meta" <?php echo $yoastStatus?>>
                                <option value="[yoastKeyword]" <?php if ($settings['title']['text'][4] === '[yoastKeyword]') echo "selected"; ?>>Yoast Keyword</option>
                                <option value="[yoastTitle]" <?php if ($settings['title']['text'][4] === '[yoastTitle]') echo "selected"; ?>>Yoast Title</option>
                                <option value="[yoastDesc]" <?php if ($settings['title']['text'][4] === '[yoastDesc]') echo "selected"; ?>>Yoast Description</option>
                            </optgroup>
                        </select>
                    </label>
                    </div>
                </fieldset>
            </div>
            <input type="submit" value="Save Settings">
            <input type="button" value="Reset to Default" id="reset-settings">
			<?php wp_nonce_field( 'nonce' ); ?>
        </form>
    </div>
</div>
<div id="success-icon" class="hidden icon">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player 
        src="https://assets6.lottiefiles.com/datafiles/jEgAWaDrrm6qdJx/data.json"  background="transparent"  speed=".8"  style="width: 400px; height: 400px;" autoplay mode>
    </lottie-player>
</div>

<script>
jQuery(document).ready(function() {
    (function($) {
        $(document).ready(function() { 
            $('#alt').change(function(){    
                if($(this).prop("checked")) {
                    $('#toggleAlt').fadeIn('fast');
                } else {
                    $('#toggleAlt').fadeOut('fast');
                }
            });
            $('#titlecheck').change(function(){    
                if($(this).prop("checked")) {
                    $('#toggleTitle').fadeIn('fast');
                } else {
                    $('#toggleTitle').fadeOut('fast');
                }
            });   
        });
        $(document).ready(function() {
            if($('#alt').prop("checked")) {
                $('#toggleAlt').removeClass('hidden');
                $('#toggleAlt').fadeIn('fast');
            } else {
                $('#toggleAlt').fadeOut('fast');
                $('#toggleAlt').addClass('hidden');
            }

            if($('#titlecheck').prop("checked")) {
                $('#toggleTitle').removeClass('hidden');
                $('#toggleTitle').fadeIn('fast');
            } else {
                $('#toggleTitle').fadeOut('fast');
                $('#toggleTitle').addClass('hidden');
            }
        });
    })(jQuery);

    jQuery('#Alt_seo_form').submit(function(e){
        e.preventDefault();
        var data = jQuery(this).serializeArray();

        jQuery.ajax({
                    type: 'POST',
					data: data,
                    beforeSend: function() {
                        jQuery('#Alt_seo_form input').attr('disabled', 'disabled');
                        jQuery('input[type="submit"], input[type="button"]').attr('value', 'Please wait...');
                    },
                    success: function(){
                        jQuery('#Alt_seo_form input').removeAttr('disabled');
                        jQuery('input[type="submit"]').attr('value', 'Save Settings');
						jQuery("#reset-settings").attr('value', 'Reset to Default');
                        jQuery('#post-success').text('Settings Saved!').fadeIn('fast');
                        jQuery('#success-icon').fadeIn('fast');
                        setTimeout(function(){ jQuery('#success-icon').fadeOut('fast'); }, 1500);
                        setTimeout(function(){ jQuery('#post-success, #success-icon').fadeOut('fast'); }, 4000);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
        });
        
    });
    
    jQuery("#reset-settings").click(function() {
		// Prepare the default settings by adding WP NONCE fields
		var defaultSettings = JSON.parse('<?php echo $default_settings; ?>');
		defaultSettings['_wpnonce'] = jQuery('[name="_wpnonce"]').val();
		defaultSettings['_wp_http_referer'] = jQuery('[name="_wp_http_referer"]').val();
        jQuery.ajax({
                    type: 'POST',
                    data: defaultSettings,
                    beforeSend: function() {
                        jQuery('#Alt_seo_form input').attr('disabled', 'disabled');
                        jQuery('input[type="submit"], input[type="button"]').attr('value', 'Please wait...');
                    },
                    success: function(data){
						// Replace the form with the new one
						jQuery("#Alt_seo_form .wrap").html(jQuery("#Alt_seo_form .wrap", data));
                        jQuery('#Alt_seo_form input').removeAttr('disabled');
                        jQuery('input[type="submit"]').attr('value', 'Save Settings');
						jQuery("#reset-settings").attr('value', 'Reset to Default');
                        jQuery('#post-success').text('Default settings applied!').fadeIn('fast');
                        setTimeout(function(){ jQuery('#post-success, #icon-success').fadeOut('fast'); }, 3000);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
        });
    })
});
</script>