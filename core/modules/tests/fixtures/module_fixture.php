<?php
/* CoreModule Fixture generated on: 2010-08-17 12:08:19 : 1282046299 */
class ModuleFixture extends CakeTestFixture {
	var $name = 'Module';

	var $table = 'core_modules';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'unique'),
		'content' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'module' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'config' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'theme_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'position_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'ordering' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'admin' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'locked' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'locked_by' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'locked_since' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'show_heading' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'core' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'author' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'licence' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 75),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'update_url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'plugin' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1), 'active' => array('column' => array('admin', 'active'), 'unique' => 0), 'ordering' => array('column' => 'ordering', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 2,
			'name' => 'login',
			'content' => '',
			'module' => 'login',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 5,
			'group_id' => 2,
			'ordering' => 1,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => NULL,
			'locked_since' => NULL,
			'show_heading' => 0,
			'core' => 0,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-01-19 00:30:53',
			'modified' => '2010-06-02 14:53:06',
			'plugin' => 'management'
		),
		array(
			'id' => 4,
			'name' => 'Popular Posts',
			'content' => '',
			'module' => '',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 4,
			'group_id' => 1,
			'ordering' => 1,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => 0,
			'locked_since' => 0,
			'show_heading' => 1,
			'core' => 0,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://www.i-project.co.za',
			'update_url' => '',
			'created' => '2010-01-19 00:58:20',
			'modified' => '2010-05-12 03:40:56',
			'plugin' => ''
		),
		array(
			'id' => 5,
			'name' => 'search',
			'content' => '',
			'module' => 'search',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 5,
			'group_id' => 2,
			'ordering' => 2,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => NULL,
			'locked_since' => NULL,
			'show_heading' => 0,
			'core' => 1,
			'author' => 'Infinitas',
			'licence' => '',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-01-19 11:22:09',
			'modified' => '2010-08-05 00:22:18',
			'plugin' => 'news'
		),
		array(
			'id' => 7,
			'name' => 'ThinkMoney Live',
			'content' => '',
			'module' => 'news',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 7,
			'group_id' => 2,
			'ordering' => 4,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => NULL,
			'locked_since' => NULL,
			'show_heading' => 1,
			'core' => 0,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://www.i-project.co.za',
			'update_url' => '',
			'created' => '2010-01-19 11:40:45',
			'modified' => '2010-08-16 16:49:06',
			'plugin' => 'think'
		),
		array(
			'id' => 12,
			'name' => 'Admin Menu',
			'content' => '',
			'module' => 'menu',
			'config' => '{\"menu\":\"core_admin\"}',
			'theme_id' => 0,
			'position_id' => 1,
			'group_id' => 1,
			'ordering' => 1,
			'admin' => 1,
			'active' => 1,
			'locked' => 0,
			'locked_by' => 0,
			'locked_since' => 0,
			'show_heading' => 0,
			'core' => 1,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-01-27 18:14:16',
			'modified' => '2010-05-07 19:05:29',
			'plugin' => 'management'
		),
		array(
			'id' => 13,
			'name' => 'Frontend Menu',
			'content' => '',
			'module' => 'main_menu',
			'config' => '{\"public\":\"main_menu\",\"registered\":\"registered_users\"}',
			'theme_id' => 0,
			'position_id' => 1,
			'group_id' => 2,
			'ordering' => 2,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => 0,
			'locked_since' => 0,
			'show_heading' => 0,
			'core' => 1,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-02-01 00:57:01',
			'modified' => '2010-05-13 20:29:15',
			'plugin' => 'management'
		),
		array(
			'id' => 14,
			'name' => 'Tag Cloud',
			'content' => '',
			'module' => 'post_tag_cloud',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 4,
			'group_id' => 2,
			'ordering' => 4,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => 0,
			'locked_since' => 0,
			'show_heading' => 1,
			'core' => 1,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-02-01 16:01:01',
			'modified' => '2010-05-07 19:06:29',
			'plugin' => 'blog'
		),
		array(
			'id' => 15,
			'name' => 'Post Dates',
			'content' => '',
			'module' => 'post_dates',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 4,
			'group_id' => 2,
			'ordering' => 5,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => 0,
			'locked_since' => 0,
			'show_heading' => 1,
			'core' => 1,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-02-01 16:34:00',
			'modified' => '2010-05-07 19:06:56',
			'plugin' => 'blog'
		),
		array(
			'id' => 16,
			'name' => 'Google analytics',
			'content' => '',
			'module' => 'google_analytics',
			'config' => '{\"code\":\"UA-xxxxxxxx-x\"}',
			'theme_id' => 0,
			'position_id' => 13,
			'group_id' => 2,
			'ordering' => 1,
			'admin' => 0,
			'active' => 0,
			'locked' => 0,
			'locked_by' => NULL,
			'locked_since' => NULL,
			'show_heading' => 0,
			'core' => 1,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org',
			'update_url' => '',
			'created' => '2010-02-01 20:45:05',
			'modified' => '2010-08-05 01:47:17',
			'plugin' => ''
		),
		array(
			'id' => 24,
			'name' => 'Rate This',
			'content' => '',
			'module' => 'rate',
			'config' => '',
			'theme_id' => 0,
			'position_id' => 4,
			'group_id' => 2,
			'ordering' => 1,
			'admin' => 0,
			'active' => 1,
			'locked' => 0,
			'locked_by' => 0,
			'locked_since' => 0,
			'show_heading' => 1,
			'core' => 0,
			'author' => 'Infinitas',
			'licence' => 'MIT',
			'url' => 'http://infinitas-cms.org/',
			'update_url' => '',
			'created' => '2010-05-10 20:06:53',
			'modified' => '2010-05-11 12:40:08',
			'plugin' => 'management'
		),
	);
}
?>