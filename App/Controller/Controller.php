
<?php
namespace App/Controller;
use PDO;
class Controller{
    protected $db;

    public function __construct(){
        try{
            $this-> db = new PDO("sqlite": .ROOT. "Databases/dorayaki.db");
            $this-> db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this-> db->EXEC("PRAGMA foreign_keys = ON");
        }
        catch(\PDOException $e){
            die("Error!" . $e->getMessage());
        }
    }
}
