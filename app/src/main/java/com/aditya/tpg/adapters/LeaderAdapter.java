package com.aditya.tpg.adapters;

import android.content.Context;

import androidx.appcompat.widget.AppCompatTextView;
import androidx.recyclerview.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.aditya.tpg.R;
import com.aditya.tpg.datas.LeaderInfo;

import java.util.ArrayList;

/**
 * Created by adityagupta on 12/03/2018 AD.
 */

public class LeaderAdapter extends RecyclerView.Adapter<LeaderAdapter.TakeAttendanceHolder> {

    Context context;
    ArrayList<LeaderInfo> leaderlist;

    public LeaderAdapter(Context context,ArrayList<LeaderInfo> leaderlist) {
        this.context = context;
        this.leaderlist = leaderlist;
    }

    @Override
    public TakeAttendanceHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(context).inflate(R.layout.item_leaderboard, parent, false);
        return new TakeAttendanceHolder(v);
    }

    @Override
    public void onBindViewHolder(TakeAttendanceHolder holder, final int position) {
        LeaderInfo item = leaderlist.get(position);

        holder.sname.setText(item.getSname());
        holder.name.setText(item.getName());
        holder.score.setText(item.getTotal() + " ("+ item.getScore().size() + ")");
    }

    @Override
    public int getItemCount() {
        return leaderlist.size();
    }

    public class TakeAttendanceHolder extends RecyclerView.ViewHolder {

        AppCompatTextView sname,name,score;

        public TakeAttendanceHolder(View itemView) {
            super(itemView);
            sname = itemView.findViewById(R.id.shortname);
            name = itemView.findViewById(R.id.name);
            score = itemView.findViewById(R.id.score);
        }
    }
}
