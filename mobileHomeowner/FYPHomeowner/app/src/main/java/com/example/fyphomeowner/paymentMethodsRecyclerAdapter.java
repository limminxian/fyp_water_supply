package com.example.fyphomeowner;

import android.annotation.SuppressLint;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

public class paymentMethodsRecyclerAdapter extends RecyclerView.Adapter<paymentMethodsRecyclerAdapter.MyViewHolder> {
    private ArrayList<Card> cardList;
    private Context context;
    private CardClickListener cardClickListener;

    public interface CardClickListener {
        void selectedCard(Card card);
    }

    public void setFilteredList(ArrayList<Card> filteredList){
        this.cardList = filteredList;
        notifyDataSetChanged();
    }

    public paymentMethodsRecyclerAdapter(Context context, ArrayList<Card> cardList, CardClickListener cardClickListener) {
        this.context = context;
        this.cardList = cardList;
        this.cardClickListener = cardClickListener;
    }

    @NonNull
    @Override
    public paymentMethodsRecyclerAdapter.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        //Inflates the layout (give look to rows)
        LayoutInflater inflater = LayoutInflater.from(context);
        View view =  inflater.inflate(R.layout.payment_methods_recycler_view, parent, false);

        return new paymentMethodsRecyclerAdapter.MyViewHolder(view);
    }

    @SuppressLint("SetTextI18n")
    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        //assign values to views created in recycler layout file
        //based on position of recycler view
        Card card = cardList.get(position);
        holder.cardTypeTxt.setText(cardList.get(position).getBrand());
        holder.cardNoTxt.setText(cardList.get(position).getCardNo().toString());
        holder.expiryDateTxt.setText("Expires on: " + cardList.get(position).getExpMonth() + "/" + cardList.get(position).getExpYear());
//        holder.statusTxt.setText("Status: " + ticketList.get(position).getStatus());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                cardClickListener.selectedCard(card);

            }
        });
    }

    @Override
    public int getItemCount() {
        // number of items wanted to be displayed
        return cardList.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{
        //grabs views from recycler layout file
        //similar to onCreate
        TextView cardTypeTxt;
        TextView cardNoTxt;
        TextView expiryDateTxt;


        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            cardTypeTxt = itemView.findViewById(R.id.cardTypeTxt);
            cardNoTxt = itemView.findViewById(R.id.cardNoTxt);
            expiryDateTxt = itemView.findViewById(R.id.expiryDateTxt);
//            statusTxt = itemView.findViewById(R.id.statusTxt);
        }
    }
}

