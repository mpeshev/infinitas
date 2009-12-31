<?php
    echo $this->Core->adminIndexHead( $this, $paginator );
?>
<div class="table">
    <?php echo $this->Core->adminTableHeadImages(); ?>
    <?php echo $this->Form->create( 'Config', array( 'url' => array( 'controller' => 'configs', 'action' => 'mass', 'admin' => 'true' ) ) ); ?>
    <table class="listing" cellpadding="0" cellspacing="0">
        <?php
            echo $this->Core->adminTableHeader(
                array(
                    $this->Form->checkbox( 'all' ) => array(
                        'class' => 'first',
                        'style' => 'width:25px;'
                    ),
                    $this->Paginator->sort( 'key' ),
                    $this->Paginator->sort( 'value' ) => array(
                        'style' => 'width:50px;'
                    ),
                    $this->Paginator->sort( 'type' ) => array(
                        'style' => 'width:50px;'
                    ),
                    $this->Paginator->sort( 'options' ) => array(
                        'style' => 'width:100px;'
                    ),
                    __( 'Description', true ),
                    __( 'Core', true ) => array(
                        'style' => 'width:50px;'
                    ),
                    __( 'Actions', true ) => array(
                        'style' => 'width:100px;'
                    )
                )
            );

            $i = 0;
            foreach ( $configs as $config )
            {
                ?>
                	<tr class="<?php echo $this->Core->rowClass( $i ); ?>">
                        <td><?php echo $this->Form->checkbox( $config['Config']['id'] ); ?>&nbsp;</td>
                		<td>
                			<?php echo $this->Html->link( $config['Config']['key'], array('controller' => 'configs', 'action' => 'edit', $config['Config']['id'])); ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $config['Config']['value']; ?>&nbsp;
                		</td>
                		<td>
                			<?php echo Inflector::humanize( $config['Config']['type'] ); ?>&nbsp;
                		</td>
                		<td>
                			<?php
                			    if ( !empty( $config['Config']['options'] ) )
                			    {
                			        echo $this->Text->toList( explode( ',', Inflector::humanize( $config['Config']['options'] ) ), 'or' );
                			    }
                			?>&nbsp;
                		</td>
                		<td>
                			<?php echo $config['Config']['description']; ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $this->Status->status( $config['Config']['core'] ); ?>&nbsp;
                		</td>
                		<td class="actions">
                			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $config['Config']['id'])); ?>
                			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $config['Config']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $config['Config']['id'])); ?>
                		</td>
                	</tr>
                <?php
            }
        ?>
    </table>
    <?php
        echo $this->Form->button( __( 'Delete', true ), array( 'value' => 'delete', 'name' => 'delete' ) );
        echo $this->Form->button( __( 'Toggle', true ), array( 'value' => 'toggle' ) );
        echo $this->Form->end();

    ?>
</div>
<?php echo $this->element( 'pagination/navigation' ); ?>