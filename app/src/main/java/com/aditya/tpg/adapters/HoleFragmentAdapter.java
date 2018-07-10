package com.aditya.tpg.adapters;

import android.animation.Animator;
import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.graphics.Typeface;
import android.support.annotation.NonNull;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.AppCompatEditText;
import android.support.v7.widget.AppCompatTextView;
import android.support.v7.widget.RecyclerView;
import android.util.DisplayMetrics;
import android.util.Log;
import android.util.TypedValue;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.view.ViewGroup;
import android.view.ViewTreeObserver;
import android.view.WindowManager;
import android.view.animation.AccelerateDecelerateInterpolator;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.aditya.tpg.R;
import com.aditya.tpg.activities.CourseInfoActivity;
import com.aditya.tpg.datas.MemberData;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.sqlite.DBHelper;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import biz.borealis.numberpicker.NumberPicker;

public class HoleFragmentAdapter extends RecyclerView.Adapter<HoleFragmentAdapter.HoleFragmentAdapterHolder> {

    Context context;
    ArrayList<String> shortnames;
    ArrayList<AppCompatTextView> editTextList;
    int fragindex;
    int parentHeight;

    public HoleFragmentAdapter(Context context, ArrayList<String> shortNames, int fragindex, int parentIndex) {
        this.context = context;
        this.fragindex = fragindex;
        this.shortnames = shortNames;
        this.parentHeight = parentIndex;
        editTextList = new ArrayList<>();
        for (String s : shortNames) {
            editTextList.add(new AppCompatTextView(context));
        }
    }

    public ArrayList<Integer> getStrokes() {
        ArrayList<Integer> list = new ArrayList<>();
        for (AppCompatTextView edit : editTextList) {
            list.add(Integer.parseInt((edit.getText().toString().trim().equals("-")) ? "-1" : edit.getText().toString()));
        }
        return list;
    }

    @Override
    public int getItemViewType(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @NonNull
    @Override
    public HoleFragmentAdapterHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new HoleFragmentAdapterHolder(LayoutInflater.from(context).inflate(R.layout.item_member_score, parent, false));
    }

    @Override
    public void onBindViewHolder(@NonNull final HoleFragmentAdapterHolder holder, final int position) {
        MemberData mem = getMemberData(shortnames.get(position));
        if (mem != null) {
            holder.sname.setText(mem.getShortName());
            holder.handicap.setText(mem.getHandicap() + "");

//            holder.itemView.getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
//                @Override
//                public void onGlobalLayout() {
//                    holder.itemView.getViewTreeObserver().removeOnGlobalLayoutListener(this);
//                    if (parentHeight > (holder.itemView.getHeight() * shortnames.size())) {
//                        holder.itemView.getLayoutParams().height = parentHeight / shortnames.size();
//                    } else {
//                        holder.itemView.getLayoutParams().height = parentHeight / 2;
//                    }
//                }
//            });

            holder.itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    final AlertDialog.Builder dialog = new AlertDialog.Builder(context);

                    View numberLayout = View.inflate(context, R.layout.dialog_picker, null);
                    final NumberPicker numberPicker = numberLayout.findViewById(R.id.numberPicker);
                    numberPicker.setMin(1);
                    numberPicker.setMax(9);
                    numberPicker.setTextSizeSelected(context.getResources().getDimensionPixelSize(R.dimen.scoredialog));
                    numberPicker.setTextColorSelected(context.getResources().getColor(R.color.colorAccent));


                    TextView title = new TextView(context);
// You Can Customise your Title here
                    title.setText("Select Score");
                    title.setPadding(10, 10, 10, 10);
                    title.setGravity(Gravity.CENTER);
                    title.setTextSize(20);

                    dialog.setCustomTitle(title);

                    dialog.setView(numberLayout);
                    dialog.setOnCancelListener(new DialogInterface.OnCancelListener() {
                        @Override
                        public void onCancel(DialogInterface dialog) {
                            holder.strokes.setText(numberPicker.getSelectedNumber() + "");
                        }
                    });
                    dialog.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            holder.strokes.setText(numberPicker.getSelectedNumber() + "");
                        }
                    });

                    AlertDialog alertDialog = dialog.create();
                    alertDialog.show();
                    alertDialog.getWindow().setLayout((int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, 200,
                            context.getResources().getDisplayMetrics()), (int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, 300,
                            context.getResources().getDisplayMetrics()));
                    final Button positiveButton = alertDialog.getButton(AlertDialog.BUTTON_POSITIVE);
                    positiveButton.setTextSize(20);
                    positiveButton.setTypeface(positiveButton.getTypeface(), Typeface.BOLD);
                    LinearLayout.LayoutParams positiveButtonLL = (LinearLayout.LayoutParams) positiveButton.getLayoutParams();
                    positiveButtonLL.width = ViewGroup.LayoutParams.MATCH_PARENT;
                    positiveButton.setLayoutParams(positiveButtonLL);
                }
            });

            int prevScore = Common.scoreBoard.Score.get(position).score.get(fragindex);

            holder.strokes.setText((prevScore == -1) ? "-" : prevScore + "");

            editTextList.set(position, holder.strokes);
        }
    }

    public MemberData getMemberData(String sname) {
        for (MemberData mem : Common.tournaments.getMembers()) {
            if (mem.getShortName().equals(sname))
                return mem;
        }
        return null;
    }

    @Override
    public int getItemCount() {
        return shortnames.size();
    }

    public void setParentIndex(int parentIndex) {
        this.parentHeight = parentIndex;
        notifyDataSetChanged();
    }

    public class HoleFragmentAdapterHolder extends RecyclerView.ViewHolder {

        TextView sname, handicap;
        AppCompatTextView strokes;

        public HoleFragmentAdapterHolder(View itemView) {
            super(itemView);
            sname = itemView.findViewById(R.id.shortname);
            handicap = itemView.findViewById(R.id.handicap);
            strokes = itemView.findViewById(R.id.score);
        }
    }
}
