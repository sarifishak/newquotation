<?php
  require_once(dirname(__FILE__).'/../dbmanager.php');
?>
<?php
class ImportField{

  private $index;
  private $inputName;
  private $inputData;
  private $anyDataFlag;  //false means no data
  private $specialForProblem; // for problem field, it could have multiple lines after the "Problem :" field...
  
  public function __construct($index, $name) {
    $this->index = $index;
    $this->inputName = $name;
    $this->anyDataFlag = FALSE;
    $this->specialForProblem = FALSE;
  }
  
  public function setSpecialForProblem($special) {
    $this->specialForProblem = $special;
  }
  
  public function getInputName() {
    return $this->inputName;
  }

  public function getInputData() {
    if($this->anyDataFlag)
        return '['.$this->index.']'.$this->inputName . ':=\'' . $this->inputData .'\'';
    else
        return '['.$this->index.']'.$this->inputName . ':=Has no data yet';
  }
  
  public function toString() {
    if($this->anyDataFlag)
        return '['.$this->index.']'.$this->inputName . ':=\'' . $this->inputData .'\'';
    else
        return '['.$this->index.']'.$this->inputName . ':=Has no data yet';
  }
  
  public function getInputDataByName(){
      return $this->inputData;
  }
  
  public function setInputDataByName($value){
      $this->inputData = trim($value);
      if(strlen($this->inputData) > 0)
          $this->anyDataFlag = TRUE;
      else
          $this->anyDataFlag = FALSE;
  }
  
  public function parseInputString($inputStrings) {
      
      foreach($inputStrings as $x => $x_value) {
          if(strpos($x_value,$this->inputName)!== false) {
              $subsStringData = trim(substr($x_value,strlen($this->inputName)+2));
              if(strlen($subsStringData) > 0) {
                $this->inputData = $subsStringData;
                $this->anyDataFlag = TRUE;
                
                // for special case only
                // Note : 24/7/2016 11:51PM ; Susah lah kes....yg last niih
                if($this->specialForProblem === TRUE){
                  for ($i = ($x+1); $i < count($inputStrings); $i++) {
                    $this->inputData = $this->inputData . "." . $inputStrings[$i];
                  }
                }
              }
              return;
          }
      }
      
  }

}

class ImportFieldFactory {
      public static function create($index, $name) {
         return new ImportField($index, $name);
      }
   }
?>