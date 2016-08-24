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
</head>
<body class="is-loading-0 is-loading-1 is-loading-2">

		<!-- Main -->
			<div id="main">

				<!-- Header -->
					<header id="header">
						<h1>Falk Werths</h1>
						<p>Herzlich willkommen! <br /> Für weitere Informationen besuchen Sie <?= $this->Html->link('Home', '/home') ?>, nehmen Sie gerne <?= $this->Html->link('Kontakt', '/home#contact') ?> auf! </p>
						<ul class="icons">
							<li><a href="http://www.facebook.com/falkwerths" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="http://www.instagram.de/falkwerths" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="http://www.flickr.com/falkwerths" class="icon fa-flickr"><span class="label">Flickr</span></a></li>
							<li><a href="http://mailto:info@falk-werths.de" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
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
