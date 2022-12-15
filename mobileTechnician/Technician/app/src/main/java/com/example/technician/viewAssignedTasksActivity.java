package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;

import com.google.android.material.bottomnavigation.BottomNavigationView;

import java.util.ArrayList;

public class viewAssignedTasksActivity extends AppCompatActivity {
    ArrayList<TaskModel> TaskModels = new ArrayList<>();
    int[] editImages = {R.drawable.ic_edit, R.drawable.ic_edit, R.drawable.ic_edit, R.drawable.ic_edit, R.drawable.ic_edit};
    BottomNavigationView bottomNavigationView;
    TextView name;
    ImageButton logoutBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_assigned_tasks);
        name = findViewById(R.id.usernameView);
        logoutBtn = findViewById(R.id.logoutButton);
        Intent intent = getIntent();
        String username = intent.getStringExtra("Username String");
        name.setText(String.format("Hello, %s", username));
        RecyclerView recyclerView = findViewById(R.id.taskRecyclerView);
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
                    intent1.putExtra("Username String", username);
                    startActivity(intent1);
                case R.id.tasks:
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

    private void setUpTaskModels() {
        String[] homeownerNames = getResources().getStringArray(R.array.homeowner_name);
        String[] serviceTypeNames = getResources().getStringArray(R.array.service_type);
        String[] descriptions = getResources().getStringArray(R.array.description);
        String[] addresses = getResources().getStringArray(R.array.address);
        String[] status = getResources().getStringArray(R.array.status);

        for(int i = 0; i<homeownerNames.length; i++ ) {
            TaskModels.add(new TaskModel(homeownerNames[i], serviceTypeNames[i], descriptions[i],
                    addresses[i], status[i], editImages[i]));
        }
    }
}