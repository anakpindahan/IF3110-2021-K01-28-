<?php
namespace App\Controller;

  class Dorayaki extends Controller{
    public function __cons(){
        parent::__cons();
    }
  }
  public function create($name,$desc,$price,$stock,$image_path) {
    $stmt = $this->db->prepare("INSERT INTO DORAYAKI (name,desc,price,stock,image_path) VALUES (?,?,?,?,?)");
    return $stmt->execute(array($name,$desc,$price,$stock,$image_path));
  }

  public function readAll() {
    $stmt = $this->db->prepare("SELECT * from DORAYAKI");
    $stmt->execute();
    $data = array();
    $result = $stmt->fetchAll();
    return $result;
  }

  public function detail($id) {
    $stmt = $this->db->prepare("SELECT * FROM DORAYAKI WHERE id = ?");
    $stmt->execute(array($id));
    $result = $stmt->fetchAll();
    return $result;
  }

  public function filter($key) {
    $pattern = "%" . $key . "%";
    $stmt = $this->db->prepare("SELECT * FROM DORAYAKI WHERE name LIKE ?");
    $result = $stmt->fetchAll();
    return $result;
  }

  public function update($name,$desc,$price,$stock,$image_path,$sold,$id) {
    $stmt = $this->db->prepare("UPDATE DORAYAKI SET name=?,desc=?,price=?,stock=?,image_path=?,sold=? WHERE id=?");
    return $stmt->execute(array($name,$desc,$price,$stock,$image_path,$sold,$id));
  }

  public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM DORAYAKI WHERE id = ?");
    return $stmt->execute(array($id));
  }
}
