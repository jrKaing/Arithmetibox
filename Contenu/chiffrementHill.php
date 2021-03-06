<script type="text/javascript" async
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
</script>

<form action="chiffrementHill.php" method = "post">
<p>Crypter : <input type="radio" name="msgcode" value="optcode"/> Decrypter : <input type="radio" name="msgcode" value="optdcode"/></p>
<p>Message <input type="text" name="msg"/></p>
<p>Cle : <input type="text" name="clecode"/></p>
<p> <input type="submit" name="chiffrer" value="Crypter/Decrypter"/></p>
</form>

<?php

	require('euclidehill.php');

function PGCD($a,$b){ //Fonction a remplacer par celle des autres !!

	if($a==0) return $b;
	if($b==0) return $a;
	
	return(PGCD($b, $a%$b));
}

function inverseModulaire($a,$n){ //Fonction a remplacer par celle des autres !!

	if(PGCD($a,$n)!=1) return 0;
	
	$A=array();
	$B=array();
	$Q=array();
	$R=array();
	
	$U=array();
	$V=array();
	
	$i=0;
	$A[$i]=$a;
	$B[$i]=$n;
	$Q[$i]=(int)($A[$i]/$B[$i]);
	$R[$i]=$A[$i]%$B[$i];
	
	while($R[$i]!=0){
		$i++;
		$A[$i] = $B[$i-1];
		$B[$i] = $R[$i-1];
		$Q[$i]=(int)($A[$i]/$B[$i]);
		$R[$i]=$A[$i]%$B[$i];
	}
	
	$U[$i]=0;
	$V[$i]=1;
	
	for($j=$i-1 ; $j>=0 ; $j--){
		$U[$j] = $V[$j+1];
		$V[$j] = -$Q[$j]*$U[$j]+$U[$j+1];
	}
	
	$res = $U[0]%$n;
	if($res<0) return $res+$n;
	return $res;
}

function aton($a){ //Fonction qui transforme les lettres en chiffre
	if(strcmp($a,'A') == 0) return 0;
	if(strcmp($a,'B') == 0) return 1;
	if(strcmp($a,'C') == 0) return 2;
	if(strcmp($a,'D') == 0) return 3;
	if(strcmp($a,'E') == 0) return 4;
	if(strcmp($a,'F') == 0) return 5;
	if(strcmp($a,'G') == 0) return 6;
	if(strcmp($a,'H') == 0) return 7;
	if(strcmp($a,'I') == 0) return 8;
	if(strcmp($a,'J') == 0) return 9;
	if(strcmp($a,'K') == 0) return 10;
	if(strcmp($a,'L') == 0) return 11;
	if(strcmp($a,'M') == 0) return 12;
	if(strcmp($a,'N') == 0) return 13;
	if(strcmp($a,'O') == 0) return 14;
	if(strcmp($a,'P') == 0) return 15;
	if(strcmp($a,'Q') == 0) return 16;
	if(strcmp($a,'R') == 0) return 17;
	if(strcmp($a,'S') == 0) return 18;
	if(strcmp($a,'T') == 0) return 19;
	if(strcmp($a,'U') == 0) return 20;
	if(strcmp($a,'V') == 0) return 21;
	if(strcmp($a,'W') == 0) return 22;
	if(strcmp($a,'X') == 0) return 23;
	if(strcmp($a,'Y') == 0) return 24;
	if(strcmp($a,'Z') == 0) return 25;
}

function ntoa($a){ //Fonction qui transforme les chifres en lettre
	if($a == 0) return 'A';
	if($a == 1) return 'B';
	if($a == 2) return 'C';
	if($a == 3) return 'D';
	if($a == 4) return 'E';
	if($a == 5) return 'F';
	if($a == 6) return 'G';
	if($a == 7) return 'H';
	if($a == 8) return 'I';
	if($a == 9) return 'J';
	if($a == 10) return 'K';
	if($a == 11) return 'L';
	if($a == 12) return 'M';
	if($a == 13) return 'N';
	if($a == 14) return 'O';
	if($a == 15) return 'P';
	if($a == 16) return 'Q';
	if($a == 17) return 'R';
	if($a == 18) return 'S';
	if($a == 19) return 'T';
	if($a == 20) return 'U';
	if($a == 21) return 'V';
	if($a == 22) return 'W';
	if($a == 23) return 'X';
	if($a == 24) return 'Y';
	if($a == 25) return 'Z';	
}

?>

<?php

// Chiffrement De Hill
if(!empty($_POST)){
$ccod = $_POST['clecode'];
$Accod = explode(' ', $ccod);

$melema = $Accod[0]; //Matrice element a 
$melemb = $Accod[1]; //Matrice element b
$melemc = $Accod[2]; //Matrice element c
$melemd = $Accod[3]; //Matrice element d

$Gamma = (($melema*$melemd)-($melemc*$melemb)); //Calcul de det(A) avec Gamma
//verifier si cle valide XO
$mod=$Gamma%26; //Mod26
if ($mod<0) $mod=$mod+26;
echo "\$\$ \\Large det(A) = (($melema \\times $melemd)-($melemc \\times $melemb)) <br>\$\$";
echo "\$\$ \\Large det(A) = $Gamma <br>\$\$";
echo "\$\$ \\Large det(A) \\equiv_{26} $mod <br>\$\$";
if($Gamma!=0) euclide(26,$mod);
$pgcd=PGCD(26,$mod); // Calcul du PGCD
echo "\$\$ \\Large PGCD(26,$mod) = $pgcd <br>\$\$";

if($pgcd==1)  { $invmod = inverseModulaire($mod,26); echo "\$\$ \\Large \\text{Cle valide} <br>\$\$"; }

if($pgcd!=1)  echo "\$\$ \\Large \\text{Cle non valide} <br>\$\$";

else {
	
  if(isset($_POST['msg'])and trim($_POST['msg'])!=''){ //Pour coder 
    	
	if(strcmp($_POST['msgcode'],'optcode') == 0){
	echo "\$\$	\\Large Cle = \\begin{pmatrix}";
 	echo "$melema&$melemb \\\\ $melemc&$melemd \\end{pmatrix} \$\$";
  	echo '<br>';			
		$msgc = $_POST['msg'];
		$Amccod = str_split(strtoupper($msgc));
		$compt=count($Amccod);

		if ($compt%2!=0) {
			
			$Amcod=$Amccod;
			$Amcod[]='A'; 
			$compt++;
		}
		else $Amcod=$Amccod;

		echo 'Texte : ';
		foreach($Amcod as $element){ //Afiche les lettres a chiffrer
			echo $element;
		}
		echo '<br>';		
		
		echo 'Codage : ';
		for($i=0;$i<count($Amcod);$i++){ //Convertie les lettres en chiffres et les affichent
			$Amcod[$i]=aton($Amcod[$i]);
			echo $Amcod[$i].' ';
		} 	
		echo '<br>';
		
		if ($compt%2==0){ //Crypte le msg
			for($i=0;$i<count($Amcod);$i++){
				if($i%2==0){
					$val=$Amcod[$i];
					$Amcod[$i]=(($Amcod[$i]*$melema)+($Amcod[$i+1]*$melemb))%26;
					if($Amcod[$i]<0){
						$Amcod[$i]=$Amcod[$i]+26;
					}
				}
				else{
					$Amcod[$i]=(($val*$melemc)+($Amcod[$i]*$melemd))%26;
					if($Amcod[$i]<0){
						$Amcod[$i]=$Amcod[$i]+26;
					}
				}			
			}
		}
		
		echo 'A.X : ';
		foreach($Amcod as $element){ //Affiche A.X
			echo $element.' ';
		}
		echo '<br>';		
		
		echo 'Decodage : ';
		for($i=0;$i<$compt;$i++){ //Convertie les chiffres en lettres et les affichent
			$Amcod[$i]=ntoa($Amcod[$i]);
			echo $Amcod[$i];
		}
		echo '<br>'; 		
	}
  }
 
 if(isset($_POST['msg'])and trim($_POST['msg'])!=''){ //Pour decoder 
 
	if(strcmp($_POST['msgcode'],'optdcode') == 0){	
		
		$imelema = ($invmod*$Accod[3])%26; //Matrice Inverse element a 
		$imelemb = ($invmod*(-$Accod[1]))%26; //Matrice Inverse element b
		$imelemc = ($invmod*(-$Accod[2]))%26; //Matrice Inverse element c
		$imelemd = ($invmod*$Accod[0])%26; //Matrice Inverse element d
		$msgdc = $_POST['msg'];
		$Amdccod = str_split(strtoupper($msgdc));
		$dcompt=count($Amdccod);
		
		echo "\$\$	\\Large A^{-1} \\equiv_{26} \\begin{pmatrix}";
 		echo "$imelema&$imelemb \\\\ $imelemc&$imelemd \\end{pmatrix} \$\$";
  		echo '<br>';
		
		if ($dcompt%2!=0) {
			$Amdcod[$compt+1]; 
			$Amdcod[]='A';
			$dcompt++;
		}

		else $Amdcod=$Amdccod;

		echo '<br>';		
		
		echo 'Texte : ';
		foreach($Amdcod as $element){ //Afiche les lettres a chiffrer
			echo $element;
		}
		echo '<br>';		
		
		echo 'Codage : ';
		for($i=0;$i<$dcompt;$i++){ //Convertie les lettres en chiffres et les affichent
			$Amdcod[$i]=aton($Amdcod[$i]);
			echo $Amdcod[$i].' ';
		} 	
		echo '<br>';
		
		if ($dcompt%2==0){ //Decrypte le msg
			for($i=0;$i<$dcompt;$i++){
				if($i%2==0){
					$val=$Amdcod[$i];
					$Amdcod[$i]=(($Amdcod[$i]*$imelema)+($Amdcod[$i+1]*$imelemb))%26;
					if($Amdcod[$i]<0){
						$Amdcod[$i]=$Amdcod[$i]+26;
					}
				}
				else{
					$Amdcod[$i]=(($val*$imelemc)+($Amdcod[$i]*$imelemd))%26;
					if($Amdcod[$i]<0){
						$Amdcod[$i]=$Amdcod[$i]+26;
					}
				}			
			}
		}
		
		echo 'A-1.X : ';
		foreach($Amdcod as $element){ //Affiche A.X
			echo $element.' ';
		}
		echo '<br>';		
		
		echo 'Decodage : ';
		for($i=0;$i<$dcompt;$i++){ //Convertie les chiffres en lettres et les affichent
			$Amdcod[$i]=ntoa($Amdcod[$i]);
			echo $Amdcod[$i];
		}
		echo '<br>'; 		
	}
 }
 
}


/*echo '\$\$	
\\LARGE cle = \\begin{pmatrix}'
.$melema.'\&'.$melemb.'<br>'.$melemc.'\&'.$melemd.'\end{pmatrix}<br>'
\LARGE det(A) = <?php echo ' ('.$melema.''?> \times <?php echo $melemd.') - ('.$melemc?> \times <?php echo $melemb.') = '.$Gamma ?>\\
\LARGE det(A) \equiv_{26} <?php echo $mod ?> \\
\LARGE PGCD(26,<?php echo $mod ?>)=<?php echo $pgcd ?>\\

\LARGE	A^{-1} \equiv_{26} \begin{pmatrix}
<?php echo $imelema%26 ?>&<?php echo $imelemb%26 ?> \\
<?php echo $imelemc%26 ?>&<?php echo $imelemd%26 ?>
\end{pmatrix} \\
\$\$'; */






}



?>


