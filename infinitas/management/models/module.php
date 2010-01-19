<?php
	/**
	 *
	 *
	 */
	class Module extends ManagementAppModel{
		var $name = 'Module';

		var $tablePrefix = 'core_';

		var $actsAs = array(
			'Libs.Ordered' => array(
				'foreign_key' => 'position_id'
			)
		);

		var $order = array(
			'Module.position_id' => 'ASC',
			'Module.ordering' => 'ASC'
		);

		var $belongsTo = array(
			'Position' => array(
				'className' => 'CoreModulePosition',
				'foreignKey' => 'position_id'
			),
			'Core.Management'
		);

		var $hasAndBelongsToMany = array(
			'Route' => array(
				'className' => 'Management.Route',
				'joinTable' => 'core_modules_routes',
				'foreignKey' => 'module_id',
				'associationForeignKey' => 'route_id',
				'unique' => true
			)
		);

		function getModules($position = null){
			if (!$position) {
				return array();
			}

			$positions = $this->find(
				'all',
				array(
					'fields' => array(
						'Module.id',
						'Module.name',
						'Module.content',
						'Module.module',
						'Module.config',
						'Module.show_heading'
					),
					'conditions' => array(
						'Position.name' => $position
					),
					'contain' => array(
						'Position' => array(
							'fields' => array(
								'Position.id',
								'Position.name'
							)
						),
						'Group' => array(
							'fields' => array(
								'Group.id',
								'Group.name'
							)
						),
						'Route' => array(
							'fields' => array(
								'Route.id',
								'Route.name'
							)
						)
					)
				)
			);

			return $positions;
		}
	}
?>