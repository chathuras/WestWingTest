<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form =  new Application_Form_CsvFileUpload();

        if ($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $values = $form->getValues();
                $values['file_path'] = $form->file->getFileName();

                $csv = new Application_Model_Csv($values);
                $csv->save();

                return $this->_helper->redirector('result');
            }
        }

        $this->view->form = $form;
    }

    public function resultAction()
    {
        $csv = new Application_Model_Csv();
        $csv->load();
        $csv->sort();

        $data = $csv->getData();
        $email = $csv->getEmail();

        $this->view->data = $data;
        $this->view->email = $email;
    }


}



