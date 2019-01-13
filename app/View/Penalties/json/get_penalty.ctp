<?php $this->log('modal', 'debug'); ?>
<dl class="dl-horizontal">
    <dt>
        <?php echo __('Player'); ?></dt>
    <dd>
        <?php echo $this->Html->link(h($penalty['Scorecard']['Player']['player_name']), array('controller' => 'Players', 'action' => 'view', $penalty['Scorecard']['Player']['id'])); ?>
    </dd>
    <dt>
        <?php echo __('Type'); ?></dt>
    <dd>
        <?php echo h($penalty['Penalty']['type']); ?>
    </dd>
    <dt>
        <?php echo __('Description'); ?></dt>
    <dd>
        <?php echo h($penalty['Penalty']['description']); ?>
    </dd>
    <dt>
        <?php echo __('Score Value'); ?></dt>
    <dd>
        <?php echo h($penalty['Penalty']['value']); ?>
    </dd>
    <dt>
        <?php echo __('MVP Value'); ?></dt>
    <dd>
        <?php echo h($penalty['Penalty']['mvp_value']); ?>
    </dd>
    <dt>
        <?php echo __('Game'); ?></dt>
    <dd>
        <?php echo $this->Html->link(h($penalty['Scorecard']['Game']['game_name'])." ".h($penalty['Scorecard']['Game']['game_datetime']), array('controller' => 'Games', 'action' => 'view', $penalty['Scorecard']['Game']['id'])); ?>
    </dd>
</dl>
<?php
    if (AuthComponent::user('role') === 'admin' || (AuthComponent::user('role') === 'center_admin' && AuthComponent::user('center') == $penalty['Scorecard']['Game']['center_id'])) {
        echo $this->Html->link("Rescind", array('controller' => 'penalties', 'action' => 'rescind', $penalty['Penalty']['id']), array('class' => 'btn btn-success'));
        echo $this->Html->link("Edit", array('controller' => 'penalties', 'action' => 'edit', $penalty['Penalty']['id']), array('class' => 'btn btn-warning'));
        echo $this->Html->link("Delete", array('controller' => 'penalties', 'action' => 'delete', $penalty['Penalty']['id']), array('class' => 'btn btn-danger'));
    }