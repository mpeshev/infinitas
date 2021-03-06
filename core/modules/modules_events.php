<?php
	final class ModulesEvents extends AppEvents{
		public function onPluginRollCall(){
			return array(
				'name' => 'Modules',
				'description' => 'Add sections of output to your site with ease',
				'icon' => '/modules/img/icon.png',
				'author' => 'Infinitas'
			);
		}
		
		public function onSetupConfig(){
		}

		public function onSetupCache(){
			return array(
				'name' => 'modules',
				'config' => array(
					'prefix' => 'core.modules.'
				)
			);
		}

		public function onAdminMenu(&$event){
			$menu['main'] = array(
				'Modules' => array('controller' => false, 'action' => false),
				'Module Positions' => array('controller' => 'module_positions', 'action' => 'index')
			);

			return $menu;
		}

		public function onRequireHelpersToLoad(&$event){
			return array(
				'Modules.ModuleLoader'
			);
		}
	}