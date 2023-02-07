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

public class taskRecyclerViewAdaptor extends RecyclerView.Adapter<taskRecyclerViewAdaptor.MyViewHolder> {
    Context context;
    ArrayList<TaskModel> TaskModels;

    public taskRecyclerViewAdaptor(Context context, ArrayList<TaskModel> TaskModels) {
        this.context = context;
        this.TaskModels = TaskModels;
    }

    @NonNull
    @Override
    public taskRecyclerViewAdaptor.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View view = inflater.inflate(R.layout.recycler_view_task, parent, false);
        return new taskRecyclerViewAdaptor.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull taskRecyclerViewAdaptor.MyViewHolder holder, int position) {
        holder.homeownerTv.setText(String.format("Homeowner Name: %s", TaskModels.get(position).getName()));
        holder.descTv.setText(String.format("Description: %s", TaskModels.get(position).getDescription()));
        holder.serviceTv.setText(String.format("Service Type: %s", TaskModels.get(position).getType()));
        holder.addressTv.setText(String.format("Address: %s %s %s %s", TaskModels.get(position).getBlockNo(), TaskModels.get(position).getStreet(),
                TaskModels.get(position).getUnitNo(), TaskModels.get(position).getPostalCode()));
        holder.statusTv.setText(String.format("Status: %s", TaskModels.get(position).getStatus()));
        holder.areaTv.setText(String.format("Area: %s", TaskModels.get(position).getArea()));
        holder.itemView.setOnClickListener((view) -> {
            Intent intent = new Intent(context, updateTasksActivity.class);
            intent.putExtra("ticketID", TaskModels.get(position).getTicketID());
            context.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return TaskModels.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{
        TextView homeownerTv, serviceTv, descTv, addressTv , statusTv, areaTv;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            homeownerTv = itemView.findViewById(R.id.homeownerTv);
            serviceTv = itemView.findViewById(R.id.serviceTv);
            descTv = itemView.findViewById(R.id.descTv);
            addressTv = itemView.findViewById(R.id.addressTv);
            statusTv = itemView.findViewById(R.id.statusTv);
            areaTv = itemView.findViewById(R.id.areaTv);
        }
    }
}
