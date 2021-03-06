<?php
	class ShortUrl extends ShortUrlsAppModel{
		function __construct($id = false, $table = null, $ds = null) {
			parent::__construct($id, $table, $ds);

			$this->codeSet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$this->base = strlen($this->codeSet);

			$this->server = env('HTTP_HOST');
		}

		function newUrl($url = null, $full = true, $webroot = '/'){
			if(!$url){
				return false;
			}

			$check = $this->find(
				'first',
				array(
					'conditions' => array(
						'ShortUrl.url' => (string)$url
					)
				)
			);

			if(isset($check['ShortUrl']['id'])){
				return $this->_encode($check['ShortUrl']['id']);
			}

			$data['ShortUrl']['url'] = $url;
			$this->create();
			$return = $this->save($data);

			if($this->id > 0){
				$code = $this->_encode($this->id);
				if($full){
					return 'http://'.env('SERVER_NAME').$webroot.'/s/'.$code;
				}
				return $code;
			}
			return false;
		}

		function getUrl($code = null){
			if(!$code){
				return false;
			}

			$check = $this->read(null, $this->_decode($code));

			if(!empty($check)){
				return $check['ShortUrl']['url'];
			}

			return false;
		}

		function _encode($id){
			$return = '';

			while ($id > 0) {
				$return = substr($this->codeSet, ($id % $this->base), 1) . $return;
				$id = floor($id / $this->base);
			}

			return $return;
		}

		function _decode($data){
			$return = '';
			$i = strlen($data);

			for ($i; $i; $i--) {
			  $return += strpos($this->codeSet, substr($data, (-1 * ($i - strlen($data))), 1)) * pow($this->base,$i-1);
			}

			return $return;
		}
	}