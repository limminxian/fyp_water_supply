package com.example.technician;

import android.content.Context;
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
        holder.homeownerTv.setText(TaskModels.get(position).getHomeownerName());
        holder.serviceTv.setText(TaskModels.get(position).getServiceType());
        holder.descTv.setText(TaskModels.get(position).getDescription());
        holder.addressTv.setText(TaskModels.get(position).getAddress());
        holder.statusTv.setText(TaskModels.get(position).getStatus());
        holder.editButton.setImageResource(TaskModels.get(position).getImage());
    }

    @Override
    public int getItemCount() {
        return TaskModels.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{

        ImageView editButton;
        TextView homeownerTv, serviceTv, descTv, addressTv , statusTv;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            editButton = itemView.findViewById(R.id.editButton);
            homeownerTv = itemView.findViewById(R.id.homeownerTv);
            serviceTv = itemView.findViewById(R.id.serviceTv);
            descTv = itemView.findViewById(R.id.descTv);
            addressTv = itemView.findViewById(R.id.addressTv);
            statusTv = itemView.findViewById(R.id.statusTv);
        }
    }
}
