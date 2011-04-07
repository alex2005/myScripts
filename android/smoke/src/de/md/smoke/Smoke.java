package de.md.smoke;

import android.app.Activity;
import android.os.Bundle;
import android.widget.TextView;
import java.util.*;

public class Smoke extends Activity {
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        Calendar cal_2 = new GregorianCalendar() ; // aktuelles Datum
        Calendar cal_1 = new GregorianCalendar(2000,Calendar.JUNE,26);  // GregorianCalendar mit vorgegebener Zeit
        long time = cal_2.getTime().getTime() - cal_1.getTime().getTime();  // Differenz in ms
        long days = Math.round( (double)time / (24. * 60.*60.*1000.) );     // Differenz in Tagen

        TextView tv = new TextView(this);
        tv.setText("Nun rauche ich schon " + days + " Tage nicht mehr!");
        setContentView(tv);
        //nteresetContentView(R.layout.main);
        //setContentView(R.layout.main);
    }
}