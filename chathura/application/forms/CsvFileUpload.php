<?php

class Application_Form_CsvFileUpload extends Zend_Form
{

    public function init()
    {
        $csrf = new Zend_Form_Element_Hash('csrf');
        $csrf->setIgnore(true);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email:')
                ->setRequired()
                ->setFilters(array('StringTrim'))
                ->setValidators(array('EmailAddress'));

        $file = new Zend_Form_Element_File('file');
        $file->setLabel('File:')
            ->setRequired()
            ->setDestination(APPLICATION_PATH . '/../public/upload/')
            ->setValidators(array(array('Count', false, 1),
                                array('Size', false, 102400),
                                array('Extension', false, 'csv'),
                                array('MimeType', false, 'text/csv,text/plain')))
            ->setMaxFileSize(102400);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $elements = array($csrf, $email, $file, $submit);

        $this->addElements($elements);

        $this->setAttrib('enctype', 'multipart/form-data');
    }


}

