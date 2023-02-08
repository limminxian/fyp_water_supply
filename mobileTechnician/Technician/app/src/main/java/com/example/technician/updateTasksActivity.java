package com.example.technician;

import androidx.activity.result.ActivityResultLauncher;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
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
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
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
    Button updateButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_tasks);
        logoutBtn = findViewById(R.id.logoutButton);
        updateButton = findViewById(R.id.update);
        //SHARED PREFERENCES
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        tasksharedPreferences = getSharedPreferences("Tasks", MODE_PRIVATE);

        Intent intent = new Intent(getApplicationContext(), loginActivity.class);

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
        ArrayList<String> statusArray = new ArrayList<>();
        statusArray.add("Open");
        statusArray.add("Close");
        ArrayAdapter<String> statusAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_dropdown_item, statusArray);
        statusSpinner.setAdapter(statusAdapter);
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
        //db
        //String url = "http://192.168.1.10/Technician/viewTask.php";
        String url ="https://fyptechnician.herokuapp.com/viewTask.php";
        Intent intent3 = getIntent();
        String ticketID = String.valueOf(intent3.getIntExtra("ticketID", 0));
        url = url + "?ticketID=" + ticketID;
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray task = jsonObject.getJSONArray("tasks");
                            for (int i = 0; i < task.length(); i++) {
                                int ticketId = task.getJSONObject(i).getInt("ID");
                                String street = task.getJSONObject(i).getString("STREET");
                                String blockNo = task.getJSONObject(i).getString("BLOCKNO");
                                String unitNo = task.getJSONObject(i).getString("UNITNO");
                                int postalCode = task.getJSONObject(i).getInt("POSTALCODE");
                                String name = task.getJSONObject(i).getString("NAME");
                                String description = task.getJSONObject(i).getString("DESCRIPTION");
                                String serviceType = task.getJSONObject(i).getString("SERVICETYPE");
                                String status = task.getJSONObject(i).getString("STATUS");
                                homeownerTV.setText(String.format("Name: %s", name));
                                serviceTypeTV.setText(String.format("Service Type: %s", serviceType));
                                descriptionTV.setText(String.format("Description: %s", description));
                                addressTV.setText(String.format("Address: %s %s %s %d", street, blockNo,unitNo, postalCode));
                                statusSpinner.setSelection(statusAdapter.getPosition(status));
                                if(status.equals("Close")){
                                    updateButton.setVisibility(View.GONE);
                                }
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
                paramV.put("ticketId", String.valueOf(tasksharedPreferences.getInt("ticketId",0)));
                paramV.put("street", tasksharedPreferences.getString("street",""));
                paramV.put("blockNo", tasksharedPreferences.getString("blockNo",""));
                paramV.put("unitNo", tasksharedPreferences.getString("unitNo",""));
                paramV.put("postalCode", String.valueOf(tasksharedPreferences.getInt("postalCode",0)));
                paramV.put("name", tasksharedPreferences.getString("name",""));
                paramV.put("description", tasksharedPreferences.getString("description",""));
                paramV.put("serviceType", tasksharedPreferences.getString("serviceType",""));
                paramV.put("status", tasksharedPreferences.getString("status",""));
                paramV.put("area", tasksharedPreferences.getString("area",""));
                return paramV;
            }
        };

        //adding our stringrequest to queue
        Volley.newRequestQueue(this).add(stringRequest);
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

        updateButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                String url ="http://192.168.1.10/Technician/updateTask.php";
                //String url ="https://fyptechnician.herokuapp.com/updateTask.php";
                String status = statusSpinner.getSelectedItem().toString();
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                if(response.equals("Status edited successfully")){
                                    Log.i("tagconvertstr", "["+response+"]");
                                    Toast.makeText(getApplicationContext(), " Status is updated", Toast.LENGTH_SHORT).show();
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
                        paramV.put("status", status);
                        paramV.put("ticketId", String.valueOf(tasksharedPreferences.getInt("ticketId",0)));
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            }
        });
    }
}