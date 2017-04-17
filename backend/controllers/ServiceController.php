<?php

namespace app\controllers\ws;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\components\helpers\WebserviceHelper;
use app\models\DocumentUploadForm;
use app\models\ImageUploadForm;
use app\models\EfProjectImage;
use app\models\EfProject;
use app\models\EfProgressDetailImage;
use app\models\TblArticle;

/**
 * Default controller for User module
 */
class ServiceController extends \app\controllers\ws\base\AppController
{
    public function actionGetTblArticle() {
         try {
                $post = Yii::$app->request->post() ;
                $data = array() ;

                $giving_info_s = \app\models\TblArticle::find()->all();
                foreach($giving_info_s as $giving_info){
                        $giving_info_data = array() ;
                        $giving_info_data['ArticleId'] = $giving_info->ArticleId ;
                        $giving_info_data['ArticleTitleTH'] = $giving_info->ArticleTitleTH ;

                        $data[] = $giving_info_data ;
                }
                $this->returnData($data);
         } catch (Exception $e) {
                $this->setException($e);
         }
    }

    public function actionGetTblDownloadCategory() {
         try {
                $post = Yii::$app->request->post() ;
                $data = array() ;

                $giving_info_s = \app\models\TblDownloadCategory::find()->all();
                foreach($giving_info_s as $giving_info){
                        $giving_info_data = array() ;
                        $giving_info_data['DownloadCategoryId'] = $giving_info->DownloadCategoryId ;
                        $giving_info_data['DownloadCategorySortId'] = $giving_info->DownloadCategorySortId ;
                        $giving_info_data['DownloadCategoryActive'] = $giving_info->DownloadCategoryActive ;
                        $giving_info_data['DownloadCategoryNameTH'] = $giving_info->DownloadCategoryNameTH ;
                        $giving_info_data['DownloadCategoryNameEN'] = $giving_info->DownloadCategoryNameEN ;


                        $criteria_sub['DownloadCategoryId'] = $giving_info->DownloadCategoryId ;
                            $giving_info_sub = \app\models\TblDownload::find()->where($criteria_sub)->orderBy('DownloadSortId')->all();
                            foreach($giving_info_sub as $giving_info_2){
                                $giving_info_data_sub = array() ;
                                $giving_info_data_sub['DownloadId'] = $giving_info_2->DownloadId ;
                                $giving_info_data_sub['DownloadSortId'] = $giving_info_2->DownloadSortId ;
                                $giving_info_data_sub['DownloadActive'] = $giving_info_2->DownloadActive ;
                                $giving_info_data_sub['DownloadCategoryId'] = $giving_info_2->DownloadCategoryId ;
                                $giving_info_data_sub['DownloadDepartmentId'] = $giving_info_2->DownloadDepartmentId ;
                                $giving_info_data_sub['DownloadNameTH'] = $giving_info_2->DownloadNameTH ;
                                $giving_info_data_sub['DownloadNameEN'] = $giving_info_2->DownloadNameEN ;
                                $giving_info_data_sub['DownloadFile'] = $giving_info_2->DownloadFile ;
                                $giving_info_data_sub['DownloadView'] = $giving_info_2->DownloadView ;
                                $giving_info_data_sub['DownloadNum'] = $giving_info_2->DownloadNum ;
                                 $giving_info_data['GIVING_INFO_SUBMENU2'] = $giving_info_data_sub  ;
                                   $data[] = $giving_info_data ;
                            }


                }
                $this->returnData($data);
         } catch (Exception $e) {
                $this->setException($e);
         }
    }

     public function actionGetTblMenu() {
         try {
                $post = Yii::$app->request->get() ;

                $criteria['MenuId'] = $post['MenuId'];
                $criteria['MenuActive']=1;
                $data = array() ;
                $giving_info_s = \app\models\TblMenu::find()->all(); //->where($criteria)
                foreach($giving_info_s as $giving_info){
                        $giving_info_data = array() ;
                        $giving_info_data['MenuId'] = $giving_info->MenuId ;
                        $giving_info_data['MenuSortId'] = $giving_info->MenuSortId ;
                        $giving_info_data['MenuType'] = $giving_info->MenuType ;
                        $giving_info_data['Menu2Target'] = $giving_info->MenuTarget ;
                        $giving_info_data['MenuUrlTH'] = $giving_info->MenuUrlTH ;
                        $giving_info_data['MenuUrlEN'] = $giving_info->MenuUrlEN ;
                        $giving_info_data['MenuNameTH'] = $giving_info->MenuNameTH ;
                        $giving_info_data['MenuNameEN'] = $giving_info->MenuNameEN ;

                        $criteria_sub['SubMenuId'] = $giving_info->MenuId ;
                        $criteria_sub['SubActive'] = 1;
                        $criteria_sub['Level'] = 0;
                        $criteria_sub['LevelId'] = 0;
                           $criteria_sub['SubTarget'] = 0;
//                            $criteria_sub['SubType'] = 0;
                            $giving_info_sub = \app\models\TblSubMenu::find()->where($criteria_sub)->orderBy('SubSortId')->all();
                            foreach($giving_info_sub as $giving_info_2){
                                $giving_info_data_sub = array() ;
                                $giving_info_data_sub['SubId'] = $giving_info_2->SubId ;
                                $giving_info_data_sub['SubSortId'] = $giving_info_2->SubSortId ;
                                $giving_info_data_sub['SubNameTH'] = $giving_info_2->SubNameTH ;
                                $giving_info_data_sub['SubDetailTH'] = $giving_info_2->SubDetailTH ;
                                $giving_info_data_sub['SubDetailEN'] = $giving_info_2->SubDetailEN ;
                                $giving_info_data_sub['SubPicTH'] = $giving_info_2->SubPicTH ;
                                $giving_info_data_sub['SubPicEN'] = $giving_info_2->SubPicEN ;
                                $giving_info_data_sub['SubUrlTH'] = $giving_info_2->SubUrlTH ;
                                $giving_info_data_sub['SubUrlEN'] = $giving_info_2->SubUrlEN ;

                                $giving_info_data['GIVING_INFO_SUBMENU2'] = $giving_info_data_sub  ;


                                $criteria_sub_3['LevelId']=$giving_info_2->SubId;
                                $criteria_sub_3['SubActive'] = 1;

                                $giving_info_sub_3 = \app\models\TblSubMenu::find()->where($criteria_sub_3)->orderBy('SubSortId')->all();
                                $num=count($giving_info_sub_3);
                                if($num>0){
                                foreach($giving_info_sub_3 as $giving_info_3){
                                    $giving_info_data_sub3 = array() ;
                                    $giving_info_data_sub3['SubId'] = $giving_info_3->SubId ;
                                    $giving_info_data_sub3['SubSortId'] = $giving_info_3->SubSortId ;
                                    $giving_info_data_sub3['SubNameTH'] = $giving_info_3->SubNameTH ;
                                    $giving_info_data_sub3['SubDetailTH'] = $giving_info_3->SubDetailTH ;
                                    $giving_info_data_sub3['SubDetailEN'] = $giving_info_3->SubDetailEN ;
                                    $giving_info_data_sub3['SubPicTH'] = $giving_info_3->SubPicTH ;
                                    $giving_info_data_sub3['SubPicEN'] = $giving_info_3->SubPicEN ;
                                    $giving_info_data_sub3['SubUrlTH'] = $giving_info_3->SubUrlTH ;
                                    $giving_info_data_sub3['SubUrlEN'] = $giving_info_3->SubUrlEN ;

                                    $giving_info_data['GIVING_INFO_SUBMENU3'] = $giving_info_data_sub3  ;
                                    $data[] = $giving_info_data ;
                                }
                                }else{
                                    $giving_info_data['GIVING_INFO_SUBMENU3'] = ' '  ;
                                    $data[] = $giving_info_data ;
                                }
                            }
                }

                return $this->returnData($data);

         } catch (Exception $e) {
                return $this->setException($e);
         }
    }

    public function actionUploadImageGivingInfo(){
    	try{
    		$post = Yii::$app->request->post();

    		if(empty($post['username'])) throw new Exception('Param username invalidate');
    		if(empty($post['password'])) throw new Exception('Param password invalidate');
    		if(empty($post['giving_info_id'])) throw new Exception('Param giving_info_id invalidate');


			$user = WebserviceHelper::checkAuthen($post['username'], $post['password']);

    		$data = [];

    		$imageUploadForm = new ImageUploadForm();
    		$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

    		if (Yii::$app->request->isPost && $imageUploadForm->file != null) {
    			$imageUploadForm->imagePath = '/images/giving_info_images/';
    			$imageUploadForm->thumbnailPath = '/images/giving_info_images/thumbnails/';
    			$imageUploadForm->thumbnailWidth = 240;
    			$imageUploadForm->thumbnailHeight = 160;
    			$imageUploadForm->thumbnailQuality = 80;

    			if ($imageUploadForm->upload()) {

    				$efGivingInfoImage = new \app\models\EfGivingInfoImage();
    				$efGivingInfoImage->GIVING_INFO_ID = $post['giving_info_id'];
    				$efGivingInfoImage->IMAGE_PATH = $imageUploadForm->imagePath;
    				$efGivingInfoImage->FILE_NAME = $imageUploadForm->fileName;
    				$efGivingInfoImage->THUMBNAIL_IMAGE_PATH = $imageUploadForm->thumbnailPath;
    				$efGivingInfoImage->CREATE_BY = $user->id;
    				$efGivingInfoImage->LAST_UPD_BY = $user->id;

    				if ($efGivingInfoImage->save()) {
    					$imageUploadData = ArrayHelper::toArray($efGivingInfoImage, [
    							'app\models\EfGivingInfoImage' => [
    									'ID' => 'GIVING_INFO_IMAGE_ID',
    									'IMAGE_URL_PATH' => function($model) {
    										return Yii::getAlias('@web/'.$model->IMAGE_PATH);
    									},
    									'THUMBNAIL_URL_PATH' => function($model) {
    										return Yii::getAlias('@web/'.$model->THUMBNAIL_IMAGE_PATH);
    									},
    									'FILE_NAME' => 'FILE_NAME'
    											]
    											]);

    					$data = $imageUploadData;
    				} else {
    					Yii::trace(print_r($projectImage->errors, true), 'debug');
    					throw new Exception('Saved fail');
    				}
    			} else {
    				throw new Exception('Uploaded fail');
    			}
    		} else {
    			throw new Exception('No upload');
    		}

    		$this->returnData($data);
    	}catch(Exception $e){
    		$this->setException($e);
    	}
    }

    public function actionDeleteImageGivingInfo(){
    	try{
    		$post = Yii::$app->request->post();

    		if(empty($post['username'])) throw new Exception('Param username invalidate');
    		if(empty($post['password'])) throw new Exception('Param password invalidate');
    		if(empty($post['giving_info_image_id'])) throw new Exception('Param giving_info_image_id invalidate');

    		WebserviceHelper::checkAuthen($post['username'], $post['password']);

    		$efGivingInfoImage = \app\models\EfGivingInfoImage::findOne($post['giving_info_image_id']);

    		if (!empty($efGivingInfoImage)) {
    			//if (unlink(Yii::getAlias('@webroot/'.$efGivingInfoImage->IMAGE_PATH.$efGivingInfoImage->FILE_NAME))
    			//		&& unlink(Yii::getAlias('@webroot/'.$efGivingInfoImage->THUMBNAIL_IMAGE_PATH.$efGivingInfoImage->FILE_NAME))) {

    						$efGivingInfoImage->delete();
    			//		} else {
    			//			Yii::trace(print_r(error_get_last()), 'debug');
    			//			throw new Exception('Remove Error: '.print_r(error_get_last(), true));
    			//		}
    		} else {
    			throw new Exception('Not found image data');
    		}

    		$this->returnData([]);
    	}catch(Exception $e){
    		$this->setException($e);
    	}
    }

    public function actionSaveGivingInfoList() {
         try {
                $post = Yii::$app->request->post() ;
                $data = array() ;

                $action = empty($post['action'])?"":$post['action'] ; // 'add' , 'edit'
                $user_name = empty($post['username'])?"":$post['username'] ;
                $password = empty($post['password'])?"":$post['password'] ;
//              $user_id = empty($post['user_id'])?"":$post['user_id'] ;
                $project_id = empty($post['project_id'])?"":$post['project_id'] ;
                $giving_info_id = empty($post['giving_info_id'])?"":$post['giving_info_id'] ;
                $subject = empty($post['subject'])?"":$post['subject'] ;
                $status = 'A' ;

                $user = WebserviceHelper::checkAuthen($post['username'], $post['password']);

                if ($action == 'add') {
                        $model = new \app\models\EfGivingInfo() ;
                        $model->PROJECT_ID = $project_id ;
                        $model->SUBJECT = $subject ;
                        $model->STATUS = $status ;
                        //$model->PROBLEM_DESC = $status ;
                        $model->CREATE_BY = $user->id ;
                        $model->LAST_UPD_BY = $user->id ;
                        if ($model->save()) {
								$data['GIVING_INFO_ID'] = $model->GIVING_INFO_ID ;
                                $data['RESULT'] = 'SUCCESS' ;
                        } else {
                                throw new Exception('บันทึกข้อมูลไม่สำเร็จ');
                        }
                } else if ($action == 'edit') {
                        $model = \app\models\EfGivingInfo::findOne($giving_info_id) ;
                        $model->SUBJECT = $subject ;
                        $model->LAST_UPD_BY = $user->id ;
                        if ($model->save()) {
                                $data['RESULT'] = 'SUCCESS' ;
                        } else {
                                throw new Exception('บันทึกข้อมูลไม่สำเร็จ');
                        }
                } else {
                        throw new Exception('ลักษณะคำสั่งบันทึกไม่ถูกต้อง');
                }
                $this->returnData($data);
         } catch (Exception $e) {
                $this->setException($e);
         }
    }

       public function actionGetGivingInfoList() {
         try {
                $post = Yii::$app->request->post() ;
                $data = array() ;

                $giving_info_s = \app\models\EfGivingInfo::find()->orderBy('CREATE_DATE')->all() ;
                foreach($giving_info_s as $giving_info){
                        $giving_info_data = array() ; //$project_group->toArray();
                        $giving_info_data['GIVING_INFO_ID'] = $giving_info->GIVING_INFO_ID ;
                        $giving_info_data['PROJECT_ID'] = $giving_info->PROJECT_ID ;
                        $giving_info_data['SUBJECT'] = $giving_info->SUBJECT ;
						$giving_info_data['CREATE_BY_NAME'] = "" ;
						$giving_info_data['CREATE_DATE'] = $giving_info->CREATE_DATE ;

						$model = \app\models\EfProject::findOne($giving_info->PROJECT_ID) ;
                        $giving_info_data['PROJECT_NAME'] = $model->PROJECT_NAME ;

                        $giving_info_image_s = \app\models\EfGivingInfoImage::find()->where(['GIVING_INFO_ID' => $giving_info->GIVING_INFO_ID])->all() ;
                        $data_giving_info_image = array() ;
                        foreach($giving_info_image_s as $giving_info_image) {
                                $giving_info_image_data = array() ;
                                $giving_info_image_data['GIVING_INFO_IMAGE_ID'] = $giving_info_image->GIVING_INFO_IMAGE_ID ;
                                $giving_info_image_data['GIVING_INFO_ID'] = $giving_info_image->GIVING_INFO_ID ;
                                $giving_info_image_data['ABSOLUTE_IMAGE_PATH'] = $giving_info_image->ABSOLUTE_IMAGE_PATH ;
                                $giving_info_image_data['THUMBNAIL_IMAGE_PATH'] = $giving_info_image->THUMBNAIL_IMAGE_PATH ;
				$giving_info_image_data['FILE_NAME'] = $giving_info_image->FILE_NAME ;
                                $data_giving_info_image [] = $giving_info_image_data ;
                        }
                        $giving_info_data['GIVING_INFO_IMAGE'] = $data_giving_info_image  ;
                        $data[] = $giving_info_data ;
                }
                $this->returnData($data);
         } catch (Exception $e) {
                $this->setException($e);
         }
    }

    public function actionUploadImageProgressDetail(){
    	try{
    		$post = Yii::$app->request->post();

    		if(empty($post['username'])) throw new Exception('Param username invalidate');
    		if(empty($post['password'])) throw new Exception('Param password invalidate');
    		if(empty($post['project_id'])) throw new Exception('Param project_id invalidate');
    		if(empty($post['progress_id'])) throw new Exception('Param progress_id invalidate');
    		if(empty($post['progress_detail_id'])) throw new Exception('Param progress_detail_id invalidate');

		$user = WebserviceHelper::checkAuthen($post['username'], $post['password']);

    		$data = [];

    		$imageUploadForm = new ImageUploadForm();
    		$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

    		if (Yii::$app->request->isPost && $imageUploadForm->file != null) {
    			$imageUploadForm->imagePath = '/images/progress_detail_images/';
    			$imageUploadForm->thumbnailPath = '/images/progress_detail_images/thumbnails/';
    			$imageUploadForm->thumbnailWidth = 240;
    			$imageUploadForm->thumbnailHeight = 160;
    			$imageUploadForm->thumbnailQuality = 80;

    			if ($imageUploadForm->upload()) {

    				$efProgressDetailImage = new EfProgressDetailImage();
    				$efProgressDetailImage->PROJECT_ID = $post['project_id'];
    				$efProgressDetailImage->PROGRESS_ID = $post['progress_id'];
    				$efProgressDetailImage->PROGRESS_DETAIL_ID = $post['progress_detail_id'];
    				$efProgressDetailImage->IMAGE_PATH = $imageUploadForm->imagePath;
    				$efProgressDetailImage->FILE_NAME = $imageUploadForm->fileName;
    				$efProgressDetailImage->THUMBNAIL_IMAGE_PATH = $imageUploadForm->thumbnailPath;
    				$efProgressDetailImage->IMAGE_DESC = '';
    				$efProgressDetailImage->CREATE_BY = $user->id;
    				$efProgressDetailImage->LAST_UPD_BY = $user->id;

    				if ($efProgressDetailImage->save()) {
    					$imageUploadData = ArrayHelper::toArray($efProgressDetailImage, [
    							'app\models\EfProgressDetailImage' => [
    									'ID' => 'PROGRESS_DETAIL_IMAGE_ID',
    									'IMAGE_URL_PATH' => function($model) {
    										return Yii::getAlias('@web/'.$model->IMAGE_PATH);
    									},
    									'THUMBNAIL_URL_PATH' => function($model) {
    										return Yii::getAlias('@web/'.$model->THUMBNAIL_IMAGE_PATH);
    									},
    									'FILE_NAME' => 'FILE_NAME'
    											]
    											]);

    					$data = $imageUploadData;
    				} else {
    					Yii::trace(print_r($projectImage->errors, true), 'debug');
    					throw new Exception('Saved fail');
    				}
    			} else {
    				throw new Exception('Uploaded fail');
    			}
    		} else {
    			throw new Exception('No upload');
    		}

    		$this->returnData($data);
    	}catch(Exception $e){
    		$this->setException($e);
    	}
    }

    public function actionDeleteImageProgressDetail(){
    	try{
    		$post = Yii::$app->request->post();

    		if(empty($post['username'])) throw new Exception('Param username invalidate');
    		if(empty($post['password'])) throw new Exception('Param password invalidate');
    		if(empty($post['progress_detail_image_id'])) throw new Exception('Param image_id invalidate');

    		$efProgressDetailImage = EfProgressDetailImage::findOne($post['progress_detail_image_id']);
    		if (!empty($efProgressDetailImage)) {
    			//if (unlink(Yii::getAlias('@webroot/'.$efProgressDetailImage->IMAGE_PATH.$efProgressDetailImage->FILE_NAME))
    			//		&& unlink(Yii::getAlias('@webroot/'.$efProgressDetailImage->THUMBNAIL_IMAGE_PATH.$efProgressDetailImage->FILE_NAME))) {

    						$efProgressDetailImage->delete();
    			//		} else {
    			//			Yii::trace(print_r(error_get_last()), 'debug');
    			//			throw new Exception('Remove Error: '.print_r(error_get_last(), true));
    			//		}
    		} else {
    			throw new Exception('Not found image data');
    		}

    		$this->returnData([]);
    	}catch(Exception $e){
    		$this->setException($e);
    	}
    }



    public function actionGetProgressDetail () {
        try {
                $post = Yii::$app->request->post() ;
                $data = array() ;

                $progress_detail_id = empty($post['progress_detail_id'])?"":$post['progress_detail_id'] ;
                if($progress_detail_id == "") {
                        throw new Exception('เงื่อนไขการค้นหาไม่ถูกต้อง');
                }

                $model = \app\models\EfProgressDetail::findOne($progress_detail_id) ;

                if (!empty($model)) {
                        $data['PROGRESS_DETAIL_ID'] = $model->PROGRESS_DETAIL_ID ;
                        $data['PROGRESS_ID'] = $model->PROGRESS_ID  ;
                        $data['PROJECT_ID'] = $model->PROJECT_ID  ;
                        $data['PROJECT_PLAN_ACT_ID'] = $model->PROJECT_PLAN_ACT_ID  ;
                        $data['PROGRESS_DESC'] = $model->PROGRESS_DESC  ;
                        $data['PROBLEM_DESC'] = $model->PROBLEM_DESC  ;
                        $data['LATITUDE'] = $model->LATITUDE  ;
                        $data['LONGITUDE'] = $model->LONGITUDE  ;

						$criteria['PROGRESS_DETAIL_ID'] = $progress_detail_id ;
						//$project_image_s = \app\models\EfProjectImage::find()->where(['PROJECT_ID' => $project->PROJECT_ID])->all() ;
                        $progress_detail_image_s = \app\models\EfProgressDetailImage::find()->where($criteria)->all() ;
                        $data_progress_detail_image = array() ;
                        foreach($progress_detail_image_s as $progress_detail_image) {
                                $progress_detail_image_data = array() ;
                                $progress_detail_image_data['PROGRESS_DETAIL_IMAGE_ID'] = $progress_detail_image->PROGRESS_DETAIL_IMAGE_ID ;
                                $progress_detail_image_data['PROGRESS_DETAIL_ID'] = $progress_detail_image->PROGRESS_DETAIL_ID ;
                                $progress_detail_image_data['PROGRESS_ID'] = $progress_detail_image->PROGRESS_ID ;
                                $progress_detail_image_data['PROJECT_ID'] = $progress_detail_image->PROJECT_ID ;
                                $progress_detail_image_data['ABSOLUTE_IMAGE_PATH'] = $progress_detail_image->ABSOLUTE_IMAGE_PATH ;
                                $progress_detail_image_data['THUMBNAIL_IMAGE_PATH'] = $progress_detail_image->THUMBNAIL_IMAGE_PATH ;
								$progress_detail_image_data['FILE_NAME'] = $progress_detail_image->FILE_NAME ;
                                $data_progress_detail_image [] = $progress_detail_image_data ;
                        }
                        $data['PROGRESS_DETAIL_IMAGE'] = $data_progress_detail_image  ;
                }
                $this->returnData($data);
        } catch (Exception $e) {
                $this->setException($e);
        }
    }

    public function actionSaveProgressDetail () {
        try {
                $post = Yii::$app->request->post() ;
                $data = array() ;
				if(empty($post['username'])) throw new Exception('Param username invalidate');
				if(empty($post['password'])) throw new Exception('Param password invalidate');

				$user = WebserviceHelper::checkAuthen($post['username'], $post['password']);

                $action = empty($post['action'])?"":$post['action'] ; // 'add' , 'edit'
                $user_name = empty($post['username'])?"":$post['username'] ;
                $password = empty($post['password'])?"":$post['password'] ;
                $user_id = empty($post['user_id'])?"":$post['user_id'] ;
                $project_id = empty($post['project_id'])?"":$post['project_id'] ;
                $progress_id = empty($post['progress_id'])?"":$post['progress_id'] ;
                $project_plan_act_id = empty($post['project_plan_act_id'])?"":$post['project_plan_act_id'] ;
                $progress_detail_id = empty($post['progress_detail_id'])?"":$post['progress_detail_id'] ;

                $progress_desc = empty($post['progress_desc'])?"":$post['progress_desc'] ;
                $problem_desc = empty($post['problem_desc'])?"":$post['problem_desc'] ;
                $latitude = empty($post['latitude'])?"":$post['latitude'] ;
                $longtitude = empty($post['longtitude'])?"":$post['longtitude'] ;

                if ($action == 'add') {
                        $model = new \app\models\EfProgressDetail() ;
                        $model->PROGRESS_ID = $progress_id ;
                        $model->PROJECT_ID = $project_id ;
                        $model->PROJECT_PLAN_ACT_ID = $project_plan_act_id ;
                        $model->PROGRESS_DESC = $progress_desc ;
                        $model->PROBLEM_DESC = $problem_desc ;
                        $model->LATITUDE = $latitude ;
                        $model->LONGITUDE = $longtitude ;

                        $model->CREATE_BY = $user->id ;
                        $model->LAST_UPD_BY = $user->id ;

                        if ($model->save()) {
                                $data['RESULT'] = 'SUCCESS' ;
								$data['PROGRESS_DETAIL_ID'] = $model->PROGRESS_DETAIL_ID ;
                        } else {
                                throw new Exception('บันทึกข้อมูลไม่สำเร็จ');
                        }
                } else if ($action == 'edit') {
                        $model = \app\models\EfProgressDetail::findOne($progress_detail_id) ;
                        $model->PROGRESS_DESC = $progress_desc ;
                        $model->PROBLEM_DESC = $problem_desc ;
                        $model->LATITUDE = $latitude ;
                        $model->LONGITUDE = $longtitude ;
                        $model->LAST_UPD_BY = $user->id ;
                        if ($model->save()) {
                                $data['RESULT'] = 'SUCCESS' ;
								$data['PROGRESS_DETAIL_ID'] = $model->PROGRESS_DETAIL_ID ;
                        } else {
                                throw new Exception('บันทึกข้อมูลไม่สำเร็จ');
                        }
                } else {
                        throw new Exception('ลักษณะคำสั่งบันทึกไม่ถูกต้อง');
                }
                $this->returnData($data);
        } catch (Exception $e) {
                $this->setException($e);
        }
    }

    public function actionSaveProgress () {
        try {
                $post = Yii::$app->request->post() ;
                $data = array() ;
                //empty($address['street2']) ? "Street2 is empty!" : $address['street2'];
                $action = empty($post['action'])?"":$post['action'] ; // 'add' , 'edit'
                $username = empty($post['username'])?"":$post['username'] ;
                $password = empty($post['password'])?"":$post['password'] ;

				$user = WebserviceHelper::checkAuthen($post['username'], $post['password']);
				$user_id = $user->id ; //empty($post['user_id'])?"":$post['user_id'] ;

                $project_id = empty($post['project_id'])?"":$post['project_id'] ;
                $progress_id = empty($post['progress_id'])?"":$post['progress_id'] ;
                $year = empty($post['year'])?"":$post['year'] ;
                $quarter = empty($post['quarter'])?"":$post['quarter'] ;
                $percent_progress = empty($post['percent_progress'])?"":$post['percent_progress'] ;
                $budget_disb = empty($post['budget_disb'])?"":$post['budget_disb'] ;

                if ($action == 'add') {
                        $model = new \app\models\EfProgress() ;
                        //$model->PROGRESS_ID = $model->getId() ;
                        $model->USER_ID = $user_id ;
                        $model->PROJ_HDLR_ID = $user_id ;
                        $model->PROJECT_ID = $project_id ; //$user_id ;
                        $model->YEAR = $year ; //$user_id ;
                        $model->QUARTER = $quarter ; //$user_id ;
                        $model->PERCENT_PROGRESS = $percent_progress ; //$user_id ;
                        $model->BUDGET_DISB = $budget_disb ; //$user_id ;
                        $model->CREATE_BY = $user_id ;
                        $model->LAST_UPD_BY = $user_id ;

                        if ($model->save()) {
                                $data['RESULT'] = 'SUCCESS' ;
								$data['PROGRESS_ID'] = $model->PROGRESS_ID ;
                        } else {
                                throw new Exception('บันทึกข้อมูลไม่สำเร็จ');
                        }
                } else if ($acton == 'edit') {
                        $model = \app\models\EfProgress::findOne($progress_id) ;
                        $model->PERCENT_PROGRESS = $percent_progress ; //$user_id ;
                        $model->BUDGET_DISB = $budget_disb ; //$user_id ;
                        $model->LAST_UPD_BY = $user_id ;
                        if ($model->save()) {
                                $data['RESULT'] = 'SUCCESS' ;
                        } else {
                                throw new Exception('บันทึกข้อมูลไม่สำเร็จ');
                        }
                } else {
                        throw new Exception('ลักษณะคำสั่งบันทึกไม่ถูกต้อง');
                }
                $this->returnData($data);
        } catch (Exception $e) {
                $this->setException($e);
        }
    }

    public function actionGetProgressDetailList() {
        try {
                $post = Yii::$app->request->post() ;
		//$post['project_id'] = '10' ;
                //$post['progress_id'] = '4' ;
                $criteria_level1['PROJECT_ID'] = $post['project_id'];
                $criteria_level1['LEVEL'] = '1' ;
                $level1Lists = \app\models\EfProjectPlanAct::find()->where($criteria_level1)->orderBy('SEQ')->all();
                foreach($level1Lists as $level1List){
                        $level1_data = array() ;
                        $level1_data['PROJECT_PLAN_ACT_ID'] = $level1List->PROJECT_PLAN_ACT_ID ;
                        $level1_data['PLAN_ACT_NAME'] = $level1List->PLAN_ACT_NAME ;
                        $level1_data['SEQ'] = $level1List->SEQ ;
                        $level1_data['LEVEL'] = $level1List->LEVEL ;

                        $criteria_progress_detail_level1['PROJECT_PLAN_ACT_ID'] = $level1List->PROJECT_PLAN_ACT_ID ;
						$criteria_progress_detail_level1['PROGRESS_ID'] = $post['progress_id'] ;
						$progress_detail_level1 = \app\models\EfProgressDetail::find()->where($criteria_progress_detail_level1)->one() ;
                        if (!empty($progress_detail_level1)) {
                                $level1_data['PROGRESS_DETAIL_ID'] = $progress_detail_level1->PROGRESS_DETAIL_ID ;
                        } else {
                                $level1_data['PROGRESS_DETAIL_ID'] = "" ;
                        }

                        $criteria_level2['PROJECT_ID'] = $post['project_id'] ;
                        $criteria_level2['PARENT_LEV1_ID'] = $level1List->PROJECT_PLAN_ACT_ID ;
                        $criteria_level2['LEVEL'] = '2' ;
                        $level2Lists = \app\models\EfProjectPlanAct::find()->where($criteria_level2)->orderBy('SEQ')->all();
                        $data_level2_array_list = array() ;
                        foreach($level2Lists as $level2List) {
                                $level2_data = array() ;
                                $level2_data['PROJECT_PLAN_ACT_ID'] = $level2List->PROJECT_PLAN_ACT_ID ;
                                $level2_data['PLAN_ACT_NAME'] = $level2List->PLAN_ACT_NAME ;
                                $level2_data['SEQ'] = $level2List->SEQ ;
                                $level2_data['LEVEL'] = $level2List->LEVEL ;

                                $progress_detail_level2 = \app\models\EfProgressDetail::find()->where(['PROJECT_PLAN_ACT_ID' => $level2List->PROJECT_PLAN_ACT_ID ,'PROGRESS_ID' => $post['progress_id']])->one();
                                if (!empty($progress_detail_level2)) {
                                        $level2_data['PROGRESS_DETAIL_ID'] = $progress_detail_level2->PROGRESS_DETAIL_ID ;
                                } else {
                                        $level2_data['PROGRESS_DETAIL_ID'] = "" ;
                                }

                                $criteria_level3['PROJECT_ID'] = $post['project_id'] ;
                                $criteria_level3['PARENT_LEV2_ID'] = $level2List->PROJECT_PLAN_ACT_ID ;
                                $criteria_level3['LEVEL'] = '3' ;
                                $level3Lists = \app\models\EfProjectPlanAct::find()->where($criteria_level3)->orderBy('SEQ')->all();
                                $data_level3_array_list = array() ;

                                foreach($level3Lists as $level3List) {
                                        $level3_data = array() ;
                                        $level3_data['PROJECT_PLAN_ACT_ID'] = $level3List->PROJECT_PLAN_ACT_ID ;
                                        $level3_data['PLAN_ACT_NAME'] = $level3List->PLAN_ACT_NAME ;
                                        $level3_data['SEQ'] = $level3List->SEQ ;
                                        $level3_data['LEVEL'] = $level3List->LEVEL ;

                                        $progress_detail_level3 = \app\models\EfProgressDetail::find()->where(['PROJECT_PLAN_ACT_ID' => $level3List->PROJECT_PLAN_ACT_ID ,'PROGRESS_ID' => $post['progress_id']])->one();
                                        if (!empty($progress_detail_level3)) {
                                                $level3_data['PROGRESS_DETAIL_ID'] = $progress_detail_level3->PROGRESS_DETAIL_ID ;
                                        } else {
                                                $level3_data['PROGRESS_DETAIL_ID'] = "" ;
                                        }

                                        $data_level3_array_list [] = $level3_data ;
                                }

                                $level2_data['LEVEL3_LIST'] = $data_level3_array_list ;
                                $data_level2_array_list [] = $level2_data ;
                        }
                        $level1_data['LEVEL2_LIST'] = $data_level2_array_list ;
                        $data[] = $level1_data;
                }
                $this->returnData($data);
        } catch (Exception $e) {

        }
    }

    public function actionGetProgressList() {
    	try{
                $post = Yii::$app->request->post() ;
                $criteria = [] ;
                if(!empty($post['project_id'])){
    			$criteria['PROJECT_ID'] = $post['project_id'];
    		}
                $data = array() ;
                $progresses = \app\models\EfProgress::find()->where($criteria)->all();
                foreach($progresses as $progress){
                        $progress_data = array() ;
                        $progress_data['PROJECT_ID'] = $progress->PROJECT_ID;
                        $progress_data['PROGRESS_ID'] = $progress->PROGRESS_ID;
                        $progress_data['USER_ID'] = $progress->USER_ID;
                        $progress_data['PROJ_HDLR_ID'] = $progress->PROJ_HDLR_ID;
                        $progress_data['YEAR'] = $progress->YEAR;
                        $progress_data['QUARTER'] = $progress->QUARTER;
                        $progress_data['PERCENT_PROGRESS'] = $progress->PERCENT_PROGRESS;
                        $progress_data['BUDGET_DISB'] = $progress->BUDGET_DISB;
                        $data[] = $progress_data;
                }
                $this->returnData($data);
        } catch (Exception $e) {

        }
    }

    public function actionGetProjectList() {
    	try{
    		$post = Yii::$app->request->post() ;
			$rec_projects = \app\models\EfProject::find();

            if(!empty($post['fiscal_year'])){
            	$rec_projects->andWhere(['FISCAL_YEAR' => $post['fiscal_year']]);
    		} else {
            	$rec_projects->andWhere(['FISCAL_YEAR' => date('Y')+543]);
    		}
    		if(!empty($post['project_group_id'])){
            	$rec_projects->andWhere(['PROJECT_GROUP_ID' => $post['project_group_id']]);
    		}
    		if(!empty($post['project_type_id'])){
            	$rec_projects->andWhere(['PROJECT_TYPE_ID' => $post['project_type_id']]);
    		}
    		if(!empty($post['province_code'])){
            	$rec_projects->andWhere(['PROVINCE_CODE' => $post['province_code']]);
    		}
    		if(!empty($post['project_name'])){
    			$rec_projects->andWhere(['like', 'PROJECT_NAME', $post['project_name']]);
    		}

                $data = array() ;
                $projects = $rec_projects->all();
                foreach($projects as $project){
                        //$tmpData=$project->toArray();
                        $project_data = array() ;
                        $project_data['PROJECT_ID'] = $project->PROJECT_ID;
                        $project_data['PROJECT_NAME'] = $project->PROJECT_NAME;
                        $project_data['LATITUDE'] = $project->LATITUDE;
                        $project_data['LONGITUDE'] = $project->LONGITUDE;
                        $project_data['PROJECT_STATUS'] = $project->PROJECT_STATUS;
						$project_data['USER_ID'] = $project->USER_ID;
                        if ( $project->PROJECT_STATUS == '1' ) {
                                $project_data['PROJECT_STATUS_DESC'] = "อยู่ระหว่างดำเนินการ" ;
                        } else if ( $project->PROJECT_STATUS == '2' ) {
                                $project_data['PROJECT_STATUS_DESC'] = "ดำเนินการเสร็จสิ้น" ;
                        } else if ( $project->PROJECT_STATUS == '3' ) {
                                $project_data['PROJECT_STATUS_DESC'] = "ยกเลิกโครงการ" ;
                        } else {
                                $project_data['PROJECT_STATUS_DESC'] = "" ;
                        }

                        $project_data['AMPHOE_NAME'] = $project->thaiAmphur->AMPHUR_NAME;
                        $project_data['PROVINCE_NAME'] = $project->thaiProvince->PROVINCE_NAME;
                        $project_data['PROJECT_GROUP_NAME'] = $project->projectGroup->GROUP_NAME;
                        $project_data['PROJECT_TYPE_NAME'] = $project->projectType->PROJECT_TYPE_NAME;
                        $project_data['UNIT_NAME'] = $project->unit->UNIT_NAME;
                        $project_data['DIVISION_NAME'] = $project->division->DIVISION_NAME;
                        if(!empty($project->budgetType)) $project_data['BUDGET_TYPE_NAME'] = $project->budgetType->BUDGET_TYPE_NAME;
                        $project_data['PROJ_HDLR_NAME'] = $project->projHdlr->NAME;

                        $project_image_s = \app\models\EfProjectImage::find()->where(['PROJECT_ID' => $project->PROJECT_ID])->all() ;
                        $data_project_image = array() ;
                        foreach($project_image_s as $project_image) {
                                $project_image_data = array() ;
                                $project_image_data['PROJECT_IMAGE_ID'] = $project_image->PROJECT_IMAGE_ID ;
                                $project_image_data['ABSOLUTE_IMAGE_PATH'] = $project_image->ABSOLUTE_IMAGE_PATH ;
                                $project_image_data['THUMBNAIL_IMAGE_PATH'] = $project_image->THUMBNAIL_IMAGE_PATH ;
				$project_image_data['FILE_NAME'] = $project_image->FILE_NAME ;
                                $data_project_image [] = $project_image_data ;
                        }
                        $project_data['PROJECT_IMAGE'] = $data_project_image  ;
                        $data[] = $project_data;
                }
                $this->returnData($data);
        } catch (Exception $e) {
                $this->setException($e);
        }

    }

    public function actionGetProjectDetail() {
        try {
				$post = Yii::$app->request->post() ;
				//$post['project_id'] = '10' ;
                $project = \app\models\EfProject::findOne($post['project_id']) ;
                $data = array() ;
                if(!empty($project)) {
                       $project_data = $project->toArray();
			$project_data['USER_ID'] = $project->USER_ID;
                        $project_data['AMPHOE_NAME'] = $project->thaiAmphur->AMPHUR_NAME;
                        $project_data['PROVINCE_NAME'] = $project->thaiProvince->PROVINCE_NAME;
                        $project_data['PROJECT_GROUP_NAME'] = $project->projectGroup->GROUP_NAME;
                        $project_data['PROJECT_TYPE_NAME'] = $project->projectType->PROJECT_TYPE_NAME;
                        $project_data['UNIT_NAME'] = $project->unit->UNIT_NAME;
                        $project_data['DIVISION_NAME'] = $project->division->DIVISION_NAME;

						if(!empty($project->budgetType)) {
                                $project_data['BUDGET_TYPE_NAME'] = $project->budgetType->BUDGET_TYPE_NAME;
						}

						$project_data['PROJ_HDLR_NAME'] = '' ;//$project->projHdlr->NAME;


						$project_image_s = \app\models\EfProjectImage::find()->where(['PROJECT_ID' => $project->PROJECT_ID])->all() ;
						$data_project_image = array() ;
						foreach($project_image_s as $project_image) {
								$project_image_data = array() ;
								$project_image_data['PROJECT_IMAGE_ID'] = $project_image->PROJECT_IMAGE_ID ;
								$project_image_data['ABSOLUTE_IMAGE_PATH'] = $project_image->ABSOLUTE_IMAGE_PATH ;
								$project_image_data['THUMBNAIL_IMAGE_PATH'] = $project_image->THUMBNAIL_IMAGE_PATH ;
								$project_image_data['FILE_NAME'] = $project_image->FILE_NAME ;
								$data_project_image [] = $project_image_data ;
						}
						$project_data['PROJECT_IMAGE'] = $data_project_image  ;

						$project_detail_desc_s = \app\models\EfProjectDetailDesc::find()->where(['PROJECT_ID' => $post['project_id']])->all() ;
						$data_array_list = array() ;
						foreach($project_detail_desc_s as $project_detail_desc) {
								$project_detail_desc_data = array() ;
								$project_detail_desc_data['PROJECT_DETAIL_DESC_ID'] = $project_detail_desc->PROJECT_DETAIL_DESC_ID ;
								$project_detail_desc_data['SEQ'] = $project_detail_desc->SEQ ;
								$project_detail_desc_data['HEADER_NAME'] = $project_detail_desc->HEADER_NAME ;
								$project_detail_desc_data['DESC'] = $project_detail_desc->DESC ;
								$data_array_list [] = $project_detail_desc_data ;
						}

						$project_data['PROJECT_DETAIL_DESC'] = $data_array_list ;
						$data[] = $project_data ;
                }
                $this->returnData($data);
        } catch (Exception $e) {
				$this->setException($e);
        }
    }

    public function actionFilter(){

    	try{
    		$post = Yii::$app->request->post();
    		$criteria = [];
    		//Add criteria FISCAL_YEAR
    		if(!empty($post['year'])){
    			$criteria['FISCAL_YEAR'] = $post['year'];
    		}else{
    			$criteria['FISCAL_YEAR'] = date('Y')+543;
    		}

    		//Add criteria PROJECT_GROUP_ID
    		if(!empty($post['project_group_id'])){
    			$criteria['PROJECT_GROUP_ID'] = $post['project_group_id'];
    		}

    		//Add criteria PROJECT_TYPE_ID
    		if(!empty($post['project_type_id'])){
    			$criteria['PROJECT_TYPE_ID'] = $post['project_type_id'];
    		}

    		$data = [];

			$projects = \app\models\EfProject::find()->where($criteria)->all();
			$tmpData;
			foreach($projects as $project){
				$tmpData=$project->toArray();
				$tmpData['AMPHOE_NAME'] = $project->thaiAmphur->AMPHUR_NAME;
				$tmpData['PROVINCE_NAME'] = $project->thaiProvince->PROVINCE_NAME;
				$tmpData['PROJECT_GROUP_NAME'] = $project->projectGroup->GROUP_NAME;
				$tmpData['PROJECT_TYPE_NAME'] = $project->projectType->PROJECT_TYPE_NAME;
				$tmpData['UNIT_NAME'] = $project->unit->UNIT_NAME;
				$tmpData['DIVISION_NAME'] = $project->division->DIVISION_NAME;
				if(!empty($project->budgetType))
					$tmpData['BUDGET_TYPE_NAME'] = $project->budgetType->BUDGET_TYPE_NAME;
				$tmpData['PROJ_HDLR_NAME'] = $project->projHdlr->NAME;
				$data[] = $tmpData;
			}

			$this->returnData($data);
    	}catch(Exception $e){
    		$this->setException($e);
    	}

    }

    public function actionUploadImage(){
    	try{
    		$post = Yii::$app->request->post();

    		if(empty($post['username'])) throw new Exception('Param username invalidate');
    		if(empty($post['password'])) throw new Exception('Param password invalidate');
    		if(empty($post['project_id'])) throw new Exception('Param project_id invalidate');

// 			$user = WebserviceHelper::checkAuthen($post['username'], $post['password']);

    		$data = [];
    		$imageUploadForm = new ImageUploadForm();
    		$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

    		if (Yii::$app->request->isPost && $imageUploadForm->file != null) {
    			$imageUploadForm->imagePath = 'images/project_images/';
    			$imageUploadForm->thumbnailPath = 'images/project_images/thumbnails/';
    			$imageUploadForm->thumbnailWidth = 240;
    			$imageUploadForm->thumbnailHeight = 160;
    			$imageUploadForm->thumbnailQuality = 80;

    			if ($imageUploadForm->upload()) {
    				$projectImage = new EfProjectImage();
    				$projectImage->PROJECT_ID = $post['project_id'];
    				$projectImage->IMAGE_PATH = $imageUploadForm->imagePath;
    				$projectImage->FILE_NAME = $imageUploadForm->fileName;
    				$projectImage->THUMBNAIL_IMAGE_PATH = $imageUploadForm->thumbnailPath;
    				$projectImage->IMAGE_DESC = '';
    				$projectImage->CREATE_BY = 2;//Yii::$app->user->identity->id;
    				$projectImage->LAST_UPD_BY = 2;//Yii::$app->user->identity->id;

    				if ($projectImage->save()) {
    					$imageUploadData = ArrayHelper::toArray($projectImage, [
    							'app\models\EfProjectImage' => [
    									'ID' => 'PROJECT_IMAGE_ID',
    									'IMAGE_URL_PATH' => function($model) {
    										return Yii::getAlias('@web/'.$model->IMAGE_PATH);
    									},
    									'THUMBNAIL_URL_PATH' => function($model) {
    										return Yii::getAlias('@web/'.$model->THUMBNAIL_IMAGE_PATH);
    									},
    									'FILE_NAME' => 'FILE_NAME'
    											]
    											]);
						$data = $imageUploadData;
    				} else {
    					Yii::trace(print_r($projectImage->errors, true), 'debug');
    					throw new Exception('Saved fail');
    				}
    			} else {
    				throw new Exception('Uploaded fail');
    			}
    		} else {
    			throw new Exception('No upload');
    		}

    		$this->returnData($data);
    	}catch(Exception $e){
    		$this->setException($e);
    	}
    }

	public function actionGetProjectNearList() {
    	try{
				$post = Yii::$app->request->post() ;
                $data = array() ;

				if(!empty($post['LATITUDE'])){
					$latitude = $post['LATITUDE'];
				}else{
					$latitude = '13.810951348813061' ;
				}

				if(!empty($post['LONGITUDE'])){
					$longtitude = $post['LONGITUDE'];
				}else{
					$longtitude = '100.74527740427584' ;
				}

				$statement = "( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( t.LATITUDE ) ) * cos( radians( t.LONGITUDE ) - radians(".$longtitude.") ) + sin( radians(".$latitude.") ) * sin( radians( t.LATITUDE ) ) ) ) AS distance, t.* " ;

                $projects = \app\models\EfProject::find()->select($statement)
                                    ->from('ef_project t')
                                    ->having('distance < 25')
                                    ->orderBy('distance')->all();
                foreach($projects as $project){
                        //$tmpData=$project->toArray();
                        $project_data = array() ;
                        $project_data['PROJECT_ID'] = $project->PROJECT_ID;
                        $project_data['PROJECT_NAME'] = $project->PROJECT_NAME;
                        $project_data['LATITUDE'] = $project->LATITUDE;
                        $project_data['LONGITUDE'] = $project->LONGITUDE;
                        $project_data['PROJECT_STATUS'] = $project->PROJECT_STATUS;
                        if ( $project->PROJECT_STATUS == '1' ) {
                                $project_data['PROJECT_STATUS_DESC'] = "อยู่ระหว่างดำเนินการ" ;
                        } else if ( $project->PROJECT_STATUS == '2' ) {
                                $project_data['PROJECT_STATUS_DESC'] = "ดำเนินการเสร็จสิ้น" ;
                        } else if ( $project->PROJECT_STATUS == '3' ) {
                                $project_data['PROJECT_STATUS_DESC'] = "ยกเลิกโครงการ" ;
                        } else {
                                $project_data['PROJECT_STATUS_DESC'] = "" ;
                        }

                        $project_data['AMPHOE_NAME'] = $project->thaiAmphur->AMPHUR_NAME;
                        $project_data['PROVINCE_NAME'] = $project->thaiProvince->PROVINCE_NAME;
                        $project_data['PROJECT_GROUP_NAME'] = $project->projectGroup->GROUP_NAME;
                        $project_data['PROJECT_TYPE_NAME'] = $project->projectType->PROJECT_TYPE_NAME;
                        $project_data['UNIT_NAME'] = $project->unit->UNIT_NAME;
                        $project_data['DIVISION_NAME'] = $project->division->DIVISION_NAME;
                        if(!empty($project->budgetType)) $project_data['BUDGET_TYPE_NAME'] = $project->budgetType->BUDGET_TYPE_NAME;
                        $project_data['PROJ_HDLR_NAME'] = $project->projHdlr->NAME;

                        $project_image_s = \app\models\EfProjectImage::find()->where(['PROJECT_ID' => $project->PROJECT_ID])->all() ;
                        $data_project_image = array() ;
                        foreach($project_image_s as $project_image) {
                                $project_image_data = array() ;
                                $project_image_data['PROJECT_IMAGE_ID'] = $project_image->PROJECT_IMAGE_ID ;
                                $project_image_data['ABSOLUTE_IMAGE_PATH'] = $project_image->ABSOLUTE_IMAGE_PATH ;
                                $project_image_data['THUMBNAIL_IMAGE_PATH'] = $project_image->THUMBNAIL_IMAGE_PATH ;
								$project_image_data['FILE_NAME'] = $project_image->FILE_NAME ;
                                $data_project_image [] = $project_image_data ;
                        }
                        $project_data['PROJECT_IMAGE'] = $data_project_image  ;
                        $data[] = $project_data;
                }
                $this->returnData($data);
        } catch (Exception $e) {
                $this->setException($e);
        }

    }

}
