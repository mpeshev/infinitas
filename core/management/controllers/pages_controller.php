<?php
	/**
	 * Static Page Manager
	 *
	 * Creating and maintainig static pages
	 *
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 *
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package management
	 * @subpackage management.controllers.pages
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.7a
	 *
	 * @author dakota
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class PagesController extends ManagementAppController{
		var $name = 'Pages';

		function admin_index(){
			$pages = $this->paginate(null, $this->Filter->filter);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'type',
				'active' => (array)Configure::read('CORE.active_options')
			);

			$path = APP . str_replace(array('/', '\\'), DS, Configure::read('CORE.page_path'));
			$writable = is_writable($path);

			$this->set(compact('pages', 'filterOptions', 'writable', 'path'));
		}

		function admin_add(){
			if (!empty($this->data)){
				$this->data['Page']['file_name'] = low(Inflector::slug($this->data['Page']['name']));

				if ($this->Page->save($this->data)){
					$this->Session->setFlash(__('Your page has been saved.', true));
					$this->redirect(array('action' => 'index'));
				}

				$this->Session->setFlash(__('Your page could not be saved.', true));
			}
		}

		function admin_edit($filename){
			if (!$filename){
				$this->Session->setFlash(__('That page could not be found', true), true);
				$this->redirect($this->referer());
			}

			if (!empty($this->data)){
				if ($this->Page->save($this->data)){
					$this->Session->setFlash(__('Your page has been saved.', true));
					$this->redirect(array('action' => 'index'));
				}

				$this->Session->setFlash(__('Your page could not be saved.', true));
			}

			if ($filename && empty($this->data)){
				$this->data = $this->Page->read(null, $filename);
			}
		}

		function __massGetIds($data) {
			if (in_array($this->__massGetAction($this->params['form']), array('add','filter'))) {
				return null;
			}

			$ids = array();
			foreach($data as $id => $selected) {
				if ($selected) {
					$ids[] = $selected['id'];
				}
			}

			if (empty($ids)) {
				$this->Session->setFlash(__('Nothing was selected, please select something and try again.', true));
				$this->redirect($this->referer());
			}

			return $ids;
		}

		function __massActionDelete($ids) {
			$deleted = true;
			foreach($ids as $id){
				$deleted = $deleted && $this->Page->delete($id);
			}

			if ($delete) {
				$this->Session->setFlash(__('All pages were deleted', true));
			}
			else{
				$this->Session->setFlash(__('Some pages could not be deleted', true));
			}

			$this->redirect($this->referer());
		}
	}