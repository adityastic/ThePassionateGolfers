package com.aditya.tpg.activities;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Typeface;
import android.preference.PreferenceManager;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.text.format.DateUtils;
import android.util.Log;
import android.view.View;
import android.view.ViewTreeObserver;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.aditya.tpg.R;
import com.aditya.tpg.adapters.TournamentAdapter;
import com.aditya.tpg.datas.Course;
import com.aditya.tpg.datas.Holes;
import com.aditya.tpg.datas.MemberData;
import com.aditya.tpg.datas.PlayerScore;
import com.aditya.tpg.datas.ScoreBoard;
import com.aditya.tpg.datas.Tournament;
import com.aditya.tpg.utils.Common;
import com.aditya.tpg.utils.sqlite.DBHelper;
import com.getkeepsafe.taptargetview.TapTarget;
import com.getkeepsafe.taptargetview.TapTargetView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Map;
import java.util.concurrent.TimeUnit;

public class MainActivity extends AppCompatActivity {

    SwipeRefreshLayout mSwipeRefreshLayout;
    RecyclerView mRecyclerView;
    TournamentAdapter mAdapter;
    Toolbar mToolbar;

    TextView title,subtitle;

    SharedPreferences prefs;

    LinearLayout noInternet;
    public static boolean already = false;

    @Override
    public void onBackPressed() {
        finishAffinity();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        noInternet = findViewById(R.id.nointernet);
        mSwipeRefreshLayout = findViewById(R.id.swipeRefresh);
        mRecyclerView = findViewById(R.id.recyclerView);
        mToolbar = findViewById(R.id.toolbar);

        title = findViewById(R.id.nocardtitle);
        subtitle = findViewById(R.id.nocardsub);

        prefs = PreferenceManager.getDefaultSharedPreferences(this);
        try {
            already = checkIfScore();
        } catch (JSONException | ParseException e) {
            e.printStackTrace();
        }

        setUpToolbar();

//        Common.trimCache(this);

        mRecyclerView.setLayoutManager(new LinearLayoutManager(this));

        refreshLayout();

        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                refreshLayout();
            }
        });

//        SQLiteDatabase readdatabase = DBHelper.dbHelper.getReadableDatabase();
//        Cursor cursor = readdatabase.rawQuery("SELECT * FROM tbgolftournament", null);
//        if (cursor.getCount() != 0) {
//            AlertDialog.Builder dialog = new AlertDialog.Builder(this);
//            dialog.setTitle("Warning");
//            dialog.setMessage("Looks like you already have a game pending. If you click on the tournament again you can add people but you will lose your scoreboard");
//            dialog.show();
//        }

        ((RelativeLayout) findViewById(R.id.recyclerRelative)).getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                ((RelativeLayout) findViewById(R.id.recyclerRelative)).getViewTreeObserver().removeOnGlobalLayoutListener(this);
                TournamentAdapter.setParentIndex(((RelativeLayout) findViewById(R.id.recyclerRelative)).getHeight());
            }
        });
    }

    private boolean checkIfScore() throws JSONException, ParseException {
        DBHelper.dbHelper = new DBHelper(this);
        SQLiteDatabase readableDatabase = DBHelper.dbHelper.getReadableDatabase();

        if (prefs.getBoolean("scoreboard", true)) {

            SQLiteDatabase writeableDatabase = DBHelper.dbHelper.getWritableDatabase();
            writeableDatabase.execSQL("CREATE TABLE `tbgolftournament` (\n" +
                    "  `gtid` int(11) NOT NULL,\n" +
                    "  `gtname` text NOT NULL,\n" +
                    "  `gtstartdate` date NOT NULL,\n" +
                    "  `gtdate` date NOT NULL,\n" +
                    "  `gttime` time NOT NULL,\n" +
                    "  `gtmember` text NOT NULL,\n" +
                    "  `gtcourse` varchar(50) NOT NULL,\n" +
                    "  `scoreboard` text NOT NULL\n" +
                    ")");

            prefs.edit().putBoolean("scoreboard", false).apply();
        }

        Cursor cursor = readableDatabase.rawQuery("SELECT * FROM tbgolftournament", null);
        if (cursor.getCount() != 0) {
            cursor.moveToFirst();

            Tournament tournament;

            JSONObject course = new JSONObject(cursor.getString(cursor.getColumnIndex("gtcourse")));

            JSONArray holes = course.getJSONArray("holes");

            ArrayList<Holes> holesArray = new ArrayList<>();
            for (int j = 0; j < holes.length(); j++) {
                JSONObject holeOb = (JSONObject) holes.get(j);
                holesArray.add(new Holes(
                        Integer.parseInt(holeOb.getString("par")),
                        Integer.parseInt(holeOb.getString("strin"))
                ));
            }

            JSONArray members = new JSONArray(cursor.getString(cursor.getColumnIndex("gtmember")));
            ArrayList<MemberData> memberArray = new ArrayList<>();
            for (int j = 0; j < members.length(); j++) {
                JSONObject mem = (JSONObject) members.get(j);
                memberArray.add(new MemberData(
                        Integer.parseInt(mem.getString("id")),
                        mem.getString("shortname"),
                        mem.getString("name"),
                        Integer.parseInt(mem.getString("handicap"))
                ));
            }

            Date tournamentDate = new SimpleDateFormat("yyyy-MM-dd").parse(cursor.getString(cursor.getColumnIndex("gtdate")));
            Log.e("Tournament Date",tournamentDate.toString()+", "+Calendar.getInstance().getTime().toString());
            Log.e("Today", String.valueOf(DateUtils.isToday(tournamentDate.getTime())));
            if(!DateUtils.isToday(tournamentDate.getTime())) {

            }
            tournament = new Tournament(
                    cursor.getInt(cursor.getColumnIndex("gtid")),
                    cursor.getString(cursor.getColumnIndex("gtname")),
                    cursor.getString(cursor.getColumnIndex("gtdate")),
                    cursor.getString(cursor.getColumnIndex("gtstartdate")),
                    cursor.getString(cursor.getColumnIndex("gttime")),
                    new Course(
                            course.getString("name"),
                            course.getString("sname"),
                            course.getString("description"),
                            course.getString("city"),
                            holesArray),
                    memberArray
            );

            Common.tournaments = tournament;

            if (Common.tournaments != null)
                Log.e("Tournament", "Not Found");

            JSONArray score = new JSONArray(cursor.getString(cursor.getColumnIndex("scoreboard")));

            ArrayList<String> playerNamesTemp = new ArrayList<>();
            Common.scoreBoard = new ScoreBoard(new ArrayList<PlayerScore>());

            for (int i = 0; i < score.length(); i++) {
                JSONObject ScoreofMember = (JSONObject) score.get(i);

                String memberName = ScoreofMember.keys().next();

                playerNamesTemp.add(memberName);

                JSONArray personalScore = ScoreofMember.getJSONArray(memberName);

                ArrayList<Integer> holeScore = new ArrayList<>();
                for (int j = 0; j < personalScore.length(); j++)
                    holeScore.add((Integer) personalScore.get(j));

                PlayerScore playerScore = new PlayerScore(memberName, holeScore);
                Common.scoreBoard.Score.add(playerScore);

            }

            Common.playerNames = playerNamesTemp;
            return true;
        }
        return false;
    }

    private void setUpToolbar() {
        setSupportActionBar(mToolbar);
        //noinspection ConstantConditions
    }


    public void refreshLayout() {

        mSwipeRefreshLayout.setRefreshing(true);
        mAdapter = null;
        mRecyclerView.setAdapter(null);

        noInternet.setVisibility(View.GONE);
        mRecyclerView.setVisibility(View.VISIBLE);

        if (Common.isNetworkAvailable(this)) {

            Common.getTournaments(this, new Common.onGotJSON() {

                @Override
                public void gotJSON(final JSONArray jsonArray) {
                    Common.tournaments = null;

                    Common.getDate(MainActivity.this, new Common.onGotJSON() {
                        @Override
                        public void gotJSON(JSONArray jsonArray) {

                        }

                        @SuppressLint("SimpleDateFormat")
                        @Override
                        public void gotJSON(JSONObject jsonObject) {

                            Date current = null;
                            try {
                                current = new SimpleDateFormat("yyyy-dd-MM").parse(jsonObject.getString("currentdate"));
                                Tournament tournament = null;
                                long datediff = TimeUnit.MILLISECONDS.convert(999, TimeUnit.DAYS);

                                for (int i = 0; i < jsonArray.length(); i++) {
                                    try {
                                        JSONObject jsonOb = (JSONObject) jsonArray.get(i);

                                        JSONObject course = jsonOb.getJSONObject("course");
                                        JSONArray holes = course.getJSONArray("holes");

                                        ArrayList<Holes> holesArray = new ArrayList<>();
                                        for (int j = 0; j < holes.length(); j++) {
                                            JSONObject holeOb = (JSONObject) holes.get(j);
                                            holesArray.add(new Holes(
                                                    Integer.parseInt(holeOb.getString("par")),
                                                    Integer.parseInt(holeOb.getString("strin"))
                                            ));
                                        }

                                        JSONArray members = jsonOb.getJSONArray("members");
                                        ArrayList<MemberData> memberArray = new ArrayList<>();
                                        for (int j = 0; j < members.length(); j++) {
                                            JSONObject mem = (JSONObject) members.get(j);
                                            memberArray.add(new MemberData(
                                                    Integer.parseInt(mem.getString("id")),
                                                    mem.getString("shortname"),
                                                    mem.getString("name"),
                                                    Integer.parseInt(mem.getString("handicap"))
                                            ));
                                        }

                                        Date tour = new SimpleDateFormat("yyyy-MM-dd").parse(jsonOb.getString("date"));
                                        long diff = tour.getTime() - current.getTime();

                                        Log.e("DateStart",jsonOb.getString("date"));

                                        if (diff >= 0 && diff < datediff) {
                                            datediff = diff;
                                            tournament = new Tournament(
                                                    Integer.parseInt(jsonOb.getString("id")),
                                                    jsonOb.getString("name"),
                                                    jsonOb.getString("date"),
                                                    jsonOb.getString("reglast"),
                                                    jsonOb.getString("time"),
                                                    new Course(
                                                            course.getString("name"),
                                                            course.getString("sname"),
                                                            course.getString("description"),
                                                            course.getString("city"),
                                                            holesArray),
                                                    memberArray
                                            );
                                        }


                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }
                                }
                                if (tournament != null)
                                    Common.tournaments = tournament;

                            } catch (ParseException | JSONException e) {
                                e.printStackTrace();
                            }

                            if (Common.tournaments == null) {
                                noInternet.setVisibility(View.VISIBLE);
                                title.setText("No Tournaments Found!!");
                                subtitle.setText("Looks like there are no upcoming tournaments...");
                                mRecyclerView.setVisibility(View.GONE);
                            } else {
                                noInternet.setVisibility(View.GONE);
                                mRecyclerView.setVisibility(View.VISIBLE);
                            }

                            mAdapter = new TournamentAdapter(MainActivity.this, current);
                            mRecyclerView.setAdapter(mAdapter);
                            mSwipeRefreshLayout.setRefreshing(false);
                        }

                        @Override
                        public void failedJSON(Exception e) {
                            Toast.makeText(MainActivity.this, "Error in Fetching Date", Toast.LENGTH_SHORT).show();
                            e.printStackTrace();
                            Common.tournaments = null;
                            mSwipeRefreshLayout.setRefreshing(false);
                        }
                    });
                }

                @Override
                public void gotJSON(JSONObject jsonObject) {

                }

                @Override
                public void failedJSON(Exception e) {
                    Toast.makeText(MainActivity.this, "Error in Fetching Tournaments", Toast.LENGTH_SHORT).show();
                    e.printStackTrace();
                    Common.tournaments = null;
                    mSwipeRefreshLayout.setRefreshing(false);
                }
            });
        }else
        {
            noInternet.setVisibility(View.VISIBLE);
            title.setText("No Internet Connection Found!!");
            subtitle.setText("Check your Connection and Try again...");
            mRecyclerView.setVisibility(View.GONE);
            mSwipeRefreshLayout.setRefreshing(false);
        }

    }
}
