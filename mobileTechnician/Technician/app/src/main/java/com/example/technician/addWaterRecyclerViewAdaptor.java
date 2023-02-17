package com.example.technician;

import static android.content.Context.MODE_PRIVATE;
import static android.content.Intent.getIntent;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.w3c.dom.Text;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class addWaterRecyclerViewAdaptor extends RecyclerView.Adapter<addWaterRecyclerViewAdaptor.MyViewHolder> {
    Context context;
    ArrayList<WaterModel> WaterModels;
    SharedPreferences AddresssharedPreferences;
    SharedPreferences waterUsagePreferences;

    private static final DecimalFormat df = new DecimalFormat("0.00");

    public addWaterRecyclerViewAdaptor(Context context, ArrayList<WaterModel> WaterModels) {
        this.context = context;
        this.WaterModels = WaterModels;
    }

    @NonNull
    @Override
    public addWaterRecyclerViewAdaptor.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View view = inflater.inflate(R.layout.recycler_add_water, parent, false);
        return new addWaterRecyclerViewAdaptor.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull addWaterRecyclerViewAdaptor.MyViewHolder holder, int position) {
        AddresssharedPreferences = context.getSharedPreferences("Addresses", MODE_PRIVATE);
        waterUsagePreferences = context.getSharedPreferences("water", MODE_PRIVATE);
        String unitNo = WaterModels.get(position).getUnitNo();
        String toDisplay;
        if(unitNo != null && !unitNo.equals("null") && !unitNo.isEmpty()) {
            toDisplay = unitNo;
        } else {
            toDisplay = WaterModels.get(position).getStreet();
            System.out.println("street: " + WaterModels.get(position).getStreet());
        }
        System.out.println("street: " + WaterModels.get(position).getStreet());
        holder.unitTv.setText(toDisplay);
//        holder.unitTv.setId(WaterModels.get(position).getHomeownerId());

        float water = WaterModels.get(position).getWaterUsage();
        if(water == 0) {
            holder.waterUsage.setText("");
            holder.editButton.setEnabled(false);
        } else {
            holder.waterUsage.setText(String.valueOf(water));
            holder.addButton.setEnabled(false);
        }

        int homeOwnerId = WaterModels.get(position).getHomeownerId();

        holder.addButton.setOnClickListener((view) -> {
            String waterUsageText = holder.waterUsage.getText().toString();
            if(!waterUsageText.isEmpty()) {
                float waterUsage = Float.parseFloat(waterUsageText.trim());
                String url ="https://fyptechnician.herokuapp.com/addWaterUsage.php";
                //String url ="http://192.168.1.10/Technician/addWaterUsage.php";
                RequestQueue queue = Volley.newRequestQueue(context.getApplicationContext());
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                if(response.equals("Water usage added successfullySuccessfully inserted bill")){
                                    Log.i("tagconvertstr", "["+response+"]");
                                    SharedPreferences.Editor editor = AddresssharedPreferences.edit();
                                    editor.putFloat("waterUsage", waterUsage);
                                    Toast.makeText(context.getApplicationContext(), "Water usage is added", Toast.LENGTH_SHORT).show();
                                    holder.waterUsage.setText(String.valueOf(waterUsage));
                                    holder.addButton.setEnabled(false);
                                    holder.editButton.setEnabled(true);
                                } else {
                                    Log.i("tagconvertstr", "["+response+"]");
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
                        paramV.put("waterUsage", String.valueOf(waterUsage));
                        paramV.put("homeownerId", String.valueOf(homeOwnerId));
                        paramV.put("sqlDate", waterUsagePreferences.getString("sqlDate","") );
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            }
            else {
                Toast.makeText(context.getApplicationContext(), " Water usage is empty!", Toast.LENGTH_SHORT).show();
            }
        });
        holder.editButton.setOnClickListener((view) -> {
            String waterUsageText = holder.waterUsage.getText().toString().trim();
            if(!waterUsageText.isEmpty()) {
                float waterUsage = Float.parseFloat(df.format(Double.parseDouble(waterUsageText)));
                String url ="https://fyptechnician.herokuapp.com/editWaterUsage.php";
                //String url ="http://192.168.1.10/Technician/editWaterUsage.php";
                RequestQueue queue = Volley.newRequestQueue(context.getApplicationContext());
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                if (response.equals("Water usage editted successfullySuccessfully updatted bill")) {
                                    Log.i("tagconvertstr", "[" + response + "]");
                                    Toast.makeText(context.getApplicationContext(), "Water Usage is Updated", Toast.LENGTH_SHORT).show();
                                } else {
                                    Log.i("tagconvertstr", "[" + response + "]");
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
                        paramV.put("homeownerId", String.valueOf(homeOwnerId));
                        paramV.put("waterUsage", String.valueOf(waterUsage));
                        System.out.println("water usage: " + waterUsage);
                        System.out.println("Homeowner: " + homeOwnerId);
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            } else {
                Toast.makeText(context.getApplicationContext(), "Water usage is empty!", Toast.LENGTH_SHORT).show();
            }
        });
    }

    @Override
    public int getItemCount() {
        return WaterModels.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{
        TextView unitTv;
        EditText waterUsage;
        Button editButton;
        Button addButton;
        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            unitTv = itemView.findViewById(R.id.unitTv);
            waterUsage = itemView.findViewById(R.id.waterUsage);
            editButton = itemView.findViewById(R.id.edit);
            addButton = itemView.findViewById(R.id.add);
        }
    }
}
