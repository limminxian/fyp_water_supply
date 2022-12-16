package com.example.fyphomeowner;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.SearchView;

import com.google.android.material.navigation.NavigationView;

import java.util.ArrayList;

public class businessViewActivity extends AppCompatActivity implements businessRecyclerAdapter.BusinessClickListner {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;
    private SearchView searchView;
    private ArrayList<Company> businessList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_business_view);

        //RECYCLER VIEW
        RecyclerView recyclerView = findViewById(R.id.businessRecyclerView);
        businessList = new ArrayList<>();
        setUpBusinessViews();
        businessRecyclerAdapter adapter = new businessRecyclerAdapter(this, businessList, this);
        recyclerView.setAdapter(adapter);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        //SEARCH VIEW
        searchView = findViewById(R.id.searchView);
        searchView.clearFocus();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String s) {
                return false;
            }
            @Override
            public boolean onQueryTextChange(String s) {
                filterList(s, adapter);
                return true;
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
    public void openSettingsPage(){
        Intent intent = new Intent(this, settingsActivity.class);
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

    //Passes the company object into the profile activity by implementing the Parcelable on the Company class
    public void openBusinessProfilePage(Company company){
        Intent intent = new Intent(this, businessProfileActivity.class);
        intent.putExtra("companyKey", company);
        startActivity(intent);
    }

    //SET UP BUSINESS RECYCLER views
    private void setUpBusinessViews(){
        for(int i = 1; i < 11; i++){
            int rating = 3;
            if(i%2==0){
                rating = 4;
            }
            User admin = new User();
            Company company = new Company(i, "Company " + i, 61234567, "Singapore street", 412345,
                    "Water is a precious resource that is key to our survival. The smart water meter offers you more insights into your water usage, empowering you to be more water conscious and sustainable for the future.",
                    rating, admin);
            businessList.add(company);
        }
    }

    //SEARCH FLITER
    private void filterList(String text, businessRecyclerAdapter adapter){
        ArrayList<Company> filteredList = new ArrayList<>();

        for(int i = 0; i < businessList.size(); i++){
            Company company = businessList.get(i);
            String cname = company.getName().toLowerCase();
            text = text.toLowerCase();
            if(text.equals(cname)){
                filteredList.add(businessList.get(i));
            }
        }
        adapter.setFilteredList(filteredList);
    }

    //RECYCLER ONCLICK
    @Override
    public void selectedBusiness(Company company) {
        openBusinessProfilePage(company);
    }
}
