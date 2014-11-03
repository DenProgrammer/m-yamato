<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined('_JEXEC') or die('Restricted access');
if (JSite::getMenu()->getActive()->id == 1) {
    header('location: index.php?option=com_content&view=frontpage&Itemid=33');
    exit;
}
$active = 0;
if ($_GET['option'] == 'com_user' || $_GET['option'] == 'com_manager') {
    $active = 2;
} elseif ($_GET['page'] == 'shop.cart') {
    $active = 3;
}
$user = JFactory::getUser();

if (isset($_GET['ajax'])) {
    ?><jdoc:include type="component" /><?php
} else {
    ?>
    <?php echo '<?xml version="1.0" encoding="utf-8"?' . '>'; ?>
    <!DOCTYPE html>
    <html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
        <head>
        <jdoc:include type="head" />
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/jquery.js"></script>
        <script>
            jQuery.noConflict();

            jQuery(document).ready(function($) {

                $('#btndown').click(function() {
                    $("html, body").animate({scrollTop: document.body.scrollHeight}, 1000);
                });
                $('#btnup').click(function() {
                    $("html, body").animate({scrollTop: 0}, 1000);
                });
            });
        </script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/script.js"></script>

        <!------------------------datepicker-------------------------->
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/themes/ui-darkness/jquery.ui.all.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/demos.css">

        <script src="media/system/js/jquery.ui.core.js"></script>
        <script src="media/system/js/jquery.ui.datepicker.js"></script>
        <script src="media/system/js/jquery-ui.custom.js"></script>

        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="width=500px, maximum-scale=0.8, user-scalable=yes" name="viewport" />
    </head>
    <body>
        <style>
            #btndown, #btnup{
                position: absolute;
                right: 0px;
                width: 48px;
                height: 48px;
                cursor: pointer;
            }
            #btndown{
                background-image: url(images/arrow-down.png);
                top: 0px;
            }
            #btnup{
                background-image: url(images/arrow-up.png);
                bottom: 0px;
            }
        </style>
        <div id="btndown"></div>
        <div class="wrapper">
            <div class="head">
                <div style="display: inline-block;width: 200px;">
                    <a href="index.php">
                        <img src="images/logo.png" alt="logo">
                    </a>
                    <a href="http://yamato.kg?route=mobile">Перейти на полную версию</a>
                </div>
                <jdoc:include type="modules" name="m.login" style="xhtml" />
            </div>

            <ul class="toppanel">
                <li id="menupage_4" class="<?php if ($active == 4) echo 'active'; ?>" style="float:right;" ><jdoc:include type="modules" name="m.search" style="xhtml" /></li>
                <li id="menupage_1" class="<?php if ($active == 1) echo 'active'; ?>"><a href="/">Каталоги</a></li>
                <?php if ($user->id > 0) { ?>
                    <li id="menupage_2" class="<?php if ($active == 2) echo 'active'; ?>"><a href="/">Кабинет</a></li>
                <?php } ?>
                <li id="menupage_3" class="<?php if ($active == 3) echo 'active'; ?>"><a href="index.php?page=shop.cart&option=com_virtuemart&Itemid=3">Корзина</a></li>
            </ul>

            <div class="topmenu">
                <div class="menupage menupage_1 <?php if ($active == 1) echo 'menupage_active'; ?>" >
                    <jdoc:include type="modules" name="m.menu" />
                </div>
                <div class="menupage menupage_2 <?php if ($active == 2) echo 'menupage_active'; ?>" >
                    <jdoc:include type="modules" name="m.kabinet" />
                </div>	
                <div class="menupage menupage_3 <?php if ($active == 3) echo 'menupage_active'; ?>" >
                </div>	
                <div class="menupage menupage_4 <?php if ($active == 4) echo 'menupage_active'; ?>" >
                    <jdoc:include type="modules" name="m.search" style="xhtml" />
                </div>			
            </div>
            <div class="content">
                <?php if (!isset($_GET['product_id'])) { ?>
                    <jdoc:include type="modules" name="m.top" style="xhtml" />
                <?php } ?>
                <jdoc:include type="modules" name="user5" style="xhtml" />
                <jdoc:include type="component" />
                <jdoc:include type="modules" name="m.bottom" style="xhtml" />
            </div>
            <div class="footer">
                <jdoc:include type="modules" name="user3" style="xhtml" />
            </div>
            <div style="position: relative">
                <div id="btnup"></div>
            </div>
    </body>
    </html>
<?php
} 