<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Pictures'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pictures form large-9 medium-8 columns content">
    <?= $this->Form->create($picture, array('type' => 'file')); ?>
    <fieldset>
        <legend><?= __('Add Picture') ?></legend>
        <?php
            echo $this->Form->input('title', array('required'=>true));
            echo $this->Form->input('description');
			echo $this->Form->input('upload', array('type' => 'file', 'required'=>true));
            echo $this->Form->input('tags._ids', ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
