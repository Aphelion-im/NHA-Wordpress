<?php
class iconsControllerGmp extends controllerGmp {
	public function saveNewIcon(){
		$data= reqGmp::get('post');
		$res = new responseGmp();
		$result=$this->getModel()->saveNewIcon($data['icon']);
		if($result){
			$data['icon']['id']=$result;
			$res->addData($data['icon']);
		}else{
			outGmp($this->getModel()->getErrors());
		}
		frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("icon.add");            
		return $res->ajaxExec();
	}
	public function downloadIconFromUrl(){
		$data = reqGmp::get('post');
		$res = new responseGmp();
		if(!isset($data['icon_url']) || empty($data['icon_url'])){
			$res->pushError(langGmp::_('Empty url'));
			return $res->ajaxExec();
		}
		$result = $this->getModel()->downloadIconFromUrl($data['icon_url']);
		if($result){
			$res->addData($result);
		}else{
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function remove() {
		$res = new responseGmp();
		if(!$this->getModel()->remove(reqGmp::get('post'))) {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	/**
	 * @see controller::getPermissions();
	 */
	public function getPermissions() {
		return array(
			GMP_USERLEVELS => array(
				GMP_ADMIN => array('saveNewIcon', 'downloadIconFromUrl', 'remove')
			),
		);
	}
}