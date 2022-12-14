package com.example.technician;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ImageButton;
import android.widget.Spinner;
import android.widget.TextView;

import com.google.android.material.bottomnavigation.BottomNavigationView;

import java.sql.SQLOutput;
import java.text.DateFormat;
import java.util.Calendar;
import java.util.Date;

public class viewWaterUsageActivity extends AppCompatActivity {
    BottomNavigationView bottomNavigationView;
    TextView name;
    ImageButton logoutBtn;
    TextView month;
    TextView month1;
    Spinner areaSpinner;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_water_usage);

        //AREA SPINNER
        areaSpinner = findViewById(R.id.areaSpinner);
        ArrayAdapter<CharSequence> spinnerAdapter = ArrayAdapter.createFromResource(this, R.array.area_array, android.R.layout.simple_spinner_item);
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        areaSpinner.setAdapter(spinnerAdapter);

        name = findViewById(R.id.usernameView);
        logoutBtn = findViewById(R.id.logoutButton);
        Intent intent = getIntent();
        String username = intent.getStringExtra("Username String");
        name.setText(String.format("Hello, %s", username));
        Calendar calendar = Calendar.getInstance();
        String currentDate = DateFormat.getDateInstance().format(calendar.getTime());
        String[] splitDate = currentDate.split(",");
        String[] splitMonth = splitDate[0].split(" ");
        bottomNavigationView = findViewById(R.id.bottom_navigator);
        bottomNavigationView.setSelectedItemId(R.id.nearMe);
        bottomNavigationView.setOnNavigationItemSelectedListener(item -> {
                switch (item.getItemId()) {
                    case R.id.tasks:
                        Intent intent1 = new Intent(getApplicationContext(), viewAssignedTasksActivity.class);
                        intent1.putExtra("Username String", username);
                        startActivity(intent1);
                    case R.id.nearMe:
                        name.setText(String.format("Hello, %s", username));
                        return true;
                }
                return false;
        });
        logoutBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), loginActivity.class);
                startActivity(intent);
            }
        });
    }
}