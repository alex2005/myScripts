#include <stdio.h>
#include <stdlib.h>
#include <time.h>

main()
{
char *str, help[20];
long value1 ,value = 10;

struct tm begin = {0,0,0,26,5,100,1};
//{0,0,0,tag,monat:0=jan;11=dez,jahr,wochentag} entspricht dem 26. Juni 2000,Montags


time_t heute, begin_int=0;


//str = asctime(&begin);
begin_int = mktime(&begin);


value = value1 = time(&heute);
value = value - begin_int;
value = value/60; //=minuten
value = value/60; //=stunden
value = value/24; //=tage


sprintf(help, "%ld", value);
//strcat (str, help);
printf("\nJetzt rauche ich schon %s Tage nicht mehr!\n\n", help);
//printf("Mal schauen: %s Tage \n%s\n", help, str);

}



