package com.example.technician;

import androidx.annotation.NonNull;
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

import java.sql.SQLOutput;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

public class viewWaterUsageActivity extends AppCompatActivity {
    BottomNavigationView bottomNavigationView;
    TextView name;
    ImageButton logoutBtn;
    TextView month;
    ArrayList<WaterModel> WaterModels = new ArrayList<>();
    Spinner areaSpinner;
    SharedPreferences sharedPreferences;
    SharedPreferences AddresssharedPreferences;
    RecyclerView recyclerView;
    TextView areaText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_water_usage);
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        AddresssharedPreferences = getSharedPreferences("Addresses", MODE_PRIVATE);
        Intent intent = new Intent(getApplicationContext(), loginActivity.class);

        if (sharedPreferences.getString("logged","false").equals("false")){
            startActivity(intent);
            finish();
        }

        name = findViewById(R.id.usernameView);
        logoutBtn = findViewById(R.id.logoutButton);
        month = findViewById(R.id.textViewmonth);
        recyclerView = findViewById(R.id.addressRecyclerView);
        areaSpinner = findViewById(R.id.areaSpinner);
        areaText = findViewById(R.id.areaTxt);

        Calendar cal = Calendar.getInstance();
        //@TODO: remove after testing
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy MM dd");
        try {
            cal.setTime(sdf.parse("2023 02 28"));
        } catch (ParseException e) {
            e.printStackTrace();
        }
        //end of todo
//        if(cal.get(Calendar.DATE) != cal.getActualMaximum(Calendar.DATE)) {
//            areaText.setText("Please visit at month end");
//            recyclerView.setVisibility(View.GONE);
//            areaSpinner.setVisibility(View.GONE);
//        }

        //AREA SPINNER

        ArrayAdapter<CharSequence> spinnerAdapter = ArrayAdapter.createFromResource(this, R.array.area_array, android.R.layout.simple_spinner_item);
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        areaSpinner.setAdapter(spinnerAdapter);


//        Intent intent = getIntent();
//        String username = intent.getStringExtra("Username String");
//        name.setText(String.format("Hello, %s", username));
        Calendar calendar = Calendar.getInstance();
        String currentDate = DateFormat.getDateInstance().format(calendar.getTime());
        String[] splitDate = currentDate.split(",");
        String[] splitMonth = splitDate[0].split(" ");
        month.setText(String.format("Water Usage for %s %s", splitMonth[0], splitDate[1]));
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        setUpWaterModels(areaSpinner.getSelectedItem().toString());
        bottomNavigationView = findViewById(R.id.bottom_navigator);
        bottomNavigationView.setSelectedItemId(R.id.nearMe);
        bottomNavigationView.setOnNavigationItemSelectedListener(item -> {
                switch (item.getItemId()) {
                    case R.id.tasks:
                        Intent intent1 = new Intent(getApplicationContext(), viewAssignedTasksActivity.class);
//                        intent1.putExtra("Username String", username);
                        startActivity(intent1);
                    case R.id.nearMe:
//                        name.setText(String.format("Hello, %s", username));
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
                WaterModels.clear();
                String selectedArea = areaSpinner.getSelectedItem().toString();
                setUpWaterModels(selectedArea);
            }

            public void onNothingSelected(AdapterView<?> parent)
            {
            }
        });
    }
    private void setUpWaterModels(String sArea) {
        //String url ="https://fyptechnician.herokuapp.com/viewAddress.php";
        String url ="http://192.168.1.10/Technician/viewAddress.php";
        url = url + "?area=" + sArea;
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray address = jsonObject.getJSONArray("addresses");
                            for (int i = 0; i < address.length(); i++) {
                                String status = address.getJSONObject(i).getString("status");
                                int homeownerId = address.getJSONObject(i).getInt("ID");
                                String street = address.getJSONObject(i).getString("STREET");
                                String blockNo = address.getJSONObject(i).getString("BLOCKNO");
                                int postalCode = address.getJSONObject(i).getInt("POSTALCODE");
                                String area = address.getJSONObject(i).getString("AREA");
                                String housetype = address.getJSONObject(i).getString("HOUSETYPE");
                                WaterModels.add(new WaterModel(homeownerId, street, blockNo, null, postalCode, 0, area, housetype));
                                SharedPreferences.Editor editor = AddresssharedPreferences.edit();
                                editor.putInt("homeownerId", homeownerId);
                                editor.putString("street", street);
                                editor.putString("blockNo", blockNo);
                                editor.putInt("postalCode", postalCode);
                                editor.putString("area", area);
                                editor.putString("houseType", housetype);
                                editor.apply();
                            }

                            //creating adapter object and setting it to recyclerview
                            viewWaterRecyclerViewAdaptor adapter = new viewWaterRecyclerViewAdaptor(viewWaterUsageActivity.this, WaterModels);
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