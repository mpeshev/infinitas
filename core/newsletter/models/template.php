<?php
/**
	* Comment Template.
	*
	* @todo Implement .this needs to be sorted out.
	*
	* Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	*
	* Licensed under The MIT License
	* Redistributions of files must retain the above copyright notice.
	* @filesource
	* @copyright Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	* @link http://infinitas-cms.org
	* @package sort
	* @subpackage sort.comments
	* @license http://www.opensource.org/licenses/mit-license.php The MIT License
	* @since 0.5a
	*/

	class Template extends NewsletterAppModel {
		var $name = 'Template';

		var $order = array(
			'Template.name' => 'ASC'
		);

		var $validation = array(
			'name' => array(
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => 'A template with that name already exists.'
				)
			)
		);

		var $hasMany = array(
			'Newsletter.Newsletter',
			'Newsletter.Campaign'
		);

		var $belongsTo = array(
			'Locker' => array(
				'className' => 'Management.User',
				'foreignKey' => 'locked_by',
				'conditions' => '',
				'fields' => array(
					'Locker.id',
					'Locker.username'
				),
				'order' => ''
			)
		);

		function getTemplate($data = null){
			if($data){
				$template = $this->find(
					'first',
					array(
						'conditions' => array(
							'or' => array(
								'Template.id' => $data,
								'Template.name' => $data
							)
						)
					)
				);

				if(!empty($template)){
					return $template;
				}
			}

			return $this->find(
				'first',
				array(
					'conditions' => array(
						'Template.name' => Configure::read('Newsletter.template')
					)
				)
			);
		}
	}