package com.aditya.tpg.adapters;

import android.content.Context;
import android.content.res.Resources;
import android.graphics.Color;
import android.graphics.Paint;
import android.support.annotation.NonNull;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Html;
import android.text.Layout;
import android.text.SpannableString;
import android.text.style.UnderlineSpan;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewTreeObserver;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.aditya.tpg.R;
import com.aditya.tpg.datas.Holes;
import com.aditya.tpg.datas.LeaderInfo;
import com.aditya.tpg.datas.PlayerScore;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.typeface.TypefaceUtil;

import java.util.ArrayList;

import static com.aditya.tpg.adapters.TournamentAdapter.parentHeight;

public class ScoreTableAdapter extends RecyclerView.Adapter<ScoreTableAdapter.ScoreTableViewholder> {

    Context context;
    ArrayList<PlayerScore> list;
    public static boolean done;
    public boolean tableadap;


    public ScoreTableAdapter(Context context, ArrayList<PlayerScore> list) {
        this.context = context;
        this.list = list;
        done = false;
        tableadap = false;
    }

    @NonNull
    @Override
    public ScoreTableViewholder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new ScoreTableViewholder(LayoutInflater.from(context).inflate(R.layout.item_scoretable, parent, false));
    }

    @Override
    public int getItemViewType(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public void onBindViewHolder(@NonNull final ScoreTableViewholder holder, int position) {

        final ArrayList<String> listItems = new ArrayList<>();
        int shape = 0;

        boolean color = false;

        if (list.get(0).score.size() == 9) {
            if (position == list.get(0).score.size() + 1) {
                holder.holeno.setText("Grand T.");
                holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 15);

                int sumpar = 0;
                for (int i = 0; i < 9; i++) {
                    sumpar += Common.tournaments.getCourse().getHoles().get(i).getPar();
                }

                holder.par.setText(sumpar + "");

                color = true;
                for (PlayerScore p : list) {
                    int sum = 0;
                    for (int i : p.score) {
                        if (i > 0)
                            sum += i;
                    }
                    listItems.add((sum > 0) ? sum + "" : "-");
                }
            } else {
                holder.holeno.setText(position + "");
                holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 20);
                holder.par.setText(Common.tournaments.getCourse().getHoles().get(position).getPar() + "");

                for (PlayerScore p : list) {
                    listItems.add(((p.score.get(position - 1)) == -1) ? "0" : String.valueOf(p.score.get(position - 1)));
                }
            }
        } else {
            if (position == 9) {
                holder.holeno.setText("F9 Tot.");
                holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 15);

                int sumpar = 0;
                for (int i = 0; i < 9; i++) {
                    sumpar += Common.tournaments.getCourse().getHoles().get(i).getPar();
                }

                holder.par.setText(sumpar + "");

                color = true;

                for (PlayerScore p : list) {
                    int sum = 0;
                    for (int i = 0; i < 9; i++) {
                        if (p.score.get(i) > 0)
                            sum += p.score.get(i);
                    }
                    listItems.add((sum > 0) ? sum + "" : "-");
                }
            } else if (position == list.get(0).score.size() + 1) {
                holder.holeno.setText("B9 Tot.");
                holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 15);

                int sumpar = 0;
                for (int i = 9; i < 18; i++) {
                    sumpar += Common.tournaments.getCourse().getHoles().get(i).getPar();
                }

                holder.par.setText(sumpar + "");

                color = true;

                for (PlayerScore p : list) {
                    int sum = 0;
                    for (int i = 9; i < 18; i++) {
                        if (p.score.get(i) > 0)
                            sum += p.score.get(i);
                    }
                    listItems.add((sum > 0) ? sum + "" : "-");
                }
            } else if (position == list.get(0).score.size() + 2) {
                holder.holeno.setText("Grand \nTotal");
                holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 15);

                int sumpar = 0;
                for (int i = 0; i < 18; i++) {
                    sumpar += Common.tournaments.getCourse().getHoles().get(i).getPar();
                }

                holder.par.setText(sumpar + "");

                color = true;

                for (PlayerScore p : list) {
                    int sum = 0;
                    for (int i : p.score) {
                        if (i > 0)
                            sum += i;
                    }
                    listItems.add((sum > 0) ? sum + "" : "-");
                }
            } else {
                if (position < 9) {
                    holder.holeno.setText((position+1) + "");
                    holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 20);
                    holder.par.setText(Common.tournaments.getCourse().getHoles().get(position).getPar() + "");

                    for (PlayerScore p : list) {
                        listItems.add(((p.score.get(position)) == -1) ? "0" : String.valueOf(p.score.get(position)));
                    }
                } else {
                    holder.holeno.setText((position) + "");

                    holder.holeno.setTextSize(TypedValue.COMPLEX_UNIT_SP, 20);
                    holder.par.setText(Common.tournaments.getCourse().getHoles().get(position - 1).getPar() + "");

                    for (PlayerScore p : list) {
                        listItems.add(((p.score.get(position - 1)) == -1) ? "0" : String.valueOf(p.score.get(position - 1)));
                    }
                }
            }
        }

        holder.recyclerScoreTable.setLayoutManager(new LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false));

        holder.recyclerScoreTable.getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                if (!done) {
                    done = true;
                    ScoreTableItemAdapter.parentHeight = holder.relativeLayout.getWidth();
                    notifyDataSetChanged();
                }
                if(!tableadap)
                {
                    tableadap = true;
                    notifyDataSetChanged();
                }
                holder.recyclerScoreTable.getViewTreeObserver().removeOnGlobalLayoutListener(this);
            }
        });

        ArrayList<Integer> shapeList = new ArrayList<>();

        if (color) {
            holder.card.setBackground(context.getResources().getDrawable(R.drawable.black_score));

            int margin = dp2px(context.getResources(), 5);

            RelativeLayout.LayoutParams cardla = (RelativeLayout.LayoutParams) holder.card.getLayoutParams();
            cardla.setMargins(margin, margin, margin, margin);
            holder.card.setLayoutParams(cardla);

            holder.holeno.setTextColor(Color.parseColor("#ffffff"));
            if (holder.par.getText().toString() == "Par") {
                holder.par.setTextColor(Color.parseColor("#ffffff"));
                holder.parim.setImageDrawable(null);
            } else {
                holder.par.setTextColor(context.getResources().getColor(R.color.colorAccent));
                holder.parim.setImageDrawable(context.getResources().getDrawable(R.drawable.ic_square_fill));
            }
        } else {
            holder.card.setBackgroundColor(Color.parseColor("#ffffff"));

            int margin = dp2px(context.getResources(), 0);
            RelativeLayout.LayoutParams cardla = (RelativeLayout.LayoutParams) holder.card.getLayoutParams();
            cardla.setMargins(margin, margin, margin, margin);
            holder.card.setLayoutParams(cardla);

            holder.par.setTextColor(context.getResources().getColor(R.color.colorAccent));
            holder.holeno.setTextColor(Color.parseColor("#909090"));

            int par = Integer.parseInt(holder.par.getText().toString());

            for (String i : listItems) {
                int item = Integer.parseInt(i);

                int diff = par - item;
                shapeList.add(diff);

            }
        }
        ScoreTableItemAdapter adapter = new ScoreTableItemAdapter(context, listItems, color, shapeList);
        holder.recyclerScoreTable.setAdapter(adapter);
    }


    public int dp2px(Resources resource, int dp) {
        return (int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, dp, resource.getDisplayMetrics());
    }

    @Override
    public int getItemCount() {
        return (list.get(0).score.size() == 9) ? list.get(0).score.size() + 1 : list.get(0).score.size() + 3;
    }

    public class ScoreTableViewholder extends RecyclerView.ViewHolder {

        RecyclerView recyclerScoreTable;
        RelativeLayout relativeLayout;
        ImageView parim;
        TextView holeno, par;
        LinearLayout card;

        public ScoreTableViewholder(View itemView) {
            super(itemView);

            holeno = itemView.findViewById(R.id.holes);
            parim = itemView.findViewById(R.id.par_img);
            par = itemView.findViewById(R.id.par);
            recyclerScoreTable = itemView.findViewById(R.id.recyclerscoreitem);
            relativeLayout = itemView.findViewById(R.id.relativeRecycler);
            card = itemView.findViewById(R.id.card);
        }
    }
}
