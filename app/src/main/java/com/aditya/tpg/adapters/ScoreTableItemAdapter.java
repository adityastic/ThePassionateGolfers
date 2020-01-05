package com.aditya.tpg.adapters;

import android.content.Context;
import android.graphics.Color;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.aditya.tpg.R;

import java.util.ArrayList;

public class ScoreTableItemAdapter extends RecyclerView.Adapter<ScoreTableItemAdapter.ScoreTableItemHolder> {

    Context context;
    ArrayList<String> list;
    ArrayList<Integer> shapes;
    public static int parentHeight;
    boolean color;

    public ScoreTableItemAdapter(Context context, ArrayList<String> list, boolean color, ArrayList<Integer> shape) {
        this.context = context;
        this.list = list;
        this.shapes = shape;
        this.color = color;
    }

    @NonNull
    @Override
    public ScoreTableItemHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new ScoreTableItemHolder(LayoutInflater.from(context).inflate(R.layout.item_scoretable_item, parent, false));
    }

    @Override
    public void onBindViewHolder(@NonNull final ScoreTableItemHolder holder, int position) {


        int width = (parentHeight - (20 * list.size()) - 20) / list.size();

        ViewGroup.LayoutParams params = holder.itemView.getLayoutParams();
        params.width = width;
        holder.itemView.setLayoutParams(params);

        if (shapes.size() != 0) {
            switch (shapes.get(position)) {
                case 0:
                    holder.image.setImageDrawable(context.getResources().getDrawable(R.drawable.ic_square));
                    break;
                case 1:
                    holder.image.setImageDrawable(context.getResources().getDrawable(R.drawable.ic_circle));
                    break;
                case 2:
                    holder.image.setImageDrawable(context.getResources().getDrawable(R.drawable.ic_circle));
                    break;
                default:
                    holder.image.setImageDrawable(null);
            }
        }

        holder.itemScore.setText((list.get(position).trim() == "0") ? "-" : (list.get(position)));
        holder.itemScore.setTextColor((color) ? Color.parseColor("#ffffff") : Color.parseColor("#000000"));
    }

    @Override
    public int getItemCount() {
        return list.size();
    }

    public class ScoreTableItemHolder extends RecyclerView.ViewHolder {

        TextView itemScore;
        ImageView image;

        public ScoreTableItemHolder(View itemView) {
            super(itemView);

            itemScore = itemView.findViewById(R.id.item_title);
            image = itemView.findViewById(R.id.img_score);
        }
    }
}
