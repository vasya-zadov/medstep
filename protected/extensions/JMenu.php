<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JMenuWinget
 *
 * @author papa
 */
class JMenu extends CWidget {

    //put your code here
    public $models;
    public $view = 'view';

    public function init() {
        if ($this->view == 'view'||$this->view == 'bottom')
            $this->models = Menu::model()->findAllByAttributes(array('parent_id' => 3), array('order' => 'iNumber'));
        else
            $this->models = Catalog::model()->findAllByAttributes(array('parentId' => '0', 'type' => '1'));
    }

    public function run() {
        $this->render($this->view);
    }

}
