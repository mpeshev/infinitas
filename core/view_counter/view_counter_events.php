<?php
	/**
	 * Events for the views behavior
	 * 
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * 
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package Infinitas
	 * @subpackage Infinitas.views.events
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.8
	 * 
	 * @author dogmatic69
	 * 
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	final class ViewCounterEvents extends AppEvents{
		public function onAttachBehaviors(&$event){
			$attach = is_subclass_of($event->Handler, 'Model')
					&& $event->Handler->hasField('views')
					&& !$event->Handler->Behaviors->enabled('ViewCounter.Viewable');
			
			if($attach) {
				$event->Handler->bindModel(
					array(
						'hasMany' => array(
							'ViewCount' => array(
								'className' => 'ViewCounter.ViewCount',
								'foreignKey' => 'foreign_key',
								'conditions' => array(
									'model' => $event->Handler->plugin.'.'.$event->Handler->alias
								),
								'limit' => 0
							)
						)
					)
				);
				
				$event->Handler->ViewCount->bindModel(
					array(
						'belongsTo' => array(
							$event->Handler->alias => array(
								'className' => $event->Handler->alias,
								'foreignKey' => 'foreign_key',
								'counterCache' => 'views',
								'counterScope' => array(
								)
							)
						)
					)
				);

				$event->Handler->Behaviors->attach('ViewCounter.Viewable');
			}
		}

		public function onRequireComponentsToLoad(){
			return array(
				'ViewCounter.ViewCounter'
			);
		}
	}