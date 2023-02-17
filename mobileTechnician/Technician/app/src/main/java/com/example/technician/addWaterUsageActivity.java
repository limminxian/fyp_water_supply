package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.InputFilter;
import android.text.Spanned;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
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
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class addWaterUsageActivity extends AppCompatActivity {
    BottomNavigationView bottomNavigationView;
    ImageButton logoutBtn;
    ArrayList<WaterModel> WaterModels = new ArrayList<>();
    SharedPreferences sharedPreferences;
    SharedPreferences AddresssharedPreferences;
    RecyclerView recyclerView;
    int postalCode;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_water_usage);
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        AddresssharedPreferences = getSharedPreferences("Addresses", MODE_PRIVATE);
        Intent intent = new Intent(getApplicationContext(), loginActivity.class);
        logoutBtn = findViewById(R.id.logoutButton);
        recyclerView = findViewById(R.id.waterRecyclerView);
        setUpWaterModels();
        if (sharedPreferences.getString("logged","false").equals("false")){
            startActivity(intent);
            finish();
        }

        //Bottom Navigator View
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
                    Intent intent2 = new Intent(getApplicationContext(), viewWaterUsageActivity.class);
//                        intent1.putExtra("Username String", username);
                    startActivity(intent2);
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
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
    }

    private void setUpWaterModels() {
        //String url ="http://192.168.1.10/Technician/viewHousesbyPostalCode.php";
        String url ="https://fyptechnician.herokuapp.com/viewHousesbyPostalCode.php";
        url = url + "?postalCode=" + getIntent().getIntExtra("postalCode", 0);
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray address = jsonObject.getJSONArray("addresses");
                            for (int i = 0; i < address.length(); i++) {
                                JSONObject addressJSONObj = address.getJSONObject(i);
                                String status = addressJSONObj.getString("status");
                                int homeownerId = addressJSONObj.getInt("ID");
                                String street = addressJSONObj.getString("STREET");
                                String unitNo = addressJSONObj.getString("UNITNO");
                                String houseType = addressJSONObj.getString("HOUSETYPE");
                                float waterUsage = addressJSONObj.isNull("WATERUSAGE") ?
                                        0f : (float) addressJSONObj.getDouble("WATERUSAGE") ;
                                WaterModels.add(new WaterModel(homeownerId, street, null, unitNo, postalCode, waterUsage, null, houseType));
                            }
                            //creating adapter object and setting it to recyclerview
                            addWaterRecyclerViewAdaptor adapter = new addWaterRecyclerViewAdaptor(addWaterUsageActivity.this, WaterModels);
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