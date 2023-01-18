package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.Spinner;
import android.widget.TextView;

import com.google.android.material.bottomnavigation.BottomNavigationView;

public class updateTasksActivity extends AppCompatActivity {
    BottomNavigationView bottomNavigationView;
    TextView homeownerTV;
    TextView serviceTypeTV;
    TextView descriptionTV;
    TextView addressTV;
    Button scanButton;
    ImageButton logoutBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_tasks);
        logoutBtn = findViewById(R.id.logoutButton);
        //SHARED PREFERENCES
        SharedPreferences sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        Intent intent = new Intent(getApplicationContext(), loginActivity.class);
        if (sharedPreferences.getString("logged", "false").equals("false")) {
            startActivity(intent);
            finish();
        }
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
        Spinner statusSpinner = findViewById(R.id.statusSpinner);
        ArrayAdapter<CharSequence> spinnerAdapter = ArrayAdapter.createFromResource(this, R.array.status_array, android.R.layout.simple_spinner_item);
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        statusSpinner.setAdapter(spinnerAdapter);
        // DATA
        homeownerTV = findViewById(R.id.homeownerTv);
        serviceTypeTV = findViewById(R.id.serviceTv);
        descriptionTV = findViewById(R.id.descTv);
        addressTV = findViewById(R.id.addressTv);
        Intent intent4 = getIntent();
        String homeowner = intent4.getStringExtra("homeownerName");
        homeownerTV.setText(String.format("Name: %s", homeowner));
        String serviceType = intent4.getStringExtra("serviceType");
        serviceTypeTV.setText(String.format("Service Type: %s", serviceType));
        String description = intent4.getStringExtra("description");
        descriptionTV.setText(String.format("Description: %s", description));
        String address = intent4.getStringExtra("address");
        addressTV.setText(String.format("Address: %s", address));
        statusSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener()
        {
            public void onItemSelected(AdapterView<?> parent, View view, int pos, long id)
            {

            }

            public void onNothingSelected(AdapterView<?> parent)
            {

            }
        });
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
}