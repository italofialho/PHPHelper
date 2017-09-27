Usage:

try {
    $db = new MySQL('USER', 'PASS', 'DB', 'HOST');
} catch (DatabaseException $ex) {
    print('ERROR MENSAGE');
}
