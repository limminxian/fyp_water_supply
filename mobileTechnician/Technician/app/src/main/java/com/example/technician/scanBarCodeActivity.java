package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.zxing.Result;

import java.util.HashMap;
import java.util.Map;

import me.dm7.barcodescanner.zxing.ZXingScannerView;

public class scanBarCodeActivity extends AppCompatActivity implements ZXingScannerView.ResultHandler {
    ZXingScannerView ScannerView;
    SharedPreferences tasksharedPreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        ScannerView = new ZXingScannerView(this);
        setContentView(ScannerView);
        tasksharedPreferences = getSharedPreferences("Tasks", MODE_PRIVATE);
    }

    @Override
    public void handleResult(Result result) {
        updateTasksActivity.serialID.setText(String.format("Serial Code: %s", result.getText()));
        String serviceType = getIntent().getStringExtra("serviceType");
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        //String url ="http://192.168.1.10/Technician/updateTask.php";
        String url ="https://fyptechnician.herokuapp.com/updateStock.php";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        if(response.equals("Equipment row is added")){
                            Log.i("tagconvertstr", "["+response+"]");
                        } else {
                            Log.i("tagconvertstr", "["+response+"]");
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                error.printStackTrace();
            }
        }) {
            protected Map<String, String> getParams() {
                Map<String, String> paramV = new HashMap<>();
                paramV.put("serial", result.getText());
                paramV.put("taskId", String.valueOf(tasksharedPreferences.getInt("taskId", 0)));
                paramV.put("homeownerId", String.valueOf(tasksharedPreferences.getInt("homeownerId", 0)));
                paramV.put("serviceType", serviceType);
                return paramV;
            }
        };
        queue.add(stringRequest);
        onBackPressed();
    }

    @Override
    protected void onPause() {
        super.onPause();
        ScannerView.stopCamera();
    }


    @Override
    protected void onResume() {
        super.onResume();
        ScannerView.setResultHandler(this);
        ScannerView.startCamera();
    }
}