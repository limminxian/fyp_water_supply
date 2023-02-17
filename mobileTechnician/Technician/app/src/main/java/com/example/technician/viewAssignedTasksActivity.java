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

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomnavigation.BottomNavigationView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.ZoneId;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Date;
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
        Intent intent = new Intent(getApplicationContext(), loginActivity.class);
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        tasksharedPreferences = getSharedPreferences("Tasks", MODE_PRIVATE);

        if (sharedPreferences.getString("logged","false").equals("false")){
            startActivity(intent);
            finish();
        }

        //AREA SPINNER
        areaSpinner = findViewById(R.id.areaSpinner);
        ArrayList<String> areaArray = new ArrayList<>();
        areaArray.add("north");
        areaArray.add("northeast");
        areaArray.add("central");
        areaArray.add("east");
        areaArray.add("west");

        ArrayAdapter<String> areaAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_dropdown_item, areaArray);
        areaSpinner.setAdapter(areaAdapter);


        name = findViewById(R.id.usernameView);
        logoutBtn = findViewById(R.id.logoutButton);
        recyclerView = findViewById(R.id.taskRecyclerView);
//        Intent intent = getIntent();
//        String username = intent.getStringExtra("Username String");
//        name.setText(String.format("Hello, %s", username));
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
//        setUpTaskModels(areaSpinner.getSelectedItem().toString());
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
                //System.out.println("Area selected: " + selectedArea);
                areaSpinner.setSelection(areaAdapter.getPosition(selectedArea));
                setUpTaskModels(selectedArea);
            }

            public void onNothingSelected(AdapterView<?> parent)
            {
            }
        });
    }

    private void setUpTaskModels(String sArea) {
        String url ="https://fyptechnician.herokuapp.com/task.php";
        System.out.println("tech ID check : " + sharedPreferences.getInt("technicianID",0));
        //String url ="http://192.168.1.10/Technician/task.php";
        url = url + "?area=" + sArea + "&technicianID=" + sharedPreferences.getInt("technicianID",0);

        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray task = jsonObject.getJSONArray("tasks");
                                for (int i = 0; i < task.length(); i++) {
                                    String serviceDateStr = task.getJSONObject(i).getString("SERVICEDATE");
                                    DateTimeFormatter sdf = DateTimeFormatter.ofPattern("yyyy-MM-dd");
                                    LocalDate serviceDate = LocalDate.parse(serviceDateStr, sdf);
                                    ZoneId zone = ZoneId.of( "Singapore" ) ;
                                    LocalDate currentDate = LocalDate.now(zone);
//                                    System.out.println("service Date " + serviceDate);
//                                    System.out.println("current Date " + currentDate);
                                    if(serviceDate.isEqual(currentDate)) {
                                        String area = task.getJSONObject(i).getString("AREA");
                                        String status1 = task.getJSONObject(i).getString("status");
                                        int taskId = task.getJSONObject(i).getInt("TASKID");
                                        int ticketId = task.getJSONObject(i).getInt("ID");
                                        int homeownerId = task.getJSONObject(i).getInt("HOMEOWNERID");
                                        String street = task.getJSONObject(i).getString("STREET");
                                        String blockNo = task.getJSONObject(i).getString("BLOCKNO");
                                        String unitNo = task.getJSONObject(i).getString("UNITNO");
                                        int postalCode = task.getJSONObject(i).getInt("POSTALCODE");
                                        String name = task.getJSONObject(i).getString("NAME");
                                        String description = task.getJSONObject(i).getString("DESCRIPTION");
                                        String serviceType = task.getJSONObject(i).getString("SERVICETYPE");
                                        String status = task.getJSONObject(i).getString("STATUS");
                                        TaskModels.add(new TaskModel(ticketId, name, serviceType, description, street, blockNo, unitNo, postalCode, status, area, serviceDate));
                                        SharedPreferences.Editor editor = tasksharedPreferences.edit();
                                        editor.putInt("taskId", taskId);
                                        editor.putInt("homeownerId", homeownerId);
                                        editor.putInt("ticketId", ticketId);
                                        editor.putString("street", street);
                                        editor.putString("blockNo", blockNo);
                                        editor.putString("unitNo", unitNo);
                                        editor.putInt("postalCode", postalCode);
                                        editor.putString("name", name);
                                        editor.putString("description", description);
                                        editor.putString("serviceType", serviceType);
                                        editor.putString("status", status);
                                        editor.putString("area", area);
                                        editor.apply();
                                    }
                                }
                            //creating adapter object and setting it to recyclerview
                            taskRecyclerViewAdaptor adapter = new taskRecyclerViewAdaptor(viewAssignedTasksActivity.this, TaskModels);
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

        Volley.newRequestQueue(this).add(stringRequest);

    }
}