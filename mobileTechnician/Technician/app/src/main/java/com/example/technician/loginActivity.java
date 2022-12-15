package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class loginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        Button loginBtn = findViewById(R.id.loginBtn);
        loginBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText usernameTxt = findViewById(R.id.usernameTxt);
                EditText passwordTxt = findViewById(R.id.passwordTxt);
                String username = usernameTxt.getText().toString();
                String password = passwordTxt.getText().toString();
                if (username.isEmpty()) {
                    Toast t = Toast.makeText(loginActivity.this, "You must enter username!", Toast.LENGTH_SHORT);
                    t.show();
                }
                if (password.isEmpty()) {
                    Toast t = Toast.makeText(loginActivity.this, "You must enter password!", Toast.LENGTH_SHORT);
                    t.show();
                }
                else {
                    Intent intent = new Intent(getApplicationContext(), viewAssignedTasksActivity.class);
                    intent.putExtra("Username String", username);
                    startActivity(intent);
                }
            }
        });
    }
}