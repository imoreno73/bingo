<?php
error_reporting(E_ERROR);
session_start(); 
$numero=-1;
srand((double)microtime()*1000000); 
$numero=rand(1,90);
$salida='';


if(isset($_POST['finPartida'])){
        $_SESSION['i']=90;
        unset($_POST['finPartida']);
}
if($_SESSION['i']==90){ 
        $salida='<div class="mensaje">Otra partida?</div>';
        $salida.='<div id="panelControl">
                        <form id="nuevoJuego" method="post" action="bingo.php">
                                <input type="submit" id="nuevaPartida" name="nuevaPartida" value="NUEVA PARTIDA"/>
                        </form>
                </div>';
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy(); 
}else{

        if(isset($_SESSION['cantados'])==FALSE){ 

                $_SESSION['i']=1;
                $_SESSION['cantados'][]=$numero;
        }else{
                while(in_array($numero,$_SESSION['cantados']))   {
                        $numero=rand(1,90);
                }
                $_SESSION['cantados'][]= $numero;
                $_SESSION['i']=$_SESSION['i']+1;
        }

        sort($_SESSION['cantados']);
        $salida.='<div class="detalle">Numeros restantes: <span class="negrita">'.(90-$_SESSION['i']).'</span></div>';
        $salida.='<div id="pizarraMain">
                        <div id="pizarraNumero">'.$numero.'</div>
                        <div id="panelControl">
                                <form method="post" action="bingo.php">
                                        <input type="submit" id="nuevoNumero" name="nuevoNumero" value="NUEVO NUMERO"/>
                                        <input type="submit" id="finPartida" name="finPartida" value="FIN PARTIDA"/>
                                </form>
                        </div>
                </div>';
        $salida.='<div id="pizarraResumen"><table>';

        $decena=0;

        for($num=1;$num<=90;$num=$num+1){ 
                if($decena==0)
                        $salida.='<tr>';

                if(in_array($num, $_SESSION['cantados'])){
                        $salida.='<td class="cantado">'.$num.'</td>';
                }else{
                        $salida.='<td>'.$num.'</td>';
                }

                if($decena==9)  {
                        $decena=0;
                        $salida.='</tr>';
                }else
                        $decena++;
        }

        $salida.='</table></div>';
}
echo $salida;
?>

