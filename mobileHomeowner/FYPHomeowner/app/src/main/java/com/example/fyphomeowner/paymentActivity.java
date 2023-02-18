package com.example.fyphomeowner;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONException;
import org.json.JSONObject;

import java.math.BigInteger;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

public class paymentActivity extends AppCompatActivity implements paymentMethodsRecyclerAdapter.CardClickListener {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;
    private ConstraintLayout constraintLayout;
    private SharedPreferences sharedPreferencesHomeowner;
    private SharedPreferences sharedPreferencesPayment;
    private RecyclerView recyclerView;
    private ArrayList<Card> cardList;
    private TextView hintTxt;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_payment);
        sharedPreferencesHomeowner = getSharedPreferences("homeownerPref", MODE_PRIVATE);
        sharedPreferencesPayment = getSharedPreferences("paymentPref", MODE_PRIVATE);

        //RECYCLER VIEW
        recyclerView = findViewById(R.id.paymentMethodsRecyclerView);
        hintTxt = findViewById(R.id.hintTxt);
        recyclerView.setNestedScrollingEnabled(false);
        cardList = new ArrayList<>();
        setUpCards();
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

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

    public void setUpCards(){
        //CONNECT DB
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        String url = "https://fyphomeowner.herokuapp.com/viewPaymentMethodsRequest.php";

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
                                JSONObject cardsObj = jsonObject.getJSONObject("cards");
                                //ArrayList<TextView> textViews = new ArrayList<>();

                                Iterator<String> keys = cardsObj.keys();
                                while(keys.hasNext()){
                                    String key = keys.next();
                                    String ID = key;
                                    JSONObject cardObj = cardsObj.getJSONObject(key);
                                    String name = cardObj.getString("name");
                                    String brand = cardObj.getString("brand");
                                    String country = cardObj.getString("country");
                                    String address = cardObj.getString("address");
                                    String city = cardObj.getString("city");
                                    String postalCode = cardObj.getString("postalCode");
                                    String cardNoStr = cardObj.getString("cardNo");
                                    String expMonth = cardObj.getString("expMonth");
                                    String expYear = cardObj.getString("expYear");
                                    String cvc = cardObj.getString("cvc");

                                    BigInteger cardNo = new BigInteger(cardNoStr);
                                    Card card = new Card(Integer.parseInt(ID), name, brand, country, address, city, Integer.parseInt(postalCode),cardNo,
                                            Integer.parseInt(expMonth), Integer.parseInt(expYear), Integer.parseInt(cvc));
                                    cardList.add(card);
                                }
                                paymentMethodsRecyclerAdapter adapter = new paymentMethodsRecyclerAdapter(paymentActivity.this, cardList, paymentActivity.this);
                                if(adapter != null){
                                    recyclerView.setAdapter(adapter);
                                }
                            }
                            else {
                                Log.d("error", message);
                                hintTxt.setVisibility(View.VISIBLE);
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

    public void openAddPaymentPage(){
        Intent intent = new Intent(this, addPaymentMethodActivity.class);
        startActivity(intent);
    }
    public void openConfirmPaymentPage(){
        Intent intent = new Intent(this, confirmPaymentActivity.class);
        startActivity(intent);
    }

    //RECYCLER ONCLICK
    @Override
    public void selectedCard(Card card) {
        SharedPreferences.Editor editor = sharedPreferencesPayment.edit();
        editor.putString("cardID", String.valueOf(card.getID()));
        editor.apply();
        openConfirmPaymentPage();
    }
}