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
 * Description of FeedbackForm
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class FeedbackForm extends CFormModel {

    public $name;
    public $phone;
    public $text;
    public $email;
    public $theme;

    public function rules() {
        return array(
            array('name, email, phone, text', 'required', 'on' => 'question'),
            array('name,  phone', 'required', 'on' => 'callback'),
            array('name,  email, text', 'required', 'on' => 'contact-us')
        );
    }

    public function send() {
        return $this->sendMessage() && $this->save();
    }

    public function sendMessage() {
        $message = $this->theme. "<br />\r\n";
        $message .= 'Имя: ' . $this->name . "<br />\r\n";
        $message .= 'Email: ' . $this->email . "<br />\r\n";
        $message .= 'Телефон: ' . $this->phone . "<br />\r\n";
        $message .= "Текст: <br />\r\n" . $this->text . "<br />\r\n";

        return EMailerAdyn::getInstance()->send(app()->settings->contactEmail,  $this->theme, $message);
    }

    public function save() {
        $model = new Feedback;
        $model->attributes = $this->attributes;
        return $model->save();
    }

    public function attributeLabels() {
        return Feedback::model()->attributeLabels();
    }

}
