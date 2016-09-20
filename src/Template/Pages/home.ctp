<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;



$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Falk Werths Fotografie
    </title>

    <?= $this->Html->css('page/main.css') ?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-55646381-1', 'auto');
	  ga('send', 'pageview');

	</script>
</head>
<body class="is-loading-0 is-loading-1 is-loading-2">

        <!-- Main -->
            <div id="main">

                <!-- Header -->
                    <header id="header">
                        <h1>Falk Werths</h1>
                        <p>Herzlich willkommen! <br /> Für weitere Informationen besuchen Sie <?= $this->Html->link('Home', '/home') ?>, nehmen Sie gerne <?= $this->Html->link('Kontakt', '/home#contact') ?> auf! </p>
                        <ul class="icons">
                            <li>
                                <a href="https://www.facebook.com/pages/Falk-Werths/" class="icon fa-facebook">
                                    <span class="label">Facebook</span>
                                </a>
                            </li>
                            <li>
                                <a href="http://instagram.com/falk_we" class="icon fa-instagram">
                                    <span class="label">Instagram</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.flickr.com/people/123684537@N05/" class="icon fa-flickr">
                                    <span class="label">Flickr</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:info@falk-werths.de" class="icon fa-envelope-o">
                                    <span class="label">Email</span>
                                </a>
                            </li>
                        </ul>
                    </header>

                <!-- Thumbnail -->
                    <section id="thumbnails">

                        <?php foreach ($pictures as $picture): ?>
                            <article>
                                <a class="thumbnail" href="<?=h('img/' . $picture->path) ?>" data-position="left center">
                                <?= $this->Html->image($picture->thumb) ?>
                                </a>
                                <h2><?= h($picture->title) ?></h2>
                                <p><?= h($picture->description) ?></p>
                            </article>
                        <?php endforeach; ?>

                    </section>

                <!-- Footer -->
                <footer id="footer">
                    <ul class="copyright">
                        <li>&copy; Falk Werths.</li><li><?= $this->Html->link('Impressum', '/home#impressum') ?>.</li>
                    </ul>
                </footer>

            </div>

        <!-- Scripts -->
        <?= $this->Html->script('page/jquery.min.js') ?>
        <?= $this->Html->script('page/skel.min.js') ?>
        <?= $this->Html->script('page/main.js') ?>

    </body>

</html>
