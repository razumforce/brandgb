<?php
class db
{
    private static $_instance = null;

    private $db; // Ресурс работы с БД

    /*
     * Получаем объект для работы с БД
	 Объект создается один раз, в независимости от количества попыток создания
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new db(); //создается объект класса db, файл db.class.php
        }
        return self::$_instance;
    }

    /*
     * Запрещаем копировать объект
     */
    private function __construct() {}
    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

    /*
     * Выполняем соединение с базой данных
     */
    public function Connect($user, $password, $base, $host = 'localhost', $port = 3306)
    {
        // Формируем строку соединения с сервером
        $connectString = 'mysql:host=' . $host . ';port= ' . $port . ';dbname=' . $base . ';charset=UTF8;';
		$this->db = new PDO($connectString, $user, $password,
							[
								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
								PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
							]
		);

    }

	
	
    /*
     * Выполнить запрос к БД
	 * select * from users where id_user = 1 and age > 25;
	 * select * from users where id_user = ? and age > ?;
	 * select * from users where id_user = :id_user and age > :age;
	 * $params = 
			 [
			 	'id_user' => 1,
				'age' => 25
			 ]
     */
    public function Query($query, $params = array())
    {
		$res = $this->db->prepare($query);
		$res->execute($params);
		return $res;
		
    }

    /*
     * Выполнить запрос с выборкой данных
     */
    public function Select($query, $params = array())
    {
        $result = $this->Query($query, $params);
        if ($result) {
            return $result->fetchAll();
        }
    }
	
    /*
     * Выполнить запрос с выборкой данных для одной строки
     */
    public function SelectRow($query, $params = array())
    {
        $result = $this->Query($query, $params);
        if ($result) {
            return $result->fetchAll()[0];
        }
    }

    /*
    * получить ID последнего выполненного Insert
    */

    public function InsertAndGetId($query, $params = array())
    {
        $res = $this->db->prepare($query);
        $this->db->beginTransaction();
        $res->execute($params);
        $insertId = $this->db->lastInsertId();
        $this->db->commit();
        return $insertId;
        
    }
		
}
?>
