<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        .container{
            text-align: center;
            background-image: linear-gradient(to right, #4c6c81, #083263);
            border-radius: 20px;
            border: 2px solid black;
            margin: 150px;
        }
        *{
            font-family: Arial, Helvetica, sans-serif;
            margin: 5px;
        }
        .titulo{
            background-color: white;
            padding-bottom: 1px;
            border-radius: 7px;
            margin: 10px;  
            text-align: left;
        }
        h3{
            width: 0px;
        }
        .calcular{
            width: 1px;
        }
        label{
            width: 1px;
        }
        .form{
            text-align: justify;
            justify-items: auto;
        }
        .historico{
            background-color: white;
            padding-bottom: 1px;
            border-radius: 7px;
            margin: 10px; 
        }   
        .button-group {
            display: flex;
            justify-content: space-around;
            width: 320px;
            margin-top: 10px;
        }
        .button-group button {
            flex: 1;
            margin: 0 5px;
        }
        .popo{
            background-color: white;
            padding-bottom: 1px;
            border-radius: 7px;
            margin: 10px; 
            text-align: left;
        }
        

    </style>
    <script>
    </script>
</head>
<body>
    
    <div class="container">
        <div class="titulo">
            <h3>CalculadoraPHP</h3>
        </div>
        
        <form class="form" action="" method="POST">
            <label>Numero 1</label>
            <input type="text" name="num1" value=" ">

            <select name="seletor" id="select">
                <option value="soma">soma</option>
                <option value="multiplicar">multiplicação</option>
                <option value="subtracao">subtração</option>
                <option value="divisao">divisão</option>
                <option value="fatorar">Fatoração</option>
                <option value="potencia">Potência</option>
            </select>

            <label>Numero 2</label>
            <input type="text" name="num2" value=" ">

            <br>
            <div class="calcular"><button type="submit">Calcular</button></div>
        </form>

        <?php
        session_start();

        if (!isset($_SESSION['historico'])) {
            $_SESSION['historico'] = [];
        }
        $historico = $_SESSION['historico'];
        
       
        $calculations = [];

        $resposta = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $numero1 = $_POST["num1"];
            $numero2 = $_POST["num2"];
            $calculo = $_POST["seletor"];

            if (is_numeric($numero1) && is_numeric($numero2)) {
                switch ($calculo) {
                    case 'soma':
                        $resposta = $numero1 + $numero2;
                       
                        $calculations[] = "$numero1 + $numero2 = $resposta";
                        break;

                    case 'subtracao':
                        $resposta = $numero1 - $numero2;
                        $calculations[] = "$numero1 - $numero2 = $resposta";
                        break;

                    case 'divisao':
                        $resposta = $numero1 / $numero2;
                        $calculations[] = "$numero1 / $numero2 = $resposta";
                        break;

                    case 'multiplicar':
                        $resposta = $numero1 * $numero2;
                        $calculations[] = "$numero1 * $numero2 = $resposta";
                        break;
                     
                    case 'fatorar':
                            $resposta = fatorar($numero1);
                            $calculations[] = "Fatoração de $numero1 = $resposta";
                            break;
            
                    case 'potencia':
                            $resposta = pow($numero1, $numero2);
                            $calculations[] = "$numero1^$numero2 = $resposta";
                            break;    
                }

               
                array_push($historico, $resposta);
                $_SESSION['historico'] = $historico;

            
                $_SESSION['calculations'] = $calculations;
            } else {
                echo "Nenhum valor definido";
            }
        }
        if (isset($_POST['limpar'])) {
            
            $_SESSION['historico'] = [];
            $_SESSION['calculations'] = [];
            $historico = [];
            $calculations = [];
        }

        echo $resposta;

        function fatorar($numero)
    {
        $fatores = [];
        $divisor = 2;
         while ($numero > 1) {
         if ($numero % $divisor == 0) {
               $fatores[] = $divisor;
              $numero /= $divisor;
           } else {
             $divisor++;
          }
       }
          return implode(" * ", $fatores);
    }
        ?>

        <br>

        <div class="button-group">
            <form action="" method="POST">
                <button type="submit" name="salvar">Salvar</button>
                <button type="submit" name="pegar">Pegar Valores</button>
                <button type="submit" name="limpar">Apagar Histórico</button>
            </form>
        </div>

        <div class="historico"><h3>Histórico</h3></div>
        <div class="popo">
        <?php
       
        if (isset($_SESSION["calculations"])) {
            foreach ($_SESSION["calculations"] as $conta) {
                echo "<p>• " . $conta . "</p>";
            }
        }
        ?>
        </div>
    </div>

    <?php
   
    if (isset($_POST['pegar']) && isset($_SESSION["calculations"]) && count($_SESSION["calculations"]) > 0) {
        $lastCalculation = end($_SESSION["calculations"]);
        $parts = explode(' ', $lastCalculation);
        $num1 = $parts[0];
        $operator = $parts[1];
        $num2 = $parts[2];
        echo "<script>
                document.getElementsByName('num1')[0].value = '$num1';
                document.getElementsByName('seletor')[0].value = '$operator';
                document.getElementsByName('num2')[0].value = '$num2';
            </script>";
    }
    ?>
</body>
</html>

