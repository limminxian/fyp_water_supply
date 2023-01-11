package com.example.fyphomeowner;

import androidx.appcompat.app.AppCompatActivity;


import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class loginActivity extends AppCompatActivity implements View.OnClickListener{

    EditText emailTxt;
    EditText passwordTxt;
    SharedPreferences sharedPreferences;

    @Override
    public void onClick(View view){
        switch(view.getId()){
            case R.id.loginBtn:
                // verify login method
                emailTxt = findViewById(R.id.emailTxt);
                passwordTxt = findViewById(R.id.passwordTxt);
                String email = String.valueOf(emailTxt.getText());
                String password = String.valueOf(passwordTxt.getText());

                //Creating a post request
                RequestQueue queue = Volley.newRequestQueue(this);
                String url ="http://192.168.1.168/fyp/loginRequest.php";

                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try{
                                //Log.i("tagconvertstr", "["+response+"]");
                                JSONObject jsonObject = new JSONObject(response);
                                String status = jsonObject.getString("status");
                                String message = jsonObject.getString("message");
                                String userID = jsonObject.getString("userID");
                                if(status.equals("success")){
                                    SharedPreferences.Editor editor = sharedPreferences.edit();
                                    editor.putString("logged", "true");
                                    editor.putString("userID", userID);
                                    editor.apply();
                                    openHomePage();
                                }
                                else{
                                    Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();
                                }
                            }
                            catch (JSONException e){
                                e.printStackTrace();
                            }
                        }
                    }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        //SET THE ERROR MESSAGE HERE
                        Toast.makeText(getApplicationContext(), error.getLocalizedMessage(), Toast.LENGTH_SHORT).show();
//                        progressBar.setVisibility(View.GONE);
//                        textViewError.setText(error.getLocalizedMessage());
//                        textViewError.setVisibility(View.VISIBLE);
                    }
                }){
                    protected Map<String, String> getParams(){
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("email", email);
                        paramV.put("password", password);
                        return paramV;
                    }
                };
                queue.add(stringRequest);
                //end of creating post req

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
        sharedPreferences = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        registerPageBtn.setOnClickListener(this);
        loginBtn.setOnClickListener(this);

        //if user is logged in, then redirect to the main activity
        if (sharedPreferences.getString("logged","false").equals("true")){
            openHomePage();
        }

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
