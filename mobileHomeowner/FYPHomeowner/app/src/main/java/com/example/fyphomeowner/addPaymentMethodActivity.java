package com.example.fyphomeowner;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

public class addPaymentMethodActivity extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;
    private SharedPreferences sharedPreferences;
    private EditText cardNoTxt;
    private EditText nameTxt;
    private EditText expirationTxt;
    private EditText cvcTxt;
    private EditText addressTxt;
    private EditText countryTxt;
    private EditText postalCodeTxt;
    private Button addBtn;
    private Spinner brandSpinner;
    private ArrayList<String> brandList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_payment_method);
        sharedPreferences = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        cardNoTxt = findViewById(R.id.cardNoTxt);
        nameTxt = findViewById(R.id.nameTxt);
        expirationTxt = findViewById(R.id.expirationTxt);
        cvcTxt = findViewById(R.id.cvcTxt);
        addressTxt = findViewById(R.id.addressTxt);
        countryTxt = findViewById(R.id.countryTxt);
        postalCodeTxt = findViewById(R.id.postalCodeTxt);
        addBtn = findViewById(R.id.addBtn);
        brandSpinner = findViewById(R.id.brandSpinner);

        brandList = new ArrayList<>();
        brandList.add("VISA");
        brandList.add("MASTER");
        brandList.add("AMEX");
        ArrayAdapter<String> brandAdapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_spinner_dropdown_item, brandList);
        brandSpinner.setAdapter(brandAdapter);

        addBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //CONNECT DB
                RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                String url = "https://fyphomeowner.herokuapp.com/addPaymentMethodRequest.php";

                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                Log.i("tagconvertstr", "["+response+"]");
                                if (response.equals("success")){
                                    Log.d("success", response);
                                    Toast.makeText(addPaymentMethodActivity.this, "Payment method added successfully", Toast.LENGTH_SHORT).show();
                                    openPaymentMethodsPage();
                                    finish();
                                }
                                else {
                                    Log.d("error", response);
                                }
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        error.printStackTrace();
                    }
                }) {
                    protected Map<String, String> getParams() {
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("userID", sharedPreferences.getString("userID",""));
                        paramV.put("cardNo", cardNoTxt.getText().toString());
                        paramV.put("name", nameTxt.getText().toString());
                        paramV.put("expiration", expirationTxt.getText().toString());
                        paramV.put("cvc", cvcTxt.getText().toString());
                        paramV.put("address", addressTxt.getText().toString());
                        paramV.put("country", countryTxt.getText().toString());
                        paramV.put("postalCode", postalCodeTxt.getText().toString());
                        paramV.put("brand", brandSpinner.getSelectedItem().toString());
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            }
        });

        //NAVIGATION MENU
        drawerLayout = findViewById(R.id.drawerLayout);
        navigationView = findViewById(R.id.navigationView);
        imageMenuView = findViewById(R.id.imageMenu);
        imageMenuView.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                drawerLayout.openDrawer(GravityCompat.START);
            }
        });
        navigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                switch(item.getItemId()){
                    case R.id.home:
                        openHomePage();
                        break;
                    case R.id.profile:
                        openProfilePage();
                        break;
                    case R.id.waterUsage:
                        openWaterUsagePage();
                        break;
                    case R.id.paymentMethods:
                        openPaymentMethodsPage();
                        break;
                    case R.id.bills:
                        openBillsPage();
                        break;
                    case R.id.tickets:
                        openTicketsPage();
                        break;
                    case R.id.business:
                        openBusinessPage();
                        break;
                    case R.id.aboutUs:
                        openAboutPage();
                        break;
                    case R.id.logout:
                        openLoginPage();
                        SharedPreferences.Editor editor = sharedPreferences.edit();
                        editor.putString("logged", "false");
                        editor.apply();
                        finish();
                        break;
                    default:
                        break;
                }
                return false;
            }
        });
    }

    //REDIRECT METHODS
    public void openHomePage(){
        Intent intent = new Intent(this, dashboardActivity.class);
        startActivity(intent);
    }

    public void openProfilePage(){
        Intent intent = new Intent(this, profileActivity.class);
        startActivity(intent);
    }

    public void openWaterUsagePage(){
        Intent intent = new Intent(this, waterUsageActivity.class);
        startActivity(intent);
    }
    public void openPaymentMethodsPage(){
        Intent intent = new Intent(this, paymentMethodsActivity.class);
        startActivity(intent);
    }

    public void openBillsPage(){
        Intent intent = new Intent(this, billsActivity.class);
        startActivity(intent);
    }
    public void openTicketsPage(){
        Intent intent = new Intent(this, ticketsActivity.class);
        startActivity(intent);
    }

    public void openBusinessPage(){
        Intent intent = new Intent(this, businessViewActivity.class);
        startActivity(intent);
    }


    public void openAboutPage(){
        Intent intent = new Intent(this, aboutActivity.class);
        startActivity(intent);
    }

    public void openLoginPage(){
        Intent intent = new Intent(this, loginActivity.class);
        startActivity(intent);
    }

}