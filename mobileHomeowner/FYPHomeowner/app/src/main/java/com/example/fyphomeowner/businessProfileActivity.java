package com.example.fyphomeowner;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.google.android.material.navigation.NavigationView;

public class businessProfileActivity extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ImageView imageMenuView;

    private int UEN;
    private String name;
    private int PhoneNo;
    private String street;
    private int postalCode;
    private String Description;
    private int noOfStars;
    private TextView companyTitle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_business_profile);

        companyTitle = findViewById(R.id.companyTitle);

        //Get object out of the parcelable from the businessViewActivity
        Intent  intent = getIntent();
        Company company = intent.getParcelableExtra("companyKey");
        UEN = company.getUEN();
        name = company.getName();
        PhoneNo = company.getPhoneNo();
        street = company.getStreet();
        postalCode = company.getPostalCode();
        Description = company.getDescription();
        noOfStars = company.getNoOfStars();

        companyTitle.setText(name);


//        switch (noOfStars){
//            case 1:
//                holder.star1.setImageResource(R.drawable.ic_star);
//                holder.star2.setImageResource(R.drawable.ic_empty_star);
//                holder.star3.setImageResource(R.drawable.ic_empty_star);
//                holder.star4.setImageResource(R.drawable.ic_empty_star);
//                holder.star5.setImageResource(R.drawable.ic_empty_star);
//                break;
//            case 2:
//                holder.star1.setImageResource(R.drawable.ic_star);
//                holder.star2.setImageResource(R.drawable.ic_star);
//                holder.star3.setImageResource(R.drawable.ic_empty_star);
//                holder.star4.setImageResource(R.drawable.ic_empty_star);
//                holder.star5.setImageResource(R.drawable.ic_empty_star);
//                break;
//            case 3:
//                holder.star1.setImageResource(R.drawable.ic_star);
//                holder.star2.setImageResource(R.drawable.ic_star);
//                holder.star3.setImageResource(R.drawable.ic_star);
//                holder.star4.setImageResource(R.drawable.ic_empty_star);
//                holder.star5.setImageResource(R.drawable.ic_empty_star);
//                break;
//            case 4:
//                holder.star1.setImageResource(R.drawable.ic_star);
//                holder.star2.setImageResource(R.drawable.ic_star);
//                holder.star3.setImageResource(R.drawable.ic_star);
//                holder.star4.setImageResource(R.drawable.ic_star);
//                holder.star5.setImageResource(R.drawable.ic_empty_star);
//                break;
//            case 5:
//                holder.star1.setImageResource(R.drawable.ic_star);
//                holder.star2.setImageResource(R.drawable.ic_star);
//                holder.star3.setImageResource(R.drawable.ic_star);
//                holder.star4.setImageResource(R.drawable.ic_star);
//                holder.star5.setImageResource(R.drawable.ic_star);
//                break;
//            default:
//                holder.star2.setImageResource(R.drawable.ic_empty_star);
//                holder.star3.setImageResource(R.drawable.ic_empty_star);
//                holder.star4.setImageResource(R.drawable.ic_empty_star);
//                holder.star5.setImageResource(R.drawable.ic_empty_star);
//                holder.star5.setImageResource(R.drawable.ic_empty_star);
//                break;
//        }
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
}