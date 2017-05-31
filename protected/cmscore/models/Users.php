<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $ckey
 * @property string $role
 * @property string $newPassword 
 * 
 * The following are the available getters
 * @property array $cabinetAttributes
 */
class Users extends BaseCActiveRecord {

    public $oldPassword;
    //public $newPassword;
    public $doNotSave = false;

    public function __get($name) {
        if ($this->getInfoField($name) !== null)
            return $this->getInfoField($name);
        return parent::__get($name);
    }

    public function __set($name, $value) {
        if ($this->setInfoField($name, $value))
            return true;
        return parent::__set($name, $value);
    }

    public $newPassword = null;
    private static $_infoFields = array();
    private $_infoFieldVals = array();
    private $_importedRules = array();

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['SetFlashBehaviour'] = array(
            'class' => 'cmscore.components.SetFlashBehaviour'
        );
        return $behaviors;
    }

    public function getRolesList() {
        $rolesList = array(
            'administrator' => Yii::t('moduleCaptions', 'Administrator'),
            'user' => Yii::t('moduleCaptions', 'User')
        );
        if (user()->role == "developer") {
            $rolesList = CMap::mergeArray(array(
                        'developer' => Yii::t('moduleCaptions', 'Developer')), $rolesList);
        }

        return $rolesList;
    }

    private $_defaultRole = 'user';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() { // +
        return '{{user}}';
    }

    

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() { // +
        return CMap::mergeArray(array(
                    array('role', 'default', 'value' => $this->_defaultRole),
                    array('name, email, role', 'required'),
                    array('newPassword', 'required', 'on' => 'insert'),
                    array('name, email', 'length', 'max' => 255),
                    array('email', 'email'), // default 'allowEmpty'=>true
                    array('email', 'unique', 'caseSensitive' => false, 'allowEmpty' => false),
                    array('password, ckey, newPassword', 'safe'),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('id, name, email, role', 'safe', 'on' => 'search'),
                        ), $this->_importedRules);
    }

    /**
     * @return array relational rules.
     */
     public function defaultScope()
    {
        return array(
            'condition' => 'role != "developer" AND isDeleted = 0'
        );
    }
     public function withDeleted()
    {
        $default = $this->defaultScope();
        $this->getDbCriteria()->condition = str_replace($default['condition'], '', $this->getDbCriteria()->condition);
        return $this;
    }
    public function relations() {
        return array(
            'orders' => array(self::HAS_MANY, 'Orders', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() { // Для клиентского интерфейса не используется
        $fieldCaptions = array();
        foreach (self::$_infoFields as $name => $fieldInfo) {
            $fieldCaptions[$name] = $fieldInfo['caption'];
        }
        return CMap::mergeArray(array(
                    'name' => Yii::t('formFields', 'Name'),
                    'email' => 'E-mail',
                    'password' => Yii::t('formFields', 'Password'),
                    'role' => Yii::t('formFields', 'Role'),
                    'newPassword' => Yii::t('formFields', 'New Password'),
                    'oldPassword' => Yii::t('formFields', 'Old Password'),
                        ), $fieldCaptions);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'id ASC'
            )
        ));
    }

    public function beforeSave() {
        if ($this->doNotSave)
            return false;
        if (parent::beforeSave()) {
            if ($this->newPassword != null && $this->newPassword != '') {
                $this->password = CPasswordHelper::hashPassword($this->newPassword);
            }
        }
        return true;
    }

    public function afterFind() {
        $this->loadInfoFields();
    }

    public function afterSave() {
        parent::afterSave();
        $this->saveInfoFields();
        if ($this->scenario == 'order') {
            $this->onAfterOrder();
        }
    }

    public function beforeDelete() {
        parent::beforeDelete();
        $this->deleteInfoFields();

        return true;
    }

    public function listData($attribute) {
        return CHtml::listData(self::model()->findAll(), 'id', $attribute);
    }

    public function getInfoFields() {
        if (empty(self::$_infoFields)) {
            $fields = UserInfoFields::model()->findAll();
            foreach ($fields as $field) {
                self::$_infoFields[$field->fieldName] = array('caption' => $field->caption, 'id' => $field->id);
            }
        }
        return self::$_infoFields;
    }

    private function getInfoField($name) {
        if (isset($this->infoFields[$name])) {
            if (!isset($this->_infoFieldVals[$name]))
                $this->_infoFieldVals[$name] = '';
            return $this->_infoFieldVals[$name];
        }
        return null;
    }

    private function setInfoField($name, $value) {
        if (isset($this->infoFields[$name])) {
            $this->_infoFieldVals[$name] = $value;
            return true;
        }
        return false;
    }

    private function loadInfoFields() {
        foreach ($this->infoFields as $fieldName => $fieldInfo) {
            $field = UserInfoValues::model()->findByAttributes(array('fieldId' => $fieldInfo['id'], 'userId' => $this->id));
            $this->_infoFieldVals[$fieldName] = ($field !== null) ? $field->value : '';
        }
        $this->_importedRules[] = array(implode(', ', array_keys($this->infoFields)), 'safe');
    }

    private function saveInfoFields() {
       
        foreach ($this->infoFields as $fieldName => $fieldInfo) {
            if (($model = UserInfoValues::model()->findByAttributes(array('fieldId' => $fieldInfo['id'], 'userId' => $this->id))) == null) {
                $model = new UserInfoValues;
                $model->userId = $this->id;
                $model->fieldId = $fieldInfo['id'];
            }
            $model->value = '';

            if (isset($this->_infoFieldVals[$fieldName]))
                $model->value = $this->_infoFieldVals[$fieldName];
            $model->save();
        }
    }

    private function deleteInfoFields() {
        UserInfoValues::model()->deleteAllByAttributes(array('userId' => $this->id));
    }

    public function onAfterOrder() {
        if (user()->isGuest) {
            $identity = new UserIdentity($this->email, $this->newPassword);
            $identity->authenticate();
            if ($this->isNewRecord)
                $this->notifyAboutRegistration();
        }
    }

    public function recover() {
        
    }

    public function notifyAboutRegistration() {
        $message = 'Ваш логин: ' . $this->email . PHP_EOL . "<br />";
        $message .= 'Ваш пароль: ' . $this->newPassword . PHP_EOL . "<br />";
        EMailerAdyn::getInstance()->send($this->email, 'Ваша регистрация на сайте ' . app()->name . ' прошла успешно', $message);
    }

}
