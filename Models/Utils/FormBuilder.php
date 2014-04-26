<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/26/14
 * Time: 12:48 PM
 */

class FormBuilder {
    private $relnObj;

    public function __construct($obj) {
        $this->relnObj = $obj;
    }

    /*
     * Auto generates an HTML form.
     * Parameters : $method - GET or POST
     * Return Value : HTML code of the auto generated form
     */
    public function buildForm($method) {
        $form = "<form name=\"".$this->relnObj->Tablename()."\" method=\"$method\">";
        $table = "<table>";
        foreach($this->relnObj->Attribs() as $col=>$val) {
            $table .= $this->getInputRow($col);
        }
        $table .= "<tr><td colspan=\"2\"><input type=\"submit\" name=\"".$this->relnObj->Tablename()."_submit\"></td></tr>";
        $table .= "</table>";
        $form .= $table . "</form>";
        echo $form;
    }

    /*
     * Auto generates the row for a form table based on the type of attribute.
     * Parameters : $col -
     * Return Value : HTML code for the auto generated row
     */
    private function getInputRow($col) {
        $row = "";
        if(isset($this->relnObj->AttribFlags()[$col]['isfunc']))
            return "";
        if(isset($this->relnObj->AttribFlags()[$col]['FK'])) {
            $objectType = $this->relnObj->AttribFlags()[$col]['FK'];
            $obj = new $objectType;
            $options = $obj->retrieveRecord();
            $row = "<tr><td>$col</td>";
            $row .= "<td><select name=\"".$col."\">";
            foreach($options as $option) {
                $row.= "<option value=\"".$option[$obj->PrimaryKey()]."\">".
                    (
                    isset($this->relnObj->AttribFlags()[$col]['FK_optionAttr'])?
                        $option[$this->relnObj->AttribFlags()[$col]['FK_optionAttr']]:
                        $option[$obj->primaryKey]
                    ).
                    "</option>";
            }
            $row .= "</select></td>";
            $row .= "</tr>";
        }
        else {
            $row = "<tr>";
            $row .= "<td>$col</td>";
            $row .= "<td><input type=\"text\" name=\"$col\"></td>";
            $row .= "</tr>";
        }
        return $row;
    }

    /*
     * Captures data submitted from a form and stores that in $relnObj.
     * Parameters : None
     * Return Value : true or false on success or failure
     */
    public function captureData() {
        if(isset($_GET[$this->relnObj->Tablename()."_submit"])) {
            $formData = $_GET;
        }
        else if(isset($_POST[$this->relnObj->Tablename()."_submit"])) {
            $formData = $_POST;
        }
        else
            return false;
        $vals = array();
        foreach($this->relnObj->Attribs() as $col=>$val) {
            if(!isset($this->relnObj->AttribFlags()[$col]['isfunc'])) {
                $vals[$col] = $formData[$col];
            }
        }
        $this->relnObj->setData($vals);
        return true;
    }
} 