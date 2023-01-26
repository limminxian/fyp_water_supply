package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.Spinner;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomnavigation.BottomNavigationView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class updateTasksActivity extends AppCompatActivity {
    BottomNavigationView bottomNavigationView;
    TextView homeownerTV;
    TextView serviceTypeTV;
    TextView descriptionTV;
    TextView addressTV;
    Button scanButton;
    ImageButton logoutBtn;
    ArrayList<TaskModel> TaskModels = new ArrayList<>();
    SharedPreferences sharedPreferences;
    SharedPreferences tasksharedPreferences;
    Spinner statusSpinner;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_tasks);
        logoutBtn = findViewById(R.id.logoutButton);
        //SHARED PREFERENCES
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        tasksharedPreferences = getSharedPreferences("Tasks", MODE_PRIVATE);

        Intent intent = new Intent(getApplicationContext(), loginActivity.class);
        setUpTaskModels();

        //LOGOUT
        logoutBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("logged", "false");
                editor.apply();
                finish();
                startActivity(intent);
            }
        });
        //STATUS SPINNER
        statusSpinner = findViewById(R.id.statusSpinner);
        ArrayAdapter<CharSequence> spinnerAdapter = ArrayAdapter.createFromResource(this, R.array.status_array, android.R.layout.simple_spinner_item);
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        statusSpinner.setAdapter(spinnerAdapter);
        // DATA
        homeownerTV = findViewById(R.id.homeownerTv);
        serviceTypeTV = findViewById(R.id.serviceTv);
        descriptionTV = findViewById(R.id.descTv);
        addressTV = findViewById(R.id.addressTv);
        // Scan Equipment
        scanButton = findViewById(R.id.scanButton);
        scanButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent4 = new Intent("android.media.action.IMAGE_CAPTURE");
                startActivity(intent4);
            }
        });
        //Bottom Navigator View
        bottomNavigationView = findViewById(R.id.bottom_navigator);
        bottomNavigationView.setSelectedItemId(R.id.tasks);
        bottomNavigationView.setOnNavigationItemSelectedListener(item -> {
            switch (item.getItemId()) {
                case R.id.nearMe:
                    Intent intent1 = new Intent(getApplicationContext(), viewWaterUsageActivity.class);
                    startActivity(intent1);
                case R.id.tasks:
                    Intent intent2 = new Intent(getApplicationContext(), viewAssignedTasksActivity.class);
                    startActivity(intent2);
            }
            return false;
        });
    }

    private void setUpTaskModels() {
        String url ="http://192.168.1.10/Technician/task.php";
        //String url = "http://10.33.70.138/Technician/task.php";
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray task = jsonObject.getJSONArray("tasks");
                            for (int i = 0; i < task.length(); i++) {
                                String street = task.getJSONObject(i).getString("STREET");
                                String blockNo = task.getJSONObject(i).getString("BLOCKNO");
                                String unitNo = task.getJSONObject(i).getString("UNITNO");
                                int postalCode = task.getJSONObject(i).getInt("POSTALCODE");
                                String name = task.getJSONObject(i).getString("NAME");
                                String description = task.getJSONObject(i).getString("DESCRIPTION");
                                String serviceType = task.getJSONObject(i).getString("SERVICETYPE");
                                String status = task.getJSONObject(i).getString("STATUS");
                                String area = task.getJSONObject(i).getString("AREA");
                                homeownerTV.setText(name);
                                serviceTypeTV.setText(serviceType);
                                descriptionTV.setText(description);
                                addressTV.setText(String.format("%s %s %s %d", street, blockNo, unitNo, postalCode));
                                //statusSpinner.setSelection(status);
                            }


                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        error.printStackTrace();
                    }
                })
                {
                    protected Map<String, String> getParams(){
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("street", tasksharedPreferences.getString("street",""));
                        paramV.put("blockNo", tasksharedPreferences.getString("blockNo",""));
                        paramV.put("unitNo", tasksharedPreferences.getString("unitNo",""));
                        paramV.put("postalCode", tasksharedPreferences.getString("postalCode",""));
                        paramV.put("name", tasksharedPreferences.getString("name",""));
                        paramV.put("description", tasksharedPreferences.getString("description",""));
                        paramV.put("serviceType", tasksharedPreferences.getString("serviceType",""));
                        paramV.put("status", tasksharedPreferences.getString("status",""));
                        return paramV;
                    }
                };

        //adding our stringrequest to queue
        Volley.newRequestQueue(this).add(stringRequest);
    }

}