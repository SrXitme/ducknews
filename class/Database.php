<?php
class DataBase{
    protected $conn;
    
    public function __construct(){
            $host = "containers-us-west-163.railway.app:5929";
            $user = "root";
            $pass = "TojlStJKiAAMIYKnM3qW";
            $dbname = "duckshot";
            $this->conn = mysqli_connect($host,$user,$pass,$dbname);
    }
     
    public function login($username, $passw){
        $command = "SELECT * FROM usuarios WHERE user='$username' AND pass='$passw';";
        $query = mysqli_query($this->conn,$command);
        if(mysqli_num_rows($query) > 0){
           
              setcookie("username",$username);
              header("Location: home.php");
              exit;
         }else{
              echo "<div id='alert' >Senha Incorreta</div>";
             
             }
          
    }
    public function cadastrar($username,$password){
      $command = "INSERT INTO usuarios(user,pass) VALUES ('$username','$password');";
      $query = mysqli_query($this->conn,$command);
      if ($query) {
        setcookie("user",$username);
        header("Location: home.php");
        exit;

      }else{
        echo "erro desconhecido";
      }
    }
    public function add_db($username,$link,$link_name){
     $command = "INSERT INTO links(user,link,namelink) VALUES ('$username','$link','$link_name');";
     $query = mysqli_query($this->conn,$command);
     if ($query) {
        echo "sucess";
     }
    }
     public function very($item){
        $command = "SELECT * FROM links WHERE namelink='$item';";
        $query = mysqli_query($this->conn,$command);
        $existe = null;
        //vereficar se ja existe um item com o mesmo nome
        while($re = mysqli_fetch_assoc($query)){
             if($re['namelink'] == $item){
               echo "Descupe mais esse Nome ja foi definido, Escolha Outro";
               $existe = true;

             }
           
      }
      return $existe;
    }
    public function view_db($username){
        $command = "SELECT * FROM links WHERE user='$username';";
        $query = mysqli_query($this->conn,$command);
        while($line = mysqli_fetch_assoc($query)){
            $name = $line['namelink'];

            echo "
            <div id='very'>
            <form method='post' action='home.php'><br>
            <input type='text' value='dc.up.railway.app/?d=".$line['namelink']."'> 
            <br>
            <input type='hidden' value='$name' name='name-dl'>
            
            <button id='$name' name='delete'>Deletar</button>
            <a href='https://dc.up.railway.app/?d=$name'>view</a>
            
            </form>  <button value='dc.up.railway.app/$name' id='copy' onclick=\"navigator.clipboard.writeText('dc.up.railway.app/?d=$name')\">copy</button>
            
            

           
           </div>

           
            "
            ;
          
         }
    }
    public function delete_items($dl){
        $command = "DELETE FROM links WHERE namelink='$dl';";
        $query = mysqli_query($this->conn,$command);
        
       
    }
    public function count($user,$tabela,$coluna){
      $command = "SELECT * FROM $tabela WHERE $coluna='$user';";
      $query = mysqli_query($this->conn,$command);
      $c = 0;
      while($result = mysqli_fetch_assoc($query)) {
        $c++;
       
      }
      echo $c;
    }
    public function view_ip($user){
      $command = "SELECT * FROM visitantes WHERE donolink='$user';";
      $query = mysqli_query($this->conn,$command);
     
      while($result = mysqli_fetch_assoc($query)) {
        $ip = $result['ip'];
        $nl = $result['nomelink'];
        $agent =$result['userangent'];
        echo "<input value='$ip Link: $nl  UserAgent: $agent'><br>";
       
      }
      
    
    }
    
      public function getConn(){
          return $this->conn;
      }
      public function setConn($conn){
          $this->conn = $conn;
      }
}


?>
