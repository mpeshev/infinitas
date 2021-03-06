<?php
    /**
     * Comment Template.
     *
     * @todo -c Implement .this needs to be sorted out.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       sort
     * @subpackage    sort.comments
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     * @since         0.5a
     */

    echo $this->Form->create('Module', array('url' => array('controller' => 'modules', 'action' => 'mass', 'admin' => 'true')));
        $massActions = $this->Core->massActionButtons(
            array(
                'add',
                'edit',
                'copy',
                'move',
                'toggle',
                'delete'
            )
        );
        echo $this->Core->adminIndexHead($this, $filterOptions, $massActions);
?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
        <?php
            echo $this->Core->adminTableHeader(
                array(
                    $this->Form->checkbox('all') => array(
                        'class' => 'first',
                        'style' => 'width:25px;'
                    ),
                    $this->Paginator->sort('name'),
                    $this->Paginator->sort('Theme', 'Theme.name'),
                    $this->Paginator->sort('plugin'),
                    $this->Paginator->sort('Position', 'Position.name'),
                    $this->Paginator->sort('author'),
                    $this->Paginator->sort('licence') => array(
                        'style' => 'width:90px;'
                    ),
                    $this->Paginator->sort('Display to', 'Group.name') => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('Locked') => array(
                        'style' => 'width:50px;'
                    ),
                    $this->Paginator->sort('Order') => array(
                        'style' => 'width:50px;'
                    ),
                    $this->Paginator->sort('core') => array(
                        'style' => 'width:50px;'
                    ),
                    $this->Paginator->sort('Status', 'active') => array(
                        'style' => 'width:50px;'
                    )
                )
            );

            $i = 0;
            foreach ($modules as $module){
                ?>
                	<tr class="<?php echo $this->Core->rowClass(); ?>">
                        <td><?php echo $this->Form->checkbox($module['Module']['id']); ?>&nbsp;</td>
                		<td>
                			<?php echo $this->Html->link(Inflector::humanize($module['Module']['name']), array('action' => 'edit', $module['Module']['id'])); ?>&nbsp;
                		</td>
                		<td>
                			<?php
	                			if (!empty($module['Theme']['name'])) {
	                				echo $module['Theme']['name'];
	                			}
	                			else{
			                		echo __('Any', true);
                				}
							?>&nbsp;
                		</td>
                		<td>
                			<?php
                				if(!empty($module['Module']['plugin'])){
                					echo Inflector::humanize($module['Module']['plugin']);
                				}
                				else{
                					echo __('Global', true);
                				}
                			?>&nbsp;
                		</td>
                		<td>
                			<?php echo Inflector::humanize($module['Position']['name']); ?>&nbsp;
                		</td>
                		<td>
                			<?php
                				if (!empty($module['Module']['url'])) {
                					echo $this->Html->link($module['Module']['author'], $module['Module']['url'], array('target' => '_blank'));
                				}
                				else{
									echo $module['Module']['author'];
								}
							?>&nbsp;
                		</td>
                		<td>
                			<?php echo $module['Module']['licence']; ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $module['Group']['name']; ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $this->Infinitas->locked($module['Module']['locked']); ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $this->Core->ordering($module['Module']['id'], $module['Module']['ordering'], 'Modules.Module'); ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $this->Infinitas->status($module['Module']['core']); ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $this->Infinitas->status($module['Module']['active']); ?>&nbsp;
                		</td>
                	</tr>
                <?php
            }
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('admin/pagination/navigation'); ?>