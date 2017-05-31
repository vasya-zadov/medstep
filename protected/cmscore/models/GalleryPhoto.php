<?php

/**
 * This is the model class for table "{{galleryPhoto}}".
 *
 * The followings are the available columns in table '{{galleryPhoto}}':
 * @property integer $id
 * @property integer $galleryId
 * @property integer $caption
 * @property integer $iNumber
 * @property string $image
 * 
 * @property Gallery $gallery 
 */
class GalleryPhoto extends BaseCActiveRecord
{
    public $file;
    public $fileUrl;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{galleryphoto}}';
	}
    
    public function __toString()
    {
        return (string)$this->image;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('galleryId, iNumber', 'required'),
            array('file', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,png','maxSize'=>2097152),
            array('file','safe','on'=>'update'),
            array('fileUrl','safe'),
			array('galleryId, iNumber', 'numerical', 'integerOnly'=>true),
			array('image, caption', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, galleryId, caption, iNumber, image', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'gallery'=>array(self::BELONGS_TO, 'Gallery', 'galleryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'galleryId' => 'Gallery',
			'caption' => 'Название',
			'iNumber' => 'I Number',
			'image' => 'Изображение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('galleryId',$this->galleryId);
		$criteria->compare('caption',$this->caption);
		$criteria->compare('iNumber',$this->iNumber);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryPhoto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getMaxOrd()
	{
		$criteria = new CDbCriteria();
		$criteria->select='MAX(iNumber) AS iNumber';
        $criteria->condition='galleryId=:galleryId';
        $criteria->params=array(':galleryId'=>$this->galleryId);
		$model = $this->find($criteria);
		return $model->iNumber;
	}
    
    public function beforeSave()
    {
        if($this->uploadFile() && parent::beforeSave())
            return true;
        return false;
    }
    
    public function afterDelete()
    {
        $this->deleteFile();
    }
    
    public function deleteFile()
    {
        if($this->image)
        {
            @unlink(app()->basePath.'/..'.$this->image);
            $this->image = '';
        }
    }
    
    public function uploadFile()
    {
        $path = $this->getPath();
        @mkdir($path,0777,true);
        $this->file = CUploadedFile::getInstance($this, 'file');
        if($this->file===null)
            $this->file = CUploadedFile::getInstanceByName('file');
        if($this->scenario=='create'&&$this->file===null&&!$this->fileUrl)
        {
            $this->addError('file', 'Необходимо прикрепить файл');
            return false;
        }
        if($this->file!==null)
        {
            if(!$this->validate())
                return false;
            $this->deleteFile();
            $this->file->saveAs($path.'/'.$this->file->name);
            chmod($path.'/'.$this->file->name,0777);
            $this->image = '/uploads/gallery/'.$this->galleryId.'/'.$this->file->name;
            return true;
        }
        elseif($this->fileUrl)
        {
            $headers = get_headers($this->fileUrl,1);
            if(substr($headers[0], 9, 3)!=200)
            {
                return false;
            }
            $file = file_get_contents($this->fileUrl);
            $fileName = explode('/',$this->fileUrl);
            $fileName = array_pop($fileName);
            file_put_contents($path.'/'.$fileName,$file);
            chmod($path.'/'.$fileName,0777);
            $this->image = '/uploads/gallery/'.$this->galleryId.'/'.$fileName;
            return true;
        }
        if($this->scenario!=='create')
        {
            return true;
        }
        return false;
    }
    
    public function getPath()
    {
        return app()->basePath.'/../uploads/gallery/'.$this->galleryId;
    }
}
