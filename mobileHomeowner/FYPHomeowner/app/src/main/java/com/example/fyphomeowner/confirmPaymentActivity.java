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
import android.widget.TextView;
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

import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.Month;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Iterator;
import java.util.Map;
import java.util.Set;
import java.util.TimeZone;

public class confirmPaymentActivity extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;
    private SharedPreferences sharedPreferences;
    private TextView cardNoTxt;
    private TextView nameTxt;
    private TextView expirationTxt;
    private TextView addressTxt;
    private TextView countryTxt;
    private TextView postalCodeTxt;
    private TextView currBillTxt;
    private Button confirmBtn;
    private TextView brandTxt;
    private ArrayList<String> brandList;
    private ArrayAdapter<String> brandAdapter;
    private LocalDate currDate;
    private Month currMonthStr;
    private int currMonth;
    private int currYear;

    private SharedPreferences sharedPreferencesHomeowner;
    private SharedPreferences sharedPreferencesPayment;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_confirm_payment);
        sharedPreferencesHomeowner = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        sharedPreferencesPayment = getSharedPreferences("paymentPref", MODE_PRIVATE);
        cardNoTxt = findViewById(R.id.cardNoTxt);
        nameTxt = findViewById(R.id.nameTxt);
        expirationTxt = findViewById(R.id.expirationTxt);
        addressTxt = findViewById(R.id.addressTxt);
        countryTxt = findViewById(R.id.countryTxt);
        postalCodeTxt = findViewById(R.id.postalCodeTxt);
        confirmBtn = findViewById(R.id.confirmBtn);
        brandTxt = findViewById(R.id.brandTxt);
        currBillTxt = findViewById(R.id.currBillTxt);

        //Get current date
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            currDate = LocalDate.now();
            currMonthStr = currDate.getMonth();
            currMonth = currDate.getMonthValue();
            currYear = currDate.getYear();
        }
        //set current bills text
        getBills(currBillTxt, currMonth, currYear);

        getPaymentMethod();
        confirmBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                sendPayment();
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

    public void getBills(TextView textView, int month, int year){
        //CONNECT DB
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/viewBillsRequest.php";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            //changing the response to a JSONobject because the php file is response is a JSON file
                            Log.i("tagconvertstr", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            String message = jsonObject.getString("message");
                            if (status.equals("success")){
                                String bills = "";
                                String companyName = "";
                                int total = 0;
                                JSONObject billsObj = jsonObject.getJSONObject("serviceBills");
                                Iterator<String> keys = billsObj.keys();
                                Set<String> billIDArr = new HashSet<String>();
                                while(keys.hasNext()){
                                    String key = keys.next();
                                    String serviceName = key;
                                    JSONObject serviceBillObj = billsObj.getJSONObject(key);
                                    String ID;
                                    String amount;
                                    String payment;
                                    String paymentDate;

                                    if(serviceBillObj.getString("ID")!="null"){
                                        ID = serviceBillObj.getString("ID");
                                        billIDArr.add(ID);
                                    }else{
                                        ID = "";
                                    }
                                    if(serviceBillObj.getString("amount")!="null"){
                                        amount = serviceBillObj.getString("amount");
                                    }else{
                                        amount = "";
                                    }
                                    if(serviceBillObj.getString("payment")!="null"){
                                        payment = serviceBillObj.getString("payment");
                                    }else{
                                        payment = "";
                                    }
                                    if(serviceBillObj.getString("billingDate")!="null"){
                                        paymentDate = serviceBillObj.getString("billingDate");
                                    }else{
                                        paymentDate = "";
                                    }
                                    if(serviceBillObj.getString("companyName")!="null"){
                                        companyName = serviceBillObj.getString("companyName");
                                    }else{
                                        companyName = "";
                                    }

                                    bills += serviceName +": "+ amount + "\n";
                                    total += Integer.parseInt(amount);
                                }

                                bills += "Total bills from " + companyName + ": " + String.valueOf(total);
                                textView.setText(bills);

                            }
                            else {
                                Log.d("error", message);
                                textView.setText("no bills found");
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
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
                paramV.put("userID", sharedPreferencesHomeowner.getString("userID",""));
                paramV.put("month", String.valueOf(month));
                paramV.put("year", String.valueOf(year));
                paramV.put("curr", "true");
                return paramV;
            }
        };
        queue.add(stringRequest);
    }

    public void getPaymentMethod(){
        //CONNECT DB
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/getPaymentMethodRequest.php";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            //changing the response to a JSONobject because the php file is response is a JSON file
                            Log.i("tagconvertstrgetpayment", "["+response+"]");
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            String message = jsonObject.getString("message");
                            if (status.equals("success")){
                                cardNoTxt.setText(jsonObject.getString("cardNo"));
                                nameTxt.setText(jsonObject.getString("name"));
                                addressTxt.setText(jsonObject.getString("address"));
                                countryTxt.setText(jsonObject.getString("country"));
                                postalCodeTxt.setText(jsonObject.getString("postalCode"));
                                brandTxt.setText(jsonObject.getString("brand"));

                                String expMonth = jsonObject.getString("expMonth");
                                String expYear = jsonObject.getString("expYear");
                                expirationTxt.setText(expMonth + "/" + expYear);
                            }
                            else {
                                Log.d("error", message);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
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
                paramV.put("cardID", sharedPreferencesPayment.getString("cardID",""));
                System.out.println("cardID: " +sharedPreferencesPayment.getString("cardID","") );
                return paramV;
            }
        };
        queue.add(stringRequest);
    }

    public void sendPayment(){
        //CONNECT DB
        //Set service types in spinner
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/makePaymentRequest.php";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        if (response.equals("success")){
                            Toast.makeText(confirmPaymentActivity.this, "successfully made payment", Toast.LENGTH_SHORT).show();
                            openBillsPage();
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
                //get all billIDs from sharedPref
                Set<String> defVal = new HashSet<>();
                Set<String> billIDsSet = sharedPreferencesPayment.getStringSet("billIDs", defVal);
                ArrayList<String> billIDs = new ArrayList<>(billIDsSet);
                for(int i=0; i < billIDs.size(); i++ ){
                    paramV.put("billID"+i, billIDs.get(i));
                }
                paramV.put("billIDSize", String.valueOf(billIDs.size()));
                paramV.put("cardID", sharedPreferencesPayment.getString("cardID", ""));
                paramV.put("paymentDate", new SimpleDateFormat("yyyy-MM-dd").format(new Date()));
                return paramV;
            }
        };
        queue.add(stringRequest);
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