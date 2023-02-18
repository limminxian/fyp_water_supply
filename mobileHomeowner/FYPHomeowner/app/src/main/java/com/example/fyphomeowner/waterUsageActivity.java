package com.example.fyphomeowner;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.icu.util.Calendar;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.Spinner;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.github.mikephil.charting.charts.BarChart;
import com.github.mikephil.charting.components.Legend;
import com.github.mikephil.charting.components.XAxis;
import com.github.mikephil.charting.components.YAxis;
import com.github.mikephil.charting.data.BarData;
import com.github.mikephil.charting.data.BarDataSet;
import com.github.mikephil.charting.data.BarEntry;
import com.github.mikephil.charting.formatter.IAxisValueFormatter;
import com.github.mikephil.charting.formatter.IndexAxisValueFormatter;
import com.github.mikephil.charting.interfaces.datasets.IBarDataSet;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.time.Month;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Objects;

public class waterUsageActivity extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;
    private SharedPreferences sharedPreferencesHomeowner;
    private Spinner sortBySpinner;
    private Spinner selectedYear;
//    private Spinner selectedDecade;
    private BarChart chart;
    private ArrayList<WaterUsage> waterUsagesList;
    private ArrayList<BarEntry> waterBarChart;
    private String sortedBy;
    private Integer yearSelected;
    private Integer currYear;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_water_usage);
        sharedPreferencesHomeowner = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        chart = findViewById(R.id.barChart);
        sortBySpinner = findViewById(R.id.sortBySpinner);
        selectedYear = findViewById(R.id.selectedYear);
//        selectedDecade = findViewById(R.id.selectedDecade);

        //Set Spinner
        //sort by spinner
        ArrayList<String> sortByArr = new ArrayList<>();
        sortByArr.add("month");
        sortByArr.add("year");
        ArrayAdapter<String> spinnerAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_dropdown_item, sortByArr);
        sortBySpinner.setAdapter(spinnerAdapter);
        sortedBy = sortBySpinner.getSelectedItem().toString();
        //selectedYear spinner
        currYear = 0;
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.N) {
            currYear = Calendar.getInstance().get(Calendar.YEAR);
        }
        ArrayList<Integer> selectedYearArr = new ArrayList<>();
        for(int i = 0; i < 6; i++){
            selectedYearArr.add(currYear-i);
        }

        ArrayAdapter<Integer> selectedYearAdapter = new ArrayAdapter<Integer>(this, android.R.layout.simple_spinner_dropdown_item, selectedYearArr);
        selectedYear.setAdapter(selectedYearAdapter);
        yearSelected = Integer.parseInt(selectedYear.getSelectedItem().toString());

        selectedYear.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
                sortedBy = sortBySpinner.getSelectedItem().toString();
                yearSelected = Integer.parseInt(selectedYear.getSelectedItem().toString());
                getWaterUsage(sortedBy, yearSelected);
            }
            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
            }
        });
        sortBySpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
                sortedBy = sortBySpinner.getSelectedItem().toString();
                yearSelected = Integer.parseInt(selectedYear.getSelectedItem().toString());
                getWaterUsage(sortedBy, yearSelected);
            }
            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
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

    public void getWaterUsage(String sortedBy, Integer yearSelected){
        //CONNECT DB
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/waterUsageRequest.php";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            //changing the response to a JSONobject because the php file is response is a JSON file
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            String message = jsonObject.getString("message");
                            if (status.equals("success")){
                                JSONObject waterUsages = jsonObject.getJSONObject("waterUsages");
                                waterUsagesList = new ArrayList<>();
                                Iterator<String> keys = waterUsages.keys();
                                while(keys.hasNext()){
                                    String key = keys.next();
                                    String date = key;
                                    JSONObject waterUsageObj = waterUsages.getJSONObject(key);
                                    String day = waterUsageObj.getString("day");
                                    String month = waterUsageObj.getString("month");
                                    String year = waterUsageObj.getString("year");
                                    String waterUsageStr = waterUsageObj.getString("waterUsage");
                                    WaterUsage waterUsage = new WaterUsage(Float.parseFloat(waterUsageStr), Integer.parseInt(day),Integer.parseInt(month),Integer.parseInt(year));
                                    waterUsagesList.add(waterUsage);
                                }

                                waterBarChart = new ArrayList<>();

                                //display 10 years chart
                                ArrayList<Integer> years = new ArrayList<>();
                                for(int i = 0; i < 6; i++){
                                    years.add(currYear-i);
                                }

                                //Create barchart by sorted by
                                if(sortedBy.equals("year")){
                                    selectedYear.setVisibility(View.GONE);
                                    //Display bar chart by year
                                    for(Integer year : years){
                                        int waterUsage = 0;
                                        for(WaterUsage wu : waterUsagesList){
                                            if(Objects.equals(wu.getYear(), year)){
                                                waterUsage += wu.getWaterUsage();
                                            }
                                            System.out.println(year);
                                            System.out.println(waterUsage);
                                        }
                                        waterBarChart.add(new BarEntry(year,waterUsage));
                                    }
                                }else{
                                    selectedYear.setVisibility(View.VISIBLE);
                                    //Display bar chart by month
                                    for(int month = 1; month < 13; month++){
                                        for(WaterUsage wu : waterUsagesList){
                                            if(Objects.equals(wu.getMonth(), month) && Objects.equals(wu.getYear(), yearSelected)){
                                                waterBarChart.add(new BarEntry(month, wu.getWaterUsage()));
                                            }
                                            else{
                                                waterBarChart.add(new BarEntry(month, 0));
                                            }
                                        }
                                    }
                                }

                                BarDataSet barDataSet = new BarDataSet(waterBarChart, "Water Usage");
                                barDataSet.setValueTextSize(16f);
                                BarData barData = new BarData(barDataSet);
                                chart.setFitBars(true);
                                chart.setData(barData);
                                chart.getDescription().setText("Water usages for this decade");
                                chart.animateY(2000);
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