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
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property integer $id
 * @property string $caption
 * @property string $alias
 * @property boolean $isIndex 
 * @property string $description
 * @property string $text
 * @property string $date
 * @property integer $type
 * @property string $image
 * @property bool $isActive 
 * @property string $shortDescription 
 * 
 * Getters:
 * @property string $dateFormatted 
 */
class PagesBase extends BaseCActiveRecord
{

    const TYPE_ID = 0;
    
    public $systemPages = array(1, 2);

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SetFlashBehaviour'] = array(
            'class' => 'cmscore.components.SetFlashBehaviour'
        );
        return $behaviors;
    }
    
    public function init()
    {
        if(static::TYPE_ID)
        {
            $this->type = static::TYPE_ID;
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{pages}}';
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
                'caption, text, type',
                'required'),
            array(
                'alias, headingOne',
                'required',
                'on' => 'news'),
            array(
                'caption,seo_title, image, headingOne',
                'length',
                'max' => 255),
            array(
                'description,seo_text, shortDescription, date, keywords',
                'safe'),
            array(
                'alias',
                'unique'),
            array(
                'isActive',
                'safe'),
            // The following rule is used by search().
            array(
                'id, seo_title,seo_text, caption, description, text, date',
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
            'id'               => 'ID',
            'caption'          => Yii::t('formFields', 'Caption'),
            'description'      => Yii::t('formFields', 'Meta-description'),
            'keywords'         => Yii::t('formFields', 'Meta-keywords'),
            'text'             => Yii::t('formFields', 'Text'),
            'date'             => Yii::t('formFields', 'Date'),
            'image'            => Yii::t('formFields', 'Image'),
            'alias'            => Yii::t('formFields', 'Alias'),
            'headingOne'       => Yii::t('formFields', 'Heading One'),
            'isActive'         => Yii::t('formFields', 'Active'),
            'shortDescription' => Yii::t('formFields', 'Short Description'),
            'seo_title'        => Yii::t('formFields', 'Seo Title'),
            'seo_text'         => Yii::t('formFields', 'Seo Text')
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
     * @param array $params additional params to add to CDbCriteria
     * @param array $dataProviderParams params of CActiveDataProvider
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($params = array(), $dataProviderParams = array())
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('caption', $this->caption, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('date', $this->date, true);
        if(static::TYPE_ID)
            $this->type = static::TYPE_ID;
        $criteria->compare('type', $this->type);
        
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
                'criteria' => $criteria), $dataProviderParams);

        return new CActiveDataProvider($this, $dataProviderParams);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function dropdownData($type)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=:type';
        $criteria->params = array(
            ':type' => $type);

        $models = static::model()->findAll($criteria);

        return CHtml::listData($models, 'id', 'caption');
    }

    public function getDateFormatted()
    {
        return Yii::app()->dateFormatter->format('dd/MM/y', $this->date);
    }

    public function beforeDelete()
    {
        if(in_array($this->id, $this->systemPages))
        {
            setErrorFlash('This page cannot be deleted.');
            return false;
        }
        return parent::beforeDelete();
    }

    public function registerMeta()
    {
        Yii::app()->clientScript->registerMetaTag($this->description, 'description');
        Yii::app()->clientScript->registerMetaTag($this->keywords, 'keywords');
    }

}
