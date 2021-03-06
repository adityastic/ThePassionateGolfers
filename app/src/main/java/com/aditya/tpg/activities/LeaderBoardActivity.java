package com.aditya.tpg.activities;

import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;
import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.appcompat.widget.Toolbar;

import com.aditya.tpg.R;
import com.aditya.tpg.adapters.LeaderAdapter;
import com.aditya.tpg.datas.LeaderInfo;
import com.aditya.tpg.utils.Common;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Collections;

public class LeaderBoardActivity extends AppCompatActivity {

    SwipeRefreshLayout mSwipeRefreshLayout;
    RecyclerView mRecyclerView;
    LeaderAdapter mAdapter;
    Toolbar mToolbar;

    ArrayList<LeaderInfo> leaderlist;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_leader_board);

        mToolbar = findViewById(R.id.toolbar);

        setUpToolbar();

        mSwipeRefreshLayout = findViewById(R.id.swipeRefresh);
        mRecyclerView = findViewById(R.id.recyclerView);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(this));

        refreshLayout();

        mSwipeRefreshLayout.setOnRefreshListener(() -> refreshLayout());
    }

    private void setUpToolbar() {
        setTitle("Leaderboard");
        setSupportActionBar(mToolbar);
        mToolbar.setNavigationOnClickListener(v -> onBackPressed());
        //noinspection ConstantConditions
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    public void refreshLayout() {

        leaderlist = new ArrayList<>();
        mSwipeRefreshLayout.setRefreshing(true);
        mAdapter = null;
        mRecyclerView.setAdapter(null);

        Common.getLeaderboard(new Common.onGotJSON() {
            @Override
            public void gotJSON(JSONArray jsonArray) throws JSONException {
                for (int i = 0; i < jsonArray.length(); i++) {
                    JSONObject scoreMain = (JSONObject) jsonArray.get(i);
                    String name = scoreMain.getString("name");
                    String sname = scoreMain.getString("shortname");

                    JSONArray score = scoreMain.getJSONArray("score");

                    ArrayList<Integer> scorecard = new ArrayList<>();
                    for (int j = 0; j < score.length(); j++) {
                        if (score.getInt(j) != -1)
                            scorecard.add(score.getInt(j));
                    }
                    LeaderInfo leaderInfo = new LeaderInfo(sname, name, scorecard);
                    if (leaderInfo.getTotal() > 0)
                        leaderlist.add(leaderInfo);
                }

                Collections.sort(leaderlist, (o1, o2) -> o1.getTotal() - o2.getTotal());

                int ranking = 1;
                for (int i = 0; i < leaderlist.size(); i++) {
                    int tot1, tot2, tot3;

                    tot1 = (leaderlist.get(i)).getTotal();
                    if (i == 0) {
                        tot2 = (leaderlist.get(i)).getTotal();
                    } else {
                        tot2 = (leaderlist.get(i - 1)).getTotal();
                    }
                    if (tot1 == tot2) {
                        if (ranking == 0) {
                            ranking += 1;
                        }
                    } else {
                        ranking = i + 1;
                    }

                    tot3 = (i == (leaderlist.size() - 1)) ? -1 : leaderlist.get(i + 1).getTotal();
                    if (i == 0) {
                        if (tot1 == tot3)
                            (leaderlist.get(i)).setSname("T" + ranking + "");
                        else
                            (leaderlist.get(i)).setSname("" + ranking + "");
                    } else {
                        if (tot1 == tot2 || tot1 == tot3)
                            (leaderlist.get(i)).setSname("T" + ranking + "");
                        else
                            (leaderlist.get(i)).setSname("" + ranking + "");
                    }
                }

                mAdapter = new LeaderAdapter(LeaderBoardActivity.this, leaderlist);
                mRecyclerView.setAdapter(mAdapter);
                mSwipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void gotJSON(JSONObject jsonObject) {

            }

            @Override
            public void failedJSON(Exception e) {

            }
        }, String.valueOf(Common.tournaments.getId()));
    }
}
