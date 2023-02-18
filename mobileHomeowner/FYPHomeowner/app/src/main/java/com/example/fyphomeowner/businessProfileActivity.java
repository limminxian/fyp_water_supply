package com.example.fyphomeowner;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.text.Layout;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;
import com.google.android.material.datepicker.MaterialDatePicker;
import com.google.android.material.datepicker.MaterialPickerOnPositiveButtonClickListener;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.time.Instant;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.TimeZone;

public class businessProfileActivity extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;

    private String name;
    private Integer PhoneNo;
    private String street;
    private Integer postalCode;
    private String Description;
    private String date;
    private Integer noOfStars;
    private TextView companyTitle;
    private TextView emailTxt;
    private TextView phoneTxt;
    private TextView addressTxt;
    private TextView descriptionTxt;
    private TextView serviceTxt;
    private TextView serviceRateTxt;
    private ImageView star1;
    private ImageView star2;
    private ImageView star3;
    private ImageView star4;
    private ImageView star5;
    private Button subBtn;
    private Button unsubBtn;
    private Button reviewBtn;
    private TextView reviewTxt;
    private RatingBar ratingBar;
    private ImageView businessLogo;

    private SharedPreferences sharedPreferencesHomeowner;
    private SharedPreferences sharedPreferencesCompany;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_business_profile);
        //Shared preferences
        sharedPreferencesHomeowner = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        sharedPreferencesCompany = getSharedPreferences("companyPref", MODE_PRIVATE);

        //Views
        companyTitle = findViewById(R.id.companyTitle);
        emailTxt = findViewById(R.id.emailTxt);
        phoneTxt = findViewById(R.id.phoneTxt);
        addressTxt = findViewById(R.id.addressTxt);
        descriptionTxt = findViewById(R.id.descriptionTxt);
        serviceTxt = findViewById(R.id.serviceTxt);
        serviceRateTxt = findViewById(R.id.serviceRateTxt);
        ratingBar = findViewById(R.id.ratingBar);
//        star1 = findViewById(R.id.star1);
//        star2 = findViewById(R.id.star2);
//        star3 = findViewById(R.id.star3);
//        star4 = findViewById(R.id.star4);
//        star5 = findViewById(R.id.star5);
        subBtn = findViewById(R.id.subscriptionBtn);
        unsubBtn = findViewById(R.id.unsubscriptionBtn);
        reviewBtn = findViewById(R.id.reviewBtn);
        reviewTxt = findViewById(R.id.reviewTxt);
        businessLogo = findViewById(R.id.businessLogo);

        getInfo();

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
                        SharedPreferences.Editor editor = sharedPreferencesHomeowner.edit();
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

    public void openReviewPage(){
        Intent intent = new Intent(this, businessReviewActivity.class);
        startActivity(intent);
    }

    public void getInfo(){
        //CONNECT DB
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/businessProfileRequest.php";

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
                                companyTitle.setText(jsonObject.getString("name"));
                                emailTxt.setText(jsonObject.getString("email"));
                                phoneTxt.setText(jsonObject.getString("phoneNo"));
                                addressTxt.setText(jsonObject.getString("address"));
                                descriptionTxt.setText(jsonObject.getString("description"));
                                serviceTxt.setText(jsonObject.getString("services"));
                                serviceRateTxt.setText(jsonObject.getString("serviceRates"));
                                if(!jsonObject.isNull("noOfStars")){
                                    noOfStars = jsonObject.getInt("noOfStars");
                                }else{
                                    noOfStars = 0;
                                }
                                ratingBar.setRating(noOfStars);
                                ratingBar.setIsIndicator(true);
                                String logo = jsonObject.getString("logo");
                                if(logo!=null && logo!="null" && !logo.isEmpty()){
                                    logo = jsonObject.getString("logo");
                                } else {
                                    logo = "imgnotfound.jpg";
                                }

                                Glide.with(getApplicationContext()).load("https://fypwatersupplyweb.herokuapp.com/companylogos/" + logo).into(businessLogo);
                                //Create list of reviews
                                ArrayList<String> listArr = new ArrayList<>();
                                //Get reviews
                                if(jsonObject.has("reviews")) {
                                    JSONObject reviewsObj = jsonObject.getJSONObject("reviews");
                                    String reviews = "";
                                    Iterator<String> keys = reviewsObj.keys();
                                    while (keys.hasNext()) {
                                        String key = keys.next();
                                        JSONObject reviewObj = reviewsObj.getJSONObject(key);
                                        String homeownerName = reviewObj.getString("homeownerName");
                                        String review = reviewObj.getString("review");
                                        String reviewStr = "'" + review + "' " + "reviewed by: " + homeownerName + "\n";
                                        reviews += reviewStr;
                                        System.out.println(reviews);
                                    }
                                    reviewTxt.setText(reviews);
                                }

                                boolean subscribed = jsonObject.getBoolean("subscribed");
                                if(subscribed){
                                    subBtn.setVisibility(View.GONE);
                                    unsubBtn.setVisibility(View.VISIBLE);
                                    reviewBtn.setVisibility(View.VISIBLE);
                                    unsubBtn.setOnClickListener(new View.OnClickListener() {
                                        @Override
                                        public void onClick(View view) {
                                            datePicker(view, subscribed);
                                        }
                                    });
                                    reviewBtn.setOnClickListener(new View.OnClickListener() {
                                        @Override
                                        public void onClick(View view) {
                                            openReviewPage();
                                        }
                                    });
                                }else{
                                    subBtn.setVisibility(View.VISIBLE);
                                    unsubBtn.setVisibility(View.GONE);
                                    reviewBtn.setVisibility(View.GONE);
                                    subBtn.setOnClickListener(new View.OnClickListener() {
                                        @Override
                                        public void onClick(View view) {
                                            if(jsonObject.has("subscribeID")){
                                                Toast.makeText(businessProfileActivity.this, "Please unsubscribe first", Toast.LENGTH_SHORT).show();
                                                try {
                                                    String subscribeID = jsonObject.getString("subscribeID");
                                                    SharedPreferences.Editor editor = sharedPreferencesCompany.edit();
                                                    editor.putString("companyID", subscribeID);
                                                    editor.apply();
                                                    finish();
                                                    startActivity(getIntent());
                                                } catch (JSONException e) {
                                                    e.printStackTrace();
                                                }
                                            } else {
                                                datePicker(view, subscribed);
                                            }
                                        }
                                    });
                                }

                                boolean reviewed = jsonObject.getBoolean("reviewed");
                                if(reviewed){
                                    reviewBtn.setClickable(false);
                                    reviewBtn.setBackgroundColor(Color.GRAY);
                                }else{
                                    reviewBtn.setClickable(true);
                                    reviewBtn.setBackgroundColor(R.color.waterBlue);
                                }

                                SharedPreferences.Editor editor = sharedPreferencesCompany.edit();
                                editor.putString("companyName", jsonObject.getString("name"));
                                editor.apply();
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
                paramV.put("userID", sharedPreferencesHomeowner.getString("userID",""));
                paramV.put("companyID", sharedPreferencesCompany.getString("companyID",""));
                return paramV;
            }
        };
        queue.add(stringRequest);
    }

    //Popup window method
    public void datePicker(View view, boolean subStatus) {
        //Date picker
        MaterialDatePicker.Builder materialDateBuilder = MaterialDatePicker.Builder.datePicker();
        if(subStatus){
            materialDateBuilder.setTitleText("Select uninstallation date");
        } else {
            materialDateBuilder.setTitleText("Select installation date");
        }
        final MaterialDatePicker materialDatePicker = materialDateBuilder.build();

        materialDatePicker.addOnPositiveButtonClickListener(new MaterialPickerOnPositiveButtonClickListener<Long>() {
            @Override public void onPositiveButtonClick(Long selection) {
                // Do something...
                //Calendar calendar = Calendar.getInstance(TimeZone.getTimeZone("UTC"));
                Calendar utc = Calendar.getInstance(TimeZone.getTimeZone("UTC"));
                utc.setTimeInMillis(selection);
                SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd");
                date = format.format(utc.getTime());
                subUnsub(subStatus);
            }
        });

        // inflate the layout of the popup window
        int layout;
        LayoutInflater inflater = (LayoutInflater)
                getSystemService(LAYOUT_INFLATER_SERVICE);
        if(subStatus){
            layout = R.layout.unsubscription_popup_window;
        } else {
            layout = R.layout.subscription_popup_window;
        }
        View popupView = inflater.inflate(layout, null);

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
                materialDatePicker.show(getSupportFragmentManager(), "MATERIAL_DATE_PICKER");
                materialDatePicker.addOnPositiveButtonClickListener(
                        new MaterialPickerOnPositiveButtonClickListener() {
                            @SuppressLint("SetTextI18n")
                            @Override
                            public void onPositiveButtonClick(Object selection) {
                                //mShowSelectedDateText.setText("Selected Date is : " + materialDatePicker.getHeaderText());
                            }
                        });
            }
        });
    }

    public void subUnsub(boolean subStatus){
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());

        if(subStatus){ // if homeowner is subbed to THIS company
            //want to unsub
            String url = "https://fyphomeowner.herokuapp.com/unsubscribeRequest.php";
            StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            //checking response for success directly because php file echos "success"
                            if (response.equals("success")) {
                                Toast.makeText(businessProfileActivity.this, "Unsubscribed", Toast.LENGTH_SHORT).show();
                                System.out.println("success");
                                finish();
                                startActivity(getIntent());
                            }
                            else {
                                Toast.makeText(businessProfileActivity.this, response, Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), error.getLocalizedMessage(), Toast.LENGTH_SHORT).show();
                }
            }) {
                //Sends data towards the php file to process
                protected Map<String, String> getParams() {
                    Map<String, String> paramV = new HashMap<>();
                    paramV.put("userID", sharedPreferencesHomeowner.getString("userID",""));
                    paramV.put("companyID", sharedPreferencesCompany.getString("companyID",""));
                    paramV.put("date", date);
                    return paramV;
                }
            };
            queue.add(stringRequest);

        }else{ // if homeowner is not subbed to this company
            //want to sub
            String url = "https://fyphomeowner.herokuapp.com/subscribeRequest.php";
            StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            //checking response for success directly because php file echos "success"
                            if (response.equals("success")) {
                                Toast.makeText(businessProfileActivity.this, "subscribed", Toast.LENGTH_SHORT).show();
                                System.out.println("success");
                                finish();
                                startActivity(getIntent());
                            }
                            else {
                                Toast.makeText(businessProfileActivity.this, response, Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), error.getLocalizedMessage(), Toast.LENGTH_SHORT).show();
                }
            }) {
                //Sends data towards the php file to process
                protected Map<String, String> getParams() {
                    Map<String, String> paramV = new HashMap<>();
                    paramV.put("userID", sharedPreferencesHomeowner.getString("userID",""));
                    paramV.put("companyID", sharedPreferencesCompany.getString("companyID",""));
                    paramV.put("date", date);
                    return paramV;
                }
            };
            queue.add(stringRequest);
        }
    }

}