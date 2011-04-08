public class wuerfel
{
private int wert;
public wuerfel(){}

public void wuerfeln()
{
wert =(int) (Math.random() * 6+1 ); // Math.random erzeugt eine Zufallszahl x
// mit 0 <= x < 1

}

public int getWert()
{
return wert;
}

}
