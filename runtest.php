<?php

startup_siege();

$res = [];
for($i = 0; $i < 4; $i++){
  $res[] = get_siege_result();
  sleep(15);
}
$avg = calcAverage($res);
display($avg);

function startup_siege($sec = 20, $loop = 3, $interval = 15){
  for($i=0;$i<$loop;$i++){
    echo "doing startup siege ${sec}sec => ".($i + 1)." ...... ";
    $cmd='siege -q -b -t'.$sec.'s -f urls.txt 2>&1';
    exec($cmd);
    echo " done \n";
    sleep($interval);
  }
}

function get_siege_result($sec = 60){
    $cmd='siege -q -b -t'.$sec.'s -f urls.txt 2>&1';

    $result='';
    exec($cmd, $result);
    $values = [];
    foreach($result as $line){
      if(preg_match('/^(?P<name>[a-zA-Z ]+):\s+(?P<value>[0-9\.]+) ?(?P<unit>[a-zA-Z%\/]*)?$/', $line, $m)){
        $mes = new MessuredValue($m['name'], $m['value'], $m['unit']);
        $values[] = $mes;
      }
    }
    return $values;
}

function calcAverage($objs_arr){
  $base;
  $unit;
  foreach($objs_arr as $obj){
    foreach($obj as $o){
      if(isset($base[$o->_name])){
        $base[$o->_name] += $o->_value;
      }else{
        $base[$o->_name] = $o->_value;
      }
      $unit[$o->_name]  = $o->_unit;
    }
  }
  foreach($base as $k => $v){
    $base[$k] = $v / count($objs_arr);
  }
  $objs = [];
  foreach($base as $k => $v){
    $mess = new MessuredValue($k, $v, $unit[$k]); 
    $objs[] = $mess;
  }
  return $objs;
}

function display($obj){
  foreach($obj as $o){
    $tmpl="%s\t%s\t%s\n";
    printf($tmpl, $o->_name, $o->_value, $o->_unit);
  }
}

class MessuredValue {
  public $_name;
  public $_value;
  public $_unit;

  function __construct($name, $value, $unit){
    $this->_name  = $name;
    $this->_value = $value;
    $this->_unit  = $unit;
  }
}