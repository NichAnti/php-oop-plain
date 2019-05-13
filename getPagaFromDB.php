<!-- ES POME:
REPO: php-oop-plain
Sulla falsa riga di quanto fatto in classe;
- fare la classe pagamenti
- scaricare i pagamenti dal db e inserirli in 3 array diversi in base allo status (pending, accepted, rejected)
- generare un output del tipo:
    Pending:
    1: 774
    5: 895
    7: 12 150
    ....

    Accepted:
    2: 110
    6: 654
    ...

    Rejected:
    ...

N.B.: cercare di sfruttare il concetto di printMe() visto in classe (che dovra' stampare un output del tipo id: price) -->

<?php

  class Pagamento {

    private $id;
    private $price;
    private $status;

    public function __construct($id, $price, $status) {
      $this->id = $id;
      $this->price = $price;
      $this->status = $status;
    }

    public function getStatus() {
      return $this->status;
    }

    public function printMe() {
      echo $this->id . ": " . $this->price;
    }
  }


  $servername = "localhost";
  $username = "root";
  $password = "password";
  $dbname = "prova";

  // Connect
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_errno) {
    echo ("Connection failed: " . $conn->connect_error);
    return;
  }

  $sql = "

    SELECT id, price, status
    FROM pagamenti

  ";

  $pending = [];
  $accepted = [];
  $rejected = [];

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      $pagamento = new Pagamento($row["id"], $row["price"], $row["status"]);

      switch ($pagamento->getStatus()) {
        case 'pending':
          $pending[] = $pagamento;
          break;
        case 'accepted':
          $accepted[] = $pagamento;
          break;
        case 'rejected':
          $rejected[] = $pagamento;
          break;
      }
    }
  }
  else {

    echo"0 results";
  }

  $conn->close();

  echo "pending </br>";
  foreach ($pending as $p) {
    $p->printMe();
    echo "</br>";
  }

  echo "accepted </br>";
  foreach ($accepted as $p) {
    $p->printMe();
    echo "</br>";
  }

  echo "rejected </br>";
  foreach ($rejected as $p) {
    $p->printMe();
    echo "</br>";
  }

?>
