package com.aditya.tpg.adapters;

import android.content.Context;
import android.support.v7.widget.AppCompatTextView;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.aditya.tpg.R;
import com.aditya.tpg.datas.LeaderInfo;
import com.aditya.tpg.datas.PlayerScore;
import com.aditya.tpg.utils.Common;

import java.util.ArrayList;

/**
 * Created by bhupendrabanothe on 12/03/2018 AD.
 */

public class TotalAdapter extends RecyclerView.Adapter<TotalAdapter.TakeAttendanceHolder> {

    Context context;
    int parentHeight;

    public TotalAdapter(Context context, int parentIndex) {
        this.context = context;
        this.parentHeight = parentIndex;
    }

    @Override
    public TakeAttendanceHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(context).inflate(R.layout.recycler_total, parent, false);
        return new TakeAttendanceHolder(v);
    }

    @Override
    public void onBindViewHolder(TakeAttendanceHolder holder, final int position) {
        PlayerScore player = Common.scoreBoard.Score.get(position);

        holder.itemView.getLayoutParams().width = (Common.scoreBoard.Score.size() == 0) ? parentHeight : parentHeight / Common.scoreBoard.Score.size();

        holder.sname.setText(player.shortname);
        int sum = 0;
        for (int i : player.score) {
            if (i != -1)
                sum = sum + i;
        }
        holder.total.setText(sum + "");
    }

    @Override
    public int getItemCount() {
        return Common.scoreBoard.Score.size();
    }

    public void setParentIndex(int parentIndex) {
        this.parentHeight = parentIndex;
        notifyDataSetChanged();
    }

    public class TakeAttendanceHolder extends RecyclerView.ViewHolder {

        AppCompatTextView sname, total;

        public TakeAttendanceHolder(View itemView) {
            super(itemView);
            sname = itemView.findViewById(R.id.sname);
            total = itemView.findViewById(R.id.total);
        }
    }
}
