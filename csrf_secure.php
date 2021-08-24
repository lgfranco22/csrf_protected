<?php
// seguro
session_start();
function getToken()
{
    $_SESSION['token'] = hash('sha256', uniqid());
}

/*
    $_SESSION['token'] = ( !isset($_SESSION['token']) ) ? getToken() : $_SESSION['token'];
    variavel    (se isso for verdade) ? faz isso : se nao, faz isso...
*/


    $_SESSION['token'] = ( !isset($_SESSION['token']) ) ? getToken() : $_SESSION['token'];

    if(isset($_POST['nome']) && !empty($_POST['nome']) 
        && isset($_POST['token']) && !empty($_POST['token']))
    {
        if(isset($_REQUEST['token']) && $_REQUEST['token'] != $_SESSION['token'])
        {
            header("Content-Type: application/json");
            echo json_encode(array("status" => "token-ivalid"));       
            die(
                header('HTTP/1.0 403 Forbidden')
            );
        }

        getToken();
        
        echo $_POST['nome']."<br>";
    }
    if(isset($_POST['nome']) && !empty($_POST['nome']) 
        && !isset($_POST['token']))
        {
            header("Content-Type: application/json");
            echo json_encode(array("status" => "not-token"));   

            die(
                header('HTTP/1.0 403 Forbidden')
            );
        }
?>

<form method="post">
    <label for="">Nome</label><br>
    <input type="text" name="nome" autocomplete="off">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"><br>
    <button type="submit">Enviar</button>
</form>
