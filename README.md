

# Usage:
```php
/* Date.php */
$date = new convertData("2017-09-28");
$date = new convertData("2017-09-28", false);
$date = new convertData("2017-09-28", false, "America/Sao_Paulo");
$date->getHora(); //Somente se o segundo paramentro for TRUE. Retorna: 14:24
$date->getDiaSemana(); // Retorna: Segunda, Terça, Quarta .. 
$date->getDia(); // Retorna: 1, 2, 3, 4 .. 30
$date->getMes(); // Retorna: Janeiro, Fevereiro, Março, Abril ..
$date->getAno(); // Retorna: getAno() para 2017 ou getAno("Y") para 2017 ou getAno("y") para 17
$date->getDataCompleta(); // Retorna: Quinta, 28 de Dezembro de 2017
```