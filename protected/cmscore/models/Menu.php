<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $iNumber
 * @property string $caption
 * @property string $alias
 * @property boolean $active
 * @property string $controller
 * @property integer $node_id ID of element to be load from DB
 * @property string $title
 * @property string $image
 */
class Menu extends BaseCActiveRecord
{

    public $systemMenuItems = array(
        1,
        2);

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SetFlashBehaviour'] = array(
            'class' => 'cmscore.components.SetFlashBehaviour'
        );
        return $behaviors;
    }
    
    protected $maxOrd;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{menu}}';
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
                'iNumber, caption',
                'required'),
            array(
                'parent_id, iNumber, node_id, active',
                'numerical',
                'integerOnly' => true),
            array(
                'caption, alias, controller, image',
                'length',
                'max' => 255),
            array(
                'alias',
                'uniqueInCat'),
            array(
                'alias, node_id, title, active',
                'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, parent_id, iNumber, caption',
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
            'submenus' => array(
                self::HAS_MANY,
                'Menu',
                'parent_id',
                'order' => 'iNumber ASC',
                'condition'=>'active=1',
                ),
            'parent'   => array(
                self::BELONGS_TO,
                'Menu',
                'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'ID',
            'parent_id'    => Yii::t('formFields', 'Parent ID'),
            'iNumber'      => Yii::t('formFields', 'Order'),
            'caption'      => Yii::t('formFields', 'Caption'),
            'alias'        => Yii::t('formFields', 'Alias/Link'),
            'active'       => Yii::t('formFields', 'Active'),
            'controller'   => Yii::t('formFields', 'Type'),
            'node_id'      => Yii::t('formFields', 'Page ID'),
            'submenuCount' => Yii::t('formFields', 'Submenu Count'),
            'link'         => Yii::t('formFields', 'Link')
        );
    }

    public function dropdownData()
    {
        $criteria = new CDbCriteria;
        if($this->id)
        {
            $criteria->condition = 'id != :thisId AND parent_id != :thisId';
            $criteria->params = array(
                ':thisId' => $this->id);
        }

        $models = self::model()->findAll($criteria);

        return CHtml::listData($models, 'id', 'caption', function($one)
            {
                if($one->parent_id != 0)
                {
                    return Menu::model()->findByPk($one->parent_id)->caption;
                }
                else
                {
                    return Yii::t('formFields', 'Root menu items');
                }
            });
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
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('iNumber', $this->iNumber);
        $criteria->compare('caption', $this->caption, true);
        $criteria->compare('route', $this->route, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Menu the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getMaxOrd()
    {
        $mo = 0;
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent_id='.$this->parent_id;
        $models = $this->findAll($criteria);
        if($models !== null)
            foreach($models as $sub)
            {
                if($sub->iNumber > $mo)
                    $mo = $sub->iNumber;
            }
        return $mo;
    }

    /**
     * Правило валидации, для проверки уникальности
     * алиаса внутри категории.
     * (можно проверять не только алиас, но используется
     *    именно для алиаса)
     */
    public function uniqueInCat($attribute, $params)
    {
        $cat = self::model()->findByPk($this->parent_id);
        if($cat !== null)
        {
            foreach($cat->submenus as $item)
            {
                if($item->$attribute === $this->$attribute && $item->id !== $this->id && !empty($this->controller))
                    $this->addError($attribute, 'В данной категории уже есть пункт c '.$this->getAttributeLabel($attribute).' = "'.$this->$attribute.'"');
            }
        }
    }

    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            if(!empty($this->submenus))
                foreach($this->submenus as $sub)
                    $sub->delete();
        }
        return true;
    }

}
