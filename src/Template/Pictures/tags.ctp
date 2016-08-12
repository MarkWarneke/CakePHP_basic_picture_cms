<h1>
	Pictures tagged with
	<?= $this->Text->toList($tags) ?>
</h1>

<section>
<?php foreach ($pictures as $picture): ?>
	<article>
	<!-- use the HtmlHelper -->
	<h4> <?= $this->Html->link($picture->title, $picture->path) ?></h4>
	<small><?= h($picture->path) ?></small>

	<?= $this->Text->autoParagraph($picture->description) ?>
</article>
<?php endforeach; ?>
</section>

