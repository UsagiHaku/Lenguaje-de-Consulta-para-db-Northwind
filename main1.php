<?php
include 'database.php';
//Establezco conexión
$db = Database::getInstance();
$mysql = $db->getConenction();
//Obtengo la búsqueda
$search = $_GET["search"];
//Hago que todas las palabras estén en minúsculas
$search = strtolower($search);
$defaultFieldsArray = ['products.product_name','products.quantity_per_unit','products.category'];
$query='SELECT ';
//Checo primero si existen campos: esto debido a que , en caso de haber, a ellos se limitará la consulta
$fields=strpos($search ,'campos');

if($fields!==false){
    //Obtengo los valores dentro de 'Campos()' y los guardo en un array
    $fields_values = substr($search , $fields +8, -1);
    $newfieldsArray = explode(',',$fields_values);
    //Obtengo el nombre de la tabla
    $tableName = (explode('.', $newfieldsArray[0]))[0];
    //Elimino de la consulta la parte de campos
    $search = substr($search ,0,$fields);
    $query = $query.$fields_values.' from '.$tableName.' where ';
    $defaultFieldsArray = $newfieldsArray;
}else{
    $query = $query . $defaultFieldsArray[0]. ','. $defaultFieldsArray[1].','. $defaultFieldsArray[2].' from products where ';
}

//Obtengo la búsqueda como una array de palabras
$search_words = explode(' ',$search );
if($search_words[count($search_words)-1]===''){
    unset($search_words[count($search_words)-1]);
}

$consecutiveKeyWords=0;
$pattern='';

for ($i=0; $i < count($search_words); $i++) { 
    if($search_words[$i]=== 'and') {
        $query= $query . ' AND ';
        $consecutiveKeyWords=0;
        continue;
    }

    if ($search_words[$i]==='or'){
        $query= $query . ' OR ';
        $consecutiveKeyWords=0;
        continue;
    }

    if ($search_words[$i]=== 'not'){
        if($search_words[$i-1]=== 'and'){
            $query= $query . 'NOT ';
        }else{
            $query= $query . ' NOT ';
        }
        $consecutiveKeyWords=0;
        continue;
    }

    $withString=strpos($search_words[$i] ,'cadena');
    if ($withString!==false){
        $i = createPatternAndReturnCurrentPosition($i,$withString);
        addWhereConditionsForQuery($pattern);
        $consecutiveKeyWords=0;
        continue;
    }

    $withPattern=strpos($search_words[$i] ,'patron');
    if ($withPattern!==false){
        $i = createPatternAndReturnCurrentPosition($i,$withPattern);
        addWhereConditionsForQuery($pattern);
        $consecutiveKeyWords=0;
        continue;
    };

    if($consecutiveKeyWords>=1){
        $query = $query . ' OR ';
    }
    $currentKeyWord= "='".$search_words[$i]."'";
    addWhereConditionsForQuery($currentKeyWord);
    $consecutiveKeyWords++;

}
//En caso de querer ver la query final descomente esto:
//echo ("<p> Query: " . $query . "</p>");

$result = $mysql->query($query);
if ($result && $result->num_rows > 0) {
  echo '<h3>Results:</h3>';
  echo '<table style="width:100% ,border: 1px solid black">';
  echo '<tr>';
  for($z=0; $z < count($defaultFieldsArray); $z++){
    echo '<th style="border: 1px solid black">'.$defaultFieldsArray[$z].'</th>';
  }
  echo '</tr>';
  while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    for($z=0; $z < count($defaultFieldsArray); $z++){
        $currentField =  (explode('.', $defaultFieldsArray[$z]))[1];
        echo '<td style="border: 1px solid black">'.$row[$currentField].'</td>';
    }
    echo '</tr>';
  }
  echo '</table>';
} else {
  echo ("0 results");
}

function addWhereConditionsForQuery($keyWord){
    global $query,$defaultFieldsArray;
    $query= $query.'(';
    for($i=0; $i < count($defaultFieldsArray); $i++){
        $query= $query .$defaultFieldsArray[$i].$keyWord;
        if($i!==(count($defaultFieldsArray)-1)){
            $query= $query .' OR ';
        }
    }
    $query=$query.')';
}

function createPatternAndReturnCurrentPosition($wordPositionInArray,$positionSelectedPattern){
    global $search_words;
    global $pattern;
    $pattern = " LIKE '%";
    //Obtengo el primer elemento, ya sea un patron o la primera palabra de la cadena
    //si solo es una genero y retorno el patron.
    $currentPosition = $wordPositionInArray+1;
    if(strpos($search_words[$currentPosition] ,')')!==false){
        $pattern = $pattern .substr($search_words[$currentPosition],1,-1)."%'";
        return $currentPosition;
    }
    $pattern = $pattern .substr($search_words[$currentPosition],1);
    $currentPosition = $currentPosition+1;
    while(strpos($search_words[$currentPosition] ,')')===false){
        $pattern = $pattern .' '. $search_words[$currentPosition];
        $currentPosition++;
    }
    $pattern = $pattern .' '. substr($search_words[$currentPosition] , 0, -1)."%'";
    return $currentPosition;
}


