package com.example.technician;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
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

public class loginActivity extends AppCompatActivity {
    String username, password, name;
    TextView textViewError;
    SharedPreferences sharedPreferences;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        Button loginBtn = findViewById(R.id.loginBtn);
        sharedPreferences = getSharedPreferences("MyAppName", MODE_PRIVATE);
        Intent intent = new Intent(getApplicationContext(), viewAssignedTasksActivity.class);
        if (sharedPreferences.getString("logged","false").equals("true")){
            startActivity(intent);
            finish();
        }
        loginBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText usernameTxt = findViewById(R.id.usernameTxt);
                EditText passwordTxt = findViewById(R.id.passwordTxt);
                username = usernameTxt.getText().toString();
                password = passwordTxt.getText().toString();
                textViewError = findViewById(R.id.error);
                RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                String url ="http://192.168.1.10/Technician/login.php";
                //String url = "http://10.33.70.138/Technician/login.php";
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                textViewError.setVisibility(View.GONE);
                                try {
                                    Log.i("tagconvertstr", "["+response+"]");
                                    JSONObject jsonObject = new JSONObject(response);
                                    String status = jsonObject.getString("status");
                                    String message = jsonObject.getString("message");
                                    if(status.equals("success")) {
                                        name = jsonObject.getString("NAME");
                                        username = jsonObject.getString("EMAIL");
                                        password = jsonObject.getString("PASSWORD");
                                        SharedPreferences.Editor editor = sharedPreferences.edit();
                                        editor.putString("logged", "true");
                                        editor.putString("name", name);
                                        editor.putString("email", username);
                                        editor.putString("password", password);
                                        editor.apply();
                                        startActivity(intent);
                                        finish();
                                    }
                                    else {
                                        textViewError.setText(message);
                                        textViewError.setVisibility(View.VISIBLE);
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        textViewError.setText(error.getLocalizedMessage());
                        textViewError.setVisibility(View.VISIBLE);
                    }
                }){
                    protected Map<String, String> getParams(){
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("EMAIL", username);
                        paramV.put("PASSWORD", password);
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            }
            //}
        });
    }
}