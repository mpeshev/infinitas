<?php
	class ShortUrlsController extends ShortUrlsAppController{
		var $name = 'ShortUrls';

		function go(){
			if(!isset($this->params['code'])){
				$this->redirect($this->referer());
			}

			$url = $this->ShortUrl->getUrl($this->params['code']);

			if(empty($url)){
				$this->Session->setFlash(__('Page not found', true));
				$this->redirect($this->referer());
			}

			$this->redirect($url);
		}
	}