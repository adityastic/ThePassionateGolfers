package com.aditya.tpg.adapters;

import android.content.Context;
import android.graphics.Color;

import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.aditya.tpg.R;
import com.aditya.tpg.datas.MemberData;

import java.util.ArrayList;

/**
 * Created by bhupendrabanothe on 12/03/2018 AD.
 */

public class MembersAdapter extends RecyclerView.Adapter<MembersAdapter.TakeAttendanceHolder> {

    ArrayList<MemberData> memberList;
    public static ArrayList<String> memberSelected;
    Context context;

    public MembersAdapter(ArrayList<MemberData> studentList, Context context) {
        this.memberList = studentList;
        memberList.add(new MemberData(0,"", "", 0));
        memberList.add(new MemberData(0,"", "", 0));
        this.context = context;
    }

    public static void setMemberSelected()
    {
        memberSelected = new ArrayList<>();
    }

    public ArrayList<String> getSelectedList() {
        return memberSelected;
    }

    public void addToList(String sname) {
        if (memberSelected.size() < 4 && checkList(sname) == -1) {
            memberSelected.add(sname);
        } else {
            Toast.makeText(context, "Cannot select more than 4 Players", Toast.LENGTH_SHORT).show();
        }
    }

    public void removeFromList(String sname) {
        memberSelected.remove(checkList(sname));
    }

    public int checkList(String sname) {
        for (int i = 0; i < memberSelected.size(); i++) {
            if (memberSelected.get(i).equals(sname)) {
                return i;
            }
        }
        return -1;
    }

    @Override
    public TakeAttendanceHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(context).inflate(R.layout.item_member, parent, false);
        return new TakeAttendanceHolder(v);
    }

    @Override
    public void onBindViewHolder(TakeAttendanceHolder holder, final int position) {
        final MemberData member = memberList.get(position);

        holder.itemView.setVisibility(View.INVISIBLE);
        if (!member.getName().equals("")) {
            holder.handicap.setText(member.getHandicap() + "");
            holder.shortname.setText(member.getShortName());
            holder.name.setText(member.getName());

            holder.card.setOnClickListener(v -> {
                if (checkList(member.getShortName()) == -1) {
                    addToList(member.getShortName());
                } else {
                    removeFromList(member.getShortName());
                }
                notifyDataSetChanged();
            });

            if (checkList(member.getShortName()) != -1) {
                holder.card.setBackground(context.getResources().getDrawable(R.color.colorAccent));
                holder.name.setTextColor(Color.parseColor("#ffffff"));
                holder.handicap.setTextColor(Color.parseColor("#ffffff"));
                holder.shortname.setTextColor(Color.parseColor("#eeeeee"));
            } else {
                holder.card.setBackground(context.getResources().getDrawable(R.color.bg));
                holder.name.setTextColor(Color.parseColor("#000000"));
                holder.shortname.setTextColor(Color.parseColor("#000000"));
                holder.handicap.setTextColor(context.getResources().getColor(R.color.colorAccent));
            }
            holder.itemView.setVisibility(View.VISIBLE);
        }
    }

    @Override
    public int getItemCount() {
        return memberList.size();
    }

    public class TakeAttendanceHolder extends RecyclerView.ViewHolder {

        TextView name, handicap, shortname;
        LinearLayout card;

        public TakeAttendanceHolder(View itemView) {
            super(itemView);
            name = itemView.findViewById(R.id.name);
            handicap = itemView.findViewById(R.id.handicap);
            shortname = itemView.findViewById(R.id.shortname);
            card = itemView.findViewById(R.id.card);
        }
    }
}
