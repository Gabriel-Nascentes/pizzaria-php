<?php 

    include_once("conn.php");

    $method = $_SERVER["REQUEST_METHOD"];

    if($method === "GET"){

        $pedidosQuery = $conn->query("SELECT * FROM pedidos;");

        $pedidos = $pedidosQuery->fetchAll();

        $pizzas = [];
        
        // Montando pizza
        foreach($pedidos as $pedido){

            $pizza = [];

            // Definir um array para a pizza
            $pizza["id"] = $pedido["pizza_id"];

            // Resgatando a pizza
            $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");

            $pizzaQuery->bindParam(":pizza_id",$pizza["id"]);

            $pizzaQuery->execute();

            $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

            // Regatando a borda da pizza
            $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :bordas_id");

            $bordaQuery->bindParam(":bordas_id",$pizzaData["bordas_id"]);

            $bordaQuery->execute();

            $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);

            $pizza["borda"] = $borda["tipo"];

            // Regatando a massa da pizza
            $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massas_id");

            $massaQuery->bindParam(":massas_id",$pizzaData["massas_id"]);

            $massaQuery->execute();

            $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);

            $pizza["massa"] = $massa["tipo"];

            // Resgatando os sabores da pizza
            $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");

            $saboresQuery->bindParam(":pizza_id",$pizza["id"]);

            $saboresQuery->execute();

            $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);
            
            // Resgatando nome dos sabores
            $saboresDaPizza = [];

            $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");

            foreach($sabores as $sabor){

                $saborQuery->bindParam(":sabor_id", $sabor["sabor_id"]);

                $saborQuery->execute();

                $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);

                array_push($saboresDaPizza, $saborPizza["nome"]);

            }

            $pizza["sabores"] = $saboresDaPizza;

            // Adicionar o estatus do pedido
            $pizza["status"] = $pedido["status_id"];

            // Adicionar o array de pizza ao array das pizzas
            array_push($pizzas, $pizza);

        }

        // Resgatando os estatus
        $statusQuery = $conn->query("SELECT * FROM status;");

        $status = $statusQuery-> fetchAll();

    } else if($method === "POST"){

        // Verificando o tipo de POST
        $type = $_POST["type"];

        // Deletar pedido
        if($type === "delete"){

            $pizzaId = $_POST["id"];

            $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id;");

            $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);

            $deleteQuery->execute();

            $_SESSION["msg"] = "Pedido removido com sucesso.";
            $_SESSION["status"] = "success";
        
        // Atualizar status do pedido
        }else if ($type === "update"){

            $pizzaId = $_POST["id"];
            $statusId = $_POST["status"];

            $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id");

            $updateQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
            $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);

            $updateQuery->execute();

            $_SESSION["msg"] = "Pedido atualizado com sucesso.";
            $_SESSION["status"] = "success";
        }

        // Retorna usuário para dashboard
        header("Location: ../dashboard.php");
    
    }

?>
