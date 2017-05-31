<?php

/**
 * This is the model class for table "{{doctors}}".
 *
 * The followings are the available columns in table '{{doctors}}':
 * @property integer $id
 * @property string $name
 * @property string $photo
 * @property string $text
 * @property integer $specId
 * @property integer $categoryId
 */
class Doctors extends BaseCActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{doctors}}';
    }

    public function defaultScope()
    {
        
 
        return array(
            'order' => 'itemOrder ASC',
           
        );      
 
    }
	
	public function patientTypes()
	{
		$a = array(
			'Взрослый прием',
			'Детский прием',
			'Прием взрослых и детей'
		);
		return array_combine($a,$a);
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, photo, text, specId, categoryId', 'required'),
            array('specId, categoryId,itemOrder', 'numerical', 'integerOnly' => true),
            array('name, photo, patientType', 'length', 'max' => 255),
            array('cite','safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, photo, text, specId, categoryId', 'safe', 'on' => 'search'),
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
            'spec'     => array(self::BELONGS_TO, 'Specs', 'specId'),
            'category' => array(self::BELONGS_TO, 'Categories', 'categoryId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'name'       => 'ФИО',
            'photo'      => 'Фото',
            'text'       => 'Описание услуг',
            'specId'     => 'Специализация',
            'cite'       => 'Цитата',
            'categoryId' => 'Ученая степень / Категория',
			'patientType' => 'Принимает пациентов'
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
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('specId', $this->specId);
        $criteria->compare('categoryId', $this->categoryId);
        $criteria->order='itemOrder DESC';
        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => false
        ));
    }
     public function getMaxOrd() {
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(itemOrder) AS itemOrder';
        $model = $this->find($criteria);
        return $model->itemOrder;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Doctors the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
