<?php

/**
 * This is the model class for table "{{feedback}}".
 *
 * The followings are the available columns in table '{{feedback}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $theme
 * @property string $text
 * @property string $timestamp
 * @property integer $isNew
 */
class Feedback extends BaseCActiveRecord
{

    private static $_newItems = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SetFlashBehaviour'] = array(
            'class' => 'cmscore.components.SetFlashBehaviour'
        );
        return $behaviors;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{feedback}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'name, email, phone, theme, text, timestamp, isNew',
                'safe'),
            array(
                'isNew',
                'numerical',
                'integerOnly' => true),
            array(
                'name, email, phone, theme',
                'length',
                'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, name, email, phone, theme, text, timestamp, isNew',
                'safe',
                'on' => 'search'),
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
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'        => 'ID',
            'name'      => Yii::t('formFields', 'Name'),
            'email'     => Yii::t('formFields', 'Email'),
            'phone'     => Yii::t('formFields', 'Phone'),
            'theme'     => Yii::t('formFields', 'Theme'),
            'text'      => Yii::t('formFields', 'Text'),
            'timestamp' => Yii::t('formFields', 'Date and Time'),
            'isNew'     => Yii::t('formFields', 'Is New'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('theme', $this->theme, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('timestamp', $this->timestamp, true);
        $criteria->compare('isNew', $this->isNew);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => 20),
            'sort'       => array(
                'defaultOrder' => 'id DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Feedback the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getNewItemsCounter()
    {
        if(self::$_newItems === null)
        {
            self::$_newItems = $this->count('isNew=1');
        }
        return self::$_newItems;
    }

}
