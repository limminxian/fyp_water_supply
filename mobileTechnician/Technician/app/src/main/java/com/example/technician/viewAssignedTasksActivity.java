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
    SharedPreferences tasksharedPreferences;
    RecyclerView recyclerView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_assigned_tasks);
        recyclerView = findViewById(R.id.taskRecyclerView);
        Intent intent = new Intent(getApplicationContext(), loginActivity.class);
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        tasksharedPreferences = getSharedPreferences("Tasks", MODE_PRIVATE);

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
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        setUpTaskModels(areaSpinner.getSelectedItem().toString());
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

        areaSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener()
        {
            public void onItemSelected(AdapterView<?> parent, View view, int pos, long id)
            {
                TaskModels.clear();
                String selectedArea = areaSpinner.getSelectedItem().toString();
                System.out.println("Area selected: " + selectedArea);
                setUpTaskModels(selectedArea);
            }

            public void onNothingSelected(AdapterView<?> parent)
            {
            }
        });
    }


    private void setUpTaskModels(String sArea) {
        String url ="https://fyptechnician.herokuapp.com/task.php";
        url = url + "?area=" + sArea;

        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
//                            //converting the string to json array object
//                            JSONArray jsonArray = new JSONArray(response);
//                            //traversing through all the object
//                            for (int i = 0; i < jsonArray.length(); i++) {
//
//                                //getting product object from json array
//                                JSONObject task = jsonArray.getJSONObject(i);
//
//                                //adding the product to product list
//                                TaskModels.add(new TaskModel(
//                                        task.getString("STREET"),
//                                        task.getString("BLOCKNO"),
//                                        task.getString("UNITNO"),
//                                        task.getInt("POSTALCODE"),
//                                        task.getString("NAME"),
//                                        task.getString("DESCRIPTION"),
//                                        task.getString("SERVICETYPE"),
//                                        task.getString("STATUS"),
//                                        task.getString("AREA")
//                                ));
//                            }
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray task = jsonObject.getJSONArray("tasks");
                                for (int i = 0; i < task.length(); i++) {
                                    String area = task.getJSONObject(i).getString("AREA");
                                        String status1 = task.getJSONObject(i).getString("status");
                                        String street = task.getJSONObject(i).getString("STREET");
                                        String blockNo = task.getJSONObject(i).getString("BLOCKNO");
                                        String unitNo = task.getJSONObject(i).getString("UNITNO");
                                        int postalCode = task.getJSONObject(i).getInt("POSTALCODE");
                                        String name = task.getJSONObject(i).getString("NAME");
                                        String description = task.getJSONObject(i).getString("DESCRIPTION");
                                        String serviceType = task.getJSONObject(i).getString("SERVICETYPE");
                                        String status = task.getJSONObject(i).getString("STATUS");
                                        TaskModels.add(new TaskModel(street, blockNo, unitNo, postalCode, name, description, serviceType, status, area));
                                        SharedPreferences.Editor editor = tasksharedPreferences.edit();
                                        editor.putString("street", street);
                                        editor.putString("blockNo", blockNo);
                                        editor.putString("unitNo", unitNo);
                                        editor.putString("postalCode", String.valueOf(postalCode));
                                        editor.putString("name", name);
                                        editor.putString("description", description);
                                        editor.putString("serviceType", serviceType);
                                        editor.putString("status", status);
                                        editor.apply();
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
              })
                {
                    protected Map<String, String> getParams(){
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("email", sharedPreferences.getString("email",""));
                        return paramV;
                    }
                };

        Volley.newRequestQueue(this).add(stringRequest);

    }
}