<?php

/**
 * This is the model class for table "{{settings_groups}}".
 *
 * The followings are the available columns in table '{{settings_groups}}':
 * @property integer $id
 * @property string $caption
 */
class SettingsGroups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{settings_groups}}';
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
			array('caption', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, caption', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'caption' => 'Caption',
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
		$criteria->compare('caption',$this->caption,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getCaptionTr()
    {
        return Yii::t('dbSettings',$this->caption);
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SettingsGroups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function getMenu()
    {
        $models = self::model()->findAll('showInList=1');
        $result = array();
        foreach($models as $model)
        {
            $result[] = array(
                'label' => $model->captionTr,
                'url' => array('/root/settings/index','id'=>$model->id),
                'icon' => $model->icon?'glyphicon glyphicon-'.$model->icon:false
            );
        }
        return $result;
    }
}
