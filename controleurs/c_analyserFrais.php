
$mois = getMois(date('d/m/Y'));
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch($action)
case 'countFiche' :