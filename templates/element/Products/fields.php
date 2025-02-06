<div class="column column-80">
    <div class="products form content">
        <?= $this->Form->create($product) ?>
        <fieldset>
            <legend><?= __('Add Product') ?></legend>
            <?php
            echo $this->Form->control('name');
            echo $this->Form->control('quantity');
            echo $this->Form->control('price');
            echo $this->Form->control('status');
            echo $this->Form->control('deleted');
            echo $this->Form->control('last_updated');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>