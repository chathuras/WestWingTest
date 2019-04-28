<?php

class Application_Model_Csv
{
    private $_email;
    private $_file;
    private $_file_path;
    private $_data;

    public function __construct(array $values = null)
    {
        if (is_array($values)) {
            foreach($values as $key => $value) {
                $variable = '_' . $key;
                $this->$variable = $value;
            }
        }
    }

    public function save()
    {
        $csvSession = new Zend_Session_Namespace('csvSession');
        $csvSession->csv = $this;
    }

    public function load()
    {
        $csvSession = new Zend_Session_Namespace('csvSession');
        $csv = $csvSession->csv;

        $this->_email = $csv->_email;
        $this->_file = $csv->_file;
        $this->_file_path = $csv->_file_path;
        $this->_data = null;

        try {
            $file = fopen($this->_file_path, "r");

            while (!feof($file)) {
                $field = fgetcsv($file);
                $data[] = $field;
            }
            fclose($file);
            $this->_data = $data;

        } catch(Exception $e)
        {
            echo 'Error : ' , $e->getMessage() , "\n";
        }

    }

    public function sort()
    {
        $data = $this->_data;
        $header = array_shift($data);

        $sortKey = array_search('Firstname', $header);

        if (isset($sortKey)) {

            foreach ($data as $key => $row) {
                $firstNames[$key] = $row[$sortKey];
            }

            array_multisort($firstNames, SORT_ASC, $data);

            $this->_data = $data;
        } else{
            throw new Exception('Firstname field not found');
        }
    }

    public function getData()
    {
        return $this->_data;
    }

    public function getEmail()
    {
        return $this->_email;
    }

}

