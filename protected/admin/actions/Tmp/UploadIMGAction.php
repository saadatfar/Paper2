<?php
/**
 * Uplaod template image action
 * @package Paper.admin.actions
 * @author Mohammad Hosein Saadatfar
 * @copyright Copyright &copy; Mohammad Hosein Saadatfar 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */
class UploadIMGAction extends CAction{
	
	/**
	 * User Massage and alerts will be stored here by "save" method
	 * @var string
	 */
	public $msg;
	
	/**
	 * Run Action!
	 */
	public function run($id,$type=''){
		if (array_key_exists('TMPUploadIMG',$_POST)) $this->save();
		$this->controller->render("UploadIMG",array('msg'=>$this->msg,
													'tmp'=>$id,
													'type'=>$type
								  ));
	}
	/**
	 * Save image
	 */
	private function save(){
		$model=new TMPUploadIMG();
		$model->setAttributes($_POST['TMPUploadIMG'],false);
		if($model->validate()){
			$model->file=CUploadedFile::getInstance($model,'file');
			$file_path=GTemplate::GetPath($model->id).DS.
					   $model->type.'.jpg';
			$model->file->saveAs($file_path,true);
			GTemplate::FindById($model->id)->Increase_Version();
			$this->getController()->redirect(array('Tmp/update','id'=>$model->id));
		}else{
			$this->msg='You need some changes!:';
			foreach($model->getErrors() as $key=>$Error){
				$this->msg=$this->msg.'<br/>-'.$Error[0];
			}
		}
	}
	
	
	
}