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

	class AppHelper extends Helper {
		var $rowClassCounter = 0;

		var $paginationCounterFormat = 'Page %page% of %pages%.';

		var $errors = array();

		var $wysiwyg = 'fck';

		var $helpers = array(
			'Html', 'Form',
			//'Libs.Design',
			'Libs.Wysiwyg',
			//'Libs.Gravatar'
		);

		/**
		* create some bread crumbs.
		*
		* Creates some bread crumbs.
		*
		* @todo -c"AppHelper" Implement AppHelper.
		* - generate some links
		* @param array $here is $this from the view.
		*/
		function breadcrumbs($view = array(), $seperator = ' :: ') {
			if (empty($view)) {
				return false;
			}

			$_prefix = isset($view->params['prefix']) ? (string)$view->params['prefix'] : false;

			$breadcrumbs = array(
				$this->Html->link(
					__(strtolower(prettyName($view->plugin)), true),
					array(
						'prefix' => $_prefix,
						'plugin' => $view->plugin,
						'controller' => false,
						'action' => false
					)
				),
				$this->Html->link(
					__(strtolower(prettyName($view->name)), true),
					array(
						'prefix' => $_prefix,
						'plugin' => $view->plugin,
						'controller' => Inflector::underscore($view->name),
						'action' => false
					)
				),
				strstr($view->action, 'mass') === false ? str_replace('admin_', '', $view->action) : $view->params['form']['action']
			);

			if ($_prefix !== false) {
				$breadcrumbs = array_merge(
					(array)$this->Html->link(
						__($_prefix, true),
						'/'.$_prefix
					),
					$breadcrumbs
				);
			}

			return implode($seperator, $breadcrumbs);
		}

		/**
		* switch the class for table rows
		*
		* @param integer $i the number of the row
		* @param string $class1 class 1 highlight
		* @param string $class2 class 2 highlight
		* @return string the class
		*/
		function rowClass($class1 = 'bg', $class2 = '') {
			return (($this->rowClassCounter++ % 2) ? $class1 : $class2);
		}

		function adminPageHead($view) {
			if (empty($view)) {
				return false;
			}

			$plugin = (strtolower($this->plugin) != 'management') ? $this->plugin : '';
			return '<h1>' . sprintf(__('%s %s Manager', true), prettyName($plugin), prettyName($view->name)) . '<small>' . $this->breadcrumbs($view) . '</small></h1>';
		}

		/**
		* creates table headers for admin.
		*
		* if the format is just array( 'head1', 'head2' ... ) it will output a
		* normal table with TH that have no classes/styles applied.  you can
		* also pass things like array ( 'head1' => array( 'class' => 'something' ) )
		* to get out put like <th class="something">head1</th>
		*
		* @param array $data an array of items for the head.
		* @param bool $footer if you want to show the table footer or not.
		*
		* @return string the thead and tfoot html
		*/
		function adminTableHeader($data, $footer = true) {
			$out = '';
			foreach($data as $field => $params) {
				$atributes = '';

				if (is_int($field) && !is_array($params)) {
					$field = $params;
					$params = '';
				}

				else {
					foreach($params as $type => $param) {
						$atributes = '';
						$atributes .= $type . '="' . $param . '" ';
					}

					$atributes .= $atributes;
				}

				if ($atributes != '') {
					$params = $atributes;
				}

				$out .= '<th ' . $params . '>' . $field . '</th>';
			}
			return '<thead>'.$out.'<thead>'. (($footer) ? '<tfoot>'.$out.'</tfoot>' : '');
		}

		function adminIndexHead($view = array(), $filterOptions = array(), $massActions = null) {
			if (empty($view)) {
				$this->errors[] = 'I need the view.';
				return false;
			}

			if(!class_exists('FilterHelper')){
				App::import('Helper', 'FilterHelper');
			}

			$filters = $this->Design->niceBox(
				'filter',
				FilterHelper::form('Post', $filterOptions) . FilterHelper::clear($filterOptions)
			);

			return $this->Design->niceBox('adminTopBar', $this->adminPageHead($view) . $massActions) . $filters;
		}

		function adminOtherHead($view = array(), $massActions = null) {
				if (empty($view)) {
					$this->errors[] = 'I need the view.';
					return false;
				}

				return $this->niceBox('adminTopBar', $this->adminPageHead($view) . $massActions);
		}

		function adminEditHead($view, $actions = array('save', 'cancel')){
	        $massActions = $this->massActionButtons(
	            $actions
	        );

	        return $this->adminOtherHead($view, $massActions);
		}

		function ordering($id = null, $currentPosition = null, $modelName = null, $results = null) {
			if (!$id) {
				$this->errors[] = 'How will i know what to move?';
			}

			if (!$currentPosition) {
				$this->errors[] = 'The new order was not passed';
			}

			if($results != null && $modelName) {
				$maxPosition = max(Set::extract('/' . $modelName . '/ordering', $results));
			}

			$out = '';

			if ($currentPosition > 1) {
				$out .= $this->Html->link(
					$this->Html->image(
						$this->Image->getRelativePath('actions', 'arrow-up'),
						array(
							'alt' => __('Up', true),
							'title' => __('Move up', true),
							'width' => '16px',
							'class' => 'arrow-up'
						)
					),
					array(
						'action' => 'reorder',
						'position' => $currentPosition - 1,
						$id
					),
					array(
						'escape' => false,
					)
				);
			}

			if($results == null || $currentPosition < $maxPosition) {
				$out .= $this->Html->link($this->Html->image($this->Image->getRelativePath('actions', 'arrow-down'),
						array(
							'alt' => __('Down', true),
							'title' => __('Move down', true),
							'width' => '16px',
							'class' => 'arrow-down'
						)
					),
					array(
						'action' => 'reorder',
						'position' => $currentPosition + 1,
						$id
					),
					array(
						'escape' => false,
					)
				);
			}

			return $out;
		}

		function treeOrdering($data = null){
			if (!$data) {
				$this->errors[] = 'There is no data to build reorder links';
				return false;
			}


			$out = $this->Html->link(
				$this->Html->image(
					$this->Image->getRelativePath('actions', 'arrow-up'),
					array(
						'alt' => __('Up', true),
						'title' => __('Move up', true),
						'width' => '16px',
						'class' => 'arrow-up'
					)
				),
				array(
					'action' => 'reorder',
					'direction' => 'up',
					$data['id']
				),
				array(
					'escape' => false,
				)
			);

			$out .= $this->Html->link(
				$this->Html->image(
					$this->Image->getRelativePath('actions', 'arrow-down'),
					array(
						'alt' => __('Down', true),
						'title' => __('Move down', true),
						'width' => '16px',
						'class' => 'arrow-down'
					)
				),
				array(
					'action' => 'reorder',
					'direction' => 'down',
					$data['id']
				),
				array(
					'escape' => false,
				)
			);

			return $out;
		}

		function paginationCounter($pagintion) {
			if (empty($pagintion)) {
				$this->errors[] = 'You did not pass the pagination object.';
				return false;
			}

			$out = '';
			$out .= $pagintion->counter(array('format' => __($this->paginationCounterFormat, true)));
			$out .= '';

			return $out;
		}

		function wysiwyg($id = null, $config = array( 'toolbar' => 'Full')) {
			if (!$id) {
				$this->errors[] = 'No field specified for the wysiwyg editor';
				return false;
			}

			if (!Configure::read('Wysiwyg.editor')) {
				$this->errors[] = 'There is no editor configured';
			}

			$editor = 'text';

			$_editor = Configure::read('Wysiwyg.editor');
			if (!empty($_editor)) {
				$editor = $_editor;
			}

			return $this->Wysiwyg->load($editor, $id, $config);
		}

		function gravatar($email = null, $options = array()) {
			if (!$email) {
				$this->errors[] = 'no email specified for the gravatar.';
				return false;
			}

			return $this->Gravatar->image($email, $options);
		}

		function niceBox($class = '', $content = false) {
			$out = '<div class="niceBox ' . $class . '"><div class="top"><div class="top"><div class="top"></div></div></div>';
			$out .= '<div class="middle">';
			if ($content) {
				$out .= $content . '<div class="clr"></div>';
			}
			if ($content) {
				$out .= $this->niceBoxEnd();
			}
			return $out;
		}

		function niceBoxEnd() {
			$out = '</div>';
			$out .= '<div class="bottom"><div class="bottom"><div class="bottom"></div></div></div></div>';
			return $out;
		}

		function massActionButtons($buttons = null, $niceBox = false) {
			if (!$buttons) {
				$this->errors[] = 'No buttons set';
				return false;
			}

			$out = '';
			foreach($buttons as $button) {
				$imagePath = $this->Image->getRelativePath(array('actions'), $button);

				$buttonCaption = '<span>';
				if ($imagePath) {
					$buttonCaption .= $this->Html->image($imagePath) . '<br>';
				}

				$buttonCaption .= __(Inflector::humanize($button), true) . '</span>';

				$out .= $this->Form->button(
					 $buttonCaption,
					array(
						'value' => strtolower(str_replace(array('-', ' '), '_', $button)),
						'name' => 'action',
						'title' => $this->niceTitleText($button),
						'div' => false
						)
					);
			}

			if ($niceBox) {
				return $this->Design->niceBox('massActions', $out);
			}

			return '<div class="massActions"><div class="wrapper">' . $out . '</div><div class="clr">&nbsp;</div></div>';
		}

		/**
		 * Generate nice title text.
		 *
		 * This method is used to generate nice looking information title text
		 * depending on what is displayed to the user.
		 *
		 * @param $switch this is the title that is passed in
		 * @param $notHuman if this is true the prettyName function will be called making the text human readable.
		 *
		 * @return string the text for the title.
		 */
		function niceTitleText($switch = null){
			$switch = prettyName($switch);

			$controller = __(Inflector::singularize($this->params['controller']), true);

			switch(strtolower($switch)){
				case 'add':
					$heading = sprintf('%s %s', __('Create a New', true), $controller);
					$text = sprintf(
						__('Click here to create a new %s. You do not need to tick any checkboxes to create a new %s.', true),
						$controller, $controller
					);
					break;

				case 'edit':
					$heading = sprintf('%s %s', __('Edit the', true), $controller);
					$text = sprintf(
						__('Tick the checkbox next to the %s you want to edit then click here.<br/><br/>Currently you may only edit one %s at a time.', true),
						$controller, $controller
					);
					break;

				case 'copy':
					$controller = __($this->params['controller'], true);
					$heading = sprintf('%s %s', __('Copy some', true), $controller);
					$text = sprintf(
						__('Tick the checkboxes next to the %s you want to copy then click here.<br/><br/>You may copy as many %s as you like.', true),
						$controller, $controller
					);
					break;

				case 'toggle':
					$controller = __($this->params['controller'], true);
					$heading = sprintf('%s %s', __('Toggle some', true), $controller);
					$text = sprintf(
						__('Tick the checkboxes next to the %s you want to toggle then click here.<br/><br/>Inactive %s will become active, and active %s will become inactive', true),
						$controller, $controller, $controller
					);
					break;

				case 'delete':
					$heading = sprintf('%s %s', __('Delete some', true), $this->params['controller']);
					$text = sprintf(
						__('Tick the checkboxes next to the %s you want to delete then click here.<br/><br/>If possible the %s will be moved to the trash can. If not they will be deleted permanently.', true),
						$controller, $controller
					);
					break;

				case 'disabled':
					$heading = sprintf('%s %s', __('Delete some', true), $this->params['controller']);
					$text = sprintf(
						__('This %s currently disabled, to enable it tick the check to the left and click toggle.', true),
						$controller
					);
					break;

				case 'active':
					$heading = sprintf('%s %s', __('Delete some', true), $this->params['controller']);
					$text = sprintf(
						__('This %s currently active, to disable it tick the check to the left and click toggle.', true),
						$controller
					);
					break;

				case 'save':
					$heading = sprintf('%s %s', __('Save the', true), $this->params['controller']);
					$text = sprintf(
						__('Click here to save your %s. This will save your current changes and take you back to the index list.', true),
						$controller
					);
					break;

				case 'cancel':
					$heading = sprintf('%s', __('Discard your changes', true));
					$text = sprintf(
						__('Click here to return to the index page without saving the changes you have made to the %s.', true),
						$controller
					);
					break;

				case 'move':
					$heading = sprintf('%s %s', __('Move the ', true), $this->params['controller']);
					$text = sprintf(
						__('Tick the checkboxes next to the %s you want to move then click here. You will be prompted with a page, asking how you would like to move the %s', true),
						$controller, $controller
					);
					break;

				default:
					$heading = $switch;
					$text = 'todo: Need to add something';
			}

			return sprintf('%s :: %s', $heading, $text);
		}

		public function niceAltText($text){
			return $text;
		}

		public function datePicker($classes, $model = null, $time = false){
			$model = (!$model) ? Inflector::classify($this->params['controller']) : $model;

			$out = '';
			foreach((array)$classes as $class){
				$out .= '<div id="'.$model.'DatePicker'.ucfirst(Inflector::classify($class)).'"></div>';
				$out .= $this->Form->input($model.'.'.$class, array('type' => 'text'));
				if($time === true){
					$out .= $this->Form->input($model.'.'.str_replace('date', 'time', $class), array('type' => 'time', 'class' => 'timePicker'));
				}

				else if(is_array($time)){
					foreach($time as $t){
						$out .= $this->Form->input($model.'.'.$t, array('type' => 'time', 'class' => 'timePicker'));
					}
				}
				$out .= "\n";
			}

			return $out;
		}

		/*
		 * Url Caching
		 * Copyright (c) 2009 Matt Curry
		 * www.PseudoCoder.com
		 * http://github.com/mcurry/url_cache
		 * http://www.pseudocoder.com/archives/how-to-save-half-a-second-on-every-cakephp-requestand-maintain-reverse-routing
		 *
		 * @author      Matt Curry <matt@pseudocoder.com>
		 * @license     MIT
		 *
		 */

		var $_cache = array();
		var $_key = '';
		var $_extras = array();
		var $_paramFields = array('controller', 'plugin', 'action', 'prefix');

		function __construct() {
			parent::__construct();

			if (Configure::read('UrlCache.pageFiles')) {
				$view =& ClassRegistry::getObject('view');
				$path = $view->here;
				if ($this->here == '/') {
					$path = 'home';
				}
				$this->_key = '_' . strtolower(Inflector::slug($path));
			}

			$this->_key = 'url_map' . $this->_key;
			$this->_cache = Cache::read($this->_key, 'core');
		}

		function beforeRender() {
			$this->_extras = array_intersect_key($this->params, array_combine($this->_paramFields, $this->_paramFields));
		}

		function afterLayout() {
			if (is_a($this, 'HtmlHelper')) {
				Cache::write($this->_key, $this->_cache, 'core');
			}
		}

		function url($url = null, $full = false) {
			$keyUrl = $url;
			if (is_array($keyUrl)) {
				$keyUrl += $this->_extras;
			}

			$key = md5(serialize($keyUrl) . $full);
			$key .= md5_file(CONFIGS . DS . 'routes.php');

			if (!empty($this->_cache[$key])) {
				return $this->_cache[$key];
			}

			$url = parent::url($url, $full);
			$this->_cache[$key] = $url;

			return $url;
		}
	}