package com.aditya.tpg.adapters;

import android.animation.Animator;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.ActivityOptions;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.RecyclerView;
import android.text.format.DateUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.view.ViewGroup;
import android.view.animation.AccelerateDecelerateInterpolator;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.aditya.tpg.R;
import com.aditya.tpg.activities.CourseInfoActivity;
import com.aditya.tpg.activities.MainActivity;
import com.aditya.tpg.activities.ScoreboardActivity;
import com.aditya.tpg.activities.SelectMembersActivity;
import com.aditya.tpg.datas.Tournament;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.sqlite.DBHelper;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

import static android.view.View.GONE;

public class TournamentAdapter extends RecyclerView.Adapter<TournamentAdapter.TounamentAdapterHolder> {

    private Context context;
    private int lastPosition = -1;
    private Date current;
    static int parentHeight;

    public TournamentAdapter(Context context, Date current) {
        this.context = context;
        this.current = current;
    }

    @NonNull
    @Override
    public TounamentAdapterHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new TounamentAdapterHolder(LayoutInflater.from(context).inflate(R.layout.tournament_recycler, parent, false));
    }

    @Override
    public void onViewDetachedFromWindow(@NonNull TounamentAdapterHolder holder) {
        super.onViewDetachedFromWindow(holder);
        holder.image.clearAnimation();
        holder.itemView.clearAnimation();
    }


    @SuppressLint({"SetTextI18n", "SimpleDateFormat"})
    @Override
    public void onBindViewHolder(@NonNull final TounamentAdapterHolder holder, @SuppressLint("RecyclerView") final int position) {
        final Tournament tournament = Common.tournaments;

        holder.itemView.getLayoutParams().height = parentHeight - 20;

        final int randim = (int) (Math.random() * 3) + 1;
        switch (randim) {
            case 1:
                holder.image.setImageDrawable(context.getResources().getDrawable(R.drawable.gc1));
                break;
            case 2:
                holder.image.setImageDrawable(context.getResources().getDrawable(R.drawable.gc2));
                break;
            case 3:
                holder.image.setImageDrawable(context.getResources().getDrawable(R.drawable.gc3));
                break;
        }

        holder.image.setVisibility(View.INVISIBLE);
        holder.title.setText(tournament.getName());
        holder.date.setText("| " + tournament.getDate());
        holder.course.setText("| " + tournament.getCourse().getName());

        try {
            if (tournament.getRegdate().getTime() - current.getTime() > 0) {
                holder.regdate.setText("Last Registration Date is:- \n" + new SimpleDateFormat("yyyy-MM-dd").format(tournament.getRegdate()));
                SQLiteDatabase readdatabase = DBHelper.dbHelper.getReadableDatabase();
                SQLiteDatabase writedatabase = DBHelper.dbHelper.getWritableDatabase();
                Cursor cursor = readdatabase.rawQuery("SELECT * FROM tbgolftournament", null);
                if (cursor.getCount() != 0) {
                    cursor.moveToFirst();
                    do {
                        writedatabase.delete("tbgolftournament", "gtid = " + cursor.getInt(cursor.getColumnIndex("gtid")), null);
                    }while(cursor.moveToNext());
                }
                holder.image.setOnClickListener(v -> {
                    try {
                        Toast.makeText(context, "Last Registration date is " + new SimpleDateFormat("yyyy-MM-dd").format(tournament.getRegdate()), Toast.LENGTH_SHORT).show();
                    } catch (ParseException e) {
                        e.printStackTrace();
                    }
                });
            } else {

                if (DateUtils.isToday(Calendar.getInstance().getTime().getTime())) {
                    holder.regdate.setText("Tap to Enter");
                    holder.image.setOnClickListener(v -> {
                        Intent i;
                        if (MainActivity.already) {
                            i = new Intent(context, ScoreboardActivity.class);
                        } else {
                            i = new Intent(context, SelectMembersActivity.class);
                        }
                        context.startActivity(i);
                    });
                } else {
                    holder.regdate.setText("Registration Complete, You can Enter on Match Day");

                    SQLiteDatabase readdatabase = DBHelper.dbHelper.getReadableDatabase();
                    SQLiteDatabase writedatabase = DBHelper.dbHelper.getWritableDatabase();
                    Cursor cursor = readdatabase.rawQuery("SELECT * FROM tbgolftournament", null);
                    if (cursor.getCount() != 0) {
                        cursor.moveToFirst();
                        do {
                            writedatabase.delete("tbgolftournament", "gtid = " + cursor.getInt(cursor.getColumnIndex("gtid")), null);
                        }while(cursor.moveToNext());
                    }
                    holder.image.setOnClickListener(v -> {
                        try {
                            Toast.makeText(context, "You Can only enter on " + new SimpleDateFormat("yyyy-MM-dd").format(new SimpleDateFormat("yyyy-MM-dd").parse(tournament.getDate())), Toast.LENGTH_SHORT).show();
                        } catch (ParseException e) {
                            e.printStackTrace();
                        }
                    });
                }
            }
        } catch (ParseException e) {
            e.printStackTrace();
        }

        Animation animation = AnimationUtils.loadAnimation(context, (position > lastPosition) ? R.anim.slide_from_bottom
                : R.anim.slide_from_top);
        animation.setAnimationListener(new Animation.AnimationListener() {
            @Override
            public void onAnimationStart(Animation animation) {

            }

            @Override
            public void onAnimationEnd(Animation animation) {
                if (holder.image.isAttachedToWindow()) {
                    int cx = (int) ((holder.image.getLeft() + holder.image.getRight()) * Math.random());
                    int cy = (int) ((holder.image.getTop() + holder.image.getBottom()) * Math.random());

                    // get the final radius for the clipping circle
                    int dx = Math.max(cx, holder.image.getWidth() - cx);
                    int dy = Math.max(cy, holder.image.getHeight() - cy);
                    float finalRadius = (float) Math.hypot(dx, dy);

                    Animator animator = null;
                    if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
                        animator = ViewAnimationUtils.createCircularReveal(holder.image, cx, cy, 0, finalRadius);
                        animator.setInterpolator(new AccelerateDecelerateInterpolator());
                        animator.setDuration(850);
                        animator.start();
                    }
                    holder.image.setVisibility(View.VISIBLE);
                } else {
                    holder.image.post(new Runnable() {
                        @Override
                        public void run() {
                            int cx = (int) ((holder.image.getLeft() + holder.image.getRight()) * Math.random());
                            int cy = (int) ((holder.image.getTop() + holder.image.getBottom()) * Math.random());

                            // get the final radius for the clipping circle
                            int dx = Math.max(cx, holder.image.getWidth() - cx);
                            int dy = Math.max(cy, holder.image.getHeight() - cy);
                            float finalRadius = (float) Math.hypot(dx, dy);

                            Animator animator = null;
                            if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
                                animator = ViewAnimationUtils.createCircularReveal(holder.image, cx, cy, 0, finalRadius);
                                animator.setInterpolator(new AccelerateDecelerateInterpolator());
                                animator.setDuration(850);
                                animator.start();
                            }
                            holder.image.setVisibility(View.VISIBLE);
                        }
                    });
                }
            }

            @Override
            public void onAnimationRepeat(Animation animation) {

            }
        });
        holder.itemView.startAnimation(animation);
        lastPosition = position;
    }

    @Override
    public int getItemCount() {
        if (Common.tournaments != null)
            return 1;
        else
            return 0;
    }

    public static void setParentIndex(int parentIndex) {
        parentHeight = parentIndex;
    }

    public class TounamentAdapterHolder extends RecyclerView.ViewHolder {

        TextView title, date, course, regdate;
        ImageView image;

        public TounamentAdapterHolder(View itemView) {
            super(itemView);

            title = itemView.findViewById(R.id.Tournament_Name);
            date = itemView.findViewById(R.id.Tournament_Date);
            regdate = itemView.findViewById(R.id.Date_Registration);
            course = itemView.findViewById(R.id.Tournament_Course);
            image = itemView.findViewById(R.id.image);
        }
    }
}
