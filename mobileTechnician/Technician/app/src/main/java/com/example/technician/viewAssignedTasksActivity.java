package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
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

public class viewAssignedTasksActivity extends AppCompatActivity {
    ArrayList<TaskModel> TaskModels = new ArrayList<>();
    BottomNavigationView bottomNavigationView;
    TextView name;
    ImageButton logoutBtn;
    Spinner areaSpinner;
    SharedPreferences sharedPreferences;
    RecyclerView recyclerView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_assigned_tasks);
        recyclerView = findViewById(R.id.taskRecyclerView);
        Intent intent = new Intent(getApplicationContext(), loginActivity.class);
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);

        if (sharedPreferences.getString("logged", "false").equals("false")) {
            startActivity(intent);
            finish();
        }

        //AREA SPINNER
        areaSpinner = findViewById(R.id.areaSpinner);
        ArrayAdapter<CharSequence> spinnerAdapter = ArrayAdapter.createFromResource(this, R.array.area_array, android.R.layout.simple_spinner_item);
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        areaSpinner.setAdapter(spinnerAdapter);

        name = findViewById(R.id.usernameView);
        logoutBtn = findViewById(R.id.logoutButton);
//        Intent intent = getIntent();
//        String username = intent.getStringExtra("Username String");
//        name.setText(String.format("Hello, %s", username));
        setUpTaskModels();
        Task_RecyclerViewAdaptor adaptor = new Task_RecyclerViewAdaptor(this, TaskModels);
        recyclerView.setAdapter(adaptor);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        bottomNavigationView = findViewById(R.id.bottom_navigator);
        bottomNavigationView.setSelectedItemId(R.id.tasks);
        bottomNavigationView.setOnNavigationItemSelectedListener(item -> {
            switch (item.getItemId()) {
                case R.id.nearMe:
                    Intent intent1 = new Intent(getApplicationContext(), viewWaterUsageActivity.class);
//                    intent1.putExtra("Username String", username);
                    startActivity(intent1);
                case R.id.tasks:
//                    name.setText(String.format("Hello, %s", username));
                    return true;
            }
            return false;
        });

        areaSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener()
        {
            public void onItemSelected(AdapterView<?> parent, View view, int pos, long id)
            {
                String selectedItem = areaSpinner.getSelectedItem().toString();
                switch(selectedItem) {
                    case "North":
                        System.out.println("Area: North");
                        break;
                    case "North East":
                        System.out.println("Area: North East");
                        break;
                    case "Central":
                        System.out.println("Area: Central");
                        break;
                    case "East":
                        System.out.println("Area: East");
                        break;
                    case "West":
                        System.out.println("Area: West");
                        break;
                }
            }

            public void onNothingSelected(AdapterView<?> parent)
            {

            }
        });

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
    }

    private void setUpTaskModels() {
        String url ="http://192.168.1.10/Technician/task.php";
        //String url = "http://10.33.70.138/Technician/task.php";
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            //converting the string to json array object
                            JSONArray jsonArray = new JSONArray(response);

                            //traversing through all the object
                            for (int i = 0; i < jsonArray.length(); i++) {

                                //getting product object from json array
                                JSONObject task = jsonArray.getJSONObject(i);

                                //adding the product to product list
                                TaskModels.add(new TaskModel(
                                        task.getString("STREET"),
                                        task.getString("BLOCKNO"),
                                        task.getString("UNITNO"),
                                        task.getInt("POSTALCODE"),
                                        task.getString("NAME"),
                                        task.getString("STATUS"),
                                        task.getString("DESCRIPTION"),
                                        task.getString("SERVICETYPE")
                                ));
                            }

                            //creating adapter object and setting it to recyclerview
                            Task_RecyclerViewAdaptor adapter = new Task_RecyclerViewAdaptor(viewAssignedTasksActivity.this, TaskModels);
                            recyclerView.setAdapter(adapter);
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
    }
}