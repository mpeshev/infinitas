<?php
	/**
	 *
	 *
	 */
	class Release extends InstallerAppModel{
		var $name = 'Release';

		var $useTable = false;

		/*
		 * Data that is required to run
		 */
		var $coreDataTables = array(
			'cms_content_layouts',

			'acos',
			'aros',
			'aros_acos',
			'core_countries',
			'core_groups',
			'core_modules',
			'core_modules_routes',
			'core_module_positions',
			'core_routes',
			'core_themes',
			'core_users'
		);

		/*
		 * Data that demonstrates functionality
		 */
		var $sampleDataTables = array(
			'blog_posts',

			'cms_contents',
			'cms_content_configs',
			'cms_content_frontpages',
			'cms_features',
			'cms_frontpages',

			'contact_branches',
			'contact_contacts',

			'core_addresses',
			'core_feeds',

			'global_categories',
			'global_tags',
			'global_tagged',
			'global_comments',
			'global_comment_attributes',

			'newsletter_campaigns',
			'newsletter_newsletters',
			'newsletter_newsletters_users',
			'newsletter_subscribers',
			'newsletter_templates',

			'shop_branches_categories',
			'shop_branches_products',
			'shop_branches_specials',
			'shop_branches_spotlights',
			'shop_categories_products',
			'shop_images',
			'shop_images_products',
			'shop_products',
			'shop_shop_branches',
			'shop_shop_categories',
			'shop_specials',
			'shop_spotlights',
			'shop_stocks',
			'shop_suppliers',
			'shop_units'
		);

		var $sql = 'INSERT INTO `%table%` (`%fields%`) VALUES %values%;';

		function path(){
			return dirname(dirname(__FILE__)).DS.'config'.DS;
		}

		function installData($sampleData){
			$this->writeCoreData();

			if($sampleData){
				$this->writeSampleData();
			}
		}

		function getCoreData(){
			return $this->_writeFileData(
				$this->_getTableData($this->coreDataTables),
				'core.dat'
			);
		}

		function getSampleData(){
			return $this->_writeFileData(
				$this->_getTableData($this->sampleDataTables),
				'sample.dat'
			);
		}

		function writeCoreData(){
			if ($this->_truncateTables($this->coreDataTables)) {
				return $this->_writeTableData(
					$this->_getFileData('core.dat')
				);
			}
			return false;
		}

		function writeSampleData(){
			if ($this->_truncateTables($this->sampleDataTables)) {
				return $this->_writeTableData(
					$this->_getFileData('sample.dat')
				);
			}
			return false;
		}


		function _truncateTables($tables = array()){
			$check = true;
			foreach($tables as $table){
				$check = $check && $this->query('TRUNCATE `'.$table.'`;');
			}

			return $check;
		}



		function _getTableData($tables){
			$sql = '';
			foreach($tables as $table ){
				$datas[$table] = $this->query('SELECT * FROM `'.$table.'`;');
			}

			foreach($datas as $table => $records){
				foreach($records as $record){
					foreach($record[$table] as $field => $value ){
						$_fields[] = $field;
						$_values[] = mysql_real_escape_string($value);
					}

					$_sql = str_replace('%table%', $table, $this->sql);
					$_sql = str_replace('%fields%', implode('`, `', $_fields), $_sql);

					$_allValues[] = '(\''.implode('\', \'', $_values).'\')';
					unset($_fields);
					unset($_values);
				}

				if (!empty($_allValues)) {
					$sql[] = str_replace('%values%', implode(', ', $_allValues), $_sql);
				}
				unset($_allValues);
			}
			return $this->_compress($sql);
		}

		function _writeTableData($datas){
			$status = true;
			foreach($datas as $data){
				$status = $status && $this->query($data);
			}
			return $status;
		}

		function _getFileData($file){
			App::import('File');

			$this->File = new File($this->path().$file);
			return $this->_decompress($this->File->read());
		}

		function _writeFileData($data, $file){
			App::import('File');

			$this->File = new File($this->path().$file, true);
			return $this->File->write($data);
		}

		function _compress($data){
			return addslashes(gzcompress(serialize($data),9));
		}

		function _decompress($data){
			return unserialize(gzuncompress(stripslashes($data)));
		}
	}