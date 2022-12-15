package com.example.fyphomeowner;

import androidx.appcompat.app.AppCompatActivity;


import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class loginActivity extends AppCompatActivity implements View.OnClickListener{

    EditText usernameTxt;
    EditText passwordTxt;

    @Override
    public void onClick(View view){
        switch(view.getId()){
            case R.id.loginBtn:
                // verify login method
                usernameTxt = findViewById(R.id.usernameTxt);
                passwordTxt = findViewById(R.id.passwordTxt);
                if(checkNull(usernameTxt.getText().toString(), passwordTxt.getText().toString())){
                    openHomePage();
                }
                else{
                    Toast.makeText(this, "Please fill in all fields", Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.registerPageBtn:
                openRegisterPage();
                break;
            default:
                break;
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        Button loginBtn = findViewById(R.id.loginBtn);
        Button registerPageBtn = findViewById(R.id.registerPageBtn);
        registerPageBtn.setOnClickListener(this);
        loginBtn.setOnClickListener(this);
    }

    public boolean checkNull(String username, String password){
        boolean bool = false;
        if(!TextUtils.isEmpty(username) && !TextUtils.isEmpty(password)){
            bool = true;
        }
        else{
            bool = false;
        }
        return bool;
    }

    public void openRegisterPage(){
        Intent intent = new Intent(this, registerActivity.class);
        startActivity(intent);
    }

    public void openHomePage(){
        Intent intent = new Intent(this, dashboardActivity.class);
        startActivity(intent);
    }
}
