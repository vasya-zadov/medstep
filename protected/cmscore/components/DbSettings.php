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
 * Description of DbSettings
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class DbSettings extends CComponent
{

    private $_attributes = array();

    public function __get($name)
    {
        if(isset($this->_attributes[$name]))
            return $this->_attributes[$name]->value;
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if(isset($this->_attributes[$name]))
        {
            $this->_attributes[$name]->value = $value;
            $this->_attributes[$name]->save();
            return $this->_attributes[$name]->value;
        }
        return parent::__set($name, $value);
    }

    public function init()
    {
        if(!app()->hasComponent('db'))
            return false;
        $models = Settings::model()->findAll();
        foreach($models as $model)
        {
            $this->_attributes[$model->name] = $model;
        }
    }

}
