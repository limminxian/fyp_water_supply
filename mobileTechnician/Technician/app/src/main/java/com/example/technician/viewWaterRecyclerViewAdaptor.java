package com.example.technician;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

public class viewWaterRecyclerViewAdaptor extends RecyclerView.Adapter<viewWaterRecyclerViewAdaptor.MyViewHolder>{
    Context context;
    ArrayList<WaterModel> WaterModels;

    public viewWaterRecyclerViewAdaptor(Context context, ArrayList<WaterModel> WaterModels) {
        this.context = context;
        this.WaterModels = WaterModels;
    }


    @NonNull
    @Override
    public viewWaterRecyclerViewAdaptor.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View view = inflater.inflate(R.layout.recycler_view_water, parent, false);
        return new viewWaterRecyclerViewAdaptor.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull viewWaterRecyclerViewAdaptor.MyViewHolder holder, int position) {
        String unitNo = WaterModels.get(position).getUnitNo();
        if(unitNo == null || unitNo.equals("null") || unitNo.isEmpty()) {
            holder.addressTV.setText(String.format("Address: %s %s", WaterModels.get(position).getStreet(), WaterModels.get(position).getPostalCode()));
        } else {
            holder.addressTV.setText(String.format("Address: %s %s %s", WaterModels.get(position).getBlockNo(), WaterModels.get(position).getStreet(),
                    WaterModels.get(position).getPostalCode()));
        }
//        holder.addressTV.setText(String.format("%s %s %s %s", WaterModels.get(position).getBlockNo(), WaterModels.get(position).getUnitNo(), WaterModels.get(position).getStreet(), WaterModels.get(position).getPostalCode()));
        holder.itemView.setOnClickListener((view) -> {
            Intent intent = new Intent(context, addWaterUsageActivity.class);
            intent.putExtra("postalCode", WaterModels.get(position).getPostalCode());
            context.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return WaterModels.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{
        TextView addressTV;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            addressTV = itemView.findViewById(R.id.addressTv);
        }
    }
}
