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
    public static TextView serialID;
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
        serialID = findViewById(R.id.serialID);
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
        statusArray.add("open");
        statusArray.add("close");
        ArrayAdapter<String> statusAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_dropdown_item, statusArray);
        statusSpinner.setAdapter(statusAdapter);
        // DATA
        homeownerTV = findViewById(R.id.homeownerTv);
        serviceTypeTV = findViewById(R.id.serviceTv);
        descriptionTV = findViewById(R.id.descTv);
        addressTV = findViewById(R.id.addressTv);
        // Scan Equipment
        scanButton = findViewById(R.id.scanButton);
        scanButton.setVisibility(View.GONE);
        serialID.setVisibility(View.GONE);
        String intentServiceType = getIntent().getStringExtra("serviceType");
        scanButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), scanBarCodeActivity.class);
                String intentServiceType = getIntent().getStringExtra("serviceType");
                intent.putExtra("serviceType", intentServiceType);
                startActivity(intent);
            }
        });
        //db
        //String url = "http://192.168.1.10/Technician/viewTask.php";
        String url ="https://fyptechnician.herokuapp.com/viewTask.php";
        //url = url + "?ticketID=" + tasksharedPreferences.getInt("ticketId",0);
        url = url + "?ticketID=" + getIntent().getIntExtra("ticketId", 0);
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
                                int serviceTypeID = task.getJSONObject(i).getInt("SERVICETYPEID");
                                String status = task.getJSONObject(i).getString("STATUS");
                                SharedPreferences.Editor editor = tasksharedPreferences.edit();
                                editor.putInt("serviceTypeID", serviceTypeID);
                                editor.apply();
                                homeownerTV.setText(String.format("Name: %s", name));
                                serviceTypeTV.setText(String.format("Service Type: %s", serviceType));
                                descriptionTV.setText(String.format("Description: %s", description));
                                if(unitNo == null || unitNo.equals("null") || unitNo.isEmpty()) {
                                    addressTV.setText(String.format("Address: %s %s", street, postalCode));
                                } else {
                                    addressTV.setText(String.format("Address: %s %s %s %s", blockNo, street,
                                            unitNo, postalCode));
                                }
                                statusSpinner.setSelection(statusAdapter.getPosition(status));
                                if(status.equals("close")){
                                    updateButton.setVisibility(View.GONE);
                                    scanButton.setVisibility(View.GONE);
                                }
                                if(serviceType.equals("installation") || serviceType.equals("uninstallation")) {
                                   scanButton.setVisibility(View.VISIBLE);
                                   serialID.setVisibility(View.VISIBLE);
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
                });

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
                //String url ="http://192.168.1.10/Technician/updateTask.php";
                //String url ="https://fyptechnician.herokuapp.com/updateTask.php";
                String url ="https://fyptechnician.herokuapp.com/generateBillForTask.php";
                String status = statusSpinner.getSelectedItem().toString();
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                if(response.equals("Successfully updated ticketSuccessfully updated workloadSuccessfully inserted bill")){
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
                        paramV.put("ticketId", String.valueOf(getIntent().getIntExtra("ticketId", 0)));
                        paramV.put("serviceType", String.valueOf(tasksharedPreferences.getInt("serviceTypeID",0)));
                        paramV.put("technicianId", String.valueOf(sharedPreferences.getInt("technicianID",0)));
                        System.out.println("ticketId" + getIntent().getIntExtra("ticketId", 0));
                        System.out.println("serviceType" + tasksharedPreferences.getInt("serviceTypeID",0));
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            }
        });
    }
}