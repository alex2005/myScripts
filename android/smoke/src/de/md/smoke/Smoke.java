package de.md.smoke;

import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import java.util.*;
import android.view.View;
import android.view.View.OnClickListener;

public class Smoke extends Activity {
    private Button closeButton;

	/** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        Calendar cal_2 = new GregorianCalendar() ; // aktuelles Datum
        Calendar cal_1 = new GregorianCalendar(2000,Calendar.JUNE,26);  // GregorianCalendar mit vorgegebener Zeit
        long time = cal_2.getTime().getTime() - cal_1.getTime().getTime();  // Differenz in ms
        long days = Math.round( (double)time / (24. * 60.*60.*1000.) );     // Differenz in Tagen

        //TextView tv = new TextView(this);
        //tv.setText("Nun rauche ich schon " + days + " Tage nicht mehr!");
        //setContentView(tv);
        setContentView(R.layout.main);

        //int count = 5;
        String text = String.format(this.getString(R.string.smokedays), days);
        TextView tv1 = (TextView) findViewById(R.id.smokeausgabe);
        tv1.setText(text);
        
        this.closeButton = (Button)this.findViewById(R.id.close);
        this.closeButton.setOnClickListener(new OnClickListener() {
     		public void onClick(View v) {
			// TODO Auto-generated method stub
			finish();
			
		}
        });
    }
}