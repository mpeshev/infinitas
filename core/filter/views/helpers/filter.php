<?php
    class FilterHelper extends Helper{
    	var $helpers = array(
    	    'Form', 'Html'
    	);

        var $count = 0;

    	function form($model, $filter = array()){
    		if (empty($filter) || !isset($filter['fields'])){
    			$this->errors[] = 'There is no filters';
    			return false;
    		}

    		$output = '<div class="filter-form"><h1>'.__('Search', true).'</h1>';
       		foreach( $filter['fields'] as $field => $options){
       			if (is_array($options)){
					switch($field){
						case 'active':
							$emptyText = __('status', true);
							break;
						
						default:
							$emptyText = __($field, true);
							break;
					}

					$emptyText = sprintf(__('Select the %s', true), Inflector::humanize(str_replace('_id', '', $emptyText)));
					$output .= $this->Form->input(
						$field,
	    				array(
		    				'type' => 'select',
		    				'div' => false,
		    				'options' => $options,
		    				'empty' => $emptyText,
							'label' => false
		    			)
	    			);
				}
				else{
					$output .= $this->Form->input(
						$options,
						array(
							'type' => 'text',
							'div' => false,
							'label' => false,
							'value' => $options
						)
					);
				}
       		}

			$output .= $this->Form->button(
				$this->Html->image(
					$this->Image->getRelativePath(array('actions'), 'filter'),
					array(
						'width' => '16px'
					)
				),
				array(
					'value' => 'filter',
					'name' => 'action',
					'title' => $this->niceTitleText('Filter results'),
					'div' => false
				)
			);
    		$output .= '</div>';
    		return $output;
    	}

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
        function clear($filter, $div = false){
            if (!isset($filter['url'][0]) || empty($filter['url'][0]) || $filter['url'][0] == '/'){
                $filter['url'][0] = '/';
            }

        	$out = '';
            if ($div){
                $out .= '<div class="filter">';
            }

            $out .= '<div class="wrap">';
                $parts = explode( '/', $filter['url'][0] );
                $done = array();

                foreach($parts as $_f){
                    if (empty($_f) || in_array($_f, $done)){
                        continue;
                    }

                    $done[] = $_f;

                    $text = explode(':', $_f);
                    $text = explode('.', $text[0]);
                    $text = count($text ) > 1 ? $text[1] : $text[0];

                    $out .= '<div class="left">'.
                                '<div class="remove">'.
                                        $this->Html->link(
                                        Inflector::humanize($text),
                                        str_replace($_f, '', '/' . $this->params['url']['url'])
                                    ).
                                '</div>'.
                            '</div>';
                }
            $out .= '</div>';
            if ($div){
                $out .= '</div>';
            }

            return $out;
        }
    }