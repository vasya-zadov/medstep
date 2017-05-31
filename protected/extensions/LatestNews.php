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
 * Description of LatestNews
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class LatestNews extends CWidget {

    public $viewName = 'view';
    public $limit = 0;
    public $order = 'date DESC';
    public $condition = '';
    public $models;
    public $type;

    public function init() {
        $criteria = new CDbCriteria;
        if ($this->limit)
            $criteria->limit = $this->limit;
        if ($this->order)
            $criteria->order = $this->order;
        $criteria->condition = 'type=2';
        if ($this->type) {
            $criteria->addCondition("newsType=" . $this->type);
        }
        if ($this->condition)
            $criteria->addCondition($this->condition);
        $this->models = News::model()->findAll($criteria);
    }

    public function run() {
        $this->render($this->viewName);
    }

}
