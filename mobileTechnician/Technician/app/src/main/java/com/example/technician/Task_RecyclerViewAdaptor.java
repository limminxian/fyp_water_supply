package com.example.technician;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

public class Task_RecyclerViewAdaptor extends RecyclerView.Adapter<Task_RecyclerViewAdaptor.MyViewHolder> {
    Context context;
    ArrayList<TaskModel> TaskModels;

    public Task_RecyclerViewAdaptor(Context context, ArrayList<TaskModel> TaskModels) {
        this.context = context;
        this.TaskModels = TaskModels;
    }

    @NonNull
    @Override
    public Task_RecyclerViewAdaptor.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View view = inflater.inflate(R.layout.recycler_view_row, parent, false);
        return new Task_RecyclerViewAdaptor.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull Task_RecyclerViewAdaptor.MyViewHolder holder, int position) {
        holder.homeownerTv.setText(TaskModels.get(position).getName());
        holder.serviceTv.setText(TaskModels.get(position).getType());
        holder.descTv.setText(TaskModels.get(position).getDescription());
        holder.addressTv.setText(String.format("%s %s %s %s", TaskModels.get(position).getBlockNo(), TaskModels.get(position).getStreet(), TaskModels.get(position).getUnitNo(), TaskModels.get(position).getPostalCode()));
        //holder.addressTv.setText(TaskModels.get(position).getAddress());
        holder.statusTv.setText(TaskModels.get(position).getStatus());

        holder.itemView.setOnClickListener((view) -> {
            Intent intent = new Intent(context, updateTasksActivity.class);
            intent.putExtra("homeownerName", TaskModels.get(position).getName());
            intent.putExtra("serviceType", TaskModels.get(position).getType());
            intent.putExtra("description", TaskModels.get(position).getDescription());
            intent.putExtra("address", TaskModels.get(position).getBlockNo() + " " + TaskModels.get(position).getStreet() + " " + TaskModels.get(position).getUnitNo() + " " + TaskModels.get(position).getPostalCode());
            intent.putExtra("status", TaskModels.get(position).getStatus());
            context.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return TaskModels.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{
        TextView homeownerTv, serviceTv, descTv, addressTv , statusTv;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            homeownerTv = itemView.findViewById(R.id.homeownerTv);
            serviceTv = itemView.findViewById(R.id.serviceTv);
            descTv = itemView.findViewById(R.id.descTv);
            addressTv = itemView.findViewById(R.id.addressTv);
            statusTv = itemView.findViewById(R.id.statusTv);
        }
    }
}
