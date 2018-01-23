<?php
/**
 * @package Helix Ultimate Framework
 * Template Name - Shaper Helix Ultimate
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$app = JFactory::getApplication();

$helix_path = JPATH_PLUGINS . '/system/helixultimate/core/helixultimate.php';
if (file_exists($helix_path)) {
    require_once($helix_path);
    $theme = new helixUltimate;
} else {
    die('Install and activate <a target="_blank" href="https://www.joomshaper.com/helix">Helix Ultimate Framework</a>.');
}

//Coming Soon
if ($this->params->get('comingsoon_mode'))
{
  header("Location: " . $this->baseUrl . "?tmpl=comingsoon");
}

$scssVars = array(
    'preset' => $this->params->get('preset', 'preset1'),
    'header_height' => $this->params->get('header_height', '60px'),
    'text_color' => $this->params->get('text_color'),
    'bg_color' => $this->params->get('bg_color'),
    'link_color' => $this->params->get('link_color'),
    'link_hover_color' => $this->params->get('link_hover_color'),
    'header_bg_color' => $this->params->get('header_bg_color'),
    'logo_text_color' => $this->params->get('logo_text_color'),
    'menu_text_color' => $this->params->get('menu_text_color'),
    'menu_text_hover_color' => $this->params->get('menu_text_hover_color'),
    'menu_text_active_color' => $this->params->get('menu_text_active_color'),
    'menu_dropdown_bg_color' => $this->params->get('menu_dropdown_bg_color'),
    'menu_dropdown_text_color' => $this->params->get('menu_dropdown_text_color'),
    'menu_dropdown_text_hover_color' => $this->params->get('menu_dropdown_text_hover_color'),
    'menu_dropdown_text_active_color' => $this->params->get('menu_dropdown_text_active_color'),
    'footer_bg_color' => $this->params->get('footer_bg_color'),
    'footer_text_color' => $this->params->get('footer_text_color'),
    'footer_link_color' => $this->params->get('footer_link_color'),
    'footer_link_hover_color' => $this->params->get('footer_link_hover_color'),
    'topbar_bg_color' => $this->params->get('topbar_bg_color'),
    'topbar_text_color' => $this->params->get('topbar_text_color')
);

//Body Background Image
if ($bg_image = $this->params->get('body_bg_image'))
{
    $body_style = 'background-image: url(' . JURI::base(true) . '/' . $bg_image . ');';
    $body_style .= 'background-repeat: ' . $this->params->get('body_bg_repeat') . ';';
    $body_style .= 'background-size: ' . $this->params->get('body_bg_size') . ';';
    $body_style .= 'background-attachment: ' . $this->params->get('body_bg_attachment') . ';';
    $body_style .= 'background-position: ' . $this->params->get('body_bg_position') . ';';
    $body_style = 'body.site {' . $body_style . '}';
    $doc->addStyledeclaration($body_style);
}

//Custom CSS
if ($custom_css = $this->params->get('custom_css'))
{
    $doc->addStyledeclaration($custom_css);
}

//Custom JS
if ($custom_js = $this->params->get('custom_js'))
{
    $doc->addScriptdeclaration($custom_js);
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="canonical" href="<?php echo JUri::current(); ?>">
        <?php

        $theme->head();
        
        $theme->add_css('font-awesome.min.css');
        $theme->add_js('jquery.sticky.js, main.js');

        $theme->add_scss('master', $scssVars, 'template');
        $theme->add_scss('presets', $scssVars, 'presets/' . $this->params->get('preset', 'preset1'));

        //Before Head
        if ($before_head = $this->params->get('before_head'))
        {
            echo $before_head . "\n";
        }
        ?>
    </head>
    <body class="<?php echo $theme->bodyClass(); ?>">
    <?php if($this->params->get('preloader')) : ?>
        <div class="sp-preloader"><div></div></div>
    <?php endif; ?>

    <div class="body-wrapper">
        <div class="body-innerwrapper">
            <?php echo $theme->getHeaderStyle(); ?>
            <?php $theme->render_layout(); ?>
        </div>
    </div>

    <!-- Off Canvas Menu -->
    <div class="offcanvas-overlay"></div>
    <div class="offcanvas-menu">
        <a href="#" class="close-offcanvas"><span class="fa fa-remove"></span></a>
        <div class="offcanvas-inner">
            <?php if ($this->countModules('offcanvas')) : ?>
                <jdoc:include type="modules" name="offcanvas" style="sp_xhtml" />
            <?php else: ?>
                <p class="alert alert-warning">
                    <?php echo JText::_('HELIX_NO_MODULE_OFFCANVAS'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <?php $theme->after_body(); ?>

    <jdoc:include type="modules" name="debug" style="none" />
    
    <!-- Go to top -->
    <?php if ($this->params->get('goto_top', 0)) : ?>
        <a href="#" class="sp-scroll-up"><span class="fa fa-chevron-up"></span></a>
    <?php endif; ?>

    </body>
</html>