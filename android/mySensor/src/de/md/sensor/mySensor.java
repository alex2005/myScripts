package de.md.sensor;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

import android.app.Activity;
import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;
import android.os.Bundle;
import android.widget.Toast;
import android.widget.TextView;

public class mySensor extends Activity implements SensorEventListener {
	private SensorManager sensorManager;
//	private float lastX = 0;
//	private float lastY = 0;
//	private float lastZ = 0;
	
	private int lastXW = 0;
	
    public void writeToFile(String filename, String value) {
        
        BufferedWriter bufferedWriter = null;
        
        try {
            
            //Construct the BufferedWriter object
            bufferedWriter = new BufferedWriter(new FileWriter(filename));
            
            //Start writing to the output stream
            bufferedWriter.append(value);
            bufferedWriter.newLine();
            
        } catch (IOException ex) {
            ex.printStackTrace();
        } finally {
            //Close the BufferedWriter
            try {
                if (bufferedWriter != null) {
                    bufferedWriter.flush();
                    bufferedWriter.close();
                }
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    }
  	
	/** Called when the activity is first created. */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		sensorManager = (SensorManager) getSystemService(SENSOR_SERVICE);
		sensorManager.registerListener(this,
				sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER),
				SensorManager.SENSOR_DELAY_NORMAL);

//		Context context = getApplicationContext();
//		CharSequence text = "Application started!";
//		int duration = Toast.LENGTH_LONG;
//		Toast toast = Toast.makeText(context, text, duration);
//		Toast toast = Toast.makeText(context, "Application started!", duration);
//		toast.show();

		Toast toast = Toast.makeText(this, "Application started!", Toast.LENGTH_SHORT);
		toast.show();

	}
	
	@Override
	public void onSensorChanged(SensorEvent event) {
		
		if (event.sensor.getType() == Sensor.TYPE_ACCELEROMETER) {
			float[] values = event.values;
			// Movement
			float x = values[0];
			float y = values[1];
			float z = values[2];

			double accX = -x/SensorManager.GRAVITY_EARTH;
	        double accY = -y/SensorManager.GRAVITY_EARTH;
	        double accZ = z/SensorManager.GRAVITY_EARTH;
	        double totAcc = Math.sqrt((accX*accX)+(accY*accY)+(accZ*accZ));
	         
	        double tiltX = Math.asin(accX/totAcc);
	        double tiltY = Math.asin(accY/totAcc);
	        double tiltZ = Math.asin(accZ/totAcc);
	                 
	        int XW = (int) Math.toDegrees(tiltX);
	        
	        int YW = (int) Math.toDegrees(tiltY);
	        int ZW = (int) Math.toDegrees(tiltZ);
	        
			TextView mTextX = (TextView) findViewById(R.id.x);
			TextView mTextY = (TextView) findViewById(R.id.y);
			TextView mTextZ = (TextView) findViewById(R.id.z);
			TextView mTextXW = (TextView) findViewById(R.id.xw);
			TextView mTextYW = (TextView) findViewById(R.id.yw);
			TextView mTextZW = (TextView) findViewById(R.id.zw);
			
			mTextX.setText(String.valueOf(x));
			mTextY.setText(String.valueOf(y));
			mTextZ.setText(String.valueOf(z));
			mTextXW.setText(String.valueOf(XW));
			mTextYW.setText(String.valueOf(YW));
			mTextZW.setText(String.valueOf(ZW));
			
			if ( Math.abs(lastXW-XW) > 10) {
//				Toast toast = Toast.makeText(this, "Mehr als 11 Grad!", Toast.LENGTH_SHORT);
//				toast.show();
//				buf.append(String.valueOf(ZW));
				writeToFile("/sdcard/winkel.txt", String.valueOf(XW)+":"+String.valueOf(YW)+":"+String.valueOf(ZW));
				lastXW=XW;
			}
			
//			float accelationSquareRoot = (x * x + y * y + z * z)
//					/ (SensorManager.GRAVITY_EARTH * SensorManager.GRAVITY_EARTH);
//			if (accelationSquareRoot >= 4) // twice the accelation of earth
//				Toast.makeText(this, "Device was shuffed", Toast.LENGTH_SHORT)
//				.show();
		}

	}

	@Override
	public void onAccuracyChanged(Sensor sensor, int accuracy) {
		// TODO Auto-generated method stub

	}

	@Override
	protected void onResume() {
		super.onResume();
		// register this class as a listener for the orientation and
		// accelerometer sensors
		sensorManager.registerListener(this,
				sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER),
				SensorManager.SENSOR_DELAY_NORMAL);
	}

	@Override
	protected void onPause() {
		// unregister listener
		sensorManager.unregisterListener(this);
		super.onStop();
	}
}
		