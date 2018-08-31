package com.aditya.tpg.activities;

import android.content.res.Resources;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.util.TypedValue;
import android.view.View;
import android.view.ViewTreeObserver;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.aditya.tpg.R;
import com.aditya.tpg.adapters.LeaderAdapter;
import com.aditya.tpg.adapters.ScoreTableAdapter;
import com.aditya.tpg.adapters.ScoreTableItemAdapter;
import com.aditya.tpg.datas.LeaderInfo;
import com.aditya.tpg.datas.PlayerScore;
import com.aditya.tpg.utils.Common;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;

import static com.aditya.tpg.adapters.ScoreTableAdapter.done;

public class ScoreTableActivity extends AppCompatActivity {

    SwipeRefreshLayout mSwipeRefreshLayout;
    RecyclerView mRecyclerView;
    ScoreTableAdapter mAdapter;
    Toolbar mToolbar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_score_table);

        mToolbar = findViewById(R.id.toolbar);

        setUpToolbar();

        mSwipeRefreshLayout = findViewById(R.id.swipeRefresh);
        mRecyclerView = findViewById(R.id.recyclerView);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(this));

        mAdapter = new ScoreTableAdapter(ScoreTableActivity.this, Common.scoreBoard.Score);
        mAdapter.setHasStableIds(true);
        mRecyclerView.setAdapter(mAdapter);

        TextView hole, par;
        RecyclerView recyclerScoreTable;
        hole = findViewById(R.id.holes);
        par = findViewById(R.id.par);
        recyclerScoreTable = findViewById(R.id.recyclerscoreitem);

        final ArrayList<String> listItems = new ArrayList<>();

        hole.setText("Hole");
        hole.setTextSize(TypedValue.COMPLEX_UNIT_SP, 20);
        par.setText("Par");

        for (PlayerScore p : Common.scoreBoard.Score) {
            listItems.add(p.shortname);
        }

        ArrayList<Integer> shapeList = new ArrayList<>();

        recyclerScoreTable.setLayoutManager(new LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false));

        findViewById(R.id.card).setBackground(getResources().getDrawable(R.drawable.black_score));

        int margin = dp2px(getResources(), 5);

        RelativeLayout.LayoutParams cardla = (RelativeLayout.LayoutParams) findViewById(R.id.card).getLayoutParams();
        cardla.setMargins(margin, margin, margin, margin);
        findViewById(R.id.card).setLayoutParams(cardla);

        hole.setTextColor(Color.parseColor("#ffffff"));
        par.setTextColor(Color.parseColor("#ffffff"));
        ((ImageView) findViewById(R.id.par_img)).setImageDrawable(null);

        ScoreTableItemAdapter adapter = new ScoreTableItemAdapter(this, listItems, true, shapeList);
        recyclerScoreTable.setAdapter(adapter);

        recyclerScoreTable.getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                if (!done) {
                    done = true;
                    ScoreTableItemAdapter.parentHeight = findViewById(R.id.relativeRecycler).getWidth();
                    adapter.notifyDataSetChanged();
                }
                recyclerScoreTable.getViewTreeObserver().removeOnGlobalLayoutListener(this);
            }
        });


        refreshLayout();

        mSwipeRefreshLayout.setOnRefreshListener(() -> refreshLayout());
    }


    public int dp2px(Resources resource, int dp) {
        return (int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, dp, resource.getDisplayMetrics());
    }

    private void setUpToolbar() {
        setTitle("Score Table");
        setSupportActionBar(mToolbar);
        mToolbar.setNavigationOnClickListener(v -> onBackPressed());
        //noinspection ConstantConditions
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    public void refreshLayout() {

        mSwipeRefreshLayout.setRefreshing(true);

        mAdapter.notifyDataSetChanged();

        mSwipeRefreshLayout.setRefreshing(false);
    }
}
