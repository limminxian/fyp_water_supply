package com.example.fyphomeowner;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;


import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
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

public class loginActivity extends AppCompatActivity implements View.OnClickListener{

    private EditText emailTxt;
    private EditText passwordTxt;
    private SharedPreferences sharedPreferences;
    private SharedPreferences verificationSharedPreferences;
    private Button loginBtn;
    private Button verificationBtn;
    private Button registerPageBtn;
    private TextView forgotPasswordMsg;
    private Button forgotPasswordBtn;
    InputMethodManager imm;

    @Override
    public void onClick(View view){
        switch(view.getId()){
            case R.id.loginBtn:
                //CLOSE KEYBOARD
                try{
                    imm.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(), 0);
                }
                catch(Exception e){
                }

                emailTxt = findViewById(R.id.emailTxt);
                passwordTxt = findViewById(R.id.passwordTxt);
                String email = String.valueOf(emailTxt.getText());
                String password = String.valueOf(passwordTxt.getText());

                //Creating a post request
                RequestQueue queue = Volley.newRequestQueue(this);
                String url ="https://fyphomeowner.herokuapp.com/loginRequest.php";

                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try{
                                Log.i("tagconvertstr", "["+response+"]");
                                JSONObject jsonObject = new JSONObject(response);
                                String status = jsonObject.getString("status");
                                String message = jsonObject.getString("message");
                                if(status.equals("success")){
                                    verificationBtn.setVisibility(View.GONE);
                                    forgotPasswordMsg.setVisibility(View.GONE);
                                    forgotPasswordBtn.setVisibility(View.GONE);
                                    String userID = jsonObject.getString("userID");
                                    SharedPreferences.Editor editor = sharedPreferences.edit();
                                    editor.putString("logged", "true");
                                    editor.putString("userID", userID);
                                    editor.apply();
                                    openHomePage();
                                }
                                else if(status.equals("verify")){
                                    String email = jsonObject.getString("email");
                                    verificationBtn.setVisibility(View.VISIBLE);
                                    forgotPasswordMsg.setVisibility(View.GONE);
                                    forgotPasswordBtn.setVisibility(View.GONE);
                                    SharedPreferences.Editor editor = verificationSharedPreferences.edit();
                                    editor.putString("email", email);
                                    editor.apply();
                                    Toast.makeText(loginActivity.this, "Please verify acc first", Toast.LENGTH_SHORT).show();
                                }
                                else if(status.equals("wrong password")){
                                    verificationBtn.setVisibility(View.GONE);
                                    forgotPasswordMsg.setVisibility(View.VISIBLE);
                                    forgotPasswordBtn.setVisibility(View.VISIBLE);
                                    String userID = jsonObject.getString("userID");
                                    forgotPasswordBtn.setOnClickListener(new View.OnClickListener() {
                                        @Override
                                        public void onClick(View v) {
                                            sendVerification(userID, "null");
                                            showPopupWindowClick(v, userID);
                                        }
                                    });
                                    Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();
                                }
                                else{
                                    verificationBtn.setVisibility(View.GONE);
                                    forgotPasswordMsg.setVisibility(View.GONE);
                                    forgotPasswordBtn.setVisibility(View.GONE);
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

            case R.id.verificationBtn:
                String emailStr = verificationSharedPreferences.getString("email", "");
                sendVerification("null", emailStr);
                openVerificationPage();
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
        loginBtn = findViewById(R.id.loginBtn);
        verificationBtn = findViewById(R.id.verificationBtn);
        registerPageBtn = findViewById(R.id.registerPageBtn);
        forgotPasswordMsg = findViewById(R.id.forgotPasswordMsg);
        forgotPasswordBtn = findViewById(R.id.forgotPasswordBtn);
        imm = (InputMethodManager)getSystemService(INPUT_METHOD_SERVICE);
        sharedPreferences = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        verificationSharedPreferences = getSharedPreferences("verificationPref", MODE_PRIVATE);

        registerPageBtn.setOnClickListener(this);
        loginBtn.setOnClickListener(this);
        verificationBtn.setOnClickListener(this);
        verificationBtn.setVisibility(View.GONE);
        forgotPasswordMsg.setVisibility(View.GONE);
        forgotPasswordBtn.setVisibility(View.GONE);

        //if user is logged in, then redirect to the main activity
        if (sharedPreferences.getString("logged","false").equals("true")){
            openHomePage();
        }

    }

    //Popup window method
    public void showPopupWindowClick(View view, String userID) {

        // inflate the layout of the popup window
        LayoutInflater inflater = (LayoutInflater)
                getSystemService(LAYOUT_INFLATER_SERVICE);
        View popupView = inflater.inflate(R.layout.verification_popup_window, null);

        // create the popup window
        int width = LinearLayout.LayoutParams.WRAP_CONTENT;
        int height = LinearLayout.LayoutParams.WRAP_CONTENT;
        boolean focusable = true; // lets taps outside the popup also dismiss it
        final PopupWindow popupWindow = new PopupWindow(popupView, width, height, focusable);

        // show the popup window
        // which view you pass in doesn't matter, it is only used for the window token
        popupWindow.showAtLocation(view, Gravity.CENTER, 0, 0);

        // dismiss the popup window when touched
        popupView.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                popupWindow.dismiss();
                return true;
            }
        });

        popupWindow.setOnDismissListener(new PopupWindow.OnDismissListener(){
            @Override
            public void onDismiss(){
                forgotPasswordMethod(userID);
            }
        });
    }

    public void sendVerification(String userID, String email){
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/verificationCodeRequest.php";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try{
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            String message = jsonObject.getString("message");
                            if(status.equals("success")){
                                Log.i("tagconvertstr", "["+response+"]");
                                String email = jsonObject.getString("email");
                                String verificationCode = jsonObject.getString("verificationCode");
                                sendEmail(email, verificationCode);
                            }
                            else{
                                Log.d("error", response);
                                Toast.makeText(loginActivity.this, response, Toast.LENGTH_SHORT).show();
                            }
                        }
                        catch (JSONException e){
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                error.printStackTrace();
            }
        })
        {
            protected Map<String, String> getParams() {
                Map<String, String> paramV = new HashMap<>();
                paramV.put("userID", userID);
                paramV.put("email", email);
                return paramV;
            }
        };
        queue.add(stringRequest);
    }

    public void sendEmail(String email, String verificationCode){
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/sendEmail.php";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        if (response.equals("success")){
                            Log.d("its a: ", response);
                        }
                        else {
                            Log.d("error", response);
                            Toast.makeText(loginActivity.this, response, Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                error.printStackTrace();
            }
        })
        {
            protected Map<String, String> getParams() {
                Map<String, String> paramV = new HashMap<>();
                paramV.put("email", email);
                paramV.put("message", "Verification code is "+verificationCode);
                System.out.println(email);
                System.out.println(verificationCode);
                return paramV;
            }
        };
        queue.add(stringRequest);
    }

    public void forgotPasswordMethod(String userID){
        AlertDialog.Builder builder = new AlertDialog.Builder(loginActivity.this);
        final View resetPasswordLayout = getLayoutInflater().inflate(R.layout.reset_password_alert_dialog, null);
        builder.setView(resetPasswordLayout);
        builder.setPositiveButton("Confirm", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {}
        });
        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {}
        });
        AlertDialog alertDialog = builder.create();
        alertDialog.setOnShowListener(new DialogInterface.OnShowListener() {
            @Override
            public void onShow(DialogInterface dialogInterface) {
                Button posBtn = ((AlertDialog) alertDialog).getButton(AlertDialog.BUTTON_POSITIVE);
                posBtn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        // TODO Do something
                        EditText verifyCodeTxt = resetPasswordLayout.findViewById(R.id.verifyCodeTxt);
                        EditText newPasswordTxt = resetPasswordLayout.findViewById(R.id.newPasswordTxt);
                        EditText rePasswordTxt = resetPasswordLayout.findViewById(R.id.rePasswordTxt);
                        String verifyCode = verifyCodeTxt.getText().toString();
                        String newPassword = newPasswordTxt.getText().toString();
                        String rePassword = rePasswordTxt.getText().toString();

                        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                        String url = "https://fyphomeowner.herokuapp.com/resetPasswordRequest.php";
                        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                                new Response.Listener<String>() {
                                    @Override
                                    public void onResponse(String response) {
                                        if (response.equals("success")){
                                            Toast.makeText(loginActivity.this, "password changed successfully", Toast.LENGTH_SHORT).show();
                                            alertDialog.dismiss();
                                        }
                                        else {
                                            Log.d("error", response);
                                            Toast.makeText(loginActivity.this, response, Toast.LENGTH_SHORT).show();
                                        }
                                    }
                                }, new Response.ErrorListener() {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                error.printStackTrace();
                            }
                        })
                        {
                            protected Map<String, String> getParams() {
                                Map<String, String> paramV = new HashMap<>();
                                paramV.put("userID", userID);
                                paramV.put("verifyCode", verifyCode);
                                paramV.put("newPassword", newPassword);
                                paramV.put("rePassword", rePassword);
                                return paramV;
                            }
                        };
                        queue.add(stringRequest);
                    }
                });
                Button negBtn = ((AlertDialog) alertDialog).getButton(AlertDialog.BUTTON_NEGATIVE);
                negBtn.setOnClickListener(new View.OnClickListener() {

                    @Override
                    public void onClick(View view) {
                        alertDialog.dismiss();
                    }
                });
            }
        });
        alertDialog.show();
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
        finish();
    }

    public void openVerificationPage(){
        Intent intent = new Intent(this,  verificationActivity.class);
        startActivity(intent);
    }
}
