<?php
function connect() :array {
	$arr = file_get_contents("./store.json");
	$arr = json_decode($arr, true);
	return $arr;
}


function chek(array $store, string $word) :bool {
	$wordTr = $store["$word"];
	if($wordTr === null){
		return false;
	}
	if($wordTr !== null){
		return true;
	}
}


function getWordTranslation(array $store, string $word): string {
	$wordTr = $store["$word"];
	foreach ($wordTr as $key => $words) {
		$rezult = $rezult . " $key: $words";
	}
	return $rezult;
}



function saveWord(array $store, string $word, string $translation, string $example)  {
	$arr["trans"] = $translation;
	$arr["exm"] = $example;
	$store[$word] = $arr;
    $store = json_encode($store);
    return file_put_contents("./store.json" , $store);
}


$searchWord = $_POST['searchWord'];
$addWord = $_POST['addWord'];
$addWordTransl = $_POST['addWordTransl'];
$addExm = $_POST['addExm'];
$massage = "";
$isMassage = false;

var_dump($searchWord);
var_dump($addWord);
var_dump($addWordTransl);
var_dump($addExm);


function run($searchWord, $addWord, $addWordTransl, $addExm){

if($searchWord !== null && $addWord === null  && $addExm === null && $addWordTransl ===null){
	$baza = connect();
	if (chek($baza, $searchWord) === true){
		$massage = getWordTranslation($baza, $searchWord);
		throw new Exception($masssage);
		
	} else {
		throw new Exception("Слово не найдено, но его можно добавить");
	}	
}

if (empty($searchWord) && !empty($addWord)  && !empty($addExm)  && !empty($addWordTransl)){
	$baza = connect();
	if(chek($baza, $addWord) === true){
		throw new Exception("Такое слово есть уже в словаре!!!");
		
	} else {
		saveWord($baza, $addWord, $addWordTransl, $addExm);
		throw new Exception("Слово успешно добавлено!!!");
	}
}

if (empty($searchWord) && empty($addWord) && empty($addExm) && empty($addWordTransl)) {
	throw new Exception("Поля пустые");
	}

if (empty($searchWord) && !empty($addWord) && empty($addExm) && !empty($addWordTransl)){
	throw new Exception("Введите пример исп. слова!!!");
 }

if (empty($searchWord) && !empty($addWord) && !empty($addExm) && empty($addWordTransl)) {
	throw new Exception("Введите перевод слова!!!");
}

if (empty($searchWord) && empty($addWord) && !empty($addExm) && !empty($addWordTransl)) {
	throw new Exception("Введите добавляемое слово!!!");
 }
 $mass = "NoT!!";
 return $mass;
}


if((isset($searchWord) && isset($addWord) && isset($addExm) && isset($addWordTransl))){
	try {
		$ss = run($searchWord, $addWord, $addWordTransl, $addExm);
	} catch(Exception $e){
		$isMassage = true;
		$massage = $e -> getMessage();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Словарь</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	<h1>Словарь</h1>
	<div class="content">
		<div class="container">
			<div class="formaSearch">
			<form action="index.php" method="post">
				<input type="text" name="searchWord" placeholder="Какое слово найти?">
				<input type="submit" placeholder="Ввод"><br>
			</form>
			</div>
		</div>
		<div class="content2">
			<form class="formavvoda" action="index.php" method="post">
				<input type="text" name="addWord" placeholder="Какое слово добавить?(Engl)"><br>
				<input type="text" name="addWordTransl" placeholder="Перевод этого слова(на русском)"><br>
				<input type="text" name="addExm" placeholder="Пример использования слова">
				<input type="submit" placeholder="Ввод">
			</form>
		</div>
		<div>
			<?php
				if($isMassage === true){
					echo "<div class = 'okno'> $massage </div>";
				} 
			?>
	</div>
	</div>
</body>
</html>