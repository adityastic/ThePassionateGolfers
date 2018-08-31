package com.aditya.tpg.activities;

import android.annotation.SuppressLint;
import android.content.ContentValues;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Build;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v4.widget.NestedScrollView;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewTreeObserver;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.aditya.tpg.R;
import com.aditya.tpg.Views.CustomViewpager;
import com.aditya.tpg.adapters.TotalAdapter;
import com.aditya.tpg.adapters.TournamentAdapter;
import com.aditya.tpg.datas.PlayerScore;
import com.aditya.tpg.datas.ScoreBoard;
import com.aditya.tpg.datas.Tournament;
import com.aditya.tpg.fragments.HoleFragment;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.sqlite.DBHelper;

import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

public class ScoreboardActivity extends AppCompatActivity {

    CustomViewpager viewPager;
    Toolbar mToolbar;
    int holes;
    List<HoleFragment> mFragmentList;

    RecyclerView mRecyclerView;
    TotalAdapter mAdapter;

    @Override
    public void onBackPressed() {
        finishAffinity();
        startActivity(new Intent(this,MainActivity.class));
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scoreboard);

        holes = Common.tournaments.getCourse().getHoles().size();

        ((NestedScrollView) findViewById(R.id.nestedView)).setFillViewport(true);

        mToolbar = findViewById(R.id.toolbar);

        setUpToolbar();


        mFragmentList = new ArrayList<>();

        viewPager = findViewById(R.id.viewpager);
        //Setup-ViewPagers
        setupScoreBoard();

        setupViewPager(viewPager);

        setupTotalView();

        FloatingActionButton button = findViewById(R.id.done);

        button.setOnClickListener(v -> onButtonClicked());


        findViewById(R.id.recyclerRelative).getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                findViewById(R.id.recyclerRelative).getViewTreeObserver().removeOnGlobalLayoutListener(this);
                mAdapter.setParentIndex(findViewById(R.id.recycleRelative).getWidth());
            }
        });
    }

    private void setupTotalView() {
        mRecyclerView = findViewById(R.id.recyclerView);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false));

        mAdapter = new TotalAdapter(this, findViewById(R.id.recyclerRelative).getWidth());
        mRecyclerView.setAdapter(mAdapter);
    }

    @SuppressLint("StaticFieldLeak")
    private void setupScoreBoard() {

        SQLiteDatabase readdatabase = DBHelper.dbHelper.getReadableDatabase();
        Cursor cursor = readdatabase.rawQuery("SELECT * FROM tbgolftournament", null);
        if (cursor.getCount() == 0) {
            Common.scoreBoard = new ScoreBoard(new ArrayList<>());

            for (String player : Common.playerNames) {
                PlayerScore playerScore = new PlayerScore(player, new ArrayList<>());
                playerScore.generateScore(holes);
                Common.scoreBoard.Score.add(playerScore);
            }
        }
    }

    private void setUpToolbar() {
        setTitle("");
        setSupportActionBar(mToolbar);
        //noinspection ConstantConditions
    }

    @SuppressLint("StaticFieldLeak")
    public void onButtonClicked() {

        new AsyncTask<Void, Void, Void>() {
            @Override
            protected Void doInBackground(Void... voids) {
                for (int j = 0; j < holes; j++) {
                    ArrayList<Integer> scoreofHole = mFragmentList.get(j).mAdapter.getStrokes();

                    for (int i = 0; i < Common.scoreBoard.Score.size(); i++) {
                        PlayerScore playerScore = Common.scoreBoard.Score.get(i);
                        playerScore.score.set(j, scoreofHole.get(i));
                    }
                }

                try {
                    uploadScoretoSqlLite();
                } catch (ParseException e) {
                    e.printStackTrace();
                }

                OutputStream os = null;
                InputStream is = null;
                HttpURLConnection conn = null;
                try {
                    //constants
                    URL url = new URL(String.format(Common.UPLOAD_SCORE, Common.tournaments.getId()));
                    String message = Common.scoreBoard.Score.toString();

                    conn = (HttpURLConnection) url.openConnection();
                    conn.setReadTimeout(10000 /*milliseconds*/);
                    conn.setConnectTimeout(15000 /* milliseconds */);
                    conn.setRequestMethod("POST");
                    conn.setDoInput(true);
                    conn.setDoOutput(true);
                    conn.setFixedLengthStreamingMode(message.getBytes().length);

                    //make some HTTP header nicety
                    conn.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                    conn.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                    //open
                    conn.connect();

                    //setup send
                    os = new BufferedOutputStream(conn.getOutputStream());
                    os.write(message.getBytes());
                    //clean up
                    os.flush();

                    //do somehting with response
                    is = conn.getInputStream();
                    BufferedReader in = new BufferedReader(new InputStreamReader(
                            is));
                    String inputLine;
                    while ((inputLine = in.readLine()) != null)
                        Log.d("Response", inputLine);
                } catch (IOException e) {
                    e.printStackTrace();
                } finally {
                    //clean up
                    try {
                        if (os != null) {
                            os.close();
                        }
                        if (is != null) {
                            is.close();
                        }
                    } catch (IOException e) {
                        e.printStackTrace();
                    }

                    if (conn != null) {
                        conn.disconnect();
                    }
                }
                return null;
            }
        }.execute();
//        viewPager.setCurrentItem(viewPager.getCurrentItem() + 1);

        Toast.makeText(this, "Score Updated for Hole "+(viewPager.getCurrentItem()+1), Toast.LENGTH_SHORT).show();

        mAdapter.notifyDataSetChanged();
    }

    private void uploadScoretoSqlLite() throws ParseException {
        Tournament tournament = Common.tournaments;

        SQLiteDatabase readdatabase = DBHelper.dbHelper.getReadableDatabase();
        SQLiteDatabase writedatabase = DBHelper.dbHelper.getWritableDatabase();

        Cursor cursor = readdatabase.rawQuery("SELECT * FROM tbgolftournament", null);
        if (cursor.getCount() != 0) {
            writedatabase.delete("tbgolftournament", "gtid = " + tournament.getId(), null);
        }

        ContentValues contentValues = new ContentValues();
        contentValues.put("gtid", tournament.getId());
        contentValues.put("gtname", tournament.getName());
        contentValues.put("gtdate", tournament.getDate());
        contentValues.put("gtstartdate", new SimpleDateFormat("yyyy-MM-dd").format(tournament.getRegdate()));
        contentValues.put("gttime", tournament.getTime());
        contentValues.put("gtmember", tournament.getGTMembers());
        contentValues.put("gtcourse", tournament.getCourse().toString());
        contentValues.put("scoreboard", Common.scoreBoard.Score.toString());

        writedatabase.insert("tbgolftournament", null, contentValues);
    }

    class ViewPagerAdapter extends FragmentPagerAdapter {

        public ViewPagerAdapter(FragmentManager manager) {
            super(manager);
        }

        @Override
        public Fragment getItem(int position) {
            return mFragmentList.get(position);
        }

        @Override
        public int getCount() {
            return mFragmentList.size();
        }

        public void addFragment(HoleFragment fragment) {
            //Adding Fragments and there Titles to the Adapter
            mFragmentList.add(fragment);
        }
    }

    private void setupViewPager(ViewPager viewPager) {
        //Calling the Adapter and adding fragments to add the Viewpager
        ViewPagerAdapter adapter = new ViewPagerAdapter(getSupportFragmentManager());

        for (int i = 0; i < holes; i++) {
            adapter.addFragment(HoleFragment.newInstance(i));
        }

        //Setting the Adapter
        viewPager.setAdapter(adapter);
        viewPager.setOffscreenPageLimit(holes - 1);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.score_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.front_scroll:
                viewPager.setCurrentItem(0);
                break;
            case R.id.back_scroll:
                if (holes == 9)
                    viewPager.setCurrentItem(8);
                else
                    viewPager.setCurrentItem(9);
                break;
            case R.id.leaderboard:
                Intent ilead = new Intent(this, LeaderBoardActivity.class);
                startActivity(ilead);
                break;
            case R.id.table:
                Intent itable = new Intent(this, ScoreTableActivity.class);
                startActivity(itable);
                break;
            case R.id.reset:
                AlertDialog.Builder builder = new AlertDialog.Builder(this);
                builder.setTitle("Reset Score");
                builder.setMessage("Are you sure you want to reset your score?");
                builder.setPositiveButton("YES", (dialog, which) -> {
                    finish();
                    startActivity(new Intent(ScoreboardActivity.this, SelectMembersActivity.class));
                });
                builder.setNegativeButton("NO", (dialog, which) -> {

                });
                builder.show();
                break;
        }
        return true;
    }
}
