<?php
class DH
{
    //Defined Prime number p and generator g
    private $p=2101111;
    private $g=5;
    
    function keyex($a,$b){
        $r1=fmod(pow($this->g,$a),$this->p);
        print "Public Prime P= ".$this->p."<br/>Public Generator G= ".$this->g."<br/>";
        print "Public Value Sent to Bob= R1 = G<sup>A</sup> mod Prime= ".$r1.'<br/><br/>Private Key of Bob= '.$b.'<br/>';
    $k1=fmod(pow($r1,$b),$this->p);
        print "Final Key= R1<sup>B</sup> mod Prime= "."<b>".$k1."</b>".'<br/>';
    }
}

    session_start();
    include_once "php/config.php";
    
    $b=$_GET['user_id'];$b=fmod($b,100);
    while($b>45)
    {
        $b=$b-4;
    }
    $a = $_SESSION['unique_id'];mysqli_close($conn);
    $a=fmod($a,100);
    while($a>45)
    {
        $a=$a-4;
    }
    print "Private Key of Alice= ".$a."<br/>";
    $keyObj=new DH();
    $key=$keyObj->keyex($a,$b);
    
?>