<?php
    /**
     * Blog Comments admin index view file.
     *
     * this is the admin index file that displays a list of comments in the
     * admin section of the blog plugin.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://www.dogmatic.co.za
     * @package       blog
     * @subpackage    blog.views.comments.admin_index
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     */
?>
<?php
    echo $this->Blog->adminIndexHead( $this, $paginator );
?>
<div class="table">
    <?php echo $this->Blog->adminTableHeadImages(); ?>
    <?php echo $this->Form->create( 'Comment', array( 'url' => array( 'controller' => 'posts', 'action' => 'mass', 'admin' => 'true' ) ) ); ?>
    <table class="listing" cellpadding="0" cellspacing="0">
        <?php
            echo $this->Blog->adminTableHeader(
                array(
                    $this->Form->checkbox( 'all' ) => array(
                        'class' => 'first',
                        'style' => 'width:25px;'
                    ),
                    $paginator->sort( 'name' ) => array(
                        'style' => '50px;'
                    ),
                    $paginator->sort( 'email' ) => array(
                        'style' => '50px;'
                    ),
                    $paginator->sort( 'website' ) => array(
                        'style' => '50px;'
                    ),
                    $paginator->sort( 'Post', 'Post.title' ) => array(
                        'style' => '50px;'
                    ),
                    $paginator->sort( 'comment' ),
                    $paginator->sort( 'Created' ) => array(
                        'width' => '150px'
                    ),
                    __( 'Status', true ) => array(
                        'class' => 'actions'
                    ),
                    __( 'Actions', true ) => array(
                        'class' => 'last actions'
                    )
                )
            );

            $i = 0;
            foreach( $comments as $comment )
            {
                ?>
                    <tr class="<?php echo $this->Blog->rowClass( $i ); ?>">
                        <td><?php echo $this->Form->checkbox( $comment['Comment']['id'] ); ?>&nbsp;</td>
                        <td><?php echo $comment['Comment']['name']; ?>&nbsp;</td>
                        <td><?php echo $comment['Comment']['email']; ?>&nbsp;</td>
                        <td><?php echo $comment['Comment']['website']; ?>&nbsp;</td>
                        <td><?php echo $this->Html->link( $comment['Post']['title'], array( 'controller' => 'posts', 'action' => 'view', $comment['Post']['slug'], 'admin' => false ), array( 'target' => '_blank' ) ); ?>&nbsp;</td>
                        <td><?php echo htmlspecialchars( $comment['Comment']['comment'] ); ?>&nbsp;</td>
                        <td><?php echo $this->Time->timeAgoInWords( $comment['Comment']['created'] ); ?>&nbsp;</td>
                        <td>
                            <?php
                                echo $this->Status->toggle( $comment['Comment']['active'], $comment['Comment']['id'] );
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $this->Html->link( 'delete', array( 'action' => 'delete', $comment['Comment']['id'] ) );
                            ?>
                        </td>
                    </tr>
                <?
                $i++;
            }
        ?>
    </table>
</div>
<?php echo $this->element( 'pagination/navigation' ); ?>