<?php

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property integer $id
 * @property string $caption
 * @property string $alias 
 * @property integer $iNumber
 * @property integer $mainImageId
 * @property bool $isActive  
 * @property string $description 
 * 
 * @property SliderImages[] $images 
 * @property-read GalleryPhoto $cover 
 */
class Slider extends BaseCActiveRecord
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SetFlashBehaviour'] = array(
            'class' => 'cmscore.components.SetFlashBehaviour'
        );
        return $behaviors;
    }

    private $_cover;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{slider}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('caption', 'required'),
            array('text', 'safe'),
            array(
                'caption', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, caption,', 'safe', 'on' => 'search'),
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
            'images'    => array(self::HAS_MANY, 'SliderImages', 'sliderId', 'order' => 'itemOrder ASC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'      => 'ID',
            'caption' => Yii::t('formFields', 'Caption'),
            'text' => Yii::t('formFields', 'Text'),
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
    public function search($params = array(), $dataProviderParams = array())
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('caption', $this->caption, true);


        foreach($params as $paramName => $paramValue)
        {
            if(is_array($paramValue))
            {
                call_user_func_array(array(
                    $criteria,
                    $paramName), $paramValue);
            }
            else
            {
                $criteria->{$paramName} = $paramValue;
            }
        }
        $dataProviderParams = CMap::mergeArray(array(
                'criteria' => $criteria,
                'sort'     => array(
                    'defaultOrder' => 'itemOrder')), $dataProviderParams);

        return new CActiveDataProvider($this, $dataProviderParams);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Gallery the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getMaxOrd()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(iNumber) AS iNumber';
        $model = $this->find($criteria);
        return $model->iNumber;
    }

    public function beforeDelete()
    {
        if($this->images !== null)
        {
            foreach($this->images as $image)
            {
                $image->delete();
            }
        }
        return parent::beforeDelete();
    }

    public static function dropdownData()
    {
        $models = self::model()->findAll();

        return CHtml::listData($models, 'id', 'caption');
    }

    public function getCover()
    {
        if(!$this->_cover)
        {
            if(!empty($this->images))
            {
                $images = $this->images;
                $this->_cover = array_shift($images);
            }
            else
            {
                $this->_cover = new SliderImages;
            }
        }
        return $this->_cover;
    }

}
