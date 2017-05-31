<?php

/*
 * The MIT License
 *
 * Copyright 2016 Alexander Larkin <lcdee@andex.ru>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * This is the model class for table "{{settings}}".
 *
 * The followings are the available columns in table '{{settings}}':
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $caption 
 * @property string $fieldType
 * @property integer $orderNumber
 * @property boolean $readOnly 
 * @property integer $groupId
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class Settings extends BaseCActiveRecord
{

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
        return '{{settings}}';
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
                'name, value, caption',
                'safe'),
            array(
                'name, caption',
                'length',
                'max' => 255),
            array(
                'value',
                'valueValidator'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, name, value',
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
            'group'=>array(self::BELONGS_TO,'SettingsGroups','groupId')
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'    => 'ID',
            'name'  => 'Name',
            'value' => 'Value',
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
        $criteria->compare('value', $this->value, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function valueValidator($attribute, $params)
    {
        if($this->fieldType == 'integer')
        {
            $pattern = FILTER_VALIDATE_INT;
            $code = Yii::t('yii', '{attribute} must be an integer.', array(
                    '{attribute}' => $this->captionTr));
        }
        if($this->fieldType == 'float')
        {
            $pattern = FILTER_VALIDATE_FLOAT;
            $code = Yii::t('yii', '{attribute} must be a number.', array(
                    '{attribute}' => $this->captionTr));
        }
        /*elseif($this->fieldType == 'boolean')
        {
            $pattern = FILTER_VALIDATE_BOOLEAN;
            $code = Yii::t('yii', '{attribute} must be either {true} or {false}.', array(
                    '{attribute}' => $this->captionTr));
        }*/
        elseif($this->fieldType == 'email')
        {
            $pattern = FILTER_VALIDATE_EMAIL;
            $code = Yii::t('yii', '{attribute} is not a valid email address.', array(
                    '{attribute}' => $this->captionTr));
        }

        if(isset($pattern) && !filter_var($this->$attribute, $pattern))
            $this->addError($attribute, $code);
    }

    public function getCaptionTr()
    {
        return Yii::t('dbSettings', $this->caption);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Settings the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
