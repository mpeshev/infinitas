<?php
	final class MenusEvents extends AppEvents{
		public function onPluginRollCall(){
			return array(
				'name' => 'Menus',
				'description' => 'Build menus for your site',
				'icon' => '/menus/img/icon.png',
				'author' => 'Infinitas'
			);
		}
		
		public function onSetupConfig(){
			return array();
		}

		public function onSetupCache(){
			return array(
				'name' => 'menus',
				'config' => array(
					'prefix' => 'core.menus.'
				)
			);
		}

		public function onAdminMenu(&$event){
			$menu['main'] = array(
				'Menus' => array('controller' => false, 'action' => false),
				'Menu Items' => array('controller' => 'menu_items', 'action' => 'index')
			);

			return $menu;
		}

		public function onRequireHelpersToLoad(&$event){
			return array(
				'Menus.Menu'
			);
		}
	}